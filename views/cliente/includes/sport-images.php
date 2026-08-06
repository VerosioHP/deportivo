<?php

require_once dirname(__DIR__, 3) . '/models/SitioImagen.php';

/**
 * URLs de imágenes del sitio (Unsplash por defecto + overrides del admin).
 */
function deportivo_img(string $key, string $size = 'lg', bool $desdeVistas = false): string
{
    static $images = [
        'hero_main'           => 'photo-1635864547980-4c818b210101',
        'hero_street'         => 'photo-1635864547980-4c818b210101',
        'running'             => 'photo-1476480862126-209bfaa8edc8',
        'gym'                 => 'photo-1571019614242-c5c5dee9f50b',
        'cycling'             => 'photo-1461896836934-ffe607ba8211',
        'tennis'              => 'photo-1595435934249-5df7ed86e1c0',
        'swimming'            => 'photo-1576678927484-cc907957088c',
        'basketball'          => 'photo-1546519638-68e109498ffc',
        'yoga'                => 'photo-1544367567-0f2fcb009e0b',
        'crossfit'            => 'photo-1517836357463-d25dfeac3438',
        'camisetas'           => 'photo-1521572163474-6864f9cf17ab',
        'pantalonetas'        => 'photo-1594381898411-846e7d193883',
        // Nosotros: sin Unsplash; se suben desde el admin.
        'nosotros_hero'       => '',
        'nosotros_tejido'     => '',
        'nosotros_gym'        => '',
        'medellin_1'          => '',
        'medellin_2'          => '',
        'medellin_3'          => '',
        'medellin_4'          => '',
        'medellin_5'          => '',
        'medellin_6'          => '',
        'login_side'          => '',
        'catalogo_camisetas'  => 'photo-1521572163474-6864f9cf17ab',
        'catalogo_pantalonetas' => 'photo-1552674605-db6ffd4facb5',
    ];

    $override = SitioImagen::obtener($key);

    if ($override !== null) {
        return SitioImagen::urlPublica($override, $desdeVistas);
    }

    if (!array_key_exists($key, $images)) {
        $photo = $images['running'];
    } else {
        $photo = $images[$key];
    }

    // Clave sin imagen por defecto (solo admin / override).
    if ($photo === null || $photo === '') {
        return '';
    }

    $widths = ['xs' => 200, 'sm' => 500, 'md' => 900, 'lg' => 1200, 'xl' => 1920];
    $w = $widths[$size] ?? 1200;

    return "https://images.unsplash.com/{$photo}?w={$w}&q=85&auto=format&fit=crop";
}

/** True si hay imagen guardada o Unsplash por defecto para esa clave. */
function deportivo_site_image_ready(string $key): bool
{
    return deportivo_img($key, 'sm') !== '';
}

function deportivo_sport_cards(): array
{
    return deportivo_camiseta_features();
}

function deportivo_camiseta_features(): array
{
    return [
        ['num' => '01', 'name' => 'Dry-Fit',     'key' => 'camisetas',  'alt' => 'Camiseta deportiva Dry-Fit'],
        ['num' => '02', 'name' => 'Corte atlético','key' => 'gym',       'alt' => 'Camiseta con corte atlético'],
        ['num' => '03', 'name' => 'Colores',      'key' => 'catalogo_camisetas', 'alt' => 'Camisetas en varios colores'],
        ['num' => '04', 'name' => 'Comodidad',    'key' => 'crossfit',   'alt' => 'Camiseta cómoda para entrenar'],
    ];
}

/** Igual que deportivo_img pero con prefijo ../ en vistas. */
function deportivo_img_ctx(string $key, string $size = 'lg'): string
{
    $desdeVistas = !empty($GLOBALS['authInViews']);

    return deportivo_img($key, $size, $desdeVistas);
}

function deportivo_admin_site_img(string $key): string
{
    if (empty($GLOBALS['esAdmin'])) {
        return '';
    }

    return ' data-admin-site-image="' . htmlspecialchars($key, ENT_QUOTES) . '"';
}

/** Atributos data-* para cambiar imagen principal de un producto (solo admin). */
function deportivo_admin_product_img(int $productoId): string
{
    if (empty($GLOBALS['esAdmin'])) {
        return '';
    }

    return ' data-admin-product-image="' . (int) $productoId . '"';
}

/** Atributos data-* para imagen de galería de producto (solo admin). */
function deportivo_admin_gallery_img(int $imagenId, int $productoId): string
{
    if (empty($GLOBALS['esAdmin'])) {
        return '';
    }

    return ' data-admin-gallery-image="' . (int) $imagenId . '" data-admin-product-id="' . (int) $productoId . '"';
}

/** Clase CSS cuando el usuario es admin. */
function deportivo_admin_body_class(): string
{
    return !empty($GLOBALS['esAdmin']) ? ' admin-mode' : '';
}
