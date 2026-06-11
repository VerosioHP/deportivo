<?php

/** @var array $producto */
/** @var bool $showAddButton */

$showAddButton = $showAddButton ?? true;
$tallaDefault = $producto['tallas'][0] ?? 'M';

?>
<article
    class="product-card group flex flex-col"
    data-product-card
    data-lavado="<?= htmlspecialchars($producto['lavado'] ?? '', ENT_QUOTES) ?>"
    data-fit="<?= htmlspecialchars($producto['fit'] ?? '', ENT_QUOTES) ?>"
    data-tallas="<?= htmlspecialchars(implode(',', $producto['tallas']), ENT_QUOTES) ?>"
>
    <a href="producto.php?id=<?= (int) $producto['id'] ?>" class="block text-inherit no-underline hover:opacity-95 transition-opacity">
        <div class="aspect-[3/4] mb-6 overflow-hidden bg-surface-container relative">
            <img alt="<?= htmlspecialchars($producto['nombre']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                src="<?= htmlspecialchars($producto['imagen_principal']) ?>"
            />
            <span class="absolute top-4 left-4 bg-surface px-3 py-1 font-label-sm text-label-sm uppercase tracking-widest"><?= htmlspecialchars(Producto::etiquetaStock($producto['stock_estado'])) ?></span>
        </div>
        <div class="space-y-1">
            <h2 class="font-headline-sm text-headline-sm"><?= htmlspecialchars($producto['nombre']) ?></h2>
            <p class="font-body-md text-body-md text-secondary"><?= Producto::formatearPrecio((float) $producto['precio']) ?></p>
        </div>
    </a>
    <div class="mt-4">
        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest block mb-2">Talla</span>
        <div class="flex flex-wrap gap-2" data-card-size-selector>
            <?php foreach ($producto['tallas'] as $talla): ?>
            <?php $activa = $talla === $tallaDefault; ?>
            <button type="button"
                class="card-size-btn min-w-10 h-10 px-2 flex items-center justify-center font-label-md text-label-md transition-colors <?= $activa ? 'bg-secondary text-on-primary border border-secondary' : 'border border-outline-variant hover:border-secondary' ?>">
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
        data-product-id="<?= (int) $producto['id'] ?>"
        data-product-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>"
        data-product-precio="<?= (float) $producto['precio'] ?>"
        data-product-imagen="<?= htmlspecialchars($producto['imagen_principal'], ENT_QUOTES) ?>"
        data-product-talla="<?= htmlspecialchars($tallaDefault, ENT_QUOTES) ?>"
        data-product-lavado="<?= htmlspecialchars($producto['lavado'] ?? '', ENT_QUOTES) ?>"
        data-product-fit="<?= htmlspecialchars($producto['fit'] ?? '', ENT_QUOTES) ?>"
        data-product-categoria="<?= htmlspecialchars($producto['categoria_nombre'] ?? '', ENT_QUOTES) ?>"
        data-product-stock="<?= htmlspecialchars($producto['stock_estado'], ENT_QUOTES) ?>">
        Añadir al carrito
    </button>
    <?php endif; ?>
</article>
