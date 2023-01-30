-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 30-01-2023 a las 15:02:59
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `login`
--
CREATE DATABASE IF NOT EXISTS `login` DEFAULT CHARACTER SET utf32 COLLATE utf32_spanish2_ci;
USE `login`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf32_spanish2_ci NOT NULL,
  `email` varchar(100) COLLATE utf32_spanish2_ci NOT NULL,
  `password` varchar(100) COLLATE utf32_spanish2_ci NOT NULL,
  `user_type` varchar(20) COLLATE utf32_spanish2_ci NOT NULL DEFAULT 'user',
  `image` varchar(100) COLLATE utf32_spanish2_ci NOT NULL,
  `bio` varchar(200) COLLATE utf32_spanish2_ci NOT NULL,
  `phone` varchar(15) COLLATE utf32_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `image`, `bio`, `phone`) VALUES
(1, 'Britt Nichole', 'brittnichole@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'user', 'img-2.jpg', '¡Desarrolladora de Software y apasionada en programar en FUNVAL', '9512778906');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
