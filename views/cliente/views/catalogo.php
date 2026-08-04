<?php

$authInViews = true;
require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/models/Producto.php';
require_once __DIR__ . '/../includes/sport-images.php';

$categorias = Producto::listarCategorias();
$categoriaSlugRequest = isset($_GET['categoria']) ? trim((string) $_GET['categoria']) : '';
$esHub = $categoriaSlugRequest === '';
$esTodo = $categoriaSlugRequest === 'todo';

$categoria = null;
$categoriaSlug = '';
$productos = [];
$filtros = [
    'tallas' => [],
    'lavados' => [],
    'fits' => [],
    'colores' => [],
    'precio_min' => 0,
    'precio_max' => 0,
];
$esPantalonetas = false;

$hubItems = [
    [
        'slug' => 'todo',
        'num' => '00',
        'nombre' => 'Ver todo',
        'accent' => 'all',
    ],
    [
        'slug' => 'camisetas',
        'num' => '01',
        'nombre' => 'Camisetas',
        'accent' => 'camisetas',
    ],
    [
        'slug' => 'pantalonetas',
        'num' => '02',
        'nombre' => 'Pantalonetas',
        'accent' => 'pantalonetas',
    ],
    [
        'slug' => 'bermudas',
        'num' => '03',
        'nombre' => 'Bermudas',
        'accent' => 'bermudas',
    ],
    [
        'slug' => 'medias',
        'num' => '04',
        'nombre' => 'Medias',
        'accent' => 'medias',
    ],
    [
        'slug' => 'gorras',
        'num' => '05',
        'nombre' => 'Gorras',
        'accent' => 'gorras',
    ],
];

if (!$esHub) {
    if ($esTodo) {
        $categoriaSlug = 'todo';
        $tituloPagina = 'Ver todo';
        $categoriaNombreUi = 'Ver todo';
        $productos = Producto::listarPorCategoria(null);
    } else {
        $categoria = Producto::obtenerCategoriaPorSlug($categoriaSlugRequest);
        if ($categoria) {
            $categoriaSlug = (string) $categoria['slug'];
            $tituloPagina = (string) $categoria['nombre'];
            $categoriaNombreUi = (string) $categoria['nombre'];
            $productos = Producto::listarPorCategoria($categoriaSlug);
        } else {
            $categoriaSlug = $categoriaSlugRequest;
            $tituloPagina = ucfirst(str_replace('-', ' ', $categoriaSlugRequest));
            $categoriaNombreUi = $tituloPagina;
            $productos = [];
        }
    }

    $filtros = Producto::extraerFiltros($productos);
    $esPantalonetas = in_array($categoriaSlug, ['pantalonetas', 'pantalonetas-pro'], true);
} else {
    $tituloPagina = 'Catálogo';
}

$navInViews = true;
$activePage = 'catalogo';
$cartBasePath = $assetBase;
$cartUrl = 'carrito_compras.php';
$catalogoHubUrl = 'catalogo.php';

?>
<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= htmlspecialchars($tituloPagina) ?> | VEMA</title>
    <?php $pageCss = 'pages/catalogo.css'; include __DIR__ . '/../includes/design-head.php'; ?>
</head>

<body class="bg-background dark:bg-on-background text-on-surface dark:text-inverse-on-surface font-body-md selection:bg-secondary-container selection:text-on-secondary-container transition-colors duration-300<?= deportivo_admin_body_class() ?>">
    <?php include __DIR__ . '/../includes/site-nav.php'; ?>
    <?php $defaultCategoriaId = (int) ($categoria['id'] ?? 0); include dirname(__DIR__, 2) . '/administrador/includes/admin-panel.php'; ?>

    <?php if ($esHub): ?>
    <main class="catalog-hub">
        <header class="catalog-hub-intro editorial-reveal">
            <h1 class="catalog-hub-title font-display-lg uppercase">Elige tu categoría. </h1>

        </header>

        <section class="catalog-hub-grid" aria-label="Categorías del catálogo">
            <?php foreach ($hubItems as $i => $item): ?>
            <a
                href="catalogo.php?categoria=<?= urlencode($item['slug']) ?>"
                class="catalog-hub-card catalog-hub-card--<?= htmlspecialchars($item['accent']) ?> editorial-reveal"
                style="--hub-i: <?= $i ?>"
            >
                <span class="catalog-hub-card-num" aria-hidden="true"><?= htmlspecialchars($item['num']) ?></span>
                <span class="catalog-hub-card-name font-headline-sm uppercase"><?= htmlspecialchars($item['nombre']) ?></span>
                <span class="catalog-hub-card-go material-symbols-outlined" aria-hidden="true">arrow_forward</span>
            </a>
            <?php endforeach; ?>
        </section>
    </main>
    <?php else: ?>
    <main class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-6 md:py-12 reveal">
        <div class="catalog-products-head mb-6 md:mb-8">
            <a href="<?= htmlspecialchars($catalogoHubUrl) ?>" class="catalog-back font-label-sm text-label-sm uppercase tracking-[0.2em] no-underline inline-flex items-center gap-2">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Volver al catálogo
            </a>
            <h1 class="sr-only"><?= htmlspecialchars($tituloPagina) ?></h1>
        </div>

        <div class="catalog-layout">
            <aside class="catalog-side-filters" data-side-filters>
                <button
                    type="button"
                    class="catalog-side-toggle"
                    data-filter-toggle
                    aria-expanded="false"
                    aria-controls="catalog-side-panel"
                >
                    <span class="catalog-side-toggle-left">
                        <span class="material-symbols-outlined" aria-hidden="true">tune</span>
                        Filtrar
                    </span>
                    <span class="material-symbols-outlined catalog-side-chevron" aria-hidden="true">expand_more</span>
                </button>

                <div class="catalog-side-panel" id="catalog-side-panel" data-side-panel hidden>
                    <div class="catalog-side-section">
                        <p class="catalog-side-label">Precio</p>
                        <div class="catalog-filter-price">
                            <label class="catalog-filter-field">
                                <span>Desde</span>
                                <input type="number" inputmode="numeric" min="0" step="1000"
                                       data-filter-precio-min
                                       value="<?= (int) ($filtros['precio_min'] ?? 0) ?>"
                                       placeholder="<?= (int) ($filtros['precio_min'] ?? 0) ?>" />
                            </label>
                            <label class="catalog-filter-field">
                                <span>Hasta</span>
                                <input type="number" inputmode="numeric" min="0" step="1000"
                                       data-filter-precio-max
                                       value="<?= (int) ($filtros['precio_max'] ?? 0) ?>"
                                       placeholder="<?= (int) ($filtros['precio_max'] ?? 0) ?>" />
                            </label>
                        </div>
                    </div>

                    <div class="catalog-side-section">
                        <p class="catalog-side-label">Talla</p>
                        <?php if (!empty($filtros['tallas'])): ?>
                        <div class="catalog-filter-chips" id="filter-tallas">
                            <?php foreach ($filtros['tallas'] as $talla): ?>
                            <button type="button" data-filter-talla="<?= htmlspecialchars($talla) ?>" class="catalog-filter-chip"><?= htmlspecialchars($talla) ?></button>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <p class="catalog-filter-empty">Sin tallas en esta categoría.</p>
                        <?php endif; ?>
                    </div>

                    <div class="catalog-side-section">
                        <p class="catalog-side-label">Color</p>
                        <?php if (!empty($filtros['colores'])): ?>
                        <ul class="catalog-filter-checks">
                            <?php foreach ($filtros['colores'] as $color): ?>
                            <li>
                                <label class="catalog-filter-check">
                                    <input type="checkbox" data-filter-color value="<?= htmlspecialchars($color, ENT_QUOTES) ?>" />
                                    <span><?= htmlspecialchars($color) ?></span>
                                </label>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php else: ?>
                        <p class="catalog-filter-empty">Sin colores disponibles.</p>
                        <?php endif; ?>
                    </div>

                    <div class="catalog-side-section">
                        <p class="catalog-side-label">Marca</p>
                        <p class="catalog-filter-empty">Filtro de marca próximamente.</p>
                        <ul class="catalog-filter-checks catalog-filter-checks--disabled" aria-disabled="true">
                            <li><label class="catalog-filter-check"><input type="checkbox" disabled /><span>Nike</span></label></li>
                            <li><label class="catalog-filter-check"><input type="checkbox" disabled /><span>Adidas</span></label></li>
                            <li><label class="catalog-filter-check"><input type="checkbox" disabled /><span>Under Armour</span></label></li>
                            <li><label class="catalog-filter-check"><input type="checkbox" disabled /><span>ON</span></label></li>
                        </ul>
                    </div>

                    <button type="button" class="catalog-side-reset" id="reset-filters">Limpiar filtros</button>
                </div>
            </aside>

            <section class="catalog-products-wrap">
                <div class="catalog-products-grid" id="catalog-grid">
                    <?php if (empty($productos)): ?>
                    <p class="col-span-full font-body-md text-body-md text-on-surface-variant">
                        <?php if ($categoria === null && !$esTodo): ?>
                            Pronto llegarán productos a <strong><?= htmlspecialchars($tituloPagina) ?></strong>. Mientras tanto, explora otras categorías desde el <a href="<?= htmlspecialchars($catalogoHubUrl) ?>" class="underline hover:text-secondary">catálogo</a>.
                        <?php else: ?>
                            No hay productos disponibles en esta categoría.
                        <?php endif; ?>
                    </p>
                    <?php else: ?>
                    <?php foreach ($productos as $producto): ?>
                    <?php include __DIR__ . '/../includes/producto-card.php'; ?>
                    <?php endforeach; ?>
                    <p id="catalog-empty-filters" class="col-span-full font-body-md text-body-md text-on-surface-variant hidden">Ningún producto coincide con los filtros seleccionados.</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </main>
    <?php endif; ?>

    <?php include __DIR__ . '/../includes/site-footer.php'; ?>
    <script>
        document.querySelectorAll('.editorial-reveal, .reveal').forEach((el) => {
            new IntersectionObserver(([e]) => {
                if (e.isIntersecting) e.target.classList.add('visible');
            }, { threshold: 0.1 }).observe(el);
        });
    </script>
    <?php if (!$esHub): ?>
    <script src="<?= htmlspecialchars($clienteJsPath) ?>catalogo-filters.js"></script>
    <?php endif; ?>
    <?php $cartBasePath = $assetBase; $cartUrl = 'carrito_compras.php'; $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="<?= htmlspecialchars($assetBase) ?>js/theme/toggle.js"></script>
</body>

</html>
