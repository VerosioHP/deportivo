<?php

class SmtpMailer
{
    public static function enviar(
        array $config,
        string $destinatario,
        string $asunto,
        string $cuerpoHtml,
        ?string $cuerpoTexto = null
    ): bool {
        if (empty($config['enabled'])) {
            return false;
        }

        $host = $config['smtp_host'] ?? '';
        $port = (int) ($config['smtp_port'] ?? 587);
        $user = $config['smtp_user'] ?? '';
        $pass = $config['smtp_pass'] ?? '';
        $fromEmail = $config['from_email'] ?? $user;
        $fromName = $config['from_name'] ?? 'DEPORTIVO';

        if ($host === '' || $user === '' || $pass === '' || $destinatario === '') {
            return false;
        }

        if ($cuerpoTexto === null) {
            $cuerpoTexto = strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>', '</tr>'], "\n", $cuerpoHtml));
        }

        $boundary = 'b_' . bin2hex(random_bytes(8));
        $mensaje = self::construirMensaje($fromEmail, $fromName, $destinatario, $asunto, $cuerpoHtml, $cuerpoTexto, $boundary);

        $socket = @stream_socket_client(
            "tcp://{$host}:{$port}",
            $errno,
            $errstr,
            30
        );

        if (!$socket) {
            return false;
        }

        stream_set_timeout($socket, 30);

        if (!self::esperarRespuesta($socket, [220])) {
            fclose($socket);
            return false;
        }

        $ehloHost = $_SERVER['SERVER_NAME'] ?? 'localhost';

        self::enviarComando($socket, "EHLO {$ehloHost}");

        if (!self::esperarRespuesta($socket, [250])) {
            fclose($socket);
            return false;
        }

        self::enviarComando($socket, 'STARTTLS');

        if (!self::esperarRespuesta($socket, [220])) {
            fclose($socket);
            return false;
        }

        $cryptoOk = @stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);

        if (!$cryptoOk) {
            fclose($socket);
            return false;
        }

        self::enviarComando($socket, "EHLO {$ehloHost}");

        if (!self::esperarRespuesta($socket, [250])) {
            fclose($socket);
            return false;
        }

        self::enviarComando($socket, 'AUTH LOGIN');

        if (!self::esperarRespuesta($socket, [334])) {
            fclose($socket);
            return false;
        }

        self::enviarComando($socket, base64_encode($user));

        if (!self::esperarRespuesta($socket, [334])) {
            fclose($socket);
            return false;
        }

        self::enviarComando($socket, base64_encode($pass));

        if (!self::esperarRespuesta($socket, [235])) {
            fclose($socket);
            return false;
        }

        self::enviarComando($socket, "MAIL FROM:<{$fromEmail}>");

        if (!self::esperarRespuesta($socket, [250])) {
            fclose($socket);
            return false;
        }

        self::enviarComando($socket, "RCPT TO:<{$destinatario}>");

        if (!self::esperarRespuesta($socket, [250, 251])) {
            fclose($socket);
            return false;
        }

        self::enviarComando($socket, 'DATA');

        if (!self::esperarRespuesta($socket, [354])) {
            fclose($socket);
            return false;
        }

        fwrite($socket, $mensaje . "\r\n.\r\n");

        if (!self::esperarRespuesta($socket, [250])) {
            fclose($socket);
            return false;
        }

        self::enviarComando($socket, 'QUIT');
        fclose($socket);

        return true;
    }

    private static function construirMensaje(
        string $fromEmail,
        string $fromName,
        string $to,
        string $subject,
        string $html,
        string $text,
        string $boundary
    ): string {
        $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        $encodedFromName = '=?UTF-8?B?' . base64_encode($fromName) . '?=';

        $headers = [
            "From: {$encodedFromName} <{$fromEmail}>",
            "To: <{$to}>",
            "Subject: {$encodedSubject}",
            'MIME-Version: 1.0',
            "Content-Type: multipart/alternative; boundary=\"{$boundary}\"",
        ];

        $body = "--{$boundary}\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= chunk_split(base64_encode($text)) . "\r\n";
        $body .= "--{$boundary}\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= chunk_split(base64_encode($html)) . "\r\n";
        $body .= "--{$boundary}--";

        return implode("\r\n", $headers) . "\r\n\r\n" . $body;
    }

    private static function enviarComando($socket, string $comando): void
    {
        fwrite($socket, $comando . "\r\n");
    }

    private static function esperarRespuesta($socket, array $codigosValidos): bool
    {
        $respuesta = '';

        while (($linea = fgets($socket, 515)) !== false) {
            $respuesta .= $linea;

            if (isset($linea[3]) && $linea[3] === ' ') {
                break;
            }
        }

        if ($respuesta === '') {
            return false;
        }

        $codigo = (int) substr($respuesta, 0, 3);

        return in_array($codigo, $codigosValidos, true);
    }
}
