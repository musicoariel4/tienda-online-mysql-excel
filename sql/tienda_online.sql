-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 
-- Tiempo de generación: 05-10-2026 a las 18:05:41
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_online`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `direccion`, `telefono`, `email`) VALUES
(1, 'Carlos Ramirez', 'Av. Principal 123', '123-456-7890', 'carlos@example.com'),
(2, 'Ana Torres', 'Calle 45 Norte', '987-654-3210', 'ana@example.com'),
(3, 'Luis Mendoza', 'Calle 45 #22-18', '3105671234', 'luis.mendoza@example.com'),
(4, 'ARIEL ESPINOZA', 'calle 8 n. 84 f1553', '1234567', '0'),
(5, 'Juan Perez', 'Medellin', '300111', 'juan@gmail.com'),
(6, 'Maria Gomez', 'Bogota', '300222', 'maria@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id`, `pedido_id`, `producto_id`, `cantidad`) VALUES
(7, 1, 6, 1),
(8, 1, 7, 2),
(9, 2, 8, 1),
(10, 3, 6, 1),
(11, 3, 7, 2),
(12, 3, 8, 3),
(13, 4, 10, 2),
(14, 4, 12, 3),
(15, 4, 13, 1),
(16, 5, 14, 3),
(17, 5, 15, 1),
(18, 5, 16, 2),
(19, 6, 17, 1),
(20, 6, 18, 2),
(21, 6, 19, 3),
(22, 7, 20, 2),
(23, 7, 21, 3),
(24, 7, 6, 1),
(25, 8, 7, 3),
(26, 8, 8, 1),
(27, 8, 10, 2),
(28, 9, 12, 1),
(29, 9, 13, 2),
(30, 9, 14, 3),
(31, 10, 15, 2),
(32, 10, 16, 3),
(33, 10, 17, 1),
(34, 11, 18, 3),
(35, 11, 19, 1),
(36, 11, 20, 2),
(37, 12, 21, 1),
(38, 12, 6, 2),
(39, 12, 7, 3),
(40, 13, 8, 2),
(41, 13, 10, 3),
(42, 13, 12, 1),
(43, 14, 13, 3),
(44, 14, 14, 1),
(45, 14, 15, 2),
(46, 15, 16, 1),
(47, 15, 17, 2),
(48, 15, 18, 3),
(49, 16, 19, 2),
(50, 16, 20, 3),
(51, 16, 21, 1),
(52, 17, 6, 3),
(53, 17, 7, 1),
(54, 17, 8, 2),
(55, 18, 10, 1),
(56, 18, 12, 2),
(57, 18, 13, 3),
(58, 19, 14, 2),
(59, 19, 15, 3),
(60, 19, 16, 1),
(61, 20, 17, 3),
(62, 20, 18, 1),
(63, 20, 19, 2),
(64, 21, 20, 1),
(65, 21, 21, 2),
(66, 21, 6, 3),
(67, 22, 7, 2),
(68, 22, 8, 3),
(69, 22, 10, 1),
(70, 23, 12, 3),
(71, 23, 13, 1),
(72, 23, 14, 2),
(73, 24, 15, 1),
(74, 24, 16, 2),
(75, 24, 17, 3),
(76, 25, 18, 2),
(77, 25, 19, 3),
(78, 25, 20, 1),
(79, 26, 21, 3),
(80, 26, 6, 1),
(81, 26, 7, 2),
(82, 27, 8, 1),
(83, 27, 10, 2),
(84, 27, 12, 3),
(85, 28, 13, 2),
(86, 28, 14, 3),
(87, 28, 15, 1),
(88, 29, 16, 3),
(89, 29, 17, 1),
(90, 29, 18, 2),
(91, 30, 19, 1),
(92, 30, 20, 2),
(93, 30, 21, 3),
(94, 31, 6, 2),
(95, 31, 7, 3),
(96, 31, 8, 1),
(97, 32, 10, 3),
(98, 32, 12, 1),
(99, 32, 13, 2),
(100, 33, 14, 1),
(101, 33, 15, 2),
(102, 33, 16, 3),
(103, 34, 17, 2),
(104, 34, 18, 3),
(105, 34, 19, 1),
(106, 35, 18, 2),
(107, 35, 7, 4),
(108, 35, 6, 2),
(109, 36, 7, 1),
(110, 36, 8, 2),
(111, 36, 10, 3),
(112, 37, 12, 2),
(113, 37, 13, 3),
(114, 37, 14, 1),
(115, 38, 15, 3),
(116, 38, 16, 1),
(117, 38, 17, 2),
(118, 39, 18, 1),
(119, 39, 19, 2),
(120, 39, 20, 3),
(121, 40, 21, 2),
(122, 40, 6, 3),
(123, 40, 7, 1),
(124, 41, 8, 3),
(125, 41, 10, 1),
(126, 41, 12, 2),
(127, 42, 13, 1),
(128, 42, 14, 2),
(129, 42, 15, 3),
(130, 43, 16, 2),
(131, 43, 17, 3),
(132, 43, 18, 1),
(133, 44, 19, 3),
(134, 44, 20, 1),
(135, 44, 21, 2),
(136, 45, 6, 1),
(137, 45, 7, 2),
(138, 45, 8, 3),
(139, 46, 10, 2),
(140, 46, 12, 3),
(141, 46, 13, 1),
(142, 47, 14, 3),
(143, 47, 15, 1),
(144, 47, 16, 2),
(145, 48, 17, 1),
(146, 48, 18, 2),
(147, 48, 19, 3),
(148, 49, 20, 2),
(149, 49, 21, 3),
(150, 49, 6, 1),
(151, 50, 7, 3),
(152, 50, 8, 1),
(153, 50, 10, 2),
(154, 51, 12, 1),
(155, 51, 13, 2),
(156, 51, 14, 3),
(157, 52, 15, 2),
(158, 52, 16, 3),
(159, 52, 17, 1),
(160, 53, 18, 3),
(161, 53, 19, 1),
(162, 53, 20, 2),
(163, 54, 21, 1),
(164, 54, 6, 2),
(165, 54, 7, 3),
(166, 55, 8, 2),
(167, 55, 10, 3),
(168, 55, 12, 1),
(169, 56, 13, 3),
(170, 56, 14, 1),
(171, 56, 15, 2),
(172, 57, 16, 1),
(173, 57, 17, 2),
(174, 57, 18, 3),
(175, 58, 19, 2),
(176, 58, 20, 3),
(177, 58, 21, 1),
(178, 59, 6, 3),
(179, 59, 7, 1),
(180, 59, 8, 2),
(181, 60, 10, 1),
(182, 60, 12, 2),
(183, 60, 13, 3),
(184, 61, 14, 2),
(185, 61, 15, 3),
(186, 61, 16, 1),
(187, 62, 17, 3),
(188, 62, 18, 1),
(189, 62, 19, 2),
(190, 63, 20, 1),
(191, 63, 21, 2),
(192, 63, 6, 3),
(193, 64, 7, 2),
(194, 64, 8, 3),
(195, 64, 10, 1),
(196, 65, 12, 3),
(197, 65, 13, 1),
(198, 65, 14, 2),
(199, 66, 15, 1),
(200, 66, 16, 2),
(201, 66, 17, 3),
(202, 67, 18, 2),
(203, 67, 19, 3),
(204, 67, 20, 1),
(205, 68, 21, 3),
(206, 68, 6, 1),
(207, 68, 7, 2),
(208, 69, 8, 1),
(209, 69, 10, 2),
(210, 69, 12, 3),
(211, 70, 13, 2),
(212, 70, 14, 3),
(213, 70, 15, 1),
(214, 71, 16, 3),
(215, 71, 17, 1),
(216, 71, 18, 2),
(217, 72, 19, 1),
(218, 72, 20, 2),
(219, 72, 21, 3),
(220, 73, 6, 2),
(221, 73, 7, 3),
(222, 73, 8, 1),
(223, 74, 10, 3),
(224, 74, 12, 1),
(225, 74, 13, 2),
(226, 75, 14, 1),
(227, 75, 15, 2),
(228, 75, 16, 3),
(229, 76, 17, 2),
(230, 76, 18, 3),
(231, 76, 19, 1),
(232, 77, 20, 3),
(233, 77, 21, 1),
(234, 77, 6, 2),
(235, 78, 7, 1),
(236, 78, 8, 2),
(237, 78, 10, 3),
(238, 79, 12, 2),
(239, 79, 13, 3),
(240, 79, 14, 1),
(241, 80, 15, 3),
(242, 80, 16, 1),
(243, 80, 17, 2),
(244, 81, 18, 1),
(245, 81, 19, 2),
(246, 81, 20, 3),
(247, 82, 21, 2),
(248, 82, 6, 3),
(249, 82, 7, 1),
(250, 83, 8, 3),
(251, 83, 10, 1),
(252, 83, 12, 2),
(253, 84, 13, 1),
(254, 84, 14, 2),
(255, 84, 15, 3),
(256, 85, 16, 2),
(257, 85, 17, 3),
(258, 85, 18, 1),
(259, 86, 19, 3),
(260, 86, 20, 1),
(261, 86, 21, 2),
(262, 87, 6, 1),
(263, 87, 7, 2),
(264, 87, 8, 3),
(265, 88, 10, 2),
(266, 88, 12, 3),
(267, 88, 13, 1),
(268, 89, 14, 3),
(269, 89, 15, 1),
(270, 89, 16, 2),
(271, 90, 17, 1),
(272, 90, 18, 2),
(273, 90, 19, 3),
(274, 91, 20, 2),
(275, 91, 21, 3),
(276, 91, 6, 1),
(277, 92, 7, 3),
(278, 92, 8, 1),
(279, 92, 10, 2),
(280, 93, 12, 1),
(281, 93, 13, 2),
(282, 93, 14, 3),
(283, 94, 15, 2),
(284, 94, 16, 3),
(285, 94, 17, 1),
(286, 95, 18, 3),
(287, 95, 19, 1),
(288, 95, 20, 2),
(289, 96, 21, 1),
(290, 96, 6, 2),
(291, 96, 7, 3),
(292, 97, 8, 2),
(293, 97, 10, 3),
(294, 97, 12, 1),
(295, 98, 13, 3),
(296, 98, 14, 1),
(297, 98, 15, 2),
(298, 99, 16, 1),
(299, 99, 17, 2),
(300, 99, 18, 3),
(301, 100, 19, 2),
(302, 100, 20, 3),
(303, 100, 21, 1),
(304, 101, 6, 3),
(305, 101, 7, 1),
(306, 101, 8, 2),
(307, 102, 10, 1),
(308, 102, 12, 2),
(309, 102, 13, 3),
(310, 106, 18, 2),
(312, 108, 20, 2),
(313, 109, 6, 2),
(314, 110, 17, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente_id`, `fecha`) VALUES
(1, 1, '2025-03-01'),
(2, 2, '2025-03-02'),
(3, 1, '2025-03-05'),
(4, 2, '2025-03-08'),
(5, 3, '2025-03-11'),
(6, 4, '2025-03-14'),
(7, 5, '2025-03-17'),
(8, 6, '2025-03-20'),
(9, 1, '2025-03-23'),
(10, 2, '2025-03-26'),
(11, 3, '2025-03-29'),
(12, 4, '2025-04-01'),
(13, 5, '2025-04-04'),
(14, 6, '2025-04-07'),
(15, 1, '2025-04-10'),
(16, 2, '2025-04-13'),
(17, 3, '2025-04-16'),
(18, 4, '2025-04-19'),
(19, 5, '2025-04-22'),
(20, 6, '2025-04-25'),
(21, 1, '2025-04-28'),
(22, 2, '2025-05-01'),
(23, 3, '2025-05-04'),
(24, 4, '2025-05-07'),
(25, 5, '2025-05-10'),
(26, 6, '2025-05-13'),
(27, 1, '2025-05-16'),
(28, 2, '2025-05-19'),
(29, 3, '2025-05-22'),
(30, 4, '2025-05-25'),
(31, 5, '2025-05-28'),
(32, 6, '2025-05-31'),
(33, 1, '2025-06-03'),
(34, 2, '2025-06-06'),
(35, 3, '2025-06-09'),
(36, 4, '2025-06-12'),
(37, 5, '2025-06-15'),
(38, 6, '2025-06-18'),
(39, 1, '2025-06-21'),
(40, 2, '2025-06-24'),
(41, 3, '2025-06-27'),
(42, 4, '2025-06-30'),
(43, 5, '2025-07-03'),
(44, 6, '2025-07-06'),
(45, 1, '2025-07-09'),
(46, 2, '2025-07-12'),
(47, 3, '2025-07-15'),
(48, 4, '2025-07-18'),
(49, 5, '2025-07-21'),
(50, 6, '2025-07-24'),
(51, 1, '2025-07-27'),
(52, 2, '2025-07-30'),
(53, 3, '2025-08-02'),
(54, 4, '2025-08-05'),
(55, 5, '2025-08-08'),
(56, 6, '2025-08-11'),
(57, 1, '2025-08-14'),
(58, 2, '2025-08-17'),
(59, 3, '2025-08-20'),
(60, 4, '2025-08-23'),
(61, 5, '2025-08-26'),
(62, 6, '2025-08-29'),
(63, 1, '2025-09-01'),
(64, 2, '2025-09-04'),
(65, 3, '2025-09-07'),
(66, 4, '2025-09-10'),
(67, 5, '2025-09-13'),
(68, 6, '2025-09-16'),
(69, 1, '2025-09-19'),
(70, 2, '2025-09-22'),
(71, 3, '2025-09-25'),
(72, 4, '2025-09-28'),
(73, 5, '2025-10-01'),
(74, 6, '2025-10-04'),
(75, 1, '2025-10-07'),
(76, 2, '2025-10-10'),
(77, 3, '2025-10-13'),
(78, 4, '2025-10-16'),
(79, 5, '2025-10-19'),
(80, 6, '2025-10-22'),
(81, 1, '2025-10-25'),
(82, 2, '2025-10-28'),
(83, 3, '2025-10-31'),
(84, 4, '2025-11-03'),
(85, 5, '2025-11-06'),
(86, 6, '2025-11-09'),
(87, 1, '2025-11-12'),
(88, 2, '2025-11-15'),
(89, 3, '2025-11-18'),
(90, 4, '2025-11-21'),
(91, 5, '2025-11-24'),
(92, 6, '2025-11-27'),
(93, 1, '2025-11-30'),
(94, 2, '2025-12-03'),
(95, 3, '2025-12-06'),
(96, 4, '2025-12-09'),
(97, 5, '2025-12-12'),
(98, 6, '2025-12-15'),
(99, 1, '2025-12-18'),
(100, 2, '2025-12-21'),
(101, 3, '2025-12-24'),
(102, 4, '2025-12-27'),
(103, 4, '2026-09-08'),
(104, 4, '2026-09-03'),
(105, 4, '2026-09-03'),
(106, 4, '2026-09-03'),
(107, 1, '2026-09-09'),
(108, 4, '2026-10-04'),
(109, 2, '2026-10-04'),
(110, 4, '2026-10-04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precio`
--

CREATE TABLE `precio` (
  `producto_id` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `precio`
--

INSERT INTO `precio` (`producto_id`, `fecha_inicio`, `fecha_fin`, `precio`) VALUES
(6, '2025-03-16', NULL, '2000.00'),
(7, '2025-03-10', NULL, '35000.00'),
(8, '2025-03-12', NULL, '45.00'),
(10, '2025-08-15', NULL, '1000.00'),
(12, '2025-01-10', NULL, '850000.00'),
(13, '2025-01-12', NULL, '600000.00'),
(14, '2025-01-15', NULL, '280000.00'),
(15, '2025-01-18', NULL, '220000.00'),
(16, '2025-01-20', NULL, '200000.00'),
(17, '2025-01-22', NULL, '250000.00'),
(18, '2025-01-25', NULL, '1900000.00'),
(19, '2025-01-27', NULL, '180000.00'),
(20, '2025-01-30', NULL, '700000.00'),
(21, '2025-02-02', NULL, '10000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `disponible` tinyint(1) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `proveedor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `fecha_ingreso`, `disponible`, `stock`, `proveedor_id`) VALUES
(6, 'Laptop', 'Laptop con procesador i7 y 16 GB de RAM', '2000.00', '2025-03-16', 0, 12, 1),
(7, 'Mouse', 'Mouse inalámbrico con sensor óptico', '35000.00', '2025-03-10', 1, 6, 1),
(8, 'Teclado', 'Teclado mecánico retroiluminado', '45.00', '2025-03-12', 0, 9, 1),
(10, 'teclado 12', 'teclado para juegos', '1000.00', '2025-08-15', 1, 5, 3),
(12, 'Procesador Intel i5-12400F', 'CPU de 6 núcleos, 12 hilos, 2.5 GHz', '850000.00', '2025-01-10', 1, 15, 1),
(13, 'Tarjeta Madre ASUS B560M', 'Motherboard micro-ATX compatible con Intel 10/11 gen', '600000.00', '2025-01-12', 1, 10, 3),
(14, 'Memoria RAM Corsair 16GB DDR4', 'Módulo RAM DDR4 3200MHz', '280000.00', '2025-01-15', 1, 25, 1),
(15, 'Disco SSD Kingston 480GB', 'Unidad SSD SATA III de 480GB', '220000.00', '2025-01-18', 1, 30, 3),
(16, 'Disco Duro Seagate 1TB', 'HDD 7200rpm de 1TB', '200000.00', '2025-01-20', 1, 20, 1),
(17, 'Fuente de Poder EVGA 600W', 'Fuente certificada 80+ White', '250000.00', '2025-01-22', 1, 16, 3),
(18, 'Tarjeta Gráfica NVIDIA RTX 3060', 'GPU de 12GB GDDR6', '1900000.00', '2025-01-25', 1, 4, 1),
(19, 'Gabinete Gamer Cougar MX330', 'Torre ATX con ventilación optimizada', '180000.00', '2025-01-27', 1, 12, 3),
(20, 'Monitor LG 24” Full HD', 'Pantalla IPS con resolución 1920x1080', '700000.00', '2025-01-30', 1, 9, 1),
(21, 'Teclado Mecánico Redragon Kumara', 'Teclado mecánico retroiluminado RGB', '10000.00', '2025-02-02', 1, 23, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `contacto`, `telefono`, `email`) VALUES
(1, 'Tech Solutions', 'Carlos Ramirez', '123-456-7890', 'carlos@techsolutions.com'),
(3, 'Distribuciones Globales S.A.', 'Carrera 15 #35-80', '6017654321', 'contacto@globales.com');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_ventas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_ventas` (
`pedido` int(11)
,`fecha` date
,`cliente` varchar(100)
,`producto` varchar(100)
,`cantidad` int(11)
,`precio` decimal(10,2)
,`total` decimal(20,2)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_ventas`
--
DROP TABLE IF EXISTS `vista_ventas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_ventas`  AS  select `p`.`id` AS `pedido`,`p`.`fecha` AS `fecha`,`c`.`nombre` AS `cliente`,`prod`.`nombre` AS `producto`,`d`.`cantidad` AS `cantidad`,`prod`.`precio` AS `precio`,`d`.`cantidad` * `prod`.`precio` AS `total` from (((`pedidos` `p` join `clientes` `c` on(`p`.`cliente_id` = `c`.`id`)) join `detalle_pedido` `d` on(`p`.`id` = `d`.`pedido_id`)) join `productos` `prod` on(`d`.`producto_id` = `prod`.`id`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `precio`
--
ALTER TABLE `precio`
  ADD PRIMARY KEY (`producto_id`,`fecha_inicio`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_proveedor` (`proveedor_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=315;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `precio`
--
ALTER TABLE `precio`
  ADD CONSTRAINT `precio_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_proveedor` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
