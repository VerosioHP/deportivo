-- Usuario administrador de prueba
-- Email: admin@denim.com  |  Contraseña: admin123

INSERT INTO `usuarios` (`nombre`, `apellido`, `email`, `password`, `rol`)
SELECT 'Administrador', 'Editorial', 'admin@denim.com', '$2y$10$DO7Dj6zDMw7E7.VRY/MfEe4BeNe9x3dNRXMPiWptdNk4kgmpguvJ6', 'admin'
WHERE NOT EXISTS (SELECT 1 FROM `usuarios` WHERE `email` = 'admin@denim.com');
