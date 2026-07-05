<?php

require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../config/moneda.php';

if (session_status() === PHP_SESSION_NONE) {
    $cookiePath = deportivo_web_base();
    $cookiePath = $cookiePath === '' ? '/' : $cookiePath . '/';

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => $cookiePath,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

$deportivoPaths = deportivo_init_paths();
extract($deportivoPaths, EXTR_SKIP);

$assetBase = $asset_base;
$rootRel = $root_rel;
$clienteBase = $cliente_base;
$clientePagesPrefix = $cliente_pages_prefix;
$clienteHomeUrl = $cliente_home_url;
$clienteViewsPath = $cliente_views;
$adminViewsPath = $admin_views;
$adminPagesPrefix = $admin_pages_prefix;
$clienteIncludesPath = $cliente_includes;
$adminIncludesPath = $admin_includes;
$adminControllersPath = $admin_controllers_abs ?? $admin_controllers;
$clienteControllersPath = $cliente_controllers;
$adminJsPath = $admin_js;
$adminCssPath = $admin_css;
$clienteJsPath = $cliente_js;
$uploadsBasePath = $uploads_base;

$GLOBALS['cliente_pages_prefix'] = $cliente_pages_prefix;
$GLOBALS['admin_pages_prefix'] = $admin_pages_prefix;

$authInViews = $in_cliente_views || $in_admin_views;
$navInViews = $in_cliente_views || $in_admin_views;
$siteRoot = $root_rel ?: '.';
$controllersPath = $admin_controllers;
$viewsPath = $cliente_views;

$usuarioLogueado = isset($_SESSION['usuario_id']);
$esAdmin = $usuarioLogueado && ($_SESSION['rol'] ?? '') === 'admin';
$usuarioNombre = trim($_SESSION['nombre'] ?? '');
$usuarioEmail = $_SESSION['email'] ?? '';
$usuarioRol = $_SESSION['rol'] ?? '';

if (!defined('MAJESTIC_AUTH_LOADED')) {
    define('MAJESTIC_AUTH_LOADED', true);
}

function requerirAdmin(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode(['ok' => false, 'error' => 'Acceso denegado. Se requiere rol administrador.']);
        exit;
    }
}
