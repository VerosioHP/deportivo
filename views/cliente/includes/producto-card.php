<?php

/** @var array $producto */
/** @var bool $showAddButton */

if (!function_exists('deportivo_admin_product_img')) {
    require_once __DIR__ . '/sport-images.php';
}

$showAddButton = $showAddButton ?? true;
$tallaDefault = $producto['tallas'][0] ?? 'M';
$desdeVistas = $desdeVistas ?? (!empty($authInViews) || str_contains(str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME'] ?? ''), '/views/cliente/views/'));
$imagenUrl = Producto::urlImagen($producto['imagen_principal'], $desdeVistas);
$productoId = (int) $producto['id'];
$esAdminCard = !empty($esAdmin);

?>
<article
    class="product-card group flex flex-col"
    data-product-card
    data-product-id="<?= $productoId ?>"
    data-lavado="<?= htmlspecialchars($producto['lavado'] ?? '', ENT_QUOTES) ?>"
    data-fit="<?= htmlspecialchars($producto['fit'] ?? '', ENT_QUOTES) ?>"
    data-tallas="<?= htmlspecialchars(implode(',', $producto['tallas']), ENT_QUOTES) ?>"
    <?= $esAdminCard ? 'data-admin-edit-card="' . $productoId . '"' : '' ?>
>
    <div class="aspect-[3/4] mb-6 overflow-hidden bg-surface-container relative">
        <a href="<?= $esAdminCard ? '#' : 'producto.php?id=' . $productoId ?>" class="block w-full h-full text-inherit no-underline hover:opacity-95 transition-opacity admin-product-link" <?= $esAdminCard ? 'data-admin-edit="' . $productoId . '"' : '' ?>>
            <img alt="<?= htmlspecialchars($producto['nombre']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                src="<?= htmlspecialchars($imagenUrl) ?>"
                <?= deportivo_admin_product_img($productoId) ?>
            />
        </a>
        <span class="absolute top-4 left-4 bg-surface px-3 py-1 font-label-sm text-label-sm uppercase tracking-widest pointer-events-none"><?= htmlspecialchars(Producto::etiquetaStock($producto['stock_estado'])) ?></span>
        <?php if (!$esAdminCard): ?>
        <button type="button"
            class="absolute top-4 right-4 z-10 transition-colors"
            data-toggle-favorite
            data-product-id="<?= $productoId ?>"
            data-product-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>"
            data-product-precio="<?= (float) $producto['precio'] ?>"
            data-product-imagen="<?= htmlspecialchars($imagenUrl, ENT_QUOTES) ?>"
            data-product-talla="<?= htmlspecialchars($tallaDefault, ENT_QUOTES) ?>"
            data-product-lavado="<?= htmlspecialchars($producto['lavado'] ?? '', ENT_QUOTES) ?>"
            data-product-fit="<?= htmlspecialchars($producto['fit'] ?? '', ENT_QUOTES) ?>"
            data-product-categoria="<?= htmlspecialchars($producto['categoria_nombre'] ?? '', ENT_QUOTES) ?>"
            data-product-stock="<?= htmlspecialchars($producto['stock_estado'], ENT_QUOTES) ?>"
            aria-label="Añadir a favoritos"
            aria-pressed="false">
            <span class="material-symbols-outlined">favorite</span>
        </button>
        <?php endif; ?>
        <?php if ($esAdminCard): ?>
        <span class="absolute top-4 right-4 z-10 bg-primary text-on-primary px-3 py-1 font-label-sm text-label-sm uppercase tracking-widest pointer-events-none">Editar producto</span>
        <?php endif; ?>
    </div>
    <a href="<?= $esAdminCard ? '#' : 'producto.php?id=' . $productoId ?>" class="space-y-1 block text-inherit no-underline hover:opacity-95 transition-opacity admin-product-link" <?= $esAdminCard ? 'data-admin-edit="' . $productoId . '"' : '' ?>>
        <h2 class="font-headline-sm text-headline-sm" <?= $esAdminCard ? 'data-admin-edit="' . $productoId . '"' : '' ?>><?= htmlspecialchars($producto['nombre']) ?></h2>
        <p class="font-body-md text-body-md text-secondary" data-product-price="<?= (float) $producto['precio'] ?>"><?= Producto::formatearPrecio((float) $producto['precio']) ?></p>
    </a>    <div class="mt-4">
        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest block mb-2">Talla</span>
        <div class="flex flex-wrap gap-2" data-card-size-selector>
            <?php foreach ($producto['tallas'] as $talla): ?>
            <?php $activa = $talla === $tallaDefault; ?>
            <button type="button"
                class="card-size-btn min-w-10 h-10 px-2 flex items-center justify-center font-label-md text-label-md transition-colors <?= $activa ? 'bg-secondary text-on-secondary border border-secondary' : 'border border-outline-variant hover:border-secondary' ?>">
                <?= htmlspecialchars($talla) ?>
            </button>
            <?php endforeach; ?>
        </div>
    </div>
    <?php if ($showAddButton): ?>
    <button type="button"
        class="mt-4 w-full py-3 border border-primary text-primary font-label-md text-label-md uppercase tracking-widest hover:bg-primary hover:text-on-primary transition-all"
        data-add-to-cart
        data-product-talla-from="card"
        data-product-id="<?= $productoId ?>"
        data-product-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>"
        data-product-precio="<?= (float) $producto['precio'] ?>"
        data-product-imagen="<?= htmlspecialchars($imagenUrl, ENT_QUOTES) ?>"
        data-product-talla="<?= htmlspecialchars($tallaDefault, ENT_QUOTES) ?>"
        data-product-lavado="<?= htmlspecialchars($producto['lavado'] ?? '', ENT_QUOTES) ?>"
        data-product-fit="<?= htmlspecialchars($producto['fit'] ?? '', ENT_QUOTES) ?>"
        data-product-categoria="<?= htmlspecialchars($producto['categoria_nombre'] ?? '', ENT_QUOTES) ?>"
        data-product-stock="<?= htmlspecialchars($producto['stock_estado'], ENT_QUOTES) ?>">
        Añadir al carrito
    </button>
    <?php endif; ?>
</article>
