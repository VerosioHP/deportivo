<?php

/** @var array $colores */
/** @var string $context 'card'|'detail' */

if (empty($colores)) {
    return;
}

$context = $context ?? 'card';
$selectorId = $context === 'detail' ? 'color-selector' : '';
$labelClass = $context === 'detail'
    ? 'font-label-md text-label-md uppercase tracking-wider text-primary'
    : 'font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest block mb-2';

$lightColors = ['blanco', 'white', 'beige', 'amarillo', 'yellow'];

$renderButtons = static function () use ($colores, $lightColors, $context, $selectorId): void {
    ?>
    <div <?= $selectorId ? 'id="' . $selectorId . '"' : '' ?> class="<?= $context === 'card' ? 'card-color-overlay' : '' ?>" data-card-color-selector>
        <?php foreach ($colores as $index => $color): ?>
        <?php
            $activo = $index === 0;
            $hex = Producto::colorHex($color['nombre']);
            $stockColor = (int) ($color['stock_cantidad'] ?? 0);
            $esClaro = in_array(strtolower(trim($color['nombre'])), $lightColors, true);
        ?>
        <button type="button"
            class="card-color-btn card-color-swatch <?= $activo ? 'border-secondary' : '' ?> <?= $esClaro ? 'card-color-swatch--light' : '' ?>"
            title="<?= htmlspecialchars($color['nombre']) ?>"
            data-color-id="<?= (int) $color['id'] ?>"
            data-color-nombre="<?= htmlspecialchars($color['nombre'], ENT_QUOTES) ?>"
            data-color-slug="<?= htmlspecialchars($color['slug'], ENT_QUOTES) ?>"
            data-color-stock="<?= $stockColor ?>"
            aria-label="<?= htmlspecialchars($color['nombre']) ?>"
            aria-pressed="<?= $activo ? 'true' : 'false' ?>"
            style="background-color: <?= htmlspecialchars($hex) ?>;">
            <span class="sr-only"><?= htmlspecialchars($color['nombre']) ?></span>
        </button>
        <?php endforeach; ?>
    </div>
    <?php
};

?>
<?php if ($context === 'card'): ?>
    <?php $renderButtons(); ?>
<?php else: ?>
<div class="flex flex-col gap-4">
    <span class="<?= $labelClass ?>">Color</span>
    <?php $renderButtons(); ?>
</div>
<?php endif; ?>
