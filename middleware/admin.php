<?php

session_start();

require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['usuario_id'])) {

    header("Location: ../views/login.php");
    exit;
}

$sql = "
SELECT rol
FROM usuarios
WHERE id = :id
LIMIT 1
";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    ':id' => $_SESSION['usuario_id']
]);

$usuario = $stmt->fetch();

if (!$usuario || $usuario['rol'] !== 'admin') {

    header("Location: ../dashboard.php");
    exit;
}