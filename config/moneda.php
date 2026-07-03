<?php

if (!defined('DEPORTIVO_MONEDA_CODIGO')) {
    define('DEPORTIVO_MONEDA_CODIGO', 'COP');
    define('DEPORTIVO_ENVIO_GRATIS_MIN', 350000);
    define('DEPORTIVO_ENVIO_COSTO', 15000);
}

function deportivo_formatear_precio(float $precio): string
{
    return '$' . number_format((int) round($precio), 0, ',', '.');
}

function deportivo_calcular_envio(float $subtotal): float
{
    if ($subtotal <= 0) {
        return 0.0;
    }

    return $subtotal >= DEPORTIVO_ENVIO_GRATIS_MIN ? 0.0 : (float) DEPORTIVO_ENVIO_COSTO;
}
