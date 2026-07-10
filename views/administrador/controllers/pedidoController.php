<?php

define('DEPORTIVO_JSON_API', true);

require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/models/Pedido.php';
require_once dirname(__DIR__, 3) . '/includes/MailPedido.php';

header('Content-Type: application/json; charset=utf-8');

requerirAdmin();

$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'list':
            $estado = trim($_GET['estado'] ?? '');
            $page = max(1, (int) ($_GET['page'] ?? 1));
            $limit = min(100, max(1, (int) ($_GET['limit'] ?? 10)));
            $offset = ($page - 1) * $limit;

            $pedidos = Pedido::listar($estado !== '' ? $estado : null, $limit, $offset);
            $total = Pedido::contar($estado !== '' ? $estado : null);

            echo json_encode([
                'ok' => true,
                'pedidos' => $pedidos,
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'totalPages' => $total > 0 ? (int) ceil($total / $limit) : 1,
            ]);
            break;

        case 'get':
            $id = (int) ($_GET['id'] ?? 0);
            $pedido = $id > 0 ? Pedido::obtenerPorId($id) : null;

            if (!$pedido) {
                echo json_encode(['ok' => false, 'error' => 'Pedido no encontrado.']);
                exit;
            }

            $pedido['items'] = Pedido::enriquecerItemsConImagen($pedido['items'] ?? []);

            echo json_encode(['ok' => true, 'pedido' => $pedido]);
            break;

        case 'update_estado':
            $id = (int) ($_POST['id'] ?? 0);
            $estado = trim($_POST['estado'] ?? '');

            if ($id <= 0) {
                echo json_encode(['ok' => false, 'error' => 'ID de pedido inválido.']);
                exit;
            }

            $pedido = Pedido::obtenerPorId($id);

            if (!$pedido) {
                echo json_encode(['ok' => false, 'error' => 'Pedido no encontrado.']);
                exit;
            }

            $estadoAnterior = $pedido['estado'] ?? '';

            if (!Pedido::actualizarEstado($id, $estado)) {
                echo json_encode(['ok' => false, 'error' => 'No se pudo actualizar el estado.']);
                exit;
            }

            $correoEnviado = false;

            if ($estado === 'enviado' && $estadoAnterior !== 'enviado') {
                $pedido['estado'] = 'enviado';
                $pedido['items'] = Pedido::enriquecerItemsConImagen($pedido['items'] ?? []);

                try {
                    $correoEnviado = MailPedido::enviarPedidoEnCamino($pedido);
                } catch (Throwable $e) {
                    $correoEnviado = false;
                }
            }

            $mensaje = 'Estado actualizado correctamente.';

            if ($estado === 'enviado' && $estadoAnterior !== 'enviado') {
                $mensaje .= $correoEnviado
                    ? ' Se notificó al cliente por correo.'
                    : ' No se pudo enviar el correo al cliente.';
            }

            echo json_encode([
                'ok' => true,
                'message' => $mensaje,
                'correo_enviado' => $correoEnviado,
            ]);
            break;

        case 'count_pendientes':
            echo json_encode([
                'ok' => true,
                'count' => Pedido::contarPendientes(),
            ]);
            break;

        default:
            echo json_encode(['ok' => false, 'error' => 'Acción no válida.']);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Error del servidor.']);
}
