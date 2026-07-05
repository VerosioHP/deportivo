<?php

require_once __DIR__ . '/../config/database.php';

class Categoria
{
    public static function listar(): array
    {
        global $conexion;

        $sql = '
            SELECT c.id, c.nombre, c.slug, c.descripcion,
                   COUNT(p.id) AS productos_count
            FROM categorias c
            LEFT JOIN productos p ON p.categoria_id = c.id
            GROUP BY c.id, c.nombre, c.slug, c.descripcion
            ORDER BY c.nombre ASC
        ';

        return $conexion->query($sql)->fetchAll();
    }

    public static function listarParaSelect(): array
    {
        global $conexion;

        return $conexion->query(
            'SELECT id, nombre, slug FROM categorias ORDER BY nombre ASC'
        )->fetchAll();
    }

    public static function obtenerPorId(int $id): ?array
    {
        global $conexion;

        $stmt = $conexion->prepare('SELECT * FROM categorias WHERE id = :id LIMIT 1');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $categoria = $stmt->fetch();

        return $categoria ?: null;
    }

    public static function obtenerPorSlug(string $slug): ?array
    {
        global $conexion;

        $stmt = $conexion->prepare('SELECT * FROM categorias WHERE slug = :slug LIMIT 1');
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();

        $categoria = $stmt->fetch();

        return $categoria ?: null;
    }

    public static function crear(string $nombre, string $descripcion = ''): int
    {
        global $conexion;

        $nombre = trim($nombre);
        $descripcion = trim($descripcion);

        if ($nombre === '') {
            throw new InvalidArgumentException('El nombre es obligatorio.');
        }

        $slug = self::generarSlugUnico($nombre);

        $stmt = $conexion->prepare(
            'INSERT INTO categorias (nombre, slug, descripcion) VALUES (:nombre, :slug, :descripcion)'
        );
        $stmt->execute([
            ':nombre' => $nombre,
            ':slug' => $slug,
            ':descripcion' => $descripcion !== '' ? $descripcion : null,
        ]);

        return (int) $conexion->lastInsertId();
    }

    public static function actualizar(int $id, string $nombre, string $descripcion = ''): bool
    {
        global $conexion;

        $nombre = trim($nombre);
        $descripcion = trim($descripcion);

        if ($id <= 0 || $nombre === '') {
            return false;
        }

        $categoria = self::obtenerPorId($id);

        if (!$categoria) {
            return false;
        }

        $slug = self::generarSlugUnico($nombre, $id);

        $stmt = $conexion->prepare(
            'UPDATE categorias SET nombre = :nombre, slug = :slug, descripcion = :descripcion WHERE id = :id'
        );

        return $stmt->execute([
            ':nombre' => $nombre,
            ':slug' => $slug,
            ':descripcion' => $descripcion !== '' ? $descripcion : null,
            ':id' => $id,
        ]);
    }

    public static function eliminar(int $id): array
    {
        global $conexion;

        if ($id <= 0) {
            return ['ok' => false, 'error' => 'ID de categoría inválido.'];
        }

        $categoria = self::obtenerPorId($id);

        if (!$categoria) {
            return ['ok' => false, 'error' => 'Categoría no encontrada.'];
        }

        $productos = self::contarProductos($id);

        if ($productos > 0) {
            return [
                'ok' => false,
                'error' => "No se puede eliminar: tiene {$productos} producto(s) asociado(s).",
            ];
        }

        $stmt = $conexion->prepare('DELETE FROM categorias WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if (!$stmt->execute() || $stmt->rowCount() === 0) {
            return ['ok' => false, 'error' => 'No se pudo eliminar la categoría.'];
        }

        return ['ok' => true];
    }

    public static function contarProductos(int $categoriaId): int
    {
        global $conexion;

        $stmt = $conexion->prepare('SELECT COUNT(*) FROM productos WHERE categoria_id = :id');
        $stmt->bindValue(':id', $categoriaId, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    private static function generarSlugUnico(string $nombre, ?int $excluirId = null): string
    {
        $base = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $nombre), '-'));

        if ($base === '') {
            $base = 'categoria';
        }

        $slug = $base;
        $contador = 1;

        while (self::slugExiste($slug, $excluirId)) {
            $slug = $base . '-' . $contador;
            $contador++;
        }

        return $slug;
    }

    private static function slugExiste(string $slug, ?int $excluirId = null): bool
    {
        global $conexion;

        $sql = 'SELECT id FROM categorias WHERE slug = :slug';

        if ($excluirId) {
            $sql .= ' AND id != :id';
        }

        $stmt = $conexion->prepare($sql . ' LIMIT 1');
        $stmt->bindValue(':slug', $slug);

        if ($excluirId) {
            $stmt->bindValue(':id', $excluirId, PDO::PARAM_INT);
        }

        $stmt->execute();

        return (bool) $stmt->fetch();
    }
}
