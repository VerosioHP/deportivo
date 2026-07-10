<?php

if (!defined('MAJESTIC_AUTH_LOADED')) {
    if (!isset($authInViews)) {
        $scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME'] ?? '');
        $authInViews = str_contains($scriptPath, '/views/cliente/views/');
    }

    require_once dirname(__DIR__, 3) . '/includes/auth.php';
}

if (empty($esAdmin)) {
    return;
}

$adminJsFile = $adminJsPath . 'admin.js';
$defaultCategoriaId = (int) ($defaultCategoriaId ?? 0);
$adminApiUrl = $adminControllersPath . 'productoController.php';
?>
<div id="admin-modal-backdrop" class="fixed inset-0 bg-primary/50 backdrop-blur-sm z-[80] hidden" aria-hidden="true"></div>

<div id="admin-modal" class="fixed inset-0 z-[90] hidden items-center justify-center p-4 overflow-y-auto" role="dialog" aria-modal="true" aria-labelledby="admin-modal-title">
    <div class="admin-modal-panel bg-surface dark:bg-on-background w-full max-w-2xl max-h-[min(90vh,900px)] flex flex-col border border-outline-variant shadow-2xl">
        <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant shrink-0 bg-surface dark:bg-on-background">
            <h2 id="admin-modal-title" class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed">Editar producto</h2>
            <button type="button" id="admin-modal-close" class="text-on-surface-variant hover:text-secondary" aria-label="Cerrar">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="admin-product-form" class="flex flex-col flex-1 min-h-0" enctype="multipart/form-data">
            <div class="admin-modal-body overflow-y-auto flex-1 min-h-0 p-6 space-y-5">
            <input type="hidden" name="id" id="admin-id" value="" />
            <input type="hidden" name="action" id="admin-action" value="update" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="admin-nombre">Nombre *</label>
                    <input class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="admin-nombre" name="nombre" type="text" required />
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="admin-precio">Precio (COP) *</label>
                    <input class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="admin-precio" name="precio" type="number" step="100" min="0" required />
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="admin-categoria">Categoría *</label>
                    <select class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="admin-categoria" name="categoria_id" required></select>
                </div>
                <div class="md:col-span-2 space-y-4">
                    <label class="block font-label-md text-label-md text-on-surface-variant" for="admin-imagen-archivo">Imagen principal *</label>
                    <div class="flex flex-col sm:flex-row gap-4 items-start">
                        <img id="admin-imagen-preview" src="" alt="Vista previa" class="hidden w-28 aspect-[3/4] object-cover border border-outline-variant bg-surface-container" />
                        <div class="flex-1 w-full space-y-4">
                            <div>
                                <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2 uppercase tracking-widest" for="admin-imagen-archivo">Subir desde tu PC</label>
                                <input class="block w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-primary file:text-on-primary file:font-label-sm file:uppercase file:tracking-widest hover:file:bg-secondary hover:file:text-on-secondary file:cursor-pointer" id="admin-imagen-archivo" name="imagen_archivo" type="file" accept="image/jpeg,image/png,image/webp,image/gif" />
                                <p class="mt-2 font-body-md text-body-md text-on-surface-variant">JPG, PNG, WEBP o GIF. Máximo 5 MB.</p>
                            </div>
                            <div>
                                <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2 uppercase tracking-widest" for="admin-imagen">O pegar URL externa</label>
                                <input class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="admin-imagen" name="imagen_principal" type="url" placeholder="https://..." />
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="admin-tallas">Tallas (separadas por coma) *</label>
                    <input class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:ring-0 font-body-md" id="admin-tallas" name="tallas" type="text" placeholder="S, M, L, XL" required />
                </div>
                <div class="md:col-span-2">
                    <div class="flex items-center justify-between mb-3">
                        <label class="block font-label-md text-label-md text-on-surface-variant">Colores y stock *</label>
                        <button type="button" id="admin-add-color" class="font-label-sm text-label-sm uppercase tracking-widest text-secondary hover:underline">+ Añadir color</button>
                    </div>
                    <p class="font-body-md text-body-md text-on-surface-variant mb-4">Usa una sola imagen con todas las variantes. Aquí defines el nombre del color y cuántas unidades hay de cada uno.</p>
                    <div id="admin-colores-list" class="space-y-3"></div>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="admin-lavado">Lavado</label>
                    <input class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:ring-0 font-body-md" id="admin-lavado" name="lavado" type="text" placeholder="Raw Indigo" />
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="admin-fit">Silueta / Fit</label>
                    <input class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:ring-0 font-body-md" id="admin-fit" name="fit" type="text" placeholder="Wide Leg" />
                </div>
                <div class="md:col-span-2">
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="admin-descripcion">Descripción *</label>
                    <textarea class="w-full py-3 bg-transparent border border-outline-variant focus:border-secondary focus:ring-0 font-body-md resize-none" id="admin-descripcion" name="descripcion" rows="4" required></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="admin-material">Material (separar con |)</label>
                    <input class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:ring-0 font-body-md" id="admin-material" name="material_info" type="text" />
                </div>
                <div class="md:col-span-2 flex items-center gap-3">
                    <input type="checkbox" id="admin-activo" name="activo" value="1" checked class="rounded border-outline-variant text-secondary focus:ring-secondary" />
                    <label for="admin-activo" class="font-body-md text-body-md">Producto visible en la tienda</label>
                </div>
            </div>

            <p id="admin-form-error" class="hidden text-error font-body-md text-body-md"></p>
            <p id="admin-form-success" class="hidden text-secondary font-body-md text-body-md"></p>
            </div>

            <div class="admin-modal-footer shrink-0 px-6 py-5 border-t border-outline-variant bg-surface dark:bg-on-background">
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="button" id="admin-delete-btn" class="hidden px-6 py-3 border border-error text-error font-label-md uppercase tracking-widest hover:bg-error-container transition-colors">
                    Ocultar producto
                </button>
                <div class="flex-1 flex flex-col sm:flex-row gap-3 sm:justify-end">
                    <button type="button" id="admin-cancel-btn" class="px-6 py-3 border border-outline-variant font-label-md uppercase tracking-widest hover:border-secondary transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-8 py-3 bg-primary text-on-primary font-label-md uppercase tracking-widest hover:bg-secondary hover:text-on-secondary transition-colors">
                        Guardar cambios
                    </button>
                </div>
            </div>
            </div>
        </form>
    </div>
</div>

<script>
    window.ADMIN_CONFIG = {
        apiUrl: <?= json_encode($adminApiUrl, JSON_UNESCAPED_SLASHES) ?>,
        defaultCategoriaId: <?= $defaultCategoriaId ?>,
        uploadsBasePath: <?= json_encode($uploadsBasePath, JSON_UNESCAPED_SLASHES) ?>
    };
</script>
<script src="<?= htmlspecialchars($adminJsFile) ?>"></script>
