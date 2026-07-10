<?php

require_once __DIR__ . '/SmtpMailer.php';
require_once __DIR__ . '/../config/moneda.php';

class MailPedido
{
    public static function enviarNotificacionAdmin(array $pedido): bool
    {
        $config = self::config();
        $adminEmail = $config['admin_email'] ?? '';

        if ($adminEmail === '') {
            return false;
        }

        $pedidoId = (int) $pedido['id'];
        $asunto = "Nuevo pedido #{$pedidoId} — DEPORTIVO";
        $html = self::construirHtmlAdmin($pedido);
        $texto = self::construirTextoAdmin($pedido);

        return SmtpMailer::enviar($config, $adminEmail, $asunto, $html, $texto);
    }

    public static function enviarConfirmacionCliente(array $pedido): bool
    {
        $config = self::config();
        $emailCliente = trim($pedido['email'] ?? '');

        if ($emailCliente === '' || !filter_var($emailCliente, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $pedidoId = (int) $pedido['id'];
        $asunto = "Tu pedido #{$pedidoId} fue recibido — DEPORTIVO";
        $html = self::construirHtmlCliente($pedido);
        $texto = self::construirTextoCliente($pedido);

        return SmtpMailer::enviar($config, $emailCliente, $asunto, $html, $texto);
    }

    public static function enviarPedidoEnCamino(array $pedido): bool
    {
        $config = self::config();
        $emailCliente = trim($pedido['email'] ?? '');

        if ($emailCliente === '' || !filter_var($emailCliente, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $pedidoId = (int) $pedido['id'];
        $asunto = "Tu pedido #{$pedidoId} va en camino — DEPORTIVO";
        $html = self::construirHtmlEnCamino($pedido);
        $texto = self::construirTextoEnCamino($pedido);

        return SmtpMailer::enviar($config, $emailCliente, $asunto, $html, $texto);
    }

    public static function notificarPedidoNuevo(int $pedidoId): array
    {
        require_once __DIR__ . '/../models/Pedido.php';

        $pedido = Pedido::obtenerPorId($pedidoId);

        if (!$pedido) {
            return ['admin' => false, 'cliente' => false];
        }

        return [
            'admin' => self::enviarNotificacionAdmin($pedido),
            'cliente' => self::enviarConfirmacionCliente($pedido),
        ];
    }

    private static function encabezadoTablaItemsHtml(): string
    {
        return <<<'HTML'
            <tr style="background:#f5f5f5;">
                <th align="left">Producto</th>
                <th align="left">Color</th>
                <th align="left">Talla</th>
                <th align="center">Cant.</th>
                <th align="right">Precio</th>
                <th align="right">Subtotal</th>
            </tr>
HTML;
    }

    private static function construirHtmlAdmin(array $pedido): string
    {
        $pedidoId = (int) $pedido['id'];
        $tablaEncabezado = self::encabezadoTablaItemsHtml();
        $itemsHtml = self::construirFilasItemsHtml($pedido['items'] ?? []);
        $notasHtml = !empty($pedido['notas'])
            ? '<p><strong>Notas:</strong> ' . htmlspecialchars($pedido['notas']) . '</p>'
            : '';
        $subtotal = deportivo_formatear_precio((float) $pedido['subtotal']);
        $envio = deportivo_formatear_precio((float) $pedido['envio']);
        $total = deportivo_formatear_precio((float) $pedido['total']);

        return <<<HTML
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"></head>
<body style="font-family: Arial, sans-serif; color: #1a1a1a; line-height: 1.5;">
    <h2 style="color: #c9a227;">Nuevo pedido #{$pedidoId}</h2>
    <p>Se ha registrado un nuevo pedido en la tienda.</p>

    <h3>Cliente</h3>
    <p>
        <strong>{$pedido['nombre']} {$pedido['apellido']}</strong><br>
        Email: {$pedido['email']}<br>
        Teléfono: {$pedido['telefono']}
    </p>

    <h3>Dirección de envío</h3>
    <p>
        {$pedido['direccion']}<br>
        {$pedido['codigo_postal']} {$pedido['ciudad']}, {$pedido['provincia']}
    </p>
    {$notasHtml}

    <h3>Productos</h3>
    <table style="width:100%; border-collapse: collapse;" cellpadding="8">
        <thead>
            {$tablaEncabezado}
        </thead>
        <tbody>{$itemsHtml}</tbody>
    </table>

    <p style="margin-top: 20px;">
        <strong>Subtotal:</strong> {$subtotal}<br>
        <strong>Envío:</strong> {$envio}<br>
        <strong style="font-size: 1.1em;">Total: {$total}</strong>
    </p>
</body>
</html>
HTML;
    }

    private static function construirHtmlCliente(array $pedido): string
    {
        $pedidoId = (int) $pedido['id'];
        $nombre = htmlspecialchars($pedido['nombre']);
        $tablaEncabezado = self::encabezadoTablaItemsHtml();
        $itemsHtml = self::construirFilasItemsHtml($pedido['items'] ?? []);
        $notasHtml = !empty($pedido['notas'])
            ? '<p><strong>Notas:</strong> ' . htmlspecialchars($pedido['notas']) . '</p>'
            : '';
        $subtotal = deportivo_formatear_precio((float) $pedido['subtotal']);
        $envio = deportivo_formatear_precio((float) $pedido['envio']);
        $total = deportivo_formatear_precio((float) $pedido['total']);

        return <<<HTML
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"></head>
<body style="font-family: Arial, sans-serif; color: #1a1a1a; line-height: 1.5;">
    <h2 style="color: #c9a227;">¡Gracias por tu pedido, {$nombre}!</h2>
    <p>Hemos recibido tu pedido <strong>#{$pedidoId}</strong>. Te contactaremos pronto para confirmar disponibilidad y envío.</p>

    <h3>Dirección de envío</h3>
    <p>
        {$pedido['nombre']} {$pedido['apellido']}<br>
        {$pedido['direccion']}<br>
        {$pedido['codigo_postal']} {$pedido['ciudad']}, {$pedido['provincia']}<br>
        Tel: {$pedido['telefono']}
    </p>
    {$notasHtml}

    <h3>Resumen del pedido</h3>
    <table style="width:100%; border-collapse: collapse;" cellpadding="8">
        <thead>
            {$tablaEncabezado}
        </thead>
        <tbody>{$itemsHtml}</tbody>
    </table>

    <p style="margin-top: 20px;">
        <strong>Subtotal:</strong> {$subtotal}<br>
        <strong>Envío:</strong> {$envio}<br>
        <strong style="font-size: 1.1em;">Total: {$total}</strong>
    </p>

    <p style="color:#666; font-size:0.9em;">DEPORTIVO — Ropa deportiva</p>
</body>
</html>
HTML;
    }

    private static function construirHtmlEnCamino(array $pedido): string
    {
        $pedidoId = (int) $pedido['id'];
        $nombre = htmlspecialchars($pedido['nombre']);
        $tablaEncabezado = self::encabezadoTablaItemsHtml();
        $itemsHtml = self::construirFilasItemsHtml($pedido['items'] ?? []);
        $total = deportivo_formatear_precio((float) $pedido['total']);

        return <<<HTML
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"></head>
<body style="font-family: Arial, sans-serif; color: #1a1a1a; line-height: 1.5;">
    <h2 style="color: #c9a227;">¡Tu pedido va en camino, {$nombre}!</h2>
    <p>Tu pedido <strong>#{$pedidoId}</strong> ya fue despachado y está en ruta hacia tu dirección.</p>

    <h3>Dirección de entrega</h3>
    <p>
        {$pedido['nombre']} {$pedido['apellido']}<br>
        {$pedido['direccion']}<br>
        {$pedido['codigo_postal']} {$pedido['ciudad']}, {$pedido['provincia']}<br>
        Tel: {$pedido['telefono']}
    </p>

    <h3>Resumen del pedido</h3>
    <table style="width:100%; border-collapse: collapse;" cellpadding="8">
        <thead>
            {$tablaEncabezado}
        </thead>
        <tbody>{$itemsHtml}</tbody>
    </table>

    <p style="margin-top: 20px;">
        <strong style="font-size: 1.1em;">Total: {$total}</strong>
    </p>

    <p>Pronto recibirás tu compra. Si tienes alguna duda, responde a este correo.</p>
    <p style="color:#666; font-size:0.9em;">DEPORTIVO — Ropa deportiva</p>
</body>
</html>
HTML;
    }

    private static function construirTextoEnCamino(array $pedido): string
    {
        $lineas = [];
        $lineas[] = "PEDIDO EN CAMINO #{$pedido['id']}";
        $lineas[] = '';
        $lineas[] = "Hola {$pedido['nombre']},";
        $lineas[] = 'Tu pedido ya fue despachado y va en camino hacia:';
        $lineas[] = $pedido['direccion'];
        $lineas[] = $pedido['codigo_postal'] . ' ' . $pedido['ciudad'] . ', ' . $pedido['provincia'];
        $lineas[] = '';
        $lineas[] = 'PRODUCTOS:';

        foreach ($pedido['items'] ?? [] as $index => $item) {
            $num = $index + 1;
            $cantidad = (int) ($item['cantidad'] ?? 1);
            $linea = "{$num}. {$item['nombre']} | Color: " . ($item['color'] ?? '-') . " | Talla: {$item['talla']} | Cant: {$cantidad}";
            $lineas[] = $linea;
        }

        $lineas[] = '';
        $lineas[] = 'Total: ' . deportivo_formatear_precio((float) $pedido['total']);
        $lineas[] = '';
        $lineas[] = 'DEPORTIVO — Ropa deportiva';

        return implode("\n", $lineas);
    }

    private static function construirFilasItemsHtml(array $items): string
    {
        $filas = '';

        foreach ($items as $item) {
            $nombre = htmlspecialchars($item['nombre'] ?? 'Producto');
            $color = self::etiquetaColorHtml($item['color'] ?? null);
            $talla = htmlspecialchars($item['talla'] ?? '-');
            $cantidad = (int) ($item['cantidad'] ?? 1);
            $precio = deportivo_formatear_precio((float) ($item['precio'] ?? 0));
            $subtotal = deportivo_formatear_precio((float) ($item['precio'] ?? 0) * $cantidad);

            $filas .= "<tr style=\"border-bottom:1px solid #eee;\">
                <td>{$nombre}</td>
                <td>{$color}</td>
                <td>{$talla}</td>
                <td align=\"center\">{$cantidad}</td>
                <td align=\"right\">{$precio}</td>
                <td align=\"right\">{$subtotal}</td>
            </tr>";
        }

        return $filas;
    }

    private static function construirTextoAdmin(array $pedido): string
    {
        return self::construirTextoPedido($pedido, 'NUEVO PEDIDO');
    }

    private static function construirTextoCliente(array $pedido): string
    {
        return self::construirTextoPedido($pedido, 'CONFIRMACIÓN DE PEDIDO');
    }

    private static function construirTextoPedido(array $pedido, string $titulo): string
    {
        $lineas = [];
        $lineas[] = "{$titulo} #{$pedido['id']}";
        $lineas[] = '';
        $lineas[] = 'Cliente: ' . $pedido['nombre'] . ' ' . $pedido['apellido'];
        $lineas[] = 'Email: ' . $pedido['email'];
        $lineas[] = 'Teléfono: ' . $pedido['telefono'];
        $lineas[] = '';
        $lineas[] = 'Dirección: ' . $pedido['direccion'];
        $lineas[] = $pedido['codigo_postal'] . ' ' . $pedido['ciudad'] . ', ' . $pedido['provincia'];

        if (!empty($pedido['notas'])) {
            $lineas[] = 'Notas: ' . $pedido['notas'];
        }

        $lineas[] = '';
        $lineas[] = 'PRODUCTOS:';

        foreach ($pedido['items'] ?? [] as $index => $item) {
            $num = $index + 1;
            $cantidad = (int) ($item['cantidad'] ?? 1);
            $precio = (float) ($item['precio'] ?? 0);
            $lineas[] = "{$num}. {$item['nombre']} | Color: " . ($item['color'] ?? '-') . " | Talla: {$item['talla']} | Cant: {$cantidad} | " . deportivo_formatear_precio($precio);
        }

        $lineas[] = '';
        $lineas[] = 'Subtotal: ' . deportivo_formatear_precio((float) $pedido['subtotal']);
        $lineas[] = 'Envío: ' . deportivo_formatear_precio((float) $pedido['envio']);
        $lineas[] = 'Total: ' . deportivo_formatear_precio((float) $pedido['total']);

        return implode("\n", $lineas);
    }

    private static function etiquetaColorHtml(?string $color): string
    {
        $nombre = trim((string) $color);
        if ($nombre === '') {
            return '-';
        }

        require_once __DIR__ . '/../models/Producto.php';
        $hex = htmlspecialchars(Producto::colorHex($nombre));
        $texto = htmlspecialchars($nombre);

        return '<span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:'
            . $hex
            . ';border:1px solid #c7c6ca;vertical-align:middle;margin-right:6px;"></span>'
            . $texto;
    }

    private static function config(): array
    {
        static $config = null;

        if ($config === null) {
            $config = require __DIR__ . '/../config/mail.php';
        }

        return $config;
    }
}
