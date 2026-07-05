<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/moneda.php';
require_once __DIR__ . '/Categoria.php';

class Producto
{
    public static function obtenerCategoriaPorSlug(string $slug): ?array
    {
        return Categoria::obtenerPorSlug($slug);
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
            'SELECT id, url, alt_text, orden FROM producto_imagenes
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
        return deportivo_formatear_precio($precio);
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

    public static function urlImagen(string $imagen, bool $desdeVistas = false): string
    {
        if (preg_match('#^https?://#i', $imagen) || str_starts_with($imagen, '//')) {
            return $imagen;
        }

        if (function_exists('deportivo_upload_url')) {
            return deportivo_upload_url($imagen);
        }

        return ($desdeVistas ? '../' : '') . ltrim($imagen, '/');
    }

    public static function listarCategorias(): array
    {
        return Categoria::listarParaSelect();
    }

    public static function obtenerPorIdAdmin(int $id): ?array
    {
        global $conexion;

        $stmt = $conexion->prepare(
            'SELECT p.*, c.nombre AS categoria_nombre, c.slug AS categoria_slug
             FROM productos p
             INNER JOIN categorias c ON c.id = p.categoria_id
             WHERE p.id = :id
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

    public static function actualizar(int $id, array $datos): bool
    {
        global $conexion;

        $slug = self::generarSlugUnico($datos['nombre'], $id);

        $stmt = $conexion->prepare(
            'UPDATE productos SET
                categoria_id = :categoria_id,
                nombre = :nombre,
                slug = :slug,
                descripcion = :descripcion,
                precio = :precio,
                imagen_principal = :imagen_principal,
                lavado = :lavado,
                fit = :fit,
                material_info = :material_info,
                stock_estado = :stock_estado,
                activo = :activo
             WHERE id = :id'
        );

        $stmt->execute([
            ':id' => $id,
            ':categoria_id' => (int) $datos['categoria_id'],
            ':nombre' => $datos['nombre'],
            ':slug' => $slug,
            ':descripcion' => $datos['descripcion'],
            ':precio' => (float) $datos['precio'],
            ':imagen_principal' => $datos['imagen_principal'],
            ':lavado' => $datos['lavado'] ?: null,
            ':fit' => $datos['fit'] ?: null,
            ':material_info' => $datos['material_info'] ?: null,
            ':stock_estado' => $datos['stock_estado'],
            ':activo' => !empty($datos['activo']) ? 1 : 0,
        ]);

        self::sincronizarTallas($id, $datos['tallas']);

        return true;
    }

    public static function crear(array $datos): int
    {
        global $conexion;

        $slug = self::generarSlugUnico($datos['nombre']);

        $stmt = $conexion->prepare(
            'INSERT INTO productos
            (categoria_id, nombre, slug, descripcion, precio, imagen_principal, lavado, fit, material_info, stock_estado, activo)
            VALUES
            (:categoria_id, :nombre, :slug, :descripcion, :precio, :imagen_principal, :lavado, :fit, :material_info, :stock_estado, :activo)'
        );

        $stmt->execute([
            ':categoria_id' => (int) $datos['categoria_id'],
            ':nombre' => $datos['nombre'],
            ':slug' => $slug,
            ':descripcion' => $datos['descripcion'],
            ':precio' => (float) $datos['precio'],
            ':imagen_principal' => $datos['imagen_principal'],
            ':lavado' => $datos['lavado'] ?: null,
            ':fit' => $datos['fit'] ?: null,
            ':material_info' => $datos['material_info'] ?: null,
            ':stock_estado' => $datos['stock_estado'],
            ':activo' => !empty($datos['activo']) ? 1 : 0,
        ]);

        $id = (int) $conexion->lastInsertId();
        self::sincronizarTallas($id, $datos['tallas']);

        return $id;
    }

    public static function desactivar(int $id): bool
    {
        global $conexion;

        $stmt = $conexion->prepare('UPDATE productos SET activo = 0 WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    private static function sincronizarTallas(int $productoId, array $tallas): void
    {
        global $conexion;

        $conexion->prepare('DELETE FROM producto_tallas WHERE producto_id = :id')
            ->execute([':id' => $productoId]);

        $stmt = $conexion->prepare(
            'INSERT INTO producto_tallas (producto_id, talla) VALUES (:producto_id, :talla)'
        );

        foreach ($tallas as $talla) {
            $talla = trim($talla);
            if ($talla === '') {
                continue;
            }
            $stmt->execute([
                ':producto_id' => $productoId,
                ':talla' => $talla,
            ]);
        }
    }

    private static function generarSlugUnico(string $nombre, ?int $excluirId = null): string
    {
        global $conexion;

        $base = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $nombre), '-'));

        if ($base === '') {
            $base = 'producto';
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

        $sql = 'SELECT id FROM productos WHERE slug = :slug';
        if ($excluirId) {
            $sql .= ' AND id != :id';
        }

        $stmt = $conexion->prepare($sql . ' LIMIT 1');
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);

        if ($excluirId) {
            $stmt->bindParam(':id', $excluirId, PDO::PARAM_INT);
        }

        $stmt->execute();

        return (bool) $stmt->fetch();
    }

    public static function parseTallasInput(string $input): array
    {
        $tallas = array_map('trim', explode(',', $input));

        return array_values(array_filter($tallas, fn ($t) => $t !== ''));
    }

    public static function actualizarImagenPrincipal(int $id, string $imagenPath): bool
    {
        global $conexion;

        $stmt = $conexion->prepare(
            'UPDATE productos SET imagen_principal = :imagen WHERE id = :id'
        );

        return $stmt->execute([
            ':id' => $id,
            ':imagen' => $imagenPath,
        ]);
    }

    public static function actualizarImagenGaleria(int $imagenId, string $url): bool
    {
        global $conexion;

        $stmt = $conexion->prepare(
            'UPDATE producto_imagenes SET url = :url WHERE id = :id'
        );

        return $stmt->execute([
            ':id' => $imagenId,
            ':url' => $url,
        ]);
    }

    public static function obtenerImagenGaleria(int $imagenId): ?array
    {
        global $conexion;

        $stmt = $conexion->prepare(
            'SELECT id, producto_id, url, alt_text FROM producto_imagenes WHERE id = :id LIMIT 1'
        );
        $stmt->bindParam(':id', $imagenId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        return $row ?: null;
    }
}
