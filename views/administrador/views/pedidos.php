<?php

require_once dirname(__DIR__, 3) . '/includes/auth.php';

if (!$esAdmin) {
    header('Location: ' . deportivo_cliente_url('catalogo.php?categoria=camisetas'));
    exit;
}

$activePage = 'admin_pedidos';
$pedidosApiUrl = $adminControllersPath . 'pedidoController.php';
$clienteIncludes = dirname(__DIR__, 2) . '/cliente/includes';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Pedidos | Administrador — DEPORTIVO</title>
    <?php $pageCss = 'pages/index.css'; include $clienteIncludes . '/design-head.php'; ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($adminCssPath) ?>admin-edit.css">
    <link rel="stylesheet" href="<?= htmlspecialchars($adminCssPath) ?>admin-pedidos.css">
</head>
<body class="bg-surface dark:bg-on-background text-on-surface dark:text-inverse-on-surface transition-colors duration-300 admin-mode">

    <?php include $clienteIncludes . '/site-nav.php'; ?>
    <?php $defaultCategoriaId = 0; include dirname(__DIR__) . '/includes/admin-panel.php'; ?>

    <main class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.25em] block mb-2">Administración</span>
                <h1 class="font-headline-md text-headline-md text-primary dark:text-primary-fixed uppercase">Pedidos</h1>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <label class="sr-only" for="filtro-estado">Filtrar por estado</label>
                <select id="filtro-estado" class="py-2 px-4 bg-surface-container border border-outline-variant font-body-md text-body-md">
                    <option value="">Todos los estados</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="confirmado">Confirmado</option>
                    <option value="enviado">Enviado</option>
                    <option value="cancelado">Cancelado</option>
                </select>
                <button type="button" id="btn-refrescar-pedidos" class="inline-flex items-center gap-2 px-4 py-2 border border-primary text-primary font-label-sm uppercase tracking-widest hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-base">refresh</span>
                    Actualizar
                </button>
            </div>
        </div>

        <div id="pedidos-loading" class="text-center py-16 text-on-surface-variant font-body-md">Cargando pedidos…</div>
        <div id="pedidos-empty" class="hidden text-center py-16 text-on-surface-variant font-body-md">No hay pedidos para mostrar.</div>
        <div id="pedidos-error" class="hidden text-center py-16 text-error font-body-md"></div>

        <div id="pedidos-table-wrap" class="hidden overflow-x-auto border border-outline-variant">
            <table class="admin-pedidos-table w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="pedidos-tbody"></tbody>
            </table>
        </div>

        <div id="pedidos-pagination" class="hidden flex items-center justify-between mt-6">
            <p id="pedidos-info" class="font-body-sm text-on-surface-variant"></p>
            <div class="flex gap-2">
                <button type="button" id="btn-pagina-anterior" class="px-4 py-2 border border-outline-variant font-label-sm uppercase tracking-widest disabled:opacity-40" disabled>Anterior</button>
                <button type="button" id="btn-pagina-siguiente" class="px-4 py-2 border border-outline-variant font-label-sm uppercase tracking-widest disabled:opacity-40" disabled>Siguiente</button>
            </div>
        </div>
    </main>

    <div id="pedido-detalle-backdrop" class="fixed inset-0 bg-primary/50 backdrop-blur-sm z-[80] hidden" aria-hidden="true"></div>
    <div id="pedido-detalle-modal" class="fixed inset-0 z-[90] hidden items-center justify-center p-4 overflow-y-auto" role="dialog" aria-modal="true" aria-labelledby="pedido-detalle-titulo">
        <div class="admin-modal-panel bg-surface dark:bg-on-background w-full max-w-3xl max-h-[min(90vh,900px)] flex flex-col border border-outline-variant shadow-2xl">
            <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant shrink-0">
                <h2 id="pedido-detalle-titulo" class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed">Detalle del pedido</h2>
                <button type="button" id="pedido-detalle-cerrar" class="text-on-surface-variant hover:text-secondary" aria-label="Cerrar">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div id="pedido-detalle-contenido" class="admin-modal-body overflow-y-auto flex-1 min-h-0 p-6 space-y-6">
                <p class="text-on-surface-variant font-body-md">Cargando…</p>
            </div>
            <div class="px-6 py-4 border-t border-outline-variant shrink-0 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest" for="pedido-estado-select">Estado</label>
                    <select id="pedido-estado-select" class="py-2 px-3 bg-surface-container border border-outline-variant font-body-md">
                        <option value="pendiente">Pendiente</option>
                        <option value="confirmado">Confirmado</option>
                        <option value="enviado">Enviado</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                    <button type="button" id="pedido-guardar-estado" class="px-4 py-2 bg-secondary text-on-secondary font-label-sm uppercase tracking-widest hover:opacity-90">Guardar</button>
                </div>
                <p id="pedido-detalle-mensaje" class="font-body-sm text-secondary hidden"></p>
            </div>
        </div>
    </div>

    <?php include $clienteIncludes . '/site-footer.php'; ?>

    <script>
        window.PEDIDOS_CONFIG = {
            apiUrl: <?= json_encode($pedidosApiUrl, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
        };
    </script>
    <script src="<?= htmlspecialchars($adminJsPath) ?>admin-pedidos.js"></script>
    <script src="<?= htmlspecialchars($assetBase) ?>js/theme/toggle.js"></script>
</body>
</html>
