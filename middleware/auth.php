<?php
//Este middleware verifica: 
//Que exista sesión.
//Que el usuario exista realmente en la BD.
//Que no haya sido eliminado.
session_start();

require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['usuario_id'])) {

    header("Location: ../views/login.php");
    exit;
}

$sql = "
SELECT id,nombre,email,rol
FROM usuarios
WHERE id = :id
LIMIT 1
";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    ':id' => $_SESSION['usuario_id']
]);

$usuario = $stmt->fetch();

if (!$usuario) {

    session_destroy();

    header("Location: ../views/login.php");
    exit;
}