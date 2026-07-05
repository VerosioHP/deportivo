-- Agregar estado "cancelado" a pedidos
ALTER TABLE `pedidos`
  MODIFY `estado` enum('pendiente','confirmado','enviado','cancelado') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pendiente';
