<?php
/**
 * Migración: fecha_nacimiento en usuarios (analytics + cumpleaños VEMA).
 */
require_once dirname(__DIR__) . '/config/database.php';

$col = $conexion->query("SHOW COLUMNS FROM usuarios LIKE 'fecha_nacimiento'")->fetch();
if (!$col) {
    $conexion->exec(
        'ALTER TABLE `usuarios`
         ADD COLUMN `fecha_nacimiento` DATE NULL DEFAULT NULL AFTER `telefono`'
    );
    echo "Columna usuarios.fecha_nacimiento agregada.\n";
} else {
    echo "Columna usuarios.fecha_nacimiento ya existe.\n";
}
