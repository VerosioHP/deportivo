<?php

require_once __DIR__ . '/../config/database.php';

class Pedido
{
    public static function crear(array $envio, array $items, ?int $usuarioId = null): int
    {
        global $conexion;

        $subtotal = 0.0;

        foreach ($items as $item) {
            $subtotal += (float) $item['precio'] * (int) $item['cantidad'];
        }

        $envioCosto = $subtotal >= 300 ? 0.0 : ($subtotal > 0 ? 12.0 : 0.0);
        $total = $subtotal + $envioCosto;

        $conexion->beginTransaction();

        try {
            $stmt = $conexion->prepare(
                'INSERT INTO pedidos
                (usuario_id, nombre, apellido, email, telefono, direccion, ciudad, provincia, codigo_postal, notas, subtotal, envio, total)
                VALUES
                (:usuario_id, :nombre, :apellido, :email, :telefono, :direccion, :ciudad, :provincia, :codigo_postal, :notas, :subtotal, :envio, :total)'
            );

            $stmt->execute([
                ':usuario_id' => $usuarioId,
                ':nombre' => $envio['nombre'],
                ':apellido' => $envio['apellido'],
                ':email' => $envio['email'],
                ':telefono' => $envio['telefono'],
                ':direccion' => $envio['direccion'],
                ':ciudad' => $envio['ciudad'],
                ':provincia' => $envio['provincia'],
                ':codigo_postal' => $envio['codigo_postal'],
                ':notas' => $envio['notas'] ?: null,
                ':subtotal' => $subtotal,
                ':envio' => $envioCosto,
                ':total' => $total,
            ]);

            $pedidoId = (int) $conexion->lastInsertId();

            $itemStmt = $conexion->prepare(
                'INSERT INTO pedido_items (pedido_id, producto_id, nombre, talla, precio, cantidad)
                 VALUES (:pedido_id, :producto_id, :nombre, :talla, :precio, :cantidad)'
            );

            foreach ($items as $item) {
                $itemStmt->execute([
                    ':pedido_id' => $pedidoId,
                    ':producto_id' => (int) $item['id'],
                    ':nombre' => $item['nombre'],
                    ':talla' => $item['talla'],
                    ':precio' => (float) $item['precio'],
                    ':cantidad' => (int) $item['cantidad'],
                ]);
            }

            $conexion->commit();

            return $pedidoId;
        } catch (Throwable $e) {
            $conexion->rollBack();
            throw $e;
        }
    }

    public static function obtenerPorId(int $id): ?array
    {
        global $conexion;

        $stmt = $conexion->prepare('SELECT * FROM pedidos WHERE id = :id LIMIT 1');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $pedido = $stmt->fetch();

        if (!$pedido) {
            return null;
        }

        $itemsStmt = $conexion->prepare(
            'SELECT * FROM pedido_items WHERE pedido_id = :pedido_id ORDER BY id ASC'
        );
        $itemsStmt->bindParam(':pedido_id', $id, PDO::PARAM_INT);
        $itemsStmt->execute();

        $pedido['items'] = $itemsStmt->fetchAll();

        return $pedido;
    }
}
