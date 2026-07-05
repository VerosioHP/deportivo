<?php

require_once dirname(__DIR__, 3) . '/includes/auth.php';
require_once dirname(__DIR__, 3) . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/login.php');
    exit;
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";

$stmt = $conexion->prepare($sql);

$stmt->bindParam(
    ':email',
    $email,
    PDO::PARAM_STR
);

$stmt->execute();

$usuario = $stmt->fetch();

if (
    $usuario &&
    password_verify(
        $password,
        $usuario['password']
    )
) {

    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['nombre'] = $usuario['nombre'];
    $_SESSION['apellido'] = $usuario['apellido'] ?? '';
    $_SESSION['email'] = $usuario['email'];
    $_SESSION['rol'] = $usuario['rol'];

    header('Location: ../index.php');
    exit;
}

header('Location: ../views/login.php?error=credenciales');
exit;
