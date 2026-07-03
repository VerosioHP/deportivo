<?php

$authInViews = true;
$activePage = 'favoritos';
require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/models/Producto.php';

$sugerencias = Producto::obtenerSugerencias(4);

$navInViews = true;
$cartBasePath = $assetBase;
$cartUrl = 'carrito_compras.php';

?>
<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Favoritos | DEPORTIVO</title>
    <?php $pageCss = 'pages/favoritos.css'; include __DIR__ . '/../includes/design-head.php'; ?>
</head>

<body class="font-body-md text-on-background dark:bg-on-background dark:text-inverse-on-surface transition-colors duration-300">
    <?php include __DIR__ . '/../includes/site-nav.php'; ?>
    <main class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-20">
        <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.25em] block mb-3">Tu lista</span>
        <h1 class="font-display-lg text-display-lg mb-4 text-primary dark:text-primary-fixed uppercase">Favoritos</h1>
        <p class="font-body-md text-body-md text-on-surface-variant mb-12 max-w-xl">Productos que guardaste para revisar después. Se mantienen en este navegador.</p>

        <div id="favorites-page-empty" class="py-20 text-center hidden">
            <span class="material-symbols-outlined text-5xl text-on-surface-variant mb-6 block">favorite</span>
            <p class="font-body-lg text-body-lg text-on-surface-variant mb-8">Aún no tienes favoritos.</p>
            <a href="catalogo.php?categoria=camisetas" class="inline-block bg-secondary text-on-secondary px-10 py-4 font-label-md text-label-md uppercase tracking-widest hover:bg-primary hover:text-on-primary transition-all no-underline">Explorar catálogo</a>
        </div>

        <div id="favorites-page-content" class="hidden">
            <div id="favorites-page-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter-desktop"></div>
        </div>

        <section class="mt-32">
            <div class="flex items-baseline justify-between mb-12">
                <h2 class="font-headline-md text-headline-md">Descubre más</h2>
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
    <script src="<?= htmlspecialchars($clienteJsPath) ?>catalogo-filters.js"></script>
    <?php $cartBasePath = $assetBase; $cartUrl = 'carrito_compras.php'; $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="<?= htmlspecialchars($assetBase) ?>js/theme/toggle.js"></script>
</body>

</html>
