DROP DATABASE IF EXISTS `crudo`;
CREATE DATABASE IF NOT EXISTS `crudo`;
USE `crudo`;

CREATE TABLE `productos` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) DEFAULT NULL,
  `descripcion` VARCHAR(50) DEFAULT NULL,
  `cantidad` INT DEFAULT NULL,
  `precio` FLOAT DEFAULT NULL
);

CREATE TABLE `usuarios` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `usuario` VARCHAR(20) NOT NULL,
  `password` VARCHAR(20) NOT NULL
);

INSERT INTO `productos` (`nombre`, `descripcion`, `cantidad`, `precio`) VALUES ('jugo', 'bebida', 2, 7);
INSERT INTO `usuarios` (`usuario`, `password`) VALUES ('usuario1', 'usuario123');