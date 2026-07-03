-- Migración: rebrand DENIM EDITORIAL → DEPORTIVO
-- Ejecutar en la base de datos activa (ej. majestic)

UPDATE `categorias` SET
    `nombre` = 'Pantalonetas',
    `slug` = 'pantalonetas',
    `descripcion` = 'Pantalonetas deportivas para entrenamiento, running y competición. Tejidos ligeros, secado rápido y máxima libertad de movimiento.'
WHERE `slug` = 'jeans' OR `id` = 1;

UPDATE `categorias` SET
    `nombre` = 'Camisetas',
    `slug` = 'camisetas',
    `descripcion` = 'Camisetas deportivas con tecnología Dry-Fit. Transpirables, cómodas y diseñadas para el máximo rendimiento en cada deporte.'
WHERE `slug` = 'camisetas' OR `id` = 2;

UPDATE `categorias` SET
    `nombre` = 'Pantalonetas Pro',
    `slug` = 'pantalonetas-pro',
    `descripcion` = 'Pantalonetas de competición con tejidos de compresión y ajuste ergonómico.'
WHERE `slug` = 'chaquetas' OR `id` = 3;
