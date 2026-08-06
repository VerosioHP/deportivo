<?php

/**
 * Migración: teléfono en usuarios + tabla password_resets.
 * Ejecutar: php tools/migrate-password-reset.php
 */

require_once dirname(__DIR__) . '/config/database.php';

$tel = $conexion->query("SHOW COLUMNS FROM usuarios LIKE 'telefono'")->fetch();

if (!$tel) {
    $conexion->exec(
        'ALTER TABLE `usuarios`
         ADD COLUMN `telefono` VARCHAR(30) NULL DEFAULT NULL AFTER `email`'
    );
    echo "Columna usuarios.telefono agregada.\n";
} else {
    echo "Columna usuarios.telefono ya existe.\n";
}

$tabla = $conexion->query("SHOW TABLES LIKE 'password_resets'")->fetch();

if (!$tabla) {
    $conexion->exec(
        "CREATE TABLE `password_resets` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `usuario_id` INT NOT NULL,
            `canal` ENUM('email','sms') NOT NULL,
            `destino` VARCHAR(180) NOT NULL,
            `codigo_hash` VARCHAR(255) NOT NULL,
            `intentos` TINYINT UNSIGNED NOT NULL DEFAULT 0,
            `expira_en` DATETIME NOT NULL,
            `usado_en` DATETIME NULL DEFAULT NULL,
            `creado_en` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `usuario_id` (`usuario_id`),
            KEY `canal_destino` (`canal`, `destino`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
    );
    echo "Tabla password_resets creada.\n";
} else {
    echo "Tabla password_resets ya existe.\n";
}

echo "Migración lista.\n";
