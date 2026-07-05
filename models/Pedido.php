<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/moneda.php';
require_once __DIR__ . '/Producto.php';

class Pedido
{
    public const ESTADOS = ['pendiente', 'confirmado', 'enviado', 'cancelado'];
    public static function crear(array $envio, array $items, ?int $usuarioId = null): int
    {
        global $conexion;

        $subtotal = 0.0;

        foreach ($items as $item) {
            $subtotal += (float) $item['precio'] * (int) $item['cantidad'];
        }

        $envioCosto = deportivo_calcular_envio($subtotal);
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

    public static function listar(?string $estado = null, int $limit = 50, int $offset = 0): array
    {
        global $conexion;

        $sql = 'SELECT * FROM pedidos';
        $params = [];

        if ($estado !== null && $estado !== '') {
            $sql .= ' WHERE estado = :estado';
            $params[':estado'] = $estado;
        }

        $sql .= ' ORDER BY fecha_creacion DESC LIMIT :limit OFFSET :offset';

        $stmt = $conexion->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function contar(?string $estado = null): int
    {
        global $conexion;

        $sql = 'SELECT COUNT(*) FROM pedidos';
        $params = [];

        if ($estado !== null && $estado !== '') {
            $sql .= ' WHERE estado = :estado';
            $params[':estado'] = $estado;
        }

        $stmt = $conexion->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public static function contarPendientes(): int
    {
        return self::contar('pendiente');
    }

    public static function actualizarEstado(int $id, string $estado): bool
    {
        global $conexion;

        $estadosValidos = self::ESTADOS;

        if (!in_array($estado, $estadosValidos, true)) {
            return false;
        }

        $stmt = $conexion->prepare('UPDATE pedidos SET estado = :estado WHERE id = :id');
        $stmt->bindValue(':estado', $estado);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute() && $stmt->rowCount() > 0;
    }

    public static function enriquecerItemsConImagen(array $items): array
    {
        foreach ($items as &$item) {
            if (!empty($item['imagen'])) {
                $item['imagen'] = Producto::urlImagen((string) $item['imagen']);
                continue;
            }

            $productoId = (int) ($item['producto_id'] ?? 0);

            if ($productoId <= 0) {
                $item['imagen'] = '';
                continue;
            }

            $producto = Producto::obtenerPorIdAdmin($productoId);

            if ($producto && !empty($producto['imagen_principal'])) {
                $item['imagen'] = Producto::urlImagen($producto['imagen_principal']);
            } else {
                $item['imagen'] = '';
            }
        }

        unset($item);

        return $items;
    }
}
