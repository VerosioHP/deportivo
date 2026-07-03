-- =============================================================================
-- DEPORTIVO — Script completo para phpMyAdmin
-- Precios en COP (pesos colombianos)
-- Uso: selecciona la base de datos "deportivo" → pestaña SQL → pegar y ejecutar
-- =============================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `producto_tallas`;
DROP TABLE IF EXISTS `producto_imagenes`;
DROP TABLE IF EXISTS `pedido_items`;
DROP TABLE IF EXISTS `pedidos`;
DROP TABLE IF EXISTS `productos`;
DROP TABLE IF EXISTS `categorias`;
DROP TABLE IF EXISTS `usuarios`;

SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
-- categorias
-- --------------------------------------------------------

CREATE TABLE `categorias` (
  `id` int NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categorias` (`id`, `nombre`, `slug`, `descripcion`) VALUES
(1, 'Pantalonetas', 'pantalonetas', 'Pantalonetas deportivas para entrenamiento, running y competición. Tejidos ligeros, secado rápido y máxima libertad de movimiento.'),
(2, 'Camisetas', 'camisetas', 'Camisetas deportivas con tecnología Dry-Fit. Transpirables, cómodas y diseñadas para el máximo rendimiento en cada deporte.'),
(3, 'Pantalonetas Pro', 'pantalonetas-pro', 'Pantalonetas de competición con tejidos de compresión y ajuste ergonómico.');

-- --------------------------------------------------------
-- usuarios
-- --------------------------------------------------------

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rol` enum('admin','cliente') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'cliente',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `rol`, `fecha_creacion`) VALUES
(1, '', NULL, 'tefa@gmail.com', '$2y$10$ie9HlIT5cm2jBR0FGoQD1evcxcXR9WN7zXjvrVWeDGgHqe/JLRWOu', 'cliente', '2026-06-02 02:23:12'),
(2, 'Estefa', NULL, 'tefania@gmail.com', '$2y$10$sXsMshbXOxIxjFv4cJUqZOVbJXtk8CA7U3vxtWhOdRV0YMnY18FaG', 'cliente', '2026-06-02 02:25:27'),
(3, 'Administrador', 'Editorial', 'admin@denim.com', '$2y$10$DO7Dj6zDMw7E7.VRY/MfEe4BeNe9x3dNRXMPiWptdNk4kgmpguvJ6', 'admin', '2026-06-15 19:06:48');

-- --------------------------------------------------------
-- productos (precios COP)
-- --------------------------------------------------------

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
  `activo` tinyint(1) DEFAULT '1',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `slug`, `descripcion`, `precio`, `imagen_principal`, `imagen_alt`, `lavado`, `fit`, `material_info`, `stock_estado`, `activo`, `fecha_creacion`) VALUES
(1, 1, 'Jeans Rectos Heritage', 'jeans-rectos-heritage', 'Un corte recto atemporal inspirado en el denim americano clásico. Talle medio-alto con caída limpia y acabado en bruto que evoluciona con el uso.', 359900.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuDxZZOft-DDm5baxPt-ZBTucRxF2sTLQ93cVop1v9oHO78dQajMfGCqIIQ3HXsHBgGG-CEPb6FQCrVpQT05ezXfuR6Frgl72e1p8-5xjwsDSh33VAv8E4nLps2LSWK0VhtFaw8643l_m3Ma8tBoILsicmN95k3WG-bTSeiu9bad2ekBl_hjZQKA2DIynio8K_A8Nu3HORlzq8rsLMnAVqtDhz-sfP3IuotY5Z8Wmb_LsdncpSpM1MV37N8I_DEPusOdA5cArbpgtLe4', 'A detailed editorial close-up of premium raw denim jeans hanging against a neutral cream-colored textured wall.', 'Raw Indigo', 'Heritage Straight', '98% Algodón Orgánico, 2% Elastano|Denim de origen japonés|Costuras reforzadas|Herrajes metálicos eco-friendly', 'pocas_unidades', 1, '2026-06-11 20:42:10'),
(2, 1, 'Architectural Slim', 'architectural-slim', 'Silueta slim de líneas arquitectónicas con denim de alta densidad. Ajuste preciso que define la silueta sin perder comodidad.', 339900.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAC6WNFTsmxXVr2s3BfaRjtDnwwFsJy9_Q-dgcdxh0VE0vCwN9qusIDalZxnQ1Xkg0z4hvMkW8lE3FuivIKmXAK-KyTFZtGrA1tWXeRqbQAObf04MPYczXySnkZCXK1MhpBSzc3EYMgCJCEW5GRN86B9vFNSS9nGwjdRd0P8CAlbD2aZceXJYcCy8KPXJvT6iEfI2Jjmll44-o2yfmAOTn_iEn5FZDTfC9flHPfyPbgS2J8mcJCr2P9tnYF9gQUI2cntH7FKKWOYMH2', 'An editorial full-length shot of a model wearing dark charcoal slim-fit denim jeans.', 'Midnight Black', 'Skinny Architectural', '98% Algodón Orgánico, 2% Elastano|Denim japonés de alta densidad|Costuras reforzadas en puntos de tensión', 'disponible', 1, '2026-06-11 20:42:10'),
(3, 1, 'Vintage Relaxed', 'vintage-relaxed', 'Lavado vintage con caída relajada y sensación desgastada desde el primer día. Ideal para un look editorial relajado.', 369900.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAnwyA5PZWTfp4eqXp-Om6_0Ti0vrv1QCc02Qhg1n6shJNXPbMMuHrMEUL57wrdRgxbCQ7Q8Ayv7ciXiHBQkIKaeqfpQxUd1ZCtdReZRthwawXyMsAFoqziIESq3p66gmjOVBwul5tJxP27qatbMEpNWsG1vqBboZJmqXcxoaArmWJwEntVZWdMaVvv3xiXsRJ-D0uDBSIqQc0YyXo9cUSdcWUZAPqpiF2-DO-xArDNeejNNlpdKmG6-0skjBxUxbA5__lTs4Jhp5JC', 'A stylish vertical photograph of vintage light-wash denim jeans folded neatly on a mid-century modern wooden chair.', 'Vintage Wash', 'Relaxed Taper', '100% Algodón Orgánico|Lavado sostenible con bajo consumo de agua|Costuras contrastadas en tono ámbar', 'disponible', 1, '2026-06-11 20:42:10'),
(4, 1, 'Raw Edge Sculptor', 'raw-edge-sculptor', 'Denim crudo con bordes sin rematar y silueta esculpida. Pieza de edición limitada para quienes buscan carácter y textura.', 439900.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuBKavW06t5c7F1rkmh0lSI8JpJgoTOqC2Z9-UvDVcttnntsV9PGcB1PKBmzaj6uq17jFtGOpqq6Za0yH89YK1o-tINhKnsnyMQpnt5uNV7os99Sk9P4XbYL6-xspJkIQn5kUwv5QrS3H9vQgjBWFmKiBUUCLFouO9VJtfbD4IJ_48mhlB9v3bgXVGm1V2YYx-ya4XVCAbdkBETqume78DOXOJ_5TKNqaCdnDzV-aKEwAAX35E1pcNZIQvEGeSMsDUIgOjnvUpyV6dbR', 'A high-fashion editorial shot featuring the hem of raw-edge indigo denim jeans paired with minimalist leather boots.', 'Raw Indigo', 'Relaxed Taper', '100% Algodón Orgánico|Denim crudo sin lavar|Bordes sin rematar a mano|Edición limitada', 'pocas_unidades', 1, '2026-06-11 20:42:10'),
(5, 1, 'Noir Tapered', 'noir-tapered', 'Denim negro profundo con corte tapered moderno. Versátil y sofisticado, perfecto para looks monocromáticos editoriales.', 359900.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCt5agxKJtBrVoNGUeghHzuJfAepBw9KlRQSH91km13ptrc-OU4OtsxGuZFXywO9pxaVAPXx-Hgi8INxyAxaS9CG2FX2JCz2VRMt0qQvrAMN6ZmZScNrQeleheQvdl4CsiZp-G1kYKHuNSAC-EFvxrG-41m8qE7Ze-vMGuz3WZGFz7YIFf4ChSAZhhfU7kLff4Y9UOvaBDSYwyazIqNtPPki3gLhXAufzEyAf-tGLigHvSrnUeHVqPyOt4K2Pm-a78RlmSiXO_38TC-', 'A moody yet bright editorial shot of midnight black denim jeans showcased on a minimalist white mannequin.', 'Midnight Black', 'Relaxed Taper', '98% Algodón Orgánico, 2% Elastano|Teñido con pigmentos de bajo impacto|Costuras reforzadas', 'disponible', 1, '2026-06-11 20:42:10'),
(6, 1, 'Bleached Wide Leg', 'bleached-wide-leg', 'Silueta wide leg con lavado decolorado etéreo. Caída amplia y talle alto para un look editorial contemporáneo.', 379900.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuBVfxSAC79cziXcez5fLYArI0M66dytbddyrrBtw9sAAd85ZTeQIl-p5lhiJRicx6ZSHrSzUOEO6DKwzr-pZH2M07sUvLTx6G-PQm_2JjEnnoUwlAmgr3G-NXqgIj_QAGm69_fuFACxsLCMOvUHdfSLU4nWSWcVdL9tQXP0lDAZ2BeGhqOpW0QTiyuYo4lsqwpXwhOIgLTljw2vUpoGlAqUDDZlgHPrxMHzXcEN_2H90-UCKPx6vvGTghZ9D6S5FpCjZxRyq2vsu2fd', 'A serene editorial landscape shot featuring wide-leg bleached denim jeans.', 'Bleached', 'Wide Leg', '98% Algodón Orgánico, 2% Elastano|Lavado decolorado artesanal|Talle alto con pierna amplia', 'disponible', 1, '2026-06-11 20:42:10'),
(7, 1, 'Jeans Wide Leg Premium', 'jeans-wide-leg-premium', 'A contemporary take on a classic silhouette. Our Wide Leg Premium jeans are crafted from high-density Japanese denim that holds its shape while offering a comfortable, broken-in feel from day one. Features a high-rise waist and a relaxed, floor-grazing hem for a sophisticated editorial look.', 339900.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAz7wSctp_9itvzY04-eIZDaMJzj8e1MkfYImoG9AT5uNB_Gbbwb7m9KtCGUwlr4UEIKciNbmyyVCywmLQjgo1mYGvtbaDJ3gkQFeWB01zZeg61woYUpEWEgSuVCuXXRvyFpMtYQ2d4TMg0Aowhr46_UdtL-cSpZkc35ZfOxtWwWtjeM33_MIJHWxommBpQvuQfH1hj4IIfsKKbb5JFWkMwvXNPUdGcU032TVD1ey5VdTZKT0fNnAjOxCRo0LWtHKHE4O8T4uyCKB7U', 'A full-length editorial shot of a model wearing Wide Leg Premium jeans in a bright, airy studio.', 'Raw Indigo', 'Wide Leg', '98% Organic Cotton, 2% Elastane|Sustainably sourced Japanese denim|Reinforced stitching at stress points|Eco-friendly metal hardware', 'disponible', 1, '2026-06-11 20:42:10'),
(8, 2, 'Essential White Tee', 'essential-white-tee', 'Camiseta blanca esencial de algodón orgánico con caída premium. El complemento perfecto para cualquier silueta denim.', 139900.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuC_iJi60y8OG1TnQn3T9UKCXk5YMOJBr5RPyP4XZqQ3nk3QV_iOpAD6mWuG2uOJhZDnkHUjwieMg0h8EXV-GBiWze4t3HEzLX6pZ5DX6NAm_xgq1sz2AXUzN-ybXoUJkP7J2_owV5Q2A2_5lkkmqDtXPn4pR19DCKZKtulibK_RAbbaBZQcIXaBTtOyI-yeO4ranpYVNL-3-OHzmr-b3QbjaBHJN21Rq0vD5WxafbPCHV4lgbLK0n3osIbsHm3-IjilrI_35QQMWmPU', 'A minimalist white organic cotton t-shirt with a premium drape.', NULL, 'Regular', '100% Algodón Orgánico|Tejido jersey premium 180gsm|Cuello ribeteado reforzado', 'disponible', 1, '2026-06-11 20:42:10'),
(9, 2, 'Essential Black Tee', 'essential-black-tee', 'Camiseta negra de algodón peinado con acabado mate. Base versátil para looks editoriales monocromáticos.', 139900.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuC_iJi60y8OG1TnQn3T9UKCXk5YMOJBr5RPyP4XZqQ3nk3QV_iOpAD6mWuG2uOJhZDnkHUjwieMg0h8EXV-GBiWze4t3HEzLX6pZ5DX6NAm_xgq1sz2AXUzN-ybXoUJkP7J2_owV5Q2A2_5lkkmqDtXPn4pR19DCKZKtulibK_RAbbaBZQcIXaBTtOyI-yeO4ranpYVNL-3-OHzmr-b3QbjaBHJN21Rq0vD5WxafbPCHV4lgbLK0n3osIbsHm3-IjilrI_35QQMWmPU', 'A minimalist black organic cotton t-shirt with a premium drape.', NULL, 'Regular', '100% Algodón Orgánico|Tejido jersey premium 180gsm|Teñido reactivo de bajo impacto', 'disponible', 1, '2026-06-11 20:42:10'),
(10, 2, 'Striped Cotton Tee', 'striped-cotton-tee', 'Camiseta a rayas marineras en algodón suave. Detalle clásico con espíritu contemporáneo.', 169900.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuC_iJi60y8OG1TnQn3T9UKCXk5YMOJBr5RPyP4XZqQ3nk3QV_iOpAD6mWuG2uOJhZDnkHUjwieMg0h8EXV-GBiWze4t3HEzLX6pZ5DX6NAm_xgq1sz2AXUzN-ybXoUJkP7J2_owV5Q2A2_5lkkmqDtXPn4pR19DCKZKtulibK_RAbbaBZQcIXaBTtOyI-yeO4ranpYVNL-3-OHzmr-b3QbjaBHJN21Rq0vD5WxafbPCHV4lgbLK0n3osIbsHm3-IjilrI_35QQMWmPU', 'A striped cotton t-shirt with clean editorial styling.', NULL, 'Relaxed', '100% Algodón Orgánico|Rayas tejidas integradas|Corte ligeramente oversize', 'disponible', 1, '2026-06-11 20:42:10'),
(11, 3, 'Tailored Oversized Blazer', 'tailored-oversized-blazer', 'Blazer oversize con sastrería impecable en tono charcoal. Capa estructurada que eleva cualquier look denim.', 579900.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCzUupDGUZBfQ6pSfMWjUrCfOFYK3S1Odk13kWf0tlKDf5DSsuQaFdaDvtvl_8QUEQ5-W5Gk3lTyVHwsV_Fxs8XMH3eI_puzQFbUQ9fhUuwXyOmzucYhAxBXqpSFbkVqN_GvMFi2CH1vmV0KuM_uAk3VtIjs7XN2put1PevfHK7J7X7wGpk0AN_xFmeFVZyNT2ppOLDhnqReiWKZHtDD2NrZtd8QirzhZBGDc1jpV_C341T_jvfOpQQe9HU5vv-Fzyn4avs_3YTp_Wn', 'A tailored oversized blazer in a charcoal gray hue, styled for a high-fashion editorial.', NULL, 'Oversized', '65% Lana Virgen, 35% Poliéster Reciclado|Forro de viscosa|Botones de nácar|Sastrería italiana', 'disponible', 1, '2026-06-11 20:42:10'),
(12, 3, 'Denim Trucker Jacket', 'denim-trucker-jacket', 'Chaqueta trucker clásica en denim índigo profundo. Icono atemporal reinventado con costuras reforzadas.', 499900.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCzUupDGUZBfQ6pSfMWjUrCfOFYK3S1Odk13kWf0tlKDf5DSsuQaFdaDvtvl_8QUEQ5-W5Gk3lTyVHwsV_Fxs8XMH3eI_puzQFbUQ9fhUuwXyOmzucYhAxBXqpSFbkVqN_GvMFi2CH1vmV0KuM_uAk3VtIjs7XN2put1PevfHK7J7X7wGpk0AN_xFmeFVZyNT2ppOLDhnqReiWKZHtDD2NrZtd8QirzhZBGDc1jpV_C341T_jvfOpQQe9HU5vv-Fzyn4avs_3YTp_Wn', 'A classic denim trucker jacket in deep indigo.', 'Raw Indigo', 'Regular', '100% Algodón Orgánico|Denim de 14oz|Forro interior de algodón|Botones de metal envejecido', 'disponible', 1, '2026-06-11 20:42:10'),
(13, 3, 'Wool Blend Coat', 'wool-blend-coat', 'Abrigo de lana mezclada en tono camel. Silueta larga y minimalista para la temporada fría.', 779900.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCzUupDGUZBfQ6pSfMWjUrCfOFYK3S1Odk13kWf0tlKDf5DSsuQaFdaDvtvl_8QUEQ5-W5Gk3lTyVHwsV_Fxs8XMH3eI_puzQFbUQ9fhUuwXyOmzucYhAxBXqpSFbkVqN_GvMFi2CH1vmV0KuM_uAk3VtIjs7XN2put1PevfHK7J7X7wGpk0AN_xFmeFVZyNT2ppOLDhnqReiWKZHtDD2NrZtd8QirzhZBGDc1jpV_C341T_jvfOpQQe9HU5vv-Fzyn4avs_3YTp_Wn', 'A wool blend coat in warm camel tone with minimalist editorial styling.', NULL, 'Longline', '70% Lana, 30% Poliéster Reciclado|Forro acolchado ligero|Bolsillos laterales ocultos', 'pocas_unidades', 1, '2026-06-11 20:42:10'),
(14, 1, 'jeans vaqueros', 'jeans-vaqueros', 'tela estrecha', 339900.00, 'uploads/productos/prod_1781752313_e9450ce2.jpg', NULL, 'Raw Indigo', 'Heritage Straight', NULL, 'disponible', 1, '2026-06-18 03:11:53'),
(15, 1, 'jeans vaqueros', 'jeans-vaqueros-1', 'producto ideal para el campo', 325900.00, 'uploads/productos/prod_1781752444_6ff46c9f.jpg', NULL, 'Raw Indigo', 'Heritage Straight', NULL, 'disponible', 1, '2026-06-18 03:14:04');

-- --------------------------------------------------------
-- producto_imagenes
-- --------------------------------------------------------

CREATE TABLE `producto_imagenes` (
  `id` int NOT NULL,
  `producto_id` int NOT NULL,
  `url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alt_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `orden` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `producto_imagenes` (`id`, `producto_id`, `url`, `alt_text`, `orden`) VALUES
(1, 7, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCesUwgJhI4eHXa6j9yHGJ4NdkYjGUhzmMPTw_ZkKBEbz-G1-CtcrNZtc1WkKLylcGTJTa2I9pbaXXMFDGAZ3wQFWeztiPDJ0byqBKqe2t3VXFDaGL_3aAgAuOWHP6rsN2iwfSKUUziMYUjkIKvVXJhzy40u80bjgfEI3j6gKc-4GxKQ_lVC_hvbDvTcM2mhXh2ekezhxry4zTbSoMM5n9o0imIBUAdcrW2MeDmK6swt7HcphrzZyKFuHYW594BtlnVdQ-n1mqWf76T', 'Close-up of premium denim fabric showing intricate weave and texture.', 1),
(2, 7, 'https://lh3.googleusercontent.com/aida-public/AB6AXuD_2qC1ziBDeXZR-6gMHiZdb82jEVngEsxTPbUJvcLTD7mt_LypbyTSmE3N3p3W7vQXLu295GaEfraRg_OqqqWmL5TtWqgymtIF6Im8cijH4OxAEP3PuHzzSIg5lpChtv0rkz0ToQYC3t_CqVQuBZnobp3d4XHX65DWxp5l_DmdUH9DU9VErXd2NLexSAoeBEx_CN7VgDr94ZvnOVIIBcxu7hNBR6YkNFWSz97q5nmySNze6i43nbMcsSuJgaMUdHsTg13hBmwWe74H', 'Side profile view of wide-leg denim jeans against a warm beige background.', 2),
(3, 7, 'https://lh3.googleusercontent.com/aida-public/AB6AXuBzSuunjhkXtP5dpALQk3J9a4fISGQq1W5d3sepgL-krZblFPxnLY9ePu1yF1cUCcj2WywUEHqH1LimCCXoUUrMMNTyO5JTkRgpFLKfGZEvTYg03qCsPkvYMsIF5v3lXqkzLAu6DxRFxBKoV02SdD6ECFkm4d82n9gDP8Cc18w98gv2vaaDBmqh5R0Hl8jAdVXaDTv-1KBxMrdIt7XC5siZt8xIDWbXIMGZqYg5kR2fVFLA_3hB1WGAbfHqwbV6GZS4mP4kKNArmsWF', 'Detail shot of the back pocket and stitching on premium indigo denim.', 3);

-- --------------------------------------------------------
-- producto_tallas
-- --------------------------------------------------------

CREATE TABLE `producto_tallas` (
  `id` int NOT NULL,
  `producto_id` int NOT NULL,
  `talla` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `producto_tallas` (`id`, `producto_id`, `talla`) VALUES
(6, 2, '34'), (7, 2, '36'), (8, 2, '40'),
(9, 3, '36'), (10, 3, '38'), (11, 3, '42'),
(12, 4, '34'), (13, 4, '38'), (14, 4, '40'),
(15, 5, '34'), (16, 5, '36'), (17, 5, '38'), (18, 5, '40'), (19, 5, '42'),
(20, 6, '38'), (21, 6, '40'), (22, 6, '42'),
(23, 7, 'XS'), (24, 7, 'S'), (25, 7, 'M'), (26, 7, 'L'), (27, 7, 'XL'),
(28, 8, 'XS'), (29, 8, 'S'), (30, 8, 'M'), (31, 8, 'L'), (32, 8, 'XL'),
(33, 9, 'XS'), (34, 9, 'S'), (35, 9, 'M'), (36, 9, 'L'), (37, 9, 'XL'),
(38, 10, 'S'), (39, 10, 'M'), (40, 10, 'L'), (41, 10, 'XL'),
(42, 11, 'XS'), (43, 11, 'S'), (44, 11, 'M'), (45, 11, 'L'), (46, 11, 'XL'),
(47, 12, 'S'), (48, 12, 'M'), (49, 12, 'L'), (50, 12, 'XL'),
(51, 13, 'S'), (52, 13, 'M'), (53, 13, 'L'),
(54, 1, '34'), (55, 1, '36'), (56, 1, '38'), (57, 1, '40'), (58, 1, '42'),
(59, 14, '34'), (60, 14, '36'), (61, 14, '38'), (62, 14, '40'), (63, 14, '42'),
(64, 15, '34'), (65, 15, '36'), (66, 15, '38'), (67, 15, '40'), (68, 15, '42');

-- --------------------------------------------------------
-- pedidos (totales COP)
-- --------------------------------------------------------

CREATE TABLE `pedidos` (
  `id` int NOT NULL,
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
  `estado` enum('pendiente','confirmado','enviado') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'pendiente',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `pedidos` (`id`, `usuario_id`, `nombre`, `apellido`, `email`, `telefono`, `direccion`, `ciudad`, `provincia`, `codigo_postal`, `notas`, `subtotal`, `envio`, `total`, `estado`, `fecha_creacion`) VALUES
(1, NULL, 'Juan Pablo', 'Vera Ochoa', 'fetrtrg@gmail.com', '5445669', 'calle 6 sur #80 ac 41', 'Medellín', 'Antioquia', '50001', 'Preguntar por daniel en caso de no estar presente el dueño.', 359900.00, 15000.00, 374900.00, 'pendiente', '2026-06-18 03:54:09'),
(2, NULL, 'Juan Pablo', 'Vera Ochoa', 'pabloochoaj3@gmail.com', '5445669', 'calle 6 sur #80 ac 41', 'Medellín', 'Antioquia', '50001', 'VIVA COLOMBIA VIVA FALCAO!!!', 719800.00, 0.00, 719800.00, 'pendiente', '2026-06-18 04:01:58'),
(3, NULL, 'VELEZ', 'VELEZ', 'VELEZ@GMAIL.COM', '5995', 'calle 6 sur #80 ac 41', 'Medellín', 'Antioquia', '50001', 'SISAS', 339900.00, 15000.00, 354900.00, 'pendiente', '2026-06-18 04:07:26');

-- --------------------------------------------------------
-- pedido_items (precios COP)
-- --------------------------------------------------------

CREATE TABLE `pedido_items` (
  `id` int NOT NULL,
  `pedido_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `talla` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `pedido_items` (`id`, `pedido_id`, `producto_id`, `nombre`, `talla`, `precio`, `cantidad`) VALUES
(1, 1, 1, 'Jeans Rectos Heritage', '34', 359900.00, 1),
(2, 2, 1, 'Jeans Rectos Heritage', '34', 359900.00, 1),
(3, 2, 5, 'Noir Tapered', '34', 359900.00, 1),
(4, 3, 14, 'jeans vaqueros', '34', 339900.00, 1);

-- --------------------------------------------------------
-- Índices y claves foráneas
-- --------------------------------------------------------

ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `categoria_id` (`categoria_id`);

ALTER TABLE `producto_imagenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

ALTER TABLE `producto_tallas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

ALTER TABLE `pedido_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`);

ALTER TABLE `categorias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `producto_imagenes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `producto_tallas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

ALTER TABLE `pedidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `pedido_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

ALTER TABLE `pedido_items`
  ADD CONSTRAINT `pedido_items_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE;

ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;

ALTER TABLE `producto_imagenes`
  ADD CONSTRAINT `producto_imagenes_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

ALTER TABLE `producto_tallas`
  ADD CONSTRAINT `producto_tallas_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

COMMIT;
