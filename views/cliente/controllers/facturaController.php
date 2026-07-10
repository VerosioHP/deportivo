<?php

session_start();

require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/models/Pedido.php';

$autoload = dirname(__DIR__, 3) . '/vendor/autoload.php';

if (!is_file($autoload)) {
    http_response_code(503);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'No se puede generar la factura: ejecuta composer install en el proyecto.';
    exit;
}

require_once $autoload;
require_once dirname(__DIR__, 3) . '/includes/FacturaPdf.php';

$pedidoId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($pedidoId <= 0) {
    http_response_code(400);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Pedido inválido.';
    exit;
}

$pedido = Pedido::obtenerPorId($pedidoId);

if (!$pedido) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Pedido no encontrado.';
    exit;
}

if (!puedeDescargarFactura($pedido)) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'No tienes permiso para descargar esta factura.';
    exit;
}

try {
    $pdf = FacturaPdf::generar($pedido);
    $nombre = FacturaPdf::nombreArchivo($pedido);

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $nombre . '"');
    header('Content-Length: ' . strlen($pdf));
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');

    echo $pdf;
} catch (Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Error al generar la factura.';
}

function puedeDescargarFactura(array $pedido): bool
{
    if (!empty($GLOBALS['esAdmin'])) {
        return true;
    }

    $pedidoId = (int) $pedido['id'];
    $ultimoPedido = (int) ($_SESSION['ultimo_pedido_id'] ?? 0);

    if ($ultimoPedido === $pedidoId) {
        return true;
    }

    if (!empty($_SESSION['usuario_id'])) {
        $usuarioId = (int) $_SESSION['usuario_id'];
        $pedidoUsuarioId = isset($pedido['usuario_id']) ? (int) $pedido['usuario_id'] : 0;

        if ($pedidoUsuarioId > 0 && $pedidoUsuarioId === $usuarioId) {
            return true;
        }
    }

    return false;
}
