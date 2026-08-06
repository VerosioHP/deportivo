<?php

class SmsSender
{
    public static function enviar(string $telefono, string $mensaje): bool
    {
        $config = self::config();

        if (empty($config['enabled'])) {
            return false;
        }

        $destino = self::normalizarTelefono($telefono);

        if ($destino === '') {
            return false;
        }

        $driver = $config['driver'] ?? 'log';

        return match ($driver) {
            'twilio' => self::enviarTwilio($destino, $mensaje, $config),
            default => self::enviarLog($destino, $mensaje),
        };
    }

    public static function normalizarTelefono(string $telefono): string
    {
        $digitos = preg_replace('/\D+/', '', $telefono) ?? '';

        if ($digitos === '') {
            return '';
        }

        // Colombia: si llega de 10 dígitos empezando en 3, anteponer 57
        if (strlen($digitos) === 10 && str_starts_with($digitos, '3')) {
            $digitos = '57' . $digitos;
        }

        return $digitos;
    }

    private static function enviarLog(string $destino, string $mensaje): bool
    {
        $dir = dirname(__DIR__) . '/data';

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $linea = sprintf(
            "[%s] to=+%s | %s%s",
            date('Y-m-d H:i:s'),
            $destino,
            $mensaje,
            PHP_EOL
        );

        return file_put_contents($dir . '/sms-log.txt', $linea, FILE_APPEND) !== false;
    }

    private static function enviarTwilio(string $destino, string $mensaje, array $config): bool
    {
        $sid = trim((string) ($config['twilio']['account_sid'] ?? ''));
        $token = trim((string) ($config['twilio']['auth_token'] ?? ''));
        $from = trim((string) ($config['twilio']['from'] ?? ($config['from'] ?? '')));

        if ($sid === '' || $token === '' || $from === '') {
            return self::enviarLog($destino, '[twilio-fallback] ' . $mensaje);
        }

        $url = 'https://api.twilio.com/2010-04-01/Accounts/' . rawurlencode($sid) . '/Messages.json';
        $body = http_build_query([
            'To' => '+' . $destino,
            'From' => $from,
            'Body' => $mensaje,
        ]);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => $sid . ':' . $token,
            CURLOPT_TIMEOUT => 20,
        ]);
        $response = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $response !== false && $status >= 200 && $status < 300;
    }

    private static function config(): array
    {
        static $config;

        if ($config === null) {
            $path = dirname(__DIR__) . '/config/sms.php';
            $config = is_file($path) ? require $path : ['enabled' => false, 'driver' => 'log'];
        }

        return $config;
    }
}
