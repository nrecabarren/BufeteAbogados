/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : bufete

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-07-03 20:10:12
*/

SET FOREIGN_KEY_CHECKS=0;



-- ----------------------------
-- Table structure for perfil
-- ----------------------------
DROP TABLE IF EXISTS `perfil`;
CREATE TABLE `perfil` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`descripcion`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=5

;

-- ----------------------------
-- Records of perfil
-- ----------------------------
BEGIN;
INSERT INTO `perfil` VALUES ('1', 'Administrador'), ('2', 'Cliente'), ('3', 'Gerente'), ('4', 'Secretaria');
COMMIT;

-- ----------------------------
-- Table structure for tipo_persona
-- ----------------------------
DROP TABLE IF EXISTS `tipo_persona`;
CREATE TABLE `tipo_persona` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`descripcion`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=3

;

-- ----------------------------
-- Records of tipo_persona
-- ----------------------------
BEGIN;
INSERT INTO `tipo_persona` VALUES ('1', 'Jurídica'), ('2', 'Natural');
COMMIT;

-- ----------------------------
-- Table structure for especialidad
-- ----------------------------
DROP TABLE IF EXISTS `especialidad`;
CREATE TABLE `especialidad` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`nombre`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=34

;

-- ----------------------------
-- Records of especialidad
-- ----------------------------
BEGIN;
INSERT INTO `especialidad` VALUES ('1', 'Accidentes de Tráfico'), ('2', 'Administrativo'), ('3', 'Adopciones'), ('4', 'Agrario'), ('5', 'Blanqueo de Capitales'), ('6', 'Civil'), ('7', 'Comunidad de Propietarios'), ('8', 'Comunitario'), ('9', 'Concursal'), ('10', 'Constitucional'), ('11', 'Consumidores y Usuarios'), ('12', 'Delitos contra el Honor'), ('13', 'Delitos contra el Patrimonio'), ('14', 'Delitos contra la Intimidad'), ('15', 'Delitos contra la Seguridad Vial'), ('16', 'Delitos de Amenazas'), ('17', 'Delitos de Calumnias e Injurias'), ('18', 'Delitos de Daños'), ('19', 'Delitos de Desc. y Rev. Secretos'), ('20', 'Delitos Propiedad Intelectual'), ('21', 'Estafas'), ('22', 'Extranjería'), ('23', 'Familia'), ('24', 'Fiscal'), ('25', 'Hereditario'), ('26', 'Internet'), ('27', 'Laboral'), ('28', 'LOPD'), ('29', 'Mercantil'), ('30', 'Penal'), ('31', 'Propiedad Intelectual'), ('32', 'Reputación Online'), ('33', 'Urbanismo');
COMMIT;

-- ----------------------------
-- Table structure for estado
-- ----------------------------
DROP TABLE IF EXISTS `estado`;
CREATE TABLE `estado` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`descripcion`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=6

;

-- ----------------------------
-- Records of estado
-- ----------------------------
BEGIN;
INSERT INTO `estado` VALUES ('1', 'Agendada'), ('2', 'Anulada'), ('3', 'Confirmada'), ('4', 'Perdida'), ('5', 'Realizada');
COMMIT;

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`rut`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
`dv`  varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
`contrasena`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
`nombre_completo`  varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
`perfil_id`  int(11) NOT NULL ,
`estado`  int(11) UNSIGNED NOT NULL DEFAULT 1 ,
PRIMARY KEY (`id`, `perfil_id`),
FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
INDEX `fk_usuario_perfil1_idx` (`perfil_id`) USING BTREE ,
INDEX `id` (`id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=14

;

-- ----------------------------
-- Records of usuario
-- ----------------------------
BEGIN;
INSERT INTO `usuario` VALUES ('1', '22.444.663', '2', '123', 'Nicolas Recabarren', '1', '1'), ('2', '19.585.569', '2', 'abc', 'Karina Soto Soto', '2', '1'), ('5', '11.111.111', '1', 'abc', 'Juanito Perez', '3', '1'), ('6', '19.583.816', 'k', 'abc', 'Cesar Gomez', '2', '1');
COMMIT;


-- ----------------------------
-- Table structure for cliente
-- ----------------------------
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`fecha_incorporacion`  date NOT NULL ,
`direccion`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
`telefono`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
`tipo_persona_id`  int(11) NOT NULL ,
`usuario_id`  int(11) NOT NULL ,
PRIMARY KEY (`id`, `tipo_persona_id`, `usuario_id`),
FOREIGN KEY (`tipo_persona_id`) REFERENCES `tipo_persona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
INDEX `fk_cliente_tipo_persona_idx` (`tipo_persona_id`) USING BTREE ,
INDEX `fk_cliente_usuario1_idx` (`usuario_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=5

;

-- ----------------------------
-- Records of cliente
-- ----------------------------
BEGIN;
INSERT INTO `cliente` VALUES ('1', '2017-06-24', 'Av. Salvador 95', '123', '1', '2'), ('3', '2017-06-25', 'Padre Sergio Correa', '232', '2', '5'), ('4', '2017-06-28', 'Calle 123', '1234442', '2', '6');
COMMIT;



-- ----------------------------
-- Table structure for abogado
-- ----------------------------
DROP TABLE IF EXISTS `abogado`;
CREATE TABLE `abogado` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`fecha_contratacion`  date NOT NULL ,
`valor_hora`  int(11) NOT NULL ,
`especialidad_id`  int(11) NOT NULL ,
`usuario_id`  int(11) NOT NULL ,
PRIMARY KEY (`id`, `especialidad_id`, `usuario_id`),
FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
INDEX `fk_abogado_especialidad1_idx` (`especialidad_id`) USING BTREE ,
INDEX `fk_abogado_usuario` (`usuario_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=2

;

-- ----------------------------
-- Records of abogado
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for atencion
-- ----------------------------
DROP TABLE IF EXISTS `atencion`;
CREATE TABLE `atencion` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`fecha_atencion`  date NOT NULL ,
`hora_atencion`  time NOT NULL ,
`cliente_id`  int(11) NOT NULL ,
`abogado_id`  int(11) NOT NULL ,
`estado_id`  int(11) NOT NULL ,
PRIMARY KEY (`id`, `cliente_id`, `abogado_id`, `estado_id`),
FOREIGN KEY (`abogado_id`) REFERENCES `abogado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
INDEX `fk_atencion_cliente1_idx` (`cliente_id`) USING BTREE ,
INDEX `fk_atencion_abogado1_idx` (`abogado_id`) USING BTREE ,
INDEX `fk_atencion_estado1_idx` (`estado_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=1

;

-- ----------------------------
-- Records of atencion
-- ----------------------------
BEGIN;
COMMIT;



-- ----------------------------
-- Auto increment value for abogado
-- ----------------------------
ALTER TABLE `abogado` AUTO_INCREMENT=2;

-- ----------------------------
-- Auto increment value for atencion
-- ----------------------------
ALTER TABLE `atencion` AUTO_INCREMENT=1;

-- ----------------------------
-- Auto increment value for cliente
-- ----------------------------
ALTER TABLE `cliente` AUTO_INCREMENT=5;

-- ----------------------------
-- Auto increment value for especialidad
-- ----------------------------
ALTER TABLE `especialidad` AUTO_INCREMENT=34;

-- ----------------------------
-- Auto increment value for estado
-- ----------------------------
ALTER TABLE `estado` AUTO_INCREMENT=6;

-- ----------------------------
-- Auto increment value for perfil
-- ----------------------------
ALTER TABLE `perfil` AUTO_INCREMENT=5;

-- ----------------------------
-- Auto increment value for tipo_persona
-- ----------------------------
ALTER TABLE `tipo_persona` AUTO_INCREMENT=3;

-- ----------------------------
-- Auto increment value for usuario
-- ----------------------------
ALTER TABLE `usuario` AUTO_INCREMENT=14;
