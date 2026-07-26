<?php

if (!defined('MAJESTIC_AUTH_LOADED')) {
    require_once dirname(__DIR__, 3) . '/includes/auth.php';
}

$homeUrl = $clienteHomeUrl ?? deportivo_cliente_url('../index.php');
$catalogoCamisetas = deportivo_cliente_url('catalogo.php?categoria=camisetas');
$favoritosUrl = deportivo_cliente_url('favoritos.php');
$loginUrl = deportivo_cliente_url('login.php');
?>
<footer class="w-full bg-surface-container-low dark:bg-tertiary-container border-t border-outline-variant">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter-desktop px-margin-mobile md:px-margin-desktop py-16 max-w-container-max-width mx-auto">
        <div>
            <?php include __DIR__ . '/brand-logo.php'; ?>
            <p class="font-body-md text-body-md text-on-surface-variant max-w-xs mt-6">Camisetas deportivas técnicas para entrenar y competir. Calidad Dry-Fit, tallas y colores con stock real.</p>
        </div>
        <div class="grid grid-cols-2 gap-8">
            <div class="flex flex-col gap-3">
                <h4 class="font-label-sm text-label-sm text-primary uppercase tracking-widest">Tienda</h4>
                <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors no-underline" href="<?= htmlspecialchars($catalogoCamisetas) ?>">Camisetas</a>
                <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors no-underline" href="<?= htmlspecialchars($catalogoCamisetas) ?>">Catálogo</a>
                <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors no-underline" href="<?= htmlspecialchars($favoritosUrl) ?>">Favoritos</a>
            </div>
            <div class="flex flex-col gap-3">
                <h4 class="font-label-sm text-label-sm text-primary uppercase tracking-widest">Ayuda</h4>
                <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors no-underline" href="<?= htmlspecialchars($catalogoCamisetas) ?>">Envíos</a>
                <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors no-underline" href="<?= htmlspecialchars($loginUrl) ?>">Contacto</a>
                <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors no-underline" href="<?= htmlspecialchars($loginUrl) ?>">Guía de tallas</a>
            </div>
        </div>
        <div class="flex flex-col justify-between items-start md:items-end gap-6">
            <div class="flex gap-5 text-on-surface-variant">
                <a class="hover:text-secondary transition-colors" href="#"><span class="material-symbols-outlined">share</span></a>
                <a class="hover:text-secondary transition-colors" href="#"><span class="material-symbols-outlined">sports_martial_arts</span></a>
                <a class="hover:text-secondary transition-colors" href="#"><span class="material-symbols-outlined">mail</span></a>
            </div>
            <p class="font-label-sm text-label-sm text-on-surface-variant opacity-50">© 2026 VEMA</p>
        </div>
    </div>
</footer>
