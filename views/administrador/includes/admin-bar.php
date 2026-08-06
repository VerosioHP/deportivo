<?php

if (empty($esAdmin)) {
    return;
}

if (!defined('MAJESTIC_AUTH_LOADED')) {
    require_once dirname(__DIR__, 3) . '/includes/auth.php';
}
?>
<link rel="stylesheet" href="<?= htmlspecialchars($adminCssPath) ?>admin-edit.css">

<div class="admin-mode-hint" role="status">
    <span class="material-symbols-outlined" aria-hidden="true">admin_panel_settings</span>
    <span>Modo administrador</span>
</div>

<div class="admin-dock" data-admin-dock>
    <button type="button" class="admin-dock-fab" data-admin-dock-toggle aria-expanded="false" aria-controls="admin-dock-panel" aria-label="Abrir menú de administración">
        <span class="material-symbols-outlined admin-dock-fab-icon" aria-hidden="true">dashboard_customize</span>
        <span class="admin-dock-fab-label">Admin</span>
    </button>

    <div class="admin-dock-panel" id="admin-dock-panel" data-admin-dock-panel hidden>
        <header class="admin-dock-head">
            <div>
                <p class="admin-dock-kicker">Panel</p>
                <h2 class="admin-dock-title">Administración</h2>
            </div>
            <button type="button" class="admin-dock-close" data-admin-dock-close aria-label="Cerrar menú">
                <span class="material-symbols-outlined">close</span>
            </button>
        </header>

        <nav class="admin-dock-grid" aria-label="Acciones de administración">
            <a href="<?= htmlspecialchars(deportivo_admin_url('categorias.php')) ?>" class="admin-dock-card">
                <span class="material-symbols-outlined admin-dock-card-icon" aria-hidden="true">category</span>
                <span class="admin-dock-card-text">
                    <strong>Categorías</strong>
                    <span>Organiza secciones del catálogo</span>
                </span>
            </a>

            <a href="<?= htmlspecialchars(deportivo_admin_url('pedidos.php')) ?>" class="admin-dock-card">
                <span class="material-symbols-outlined admin-dock-card-icon" aria-hidden="true">receipt_long</span>
                <span class="admin-dock-card-text">
                    <strong>Pedidos</strong>
                    <span>Revisa y actualiza órdenes</span>
                </span>
            </a>

            <a href="<?= htmlspecialchars(deportivo_admin_url('usuarios.php')) ?>" class="admin-dock-card">
                <span class="material-symbols-outlined admin-dock-card-icon" aria-hidden="true">group</span>
                <span class="admin-dock-card-text">
                    <strong>Usuarios</strong>
                    <span>Gestiona cuentas y roles</span>
                </span>
            </a>

            <button type="button" id="admin-new-product" class="admin-dock-card admin-dock-card--accent" data-admin-dock-close>
                <span class="material-symbols-outlined admin-dock-card-icon" aria-hidden="true">add_box</span>
                <span class="admin-dock-card-text">
                    <strong>Nuevo producto</strong>
                    <span>Crea una prenda al instante</span>
                </span>
            </button>
        </nav>
    </div>
</div>

<script>
(() => {
    const root = document.querySelector('[data-admin-dock]');
    if (!root) return;
    const toggle = root.querySelector('[data-admin-dock-toggle]');
    const panel = root.querySelector('[data-admin-dock-panel]');
    const closers = root.querySelectorAll('[data-admin-dock-close]');
    if (!toggle || !panel) return;

    const open = () => {
        panel.hidden = false;
        root.classList.add('is-open');
        toggle.setAttribute('aria-expanded', 'true');
    };
    const close = () => {
        root.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        window.setTimeout(() => {
            if (!root.classList.contains('is-open')) panel.hidden = true;
        }, 200);
    };

    toggle.addEventListener('click', () => {
        root.classList.contains('is-open') ? close() : open();
    });
    closers.forEach((el) => el.addEventListener('click', () => {
        // Deja que el click de "Nuevo producto" también dispare su handler.
        window.setTimeout(close, 0);
    }));
    document.addEventListener('click', (e) => {
        if (!root.classList.contains('is-open')) return;
        if (!root.contains(e.target)) close();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && root.classList.contains('is-open')) close();
    });
})();
</script>
