<?php

if (!defined('MAJESTIC_AUTH_LOADED')) {
    if (!isset($authInViews)) {
        $scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME'] ?? '');
        $authInViews = str_contains($scriptPath, '/views/');
    }

    require_once __DIR__ . '/auth.php';
}

if (empty($esAdmin)) {
    return;
}

$adminJsPath = !empty($authInViews) ? '../js/admin.js' : 'js/admin.js';
$uploadsBasePath = !empty($authInViews) ? '../' : '';
$defaultCategoriaId = (int) ($defaultCategoriaId ?? 0);
$adminApiUrl = $controllersPath . 'productoController.php';
?>
<div id="admin-modal-backdrop" class="fixed inset-0 bg-primary/50 backdrop-blur-sm z-[80] hidden" aria-hidden="true"></div>

<div id="admin-modal" class="fixed inset-0 z-[90] hidden items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="admin-modal-title">
    <div class="bg-surface dark:bg-on-background w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-outline-variant shadow-2xl">
        <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant sticky top-0 bg-surface dark:bg-on-background z-10">
            <h2 id="admin-modal-title" class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed">Editar producto</h2>
            <button type="button" id="admin-modal-close" class="text-on-surface-variant hover:text-secondary" aria-label="Cerrar">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="admin-product-form" class="p-6 space-y-5" enctype="multipart/form-data">
            <input type="hidden" name="id" id="admin-id" value="" />
            <input type="hidden" name="action" id="admin-action" value="update" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="admin-nombre">Nombre *</label>
                    <input class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="admin-nombre" name="nombre" type="text" required />
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="admin-precio">Precio (USD) *</label>
                    <input class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="admin-precio" name="precio" type="number" step="0.01" min="0" required />
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
                                <input class="block w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-primary file:text-on-primary file:font-label-sm file:uppercase file:tracking-widest hover:file:bg-secondary file:cursor-pointer" id="admin-imagen-archivo" name="imagen_archivo" type="file" accept="image/jpeg,image/png,image/webp,image/gif" />
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
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="admin-stock">Estado de stock</label>
                    <select class="w-full py-3 bg-transparent border-0 border-b border-outline-variant focus:ring-0 font-body-md" id="admin-stock" name="stock_estado">
                        <option value="disponible">Disponible</option>
                        <option value="pocas_unidades">Pocas unidades</option>
                        <option value="agotado">Agotado</option>
                    </select>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="admin-tallas">Tallas (separadas por coma) *</label>
                    <input class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:ring-0 font-body-md" id="admin-tallas" name="tallas" type="text" placeholder="34, 36, 38" required />
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

            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-outline-variant">
                <button type="button" id="admin-delete-btn" class="hidden px-6 py-3 border border-error text-error font-label-md uppercase tracking-widest hover:bg-error-container transition-colors">
                    Ocultar producto
                </button>
                <div class="flex-1 flex flex-col sm:flex-row gap-3 sm:justify-end">
                    <button type="button" id="admin-cancel-btn" class="px-6 py-3 border border-outline-variant font-label-md uppercase tracking-widest hover:border-secondary transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-8 py-3 bg-primary text-on-primary font-label-md uppercase tracking-widest hover:bg-secondary transition-colors">
                        Guardar cambios
                    </button>
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
<script src="<?= htmlspecialchars($adminJsPath) ?>"></script>
