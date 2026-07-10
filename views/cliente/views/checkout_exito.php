<?php

session_start();

require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/models/Pedido.php';

$pedidoId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$pedido = $pedidoId > 0 ? Pedido::obtenerPorId($pedidoId) : null;

if (!$pedido) {
    header('Location: catalogo.php?categoria=camisetas');
    exit;
}

$navInViews = true;
$cartBasePath = $assetBase;
$cartUrl = 'carrito_compras.php';
$facturaUrl = '../controllers/facturaController.php?id=' . (int) $pedido['id'];

?>
<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Pedido confirmado | DEPORTIVO</title>
    <?php include __DIR__ . '/../includes/design-head.php'; ?>
</head>

<body class="font-body-md text-on-background dark:bg-on-background dark:text-inverse-on-surface transition-colors duration-300">
    <?php include __DIR__ . '/../includes/site-nav.php'; ?>

    <main class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-20 text-center">
        <div class="max-w-xl mx-auto">
            <span class="material-symbols-outlined text-5xl text-secondary mb-6">check_circle</span>
            <h1 class="font-display-lg text-display-lg text-primary dark:text-primary-fixed mb-4 uppercase">¡Pedido confirmado!</h1>
            <p class="font-body-lg text-on-surface-variant mb-2">Gracias, <?= htmlspecialchars($pedido['nombre']) ?>. Hemos recibido tu pedido <strong>#<?= htmlspecialchars(Pedido::numeroPublico($pedido)) ?></strong>.</p>
            <p class="font-body-md text-on-surface-variant mb-10">Te enviamos un correo a <strong><?= htmlspecialchars($pedido['email']) ?></strong> con los detalles. La tienda también fue notificada por email. Tu compra llegará a:</p>

            <div class="text-left bg-surface-container-low dark:bg-tertiary-container p-8 mb-10 border border-outline-variant">
                <p class="font-label-sm uppercase tracking-widest text-on-surface-variant mb-4">Dirección de envío</p>
                <p class="font-body-md"><?= htmlspecialchars($pedido['nombre'] . ' ' . $pedido['apellido']) ?></p>
                <p class="font-body-md text-on-surface-variant"><?= htmlspecialchars($pedido['direccion']) ?></p>
                <p class="font-body-md text-on-surface-variant"><?= htmlspecialchars($pedido['codigo_postal'] . ' ' . $pedido['ciudad'] . ', ' . $pedido['provincia']) ?></p>
                <p class="font-body-md text-on-surface-variant mt-2"><?= htmlspecialchars($pedido['telefono']) ?></p>
            </div>

            <p class="font-headline-sm text-headline-sm text-primary mb-2">Total: <?= deportivo_formatear_precio((float) $pedido['total']) ?></p>
            <p class="font-body-md text-on-surface-variant mb-8">Te contactaremos pronto para confirmar disponibilidad y coordinar el envío.</p>

            <div class="bg-surface-container-low dark:bg-tertiary-container border border-outline-variant p-6 mb-10 text-left">
                <p class="font-label-sm uppercase tracking-widest text-on-surface-variant mb-2">Tu factura</p>
                <p class="font-body-md text-on-surface-variant mb-4">Descarga el comprobante de tu pedido en PDF con el detalle de productos y totales.</p>
                <a href="<?= htmlspecialchars($facturaUrl) ?>" class="inline-flex items-center justify-center gap-2 bg-primary text-on-primary px-8 py-4 font-label-md uppercase tracking-widest no-underline hover:opacity-90 transition-all">
                    <span class="material-symbols-outlined text-base">download</span>
                    Descargar factura
                </a>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-10">
                <a href="catalogo.php?categoria=camisetas" class="inline-block bg-secondary text-on-secondary px-10 py-4 font-label-md uppercase tracking-widest no-underline hover:bg-primary hover:text-on-primary transition-all">Seguir comprando</a>
                <a href="../index.php" class="inline-block border border-primary text-primary px-10 py-4 font-label-md uppercase tracking-widest no-underline hover:bg-surface-container transition-all">Ir al inicio</a>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/site-footer.php'; ?>

    <script>
        localStorage.removeItem('majestic_cart');
    </script>
    <?php $cartBasePath = $assetBase; $cartUrl = 'carrito_compras.php'; $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="<?= htmlspecialchars($clienteJsPath) ?>cart.js"></script>
    <script src="<?= htmlspecialchars($assetBase) ?>js/theme/toggle.js"></script>
</body>

</html>
