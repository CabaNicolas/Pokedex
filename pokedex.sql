-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-09-2024 a las 21:57:36
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
(1, 35),
(2, 1),
(2, 35),
(3, 4),
(3, 7),
(4, 3),
(4, 7),
(5, 6),
(5, 9),
(6, 5),
(6, 9),
(7, 3),
(7, 4),
(9, 5),
(9, 6),
(35, 1),
(35, 2),
(40, 41),
(40, 42),
(41, 40),
(41, 42),
(42, 40),
(42, 41),
(43, 44),
(43, 45),
(44, 43),
(44, 45),
(45, 43),
(45, 44),
(46, 47),
(46, 48),
(47, 46),
(47, 48),
(48, 46),
(48, 47);

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
(1, 4, 'Charmander', 'Charmander.webp', 'Su nombre es una contracción de las palabras en inglés charcoal (carbón) y salamander (salamandra). Su nombre japonés, Hitokage, proviene de 火蜥蜴 (salamandra de fuego), siendo 火 hi \"fuego\" y 蜥蜴 tokage \"lagarto\". Su nombre francés, Salameche, proviene de las palabras en francés salamandre (salamandra) y mèche (mecha).'),
(2, 5, 'Charmeleon', 'Charmeleon.webp', 'Su nombre es una contracción de las palabras inglesas char (carbonizar, quemar) y chameleon (camaleón). Su nombre japonés, lizardo, es simplemente la escritura en katakana de la palabra lizard (lagarto en inglés). Su nombre francés, reptincel, proviene de las palabras reptil (reptil) y étincelle (chispa).'),
(3, 1, 'Bulbasaur', 'Bulbasaur.webp', 'Su nombre proviene de las palabras en inglés bulb (bulbo) y saur, traducción al inglés de la palabra griega saûros (reptil o lagarto).'),
(4, 2, 'Ivysaur', 'Ivysaur.webp', 'Su nombre proviene de las palabras en inglés ivy (hiedra) y saur, traducción al inglés de la palabra griega saûros (reptil o lagarto).'),
(5, 7, 'Squirtle', 'Squirtle.webp', 'Su nombre proviene de las palabras en inglés squirt (disparar un chorro de agua) y turtle (tortuga). Su nombre en japonés es Zenigame, es simplemente la palabra japonesa para tortuga de estanque, 銭亀. Su nombre francés, Carapuce, proviene de las palabras carapace (caparazón) y puce (pulga, en referencia a su tamaño). Puce también puede ser un término cariñoso, por su apariencia tierna y dulce.'),
(6, 8, 'Wartortle', 'Wartortle.webp', 'Su nombre proviene de las palabras en inglés war (guerra) y turtle (tortuga).\r\nSu nombre japonés el nombre proviene de kame (tortuga) y probablemente de evil (cruel en inglés) o de えル (conseguir o mejorar)\r\nSu nombre francés, Carabaffe, viene de carapace (caparazón) y Baffe (bofetada).'),
(7, 3, 'Venasaur', 'Venusaur.webp', 'Su nombre es una combinación de las palabras Venus (una flor parecida a la planta que le crece desde su etapa como Bulbasaur) y saur, que viene del griego saurus, que quiere decir reptil o lagarto y es el equivalente a la terminación -saurio en los nombres de muchos dinosaurios. Así, Venusaur podría traducirse como Venusaurio. Su nombre japonés, Fushigibana, proviene de 不思議花 (significa flor extraña).'),
(9, 9, 'Blastoise', 'Blastoise.webp', 'Su nombre es una combinación de las palabras en inglés blast (explosión o ráfaga) y tortoise (tortuga terrestre). Su nombre japonés, Kamex, proviene de 亀 kame (tortuga) y posiblemente de マックス makkusu o max (máximo). Su nombre francés, Tortank, proviene de las palabras tortue (tortuga) y tank (tanque).'),
(35, 6, 'Charizard', 'Charizard.webp', 'Su nombre es una contracción de las palabras en inglés char (carbonizar, quemar, incinerar) y lizard (lagarto). Su nombre en japonés, Lizardon, es una combinación de lizard (lagarto en inglés) y don, un sufijo que se utiliza comúnmente en dinosaurios y significa diente. Su nombre francés, Dracaufeu, proviene de las palabras draco (dragón) y feu (fuego, en francés).'),
(40, 10, 'Caterpie', 'Caterpie.webp', 'Su nombre deriva del inglés caterpillar (oruga, animal con el que comparte algunos rasgos). Su nombre francés, Chenipan, proviene de las palabras chenille (oruga) y pan (trepar, probablemente por su hábito de trepar a los árboles y vivir allí en sus copas).'),
(41, 11, 'Metapod', 'Metapod.webp', 'Su nombre proviene de metamorfosis, proceso de transformación de la oruga en mariposa, o bien \"metal\" por su dura coraza y pod (en inglés, vaina o cápsula), es decir, un caparazón que envuelve a la oruga durante su proceso de metamorfosis. Su nombre japonés, Trancell, proviene de las palabras transformation (\"transformación\") y cell (\"célula\"). Su nombre francés, Chrysacier, viene de las palabras Chrysalide (\"crisálida\") y Acier (\"acero\").'),
(42, 12, 'Butterfree', 'Butterfree.webp', 'Su nombre es el resultado de la combinación de las palabras butterfly (\"mariposa\") y free (\"libre\"). Su nombre francés, Papilusion, viene de las palabras papillon (\"mariposa\") e ilusion (\"ilusión\"), posiblemente por saber algunos movimientos de tipo psíquico.'),
(43, 13, 'Weedle', 'Weedle.webp', 'Su nombre proviene de \"wee\", \"pequeñito\" en inglés (aunque esta palabra solo adopta este significado en Escocia e Irlanda, teniendo en otros países un significado diferente) y \"needle\", \"aguja\" en inglés. No obstante, también es posible que sea un acrónimo de worm (gusano) y needle (aguja), o de weevil (gorgojo) y needle. El nombre japonés Beedle es un acrónimo de las palabras inglesas bee (abeja) y needle.'),
(44, 14, 'Kakuna', 'Kakuna.webp', 'Su nombre, tanto japonés como inglés, proviene del inglés cocoon (crisálida).'),
(45, 15, 'Beedrill', 'Beedrill.webp', 'Su nombre proviene de la unión de las palabras en inglés bee (abeja) y drill (taladro), en alusión a su forma de abeja y a los aguijones con forma de taladro que tiene. Su nombre en japonés, スピアー (Spear), puede provenir de la palabra inglesa spear (lanza, arpón), aludiendo nuevamente a los puntiagudos aguijones que tiene.'),
(46, 16, 'Pidgey', 'Pidgey.webp', 'El nombre de Pidgey proviene de la palabra inglesa pigeon (paloma), la \"y\" puede indicar su miniatura. O también puede derivar de la combinación de las palabras Pigeon (Paloma) y Budgie (Periquito, Canario). Su nombre en japonés tiene su origen en la palabra onomatopéyica ポッポ (Poppo), que alude al sonido que produce el zureo de las palomas.'),
(47, 17, 'Pidgeotto', 'Pidgeotto.webp', 'Su nombre proviene de Pigeon, que significa paloma, y el sufijo italiano \"-otto\", que significa pequeño (equivalente al sufijio \"-ito\" en español).'),
(48, 18, 'Pidgeot', 'Pidgeot.webp', 'Su nombre proviene de las palabras inglesas pigeon (paloma) y jet (jet).');

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
(1, 'fuego.webp'),
(2, 'planta.webp'),
(3, 'agua.webp'),
(5, 'veneno.webp'),
(6, 'volador.webp'),
(7, 'tierra.webp'),
(8, 'siniestro.webp'),
(9, 'roca.webp'),
(10, 'psiquico.webp'),
(11, 'normal.webp'),
(12, 'lucha.webp'),
(13, 'hielo.webp'),
(14, 'hada.webp'),
(15, 'fantasma.webp'),
(16, 'electrico.webp'),
(17, 'dragon.webp'),
(18, 'bicho.webp'),
(19, 'acero.webp');

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
(9, 3),
(3, 2),
(3, 5),
(4, 2),
(4, 5),
(7, 2),
(7, 5),
(1, 1),
(2, 1),
(35, 1),
(35, 6),
(5, 3),
(6, 3),
(40, 18),
(41, 18),
(42, 6),
(42, 18),
(43, 5),
(43, 18),
(44, 5),
(44, 18),
(45, 5),
(45, 18),
(48, 6),
(48, 11),
(46, 6),
(46, 11),
(47, 6),
(47, 11);

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
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `password`) VALUES
(2, 'nicolas@caba.com', '1234-'),
(3, 'leverattomariag@gmail.com', '123');

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
