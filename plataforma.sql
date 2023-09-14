-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `plataforma`;

SET NAMES utf8mb4;

CREATE TABLE `admin` (
  `idadmin` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id unico de escuela, solo existira este usuario en un futuro/',
  `nombre` varchar(255) NOT NULL COMMENT 'nombre de la escuela',
  `direcion` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL COMMENT 'nivel educativo que imparten',
  `foto` varchar(255) NOT NULL,
  `idusuario` int(11) NOT NULL COMMENT 'para saber quien hace el login y mostar sus datos.',
  PRIMARY KEY (`idadmin`),
  KEY `idusuario` (`idusuario`),
  CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admin` (`idadmin`, `nombre`, `direcion`, `tipo`, `foto`, `idusuario`) VALUES
(1,	'Samuel Ismael Pech Ek',	'Multiple',	'Superior',	'foto/admin5302885767.jpg',	1);

CREATE TABLE `alumno` (
  `idalumno` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `matricula` varchar(255) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idsalon` int(11) NOT NULL,
  `foto` varchar(100) NOT NULL,
  PRIMARY KEY (`idalumno`),
  KEY `idusuario` (`idusuario`),
  KEY `idsalon` (`idsalon`),
  CONSTRAINT `alumno_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`),
  CONSTRAINT `alumno_ibfk_2` FOREIGN KEY (`idsalon`) REFERENCES `salon` (`idsalon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `alumno` (`idalumno`, `nombre`, `matricula`, `idusuario`, `idsalon`, `foto`) VALUES
(25,	'Archivaldo',	'0793802525',	72,	9,	'foto/alumno0793802525-1615314293.png'),
(26,	'Ejemplo',	'9348882389',	73,	9,	'foto/alumno9348882389-1614749034.png'),
(27,	'asas',	'3831268125',	74,	9,	'foto/alumno3831268125-1614749046.jpg'),
(34,	'Daniel Ix',	'7133649299',	87,	2,	'foto/alumno7133649299.jpg'),
(35,	'hhh',	'9700686452',	89,	2,	'');

CREATE TABLE `asignatura` (
  `idasignatura` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`idasignatura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `asignatura` (`idasignatura`, `nombre`) VALUES
(1,	'Lenguaje escritoo'),
(2,	'Matematicas'),
(7,	'Geografia'),
(8,	'Integradora');

CREATE TABLE `asignatura_salon` (
  `idasignatura` int(11) NOT NULL COMMENT 'a partir de esta se sabra que maestro pertenece al salon donde se imparte la asignatura',
  `idsalon` int(11) NOT NULL COMMENT 'para asignar las asignaturas a un salon',
  KEY `idasignatura` (`idasignatura`),
  KEY `idsalon` (`idsalon`),
  CONSTRAINT `asignatura_salon_ibfk_1` FOREIGN KEY (`idasignatura`) REFERENCES `asignatura` (`idasignatura`),
  CONSTRAINT `asignatura_salon_ibfk_2` FOREIGN KEY (`idsalon`) REFERENCES `salon` (`idsalon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `asignatura_salon` (`idasignatura`, `idsalon`) VALUES
(1,	3),
(1,	8),
(1,	9),
(2,	9),
(1,	2),
(2,	2);

CREATE TABLE `calificasion` (
  `idcalificasion` int(11) NOT NULL AUTO_INCREMENT,
  `valor` float NOT NULL,
  `nota` varchar(255) NOT NULL,
  `idalumno` int(11) NOT NULL,
  `idmomento` int(11) NOT NULL,
  `idasignatura` int(11) NOT NULL,
  `idperiodo` int(11) NOT NULL,
  `idsalon` int(11) NOT NULL,
  PRIMARY KEY (`idcalificasion`),
  KEY `idalumno` (`idalumno`),
  KEY `idmomento` (`idmomento`),
  KEY `idasignatura` (`idasignatura`),
  KEY `idperiodo` (`idperiodo`),
  KEY `idsalon` (`idsalon`),
  CONSTRAINT `calificasion_ibfk_1` FOREIGN KEY (`idalumno`) REFERENCES `alumno` (`idalumno`),
  CONSTRAINT `calificasion_ibfk_2` FOREIGN KEY (`idmomento`) REFERENCES `momento` (`idmomento`),
  CONSTRAINT `calificasion_ibfk_3` FOREIGN KEY (`idasignatura`) REFERENCES `asignatura` (`idasignatura`),
  CONSTRAINT `calificasion_ibfk_4` FOREIGN KEY (`idperiodo`) REFERENCES `periodo` (`idperiodo`),
  CONSTRAINT `calificasion_ibfk_5` FOREIGN KEY (`idsalon`) REFERENCES `salon` (`idsalon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `calificasion` (`idcalificasion`, `valor`, `nota`, `idalumno`, `idmomento`, `idasignatura`, `idperiodo`, `idsalon`) VALUES
(98,	10,	'Ninguna',	34,	35,	1,	16,	2),
(99,	9,	'Ninguna',	35,	35,	1,	16,	2),
(100,	9,	'Ninguna',	25,	35,	1,	16,	9),
(101,	10,	'Ninguna',	26,	35,	1,	16,	9),
(102,	10,	'Ninguna',	27,	35,	1,	16,	9),
(103,	9,	'Ninguna',	34,	36,	1,	16,	2),
(104,	8,	'Ninguna',	35,	36,	1,	16,	2),
(105,	6,	'Ninguna',	25,	36,	1,	16,	9),
(106,	8,	'Ninguna',	26,	36,	1,	16,	9),
(107,	7,	'Ninguna',	27,	36,	1,	16,	9),
(108,	8,	'falto a clases',	25,	35,	2,	16,	9),
(109,	10,	'falto',	26,	35,	2,	16,	9),
(110,	10,	'Ninguna',	27,	35,	2,	16,	9),
(111,	10,	'Ninguna',	34,	35,	2,	16,	2),
(112,	8,	'Ninguna',	35,	35,	2,	16,	2),
(113,	7,	'no entrego tareas',	34,	36,	2,	16,	2),
(114,	10,	'Ninguna',	35,	36,	2,	16,	2),
(115,	8,	'Ninguno',	25,	37,	1,	16,	9),
(116,	7,	'Ninguno',	26,	37,	1,	16,	9),
(117,	9,	'Ninguno',	27,	37,	1,	16,	9),
(118,	5,	'Ninguno',	34,	37,	1,	16,	2),
(119,	6,	'Ninguno',	35,	37,	1,	16,	2);

CREATE TABLE `disputa` (
  `iddisputa` int(11) NOT NULL AUTO_INCREMENT,
  `idcalificasion` int(11) NOT NULL,
  `idalumno` int(11) NOT NULL,
  `idmaestro` int(11) NOT NULL,
  PRIMARY KEY (`iddisputa`),
  KEY `idcalificasion` (`idcalificasion`),
  KEY `idalumno` (`idalumno`),
  KEY `idmaestro` (`idmaestro`),
  CONSTRAINT `disputa_ibfk_1` FOREIGN KEY (`idcalificasion`) REFERENCES `calificasion` (`idcalificasion`),
  CONSTRAINT `disputa_ibfk_2` FOREIGN KEY (`idalumno`) REFERENCES `alumno` (`idalumno`),
  CONSTRAINT `disputa_ibfk_3` FOREIGN KEY (`idmaestro`) REFERENCES `maestro` (`idmaestro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `disputa` (`iddisputa`, `idcalificasion`, `idalumno`, `idmaestro`) VALUES
(8,	115,	25,	27);

CREATE TABLE `ediciones` (
  `idcalificasion` int(11) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  KEY `idcalificasion` (`idcalificasion`),
  CONSTRAINT `ediciones_ibfk_1` FOREIGN KEY (`idcalificasion`) REFERENCES `calificasion` (`idcalificasion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `if_save` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idmomento` int(11) NOT NULL,
  `idmaestro` int(11) NOT NULL,
  `idsalon` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idmomento` (`idmomento`),
  KEY `idmaestro` (`idmaestro`),
  KEY `idsalon` (`idsalon`),
  CONSTRAINT `if_save_ibfk_1` FOREIGN KEY (`idmomento`) REFERENCES `momento` (`idmomento`),
  CONSTRAINT `if_save_ibfk_2` FOREIGN KEY (`idmaestro`) REFERENCES `maestro` (`idmaestro`),
  CONSTRAINT `if_save_ibfk_3` FOREIGN KEY (`idsalon`) REFERENCES `salon` (`idsalon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `if_save` (`id`, `idmomento`, `idmaestro`, `idsalon`) VALUES
(24,	35,	27,	2),
(25,	35,	27,	9),
(26,	36,	27,	2),
(27,	36,	27,	9),
(28,	35,	31,	9),
(29,	35,	31,	2),
(30,	36,	31,	2),
(31,	37,	27,	9),
(32,	37,	27,	2);

CREATE TABLE `maestro` (
  `idmaestro` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `matricula` varchar(100) NOT NULL,
  `idasignatura` int(11) NOT NULL COMMENT 'para saber la materia que imparte y en que salon labora',
  `idusuario` int(11) NOT NULL,
  `foto` varchar(100) NOT NULL,
  PRIMARY KEY (`idmaestro`),
  KEY `idasignatura` (`idasignatura`),
  KEY `idusuario` (`idusuario`),
  CONSTRAINT `maestro_ibfk_1` FOREIGN KEY (`idasignatura`) REFERENCES `asignatura` (`idasignatura`),
  CONSTRAINT `maestro_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `maestro` (`idmaestro`, `nombre`, `matricula`, `idasignatura`, `idusuario`, `foto`) VALUES
(27,	'Ernesto Contreras',	'7832927031',	1,	63,	'foto/maestro7832927031-1614296663.jpg'),
(30,	'maestro',	'0851854746',	1,	75,	''),
(31,	'mastroo',	'1305662570',	2,	76,	''),
(32,	'maestrrrrr',	'8860999199',	2,	77,	''),
(36,	'Ejemplo A',	'5177619220',	8,	88,	'foto/maestro5177619220.png');

CREATE TABLE `maestro_salon` (
  `idmaestro` int(11) NOT NULL,
  `idsalon` int(11) NOT NULL,
  KEY `idmaestro` (`idmaestro`),
  KEY `idsalon` (`idsalon`),
  CONSTRAINT `maestro_salon_ibfk_1` FOREIGN KEY (`idmaestro`) REFERENCES `maestro` (`idmaestro`),
  CONSTRAINT `maestro_salon_ibfk_2` FOREIGN KEY (`idsalon`) REFERENCES `salon` (`idsalon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `maestro_salon` (`idmaestro`, `idsalon`) VALUES
(27,	3),
(27,	8),
(27,	9),
(31,	9),
(27,	2),
(31,	2);

CREATE TABLE `mensaje` (
  `idmensaje` int(11) NOT NULL AUTO_INCREMENT,
  `iddisputa` int(11) NOT NULL,
  `de` int(11) NOT NULL,
  `para` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`idmensaje`),
  KEY `iddisputa` (`iddisputa`),
  KEY `de` (`de`),
  KEY `para` (`para`),
  CONSTRAINT `mensaje_ibfk_1` FOREIGN KEY (`iddisputa`) REFERENCES `disputa` (`iddisputa`),
  CONSTRAINT `mensaje_ibfk_2` FOREIGN KEY (`de`) REFERENCES `usuario` (`idusuario`),
  CONSTRAINT `mensaje_ibfk_3` FOREIGN KEY (`para`) REFERENCES `usuario` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `mensaje` (`idmensaje`, `iddisputa`, `de`, `para`, `mensaje`, `estado`) VALUES
(24,	8,	72,	63,	'aaaaa',	'NO LEIDO');

CREATE TABLE `momento` (
  `idmomento` int(11) NOT NULL AUTO_INCREMENT COMMENT 'cuatrimestres, semestre o parcial etc',
  `nombre` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL COMMENT 'podran ser 3, activo,finalizado o algun otro.',
  PRIMARY KEY (`idmomento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `momento` (`idmomento`, `nombre`, `estado`) VALUES
(35,	'Parcial 1',	'Finalizado'),
(36,	'Parcial 2',	'Finalizado'),
(37,	'Parcial 3',	'Activo');

CREATE TABLE `periodo` (
  `idperiodo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL COMMENT 'activo,finalizado',
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  PRIMARY KEY (`idperiodo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `periodo` (`idperiodo`, `nombre`, `estado`, `inicio`, `fin`) VALUES
(16,	'2021-06_2021-09',	'Activo',	'2021-06-06',	'2021-09-06');

CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `clave` varchar(255) NOT NULL,
  PRIMARY KEY (`idpermiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `permiso` (`idpermiso`, `nombre`, `clave`) VALUES
(1,	'Vista admin',	'ADMIN'),
(2,	'Vista maestro',	'MAESTRO'),
(3,	'Vista alumno',	'ALUMNO');

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL AUTO_INCREMENT COMMENT 'define el tipo de usuario',
  `nombre` varchar(255) NOT NULL COMMENT 'nombre del tipo',
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `rol` (`idrol`, `nombre`) VALUES
(1,	'Administrador'),
(2,	'Maestro'),
(3,	'Alumno');

CREATE TABLE `rol_permiso` (
  `idpermiso` int(11) NOT NULL COMMENT 'se obtiene de la tabla permiso',
  `idrol` int(11) NOT NULL COMMENT 'se obtiene de la tabla rol',
  KEY `idpermiso` (`idpermiso`),
  KEY `idrol` (`idrol`),
  CONSTRAINT `rol_permiso_ibfk_1` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`idpermiso`),
  CONSTRAINT `rol_permiso_ibfk_2` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `rol_permiso` (`idpermiso`, `idrol`) VALUES
(1,	1),
(2,	2),
(3,	3);

CREATE TABLE `salon` (
  `idsalon` int(11) NOT NULL AUTO_INCREMENT COMMENT 'servira para identificar las materias y alumnos que pertenecen a el',
  `nombre` varchar(255) NOT NULL COMMENT 'ouede ser el nombre o especificar grado y grupo.',
  PRIMARY KEY (`idsalon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `salon` (`idsalon`, `nombre`) VALUES
(1,	'4Z'),
(2,	'4B'),
(3,	'4C'),
(8,	'1A'),
(9,	'5A');

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'para identificar el personal luego del login.',
  `email` varchar(255) NOT NULL COMMENT 'unica forma de inicio de sesion',
  `password` varchar(500) NOT NULL,
  `remember_token` varchar(500) NOT NULL,
  `idrol` int(11) NOT NULL COMMENT 'para saber el tipo de login y obtener permiso.',
  PRIMARY KEY (`idusuario`),
  KEY `idrol` (`idrol`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuario` (`idusuario`, `email`, `password`, `remember_token`, `idrol`) VALUES
(1,	'control@plataforma.edu',	'$2y$10$e2rh4B5zAsRPaNBhqKIEmuMZ.hfphixYX0shFbnNxWkdYadxYiNZW',	'UZpLuuEdFmpxGH7JJUDzz2SxIIG7u9otESkRXXB2T9R87CpQY6LzXZgv2qyc',	1),
(63,	'Maestro@plataforma.edu',	'$2y$10$e2rh4B5zAsRPaNBhqKIEmuMZ.hfphixYX0shFbnNxWkdYadxYiNZW',	'ILW7cmyIixOiSRYOhgtRFCWXgWBeRhR00GRCxTHNGIpH7gYuuhvbRaIoGZPh',	2),
(72,	'alumnob@plataforma.edu',	'$2y$10$e2rh4B5zAsRPaNBhqKIEmuMZ.hfphixYX0shFbnNxWkdYadxYiNZW',	'EcxdbwNL5BEWWOwdDq6YLpj0Ax7GA2pyaSB9ZJDRtlBDf7Eg5q2tn2d0ZJ0A',	3),
(73,	'samueeee@plataforma.edu',	'$2y$10$wXEhgy6vHD2R7Rhf01TKBOyNuSlMWwvPG6TUUXInwId00PLrD8kuC',	'',	3),
(74,	'aaaaasasa@plataforma.edu',	'$2y$10$LaikEij4GGERha8pqPrpZ.7d3LyUAeJzmjBnXGl5yJovpEcDqEX6C',	'',	3),
(75,	'maestrooooo@plataforma.edu',	'$2y$10$e2rh4B5zAsRPaNBhqKIEmuMZ.hfphixYX0shFbnNxWkdYadxYiNZW',	'sGR5SiKG7VE5fGZxKn2hWJFhzjepRwd7u3E1bz7gSOvCj5Zf3VlAM2dRoepb',	2),
(76,	'maestrax@plataforma.edu',	'$2y$10$e2rh4B5zAsRPaNBhqKIEmuMZ.hfphixYX0shFbnNxWkdYadxYiNZW',	'6uhcrhjv8qT3f3NjpslCEki6FBFP2spKk73GVcTK2H9BKBrR4Ik5Cff1hjJ1',	2),
(77,	'maestraaaaao@plataforma.edu',	'$2y$10$w9HFAlCvtVzsH8kDmIWEB.z5Qj/t17qJt3V5JFwKRcgqNx1NAajW.',	'',	2),
(87,	'Alumnoa@plataforma.edu',	'$2y$10$e2rh4B5zAsRPaNBhqKIEmuMZ.hfphixYX0shFbnNxWkdYadxYiNZW',	'iNR7D0JhnK3KIe3ve4YfL6hQxZW6aTVMXju1u1z49oaJJT2s1sci4bJlO5pD',	3),
(88,	'ErnestoOOO@plataforma.edu',	'$2y$10$2J5tA5pl9KcF6XZrOLGXmOnsSvBkRtx.GCo7PDnRoHsbiyGHj4mUe',	'',	2),
(89,	'alguien@plataforma.edu',	'$2y$10$o6KQ194yJJU1.7Op.yDm/OLMoZZHlWvKda3fAYr.bOKjE/TMWjNWe',	'',	3);

-- 2021-03-26 09:19:41
