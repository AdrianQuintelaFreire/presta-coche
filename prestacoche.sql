-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-05-2026 a las 13:52:52
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

CREATE DATABASE IF NOT EXISTS prestacoche
DEFAULT CHARACTER SET utf8mb4
DEFAULT COLLATE utf8mb4_general_ci;

USE prestacoche;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prestacoche`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `matricula` varchar(7) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','confirmada','cancelada','finalizada') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `apelidos` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contrasinal` varchar(255) NOT NULL,
  `DNI` varchar(9) NOT NULL,
  `foto_dni` varchar(255) NOT NULL,
  `fecha_caducidad_dni` date DEFAULT NULL,
  `telefono` varchar(15) NOT NULL,
  `data_nacemento` date NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `permiso_conducir` varchar(255) NOT NULL,
  `validado` enum('si','no') NOT NULL DEFAULT 'no',
  `rol` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `apelidos`, `email`, `contrasinal`, `DNI`, `foto_dni`, `fecha_caducidad_dni`, `telefono`, `data_nacemento`, `direccion`, `permiso_conducir`, `validado`, `rol`) VALUES
(30, 'Adrián', 'Quintela Freire', 'adrianquintela2003@gmail.com', '$2y$10$BqSFmTXpn9uXxGYqcLlavO7giI98Ve58Bh9NIIW1aGAD9ET.iWcWi', '44556677G', '44556677G_213_dni.jpg', '2028-10-11', '690123456', '2003-12-26', 'Vilar de Astrés, Ourense', '44556677G_995_carnet.jpg', 'si', 'admin'),
(31, 'Juan', 'Pérez García', 'juanperez@gmail.com', '$2y$10$PkvPPigcA/Ui1FX4jz9ZfOQJlaz7JH.vcnTTbNlnt1RHFNpNabywq', '40501020X', '40501020X_523_dni.jpg', '2029-05-23', '610203040', '1990-01-24', 'Avenido de Progreso, Ourense', '40501020X_231_carnet.jpg', 'si', 'user'),
(32, 'María', 'González Nóvoa', 'mariagonzalez@gmail.com', '$2y$10$sVbvWBrLYsAJDQoO0SgHyuZ3p4MPtNty.w9pzy9K53JyAPWPyT9f2', '50237862B', '50237862B_786_dni.jpg', '2030-05-07', '625102030', '1985-01-24', 'Avenida de Santiago, Ourense', '50237862B_97_carnet.jpg', 'si', 'user'),
(33, 'Mauro', 'Gomez Delgado', 'maurogomez@gmail.com', '$2y$10$kT2b3ZUP1/PMj47Lq4Hl4eeR588qQNZHhMj.d7451rPwXLa586nCi', '52123040D', '52123040D_146_dni.jpg', '2028-01-21', '680402030', '2000-01-01', 'Avenida de Portugal, Ourense', '52123040D_477_carnet.jpg', 'no', 'user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `matricula` varchar(7) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `potencia` int(11) NOT NULL,
  `tamano` enum('utilitario','mediano','grande') NOT NULL,
  `combustible` enum('gasolina','diesel','hibrido','electrico','glp') NOT NULL,
  `kilometraxe` int(11) NOT NULL,
  `tipo_cambio` enum('manual','automatico') NOT NULL,
  `estado` enum('pendente','validado') NOT NULL,
  `año` int(11) NOT NULL,
  `precio_dia` decimal(10,2) NOT NULL,
  `precio_km` decimal(10,2) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`matricula`, `id_usuario`, `marca`, `modelo`, `potencia`, `tamano`, `combustible`, `kilometraxe`, `tipo_cambio`, `estado`, `año`, `precio_dia`, `precio_km`, `direccion`, `foto`) VALUES
('1111BCD', 31, 'Opel', 'Tucson', 50, 'grande', 'electrico', 1500, 'automatico', 'pendente', 2004, 149.99, 2.95, 'Calle Ervedelo, 3', '1111BCD_30_coche.jpg'),
('3341JVN', 31, 'Audi', 'S4', 250, 'mediano', 'gasolina', 44998, 'automatico', 'validado', 2020, 60.00, 0.30, 'Rúa do Progreso, 39', '3341JVN_132_coche.jpeg'),
('6049LVN', 31, 'Tesla', 'Model 3', 300, 'mediano', 'electrico', 55000, 'automatico', 'pendente', 2018, 70.00, 0.25, 'Rúa Vicente Risco, 3', '6049LVN_616_coche.jpeg'),
('7104LSZ', 31, 'Opel', 'Corsa-e', 150, 'utilitario', 'hibrido', 45000, 'automatico', 'pendente', 2022, 50.00, 0.25, 'Rúa Eulogio Gómez Franqueira, 3', '7104LSZ_751_coche.jpg'),
('7409MNG', 31, 'Peugeot', '208', 100, 'utilitario', 'diesel', 30000, 'manual', 'validado', 2023, 55.00, 0.25, 'Avenida de Santiago, 239', '7409MNG_457_coche.jpg'),
('8728MBK', 31, 'BMW', 'x1', 220, 'grande', 'hibrido', 30000, 'automatico', 'validado', 2025, 90.00, 0.35, 'Avenida da Habana, 3', '8728MBK_369_coche.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_disponibilidad`
--

CREATE TABLE `vehiculos_disponibilidad` (
  `id` int(11) NOT NULL,
  `matricula` varchar(7) NOT NULL,
  `fecha` date NOT NULL,
  `disponible` tinyint(1) DEFAULT 1,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos_disponibilidad`
--

INSERT INTO `vehiculos_disponibilidad` (`id`, `matricula`, `fecha`, `disponible`, `user_id`) VALUES
(218, '3341JVN', '2026-05-25', 1, NULL),
(219, '3341JVN', '2026-05-26', 1, NULL),
(220, '3341JVN', '2026-05-27', 1, NULL),
(221, '3341JVN', '2026-05-28', 1, NULL),
(222, '3341JVN', '2026-06-01', 1, NULL),
(223, '3341JVN', '2026-06-02', 1, NULL),
(224, '3341JVN', '2026-06-03', 1, NULL),
(225, '3341JVN', '2026-06-04', 1, NULL),
(226, '3341JVN', '2026-06-08', 1, NULL),
(227, '3341JVN', '2026-06-09', 1, NULL),
(228, '3341JVN', '2026-06-10', 1, NULL),
(229, '3341JVN', '2026-06-11', 1, NULL),
(230, '3341JVN', '2026-06-15', 1, NULL),
(231, '3341JVN', '2026-06-16', 1, NULL),
(232, '3341JVN', '2026-06-17', 1, NULL),
(233, '3341JVN', '2026-06-18', 1, NULL),
(234, '3341JVN', '2026-06-22', 0, 32),
(235, '3341JVN', '2026-06-23', 0, 32),
(236, '3341JVN', '2026-06-24', 0, 32),
(237, '3341JVN', '2026-06-25', 1, NULL),
(263, '7409MNG', '2026-05-28', 1, NULL),
(264, '7409MNG', '2026-05-29', 1, NULL),
(265, '7409MNG', '2026-05-30', 1, NULL),
(266, '7409MNG', '2026-05-31', 1, NULL),
(267, '7409MNG', '2026-06-03', 1, NULL),
(268, '7409MNG', '2026-06-04', 1, NULL),
(269, '7409MNG', '2026-06-05', 1, NULL),
(270, '7409MNG', '2026-06-06', 1, NULL),
(271, '7409MNG', '2026-06-07', 1, NULL),
(272, '7409MNG', '2026-06-10', 1, NULL),
(273, '7409MNG', '2026-06-11', 1, NULL),
(274, '7409MNG', '2026-06-12', 1, NULL),
(275, '7409MNG', '2026-06-13', 1, NULL),
(276, '7409MNG', '2026-06-14', 1, NULL),
(277, '7409MNG', '2026-06-17', 1, NULL),
(278, '7409MNG', '2026-06-18', 1, NULL),
(279, '7409MNG', '2026-06-19', 1, NULL),
(280, '7409MNG', '2026-06-20', 1, NULL),
(281, '7409MNG', '2026-06-21', 1, NULL),
(282, '7409MNG', '2026-06-24', 1, NULL),
(283, '7409MNG', '2026-06-25', 1, NULL),
(284, '7409MNG', '2026-06-26', 0, 32),
(285, '7409MNG', '2026-06-27', 0, 32),
(286, '7409MNG', '2026-06-28', 0, 32),
(287, '7409MNG', '2026-05-27', 1, NULL),
(313, '8728MBK', '2026-05-26', 1, NULL),
(314, '8728MBK', '2026-05-27', 1, NULL),
(315, '8728MBK', '2026-05-28', 1, NULL),
(316, '8728MBK', '2026-05-29', 1, NULL),
(317, '8728MBK', '2026-05-30', 1, NULL),
(318, '8728MBK', '2026-06-02', 1, NULL),
(319, '8728MBK', '2026-06-03', 1, NULL),
(320, '8728MBK', '2026-06-04', 1, NULL),
(321, '8728MBK', '2026-06-05', 1, NULL),
(322, '8728MBK', '2026-06-06', 1, NULL),
(323, '8728MBK', '2026-06-09', 1, NULL),
(324, '8728MBK', '2026-06-10', 1, NULL),
(325, '8728MBK', '2026-06-11', 1, NULL),
(326, '8728MBK', '2026-06-12', 1, NULL),
(327, '8728MBK', '2026-06-13', 1, NULL),
(328, '8728MBK', '2026-06-16', 1, NULL),
(329, '8728MBK', '2026-06-17', 1, NULL),
(330, '8728MBK', '2026-06-18', 1, NULL),
(331, '8728MBK', '2026-06-19', 1, NULL),
(332, '8728MBK', '2026-06-20', 1, NULL),
(333, '8728MBK', '2026-06-23', 1, NULL),
(334, '8728MBK', '2026-06-24', 1, NULL),
(335, '8728MBK', '2026-06-25', 0, 32),
(336, '8728MBK', '2026-06-26', 1, NULL),
(337, '8728MBK', '2026-06-27', 1, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `matricula` (`matricula`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `DNI` (`DNI`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`matricula`),
  ADD KEY `fk_usuario` (`id_usuario`);

--
-- Indices de la tabla `vehiculos_disponibilidad`
--
ALTER TABLE `vehiculos_disponibilidad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matricula` (`matricula`,`fecha`),
  ADD KEY `fk_vehiculos_usuario` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `vehiculos_disponibilidad`
--
ALTER TABLE `vehiculos_disponibilidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=338;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `vehiculos` (`matricula`) ON DELETE CASCADE;

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `vehiculos_disponibilidad`
--
ALTER TABLE `vehiculos_disponibilidad`
  ADD CONSTRAINT `fk_vehiculos_usuario` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vehiculos_disponibilidad_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `vehiculos` (`matricula`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE USER IF NOT EXISTS 'prestacoche_user'@'localhost'
IDENTIFIED BY 'C0NTR1S3Ñ1';

GRANT ALL PRIVILEGES ON prestacoche.* TO 'prestacoche_user'@'localhost';

FLUSH PRIVILEGES;