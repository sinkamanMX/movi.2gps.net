-- MySQL dump 10.13  Distrib 5.1.58, for redhat-linux-gnu (i686)
--
-- Host: 188.138.40.249    Database: ALG_BD_CORPORATE_MOVI
-- ------------------------------------------------------
-- Server version	5.1.58

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ACC_HIST00000`
--

DROP TABLE IF EXISTS `ACC_HIST00000`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ACC_HIST00000` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `COD_ENTITY` int(11) NOT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LATITUDE` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(8,2) DEFAULT NULL,
  `ALTITUDE` decimal(8,2) DEFAULT NULL,
  `ANGLE` decimal(8,2) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `TOD` varchar(10) DEFAULT '0' COMMENT 'ODOMETRO TOTAL',
  `TF` varchar(10) DEFAULT '0' COMMENT 'COMBUSTIBLE TOTAL USADO',
  `VS` varchar(10) DEFAULT '0' COMMENT 'VELOCIDAD DEL VEHICULO',
  `IFU` varchar(10) DEFAULT '0' COMMENT 'HORAS DE USO DE COMBUSTIBLE RALENTI',
  `E_TEMP` varchar(10) DEFAULT '0' COMMENT 'TEMPERATURA DEL REFRIGERANTE',
  `OIL_PRE` varchar(10) DEFAULT '0' COMMENT 'PRESION DE ACEITE',
  `E_RPM` varchar(10) DEFAULT '0' COMMENT 'REVOLUCIONES POR MINUTO DEL MOTOR',
  `T_CRU` varchar(10) DEFAULT '0' COMMENT 'TIEMPO TOTAL DE CRUCERO',
  `DTC` varchar(10) DEFAULT '0' COMMENT 'CODIGO DCT ACTIVO',
  `E_IDLE` varchar(10) DEFAULT '0' COMMENT 'TIEMPO DEL MOTOR DETENIDO EN HORAS',
  `F_ECO` varchar(10) DEFAULT '0' COMMENT 'ECONOMIA DE COMBUSTIBLE EN HORAS',
  `E_LOAD` varchar(10) DEFAULT '0' COMMENT 'PORCENTAJE DE CARGA DEL MOTOR',
  `E_TIME` varchar(10) DEFAULT '0' COMMENT 'TIEMPO TOTAL DE TRABAJO DEL MOTOR',
  `TMP_S1` varchar(10) DEFAULT '0' COMMENT 'SENSOR DE TEMPERATURA 1',
  `TMP_S2` varchar(10) DEFAULT '0' COMMENT 'SENSOR DE TEMPERATURA 2',
  `TMP_S3` varchar(10) DEFAULT '0' COMMENT 'SENSOR DE TEMPERATURA 3',
  `TMP_S4` varchar(10) DEFAULT '0' COMMENT 'SENSOR DE TEMPERATURA 4',
  `CMB_T1` varchar(10) DEFAULT '0' COMMENT 'TANQUE DE COMBUSTIBLE 1',
  `CMB_T2` varchar(10) DEFAULT '0' COMMENT 'TANQUE DE COMBUSTIBLE 2',
  `CMB_T3` varchar(10) DEFAULT '0' COMMENT 'TANQUE DE COMBUSTIBLE 3',
  `CMB_T4` varchar(10) DEFAULT '0' COMMENT 'TANQUE DE COMBUSTIBLE 4',
  `TIPO_ACC` int(11) NOT NULL DEFAULT '0' COMMENT 'TIPO DE ACCESORIO',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ACC_HIST00001`
--

DROP TABLE IF EXISTS `ACC_HIST00001`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ACC_HIST00001` (
  `ID_HISTORY` int(11) NOT NULL AUTO_INCREMENT,
  `COD_ENTITY` int(11) NOT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `TOD` varchar(10) DEFAULT '0' COMMENT 'ODOMETRO TOTAL',
  `TF` varchar(10) DEFAULT '0' COMMENT 'COMBUSTIBLE TOTAL USADO',
  `VS` varchar(10) DEFAULT '0' COMMENT 'VELOCIDAD DEL VEHICULO',
  `IFU` varchar(10) DEFAULT '0' COMMENT 'HORAS DE USO DE COMBUSTIBLE RALENTI',
  `E_TEMP` varchar(10) DEFAULT '0' COMMENT 'TEMPERATURA DEL REFRIGERANTE',
  `OIL_PRE` varchar(10) DEFAULT '0' COMMENT 'PRESION DE ACEITE',
  `E_RPM` varchar(10) DEFAULT '0' COMMENT 'REVOLUCIONES POR MINUTO DEL MOTOR',
  `T_CRU` varchar(10) DEFAULT '0' COMMENT 'TIEMPO TOTAL DE CRUCERO',
  `DTC` varchar(10) DEFAULT '0' COMMENT 'CODIGO DCT ACTIVO',
  `E_IDLE` varchar(10) DEFAULT '0' COMMENT 'TIEMPO DEL MOTOR DETENIDO EN HORAS',
  `F_ECO` varchar(10) DEFAULT '0' COMMENT 'ECONOMIA DE COMBUSTIBLE EN HORAS',
  `E_LOAD` varchar(10) DEFAULT '0' COMMENT 'PORCENTAJE DE CARGA DEL MOTOR',
  `E_TIME` varchar(10) DEFAULT '0' COMMENT 'TIEMPO TOTAL DE TRABAJO DEL MOTOR',
  `TMP_S1` varchar(10) DEFAULT '0' COMMENT 'SENSOR DE TEMPERATURA 1',
  `TMP_S2` varchar(10) DEFAULT '0' COMMENT 'SENSOR DE TEMPERATURA 2',
  `TMP_S3` varchar(10) DEFAULT '0' COMMENT 'SENSOR DE TEMPERATURA 3',
  `TMP_S4` varchar(10) DEFAULT '0' COMMENT 'SENSOR DE TEMPERATURA 4',
  `CMB_T1` varchar(10) DEFAULT '0' COMMENT 'TANQUE DE COMBUSTIBLE 1',
  `CMB_T2` varchar(10) DEFAULT '0' COMMENT 'TANQUE DE COMBUSTIBLE 2',
  `CMB_T3` varchar(10) DEFAULT '0' COMMENT 'TANQUE DE COMBUSTIBLE 3',
  `CMB_T4` varchar(10) DEFAULT '0' COMMENT 'TANQUE DE COMBUSTIBLE 4',
  `TIPO_ACC` int(11) NOT NULL DEFAULT '0' COMMENT 'TIPO DE ACCESORIO',
  PRIMARY KEY (`ID_HISTORY`),
  KEY `ID` (`ID_HISTORY`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ACC_LAST00000`
--

DROP TABLE IF EXISTS `ACC_LAST00000`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ACC_LAST00000` (
  `ID` decimal(10,0) NOT NULL,
  `COD_ENTITY` decimal(10,0) NOT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LATITUDE` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(8,2) DEFAULT NULL,
  `ALTITUDE` decimal(8,2) DEFAULT NULL,
  `ANGLE` decimal(8,2) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `TOD` varchar(10) DEFAULT '0' COMMENT 'ODOMETRO TOTAL',
  `TF` varchar(10) DEFAULT '0' COMMENT 'COMBUSTIBLE TOTAL USADO',
  `VS` varchar(10) DEFAULT '0' COMMENT 'VELOCIDAD DEL VEHICULO',
  `IFU` varchar(10) DEFAULT '0' COMMENT 'HORAS DE USO DE COMBUSTIBLE RALENTI',
  `E_TEMP` varchar(10) DEFAULT '0' COMMENT 'TEMPERATURA DEL REFRIGERANTE',
  `OIL_PRE` varchar(10) DEFAULT '0' COMMENT 'PRESION DE ACEITE',
  `E_RPM` varchar(10) DEFAULT '0' COMMENT 'REVOLUCIONES POR MINUTO DEL MOTOR',
  `T_CRU` varchar(10) DEFAULT '0' COMMENT 'TIEMPO TOTAL DE CRUCERO',
  `DTC` varchar(10) DEFAULT '0' COMMENT 'CODIGO DCT ACTIVO',
  `E_IDLE` varchar(10) DEFAULT '0' COMMENT 'TIEMPO DEL MOTOR DETENIDO EN HORAS',
  `F_ECO` varchar(10) DEFAULT '0' COMMENT 'ECONOMIA DE COMBUSTIBLE EN HORAS',
  `E_LOAD` varchar(10) DEFAULT '0' COMMENT 'PORCENTAJE DE CARGA DEL MOTOR',
  `E_TIME` varchar(10) DEFAULT '0' COMMENT 'TIEMPO TOTAL DE TRABAJO DEL MOTOR',
  `TMP_S1` varchar(10) DEFAULT '0' COMMENT 'SENSOR DE TEMPERATURA 1',
  `TMP_S2` varchar(10) DEFAULT '0' COMMENT 'SENSOR DE TEMPERATURA 2',
  `TMP_S3` varchar(10) DEFAULT '0' COMMENT 'SENSOR DE TEMPERATURA 3',
  `TMP_S4` varchar(10) DEFAULT '0' COMMENT 'SENSOR DE TEMPERATURA 4',
  `CMB_T1` varchar(10) DEFAULT '0' COMMENT 'TANQUE DE COMBUSTIBLE 1',
  `CMB_T2` varchar(10) DEFAULT '0' COMMENT 'TANQUE DE COMBUSTIBLE 2',
  `CMB_T3` varchar(10) DEFAULT '0' COMMENT 'TANQUE DE COMBUSTIBLE 3',
  `CMB_T4` varchar(10) DEFAULT '0' COMMENT 'TANQUE DE COMBUSTIBLE 4',
  `TIPO_ACC` int(6) NOT NULL DEFAULT '0' COMMENT 'TIPO DE ACCESORIO',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_ACCESORIO_TIPO`
--

DROP TABLE IF EXISTS `ADM_ACCESORIO_TIPO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_ACCESORIO_TIPO` (
  `TIPO_ACC` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TIPO DE ACCESSORIO',
  `DESCRIPCION` varchar(30) DEFAULT NULL,
  `ID_DASHBOARD` int(6) DEFAULT NULL COMMENT 'EL ID DEL DASHBOARD A USAR PARA MOSTRAR VARIABLES',
  PRIMARY KEY (`TIPO_ACC`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_ACCESORIO_VARIABLES`
--

DROP TABLE IF EXISTS `ADM_ACCESORIO_VARIABLES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_ACCESORIO_VARIABLES` (
  `ID_VARIABLE` int(11) NOT NULL AUTO_INCREMENT,
  `VARIABLE` varchar(30) DEFAULT NULL COMMENT 'NOMBRE DE LA VARIABLE A MOSTRAR',
  `CAMPO` varchar(30) NOT NULL COMMENT 'CAMPO EN LA TABLA ACC_HIST Y ACC_LAST',
  `TIPO_ACC` int(11) NOT NULL,
  PRIMARY KEY (`ID_VARIABLE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_ACC_DASHBOARD`
--

DROP TABLE IF EXISTS `ADM_ACC_DASHBOARD`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_ACC_DASHBOARD` (
  `ID_DASHBOARD` int(11) NOT NULL,
  `DESCRIPCION` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID_DASHBOARD`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_APLICACIONES`
--

DROP TABLE IF EXISTS `ADM_APLICACIONES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_APLICACIONES` (
  `ID_APLICACION` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(45) NOT NULL,
  PRIMARY KEY (`ID_APLICACION`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_APLICACIONES_EMPRESA`
--

DROP TABLE IF EXISTS `ADM_APLICACIONES_EMPRESA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_APLICACIONES_EMPRESA` (
  `ID_APP_EMPRESA` int(11) NOT NULL AUTO_INCREMENT,
  `ID_EMPRESA` int(11) NOT NULL,
  `ID_VERSION` int(11) NOT NULL,
  `REGISTRADO` datetime NOT NULL,
  `ACTIVO` int(11) NOT NULL,
  `ITEM_APP` varchar(100) DEFAULT NULL,
  `URL_PRIMARIO` varchar(200) DEFAULT NULL,
  `URL_SECUNDARIO` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`ID_APP_EMPRESA`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT=' /* comment truncated */ /*APLICACIONES CLIENTE*/';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_APLICACIONES_VERSION`
--

DROP TABLE IF EXISTS `ADM_APLICACIONES_VERSION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_APLICACIONES_VERSION` (
  `ID_VERSION` int(11) NOT NULL AUTO_INCREMENT,
  `ID_APLICACION` int(11) NOT NULL,
  `VERSION` varchar(45) DEFAULT NULL,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `COMENTARIOS` varchar(45) DEFAULT NULL,
  `SISTEMA` enum('Android','iOS','BB') DEFAULT NULL,
  PRIMARY KEY (`ID_VERSION`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT=' /* comment truncated */ /*VERSIONES DE LAS APLICACIONES*/';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_CLIENTES`
--

DROP TABLE IF EXISTS `ADM_CLIENTES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_CLIENTES` (
  `ID_CLIENTE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_EMPRESA` int(11) NOT NULL,
  `ID_USUARIO_CREO` int(11) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `RFC` varchar(45) DEFAULT NULL,
  `RAZON_SOCIAL` varchar(45) DEFAULT NULL,
  `PERSONA` enum('FISICA','MORAL') DEFAULT NULL,
  `TELEFONO` varchar(10) NOT NULL,
  `DIRECCION` varchar(100) DEFAULT NULL,
  `NOMBRE_CONTACTO` varchar(45) NOT NULL,
  `EMAIL` varchar(45) NOT NULL,
  `MOVIL` varchar(20) NOT NULL,
  `FECHA_CREACION` datetime NOT NULL,
  `COMENTARIOS` varchar(100) DEFAULT NULL,
  `ACTIVO` enum('S','N') NOT NULL,
  `DESCRIPCION` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`ID_CLIENTE`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_CLIENTES_VALIDACION`
--

DROP TABLE IF EXISTS `ADM_CLIENTES_VALIDACION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_CLIENTES_VALIDACION` (
  `ID_VALIDACION` int(11) NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` varchar(45) NOT NULL,
  `PREGUNTA` varchar(60) NOT NULL,
  `RESPUESTA` varchar(60) NOT NULL,
  `CREADO` datetime NOT NULL,
  PRIMARY KEY (`ID_VALIDACION`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_CLIENTE_DETALLE`
--

DROP TABLE IF EXISTS `ADM_CLIENTE_DETALLE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_CLIENTE_DETALLE` (
  `ID_CLIENTE_DETALLE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` int(11) NOT NULL,
  `ID_USUARIO_CREO` int(11) DEFAULT NULL,
  `RFC` int(11) NOT NULL,
  `RAZON_SOCIAL` varchar(45) NOT NULL,
  `TIPO` varchar(45) DEFAULT NULL,
  `TELEFONO` varchar(45) DEFAULT NULL,
  `DIRECCION` varchar(45) DEFAULT NULL,
  `NOMBRE_CONTACTO` varchar(45) DEFAULT NULL,
  `EMAIL_CONTACTO` varchar(45) DEFAULT NULL,
  `MOVIL_CONTACTO` varchar(45) DEFAULT NULL,
  `FECHA_CREACION` varchar(45) DEFAULT NULL,
  `ESTATUS` varchar(45) DEFAULT NULL,
  `COMENTARIOS` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID_CLIENTE_DETALLE`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_COLORES`
--

DROP TABLE IF EXISTS `ADM_COLORES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_COLORES` (
  `COD_COLOR` decimal(10,0) NOT NULL DEFAULT '0',
  `DESCRIPTION` varchar(60) NOT NULL,
  `R` decimal(3,0) DEFAULT NULL,
  `G` decimal(3,0) DEFAULT NULL,
  `B` decimal(3,0) DEFAULT NULL,
  `FLAG_VALID_RSI` decimal(1,0) DEFAULT NULL,
  PRIMARY KEY (`COD_COLOR`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_COMANDOS_CLIENTE`
--

DROP TABLE IF EXISTS `ADM_COMANDOS_CLIENTE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_COMANDOS_CLIENTE` (
  `ID_COMANDO_CLIENTE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` int(11) NOT NULL,
  `COD_EQUIPMENT_PROGRAM` int(11) NOT NULL,
  `DESCRIPCION` varchar(60) DEFAULT NULL,
  `CREADO` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_COMANDO_CLIENTE`)
) ENGINE=InnoDB AUTO_INCREMENT=590 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_COMANDOS_ENVIADOS`
--

DROP TABLE IF EXISTS `ADM_COMANDOS_ENVIADOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_COMANDOS_ENVIADOS` (
  `ID_ENVIADO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int(11) NOT NULL,
  `COMANDO` varchar(100) NOT NULL,
  `SINTAXIS` varchar(100) NOT NULL,
  `IMEI` varchar(60) NOT NULL,
  `ENVIADO` int(11) NOT NULL,
  `CREADO` datetime NOT NULL,
  `COMENTARIOS` varchar(200) NOT NULL,
  `ORIGEN` varchar(100) DEFAULT NULL,
  `PROCESADO` datetime DEFAULT NULL,
  `COD_EQUIPMENT` int(11) NOT NULL,
  `COD_TYPE_EQUIPMENT` int(11) NOT NULL,
  PRIMARY KEY (`ID_ENVIADO`)
) ENGINE=InnoDB AUTO_INCREMENT=7522 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`sa`@`%`*/ /*!50003 TRIGGER `COMANDS_HIST` AFTER DELETE ON `ADM_COMANDOS_ENVIADOS`
  FOR EACH ROW
BEGIN
INSERT INTO ADM_COMANDOS_HIST
	(ID_ENVIADO, 
	ID_USUARIO, 
	COMANDO, 
	SINTAXIS, 
	IMEI, 
	ENVIADO, 
	CREADO, 
	COMENTARIOS, 
	ORIGEN, 
	PROCESADO, 
	COD_EQUIPMENT, 
	COD_TYPE_EQUIPMENT
	)
	VALUES
	(OLD.ID_ENVIADO, 
	OLD.ID_USUARIO, 
	OLD.COMANDO, 
	OLD.SINTAXIS, 
	OLD.IMEI, 
	OLD.ENVIADO, 
	OLD.CREADO, 
	OLD.COMENTARIOS, 
	OLD.ORIGEN, 
	OLD.PROCESADO, 
	OLD.COD_EQUIPMENT, 
	OLD.COD_TYPE_EQUIPMENT
	);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `ADM_COMANDOS_HIST`
--

DROP TABLE IF EXISTS `ADM_COMANDOS_HIST`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_COMANDOS_HIST` (
  `ID_ENVIADO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int(11) NOT NULL,
  `COMANDO` varchar(100) NOT NULL,
  `SINTAXIS` varchar(100) NOT NULL,
  `IMEI` varchar(60) NOT NULL,
  `ENVIADO` int(11) NOT NULL,
  `CREADO` datetime NOT NULL,
  `COMENTARIOS` varchar(200) NOT NULL,
  `ORIGEN` varchar(100) DEFAULT NULL,
  `PROCESADO` datetime DEFAULT NULL,
  `COD_EQUIPMENT` int(11) NOT NULL,
  `COD_TYPE_EQUIPMENT` int(11) NOT NULL,
  PRIMARY KEY (`ID_ENVIADO`)
) ENGINE=InnoDB AUTO_INCREMENT=7522 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_COMANDOS_SALIDA`
--

DROP TABLE IF EXISTS `ADM_COMANDOS_SALIDA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_COMANDOS_SALIDA` (
  `COD_EQUIPMENT_PROGRAM` int(11) NOT NULL AUTO_INCREMENT,
  `COD_TYPE_EQUIPMENT` int(11) NOT NULL,
  `DESCRIPCION` varchar(100) NOT NULL,
  `COMMAND_EQUIPMENT` varchar(300) NOT NULL,
  `FLAG_INPUT_VARIABLE` decimal(1,0) NOT NULL,
  `QUANTITY_BYTES_SENT` decimal(15,0) NOT NULL,
  `FLAG_INDEX_MENU` decimal(10,0) DEFAULT NULL,
  `FLAG_PASS` decimal(1,0) DEFAULT NULL,
  `FLAG_EXPERT_MODE` decimal(1,0) DEFAULT NULL,
  `FLAG_SMS` int(1) DEFAULT '0',
  `MOSTRAR_ATENCION` int(1) DEFAULT '0',
  `ICONO` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`COD_EQUIPMENT_PROGRAM`),
  KEY `COD_TYPE_EQUIPMENT` (`COD_TYPE_EQUIPMENT`),
  KEY `COMMAND_EQUIPMENT` (`COMMAND_EQUIPMENT`(255))
) ENGINE=InnoDB AUTO_INCREMENT=536 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_COMANDOS_USUARIO`
--

DROP TABLE IF EXISTS `ADM_COMANDOS_USUARIO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_COMANDOS_USUARIO` (
  `ID_COMANDO_USUARIO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_COMANDO_CLIENTE` int(11) NOT NULL,
  `ID_USUARIO` int(11) NOT NULL,
  `CREADO` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_COMANDO_USUARIO`)
) ENGINE=InnoDB AUTO_INCREMENT=214 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_CONTACTOS`
--

DROP TABLE IF EXISTS `ADM_CONTACTOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_CONTACTOS` (
  `ID_CONTACTO` int(11) NOT NULL AUTO_INCREMENT,
  `COD_PROTOCOLO` int(11) NOT NULL,
  `ID_CLIENTE` int(11) NOT NULL,
  `NOMBRE` varchar(45) DEFAULT NULL,
  `HORA_INICIAL` time DEFAULT NULL,
  `HORA_FINAL` time DEFAULT NULL,
  `ROL` varchar(45) DEFAULT NULL,
  `CLAVE_SEGURIDAD` varchar(45) DEFAULT NULL,
  `CONTACTO_CONSULTA` enum('S','N') DEFAULT NULL,
  `CONTACTO_AUTORIZA` enum('S','N') DEFAULT NULL,
  `ID_ADM_USUARIO` int(11) DEFAULT NULL,
  `CREADO` datetime DEFAULT NULL,
  `ADM_PROTOCOLOS_CONTACTOScol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID_CONTACTO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_EMPRESAS`
--

DROP TABLE IF EXISTS `ADM_EMPRESAS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_EMPRESAS` (
  `ID_EMPRESA` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `ACTIVO` enum('S','N') DEFAULT NULL,
  `RAZON_SOCIAL` varchar(60) DEFAULT NULL,
  `RFC` varchar(45) DEFAULT NULL,
  `DIRECCION` varchar(200) DEFAULT NULL,
  `TELEFONO` varchar(45) DEFAULT NULL,
  `CREADO` datetime DEFAULT NULL,
  `REPRESENTANTE_LEGAL` varchar(100) DEFAULT NULL,
  `EMAIL` varchar(45) DEFAULT NULL,
  `OBSERVACIONES` text,
  PRIMARY KEY (`ID_EMPRESA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_EQUIPOS`
--

DROP TABLE IF EXISTS `ADM_EQUIPOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_EQUIPOS` (
  `COD_EQUIPMENT` int(11) NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` int(11) DEFAULT NULL,
  `COD_TYPE_EQUIPMENT` int(11) NOT NULL,
  `DESCRIPCION` varchar(100) NOT NULL,
  `ITEM_NUMBER` varchar(100) NOT NULL COMMENT ' /* comment truncated */ /*IP*/',
  `SECOND_ITEM_NUMBER` varchar(100) DEFAULT NULL,
  `PORT_TX` varchar(10) DEFAULT NULL,
  `PORT_RX` varchar(10) DEFAULT NULL,
  `PHONE` varchar(30) NOT NULL,
  `IMEI` varchar(30) NOT NULL,
  `FLAG_MENSAJES` decimal(1,0) DEFAULT NULL,
  `FLAG_VIDEO` decimal(1,0) DEFAULT NULL,
  `FLAG_VOZ` decimal(1,0) DEFAULT NULL,
  `FLAG_DEMO_ACTIVE` decimal(1,0) DEFAULT NULL,
  `TIME_REPORT` decimal(4,0) DEFAULT NULL,
  `FLAG_DHCP_ON` decimal(1,0) DEFAULT NULL,
  `PORT_DHCP` decimal(6,0) DEFAULT NULL,
  PRIMARY KEY (`COD_EQUIPMENT`),
  UNIQUE KEY `IP_UNICA` (`ITEM_NUMBER`),
  UNIQUE KEY `IP_PUERTO_UNICA` (`ITEM_NUMBER`,`PORT_TX`),
  KEY `COD_TYPE_EQUIPMENT` (`COD_TYPE_EQUIPMENT`),
  KEY `ITEM_NUMBER` (`ITEM_NUMBER`)
) ENGINE=InnoDB AUTO_INCREMENT=575 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_EQUIPOS_TIPO`
--

DROP TABLE IF EXISTS `ADM_EQUIPOS_TIPO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_EQUIPOS_TIPO` (
  `COD_TYPE_EQUIPMENT` int(11) NOT NULL AUTO_INCREMENT,
  `COD_TRADEMARK_MODEL` int(11) NOT NULL,
  `COD_TYPE_COMUNICATION` int(11) NOT NULL,
  `PORT_DEFAULT` varchar(60) DEFAULT NULL,
  `DESCRIPTION` varchar(60) NOT NULL,
  `BLOQUEO` int(1) DEFAULT '-1',
  PRIMARY KEY (`COD_TYPE_EQUIPMENT`),
  KEY `COD_TYPE_COMUNICATION` (`COD_TYPE_COMUNICATION`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_EVENTOS`
--

DROP TABLE IF EXISTS `ADM_EVENTOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_EVENTOS` (
  `COD_EVENT` int(11) NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` int(11) DEFAULT NULL,
  `COLOR` varchar(10) DEFAULT NULL,
  `DESCRIPTION` varchar(100) NOT NULL,
  `PRIORITY` decimal(2,0) NOT NULL,
  `FILE_SOUND` varchar(100) DEFAULT NULL,
  `FLAG_VISIBLE_CONSOLE` decimal(1,0) NOT NULL,
  `ICONO` varchar(100) DEFAULT NULL,
  `FLAG_EVENT_ALERT` int(11) DEFAULT NULL,
  `TYPE_ITINE` int(11) DEFAULT NULL,
  `ICO_ITE` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`COD_EVENT`)
) ENGINE=InnoDB AUTO_INCREMENT=10028 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_EVENTOS_EQUIPOS`
--

DROP TABLE IF EXISTS `ADM_EVENTOS_EQUIPOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_EVENTOS_EQUIPOS` (
  `COD_EVENT_EQUIPMENT` int(11) NOT NULL AUTO_INCREMENT,
  `COD_TYPE_EQUIPMENT` int(11) NOT NULL,
  `COD_EVENT_DEFAULT` int(11) NOT NULL,
  `EVENT_REASON` varchar(100) NOT NULL,
  `SEARCH_CODE` varchar(20) NOT NULL,
  `QUANTITY_BYTES_RECEIVE` decimal(15,0) DEFAULT NULL,
  PRIMARY KEY (`COD_EVENT_EQUIPMENT`),
  KEY `COD_TYPE_EQUIPMENT` (`COD_TYPE_EQUIPMENT`),
  KEY `SEARCH_CODE` (`SEARCH_CODE`)
) ENGINE=InnoDB AUTO_INCREMENT=329093 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_EVENTOS_SISTEMA`
--

DROP TABLE IF EXISTS `ADM_EVENTOS_SISTEMA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_EVENTOS_SISTEMA` (
  `COD_EVENT_EQUIPMENT_HARDWARE` int(11) NOT NULL AUTO_INCREMENT,
  `COD_EVENT` int(11) NOT NULL,
  `COD_EQUIPMENT` int(11) NOT NULL,
  `COD_EVENT_EQUIPMENT` int(11) NOT NULL,
  PRIMARY KEY (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_EVENT_EQUIPMENT` (`COD_EVENT_EQUIPMENT`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_EQUIPMENT` (`COD_EQUIPMENT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_FORMA_CONTACTO`
--

DROP TABLE IF EXISTS `ADM_FORMA_CONTACTO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_FORMA_CONTACTO` (
  `ID_FORMA_CONTACTO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_FORMA` int(11) NOT NULL,
  `ID_CONTACTO` int(11) DEFAULT NULL,
  `MEDIO_CONTACTO` varchar(45) DEFAULT NULL,
  `ACTIVO` enum('S','N') DEFAULT NULL,
  `CONTACTOS` int(11) DEFAULT NULL,
  `PRIORIDAD` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_FORMA_CONTACTO`),
  KEY `fk_ADM_FORMA_CONTACTO_ADM_MEDIOS_CONTACTO1` (`ID_FORMA`),
  KEY `fk_ADM_FORMA_CONTACTO_ADM_CONTACTOS1` (`ID_CONTACTO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_GEOREFERENCIAS`
--

DROP TABLE IF EXISTS `ADM_GEOREFERENCIAS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_GEOREFERENCIAS` (
  `ID_OBJECT_MAP` int(10) NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` int(10) DEFAULT NULL,
  `ID_TIPO_GEO` int(10) NOT NULL,
  `DESCRIPCION` varchar(45) NOT NULL,
  `LONGITUDE` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `LATITUDE` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `CALLE` varchar(45) DEFAULT NULL,
  `NO_INT` varchar(10) DEFAULT NULL,
  `NO_EXT` varchar(10) DEFAULT NULL,
  `COLONIA` varchar(45) DEFAULT NULL,
  `MUNICIPIO` varchar(45) DEFAULT NULL,
  `ESTADO` varchar(45) DEFAULT NULL,
  `CP` varchar(45) DEFAULT NULL,
  `RADIO` int(10) DEFAULT NULL,
  `TIPO` enum('G','C','R','RH') DEFAULT 'G' COMMENT 'G=GEOPUNTO,C=GEOCERCA,R=RUTA,RH=RECURSO HUMANO',
  `COD_COLOR` varchar(15) DEFAULT NULL,
  `PRIVACIDAD` enum('T','C','P') DEFAULT 'P' COMMENT 'T=TODOS LO PUEDEN VER\nC=SOLO CLIENTE LO PUEDE VER\nP=SOLO EL USUARIO PUEDE VER',
  `ID_ADM_USUARIO` int(10) NOT NULL,
  `CREADO` datetime NOT NULL,
  `BASE` int(5) DEFAULT '0' COMMENT 'valor 1=SI 0=NO',
  `ITEM_NUMBER` varchar(45) DEFAULT NULL,
  `RESPONSABLE` varchar(45) DEFAULT NULL,
  `CORREO` varchar(45) DEFAULT NULL,
  `CELULAR` varchar(45) DEFAULT NULL,
  `TWITTER` varchar(45) NOT NULL,
  `ITI_AUTO_E_S_GPS` enum('S','N') DEFAULT 'S',
  `ITI_NOTI_ENTRADA` enum('S','N') DEFAULT 'N',
  `ITI_NOTI_SALIDA` enum('S','N') DEFAULT 'N',
  `ITI_NOTI_ATRAZO` enum('S','N') DEFAULT 'N',
  `ITI_NOTI_VISTA_RUTA` enum('S','N') DEFAULT 'N',
  PRIMARY KEY (`ID_OBJECT_MAP`)
) ENGINE=InnoDB AUTO_INCREMENT=1867 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_GEOREFERENCIAS_ESPACIAL`
--

DROP TABLE IF EXISTS `ADM_GEOREFERENCIAS_ESPACIAL`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_GEOREFERENCIAS_ESPACIAL` (
  `ID_OBJECT_MAP` int(10) NOT NULL,
  `GEOM` geometry DEFAULT NULL,
  `ADM_GEOS_ID_OBJECT_MAP` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ADM_GEOS_ID_OBJECT_MAP`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COMMENT=' /* comment truncated */ /*GURDA EL DETALLE DE LOS BLOBS*/';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_GEOREFERENCIAS_TIPO`
--

DROP TABLE IF EXISTS `ADM_GEOREFERENCIAS_TIPO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_GEOREFERENCIAS_TIPO` (
  `ID_TIPO` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(60) NOT NULL,
  `IMAGE` text,
  PRIMARY KEY (`ID_TIPO`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_GEOREFERENCIA_CUESTIONARIO`
--

DROP TABLE IF EXISTS `ADM_GEOREFERENCIA_CUESTIONARIO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_GEOREFERENCIA_CUESTIONARIO` (
  `ID_CUESTIONARIO` int(11) NOT NULL,
  `ID_OBJECT_MAP` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_GEOREFERENCIA_IMG`
--

DROP TABLE IF EXISTS `ADM_GEOREFERENCIA_IMG`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_GEOREFERENCIA_IMG` (
  `COD_IMAGEN` int(11) NOT NULL AUTO_INCREMENT,
  `ID_OBJECT_MAP` int(11) NOT NULL,
  `IMG` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`COD_IMAGEN`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_GEOREFERENCIA_RESPUESTAS`
--

DROP TABLE IF EXISTS `ADM_GEOREFERENCIA_RESPUESTAS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_GEOREFERENCIA_RESPUESTAS` (
  `ID_RES_CUESTIONARIO` int(11) NOT NULL,
  `ID_OBJECT_MAP` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_GEO_PAYLOAD`
--

DROP TABLE IF EXISTS `ADM_GEO_PAYLOAD`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_GEO_PAYLOAD` (
  `ID_CUESTIONARIO` int(11) NOT NULL,
  `ID_OBJECT_MAP` int(11) NOT NULL,
  `CADENA_PAYLOAD` longtext COLLATE utf8_spanish_ci,
  `FECHA_CREADO` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_CUESTIONARIO`,`ID_OBJECT_MAP`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_GRUPOS`
--

DROP TABLE IF EXISTS `ADM_GRUPOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_GRUPOS` (
  `ID_GRUPO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ADM_USUARIO` varchar(45) DEFAULT NULL,
  `NOMBRE` varchar(45) DEFAULT NULL,
  `ABREVIATURA` varchar(45) DEFAULT NULL,
  `TEMPORAL` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_GRUPO`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_GRUPOS_CLIENTES`
--

DROP TABLE IF EXISTS `ADM_GRUPOS_CLIENTES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_GRUPOS_CLIENTES` (
  `ID_GRUPO_CLIENTE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_GRUPO` int(11) NOT NULL,
  `ID_CLIENTE` int(11) NOT NULL,
  PRIMARY KEY (`ID_GRUPO_CLIENTE`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_GRUPOS_REL`
--

DROP TABLE IF EXISTS `ADM_GRUPOS_REL`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_GRUPOS_REL` (
  `ID_GRUPO_PADRE` int(11) NOT NULL,
  `ID_GRUPO_HIJO` int(11) NOT NULL,
  KEY `IDX_HIJO_UNICO` (`ID_GRUPO_HIJO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_GRUPOS_UNIDADES`
--

DROP TABLE IF EXISTS `ADM_GRUPOS_UNIDADES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_GRUPOS_UNIDADES` (
  `ID_GRUPO` int(11) NOT NULL,
  `COD_ENTITY` varchar(45) NOT NULL,
  `FECHA_VIGENCIA` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY `IDX_UNIDAD_GRUPO` (`ID_GRUPO`,`COD_ENTITY`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_LEGAL_INFO`
--

DROP TABLE IF EXISTS `ADM_LEGAL_INFO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_LEGAL_INFO` (
  `ID_LEGAL_INFO` int(11) NOT NULL,
  `RFC` int(11) DEFAULT NULL,
  `RAZON_SOCIAL` varchar(45) DEFAULT NULL,
  `TIPO` varchar(45) DEFAULT NULL,
  `TELEFONO` varchar(45) DEFAULT NULL,
  `DIRECCION` varchar(45) DEFAULT NULL,
  `NOMBRE_CONTACTO` varchar(45) DEFAULT NULL,
  `EMAIL_CONTACTO` varchar(45) DEFAULT NULL,
  `MOVIL_CONTACTO` varchar(45) DEFAULT NULL,
  `ID_ADM_USUARIO` varchar(45) DEFAULT NULL,
  `FECHA_CREACION` varchar(45) DEFAULT NULL,
  `ESTATUS` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID_LEGAL_INFO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_LEGAL_INFO_CLIENTES`
--

DROP TABLE IF EXISTS `ADM_LEGAL_INFO_CLIENTES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_LEGAL_INFO_CLIENTES` (
  `ID_LI_CLIENTES` int(11) NOT NULL,
  `ID_CLIENTE` varchar(45) DEFAULT NULL,
  `ID_EMPRESA` varchar(45) DEFAULT NULL,
  `ID_LEGAL_INFO` varchar(45) DEFAULT NULL,
  `ADM_LEGAL_INFO_ID_LEGAL_INFO` int(11) NOT NULL,
  PRIMARY KEY (`ID_LI_CLIENTES`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='<double-click to overwrite multiple objects>';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_MARCA`
--

DROP TABLE IF EXISTS `ADM_MARCA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_MARCA` (
  `COD_TRADEMARK` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPTION` varchar(60) NOT NULL,
  PRIMARY KEY (`COD_TRADEMARK`)
) ENGINE=InnoDB AUTO_INCREMENT=197 DEFAULT CHARSET=latin1 COMMENT='CATALOGO DE MARCAS O GRUPOS DE ACTIVOS*/';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_MARCA_MODELO`
--

DROP TABLE IF EXISTS `ADM_MARCA_MODELO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_MARCA_MODELO` (
  `COD_TRADEMARK_MODEL` int(11) NOT NULL AUTO_INCREMENT,
  `COD_TRADEMARK` int(11) NOT NULL,
  `DESCRIPTION` varchar(60) NOT NULL,
  `TYPE` enum('M','V','G','H','A','C') NOT NULL DEFAULT 'G' COMMENT 'mascota, vehiculo, GPS, helicoptero, avion, celular',
  `OTRO` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`COD_TRADEMARK_MODEL`)
) ENGINE=InnoDB AUTO_INCREMENT=894 DEFAULT CHARSET=latin1 COMMENT=' M = móvil, H = humano, V = vehículo, C = Activo, A = Animal';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_MATRIX`
--

DROP TABLE IF EXISTS `ADM_MATRIX`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_MATRIX` (
  `ID_MATRIX` int(11) NOT NULL AUTO_INCREMENT,
  `IMEI` varchar(30) NOT NULL,
  `SERVIDOR` varchar(30) NOT NULL,
  `APLICACION` varchar(30) DEFAULT NULL,
  `VERSION` varchar(30) DEFAULT NULL,
  `MARCA` varchar(30) DEFAULT NULL,
  `MODELO` varchar(30) DEFAULT NULL,
  `ACTIVO` int(1) DEFAULT NULL,
  `REGISTRADO` int(1) DEFAULT NULL,
  `FECHA_CREADO` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_MATRIX`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_MEDIOS_CONTACTO`
--

DROP TABLE IF EXISTS `ADM_MEDIOS_CONTACTO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_MEDIOS_CONTACTO` (
  `ID_FORMA` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID_FORMA`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_MENU`
--

DROP TABLE IF EXISTS `ADM_MENU`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_MENU` (
  `ID_MENU` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(45) NOT NULL,
  `URL` varchar(45) DEFAULT NULL,
  `ACTIVO` enum('S','N') DEFAULT NULL,
  `ICONO` varchar(45) DEFAULT NULL,
  `CREADO` datetime DEFAULT NULL,
  `TIPO` enum('W','M','A') DEFAULT NULL,
  PRIMARY KEY (`ID_MENU`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_MENU_TIPO`
--

DROP TABLE IF EXISTS `ADM_MENU_TIPO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_MENU_TIPO` (
  `ID_USUARIOS_TIPO` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_TIPO_USUARIO` int(11) NOT NULL,
  `ID_MENU` int(11) NOT NULL,
  `ORDEN` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_USUARIOS_TIPO`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_PAIS_INFO`
--

DROP TABLE IF EXISTS `ADM_PAIS_INFO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_PAIS_INFO` (
  `ID_PAIS` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(60) DEFAULT NULL,
  `ABREVIATURA` varchar(3) DEFAULT NULL,
  `ZOOM` decimal(12,8) DEFAULT NULL,
  `CENTER_X` decimal(12,8) DEFAULT NULL,
  `CENTER_Y` decimal(12,8) DEFAULT NULL,
  PRIMARY KEY (`ID_PAIS`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_PERFILES`
--

DROP TABLE IF EXISTS `ADM_PERFILES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_PERFILES` (
  `ID_PERFIL` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(60) NOT NULL,
  `ESTATUS` enum('Activo','Inactivo') DEFAULT NULL,
  `ID_ADM_USUARIO` int(11) DEFAULT NULL,
  `CREADO` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_PERFIL`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='PERFILES DE USUARIO';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_PERFILES_CLIENTES`
--

DROP TABLE IF EXISTS `ADM_PERFILES_CLIENTES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_PERFILES_CLIENTES` (
  `ID_EMPRESA` int(6) DEFAULT NULL,
  `ID_CLIENTE` int(6) DEFAULT NULL,
  `ID_PERFIL` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_PERFIL_PERMISOS`
--

DROP TABLE IF EXISTS `ADM_PERFIL_PERMISOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_PERFIL_PERMISOS` (
  `ID_PERFIL` int(11) NOT NULL,
  `ID_SUBMENU` int(11) NOT NULL,
  `ID_PERMISO` int(11) NOT NULL,
  UNIQUE KEY `PRIVILEGIO_PERMISO` (`ID_PERFIL`,`ID_SUBMENU`,`ID_PERMISO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_PERMISOS`
--

DROP TABLE IF EXISTS `ADM_PERMISOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_PERMISOS` (
  `ID_PERMISO` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(45) NOT NULL,
  `RD` int(11) NOT NULL,
  `WR` int(11) NOT NULL,
  `EX` int(11) NOT NULL,
  `UP` int(11) NOT NULL,
  `DL` int(11) NOT NULL,
  PRIMARY KEY (`ID_PERMISO`),
  UNIQUE KEY `PERMISO_UNICO` (`DESCRIPCION`,`RD`,`WR`,`EX`,`UP`,`DL`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_PROTOCOLOS`
--

DROP TABLE IF EXISTS `ADM_PROTOCOLOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_PROTOCOLOS` (
  `COD_PROTOCOLO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` int(11) NOT NULL,
  `DESCRIPCION` varchar(100) NOT NULL,
  `OBSERVACION` text,
  `ACTIVO` enum('S','N') NOT NULL DEFAULT 'N',
  `CREADO` datetime NOT NULL,
  PRIMARY KEY (`COD_PROTOCOLO`),
  KEY `1122_CLIENTES` (`ID_CLIENTE`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT=' /* comment truncated */ /*PROTOCOLOS*/';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_PROTOCOLO_CONTACTOS`
--

DROP TABLE IF EXISTS `ADM_PROTOCOLO_CONTACTOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_PROTOCOLO_CONTACTOS` (
  `ID_CONTACTO` int(11) NOT NULL AUTO_INCREMENT,
  `COD_PROTOCOLO` int(11) NOT NULL,
  `NOMBRE` varchar(45) DEFAULT NULL,
  `HORA_INICIAL` time DEFAULT NULL,
  `HORA_FINAL` time DEFAULT NULL,
  `ROL` varchar(45) DEFAULT NULL,
  `CLAVE_SEGURIDAD` varchar(45) DEFAULT NULL,
  `CONTACTO_CONSULTA` enum('S','N') DEFAULT NULL,
  `CONTACTO_AUTORIZA` enum('S','N') DEFAULT NULL,
  `ID_ADM_USUARIO` int(11) DEFAULT NULL,
  `CREADO` datetime DEFAULT NULL,
  `PRIORIDAD` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_CONTACTO`),
  KEY `fk_ADM_CONTACTOS_ADM_PROTOCOLOS1` (`COD_PROTOCOLO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_PROTOCOLO_UNIDADES`
--

DROP TABLE IF EXISTS `ADM_PROTOCOLO_UNIDADES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_PROTOCOLO_UNIDADES` (
  `COD_PROTOCOLO` int(11) NOT NULL,
  `COD_ENTITY` int(11) NOT NULL,
  `PRIORIDAD` int(11) DEFAULT NULL,
  KEY `fk_ADM_PROTOCOLO_UNIDADES_ADM_PROTOCOLOS1` (`COD_PROTOCOLO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_RH`
--

DROP TABLE IF EXISTS `ADM_RH`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_RH` (
  `ID_OBJECT_MAP` int(10) NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` int(10) DEFAULT NULL,
  `ID_TIPO_GEO` int(10) NOT NULL,
  `DESCRIPCION` varchar(45) NOT NULL,
  `LONGITUDE` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `LATITUDE` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `CALLE` varchar(45) DEFAULT NULL,
  `NO_INT` varchar(10) DEFAULT NULL,
  `NO_EXT` varchar(10) DEFAULT NULL,
  `COLONIA` varchar(45) DEFAULT NULL,
  `MUNICIPIO` varchar(45) DEFAULT NULL,
  `ESTADO` varchar(45) DEFAULT NULL,
  `CP` varchar(45) DEFAULT NULL,
  `RADIO` int(10) DEFAULT NULL,
  `TIPO` enum('G','C','R') DEFAULT 'G' COMMENT 'G=GEOPUNTO,C=GEOCERCA,R=RUTA',
  `COD_COLOR` varchar(15) DEFAULT NULL,
  `PRIVACIDAD` enum('T','C','P') DEFAULT 'P' COMMENT 'T=TODOS LO PUEDEN VER\nC=SOLO CLIENTE LO PUEDE VER\nP=SOLO EL USUARIO PUEDE VER',
  `ID_ADM_USUARIO` int(10) NOT NULL,
  `CREADO` datetime NOT NULL,
  `BASE` int(5) DEFAULT '0' COMMENT 'valor 1=SI 0=NO',
  `ITEM_NUMBER` varchar(45) DEFAULT NULL,
  `RESPONSABLE` varchar(45) DEFAULT NULL,
  `CORREO` varchar(45) DEFAULT NULL,
  `CELULAR` varchar(45) DEFAULT NULL,
  `TWITTER` varchar(45) NOT NULL,
  `ITI_AUTO_E_S_GPS` enum('S','N') DEFAULT 'S',
  `ITI_NOTI_ENTRADA` enum('S','N') DEFAULT 'N',
  `ITI_NOTI_SALIDA` enum('S','N') DEFAULT 'N',
  `ITI_NOTI_ATRAZO` enum('S','N') DEFAULT 'N',
  `ITI_NOTI_VISTA_RUTA` enum('S','N') DEFAULT 'N',
  PRIMARY KEY (`ID_OBJECT_MAP`)
) ENGINE=InnoDB AUTO_INCREMENT=1653 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_RH_PDI`
--

DROP TABLE IF EXISTS `ADM_RH_PDI`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_RH_PDI` (
  `ID_RH_PDI` int(11) NOT NULL AUTO_INCREMENT,
  `ID_RH` int(11) DEFAULT NULL,
  `ID_OBJECT_MAP` int(11) DEFAULT NULL,
  `ID_USUARIO` int(11) DEFAULT NULL,
  `ID_CLIENTE` int(11) DEFAULT NULL,
  `ORDEN` int(3) DEFAULT NULL,
  PRIMARY KEY (`ID_RH_PDI`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_RH_TIPO`
--

DROP TABLE IF EXISTS `ADM_RH_TIPO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_RH_TIPO` (
  `ID_TIPO` int(10) NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` int(10) DEFAULT NULL,
  `DESCRIPCION` varchar(144) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IMAGE` text COLLATE utf8_spanish_ci,
  `OBSERVACIONES` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`ID_TIPO`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_RH_USUARIO`
--

DROP TABLE IF EXISTS `ADM_RH_USUARIO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_RH_USUARIO` (
  `ID_RH_USUARIO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_RH` int(11) NOT NULL,
  `ID_USUARIO` int(11) NOT NULL,
  `FECHA` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_RH_USUARIO`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_SPM_CIUDADES`
--

DROP TABLE IF EXISTS `ADM_SPM_CIUDADES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_SPM_CIUDADES` (
  `ID_CIUDAD` int(10) unsigned NOT NULL DEFAULT '0',
  `ID_ESTADO` int(10) unsigned NOT NULL DEFAULT '0',
  `ID_MUNICIPIO` int(10) unsigned NOT NULL DEFAULT '0',
  `NOMBRE` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID_CIUDAD`,`ID_ESTADO`,`ID_MUNICIPIO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_SPM_COLONIAS`
--

DROP TABLE IF EXISTS `ADM_SPM_COLONIAS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_SPM_COLONIAS` (
  `ID_COLONIA` int(10) unsigned NOT NULL DEFAULT '0',
  `ID_ESTADO` int(10) unsigned NOT NULL DEFAULT '0',
  `ID_CIUDAD` int(10) unsigned NOT NULL DEFAULT '0',
  `ID_MUNICIPIO` int(10) unsigned NOT NULL DEFAULT '0',
  `NOMBRE` varchar(150) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `CP` int(10) unsigned NOT NULL DEFAULT '0',
  `ID_TIPO` int(10) unsigned NOT NULL DEFAULT '0',
  `ZONA` varchar(45) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`ID_COLONIA`,`ID_ESTADO`,`ID_CIUDAD`,`ID_MUNICIPIO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_SPM_ENTIDADES`
--

DROP TABLE IF EXISTS `ADM_SPM_ENTIDADES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_SPM_ENTIDADES` (
  `ID_ESTADO` int(10) unsigned NOT NULL DEFAULT '0',
  `NOMBRE` varchar(45) NOT NULL DEFAULT '',
  `CLAVE` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`ID_ESTADO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_SPM_MUNICIPIOS`
--

DROP TABLE IF EXISTS `ADM_SPM_MUNICIPIOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_SPM_MUNICIPIOS` (
  `ID_ESTADO` int(10) unsigned NOT NULL DEFAULT '0',
  `ID_MUNICIPIO` int(10) unsigned NOT NULL DEFAULT '0',
  `NOMBRE` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID_ESTADO`,`ID_MUNICIPIO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_SPM_TIPO_ASENTAMIENTO`
--

DROP TABLE IF EXISTS `ADM_SPM_TIPO_ASENTAMIENTO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_SPM_TIPO_ASENTAMIENTO` (
  `ID_TIPO` int(10) unsigned NOT NULL,
  `DESCRIPCION` varchar(90) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID_TIPO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_SUBMENU`
--

DROP TABLE IF EXISTS `ADM_SUBMENU`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_SUBMENU` (
  `ID_SUBMENU` int(11) NOT NULL AUTO_INCREMENT,
  `ID_MENU` int(11) NOT NULL,
  `DESCRIPTION` varchar(45) NOT NULL,
  `ITEM_NUMBER` varchar(20) NOT NULL,
  `SECUENCIA` int(11) NOT NULL,
  `UBICACION` varchar(45) DEFAULT NULL,
  `TIPO` enum('M','A','R') NOT NULL COMMENT 'A-APLICACION,M-MODULO,R-REPORTE',
  `ACCION` enum('D','V','W','A','C','U') DEFAULT NULL COMMENT '''D'' -> DIRECTORIO\n''V'' -> VENTANA \n''A'' -> APLICACION\n''C''-> COMANDO\n''U''->URL\nW-> Venta y URL',
  `ACTIVO` enum('S','N') NOT NULL,
  `ICONO_MOVIL` varchar(45) DEFAULT NULL,
  `ICONO_WEB` varchar(45) DEFAULT NULL,
  `CREADO` datetime DEFAULT NULL,
  `ISDEFAULT` int(1) DEFAULT '0',
  `ADMIN_ROOT` int(1) DEFAULT '0',
  PRIMARY KEY (`ID_SUBMENU`),
  UNIQUE KEY `SECUENCIA_MENU` (`ID_MENU`,`SECUENCIA`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_SUBMENU_CLIENTES`
--

DROP TABLE IF EXISTS `ADM_SUBMENU_CLIENTES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_SUBMENU_CLIENTES` (
  `ID_SUBMENU_CONTENIDO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_SUBMENU` int(11) NOT NULL,
  `ID_CLIENTE` int(11) NOT NULL,
  `ORDEN` int(1) DEFAULT NULL,
  PRIMARY KEY (`ID_SUBMENU_CONTENIDO`)
) ENGINE=MyISAM AUTO_INCREMENT=498 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_TIPO_COMUNICACION`
--

DROP TABLE IF EXISTS `ADM_TIPO_COMUNICACION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_TIPO_COMUNICACION` (
  `COD_TYPE_COMUNICATION` int(11) NOT NULL DEFAULT '0',
  `TYPE_COMUNICATION` varchar(60) NOT NULL,
  `PORT_RX_DEFAULT` decimal(5,0) DEFAULT NULL,
  `PORT_TX_DEFAULT` decimal(5,0) DEFAULT NULL,
  PRIMARY KEY (`COD_TYPE_COMUNICATION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_TIPO_UNIDAD`
--

DROP TABLE IF EXISTS `ADM_TIPO_UNIDAD`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_TIPO_UNIDAD` (
  `COD_TYPE_ENTITY` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPTION` varchar(60) DEFAULT NULL,
  `MAP_SYMBOL` varchar(60) DEFAULT NULL,
  `FLAG_MOBILE` decimal(1,0) DEFAULT NULL,
  `FONT_SYMBOL` varchar(60) DEFAULT NULL,
  `OBSERVACION` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`COD_TYPE_ENTITY`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_UNIDADES`
--

DROP TABLE IF EXISTS `ADM_UNIDADES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_UNIDADES` (
  `COD_ENTITY` int(11) NOT NULL AUTO_INCREMENT,
  `COD_TRADEMARK_MODEL` int(11) NOT NULL,
  `COD_TYPE_ENTITY` int(11) NOT NULL,
  `COD_DETAIL_STATUS` int(11) DEFAULT NULL,
  `COD_CLIENT` int(11) DEFAULT NULL,
  `COD_PROTOCOLO` int(11) DEFAULT NULL,
  `DESCRIPTION` varchar(100) NOT NULL,
  `ACTIVE` decimal(1,0) DEFAULT '1',
  `ITEM_NUMBER_ENTITY` varchar(10) DEFAULT NULL,
  `PLAQUE` varchar(10) DEFAULT NULL,
  `BODYWORK_CODE` varchar(30) DEFAULT NULL,
  `MOTOR_CODE` varchar(30) DEFAULT NULL,
  `YEAR` decimal(4,0) DEFAULT NULL,
  `INITIAL_KM` decimal(10,0) DEFAULT NULL,
  `ITEM_NUMBER_UNITY` varchar(20) DEFAULT NULL,
  `OBSERVATIONS` varchar(100) DEFAULT NULL,
  `NAME_INSTALLER` varchar(30) DEFAULT NULL,
  `DATETIME_INSTALLER` datetime DEFAULT NULL,
  `CAPACITY_CARRY_KG` decimal(20,0) DEFAULT NULL,
  `ID_EMPRESA` int(11) NOT NULL,
  PRIMARY KEY (`COD_ENTITY`)
) ENGINE=InnoDB AUTO_INCREMENT=466 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_UNIDADES_EQUIPOS`
--

DROP TABLE IF EXISTS `ADM_UNIDADES_EQUIPOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_UNIDADES_EQUIPOS` (
  `COD_ENTITY_EQUIPMENT` int(11) NOT NULL AUTO_INCREMENT,
  `COD_EQUIPMENT` int(11) NOT NULL,
  `COD_ENTITY` int(11) NOT NULL,
  PRIMARY KEY (`COD_ENTITY_EQUIPMENT`),
  UNIQUE KEY `UNIDAD_EQUIPO_UNICO` (`COD_EQUIPMENT`,`COD_ENTITY`),
  UNIQUE KEY `EQUIPO_UNIDAD_UNICO` (`COD_EQUIPMENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`)
) ENGINE=InnoDB AUTO_INCREMENT=646 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_UNIDADES_ESTATUS`
--

DROP TABLE IF EXISTS `ADM_UNIDADES_ESTATUS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_UNIDADES_ESTATUS` (
  `COD_DETAIL_STATUS` int(11) NOT NULL DEFAULT '0',
  `DESCRIPTION` varchar(60) DEFAULT NULL,
  `COD_COLOR` decimal(10,0) DEFAULT NULL,
  `FLAG_NORMAL` decimal(1,0) DEFAULT NULL,
  `FLAG_CLIENTE` decimal(1,0) DEFAULT NULL,
  `FLAG_ERROR_HARDWARE` decimal(1,0) DEFAULT NULL,
  PRIMARY KEY (`COD_DETAIL_STATUS`),
  KEY `FLAG_STATUS_HARD_NORMAL` (`FLAG_NORMAL`),
  KEY `COD_COLOR` (`COD_COLOR`),
  KEY `FLAG_STATUS_SAVL` (`FLAG_CLIENTE`),
  KEY `FLAG_ERROR_HARDWARE` (`FLAG_ERROR_HARDWARE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_USUARIOS`
--

DROP TABLE IF EXISTS `ADM_USUARIOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_USUARIOS` (
  `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PERFIL` int(11) DEFAULT NULL,
  `ID_EMPRESA` int(11) NOT NULL,
  `ID_CLIENTE` int(11) DEFAULT NULL,
  `ID_PAIS` int(11) DEFAULT NULL,
  `ID_TIPO_USUARIO` int(11) NOT NULL,
  `NOMBRE_COMPLETO` varchar(200) DEFAULT NULL,
  `EMAIL` varchar(60) NOT NULL,
  `USUARIO` varchar(40) DEFAULT NULL,
  `PASSWORD` varchar(40) DEFAULT NULL,
  `SHA1_PASSWORD` varchar(100) NOT NULL,
  `ID_ADM_USUARIO` varchar(60) DEFAULT NULL,
  `FECHA_CREACION` datetime NOT NULL,
  `ESTATUS` enum('Activo','Inactivo') DEFAULT NULL,
  PRIMARY KEY (`ID_USUARIO`),
  KEY `NICK_NAME` (`SHA1_PASSWORD`),
  KEY `COD_GROUP_USER` (`ID_EMPRESA`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_USUARIOS_GRUPOS`
--

DROP TABLE IF EXISTS `ADM_USUARIOS_GRUPOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_USUARIOS_GRUPOS` (
  `ID_USUARIO` int(11) NOT NULL,
  `COD_ENTITY` int(11) DEFAULT NULL,
  `ID_GRUPO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_USUARIOS_PERMISOS`
--

DROP TABLE IF EXISTS `ADM_USUARIOS_PERMISOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_USUARIOS_PERMISOS` (
  `ID_USUARIOS_PERMISOS` int(11) NOT NULL AUTO_INCREMENT,
  `ID_SUBMENU` int(11) NOT NULL,
  `ID_USUARIO` int(11) NOT NULL,
  `ID_PERMISO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_USUARIOS_PERMISOS`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_USUARIOS_SUPER`
--

DROP TABLE IF EXISTS `ADM_USUARIOS_SUPER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_USUARIOS_SUPER` (
  `ID_USUARIO` int(11) NOT NULL,
  `NIVEL` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ADM_USUARIOS_TIPO`
--

DROP TABLE IF EXISTS `ADM_USUARIOS_TIPO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADM_USUARIOS_TIPO` (
  `ID_TIPO_USUARIO` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(60) DEFAULT NULL,
  `ESTATUS` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_TIPO_USUARIO`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CAT_CATALOGO`
--

DROP TABLE IF EXISTS `CAT_CATALOGO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CAT_CATALOGO` (
  `ID_CATALOGO` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ACTIVO` enum('S','N') COLLATE utf8_spanish_ci DEFAULT 'S',
  PRIMARY KEY (`ID_CATALOGO`),
  UNIQUE KEY `ID_CATALOGO` (`ID_CATALOGO`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CAT_CLIENTE_CATALOGO`
--

DROP TABLE IF EXISTS `CAT_CLIENTE_CATALOGO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CAT_CLIENTE_CATALOGO` (
  `ID_CATALOGO` int(11) NOT NULL,
  `ID_CLIENTE` int(11) NOT NULL,
  PRIMARY KEY (`ID_CATALOGO`),
  KEY `ID_CLIENTE` (`ID_CLIENTE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CAT_CONTENIDO`
--

DROP TABLE IF EXISTS `CAT_CONTENIDO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CAT_CONTENIDO` (
  `ID_SUBMENU_CONTENIDO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_SUBMENU` int(11) NOT NULL,
  `UBICACION_LOCAL` varchar(45) DEFAULT NULL,
  `UBICACION_REMOTA` varchar(300) DEFAULT NULL,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  `ORDEN` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_SUBMENU_CONTENIDO`),
  KEY `ID_SUBMENU` (`ID_SUBMENU`),
  CONSTRAINT `CAT_CONTENIDO_ibfk_1` FOREIGN KEY (`ID_SUBMENU`) REFERENCES `CAT_SUBMENU` (`ID_SUBMENU`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1 COMMENT='DETALLE DE CONTENIDO';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CAT_CONTENIDO_DETALLE`
--

DROP TABLE IF EXISTS `CAT_CONTENIDO_DETALLE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CAT_CONTENIDO_DETALLE` (
  `ID_CONTENIDO_DETALLE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_CONTENIDO` int(11) DEFAULT NULL,
  `TITULO` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `NOMBRE_AUTOR` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `RESUMEN` blob,
  `TAG` varchar(150) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `ID_EVENTO` int(11) DEFAULT NULL,
  `IMAGEN` varchar(150) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`ID_CONTENIDO_DETALLE`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CAT_IMAGENES`
--

DROP TABLE IF EXISTS `CAT_IMAGENES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CAT_IMAGENES` (
  `ID_CATALOGO` int(11) NOT NULL AUTO_INCREMENT,
  `IMG_LOGIN` varchar(120) CHARACTER SET latin1 DEFAULT NULL,
  `IMG_PORTADA` varchar(120) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`ID_CATALOGO`),
  CONSTRAINT `FK_CAT_IMAGENES` FOREIGN KEY (`ID_CATALOGO`) REFERENCES `CAT_CATALOGO` (`ID_CATALOGO`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CAT_MENU`
--

DROP TABLE IF EXISTS `CAT_MENU`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CAT_MENU` (
  `ID_MENU` int(11) NOT NULL AUTO_INCREMENT,
  `ID_CATALOGO` int(11) DEFAULT NULL,
  `DESCRIPTION` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `URL` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `ACTIVO` enum('S','N') CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `ICONO` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `CREADO` datetime DEFAULT NULL,
  `TIPO` enum('W','M','A') CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `DESCRIPTION2` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`ID_MENU`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COMMENT='TABLA DE OPCIONES DEL SISTEMA';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CAT_SUBMENU`
--

DROP TABLE IF EXISTS `CAT_SUBMENU`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CAT_SUBMENU` (
  `ID_SUBMENU` int(11) NOT NULL AUTO_INCREMENT,
  `ID_MENU` int(11) NOT NULL,
  `DESCRIPTION` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ITEM_NUMBER` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `SECUENCIA` int(11) NOT NULL,
  `UBICACION` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `TIPO` enum('M','W','A') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'M - MOVIL\nW - WEB\nA - AMBOS',
  `ACCION` enum('D','V','W','A','C','U','F') CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT '''D'' -> DIRECTORIO\r\n''V'' -> VENTANA \r\n''A'' -> APLICACION\r\n''C''-> COMANDO\r\n''U''->URL\r\nW-> Venta y URL',
  `ACTIVO` enum('S','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ICONO_MOVIL` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `ICONO_WEB` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `CREADO` datetime DEFAULT NULL,
  `DESCRIPTION2` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`ID_SUBMENU`),
  KEY `ID_MENU` (`ID_MENU`),
  CONSTRAINT `CAT_SUBMENU_ibfk_1` FOREIGN KEY (`ID_MENU`) REFERENCES `CAT_MENU` (`ID_MENU`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='SUBMENUS';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CAT_USUARIO_SUBMENU`
--

DROP TABLE IF EXISTS `CAT_USUARIO_SUBMENU`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CAT_USUARIO_SUBMENU` (
  `ID_USUARIO` int(11) DEFAULT NULL,
  `ID_SUBMENU` int(11) DEFAULT NULL,
  KEY `ID_SUBMENU` (`ID_SUBMENU`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  CONSTRAINT `CAT_USUARIO_SUBMENU_ibfk_2` FOREIGN KEY (`ID_USUARIO`) REFERENCES `ADM_USUARIOS` (`ID_USUARIO`),
  CONSTRAINT `CAT_USUARIO_SUBMENU_ibfk_1` FOREIGN KEY (`ID_SUBMENU`) REFERENCES `CAT_SUBMENU` (`ID_SUBMENU`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CRM2_CUESTIONARIOS`
--

DROP TABLE IF EXISTS `CRM2_CUESTIONARIOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CRM2_CUESTIONARIOS` (
  `ID_CUESTIONARIO` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `COD_CLIENT` int(11) NOT NULL,
  `ID_TIPO` int(11) NOT NULL DEFAULT '1',
  `MULTIPLES_RESPUESTAS` int(1) DEFAULT '0',
  `OFFLINE` int(1) DEFAULT '0',
  `TEMA` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `URL` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ID_EJE_X` int(11) DEFAULT '0',
  `ID_EJE_Y` int(11) DEFAULT '0',
  KEY `ID_CUESTIONARIO` (`ID_CUESTIONARIO`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CRM2_CUESTIONARIO_PREGUNTAS`
--

DROP TABLE IF EXISTS `CRM2_CUESTIONARIO_PREGUNTAS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CRM2_CUESTIONARIO_PREGUNTAS` (
  `ID_PREGUNTA` int(11) NOT NULL,
  `ID_CUESTIONARIO` int(11) NOT NULL,
  `ORDEN` int(11) NOT NULL,
  PRIMARY KEY (`ID_PREGUNTA`,`ID_CUESTIONARIO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CRM2_EJE_X`
--

DROP TABLE IF EXISTS `CRM2_EJE_X`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CRM2_EJE_X` (
  `ID_CLIENTE` int(11) NOT NULL,
  `ID_EJE_X` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(145) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID_EJE_X`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CRM2_EJE_Y`
--

DROP TABLE IF EXISTS `CRM2_EJE_Y`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CRM2_EJE_Y` (
  `ID_EJE_Y` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(145) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `ID_EJE_Z` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_EJE_Y`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CRM2_EJE_Z`
--

DROP TABLE IF EXISTS `CRM2_EJE_Z`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CRM2_EJE_Z` (
  `ID_CLIENTE` int(11) NOT NULL,
  `ID_EJE_Z` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`ID_EJE_Z`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CRM2_LOG`
--

DROP TABLE IF EXISTS `CRM2_LOG`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CRM2_LOG` (
  `ID_LOG` int(11) NOT NULL AUTO_INCREMENT,
  `ID_RES_CUESTIONARIO` int(11) DEFAULT NULL,
  `ID_USER` int(11) DEFAULT NULL,
  `FECHA` datetime DEFAULT NULL,
  `OBSERVACIONES` longtext COLLATE utf8_spanish_ci,
  PRIMARY KEY (`ID_LOG`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CRM2_PREGUNTAS`
--

DROP TABLE IF EXISTS `CRM2_PREGUNTAS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CRM2_PREGUNTAS` (
  `ID_PREGUNTA` int(11) NOT NULL AUTO_INCREMENT,
  `ID_TIPO` int(11) NOT NULL,
  `COD_CLIENT` int(11) DEFAULT NULL,
  `DESCRIPCION` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ACTIVO` tinyint(1) DEFAULT NULL,
  `COMPLEMENTO` varchar(200) CHARACTER SET utf8 NOT NULL,
  `RECORDADO` int(11) NOT NULL DEFAULT '0',
  `REQUERIDO` int(11) NOT NULL DEFAULT '1',
  `GRAFICABLEDATA` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`ID_PREGUNTA`),
  KEY `ID_PREGUNTA` (`ID_PREGUNTA`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CRM2_PREG_RES`
--

DROP TABLE IF EXISTS `CRM2_PREG_RES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CRM2_PREG_RES` (
  `ID_PREGUNTA` int(11) NOT NULL,
  `RESPUESTA` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ID_RES_CUESTIONARIO` int(11) DEFAULT NULL,
  `CALIFICACION` int(10) DEFAULT '0',
  KEY `ID_RES_CUESTIONARIO` (`ID_RES_CUESTIONARIO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CRM2_RESPUESTAS`
--

DROP TABLE IF EXISTS `CRM2_RESPUESTAS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CRM2_RESPUESTAS` (
  `ID_RES_CUESTIONARIO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_CUESTIONARIO` int(11) NOT NULL,
  `COD_USER` int(11) NOT NULL,
  `FECHA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'FECHA DE FIN DE CAPTURA DE CUESTIONARIO',
  `LATITUD` decimal(12,6) DEFAULT NULL,
  `LONGITUD` decimal(12,6) DEFAULT NULL,
  `BATERIA` int(11) DEFAULT '0' COMMENT 'NIVEL DE BATERIA',
  `FECHA_INICIO_CAPTURA` timestamp NULL DEFAULT NULL,
  `FECHA_RECEPCION` timestamp NULL DEFAULT NULL,
  `NUM_SEMANA` int(11) DEFAULT NULL,
  `ID_EJE_X` int(11) DEFAULT '0' COMMENT 'CAMPO PARA TIPO CUANTITATIVO',
  `ID_EJE_Y` int(11) DEFAULT '0' COMMENT 'CAMPO PARA TIPO CUANTITATIVO',
  `CALIFICACION` int(11) DEFAULT '0',
  PRIMARY KEY (`ID_RES_CUESTIONARIO`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CRM2_RESPUESTAS_CUANTITATIVO`
--

DROP TABLE IF EXISTS `CRM2_RESPUESTAS_CUANTITATIVO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CRM2_RESPUESTAS_CUANTITATIVO` (
  `ID_RES_CUESTIONARIO` int(11) DEFAULT NULL,
  `CADENA_CUANTITATIVO` longtext,
  `CALIFICADO` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CRM2_RESPUESTAS_HISTORICO`
--

DROP TABLE IF EXISTS `CRM2_RESPUESTAS_HISTORICO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CRM2_RESPUESTAS_HISTORICO` (
  `ID_RES_CUESTIONARIO` int(11) NOT NULL,
  `COD_HISTORY` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CRM2_TEMA`
--

DROP TABLE IF EXISTS `CRM2_TEMA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CRM2_TEMA` (
  `ID_TEMA` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `CABECERA` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BARRA` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CUERPO` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID_TEMA`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CRM2_TIPO_CUES`
--

DROP TABLE IF EXISTS `CRM2_TIPO_CUES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CRM2_TIPO_CUES` (
  `ID_TIPO` int(11) NOT NULL,
  `DESCRIPCION` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`ID_TIPO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CRM2_TIPO_PREG`
--

DROP TABLE IF EXISTS `CRM2_TIPO_PREG`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CRM2_TIPO_PREG` (
  `ID_TIPO` int(11) NOT NULL,
  `TIPO` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT '01 NUMERO\n02 TEXTO\n03 SI-NO\n04 FECHA\n05 SELECCION S\n06 SELECCION MULTIPLE\n07 SI-NO DESCRIP\n08 FOTO\n09 AUDIO\n10 VIDEO\n\n',
  `MULTIMEDIA` int(2) DEFAULT '0',
  `ACTIVO` int(11) DEFAULT '0',
  `P_PANTALLA` int(11) DEFAULT '0',
  `GRAFICABLE` int(1) DEFAULT '0',
  `HTML` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `PAYLOAD` int(1) DEFAULT NULL,
  PRIMARY KEY (`ID_TIPO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CRM2_VENDEDOR_CUESTIONARIO`
--

DROP TABLE IF EXISTS `CRM2_VENDEDOR_CUESTIONARIO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CRM2_VENDEDOR_CUESTIONARIO` (
  `ID_CUESTIONARIO` int(11) NOT NULL,
  `COD_USER` int(11) NOT NULL,
  `ORDEN` int(11) DEFAULT NULL,
  `POR_DEFECTO` int(11) DEFAULT '0',
  KEY `fk_CRM2_VENDEDOR_CUESTIONARIO_SAVL11001` (`COD_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DSP_CIRCUITO`
--

DROP TABLE IF EXISTS `DSP_CIRCUITO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DSP_CIRCUITO` (
  `ID_CTO` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(45) NOT NULL DEFAULT '',
  `FECHA_CREACION` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `COD_USER` int(10) unsigned NOT NULL DEFAULT '0',
  `COD_CLIENT` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_CTO`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DSP_CIRCUITO_PDI`
--

DROP TABLE IF EXISTS `DSP_CIRCUITO_PDI`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DSP_CIRCUITO_PDI` (
  `ID_CIRCUITO` int(10) unsigned NOT NULL DEFAULT '0',
  `COD_OBEJECT_MAP` int(10) unsigned NOT NULL DEFAULT '0',
  `FECHA_CREACION` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `COD_USER` int(10) unsigned NOT NULL DEFAULT '0',
  `COD_CLIENT` int(10) unsigned NOT NULL DEFAULT '0',
  `ORDEN` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DSP_DESPACHO`
--

DROP TABLE IF EXISTS `DSP_DESPACHO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DSP_DESPACHO` (
  `ID_DESPACHO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ESTATUS` int(11) DEFAULT NULL,
  `COD_USER` int(11) DEFAULT NULL,
  `DESCRIPCION` varchar(100) NOT NULL DEFAULT '',
  `ITEM_NUMBER` varchar(100) NOT NULL DEFAULT '',
  `FECHA_INICIO` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `FECHA_REAL_INICIO` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `FECHA_FIN` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `FECHA_REAL_FIN` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `TOLERANCIA` int(11) NOT NULL DEFAULT '0',
  `PARADAS` int(11) NOT NULL DEFAULT '0',
  `EXCESOS` int(11) NOT NULL DEFAULT '0',
  `CREADO` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `TOTAL_PARADAS` int(11) NOT NULL DEFAULT '0',
  `TOTAL_EXCESOS` int(11) NOT NULL DEFAULT '0',
  `DIF_INICIO` int(11) NOT NULL DEFAULT '0',
  `DIF_FIN` int(11) NOT NULL DEFAULT '0',
  `TOTAL_DISTANCIA` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_DESPACHO`)
) ENGINE=MyISAM AUTO_INCREMENT=617 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DSP_DOCUMENTA_ITINERARIO`
--

DROP TABLE IF EXISTS `DSP_DOCUMENTA_ITINERARIO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DSP_DOCUMENTA_ITINERARIO` (
  `ID_DOCUMENTACION` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ENTREGA` int(11) NOT NULL,
  `ID_CUESTIONARIO` int(11) NOT NULL,
  `ID_PAYLOAD` int(11) NOT NULL,
  PRIMARY KEY (`ID_DOCUMENTACION`)
) ENGINE=MyISAM AUTO_INCREMENT=211 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DSP_ESTATUS`
--

DROP TABLE IF EXISTS `DSP_ESTATUS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DSP_ESTATUS` (
  `ID_ESTATUS` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(100) NOT NULL,
  `COLOR` varchar(20) NOT NULL,
  `EDITABLE` int(11) NOT NULL,
  `FINAL` int(11) NOT NULL,
  PRIMARY KEY (`ID_ESTATUS`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DSP_INCIDENCIA_ITINERARIO`
--

DROP TABLE IF EXISTS `DSP_INCIDENCIA_ITINERARIO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DSP_INCIDENCIA_ITINERARIO` (
  `ID_INCIDENCIA` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ENTREGA` int(11) NOT NULL,
  `ID_TIPO` int(11) NOT NULL,
  `COD_USER` int(11) NOT NULL,
  `COMENTARIOS` text NOT NULL,
  `FECHA` datetime NOT NULL,
  PRIMARY KEY (`ID_INCIDENCIA`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DSP_ITINERARIO`
--

DROP TABLE IF EXISTS `DSP_ITINERARIO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DSP_ITINERARIO` (
  `ID_ENTREGA` int(11) NOT NULL AUTO_INCREMENT,
  `ID_DESPACHO` int(11) NOT NULL,
  `ID_ESTATUS` int(11) NOT NULL,
  `COD_GEO` int(11) NOT NULL,
  `COD_USER` int(11) NOT NULL,
  `ITEM_NUMBER` varchar(60) NOT NULL DEFAULT '',
  `COMENTARIOS` varchar(200) NOT NULL,
  `FECHA_ENTREGA` datetime NOT NULL COMMENT 'FECHA EN LA QUE SE ESPERA LLEGUE AL LUGAR',
  `FECHA_ARRIBO` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'FECHA EN LA QUE REALMENTE LLEGO',
  `FECHA_SALIDA` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'FECHA EN LA QUE REAMENTE SALIO',
  `FECHA_FIN` datetime NOT NULL COMMENT 'FECHA EN LA QUE SE ESPERA SALGA DEL LUGAR',
  `VOLUMEN` decimal(10,2) NOT NULL COMMENT 'TOTAL DE VOLUMEN ENTREGADO PZAS, LITROS, KILOS, TONS',
  `CREADO` datetime NOT NULL,
  `VISITA_DURACION` int(11) NOT NULL,
  `DISTANCIA` int(11) NOT NULL,
  `ID_TIPO_VOLUMEN` int(11) NOT NULL,
  `TOLERANCIA` int(11) NOT NULL DEFAULT '0',
  `TIPO_RH` enum('GP','RH') DEFAULT NULL,
  `COD_RH` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ENTREGA`)
) ENGINE=MyISAM AUTO_INCREMENT=650 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DSP_NOTAS_DESPACHO`
--

DROP TABLE IF EXISTS `DSP_NOTAS_DESPACHO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DSP_NOTAS_DESPACHO` (
  `ID_NOTA` int(11) NOT NULL,
  `ID_DESPACHO` int(11) NOT NULL,
  `ID_TIPO` int(11) NOT NULL,
  `COD_USER` int(11) NOT NULL,
  `COMENTARIOS` text NOT NULL,
  `FECHA` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DSP_RESUMEN`
--

DROP TABLE IF EXISTS `DSP_RESUMEN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DSP_RESUMEN` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_DESPACHO` int(11) DEFAULT NULL,
  `COD_ENTITY` int(11) DEFAULT NULL,
  `COD_USER` int(11) DEFAULT NULL,
  `COD_CLIENT` int(10) DEFAULT NULL,
  `FECHA` date DEFAULT NULL,
  `UNIDAD` varchar(60) NOT NULL,
  `ITEM_VIAJE` varchar(60) DEFAULT NULL,
  `FECHA_IN_PROGRAMADA` datetime DEFAULT NULL,
  `FECHA_OUT_PROGRAMADA` datetime DEFAULT NULL,
  `FECHA_IN_REAL` datetime DEFAULT NULL,
  `FECHA_OUT_REAL` datetime DEFAULT NULL,
  `RETARDOS` int(11) NOT NULL,
  `TIPO` varchar(60) NOT NULL,
  `C0000` varchar(1000) DEFAULT '0',
  `C0030` varchar(1000) DEFAULT '0',
  `C0100` varchar(1000) DEFAULT '0',
  `C0130` varchar(1000) DEFAULT '0',
  `C0200` varchar(1000) DEFAULT '0',
  `C0230` varchar(1000) DEFAULT '0',
  `C0300` varchar(1000) DEFAULT '0',
  `C0330` varchar(1000) DEFAULT '0',
  `C0400` varchar(1000) DEFAULT '0',
  `C0430` varchar(1000) DEFAULT '0',
  `C0500` varchar(1000) DEFAULT '0',
  `C0530` varchar(1000) DEFAULT '0',
  `C0600` varchar(1000) DEFAULT '0',
  `C0630` varchar(1000) DEFAULT '0',
  `C0700` varchar(1000) DEFAULT '0',
  `C0730` varchar(1000) DEFAULT '0',
  `C0800` varchar(1000) DEFAULT '0',
  `C0830` varchar(1000) DEFAULT '0',
  `C0900` varchar(1000) DEFAULT '0',
  `C0930` varchar(1000) DEFAULT '0',
  `C1000` varchar(1000) DEFAULT '0',
  `C1030` varchar(1000) DEFAULT '0',
  `C1100` varchar(1000) DEFAULT '0',
  `C1130` varchar(1000) DEFAULT '0',
  `C1200` varchar(1000) DEFAULT '0',
  `C1230` varchar(1000) DEFAULT '0',
  `C1300` varchar(1000) DEFAULT '0',
  `C1330` varchar(1000) DEFAULT '0',
  `C1400` varchar(1000) DEFAULT '0',
  `C1430` varchar(1000) DEFAULT '0',
  `C1500` varchar(1000) DEFAULT '0',
  `C1530` varchar(1000) DEFAULT '0',
  `C1600` varchar(1000) DEFAULT '0',
  `C1630` varchar(1000) DEFAULT '0',
  `C1700` varchar(1000) DEFAULT '0',
  `C1730` varchar(1000) DEFAULT '0',
  `C1800` varchar(1000) DEFAULT '0',
  `C1830` varchar(1000) DEFAULT '0',
  `C1900` varchar(1000) DEFAULT '0',
  `C1930` varchar(1000) DEFAULT '0',
  `C2000` varchar(1000) DEFAULT '0',
  `C2030` varchar(1000) DEFAULT '0',
  `C2100` varchar(1000) DEFAULT '0',
  `C2130` varchar(1000) DEFAULT '0',
  `C2200` varchar(1000) DEFAULT '0',
  `C2230` varchar(1000) DEFAULT '0',
  `C2300` varchar(1000) DEFAULT '0',
  `C2330` varchar(1000) DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_CLIENT` (`COD_USER`),
  KEY `FECHA` (`FECHA`),
  KEY `ID_DESPACHO` (`ID_DESPACHO`),
  KEY `idx_tipo` (`TIPO`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DSP_TIPO_NOTA`
--

DROP TABLE IF EXISTS `DSP_TIPO_NOTA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DSP_TIPO_NOTA` (
  `ID_TIPO` int(11) NOT NULL,
  `DESCRIPCION` varchar(60) NOT NULL,
  PRIMARY KEY (`ID_TIPO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DSP_TIPO_VOLUMEN`
--

DROP TABLE IF EXISTS `DSP_TIPO_VOLUMEN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DSP_TIPO_VOLUMEN` (
  `ID_TIPO_VOLUMEN` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(60) NOT NULL,
  `ABREVIATURA` varchar(1) NOT NULL,
  PRIMARY KEY (`ID_TIPO_VOLUMEN`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DSP_UNIDAD_ASIGNADA`
--

DROP TABLE IF EXISTS `DSP_UNIDAD_ASIGNADA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DSP_UNIDAD_ASIGNADA` (
  `ID_ASIGNACION` int(11) NOT NULL AUTO_INCREMENT,
  `ID_DESPACHO` int(11) NOT NULL,
  `COD_ENTITY` int(11) NOT NULL,
  `FECHA_ASIGNACION` datetime NOT NULL,
  `COMENTARIO` varchar(100) NOT NULL,
  `ACTIVO` int(11) NOT NULL,
  `LIBRE` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ASIGNACION`),
  UNIQUE KEY `IDX_UNIDAD_UNICA` (`ID_DESPACHO`,`COD_ENTITY`)
) ENGINE=MyISAM AUTO_INCREMENT=264 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DSP_ZONA`
--

DROP TABLE IF EXISTS `DSP_ZONA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DSP_ZONA` (
  `ID_ZONA` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(45) NOT NULL DEFAULT '',
  `FECHA_CREACION` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `COD_USER` int(10) unsigned NOT NULL DEFAULT '0',
  `COD_CLIENT` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_ZONA`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DSP_ZONA_PDI`
--

DROP TABLE IF EXISTS `DSP_ZONA_PDI`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DSP_ZONA_PDI` (
  `ID_ZONA` int(10) unsigned NOT NULL DEFAULT '0',
  `COD_OBJECT_MAP` int(10) unsigned NOT NULL DEFAULT '0',
  `FECHA_CREACION` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `COD_USER` int(10) unsigned NOT NULL DEFAULT '0',
  `COD_CLIENT` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00000`
--

DROP TABLE IF EXISTS `HIST00000`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00000` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` timestamp NULL DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_DBM_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_DBM_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` varchar(10) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=704114 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00001`
--

DROP TABLE IF EXISTS `HIST00001`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00001` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_DBM_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_DBM_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` varchar(10) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=14251 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00019`
--

DROP TABLE IF EXISTS `HIST00019`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00019` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_DBM_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_DBM_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` varchar(10) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=49051 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00020`
--

DROP TABLE IF EXISTS `HIST00020`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00020` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_DBM_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_DBM_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=514461 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00021`
--

DROP TABLE IF EXISTS `HIST00021`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00021` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=498599 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00023`
--

DROP TABLE IF EXISTS `HIST00023`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00023` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=1693701 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00024`
--

DROP TABLE IF EXISTS `HIST00024`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00024` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=345929 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00025`
--

DROP TABLE IF EXISTS `HIST00025`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00025` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=65851 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00026`
--

DROP TABLE IF EXISTS `HIST00026`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00026` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=3489 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00027`
--

DROP TABLE IF EXISTS `HIST00027`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00027` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00028`
--

DROP TABLE IF EXISTS `HIST00028`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00028` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=1779 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00029`
--

DROP TABLE IF EXISTS `HIST00029`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00029` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=1274452 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00030`
--

DROP TABLE IF EXISTS `HIST00030`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00030` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=38236 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00031`
--

DROP TABLE IF EXISTS `HIST00031`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00031` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=18899 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00032`
--

DROP TABLE IF EXISTS `HIST00032`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00032` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=25963 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00033`
--

DROP TABLE IF EXISTS `HIST00033`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00033` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=24948 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00034`
--

DROP TABLE IF EXISTS `HIST00034`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00034` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=9438 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00035`
--

DROP TABLE IF EXISTS `HIST00035`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00035` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=16426 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00036`
--

DROP TABLE IF EXISTS `HIST00036`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00036` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=14594 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00037`
--

DROP TABLE IF EXISTS `HIST00037`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00037` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_DBM_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_DBM_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(10) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=13177 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00038`
--

DROP TABLE IF EXISTS `HIST00038`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00038` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `BATTERY` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_DBM_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_DBM_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00039`
--

DROP TABLE IF EXISTS `HIST00039`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00039` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `BATTERY` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_DBM_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_DBM_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00040`
--

DROP TABLE IF EXISTS `HIST00040`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00040` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `BATTERY` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_DBM_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_DBM_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=4386 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST00041`
--

DROP TABLE IF EXISTS `HIST00041`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST00041` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_DBM_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_DBM_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` varchar(10) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=2355 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HIST1143`
--

DROP TABLE IF EXISTS `HIST1143`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST1143` (
  `COD_ENTITY` decimal(10,0) NOT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(10) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(1) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) NOT NULL,
  `DIG_OUTPUT` varchar(10) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) NOT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_HISTORY` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`COD_HISTORY`),
  KEY `HIST1143_FECHA_SAVE` (`FECHA_SAVE`),
  KEY `REF_HIST01144_IN_FECHA` (`GPS_DATETIME`),
  KEY `HIST1143_EVENTOS` (`COD_HISTORY`,`COD_ENTITY`,`COD_EVENT`,`GPS_DATETIME`),
  KEY `HIST1143_COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`)
) ENGINE=MyISAM AUTO_INCREMENT=163954 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`sa`@`%`*/ /*!50003 TRIGGER `INSERTA_LOCK` AFTER INSERT ON HIST1143 FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
BEGIN

INSERT INTO HIST1143_LOCK (
        COD_HISTORY,
        COD_ENTITY,
        COD_EVENT,
        LIBRE,
        FECHA_SAVE,
        LATITUD,
        LONGITUD,
        VELOCITY,
        GPS_DATETIME)
      VALUES (
        NEW.COD_HISTORY,
        NEW.COD_ENTITY,
        NEW.COD_EVENT,
        'S',
        CURRENT_TIMESTAMP,
        NEW.LATITUDE,
        NEW.LONGITUDE,
        NEW.VELOCITY,
        NEW.GPS_DATETIME);
        END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `HIST1143_LOCK`
--

DROP TABLE IF EXISTS `HIST1143_LOCK`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `HIST1143_LOCK` (
  `COD_HISTORY` decimal(10,0) NOT NULL,
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `ID_USUARIO` int(11) DEFAULT NULL,
  `BLOQUEADO` datetime DEFAULT NULL,
  `LIBRE` enum('S','N') DEFAULT 'S',
  `FECHA_SAVE` datetime DEFAULT NULL,
  `LATITUD` decimal(12,6) DEFAULT NULL,
  `LONGITUD` decimal(12,6) DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `DIRECCION` varchar(60) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `PUBLISHED` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`COD_HISTORY`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `LIBRE` (`LIBRE`),
  KEY `COD_ENTITY` (`COD_ENTITY`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=43;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00000`
--

DROP TABLE IF EXISTS `LAST00000`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00000` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` timestamp NULL DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` timestamp NULL DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_DBM_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_DBM_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` varchar(10) DEFAULT NULL COMMENT '0 GPS; 1 RADIOBASE; 2 RADIOBASE Y GPS; 3 WIFI; 4 WIFI Y GPS; 5 RADIOBASE Y WIFI; 6 RADIOBASE, WIFI Y GPS',
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=704106 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00001`
--

DROP TABLE IF EXISTS `LAST00001`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00001` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_DBM_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_DBM_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` varchar(10) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=12886 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00019`
--

DROP TABLE IF EXISTS `LAST00019`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00019` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` varchar(10) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=29197 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00020`
--

DROP TABLE IF EXISTS `LAST00020`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00020` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(1) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=507121 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00021`
--

DROP TABLE IF EXISTS `LAST00021`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00021` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=497956 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00023`
--

DROP TABLE IF EXISTS `LAST00023`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00023` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=1692611 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00024`
--

DROP TABLE IF EXISTS `LAST00024`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00024` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=345930 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00025`
--

DROP TABLE IF EXISTS `LAST00025`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00025` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=65851 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00026`
--

DROP TABLE IF EXISTS `LAST00026`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00026` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=3487 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00027`
--

DROP TABLE IF EXISTS `LAST00027`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00027` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00028`
--

DROP TABLE IF EXISTS `LAST00028`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00028` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=1779 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00029`
--

DROP TABLE IF EXISTS `LAST00029`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00029` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=1274441 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00030`
--

DROP TABLE IF EXISTS `LAST00030`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00030` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=38236 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00031`
--

DROP TABLE IF EXISTS `LAST00031`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00031` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=18899 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00032`
--

DROP TABLE IF EXISTS `LAST00032`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00032` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=25483 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00033`
--

DROP TABLE IF EXISTS `LAST00033`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00033` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=24947 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00034`
--

DROP TABLE IF EXISTS `LAST00034`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00034` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=9438 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00035`
--

DROP TABLE IF EXISTS `LAST00035`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00035` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=16426 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00036`
--

DROP TABLE IF EXISTS `LAST00036`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00036` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_RSSI_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_RSSI_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=14593 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00037`
--

DROP TABLE IF EXISTS `LAST00037`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00037` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_DBM_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_DBM_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=13151 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00038`
--

DROP TABLE IF EXISTS `LAST00038`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00038` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `BATTERY` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_DBM_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_DBM_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00039`
--

DROP TABLE IF EXISTS `LAST00039`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00039` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `BATTERY` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_DBM_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_DBM_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00040`
--

DROP TABLE IF EXISTS `LAST00040`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00040` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `BATTERY` int(11) DEFAULT NULL,
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_DBM_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_DBM_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` int(1) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LAST00041`
--

DROP TABLE IF EXISTS `LAST00041`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LAST00041` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_OBJECT_MAP` decimal(10,0) DEFAULT NULL,
  `COD_UID_ADDRESS` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` datetime DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `DIG_INPUT` varchar(20) DEFAULT NULL,
  `ANA_INPUT` varchar(35) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FLAG_EVALUATED_EE` decimal(1,0) DEFAULT NULL,
  `DIG_OUTPUT` varchar(20) DEFAULT NULL,
  `ANA_OUTPUT` varchar(35) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EVENT_EQUIPMENT_HARDWARE` decimal(10,0) DEFAULT NULL,
  `FECHA_SAVE` datetime DEFAULT NULL,
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_LAST_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `EANA1` varchar(20) DEFAULT NULL,
  `EANA2` varchar(20) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `COD_PAIS` varchar(3) DEFAULT NULL,
  `OPERADORA_TEL` varchar(3) DEFAULT NULL,
  `COD_AREA_LOCAL` varchar(16) DEFAULT NULL,
  `COD_CELDA` varchar(16) DEFAULT NULL,
  `NIVEL_SENAL` int(11) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `BATTERY` int(2) DEFAULT '0',
  `GL_GCI` int(14) DEFAULT NULL,
  `GL_DBM_C` int(11) DEFAULT NULL,
  `GL_MAC_ADD` varchar(30) DEFAULT NULL,
  `GL_DBM_W` int(11) DEFAULT NULL,
  `GL_TYPE_LOC` varchar(10) DEFAULT NULL,
  `GL_RADIO_ERROR` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_LAST_PACKAGE`),
  UNIQUE KEY `COD_LAST_PACKAGE` (`COD_LAST_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_EVENT_EQUIPMENT_HARDWARE` (`COD_EVENT_EQUIPMENT_HARDWARE`),
  KEY `COD_OBJECT_MAP` (`COD_OBJECT_MAP`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`)
) ENGINE=MyISAM AUTO_INCREMENT=2355 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SAVL1470`
--

DROP TABLE IF EXISTS `SAVL1470`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SAVL1470` (
  `COD_TABLE` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPTION` varchar(50) DEFAULT NULL,
  `FLAG_TABLE_USER` int(1) DEFAULT '0',
  `COD_USER` int(11) DEFAULT NULL,
  `ID_CLIENTE` int(11) DEFAULT NULL,
  `LAST_CONNECT_USER` datetime DEFAULT NULL COMMENT 'FECHAHORA DE LA LTIMA CONEXIN',
  `FLAG_CONNECT_USER` int(1) DEFAULT NULL COMMENT '1 SI ESTA CONECTADO, 0 SI CERRO LA CONSOLA',
  `INSTANCIA_SH` int(11) NOT NULL,
  PRIMARY KEY (`COD_TABLE`),
  KEY `COD_USER` (`COD_USER`),
  KEY `COD_FLEET` (`ID_CLIENTE`),
  KEY `DESCRIPTION` (`DESCRIPTION`),
  KEY `FLAG_CONNECT` (`FLAG_CONNECT_USER`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SAVL1471`
--

DROP TABLE IF EXISTS `SAVL1471`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SAVL1471` (
  `COD_TABLE` int(11) NOT NULL AUTO_INCREMENT,
  `NAME_TABLE` varchar(50) DEFAULT NULL,
  `DESCRIPTION_TABLE` varchar(50) DEFAULT NULL,
  `SQL_CREATE_TABLE` varchar(2000) DEFAULT NULL,
  `SQL_ALTER_TABLE` text,
  PRIMARY KEY (`COD_TABLE`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SRV_CONTACTO_CALIFICACION`
--

DROP TABLE IF EXISTS `SRV_CONTACTO_CALIFICACION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SRV_CONTACTO_CALIFICACION` (
  `ID_CALIFICACION` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(45) NOT NULL,
  `PONDERACION` int(11) NOT NULL,
  PRIMARY KEY (`ID_CALIFICACION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SRV_CONTACTO_LLAMADA`
--

DROP TABLE IF EXISTS `SRV_CONTACTO_LLAMADA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SRV_CONTACTO_LLAMADA` (
  `ID_LLAMADA` int(11) NOT NULL AUTO_INCREMENT,
  `COD_ORDER_SERVICE` int(11) NOT NULL,
  `ID_CONTACTO` int(11) NOT NULL,
  `ID_CALIFICACION` int(11) NOT NULL,
  `ID_FORMA` int(11) DEFAULT NULL,
  `CONTACTADO` datetime DEFAULT NULL,
  `NOTIFICACION` enum('S','N') DEFAULT NULL,
  `TIEMPO_LLAMADA` time DEFAULT NULL,
  `COMENTARIO` text,
  PRIMARY KEY (`ID_LLAMADA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SRV_ESTATUS`
--

DROP TABLE IF EXISTS `SRV_ESTATUS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SRV_ESTATUS` (
  `ID_ESTATUS` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(60) NOT NULL,
  `CIERRE` enum('S','N') NOT NULL,
  PRIMARY KEY (`ID_ESTATUS`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SRV_ID_GEN`
--

DROP TABLE IF EXISTS `SRV_ID_GEN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SRV_ID_GEN` (
  `COD_ORDER_SERVICE` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`COD_ORDER_SERVICE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=7 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SRV_ORDENES`
--

DROP TABLE IF EXISTS `SRV_ORDENES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SRV_ORDENES` (
  `COD_ORDER_SERVICE` int(11) NOT NULL,
  `ID_CLIENTE` int(11) DEFAULT NULL,
  `ID_ESTATUS` int(11) NOT NULL,
  `ID_USUARIO_ABRIO` int(11) NOT NULL,
  `ID_TIPO` int(11) NOT NULL,
  `FECHA_CONTACTO` datetime DEFAULT NULL,
  `NOTIFICACION_CIERRE` enum('S','N') DEFAULT NULL,
  `ID_USUARIO_CERRO` int(11) DEFAULT NULL,
  `FECHA_BUSQUEDA` datetime DEFAULT NULL,
  `CREADO` datetime DEFAULT NULL,
  `FECHA_CIERRE` datetime DEFAULT NULL,
  `FECHA_VALIDACION` datetime DEFAULT NULL,
  PRIMARY KEY (`COD_ORDER_SERVICE`),
  KEY `ID_ESTATUS` (`ID_ESTATUS`),
  KEY `CREADO` (`CREADO`),
  KEY `ID_USUARIO_ABRIO` (`ID_USUARIO_ABRIO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT=' /* comment truncated */ /*ORDENES DE SERVICIO*/';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SRV_ORDENES_EVENTOS`
--

DROP TABLE IF EXISTS `SRV_ORDENES_EVENTOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SRV_ORDENES_EVENTOS` (
  `COD_DET_ORDER_SERVICE` int(11) NOT NULL AUTO_INCREMENT,
  `COD_ORDER_SERVICE` int(11) NOT NULL,
  `COD_HISTORY` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_DET_ORDER_SERVICE`),
  KEY `COD_ORDER_SERVICE` (`COD_ORDER_SERVICE`),
  KEY `COD_HISTORY` (`COD_HISTORY`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT=' /* comment truncated */ /*EVENTOS ATENDIDOS X SERVICIO*/';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SRV_ORDENES_NOTAS`
--

DROP TABLE IF EXISTS `SRV_ORDENES_NOTAS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SRV_ORDENES_NOTAS` (
  `ID_COMENTARIO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int(11) NOT NULL,
  `COD_ORDER_SERVICE` int(11) NOT NULL,
  `COMENTARIOS` text NOT NULL,
  `CREADO` datetime NOT NULL,
  PRIMARY KEY (`ID_COMENTARIO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SRV_TIPO`
--

DROP TABLE IF EXISTS `SRV_TIPO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SRV_TIPO` (
  `ID_TIPO` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(45) NOT NULL,
  `FORMULARIO` text NOT NULL,
  `SCRIPT` text NOT NULL,
  PRIMARY KEY (`ID_TIPO`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SRV_USUARIOS`
--

DROP TABLE IF EXISTS `SRV_USUARIOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SRV_USUARIOS` (
  `ID_SERV_USUARIOS` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int(11) DEFAULT NULL,
  `TIPO_USUARIO` enum('M','S') DEFAULT NULL COMMENT 'M=MONITORISTA, S=SUPERVISOR',
  PRIMARY KEY (`ID_SERV_USUARIOS`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ZZ_SPM_CIUDADES`
--

DROP TABLE IF EXISTS `ZZ_SPM_CIUDADES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ZZ_SPM_CIUDADES` (
  `ID_CIUDAD` int(11) NOT NULL DEFAULT '0',
  `ID_ESTADO` int(11) NOT NULL DEFAULT '0',
  `NOMBRE` varchar(40) DEFAULT NULL,
  `RANGO1` int(11) DEFAULT NULL,
  `RANGO2` int(11) DEFAULT NULL,
  `RANGO3` int(11) DEFAULT NULL,
  `RANGO4` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_CIUDAD`,`ID_ESTADO`),
  UNIQUE KEY `XAK1ZZ_SPM_CIUDADES` (`ID_CIUDAD`,`ID_ESTADO`),
  KEY `NOMBRE` (`NOMBRE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ZZ_SPM_COLONIAS`
--

DROP TABLE IF EXISTS `ZZ_SPM_COLONIAS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ZZ_SPM_COLONIAS` (
  `ID_COLONIA` int(11) NOT NULL DEFAULT '0',
  `ID_ESTADO` int(11) NOT NULL DEFAULT '0',
  `ID_CLASE` char(2) NOT NULL DEFAULT '',
  `ID_CIUDAD` int(11) NOT NULL DEFAULT '0',
  `ID_MUNICIPIO` int(11) NOT NULL DEFAULT '0',
  `NOMBRE` varchar(60) NOT NULL DEFAULT '',
  `REPARTO` char(1) DEFAULT NULL,
  `SERVICIOS` char(1) DEFAULT NULL,
  `OFICINA` int(11) DEFAULT NULL,
  `ID_ASENTAMIENTO` char(2) NOT NULL DEFAULT '',
  `CODIGO` int(11) DEFAULT NULL,
  `COR` int(11) DEFAULT NULL,
  `ACTUALIZADO` date DEFAULT NULL,
  `ZONA` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_COLONIA`,`ID_ESTADO`),
  UNIQUE KEY `XAK1ZZ_SPM_COLONIAS` (`ID_ESTADO`,`ID_COLONIA`),
  KEY `NOMBRE` (`NOMBRE`),
  KEY `CODIGO` (`CODIGO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ZZ_SPM_ENTIDADES`
--

DROP TABLE IF EXISTS `ZZ_SPM_ENTIDADES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ZZ_SPM_ENTIDADES` (
  `ID_ESTADO` int(11) NOT NULL DEFAULT '0',
  `NOMBRE` varchar(20) NOT NULL DEFAULT '',
  `ABREVIATURA` varchar(6) DEFAULT NULL,
  `RANGO_INI` int(11) NOT NULL DEFAULT '0',
  `RANGO_FIN` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_ESTADO`),
  KEY `NOMBRE` (`NOMBRE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ZZ_SPM_MUNICIPIOS`
--

DROP TABLE IF EXISTS `ZZ_SPM_MUNICIPIOS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ZZ_SPM_MUNICIPIOS` (
  `ID_MUNICIPIO` int(11) NOT NULL DEFAULT '0',
  `ID_ESTADO` int(11) NOT NULL DEFAULT '0',
  `NOMBRE` varchar(36) DEFAULT NULL,
  `RANGO1` int(11) DEFAULT NULL,
  `RANGO2` int(11) DEFAULT NULL,
  `RANGO3` int(11) DEFAULT NULL,
  `RANGO4` int(11) DEFAULT NULL,
  `RANGO5` int(11) DEFAULT NULL,
  `RANGO6` int(11) DEFAULT NULL,
  `RANGO7` int(11) DEFAULT NULL,
  `RANGO8` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_MUNICIPIO`,`ID_ESTADO`),
  UNIQUE KEY `XAK1ZZ_SPM_MUNICIPIOS` (`ID_ESTADO`,`ID_MUNICIPIO`),
  KEY `NOMBRE` (`NOMBRE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-10-01 18:20:21
