<?php

require_once __DIR__ . '/../config/database.php';

class Producto
{
    public static function obtenerCategoriaPorSlug(string $slug): ?array
    {
        global $conexion;

        $stmt = $conexion->prepare(
            'SELECT * FROM categorias WHERE slug = :slug LIMIT 1'
        );
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();

        $categoria = $stmt->fetch();
        return $categoria ?: null;
    }

    public static function listarPorCategoria(?string $categoriaSlug = null): array
    {
        global $conexion;

        $sql = '
            SELECT p.*, c.nombre AS categoria_nombre, c.slug AS categoria_slug
            FROM productos p
            INNER JOIN categorias c ON c.id = p.categoria_id
            WHERE p.activo = 1
        ';

        if ($categoriaSlug) {
            $sql .= ' AND c.slug = :categoria';
        }

        $sql .= ' ORDER BY p.id ASC';

        $stmt = $conexion->prepare($sql);

        if ($categoriaSlug) {
            $stmt->bindParam(':categoria', $categoriaSlug, PDO::PARAM_STR);
        }

        $stmt->execute();
        $productos = $stmt->fetchAll();

        foreach ($productos as &$producto) {
            $producto['tallas'] = self::obtenerTallas((int) $producto['id']);
        }

        return $productos;
    }

    public static function obtenerPorId(int $id): ?array
    {
        global $conexion;

        $stmt = $conexion->prepare(
            'SELECT p.*, c.nombre AS categoria_nombre, c.slug AS categoria_slug
             FROM productos p
             INNER JOIN categorias c ON c.id = p.categoria_id
             WHERE p.id = :id AND p.activo = 1
             LIMIT 1'
        );
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $producto = $stmt->fetch();

        if (!$producto) {
            return null;
        }

        $producto['tallas'] = self::obtenerTallas($id);
        $producto['imagenes'] = self::obtenerImagenes($id);

        return $producto;
    }

    public static function obtenerRelacionados(int $productoId, int $categoriaId, int $limite = 4): array
    {
        global $conexion;

        $stmt = $conexion->prepare(
            'SELECT p.*, c.nombre AS categoria_nombre, c.slug AS categoria_slug
             FROM productos p
             INNER JOIN categorias c ON c.id = p.categoria_id
             WHERE p.categoria_id = :categoria_id
               AND p.id != :producto_id
               AND p.activo = 1
             ORDER BY p.id ASC
             LIMIT :limite'
        );
        $stmt->bindParam(':categoria_id', $categoriaId, PDO::PARAM_INT);
        $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        $productos = $stmt->fetchAll();

        foreach ($productos as &$producto) {
            $producto['tallas'] = self::obtenerTallas((int) $producto['id']);
        }

        return $productos;
    }

    public static function obtenerTallas(int $productoId): array
    {
        global $conexion;

        $stmt = $conexion->prepare(
            'SELECT talla FROM producto_tallas
             WHERE producto_id = :producto_id
             ORDER BY id ASC'
        );
        $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
        $stmt->execute();

        return array_column($stmt->fetchAll(), 'talla');
    }

    public static function obtenerImagenes(int $productoId): array
    {
        global $conexion;

        $stmt = $conexion->prepare(
            'SELECT url, alt_text FROM producto_imagenes
             WHERE producto_id = :producto_id
             ORDER BY orden ASC'
        );
        $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function etiquetaStock(string $estado): string
    {
        return match ($estado) {
            'pocas_unidades' => 'Pocas unidades',
            'agotado' => 'Agotado',
            default => 'Disponible',
        };
    }

    public static function mensajeStock(string $estado): string
    {
        return match ($estado) {
            'pocas_unidades' => 'Pocas unidades - Envío inmediato',
            'agotado' => 'Agotado temporalmente',
            default => 'En stock - Listo para enviar',
        };
    }

    public static function formatearPrecio(float $precio): string
    {
        return '$' . number_format($precio, 2, '.', '');
    }

    public static function parseMaterialInfo(?string $materialInfo): array
    {
        if (!$materialInfo) {
            return [];
        }

        return array_filter(array_map('trim', explode('|', $materialInfo)));
    }

    public static function extraerFiltros(array $productos): array
    {
        $tallas = [];
        $lavados = [];
        $fits = [];

        foreach ($productos as $producto) {
            foreach ($producto['tallas'] as $talla) {
                $tallas[$talla] = true;
            }
            if (!empty($producto['lavado'])) {
                $lavados[$producto['lavado']] = true;
            }
            if (!empty($producto['fit'])) {
                $fits[$producto['fit']] = true;
            }
        }

        return [
            'tallas' => array_keys($tallas),
            'lavados' => array_keys($lavados),
            'fits' => array_keys($fits),
        ];
    }

    public static function obtenerSugerencias(int $limite = 4): array
    {
        global $conexion;

        $stmt = $conexion->prepare(
            'SELECT p.*, c.nombre AS categoria_nombre, c.slug AS categoria_slug
             FROM productos p
             INNER JOIN categorias c ON c.id = p.categoria_id
             WHERE p.activo = 1
             ORDER BY RAND()
             LIMIT :limite'
        );
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        $productos = $stmt->fetchAll();

        foreach ($productos as &$producto) {
            $producto['tallas'] = self::obtenerTallas((int) $producto['id']);
        }

        return $productos;
    }

    public static function traducirLavado(?string $lavado): string
    {
        if (!$lavado) {
            return '';
        }

        $mapa = [
            'Raw Indigo' => 'Índigo crudo',
            'Vintage Wash' => 'Lavado vintage',
            'Midnight Black' => 'Negro medianoche',
            'Bleached' => 'Decolorado',
        ];

        return $mapa[$lavado] ?? $lavado;
    }

    public static function traducirFit(?string $fit): string
    {
        if (!$fit) {
            return '';
        }

        $mapa = [
            'Heritage Straight' => 'Recto heritage',
            'Relaxed Taper' => 'Taper relajado',
            'Skinny Architectural' => 'Skinny arquitectónico',
            'Wide Leg' => 'Pierna ancha',
            'Regular' => 'Regular',
            'Relaxed' => 'Relajado',
            'Oversized' => 'Oversize',
            'Longline' => 'Largo',
        ];

        return $mapa[$fit] ?? $fit;
    }
}
