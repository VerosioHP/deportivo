<?php

require_once __DIR__ . '/../models/Producto.php';

$productoId = isset($_GET['id']) ? (int) $_GET['id'] : 7;
$producto = Producto::obtenerPorId($productoId);

if (!$producto) {
    header('Location: catalogo.php');
    exit;
}

$relacionados = Producto::obtenerRelacionados(
    (int) $producto['id'],
    (int) $producto['categoria_id'],
    4
);

$materialItems = Producto::parseMaterialInfo($producto['material_info']);
$primeraTalla = $producto['tallas'][0] ?? null;

?>
<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= htmlspecialchars($producto['nombre']) ?> | DENIM EDITORIAL</title>
    <script src="../js/theme-init.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&amp;family=Playfair+Display:ital,wght@0,500;0,600;1,500&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../css/producto.css">
    <link rel="stylesheet" href="../css/theme.css">
    <script src="../js/producto.js"></script>
</head>

<body class="bg-surface dark:bg-on-background text-on-surface dark:text-inverse-on-surface font-body-md antialiased transition-colors duration-300">
    <!-- TopNavBar -->
    <header class="w-full top-0 sticky bg-surface dark:bg-on-background border-b border-outline-variant dark:border-outline z-50">
        <nav class="flex justify-between items-center px-margin-desktop py-4 max-w-container-max-width mx-auto">
            <a class="font-headline-md text-headline-md font-semibold text-primary dark:text-primary-fixed no-underline hover:opacity-80 transition-opacity" href="../index.php">DENIM EDITORIAL</a>

            <div class="hidden md:flex gap-8">
                <a class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed transition-colors duration-300" href="catalogo.php?categoria=jeans">Catálogo</a>

                <a class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed transition-colors duration-300" href="catalogo.php?categoria=camisetas">Camisetas</a>

                <a class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed transition-colors duration-300" href="catalogo.php?categoria=chaquetas">Chaquetas</a>

                <a class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed transition-colors duration-300" href="nosotros.php">Nosotros</a>

            </div>
            <div class="flex items-center gap-6 text-primary dark:text-primary-fixed">
                <button type="button" class="transition-opacity duration-200 active:opacity-70 text-primary dark:text-primary-fixed">
                        <span class="material-symbols-outlined"
                            data-icon="search">search</span>
                    </button>
                <?php $cartBasePath = '../'; $cartUrl = 'carrito_compras.php'; $cartPart = 'button'; include __DIR__ . '/../includes/cart-widget.php'; ?>
                <a class="transition-opacity duration-200 active:opacity-70 text-primary dark:text-primary-fixed" href="login.php" aria-label="Cuenta">
                    <span class="material-symbols-outlined"
                        data-icon="person">person</span>
                </a>
                <button type="button" data-theme-toggle class="theme-toggle transition-opacity duration-200 active:opacity-70 text-primary dark:text-primary-fixed" aria-label="Activar modo oscuro" aria-pressed="false">
                    <span class="material-symbols-outlined theme-toggle-icon">dark_mode</span>
                </button>
            </div>
        </nav>
    </header>
    <main class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter-desktop">
            <!-- Thumbnail Gallery (Desktop Left) -->
            <?php if (!empty($producto['imagenes'])): ?>
            <div class="hidden lg:flex lg:col-span-1 flex-col gap-4">
                <?php foreach ($producto['imagenes'] as $index => $imagen): ?>
                <img class="w-full aspect-[3/4] object-cover cursor-pointer hover:opacity-80 transition-opacity <?= $index === 0 ? 'border border-outline-variant' : '' ?>" data-alt="<?= htmlspecialchars($imagen['alt_text'] ?? $producto['nombre']) ?>"
                    src="<?= htmlspecialchars($imagen['url']) ?>"
                />
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <!-- Main Product Image -->
            <div class="<?= !empty($producto['imagenes']) ? 'lg:col-span-6' : 'lg:col-span-7' ?> relative group overflow-hidden">
                <img class="w-full aspect-[3/4] object-cover transition-transform duration-700 group-hover:scale-105" data-alt="<?= htmlspecialchars($producto['imagen_alt'] ?? $producto['nombre']) ?>"
                    id="main-image" src="<?= htmlspecialchars($producto['imagen_principal']) ?>"
                />
                <!-- Mobile Carousel Indicators -->
                <?php if (!empty($producto['imagenes'])): ?>
                <div class="flex lg:hidden justify-center gap-2 mt-4">
                    <div class="w-2 h-2 rounded-full bg-secondary"></div>
                    <?php for ($i = 1; $i < count($producto['imagenes']); $i++): ?>
                    <div class="w-2 h-2 rounded-full bg-outline-variant"></div>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
            </div>
            <!-- Product Details -->
            <div class="lg:col-span-5 flex flex-col gap-8">
                <header class="flex flex-col gap-2">
                    <div class="flex justify-between items-start">
                        <h1 class="font-headline-md text-headline-md text-primary"><?= htmlspecialchars($producto['nombre']) ?></h1>
                        <button class="text-on-surface-variant hover:text-secondary transition-colors">
                                <span class="material-symbols-outlined"
                                    data-icon="favorite">favorite</span>
                            </button>
                    </div>
                    <p class="font-headline-sm text-headline-sm text-secondary"><?= Producto::formatearPrecio((float) $producto['precio']) ?></p>
                </header>
                <!-- Stock Indicator -->
                <div class="flex items-center gap-2 text-label-md font-label-md text-secondary">
                    <span class="w-2 h-2 rounded-full bg-secondary"></span> <?= htmlspecialchars(Producto::mensajeStock($producto['stock_estado'])) ?>
                </div>
                <div class="flex flex-col gap-6">
                    <div class="flex flex-col gap-4">
                        <div class="flex justify-between items-center">
                            <span class="font-label-md text-label-md uppercase tracking-wider text-primary">Talla</span>
                            <button type="button" class="font-label-sm text-label-sm text-secondary hover:underline">Guía de tallas</button>
                        </div>
                        <div class="flex flex-wrap gap-3" id="size-selector">
                            <?php foreach ($producto['tallas'] as $talla): ?>
                            <?php $activa = $talla === $primeraTalla; ?>
                            <button type="button" class="px-6 py-3 font-label-md uppercase <?= $activa ? 'border-2 border-secondary bg-surface-container text-secondary font-bold' : 'border border-outline text-on-surface-variant hover:border-secondary transition-all' ?>"><?= htmlspecialchars($talla) ?></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4 mt-4">
                        <button type="button"
                            class="w-full bg-primary text-on-primary py-5 font-label-md uppercase tracking-widest hover:bg-primary-container transition-all active:scale-[0.98] text-center"
                            data-add-to-cart
                            data-product-talla-from="selector"
                            data-product-id="<?= (int) $producto['id'] ?>"
                            data-product-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>"
                            data-product-precio="<?= (float) $producto['precio'] ?>"
                            data-product-imagen="<?= htmlspecialchars($producto['imagen_principal'], ENT_QUOTES) ?>"
                            data-product-talla="<?= htmlspecialchars($primeraTalla ?? 'M', ENT_QUOTES) ?>"
                            data-product-lavado="<?= htmlspecialchars($producto['lavado'] ?? '', ENT_QUOTES) ?>"
                            data-product-fit="<?= htmlspecialchars($producto['fit'] ?? '', ENT_QUOTES) ?>"
                            data-product-categoria="<?= htmlspecialchars($producto['categoria_nombre'] ?? '', ENT_QUOTES) ?>"
                            data-product-stock="<?= htmlspecialchars($producto['stock_estado'], ENT_QUOTES) ?>">
                            Añadir al carrito
                        </button>
                        <button type="button" class="w-full border border-primary text-primary py-5 font-label-md uppercase tracking-widest hover:bg-surface-container transition-all active:scale-[0.98]">
                                Añadir a favoritos
                            </button>
                    </div>
                </div>
                <div class="flex flex-col gap-6 pt-8 border-t border-outline-variant">
                    <details class="group" open>
                        <summary class="flex justify-between items-center cursor-pointer list-none font-label-md uppercase tracking-wider text-primary">
                            Descripción detallada
                            <span class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="mt-4 font-body-md text-on-surface-variant leading-relaxed">
                            <?= nl2br(htmlspecialchars($producto['descripcion'])) ?>
                        </div>
                    </details>
                    <?php if (!empty($materialItems)): ?>
                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer list-none font-label-md uppercase tracking-wider text-primary">
                            Información del material
                            <span class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="mt-4 font-body-md text-on-surface-variant">
                            <ul class="list-disc list-inside flex flex-col gap-2">
                                <?php foreach ($materialItems as $item): ?>
                                <li><?= htmlspecialchars($item) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </details>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Recommended Section -->
        <?php if (!empty($relacionados)): ?>
        <section class="mt-32">
            <h2 class="font-headline-md text-headline-md text-primary mb-12 text-center">Recomendado con este producto</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter-desktop">
                <?php foreach ($relacionados as $relacionado): ?>
                <?php $producto = $relacionado; include __DIR__ . '/../includes/producto-card.php'; ?>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </main>
    <!-- Footer -->
    <footer class="w-full mt-20 bg-surface-container-low dark:bg-tertiary-container border-t border-outline-variant dark:border-outline">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter-desktop px-margin-desktop py-16 max-w-container-max-width mx-auto">
            <div class="flex flex-col gap-4">
                <a class="font-headline-sm text-headline-sm text-primary no-underline hover:opacity-80 transition-opacity" href="../index.php">DENIM EDITORIAL</a>
                <p class="font-body-md text-on-surface-variant">Elevamos lo cotidiano con denim curado y siluetas atemporales.</p>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="font-label-md text-label-md uppercase tracking-widest text-primary">Enlaces rápidos</h4>
                <div class="flex flex-wrap gap-x-8 gap-y-2">
                    <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="login.php">Newsletter</a>
                    <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="login.php">Privacidad</a>
                    <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="login.php">Términos</a>
                    <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="catalogo.php">Envíos</a>
                    <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="login.php">Contacto</a>
                </div>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="font-label-md text-label-md uppercase tracking-widest text-primary">Newsletter</h4>
                <div class="flex border-b border-outline">
                    <input class="bg-transparent border-none py-2 px-0 w-full focus:ring-0 text-label-md uppercase" placeholder="TU CORREO" type="email" />
                    <button class="text-primary hover:text-secondary transition-colors">
                            <span class="material-symbols-outlined"
                                data-icon="arrow_forward">arrow_forward</span>
                        </button>
                </div>
            </div>
        </div>
        <div class="px-margin-desktop py-8 max-w-container-max-width mx-auto border-t border-outline-variant">
            <p class="font-label-sm text-label-sm text-on-surface-variant">© 2024 DENIM EDITORIAL. TODOS LOS DERECHOS RESERVADOS.</p>
        </div>
    </footer>
    <script>
        const thumbnails = document.querySelectorAll('.lg\\:col-span-1 img[data-alt]');
        const mainImage = document.getElementById('main-image');

        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', () => {
                mainImage.src = thumb.src;
                mainImage.setAttribute('data-alt', thumb.getAttribute('data-alt'));
            });
        });

        const sizeButtons = document.querySelectorAll('#size-selector button');
        sizeButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                sizeButtons.forEach(b => {
                    b.classList.remove('border-2', 'border-secondary', 'bg-surface-container', 'text-secondary', 'font-bold');
                    b.classList.add('border', 'border-outline', 'text-on-surface-variant');
                });
                btn.classList.add('border-2', 'border-secondary', 'bg-surface-container', 'text-secondary', 'font-bold');
                btn.classList.remove('border', 'border-outline', 'text-on-surface-variant');
            });
        });
    </script>
    <script src="../js/catalogo-filters.js"></script>
    <?php $cartBasePath = '../'; $cartUrl = 'carrito_compras.php'; $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="../js/theme.js"></script>
</body>

</html>
