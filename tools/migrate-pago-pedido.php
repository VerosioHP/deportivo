<?php

/**
 * Agrega columnas de zona de envío, método de pago y comprobante a pedidos.
 */

require_once dirname(__DIR__) . '/config/database.php';

$columnas = [
    'zona_envio' => "ENUM('metropolitana','nacional') NULL DEFAULT NULL AFTER `provincia`",
    'metodo_pago' => "ENUM('contraentrega','transferencia') NULL DEFAULT NULL AFTER `estado`",
    'comprobante_pago' => "VARCHAR(255) NULL DEFAULT NULL AFTER `metodo_pago`",
];

foreach ($columnas as $nombre => $definicion) {
    $existe = $conexion->query("SHOW COLUMNS FROM pedidos LIKE " . $conexion->quote($nombre))->fetch();

    if ($existe) {
        echo "Columna {$nombre} ya existe.\n";
        continue;
    }

    $conexion->exec("ALTER TABLE `pedidos` ADD COLUMN `{$nombre}` {$definicion}");
    echo "Columna {$nombre} agregada.\n";
}

echo "Migración de pago completada.\n";
