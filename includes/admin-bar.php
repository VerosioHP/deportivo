<?php

if (empty($esAdmin)) {
    return;
}
?>
<div class="w-full bg-primary text-on-primary border-b border-secondary/30 z-40 relative">
    <div class="max-w-container-max-width mx-auto px-margin-desktop py-3 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="flex items-center gap-2 font-label-sm text-label-sm uppercase tracking-widest">
            <span class="material-symbols-outlined text-base">admin_panel_settings</span>
            Modo administrador — los cambios se reflejan para todos los clientes
        </div>
        <div class="flex items-center gap-3">
            <button type="button" id="admin-new-product" class="px-4 py-2 bg-secondary text-on-secondary font-label-sm uppercase tracking-widest hover:opacity-90 transition-opacity">
                Nuevo producto
            </button>
        </div>
    </div>
</div>
