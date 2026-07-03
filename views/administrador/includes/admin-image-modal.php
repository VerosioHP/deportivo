<?php

if (empty($esAdmin)) {
    return;
}

if (!defined('MAJESTIC_AUTH_LOADED')) {
    require_once dirname(__DIR__, 3) . '/includes/auth.php';
}

$adminImageJsFile = $adminJsPath . 'admin-images.js';
$sitioApiUrl = $adminControllersPath . 'sitioController.php';
$adminApiUrl = $adminControllersPath . 'productoController.php';
?>
<div id="admin-image-backdrop" class="fixed inset-0 bg-primary/50 backdrop-blur-sm z-[100] hidden" aria-hidden="true"></div>

<div id="admin-image-modal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4 overflow-y-auto" role="dialog" aria-modal="true" aria-labelledby="admin-image-title">
    <div class="admin-modal-panel bg-surface dark:bg-on-background w-full max-w-lg max-h-[min(90vh,720px)] flex flex-col border border-outline-variant shadow-2xl">
        <div class="flex items-center justify-between px-6 py-4 border-b border-outline-variant shrink-0 bg-surface dark:bg-on-background">
            <h2 id="admin-image-title" class="font-headline-sm text-headline-sm text-primary dark:text-primary-fixed">Cambiar imagen</h2>
            <button type="button" id="admin-image-close" class="text-on-surface-variant hover:text-secondary" aria-label="Cerrar">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="admin-image-form" class="flex flex-col flex-1 min-h-0" enctype="multipart/form-data">
            <div class="admin-modal-body overflow-y-auto flex-1 min-h-0 p-6 space-y-4">
            <input type="hidden" id="admin-image-type" name="type" value="" />
            <input type="hidden" id="admin-image-key" name="key" value="" />
            <input type="hidden" id="admin-image-product-id" name="producto_id" value="" />
            <input type="hidden" id="admin-image-gallery-id" name="imagen_id" value="" />

            <p id="admin-image-hint" class="font-body-md text-body-md text-on-surface-variant"></p>

            <img id="admin-image-preview" src="" alt="Vista previa" class="admin-image-modal-preview w-full hidden border border-outline-variant" />

            <div>
                <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2 uppercase tracking-widest" for="admin-image-file">Subir imagen</label>
                <input class="block w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-primary file:text-on-primary file:font-label-sm file:uppercase file:tracking-widest hover:file:bg-secondary hover:file:text-on-secondary file:cursor-pointer" id="admin-image-file" name="imagen_archivo" type="file" accept="image/jpeg,image/png,image/webp,image/gif" />
            </div>
            <div>
                <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2 uppercase tracking-widest" for="admin-image-url">O URL externa</label>
                <input class="w-full py-3 px-0 bg-transparent border-0 border-b border-outline-variant focus:border-secondary focus:ring-0 font-body-md" id="admin-image-url" name="url" type="url" placeholder="https://..." />
            </div>

            <p id="admin-image-error" class="hidden text-error font-body-md text-body-md"></p>
            <p id="admin-image-success" class="hidden text-secondary font-body-md text-body-md"></p>
            </div>

            <div class="admin-modal-footer shrink-0 px-6 py-5 border-t border-outline-variant bg-surface dark:bg-on-background">
            <div class="flex gap-3">
                <button type="button" id="admin-image-cancel" class="flex-1 px-4 py-3 border border-outline-variant font-label-md uppercase tracking-widest hover:border-secondary transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="flex-1 px-4 py-3 bg-secondary text-on-secondary font-label-md uppercase tracking-widest hover:opacity-90 transition-opacity">
                    Guardar imagen
                </button>
            </div>
            </div>
        </form>
    </div>
</div>

<script>
    window.ADMIN_IMAGE_CONFIG = {
        sitioApiUrl: <?= json_encode($sitioApiUrl, JSON_UNESCAPED_SLASHES) ?>,
        productoApiUrl: <?= json_encode($adminApiUrl, JSON_UNESCAPED_SLASHES) ?>,
        desdeVistas: <?= !empty($authInViews) ? 'true' : 'false' ?>,
        uploadsBasePath: <?= json_encode($uploadsBasePath, JSON_UNESCAPED_SLASHES) ?>
    };
</script>
<script src="<?= htmlspecialchars($adminImageJsFile) ?>"></script>
