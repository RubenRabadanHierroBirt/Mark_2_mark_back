SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- 1. Generar Usuarios (Contraseñas simuladas como hash dummy)
-- Roles: 1 Federación, 3 Clubs, 5 Atletas
-- ----------------------------
INSERT INTO `usuarios` (`id`, `username`, `password`, `email`, `rol`, `desactivado`) VALUES
(1, 'admin_fed', '$2y$10$dummyhashfederacion123', 'federacion@euskadi.eus', 'FEDERACION', 0),
(2, 'real_sociedad', '$2y$10$dummyhashclub1', 'atletismo@realsociedad.eus', 'CLUB', 0),
(3, 'bm_bilbao', '$2y$10$dummyhashclub2', 'info@bilbaoatletismo.com', 'CLUB', 0),
(4, 'durango_kt', '$2y$10$dummyhashclub3', 'admin@durangokt.eus', 'CLUB', 0),
(5, 'jon_agirre', '$2y$10$dummyhashatleta1', 'jon.agirre@email.com', 'ATLETA', 0),
(6, 'ane_etxebarria', '$2y$10$dummyhashatleta2', 'ane.etxe@email.com', 'ATLETA', 0),
(7, 'mikel_zubi', '$2y$10$dummyhashatleta3', 'mikel.zubiaga@email.com', 'ATLETA', 0),
(8, 'maite_izar', '$2y$10$dummyhashatleta4', 'maite.izar@email.com', 'ATLETA', 0),
(9, 'unai_goiko', '$2y$10$dummyhashatleta5', 'unai.goiko@email.com', 'ATLETA', 0);

-- ----------------------------
-- 2. Generar Clubs
-- Vinculados a los usuarios creados arriba
-- ----------------------------
INSERT INTO `clubs` (`id`, `id_usuario`, `code`, `name`, `direccion`, `telefono`, `responsable`, `estado`, `codigo_postal`, `localidad`) VALUES
(1, 2, 'SS001', 'Real Sociedad S.A.D.', 'Paseo de Anoeta 1', '943462833', 'Xabier Arruabarrena', 'Activo', 20014, 'Donostia-San Sebastián'),
(2, 3, 'BI002', 'Bilbao Atletismo', 'Martin Barua Picaza 27', '944415566', 'Amaia Piedra', 'Activo', 48003, 'Bilbao'),
(3, 4, 'BI003', 'Durango Kirol Taldea', 'Landako Etorbidea s/n', '946200112', 'Iñaki Eguren', 'Activo', 48200, 'Durango');

-- ----------------------------
-- 3. Generar Atletas
-- Vinculados a usuarios y asignados a clubs actuales
-- ----------------------------
INSERT INTO `atletas` (`id`, `id_usuario`, `club_actual_id`, `nombre`, `email`, `telefono`, `fecha_nacimiento`, `status`) VALUES
(1, 5, 1, 'Jon Agirre Larrañaga', 'jon.agirre@email.com', '666111222', '1998-05-12', 'Activo'),
(2, 6, 2, 'Ane Etxebarria Garmendia', 'ane.etxe@email.com', '666333444', '2001-08-23', 'Activo'),
(3, 7, 3, 'Mikel Zubiaga Urrutia', 'mikel.zubiaga@email.com', '666555666', '1995-11-04', 'Activo'),
(4, 8, 1, 'Maite Izagirre Olabarria', 'maite.izar@email.com', '666777888', '2003-02-15', 'Activo'),
(5, 9, 3, 'Unai Goikoetxea Bilbao', 'unai.goiko@email.com', '666999000', '2000-07-30', 'Suspendido');

-- ----------------------------
-- 4. Historial Atleta-Club (Tabla intermedia)
-- Refleja la pertenencia actual y un cambio histórico (fichaje)
-- ----------------------------
INSERT INTO `atleta_club` (`id`, `id_atleta`, `id_club`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 1, 1, '2023-01-01', NULL), -- Jon en Real Sociedad (Actual)
(2, 2, 2, '2022-09-01', NULL), -- Ane en Bilbao Atletismo (Actual)
(3, 3, 3, '2020-01-01', NULL), -- Mikel en Durango (Actual)
(4, 4, 1, '2024-01-01', NULL), -- Maite en Real Sociedad (Actual)
(5, 4, 3, '2022-01-01', '2023-12-31'), -- Maite estuvo en Durango antes (Histórico)
(6, 5, 3, '2021-06-15', NULL); -- Unai en Durango (Actual)

-- ----------------------------
-- 5. Generar Competiciones
-- Eventos pasados y futuros en el País Vasco
-- ----------------------------
INSERT INTO `competiciones` (`id`, `name`, `sede`, `fecha`, `organizador`, `status`, `revisado_federacion`, `fecha_inicio`, `fecha_fin`, `fecha_limite`) VALUES
(1, 'Campeonato de Euskadi Absoluto Pista Cubierta', 'Velódromo Antonio Elorza (Anoeta)', '2024-02-15', 'Federación Vasca de Atletismo', 'Finalizada', 1, '2024-02-15', '2024-02-16', '2024-02-10'),
(2, 'Meeting Internacional de Bilbao', 'Polideportivo Zorroza', '2024-06-20', 'Bilbao Kirolak', 'Inscripcion', 1, '2024-06-20', '2024-06-20', '2024-06-15'),
(3, 'Cross Internacional de San Sebastián', 'Lasarte', '2024-11-05', 'Flych Kirol Elkartea', 'Borrador', 0, '2024-11-05', '2024-11-05', '2024-10-30');

-- ----------------------------
-- 6. Registros de Clubs en Competiciones
-- ----------------------------
INSERT INTO `registros_club` (`id`, `id_competicion`, `id_club`, `fecha_registro`) VALUES
(1, 1, 1, '2024-02-01 10:00:00'), -- Real Sociedad se registró al Cto Euskadi
(2, 1, 2, '2024-02-02 11:30:00'), -- Bilbao Atletismo se registró al Cto Euskadi
(3, 1, 3, '2024-02-01 09:15:00'), -- Durango se registró al Cto Euskadi
(4, 2, 1, '2024-05-20 10:00:00'); -- Real Sociedad se registra al Meeting

-- ----------------------------
-- 7. Registros de Atletas en Competiciones (Inscripciones)
-- ----------------------------
INSERT INTO `registros_atleta` (`id`, `id_competicion`, `id_atleta`, `id_club`, `tipo_evento`, `dorsal`, `fecha_inscripcion`) VALUES
-- Competición 1 (Finalizada): Cto Euskadi
(1, 1, 1, 1, '100m Lisos', 104, '2024-02-05'), -- Jon Agirre
(2, 1, 1, 1, '200m Lisos', 104, '2024-02-05'), -- Jon Agirre (Doblete)
(3, 1, 2, 2, '1500m', 205, '2024-02-06'), -- Ane Etxebarria
(4, 1, 3, 3, 'Lanzamiento de Peso', 310, '2024-02-04'), -- Mikel Zubiaga
(5, 1, 4, 1, 'Salto de Longitud', 112, '2024-02-05'), -- Maite Izagirre

-- Competición 2 (Inscripción abierta): Meeting Bilbao
(6, 2, 1, 1, '100m Lisos', NULL, '2024-05-25');

-- ----------------------------
-- 8. Resultados
-- Solo para la competición finalizada (ID 1)
-- ----------------------------
INSERT INTO `resultados` (`id`, `id_competicion`, `id_registro_atletico`, `tipo_evento`, `categoria`, `marca`, `posicion`, `wind_speed`) VALUES
(1, 1, 1, '100m Lisos', 'Senior', '10.54', 1, 1.2), -- Jon ganó los 100m
(2, 1, 2, '200m Lisos', 'Senior', '21.30', 2, 0.5), -- Jon 2º en 200m
(3, 1, 3, '1500m', 'Sub-23', '4:15.20', 1, NULL), -- Ane ganó 1500m
(4, 1, 4, 'Lanzamiento de Peso', 'Senior', '14.50m', 3, NULL), -- Mikel 3º en peso
(5, 1, 5, 'Salto de Longitud', 'Sub-23', '6.10m', 1, 2.1); -- Maite ganó Longitud

-- ----------------------------
-- 9. Novedades / Noticias
-- ----------------------------
INSERT INTO `novedades` (`id`, `fecha`, `contenido`, `tipo`) VALUES
(1, '2024-02-18 09:00:00', 'Resultados oficiales del Campeonato de Euskadi Absoluto disponibles.', 'resultado'),
(2, '2024-05-01 10:00:00', 'Abierto el plazo de inscripción para el Meeting Internacional de Bilbao.', 'info'),
(3, '2024-06-01 08:30:00', 'Recordatorio: Los clubs deben renovar licencias antes del 30 de junio.', 'alerta');

SET FOREIGN_KEY_CHECKS = 1;