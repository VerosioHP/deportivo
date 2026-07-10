<?php

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../models/Producto.php';

$productoId = 10;

$stmt = $conexion->prepare('SELECT id, nombre, imagen_principal FROM productos WHERE id = :id LIMIT 1');
$stmt->execute([':id' => $productoId]);
$producto = $stmt->fetch();

if (!$producto) {
    echo "Producto #{$productoId} no encontrado.\n";
    exit(1);
}

$colores = [
    ['nombre' => 'Blanco', 'stock_cantidad' => 3, 'orden' => 0],
    ['nombre' => 'Gris', 'stock_cantidad' => 8, 'orden' => 1],
    ['nombre' => 'Negro', 'stock_cantidad' => 12, 'orden' => 2],
];

Producto::sincronizarColores($productoId, $colores, $producto['imagen_principal']);
Producto::recalcularStockProducto($productoId);

$verificar = Producto::obtenerColores($productoId);
echo "Colores cargados para \"{$producto['nombre']}\" (id {$productoId}):\n";
foreach ($verificar as $c) {
    echo "  - {$c['nombre']}: {$c['stock_cantidad']} unidades\n";
}
