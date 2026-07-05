<?php

require_once __DIR__ . '/../config/moneda.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class FacturaPdf
{
    public static function generar(array $pedido): string
    {
        if (!class_exists(Dompdf::class)) {
            throw new RuntimeException('Dompdf no está instalado. Ejecuta: composer install');
        }

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

    public static function nombreArchivo(int $pedidoId): string
    {
        return 'factura-deportivo-' . $pedidoId . '.pdf';
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
            $talla = htmlspecialchars($item['talla'] ?? '-');
            $cantidad = (int) ($item['cantidad'] ?? 1);
            $precio = deportivo_formatear_precio((float) ($item['precio'] ?? 0));
            $subtotal = deportivo_formatear_precio((float) ($item['precio'] ?? 0) * $cantidad);

            $filas .= "<tr>
                <td>{$nombre}</td>
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
                <th>Producto</th>
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
}
