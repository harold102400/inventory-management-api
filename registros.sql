-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2024 a las 14:47:59
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `registros`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id`, `codigo`, `nombre`, `tipo`, `marca`, `precio`) VALUES
(1, '2462', 'Llave Chorro 3/4', 'Llave plastica', 'Veno', 70.00),
(2, '2463', 'Llave c/candado 1/2', 'Llave con candado 1/2', 'Tor', 200.00),
(3, '2464', 'Llave bola 1/2', 'Llave para manguera 1/2', 'Truper', 275.00),
(4, '2465', 'Interruptor S. Tomacorriente', 'I/T Sencillo', 'Kolny', 170.00),
(5, '2466', 'Tomacorriente puerto USB', 'Con entrada USB', 'Venno', 300.00),
(7, '1000', 'Blanco 100', 'Galon para interior', 'ECOPAINT', 500.00),
(8, '1001', 'Marfil 157', 'Galon para interior', 'ECOPAINT', 490.00),
(9, '1002', 'Colonial 125', 'Galon para interior', 'ECOPAINT', 490.00),
(10, '1003', 'Salmón 103', 'Galon para interior', 'ECOPAINT', 490.00),
(11, '1004', 'Amarillo Fiesta', 'Galon para interior', 'ECOPAINT', 490.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
