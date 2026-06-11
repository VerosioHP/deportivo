<?php

require_once __DIR__ . '/../models/Producto.php';

$categoriaSlug = $_GET['categoria'] ?? 'jeans';
$categoria = Producto::obtenerCategoriaPorSlug($categoriaSlug);

if (!$categoria) {
    $categoriaSlug = 'jeans';
    $categoria = Producto::obtenerCategoriaPorSlug($categoriaSlug);
}

$productos = Producto::listarPorCategoria($categoriaSlug);
$filtros = Producto::extraerFiltros($productos);
$esJeans = $categoriaSlug === 'jeans';

$titulosCategoria = [
    'jeans' => 'Jeans',
    'camisetas' => 'Camisetas',
    'chaquetas' => 'Chaquetas',
];

$tituloPagina = $titulosCategoria[$categoriaSlug] ?? 'Catálogo';

?>
<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= htmlspecialchars($tituloPagina) ?> | DENIM EDITORIAL</title>
    <script src="../js/theme-init.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&amp;family=Playfair+Display:wght@500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../css/catalogo.css">
    <link rel="stylesheet" href="../css/theme.css">
    <script src="../js/catalogo.js"></script>
</head>

<body class="bg-background dark:bg-on-background text-on-surface dark:text-inverse-on-surface font-body-md selection:bg-secondary-container selection:text-on-secondary-container transition-colors duration-300">
    <!-- TopNavBar -->
    <header class="w-full top-0 sticky bg-surface dark:bg-on-background border-b border-outline-variant dark:border-outline z-50 transition-opacity duration-200 active:opacity-70">
        <nav class="flex justify-between items-center px-margin-desktop py-4 max-w-container-max-width mx-auto">
            <a class="font-headline-md text-headline-md font-semibold text-primary dark:text-primary-fixed no-underline hover:opacity-80 transition-opacity" href="../index.php">DENIM EDITORIAL</a>

            <div class="hidden md:flex items-center space-x-8">
                <a class="font-label-md text-label-md uppercase tracking-widest <?= $categoriaSlug === 'jeans' ? 'text-secondary dark:text-secondary-fixed-dim border-b-2 border-secondary pb-1' : 'text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed' ?> transition-colors duration-300" href="catalogo.php?categoria=jeans">Catálogo</a>

                <a class="font-label-md text-label-md uppercase tracking-widest <?= $categoriaSlug === 'camisetas' ? 'text-secondary dark:text-secondary-fixed-dim border-b-2 border-secondary pb-1' : 'text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed' ?> transition-colors duration-300" href="catalogo.php?categoria=camisetas">Camisetas</a>

                <a class="font-label-md text-label-md uppercase tracking-widest <?= $categoriaSlug === 'chaquetas' ? 'text-secondary dark:text-secondary-fixed-dim border-b-2 border-secondary pb-1' : 'text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed' ?> transition-colors duration-300" href="catalogo.php?categoria=chaquetas">Chaquetas</a>

                <a class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant dark:text-surface-variant hover:text-secondary dark:hover:text-secondary-fixed transition-colors duration-300" href="nosotros.php">Nosotros</a>

            </div>
            <div class="flex items-center space-x-6 text-primary dark:text-primary-fixed">
                <button type="button" class="material-symbols-outlined hover:text-secondary transition-colors" data-icon="search">search</button>
                <?php $cartBasePath = '../'; $cartUrl = 'carrito_compras.php'; $cartPart = 'button'; include __DIR__ . '/../includes/cart-widget.php'; ?>
                <a class="material-symbols-outlined hover:text-secondary transition-colors text-current no-underline" href="login.php" data-icon="person" aria-label="Cuenta">person</a>
                <button type="button" data-theme-toggle class="theme-toggle transition-opacity duration-200 active:opacity-70 text-primary dark:text-primary-fixed" aria-label="Activar modo oscuro" aria-pressed="false">
                    <span class="material-symbols-outlined theme-toggle-icon">dark_mode</span>
                </button>
            </div>
        </nav>
    </header>
    <main class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-12 md:py-20">
        <!-- Editorial Header -->
        <header class="mb-16 md:mb-24">
            <h1 class="font-display-lg text-display-lg md:text-display-lg mb-4 text-primary dark:text-primary-fixed"><?= htmlspecialchars($tituloPagina) ?></h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl leading-relaxed">
                <?= htmlspecialchars($categoria['descripcion']) ?>
            </p>
        </header>
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
                <?php if ($esJeans && !empty($filtros['lavados'])): ?>
                <div class="space-y-6">
                    <h3 class="font-label-sm text-label-sm uppercase text-on-surface-variant tracking-widest">Lavado</h3>
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
                <?php if ($esJeans && !empty($filtros['fits'])): ?>
                <div class="space-y-6">
                    <h3 class="font-label-sm text-label-sm uppercase text-on-surface-variant tracking-widest">Silueta</h3>
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
                <button type="button" id="reset-filters" class="w-full py-4 bg-primary text-on-primary font-label-md text-label-md uppercase tracking-widest hover:bg-opacity-90 transition-all">
                    Restablecer filtros
                </button>
            </aside>
            <!-- Product Grid -->
            <section class="col-span-12 md:col-span-9">
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
    <!-- Footer -->
    <footer class="w-full mt-20 bg-surface-container-low dark:bg-tertiary-container border-t border-outline-variant transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter-desktop px-margin-desktop py-16 max-w-container-max-width mx-auto">
            <div class="space-y-6">
                <div class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed mb-6"><a class="text-current no-underline hover:opacity-80 transition-opacity" href="../index.php">DENIM EDITORIAL</a></div>
                <p class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container max-w-xs">
                    Curaduría de siluetas atemporales y denim premium para quienes valoran la calidad y el diseño impecable.
                </p>
            </div>
            <div class="flex flex-col space-y-4">
                <h4 class="font-label-sm text-label-sm uppercase tracking-widest text-primary dark:text-primary-fixed">Atención al cliente</h4>
                <div class="flex flex-col space-y-2">
                    <a class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors" href="catalogo.php">Envíos</a>
                    <a class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors" href="login.php">Contacto</a>
                    <a class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors" href="login.php">Privacidad</a>
                    <a class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container hover:text-secondary dark:hover:text-secondary-fixed transition-colors" href="login.php">Términos</a>
                </div>
            </div>
            <div class="space-y-6">
                <h4 class="font-label-sm text-label-sm uppercase tracking-widest text-primary dark:text-primary-fixed">Newsletter</h4>
                <p class="font-body-md text-body-md text-on-surface-variant dark:text-on-tertiary-container">Únete a nuestro círculo exclusivo para lanzamientos editoriales.</p>
                <div class="flex border-b border-outline-variant pb-2">
                    <input class="bg-transparent border-none outline-none flex-grow font-body-md text-body-md py-1" placeholder="Tu correo electrónico" type="email" />
                    <button class="material-symbols-outlined text-primary" data-icon="arrow_forward">arrow_forward</button>
                </div>
            </div>
        </div>
        <div class="px-margin-desktop py-8 border-t border-outline-variant max-w-container-max-width mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <span class="font-label-md text-label-md text-on-surface-variant">© 2024 DENIM EDITORIAL. TODOS LOS DERECHOS RESERVADOS.</span>
            <div class="flex space-x-6 text-on-surface-variant">
                <span class="material-symbols-outlined hover:text-primary cursor-pointer" data-icon="share">share</span>
                <span class="material-symbols-outlined hover:text-primary cursor-pointer" data-icon="language">language</span>
            </div>
        </div>
    </footer>
    <script src="../js/catalogo-filters.js"></script>
    <?php $cartBasePath = '../'; $cartUrl = 'carrito_compras.php'; $cartPart = 'modal'; include __DIR__ . '/../includes/cart-widget.php'; ?>
    <script src="../js/theme.js"></script>
</body>

</html>