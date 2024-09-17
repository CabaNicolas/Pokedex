-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-09-2024 a las 18:55:48
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
-- Base de datos: `pokedex`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evolucion`
--

CREATE TABLE `evolucion` (
  `id_poke` int(11) NOT NULL,
  `id_poke2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `evolucion`
--

INSERT INTO `evolucion` (`id_poke`, `id_poke2`) VALUES
(1, 2),
(2, 1),
(3, 4),
(4, 3),
(5, 6),
(6, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pokemon`
--

CREATE TABLE `pokemon` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `imagen` text NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pokemon`
--

INSERT INTO `pokemon` (`id`, `numero`, `nombre`, `imagen`, `descripcion`) VALUES
(1, 4, 'Charmander', 'Imagenes/Charmander.webp', 'Charmander es un pequeño monstruo bípedo parecido a un lagarto. Sus características de fuego son resaltadas por su color de piel anaranjado y su cola, cuya punta está envuelta en llamas. Estas llamas indican su fuerza vital. Si está débil, las llamas arderán más tenue.\r\n'),
(2, 5, 'Charmeleon', 'Imagenes/Charmeleon.webp', 'Charmeleon es un gran lagarto bípedo con escamas de color rojo oscuro y en la parte inferior de color crema, posee como característica general una llama en la punta de su cola al igual que Charmander y Charizard. Es un Pokemon orgulloso que ama las batallas, esgrime su cola para elevar la temperatura y buscando derribar al oponente.\r\n'),
(3, 1, 'Bulbasaur', 'Imagenes/Bulbasaur.webp', '\'Bulbasaur es un Pokémon tipo Planta/Veneno. Es conocido por tener una planta en su espalda que crece con él desde que nace.\''),
(4, 2, 'Ivysaur', 'Imagenes/Ivysaur.webp', '\'Ivysaur es la forma evolucionada de Bulbasaur. La planta en su espalda ha crecido más y ahora tiene un brote de flor.\''),
(5, 7, 'Squirtle', 'Imagenes/Squirtle.webp', '\'Squirtle es un Pokémon tipo Agua. Es una pequeña tortuga azul que utiliza su caparazón para defenderse de ataques y disparar agua con fuerza.\''),
(6, 8, 'Wartortle', 'Imagenes/Wartortle.webp', '\'Wartortle es la evolución de Squirtle. Tiene orejas peludas y su cola se ha vuelto más grande, lo que lo hace nadar con mayor agilidad.\'');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id`, `nombre`) VALUES
(1, 'Imagenes/fuego.webp'),
(2, 'Imagenes/hierba.webp'),
(3, 'Imagenes/agua.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pokemon`
--

CREATE TABLE `tipo_pokemon` (
  `id_pokemon` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_pokemon`
--

INSERT INTO `tipo_pokemon` (`id_pokemon`, `id_tipo`) VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 2),
(5, 3),
(6, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `evolucion`
--
ALTER TABLE `evolucion`
  ADD PRIMARY KEY (`id_poke`,`id_poke2`),
  ADD KEY `Evolucion` (`id_poke2`);

--
-- Indices de la tabla `pokemon`
--
ALTER TABLE `pokemon`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_numero` (`numero`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_pokemon`
--
ALTER TABLE `tipo_pokemon`
  ADD KEY `Pokemon_FK` (`id_pokemon`),
  ADD KEY `Tipo_FK` (`id_tipo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pokemon`
--
ALTER TABLE `pokemon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `evolucion`
--
ALTER TABLE `evolucion`
  ADD CONSTRAINT `Evolucion` FOREIGN KEY (`id_poke2`) REFERENCES `pokemon` (`id`),
  ADD CONSTRAINT `Evolucion2` FOREIGN KEY (`id_poke`) REFERENCES `pokemon` (`id`);

--
-- Filtros para la tabla `tipo_pokemon`
--
ALTER TABLE `tipo_pokemon`
  ADD CONSTRAINT `Pokemon_FK` FOREIGN KEY (`id_pokemon`) REFERENCES `pokemon` (`id`),
  ADD CONSTRAINT `Tipo_FK` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
