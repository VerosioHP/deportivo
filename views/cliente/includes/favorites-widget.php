<?php

$favoritesUrl = deportivo_cliente_url('favoritos.php');
$productUrlPrefix = deportivo_cliente_url('producto.php?id=');
?>
<script>
    window.FAVORITES_CONFIG = window.FAVORITES_CONFIG || {
        favoritesUrl: <?= json_encode($favoritesUrl, JSON_UNESCAPED_SLASHES) ?>,
        productUrlPrefix: <?= json_encode($productUrlPrefix, JSON_UNESCAPED_SLASHES) ?>
    };
</script>
<a href="<?= htmlspecialchars($favoritesUrl) ?>" class="relative transition-opacity duration-200 active:opacity-70 text-primary dark:text-primary-fixed no-underline" aria-label="Ver favoritos">
    <span class="material-symbols-outlined">favorite</span>
    <span data-favorites-count class="absolute -top-1 -right-2 text-[10px] bg-secondary text-on-secondary rounded-full min-w-4 h-4 px-1 flex items-center justify-center hidden">0</span>
</a>
<script src="<?= htmlspecialchars($clienteJsPath ?? ($assetBase ?? '') . 'views/cliente/js/') ?>favorites.js"></script>
