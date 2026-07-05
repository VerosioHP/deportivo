<?php

/**
 * Configuración de correo (Gmail SMTP).
 *
 * Para Gmail:
 * 1. Activa verificación en 2 pasos en tu cuenta Google.
 * 2. Crea una "Contraseña de aplicación" en https://myaccount.google.com/apppasswords
 * 3. Usa esa contraseña en smtp_pass (sin espacios).
 */

return [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 587,
    'smtp_user' => 'enganchef23@gmail.com',
    'smtp_pass' => 'rosojcyxfogvjjkg',   // Pega aquí tu contraseña de aplicación de Gmail (sin espacios)
    'from_email' => 'enganchef23@gmail.com',
    'from_name' => 'DEPORTIVO',
    'admin_email' => 'enganchef23@gmail.com',
    'enabled' => true,
];
