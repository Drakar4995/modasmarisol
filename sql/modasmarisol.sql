-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 05-12-2022 a las 11:16:52
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `modasmarisol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `paypal` varchar(255) NOT NULL,
  `dni` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `precioTotal` decimal(20,2) NOT NULL,
  `idUsuario` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `nombre`, `direccion`, `paypal`, `dni`, `fecha`, `precioTotal`, `idUsuario`) VALUES
(7, 'Usuario', 'DireccionUsuario', 'user@uclm.com', '24234242F', '2022-12-02', '143.97', 3),
(8, 'Usuario', 'direccionusuario2', 'usuario@uclm.com', '32131231J', '2022-12-02', '30.99', 3),
(9, 'ana garcia', 'anadireccion', 'ana12@uclm.com', '12312312A', '2022-12-02', '64.99', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itemcompra`
--

CREATE TABLE `itemcompra` (
  `idCompra` int(255) NOT NULL,
  `idPrenda` int(255) NOT NULL,
  `cantidad` int(255) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `itemcompra`
--

INSERT INTO `itemcompra` (`idCompra`, `idPrenda`, `cantidad`, `subtotal`) VALUES
(7, 1, 1, '10.99'),
(7, 8, 1, '12.99'),
(7, 9, 1, '99.99'),
(8, 1, 1, '10.99'),
(9, 6, 1, '44.99');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prendas`
--

CREATE TABLE `prendas` (
  `id` int(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidadStock` int(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prendas`
--

INSERT INTO `prendas` (`id`, `nombre`, `precio`, `cantidadStock`, `url`) VALUES
(1, 'Camiseta Capibara', '10.99', 100, 'id1.jpeg'),
(2, 'pantalon', '19.99', 20, 'id2.png'),
(3, 'Disfraz', '34.99', 100, 'id3.png'),
(4, 'Dwayne Johnson', '15.00', 1000, 'id4.png'),
(5, 'Sudadera Patriota', '20.00', 1000, 'id5.jpeg'),
(6, 'Maillot Azul', '44.99', 100000, 'id6.jpeg'),
(7, '\"I LOVE PHP\"', '9.99', 12222, 'id7.png'),
(8, 'Camiseta PHP ENJOYER', '12.99', 1231321, 'id8.png'),
(9, 'Roberto 👍', '99.99', 12, 'roberto.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `email`, `password`) VALUES
(3, 'user', 'user@uclm.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(6, 'ana12', 'ana@uclm.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(7, 'pedro', 'pedro@uclm.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(8, 'pepe', 'pepe@uclm.com', 'd93591bdf7860e1e4ee2fca799911215');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`,`idUsuario`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `itemcompra`
--
ALTER TABLE `itemcompra`
  ADD PRIMARY KEY (`idCompra`,`idPrenda`),
  ADD KEY `idPrenda` (`idPrenda`);

--
-- Indices de la tabla `prendas`
--
ALTER TABLE `prendas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `prendas`
--
ALTER TABLE `prendas`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `itemcompra`
--
ALTER TABLE `itemcompra`
  ADD CONSTRAINT `itemcompra_ibfk_1` FOREIGN KEY (`idPrenda`) REFERENCES `prendas` (`id`),
  ADD CONSTRAINT `itemcompra_ibfk_2` FOREIGN KEY (`idCompra`) REFERENCES `compra` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
