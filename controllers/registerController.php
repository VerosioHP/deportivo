<?php

require_once "../config/database.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit;
}

$nombre = trim($_POST['nombre']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);

$verificar = $conexion->prepare(
    "SELECT id FROM usuarios WHERE email = :email"
);

$verificar->execute([
    ':email' => $email
]);

if ($verificar->rowCount() > 0) {

    header(
        "Location: ../views/login.php?error=email_existe"
    );

    exit;
}

$passwordHash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$sql = "
INSERT INTO usuarios
(
    nombre,
    email,
    password
)
VALUES
(
    :nombre,
    :email,
    :password
)
";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    ':nombre' => $nombre,
    ':email' => $email,
    ':password' => $passwordHash
]);

header(
    "Location: ../views/login.php?registro=ok"
);

exit;