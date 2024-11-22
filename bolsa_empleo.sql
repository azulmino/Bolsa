-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2024 a las 22:02:41
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
-- Base de datos: `bolsa_empleo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `idCurso` int(11) NOT NULL,
  `anio` int(11) DEFAULT NULL,
  `division` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`idCurso`, `anio`, `division`) VALUES
(1, 7, 2),
(2, 6, 2),
(3, 4, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario`
--

CREATE TABLE `formulario` (
  `idFormulario` int(11) NOT NULL,
  `nombre_apellido` varchar(100) DEFAULT NULL,
  `gmail` varchar(45) DEFAULT NULL,
  `telefono` int(20) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `anio_egreso` date DEFAULT NULL,
  `Tecnicatura_idTecnicatura` int(11) NOT NULL,
  `Curso_idCurso` int(11) NOT NULL,
  `Pasantias_idPasantias` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasantias`
--

CREATE TABLE `pasantias` (
  `idPasantias` int(11) NOT NULL,
  `Nombre_Empresa` varchar(50) NOT NULL,
  `tutor` varchar(50) NOT NULL,
  `telefono` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnicatura`
--

CREATE TABLE `tecnicatura` (
  `idTecnicatura` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tecnicatura`
--

INSERT INTO `tecnicatura` (`idTecnicatura`, `nombre`) VALUES
(1, 'Informatica'),
(2, 'Maestro mayor de obra'),
(3, 'Electro'),
(4, 'Electro');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`idCurso`);

--
-- Indices de la tabla `formulario`
--
ALTER TABLE `formulario`
  ADD PRIMARY KEY (`idFormulario`),
  ADD KEY `fk_formulario_Tecnicatura` (`Tecnicatura_idTecnicatura`),
  ADD KEY `fk_formulario_Curso` (`Curso_idCurso`),
  ADD KEY `fk_formulario_pasantias` (`Pasantias_idPasantias`);

--
-- Indices de la tabla `pasantias`
--
ALTER TABLE `pasantias`
  ADD PRIMARY KEY (`idPasantias`);

--
-- Indices de la tabla `tecnicatura`
--
ALTER TABLE `tecnicatura`
  ADD PRIMARY KEY (`idTecnicatura`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `idCurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `formulario`
--
ALTER TABLE `formulario`
  MODIFY `idFormulario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `pasantias`
--
ALTER TABLE `pasantias`
  MODIFY `idPasantias` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tecnicatura`
--
ALTER TABLE `tecnicatura`
  MODIFY `idTecnicatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `formulario`
--
ALTER TABLE `formulario`
  ADD CONSTRAINT `fk_formulario_Curso` FOREIGN KEY (`Curso_idCurso`) REFERENCES `curso` (`idCurso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_formulario_Tecnicatura` FOREIGN KEY (`Tecnicatura_idTecnicatura`) REFERENCES `tecnicatura` (`idTecnicatura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_formulario_pasantias` FOREIGN KEY (`Pasantias_idPasantias`) REFERENCES `pasantias` (`idPasantias`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
