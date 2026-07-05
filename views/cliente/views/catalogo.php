<?php

$authInViews = true;
require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/models/Producto.php';

$categorias = Producto::listarCategorias();
$categoriaSlug = $_GET['categoria'] ?? ($categorias[0]['slug'] ?? '');
$categoria = $categoriaSlug !== '' ? Producto::obtenerCategoriaPorSlug($categoriaSlug) : null;

if (!$categoria && !empty($categorias)) {
    $categoriaSlug = $categorias[0]['slug'];
    $categoria = Producto::obtenerCategoriaPorSlug($categoriaSlug);
}

$productos = $categoria ? Producto::listarPorCategoria($categoriaSlug) : [];
$filtros = Producto::extraerFiltros($productos);
$esPantalonetas = in_array($categoriaSlug, ['pantalonetas', 'pantalonetas-pro'], true);

$tituloPagina = $categoria['nombre'] ?? 'Catálogo';

$bannerKey = match (true) {
    $categoriaSlug === 'camisetas' => 'catalogo_camisetas',
    in_array($categoriaSlug, ['pantalonetas', 'jeans', 'pantalonetas-pro'], true) => 'catalogo_pantalonetas',
    default => 'hero_main',
};

require_once __DIR__ . '/../includes/sport-images.php';

$navInViews = true;
$activePage = 'catalogo';
$categoriaSlug = $categoria['slug'] ?? '';
$cartBasePath = $assetBase;
$cartUrl = 'carrito_compras.php';

?>
<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= htmlspecialchars($tituloPagina) ?> | DEPORTIVO</title>
    <?php $pageCss = 'pages/catalogo.css'; include __DIR__ . '/../includes/design-head.php'; ?>
</head>

<body class="bg-background dark:bg-on-background text-on-surface dark:text-inverse-on-surface font-body-md selection:bg-secondary-container selection:text-on-secondary-container transition-colors duration-300<?= deportivo_admin_body_class() ?>">
    <?php include __DIR__ . '/../includes/site-nav.php'; ?>
    <?php $defaultCategoriaId = (int) ($categoria['id'] ?? 0); include dirname(__DIR__, 2) . '/administrador/includes/admin-panel.php'; ?>

    <section class="page-hero">
        <img src="<?= deportivo_img_ctx($bannerKey, 'xl') ?>" alt="<?= htmlspecialchars($tituloPagina) ?> deportivas"<?= deportivo_admin_site_img($bannerKey) ?> />
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="page-hero-content text-white max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop">
            <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.25em] block mb-3">Catálogo</span>
            <h1 class="font-display-lg text-display-lg md:text-display-lg uppercase leading-none mb-4"><?= htmlspecialchars($tituloPagina) ?></h1>
            <p class="font-body-lg text-body-lg text-white/80 max-w-xl"><?= htmlspecialchars($categoria['descripcion'] ?? '') ?></p>
        </div>
    </section>

    <main class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-12 md:py-20 reveal">
        <div class="editorial-grid gap-gutter-desktop">
            <!-- Sidebar Filters -->
            <aside class="col-span-12 md:col-span-3 space-y-12 mb-12 md:mb-0" id="catalog-filters">
                <?php if (!empty($filtros['tallas'])): ?>
                <div class="space-y-6">
                    <h3 class="font-label-sm text-label-sm uppercase text-on-surface-variant tracking-widest">Talla</h3>
                    <div class="flex flex-wrap gap-2" id="filter-tallas">
                        <?php foreach ($filtros['tallas'] as $talla): ?>
                        <button type="button" data-filter-talla="<?= htmlspecialchars($talla) ?>" class="w-10 h-10 flex items-center justify-center border border-outline-variant font-label-md text-label-md hover:border-secondary transition-colors"><?= htmlspecialchars($talla) ?></button>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($esPantalonetas && !empty($filtros['lavados'])): ?>
                <div class="space-y-6">
                    <h3 class="font-label-sm text-label-sm uppercase text-on-surface-variant tracking-widest">Color</h3>
                    <ul class="space-y-3 font-body-md text-body-md">
                        <?php foreach ($filtros['lavados'] as $lavado): ?>
                        <li>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="sr-only" data-filter-lavado value="<?= htmlspecialchars($lavado, ENT_QUOTES) ?>" />
                                <div data-filter-indicator class="w-4 h-4 border border-outline-variant group-hover:border-secondary"></div>
                                <?= htmlspecialchars(Producto::traducirLavado($lavado)) ?>
                            </label>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                <?php if ($esPantalonetas && !empty($filtros['fits'])): ?>
                <div class="space-y-6">
                    <h3 class="font-label-sm text-label-sm uppercase text-on-surface-variant tracking-widest">Corte</h3>
                    <ul class="space-y-3 font-body-md text-body-md">
                        <?php foreach ($filtros['fits'] as $fit): ?>
                        <li>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="sr-only" data-filter-fit value="<?= htmlspecialchars($fit, ENT_QUOTES) ?>" />
                                <div data-filter-indicator class="w-4 h-4 border border-outline-variant group-hover:border-secondary"></div>
                                <?= htmlspecialchars(Producto::traducirFit($fit)) ?>
                            </label>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                <button type="button" id="reset-filters" class="w-full py-4 bg-secondary text-on-secondary font-label-md text-label-md uppercase tracking-widest hover:opacity-90 transition-all">
                    Restablecer filtros
                </button>
            </aside>
            <!-- Product Grid -->
            <section class="col-span-12 md:col-span-9">
                <div class="catalog-category-bar flex justify-end mb-8 md:mb-10">
                    <div class="catalog-category-dropdown" data-category-dropdown>
                        <span class="font-label-sm text-label-sm uppercase text-on-surface-variant tracking-widest sr-only">Categoría</span>
                        <button type="button"
                                class="catalog-category-trigger"
                                data-category-trigger
                                aria-haspopup="listbox"
                                aria-expanded="false"
                                aria-controls="catalog-category-menu">
                            <span><?= htmlspecialchars($categoria['nombre']) ?></span>
                            <span class="material-symbols-outlined catalog-category-chevron" aria-hidden="true">expand_more</span>
                        </button>
                        <ul class="catalog-category-menu"
                            id="catalog-category-menu"
                            role="listbox"
                            aria-label="Categorías"
                            hidden>
                            <?php foreach ($categorias as $cat): ?>
                            <?php $esActiva = $cat['slug'] === $categoriaSlug; ?>
                            <li role="option" <?= $esActiva ? 'aria-selected="true"' : 'aria-selected="false"' ?>>
                                <?php if ($esActiva): ?>
                                <span class="catalog-category-option is-active"><?= htmlspecialchars($cat['nombre']) ?></span>
                                <?php else: ?>
                                <a href="catalogo.php?categoria=<?= urlencode($cat['slug']) ?>"
                                   class="catalog-category-option">
                                    <?= htmlspecialchars($cat['nombre']) ?>
                                </a>
                                <?php endif; ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-16 gap-x-gutter-desktop" id="catalog-grid">
                    <?php if (empty($productos)): ?>
                    <p class="col-span-full font-body-md text-body-md text-on-surface-variant">No hay productos disponibles en esta categoría.</p>
                    <?php else: ?>
                    <?php foreach ($productos as $producto): ?>
                    <?php include __DIR__ . '/../includes/producto-card.php'; ?>
                    <?php endforeach; ?>
                    <p id="catalog-empty-filters" class="col-span-full font-body-md text-body-md text-on-surface-variant hidden">Ningún producto coincide con los filtros seleccionados.</p>
                    <?php endif; ?>
                </div>
                <!-- Paginación -->
                <div class="mt-20 flex items-center justify-center space-x-4 border-t border-outline-variant pt-12">
                    <span class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant">Página</span>
                    <span class="font-label-md text-label-md px-4 py-2 bg-secondary-container text-on-secondary-container">01</span>
                </div>
            </section>
        </div>
    </main>
    <?php include __DIR__ . '/../includes/site-footer.php'; ?>
    <script>
        document.querySelectorAll('.reveal').forEach(el => {
            new IntersectionObserver(([e]) => { if (e.isIntersecting) e.target.classList.add('visible'); }, { threshold: 0.1 }).observe(el);
        });
    </script>
    <script src="<?= htmlspecialchars($clienteJsPath) ?>catalogo-filters.js"></script>
    <?php $cartBasePath = $assetBase; $cartUrl = 'carrito_compras.php'; $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="<?= htmlspecialchars($assetBase) ?>js/theme/toggle.js"></script>
</body>

</html>