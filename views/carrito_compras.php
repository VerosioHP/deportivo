<?php

require_once __DIR__ . '/../models/Producto.php';

$sugerencias = Producto::obtenerSugerencias(4);

$navInViews = true;
$cartBasePath = '../';
$cartUrl = 'carrito_compras.php';

?>
<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Tu bolsa | DEPORTIVO</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&amp;family=Oswald:wght@500;600;700&amp;display=swap" rel="stylesheet" />
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script src="../js/theme-init.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="../css/site.css">
    <link rel="stylesheet" href="../css/carrito_compras.css">
    <link rel="stylesheet" href="../css/theme.css">
    <script src="../js/tailwind-theme.js"></script>
</head>

<body class="font-body-md text-on-background dark:bg-on-background dark:text-inverse-on-surface transition-colors duration-300">
    <?php include __DIR__ . '/../includes/site-nav.php'; ?>
    <main class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-20">
        <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.25em] block mb-3">Tu compra</span>
        <h1 class="font-display-lg text-display-lg mb-12 text-primary dark:text-primary-fixed uppercase">Bolsa de compras</h1>
        <div id="cart-page-empty" class="py-20 text-center hidden">
            <p class="font-body-lg text-body-lg text-on-surface-variant mb-8">Tu bolsa está vacía.</p>
            <a href="catalogo.php?categoria=camisetas" class="inline-block bg-secondary text-on-secondary px-10 py-4 font-label-md text-label-md uppercase tracking-widest hover:bg-primary hover:text-on-primary transition-all no-underline">Explorar catálogo</a>
        </div>
        <div id="cart-page-content" class="hidden grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            <!-- Items List -->
            <section class="lg:col-span-8 space-y-12" id="cart-page-items"></section>
            <!-- Summary Sidebar -->
            <aside class="lg:col-span-4 bg-surface-container-low dark:bg-tertiary-container p-10">
                <h2 class="font-headline-sm text-headline-sm mb-8">Resumen</h2>
                <div class="space-y-4 mb-8 border-b border-outline-variant pb-8">
                    <div class="flex justify-between font-body-md text-body-md">
                        <span class="text-on-surface-variant">Subtotal</span>
                        <span id="cart-summary-subtotal">$0.00</span>
                    </div>
                    <div class="flex justify-between font-body-md text-body-md">
                        <span class="text-on-surface-variant">Envío estimado</span>
                        <span id="cart-summary-shipping">$0.00</span>
                    </div>
                    <div class="flex justify-between font-body-md text-body-md">
                        <span class="text-on-surface-variant">Impuestos</span>
                        <span>$0.00</span>
                    </div>
                </div>
                <div class="flex justify-between font-body-lg text-body-lg font-bold mb-10">
                    <span>Total</span>
                    <span id="cart-summary-total">$0.00</span>
                </div>
                <a id="checkout-btn" href="checkout.php" class="w-full bg-secondary text-on-secondary py-5 font-label-md text-label-md hover:opacity-90 transition-all flex items-center justify-center gap-2 no-underline opacity-50 pointer-events-none">
                        FINALIZAR COMPRA
                        <span class="material-symbols-outlined text-sm"
                            data-icon="arrow_forward">arrow_forward</span>
                    </a>
                <div class="mt-8 flex flex-col gap-4">
                    <div class="flex items-center gap-3 text-on-surface-variant">
                        <span class="material-symbols-outlined" data-icon="local_shipping">local_shipping</span>
                        <span class="text-label-sm">Envío gratis en pedidos superiores a $300</span>
                    </div>
                    <div class="flex items-center gap-3 text-on-surface-variant">
                        <span class="material-symbols-outlined" data-icon="reusable_bag">shopping_bag</span>
                        <span class="text-label-sm">Embalaje ecológico para tu equipo deportivo</span>
                    </div>
                </div>
            </aside>
        </div>
        <!-- Recommendations -->
        <section class="mt-32">
            <div class="flex items-baseline justify-between mb-12">
                <h2 class="font-headline-md text-headline-md">También te puede gustar</h2>
                <a class="text-label-md font-label-md underline hover:text-secondary transition-colors" href="catalogo.php?categoria=camisetas">VER TODO</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter-desktop">
                <?php foreach ($sugerencias as $producto): ?>
                <?php include __DIR__ . '/../includes/producto-card.php'; ?>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <?php include __DIR__ . '/../includes/site-footer.php'; ?>
    <script src="../js/catalogo-filters.js"></script>
    <?php $cartBasePath = '../'; $cartUrl = 'carrito_compras.php'; $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="../js/theme.js"></script>
</body>

</html>