<?php

session_start();

require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../includes/WhatsAppPedido.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/checkout.php');
    exit;
}

$campos = [
    'nombre',
    'apellido',
    'email',
    'telefono',
    'direccion',
    'ciudad',
    'provincia',
    'codigo_postal',
];

$envio = [];

foreach ($campos as $campo) {
    $envio[$campo] = trim($_POST[$campo] ?? '');
}

$envio['notas'] = trim($_POST['notas'] ?? '');

foreach ($campos as $campo) {
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

$subtotal = 0.0;

foreach ($items as $item) {
    $subtotal += (float) ($item['precio'] ?? 0) * (int) ($item['cantidad'] ?? 1);
}

$envioCosto = $subtotal >= 300 ? 0.0 : ($subtotal > 0 ? 12.0 : 0.0);
$total = $subtotal + $envioCosto;

try {
    $pedidoId = Pedido::crear($envio, $items, $usuarioId);
} catch (Throwable $e) {
    header('Location: ../views/checkout.php?error=servidor');
    exit;
}

$mensajeWhatsApp = WhatsAppPedido::construirMensaje(
    $pedidoId,
    $envio,
    $items,
    $subtotal,
    $envioCosto,
    $total
);

$_SESSION['whatsapp_pedido_url'] = WhatsAppPedido::construirUrl($mensajeWhatsApp);
$_SESSION['ultimo_pedido_id'] = $pedidoId;

header('Location: ../views/checkout_exito.php?id=' . $pedidoId);
exit;
