<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/ImagenProducto.php';
require_once __DIR__ . '/../models/Producto.php';

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

            $datos = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'precio' => $_POST['precio'] ?? 0,
                'categoria_id' => (int) ($_POST['categoria_id'] ?? 0),
                'imagen_principal' => $imagenResultado['path'],
                'descripcion' => trim($_POST['descripcion'] ?? ''),
                'lavado' => trim($_POST['lavado'] ?? ''),
                'fit' => trim($_POST['fit'] ?? ''),
                'material_info' => trim($_POST['material_info'] ?? ''),
                'stock_estado' => $_POST['stock_estado'] ?? 'disponible',
                'activo' => isset($_POST['activo']) ? 1 : ($action === 'create' ? 1 : 0),
                'tallas' => Producto::parseTallasInput($_POST['tallas'] ?? ''),
            ];

            if ($datos['nombre'] === '' || $datos['categoria_id'] <= 0 || $datos['descripcion'] === '') {
                echo json_encode(['ok' => false, 'error' => 'Completa los campos obligatorios.']);
                exit;
            }

            if (empty($datos['tallas'])) {
                echo json_encode(['ok' => false, 'error' => 'Indica al menos una talla.']);
                exit;
            }

            if (!in_array($datos['stock_estado'], ['disponible', 'pocas_unidades', 'agotado'], true)) {
                $datos['stock_estado'] = 'disponible';
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
