<?php

if (!defined('MAJESTIC_AUTH_LOADED')) {
    if (!isset($authInViews)) {
        $scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME'] ?? '');
        $authInViews = str_contains($scriptPath, '/views/cliente/views/');
    }

    require_once dirname(__DIR__, 3) . '/includes/auth.php';
}

$loginUrl = $clienteViewsPath . 'login.php';
$logoutUrl = $clienteControllersPath . 'logout.php';
$perfilUrl = deportivo_cliente_url('perfil.php');
$pedidosUrl = deportivo_cliente_url('mis_pedidos.php');
$cuentaNombre = $usuarioDisplayNombre !== '' ? $usuarioDisplayNombre : 'Cuenta';

?>
<?php if ($usuarioLogueado): ?>
<div class="account-menu" data-account-menu>
    <button type="button" class="account-menu-trigger transition-opacity duration-200 active:opacity-70 text-current" data-account-menu-toggle aria-expanded="false" aria-haspopup="true" aria-controls="account-menu-panel" aria-label="Menú de cuenta">
        <span class="material-symbols-outlined" aria-hidden="true">person</span>
    </button>

    <div class="account-menu-panel" id="account-menu-panel" data-account-menu-panel hidden>
        <div class="account-menu-head">
            <span class="material-symbols-outlined account-menu-avatar" aria-hidden="true">person</span>
            <div class="account-menu-user">
                <p class="account-menu-name"><?= htmlspecialchars($cuentaNombre) ?></p>
                <p class="account-menu-email"><?= htmlspecialchars((string) $usuarioEmail) ?></p>
            </div>
        </div>

        <nav class="account-menu-links" aria-label="Cuenta">
            <a class="account-menu-link" href="<?= htmlspecialchars($perfilUrl) ?>">
                <span class="material-symbols-outlined" aria-hidden="true">manage_accounts</span>
                Editar perfil
            </a>
            <a class="account-menu-link" href="<?= htmlspecialchars($pedidosUrl) ?>">
                <span class="material-symbols-outlined" aria-hidden="true">receipt_long</span>
                Mis pedidos
            </a>
        </nav>

        <a class="account-menu-logout" href="<?= htmlspecialchars($logoutUrl) ?>">
            <span class="material-symbols-outlined" aria-hidden="true">logout</span>
            Cerrar sesión
        </a>
    </div>
</div>
<script>
(() => {
    const root = document.querySelector('[data-account-menu]');
    if (!root || root.dataset.bound === '1') return;
    root.dataset.bound = '1';

    const toggle = root.querySelector('[data-account-menu-toggle]');
    const panel = root.querySelector('[data-account-menu-panel]');
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
        }, 160);
    };

    toggle.addEventListener('click', (e) => {
        e.stopPropagation();
        root.classList.contains('is-open') ? close() : open();
    });
    document.addEventListener('click', (e) => {
        if (!root.classList.contains('is-open')) return;
        if (!root.contains(e.target)) close();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && root.classList.contains('is-open')) close();
    });
})();
</script>
<?php else: ?>
<a class="transition-opacity duration-200 active:opacity-70 text-current no-underline" href="<?= htmlspecialchars($loginUrl) ?>" aria-label="Iniciar sesión">
    <span class="material-symbols-outlined">person</span>
</a>
<?php endif; ?>
