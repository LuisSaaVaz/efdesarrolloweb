-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-07-2026 a las 12:24:24
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `examen`
--
CREATE DATABASE IF NOT EXISTS `examen` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `examen`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cli` int(3) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` char(9) DEFAULT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_cli`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cli`, `nombre`, `email`, `telefono`, `fecha_alta`) VALUES
(1, 'Luis', 'luis@efmail.luis', '666666666', '2026-07-30 08:15:47'),
(2, 'Manuel', 'luis@efmail.luis', '777777777', '2026-07-30 08:16:47'),
(3, 'Marcia', 'luis@efmail.luis', '888888888', '2026-07-30 08:25:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ids`
--

CREATE TABLE IF NOT EXISTS `ids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tabla` varchar(50) NOT NULL,
  `lastId` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tabla` (`tabla`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ids`
--

INSERT INTO `ids` (`id`, `tabla`, `lastId`) VALUES
(1, 'clientes', 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
