<?php

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../models/Pedido.php';

$id = (int) ($argv[1] ?? 0);
if ($id <= 0) {
    $id = (int) $conexion->query('SELECT id FROM pedidos ORDER BY id DESC LIMIT 1')->fetchColumn();
}

if ($id <= 0) {
    fwrite(STDERR, "No hay pedidos en la base de datos.\n");
    exit(1);
}

$autoload = __DIR__ . '/../vendor/autoload.php';
if (!is_file($autoload)) {
    fwrite(STDERR, "Ejecuta composer install primero.\n");
    exit(1);
}

require $autoload;
require __DIR__ . '/../includes/FacturaPdf.php';

$pedido = Pedido::obtenerPorId($id);
if (!$pedido) {
    fwrite(STDERR, "Pedido #{$id} no encontrado.\n");
    exit(1);
}

$pdf = FacturaPdf::generar($pedido);
$nombreArchivo = FacturaPdf::nombreArchivo($pedido);
$uploadsDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads';

if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0775, true);
}

$out = $uploadsDir . DIRECTORY_SEPARATOR . $nombreArchivo;
file_put_contents($out, $pdf);

echo "Factura generada: {$out}\n";
echo "Pedido #{$id} · " . count($pedido['items'] ?? []) . " producto(s)\n";
