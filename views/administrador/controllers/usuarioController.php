<?php

define('DEPORTIVO_JSON_API', true);

require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/models/Usuario.php';

header('Content-Type: application/json; charset=utf-8');

requerirAdmin();

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$usuarioSesionId = (int) ($_SESSION['usuario_id'] ?? 0);

try {
    switch ($action) {
        case 'list':
            echo json_encode(['ok' => true, 'usuarios' => Usuario::listar()]);
            break;

        case 'get':
            $id = (int) ($_GET['id'] ?? 0);
            $usuario = $id > 0 ? Usuario::obtenerPorId($id) : null;

            if (!$usuario) {
                echo json_encode(['ok' => false, 'error' => 'Usuario no encontrado.']);
                exit;
            }

            echo json_encode(['ok' => true, 'usuario' => $usuario]);
            break;

        case 'create':
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $rol = trim($_POST['rol'] ?? 'cliente');

            $id = Usuario::crear($nombre, $email, $password, $rol, $apellido);
            $usuario = Usuario::obtenerPorId($id);

            echo json_encode([
                'ok' => true,
                'message' => 'Usuario creado correctamente.',
                'usuario' => $usuario,
            ]);
            break;

        case 'update':
            $id = (int) ($_POST['id'] ?? 0);
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? null;
            $rol = trim($_POST['rol'] ?? 'cliente');

            if ($id <= 0) {
                echo json_encode(['ok' => false, 'error' => 'ID de usuario inválido.']);
                exit;
            }

            if ($id === $usuarioSesionId && $rol !== 'admin') {
                echo json_encode(['ok' => false, 'error' => 'No puedes quitarte el rol de administrador a ti mismo.']);
                exit;
            }

            if (!Usuario::actualizar($id, $nombre, $email, $rol, $apellido, $password)) {
                echo json_encode(['ok' => false, 'error' => 'No se pudo actualizar el usuario.']);
                exit;
            }

            echo json_encode([
                'ok' => true,
                'message' => 'Usuario actualizado correctamente.',
                'usuario' => Usuario::obtenerPorId($id),
            ]);
            break;

        case 'delete':
            $id = (int) ($_POST['id'] ?? 0);
            $resultado = Usuario::eliminar($id, $usuarioSesionId);

            if (!$resultado['ok']) {
                echo json_encode(['ok' => false, 'error' => $resultado['error']]);
                exit;
            }

            echo json_encode(['ok' => true, 'message' => 'Usuario eliminado correctamente.']);
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
