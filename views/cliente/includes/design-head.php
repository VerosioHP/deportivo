<?php
/**
 * Assets del design system Kinetic Noir.
 * Variables esperadas: $assetBase (ej. '' o '../'), $pageCss (ej. 'pages/index.css')
 */
$assetBase = $assetBase ?? '';
$pageCss = $pageCss ?? null;
$fontsUrl = 'https://fonts.googleapis.com/css2?family=Anybody:ital,wght@0,600;0,700;0,800;1,700&family=Hanken+Grotesk:wght@400;500;600&family=JetBrains+Mono:wght@500;700&display=swap';
?>
<script src="<?= htmlspecialchars($assetBase) ?>js/theme/moneda.js"></script>
<script src="<?= htmlspecialchars($assetBase) ?>js/theme/init.js"></script>
<script src="<?= htmlspecialchars($assetBase) ?>js/theme/tokens.js"></script>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="<?= htmlspecialchars($fontsUrl) ?>" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
<link rel="stylesheet" href="<?= htmlspecialchars($assetBase) ?>css/site.css">
<?php if ($pageCss): ?>
<link rel="stylesheet" href="<?= htmlspecialchars($assetBase) ?>css/<?= htmlspecialchars($pageCss) ?>">
<?php endif; ?>
<script src="<?= htmlspecialchars($assetBase) ?>js/theme/config.js"></script>
