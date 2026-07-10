<?php

/**
 * Migración segura: agrega columna `numero` sin borrar datos existentes.
 * Solo ejecuta ALTER TABLE y UPDATE en filas sin número.
 */

require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/models/Pedido.php';

$columna = $conexion->query("SHOW COLUMNS FROM pedidos LIKE 'numero'")->fetch();

if (!$columna) {
    $conexion->exec('ALTER TABLE `pedidos` ADD COLUMN `numero` CHAR(5) NULL AFTER `id`');
    echo "Columna numero agregada.\n";
} else {
    echo "Columna numero ya existe.\n";
}

$pendientes = $conexion->query(
    "SELECT id FROM pedidos WHERE numero IS NULL OR numero = ''"
)->fetchAll(PDO::FETCH_COLUMN);

foreach ($pendientes as $id) {
    $numero = Pedido::generarNumeroUnico();
    $stmt = $conexion->prepare('UPDATE pedidos SET numero = :numero WHERE id = :id');
    $stmt->execute([':numero' => $numero, ':id' => (int) $id]);
    echo "Pedido id {$id} → numero {$numero}\n";
}

if (count($pendientes) === 0) {
    echo "Todos los pedidos ya tienen numero.\n";
}

$indice = $conexion->query("SHOW INDEX FROM pedidos WHERE Key_name = 'numero'")->fetch();

if (!$indice) {
    $conexion->exec('ALTER TABLE `pedidos` MODIFY COLUMN `numero` CHAR(5) NOT NULL');
    $conexion->exec('ALTER TABLE `pedidos` ADD UNIQUE KEY `numero` (`numero`)');
    echo "Restricción única aplicada.\n";
} else {
    echo "Índice único ya existe.\n";
}

echo "Listo. Pedidos en BD: " . $conexion->query('SELECT COUNT(*) FROM pedidos')->fetchColumn() . "\n";
