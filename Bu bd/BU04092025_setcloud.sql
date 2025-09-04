-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-09-2025 a las 16:45:10
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `setcloud`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hoja_pauta`
--

CREATE TABLE `hoja_pauta` (
  `id_hpauta` int(10) NOT NULL,
  `num_hpauta` varchar(10) NOT NULL,
  `id_novela` int(10) NOT NULL,
  `id_ubic_rodaje` int(10) NOT NULL,
  `id_momento_dia` int(10) NOT NULL,
  `fecha` date NOT NULL,
  `director` varchar(50) NOT NULL,
  `df` varchar(50) NOT NULL,
  `script` varchar(50) NOT NULL,
  `sonido` varchar(50) NOT NULL,
  `dia_ficcion` varchar(100) NOT NULL,
  `locacion` varchar(100) NOT NULL,
  `personajes` varchar(500) NOT NULL,
  `nota` varchar(500) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novela`
--

CREATE TABLE `novela` (
  `id_novela` int(10) NOT NULL,
  `novela` varchar(100) NOT NULL,
  `director_n` varchar(50) NOT NULL,
  `df_n` varchar(50) NOT NULL,
  `script_n` varchar(50) NOT NULL,
  `sonido_n` varchar(50) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `novela`
--

INSERT INTO `novela` (`id_novela`, `novela`, `director_n`, `df_n`, `script_n`, `sonido_n`, `estado`) VALUES
(4, 'Luz de Luna 4', 'Ani', 'Miguel', 'Luvi', 'Christian Cuba', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_pautas`
--

CREATE TABLE `registro_pautas` (
  `id_registro_pauta` int(10) NOT NULL,
  `id_hpauta` varchar(10) NOT NULL,
  `capitulo` varchar(10) NOT NULL,
  `escena` varchar(10) NOT NULL,
  `plano` varchar(10) NOT NULL,
  `toma` varchar(10) NOT NULL,
  `retoma` varchar(10) NOT NULL,
  `clip_cam1` varchar(10) NOT NULL,
  `time_cam1` varchar(10) NOT NULL,
  `clip_cam2` varchar(10) NOT NULL,
  `time_cam2` varchar(10) NOT NULL,
  `clip_cam3` varchar(10) NOT NULL,
  `time_cam3` varchar(10) NOT NULL,
  `clip_cam4` varchar(10) DEFAULT NULL,
  `time_cam4` varchar(10) DEFAULT NULL,
  `clip_cam5` varchar(10) DEFAULT NULL,
  `time_cam5` varchar(10) DEFAULT NULL,
  `vb` int(1) DEFAULT NULL,
  `obs` varchar(500) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

CREATE TABLE `sesiones` (
  `id_sesion` int(10) NOT NULL,
  `id_orden` decimal(10,3) NOT NULL,
  `identificador` int(5) NOT NULL,
  `id_user` int(10) NOT NULL,
  `estado_sesion` int(1) NOT NULL,
  `sesion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sesiones`
--

INSERT INTO `sesiones` (`id_sesion`, `id_orden`, `identificador`, `id_user`, `estado_sesion`, `sesion`) VALUES
(1, 1.000, 1, 1, 1, 'Módulo Gestión de Usuarios'),
(2, 2.000, 2, 1, 1, 'Crear/editar/eliminar Producción'),
(3, 3.000, 3, 1, 1, 'Crear/editar/eliminar Hojas de Pauta'),
(4, 4.000, 4, 1, 1, 'Crear/editar/eliminar Pautas'),
(5, 5.000, 5, 1, 1, 'Editar Notas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `pass` char(60) NOT NULL,
  `estado` varchar(1) NOT NULL,
  `cargo` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `nombre`, `usuario`, `pass`, `estado`, `cargo`) VALUES
(1, 'Administrador pruebas', 'admin', '$2y$10$KPq4FUK37Zj75Khb0JINJ.onGDhLW9KnqB8imzEzZiKwXDXvo8fGy', 'A', 'Script');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `hoja_pauta`
--
ALTER TABLE `hoja_pauta`
  ADD PRIMARY KEY (`id_hpauta`);

--
-- Indices de la tabla `novela`
--
ALTER TABLE `novela`
  ADD PRIMARY KEY (`id_novela`);

--
-- Indices de la tabla `registro_pautas`
--
ALTER TABLE `registro_pautas`
  ADD PRIMARY KEY (`id_registro_pauta`);

--
-- Indices de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD PRIMARY KEY (`id_sesion`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `hoja_pauta`
--
ALTER TABLE `hoja_pauta`
  MODIFY `id_hpauta` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `novela`
--
ALTER TABLE `novela`
  MODIFY `id_novela` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `registro_pautas`
--
ALTER TABLE `registro_pautas`
  MODIFY `id_registro_pauta` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  MODIFY `id_sesion` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
