<?php

$navInViews = $navInViews ?? false;

$homeUrl = $navInViews ? '../index.php' : 'index.php';
$catalogoCamisetas = $navInViews ? 'catalogo.php?categoria=camisetas' : 'views/catalogo.php?categoria=camisetas';
$catalogoPantalonetas = $navInViews ? 'catalogo.php?categoria=pantalonetas' : 'views/catalogo.php?categoria=pantalonetas';
$loginUrl = $navInViews ? 'login.php' : 'views/login.php';
?>
<footer class="w-full bg-surface-container-low dark:bg-tertiary-container border-t border-outline-variant">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter-desktop px-margin-mobile md:px-margin-desktop py-16 max-w-container-max-width mx-auto">
        <div>
            <a class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed mb-6 block hover:opacity-80 transition-opacity no-underline uppercase tracking-widest" href="<?= htmlspecialchars($homeUrl) ?>">DEPORTIVO<span class="text-secondary">.</span></a>
            <p class="font-body-md text-body-md text-on-surface-variant max-w-xs">Ropa deportiva para todos los deportes. Camisetas y pantalonetas que rinden cuando tú rindes.</p>
        </div>
        <div class="grid grid-cols-2 gap-8">
            <div class="flex flex-col gap-3">
                <h4 class="font-label-sm text-label-sm text-primary uppercase tracking-widest">Tienda</h4>
                <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors no-underline" href="<?= htmlspecialchars($catalogoCamisetas) ?>">Camisetas</a>
                <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors no-underline" href="<?= htmlspecialchars($catalogoPantalonetas) ?>">Pantalonetas</a>
                <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors no-underline" href="<?= htmlspecialchars($catalogoCamisetas) ?>">Catálogo</a>
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
            <p class="font-label-sm text-label-sm text-on-surface-variant opacity-50">© 2026 DEPORTIVO</p>
        </div>
    </div>
</footer>
