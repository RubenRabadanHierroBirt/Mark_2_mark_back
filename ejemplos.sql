-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         11.8.3-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando datos para la tabla m2m.atletas: ~20 rows (aproximadamente)
REPLACE INTO `atletas` (`id`, `id_usuario`, `club_actual_id`, `nombre`, `email`, `telefono`, `fecha_nacimiento`, `status`, `sexo`, `categoria`) VALUES
	(1, 22, 1, 'Unai Zabala Etxeberria', 'unai@mail.com', '600123001', '2001-07-21', 'Activo', 'M', 'Sub-23'),
	(2, 23, 2, 'Maialen Ibarretxe López', 'maialen@mail.com', '600123002', '2006-02-09', 'Activo', 'F', 'Sub-18'),
	(3, 24, 3, 'Iker Iriondo Goikoetxea', 'iker@mail.com', '600123003', '1998-01-27', 'Activo', 'M', 'Senior'),
	(4, 25, 1, 'Ane Agirretxe Etxeberri', 'aneane@mail.com', '600123007', '2009-10-04', 'Activo', 'F', 'Sub-18'),
	(5, 26, 2, 'Mikel Rodríguez Agirretxe', 'mikel@mail.com', '600123005', '2004-11-19', 'Activo', 'M', 'Sub-20'),
	(6, 27, 3, 'Leire Bilbao Agirretxe', 'leire@mail.com', '600123006', '2005-09-03', 'Activo', 'F', 'Sub-20'),
	(7, 28, 1, 'Jon Zubizarreta Larrea', 'jon@mail.com', '600123007', '2000-06-19', 'Activo', 'M', 'Senior'),
	(8, 29, 2, 'Nerea Rodríguez Bilbao', 'nerea@mail.com', '600123008', '2002-05-12', 'Activo', 'F', 'Sub-23'),
	(9, 30, 3, 'Aitor Ibarretxe González', 'aitor@mail.com', '600123009', '2007-04-07', 'Activo', 'M', 'Sub-18'),
	(10, 31, 1, 'Oihane García Agirretxe', 'oihane@mail.com', '600123010', '2006-08-11', 'Activo', 'F', 'Sub-18'),
	(11, 32, 2, 'Asier Ibarretxe Etxeberria', 'asier@mail.com', '600123011', '2003-03-15', 'Activo', 'M', 'Sub-23'),
	(12, 33, 3, 'Irati Ibarretxe Ugarte', 'irati@mail.com', '600123012', '2002-05-23', 'Activo', 'F', 'Sub-23'),
	(13, 34, 1, 'Eneko Agirretxe Zabala', 'eneko@mail.com', '600123013', '2000-01-02', 'Activo', 'M', 'Senior'),
	(14, 35, 2, 'Izaro Martínez Rodríguez', 'izaro@mail.com', '600123014', '2008-12-09', 'Activo', 'F', 'Sub-18'),
	(15, 36, 3, 'Julen Agirretxe Zubizarreta', 'julen@mail.com', '600123015', '2003-04-09', 'Activo', 'M', 'Sub-23'),
	(16, 37, 1, 'Uxue Etxeberria Iriondo', 'uxue@mail.com', '600123016', '2004-02-24', 'Activo', 'F', 'Sub-20'),
	(17, 38, 2, 'Ander Iriondo Martínez', 'ander@mail.com', '600123017', '2006-07-23', 'Activo', 'M', 'Sub-18'),
	(18, 39, 3, 'Nagore Fernández Etxeberria', 'nagore@mail.com', '600123018', '2001-09-24', 'Activo', 'F', 'Sub-23'),
	(19, 40, 1, 'Xabier Ugarte Fernández', 'xabier@mail.com', '600123019', '1999-03-14', 'Activo', 'M', 'Senior'),
	(20, 41, 2, 'Garazi Ibarretxe Pérez', 'garazi@mail.com', '600123020', '2006-05-28', 'Activo', 'F', 'Sub-18');

-- Volcando datos para la tabla m2m.cache: ~16 rows (aproximadamente)
REPLACE INTO `cache` (`key`, `value`, `expiration`) VALUES
	('laravel-cache-144c280798fb468d65b2333f8eb80d33fcfc6a4b', 'i:1;', 1768137670),
	('laravel-cache-144c280798fb468d65b2333f8eb80d33fcfc6a4b:timer', 'i:1768137670;', 1768137670),
	('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:2;', 1768157082),
	('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1768157082;', 1768157082),
	('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:2;', 1768156247),
	('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1768156247;', 1768156247),
	('laravel-cache-5de1ab11ec752c0020a031256913726d7f1f1a93', 'i:4;', 1768153325),
	('laravel-cache-5de1ab11ec752c0020a031256913726d7f1f1a93:timer', 'i:1768153325;', 1768153325),
	('laravel-cache-b7db4a34324895ec0d66e89d94839503e740e733', 'i:1;', 1768128901),
	('laravel-cache-b7db4a34324895ec0d66e89d94839503e740e733:timer', 'i:1768128901;', 1768128901),
	('laravel-cache-d357b29dc733d9190a4de778e9ee9577a63137f3', 'i:1;', 1768137789),
	('laravel-cache-d357b29dc733d9190a4de778e9ee9577a63137f3:timer', 'i:1768137789;', 1768137789),
	('laravel-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0', 'i:1;', 1768154803),
	('laravel-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0:timer', 'i:1768154803;', 1768154803),
	('laravel-cache-f6e1126cedebf23e1463aee73f9df08783640400', 'i:3;', 1768151849),
	('laravel-cache-f6e1126cedebf23e1463aee73f9df08783640400:timer', 'i:1768151848;', 1768151849);

-- Volcando datos para la tabla m2m.cache_locks: ~0 rows (aproximadamente)

-- Volcando datos para la tabla m2m.clubs: ~20 rows (aproximadamente)
REPLACE INTO `clubs` (`id`, `id_usuario`, `code`, `name`, `direccion`, `telefono`, `responsable`, `estado`, `codigo_postal`, `localidad`, `email`) VALUES
	(1, 2, 'SS-101', 'Real Sociedad', 'Paseo de Anoeta 1', '943000101', 'Jokin Aperribay', 'Activo', 20014, 'Donostia', 'atletismo@realsociedad.eus'),
	(2, 3, 'SS-102', 'Super Amara BAT', 'Calle Mayor 5', '943000102', 'Iker Casanova', 'Activo', 20304, 'Irun', 'bat@atletismo.eus'),
	(3, 4, 'SS-103', 'Atlético San Sebastián', 'Plaza Concha 2', '943000103', 'Amaia Andres', 'Activo', 20007, 'Donostia', 'info@atleticoss.com'),
	(4, 5, 'SS-104', 'Bidezabal Durango AT', 'Landako Etorbidea 4', '946000104', 'Juanjo Baeza', 'Activo', 48200, 'Durango', 'bidezabal@durango.eus'),
	(5, 6, 'SS-105', 'Txindoki A.T.', 'Calle Beasain 3', '943000105', 'Nerea Arruti', 'Activo', 20240, 'Ordizia', 'txindoki@atletismo.eus'),
	(6, 7, 'SS-106', 'Tolosa C.F.', 'Estadio Berazubi', '943000106', 'Mikel Odriozola', 'Activo', 20400, 'Tolosa', 'tolosacf@atletismo.eus'),
	(7, 8, 'SS-107', 'Aloña Mendi K.E.', 'Plaza Oñati 1', '943000107', 'Kepa Arrizabalaga', 'Activo', 20560, 'Oñati', 'alona@mendi.eus'),
	(8, 9, 'SS-108', 'Barrutia A.E.', 'Vitoria Kalea 8', '945000108', 'Maite Martinez', 'Activo', 1001, 'Vitoria-Gasteiz', 'barrutia@gasteiz.eus'),
	(9, 10, 'SS-109', 'Bilbao Atletismo', 'Calle Licenciado Poza', '944000109', 'Alex de la Iglesia', 'Activo', 48011, 'Bilbao', 'bilbao@atletismo.eus'),
	(10, 11, 'SS-110', 'C.A. Getxo', 'Fadura Kirolgunea', '944000110', 'Jon Rahm', 'Activo', 48993, 'Getxo', 'getxo@atletismo.eus'),
	(11, 12, 'SS-111', 'C.A. Barakaldo', 'Lasesarre 1', '944000111', 'Unai Simon', 'Activo', 48902, 'Barakaldo', 'barakaldo@atletismo.eus'),
	(12, 13, 'SS-112', 'C.A. Santurtzi', 'Puerto Deportivo', '944000112', 'Iñaki Williams', 'Activo', 48980, 'Santurtzi', 'santurtzi@atletismo.eus'),
	(13, 14, 'SS-113', 'Deportivo Eibar', 'Unbe Kirolgunea', '943000113', 'Mikel Oyarzabal', 'Activo', 20600, 'Eibar', 'deporeibar@atletismo.eus'),
	(14, 15, 'SS-114', 'Goierri Garaia', 'Zumarraga Kalea', '943000114', 'Aritz Aduriz', 'Activo', 20700, 'Zumarraga', 'goierri@atletismo.eus'),
	(15, 16, 'SS-115', 'Haurtzaro', 'Oiartzun Bidea', '943000115', 'Julen Guerrero', 'Activo', 20180, 'Oiartzun', 'haurtzaro@atletismo.eus'),
	(16, 17, 'SS-116', 'Hernani C.R.E.', 'Landare Toki', '943000116', 'Xabi Alonso', 'Activo', 20120, 'Hernani', 'hernani@atletismo.eus'),
	(17, 18, 'SS-117', 'Ostadar S.K.T.', 'Lasarte Kalea', '943000117', 'Maialen Chourraut', 'Activo', 20160, 'Lasarte-Oria', 'ostadar@atletismo.eus'),
	(18, 19, 'SS-118', 'Lekeitio', 'Isuntza Hondartza', '946000118', 'Gaizka Mendieta', 'Activo', 48280, 'Lekeitio', 'lekeitio@atletismo.eus'),
	(19, 20, 'SS-119', 'Mintxeta A.T.', 'Elgoibar Kalea', '943000119', 'Joseba Etxeberria', 'Activo', 20870, 'Elgoibar', 'mintxeta@atletismo.eus'),
	(20, 21, 'SS-120', 'C.A. Portugalete', 'Los Llanos', '944000120', 'Julen Lopetegui', 'Activo', 48920, 'Portugalete', 'portu@atletismo.eus');

-- Volcando datos para la tabla m2m.competiciones: ~20 rows (aproximadamente)
REPLACE INTO `competiciones` (`id`, `name`, `sede`, `fecha`, `organizador`, `status`, `revisado_federacion`, `creado_el`, `fecha_inicio`, `fecha_fin`, `fecha_limite`) VALUES
	(1, 'Campeonato Euskadi Pista Cubierta', 'Donostia', '2025-11-18', 'Federación Vasca', 'Finalizada', 1, '2026-01-11 00:02:01', '2025-01-18', '2025-01-18', '2025-01-13'),
	(2, 'PLP Donostia Jornada 1', 'Donostia', '2026-01-24', 'Atlético SS', 'Cerrada', 1, '2026-01-11 00:02:01', '2025-01-25', '2025-01-25', '2025-01-20'),
	(3, 'Control Pista Cubierta Durango', 'Durango', '2026-01-20', 'Bidezabal', 'Cerrada', 1, '2026-01-11 00:02:01', '2025-02-01', '2025-02-01', '2025-01-27'),
	(4, 'Cto Bizkaia Clubes', 'Barakaldo', '2026-02-17', 'Federación Bizkaia', 'Inscripcion', 1, '2026-01-11 00:02:01', '2025-02-15', '2025-02-15', '2025-02-10'),
	(5, 'Jornada Saltos Vitoria', 'Vitoria-Gasteiz', '2026-02-26', 'Barrutia', 'Inscripcion', 1, '2026-01-11 00:02:01', '2025-02-22', '2025-02-22', '2025-02-17'),
	(6, 'PLP Anoeta Jornada 2', 'Donostia', '2026-03-01', 'Federación Gipuzkoa', 'Borrador', 1, '2026-01-11 00:02:01', '2025-03-01', '2025-03-01', '2025-02-24'),
	(7, 'Cto Gipuzkoa Lanzamientos', 'Tolosa', '2026-03-15', 'Tolosa CF', 'Inscripcion', 1, '2026-01-11 00:02:01', '2025-03-15', '2025-03-15', '2025-03-10'),
	(8, 'Reunión Internacional Basauri', 'Basauri', '2026-04-05', 'Federación Vasca', 'Inscripcion', 1, '2026-01-11 00:02:01', '2025-04-05', '2025-04-05', '2025-03-31'),
	(9, 'Jornada Escolar A', 'Eibar', '2026-04-12', 'Depor Eibar', 'Finalizada', 1, '2026-01-11 00:02:01', '2025-04-12', '2025-04-12', '2025-04-07'),
	(10, 'Control Marcas Aire Libre', 'Getxo', '2026-04-26', 'Getxo AT', 'Borrador', 1, '2026-01-11 00:02:01', '2025-04-26', '2025-04-26', '2025-04-21'),
	(11, 'Campeonato Euskadi Absoluto', 'Donostia', '2026-05-10', 'Federación Vasca', 'Borrador', 1, '2026-01-11 00:02:01', '2025-05-10', '2025-05-11', '2025-05-05'),
	(12, 'Trofeo San Prudencio', 'Vitoria-Gasteiz', '2026-05-24', 'Federación Alavesa', 'Borrador', 1, '2026-01-11 00:02:01', '2025-05-24', '2025-05-24', '2025-05-19'),
	(13, 'Gran Premio Ordizia', 'Ordizia', '2026-06-07', 'Txindoki', 'Borrador', 1, '2026-01-11 00:02:01', '2025-06-07', '2025-06-07', '2025-06-02'),
	(14, 'Cto Euskadi Sub23', 'Durango', '2026-06-21', 'Federación Vasca', 'Borrador', 1, '2026-01-11 00:02:01', '2025-06-21', '2025-06-21', '2025-06-16'),
	(15, 'Meeting Internacional Bilbao', 'Bilbao', '2026-07-05', 'Bilbao Atletismo', 'Borrador', 1, '2026-01-11 00:02:01', '2025-07-05', '2025-07-05', '2025-06-30'),
	(16, 'Cto Euskadi Sub18', 'Santurtzi', '2026-07-19', 'Santurtzi', 'Borrador', 1, '2026-01-11 00:02:01', '2025-07-19', '2025-07-19', '2025-07-14'),
	(17, 'Control Fin de Temporada', 'Donostia', '2026-01-26', 'Federación Gipuzkoa', 'Inscripcion', 1, '2026-01-11 00:02:01', '2025-07-26', '2025-07-26', '2025-07-21'),
	(18, 'Jornada Inicio Temporada', 'Tolosa', '2026-01-11', 'Tolosa CF', 'Finalizada', 1, '2026-01-11 00:02:01', '2026-01-11', '2026-01-15', '2025-12-13'),
	(19, 'PLP Otoño 1', 'Donostia', '2025-11-08', 'Federación Gipuzkoa', 'Finalizada', 1, '2026-01-11 00:02:01', '2025-11-08', '2025-11-08', '2025-11-03'),
	(20, 'Cto Euskadi Invierno', 'Vitoria-Gasteiz', '2025-12-13', 'Federación Alavesa', 'Finalizada', 1, '2026-01-11 00:02:01', '2025-12-13', '2025-12-13', '2025-12-08');

-- Volcando datos para la tabla m2m.migrations: ~13 rows (aproximadamente)
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2025_12_18_160143_create_personal_access_tokens_table', 1),
	(2, '2025_12_21_161754_create_cache_locks_table', 1),
	(3, '2025_12_21_161754_create_cache_table', 1),
	(4, '2025_12_21_161754_create_sessions_table', 1),
	(5, '2025_12_21_202755_create_usuarios_table', 1),
	(6, '2025_12_21_202756_create_clubs_table', 1),
	(7, '2025_12_21_202757_create_competiciones_table', 1),
	(8, '2025_12_21_202758_create_atletas_table', 1),
	(9, '2025_12_21_202800_create_registros_atleta_table', 1),
	(10, '2025_12_21_202802_create_resultados_table', 1),
	(11, '2025_12_21_202803_create_novedades_table', 1),
	(12, '2026_01_09_190000_create_atleta_categoria_triggers', 1),
	(13, '2026_01_10_230000_seed_admin_user', 1);

-- Volcando datos para la tabla m2m.novedades: ~21 rows (aproximadamente)
REPLACE INTO `novedades` (`id`, `fecha`, `contenido`, `tipo`) VALUES
	(1, '2025-01-19 10:00:00', 'Publicados los resultados del Campeonato de Euskadi PC.', 'resultado'),
	(2, '2025-01-20 12:00:00', 'Abierta inscripción para el control de Durango.', 'info'),
	(3, '2025-02-16 09:00:00', 'Resultados disponibles del Cto Bizkaia de Clubes.', 'resultado'),
	(4, '2025-02-20 16:30:00', 'Cambio de horario en la jornada de Saltos en Vitoria.', 'alerta'),
	(5, '2025-03-02 11:00:00', 'Gran participación en el PLP de Anoeta.', 'info'),
	(6, '2025-03-16 10:00:00', 'Récord de participación en Tolosa lanzamientos.', 'info'),
	(7, '2025-04-01 10:00:00', 'Lista de admitidos para Basauri disponible.', 'competicion'),
	(8, '2025-04-13 18:00:00', 'Fotos de la jornada escolar de Eibar subidas.', 'info'),
	(9, '2025-05-01 09:00:00', 'Horario definitivo Cto Euskadi Absoluto.', 'alerta'),
	(10, '2025-05-11 20:00:00', 'Finalizado el Cto Euskadi Absoluto con grandes marcas.', 'resultado'),
	(11, '2025-05-25 10:00:00', 'Resultados Trofeo San Prudencio.', 'resultado'),
	(12, '2025-06-01 12:00:00', 'Abiertas inscripciones Gran Premio Ordizia.', 'competicion'),
	(13, '2025-06-08 10:00:00', 'Resultados Ordizia disponibles.', 'resultado'),
	(14, '2025-06-22 10:00:00', 'Resultados Cto Euskadi Sub23.', 'resultado'),
	(15, '2025-07-01 09:00:00', 'Meeting de Bilbao: Atletas confirmados.', 'info'),
	(16, '2025-07-06 10:00:00', 'Resultados Meeting Bilbao.', 'resultado'),
	(17, '2025-07-20 10:00:00', 'Resultados Cto Euskadi Sub18.', 'resultado'),
	(18, '2025-09-01 10:00:00', 'Calendario de Otoño publicado.', 'info'),
	(19, '2025-10-20 10:00:00', 'Resultados inicio de temporada Tolosa.', 'resultado'),
	(20, '2025-12-01 10:00:00', 'Abierta inscripción Cto Invierno Vitoria.', 'competicion'),
	(21, '2026-01-11 00:00:00', 'Peruba prueba', 'info');

-- Volcando datos para la tabla m2m.personal_access_tokens: ~29 rows (aproximadamente)
REPLACE INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
	(1, 'App\\Models\\User', 1, 'auth_token', '656fa0ca369d9eb96943a9b9f80bd75d5211cb53314e249902ad4fede48ef7a9', '["*"]', '2026-01-11 09:26:12', NULL, '2026-01-11 09:25:54', '2026-01-11 09:26:12'),
	(2, 'App\\Models\\User', 25, 'auth_token', '71a466fc031ea97f2b2f28aad134be36b79a5bdb98486a95f46961275c895ca4', '["*"]', '2026-01-11 10:01:17', NULL, '2026-01-11 10:00:25', '2026-01-11 10:01:17'),
	(3, 'App\\Models\\User', 1, 'auth_token', '7c91d7f34dd64bb4aa774a74b7768127481532916784e6a4d4522a835a8eca2d', '["*"]', '2026-01-11 11:00:05', NULL, '2026-01-11 10:33:31', '2026-01-11 11:00:05'),
	(4, 'App\\Models\\User', 1, 'auth_token', 'd0180419d7499d99c0cdb96e5a3fa8fb504d4281bb97ffd6c1bfee071a5e4e0a', '["*"]', '2026-01-11 11:09:47', NULL, '2026-01-11 10:58:42', '2026-01-11 11:09:47'),
	(5, 'App\\Models\\User', 25, 'auth_token', '76d588509585f66b07b91704d7710f07b032bcbbaefb5673ef5d760f5518dd96', '["*"]', '2026-01-11 11:07:38', NULL, '2026-01-11 11:07:38', '2026-01-11 11:07:38'),
	(6, 'App\\Models\\User', 25, 'auth_token', '4a851a17781f56966cc6b18da77ea23c386a3bca331b03c685753e59685f41ca', '["*"]', '2026-01-11 11:36:16', NULL, '2026-01-11 11:12:54', '2026-01-11 11:36:16'),
	(7, 'App\\Models\\User', 25, 'auth_token', '11e1618791fff944dccad66207e85c63e7404335cacdf947db14ba3869d9781d', '["*"]', '2026-01-11 11:20:05', NULL, '2026-01-11 11:19:53', '2026-01-11 11:20:05'),
	(8, 'App\\Models\\User', 25, 'auth_token', '025f9bc3edcf11beb106e3b35a94892e9b1e25da2c39ed04ca22e7da2663cbc2', '["*"]', '2026-01-11 11:21:28', NULL, '2026-01-11 11:20:43', '2026-01-11 11:21:28'),
	(9, 'App\\Models\\User', 1, 'auth_token', '95235756550a0edfd7587693fee86428b262f009785e925d19f09cead1b096ad', '["*"]', '2026-01-11 11:24:47', NULL, '2026-01-11 11:24:47', '2026-01-11 11:24:47'),
	(10, 'App\\Models\\User', 25, 'auth_token', '82d50a7d9437df03201071522dfb5436f940d1be521eed1492cfdb8dcfa40f8d', '["*"]', '2026-01-11 11:26:05', NULL, '2026-01-11 11:25:06', '2026-01-11 11:26:05'),
	(11, 'App\\Models\\User', 1, 'auth_token', '3334f4b488b6cf8465f08bf5657701810395e0dd3c3e6286f5f540a830d16e74', '["*"]', '2026-01-11 11:28:44', NULL, '2026-01-11 11:26:21', '2026-01-11 11:28:44'),
	(12, 'App\\Models\\User', 2, 'auth_token', '4b905c6c863e313a57c7a5853a3c040b108190a91ee6e4472aa438453e3b4f80', '["*"]', '2026-01-11 11:40:11', NULL, '2026-01-11 11:36:50', '2026-01-11 11:40:11'),
	(13, 'App\\Models\\User', 2, 'auth_token', '51e6861da1d1ca2f36da352ab9117f8234e933dc69cb8038a7afcf52eaa21beb', '["*"]', '2026-01-11 11:51:47', NULL, '2026-01-11 11:37:43', '2026-01-11 11:51:47'),
	(14, 'App\\Models\\User', 25, 'auth_token', 'e15995be27208abd6955e1dbaf86e480a03233631bc00ffbc6044a9f683591b7', '["*"]', '2026-01-11 12:13:47', NULL, '2026-01-11 11:49:25', '2026-01-11 12:13:47'),
	(15, 'App\\Models\\User', 2, 'auth_token', 'ff6d556614b9a1b7dec2161481bea3034e7548e14799e3a3a2d8f1a76067b16c', '["*"]', '2026-01-11 11:59:53', NULL, '2026-01-11 11:52:03', '2026-01-11 11:59:53'),
	(16, 'App\\Models\\User', 1, 'auth_token', '762afccb68063c93b1ef163b291583b32d6a90b69765cdae09fb031df3c9825d', '["*"]', '2026-01-11 11:59:31', NULL, '2026-01-11 11:59:12', '2026-01-11 11:59:31'),
	(17, 'App\\Models\\User', 25, 'auth_token', 'f2bf234160d2e94a82f2ef48ba9c160432183ccabb752d48347538585a7f07ca', '["*"]', '2026-01-11 12:20:30', NULL, '2026-01-11 12:01:03', '2026-01-11 12:20:30'),
	(18, 'App\\Models\\User', 1, 'auth_token', '86dd209c1dd915f12fa47eabdcb202903e52de7a17c1b13c9a7b4ad23b62025d', '["*"]', '2026-01-11 12:17:16', NULL, '2026-01-11 12:17:10', '2026-01-11 12:17:16'),
	(19, 'App\\Models\\User', 25, 'auth_token', 'a154a91104d786a6f175deed95adc5ae55dd897ba884b56a7a83447d74452538', '["*"]', '2026-01-11 12:20:45', NULL, '2026-01-11 12:20:11', '2026-01-11 12:20:45'),
	(20, 'App\\Models\\User', 25, 'auth_token', '9eb48de1edfb478149a05365f86d8f41f93d1df3e3870702077b5b17eeb4756e', '["*"]', '2026-01-11 14:07:20', NULL, '2026-01-11 12:21:34', '2026-01-11 14:07:20'),
	(21, 'App\\Models\\User', 25, 'auth_token', '705eedb4f1839f39896e2ea83be2a6bec0e8af01be5dbe5c842ea51b748eed9b', '["*"]', '2026-01-11 15:07:08', NULL, '2026-01-11 14:30:01', '2026-01-11 15:07:08'),
	(22, 'App\\Models\\User', 1, 'auth_token', '44ff920d8c3b4edb29693ebe263bc56b319753c0e84dd74e1dd2a6c22d7b0438', '["*"]', '2026-01-11 15:23:14', NULL, '2026-01-11 15:22:45', '2026-01-11 15:23:14'),
	(23, 'App\\Models\\User', 25, 'auth_token', '57b01cb4f87568e6c3cdb76ac3bf5609bfaa97ff30ce5a5aba31341d8d8a0873', '["*"]', '2026-01-11 16:06:28', NULL, '2026-01-11 16:05:56', '2026-01-11 16:06:28'),
	(24, 'App\\Models\\User', 2, 'auth_token', 'ae95ad4cd6c6b2ff5e914a9edd89d31190b924d4df0ac50bf241c99f332e7f00', '["*"]', '2026-01-11 16:16:08', NULL, '2026-01-11 16:11:45', '2026-01-11 16:16:08'),
	(25, 'App\\Models\\User', 25, 'auth_token', '91a1fcc54de4f45e51dc2258a07257baaacf8e3dc5f849189fc512133bf3731f', '["*"]', '2026-01-11 16:16:41', NULL, '2026-01-11 16:16:28', '2026-01-11 16:16:41'),
	(26, 'App\\Models\\User', 2, 'auth_token', '2ec10bc2911b3bb86a9bf38c333852e139057c44abbdd73275075e5b260b9950', '["*"]', '2026-01-11 17:05:43', NULL, '2026-01-11 16:18:02', '2026-01-11 17:05:43'),
	(27, 'App\\Models\\User', 2, 'auth_token', 'b0674d4ba981045f7d376ae6469b86678ba551c99a2571b24d461293fb97cd7c', '["*"]', '2026-01-11 16:38:27', NULL, '2026-01-11 16:36:43', '2026-01-11 16:38:27'),
	(28, 'App\\Models\\User', 1, 'auth_token', 'ca9f397ddcb59d3a21e67f63ab6ead4526a36974f540906ac4a28d18fe20aaa3', '["*"]', '2026-01-11 16:42:12', NULL, '2026-01-11 16:41:53', '2026-01-11 16:42:12'),
	(29, 'App\\Models\\User', 1, 'auth_token', '17ea5dca1bf900a77cc944d330c0cff3db7803faf040de94c846ec6440577954', '["*"]', '2026-01-11 17:43:43', NULL, '2026-01-11 17:23:39', '2026-01-11 17:43:43');

-- Volcando datos para la tabla m2m.registros_atleta: ~24 rows (aproximadamente)
REPLACE INTO `registros_atleta` (`id`, `id_competicion`, `id_atleta`, `id_club`, `tipo_evento`, `dorsal`, `fecha_inscripcion`) VALUES
	(1, 1, 1, 1, '60m', 101, '2025-01-10'),
	(2, 1, 3, 3, '60m', 102, '2025-01-10'),
	(3, 1, 5, 5, '400m', 103, '2025-01-10'),
	(4, 2, 2, 2, 'Salto Altura', 104, '2025-01-20'),
	(5, 2, 4, 4, 'Salto Longitud', 105, '2025-01-20'),
	(6, 3, 7, 7, '1500m', 106, '2025-01-28'),
	(7, 4, 9, 9, '800m', 107, '2025-02-10'),
	(8, 5, 8, 8, 'Salto Altura', 108, '2025-02-18'),
	(9, 6, 11, 11, '200m', 109, '2025-02-25'),
	(10, 7, 13, 13, 'Lanzamiento Peso', 110, '2025-03-10'),
	(11, 8, 1, 1, '100m', 111, '2025-04-01'),
	(12, 9, 14, 14, '100m', 112, '2025-04-08'),
	(13, 10, 15, 15, '400m', 113, '2025-04-22'),
	(14, 11, 3, 3, '100m', 114, '2025-05-05'),
	(15, 11, 5, 5, '200m', 115, '2025-05-05'),
	(16, 12, 19, 19, '1500m', 116, '2025-05-20'),
	(17, 13, 17, 17, '800m', 117, '2025-06-02'),
	(18, 14, 10, 10, 'Salto Altura', 118, '2025-06-16'),
	(19, 15, 6, 6, '100m vallas', 119, '2025-06-30'),
	(20, 16, 20, 20, '400m', 120, '2025-07-14'),
	(21, 17, 4, 1, '100m', NULL, '2026-01-11'),
	(22, 17, 4, 1, '1500m', NULL, '2026-01-11'),
	(23, 4, 4, 1, '800m', NULL, '2026-01-11'),
	(24, 17, 1, 1, '60m', NULL, '2026-01-11');

-- Volcando datos para la tabla m2m.resultados: ~22 rows (aproximadamente)
REPLACE INTO `resultados` (`id`, `id_competicion`, `id_registro_atletico`, `tipo_evento`, `categoria`, `marca`, `posicion`, `wind_speed`, `id_atleta`) VALUES
	(1, 1, 1, '60m', 'Sub-23', '6.95', 1, 0.0, 1),
	(2, 1, 3, '60m', 'Senior', '7.02', 2, 0.0, 3),
	(3, 1, 5, '400m', 'Sub-20', '49.12', 1, 0.0, 5),
	(4, 2, 2, 'Salto Altura', 'Sub-18', '1.75', 1, 0.0, 2),
	(5, 2, 4, 'Salto de Longitud', 'Sub-18', '5.20', 3, 0.0, 4),
	(6, 3, 7, '1500m', 'Senior', '3:55.10', 4, 0.0, 7),
	(7, 4, 9, '800m', 'Sub-18', '1:52.30', 2, 0.5, 9),
	(8, 5, 8, 'Salto Altura', 'Sub-23', '1.65', 1, 0.0, 8),
	(9, 6, 11, '200m', 'Sub-23', '22.15', 3, 0.0, 11),
	(10, 7, 13, 'Lanzamiento de Peso', 'Senior', '14.50', 1, 0.0, 13),
	(11, 8, 1, '100m', 'Sub-23', '10.65', 2, 1.2, 1),
	(12, 9, 14, '100m', 'Sub-18', '12.80', 1, -0.5, 14),
	(13, 10, 15, '400m', 'Sub-23', '50.45', 5, 0.8, 15),
	(14, 11, 3, '100m', 'Senior', '10.85', 4, 0.2, 3),
	(15, 11, 5, '200m', 'Sub-20', '21.90', 2, 0.2, 5),
	(16, 12, 19, '1500m', 'Senior', '3:48.20', 1, 0.0, 19),
	(17, 13, 17, '800m', 'Sub-18', '1:55.60', 6, 0.4, 17),
	(18, 14, 10, 'Salto Altura', 'Sub-18', '1.70', 2, 0.0, 10),
	(19, 15, 6, '100m vallas', 'Sub-20', '14.10', 3, 1.1, 6),
	(20, 16, 20, '400m', 'Sub-18', '58.20', 2, 0.9, 20),
	(21, 1, 4, 'Salto de Longitud', 'Sub-18', '5.55', 3, 0.0, 4),
	(22, 19, 4, '100m', 'Sub-18', '12.33', 3, 0.0, 4);

-- Volcando datos para la tabla m2m.sessions: ~19 rows (aproximadamente)
REPLACE INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('2f4HlvII2l5GqWnq6FRSGD78NI0D2lFigRmMiXsR', NULL, '3.134.148.59', 'cypex.ai/scanning Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaGxQaWlaYW9PT1JrN0dpTkN3dGIyVlFhdkhJQmhMaVBKUDBhU005RSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768106474),
	('52l9SunMVxLSqFP1VmVZY6YquWgPTuHte0ELLaHW', NULL, '199.45.155.76', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN2pLV0VwWVJtR1NrRjhHVFBUV1QzQXRudE9sc0RYR2ZEeDVYSUNqVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768096196),
	('7VGF22j1XNRhEkrrklBv5ZIhnXvbasorjW8zspJt', NULL, '147.182.254.94', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSXJGdUREakx5RXY4a2ttSzdZWnhpcHI0dHh3dlN6ZHI5TzhHUjJYZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly84OC4xNC40Mi4yNDMiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768091598),
	('8IVTtHXHNKp2d9L9jf8hN2iMABGVmUTbAxvU1WOg', NULL, '199.45.155.76', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic3VGVVlCYXppQnJXMEljTkFodXFUYzhvWWtGQ054UnRma3dnRkU4OCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768096202),
	('97OxmE7CsczGjAumeVcstFcfYUa35RYf6TWR3RIS', NULL, '95.214.55.71', 'Hello World/1.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXU4UERDbW16Vnhuc2tiSTBtSkFOcENhck5kU1F6Y2VzSnlWMWJyWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768147390),
	('aQ4pQWBvZSOQWsjC56UD0GZAupUwIysOah5o6cZH', NULL, '167.94.138.184', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicTd3anprelBMQTBWME9TeDBPVGZmcXU3eEdYc0lOU1FYSFZ1ZnBSSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768110083),
	('egzaHvrw4yBdQksMGpjY95NZH3kgH3NgJfzsBKDN', NULL, '95.214.55.71', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidnlacEh2UkdIVE1aN3NhMWVVQ2Y0Rk8yVW1JcTFNMUx3UHpNT0s4diI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768149540),
	('eNVW9IXTpVN7wdMBjvZiNkdpHVWohcmG5zd0ZE7q', NULL, '213.176.19.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:121.0) Gecko/20100101 Firefox/121.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS0wwZU9VZjNzS0F5R29mSlVaRVRUbThKU0RxckRNT0xqV1pJU3NZcCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768150712),
	('GaRDcyDB729fciyrB0d06hDz0PhUeqT4FqTip3ns', NULL, '95.214.55.71', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiREZvSFo0c0xUblBHWTk4QTl4SzFwN0FNZHY2SmY1cXY2NnVjQzRhRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768094641),
	('jX0ykHtcs7sqIimF2sXtoJVB60qB8L4nCWsgyX0N', NULL, '91.196.152.66', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmljSmZzc3VIbmFmRVhzUGRTdmFPakIxT3RGeVBNYnB5V0dPZ0tsSSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768101571),
	('n9XeIlNhmxprLKPsuQLo6WuPH0xckYfBwkJZbBGl', NULL, '204.76.203.18', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWRVNmQ0ZHlvRWVvQVdaWjh2S1UxRDJudXg2TVBHZGRnWHFyVWhxZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768138359),
	('nTpWqnrIE0DcmQTCB8ecyDstTHYDLkgz115wPyaR', NULL, '18.97.9.102', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; PerplexityBot/1.0; +https://perplexity.ai/perplexitybot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSjJkb0pnUXdLUDFEQmVWMXQxTGhzZHpYSEVzTmlNUXV5aTE3QzZ4ZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9ydWJpcnJoLmVycGdlc3Rpb24uZXM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768101312),
	('q3pkKgNFlQbxnikc5VcQk9IHJD8UjPaPuuP5SY6z', NULL, '167.94.138.184', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicUpDb2NvRUxtWUdjRHp6dDl4T1NlYTlYME1CN2RsbmRtTXZ2MTk3byI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768110087),
	('t26z3qsbWYUIMdSOWefkze8NaHcCsaNe1r5ywDxw', NULL, '45.194.92.18', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZDQ4VDh0SXo5akFaYTJzYUoyTGhUMTNSR3V5Q2NoVzRzRXVQbnExciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768098344),
	('UbMBmfeKzAjJTrUmKhv1QJCYGXsSsO7l1C9PzKRB', NULL, '159.89.126.49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib0Y2Vm5MMHlrSVNoemFieWlOQ1c2RzZVUXJObG9zUmk2UG9Hc3VxSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768153091),
	('vsSzcRyZNPMf9rjlFrGH2ntAPE15adPNXHlYf1tt', NULL, '95.214.55.71', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOFRsQXl3dlEwWVVLQjRHWVdONmdxc2NUaGRyZ1J2Zk5IdGZDT1hLRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768123537),
	('w9Y5jOCdqnuGJnuyeWvgUmytnHb7kLU3PipRIeav', NULL, '20.163.14.51', 'Mozilla/5.0 zgrab/0.x', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVnhibHh1WWJnWmNLSGNtQlNlbERHODlOMHlXY1I2b3dhamdXWXduZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768156241),
	('wjbzZfkocXVA4KcSCQUCMpgVGSe01wb1nn1hOKrt', NULL, '3.134.148.59', 'cypex.ai/scanning Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGtJTXRLdUhKTTRhMjVUelgxQnc3clZwNzMxMndqN2NvNTlYRk5CaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768106328),
	('ztpyFwidO6ADDA0HAR684Keh3TozjA1uiCiwWrBo', NULL, '64.62.156.192', 'Mozilla/5.0 (Windows NT 10.0; rv:109.0) Gecko/20100101 Firefox/115.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYnpkM2xueG5IN1hrQmRNZWNpYmRLZTRZOXV1OUJtRWpxQjF1NzlFaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly84OC4xNC40Mi4yNDM6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768127594);

-- Volcando datos para la tabla m2m.usuarios: ~41 rows (aproximadamente)
REPLACE INTO `usuarios` (`id`, `username`, `password`, `email`, `rol`, `creado_el`, `desactivado`, `imagen`) VALUES
	(1, 'admin_fed', '$2y$12$03SRamzB1nmiYayJR4cb5uaySZ00kyYcvpggdddZGYeJI0GQAdn4G', 'admin@admin.com', 'FEDERACION', '2026-01-11 00:01:34', 0, NULL),
	(2, 'club_realsociedad', '$2y$12$fpCG9kidnXUzuBjvVk7ek.nMGrSplhANaJLOhDnzamiVsraW4TaUy', 'realsociedad@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, _binary 0x68747470733a2f2f7265732e636c6f7564696e6172792e636f6d2f646b75746a696874792f696d6167652f75706c6f61642f76313736383135313736392f617661746172732f6a6f346f61303834693361376e70333263646c762e6a7067),
	(3, 'club_superamara', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'superamara@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(4, 'club_atletico_ss', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'atleticoss@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(5, 'club_bidezabal', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'bidezabal@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(6, 'club_txindoki', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'txindoki@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(7, 'club_tolosa', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tolosa@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(8, 'club_alona', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'alonamendi@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(9, 'club_barrutia', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'barrutia@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(10, 'club_bilbao', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'bilbaoat@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(11, 'club_getxo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'getxo@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(12, 'club_barakaldo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'barakaldo@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(13, 'club_santurtzi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'santurtzi@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(14, 'club_eibar', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'eibar@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(15, 'club_goierri', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'goierri@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(16, 'club_haurtzaro', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'haurtzaro@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(17, 'club_hernani', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hernani@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(18, 'club_ostadar', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ostadar@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(19, 'club_lekeitio', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lekeitio@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(20, 'club_mintxeta', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'mintxeta@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(21, 'club_portugalete', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'portugalete@atletismo.eus', 'CLUB', '2026-01-11 00:02:01', 0, NULL),
	(22, 'atleta_unai', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'unai@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(23, 'atleta_maialen', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'maialen@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(24, 'atleta_iker', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'iker@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(25, 'atleta_ane', '$2y$12$68XrRYTbsUYPuQc5toh.f.Giu0YMHzE.w.NMxJB6v/K/qC22q2lTK', 'ane@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, _binary 0x68747470733a2f2f7265732e636c6f7564696e6172792e636f6d2f646b75746a696874792f696d6167652f75706c6f61642f76313736383135313830302f617661746172732f6269636568647579676c6367626b69776c6e6c792e6a7067),
	(26, 'atleta_mikel', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'mikel@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(27, 'atleta_leire', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'leire@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(28, 'atleta_jon', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'jon@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(29, 'atleta_nerea', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'nerea@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(30, 'atleta_aitor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'aitor@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(31, 'atleta_oihane', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'oihane@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(32, 'atleta_asier', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'asier@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(33, 'atleta_irati', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'irati@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(34, 'atleta_eneko', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'eneko@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(35, 'atleta_izaro', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'izaro@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(36, 'atleta_julen', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'julen@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(37, 'atleta_uxue', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'uxue@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(38, 'atleta_ander', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ander@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(39, 'atleta_nagore', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'nagore@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(40, 'atleta_xabier', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'xabier@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL),
	(41, 'atleta_garazi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'garazi@mail.com', 'ATLETA', '2026-01-11 00:02:01', 0, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
