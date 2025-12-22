/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MariaDB
 Source Server Version : 110302 (11.3.2-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : aaa

 Target Server Type    : MariaDB
 Target Server Version : 110302 (11.3.2-MariaDB)
 File Encoding         : 65001

 Date: 20/12/2025 23:03:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for atleta_club
-- ----------------------------
DROP TABLE IF EXISTS `atleta_club`;
CREATE TABLE `atleta_club`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_atleta` int(11) NOT NULL,
  `id_club` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `athlete_id`(`id_atleta`) USING BTREE,
  INDEX `club_id`(`id_club`) USING BTREE,
  CONSTRAINT `atleta_club_ibfk_1` FOREIGN KEY (`id_atleta`) REFERENCES `atletas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `atleta_club_ibfk_2` FOREIGN KEY (`id_club`) REFERENCES `clubs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for atletas
-- ----------------------------
DROP TABLE IF EXISTS `atletas`;
CREATE TABLE `atletas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NULL DEFAULT NULL,
  `club_actual_id` int(11) NULL DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fecha_nacimiento` date NULL DEFAULT NULL,
  `status` enum('Activo','Pendiente','Suspendido') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Pendiente',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`id_usuario`) USING BTREE,
  INDEX `current_club_id`(`club_actual_id`) USING BTREE,
  CONSTRAINT `atletas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `atletas_ibfk_2` FOREIGN KEY (`club_actual_id`) REFERENCES `clubs` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for clubs
-- ----------------------------
DROP TABLE IF EXISTS `clubs`;
CREATE TABLE `clubs`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NULL DEFAULT NULL,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `direccion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `responsable` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estado` enum('Activo','Pendiente','Suspendido') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Pendiente',
  `codigo_postal` int(11) NULL DEFAULT NULL,
  `localidad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `code`(`code`) USING BTREE,
  INDEX `user_id`(`id_usuario`) USING BTREE,
  CONSTRAINT `clubs_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for competiciones
-- ----------------------------
DROP TABLE IF EXISTS `competiciones`;
CREATE TABLE `competiciones`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sede` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fecha` date NOT NULL,
  `organizador` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` enum('Borrador','Inscripcion','Cerrada','Finalizada') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Borrador',
  `revisado_federacion` tinyint(1) NULL DEFAULT 0,
  `creado_el` timestamp NULL DEFAULT current_timestamp(),
  `fecha_inicio` date NULL DEFAULT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  `fecha_limite` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for novedades
-- ----------------------------
DROP TABLE IF EXISTS `novedades`;
CREATE TABLE `novedades`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `contenido` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tipo` enum('info','alerta','resultado','competicion') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for registros_atleta
-- ----------------------------
DROP TABLE IF EXISTS `registros_atleta`;
CREATE TABLE `registros_atleta`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_competicion` int(11) NOT NULL,
  `id_atleta` int(11) NOT NULL,
  `id_club` int(11) NOT NULL,
  `tipo_evento` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `dorsal` int(11) NULL DEFAULT NULL,
  `fecha_inscripcion` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `competition_id`(`id_competicion`) USING BTREE,
  INDEX `athlete_id`(`id_atleta`) USING BTREE,
  INDEX `club_id`(`id_club`) USING BTREE,
  CONSTRAINT `registros_atleta_ibfk_1` FOREIGN KEY (`id_competicion`) REFERENCES `competiciones` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `registros_atleta_ibfk_2` FOREIGN KEY (`id_atleta`) REFERENCES `atletas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `registros_atleta_ibfk_3` FOREIGN KEY (`id_club`) REFERENCES `clubs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for registros_club
-- ----------------------------
DROP TABLE IF EXISTS `registros_club`;
CREATE TABLE `registros_club`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_competicion` int(11) NOT NULL,
  `id_club` int(11) NOT NULL,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `competition_id`(`id_competicion`) USING BTREE,
  INDEX `club_id`(`id_club`) USING BTREE,
  CONSTRAINT `registros_club_ibfk_1` FOREIGN KEY (`id_competicion`) REFERENCES `competiciones` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `registros_club_ibfk_2` FOREIGN KEY (`id_club`) REFERENCES `clubs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for resultados
-- ----------------------------
DROP TABLE IF EXISTS `resultados`;
CREATE TABLE `resultados`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_competicion` int(11) NOT NULL,
  `id_registro_atletico` int(11) NOT NULL,
  `tipo_evento` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `categoria` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `marca` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `posicion` int(11) NULL DEFAULT NULL,
  `wind_speed` decimal(3, 1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `competition_id`(`id_competicion`) USING BTREE,
  INDEX `athlete_id`(`id_registro_atletico`) USING BTREE,
  CONSTRAINT `resultados_ibfk_1` FOREIGN KEY (`id_competicion`) REFERENCES `competiciones` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `resultados_ibfk_2` FOREIGN KEY (`id_registro_atletico`) REFERENCES `atletas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rol` enum('FEDERACION','CLUB','ATLETA') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `creado_el` timestamp NULL DEFAULT current_timestamp(),
  `desactivado` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
