<?php

session_start();

require_once dirname(__DIR__, 3) . '/models/Pedido.php';
require_once dirname(__DIR__, 3) . '/includes/MailPedido.php';
require_once dirname(__DIR__, 3) . '/config/moneda.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/checkout.php');
    exit;
}

$camposObligatorios = [
    'nombre',
    'apellido',
    'email',
    'telefono',
    'direccion',
    'ciudad',
    'provincia',
];

$envio = [];

foreach (array_merge($camposObligatorios, ['codigo_postal']) as $campo) {
    $envio[$campo] = trim($_POST[$campo] ?? '');
}

$envio['notas'] = trim($_POST['notas'] ?? '');

foreach ($camposObligatorios as $campo) {
    if ($envio[$campo] === '') {
        header('Location: ../views/checkout.php?error=campos');
        exit;
    }
}

if (!filter_var($envio['email'], FILTER_VALIDATE_EMAIL)) {
    header('Location: ../views/checkout.php?error=email');
    exit;
}

$cartJson = $_POST['cart_data'] ?? '[]';
$items = json_decode($cartJson, true);

if (!is_array($items) || empty($items)) {
    header('Location: ../views/carrito_compras.php');
    exit;
}

$usuarioId = isset($_SESSION['usuario_id']) ? (int) $_SESSION['usuario_id'] : null;

try {
    $pedidoId = Pedido::crear($envio, $items, $usuarioId);
} catch (Throwable $e) {
    header('Location: ../views/checkout.php?error=servidor');
    exit;
}

try {
    MailPedido::notificarPedidoNuevo($pedidoId);
} catch (Throwable $e) {
    // El pedido ya está guardado; no bloquear si falla el correo.
}

$_SESSION['ultimo_pedido_id'] = $pedidoId;

header('Location: ../views/checkout_exito.php?id=' . $pedidoId);
exit;
