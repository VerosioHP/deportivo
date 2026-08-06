<?php

if (!defined('MAJESTIC_AUTH_LOADED')) {
    require_once dirname(__DIR__, 3) . '/includes/auth.php';
}

$navBasePath = $navBasePath ?? $assetBase ?? '';
$navInViews = $navInViews ?? $in_cliente_views ?? false;
$activePage = $activePage ?? '';
$categoriaSlug = $categoriaSlug ?? '';
$cartBasePath = $cartBasePath ?? $navBasePath;
$cartUrl = $cartUrl ?? deportivo_cliente_url('carrito_compras.php');

$homeUrl = $clienteHomeUrl ?? deportivo_cliente_url('../index.php');
$catalogoUrl = deportivo_cliente_url('catalogo.php');
$nosotrosUrl = deportivo_cliente_url('nosotros.php');

$navClass = static function (string $page) use ($activePage): string {
    $base = 'font-label-md text-label-md uppercase tracking-widest transition-colors duration-300';
    $active = 'text-secondary border-b-2 border-secondary pb-1';
    $idle = 'text-on-surface-variant hover:text-secondary';

    if ($page === 'nosotros' && $activePage === 'nosotros') {
        return "$base $active";
    }
    if ($page === 'catalogo' && $activePage === 'catalogo') {
        return "$base $active";
    }
    return "$base $idle";
};
?>
<nav class="site-nav w-full top-0 sticky bg-surface/95 dark:bg-on-background/95 backdrop-blur-md border-b border-outline-variant dark:border-outline z-50">
    <div class="site-nav-inner flex justify-between items-center px-margin-mobile md:px-margin-desktop max-w-container-max-width mx-auto">
        <?php include __DIR__ . '/brand-logo.php'; ?>
        <div class="hidden md:flex gap-8">
            <a class="<?= $navClass('catalogo') ?>" href="<?= htmlspecialchars($catalogoUrl) ?>">Catálogo</a>
            <a class="<?= $navClass('nosotros') ?>" href="<?= htmlspecialchars($nosotrosUrl) ?>">Nosotros</a>
        </div>
        <div class="site-nav-actions flex items-center gap-4 text-primary dark:text-primary-fixed">
            <?php if (empty($esAdmin)) : ?>
            <button type="button" class="transition-opacity active:opacity-70 hidden sm:block"><span class="material-symbols-outlined">search</span></button>
            <?php include __DIR__ . '/favorites-widget.php'; ?>
            <?php $cartPart = 'button'; include __DIR__ . '/cart-widget.php'; ?>
            <?php endif; ?>
            <?php include __DIR__ . '/user-nav.php'; ?>
            <button type="button" data-theme-toggle class="theme-toggle transition-opacity active:opacity-70 text-primary dark:text-primary-fixed" aria-label="Activar modo oscuro" aria-pressed="false">
                <span class="material-symbols-outlined theme-toggle-icon">dark_mode</span>
            </button>
        </div>
    </div>
</nav>
<?php include __DIR__ . '/welcome-toast.php'; ?>
