<?php

define('DEPORTIVO_JSON_API', true);

require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/includes/ImagenProducto.php';
require_once dirname(__DIR__, 3) . '/models/Producto.php';

header('Content-Type: application/json; charset=utf-8');

requerirAdmin();

$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'get':
            $id = (int) ($_GET['id'] ?? 0);
            $producto = Producto::obtenerPorIdAdmin($id);

            if (!$producto) {
                echo json_encode(['ok' => false, 'error' => 'Producto no encontrado.']);
                exit;
            }

            echo json_encode([
                'ok' => true,
                'producto' => $producto,
                'categorias' => Producto::listarCategorias(),
            ]);
            break;

        case 'create':
        case 'update':
            $productoId = (int) ($_POST['id'] ?? 0);
            $imagenResultado = resolverImagenPrincipal(
                trim($_POST['imagen_principal'] ?? ''),
                $action === 'update' ? $productoId : null
            );

            if (!$imagenResultado['ok']) {
                echo json_encode(['ok' => false, 'error' => $imagenResultado['error']]);
                exit;
            }

            $colores = procesarColoresFormulario($_POST);

            if (empty($colores)) {
                echo json_encode(['ok' => false, 'error' => 'Agrega al menos un color con su stock.']);
                exit;
            }

            $imagenPrincipal = $imagenResultado['path'] ?: ($action === 'update' ? (Producto::obtenerPorIdAdmin($productoId)['imagen_principal'] ?? '') : '');

            if ($imagenPrincipal === '') {
                echo json_encode(['ok' => false, 'error' => 'Sube la imagen principal del producto.']);
                exit;
            }

            $datos = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'precio' => $_POST['precio'] ?? 0,
                'categoria_id' => (int) ($_POST['categoria_id'] ?? 0),
                'imagen_principal' => $imagenPrincipal,
                'descripcion' => trim($_POST['descripcion'] ?? ''),
                'lavado' => trim($_POST['lavado'] ?? ''),
                'fit' => trim($_POST['fit'] ?? ''),
                'material_info' => trim($_POST['material_info'] ?? ''),
                'stock_estado' => Producto::calcularStockEstado(array_sum(array_column($colores, 'stock_cantidad'))),
                'activo' => isset($_POST['activo']) ? 1 : ($action === 'create' ? 1 : 0),
                'tallas' => Producto::parseTallasInput($_POST['tallas'] ?? ''),
                'colores' => $colores,
            ];

            if ($datos['nombre'] === '' || $datos['categoria_id'] <= 0 || $datos['descripcion'] === '') {
                echo json_encode(['ok' => false, 'error' => 'Completa los campos obligatorios.']);
                exit;
            }

            if (empty($datos['tallas'])) {
                echo json_encode(['ok' => false, 'error' => 'Indica al menos una talla.']);
                exit;
            }

            if ($action === 'create') {
                $nuevoId = Producto::crear($datos);
                echo json_encode(['ok' => true, 'message' => 'Producto creado correctamente.', 'id' => $nuevoId]);
                break;
            }

            if ($productoId <= 0) {
                echo json_encode(['ok' => false, 'error' => 'ID de producto inválido.']);
                exit;
            }

            Producto::actualizar($productoId, $datos);
            echo json_encode(['ok' => true, 'message' => 'Producto actualizado correctamente.', 'id' => $productoId]);
            break;

        case 'delete':
            $id = (int) ($_POST['id'] ?? 0);

            if ($id <= 0) {
                echo json_encode(['ok' => false, 'error' => 'ID de producto inválido.']);
                exit;
            }

            Producto::desactivar($id);
            echo json_encode(['ok' => true, 'message' => 'Producto ocultado de la tienda.']);
            break;

        case 'categorias':
            echo json_encode(['ok' => true, 'categorias' => Producto::listarCategorias()]);
            break;

        case 'update_imagen':
            $productoId = (int) ($_POST['producto_id'] ?? 0);

            if ($productoId <= 0) {
                echo json_encode(['ok' => false, 'error' => 'ID de producto inválido.']);
                exit;
            }

            $imagenResultado = resolverImagenPrincipal('', $productoId);

            if (!$imagenResultado['ok']) {
                echo json_encode(['ok' => false, 'error' => $imagenResultado['error']]);
                exit;
            }

            Producto::actualizarImagenPrincipal($productoId, $imagenResultado['path']);
            $desdeVistas = !empty($_POST['desde_vistas']);

            echo json_encode([
                'ok' => true,
                'message' => 'Imagen del producto actualizada.',
                'producto_id' => $productoId,
                'url' => Producto::urlImagen($imagenResultado['path'], $desdeVistas) . '?t=' . time(),
                'path' => $imagenResultado['path'],
            ]);
            break;

        case 'update_imagen_galeria':
            $imagenId = (int) ($_POST['imagen_id'] ?? 0);

            if ($imagenId <= 0) {
                echo json_encode(['ok' => false, 'error' => 'ID de imagen inválido.']);
                exit;
            }

            $imagenActual = Producto::obtenerImagenGaleria($imagenId);

            if (!$imagenActual) {
                echo json_encode(['ok' => false, 'error' => 'Imagen de galería no encontrada.']);
                exit;
            }

            $imagenResultado = resolverImagenGaleria('', $imagenActual['url']);

            if (!$imagenResultado['ok']) {
                echo json_encode(['ok' => false, 'error' => $imagenResultado['error']]);
                exit;
            }

            Producto::actualizarImagenGaleria($imagenId, $imagenResultado['path']);
            $desdeVistas = !empty($_POST['desde_vistas']);
            $urlPublica = Producto::urlImagen($imagenResultado['path'], $desdeVistas);

            echo json_encode([
                'ok' => true,
                'message' => 'Imagen de galería actualizada.',
                'imagen_id' => $imagenId,
                'producto_id' => (int) $imagenActual['producto_id'],
                'url' => $urlPublica . (str_contains($urlPublica, '?') ? '&' : '?') . 't=' . time(),
            ]);
            break;

        default:
            echo json_encode(['ok' => false, 'error' => 'Acción no válida.']);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Error al procesar la solicitud.']);
}

function resolverImagenPrincipal(string $urlImagen, ?int $productoId = null): array
{
    $archivo = $_FILES['imagen_archivo'] ?? null;

    if ($archivo && ($archivo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
        return ImagenProducto::guardar($archivo);
    }

    if ($urlImagen !== '') {
        return ['ok' => true, 'path' => $urlImagen];
    }

    if ($productoId) {
        $existente = Producto::obtenerPorIdAdmin($productoId);

        if ($existente && !empty($existente['imagen_principal'])) {
            return ['ok' => true, 'path' => $existente['imagen_principal']];
        }
    }

    return ['ok' => false, 'error' => 'Sube una imagen o indica una URL.'];
}

function procesarColoresFormulario(array $post): array
{
    $nombres = $post['colores_nombre'] ?? [];
    $stocks = $post['colores_stock'] ?? [];
    $colores = [];

    if (!is_array($nombres)) {
        return [];
    }

    foreach ($nombres as $index => $nombre) {
        $nombre = trim((string) $nombre);
        if ($nombre === '') {
            continue;
        }

        $colores[] = [
            'nombre' => $nombre,
            'stock_cantidad' => max(0, (int) ($stocks[$index] ?? 0)),
            'orden' => count($colores),
        ];
    }

    return $colores;
}

function resolverImagenGaleria(string $urlImagen, ?string $urlActual = null): array
{
    $archivo = $_FILES['imagen_archivo'] ?? null;

    if ($archivo && ($archivo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
        return ImagenProducto::guardar($archivo);
    }

    if ($urlImagen !== '') {
        return ['ok' => true, 'path' => $urlImagen];
    }

    if ($urlActual) {
        return ['ok' => true, 'path' => $urlActual];
    }

    return ['ok' => false, 'error' => 'Sube una imagen o indica una URL.'];
}
