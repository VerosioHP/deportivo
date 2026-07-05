<?php

require_once dirname(__DIR__, 3) . '/includes/auth.php';

if (!$esAdmin) {
    header('Location: ' . deportivo_cliente_url('catalogo.php?categoria=camisetas'));
    exit;
}

$activePage = 'admin_usuarios';
$usuariosApiUrl = $adminControllersPath . 'usuarioController.php';
$clienteIncludes = dirname(__DIR__, 2) . '/cliente/includes';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Usuarios | Administrador — DEPORTIVO</title>
    <?php $pageCss = 'pages/index.css'; include $clienteIncludes . '/design-head.php'; ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($adminCssPath) ?>admin-edit.css">
    <link rel="stylesheet" href="<?= htmlspecialchars($adminCssPath) ?>admin-usuarios.css">
</head>
<body class="bg-surface dark:bg-on-background text-on-surface dark:text-inverse-on-surface transition-colors duration-300 admin-mode">

    <?php include $clienteIncludes . '/site-nav.php'; ?>
    <?php $defaultCategoriaId = 0; include dirname(__DIR__) . '/includes/admin-panel.php'; ?>

    <main class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.25em] block mb-2">Administración</span>
                <h1 class="font-headline-md text-headline-md text-primary dark:text-primary-fixed uppercase">Usuarios</h1>
                <p class="font-body-md text-on-surface-variant mt-2">Crea, edita o elimina cuentas de clientes y administradores.</p>
            </div>
            <button type="button" id="btn-nuevo-usuario" class="inline-flex items-center gap-2 px-4 py-2 bg-secondary text-on-secondary font-label-sm uppercase tracking-widest hover:opacity-90 transition-opacity">
                <span class="material-symbols-outlined text-base">person_add</span>
                Nuevo usuario
            </button>
        </div>

        <div id="usuarios-loading" class="text-center py-16 text-on-surface-variant font-body-md">Cargando usuarios…</div>
        <div id="usuarios-empty" class="hidden text-center py-16 text-on-surface-variant font-body-md">No hay usuarios registrados.</div>
        <div id="usuarios-error" class="hidden text-center py-16 text-error font-body-md"></div>

        <div id="usuarios-table-wrap" class="hidden overflow-x-auto border border-outline-variant">
            <table class="admin-usuarios-table w-full">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Registro</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="usuarios-tbody"></tbody>
            </table>
        </div>
    </main>

    <div id="usuario-modal-backdrop" class="fixed inset-0 bg-primary/50 backdrop-blur-sm z-[80] hidden" aria-hidden="true"></div>
    <div id="usuario-modal" class="fixed inset-0 z-[90] hidden items-center justify-center p-4 overflow-y-auto" role="dialog" aria-modal="true" aria-labelledby="usuario-modal-titulo">
        <div class="admin-modal-panel bg-surface dark:bg-on-background w-full max-w-lg max-h-[min(90vh,700px)] flex flex-col border border-outline-variant shadow-2xl">
            <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant shrink-0">
                <h2 id="usuario-modal-titulo" class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed">Nuevo usuario</h2>
                <button type="button" id="usuario-modal-cerrar" class="text-on-surface-variant hover:text-secondary" aria-label="Cerrar">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form id="usuario-form" class="flex flex-col flex-1 min-h-0">
                <div class="admin-modal-body overflow-y-auto flex-1 min-h-0 p-6 space-y-5">
                    <input type="hidden" name="id" id="usuario-id" value="" />
                    <input type="hidden" name="action" id="usuario-action" value="create" />

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="usuario-nombre">Nombre *</label>
                            <input class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="usuario-nombre" name="nombre" type="text" required />
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="usuario-apellido">Apellido</label>
                            <input class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="usuario-apellido" name="apellido" type="text" />
                        </div>
                    </div>
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="usuario-email">Correo *</label>
                        <input class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="usuario-email" name="email" type="email" required autocomplete="off" />
                    </div>
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="usuario-password">Contraseña <span id="usuario-password-hint">*</span></label>
                        <input class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="usuario-password" name="password" type="password" minlength="6" autocomplete="new-password" />
                        <p id="usuario-password-ayuda" class="font-body-sm text-on-surface-variant mt-2 hidden">Deja en blanco para mantener la contraseña actual.</p>
                    </div>
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="usuario-rol">Rol *</label>
                        <select class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="usuario-rol" name="rol" required>
                            <option value="cliente">Cliente</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                    <p id="usuario-form-error" class="font-body-sm text-error hidden"></p>
                </div>
                <div class="px-6 py-4 border-t border-outline-variant shrink-0 flex flex-wrap items-center justify-between gap-4">
                    <button type="button" id="usuario-eliminar" class="hidden px-4 py-2 border border-error text-error font-label-sm uppercase tracking-widest hover:bg-error/10">Eliminar</button>
                    <div class="flex gap-3 ml-auto">
                        <button type="button" id="usuario-cancelar" class="px-4 py-2 border border-outline-variant font-label-sm uppercase tracking-widest">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-secondary text-on-secondary font-label-sm uppercase tracking-widest hover:opacity-90">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include $clienteIncludes . '/site-footer.php'; ?>

    <script>
        window.USUARIOS_CONFIG = {
            apiUrl: <?= json_encode($usuariosApiUrl, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>,
            sesionUsuarioId: <?= (int) ($_SESSION['usuario_id'] ?? 0) ?>
        };
    </script>
    <script src="<?= htmlspecialchars($adminJsPath) ?>admin-usuarios.js"></script>
    <script src="<?= htmlspecialchars($assetBase) ?>js/theme/toggle.js"></script>
</body>
</html>
