<?php

require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../config/moneda.php';

class WhatsAppPedido
{
    public static function construirMensaje(
        int $pedidoId,
        array $envio,
        array $items,
        float $subtotal,
        float $envioCosto,
        float $total
    ): string {
        $config = self::config();
        $tienda = $config['nombre_tienda'];
        $lineas = [];

        $lineas[] = '🛍️ *NUEVO PEDIDO #' . $pedidoId . '*';
        $lineas[] = '*' . $tienda . '*';
        $lineas[] = '';
        $lineas[] = '👤 *DATOS DEL CLIENTE*';
        $lineas[] = 'Nombre: ' . self::linea($envio['nombre'] . ' ' . $envio['apellido']);
        $lineas[] = 'Email: ' . self::linea($envio['email']);
        $lineas[] = 'Teléfono: ' . self::linea($envio['telefono']);
        $lineas[] = '';
        $lineas[] = '📦 *DIRECCIÓN DE ENVÍO*';
        $lineas[] = self::linea($envio['direccion']);
        $lineas[] = self::linea($envio['codigo_postal'] . ' ' . $envio['ciudad'] . ', ' . $envio['provincia']);

        if (!empty($envio['notas'])) {
            $lineas[] = 'Notas: ' . self::linea($envio['notas']);
        }

        $lineas[] = '';
        $lineas[] = '🛒 *PRODUCTOS*';

        foreach ($items as $index => $item) {
            $num = $index + 1;
            $cantidad = (int) ($item['cantidad'] ?? 1);
            $precio = (float) ($item['precio'] ?? 0);
            $subtotalItem = $precio * $cantidad;

            $lineas[] = '';
            $lineas[] = '*' . $num . '. ' . self::linea($item['nombre'] ?? 'Producto') . '*';
            $lineas[] = '   Talla: ' . self::linea($item['talla'] ?? '-');
            $lineas[] = '   Cantidad: ' . $cantidad;
            $lineas[] = '   Precio unit.: ' . deportivo_formatear_precio($precio);
            $lineas[] = '   Subtotal: ' . deportivo_formatear_precio($subtotalItem);

            $detalles = array_filter([
                !empty($item['categoria']) ? 'Categoría: ' . $item['categoria'] : '',
                !empty($item['lavado']) ? 'Lavado: ' . $item['lavado'] : '',
                !empty($item['fit']) ? 'Silueta: ' . $item['fit'] : '',
            ]);

            foreach ($detalles as $detalle) {
                $lineas[] = '   ' . $detalle;
            }

            $imagen = self::urlAbsolutaImagen((string) ($item['imagen'] ?? ''));

            if ($imagen !== '') {
                $lineas[] = '   🖼️ Imagen: ' . $imagen;
            }
        }

        $lineas[] = '';
        $lineas[] = '💰 *RESUMEN*';
        $lineas[] = 'Subtotal: ' . deportivo_formatear_precio($subtotal);
        $lineas[] = 'Envío: ' . deportivo_formatear_precio($envioCosto);
        $lineas[] = '*Total: ' . deportivo_formatear_precio($total) . '*';
        $lineas[] = '';
        $lineas[] = 'Pedido registrado en la tienda. Por favor confirmar disponibilidad y envío.';

        return implode("\n", $lineas);
    }

    public static function construirUrl(string $mensaje): string
    {
        $numero = preg_replace('/\D+/', '', self::config()['numero']);

        return 'https://wa.me/' . $numero . '?text=' . rawurlencode($mensaje);
    }

    public static function urlDesdePedido(array $pedido): string
    {
        $items = self::enriquecerItemsConImagen($pedido['items'] ?? []);

        $mensaje = self::construirMensaje(
            (int) $pedido['id'],
            [
                'nombre' => $pedido['nombre'],
                'apellido' => $pedido['apellido'],
                'email' => $pedido['email'],
                'telefono' => $pedido['telefono'],
                'direccion' => $pedido['direccion'],
                'ciudad' => $pedido['ciudad'],
                'provincia' => $pedido['provincia'],
                'codigo_postal' => $pedido['codigo_postal'],
                'notas' => $pedido['notas'] ?? '',
            ],
            $items,
            (float) $pedido['subtotal'],
            (float) $pedido['envio'],
            (float) $pedido['total']
        );

        return self::construirUrl($mensaje);
    }

    public static function urlAbsolutaImagen(string $imagen): string
    {
        $imagen = trim($imagen);

        if ($imagen === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $imagen) || str_starts_with($imagen, '//')) {
            return $imagen;
        }

        $path = preg_replace('#^\.\./#', '', $imagen);

        return rtrim(self::baseUrl(), '/') . '/' . ltrim($path, '/');
    }

    private static function enriquecerItemsConImagen(array $items): array
    {
        foreach ($items as &$item) {
            if (!empty($item['imagen'])) {
                continue;
            }

            $productoId = (int) ($item['producto_id'] ?? 0);

            if ($productoId <= 0) {
                continue;
            }

            $producto = Producto::obtenerPorIdAdmin($productoId);

            if ($producto && !empty($producto['imagen_principal'])) {
                $desdeVistas = true;
                $item['imagen'] = Producto::urlImagen($producto['imagen_principal'], $desdeVistas);
            }
        }

        return $items;
    }

    private static function baseUrl(): string
    {
        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
        $scheme = $https ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $projectPath = dirname(dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        $projectPath = str_replace('\\', '/', $projectPath);

        return rtrim($scheme . '://' . $host . $projectPath, '/');
    }

    private static function linea(string $texto): string
    {
        return trim(preg_replace('/\s+/', ' ', $texto));
    }

    private static function config(): array
    {
        static $config = null;

        if ($config === null) {
            $config = require __DIR__ . '/../config/whatsapp.php';
        }

        return $config;
    }
}
