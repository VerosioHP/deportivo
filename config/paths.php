<?php

if (!defined('DEPORTIVO_ROOT')) {
    define('DEPORTIVO_ROOT', dirname(__DIR__));
}

/**
 * Ruta web desde la raíz del sitio hasta la carpeta del proyecto (ej. '' o '/deportivo').
 */
function deportivo_web_base(): string
{
    static $base = null;

    if ($base !== null) {
        return $base;
    }

    $docRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? DEPORTIVO_ROOT);
    $projectRoot = realpath(DEPORTIVO_ROOT);

    if ($docRoot && $projectRoot) {
        $docRoot = str_replace('\\', '/', $docRoot);
        $projectRoot = str_replace('\\', '/', $projectRoot);

        if (str_starts_with($projectRoot, $docRoot)) {
            $base = substr($projectRoot, strlen($docRoot));

            return $base === '' ? '' : rtrim($base, '/');
        }
    }

    $base = '';

    return $base;
}

/**
 * Resuelve rutas web relativas según la ubicación del script que ejecuta la petición.
 */
function deportivo_init_paths(?string $scriptFile = null): array
{
    $scriptFile = $scriptFile ?? ($_SERVER['SCRIPT_FILENAME'] ?? '');
    $scriptDir = str_replace('\\', '/', dirname($scriptFile));
    $root = str_replace('\\', '/', DEPORTIVO_ROOT);

    $suffix = '';
    if (str_starts_with($scriptDir, $root)) {
        $suffix = ltrim(substr($scriptDir, strlen($root)), '/');
    }

    $segments = $suffix !== '' ? explode('/', $suffix) : [];
    $depth = count($segments);
    $rootRel = $depth > 0 ? str_repeat('../', $depth) : '';

    $inClientePages = str_contains($suffix, 'views/cliente/views');
    $inClienteHome = $suffix === 'views/cliente';
    $inAdminViews = str_contains($suffix, 'views/administrador/views');
    $inAdminControllers = str_contains($suffix, 'views/administrador/controllers');

    if ($inAdminViews) {
        $clienteHomeUrl = $rootRel . 'views/cliente/index.php';
        $clientePagesPrefix = $rootRel . 'views/cliente/views/';
        $adminPagesPrefix = '';
    } elseif ($inClientePages) {
        $clienteHomeUrl = '../index.php';
        $clientePagesPrefix = '';
        $adminPagesPrefix = $rootRel . 'views/administrador/views/';
    } elseif ($inClienteHome) {
        $clienteHomeUrl = 'index.php';
        $clientePagesPrefix = 'views/';
        $adminPagesPrefix = $rootRel . 'views/administrador/views/';
    } else {
        $clienteHomeUrl = $rootRel . 'views/cliente/index.php';
        $clientePagesPrefix = $rootRel . 'views/cliente/views/';
        $adminPagesPrefix = $rootRel . 'views/administrador/views/';
    }

    $webBase = deportivo_web_base();
    $adminApiBase = ($webBase === '' ? '' : $webBase) . '/views/administrador/controllers/';

    return [
        'root_rel' => $rootRel,
        'asset_base' => $rootRel,
        'web_base' => $webBase,
        'cliente_base' => $rootRel . 'views/cliente/',
        'cliente_pages_prefix' => $clientePagesPrefix,
        'cliente_home_url' => $clienteHomeUrl,
        'cliente_views' => $rootRel . 'views/cliente/views/',
        'admin_views' => $rootRel . 'views/administrador/views/',
        'admin_pages_prefix' => $adminPagesPrefix,
        'cliente_includes' => $rootRel . 'views/cliente/includes/',
        'admin_includes' => $rootRel . 'views/administrador/includes/',
        'admin_controllers' => $rootRel . 'views/administrador/controllers/',
        'admin_controllers_abs' => $adminApiBase,
        'cliente_controllers' => $rootRel . 'views/cliente/controllers/',
        'admin_js' => $rootRel . 'views/administrador/js/',
        'admin_css' => $rootRel . 'views/administrador/css/',
        'cliente_js' => $rootRel . 'views/cliente/js/',
        'uploads_base' => $rootRel,
        'in_cliente_views' => $inClientePages,
        'in_cliente_home' => $inClienteHome,
        'in_admin_views' => $inAdminViews,
        'in_admin_controllers' => $inAdminControllers,
        'fs_root' => $root,
        'fs_cliente' => $root . '/views/cliente',
        'fs_admin' => $root . '/views/administrador',
        'fs_includes' => $root . '/includes',
    ];
}

function deportivo_cliente_url(string $page): string
{
    global $cliente_pages_prefix;

    return ($cliente_pages_prefix ?? '') . ltrim($page, '/');
}

function deportivo_admin_url(string $page): string
{
    global $admin_pages_prefix;

    return ($admin_pages_prefix ?? '') . ltrim($page, '/');
}

/**
 * URL pública de un archivo en uploads/ (absoluta desde la raíz del sitio).
 */
function deportivo_upload_url(string $ruta): string
{
    if ($ruta === '') {
        return '';
    }

    if (preg_match('#^https?://#i', $ruta) || str_starts_with($ruta, '//')) {
        return $ruta;
    }

    if (str_starts_with($ruta, '/')) {
        return $ruta;
    }

    $webBase = deportivo_web_base();
    $path = ltrim(str_replace('\\', '/', $ruta), '/');

    return ($webBase === '' ? '' : $webBase) . '/' . $path;
}
