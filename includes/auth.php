<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuarioLogueado = isset($_SESSION['usuario_id']);
$esAdmin = $usuarioLogueado && ($_SESSION['rol'] ?? '') === 'admin';
$usuarioNombre = trim($_SESSION['nombre'] ?? '');
$usuarioEmail = $_SESSION['email'] ?? '';
$usuarioRol = $_SESSION['rol'] ?? '';

$authInViews = $authInViews ?? false;
$siteRoot = $authInViews ? '..' : '.';
$controllersPath = $authInViews ? '../controllers/' : 'controllers/';
$viewsPath = $authInViews ? '' : 'views/';

define('MAJESTIC_AUTH_LOADED', true);

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
