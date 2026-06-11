<?php

require_once __DIR__ . '/../models/Producto.php';

$sugerencias = Producto::obtenerSugerencias(4);

?>
<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Tu bolsa | DENIM EDITORIAL</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&amp;family=Playfair+Display:ital,wght@0,400..900;1,400..900&amp;display=swap" rel="stylesheet" />
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script src="../js/theme-init.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="../css/carrito_compras.css">
    <link rel="stylesheet" href="../css/theme.css">
    <script src="../js/carrito_compras.js"></script>
</head>

<body class="font-body-md text-on-background dark:bg-on-background dark:text-inverse-on-surface transition-colors duration-300">
    <!-- TopNavBar -->
    <header class="sticky top-0 w-full z-50 bg-surface dark:bg-surface-dim border-b border-outline-variant dark:border-outline">
        <nav class="flex justify-between items-center h-20 px-margin-desktop max-w-container-max-width mx-auto">
            <a class="text-headline-sm font-headline-sm tracking-tight text-primary dark:text-primary-fixed cursor-pointer no-underline hover:opacity-80 transition-opacity" href="../index.php">DENIM EDITORIAL</a>

            <div class="hidden md:flex items-center gap-10">
                <a class="font-label-md text-label-md text-on-surface-variant dark:text-on-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors" href="catalogo.php?categoria=jeans">Catálogo</a>

                <a class="font-label-md text-label-md text-on-surface-variant dark:text-on-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors" href="catalogo.php?categoria=camisetas">Camisetas</a>

                <a class="font-label-md text-label-md text-on-surface-variant dark:text-on-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors" href="catalogo.php?categoria=chaquetas">Chaquetas</a>

                <a class="font-label-md text-label-md text-on-surface-variant dark:text-on-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors" href="nosotros.php">Nosotros</a>
            </div>
            <div class="flex items-center gap-6 text-primary dark:text-primary-fixed">
                <button type="button" class="cursor-pointer transition-opacity duration-200 active:opacity-70 text-primary dark:text-primary-fixed">
                        <span class="material-symbols-outlined"
                            data-icon="search">search</span>
                    </button>
                <?php $cartBasePath = '../'; $cartUrl = 'carrito_compras.php'; $cartPart = 'button'; include __DIR__ . '/../includes/cart-widget.php'; ?>
                <a class="cursor-pointer transition-opacity duration-200 active:opacity-70 text-primary dark:text-primary-fixed no-underline" href="login.php" aria-label="Cuenta">
                    <span class="material-symbols-outlined" data-icon="person">person</span>
                </a>
                <button type="button" data-theme-toggle class="theme-toggle cursor-pointer transition-opacity duration-200 active:opacity-70 text-primary dark:text-primary-fixed" aria-label="Activar modo oscuro" aria-pressed="false">
                    <span class="material-symbols-outlined theme-toggle-icon">dark_mode</span>
                </button>
            </div>
        </nav>
    </header>
    <main class="max-w-container-max-width mx-auto px-margin-desktop py-20">
        <h1 class="font-display-lg text-display-lg mb-12 text-primary dark:text-primary-fixed">Tu bolsa de compras</h1>
        <div id="cart-page-empty" class="py-20 text-center hidden">
            <p class="font-body-lg text-body-lg text-on-surface-variant mb-8">Tu bolsa está vacía.</p>
            <a href="catalogo.php?categoria=jeans" class="inline-block bg-primary text-on-primary px-10 py-4 font-label-md text-label-md uppercase tracking-widest hover:bg-secondary transition-all no-underline">Explorar catálogo</a>
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
                <button class="w-full bg-primary text-on-primary py-5 font-label-md text-label-md hover:bg-opacity-90 transition-all flex items-center justify-center gap-2">
                        FINALIZAR COMPRA
                        <span class="material-symbols-outlined text-sm"
                            data-icon="arrow_forward">arrow_forward</span>
                    </button>
                <div class="mt-8 flex flex-col gap-4">
                    <div class="flex items-center gap-3 text-on-surface-variant">
                        <span class="material-symbols-outlined" data-icon="local_shipping">local_shipping</span>
                        <span class="text-label-sm">Envío gratis en pedidos superiores a $300</span>
                    </div>
                    <div class="flex items-center gap-3 text-on-surface-variant">
                        <span class="material-symbols-outlined" data-icon="reusable_bag">shopping_bag</span>
                        <span class="text-label-sm">Embalaje editorial sostenible</span>
                    </div>
                </div>
            </aside>
        </div>
        <!-- Recommendations -->
        <section class="mt-32">
            <div class="flex items-baseline justify-between mb-12">
                <h2 class="font-headline-md text-headline-md">También te puede gustar</h2>
                <a class="text-label-md font-label-md underline hover:text-secondary transition-colors" href="catalogo.php?categoria=jeans">VER TODO</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter-desktop">
                <?php foreach ($sugerencias as $producto): ?>
                <?php include __DIR__ . '/../includes/producto-card.php'; ?>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer class="w-full bg-surface-container dark:bg-surface-container-highest mt-32">
        <div class="flex flex-col md:flex-row justify-between items-start gap-gutter-desktop py-20 px-margin-desktop max-w-container-max-width mx-auto">
            <div class="max-w-xs">
                <a class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed mb-6 block no-underline hover:opacity-80 transition-opacity" href="../index.php">DENIM EDITORIAL</a>
                <p class="font-body-md text-body-md text-on-surface-variant">Curaduría de siluetas denim atemporales para el guardarropa moderno. Enfocados en calidad, durabilidad y la belleza del tejido que evoluciona.</p>
            </div>
            <div class="grid grid-cols-2 gap-20">
                <div class="flex flex-col gap-4">
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary">Información</span>
                    <a class="font-body-md text-body-md text-on-tertiary-fixed-variant dark:text-on-tertiary-container hover:text-primary transition-all" href="login.php">Sostenibilidad</a>
                    <a class="font-body-md text-body-md text-on-tertiary-fixed-variant dark:text-on-tertiary-container hover:text-primary transition-all" href="catalogo.php">Envíos</a>
                    <a class="font-body-md text-body-md text-on-tertiary-fixed-variant dark:text-on-tertiary-container hover:text-primary transition-all" href="catalogo.php">Devoluciones</a>
                </div>
                <div class="flex flex-col gap-4">
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary">Contacto</span>
                    <a class="font-body-md text-body-md text-on-tertiary-fixed-variant dark:text-on-tertiary-container hover:text-primary transition-all" href="login.php">Contacto</a>
                    <a class="font-body-md text-body-md text-on-tertiary-fixed-variant dark:text-on-tertiary-container hover:text-primary transition-all" href="login.php">Privacidad</a>
                    <a class="font-body-md text-body-md text-on-tertiary-fixed-variant dark:text-on-tertiary-container hover:text-primary transition-all" href="../index.php">Instagram</a>
                </div>
            </div>
        </div>
        <div class="px-margin-desktop max-w-container-max-width mx-auto pb-10 border-t border-outline-variant/30 pt-10">
            <div class="font-label-sm text-label-sm text-on-tertiary-fixed-variant">© 2024 DENIM EDITORIAL. TODOS LOS DERECHOS RESERVADOS.</div>
        </div>
    </footer>
    <script src="../js/catalogo-filters.js"></script>
    <?php $cartBasePath = '../'; $cartUrl = 'carrito_compras.php'; $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="../js/theme.js"></script>
</body>

</html>