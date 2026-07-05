<?php

define('DEPORTIVO_JSON_API', true);

require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/models/Categoria.php';

header('Content-Type: application/json; charset=utf-8');

requerirAdmin();

$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'list':
            echo json_encode(['ok' => true, 'categorias' => Categoria::listar()]);
            break;

        case 'get':
            $id = (int) ($_GET['id'] ?? 0);
            $categoria = $id > 0 ? Categoria::obtenerPorId($id) : null;

            if (!$categoria) {
                echo json_encode(['ok' => false, 'error' => 'Categoría no encontrada.']);
                exit;
            }

            $categoria['productos_count'] = Categoria::contarProductos($id);

            echo json_encode(['ok' => true, 'categoria' => $categoria]);
            break;

        case 'create':
            $nombre = trim($_POST['nombre'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');

            if ($nombre === '') {
                echo json_encode(['ok' => false, 'error' => 'El nombre es obligatorio.']);
                exit;
            }

            $id = Categoria::crear($nombre, $descripcion);
            $categoria = Categoria::obtenerPorId($id);

            echo json_encode([
                'ok' => true,
                'message' => 'Categoría creada correctamente.',
                'categoria' => $categoria,
            ]);
            break;

        case 'update':
            $id = (int) ($_POST['id'] ?? 0);
            $nombre = trim($_POST['nombre'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');

            if ($id <= 0) {
                echo json_encode(['ok' => false, 'error' => 'ID de categoría inválido.']);
                exit;
            }

            if ($nombre === '') {
                echo json_encode(['ok' => false, 'error' => 'El nombre es obligatorio.']);
                exit;
            }

            if (!Categoria::actualizar($id, $nombre, $descripcion)) {
                echo json_encode(['ok' => false, 'error' => 'No se pudo actualizar la categoría.']);
                exit;
            }

            echo json_encode([
                'ok' => true,
                'message' => 'Categoría actualizada correctamente.',
                'categoria' => Categoria::obtenerPorId($id),
            ]);
            break;

        case 'delete':
            $id = (int) ($_POST['id'] ?? 0);
            $resultado = Categoria::eliminar($id);

            if (!$resultado['ok']) {
                echo json_encode(['ok' => false, 'error' => $resultado['error']]);
                exit;
            }

            echo json_encode(['ok' => true, 'message' => 'Categoría eliminada correctamente.']);
            break;

        default:
            echo json_encode(['ok' => false, 'error' => 'Acción no válida.']);
    }
} catch (InvalidArgumentException $e) {
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Error del servidor.']);
}
