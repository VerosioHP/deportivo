<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/SmtpMailer.php';
require_once __DIR__ . '/../includes/SmsSender.php';

class PasswordReset
{
    private const TTL_MINUTOS = 15;
    private const MAX_INTENTOS = 5;

    public static function ensureSchema(): void
    {
        global $conexion;
        static $ready = false;

        if ($ready) {
            return;
        }

        $tel = $conexion->query("SHOW COLUMNS FROM usuarios LIKE 'telefono'")->fetch();
        if (!$tel) {
            $conexion->exec(
                'ALTER TABLE `usuarios`
                 ADD COLUMN `telefono` VARCHAR(30) NULL DEFAULT NULL AFTER `email`'
            );
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
        }

        $ready = true;
    }

    public static function solicitar(string $canal, string $destino): array
    {
        self::ensureSchema();
        global $conexion;

        $canal = $canal === 'sms' ? 'sms' : 'email';
        $destino = trim($destino);

        if ($canal === 'email') {
            if ($destino === '' || !filter_var($destino, FILTER_VALIDATE_EMAIL)) {
                return ['ok' => false, 'error' => 'Ingresa el correo con el que te registraste.'];
            }
            $usuario = self::buscarPorEmail(strtolower($destino));
            $destinoEnvio = strtolower($destino);
        } else {
            $normalizado = SmsSender::normalizarTelefono($destino);
            if (strlen($normalizado) < 10) {
                return ['ok' => false, 'error' => 'Ingresa el celular con el que te registraste.'];
            }
            $usuario = self::buscarPorTelefono($normalizado);
            $destinoEnvio = $normalizado;
        }

        if (!$usuario) {
            return [
                'ok' => false,
                'error' => $canal === 'email'
                    ? 'No encontramos una cuenta VEMA con ese correo. Revisa el dato o crea una cuenta.'
                    : 'No encontramos una cuenta VEMA con ese celular. Revisa el dato o crea una cuenta.',
            ];
        }

        // Si identificó por correo, el código va al email de la cuenta.
        // Si identificó por celular, el código va por SMS al teléfono registrado.
        if ($canal === 'email') {
            $destinoEnvio = (string) $usuario['email'];
        } else {
            $telCuenta = SmsSender::normalizarTelefono((string) ($usuario['telefono'] ?? ''));
            if ($telCuenta === '' || strlen($telCuenta) < 10) {
                return [
                    'ok' => false,
                    'error' => 'Esa cuenta no tiene un celular registrado. Recupera con el correo.',
                ];
            }
            $destinoEnvio = $telCuenta;
        }

        $codigo = (string) random_int(100000, 999999);
        $hash = password_hash($codigo, PASSWORD_DEFAULT);
        $expira = (new DateTimeImmutable('+' . self::TTL_MINUTOS . ' minutes'))->format('Y-m-d H:i:s');

        $conexion->prepare(
            'UPDATE password_resets SET usado_en = NOW()
             WHERE usuario_id = :uid AND usado_en IS NULL'
        )->execute([':uid' => (int) $usuario['id']]);

        $stmt = $conexion->prepare(
            'INSERT INTO password_resets (usuario_id, canal, destino, codigo_hash, expira_en)
             VALUES (:uid, :canal, :destino, :hash, :expira)'
        );
        $stmt->execute([
            ':uid' => (int) $usuario['id'],
            ':canal' => $canal,
            ':destino' => $destinoEnvio,
            ':hash' => $hash,
            ':expira' => $expira,
        ]);

        $resetId = (int) $conexion->lastInsertId();
        $enviado = $canal === 'email'
            ? self::enviarEmail($destinoEnvio, $codigo, (string) ($usuario['nombre'] ?? ''))
            : self::enviarSms($destinoEnvio, $codigo);

        if (!$enviado) {
            return [
                'ok' => false,
                'error' => $canal === 'email'
                    ? 'Encontramos tu cuenta, pero no pudimos enviar el correo. Intenta más tarde.'
                    : 'Encontramos tu cuenta, pero no pudimos enviar el SMS. Intenta con el correo.',
            ];
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $destinoMask = self::enmascarar($canal, $destinoEnvio);

        $_SESSION['password_reset'] = [
            'reset_id' => $resetId,
            'usuario_id' => (int) $usuario['id'],
            'canal' => $canal,
            'destino_mask' => $destinoMask,
            'verificado' => false,
        ];

        return [
            'ok' => true,
            'mensaje' => 'Cuenta encontrada. Te enviamos un código de verificación.',
            'canal' => $canal,
            'destino_mask' => $destinoMask,
        ];
    }

    public static function verificarCodigo(string $codigo): array
    {
        self::ensureSchema();
        global $conexion;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $estado = $_SESSION['password_reset'] ?? null;
        if (!$estado || empty($estado['reset_id'])) {
            return ['ok' => false, 'error' => 'Código incorrecto o sesión expirada. Solicita uno nuevo.'];
        }

        $codigo = trim($codigo);
        if (!preg_match('/^\d{6}$/', $codigo)) {
            return ['ok' => false, 'error' => 'El código debe tener 6 dígitos.'];
        }

        $stmt = $conexion->prepare(
            'SELECT * FROM password_resets WHERE id = :id LIMIT 1'
        );
        $stmt->execute([':id' => (int) $estado['reset_id']]);
        $row = $stmt->fetch();

        if (!$row || $row['usado_en'] !== null) {
            return ['ok' => false, 'error' => 'El código ya no es válido. Solicita uno nuevo.'];
        }

        if (strtotime((string) $row['expira_en']) < time()) {
            return ['ok' => false, 'error' => 'El código expiró. Solicita uno nuevo.'];
        }

        if ((int) $row['intentos'] >= self::MAX_INTENTOS) {
            return ['ok' => false, 'error' => 'Demasiados intentos. Solicita un código nuevo.'];
        }

        if (!password_verify($codigo, (string) $row['codigo_hash'])) {
            $conexion->prepare(
                'UPDATE password_resets SET intentos = intentos + 1 WHERE id = :id'
            )->execute([':id' => (int) $row['id']]);

            return ['ok' => false, 'error' => 'Código incorrecto.'];
        }

        $_SESSION['password_reset']['verificado'] = true;

        return ['ok' => true, 'mensaje' => 'Código verificado. Ahora elige tu nueva contraseña.'];
    }

    public static function actualizarPassword(string $password, string $password2): array
    {
        self::ensureSchema();
        global $conexion;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $estado = $_SESSION['password_reset'] ?? null;
        if (!$estado || empty($estado['verificado']) || empty($estado['usuario_id']) || empty($estado['reset_id'])) {
            return ['ok' => false, 'error' => 'Debes verificar el código antes de cambiar la contraseña.'];
        }

        $password = trim($password);
        $password2 = trim($password2);

        if (strlen($password) < 6) {
            return ['ok' => false, 'error' => 'La contraseña debe tener al menos 6 caracteres.'];
        }

        if ($password !== $password2) {
            return ['ok' => false, 'error' => 'Las contraseñas no coinciden.'];
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $upd = $conexion->prepare('UPDATE usuarios SET password = :p WHERE id = :id');
        $ok = $upd->execute([
            ':p' => $hash,
            ':id' => (int) $estado['usuario_id'],
        ]);

        if (!$ok) {
            return ['ok' => false, 'error' => 'No se pudo actualizar la contraseña.'];
        }

        $conexion->prepare(
            'UPDATE password_resets SET usado_en = NOW() WHERE id = :id'
        )->execute([':id' => (int) $estado['reset_id']]);

        unset($_SESSION['password_reset']);

        return ['ok' => true, 'mensaje' => 'Contraseña actualizada. Ya puedes iniciar sesión.'];
    }

    private static function buscarPorEmail(string $email): ?array
    {
        global $conexion;
        $stmt = $conexion->prepare(
            'SELECT id, nombre, email, telefono FROM usuarios WHERE LOWER(email) = :email LIMIT 1'
        );
        $stmt->execute([':email' => strtolower($email)]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    private static function buscarPorTelefono(string $normalizado): ?array
    {
        global $conexion;

        // Compara quitando no-dígitos en PHP sobre candidatos recientes sería costoso;
        // guardamos el teléfono normalizado o buscamos coincidencias comunes.
        $stmt = $conexion->query('SELECT id, nombre, email, telefono FROM usuarios WHERE telefono IS NOT NULL AND telefono != \'\'');
        $filas = $stmt->fetchAll();

        foreach ($filas as $fila) {
            if (SmsSender::normalizarTelefono((string) $fila['telefono']) === $normalizado) {
                return $fila;
            }
        }

        return null;
    }

    private static function enviarEmail(string $email, string $codigo, string $nombre): bool
    {
        $path = dirname(__DIR__) . '/config/mail.php';
        if (!is_file($path)) {
            return false;
        }

        $config = require $path;
        $quien = $nombre !== '' ? htmlspecialchars($nombre) : 'hola';
        $html = '
            <div style="font-family:Arial,sans-serif;max-width:520px;margin:0 auto;padding:24px;color:#111">
                <h2 style="margin:0 0 12px">Recuperar contraseña · VEMA</h2>
                <p>Hola ' . $quien . ',</p>
                <p>Tu código de verificación es:</p>
                <p style="font-size:28px;letter-spacing:8px;font-weight:700">' . htmlspecialchars($codigo) . '</p>
                <p>Caduca en ' . self::TTL_MINUTOS . ' minutos. Si no pediste este código, ignora este correo.</p>
            </div>';
        $texto = "Tu código VEMA es {$codigo}. Caduca en " . self::TTL_MINUTOS . " minutos.";

        return SmtpMailer::enviar($config, $email, 'Código para recuperar tu contraseña · VEMA', $html, $texto);
    }

    private static function enviarSms(string $telefono, string $codigo): bool
    {
        $mensaje = 'VEMA: tu codigo de recuperacion es ' . $codigo . '. Valido por ' . self::TTL_MINUTOS . ' min.';

        return SmsSender::enviar($telefono, $mensaje);
    }

    private static function enmascarar(string $canal, string $destino): string
    {
        if ($canal === 'email') {
            [$user, $domain] = array_pad(explode('@', $destino, 2), 2, '');
            $userMask = strlen($user) <= 2
                ? str_repeat('*', max(strlen($user), 1))
                : substr($user, 0, 1) . str_repeat('*', max(strlen($user) - 2, 1)) . substr($user, -1);

            return $userMask . '@' . $domain;
        }

        $len = strlen($destino);
        if ($len <= 4) {
            return str_repeat('*', $len);
        }

        return '+' . str_repeat('*', max($len - 4, 0)) . substr($destino, -4);
    }
}
