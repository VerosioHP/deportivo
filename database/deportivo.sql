-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 10-07-2026 a las 04:13:43
-- Versión del servidor: 9.6.0
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `deportivo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `slug`, `descripcion`) VALUES
(1, 'Camisetas', 'camisetas', 'Camisetas técnicas Dry-Fit para entrenar y competir.'),
(2, 'Pantalonetas', 'pantalonetas', 'Pantalonetas ligeras y elásticas para todo tipo de deporte.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int NOT NULL,
  `numero` char(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usuario_id` int DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ciudad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `provincia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `codigo_postal` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `notas` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `subtotal` decimal(10,2) NOT NULL,
  `envio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','confirmado','enviado','cancelado') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'pendiente',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `numero`, `usuario_id`, `nombre`, `apellido`, `email`, `telefono`, `direccion`, `ciudad`, `provincia`, `codigo_postal`, `notas`, `subtotal`, `envio`, `total`, `estado`, `fecha_creacion`) VALUES
(6, NULL, NULL, 'Jhonatan Stiven', 'Velez Guevara', 'jhonatangdeve@gmail.com', '+57 728478934', 'cll 6 sur 80 ac 41', 'Medellín', 'Antioquia', '50001', NULL, 130000.00, 15000.00, 145000.00, 'pendiente', '2026-07-06 23:31:44'),
(7, NULL, NULL, 'Juan Pablo', 'Vera Ochoa', 'pabloochoaj3@gmail.com', '+575445669', 'cll 6 sur 80 ac 41', 'Medellín', 'Antioquia', '50001', NULL, 130000.00, 15000.00, 145000.00, 'enviado', '2026-07-06 23:55:49'),
(8, NULL, NULL, 'Maria Jose', 'Velásquez Arroyave', 'majobeto14052003@gmail.com', '+57 3146229292', 'cll 6 sur 80 ac 41', 'Medellín', 'Antioquia', '50001', 'Vereda El Jardín.', 260000.00, 15000.00, 275000.00, 'pendiente', '2026-07-07 01:44:56'),
(9, NULL, NULL, 'Carlos Andres', 'Mazo', 'xdmazo@gmail.com', '+575445669', 'cll 6 sur 80 ac 41', 'Medellín', 'Antioquia', '50001', NULL, 130000.00, 15000.00, 145000.00, 'pendiente', '2026-07-09 02:18:22'),
(10, NULL, NULL, 'Pablo', 'Vera', 'pabloochoaj3@gmail.com', '+575445669', 'cll 6 sur 80 ac 41', 'Medellín', 'Antioquia', '50001', NULL, 130000.00, 15000.00, 145000.00, 'pendiente', '2026-07-10 02:01:16'),
(11, NULL, NULL, 'Pablo', 'Vera', 'pabloochoaj3@gmail.com', '+575445669', 'cll 6 sur 80 ac 41', 'Medellín', 'Antioquia', '50001', NULL, 130000.00, 15000.00, 145000.00, 'pendiente', '2026-07-10 02:34:18'),
(12, '37779', NULL, 'Jhonatan', 'Guevara', 'jhonatangdeve@gmail.com', '+573113838914', 'Calle 6Sur #81B 73', 'Medellin', 'Antioquia', '', NULL, 195000.00, 15000.00, 210000.00, 'pendiente', '2026-07-10 04:10:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_items`
--

CREATE TABLE `pedido_items` (
  `id` int NOT NULL,
  `pedido_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `talla` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `color` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido_items`
--

INSERT INTO `pedido_items` (`id`, `pedido_id`, `producto_id`, `nombre`, `talla`, `color`, `precio`, `cantidad`) VALUES
(7, 6, 1, 'Nike pro Negra', 'L', NULL, 65000.00, 1),
(8, 6, 2, 'Nike pro Blanca', 'L', NULL, 65000.00, 1),
(9, 7, 1, 'Nike pro Negra', 'S', NULL, 65000.00, 1),
(10, 7, 2, 'Nike pro Blanca', 'S', NULL, 65000.00, 1),
(11, 8, 3, 'Under Armour Negra', 'L', NULL, 65000.00, 1),
(12, 8, 2, 'Nike pro Blanca', 'M', NULL, 65000.00, 1),
(13, 8, 6, 'Nike Blanca', 'L', NULL, 65000.00, 1),
(14, 8, 1, 'Nike pro Negra', 'XL', NULL, 65000.00, 1),
(15, 9, 8, 'Adidas', 'XL', NULL, 65000.00, 1),
(16, 9, 1, 'Nike pro Negra', 'L', NULL, 65000.00, 1),
(17, 10, 10, 'Adidas', 'XL', 'Blanco', 65000.00, 1),
(18, 10, 7, 'ON', 'M', 'Verde', 65000.00, 1),
(19, 11, 10, 'Adidas', 'L', 'Gris', 65000.00, 1),
(20, 11, 7, 'ON', 'M', 'Verde', 65000.00, 1),
(21, 12, 7, 'ON', 'L', 'Verde', 65000.00, 1),
(22, 12, 7, 'ON', 'XL', 'Blanco', 65000.00, 1),
(23, 12, 4, 'Under Armour Blanca', 'M', NULL, 65000.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int NOT NULL,
  `categoria_id` int NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen_principal` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `imagen_alt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `lavado` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fit` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `material_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `stock_estado` enum('disponible','pocas_unidades','agotado') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'disponible',
  `stock_cantidad` int UNSIGNED NOT NULL DEFAULT '0',
  `activo` tinyint(1) DEFAULT '1',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `slug`, `descripcion`, `precio`, `imagen_principal`, `imagen_alt`, `lavado`, `fit`, `material_info`, `stock_estado`, `stock_cantidad`, `activo`, `fecha_creacion`) VALUES
(1, 1, 'Nike pro Negra', 'nike-pro-negra', 'nike pro', 65000.00, 'uploads/productos/prod_1783300724_ebd0faa2.jpg', NULL, NULL, NULL, NULL, 'disponible', 0, 1, '2026-07-06 01:00:11'),
(2, 1, 'Nike pro Blanca', 'nike-pro-blanca', 'dd', 65000.00, 'uploads/productos/prod_1783300626_69a44602.jpg', NULL, NULL, NULL, NULL, 'disponible', 0, 1, '2026-07-06 01:15:09'),
(3, 1, 'Under Armour Negra', 'under-armour-negra', 'la grasa', 65000.00, 'uploads/productos/prod_1783387012_7dce46b6.jpg', NULL, NULL, NULL, NULL, 'disponible', 0, 1, '2026-07-07 01:16:52'),
(4, 1, 'Under Armour Blanca', 'under-armour-blanca', 'la miel', 65000.00, 'uploads/productos/prod_1783387156_1536137c.jpg', NULL, NULL, NULL, NULL, 'disponible', 0, 1, '2026-07-07 01:19:16'),
(5, 1, 'Under Negra', 'under-negra', 'agogo', 65000.00, 'uploads/productos/prod_1783387435_aadf9eb2.jpg', NULL, NULL, NULL, NULL, 'disponible', 0, 1, '2026-07-07 01:20:18'),
(6, 1, 'Nike Blanca', 'nike-blanca', 'bofff', 65000.00, 'uploads/productos/prod_1783562379_d1186533.jpg', NULL, NULL, NULL, NULL, 'disponible', 0, 1, '2026-07-07 01:25:01'),
(7, 1, 'ON', 'on', 'LA GRA$A', 65000.00, 'uploads/productos/prod_1783648435_a5df206d.jpg', NULL, NULL, NULL, NULL, 'disponible', 0, 1, '2026-07-09 01:31:00'),
(10, 1, 'Adidas', 'adidas', 'JHJ', 65000.00, 'uploads/productos/prod_1783647274_a3031e1c.jpg', NULL, NULL, NULL, NULL, 'disponible', 0, 1, '2026-07-10 01:34:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_colores`
--

CREATE TABLE `producto_colores` (
  `id` int NOT NULL,
  `producto_id` int NOT NULL,
  `nombre` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `imagen` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stock_cantidad` int UNSIGNED NOT NULL DEFAULT '0',
  `orden` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_colores`
--

INSERT INTO `producto_colores` (`id`, `producto_id`, `nombre`, `imagen`, `stock_cantidad`, `orden`) VALUES
(3, 10, 'Blanco', 'uploads/productos/prod_1783647274_a3031e1c.jpg', 2, 0),
(4, 10, 'Gris', 'uploads/productos/prod_1783647274_a3031e1c.jpg', 7, 1),
(5, 10, 'Negro', 'uploads/productos/prod_1783647274_a3031e1c.jpg', 12, 2),
(6, 7, 'Blanco', 'uploads/productos/prod_1783648435_a5df206d.jpg', 4, 0),
(7, 7, 'Negro', 'uploads/productos/prod_1783648435_a5df206d.jpg', 4, 1),
(8, 7, 'Verde', 'uploads/productos/prod_1783648435_a5df206d.jpg', 0, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_imagenes`
--

CREATE TABLE `producto_imagenes` (
  `id` int NOT NULL,
  `producto_id` int NOT NULL,
  `url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alt_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `orden` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_tallas`
--

CREATE TABLE `producto_tallas` (
  `id` int NOT NULL,
  `producto_id` int NOT NULL,
  `talla` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_tallas`
--

INSERT INTO `producto_tallas` (`id`, `producto_id`, `talla`) VALUES
(9, 2, 'S'),
(10, 2, 'M'),
(11, 2, 'L'),
(12, 2, 'XL'),
(13, 1, 'S'),
(14, 1, 'M'),
(15, 1, 'L'),
(16, 1, 'XL'),
(17, 3, 'S'),
(18, 3, 'M'),
(19, 3, 'L'),
(20, 3, 'XL'),
(21, 4, 'S'),
(22, 4, 'M'),
(23, 4, 'L'),
(24, 4, 'XL'),
(29, 5, 'S'),
(30, 5, 'M'),
(31, 5, 'L'),
(32, 5, 'XL'),
(50, 6, 'M'),
(51, 6, 'L'),
(52, 6, 'XL'),
(53, 6, 'XXL'),
(66, 10, 'M'),
(67, 10, 'L'),
(68, 10, 'XL'),
(69, 10, 'XXL'),
(70, 7, 'M'),
(71, 7, 'L'),
(72, 7, 'XL'),
(73, 7, 'XXL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rol` enum('admin','cliente') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'cliente',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `rol`, `fecha_creacion`) VALUES
(1, 'Administrador', 'DEPORTIVO', 'admin@denim.com', '$2y$10$DO7Dj6zDMw7E7.VRY/MfEe4BeNe9x3dNRXMPiWptdNk4kgmpguvJ6', 'admin', '2026-07-06 00:21:43');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `pedido_items`
--
ALTER TABLE `pedido_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `producto_colores`
--
ALTER TABLE `producto_colores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `producto_tallas`
--
ALTER TABLE `producto_tallas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `pedido_items`
--
ALTER TABLE `pedido_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `producto_colores`
--
ALTER TABLE `producto_colores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `producto_tallas`
--
ALTER TABLE `producto_tallas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `pedido_items`
--
ALTER TABLE `pedido_items`
  ADD CONSTRAINT `pedido_items_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `producto_colores`
--
ALTER TABLE `producto_colores`
  ADD CONSTRAINT `producto_colores_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD CONSTRAINT `producto_imagenes_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `producto_tallas`
--
ALTER TABLE `producto_tallas`
  ADD CONSTRAINT `producto_tallas_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
