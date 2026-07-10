<?php

$authInViews = true;
require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/models/Producto.php';

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
$colores = $producto['colores'] ?? [];
$tieneColores = count($colores) > 0;
$colorDefault = $tieneColores ? $colores[0] : null;
$stockColorDefault = (int) ($colorDefault['stock_cantidad'] ?? 0);
$agotado = $tieneColores ? $stockColorDefault <= 0 : ($producto['stock_estado'] ?? '') === 'agotado';

require_once __DIR__ . '/../includes/sport-images.php';
require_once __DIR__ . '/../includes/size-guide.php';

$guiaTallas = deportivo_guia_tallas($producto['categoria_slug'] ?? 'camisetas');
$productoPrincipal = $producto;
$imagenProductoUrl = Producto::urlImagen($producto['imagen_principal'], true);
$mensajeStock = $tieneColores
    ? Producto::mensajeStockColor($stockColorDefault, $colorDefault['nombre'] ?? '')
    : Producto::mensajeStock($producto['stock_estado']);

$navInViews = true;
$cartBasePath = $assetBase;
$cartUrl = 'carrito_compras.php';

?>
<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= htmlspecialchars($producto['nombre']) ?> | DEPORTIVO</title>
    <?php $pageCss = 'pages/producto.css'; include __DIR__ . '/../includes/design-head.php'; ?>
</head>

<body class="bg-surface dark:bg-on-background text-on-surface dark:text-inverse-on-surface font-body-md antialiased transition-colors duration-300<?= deportivo_admin_body_class() ?>">
    <?php include __DIR__ . '/../includes/site-nav.php'; ?>
    <?php $defaultCategoriaId = (int) $producto['categoria_id']; include dirname(__DIR__, 2) . '/administrador/includes/admin-panel.php'; ?>
    <main class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter-desktop">
            <!-- Thumbnail Gallery (Desktop Left) -->
            <?php if (!empty($producto['imagenes'])): ?>
            <div class="hidden lg:flex lg:col-span-1 flex-col gap-4">
                <?php foreach ($producto['imagenes'] as $index => $imagen): ?>
                <img class="w-full aspect-[3/4] object-cover cursor-pointer hover:opacity-80 transition-opacity <?= $index === 0 ? 'border border-outline-variant' : '' ?>" data-alt="<?= htmlspecialchars($imagen['alt_text'] ?? $producto['nombre']) ?>"
                    src="<?= htmlspecialchars($imagen['url']) ?>"
                    <?= deportivo_admin_gallery_img((int) $imagen['id'], (int) $producto['id']) ?>
                />
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <!-- Main Product Image -->
            <div class="<?= !empty($producto['imagenes']) ? 'lg:col-span-6' : 'lg:col-span-7' ?> relative group overflow-hidden">
                <img class="w-full aspect-[3/4] object-cover transition-transform duration-700 group-hover:scale-105" data-alt="<?= htmlspecialchars($producto['imagen_alt'] ?? $producto['nombre']) ?>"
                    id="main-image" src="<?= htmlspecialchars(Producto::urlImagen($producto['imagen_principal'], true)) ?>"
                    <?= deportivo_admin_product_img((int) $producto['id']) ?>
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
                        <h1 class="font-headline-md text-headline-md text-primary" data-admin-edit="<?= (int) $producto['id'] ?>" data-admin-edit-title><?= htmlspecialchars($producto['nombre']) ?></h1>
                        <button type="button"
                            class="text-on-surface-variant hover:text-secondary transition-colors"
                            data-toggle-favorite
                            data-product-id="<?= (int) $producto['id'] ?>"
                            data-product-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>"
                            data-product-precio="<?= (float) $producto['precio'] ?>"
                            data-product-imagen="<?= htmlspecialchars($imagenProductoUrl, ENT_QUOTES) ?>"
                            data-product-talla="<?= htmlspecialchars($primeraTalla ?? 'M', ENT_QUOTES) ?>"
                            data-product-lavado="<?= htmlspecialchars($producto['lavado'] ?? '', ENT_QUOTES) ?>"
                            data-product-fit="<?= htmlspecialchars($producto['fit'] ?? '', ENT_QUOTES) ?>"
                            data-product-categoria="<?= htmlspecialchars($producto['categoria_nombre'] ?? '', ENT_QUOTES) ?>"
                            data-product-stock="<?= htmlspecialchars($producto['stock_estado'], ENT_QUOTES) ?>"
                            aria-label="Añadir a favoritos"
                            aria-pressed="false">
                            <span class="material-symbols-outlined" data-icon="favorite">favorite</span>
                        </button>
                    </div>
                    <p class="font-headline-sm text-headline-sm text-secondary"><?= Producto::formatearPrecio((float) $producto['precio']) ?></p>
                </header>
                <!-- Stock Indicator -->
                <div class="flex items-center gap-2 text-label-md font-label-md text-secondary" id="stock-message">
                    <span class="w-2 h-2 rounded-full bg-secondary"></span>
                    <span id="stock-message-text"><?= htmlspecialchars($mensajeStock) ?></span>
                </div>
                <div class="flex flex-col gap-6">
                    <div class="flex flex-col gap-4">
                        <div class="flex justify-between items-center">
                            <span class="font-label-md text-label-md uppercase tracking-wider text-primary">Talla</span>
                            <button type="button" class="font-label-sm text-label-sm text-secondary hover:underline" data-size-guide>Guía de tallas</button>
                        </div>
                        <div class="flex flex-wrap gap-3" id="size-selector">
                            <?php foreach ($producto['tallas'] as $talla): ?>
                            <?php $activa = $talla === $primeraTalla; ?>
                            <button type="button" class="px-6 py-3 font-label-md uppercase <?= $activa ? 'border-2 border-secondary bg-surface-container text-secondary font-bold' : 'border border-outline text-on-surface-variant hover:border-secondary transition-all' ?>"><?= htmlspecialchars($talla) ?></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php if ($tieneColores): ?>
                    <?php $context = 'detail'; include __DIR__ . '/../includes/producto-color-selector.php'; ?>
                    <?php endif; ?>
                    <div class="flex flex-col gap-4 mt-4">
                        <button type="button"
                            class="w-full bg-secondary text-on-secondary py-5 font-label-md uppercase tracking-widest hover:opacity-90 transition-all active:scale-[0.98] text-center disabled:opacity-50 disabled:pointer-events-none"
                            data-add-to-cart data-product-talla-from="selector"
                            data-product-id="<?= (int) $producto['id'] ?>"
                            data-product-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>"
                            data-product-precio="<?= (float) $producto['precio'] ?>"
                            data-product-imagen="<?= htmlspecialchars($imagenProductoUrl, ENT_QUOTES) ?>"
                            data-product-talla="<?= htmlspecialchars($primeraTalla ?? 'M', ENT_QUOTES) ?>"
                            data-product-color="<?= htmlspecialchars($colorDefault['nombre'] ?? '', ENT_QUOTES) ?>"
                            data-product-color-slug="<?= htmlspecialchars($colorDefault['slug'] ?? '', ENT_QUOTES) ?>"
                            data-product-color-id="<?= (int) ($colorDefault['id'] ?? 0) ?>"
                            data-product-stock-cantidad="<?= $stockColorDefault ?>"
                            data-product-lavado="<?= htmlspecialchars($producto['lavado'] ?? '', ENT_QUOTES) ?>"
                            data-product-fit="<?= htmlspecialchars($producto['fit'] ?? '', ENT_QUOTES) ?>"
                            data-product-categoria="<?= htmlspecialchars($producto['categoria_nombre'] ?? '', ENT_QUOTES) ?>"
                            data-product-stock="<?= htmlspecialchars($producto['stock_estado'], ENT_QUOTES) ?>"
                            <?= $agotado ? 'disabled' : '' ?>>
                            <?= $agotado ? 'Agotado' : 'Añadir al carrito' ?>
                        </button>
                        <button type="button"
                            class="w-full border border-primary text-primary py-5 font-label-md uppercase tracking-widest hover:bg-surface-container transition-all active:scale-[0.98]"
                            data-toggle-favorite
                            data-favorite-label="1"
                            data-product-id="<?= (int) $producto['id'] ?>"
                            data-product-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>"
                            data-product-precio="<?= (float) $producto['precio'] ?>"
                            data-product-imagen="<?= htmlspecialchars($imagenProductoUrl, ENT_QUOTES) ?>"
                            data-product-talla="<?= htmlspecialchars($primeraTalla ?? 'M', ENT_QUOTES) ?>"
                            data-product-lavado="<?= htmlspecialchars($producto['lavado'] ?? '', ENT_QUOTES) ?>"
                            data-product-fit="<?= htmlspecialchars($producto['fit'] ?? '', ENT_QUOTES) ?>"
                            data-product-categoria="<?= htmlspecialchars($producto['categoria_nombre'] ?? '', ENT_QUOTES) ?>"
                            data-product-stock="<?= htmlspecialchars($producto['stock_estado'], ENT_QUOTES) ?>"
                            aria-pressed="false">
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
                <?php $producto = $productoPrincipal; ?>
            </div>
        </section>
        <?php endif; ?>
    </main>
    <?php include __DIR__ . '/../includes/site-footer.php'; ?>
    <?php include __DIR__ . '/../includes/size-guide-modal.php'; ?>
    <script>
        window.SIZE_GUIDE = <?= json_encode($guiaTallas, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    </script>
    <script src="<?= htmlspecialchars($clienteJsPath) ?>size-guide.js"></script>
    <script>
        const thumbnails = document.querySelectorAll('.lg\\:col-span-1 img[data-alt]');
        const mainImage = document.getElementById('main-image');

        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', (event) => {
                if (thumb.hasAttribute('data-admin-gallery-image')) {
                    return;
                }
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
    <script src="<?= htmlspecialchars($clienteJsPath) ?>catalogo-filters.js"></script>
    <?php $cartBasePath = $assetBase; $cartUrl = 'carrito_compras.php'; $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="<?= htmlspecialchars($assetBase) ?>js/theme/toggle.js"></script>
</body>

</html>
