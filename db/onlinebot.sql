-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-01-2022 a las 02:14:50
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `onlinebot`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asesores`
--

CREATE TABLE `asesores` (
  `id` int(11) NOT NULL,
  `cedula` varchar(15) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `totalTramitesAsignados` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asesores`
--

INSERT INTO `asesores` (`id`, `cedula`, `nombre`, `email`, `telefono`, `totalTramitesAsignados`) VALUES
(2, '123456785', 'nactualizado', 'email@actualizado.cpm', '3140000', '1'),
(3, '485697895', 'asesor postman', 'postman@pruebas.com', '5480000', '0'),
(4, '485697895', 'asesor postman', 'postman@pruebas.com', '5480000', '0'),
(6, '485697895', 'asesor postman', 'postman@pruebas.com', '5480000', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `citas` datetime NOT NULL,
  `cedula` varchar(15) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `correo` varchar(30) NOT NULL,
  `celular` varchar(15) NOT NULL,
  `estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `citas`, `cedula`, `nombre`, `correo`, `celular`, `estado`) VALUES
(29, '2021-06-02 07:00:00', '', '', '', '', 'disponible'),
(30, '2021-06-02 09:00:00', '', '', '', '', 'disponible'),
(31, '2021-06-10 10:40:00', '123456789', 'ca', 'ca@ca.ocm', '5480000', 'ocupado'),
(32, '2021-06-10 12:00:00', '', '', '', '', 'disponible'),
(33, '2021-06-12 10:40:00', '', '', '', '', 'disponible'),
(34, '2021-06-11 12:00:00', '', '', '', '', 'disponible'),
(35, '2021-06-15 07:00:00', '', '', '', '', 'disponible'),
(36, '2021-06-15 09:00:00', '', '', '', '', 'disponible'),
(37, '2021-06-15 11:00:00', '', '', '', '', 'disponible'),
(38, '2021-06-15 13:00:00', '', '', '', '', 'disponible'),
(39, '2021-06-15 15:00:00', '', '', '', '', 'disponible'),
(40, '2021-06-15 17:00:00', '', '', '', '', 'disponible'),
(41, '2021-06-24 15:00:00', '', '', '', '', 'disponible'),
(42, '2021-06-24 17:00:00', '', '', '', '', 'disponible'),
(43, '2021-06-24 19:00:00', '', '', '', '', 'disponible'),
(44, '2021-06-24 21:00:00', '', '', '', '', 'disponible'),
(45, '2021-06-24 23:00:00', '', '', '', '', 'disponible'),
(46, '2021-07-15 07:00:00', '', '', '', '', 'disponible'),
(47, '2021-07-15 09:00:00', '', '', '', '', 'disponible'),
(48, '2021-08-15 07:00:00', '', '', '', '', 'disponible'),
(49, '2021-08-15 09:00:00', '', '', '', '', 'disponible');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asesores`
--
ALTER TABLE `asesores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asesores`
--
ALTER TABLE `asesores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
