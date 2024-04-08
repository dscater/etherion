-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 08-04-2024 a las 16:53:16
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
(1, 2, 'BANCO UNION', '10000011222', 1, '2024-04-08 15:10:05', '2024-04-08 15:10:05');

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
(1, 4, 1, '2024-04-08 15:45:24', '2024-04-08 15:45:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_pagos`
--

CREATE TABLE `configuracion_pagos` (
  `id` bigint UNSIGNED NOT NULL,
  `banco` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_cuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(7, 2, 'imagen21712595183_1.png', '2024-04-08 16:53:03', '2024-04-08 16:53:03');

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
(22, 2, 'MODIFICACIÓN', 'EL USUARIO  MODIFICÓ UN PRODUCTO', 'id: 2<br/>user_id: 2<br/>descripcion: PRODUCTO #1 AFILIADO 1<br/>categoria_id: 1<br/>producto_tamano_id: 1<br/>precio: 400.00<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 12:46:02<br/>updated_at: 2024-04-08 12:46:02<br/>', 'id: 2<br/>user_id: 2<br/>descripcion: PRODUCTO #1 AFILIADO 1<br/>categoria_id: 1<br/>producto_tamano_id: 1<br/>precio: 400.00<br/>fecha_registro: 2024-04-08<br/>created_at: 2024-04-08 12:46:02<br/>updated_at: 2024-04-08 12:46:02<br/>', 'PRODUCTOS', '2024-04-08', '12:53:03', '2024-04-08 16:53:03', '2024-04-08 16:53:03');

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
(1, 'ETHERION', 'ET', 'ETHERION S.A.', '11111111', 'LA PAZ', 'LOS OLIVOS', '7777777', 'ETHERION@GMAIL.COM', 'ETHERION.COM', 'ACTIVIDAD', '1710002413_1.jpg', 'smtp.hostinger.com', '587', 'tls', 'web@emsytsrl.com', 'ETHERION', '10-Co20re30oS', 'smtp', NULL, '2024-04-08 15:46:09');

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
  `comision_cat` double(24,2) NOT NULL,
  `comision_tam` double(24,2) NOT NULL,
  `precio_total` decimal(24,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_ventas`
--

CREATE TABLE `orden_ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `celular` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comprobante` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_sc` decimal(24,2) NOT NULL,
  `total` decimal(24,2) NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `user_id`, `descripcion`, `categoria_id`, `producto_tamano_id`, `precio`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(2, 2, 'PRODUCTO #1 AFILIADO 1', 1, 1, 400.00, '2024-04-08', '2024-04-08 16:46:02', '2024-04-08 16:46:02');

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
(4, 'marcos@gmail.com', '$2y$12$WyvGWNAM9qAb/P4qikQP8uREWqIlwuqMhX4GKH182fkQ8RJ6t0bSS', 'MARCOS', 'MAMANI', '', '123123', 'CB', 'LOS OLIVOS', 'marcos@gmail.com', '7777777', 'CLIENTE', NULL, 1, '2024-04-08', '2024-04-08 15:45:24', '2024-04-08 15:46:45');

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
  ADD UNIQUE KEY `orden_ventas_codigo_unique` (`codigo`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `configuracion_pagos`
--
ALTER TABLE `configuracion_pagos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `foto_productos`
--
ALTER TABLE `foto_productos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `historial_accions`
--
ALTER TABLE `historial_accions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden_ventas`
--
ALTER TABLE `orden_ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pago_afiliados`
--
ALTER TABLE `pago_afiliados`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `producto_tamanos`
--
ALTER TABLE `producto_tamanos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
