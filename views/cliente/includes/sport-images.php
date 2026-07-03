<?php

require_once dirname(__DIR__, 3) . '/models/SitioImagen.php';

/**
 * URLs de imágenes del sitio (Unsplash por defecto + overrides del admin).
 */
function deportivo_img(string $key, string $size = 'lg', bool $desdeVistas = false): string
{
    static $images = [
        'hero_main'           => 'photo-1476480862126-209bfaa8edc8',
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
        'nosotros_hero'       => 'photo-1502904550040-7534597429ae',
        'nosotros_tejido'     => 'photo-1571019614242-c5c5dee9f50b',
        'nosotros_gym'        => 'photo-1534438327276-14e5300c3a48',
        'login_side'          => 'photo-1571019614242-c5c5dee9f50b',
        'catalogo_camisetas'  => 'photo-1521572163474-6864f9cf17ab',
        'catalogo_pantalonetas' => 'photo-1552674605-db6ffd4facb5',
    ];

    $override = SitioImagen::obtener($key);

    if ($override !== null) {
        return SitioImagen::urlPublica($override, $desdeVistas);
    }

    $widths = ['xs' => 200, 'sm' => 500, 'md' => 900, 'lg' => 1200, 'xl' => 1920];
    $w = $widths[$size] ?? 1200;
    $photo = $images[$key] ?? $images['running'];

    return "https://images.unsplash.com/{$photo}?w={$w}&q=85&auto=format&fit=crop";
}

function deportivo_sport_cards(): array
{
    return [
        ['num' => '01', 'name' => 'Running',  'key' => 'running',    'alt' => 'Corredor en carretera al amanecer'],
        ['num' => '02', 'name' => 'Gym',      'key' => 'gym',        'alt' => 'Entrenamiento de fuerza en gimnasio'],
        ['num' => '03', 'name' => 'Básquet',  'key' => 'basketball', 'alt' => 'Jugador de baloncesto en cancha'],
        ['num' => '04', 'name' => 'Tenis',    'key' => 'tennis',     'alt' => 'Jugador de tenis en pista'],
        ['num' => '05', 'name' => 'Ciclismo', 'key' => 'cycling',    'alt' => 'Ciclistas en carretera'],
        ['num' => '06', 'name' => 'Yoga',     'key' => 'yoga',       'alt' => 'Persona practicando yoga'],
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
