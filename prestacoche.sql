-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2026 a las 20:23:38
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

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `matricula`, `id_usuario`, `fecha_inicio`, `fecha_fin`, `created_at`, `estado`) VALUES
(1, '1234ABC', 22, '2026-05-10', '2026-05-15', '2026-05-14 06:42:59', 'confirmada');

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
(20, 'María Teresa', 'Freire Pardo', 'a@a', '1', '45148222A', '', NULL, '680486941', '2026-05-21', 'Vilar de Astrés, nº39', 'WhatsApp Image 2026-05-06 at 16.14.36.jpeg', 'no', 'admin'),
(21, 'María Teresa', 'Freire Pardo', 'b@b', 'b', '45148222b', '', NULL, '680486939', '2026-05-29', 'Vilar de Astrés, nº39', 'WhatsApp Image 2026-05-06 at 16.14.36.jpeg', 'no', 'user'),
(22, 'María Teresa', 'Freire Pardo', 'c@c', '3', '45148222c', '', NULL, '680486941', '2026-05-22', 'Vilar de Astrés, nº39', 'descarga.jpg', 'si', 'user'),
(23, 'María Teresa', 'Freire Pardo', 'd@d', 'd', 'descarga.', '', NULL, '680486941', '2026-05-14', 'Vilar de Astrés, nº39', 'Calendario_FCT.png', 'no', 'user'),
(24, 'María Teresa', 'Freire Pardo', 'e@e', 'e', '234', 'dni_6a0de64546e4d9.91943077_logo_prestacoche.png', NULL, '680486941', '2026-05-07', 'Vilar de Astrés, nº39', 'license_6a0de645470612.57678508_logo_instagram.png', 'no', 'user'),
(25, 'María Teresa', 'Freire Pardo', 'f@f', 'f', '12345678f', '12345678f_410_dni.png', NULL, '680486941', '2026-05-13', 'Vilar de Astrés, nº39', '12345678f_935_carnet.png', 'no', 'user'),
(27, 'María Teresa', 'Freire Pardo', 'abc@abc', 'abc', '12345abc', '12345abc_841_dni.png', '2026-05-07', '680486941', '2026-05-21', 'Vilar de Astrés, nº39', '12345abc_754_carnet.png', 'no', 'user');

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
('0010ACB', 22, 'Opel', 'Corsa', 0, 'utilitario', 'gasolina', 63500, 'manual', 'pendente', 2021, 50.00, 0.20, 'Vilar de Astrés, nº39', '1778741467_Calendario_FCT.png'),
('1234A', 22, 'Opel', 'Astra', 130, 'utilitario', 'gasolina', 65000, 'manual', 'pendente', 2025, 30.00, 0.10, 'Vilar de Astrés, nº39', '1779372558_fondo_home_p.png'),
('1234ABC', 21, 'Fiat', '500', 0, 'utilitario', 'gasolina', 45200, 'manual', 'validado', 2021, 35.00, 0.20, 'Calle Mayor 12, Madrid', 'Fiat.jpg'),
('2977CZV', 21, 'Audi', 'A4', 0, 'utilitario', 'diesel', 219998, 'manual', 'pendente', 2002, 25.00, 0.10, 'Vilar de Astrés, nº39', '1778433245_Calendario_FCT.png'),
('3456JKL', 21, 'Audi', 'A4', 0, 'utilitario', 'diesel', 61000, 'automatico', 'validado', 2020, 60.00, 0.35, 'Gran Via 44, Vigo', 'Fiat.jpg'),
('3913LTD', 21, 'Opel', 'Corsa', 0, 'utilitario', 'gasolina', 65000, 'manual', 'pendente', 2021, 50.00, 0.18, 'Vilar de Astrés, nº39', '1778432858_WhatsApp Image 2026-05-06 at 16.14.44 (1).jpeg'),
('5916acv', 22, 'Peugeot', '208', 50, 'utilitario', 'diesel', 65000, 'automatico', 'pendente', 2019, 50.00, 0.20, 'Vilar de astres', '5916acv_584_coche.png'),
('7890MNO', 21, 'Toyota', 'Corolla', 0, 'utilitario', 'gasolina', 33000, 'automatico', 'pendente', 2022, 50.00, 0.22, 'Calle Real 9, A Coruña', 'Fiat.jpg'),
('9012GHI', 21, 'BMW', 'Serie 3', 0, 'utilitario', 'gasolina', 25000, 'automatico', 'pendente', 2023, 75.00, 0.35, 'Rua do Paseo 18, Ourense', 'Fiat.jpg'),
('9473LWY', 21, 'Peugeot', '208', 0, 'utilitario', 'diesel', 45000, 'manual', 'pendente', 2021, 60.00, 0.15, 'Vilar de Astrés, nº39', '1778432994_descarga (1).jpg');

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
(39, '1234ABC', '2026-05-19', 1, NULL),
(40, '1234ABC', '2026-05-20', 1, NULL),
(41, '1234ABC', '2026-05-21', 0, 22),
(42, '1234ABC', '2026-05-22', 0, 22),
(43, '1234ABC', '2026-05-23', 0, 22),
(44, '1234ABC', '2026-05-24', 0, 22),
(45, '3456JKL', '2026-05-23', 1, NULL),
(46, '3456JKL', '2026-05-24', 0, 22),
(47, '3456JKL', '2026-05-25', 1, NULL),
(48, '3456JKL', '2026-05-26', 1, NULL),
(49, '3456JKL', '2026-05-27', 0, 22),
(50, '3456JKL', '2026-05-28', 1, NULL),
(51, '3456JKL', '2026-05-29', 0, 22),
(52, '3456JKL', '2026-05-30', 0, 22),
(53, '3456JKL', '2026-05-31', 1, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `vehiculos_disponibilidad`
--
ALTER TABLE `vehiculos_disponibilidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

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
