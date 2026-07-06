-- Categorías iniciales para DEPORTIVO
-- Ejecutar en phpMyAdmin sobre la base de datos "deportivo" si el catálogo está vacío.

INSERT INTO `categorias` (`id`, `nombre`, `slug`, `descripcion`) VALUES
(1, 'Camisetas', 'camisetas', 'Camisetas técnicas Dry-Fit para entrenar y competir.'),
(2, 'Pantalonetas', 'pantalonetas', 'Pantalonetas ligeras y elásticas para todo tipo de deporte.')
ON DUPLICATE KEY UPDATE
  `nombre` = VALUES(`nombre`),
  `descripcion` = VALUES(`descripcion`);

ALTER TABLE `categorias` AUTO_INCREMENT = 3;
