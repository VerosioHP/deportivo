<?php

/**
 * Panel admin unificado: barra, modales de producto e imagen.
 * Requiere auth.php cargado y $esAdmin === true.
 */

if (empty($esAdmin)) {
    return;
}

include __DIR__ . '/admin-bar.php';
include __DIR__ . '/admin-modal.php';
include __DIR__ . '/admin-image-modal.php';
