<?php

/**
 * Logo de marca VEMA (ícono + wordmark).
 * Requiere $assetBase y $homeUrl.
 */
$brandHomeUrl = $homeUrl ?? ($clienteHomeUrl ?? '#');
$brandAssetBase = $assetBase ?? '';
$brandMarkUrl = $brandAssetBase . 'assets/brand/vema-mark.png';
$brandWordUrl = $brandAssetBase . 'assets/brand/vema-wordmark.png';
?>
<a class="brand-logo no-underline hover:opacity-80 transition-opacity" href="<?= htmlspecialchars($brandHomeUrl) ?>" aria-label="VEMA — Inicio">
    <img class="brand-logo-mark" src="<?= htmlspecialchars($brandMarkUrl) ?>" alt="" width="46" height="46" decoding="async" />
    <img class="brand-logo-word" src="<?= htmlspecialchars($brandWordUrl) ?>" alt="VEMA" width="140" height="30" decoding="async" />
</a>
