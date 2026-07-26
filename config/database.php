<?php

$host = "localhost";
$dbname = "deportivo";
$user = "root";
$password = "";

try {

    $conexion = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $password
    );

    $conexion->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $conexion->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );

} catch(PDOException $e){

    if (defined('DEPORTIVO_JSON_API') && DEPORTIVO_JSON_API) {
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(500);
        }
        echo json_encode(['ok' => false, 'error' => 'Error de conexión a la base de datos.']);
        exit;
    }

    die("Error de conexión: " . $e->getMessage());

}