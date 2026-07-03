-- Tablas de productos para DEPORTIVO
-- Importar en Laragon: mysql -u root majestic < database/productos.sql

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria_id` int NOT NULL,
  `nombre` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen_principal` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `imagen_alt` text COLLATE utf8mb4_general_ci,
  `lavado` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fit` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `material_info` text COLLATE utf8mb4_general_ci,
  `stock_estado` enum('disponible','pocas_unidades','agotado') COLLATE utf8mb4_general_ci DEFAULT 'disponible',
  `activo` tinyint(1) DEFAULT '1',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `categoria_id` (`categoria_id`),
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `producto_imagenes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `producto_id` int NOT NULL,
  `url` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `alt_text` text COLLATE utf8mb4_general_ci,
  `orden` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `producto_imagenes_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `producto_tallas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `producto_id` int NOT NULL,
  `talla` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `producto_tallas_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Categorías
-- --------------------------------------------------------

INSERT INTO `categorias` (`id`, `nombre`, `slug`, `descripcion`) VALUES
(1, 'Pantalonetas', 'pantalonetas', 'Pantalonetas deportivas para entrenamiento, running y competición. Tejidos ligeros, secado rápido y máxima libertad de movimiento.'),
(2, 'Camisetas', 'camisetas', 'Camisetas deportivas con tecnología Dry-Fit. Transpirables, cómodas y diseñadas para el máximo rendimiento.'),
(3, 'Pantalonetas Pro', 'pantalonetas-pro', 'Pantalonetas de competición con tejidos de compresión y ajuste ergonómico.');

-- --------------------------------------------------------
-- Productos: Jeans
-- --------------------------------------------------------

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `slug`, `descripcion`, `precio`, `imagen_principal`, `imagen_alt`, `lavado`, `fit`, `material_info`, `stock_estado`) VALUES
(1, 1, 'Jeans Rectos Heritage', 'jeans-rectos-heritage', 'Un corte recto atemporal inspirado en el denim americano clásico. Talle medio-alto con caída limpia y acabado en bruto que evoluciona con el uso.', 79.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuDxZZOft-DDm5baxPt-ZBTucRxF2sTLQ93cVop1v9oHO78dQajMfGCqIIQ3HXsHBgGG-CEPb6FQCrVpQT05ezXfuR6Frgl72e1p8-5xjwsDSh33VAv8E4nLps2LSWK0VhtFaw8643l_m3Ma8tBoILsicmN95k3WG-bTSeiu9bad2ekBl_hjZQKA2DIynio8K_A8Nu3HORlzq8rsLMnAVqtDhz-sfP3IuotY5Z8Wmb_LsdncpSpM1MV37N8I_DEPusOdA5cArbpgtLe4', 'A detailed editorial close-up of premium raw denim jeans hanging against a neutral cream-colored textured wall.', 'Raw Indigo', 'Heritage Straight', '98% Algodón Orgánico, 2% Elastano|Denim de origen japonés|Costuras reforzadas|Herrajes metálicos eco-friendly', 'pocas_unidades'),

(2, 1, 'Architectural Slim', 'architectural-slim', 'Silueta slim de líneas arquitectónicas con denim de alta densidad. Ajuste preciso que define la silueta sin perder comodidad.', 85.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAC6WNFTsmxXVr2s3BfaRjtDnwwFsJy9_Q-dgcdxh0VE0vCwN9qusIDalZxnQ1Xkg0z4hvMkW8lE3FuivIKmXAK-KyTFZtGrA1tWXeRqbQAObf04MPYczXySnkZCXK1MhpBSzc3EYMgCJCEW5GRN86B9vFNSS9nGwjdRd0P8CAlbD2aZceXJYcCy8KPXJvT6iEfI2Jjmll44-o2yfmAOTn_iEn5FZDTfC9flHPfyPbgS2J8mcJCr2P9tnYF9gQUI2cntH7FKKWOYMH2', 'An editorial full-length shot of a model wearing dark charcoal slim-fit denim jeans.', 'Midnight Black', 'Skinny Architectural', '98% Algodón Orgánico, 2% Elastano|Denim japonés de alta densidad|Costuras reforzadas en puntos de tensión', 'disponible'),

(3, 1, 'Vintage Relaxed', 'vintage-relaxed', 'Lavado vintage con caída relajada y sensación desgastada desde el primer día. Ideal para un look editorial relajado.', 92.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAnwyA5PZWTfp4eqXp-Om6_0Ti0vrv1QCc02Qhg1n6shJNXPbMMuHrMEUL57wrdRgxbCQ7Q8Ayv7ciXiHBQkIKaeqfpQxUd1ZCtdReZRthwawXyMsAFoqziIESq3p66gmjOVBwul5tJxP27qatbMEpNWsG1vqBboZJmqXcxoaArmWJwEntVZWdMaVvv3xiXsRJ-D0uDBSIqQc0YyXo9cUSdcWUZAPqpiF2-DO-xArDNeejNNlpdKmG6-0skjBxUxbA5__lTs4Jhp5JC', 'A stylish vertical photograph of vintage light-wash denim jeans folded neatly on a mid-century modern wooden chair.', 'Vintage Wash', 'Relaxed Taper', '100% Algodón Orgánico|Lavado sostenible con bajo consumo de agua|Costuras contrastadas en tono ámbar', 'disponible'),

(4, 1, 'Raw Edge Sculptor', 'raw-edge-sculptor', 'Denim crudo con bordes sin rematar y silueta esculpida. Pieza de edición limitada para quienes buscan carácter y textura.', 110.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuBKavW06t5c7F1rkmh0lSI8JpJgoTOqC2Z9-UvDVcttnntsV9PGcB1PKBmzaj6uq17jFtGOpqq6Za0yH89YK1o-tINhKnsnyMQpnt5uNV7os99Sk9P4XbYL6-xspJkIQn5kUwv5QrS3H9vQgjBWFmKiBUUCLFouO9VJtfbD4IJ_48mhlB9v3bgXVGm1V2YYx-ya4XVCAbdkBETqume78DOXOJ_5TKNqaCdnDzV-aKEwAAX35E1pcNZIQvEGeSMsDUIgOjnvUpyV6dbR', 'A high-fashion editorial shot featuring the hem of raw-edge indigo denim jeans paired with minimalist leather boots.', 'Raw Indigo', 'Relaxed Taper', '100% Algodón Orgánico|Denim crudo sin lavar|Bordes sin rematar a mano|Edición limitada', 'pocas_unidades'),

(5, 1, 'Noir Tapered', 'noir-tapered', 'Denim negro profundo con corte tapered moderno. Versátil y sofisticado, perfecto para looks monocromáticos editoriales.', 89.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCt5agxKJtBrVoNGUeghHzuJfAepBw9KlRQSH91km13ptrc-OU4OtsxGuZFXywO9pxaVAPXx-Hgi8INxyAxaS9CG2FX2JCz2VRMt0qQvrAMN6ZmZScNrQeleheQvdl4CsiZp-G1kYKHuNSAC-EFvxrG-41m8qE7Ze-vMGuz3WZGFz7YIFf4ChSAZhhfU7kLff4Y9UOvaBDSYwyazIqNtPPki3gLhXAufzEyAf-tGLigHvSrnUeHVqPyOt4K2Pm-a78RlmSiXO_38TC-', 'A moody yet bright editorial shot of midnight black denim jeans showcased on a minimalist white mannequin.', 'Midnight Black', 'Relaxed Taper', '98% Algodón Orgánico, 2% Elastano|Teñido con pigmentos de bajo impacto|Costuras reforzadas', 'disponible'),

(6, 1, 'Bleached Wide Leg', 'bleached-wide-leg', 'Silueta wide leg con lavado decolorado etéreo. Caída amplia y talle alto para un look editorial contemporáneo.', 95.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuBVfxSAC79cziXcez5fLYArI0M66dytbddyrrBtw9sAAd85ZTeQIl-p5lhiJRicx6ZSHrSzUOEO6DKwzr-pZH2M07sUvLTx6G-PQm_2JjEnnoUwlAmgr3G-NXqgIj_QAGm69_fuFACxsLCMOvUHdfSLU4nWSWcVdL9tQXP0lDAZ2BeGhqOpW0QTiyuYo4lsqwpXwhOIgLTljw2vUpoGlAqUDDZlgHPrxMHzXcEN_2H90-UCKPx6vvGTghZ9D6S5FpCjZxRyq2vsu2fd', 'A serene editorial landscape shot featuring wide-leg bleached denim jeans.', 'Bleached', 'Wide Leg', '98% Algodón Orgánico, 2% Elastano|Lavado decolorado artesanal|Talle alto con pierna amplia', 'disponible'),

(7, 1, 'Jeans Wide Leg Premium', 'jeans-wide-leg-premium', 'A contemporary take on a classic silhouette. Our Wide Leg Premium jeans are crafted from high-density Japanese denim that holds its shape while offering a comfortable, broken-in feel from day one. Features a high-rise waist and a relaxed, floor-grazing hem for a sophisticated editorial look.', 85.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAz7wSctp_9itvzY04-eIZDaMJzj8e1MkfYImoG9AT5uNB_Gbbwb7m9KtCGUwlr4UEIKciNbmyyVCywmLQjgo1mYGvtbaDJ3gkQFeWB01zZeg61woYUpEWEgSuVCuXXRvyFpMtYQ2d4TMg0Aowhr46_UdtL-cSpZkc35ZfOxtWwWtjeM33_MIJHWxommBpQvuQfH1hj4IIfsKKbb5JFWkMwvXNPUdGcU032TVD1ey5VdTZKT0fNnAjOxCRo0LWtHKHE4O8T4uyCKB7U', 'A full-length editorial shot of a model wearing Wide Leg Premium jeans in a bright, airy studio.', 'Raw Indigo', 'Wide Leg', '98% Organic Cotton, 2% Elastane|Sustainably sourced Japanese denim|Reinforced stitching at stress points|Eco-friendly metal hardware', 'disponible');

-- --------------------------------------------------------
-- Productos: Camisetas
-- --------------------------------------------------------

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `slug`, `descripcion`, `precio`, `imagen_principal`, `imagen_alt`, `lavado`, `fit`, `material_info`, `stock_estado`) VALUES
(8, 2, 'Essential White Tee', 'essential-white-tee', 'Camiseta blanca esencial de algodón orgánico con caída premium. El complemento perfecto para cualquier silueta denim.', 35.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuC_iJi60y8OG1TnQn3T9UKCXk5YMOJBr5RPyP4XZqQ3nk3QV_iOpAD6mWuG2uOJhZDnkHUjwieMg0h8EXV-GBiWze4t3HEzLX6pZ5DX6NAm_xgq1sz2AXUzN-ybXoUJkP7J2_owV5Q2A2_5lkkmqDtXPn4pR19DCKZKtulibK_RAbbaBZQcIXaBTtOyI-yeO4ranpYVNL-3-OHzmr-b3QbjaBHJN21Rq0vD5WxafbPCHV4lgbLK0n3osIbsHm3-IjilrI_35QQMWmPU', 'A minimalist white organic cotton t-shirt with a premium drape.', NULL, 'Regular', '100% Algodón Orgánico|Tejido jersey premium 180gsm|Cuello ribeteado reforzado', 'disponible'),

(9, 2, 'Essential Black Tee', 'essential-black-tee', 'Camiseta negra de algodón peinado con acabado mate. Base versátil para looks editoriales monocromáticos.', 35.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuC_iJi60y8OG1TnQn3T9UKCXk5YMOJBr5RPyP4XZqQ3nk3QV_iOpAD6mWuG2uOJhZDnkHUjwieMg0h8EXV-GBiWze4t3HEzLX6pZ5DX6NAm_xgq1sz2AXUzN-ybXoUJkP7J2_owV5Q2A2_5lkkmqDtXPn4pR19DCKZKtulibK_RAbbaBZQcIXaBTtOyI-yeO4ranpYVNL-3-OHzmr-b3QbjaBHJN21Rq0vD5WxafbPCHV4lgbLK0n3osIbsHm3-IjilrI_35QQMWmPU', 'A minimalist black organic cotton t-shirt with a premium drape.', NULL, 'Regular', '100% Algodón Orgánico|Tejido jersey premium 180gsm|Teñido reactivo de bajo impacto', 'disponible'),

(10, 2, 'Striped Cotton Tee', 'striped-cotton-tee', 'Camiseta a rayas marineras en algodón suave. Detalle clásico con espíritu contemporáneo.', 42.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuC_iJi60y8OG1TnQn3T9UKCXk5YMOJBr5RPyP4XZqQ3nk3QV_iOpAD6mWuG2uOJhZDnkHUjwieMg0h8EXV-GBiWze4t3HEzLX6pZ5DX6NAm_xgq1sz2AXUzN-ybXoUJkP7J2_owV5Q2A2_5lkkmqDtXPn4pR19DCKZKtulibK_RAbbaBZQcIXaBTtOyI-yeO4ranpYVNL-3-OHzmr-b3QbjaBHJN21Rq0vD5WxafbPCHV4lgbLK0n3osIbsHm3-IjilrI_35QQMWmPU', 'A striped cotton t-shirt with clean editorial styling.', NULL, 'Relaxed', '100% Algodón Orgánico|Rayas tejidas integradas|Corte ligeramente oversize', 'disponible');

-- --------------------------------------------------------
-- Productos: Chaquetas
-- --------------------------------------------------------

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `slug`, `descripcion`, `precio`, `imagen_principal`, `imagen_alt`, `lavado`, `fit`, `material_info`, `stock_estado`) VALUES
(11, 3, 'Tailored Oversized Blazer', 'tailored-oversized-blazer', 'Blazer oversize con sastrería impecable en tono charcoal. Capa estructurada que eleva cualquier look denim.', 145.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCzUupDGUZBfQ6pSfMWjUrCfOFYK3S1Odk13kWf0tlKDf5DSsuQaFdaDvtvl_8QUEQ5-W5Gk3lTyVHwsV_Fxs8XMH3eI_puzQFbUQ9fhUuwXyOmzucYhAxBXqpSFbkVqN_GvMFi2CH1vmV0KuM_uAk3VtIjs7XN2put1PevfHK7J7X7wGpk0AN_xFmeFVZyNT2ppOLDhnqReiWKZHtDD2NrZtd8QirzhZBGDc1jpV_C341T_jvfOpQQe9HU5vv-Fzyn4avs_3YTp_Wn', 'A tailored oversized blazer in a charcoal gray hue, styled for a high-fashion editorial.', NULL, 'Oversized', '65% Lana Virgen, 35% Poliéster Reciclado|Forro de viscosa|Botones de nácar|Sastrería italiana', 'disponible'),

(12, 3, 'Denim Trucker Jacket', 'denim-trucker-jacket', 'Chaqueta trucker clásica en denim índigo profundo. Icono atemporal reinventado con costuras reforzadas.', 125.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCzUupDGUZBfQ6pSfMWjUrCfOFYK3S1Odk13kWf0tlKDf5DSsuQaFdaDvtvl_8QUEQ5-W5Gk3lTyVHwsV_Fxs8XMH3eI_puzQFbUQ9fhUuwXyOmzucYhAxBXqpSFbkVqN_GvMFi2CH1vmV0KuM_uAk3VtIjs7XN2put1PevfHK7J7X7wGpk0AN_xFmeFVZyNT2ppOLDhnqReiWKZHtDD2NrZtd8QirzhZBGDc1jpV_C341T_jvfOpQQe9HU5vv-Fzyn4avs_3YTp_Wn', 'A classic denim trucker jacket in deep indigo.', 'Raw Indigo', 'Regular', '100% Algodón Orgánico|Denim de 14oz|Forro interior de algodón|Botones de metal envejecido', 'disponible'),

(13, 3, 'Wool Blend Coat', 'wool-blend-coat', 'Abrigo de lana mezclada en tono camel. Silueta larga y minimalista para la temporada fría.', 195.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCzUupDGUZBfQ6pSfMWjUrCfOFYK3S1Odk13kWf0tlKDf5DSsuQaFdaDvtvl_8QUEQ5-W5Gk3lTyVHwsV_Fxs8XMH3eI_puzQFbUQ9fhUuwXyOmzucYhAxBXqpSFbkVqN_GvMFi2CH1vmV0KuM_uAk3VtIjs7XN2put1PevfHK7J7X7wGpk0AN_xFmeFVZyNT2ppOLDhnqReiWKZHtDD2NrZtd8QirzhZBGDc1jpV_C341T_jvfOpQQe9HU5vv-Fzyn4avs_3YTp_Wn', 'A wool blend coat in warm camel tone with minimalist editorial styling.', NULL, 'Longline', '70% Lana, 30% Poliéster Reciclado|Forro acolchado ligero|Bolsillos laterales ocultos', 'pocas_unidades');

-- --------------------------------------------------------
-- Tallas
-- --------------------------------------------------------

INSERT INTO `producto_tallas` (`producto_id`, `talla`) VALUES
(1, '34'), (1, '36'), (1, '38'), (1, '40'), (1, '42'),
(2, '34'), (2, '36'), (2, '40'),
(3, '36'), (3, '38'), (3, '42'),
(4, '34'), (4, '38'), (4, '40'),
(5, '34'), (5, '36'), (5, '38'), (5, '40'), (5, '42'),
(6, '38'), (6, '40'), (6, '42'),
(7, 'XS'), (7, 'S'), (7, 'M'), (7, 'L'), (7, 'XL'),
(8, 'XS'), (8, 'S'), (8, 'M'), (8, 'L'), (8, 'XL'),
(9, 'XS'), (9, 'S'), (9, 'M'), (9, 'L'), (9, 'XL'),
(10, 'S'), (10, 'M'), (10, 'L'), (10, 'XL'),
(11, 'XS'), (11, 'S'), (11, 'M'), (11, 'L'), (11, 'XL'),
(12, 'S'), (12, 'M'), (12, 'L'), (12, 'XL'),
(13, 'S'), (13, 'M'), (13, 'L');

-- --------------------------------------------------------
-- Imágenes adicionales (galería detalle)
-- --------------------------------------------------------

INSERT INTO `producto_imagenes` (`producto_id`, `url`, `alt_text`, `orden`) VALUES
(7, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCesUwgJhI4eHXa6j9yHGJ4NdkYjGUhzmMPTw_ZkKBEbz-G1-CtcrNZtc1WkKLylcGTJTa2I9pbaXXMFDGAZ3wQFWeztiPDJ0byqBKqe2t3VXFDaGL_3aAgAuOWHP6rsN2iwfSKUUziMYUjkIKvVXJhzy40u80bjgfEI3j6gKc-4GxKQ_lVC_hvbDvTcM2mhXh2ekezhxry4zTbSoMM5n9o0imIBUAdcrW2MeDmK6swt7HcphrzZyKFuHYW594BtlnVdQ-n1mqWf76T', 'Close-up of premium denim fabric showing intricate weave and texture.', 1),
(7, 'https://lh3.googleusercontent.com/aida-public/AB6AXuD_2qC1ziBDeXZR-6gMHiZdb82jEVngEsxTPbUJvcLTD7mt_LypbyTSmE3N3p3W7vQXLu295GaEfraRg_OqqqWmL5TtWqgymtIF6Im8cijH4OxAEP3PuHzzSIg5lpChtv0rkz0ToQYC3t_CqVQuBZnobp3d4XHX65DWxp5l_DmdUH9DU9VErXd2NLexSAoeBEx_CN7VgDr94ZvnOVIIBcxu7hNBR6YkNFWSz97q5nmySNze6i43nbMcsSuJgaMUdHsTg13hBmwWe74H', 'Side profile view of wide-leg denim jeans against a warm beige background.', 2),
(7, 'https://lh3.googleusercontent.com/aida-public/AB6AXuBzSuunjhkXtP5dpALQk3J9a4fISGQq1W5d3sepgL-krZblFPxnLY9ePu1yF1cUCcj2WywUEHqH1LimCCXoUUrMMNTyO5JTkRgpFLKfGZEvTYg03qCsPkvYMsIF5v3lXqkzLAu6DxRFxBKoV02SdD6ECFkm4d82n9gDP8Cc18w98gv2vaaDBmqh5R0Hl8jAdVXaDTv-1KBxMrdIt7XC5siZt8xIDWbXIMGZqYg5kR2fVFLA_3hB1WGAbfHqwbV6GZS4mP4kKNArmsWF', 'Detail shot of the back pocket and stitching on premium indigo denim.', 3);

COMMIT;
