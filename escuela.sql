-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-02-2023 a las 13:49:37
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `escuela`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnado`
--

CREATE TABLE `alumnado` (
  `expediente` int(5) NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `dni` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL,
  `direccion` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefonos` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre_padres` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `socio_banda` varchar(2) COLLATE utf8mb4_spanish_ci NOT NULL,
  `observaciones` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `codigo_G` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `alumnado`
--

INSERT INTO `alumnado` (`expediente`, `nombre`, `apellidos`, `fecha_nacimiento`, `dni`, `direccion`, `telefonos`, `nombre_padres`, `socio_banda`, `observaciones`, `email`, `codigo_G`) VALUES
(20, 'Antonio', 'awrgaw', '1992-09-09', '', '', '', '', 'fa', '', '', 1),
(21, 'Juan', 'Solo', '1992-06-08', '', '', '', '', 'fa', '', '', 2),
(22, 'Joni', 'mela', '1970-04-03', '', '', '', '', 'fa', '', '', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

CREATE TABLE `asignatura` (
  `codigo_A` int(5) NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `duracion_semanal` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `asignatura`
--

INSERT INTO `asignatura` (`codigo_A`, `nombre`, `duracion_semanal`) VALUES
(14, 'Flauta', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faltas`
--

CREATE TABLE `faltas` (
  `codigo_F` int(5) NOT NULL,
  `expediente` int(5) NOT NULL,
  `codigo_A` int(5) NOT NULL,
  `tipo` varchar(1) NOT NULL,
  `fecha` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `codigo_G` int(5) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`codigo_G`, `nombre`) VALUES
(1, 'A'),
(2, 'B');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas`
--

CREATE TABLE `matriculas` (
  `codigo_A` int(5) NOT NULL,
  `codigo_P` int(5) NOT NULL,
  `expediente` int(5) NOT NULL,
  `año_escolar` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL,
  `convocatoria` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `matriculas`
--

INSERT INTO `matriculas` (`codigo_A`, `codigo_P`, `expediente`, `año_escolar`, `convocatoria`) VALUES
(14, 28, 20, '2022-2023', 1),
(14, 29, 21, '2022-2023', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `codigo_P` int(5) NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `clave` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `admin` varchar(5) COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`codigo_P`, `nombre`, `clave`, `admin`) VALUES
(24, 'Antonio', 'a', 'si'),
(28, 'abraham', '28', 'si'),
(29, 'pedro', '29', ''),
(32, 'angus', '32', ''),
(34, 'kurt', '34', ''),
(35, 'angus', '35', ''),
(36, 'abraham', '36', ''),
(37, 'kurt', '37', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnado`
--
ALTER TABLE `alumnado`
  ADD PRIMARY KEY (`expediente`,`codigo_G`),
  ADD KEY `codigo_G` (`codigo_G`);

--
-- Indices de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD PRIMARY KEY (`codigo_A`);

--
-- Indices de la tabla `faltas`
--
ALTER TABLE `faltas`
  ADD PRIMARY KEY (`codigo_F`,`expediente`,`codigo_A`),
  ADD KEY `expediente` (`expediente`),
  ADD KEY `codigo_A` (`codigo_A`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`codigo_G`);

--
-- Indices de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD PRIMARY KEY (`codigo_A`,`codigo_P`,`expediente`,`año_escolar`),
  ADD KEY `matriculas_ibfk_1` (`codigo_P`),
  ADD KEY `matriculas_ibfk_3` (`expediente`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`codigo_P`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnado`
--
ALTER TABLE `alumnado`
  MODIFY `expediente` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  MODIFY `codigo_A` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `faltas`
--
ALTER TABLE `faltas`
  MODIFY `codigo_F` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `codigo_G` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `profesor`
--
ALTER TABLE `profesor`
  MODIFY `codigo_P` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnado`
--
ALTER TABLE `alumnado`
  ADD CONSTRAINT `alumnado_ibfk_1` FOREIGN KEY (`codigo_G`) REFERENCES `grupo` (`codigo_G`);

--
-- Filtros para la tabla `faltas`
--
ALTER TABLE `faltas`
  ADD CONSTRAINT `faltas_ibfk_3` FOREIGN KEY (`expediente`) REFERENCES `alumnado` (`expediente`),
  ADD CONSTRAINT `faltas_ibfk_4` FOREIGN KEY (`codigo_A`) REFERENCES `asignatura` (`codigo_A`);

--
-- Filtros para la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD CONSTRAINT `matriculas_ibfk_1` FOREIGN KEY (`codigo_P`) REFERENCES `profesor` (`codigo_P`),
  ADD CONSTRAINT `matriculas_ibfk_2` FOREIGN KEY (`codigo_A`) REFERENCES `asignatura` (`codigo_A`),
  ADD CONSTRAINT `matriculas_ibfk_3` FOREIGN KEY (`expediente`) REFERENCES `alumnado` (`expediente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
