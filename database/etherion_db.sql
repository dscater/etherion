-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 10-04-2024 a las 23:15:11
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `etherion_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afiliados`
--

CREATE TABLE `afiliados` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `banco` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_cuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acepto_contrato` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `afiliados`
--

INSERT INTO `afiliados` (`id`, `user_id`, `banco`, `nro_cuenta`, `acepto_contrato`, `created_at`, `updated_at`) VALUES
(1, 2, 'BANCO UNION', '10000011222', 1, '2024-04-08 15:10:05', '2024-04-08 15:10:05'),
(2, 5, 'BANCO UNION', '1000000111', 1, '2024-04-09 15:24:29', '2024-04-09 15:24:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apis`
--

CREATE TABLE `apis` (
  `id` bigint UNSIGNED NOT NULL,
  `google_maps` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `map_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `apis`
--

INSERT INTO `apis` (`id`, `google_maps`, `map_id`, `created_at`, `updated_at`) VALUES
(1, 'AIzaSyDhJquXCekb8guwEiX1aLHvPePi3SMkKis', '1fb896f332f7b53c', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `p_comision` double(8,2) NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `p_comision`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 'CATEGORIA #1', 'DESC. CAT. #1', 4.00, '2024-04-05', '2024-04-05 16:01:20', '2024-04-05 16:01:51'),
(2, 'CATEGORIA #2', '', 10.00, '2024-04-05', '2024-04-05 16:01:45', '2024-04-05 16:01:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `acepto_contrato` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `user_id`, `acepto_contrato`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '2024-04-08 15:45:24', '2024-04-08 15:45:24'),
(2, 7, 1, '2024-04-10 21:47:10', '2024-04-10 21:47:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_pagos`
--

CREATE TABLE `configuracion_pagos` (
  `id` bigint UNSIGNED NOT NULL,
  `banco` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_cuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configuracion_pagos`
--

INSERT INTO `configuracion_pagos` (`id`, `banco`, `nro_cuenta`, `qr`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 'BANCO #1', '10000001111', '1712702813_1.png', '2024-04-09', '2024-04-09 22:46:53', '2024-04-09 22:46:53'),
(2, 'BANCO #2', '22222222', '1712702841_2.png', '2024-04-09', '2024-04-09 22:47:21', '2024-04-09 22:47:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto_productos`
--

CREATE TABLE `foto_productos` (
  `id` bigint UNSIGNED NOT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `foto_productos`
--

INSERT INTO `foto_productos` (`id`, `producto_id`, `foto`, `created_at`, `updated_at`) VALUES
(6, 2, 'imagen21712595183_0.png', '2024-04-08 16:53:03', '2024-04-08 16:53:03'),
(7, 2, 'imagen21712595183_1.png', '2024-04-08 16:53:03', '2024-04-08 16:53:03'),
(8, 3, 'imagen31712596398_0.png', '2024-04-08 17:13:18', '2024-04-08 17:13:18'),
(9, 4, 'imagen41712676421_0.jpg', '2024-04-09 15:27:01', '2024-04-09 15:27:01'),
(10, 4, 'imagen41712676421_1.jpg', '2024-04-09 15:27:01', '2024-04-09 15:27:01'),
(11, 5, 'imagen51712676438_0.jpg', '2024-04-09 15:27:18', '2024-04-09 15:27:18'),
(12, 5, 'imagen51712676438_1.jpg', '2024-04-09 15:27:18', '2024-04-09 15:27:18'),
(13, 6, 'imagen61712676455_0.jpg', '2024-04-09 15:27:35', '2024-04-09 15:27:35'),
(14, 7, 'imagen71712676480_0.jpg', '2024-04-09 15:28:00', '2024-04-09 15:28:00'),
(15, 8, 'imagen81712676509_0.jpg', '2024-04-09 15:28:29', '2024-04-09 15:28:29'),
(16, 9, 'imagen91712676526_0.jpg', '2024-04-09 15:28:46', '2024-04-09 15:28:46'),
(17, 10, 'imagen101712676566_0.jpg', '2024-04-09 15:29:26', '2024-04-09 15:29:26'),
(18, 11, 'imagen111712676584_0.jpg', '2024-04-09 15:29:44', '2024-04-09 15:29:44'),
(19, 12, 'imagen121712676600_0.jpg', '2024-04-09 15:30:00', '2024-04-09 15:30:00'),
(20, 13, 'imagen131712678699_0.jpg', '2024-04-09 16:04:59', '2024-04-09 16:04:59'),
(21, 14, 'imagen141712678733_0.jpg', '2024-04-09 16:05:33', '2024-04-09 16:05:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_accions`
--

CREATE TABLE `historial_accions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `accion` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `datos_original` text COLLATE utf8mb4_unicode_ci,
  `datos_nuevo` text COLLATE utf8mb4_unicode_ci,
  `modulo` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `historial_accions`
--

INSERT INTO `historial_accions` (`id`, `user_id`, `accion`, `descripcion`, `datos_original`, `datos_nuevo`, `modulo`, `fecha`, `hora`, `created_at`, `updated_at`) VALUES
(1, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA CATEGORIA', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CATEGORIA #1<br/>p_comision: 5.5<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 11:59:13<br/>updated_at: 2024-04-05 11:59:13<br/>', NULL, 'CATEGORIAS', '2024-04-05', '11:59:13', '2024-04-05 15:59:13', '2024-04-05 15:59:13'),
(2, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA CATEGORIA', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CATEGORIA #1<br/>p_comision: 5.5<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 11:59:13<br/>updated_at: 2024-04-05 11:59:13<br/>', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CATEGORIA #1<br/>p_comision: 5.55<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 11:59:13<br/>updated_at: 2024-04-05 11:59:22<br/>', 'CATEGORIAS', '2024-04-05', '11:59:22', '2024-04-05 15:59:22', '2024-04-05 15:59:22'),
(3, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA CATEGORIA', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CATEGORIA #1<br/>p_comision: 5.55<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 11:59:13<br/>updated_at: 2024-04-05 11:59:22<br/>', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CATEGORIA #1<br/>p_comision: 5.555<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 11:59:13<br/>updated_at: 2024-04-05 11:59:26<br/>', 'CATEGORIAS', '2024-04-05', '11:59:26', '2024-04-05 15:59:26', '2024-04-05 15:59:26'),
(4, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA CATEGORIA', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CATEGORIA #1<br/>p_comision: 5.55<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 11:59:13<br/>updated_at: 2024-04-05 11:59:26<br/>', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CATEGORIA #1<br/>p_comision: 5<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 11:59:13<br/>updated_at: 2024-04-05 12:00:21<br/>', 'CATEGORIAS', '2024-04-05', '12:00:21', '2024-04-05 16:00:21', '2024-04-05 16:00:21'),
(5, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA CATEGORIA', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CATEGORIA #1<br/>p_comision: 5<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 11:59:13<br/>updated_at: 2024-04-05 12:00:21<br/>', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CATEGORIA #1<br/>p_comision: 5.54<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 11:59:13<br/>updated_at: 2024-04-05 12:00:25<br/>', 'CATEGORIAS', '2024-04-05', '12:00:25', '2024-04-05 16:00:25', '2024-04-05 16:00:25'),
(6, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA CATEGORIA', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CATEGORIA #1<br/>p_comision: 5.54<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 11:59:13<br/>updated_at: 2024-04-05 12:00:25<br/>', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CATEGORIA #1<br/>p_comision: 5<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 11:59:13<br/>updated_at: 2024-04-05 12:00:30<br/>', 'CATEGORIAS', '2024-04-05', '12:00:30', '2024-04-05 16:00:30', '2024-04-05 16:00:30'),
(7, 1, 'ELIMINACIÓN', 'EL USUARIO  ELIMINÓ UNA CATEGORIA', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CATEGORIA #1<br/>p_comision: 5<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 11:59:13<br/>updated_at: 2024-04-05 12:00:30<br/>', NULL, 'CATEGORIAS', '2024-04-05', '12:00:59', '2024-04-05 16:00:59', '2024-04-05 16:00:59'),
(8, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA CATEGORIA', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CAT. #1<br/>p_comision: 0<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:01:20<br/>updated_at: 2024-04-05 12:01:20<br/>', NULL, 'CATEGORIAS', '2024-04-05', '12:01:20', '2024-04-05 16:01:20', '2024-04-05 16:01:20'),
(9, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA CATEGORIA', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CAT. #1<br/>p_comision: 0<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:01:20<br/>updated_at: 2024-04-05 12:01:20<br/>', 'id: 1<br/>nombre: CATEGORIA #1S<br/>descripcion: DESC. CAT. #1<br/>p_comision: 0<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:01:20<br/>updated_at: 2024-04-05 12:01:24<br/>', 'CATEGORIAS', '2024-04-05', '12:01:24', '2024-04-05 16:01:24', '2024-04-05 16:01:24'),
(10, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA CATEGORIA', 'id: 1<br/>nombre: CATEGORIA #1S<br/>descripcion: DESC. CAT. #1<br/>p_comision: 0<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:01:20<br/>updated_at: 2024-04-05 12:01:24<br/>', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CAT. #1<br/>p_comision: 0<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:01:20<br/>updated_at: 2024-04-05 12:01:28<br/>', 'CATEGORIAS', '2024-04-05', '12:01:28', '2024-04-05 16:01:28', '2024-04-05 16:01:28'),
(11, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA CATEGORIA', 'id: 2<br/>nombre: CATEGORIA #2<br/>descripcion: <br/>p_comision: 10<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:01:45<br/>updated_at: 2024-04-05 12:01:45<br/>', NULL, 'CATEGORIAS', '2024-04-05', '12:01:45', '2024-04-05 16:01:45', '2024-04-05 16:01:45'),
(12, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA CATEGORIA', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CAT. #1<br/>p_comision: 0<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:01:20<br/>updated_at: 2024-04-05 12:01:28<br/>', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CAT. #1<br/>p_comision: 4<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:01:20<br/>updated_at: 2024-04-05 12:01:51<br/>', 'CATEGORIAS', '2024-04-05', '12:01:51', '2024-04-05 16:01:51', '2024-04-05 16:01:51'),
(13, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA CATEGORIA', 'id: 1<br/>nombre: TAMAÑO #1<br/>descripcion: DESC. TAM. #1<br/>p_comision: 7<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:13:40<br/>updated_at: 2024-04-05 12:13:40<br/>', NULL, 'CATEGORIAS', '2024-04-05', '12:13:40', '2024-04-05 16:13:40', '2024-04-05 16:13:40'),
(14, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA CATEGORIA', 'id: 1<br/>nombre: TAMAÑO #1<br/>descripcion: DESC. TAM. #1<br/>p_comision: 7<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:13:40<br/>updated_at: 2024-04-05 12:13:40<br/>', 'id: 1<br/>nombre: TAMAÑO #1S<br/>descripcion: DESC. TAM. #1S<br/>p_comision: 7.88<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:13:40<br/>updated_at: 2024-04-05 12:13:52<br/>', 'CATEGORIAS', '2024-04-05', '12:13:52', '2024-04-05 16:13:52', '2024-04-05 16:13:52'),
(15, 1, 'ELIMINACIÓN', 'EL USUARIO  ELIMINÓ UNA CATEGORIA', 'id: 1<br/>nombre: TAMAÑO #1S<br/>descripcion: DESC. TAM. #1S<br/>p_comision: 7.88<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:13:40<br/>updated_at: 2024-04-05 12:13:52<br/>', NULL, 'CATEGORIAS', '2024-04-05', '12:13:56', '2024-04-05 16:13:56', '2024-04-05 16:13:56'),
(16, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA CATEGORIA', 'id: 1<br/>nombre: 50X50 CM<br/>descripcion: TAMAÑO#1<br/>p_comision: 3<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:14:22<br/>updated_at: 2024-04-05 12:14:22<br/>', NULL, 'CATEGORIAS', '2024-04-05', '12:14:22', '2024-04-05 16:14:22', '2024-04-05 16:14:22'),
(17, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA CATEGORIA', 'id: 2<br/>nombre: 1X1M<br/>descripcion: TAMAÑO #2<br/>p_comision: 8<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:14:36<br/>updated_at: 2024-04-05 12:14:36<br/>', NULL, 'CATEGORIAS', '2024-04-05', '12:14:36', '2024-04-05 16:14:36', '2024-04-05 16:14:36'),
(19, 2, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PRODUCTO', 'id: 2<br/>user_id: 2<br/>descripcion: PRODUCTO #1 AFILIADO 1<br/>categoria_id: 1<br/>producto_tamano_id: 1<br/>precio: 400<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 12:46:02<br/>updated_at: 2024-04-08 12:46:02<br/>', NULL, 'PRODUCTOS', '2024-04-08', '12:46:02', '2024-04-08 16:46:02', '2024-04-08 16:46:02'),
(20, 2, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UN PRODUCTO', 'id: 2<br/>user_id: 2<br/>descripcion: PRODUCTO #1 AFILIADO 1<br/>categoria_id: 1<br/>producto_tamano_id: 1<br/>precio: 400.00<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 12:46:02<br/>updated_at: 2024-04-08 12:46:02<br/>', 'id: 2<br/>user_id: 2<br/>descripcion: PRODUCTO #1 AFILIADO 1<br/>categoria_id: 1<br/>producto_tamano_id: 1<br/>precio: 400.00<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 12:46:02<br/>updated_at: 2024-04-08 12:46:02<br/>', 'PRODUCTOS', '2024-04-08', '12:52:20', '2024-04-08 16:52:20', '2024-04-08 16:52:20'),
(21, 2, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UN PRODUCTO', 'id: 2<br/>user_id: 2<br/>descripcion: PRODUCTO #1 AFILIADO 1<br/>categoria_id: 1<br/>producto_tamano_id: 1<br/>precio: 400.00<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 12:46:02<br/>updated_at: 2024-04-08 12:46:02<br/>', 'id: 2<br/>user_id: 2<br/>descripcion: PRODUCTO #1 AFILIADO 1<br/>categoria_id: 1<br/>producto_tamano_id: 1<br/>precio: 400.00<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 12:46:02<br/>updated_at: 2024-04-08 12:46:02<br/>', 'PRODUCTOS', '2024-04-08', '12:52:35', '2024-04-08 16:52:35', '2024-04-08 16:52:35'),
(22, 2, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UN PRODUCTO', 'id: 2<br/>user_id: 2<br/>descripcion: PRODUCTO #1 AFILIADO 1<br/>categoria_id: 1<br/>producto_tamano_id: 1<br/>precio: 400.00<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 12:46:02<br/>updated_at: 2024-04-08 12:46:02<br/>', 'id: 2<br/>user_id: 2<br/>descripcion: PRODUCTO #1 AFILIADO 1<br/>categoria_id: 1<br/>producto_tamano_id: 1<br/>precio: 400.00<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 12:46:02<br/>updated_at: 2024-04-08 12:46:02<br/>', 'PRODUCTOS', '2024-04-08', '12:53:03', '2024-04-08 16:53:03', '2024-04-08 16:53:03'),
(23, 2, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PRODUCTO', 'id: 3<br/>user_id: 2<br/>descripcion: PRODUCTO #2<br/>categoria_id: 2<br/>producto_tamano_id: 1<br/>precio: 290.50<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 13:13:18<br/>updated_at: 2024-04-08 13:13:18<br/>', NULL, 'PRODUCTOS', '2024-04-08', '13:13:18', '2024-04-08 17:13:18', '2024-04-08 17:13:18'),
(24, 2, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UN PRODUCTO', 'id: 3<br/>user_id: 2<br/>descripcion: PRODUCTO #2<br/>categoria_id: 2<br/>producto_tamano_id: 1<br/>precio: 290.50<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 13:13:18<br/>updated_at: 2024-04-08 13:13:18<br/>', 'id: 3<br/>user_id: 2<br/>descripcion: PRODUCTO #2 AF. 1<br/>categoria_id: 2<br/>producto_tamano_id: 1<br/>precio: 290.50<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 13:13:18<br/>updated_at: 2024-04-08 13:13:25<br/>', 'PRODUCTOS', '2024-04-08', '13:13:25', '2024-04-08 17:13:25', '2024-04-08 17:13:25'),
(25, 2, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UN PRODUCTO', 'id: 3<br/>user_id: 2<br/>descripcion: PRODUCTO #2 AF. 1<br/>categoria_id: 2<br/>producto_tamano_id: 1<br/>precio: 290.50<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 13:13:18<br/>updated_at: 2024-04-08 13:13:25<br/>', 'id: 3<br/>user_id: 2<br/>descripcion: PRODUCTO #2 AF. 1<br/>categoria_id: 2<br/>producto_tamano_id: 2<br/>precio: 290.50<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 13:13:18<br/>updated_at: 2024-04-08 13:13:46<br/>', 'PRODUCTOS', '2024-04-08', '13:13:46', '2024-04-08 17:13:46', '2024-04-08 17:13:46'),
(26, 5, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PRODUCTO', 'id: 4<br/>user_id: 5<br/>descripcion: DESCRIPCION PROD #1 AFILIADO 2<br/>categoria_id: 2<br/>producto_tamano_id: 1<br/>precio: 190<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 11:27:01<br/>updated_at: 2024-04-09 11:27:01<br/>', NULL, 'PRODUCTOS', '2024-04-09', '11:27:01', '2024-04-09 15:27:01', '2024-04-09 15:27:01'),
(27, 5, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PRODUCTO', 'id: 5<br/>user_id: 5<br/>descripcion: PROD #2 AFI 2<br/>categoria_id: 1<br/>producto_tamano_id: 2<br/>precio: 400<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 11:27:18<br/>updated_at: 2024-04-09 11:27:18<br/>', NULL, 'PRODUCTOS', '2024-04-09', '11:27:18', '2024-04-09 15:27:18', '2024-04-09 15:27:18'),
(28, 5, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PRODUCTO', 'id: 6<br/>user_id: 5<br/>descripcion: PROD #3 AFI 2<br/>categoria_id: 2<br/>producto_tamano_id: 2<br/>precio: 50.50<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 11:27:35<br/>updated_at: 2024-04-09 11:27:35<br/>', NULL, 'PRODUCTOS', '2024-04-09', '11:27:35', '2024-04-09 15:27:35', '2024-04-09 15:27:35'),
(29, 5, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PRODUCTO', 'id: 7<br/>user_id: 5<br/>descripcion: PROD #4 AFI 2<br/>categoria_id: 1<br/>producto_tamano_id: 2<br/>precio: 50.50<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 11:28:00<br/>updated_at: 2024-04-09 11:28:00<br/>', NULL, 'PRODUCTOS', '2024-04-09', '11:28:00', '2024-04-09 15:28:00', '2024-04-09 15:28:00'),
(30, 5, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UN PRODUCTO', 'id: 7<br/>user_id: 5<br/>descripcion: PROD #4 AFI 2<br/>categoria_id: 1<br/>producto_tamano_id: 2<br/>precio: 50.50<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 11:28:00<br/>updated_at: 2024-04-09 11:28:00<br/>', 'id: 7<br/>user_id: 5<br/>descripcion: PROD #4 AFI 2<br/>categoria_id: 1<br/>producto_tamano_id: 2<br/>precio: 190.99<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 11:28:00<br/>updated_at: 2024-04-09 11:28:10<br/>', 'PRODUCTOS', '2024-04-09', '11:28:10', '2024-04-09 15:28:10', '2024-04-09 15:28:10'),
(31, 5, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PRODUCTO', 'id: 8<br/>user_id: 5<br/>descripcion: PROD # 5 AFI 2<br/>categoria_id: 2<br/>producto_tamano_id: 1<br/>precio: 50<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 11:28:29<br/>updated_at: 2024-04-09 11:28:29<br/>', NULL, 'PRODUCTOS', '2024-04-09', '11:28:29', '2024-04-09 15:28:29', '2024-04-09 15:28:29'),
(32, 5, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PRODUCTO', 'id: 9<br/>user_id: 5<br/>descripcion: PROD #6 AFILIADO 2<br/>categoria_id: 1<br/>producto_tamano_id: 1<br/>precio: 40<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 11:28:46<br/>updated_at: 2024-04-09 11:28:46<br/>', NULL, 'PRODUCTOS', '2024-04-09', '11:28:46', '2024-04-09 15:28:46', '2024-04-09 15:28:46'),
(33, 2, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PRODUCTO', 'id: 10<br/>user_id: 2<br/>descripcion: PRODUCTO #2 AFI 1<br/>categoria_id: 1<br/>producto_tamano_id: 2<br/>precio: 300<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 11:29:26<br/>updated_at: 2024-04-09 11:29:26<br/>', NULL, 'PRODUCTOS', '2024-04-09', '11:29:26', '2024-04-09 15:29:26', '2024-04-09 15:29:26'),
(34, 2, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PRODUCTO', 'id: 11<br/>user_id: 2<br/>descripcion: PRODUCTO #4 AFILIADO 1<br/>categoria_id: 1<br/>producto_tamano_id: 2<br/>precio: 300.99<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 11:29:44<br/>updated_at: 2024-04-09 11:29:44<br/>', NULL, 'PRODUCTOS', '2024-04-09', '11:29:44', '2024-04-09 15:29:44', '2024-04-09 15:29:44'),
(35, 2, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PRODUCTO', 'id: 12<br/>user_id: 2<br/>descripcion: PRODUCTO #6 AFILIADO 1<br/>categoria_id: 2<br/>producto_tamano_id: 1<br/>precio: 100.99<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 11:30:00<br/>updated_at: 2024-04-09 11:30:00<br/>', NULL, 'PRODUCTOS', '2024-04-09', '11:30:00', '2024-04-09 15:30:00', '2024-04-09 15:30:00'),
(36, 2, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PRODUCTO', 'id: 13<br/>user_id: 2<br/>descripcion: PRODUCTO #6<br/>categoria_id: 2<br/>producto_tamano_id: 1<br/>precio: 300<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 12:04:59<br/>updated_at: 2024-04-09 12:04:59<br/>', NULL, 'PRODUCTOS', '2024-04-09', '12:04:59', '2024-04-09 16:04:59', '2024-04-09 16:04:59'),
(37, 2, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UN PRODUCTO', 'id: 13<br/>user_id: 2<br/>descripcion: PRODUCTO #6<br/>categoria_id: 2<br/>producto_tamano_id: 1<br/>precio: 300.00<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 12:04:59<br/>updated_at: 2024-04-09 12:04:59<br/>', 'id: 13<br/>user_id: 2<br/>descripcion: PRODUCTO #7<br/>categoria_id: 2<br/>producto_tamano_id: 1<br/>precio: 300.00<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 12:04:59<br/>updated_at: 2024-04-09 12:05:16<br/>', 'PRODUCTOS', '2024-04-09', '12:05:16', '2024-04-09 16:05:16', '2024-04-09 16:05:16'),
(38, 2, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PRODUCTO', 'id: 14<br/>user_id: 2<br/>descripcion: PRODUCTO # 8 AFI 1<br/>categoria_id: 2<br/>producto_tamano_id: 1<br/>precio: 200.99<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 12:05:33<br/>updated_at: 2024-04-09 12:05:33<br/>', NULL, 'PRODUCTOS', '2024-04-09', '12:05:33', '2024-04-09 16:05:33', '2024-04-09 16:05:33'),
(39, 2, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UN PRODUCTO', 'id: 2<br/>user_id: 2<br/>descripcion: PRODUCTO #1 AFILIADO 1<br/>categoria_id: 1<br/>producto_tamano_id: 1<br/>precio: 400.00<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 12:46:02<br/>updated_at: 2024-04-08 12:46:02<br/>', 'id: 2<br/>user_id: 2<br/>descripcion: PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1<br/>categoria_id: 1<br/>producto_tamano_id: 1<br/>precio: 400.00<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 12:46:02<br/>updated_at: 2024-04-09 12:33:01<br/>', 'PRODUCTOS', '2024-04-09', '12:33:01', '2024-04-09 16:33:01', '2024-04-09 16:33:01'),
(40, 2, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UN PRODUCTO', 'id: 2<br/>user_id: 2<br/>descripcion: PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1<br/>categoria_id: 1<br/>producto_tamano_id: 1<br/>precio: 400.00<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 12:46:02<br/>updated_at: 2024-04-09 12:33:01<br/>', 'id: 2<br/>user_id: 2<br/>descripcion: PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1<br/>categoria_id: 1<br/>producto_tamano_id: 1<br/>precio: 400.00<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 12:46:02<br/>updated_at: 2024-04-09 12:33:24<br/>', 'PRODUCTOS', '2024-04-09', '12:33:25', '2024-04-09 16:33:25', '2024-04-09 16:33:25'),
(42, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA CATEGORIA', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CAT. #1<br/>p_comision: 4<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:01:20<br/>updated_at: 2024-04-05 12:01:51<br/>', 'id: 1<br/>nombre: CATEGORIA #1<br/>descripcion: DESC. CAT. #1<br/>p_comision: 4<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:01:20<br/>updated_at: 2024-04-05 12:01:51<br/>', 'CATEGORIAS', '2024-04-09', '12:46:23', '2024-04-09 16:46:23', '2024-04-09 16:46:23'),
(43, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA CATEGORIA', 'id: 2<br/>nombre: CATEGORIA #2<br/>descripcion: <br/>p_comision: 10<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:01:45<br/>updated_at: 2024-04-05 12:01:45<br/>', 'id: 2<br/>nombre: CATEGORIA #2<br/>descripcion: <br/>p_comision: 10<br/>fecha_registro: 2024-04-05<br/>created_at: 2024-04-05 12:01:45<br/>updated_at: 2024-04-05 12:01:45<br/>', 'CATEGORIAS', '2024-04-09', '12:46:28', '2024-04-09 16:46:28', '2024-04-09 16:46:28'),
(44, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA CONFIGURACIÓN DE PAGO', 'id: 1<br/>banco: BANCO #1<br/>nro_cuenta: 100000011<br/>qr: <br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 18:45:22<br/>updated_at: 2024-04-09 18:45:22<br/>', NULL, 'CONFIGURACIÓN DE PAGOS', '2024-04-09', '18:45:22', '2024-04-09 22:45:22', '2024-04-09 22:45:22'),
(46, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA CONFIGURACIÓN DE PAGO', 'id: 1<br/>banco: BANCO #1<br/>nro_cuenta: 100000011<br/>qr: 1712702722_1.png<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 18:45:22<br/>updated_at: 2024-04-09 18:45:22<br/>', 'id: 1<br/>banco: BANCO #1<br/>nro_cuenta: 100000011<br/>qr: 1712702761_1.png<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 18:45:22<br/>updated_at: 2024-04-09 18:46:01<br/>', 'CONFIGURACIÓN DE PAGOS', '2024-04-09', '18:46:01', '2024-04-09 22:46:01', '2024-04-09 22:46:01'),
(47, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA CONFIGURACIÓN DE PAGO', 'id: 1<br/>banco: BANCO #1<br/>nro_cuenta: 100000011<br/>qr: 1712702761_1.png<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 18:45:22<br/>updated_at: 2024-04-09 18:46:01<br/>', 'id: 1<br/>banco: BANCO #1<br/>nro_cuenta: 100000011<br/>qr: 1712702767_1.png<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 18:45:22<br/>updated_at: 2024-04-09 18:46:07<br/>', 'CONFIGURACIÓN DE PAGOS', '2024-04-09', '18:46:07', '2024-04-09 22:46:07', '2024-04-09 22:46:07'),
(48, 1, 'ELIMINACIÓN', 'EL USUARIO  ELIMINÓ UNA CONFIGURACIÓN DE PAGO', 'id: 1<br/>banco: BANCO #1<br/>nro_cuenta: 100000011<br/>qr: 1712702767_1.png<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 18:45:22<br/>updated_at: 2024-04-09 18:46:07<br/>', NULL, 'CONFIGURACIÓN DE PAGOS', '2024-04-09', '18:46:33', '2024-04-09 22:46:33', '2024-04-09 22:46:33'),
(49, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA CONFIGURACIÓN DE PAGO', 'id: 1<br/>banco: BANCO #1<br/>nro_cuenta: 10000001111<br/>qr: <br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 18:46:53<br/>updated_at: 2024-04-09 18:46:53<br/>', NULL, 'CONFIGURACIÓN DE PAGOS', '2024-04-09', '18:46:53', '2024-04-09 22:46:53', '2024-04-09 22:46:53'),
(50, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA CONFIGURACIÓN DE PAGO', 'id: 2<br/>banco: BANCO #2<br/>nro_cuenta: 22222222<br/>qr: <br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 18:47:21<br/>updated_at: 2024-04-09 18:47:21<br/>', NULL, 'CONFIGURACIÓN DE PAGOS', '2024-04-09', '18:47:21', '2024-04-09 22:47:21', '2024-04-09 22:47:21'),
(51, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA CONFIGURACIÓN DE PAGO', 'id: 2<br/>banco: BANCO #2<br/>nro_cuenta: 22222222<br/>qr: 1712702841_2.png<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 18:47:21<br/>updated_at: 2024-04-09 18:47:21<br/>', 'id: 2<br/>banco: BANCO #2S<br/>nro_cuenta: 22222222<br/>qr: 1712702841_2.png<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 18:47:21<br/>updated_at: 2024-04-09 18:47:27<br/>', 'CONFIGURACIÓN DE PAGOS', '2024-04-09', '18:47:27', '2024-04-09 22:47:27', '2024-04-09 22:47:27'),
(52, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA CONFIGURACIÓN DE PAGO', 'id: 2<br/>banco: BANCO #2S<br/>nro_cuenta: 22222222<br/>qr: 1712702841_2.png<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 18:47:21<br/>updated_at: 2024-04-09 18:47:27<br/>', 'id: 2<br/>banco: BANCO #2<br/>nro_cuenta: 22222222<br/>qr: 1712702841_2.png<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 18:47:21<br/>updated_at: 2024-04-09 18:47:31<br/>', 'CONFIGURACIÓN DE PAGOS', '2024-04-09', '18:47:31', '2024-04-09 22:47:31', '2024-04-09 22:47:31'),
(55, 4, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA ORDEN DE VENTA', 'id: 4<br/>codigo: ORD.1<br/>nro: 1<br/>configuracion_pago_id: 1<br/>celular: 777777<br/>comprobante: C:\\USERS\\VICTO\\APPDATA\\LOCAL\\TEMP\\PHP91F0.TMP<br/>lat: -16.496684380292038<br/>lng: -68.13277766234039<br/>total_sc: 1958.92<br/>total: 1958.92<br/>estado: PENDIENTE<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 20:10:13<br/>updated_at: 2024-04-09 20:10:13<br/>', NULL, 'ORDEN DE VENTAS', '2024-04-09', '20:10:13', '2024-04-10 00:10:13', '2024-04-10 00:10:13'),
(56, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA ORDEN DE VENTA', 'id: 4<br/>codigo: ORD.1<br/>nro: 1<br/>configuracion_pago_id: 1<br/>celular: 777777<br/>comprobante: 1712707813_4.pdf<br/>lat: -16.496684380292038<br/>lng: -68.13277766234039<br/>total_sc: 1958.92<br/>total: 1958.92<br/>estado: PENDIENTE<br/>user_id: 4<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 20:10:13<br/>updated_at: 2024-04-09 20:10:13<br/>', 'id: 4<br/>codigo: ORD.1<br/>nro: 1<br/>configuracion_pago_id: 1<br/>celular: 777777<br/>comprobante: 1712707813_4.pdf<br/>lat: -16.496684380292038<br/>lng: -68.13277766234039<br/>total_sc: 1958.92<br/>total: 1958.92<br/>estado: ENTREGA PENDIENTE<br/>user_id: 4<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 20:10:13<br/>updated_at: 2024-04-10 10:53:21<br/>', 'ORDEN DE VENTAS', '2024-04-10', '10:53:21', '2024-04-10 14:53:21', '2024-04-10 14:53:21'),
(57, 1, 'ELIMINACIÓN', 'EL USUARIO  ELIMINÓ UNA ORDEN DE VENTA', 'id: 4<br/>codigo: ORD.1<br/>nro: 1<br/>configuracion_pago_id: 1<br/>celular: 777777<br/>comprobante: 1712707813_4.pdf<br/>lat: -16.496684380292038<br/>lng: -68.13277766234039<br/>total_sc: 1958.92<br/>total: 1958.92<br/>estado: ENTREGA PENDIENTE<br/>user_id: 4<br/>fecha_registro: 2024-04-09<br/>created_at: 2024-04-09 20:10:13<br/>updated_at: 2024-04-10 10:53:21<br/>', NULL, 'ORDEN DE VENTAS', '2024-04-10', '10:57:12', '2024-04-10 14:57:12', '2024-04-10 14:57:12'),
(58, 4, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA ORDEN DE VENTA', 'id: 1<br/>codigo: ORD.1<br/>nro: 1<br/>configuracion_pago_id: 2<br/>celular: 67676767<br/>comprobante: C:\\USERS\\VICTO\\APPDATA\\LOCAL\\TEMP\\PHPFB3A.TMP<br/>lat: -16.496059<br/>lng: -68.133345<br/>total_sc: 895.90<br/>total: 895.90<br/>estado: PENDIENTE<br/>user_id: 4<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 11:05:14<br/>updated_at: 2024-04-10 11:05:14<br/>', NULL, 'ORDEN DE VENTAS', '2024-04-10', '11:05:14', '2024-04-10 15:05:14', '2024-04-10 15:05:14'),
(59, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA ORDEN DE VENTA', 'id: 1<br/>codigo: ORD.1<br/>nro: 1<br/>configuracion_pago_id: 2<br/>celular: 67676767<br/>comprobante: 1712761514_1.pdf<br/>lat: -16.496059<br/>lng: -68.133345<br/>total_sc: 895.90<br/>total: 895.90<br/>estado: PENDIENTE<br/>user_id: 4<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 11:05:14<br/>updated_at: 2024-04-10 11:05:14<br/>', 'id: 1<br/>codigo: ORD.1<br/>nro: 1<br/>configuracion_pago_id: 2<br/>celular: 67676767<br/>comprobante: 1712761514_1.pdf<br/>lat: -16.496059<br/>lng: -68.133345<br/>total_sc: 895.90<br/>total: 895.90<br/>estado: ENTREGA PENDIENTE<br/>user_id: 4<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 11:05:14<br/>updated_at: 2024-04-10 11:27:53<br/>', 'ORDEN DE VENTAS', '2024-04-10', '11:27:53', '2024-04-10 15:27:53', '2024-04-10 15:27:53'),
(60, 1, 'ELIMINACIÓN', 'EL USUARIO  ELIMINÓ UNA ORDEN DE VENTA', 'id: 1<br/>codigo: ORD.1<br/>nro: 1<br/>configuracion_pago_id: 2<br/>celular: 67676767<br/>comprobante: 1712761514_1.pdf<br/>lat: -16.496059<br/>lng: -68.133345<br/>total_sc: 895.90<br/>total: 895.90<br/>estado: ENTREGA PENDIENTE<br/>user_id: 4<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 11:05:14<br/>updated_at: 2024-04-10 11:27:53<br/>', NULL, 'ORDEN DE VENTAS', '2024-04-10', '11:47:02', '2024-04-10 15:47:02', '2024-04-10 15:47:02'),
(64, 4, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA ORDEN DE VENTA', 'id: 1<br/>codigo: ORD.1<br/>nro: 1<br/>configuracion_pago_id: 2<br/>celular: 67676767<br/>comprobante: C:\\USERS\\VICTO\\APPDATA\\LOCAL\\TEMP\\PHP3C47.TMP<br/>lat: -16.496059<br/>lng: -68.133345<br/>total_sc: 397.74<br/>total: 397.74<br/>estado: PENDIENTE<br/>user_id: 4<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 11:50:18<br/>updated_at: 2024-04-10 11:50:18<br/>', NULL, 'ORDEN DE VENTAS', '2024-04-10', '11:50:18', '2024-04-10 15:50:18', '2024-04-10 15:50:18'),
(65, 1, 'ELIMINACIÓN', 'EL USUARIO  ELIMINÓ UNA ORDEN DE VENTA', 'id: 1<br/>codigo: ORD.1<br/>nro: 1<br/>configuracion_pago_id: 2<br/>celular: 67676767<br/>comprobante: 1712764218_1.pdf<br/>lat: -16.496059<br/>lng: -68.133345<br/>total_sc: 351.98<br/>total: 397.74<br/>estado: PENDIENTE<br/>user_id: 4<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 11:50:18<br/>updated_at: 2024-04-10 11:50:18<br/>', NULL, 'ORDEN DE VENTAS', '2024-04-10', '11:50:49', '2024-04-10 15:50:49', '2024-04-10 15:50:49'),
(66, 4, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA ORDEN DE VENTA', 'id: 1<br/>codigo: ORD.1<br/>nro: 1<br/>configuracion_pago_id: 1<br/>celular: 67676767<br/>comprobante: C:\\USERS\\VICTO\\APPDATA\\LOCAL\\TEMP\\PHP5049.TMP<br/>lat: -16.496059<br/>lng: -68.133345<br/>total_sc: 824.44<br/>total: 824.44<br/>estado: PENDIENTE<br/>user_id: 4<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 11:51:29<br/>updated_at: 2024-04-10 11:51:29<br/>', NULL, 'ORDEN DE VENTAS', '2024-04-10', '11:51:29', '2024-04-10 15:51:29', '2024-04-10 15:51:29'),
(67, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA ORDEN DE VENTA', 'id: 1<br/>codigo: ORD.1<br/>nro: 1<br/>configuracion_pago_id: 1<br/>celular: 67676767<br/>comprobante: 1712764289_1.pdf<br/>lat: -16.496059<br/>lng: -68.133345<br/>total_sc: 732.97<br/>total: 824.44<br/>estado: PENDIENTE<br/>user_id: 4<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 11:51:29<br/>updated_at: 2024-04-10 11:51:29<br/>', 'id: 1<br/>codigo: ORD.1<br/>nro: 1<br/>configuracion_pago_id: 1<br/>celular: 67676767<br/>comprobante: 1712764289_1.pdf<br/>lat: -16.496059<br/>lng: -68.133345<br/>total_sc: 732.97<br/>total: 824.44<br/>estado: ENTREGA PENDIENTE<br/>user_id: 4<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 11:51:29<br/>updated_at: 2024-04-10 11:53:14<br/>', 'ORDEN DE VENTAS', '2024-04-10', '11:53:14', '2024-04-10 15:53:14', '2024-04-10 15:53:14'),
(68, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PAGO DE AFILIADO', 'id: 1<br/>orden_venta_id: 1<br/>descripcion: DESC. PAGO #1 AFI 1<br/>estado: ENTREGADO<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 12:20:54<br/>updated_at: 2024-04-10 12:20:54<br/>', NULL, 'PAGO A AFILIADOS', '2024-04-10', '12:20:54', '2024-04-10 16:20:54', '2024-04-10 16:20:54'),
(69, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UN USUARIO', 'id: 6<br/>usuario: JUAN@GMAIL.COM<br/>password: $2y$12$mbovBCjyoUkYkHCc8H2Wv.4BFsfZL16onIy4P6/kxXfB5a0zAImNG<br/>nombre: JUAN<br/>paterno: PERES<br/>materno: <br/>ci: 1111<br/>ci_exp: LP<br/>dir: LOS OLIVOS<br/>email: JUAN@GMAIL.COM<br/>fono: 777777<br/>tipo: OPERADOR<br/>foto: <br/>acceso: 1<br/>fecha_registro: 2024-04-10 00:00:00<br/>created_at: 2024-04-10 12:46:53<br/>updated_at: 2024-04-10 12:46:53<br/>', NULL, 'USUARIOS', '2024-04-10', '12:46:53', '2024-04-10 16:46:53', '2024-04-10 16:46:53'),
(70, 1, 'MODIFICACIÓN', 'EL USUARIO admin MODIFICÓ UN USUARIO', 'id: 6<br/>usuario: JUAN@GMAIL.COM<br/>password: $2y$12$mbovBCjyoUkYkHCc8H2Wv.4BFsfZL16onIy4P6/kxXfB5a0zAImNG<br/>nombre: JUAN<br/>paterno: PERES<br/>materno: <br/>ci: 1111<br/>ci_exp: LP<br/>dir: LOS OLIVOS<br/>email: JUAN@GMAIL.COM<br/>fono: 777777<br/>tipo: OPERADOR<br/>foto: <br/>acceso: 1<br/>fecha_registro: 2024-04-10 00:00:00<br/>created_at: 2024-04-10 12:46:53<br/>updated_at: 2024-04-10 12:46:53<br/>', 'id: 6<br/>usuario: JUAN@GMAIL.COM<br/>password: $2y$12$mbovBCjyoUkYkHCc8H2Wv.4BFsfZL16onIy4P6/kxXfB5a0zAImNG<br/>nombre: JUAN<br/>paterno: PERES<br/>materno: <br/>ci: 1111<br/>ci_exp: LP<br/>dir: LOS OLIVOS<br/>email: JUAN@GMAIL.COM<br/>fono: 777777<br/>tipo: OPERADOR<br/>foto: <br/>acceso: 1<br/>fecha_registro: 2024-04-10 00:00:00<br/>created_at: 2024-04-10 12:46:53<br/>updated_at: 2024-04-10 12:46:53<br/>', 'USUARIOS', '2024-04-10', '12:47:28', '2024-04-10 16:47:28', '2024-04-10 16:47:28'),
(71, 7, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA ORDEN DE VENTA', 'id: 2<br/>codigo: ORD.2<br/>nro: 2<br/>configuracion_pago_id: 2<br/>celular: 67676767<br/>comprobante: C:\\USERS\\VICTO\\APPDATA\\LOCAL\\TEMP\\PHP9A2D.TMP<br/>lat: -16.496059<br/>lng: -68.133345<br/>total_sc: 674.22<br/>total: 674.22<br/>estado: PENDIENTE<br/>user_id: 7<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 17:48:58<br/>updated_at: 2024-04-10 17:48:58<br/>', NULL, 'ORDEN DE VENTAS', '2024-04-10', '17:48:58', '2024-04-10 21:48:58', '2024-04-10 21:48:58'),
(72, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UNA ORDEN DE VENTA', 'id: 2<br/>codigo: ORD.2<br/>nro: 2<br/>configuracion_pago_id: 2<br/>celular: 67676767<br/>comprobante: 1712785738_2.pdf<br/>lat: -16.496059<br/>lng: -68.133345<br/>total_sc: 601.98<br/>total: 674.22<br/>estado: PENDIENTE<br/>user_id: 7<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 17:48:58<br/>updated_at: 2024-04-10 17:48:58<br/>', 'id: 2<br/>codigo: ORD.2<br/>nro: 2<br/>configuracion_pago_id: 2<br/>celular: 67676767<br/>comprobante: 1712785738_2.pdf<br/>lat: -16.496059<br/>lng: -68.133345<br/>total_sc: 601.98<br/>total: 674.22<br/>estado: ENTREGA PENDIENTE<br/>user_id: 7<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 17:48:58<br/>updated_at: 2024-04-10 17:55:32<br/>', 'ORDEN DE VENTAS', '2024-04-10', '17:55:32', '2024-04-10 21:55:32', '2024-04-10 21:55:32'),
(73, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UN PAGO DE AFILIADO', 'id: 1<br/>orden_venta_id: 1<br/>descripcion: DESC. PAGO #1 AFI 1<br/>estado: ENTREGADO<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 12:20:54<br/>updated_at: 2024-04-10 12:20:54<br/>', 'id: 1<br/>orden_venta_id: 1<br/>descripcion: DESC. PAGO #1 AFI 1<br/>estado: ENTREGADO<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 12:20:54<br/>updated_at: 2024-04-10 12:20:54<br/>', 'PAGO A AFILIADOS', '2024-04-10', '18:08:27', '2024-04-10 22:08:27', '2024-04-10 22:08:27'),
(74, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UN PAGO DE AFILIADO', 'id: 1<br/>orden_venta_id: 1<br/>descripcion: DESC. PAGO #1 AFI 1<br/>estado: ENTREGADO<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 12:20:54<br/>updated_at: 2024-04-10 12:20:54<br/>', 'id: 1<br/>orden_venta_id: 1<br/>descripcion: DESC. PAGO #1 AFI 1<br/>estado: DEVOLUCIÓN<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 12:20:54<br/>updated_at: 2024-04-10 18:08:31<br/>', 'PAGO A AFILIADOS', '2024-04-10', '18:08:31', '2024-04-10 22:08:31', '2024-04-10 22:08:31'),
(75, 1, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UN PAGO DE AFILIADO', 'id: 1<br/>orden_venta_id: 1<br/>descripcion: DESC. PAGO #1 AFI 1<br/>estado: DEVOLUCIÓN<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 12:20:54<br/>updated_at: 2024-04-10 18:08:31<br/>', 'id: 1<br/>orden_venta_id: 1<br/>descripcion: DESC. PAGO #1 AFI 1<br/>estado: ENTREGADO<br/>fecha_registro: 2024-04-10<br/>created_at: 2024-04-10 12:20:54<br/>updated_at: 2024-04-10 18:08:46<br/>', 'PAGO A AFILIADOS', '2024-04-10', '18:08:46', '2024-04-10 22:08:46', '2024-04-10 22:08:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `institucions`
--

CREATE TABLE `institucions` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre_sistema` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razon_social` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciudad` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actividad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `host` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `puerto` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `encriptado` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `institucions`
--

INSERT INTO `institucions` (`id`, `nombre_sistema`, `alias`, `razon_social`, `nit`, `ciudad`, `dir`, `fono`, `correo`, `web`, `actividad`, `logo`, `host`, `puerto`, `encriptado`, `email`, `nombre`, `password`, `driver`, `created_at`, `updated_at`) VALUES
(1, 'ETHERION', 'ET', 'ETHERION S.A.', '11111111', 'LA PAZ', 'LOS OLIVOS', '7777777', 'ETHERION@GMAIL.COM', 'ETHERION.COM', 'ACTIVIDAD', '1710002413_1.jpg', 'smtp.hostinger.com', '587', 'tls', 'web@emsytsrl.com', 'ETHERION', '10-Co20re30oS', 'SMTP', NULL, '2024-04-10 16:42:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2024_01_31_165641_create_institucions_table', 1),
(4, '2024_02_02_205431_create_historial_accions_table', 1),
(5, '2024_03_09_125123_create_afiliados_table', 1),
(6, '2024_03_09_125125_create_categorias_table', 1),
(7, '2024_03_09_125126_create_producto_tamanos_table', 1),
(8, '2024_03_09_125138_create_pruductos_table', 1),
(9, '2024_03_12_142219_create_apis_table', 1),
(10, '2024_04_04_110458_create_clientes_table', 1),
(11, '2024_04_04_110938_create_foto_productos_table', 1),
(12, '2024_04_04_111244_create_orden_ventas_table', 1),
(13, '2024_04_04_111523_create_orden_detalles_table', 1),
(14, '2024_04_04_112333_create_pago_afiliados_table', 1),
(15, '2024_04_04_112609_create_configuracion_pagos_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_detalles`
--

CREATE TABLE `orden_detalles` (
  `id` bigint UNSIGNED NOT NULL,
  `orden_venta_id` bigint UNSIGNED NOT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `cantidad` double(8,2) NOT NULL,
  `precio` decimal(24,2) NOT NULL,
  `precio_sc` decimal(24,2) NOT NULL,
  `precio_total` decimal(24,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `orden_detalles`
--

INSERT INTO `orden_detalles` (`id`, `orden_venta_id`, `producto_id`, `cantidad`, `precio`, `precio_sc`, `precio_total`, `created_at`, `updated_at`) VALUES
(4, 1, 14, 1.00, 227.12, 200.99, 227.12, '2024-04-10 15:51:29', '2024-04-10 15:51:29'),
(5, 1, 8, 3.00, 56.50, 150.00, 169.50, '2024-04-10 15:51:29', '2024-04-10 15:51:29'),
(6, 1, 7, 2.00, 213.91, 381.98, 427.82, '2024-04-10 15:51:29', '2024-04-10 15:51:29'),
(7, 2, 11, 2.00, 337.11, 601.98, 674.22, '2024-04-10 21:48:58', '2024-04-10 21:48:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_ventas`
--

CREATE TABLE `orden_ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro` bigint NOT NULL,
  `configuracion_pago_id` bigint UNSIGNED NOT NULL,
  `celular` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comprobante` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_sc` decimal(24,2) NOT NULL,
  `total` decimal(24,2) NOT NULL,
  `estado` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `orden_ventas`
--

INSERT INTO `orden_ventas` (`id`, `codigo`, `nro`, `configuracion_pago_id`, `celular`, `comprobante`, `lat`, `lng`, `total_sc`, `total`, `estado`, `user_id`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 'ORD.1', 1, 1, '67676767', '1712764289_1.pdf', '-16.496059', '-68.133345', 732.97, 824.44, 'ENTREGADO', 4, '2024-04-10', '2024-04-10 15:51:29', '2024-04-10 22:08:46'),
(2, 'ORD.2', 2, 2, '67676767', '1712785738_2.pdf', '-16.496059', '-68.133345', 601.98, 674.22, 'ENTREGA PENDIENTE', 7, '2024-04-10', '2024-04-10 21:48:58', '2024-04-10 21:55:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_afiliados`
--

CREATE TABLE `pago_afiliados` (
  `id` bigint UNSIGNED NOT NULL,
  `orden_venta_id` bigint UNSIGNED NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pago_afiliados`
--

INSERT INTO `pago_afiliados` (`id`, `orden_venta_id`, `descripcion`, `estado`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 1, 'DESC. PAGO #1 AFI 1', 'ENTREGADO', '2024-04-10', '2024-04-10 16:20:54', '2024-04-10 22:08:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria_id` bigint UNSIGNED NOT NULL,
  `producto_tamano_id` bigint UNSIGNED NOT NULL,
  `precio` decimal(24,2) NOT NULL,
  `precio_total` decimal(24,2) NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `user_id`, `descripcion`, `categoria_id`, `producto_tamano_id`, `precio`, `precio_total`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(2, 2, 'PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1 PRODUCTO #1 AFILIADO 1', 1, 1, 400.00, 428.00, '2024-04-08', '2024-04-08 16:46:02', '2024-04-09 16:46:23'),
(3, 2, 'PRODUCTO #2 AF. 1', 2, 2, 290.50, 342.79, '2024-04-08', '2024-04-08 17:13:18', '2024-04-09 16:46:28'),
(4, 5, 'DESCRIPCION PROD #1 AFILIADO 2', 2, 1, 190.00, 214.70, '2024-04-09', '2024-04-09 15:27:01', '2024-04-09 16:46:28'),
(5, 5, 'PROD #2 AFI 2', 1, 2, 400.00, 448.00, '2024-04-09', '2024-04-09 15:27:18', '2024-04-09 16:46:23'),
(6, 5, 'PROD #3 AFI 2', 2, 2, 50.50, 59.59, '2024-04-09', '2024-04-09 15:27:35', '2024-04-09 16:46:29'),
(7, 5, 'PROD #4 AFI 2', 1, 2, 190.99, 213.91, '2024-04-09', '2024-04-09 15:28:00', '2024-04-09 16:46:23'),
(8, 5, 'PROD # 5 AFI 2', 2, 1, 50.00, 56.50, '2024-04-09', '2024-04-09 15:28:29', '2024-04-09 16:46:29'),
(9, 5, 'PROD #6 AFILIADO 2', 1, 1, 40.00, 42.80, '2024-04-09', '2024-04-09 15:28:46', '2024-04-09 16:46:23'),
(10, 2, 'PRODUCTO #2 AFI 1', 1, 2, 300.00, 336.00, '2024-04-09', '2024-04-09 15:29:26', '2024-04-09 16:46:23'),
(11, 2, 'PRODUCTO #4 AFILIADO 1', 1, 2, 300.99, 337.11, '2024-04-09', '2024-04-09 15:29:44', '2024-04-09 16:46:23'),
(12, 2, 'PRODUCTO #6 AFILIADO 1', 2, 1, 100.99, 114.12, '2024-04-09', '2024-04-09 15:30:00', '2024-04-09 16:46:29'),
(13, 2, 'PRODUCTO #7', 2, 1, 300.00, 339.00, '2024-04-09', '2024-04-09 16:04:59', '2024-04-09 16:46:29'),
(14, 2, 'PRODUCTO # 8 AFI 1', 2, 1, 200.99, 227.12, '2024-04-09', '2024-04-09 16:05:33', '2024-04-09 16:46:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_tamanos`
--

CREATE TABLE `producto_tamanos` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `p_comision` double(8,2) NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto_tamanos`
--

INSERT INTO `producto_tamanos` (`id`, `nombre`, `descripcion`, `p_comision`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, '50X50 CM', 'TAMAÑO#1', 3.00, '2024-04-05', '2024-04-05 16:14:22', '2024-04-05 16:14:22'),
(2, '1X1M', 'TAMAÑO #2', 8.00, '2024-04-05', '2024-04-05 16:14:36', '2024-04-05 16:14:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paterno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `materno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ci` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci_exp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acceso` int NOT NULL DEFAULT '1',
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `usuario`, `password`, `nombre`, `paterno`, `materno`, `ci`, `ci_exp`, `dir`, `email`, `fono`, `tipo`, `foto`, `acceso`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$65d4fgZsvBV5Lc/AxNKh4eoUdbGyaczQ4sSco20feSQANshNLuxSC', 'admin', NULL, NULL, '0', '', '', 'admin@gmail.com', '', 'ADMINISTRADOR', NULL, 1, '2024-01-31', NULL, '2024-02-02 18:13:58'),
(2, 'eduardo@gmail.com', '$2y$12$H210oHjJfzjgkQ0eqteu.ecgcHOdMQtJF/ibwoc4SBLBntnGQfrBS', 'EDUARDO', 'RAMIRES', 'RAMIRES', '3434', 'LP', 'LOS OLIVOS', 'eduardo@gmail.com', '77777777', 'AFILIADO', NULL, 1, '2024-04-08', '2024-04-08 15:10:05', '2024-04-08 15:40:05'),
(4, 'marcos@gmail.com', '$2y$12$WyvGWNAM9qAb/P4qikQP8uREWqIlwuqMhX4GKH182fkQ8RJ6t0bSS', 'MARCOS', 'MAMANI', '', '123123', 'CB', 'LOS OLIVOS', 'marcos@gmail.com', '7777777', 'CLIENTE', NULL, 1, '2024-04-08', '2024-04-08 15:45:24', '2024-04-08 15:46:45'),
(5, 'alberto@gmail.com', '$2y$12$95as.MevAI.w9oclvyUsY.7RWjjweCfPSgOXmGPzAFDC76IrkDXyO', 'ALBERTO', 'GONZALES', '', '78787878', 'LP', 'LOS OLIVOS', 'alberto@gmail.com', '7777777', 'AFILIADO', NULL, 1, '2024-04-09', '2024-04-09 15:24:29', '2024-04-09 15:24:29'),
(6, 'JUAN@GMAIL.COM', '$2y$12$mbovBCjyoUkYkHCc8H2Wv.4BFsfZL16onIy4P6/kxXfB5a0zAImNG', 'JUAN', 'PERES', '', '1111', 'LP', 'LOS OLIVOS', 'JUAN@GMAIL.COM', '777777', 'OPERADOR', NULL, 1, '2024-04-10', '2024-04-10 16:46:53', '2024-04-10 16:46:53'),
(7, 'carlos@gmail.com', '$2y$12$r0vh/Z.eQbxx/Mb9rB5uCefItMNYgy8B0p/17uDfWMM3yJckNHffC', 'CARLOS', 'GONZALES', '', '898789', 'CB', 'LOS OLIVOS', 'carlos@gmail.com', '7878787878', 'CLIENTE', NULL, 1, '2024-04-10', '2024-04-10 21:47:10', '2024-04-10 21:47:10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `afiliados`
--
ALTER TABLE `afiliados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `afiliados_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `apis`
--
ALTER TABLE `apis`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientes_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `configuracion_pagos`
--
ALTER TABLE `configuracion_pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `foto_productos`
--
ALTER TABLE `foto_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foto_productos_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `historial_accions`
--
ALTER TABLE `historial_accions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `institucions`
--
ALTER TABLE `institucions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orden_detalles`
--
ALTER TABLE `orden_detalles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orden_detalles_orden_venta_id_foreign` (`orden_venta_id`),
  ADD KEY `orden_detalles_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `orden_ventas`
--
ALTER TABLE `orden_ventas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orden_ventas_codigo_unique` (`codigo`),
  ADD KEY `configuracion_pago_id` (`configuracion_pago_id`);

--
-- Indices de la tabla `pago_afiliados`
--
ALTER TABLE `pago_afiliados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pago_afiliados_orden_venta_id_foreign` (`orden_venta_id`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productos_categoria_id_foreign` (`categoria_id`),
  ADD KEY `productos_producto_tamano_id_foreign` (`producto_tamano_id`),
  ADD KEY `productos_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `producto_tamanos`
--
ALTER TABLE `producto_tamanos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_usuario_unique` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `afiliados`
--
ALTER TABLE `afiliados`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `apis`
--
ALTER TABLE `apis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `configuracion_pagos`
--
ALTER TABLE `configuracion_pagos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `foto_productos`
--
ALTER TABLE `foto_productos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `historial_accions`
--
ALTER TABLE `historial_accions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `institucions`
--
ALTER TABLE `institucions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `orden_detalles`
--
ALTER TABLE `orden_detalles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `orden_ventas`
--
ALTER TABLE `orden_ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pago_afiliados`
--
ALTER TABLE `pago_afiliados`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `producto_tamanos`
--
ALTER TABLE `producto_tamanos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `afiliados`
--
ALTER TABLE `afiliados`
  ADD CONSTRAINT `afiliados_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `foto_productos`
--
ALTER TABLE `foto_productos`
  ADD CONSTRAINT `foto_productos_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `orden_detalles`
--
ALTER TABLE `orden_detalles`
  ADD CONSTRAINT `orden_detalles_orden_venta_id_foreign` FOREIGN KEY (`orden_venta_id`) REFERENCES `orden_ventas` (`id`),
  ADD CONSTRAINT `orden_detalles_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `orden_ventas`
--
ALTER TABLE `orden_ventas`
  ADD CONSTRAINT `orden_ventas_ibfk_1` FOREIGN KEY (`configuracion_pago_id`) REFERENCES `configuracion_pagos` (`id`);

--
-- Filtros para la tabla `pago_afiliados`
--
ALTER TABLE `pago_afiliados`
  ADD CONSTRAINT `pago_afiliados_orden_venta_id_foreign` FOREIGN KEY (`orden_venta_id`) REFERENCES `orden_ventas` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `productos_producto_tamano_id_foreign` FOREIGN KEY (`producto_tamano_id`) REFERENCES `producto_tamanos` (`id`),
  ADD CONSTRAINT `productos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
