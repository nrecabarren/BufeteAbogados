/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : bufete

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-07-08 11:20:44
*/

SET FOREIGN_KEY_CHECKS=0;


-- ----------------------------
-- Table structure for especialidad
-- ----------------------------
DROP TABLE IF EXISTS `especialidad`;
CREATE TABLE `especialidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of especialidad
-- ----------------------------
INSERT INTO `especialidad` VALUES ('1', 'Accidentes de Tráfico');
INSERT INTO `especialidad` VALUES ('2', 'Administrativo');
INSERT INTO `especialidad` VALUES ('3', 'Adopciones');
INSERT INTO `especialidad` VALUES ('4', 'Agrario');
INSERT INTO `especialidad` VALUES ('5', 'Blanqueo de Capitales');
INSERT INTO `especialidad` VALUES ('6', 'Civil');
INSERT INTO `especialidad` VALUES ('7', 'Comunidad de Propietarios');
INSERT INTO `especialidad` VALUES ('8', 'Comunitario');
INSERT INTO `especialidad` VALUES ('9', 'Concursal');
INSERT INTO `especialidad` VALUES ('10', 'Constitucional');
INSERT INTO `especialidad` VALUES ('11', 'Consumidores y Usuarios');
INSERT INTO `especialidad` VALUES ('12', 'Delitos contra el Honor');
INSERT INTO `especialidad` VALUES ('13', 'Delitos contra el Patrimonio');
INSERT INTO `especialidad` VALUES ('14', 'Delitos contra la Intimidad');
INSERT INTO `especialidad` VALUES ('15', 'Delitos contra la Seguridad Vial');
INSERT INTO `especialidad` VALUES ('16', 'Delitos de Amenazas');
INSERT INTO `especialidad` VALUES ('17', 'Delitos de Calumnias e Injurias');
INSERT INTO `especialidad` VALUES ('18', 'Delitos de Daños');
INSERT INTO `especialidad` VALUES ('19', 'Delitos de Desc. y Rev. Secretos');
INSERT INTO `especialidad` VALUES ('20', 'Delitos Propiedad Intelectual');
INSERT INTO `especialidad` VALUES ('21', 'Estafas');
INSERT INTO `especialidad` VALUES ('22', 'Extranjería');
INSERT INTO `especialidad` VALUES ('23', 'Familia');
INSERT INTO `especialidad` VALUES ('24', 'Fiscal');
INSERT INTO `especialidad` VALUES ('25', 'Hereditario');
INSERT INTO `especialidad` VALUES ('26', 'Internet');
INSERT INTO `especialidad` VALUES ('27', 'Laboral');
INSERT INTO `especialidad` VALUES ('28', 'LOPD');
INSERT INTO `especialidad` VALUES ('29', 'Mercantil');
INSERT INTO `especialidad` VALUES ('30', 'Penal');
INSERT INTO `especialidad` VALUES ('31', 'Propiedad Intelectual');
INSERT INTO `especialidad` VALUES ('32', 'Reputación Online');
INSERT INTO `especialidad` VALUES ('33', 'Urbanismo');

-- ----------------------------
-- Table structure for estado
-- ----------------------------
DROP TABLE IF EXISTS `estado`;
CREATE TABLE `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of estado
-- ----------------------------
INSERT INTO `estado` VALUES ('1', 'Agendada');
INSERT INTO `estado` VALUES ('2', 'Anulada');
INSERT INTO `estado` VALUES ('3', 'Confirmada');
INSERT INTO `estado` VALUES ('4', 'Perdida');
INSERT INTO `estado` VALUES ('5', 'Realizada');

-- ----------------------------
-- Table structure for perfil
-- ----------------------------
DROP TABLE IF EXISTS `perfil`;
CREATE TABLE `perfil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of perfil
-- ----------------------------
INSERT INTO `perfil` VALUES ('1', 'Administrador');
INSERT INTO `perfil` VALUES ('2', 'Cliente');
INSERT INTO `perfil` VALUES ('3', 'Gerente');
INSERT INTO `perfil` VALUES ('4', 'Secretaria');
INSERT INTO `perfil` VALUES ('5', 'Sin Perfil');

-- ----------------------------
-- Table structure for tipo_persona
-- ----------------------------
DROP TABLE IF EXISTS `tipo_persona`;
CREATE TABLE `tipo_persona` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tipo_persona
-- ----------------------------
INSERT INTO `tipo_persona` VALUES ('1', 'Jurídica');
INSERT INTO `tipo_persona` VALUES ('2', 'Natural');

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rut` varchar(45) NOT NULL,
  `dv` varchar(1) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `nombre_completo` varchar(60) NOT NULL,
  `perfil_id` int(11) NOT NULL,
  `estado` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`,`perfil_id`),
  KEY `fk_usuario_perfil1_idx` (`perfil_id`),
  KEY `id` (`id`),
  CONSTRAINT `fk_usuario_perfil1` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES ('1', '22.444.663', '2', '900150983cd24fb0d6963f7d28e17f72', 'Nicolas Recabarren', '1', '1');
INSERT INTO `usuario` VALUES ('2', '19.585.569', '2', '900150983cd24fb0d6963f7d28e17f72', 'Karina Soto Soto', '2', '1');
INSERT INTO `usuario` VALUES ('5', '11.111.111', '1', '900150983cd24fb0d6963f7d28e17f72', 'Juanito Perez', '4', '1');
INSERT INTO `usuario` VALUES ('6', '19.583.816', 'k', '900150983cd24fb0d6963f7d28e17f72', 'Cesar Gomez', '2', '1');
INSERT INTO `usuario` VALUES ('11', '15.480.665', '2', '900150983cd24fb0d6963f7d28e17f72', 'Leonardo Recabarren', '5', '1');
INSERT INTO `usuario` VALUES ('12', '8.218.133', '4', '900150983cd24fb0d6963f7d28e17f72', 'Rita Valderrama', '5', '1');
INSERT INTO `usuario` VALUES ('13', '14.571.123', '1', '900150983cd24fb0d6963f7d28e17f72', 'Hans Martinez', '5', '1');
INSERT INTO `usuario` VALUES ('14', '22.222.222', '2', '900150983cd24fb0d6963f7d28e17f72', 'Gerente', '3', '1');
INSERT INTO `usuario` VALUES ('15', '10.664.444', '6', '900150983cd24fb0d6963f7d28e17f72', 'Nelly Graciela', '5', '1');
INSERT INTO `usuario` VALUES ('16', '17.339.267', '2', '900150983cd24fb0d6963f7d28e17f72', 'Marina Cecilia Saavedra Urrutia', '4', '1');
INSERT INTO `usuario` VALUES ('17', '17.325.243', '9', '900150983cd24fb0d6963f7d28e17f72', 'Hector Rene Concha Godoy', '2', '1');
INSERT INTO `usuario` VALUES ('18', '16.901.863', '4', '900150983cd24fb0d6963f7d28e17f72', 'Jose Luis Villanueva Caceres', '2', '1');
INSERT INTO `usuario` VALUES ('19', '91.143.000', '2', '900150983cd24fb0d6963f7d28e17f72', 'COMPAÑÍA NACIONAL DE FUERZA ELÉCTRICA S.A.', '2', '1');
INSERT INTO `usuario` VALUES ('20', '19.186.628', '2', '900150983cd24fb0d6963f7d28e17f72', 'Luis Antonio Bustos Bustos', '2', '1');
INSERT INTO `usuario` VALUES ('21', '76.037.523', '3', '900150983cd24fb0d6963f7d28e17f72', 'Capitales y Rentas S.A.', '2', '1');
INSERT INTO `usuario` VALUES ('22', '17.402.488', 'K', '900150983cd24fb0d6963f7d28e17f72', 'Juan Luis Andrade Geis', '2', '1');
INSERT INTO `usuario` VALUES ('23', '83.593.300', '8', '900150983cd24fb0d6963f7d28e17f72', 'Sociedad Kutz y Rodriguez Ltda.', '2', '1');
INSERT INTO `usuario` VALUES ('24', '18.849.984', '8', '900150983cd24fb0d6963f7d28e17f72', 'Miguel Angel Barrientos Yañez', '2', '1');
INSERT INTO `usuario` VALUES ('25', '83.382.700', '6', '900150983cd24fb0d6963f7d28e17f72', 'Comercial Ecsa S.A.', '2', '1');
INSERT INTO `usuario` VALUES ('26', '17.339.267', '2', '900150983cd24fb0d6963f7d28e17f72', 'Marina Cecilia Saavedra Urrutia', '2', '1');
INSERT INTO `usuario` VALUES ('27', '17.680.643', '5', '900150983cd24fb0d6963f7d28e17f72', 'Alfredo Manuel Montero Medina', '2', '1');
INSERT INTO `usuario` VALUES ('28', '79713440', '6', '900150983cd24fb0d6963f7d28e17f72', 'Agricola Miravalle Ltda.', '2', '1');
INSERT INTO `usuario` VALUES ('29', '10.664.444', '6', '900150983cd24fb0d6963f7d28e17f72', 'Nelly Graciela Morales Silva', '2', '1');
INSERT INTO `usuario` VALUES ('30', '76.035.443', '0', '900150983cd24fb0d6963f7d28e17f72', 'AGRICOLA CAMERON LTDA', '2', '1');
INSERT INTO `usuario` VALUES ('31', '10.302.190', '1', '900150983cd24fb0d6963f7d28e17f72', 'Hugo Jorge Urrutia Montes', '2', '1');
INSERT INTO `usuario` VALUES ('32', '10.547.536', '5', '900150983cd24fb0d6963f7d28e17f72', 'Rina Alme Meza Araneda', '2', '1');
INSERT INTO `usuario` VALUES ('33', '76.039.999', 'k', '900150983cd24fb0d6963f7d28e17f72', 'PARQUE TITANIUM S.A.', '2', '1');
INSERT INTO `usuario` VALUES ('34', '19.860.248', '5', '900150983cd24fb0d6963f7d28e17f72', 'Soledad Alejandra Sanchez Peña', '2', '1');
INSERT INTO `usuario` VALUES ('35', '17.691.849', '7', '900150983cd24fb0d6963f7d28e17f72', 'Jose Gaston Cid Arroyo', '2', '1');
INSERT INTO `usuario` VALUES ('36', '79.808.860', '2', '900150983cd24fb0d6963f7d28e17f72', 'ABSALON ESPINOSA INMOBILIARIA LTDA.', '2', '1');
INSERT INTO `usuario` VALUES ('37', '12.765.836', '6', '900150983cd24fb0d6963f7d28e17f72', 'Carolina Andrea Plaza Rojas', '3', '1');
INSERT INTO `usuario` VALUES ('38', '11.448.904', '2', '900150983cd24fb0d6963f7d28e17f72', 'Carlos Ivan Valenzuela Cid', '3', '1');
INSERT INTO `usuario` VALUES ('39', '13.770.506', '0', '900150983cd24fb0d6963f7d28e17f72', 'Ana Maria Henriquez Mendez', '3', '1');
INSERT INTO `usuario` VALUES ('40', '11.959.315', '8', '900150983cd24fb0d6963f7d28e17f72', 'Alberto Rodrigo Espejo Vargas', '3', '1');
INSERT INTO `usuario` VALUES ('41', '16.204.720', '5', '900150983cd24fb0d6963f7d28e17f72', 'Marco Antonio Navarro Avendaño', '3', '1');
INSERT INTO `usuario` VALUES ('42', '14.490.825', '2', '900150983cd24fb0d6963f7d28e17f72', 'Ana Lidia Navarro Guajardo', '3', '1');
INSERT INTO `usuario` VALUES ('43', '13.604.300', '5', '900150983cd24fb0d6963f7d28e17f72', 'Cesar Enrique Morales Medina', '3', '1');
INSERT INTO `usuario` VALUES ('44', '14.284.031', '6', '900150983cd24fb0d6963f7d28e17f72', 'Juan Manuel Flores Rebolledo', '3', '1');
INSERT INTO `usuario` VALUES ('45', '10.066.612', 'k', '900150983cd24fb0d6963f7d28e17f72', 'Juan Miguel Arriagada Castañeda', '3', '1');
INSERT INTO `usuario` VALUES ('46', '11.448.750', '3', '900150983cd24fb0d6963f7d28e17f72', 'Juan Carlos Cataldo Munizaga', '3', '1');
INSERT INTO `usuario` VALUES ('47', '11.574.234', '5', '900150983cd24fb0d6963f7d28e17f72', 'Cecilia Maria Perez Fernandez', '3', '1');
INSERT INTO `usuario` VALUES ('48', '13.604.392', '7', '900150983cd24fb0d6963f7d28e17f72', 'Manuel Gustavo Aranda Garcia', '3', '1');
INSERT INTO `usuario` VALUES ('49', '12.077.264', '3', '900150983cd24fb0d6963f7d28e17f72', 'Carmen Gloria Delgado Rojas', '3', '1');
INSERT INTO `usuario` VALUES ('50', '14.438.381', '8', '900150983cd24fb0d6963f7d28e17f72', 'Esteban Luis Morales Paredes', '3', '1');
INSERT INTO `usuario` VALUES ('51', '13.604.980', '1', '900150983cd24fb0d6963f7d28e17f72', 'Alejandro Manuel Martine Concha', '3', '1');
INSERT INTO `usuario` VALUES ('52', '10.493.740', '3', '900150983cd24fb0d6963f7d28e17f72', 'Mario Carlos Gonzales Blanco', '3', '1');
INSERT INTO `usuario` VALUES ('53', '11.959.215', '1', '900150983cd24fb0d6963f7d28e17f72', 'Juan Carlos Maturana Perez', '3', '1');
INSERT INTO `usuario` VALUES ('54', '15.494.012', 'k', '900150983cd24fb0d6963f7d28e17f72', 'Rosario Adriana Cortez Vega', '3', '1');
INSERT INTO `usuario` VALUES ('55', '10.108.093', '5', '900150983cd24fb0d6963f7d28e17f72', 'Miguel Andres Miranda Cofre', '3', '1');
INSERT INTO `usuario` VALUES ('56', '10.805.156', '6', '900150983cd24fb0d6963f7d28e17f72', 'Judith Daniela Vega Carmona', '3', '1');




-- ----------------------------
-- Table structure for abogado
-- ----------------------------
DROP TABLE IF EXISTS `abogado`;
CREATE TABLE `abogado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_contratacion` date NOT NULL,
  `valor_hora` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`especialidad_id`,`usuario_id`),
  KEY `fk_abogado_especialidad1_idx` (`especialidad_id`),
  KEY `fk_abogado_usuario` (`usuario_id`),
  CONSTRAINT `fk_abogado_especialidad1` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_abogado_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of abogado
-- ----------------------------
INSERT INTO `abogado` VALUES ('2', '2017-07-07', '25000', '6', '11');
INSERT INTO `abogado` VALUES ('3', '2017-07-04', '32000', '1', '12');
INSERT INTO `abogado` VALUES ('4', '2017-07-19', '30000', '1', '13');
INSERT INTO `abogado` VALUES ('5', '2017-07-18', '27000', '3', '15');
INSERT INTO `abogado` VALUES ('6', '2016-06-01', '80017', '6', '37');
INSERT INTO `abogado` VALUES ('7', '2016-06-01', '80017', '8', '38');
INSERT INTO `abogado` VALUES ('8', '2016-08-30', '106689', '27', '39');
INSERT INTO `abogado` VALUES ('9', '2016-09-04', '133361', '10', '40');
INSERT INTO `abogado` VALUES ('10', '2016-06-18', '80017', '23', '41');
INSERT INTO `abogado` VALUES ('11', '2016-11-09', '160033', '4', '42');
INSERT INTO `abogado` VALUES ('12', '2016-12-04', '106689', '3', '43');
INSERT INTO `abogado` VALUES ('13', '2017-01-03', '80017', '2', '44');
INSERT INTO `abogado` VALUES ('14', '2016-10-09', '133361', '22', '45');
INSERT INTO `abogado` VALUES ('15', '2017-02-04', '160033', '30', '46');
INSERT INTO `abogado` VALUES ('16', '2016-09-03', '80017', '14', '47');
INSERT INTO `abogado` VALUES ('17', '2016-10-05', '80017', '33', '48');
INSERT INTO `abogado` VALUES ('18', '2017-02-22', '80017', '32', '49');
INSERT INTO `abogado` VALUES ('19', '2017-01-30', '80017', '31', '50');
INSERT INTO `abogado` VALUES ('20', '2016-12-14', '106689', '30', '51');
INSERT INTO `abogado` VALUES ('21', '2017-01-13', '133361', '29', '52');
INSERT INTO `abogado` VALUES ('22', '2017-02-20', '80017', '28', '53');
INSERT INTO `abogado` VALUES ('23', '2017-03-01', '133361', '26', '54');
INSERT INTO `abogado` VALUES ('24', '2017-03-02', '106689', '2', '55');
INSERT INTO `abogado` VALUES ('25', '2016-11-13', '106689', '3', '56');


-- ----------------------------
-- Table structure for cliente
-- ----------------------------
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_incorporacion` date NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(45) NOT NULL,
  `tipo_persona_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`tipo_persona_id`,`usuario_id`),
  KEY `fk_cliente_tipo_persona_idx` (`tipo_persona_id`),
  KEY `fk_cliente_usuario1_idx` (`usuario_id`),
  CONSTRAINT `fk_cliente_tipo_persona` FOREIGN KEY (`tipo_persona_id`) REFERENCES `tipo_persona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cliente
-- ----------------------------
INSERT INTO `cliente` VALUES ('1', '2017-06-24', 'Av. Salvador 95', '123', '1', '2');
INSERT INTO `cliente` VALUES ('4', '2017-06-28', 'Calle 123', '1234442', '2', '6');
INSERT INTO `cliente` VALUES ('5', '2016-12-12', 'Manquehue 1410,VITACURA', '995444872', '2', '17');
INSERT INTO `cliente` VALUES ('6', '2017-01-13', 'Providencia 2185,PROVIDENCIA', '227358316', '2', '18');
INSERT INTO `cliente` VALUES ('7', '2017-02-22', 'Estado 235,SANTIAGO', '225252534', '1', '19');
INSERT INTO `cliente` VALUES ('8', '2017-03-04', 'Nueva Matucana 1525,QUINTA NORMAL', '964395652', '2', '20');
INSERT INTO `cliente` VALUES ('9', '2017-01-03', 'San Pablo 2137,SANTIAGO', '227469034', '1', '21');
INSERT INTO `cliente` VALUES ('10', '2017-05-05', 'Comandante malbec 12851,LO BARNECHEA', '226246641', '2', '22');
INSERT INTO `cliente` VALUES ('11', '2017-06-02', 'Elisa Correa # 3936,PUENTE ALTO', '981764613', '1', '23');
INSERT INTO `cliente` VALUES ('12', '2017-06-06', 'Av. La plaza 590,LAS CONDES', '964261693', '2', '24');
INSERT INTO `cliente` VALUES ('13', '2017-01-01', 'Pedro de Valdivia 1885,PROVIDENCIA', '224830714', '1', '25');
INSERT INTO `cliente` VALUES ('14', '2017-02-03', 'Rodrigo de Araya 2197,MACUL', '981929873', '2', '26');
INSERT INTO `cliente` VALUES ('15', '2016-06-29', 'Bravo de Saravia Nº 2970,CONCHALI', '933444344', '2', '27');
INSERT INTO `cliente` VALUES ('16', '2016-08-14', 'Cuatro Alamos N°301, MAIPU', '225566778', '1', '28');
INSERT INTO `cliente` VALUES ('17', '2016-07-03', 'agustinas 1161,SANTIAGO', '223546777', '2', '29');
INSERT INTO `cliente` VALUES ('18', '2016-08-12', 'Jose Luis Caro 1795,TALAGANTE', '976463737', '1', '30');
INSERT INTO `cliente` VALUES ('19', '2016-12-13', 'Salvador # 1771,ÑUÑOA', '224354666', '2', '31');
INSERT INTO `cliente` VALUES ('20', '2017-04-24', 'Miguel Claro N° 1314,PROVIDENCIA', '923343555', '2', '32');
INSERT INTO `cliente` VALUES ('21', '2017-05-20', 'Marcoleta # 377,SANTIAGO', '932434434', '1', '33');
INSERT INTO `cliente` VALUES ('22', '2017-06-25', 'Camino San Antonio Nº 89,LAS CONDES', '224444444', '2', '34');
INSERT INTO `cliente` VALUES ('23', '2017-06-24', 'Av. Eyzaguirre 1951,PUENTE ALTO', '225564644', '2', '35');
INSERT INTO `cliente` VALUES ('24', '2017-02-15', 'Avda Americo Vespucio # 1501,MAIPU', '934432222', '1', '36');

-- ----------------------------
-- Table structure for atencion
-- ----------------------------
DROP TABLE IF EXISTS `atencion`;
CREATE TABLE `atencion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_atencion` date NOT NULL,
  `hora_atencion` time NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `abogado_id` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`cliente_id`,`abogado_id`,`estado_id`),
  KEY `fk_atencion_cliente1_idx` (`cliente_id`),
  KEY `fk_atencion_abogado1_idx` (`abogado_id`),
  KEY `fk_atencion_estado1_idx` (`estado_id`),
  CONSTRAINT `fk_atencion_abogado1` FOREIGN KEY (`abogado_id`) REFERENCES `abogado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_atencion_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_atencion_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of atencion
-- ----------------------------
INSERT INTO `atencion` VALUES ('1', '2017-07-18', '08:00:00', '1', '2', '2', '');
INSERT INTO `atencion` VALUES ('2', '2017-07-19', '08:00:00', '1', '2', '3', '');
INSERT INTO `atencion` VALUES ('3', '2017-07-19', '12:00:00', '1', '2', '5', '');
INSERT INTO `atencion` VALUES ('4', '2017-07-09', '10:00:00', '1', '2', '2', '');
INSERT INTO `atencion` VALUES ('5', '2017-07-07', '14:00:00', '1', '2', '3', '');
INSERT INTO `atencion` VALUES ('6', '2017-07-09', '08:00:00', '1', '2', '3', '');
INSERT INTO `atencion` VALUES ('7', '2017-07-07', '17:00:00', '1', '2', '3', '');
