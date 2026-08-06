<?php

require_once dirname(__DIR__, 3) . '/config/database.php';
require_once dirname(__DIR__, 3) . '/includes/SmsSender.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit;
}

$nombre = trim((string) ($_POST['nombre'] ?? ''));
$apellido = trim((string) ($_POST['apellido'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$password = trim((string) ($_POST['password'] ?? ''));
$fechaNacimiento = trim((string) ($_POST['fecha_nacimiento'] ?? ''));
$telefonoRaw = trim((string) ($_POST['telefono'] ?? ''));
$telefono = $telefonoRaw !== '' ? SmsSender::normalizarTelefono($telefonoRaw) : null;

if ($nombre === '' || $apellido === '' || $email === '' || $password === '' || $fechaNacimiento === '') {
    header('Location: ../views/login.php?error=datos_incompletos');
    exit;
}

if (strlen($password) < 8) {
    header('Location: ../views/login.php?error=password_corta');
    exit;
}

$nacimiento = DateTimeImmutable::createFromFormat('Y-m-d', $fechaNacimiento);
$nacimientoOk = $nacimiento && $nacimiento->format('Y-m-d') === $fechaNacimiento;
$minAge = (new DateTimeImmutable('today'))->modify('-13 years');
$maxAge = new DateTimeImmutable('1920-01-01');

if (!$nacimientoOk || $nacimiento > $minAge || $nacimiento < $maxAge) {
    header('Location: ../views/login.php?error=fecha_invalida');
    exit;
}

$verificar = $conexion->prepare(
    'SELECT id FROM usuarios WHERE email = :email'
);

$verificar->execute([
    ':email' => $email,
]);

if ($verificar->rowCount() > 0) {
    header('Location: ../views/login.php?error=email_existe');
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$colTel = $conexion->query("SHOW COLUMNS FROM usuarios LIKE 'telefono'")->fetch();
if (!$colTel) {
    $conexion->exec(
        'ALTER TABLE `usuarios` ADD COLUMN `telefono` VARCHAR(30) NULL DEFAULT NULL AFTER `email`'
    );
}

$colNac = $conexion->query("SHOW COLUMNS FROM usuarios LIKE 'fecha_nacimiento'")->fetch();
if (!$colNac) {
    $conexion->exec(
        'ALTER TABLE `usuarios` ADD COLUMN `fecha_nacimiento` DATE NULL DEFAULT NULL AFTER `telefono`'
    );
}

$stmt = $conexion->prepare(
    'INSERT INTO usuarios (nombre, apellido, email, telefono, fecha_nacimiento, password)
     VALUES (:nombre, :apellido, :email, :telefono, :fecha_nacimiento, :password)'
);

$stmt->execute([
    ':nombre' => $nombre,
    ':apellido' => $apellido,
    ':email' => $email,
    ':telefono' => $telefono,
    ':fecha_nacimiento' => $fechaNacimiento,
    ':password' => $passwordHash,
]);

header('Location: ../views/login.php?registro=ok');
exit;
