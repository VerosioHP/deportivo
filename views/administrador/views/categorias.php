<?php

require_once dirname(__DIR__, 3) . '/includes/auth.php';

if (!$esAdmin) {
    header('Location: ' . deportivo_cliente_url('catalogo.php?categoria=camisetas'));
    exit;
}

$activePage = 'admin_categorias';
$categoriasApiUrl = $adminControllersPath . 'categoriaController.php';
$clienteIncludes = dirname(__DIR__, 2) . '/cliente/includes';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Categorías | Administrador — DEPORTIVO</title>
    <?php $pageCss = 'pages/index.css'; include $clienteIncludes . '/design-head.php'; ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($adminCssPath) ?>admin-edit.css">
    <link rel="stylesheet" href="<?= htmlspecialchars($adminCssPath) ?>admin-categorias.css">
</head>
<body class="bg-surface dark:bg-on-background text-on-surface dark:text-inverse-on-surface transition-colors duration-300 admin-mode">

    <?php include $clienteIncludes . '/site-nav.php'; ?>
    <?php $defaultCategoriaId = 0; include dirname(__DIR__) . '/includes/admin-panel.php'; ?>

    <main class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.25em] block mb-2">Administración</span>
                <h1 class="font-headline-md text-headline-md text-primary dark:text-primary-fixed uppercase">Categorías</h1>
                <p class="font-body-md text-on-surface-variant mt-2">Gestiona las categorías del catálogo y del formulario de productos.</p>
            </div>
            <button type="button" id="btn-nueva-categoria" class="inline-flex items-center gap-2 px-4 py-2 bg-secondary text-on-secondary font-label-sm uppercase tracking-widest hover:opacity-90 transition-opacity">
                <span class="material-symbols-outlined text-base">add</span>
                Nueva categoría
            </button>
        </div>

        <div id="categorias-loading" class="text-center py-16 text-on-surface-variant font-body-md">Cargando categorías…</div>
        <div id="categorias-empty" class="hidden text-center py-16 text-on-surface-variant font-body-md">No hay categorías. Crea la primera.</div>
        <div id="categorias-error" class="hidden text-center py-16 text-error font-body-md"></div>

        <div id="categorias-table-wrap" class="hidden overflow-x-auto border border-outline-variant">
            <table class="admin-categorias-table w-full">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Slug</th>
                        <th>Descripción</th>
                        <th>Productos</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="categorias-tbody"></tbody>
            </table>
        </div>
    </main>

    <div id="categoria-modal-backdrop" class="fixed inset-0 bg-primary/50 backdrop-blur-sm z-[80] hidden" aria-hidden="true"></div>
    <div id="categoria-modal" class="fixed inset-0 z-[90] hidden items-center justify-center p-4 overflow-y-auto" role="dialog" aria-modal="true" aria-labelledby="categoria-modal-titulo">
        <div class="admin-modal-panel bg-surface dark:bg-on-background w-full max-w-lg max-h-[min(90vh,700px)] flex flex-col border border-outline-variant shadow-2xl">
            <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant shrink-0">
                <h2 id="categoria-modal-titulo" class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed">Nueva categoría</h2>
                <button type="button" id="categoria-modal-cerrar" class="text-on-surface-variant hover:text-secondary" aria-label="Cerrar">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form id="categoria-form" class="flex flex-col flex-1 min-h-0">
                <div class="admin-modal-body overflow-y-auto flex-1 min-h-0 p-6 space-y-5">
                    <input type="hidden" name="id" id="categoria-id" value="" />
                    <input type="hidden" name="action" id="categoria-action" value="create" />

                    <div>
                        <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="categoria-nombre">Nombre *</label>
                        <input class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="categoria-nombre" name="nombre" type="text" required />
                    </div>
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="categoria-descripcion">Descripción</label>
                        <textarea class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md resize-y min-h-[100px]" id="categoria-descripcion" name="descripcion" rows="4" placeholder="Texto que verá el cliente en el catálogo"></textarea>
                    </div>
                    <p id="categoria-slug-preview" class="font-body-sm text-on-surface-variant hidden"></p>
                    <p id="categoria-form-error" class="font-body-sm text-error hidden"></p>
                </div>
                <div class="px-6 py-4 border-t border-outline-variant shrink-0 flex flex-wrap items-center justify-between gap-4">
                    <button type="button" id="categoria-eliminar" class="hidden px-4 py-2 border border-error text-error font-label-sm uppercase tracking-widest hover:bg-error/10">Eliminar</button>
                    <div class="flex gap-3 ml-auto">
                        <button type="button" id="categoria-cancelar" class="px-4 py-2 border border-outline-variant font-label-sm uppercase tracking-widest">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-secondary text-on-secondary font-label-sm uppercase tracking-widest hover:opacity-90">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include $clienteIncludes . '/site-footer.php'; ?>

    <script>
        window.CATEGORIAS_CONFIG = {
            apiUrl: <?= json_encode($categoriasApiUrl, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
        };
    </script>
    <script src="<?= htmlspecialchars($adminJsPath) ?>admin-categorias.js"></script>
    <script src="<?= htmlspecialchars($assetBase) ?>js/theme/toggle.js"></script>
</body>
</html>
