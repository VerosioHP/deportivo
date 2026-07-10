<?php

require_once __DIR__ . '/../config/moneda.php';
require_once __DIR__ . '/../models/Producto.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class FacturaPdf
{
    public static function generar(array $pedido): string
    {
        if (!class_exists(Dompdf::class)) {
            throw new RuntimeException('Dompdf no está instalado. Ejecuta: composer install');
        }

        $pedido['items'] = self::prepararItemsParaPdf($pedido['items'] ?? []);
        $html = self::construirHtml($pedido);

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }

    public static function nombreArchivo(array $pedido): string
    {
        return 'factura-deportiva-' . self::slugCliente($pedido) . '.pdf';
    }

    private static function slugCliente(array $pedido): string
    {
        $primerNombre = self::primerPalabra(trim($pedido['nombre'] ?? ''));
        $primerApellido = self::primerPalabra(trim($pedido['apellido'] ?? ''));
        $base = trim($primerNombre . ' ' . $primerApellido);
        $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $base), '-'));

        return $slug !== '' ? $slug : 'cliente';
    }

    private static function primerPalabra(string $texto): string
    {
        if ($texto === '') {
            return '';
        }

        $partes = preg_split('/\s+/u', $texto);

        return $partes[0] ?? '';
    }

    private static function construirHtml(array $pedido): string
    {
        $pedidoId = (int) $pedido['id'];
        $fecha = self::formatearFecha($pedido['fecha_creacion'] ?? '');
        $cliente = htmlspecialchars($pedido['nombre'] . ' ' . $pedido['apellido']);
        $email = htmlspecialchars($pedido['email'] ?? '');
        $telefono = htmlspecialchars($pedido['telefono'] ?? '');
        $direccion = htmlspecialchars($pedido['direccion'] ?? '');
        $ciudad = htmlspecialchars(trim(($pedido['codigo_postal'] ?? '') . ' ' . ($pedido['ciudad'] ?? '') . ', ' . ($pedido['provincia'] ?? '')));
        $estado = htmlspecialchars(self::etiquetaEstado($pedido['estado'] ?? 'pendiente'));
        $notas = trim($pedido['notas'] ?? '');
        $notasHtml = $notas !== ''
            ? '<p class="notas"><strong>Notas:</strong> ' . htmlspecialchars($notas) . '</p>'
            : '';

        $filas = '';
        foreach ($pedido['items'] ?? [] as $item) {
            $nombre = htmlspecialchars($item['nombre'] ?? 'Producto');
            $color = self::etiquetaColorHtml($item['color'] ?? null);
            $talla = htmlspecialchars($item['talla'] ?? '-');
            $cantidad = (int) ($item['cantidad'] ?? 1);
            $precio = deportivo_formatear_precio((float) ($item['precio'] ?? 0));
            $subtotal = deportivo_formatear_precio((float) ($item['precio'] ?? 0) * $cantidad);
            $imagenHtml = self::celdaImagenHtml((string) ($item['imagen_data'] ?? ''));

            $filas .= "<tr>
                <td class=\"img-cell\">{$imagenHtml}</td>
                <td>{$nombre}</td>
                <td class=\"center\">{$color}</td>
                <td class=\"center\">{$talla}</td>
                <td class=\"center\">{$cantidad}</td>
                <td class=\"right\">{$precio}</td>
                <td class=\"right\">{$subtotal}</td>
            </tr>";
        }

        $subtotalPedido = deportivo_formatear_precio((float) $pedido['subtotal']);
        $envio = deportivo_formatear_precio((float) $pedido['envio']);
        $total = deportivo_formatear_precio((float) $pedido['total']);

        return <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #12131a;
            line-height: 1.5;
            margin: 0;
            padding: 32px;
        }
        .header {
            border-bottom: 3px solid #dfff00;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }
        .brand {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .brand span { color: #5c6200; }
        .meta {
            margin-top: 8px;
            color: #46464a;
            font-size: 11px;
        }
        h2 {
            font-size: 16px;
            margin: 0 0 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .grid {
            width: 100%;
            margin-bottom: 24px;
        }
        .grid td {
            vertical-align: top;
            width: 50%;
            padding-right: 16px;
        }
        .box {
            background: #f4f4f6;
            padding: 14px;
            margin-bottom: 8px;
        }
        .box p { margin: 0 0 4px; }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0 24px;
        }
        table.items th,
        table.items td {
            border-bottom: 1px solid #c7c6ca;
            padding: 10px 8px;
            text-align: left;
        }
        table.items th {
            background: #e8e8ec;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        table.items .img-cell {
            width: 135px;
            padding: 10px 8px;
        }
        table.items .product-img {
            width: 115px;
            height: 153px;
            object-fit: cover;
            border: 1px solid #c7c6ca;
            display: block;
            background: #fff;
        }
        table.items .img-placeholder {
            width: 115px;
            height: 153px;
            border: 1px solid #c7c6ca;
            background: #ececee;
            color: #919094;
            font-size: 9px;
            text-align: center;
            line-height: 153px;
            display: block;
        }
        .center { text-align: center; }
        .right { text-align: right; }
        .totals {
            width: 280px;
            margin-left: auto;
        }
        .totals td {
            padding: 6px 0;
        }
        .totals .total-row td {
            font-size: 14px;
            font-weight: bold;
            border-top: 2px solid #12131a;
            padding-top: 10px;
        }
        .notas {
            margin-top: 16px;
            padding: 12px;
            background: #f4f4f6;
        }
        .footer {
            margin-top: 32px;
            padding-top: 16px;
            border-top: 1px solid #c7c6ca;
            font-size: 10px;
            color: #46464a;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">DEPORTIVO<span>.</span></div>
        <div class="meta">Factura de pedido #{$pedidoId} · {$fecha} · Estado: {$estado}</div>
    </div>

    <table class="grid">
        <tr>
            <td>
                <h2>Cliente</h2>
                <div class="box">
                    <p><strong>{$cliente}</strong></p>
                    <p>{$email}</p>
                    <p>{$telefono}</p>
                </div>
            </td>
            <td>
                <h2>Envío</h2>
                <div class="box">
                    <p>{$direccion}</p>
                    <p>{$ciudad}</p>
                </div>
            </td>
        </tr>
    </table>

    <h2>Detalle del pedido</h2>
    <table class="items">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Producto</th>
                <th class="center">Color</th>
                <th class="center">Talla</th>
                <th class="center">Cant.</th>
                <th class="right">Precio</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>{$filas}</tbody>
    </table>

    <table class="totals">
        <tr>
            <td>Subtotal</td>
            <td class="right">{$subtotalPedido}</td>
        </tr>
        <tr>
            <td>Envío</td>
            <td class="right">{$envio}</td>
        </tr>
        <tr class="total-row">
            <td>Total</td>
            <td class="right">{$total}</td>
        </tr>
    </table>

    {$notasHtml}

    <div class="footer">
        DEPORTIVO — Ropa deportiva · Documento generado automáticamente · Moneda: COP
    </div>
</body>
</html>
HTML;
    }

    private static function formatearFecha(string $fecha): string
    {
        if ($fecha === '') {
            return date('d/m/Y H:i');
        }

        $dt = date_create($fecha);

        return $dt ? $dt->format('d/m/Y H:i') : $fecha;
    }

    private static function etiquetaEstado(string $estado): string
    {
        return match ($estado) {
            'confirmado' => 'Confirmado',
            'enviado' => 'Enviado',
            'cancelado' => 'Cancelado',
            default => 'Pendiente',
        };
    }

    private static function prepararItemsParaPdf(array $items): array
    {
        require_once __DIR__ . '/../config/paths.php';
        require_once __DIR__ . '/../models/Pedido.php';

        $items = Pedido::enriquecerItemsConImagen($items);

        foreach ($items as &$item) {
            $item['imagen_data'] = self::imagenComoDataUri((string) ($item['imagen'] ?? ''));
        }

        unset($item);

        return $items;
    }

    private static function imagenComoDataUri(string $url): string
    {
        $path = self::resolverRutaLocalImagen($url);

        if ($path === '' || !is_readable($path)) {
            return '';
        }

        $mime = mime_content_type($path) ?: 'image/jpeg';
        $data = base64_encode((string) file_get_contents($path));

        return "data:{$mime};base64,{$data}";
    }

    private static function resolverRutaLocalImagen(string $url): string
    {
        if ($url === '') {
            return '';
        }

        if (!defined('DEPORTIVO_ROOT')) {
            require_once __DIR__ . '/../config/paths.php';
        }

        $relative = str_replace('\\', '/', $url);

        if (preg_match('#^https?://#i', $relative)) {
            $parsed = parse_url($relative);
            $relative = ltrim($parsed['path'] ?? '', '/');
        } else {
            $relative = ltrim($relative, '/');
        }

        $webBase = ltrim(deportivo_web_base(), '/');
        if ($webBase !== '' && str_starts_with($relative, $webBase . '/')) {
            $relative = substr($relative, strlen($webBase) + 1);
        }

        $fullPath = DEPORTIVO_ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);

        return is_file($fullPath) ? $fullPath : '';
    }

    private static function celdaImagenHtml(string $dataUri): string
    {
        if ($dataUri === '') {
            return '<span class="img-placeholder">Sin foto</span>';
        }

        $src = htmlspecialchars($dataUri, ENT_QUOTES, 'UTF-8');

        return "<img class=\"product-img\" src=\"{$src}\" alt=\"Producto\" />";
    }

    private static function etiquetaColorHtml(?string $color): string
    {
        $nombre = trim((string) $color);
        if ($nombre === '') {
            return '-';
        }

        $hex = htmlspecialchars(Producto::colorHex($nombre));
        $texto = htmlspecialchars($nombre);

        return '<span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:'
            . $hex
            . ';border:1px solid #c7c6ca;vertical-align:middle;margin-right:5px;"></span>'
            . $texto;
    }
}
