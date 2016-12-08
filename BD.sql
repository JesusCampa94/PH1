-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         10.1.16-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para pibd
CREATE DATABASE IF NOT EXISTS `pibd` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `pibd`;

-- Volcando estructura para tabla pibd.albumes
DROP TABLE IF EXISTS `albumes`;
CREATE TABLE IF NOT EXISTS `albumes` (
  `IdAlbum` int(11) NOT NULL AUTO_INCREMENT,
  `TituloAlbum` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `DescripcionAlbum` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FechaAlbum` date NOT NULL,
  `PaisAlbum` int(11) DEFAULT NULL,
  `UsuarioAlbum` int(11) NOT NULL,
  PRIMARY KEY (`IdAlbum`),
  UNIQUE KEY `TituloAlbum` (`TituloAlbum`,`UsuarioAlbum`),
  KEY `FK__paises` (`PaisAlbum`),
  KEY `FK__usuarios` (`UsuarioAlbum`),
  CONSTRAINT `FK__paises` FOREIGN KEY (`PaisAlbum`) REFERENCES `paises` (`IdPais`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `FK__usuarios` FOREIGN KEY (`UsuarioAlbum`) REFERENCES `usuarios` (`IdUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Datos de los albumes y usuarios vinculados a cada uno.';

-- Volcando datos para la tabla pibd.albumes: ~4 rows (aproximadamente)
DELETE FROM `albumes`;
/*!40000 ALTER TABLE `albumes` DISABLE KEYS */;
INSERT INTO `albumes` (`IdAlbum`, `TituloAlbum`, `DescripcionAlbum`, `FechaAlbum`, `PaisAlbum`, `UsuarioAlbum`) VALUES
	(1, 'Caminos', 'Caminos de todo tipo: asfalto, madera... lava...', '2016-05-29', 11, 4),
	(2, 'Agua', 'Vamos a la playa', '2016-07-22', 16, 3),
	(3, 'Animales', 'Animales en toda su gloria', '2016-09-12', 6, 2),
	(4, 'Tokio', '¿De verdad es París la Ciudad de la Luz?', '2016-10-27', 15, 1);
/*!40000 ALTER TABLE `albumes` ENABLE KEYS */;

-- Volcando estructura para tabla pibd.fotos
DROP TABLE IF EXISTS `fotos`;
CREATE TABLE IF NOT EXISTS `fotos` (
  `IdFoto` int(11) NOT NULL AUTO_INCREMENT,
  `TituloFoto` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `DescripcionFoto` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FechaFoto` date NOT NULL,
  `PaisFoto` int(11) DEFAULT NULL,
  `AlbumFoto` int(11) NOT NULL,
  `FicheroFoto` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'img/com/album.png',
  `MiniaturaFoto` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'img/com/album.png',
  `FRegistroFoto` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`IdFoto`),
  UNIQUE KEY `TituloFoto` (`TituloFoto`,`AlbumFoto`),
  KEY `FK_fotos_paises` (`PaisFoto`),
  KEY `FK_fotos_albumes` (`AlbumFoto`),
  CONSTRAINT `FK_fotos_albumes` FOREIGN KEY (`AlbumFoto`) REFERENCES `albumes` (`IdAlbum`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_fotos_paises` FOREIGN KEY (`PaisFoto`) REFERENCES `paises` (`IdPais`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Informacion sobre las fotos.';

-- Volcando datos para la tabla pibd.fotos: ~10 rows (aproximadamente)
DELETE FROM `fotos`;
/*!40000 ALTER TABLE `fotos` DISABLE KEYS */;
INSERT INTO `fotos` (`IdFoto`, `TituloFoto`, `DescripcionFoto`, `FechaFoto`, `PaisFoto`, `AlbumFoto`, `FicheroFoto`, `MiniaturaFoto`, `FRegistroFoto`) VALUES
	(1, 'Carretera', 'Tranquilos, miramos que no pasara nadie antes de hacer la foto', '2016-05-29', 11, 1, 'img/photos/4/1/1.jpg', 'img/photos/4/1/thumb/1.jpg', '2016-12-08 16:21:28'),
	(2, 'Castillo', 'Con su puente de madera, pero no es levadizo', '2016-05-30', 11, 1, 'img/photos/4/1/2.jpg', 'img/photos/4/1/thumb/2.jpg', '2016-12-08 16:35:18'),
	(3, 'Tiburón', 'Nadando tranquilo, en toda su salsa', '2016-07-22', 16, 2, 'img/photos/3/2/3.jpg', 'img/photos/3/2/thumb/3.jpg', '2016-12-08 16:35:29'),
	(4, 'Peñón', 'Como un iceberg, pero en roca', '2016-07-28', 16, 2, 'img/photos/3/2/4.jpg', 'img/photos/3/2/thumb/4.jpg', '2016-12-08 16:35:40'),
	(5, 'Pato', 'Un pato que le gustó mucho la cámara', '2016-09-12', 6, 3, 'img/photos/2/3/5.jpg', 'img/photos/2/3/thumb/5.jpg', '2016-12-08 16:35:48'),
	(6, 'Panda', 'Los animales estaban muy simpáticos ese día', '2016-09-13', 6, 3, 'img/photos/2/3/6.jpg', 'img/photos/2/3/thumb/6.jpg', '2016-12-08 16:36:04'),
	(7, 'Río de lava', 'Porque los ríos de agua están muy sobrevalorados', '2016-09-16', 11, 1, 'img/photos/4/1/7.jpg', 'img/photos/4/1/thumb/7.jpg', '2016-12-08 16:36:16'),
	(8, 'Tortuga marina', 'No le pregunté la edad', '2016-09-20', 16, 2, 'img/photos/3/2/8.jpg', 'img/photos/3/2/thumb/8.jpg', '2016-12-08 16:36:32'),
	(9, 'Tigre', 'La típica escena que uno espera ver un día cualquiera', '2016-09-27', 16, 2, 'img/photos/3/2/9.jpg', 'img/photos/3/2/thumb/9.jpg', '2016-12-08 16:37:16'),
	(10, 'Tokio', '¿De verdad es París la Ciudad de la Luz?', '2016-10-27', 15, 4, 'img/photos/1/4/10.jpg', 'img/photos/1/4/thumb/10.jpg', '2016-12-08 16:34:40');
/*!40000 ALTER TABLE `fotos` ENABLE KEYS */;

-- Volcando estructura para tabla pibd.paises
DROP TABLE IF EXISTS `paises`;
CREATE TABLE IF NOT EXISTS `paises` (
  `IdPais` int(11) NOT NULL AUTO_INCREMENT,
  `NomPais` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`IdPais`),
  UNIQUE KEY `NomPais` (`NomPais`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Paises con su identificador.';

-- Volcando datos para la tabla pibd.paises: ~21 rows (aproximadamente)
DELETE FROM `paises`;
/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
INSERT INTO `paises` (`IdPais`, `NomPais`) VALUES
	(1, 'Albania'),
	(2, 'Alemania'),
	(3, 'Andorra'),
	(4, 'Brasil'),
	(5, 'Calimero'),
	(6, 'China'),
	(7, 'Ecuador'),
	(9, 'EE.UU'),
	(8, 'España'),
	(10, 'Finlandia'),
	(12, 'Gameland'),
	(13, 'Grecia'),
	(14, 'Hungría'),
	(11, 'Italia'),
	(15, 'Japón'),
	(16, 'México'),
	(17, 'Noruega'),
	(18, 'Pandora'),
	(19, 'Reino Unido'),
	(20, 'Rusia'),
	(21, 'Suecia'),
	(22, 'Wonderland');
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;

-- Volcando estructura para tabla pibd.solicitudes
DROP TABLE IF EXISTS `solicitudes`;
CREATE TABLE IF NOT EXISTS `solicitudes` (
  `IdSolicitud` int(11) NOT NULL AUTO_INCREMENT,
  `AlbumSolicitud` int(11) NOT NULL,
  `NombreSolicitud` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `TituloSolicitud` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `DescripcionSolicitud` varchar(4000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EmailSolicitud` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `DireccionSolicitud` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `TelefonoSolicitud` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ColorSolicitud` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `CopiasSolicitud` int(11) NOT NULL,
  `ResolucionSolicitud` int(11) NOT NULL,
  `FechaSolicitud` date NOT NULL,
  `IColorSolicitud` bit(1) NOT NULL,
  `FRegistroSolicitud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CosteSolicitud` float NOT NULL,
  PRIMARY KEY (`IdSolicitud`),
  KEY `FK__albumes` (`AlbumSolicitud`),
  CONSTRAINT `FK__albumes` FOREIGN KEY (`AlbumSolicitud`) REFERENCES `albumes` (`IdAlbum`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tabla que contiene las solicitudes realizadas.';

-- Volcando datos para la tabla pibd.solicitudes: ~1 rows (aproximadamente)
DELETE FROM `solicitudes`;
/*!40000 ALTER TABLE `solicitudes` DISABLE KEYS */;
INSERT INTO `solicitudes` (`IdSolicitud`, `AlbumSolicitud`, `NombreSolicitud`, `TituloSolicitud`, `DescripcionSolicitud`, `EmailSolicitud`, `DireccionSolicitud`, `TelefonoSolicitud`, `ColorSolicitud`, `CopiasSolicitud`, `ResolucionSolicitud`, `FechaSolicitud`, `IColorSolicitud`, `FRegistroSolicitud`, `CosteSolicitud`) VALUES
	(1, 4, 'Jesús', 'Foto de Tokio', 'Un bonito recuerdo, me gustaría enmarcarlo.', 'e@mi.lio', 'Calle Pino, 5 - 03325 Muy lejos (Alicante)', '666555444', '#009688', 2, 900, '2016-12-07', b'1', '2016-12-04 19:36:04', 0.2);
/*!40000 ALTER TABLE `solicitudes` ENABLE KEYS */;

-- Volcando estructura para tabla pibd.usuarios
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `IdUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `NomUsuario` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `ClaveUsuario` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `EmailUsuario` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `SexoUsuario` tinyint(4) NOT NULL,
  `FNacimientoUsuario` date NOT NULL,
  `CiudadUsuario` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PaisUsuario` int(11) DEFAULT NULL,
  `FotoUsuario` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'img/com/avatar.png',
  `FRegistroUsuario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`IdUsuario`),
  UNIQUE KEY `NomUsuario` (`NomUsuario`),
  UNIQUE KEY `EmailUsuario` (`EmailUsuario`),
  KEY `FK_usuarios_paises` (`PaisUsuario`),
  CONSTRAINT `FK_usuarios_paises` FOREIGN KEY (`PaisUsuario`) REFERENCES `paises` (`IdPais`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Esta tabla contiene los datos que el usuario nos envía al registrarse, además de un ID y su fecha de registro.';

-- Volcando datos para la tabla pibd.usuarios: ~7 rows (aproximadamente)
DELETE FROM `usuarios`;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`IdUsuario`, `NomUsuario`, `ClaveUsuario`, `EmailUsuario`, `SexoUsuario`, `FNacimientoUsuario`, `CiudadUsuario`, `PaisUsuario`, `FotoUsuario`, `FRegistroUsuario`) VALUES
	(1, 'yisus', 'cawendie', 'erYisusToReshulon69XD@gmail.com', 1, '1994-05-29', 'Far, Far Away', 8, 'img/usu/yisus.png', '2016-11-29 15:27:26'),
	(2, 'maermka', 'odioelmundo', 'sonrisasfelicesFTW@posok.com', 1, '1995-07-08', 'Pulgarcity', 5, 'img/usu/maermka.png', '2016-11-29 15:27:29'),
	(3, 'flequi1000', '#heperdido', 'swaggerToLoko@gmail.com', 1, '1994-09-14', 'Instagram', 22, 'img/usu/avatar_default.png', '2016-11-29 15:27:35'),
	(4, 'grecio95', 'helenofiel', 'tuAmoZeus@gmail.com', 1, '1995-07-04', 'Olimpia', 13, 'img/usu/avatar_default.png', '2016-11-29 15:27:40'),
	(5, 'laVaneh', 'imsofabolous', 'soyDivina@gmail.com', 2, '1996-11-15', 'Rainbow Town', 22, 'img/usu/avatar_default.png', '2016-11-29 15:27:43'),
	(6, 'birdo', 'tomilazo', 'soyToRosa@pink.com', 3, '1988-10-09', 'Incognita', 12, 'img/usu/avatar_default.png', '2016-12-01 20:48:26'),
	(7, 'ryasu', 'esoestamal', 'ryasulion@gmail.com', 1, '1994-07-13', 'Narnia', 22, 'img/usu/avatar_default.png', '2016-12-01 18:05:47');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
