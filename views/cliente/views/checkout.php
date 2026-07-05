<?php

session_start();

require_once dirname(__DIR__, 3) . '/includes/auth.php';

$nombreSesion = $_SESSION['nombre'] ?? '';
$emailSesion = $_SESSION['email'] ?? '';
$error = $_GET['error'] ?? '';

$mensajesError = [
    'campos' => 'Completa todos los campos obligatorios de envío.',
    'email' => 'Introduce un correo electrónico válido.',
    'servidor' => 'No pudimos procesar tu pedido. Inténtalo de nuevo.',
];

$mensajeError = $mensajesError[$error] ?? '';

$navInViews = true;
$cartBasePath = $assetBase;
$cartUrl = 'carrito_compras.php';

?>
<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Datos de envío | DEPORTIVO</title>
    <?php include __DIR__ . '/../includes/design-head.php'; ?>
</head>

<body class="font-body-md text-on-background dark:bg-on-background dark:text-inverse-on-surface transition-colors duration-300">
    <?php include __DIR__ . '/../includes/site-nav.php'; ?>

    <main class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-20">
        <nav class="flex items-center gap-2 font-label-sm text-label-sm text-on-surface-variant mb-8">
            <a href="carrito_compras.php" class="hover:text-secondary transition-colors no-underline text-current">Carrito</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary dark:text-primary-fixed">Envío</span>
        </nav>

        <h1 class="font-display-lg text-display-lg mb-4 text-primary dark:text-primary-fixed uppercase">Datos de envío</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant mb-12 max-w-2xl">Indica dónde quieres recibir tu pedido. Usaremos estos datos para preparar y enviar tu compra.</p>

        <?php if ($mensajeError): ?>
        <div class="mb-8 p-4 border border-error/30 bg-error-container/30 text-on-error-container font-body-md">
            <?= htmlspecialchars($mensajeError) ?>
        </div>
        <?php endif; ?>

        <div id="checkout-empty" class="hidden py-16 text-center">
            <p class="font-body-lg text-on-surface-variant mb-8">Tu bolsa está vacía. Añade productos antes de finalizar la compra.</p>
            <a href="catalogo.php?categoria=camisetas" class="inline-block bg-secondary text-on-secondary px-10 py-4 font-label-md uppercase tracking-widest no-underline hover:bg-primary hover:text-on-primary transition-all">Explorar catálogo</a>
        </div>

        <div id="checkout-content" class="hidden grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            <section class="lg:col-span-7">
                <form id="checkout-form" action="../controllers/checkoutController.php" method="post" class="space-y-10">
                    <input type="hidden" name="cart_data" id="cart-data" value="" />

                    <div class="space-y-6">
                        <h2 class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed">Información personal</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="nombre">Nombre *</label>
                                <input class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="nombre" name="nombre" type="text" required value="<?= htmlspecialchars($nombreSesion) ?>" placeholder="María" />
                            </div>
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="apellido">Apellido *</label>
                                <input class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="apellido" name="apellido" type="text" required placeholder="García" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="email">Correo electrónico *</label>
                                <input class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="email" name="email" type="email" required value="<?= htmlspecialchars($emailSesion) ?>" placeholder="nombre@ejemplo.com" />
                            </div>
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="telefono">Teléfono *</label>
                                <input class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="telefono" name="telefono" type="tel" required placeholder="+34 600 000 000" />
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6 pt-4 border-t border-outline-variant">
                        <h2 class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed">Dirección de envío</h2>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="direccion">Dirección *</label>
                            <input class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="direccion" name="direccion" type="text" required placeholder="Calle, número, piso, puerta" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="ciudad">Ciudad *</label>
                                <input class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="ciudad" name="ciudad" type="text" required placeholder="Madrid" />
                            </div>
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="provincia">Provincia *</label>
                                <input class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="provincia" name="provincia" type="text" required placeholder="Madrid" />
                            </div>
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="codigo_postal">Código postal (opcional)</label>
                                <input class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="codigo_postal" name="codigo_postal" type="text" placeholder="28001" />
                            </div>
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="notas">Notas para el envío (opcional)</label>
                            <textarea class="w-full py-3 bg-transparent border border-outline-variant focus:border-secondary focus:ring-0 font-body-md resize-none" id="notas" name="notas" rows="3" placeholder="Instrucciones para el repartidor, horario preferido, etc."></textarea>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="carrito_compras.php" class="flex-1 text-center py-4 border border-primary text-primary font-label-md uppercase tracking-widest no-underline hover:bg-surface-container transition-all">Volver al carrito</a>
                        <button type="submit" class="flex-1 py-4 bg-secondary text-on-secondary font-label-md uppercase tracking-widest hover:opacity-90 transition-all flex items-center justify-center gap-2">
                            Confirmar pedido
                            <span class="material-symbols-outlined text-sm">chat</span>
                        </button>
                    </div>
                    <p class="font-body-md text-body-md text-on-surface-variant pt-2">Al confirmar, guardaremos tu pedido y se abrirá WhatsApp con el resumen para que lo envíes a la tienda.</p>
                </form>
            </section>

            <aside class="lg:col-span-5 bg-surface-container-low dark:bg-tertiary-container p-10">
                <h2 class="font-headline-sm text-headline-sm mb-8">Tu pedido</h2>
                <div id="checkout-items" class="space-y-6 mb-8 max-h-80 overflow-y-auto"></div>
                <div class="space-y-4 border-t border-outline-variant pt-8">
                    <div class="flex justify-between font-body-md">
                        <span class="text-on-surface-variant">Subtotal</span>
                        <span id="checkout-subtotal">$0.00</span>
                    </div>
                    <div class="flex justify-between font-body-md">
                        <span class="text-on-surface-variant">Envío estimado</span>
                        <span id="checkout-shipping">$0.00</span>
                    </div>
                    <div class="flex justify-between font-body-lg font-bold pt-4 border-t border-outline-variant">
                        <span>Total</span>
                        <span id="checkout-total">$0.00</span>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/site-footer.php'; ?>

    <script>
        window.CART_CONFIG = { basePath: <?= json_encode($assetBase) ?>, cartUrl: 'carrito_compras.php' };
    </script>
    <script src="<?= htmlspecialchars($clienteJsPath) ?>cart.js"></script>
    <script src="<?= htmlspecialchars($clienteJsPath) ?>checkout.js"></script>
    <?php $cartBasePath = $assetBase; $cartUrl = 'carrito_compras.php'; $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="<?= htmlspecialchars($assetBase) ?>js/theme/toggle.js"></script>
</body>

</html>
