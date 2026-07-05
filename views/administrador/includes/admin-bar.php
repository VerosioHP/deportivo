<?php

if (empty($esAdmin)) {
    return;
}

if (!defined('MAJESTIC_AUTH_LOADED')) {
    require_once dirname(__DIR__, 3) . '/includes/auth.php';
}
?>
<link rel="stylesheet" href="<?= htmlspecialchars($adminCssPath) ?>admin-edit.css">
<div class="w-full bg-primary text-on-primary border-b border-secondary/30 z-40 relative">
    <div class="max-w-container-max-width mx-auto px-margin-desktop py-3 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="flex items-center gap-2 font-label-sm text-label-sm uppercase tracking-widest">
            <span class="material-symbols-outlined text-base">admin_panel_settings</span>
            Modo administrador — clic en imágenes o productos para editar
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= htmlspecialchars(deportivo_admin_url('categorias.php')) ?>" class="inline-flex items-center gap-2 px-4 py-2 border border-on-primary/30 text-on-primary font-label-sm uppercase tracking-widest hover:bg-on-primary/10 transition-colors no-underline">
                <span class="material-symbols-outlined text-base">category</span>
                Categorías
            </a>
            <a href="<?= htmlspecialchars(deportivo_admin_url('pedidos.php')) ?>" class="inline-flex items-center gap-2 px-4 py-2 border border-on-primary/30 text-on-primary font-label-sm uppercase tracking-widest hover:bg-on-primary/10 transition-colors no-underline">
                <span class="material-symbols-outlined text-base">receipt_long</span>
                Pedidos
            </a>
            <button type="button" id="admin-new-product" class="px-4 py-2 bg-secondary text-on-secondary font-label-sm uppercase tracking-widest hover:opacity-90 transition-opacity">
                Nuevo producto
            </button>
        </div>
    </div>
</div>
