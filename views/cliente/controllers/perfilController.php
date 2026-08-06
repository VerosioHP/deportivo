<?php

require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/models/Usuario.php';
require_once dirname(__DIR__, 3) . '/includes/SmsSender.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/perfil.php');
    exit;
}

if (!$usuarioLogueado || empty($_SESSION['usuario_id'])) {
    header('Location: ../views/login.php');
    exit;
}

$usuarioId = (int) $_SESSION['usuario_id'];
$nombre = trim((string) ($_POST['nombre'] ?? ''));
$apellido = trim((string) ($_POST['apellido'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$telefonoRaw = trim((string) ($_POST['telefono'] ?? ''));
$fechaNacimiento = trim((string) ($_POST['fecha_nacimiento'] ?? ''));
$password = trim((string) ($_POST['password'] ?? ''));
$password2 = trim((string) ($_POST['password2'] ?? ''));

$telefono = $telefonoRaw !== '' ? SmsSender::normalizarTelefono($telefonoRaw) : null;

if ($nombre === '' || $apellido === '') {
    header('Location: ../views/perfil.php?error=datos');
    exit;
}

if ($password !== '' && $password !== $password2) {
    header('Location: ../views/perfil.php?error=password');
    exit;
}

try {
    Usuario::actualizarPerfilCliente(
        $usuarioId,
        $nombre,
        $apellido,
        $email,
        $telefono,
        $fechaNacimiento !== '' ? $fechaNacimiento : null,
        $password !== '' ? $password : null
    );
} catch (InvalidArgumentException $e) {
    $code = 'datos';
    $msg = $e->getMessage();
    if (str_contains($msg, 'correo')) {
        $code = 'email';
    } elseif (str_contains($msg, 'nacimiento')) {
        $code = 'fecha';
    } elseif (str_contains($msg, 'contraseña') || str_contains($msg, 'apellido')) {
        $code = str_contains($msg, 'contraseña') ? 'password' : 'datos';
    }
    header('Location: ../views/perfil.php?error=' . urlencode($code));
    exit;
} catch (Throwable $e) {
    header('Location: ../views/perfil.php?error=servidor');
    exit;
}

$_SESSION['nombre'] = $nombre;
$_SESSION['apellido'] = $apellido;
$_SESSION['email'] = $email;

header('Location: ../views/perfil.php?ok=1');
exit;
