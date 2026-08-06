<?php

$authInViews = true;
require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/models/PasswordReset.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Método no permitido.']);
    exit;
}

$accion = trim((string) ($_POST['accion'] ?? ''));

try {
    $resultado = match ($accion) {
        'solicitar' => PasswordReset::solicitar(
            (string) ($_POST['canal'] ?? 'email'),
            (string) ($_POST['destino'] ?? '')
        ),
        'verificar' => PasswordReset::verificarCodigo((string) ($_POST['codigo'] ?? '')),
        'actualizar' => PasswordReset::actualizarPassword(
            (string) ($_POST['password'] ?? ''),
            (string) ($_POST['password2'] ?? '')
        ),
        default => ['ok' => false, 'error' => 'Acción no válida.'],
    };
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Error del servidor. Intenta de nuevo.']);
    exit;
}

echo json_encode($resultado);
