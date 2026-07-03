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

?>
<?php if ($usuarioLogueado): ?>
<div class="flex items-center gap-3 text-primary dark:text-primary-fixed">
    <?php if ($esAdmin): ?>
    <span class="hidden sm:inline font-label-sm text-label-sm uppercase tracking-widest text-secondary dark:text-secondary-fixed-dim">Admin</span>
    <?php endif; ?>
    <span class="hidden lg:inline font-label-sm text-label-sm text-on-surface-variant max-w-[120px] truncate" title="<?= htmlspecialchars($usuarioNombre ?: $usuarioEmail) ?>">
        <?= htmlspecialchars($usuarioNombre ?: $usuarioEmail) ?>
    </span>
    <a class="font-label-sm text-label-sm uppercase tracking-widest hover:text-secondary transition-colors no-underline text-current" href="<?= htmlspecialchars($logoutUrl) ?>" title="Cerrar sesión">
        <span class="material-symbols-outlined text-xl">logout</span>
    </a>
</div>
<?php else: ?>
<a class="transition-opacity duration-200 active:opacity-70 text-current no-underline" href="<?= htmlspecialchars($loginUrl) ?>" aria-label="Iniciar sesión">
    <span class="material-symbols-outlined">person</span>
</a>
<?php endif; ?>
