-- Migración segura: no borra tablas ni datos.
-- Solo agrega la columna `numero` y asigna valores a filas existentes.

ALTER TABLE `pedidos`
  ADD COLUMN `numero` CHAR(5) NULL AFTER `id`;

-- Ejecutar después de asignar números únicos con: php tools/migrate-numero-pedido.php
-- O asignar manualmente cada fila y luego:
-- ALTER TABLE `pedidos` MODIFY COLUMN `numero` CHAR(5) NOT NULL;
-- ALTER TABLE `pedidos` ADD UNIQUE KEY `numero` (`numero`);
