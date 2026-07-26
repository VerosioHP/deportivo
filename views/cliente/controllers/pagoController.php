<?php

session_start();

require_once dirname(__DIR__, 3) . '/models/Pedido.php';
require_once dirname(__DIR__, 3) . '/includes/ImagenProducto.php';
require_once dirname(__DIR__, 3) . '/includes/MailPedido.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/checkout.php');
    exit;
}

$pedidoId = (int) ($_POST['pedido_id'] ?? 0);
$accion = trim((string) ($_POST['accion'] ?? 'confirmar'));

$redirectPago = static function (int $id, string $error = '') {
    $url = '../views/checkout_pago.php?id=' . $id;
    if ($error !== '') {
        $url .= '&error=' . urlencode($error);
    }
    header('Location: ' . $url);
    exit;
};

if ($pedidoId <= 0) {
    header('Location: ../views/checkout.php');
    exit;
}

$pedido = Pedido::obtenerPorId($pedidoId);

if (!$pedido) {
    header('Location: ../views/catalogo.php?categoria=camisetas');
    exit;
}

if ($accion === 'cancelar') {
    try {
        if (!Pedido::cancelarPorCliente($pedidoId)) {
            $redirectPago($pedidoId, 'servidor');
        }
    } catch (Throwable $e) {
        $redirectPago($pedidoId, 'servidor');
    }

    unset($_SESSION['ultimo_pedido_id']);
    header('Location: ../views/catalogo.php?categoria=camisetas&pedido=cancelado');
    exit;
}

if (!empty($pedido['metodo_pago'])) {
    header('Location: ../views/checkout_exito.php?id=' . $pedidoId);
    exit;
}

if (($pedido['estado'] ?? '') === 'cancelado') {
    header('Location: ../views/catalogo.php?categoria=camisetas');
    exit;
}

$metodoPago = trim((string) ($_POST['metodo_pago'] ?? ''));

$esMetropolitana = ($pedido['zona_envio'] ?? '') === 'metropolitana'
    || Pedido::esZonaMetropolitana((string) $pedido['ciudad']);

if ($metodoPago === '' || !in_array($metodoPago, Pedido::METODOS_PAGO, true)) {
    $redirectPago($pedidoId, 'metodo');
}

if (!$esMetropolitana && $metodoPago !== 'transferencia') {
    $metodoPago = 'transferencia';
}

$comprobantePath = null;

if ($metodoPago === 'transferencia') {
    if (empty($_FILES['comprobante']) || ($_FILES['comprobante']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        $redirectPago($pedidoId, 'comprobante');
    }

    $resultado = ImagenProducto::guardar($_FILES['comprobante'], 'comprobantes');

    if (empty($resultado['ok'])) {
        $redirectPago($pedidoId, 'archivo');
    }

    $comprobantePath = $resultado['path'];
}

try {
    if (!Pedido::registrarPago($pedidoId, $metodoPago, $comprobantePath)) {
        $redirectPago($pedidoId, 'servidor');
    }
} catch (Throwable $e) {
    $redirectPago($pedidoId, 'servidor');
}

try {
    MailPedido::notificarPedidoNuevo($pedidoId);
} catch (Throwable $e) {
    // El pedido ya está registrado; no bloquear si falla el correo.
}

$_SESSION['ultimo_pedido_id'] = $pedidoId;

header('Location: ../views/checkout_exito.php?id=' . $pedidoId);
exit;
