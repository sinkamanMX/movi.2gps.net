-- MySQL dump 10.13  Distrib 5.1.69, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: ALG_BD_CORPORATE_ALERTAS_MOVI
-- ------------------------------------------------------
-- Server version	5.1.69

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
-- Table structure for table `ALERTENTITY019827`
--

DROP TABLE IF EXISTS `ALERTENTITY019827`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ALERTENTITY019827` (
  `COD_FLEET` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` timestamp NULL DEFAULT NULL,
  `geo_descrip` varchar(30) DEFAULT NULL,
  `geo_in` decimal(1,0) DEFAULT NULL,
  `geo_on` decimal(1,0) DEFAULT NULL,
  `geo_out` decimal(1,0) DEFAULT NULL,
  `geo_pk` decimal(10,0) DEFAULT NULL,
  `time_geo` decimal(3,0) DEFAULT NULL,
  `pdi_descrip` varchar(30) DEFAULT NULL,
  `pdi_in` decimal(1,0) DEFAULT NULL,
  `pdi_on` decimal(1,0) DEFAULT NULL,
  `pdi_out` decimal(1,0) DEFAULT NULL,
  `pdi_pk` decimal(10,0) DEFAULT NULL,
  `time_pdi` decimal(3,0) DEFAULT NULL,
  `pk_rsi` decimal(10,0) DEFAULT NULL,
  `rsi_begin` decimal(1,0) DEFAULT NULL,
  `rsi_cancel` decimal(1,0) DEFAULT NULL,
  `rsi_descrip` varchar(30) DEFAULT NULL,
  `rsi_detalle_descrip` varchar(40) DEFAULT NULL,
  `rsi_distance_acumulate_km` decimal(10,0) DEFAULT NULL,
  `rsi_distance_less_km` decimal(10,0) DEFAULT NULL,
  `rsi_end` decimal(1,0) DEFAULT NULL,
  `rsi_in` decimal(1,0) DEFAULT NULL,
  `rsi_last_status` decimal(1,0) DEFAULT NULL,
  `rsi_on` decimal(1,0) DEFAULT NULL,
  `rsi_order_apparition` decimal(10,0) DEFAULT NULL,
  `rsi_out` decimal(1,0) DEFAULT NULL,
  `rsi_percent_progress` decimal(5,0) DEFAULT NULL,
  `rsi_reverse` decimal(1,0) DEFAULT NULL,
  `rsi_type_point_rsi` decimal(2,0) DEFAULT NULL,
  `time_out_rsi` decimal(3,0) DEFAULT NULL,
  `time_rsi` decimal(3,0) DEFAULT NULL,
  `ana_in1` decimal(6,0) DEFAULT NULL,
  `ana_in2` decimal(6,0) DEFAULT NULL,
  `ana_in3` decimal(6,0) DEFAULT NULL,
  `ana_in4` decimal(6,0) DEFAULT NULL,
  `time_exceso_vel` decimal(3,0) DEFAULT NULL,
  `time_motor_off` decimal(3,0) DEFAULT NULL,
  `time_motor_on` decimal(3,0) DEFAULT NULL,
  `time_move` decimal(3,0) DEFAULT NULL,
  `time_stop_all` decimal(3,0) DEFAULT NULL,
  `time_stop_motor_on` decimal(3,0) DEFAULT NULL,
  `uni_descrip_event` varchar(30) DEFAULT NULL,
  `uni_descrip_flota` varchar(30) DEFAULT NULL,
  `uni_descrip_gral` varchar(30) DEFAULT NULL,
  `uni_pk_event` decimal(10,0) DEFAULT NULL,
  `uni_prio_event` decimal(1,0) DEFAULT NULL,
  `uni_status_gps` varchar(2) DEFAULT NULL,
  `uni_status_motor` varchar(3) DEFAULT NULL,
  `uni_vel_stop` decimal(3,0) DEFAULT NULL,
  `uni_vel_tope` decimal(3,0) DEFAULT NULL,
  `uni_velocidad` decimal(7,0) DEFAULT NULL,
  `latitude` decimal(12,6) DEFAULT NULL,
  `longitude` decimal(12,6) DEFAULT NULL,
  `COD_ALERT_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `uni_pk_flota` int(11) NOT NULL,
  `uni_pk_gral` int(11) NOT NULL,
  `COD_ENTITY` int(11) NOT NULL,
  PRIMARY KEY (`COD_ALERT_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_ALERT_HISTORY`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALERTENTITY019827`
--

LOCK TABLES `ALERTENTITY019827` WRITE;
/*!40000 ALTER TABLE `ALERTENTITY019827` DISABLE KEYS */;
/*!40000 ALTER TABLE `ALERTENTITY019827` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ALERTENTITY019844`
--

DROP TABLE IF EXISTS `ALERTENTITY019844`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ALERTENTITY019844` (
  `COD_FLEET` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` timestamp NULL DEFAULT NULL,
  `geo_descrip` varchar(30) DEFAULT NULL,
  `geo_in` decimal(1,0) DEFAULT NULL,
  `geo_on` decimal(1,0) DEFAULT NULL,
  `geo_out` decimal(1,0) DEFAULT NULL,
  `geo_pk` decimal(10,0) DEFAULT NULL,
  `time_geo` decimal(3,0) DEFAULT NULL,
  `pdi_descrip` varchar(30) DEFAULT NULL,
  `pdi_in` decimal(1,0) DEFAULT NULL,
  `pdi_on` decimal(1,0) DEFAULT NULL,
  `pdi_out` decimal(1,0) DEFAULT NULL,
  `pdi_pk` decimal(10,0) DEFAULT NULL,
  `time_pdi` decimal(3,0) DEFAULT NULL,
  `pk_rsi` decimal(10,0) DEFAULT NULL,
  `rsi_begin` decimal(1,0) DEFAULT NULL,
  `rsi_cancel` decimal(1,0) DEFAULT NULL,
  `rsi_descrip` varchar(30) DEFAULT NULL,
  `rsi_detalle_descrip` varchar(40) DEFAULT NULL,
  `rsi_distance_acumulate_km` decimal(10,0) DEFAULT NULL,
  `rsi_distance_less_km` decimal(10,0) DEFAULT NULL,
  `rsi_end` decimal(1,0) DEFAULT NULL,
  `rsi_in` decimal(1,0) DEFAULT NULL,
  `rsi_last_status` decimal(1,0) DEFAULT NULL,
  `rsi_on` decimal(1,0) DEFAULT NULL,
  `rsi_order_apparition` decimal(10,0) DEFAULT NULL,
  `rsi_out` decimal(1,0) DEFAULT NULL,
  `rsi_percent_progress` decimal(5,0) DEFAULT NULL,
  `rsi_reverse` decimal(1,0) DEFAULT NULL,
  `rsi_type_point_rsi` decimal(2,0) DEFAULT NULL,
  `time_out_rsi` decimal(3,0) DEFAULT NULL,
  `time_rsi` decimal(3,0) DEFAULT NULL,
  `ana_in1` decimal(6,0) DEFAULT NULL,
  `ana_in2` decimal(6,0) DEFAULT NULL,
  `ana_in3` decimal(6,0) DEFAULT NULL,
  `ana_in4` decimal(6,0) DEFAULT NULL,
  `time_exceso_vel` decimal(3,0) DEFAULT NULL,
  `time_motor_off` decimal(3,0) DEFAULT NULL,
  `time_motor_on` decimal(3,0) DEFAULT NULL,
  `time_move` decimal(3,0) DEFAULT NULL,
  `time_stop_all` decimal(3,0) DEFAULT NULL,
  `time_stop_motor_on` decimal(3,0) DEFAULT NULL,
  `uni_descrip_event` varchar(30) DEFAULT NULL,
  `uni_descrip_flota` varchar(30) DEFAULT NULL,
  `uni_descrip_gral` varchar(30) DEFAULT NULL,
  `uni_pk_event` decimal(10,0) DEFAULT NULL,
  `uni_prio_event` decimal(1,0) DEFAULT NULL,
  `uni_status_gps` varchar(2) DEFAULT NULL,
  `uni_status_motor` varchar(3) DEFAULT NULL,
  `uni_vel_stop` decimal(3,0) DEFAULT NULL,
  `uni_vel_tope` decimal(3,0) DEFAULT NULL,
  `uni_velocidad` decimal(7,0) DEFAULT NULL,
  `latitude` decimal(12,6) DEFAULT NULL,
  `longitude` decimal(12,6) DEFAULT NULL,
  `COD_ALERT_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `uni_pk_flota` int(11) NOT NULL,
  `uni_pk_gral` int(11) NOT NULL,
  `COD_ENTITY` int(11) NOT NULL,
  PRIMARY KEY (`COD_ALERT_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_ALERT_HISTORY`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALERTENTITY019844`
--

LOCK TABLES `ALERTENTITY019844` WRITE;
/*!40000 ALTER TABLE `ALERTENTITY019844` DISABLE KEYS */;
/*!40000 ALTER TABLE `ALERTENTITY019844` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ALERTLAST019827`
--

DROP TABLE IF EXISTS `ALERTLAST019827`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ALERTLAST019827` (
  `COD_FLEET` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` timestamp NULL DEFAULT NULL,
  `geo_descrip` varchar(30) DEFAULT NULL,
  `geo_in` decimal(1,0) DEFAULT NULL,
  `geo_on` decimal(1,0) DEFAULT NULL,
  `geo_out` decimal(1,0) DEFAULT NULL,
  `geo_pk` decimal(10,0) DEFAULT NULL,
  `time_geo` decimal(3,0) DEFAULT NULL,
  `pdi_descrip` varchar(30) DEFAULT NULL,
  `pdi_in` decimal(1,0) DEFAULT NULL,
  `pdi_on` decimal(1,0) DEFAULT NULL,
  `pdi_out` decimal(1,0) DEFAULT NULL,
  `pdi_pk` decimal(10,0) DEFAULT NULL,
  `time_pdi` decimal(3,0) DEFAULT NULL,
  `pk_rsi` decimal(10,0) DEFAULT NULL,
  `rsi_begin` decimal(1,0) DEFAULT NULL,
  `rsi_cancel` decimal(1,0) DEFAULT NULL,
  `rsi_descrip` varchar(30) DEFAULT NULL,
  `rsi_detalle_descrip` varchar(40) DEFAULT NULL,
  `rsi_distance_acumulate_km` decimal(10,0) DEFAULT NULL,
  `rsi_distance_less_km` decimal(10,0) DEFAULT NULL,
  `rsi_end` decimal(1,0) DEFAULT NULL,
  `rsi_in` decimal(1,0) DEFAULT NULL,
  `rsi_last_status` decimal(1,0) DEFAULT NULL,
  `rsi_on` decimal(1,0) DEFAULT NULL,
  `rsi_order_apparition` decimal(10,0) DEFAULT NULL,
  `rsi_out` decimal(1,0) DEFAULT NULL,
  `rsi_percent_progress` decimal(5,0) DEFAULT NULL,
  `rsi_reverse` decimal(1,0) DEFAULT NULL,
  `rsi_type_point_rsi` decimal(2,0) DEFAULT NULL,
  `time_out_rsi` decimal(3,0) DEFAULT NULL,
  `time_rsi` decimal(3,0) DEFAULT NULL,
  `ana_in1` decimal(6,0) DEFAULT NULL,
  `ana_in2` decimal(6,0) DEFAULT NULL,
  `ana_in3` decimal(6,0) DEFAULT NULL,
  `ana_in4` decimal(6,0) DEFAULT NULL,
  `time_exceso_vel` decimal(3,0) DEFAULT NULL,
  `time_motor_off` decimal(3,0) DEFAULT NULL,
  `time_motor_on` decimal(3,0) DEFAULT NULL,
  `time_move` decimal(3,0) DEFAULT NULL,
  `time_stop_all` decimal(3,0) DEFAULT NULL,
  `time_stop_motor_on` decimal(3,0) DEFAULT NULL,
  `uni_descrip_event` varchar(30) DEFAULT NULL,
  `uni_descrip_flota` varchar(30) DEFAULT NULL,
  `uni_descrip_gral` varchar(30) DEFAULT NULL,
  `uni_pk_event` decimal(10,0) DEFAULT NULL,
  `uni_prio_event` decimal(1,0) DEFAULT NULL,
  `uni_status_gps` varchar(2) DEFAULT NULL,
  `uni_status_motor` varchar(3) DEFAULT NULL,
  `uni_vel_stop` decimal(3,0) DEFAULT NULL,
  `uni_vel_tope` decimal(3,0) DEFAULT NULL,
  `uni_velocidad` decimal(7,0) DEFAULT NULL,
  `latitude` decimal(12,6) DEFAULT NULL,
  `longitude` decimal(12,6) DEFAULT NULL,
  `COD_ALERT_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `uni_pk_flota` int(11) NOT NULL,
  `uni_pk_gral` int(11) NOT NULL,
  `COD_ENTITY` int(11) NOT NULL,
  PRIMARY KEY (`COD_ALERT_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_ALERT_HISTORY`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALERTLAST019827`
--

LOCK TABLES `ALERTLAST019827` WRITE;
/*!40000 ALTER TABLE `ALERTLAST019827` DISABLE KEYS */;
/*!40000 ALTER TABLE `ALERTLAST019827` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ALERTLAST019844`
--

DROP TABLE IF EXISTS `ALERTLAST019844`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ALERTLAST019844` (
  `COD_FLEET` decimal(10,0) DEFAULT NULL,
  `GPS_DATETIME` timestamp NULL DEFAULT NULL,
  `geo_descrip` varchar(30) DEFAULT NULL,
  `geo_in` decimal(1,0) DEFAULT NULL,
  `geo_on` decimal(1,0) DEFAULT NULL,
  `geo_out` decimal(1,0) DEFAULT NULL,
  `geo_pk` decimal(10,0) DEFAULT NULL,
  `time_geo` decimal(3,0) DEFAULT NULL,
  `pdi_descrip` varchar(30) DEFAULT NULL,
  `pdi_in` decimal(1,0) DEFAULT NULL,
  `pdi_on` decimal(1,0) DEFAULT NULL,
  `pdi_out` decimal(1,0) DEFAULT NULL,
  `pdi_pk` decimal(10,0) DEFAULT NULL,
  `time_pdi` decimal(3,0) DEFAULT NULL,
  `pk_rsi` decimal(10,0) DEFAULT NULL,
  `rsi_begin` decimal(1,0) DEFAULT NULL,
  `rsi_cancel` decimal(1,0) DEFAULT NULL,
  `rsi_descrip` varchar(30) DEFAULT NULL,
  `rsi_detalle_descrip` varchar(40) DEFAULT NULL,
  `rsi_distance_acumulate_km` decimal(10,0) DEFAULT NULL,
  `rsi_distance_less_km` decimal(10,0) DEFAULT NULL,
  `rsi_end` decimal(1,0) DEFAULT NULL,
  `rsi_in` decimal(1,0) DEFAULT NULL,
  `rsi_last_status` decimal(1,0) DEFAULT NULL,
  `rsi_on` decimal(1,0) DEFAULT NULL,
  `rsi_order_apparition` decimal(10,0) DEFAULT NULL,
  `rsi_out` decimal(1,0) DEFAULT NULL,
  `rsi_percent_progress` decimal(5,0) DEFAULT NULL,
  `rsi_reverse` decimal(1,0) DEFAULT NULL,
  `rsi_type_point_rsi` decimal(2,0) DEFAULT NULL,
  `time_out_rsi` decimal(3,0) DEFAULT NULL,
  `time_rsi` decimal(3,0) DEFAULT NULL,
  `ana_in1` decimal(6,0) DEFAULT NULL,
  `ana_in2` decimal(6,0) DEFAULT NULL,
  `ana_in3` decimal(6,0) DEFAULT NULL,
  `ana_in4` decimal(6,0) DEFAULT NULL,
  `time_exceso_vel` decimal(3,0) DEFAULT NULL,
  `time_motor_off` decimal(3,0) DEFAULT NULL,
  `time_motor_on` decimal(3,0) DEFAULT NULL,
  `time_move` decimal(3,0) DEFAULT NULL,
  `time_stop_all` decimal(3,0) DEFAULT NULL,
  `time_stop_motor_on` decimal(3,0) DEFAULT NULL,
  `uni_descrip_event` varchar(30) DEFAULT NULL,
  `uni_descrip_flota` varchar(30) DEFAULT NULL,
  `uni_descrip_gral` varchar(30) DEFAULT NULL,
  `uni_pk_event` decimal(10,0) DEFAULT NULL,
  `uni_prio_event` decimal(1,0) DEFAULT NULL,
  `uni_status_gps` varchar(2) DEFAULT NULL,
  `uni_status_motor` varchar(3) DEFAULT NULL,
  `uni_vel_stop` decimal(3,0) DEFAULT NULL,
  `uni_vel_tope` decimal(3,0) DEFAULT NULL,
  `uni_velocidad` decimal(7,0) DEFAULT NULL,
  `latitude` decimal(12,6) DEFAULT NULL,
  `longitude` decimal(12,6) DEFAULT NULL,
  `COD_ALERT_HISTORY` int(20) NOT NULL AUTO_INCREMENT,
  `uni_pk_flota` int(11) NOT NULL,
  `uni_pk_gral` int(11) NOT NULL,
  `COD_ENTITY` int(11) NOT NULL,
  PRIMARY KEY (`COD_ALERT_HISTORY`),
  UNIQUE KEY `COD_HISTORY` (`COD_ALERT_HISTORY`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALERTLAST019844`
--

LOCK TABLES `ALERTLAST019844` WRITE;
/*!40000 ALTER TABLE `ALERTLAST019844` DISABLE KEYS */;
/*!40000 ALTER TABLE `ALERTLAST019844` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ALERT_DETAIL_VARIABLES`
--

DROP TABLE IF EXISTS `ALERT_DETAIL_VARIABLES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ALERT_DETAIL_VARIABLES` (
  `COD_ALERT_ENTITY` int(20) NOT NULL AUTO_INCREMENT,
  `COD_ALERT_MASTER` int(11) NOT NULL,
  `COD_FLEET` decimal(10,0) DEFAULT '0',
  `COD_ENTITY` int(11) NOT NULL,
  `geo_descrip` varchar(30) DEFAULT NULL,
  `geo_in` decimal(1,0) DEFAULT NULL,
  `geo_on` decimal(1,0) DEFAULT NULL,
  `geo_out` decimal(1,0) DEFAULT NULL,
  `geo_pk` decimal(10,0) DEFAULT NULL,
  `time_geo` decimal(3,0) DEFAULT NULL,
  `pdi_descrip` varchar(30) DEFAULT NULL,
  `pdi_in` decimal(1,0) DEFAULT NULL,
  `pdi_on` decimal(1,0) DEFAULT NULL,
  `pdi_out` decimal(1,0) DEFAULT NULL,
  `pdi_pk` decimal(10,0) DEFAULT NULL,
  `time_pdi` decimal(3,0) DEFAULT NULL,
  `pk_rsi` decimal(10,0) DEFAULT NULL,
  `rsi_begin` decimal(1,0) DEFAULT NULL,
  `rsi_cancel` decimal(1,0) DEFAULT NULL,
  `rsi_descrip` varchar(30) DEFAULT NULL,
  `rsi_detalle_descrip` varchar(40) DEFAULT NULL,
  `rsi_distance_acumulate_km` decimal(10,0) DEFAULT NULL,
  `rsi_distance_less_km` decimal(10,0) DEFAULT NULL,
  `rsi_end` decimal(1,0) DEFAULT NULL,
  `rsi_in` decimal(1,0) DEFAULT NULL,
  `rsi_last_status` decimal(1,0) DEFAULT NULL,
  `rsi_on` decimal(1,0) DEFAULT NULL,
  `rsi_order_apparition` decimal(10,0) DEFAULT NULL,
  `rsi_out` decimal(1,0) DEFAULT NULL,
  `rsi_percent_progress` decimal(5,0) DEFAULT NULL,
  `rsi_reverse` decimal(1,0) DEFAULT NULL,
  `rsi_type_point_rsi` decimal(2,0) DEFAULT NULL,
  `time_out_rsi` decimal(3,0) DEFAULT NULL,
  `time_rsi` decimal(3,0) DEFAULT NULL,
  `ana_in1` decimal(6,0) DEFAULT NULL,
  `ana_in2` decimal(6,0) DEFAULT NULL,
  `ana_in3` decimal(6,0) DEFAULT NULL,
  `ana_in4` decimal(6,0) DEFAULT NULL,
  `time_exceso_vel` decimal(3,0) DEFAULT NULL,
  `time_motor_off` decimal(3,0) DEFAULT NULL,
  `time_motor_on` decimal(3,0) DEFAULT NULL,
  `time_move` decimal(3,0) DEFAULT NULL,
  `time_stop_all` decimal(3,0) DEFAULT NULL,
  `time_stop_motor_on` decimal(3,0) DEFAULT NULL,
  `uni_descrip_event` varchar(30) DEFAULT NULL,
  `uni_descrip_flota` varchar(30) DEFAULT NULL,
  `uni_descrip_gral` varchar(30) DEFAULT NULL,
  `uni_pk_event` decimal(10,0) DEFAULT NULL,
  `uni_prio_event` decimal(1,0) DEFAULT NULL,
  `uni_status_gps` varchar(2) DEFAULT NULL,
  `uni_status_motor` varchar(3) DEFAULT NULL,
  `uni_vel_stop` decimal(3,0) DEFAULT NULL,
  `uni_vel_tope` decimal(3,0) DEFAULT NULL,
  `uni_velocidad` decimal(7,0) DEFAULT NULL,
  `latitude` decimal(12,6) DEFAULT NULL,
  `longitude` decimal(12,6) DEFAULT NULL,
  `uni_pk_flota` int(11) NOT NULL,
  `uni_pk_gral` int(11) NOT NULL,
  PRIMARY KEY (`COD_ALERT_ENTITY`),
  UNIQUE KEY `PK_ALERT_ENTITY` (`COD_ALERT_ENTITY`)
) ENGINE=MyISAM AUTO_INCREMENT=8180 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALERT_DETAIL_VARIABLES`
--

LOCK TABLES `ALERT_DETAIL_VARIABLES` WRITE;
/*!40000 ALTER TABLE `ALERT_DETAIL_VARIABLES` DISABLE KEYS */;
INSERT INTO `ALERT_DETAIL_VARIABLES` VALUES (8179,707,'0',19827,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Unidad 1','24',NULL,NULL,NULL,NULL,'10',NULL,NULL,NULL,0,0);
/*!40000 ALTER TABLE `ALERT_DETAIL_VARIABLES` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`sa`@`%`*/ /*!50003 TRIGGER `REGISTRA_UNIDAD` AFTER INSERT ON `ALERT_DETAIL_VARIABLES` FOR EACH ROW BEGIN
  DECLARE VEXISTE INTEGER;
  SELECT COUNT(*) INTO VEXISTE FROM ALERT_UNITY WHERE COD_ENTITY = NEW.COD_ENTITY;
  IF (VEXISTE = 0) THEN 
    INSERT INTO ALERT_UNITY (COD_ENTITY,COD_FLEET,TABLA) VALUES (NEW.COD_ENTITY,NEW.COD_FLEET,0);
  END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `ALERT_DICTIONARY_DATA`
--

DROP TABLE IF EXISTS `ALERT_DICTIONARY_DATA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ALERT_DICTIONARY_DATA` (
  `COD_ALERT_DICT_DATA` int(11) NOT NULL AUTO_INCREMENT,
  `COD_ALERT_DICTIONARY` int(11) NOT NULL,
  `NAME_VARIABLE` varchar(30) DEFAULT NULL COMMENT 'NOMBRE DE LA VARIABLE',
  `VALUE_VARIABLE` varchar(30) DEFAULT NULL COMMENT 'VALOR DE LA VARIABLE',
  `DESCRIP_VARIABLE` varchar(30) DEFAULT NULL COMMENT 'DESCRIPCION DE LA VARIABLE',
  PRIMARY KEY (`COD_ALERT_DICT_DATA`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALERT_DICTIONARY_DATA`
--

LOCK TABLES `ALERT_DICTIONARY_DATA` WRITE;
/*!40000 ALTER TABLE `ALERT_DICTIONARY_DATA` DISABLE KEYS */;
/*!40000 ALTER TABLE `ALERT_DICTIONARY_DATA` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ALERT_DICTIONARY_EXAMPLE_EXPR`
--

DROP TABLE IF EXISTS `ALERT_DICTIONARY_EXAMPLE_EXPR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ALERT_DICTIONARY_EXAMPLE_EXPR` (
  `COD_ALERT_DICT_EXAM_EXP` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIP_EXAMPLE` varchar(100) DEFAULT NULL COMMENT 'DESCRIPCION DEl EJEMPLO',
  `EXP_ALERT_EXAMPLE` text COMMENT 'CON ESTA EXPRESION PODEMOS INCLUIRLE @VAR1, @VAR2, @VARn',
  `EXP_SUBJECT_EXAMPLE` text COMMENT 'ASUNTO DEL CORREO',
  `EXP_EMAIL_EXAMPLE` text COMMENT 'CONTENIDO DEL CORREO',
  `EXP_SMS_EXAMPLE` varchar(300) DEFAULT NULL COMMENT 'SMS SI APLICA',
  `CANT_VARIABLE` int(2) NOT NULL DEFAULT '0',
  `COD_ALERT_DICTIONARY_01` int(11) DEFAULT NULL COMMENT 'VARIABLE 01, DE ESTE CÓDIGO SACAMOS EL NOMBRE Y LA DESCRIPCIÓN',
  `VALUE_VARIABLE_01` varchar(30) DEFAULT NULL COMMENT 'VALOR DE LA VARIABLE 01',
  `COD_ALERT_DICTIONARY_02` int(11) DEFAULT NULL COMMENT 'VARIABLE 02, DE ESTE CÓDIGO SACAMOS EL NOMBRE Y LA DESCRIPCIÓN',
  `VALUE_VARIABLE_02` varchar(30) DEFAULT NULL COMMENT 'VALOR DE LA VARIABLE 02',
  `COD_ALERT_DICTIONARY_03` int(11) DEFAULT NULL COMMENT 'VARIABLE 03, DE ESTE CÓDIGO SACAMOS EL NOMBRE Y LA DESCRIPCIÓN',
  `VALUE_VARIABLE_03` varchar(30) DEFAULT NULL COMMENT 'VALOR DE LA VARIABLE 03',
  `COD_ALERT_DICTIONARY_04` int(11) DEFAULT NULL COMMENT 'VARIABLE 04, DE ESTE CÓDIGO SACAMOS EL NOMBRE Y LA DESCRIPCIÓN',
  `VALUE_VARIABLE_04` varchar(30) DEFAULT NULL COMMENT 'VALOR DE LA VARIABLE 04',
  `COD_ALERT_DICTIONARY_05` int(11) DEFAULT NULL COMMENT 'VARIABLE 05, DE ESTE CÓDIGO SACAMOS EL NOMBRE Y LA DESCRIPCIÓN',
  `VALUE_VARIABLE_05` varchar(30) DEFAULT NULL COMMENT 'VALOR DE LA VARIABLE 05',
  `FLAG_ACTIVE` enum('1','0') DEFAULT NULL COMMENT '1 ACTIVA, 0 INACTIVA',
  PRIMARY KEY (`COD_ALERT_DICT_EXAM_EXP`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALERT_DICTIONARY_EXAMPLE_EXPR`
--

LOCK TABLES `ALERT_DICTIONARY_EXAMPLE_EXPR` WRITE;
/*!40000 ALTER TABLE `ALERT_DICTIONARY_EXAMPLE_EXPR` DISABLE KEYS */;
/*!40000 ALTER TABLE `ALERT_DICTIONARY_EXAMPLE_EXPR` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ALERT_DICTIONARY_EXPRESION`
--

DROP TABLE IF EXISTS `ALERT_DICTIONARY_EXPRESION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ALERT_DICTIONARY_EXPRESION` (
  `COD_ALERT_DICTIONARY` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPTION` varchar(30) DEFAULT NULL,
  `ID_TIPO_VARIABLE` int(11) DEFAULT '0' COMMENT 'P PDI, R RSI, G GEOCERCA, U UNIDAD, T CONTADOR DE TIEMPO, A VARIABLE ANALOGICA',
  `NAME_VARIABLE` varchar(30) DEFAULT NULL COMMENT 'NOMBRE DE LA VARIABLE USADA, EJEMPLO "{EVENT_DESCRIPTION}"',
  `DEPENDENCIA` int(11) NOT NULL,
  `DATASOURCE` varchar(20) NOT NULL,
  `DATA_SQL` varchar(300) NOT NULL,
  `DATA_TYPE` enum('N','S') DEFAULT 'N' COMMENT 'N NUMÉRICO, S STRING',
  `METHOD_CALCULATION` text COMMENT 'AQUI DESCRIBIMOS COMO SE CALCULA ESTA VARIABLE',
  `DIC_DEFAULT_VALUE` varchar(100) DEFAULT NULL COMMENT 'VALORES POR DEFECTO PARA PROBAR LA EXPRESSION',
  `FLAG_TRASICION` enum('0','1') DEFAULT '0',
  `DATA_LEN` int(4) DEFAULT '0',
  `TYPE_EXPRESION` enum('A','T') DEFAULT NULL COMMENT 'VARIABLE DE ALERTA (A)O DE TEXTO (T)',
  `FLAG_ACTIVE` enum('0','1') DEFAULT NULL COMMENT '0 INACTIVA, 1 ACTIVA',
  `EQUAL_CONDITION` varchar(2) DEFAULT NULL COMMENT '=,<>,>=,<=,>,<',
  `COMBINATIONS` varchar(200) NOT NULL,
  `ICONO` varchar(100) NOT NULL,
  PRIMARY KEY (`COD_ALERT_DICTIONARY`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALERT_DICTIONARY_EXPRESION`
--

LOCK TABLES `ALERT_DICTIONARY_EXPRESION` WRITE;
/*!40000 ALTER TABLE `ALERT_DICTIONARY_EXPRESION` DISABLE KEYS */;
INSERT INTO `ALERT_DICTIONARY_EXPRESION` VALUES (7,'INICIO RSI',4,'rsi_begin',0,'','','N','EVENTO DE TRANSICIÓN QUE SE ACTIVA A 1 CUANDO SE TOCA ALGÚN PUNTO DEL RSI','1','1',1,'A','0','=','0','/public/images/pdi_pk.png'),(1,'ENTRADA PDI',1,'pdi_in',4,'OP','0?FALSO;1?VERDADERO','N','ESTA ES UNA VARIABLE DE TRANSICIÓN QUE SE ACTIVA CUANDO LA UNIDAD SE ACERCA A UN PDI A UNA DISTANCIA <= CON EL RADIO','1','1',1,'A','1','=','4x20x30x22','/public/images/pdi_pk.png'),(2,'SALIDA PDI',1,'pdi_out',4,'OP','0?FALSO;1?VERDADERO','N','ESTA ES UNA VARIABLE DE TRANSICIÓN QUE SE ACTIVA CUANDO LA UNIDAD SE ALEJA A UN PDI A UNA DISTANCIA > DEL RADIO','1','1',1,'A','1','=','4x20x30x22','/public/images/pdi_pk.png'),(3,'PERMANENCIA PDI',1,'pdi_on',4,'OP','0?FALSO;1?VERDADERO','N','ES 1 CUANDO LA UNIDAD EL ÚLTIMO PDI ENTRANTE O EL ÚLTIMO PDI ES EL MISMO QUE EL ACTUAL PDI','1','0',1,'A','1','=','4x20x27x30x31x32x33x34x36x22','/public/images/pdi_pk.png'),(4,'CLAVE PDI',1,'pdi_pk',0,'BD','SELECT ID_OBJECT_MAP AS ID, DESCRIPCION AS DESCRIPTION FROM ADM_GEOREFERENCIAS WHERE ID_CLIENTE = $cliente AND TIPO =  \\\'P\\\'','N','CLAVE ÚNICA DEL PDI','1','0',10,'A','1','=','1x2x3x20x30x22x33x27x31x32x34x36','/public/images/pdi_pk.png'),(5,'NOMBRE PDI',1,'pdi_descrip',4,'','','S','DESCRIPCIÓN DEL PDI, NORMALMENTE USADO PARA ARMAR LA RESPUESTA DEL CORREO','PDI X','0',30,'T','0','=','0','/public/images/pdi_pk.png'),(8,'CANCELACION RSI',4,'rsi_cancel',0,'','','N','EVENTO DE TRANSICIÓN QUE SE ACTIVA A 1 CUANDO SE ALEJA LA DISTANCIA PARA CANCELACION DEL RSI','1','1',1,'A','0','=','0','/public/images/pdi_pk.png'),(9,'FIN RSI',4,'rsi_end',0,'','','N','EVENTO DE TRANSICIÓN QUE SE ACTIVA A 1 CUANDO LLEGA A ALGÚN PUNTO DEL 97% DE LA FINALIZACIÓN','1','1',1,'A','0','=','0','/public/images/pdi_pk.png'),(10,'SALIDA RSI',4,'rsi_out',0,'','','N','EVENTO DE TRANSICIÓN QUE SE ACTIVA A 1 CUANDO SE ALEJA LA DISTANCIA PARA SALIDA DEL RSI','1','1',1,'A','0','=','0','/public/images/pdi_pk.png'),(11,'ENTRADA RSI',4,'rsi_in',0,'','','N','EVENTO DE TRANSICIÓN QUE SE ACTIVA A 1 CUANDO SE ACERCA LA DISTANCIA PARA ENTRADA DEL RSI PERO ESTÁ ACTIVO UN RSI','1','1',1,'A','0','=','0','/public/images/pdi_pk.png'),(12,'PERMANENCIA RSI',4,'rsi_on',0,'','','N','ES 1 CUANDO SE MANTIENE EN EL ÚLTIMO RSI','1','0',1,'A','0','=','0','/public/images/pdi_pk.png'),(13,'CLAVE RSI',4,'pk_rsi',0,'','','N','CLAVE ÚNICA DEL RSI','1','0',10,'A','0','=','0','/public/images/pdi_pk.png'),(14,'NOMBRE RSI',4,'rsi_descrip',0,'','','S','DESCRIPCIÓN DEL RSI, NORMALMENTE USADO PARA ARMAR LA RESPUESTA DEL CORREO','RSI X','0',30,'T','0','=','0','/public/images/pdi_pk.png'),(15,'ENTRADA GEO',2,'geo_in',18,'OP','0?FALSO;1?VERDADERO','N','EVENTO DE TRANSICIÓN QUE SE ACTIVA A 1 CUANDO SE ESTÁ EN LA GEOCERCA','1','1',1,'A','1','=','18x20x30x22','/public/images/pdi_pk.png'),(16,'SALIDA GEO',2,'geo_out',18,'OP','0?FALSO;1?VERDADERO','N','EVENTO DE TRANSICIÓN QUE SE ACTIVA A 1 CUANDO SE SALE DE LA GEOCERCA','1','1',1,'A','1','=','18x20x22x30','/public/images/pdi_pk.png'),(17,'PERMANENCIA GEOCERCA',2,'geo_on',18,'OP','0?FALSO;1?VERDADERO','N','ES 1 CUANDO SE MANTIENE EN LA ÚLTIMA GEOCERCA','1','0',1,'A','1','=','18x20x27x30x31x32x33x34x36','/public/images/pdi_pk.png'),(18,'CLAVE GEOCERCA',2,'geo_pk',0,'BD','SELECT ID_OBJECT_MAP AS ID, DESCRIPCION AS DESCRIPTION FROM ADM_GEOREFERENCIAS WHERE ID_CLIENTE = $cliente AND TIPO = \\\'G\\\'','N','CLAVE ÚNICA DEL GEOCERCA','1','0',10,'A','1','=','15x16x17x20x30x22x31x34x36x32x33','/public/images/pdi_pk.png'),(19,'NOMBRE GEOCERCA',2,'geo_descrip',18,'','','S','DESCRIPCIÓN DE LA GEOCERCA, NORMALMENTE USADO PARA ARMAR LA RESPUESTA DEL CORREO','GEOCERCA X','0',30,'T','0','=','0','/public/images/pdi_pk.png'),(20,'CLAVE UNIDAD',3,'uni_pk_gral',0,'','','N','CLAVE ÚNICA DE LA UNIDAD','1','0',10,'A','0','=','21x22x23x24x25x26x27x28x29x30x31x32x33x34x35x36x18','/public/images/pdi_pk.png'),(21,'NOMBRE UNIDAD',3,'uni_descrip_gral',0,'','','S','DESCRIPCIÓN DE LA UNIDAD, NORMALMENTE USADO PARA ARMAR LA RESPUESTA DEL CORREO','UNIDAD X','0',30,'T','0','=','0','/public/images/pdi_pk.png'),(22,'VELOCIDAD',3,'uni_velocidad',0,'OP','10?10;20?20;30?30;40?40;50?50;60?60;70?70;80?80;90?90;100?100;110?110;120?120;130?130;140?140;150?150;160?160','N','VELOCIDAD DE LA UNIDAD','0','0',7,'A','1','=','20','/public/images/pdi_pk.png'),(23,'ESTATUS GPS',3,'uni_status_gps',0,'OP','0?ERROR;2?OK','S','ESTATUS DEL GPS, (-1 ERROR, 0 DESCONOCIDO, 1 > 10 SEG,2 OK)','2','0',2,'A','1','=','20','/public/images/pdi_pk.png'),(24,'NOMBRE FLOTA',3,'uni_descrip_flota',0,'','','S','DESCRIPCIÓN DE LA FLOTA','FLOTA X','0',30,'T','0','=','0','/public/images/pdi_pk.png'),(25,'VELOCIDAD TOPE',3,'uni_vel_tope',0,'OP','10?10;20?20;30?30;40?40;50?50;60?60;70?70;80?80;90?90;100?100;110?110;120?120;130?130;140?140;150?150;160?160','N','VELOCIDAD TOPE CONFIGURADA PARA QUE SEA UN EXCESO DE VELOCIDAD','96','0',3,'A','1','=','20','/public/images/pdi_pk.png'),(26,'VELOCIDAD DETENIDA',3,'uni_vel_stop',0,'OP','0?0','N','VELOCIDAD MÁXIMA PARA QUE SE CONSIDERE UNIDAD DETENIDA, NORMALMENTE ES 5KPH POR EL ERROR DE GPS','5','0',3,'A','1','=','20','/public/images/pdi_pk.png'),(27,'ESTATUS MOTOR',3,'uni_status_motor',0,'OP','ON?ENCENDIDO; OFF?APAGADO','S','ESTATUS DEL MOTOR, (ON ENCENDIDO, OFF APAGADO)','OFF','0',3,'A','1','=','20','/public/images/pdi_pk.png'),(28,'NOMBRE DEL EVENTO',3,'uni_descrip_event',0,'','','S','DESCRIPCIÓN DEL EVENTO','REPORTE X SOLICITUD','0',30,'T','0','=','20','/public/images/pdi_pk.png'),(29,'PRIORIDAD DEL EVENTO',3,'uni_prio_event',0,'','','N','PRIORIDAD, (1 ALTA, 0 NORMAL)','1','0',1,'A','0','=','20','/public/images/pdi_pk.png'),(30,'CLAVE EVENTO',3,'uni_pk_event',0,'BD','SELECT COD_EVENT AS ID, DESCRIPTION AS DESCRIPTION FROM ADM_EVENTOS WHERE COD_EVENT > 0 ','N','CLAVE ÚNICA DEL EVENTO','1','0',10,'A','1','=','20x1x2x3x4x15x16x17x18','/public/images/pdi_pk.png'),(31,'TIEMPO DETENIDA MOTOR ON',3,'time_stop_motor_on',0,'','','N','VARIABLE DE TIEMPO DESDE EL ÚLTIMO MOTOR ON Y DETENIDA, PASA A CERO CON UN CAMBIO.','1','0',3,'A','0','=','20x3x4x18x17','/public/images/pdi_pk.png'),(32,'TIEMPO EXCESO VELOCIDAD',3,'time_exceso_vel',0,'','','N','VARIABLE DE TIEMPO DESDE EL EXCESO VELOCIDAD, PASA A CERO CON UN CAMBIO.','1','0',3,'A','0','=','20x3x4x17x18','/public/images/pdi_pk.png'),(33,'TIEMPO MOTOR ON',3,'time_motor_on',0,'','','N','VARIABLE DE TIEMPO DESDE EL ÚLTIMO MOTOR ON, PASA A CERO CON UN CAMBIO.','1','0',3,'A','0','=','20x3x17x4x18','/public/images/pdi_pk.png'),(34,'TIEMPO DETENIDA',3,'time_stop_all',0,'','','N','VARIABLE DE TIEMPO DESDE LA ÚLTIMA UNIDAD DETENIDA, PASA A CERO CON UN CAMBIO.','1','0',3,'A','0','=','20x3x4x17x18','/public/images/pdi_pk.png'),(35,'TIEMPO MOVIMIENTO',3,'time_move',0,'','','N','VARIABLE DE TIEMPO DESDE LA ÚLTIMA UNIDAD MOVIMIENTO, PASA A CERO CON UN CAMBIO.','1','0',3,'A','0','=','20','/public/images/pdi_pk.png'),(36,'TIEMPO MOTOR OFF',3,'time_motor_off',0,'','','N','VARIABLE DE TIEMPO DESDE EL ÚLTIMO MOTOR OFF, PASA A CERO CON UN CAMBIO.','1','0',3,'A','0','=','20x3x4x17x18','/public/images/pdi_pk.png'),(37,'TIEMPO EN PDI',1,'time_pdi',4,'','','N','VARIABLE DE TIEMPO DESDE LA ENTRADA O PERMANENCIA MISMO PDI, PASA A CERO CON SALIDA','1','0',3,'A','0','=','0','/public/images/pdi_pk.png'),(38,'TIEMPO EN GEO',2,'time_geo',18,'','','N','VARIABLE DE TIEMPO DESDE LA ENTRADA O PERMANENCIA MISMO GEO, PASA A CERO CON SALIDA','1','0',3,'A','0','=','0','/public/images/pdi_pk.png'),(39,'TIEMPO EN RSI',4,'time_rsi',0,'','','N','VARIABLE DE TIEMPO DESDE LA ENTRADA O PERMANENCIA MISMO RSI, PASA A CERO CON SALIDA','1','0',3,'A','0','=','0','/public/images/pdi_pk.png'),(40,'VALOR IN ANALOGICA 1',3,'ana_in1',0,'','','N','VALOR DE LA ENTRADA ANALÓGICA 1, SI NO LO MANDA EL EQUIPO POR DEFECTO ES 0','0.0','0',6,'A','0','=','0','/public/images/pdi_pk.png'),(41,'VALOR IN ANALOGICA 2',3,'ana_in2',0,'','','N','VALOR DE LA ENTRADA ANALÓGICA 2, SI NO LO MANDA EL EQUIPO POR DEFECTO ES 0','0.0','0',6,'A','0','=','0','/public/images/pdi_pk.png'),(42,'VALOR IN ANALOGICA 3',3,'ana_in3',0,'','','N','VALOR DE LA ENTRADA ANALÓGICA 3, SI NO LO MANDA EL EQUIPO POR DEFECTO ES 0','0.0','0',6,'A','0','=','0','/public/images/pdi_pk.png'),(43,'VALOR IN ANALOGICA 4',3,'ana_in4',0,'','','N','VALOR DE LA ENTRADA ANALÓGICA 4, SI NO LO MANDA EL EQUIPO POR DEFECTO ES 0','0.0','0',6,'A','0','=','0','/public/images/pdi_pk.png'),(44,'CLAVE FLOTA',3,'uni_pk_flota',0,'','','N','CLAVE ÚNICA DE LA FLOTA','1','0',10,'A','0','=','0','/public/images/pdi_pk.png'),(45,'ESTATUS RSI',4,'rsi_last_status',0,'','','N','ÚLTIMO STATUS RSI','0','0',1,'A','0','=','0','/public/images/pdi_pk.png'),(46,'RSI ORDEN APARICION',4,'rsi_order_apparition',0,'','','N','ORDEN DE APARICIÓN','0','0',10,'A','0','=','0','/public/images/pdi_pk.png'),(47,'RSI AVANCE',4,'rsi_percent_progress',0,'','','N','PORCENTAJE DE AVANCE (0-100)','0','0',5,'A','0','=','0','/public/images/pdi_pk.png'),(48,'RSI DIST ACUMULADA',4,'rsi_distance_acumulate_km',0,'','','N','DISTANCIA ACUMULADA DEL RSI','0','0',10,'A','0','=','0','/public/images/pdi_pk.png'),(49,'RSI DIST PENDIENTE',4,'rsi_distance_less_km',0,'','','N','DISTANCIA POR RECORRER DEL RSI','0','0',10,'A','0','=','0','/public/images/pdi_pk.png'),(50,'RSI TIPO DE PUNTO',4,'rsi_type_point_rsi',0,'','','N','TIPO DE PUNTO DEL RSI','0','0',2,'A','0','=','0','/public/images/pdi_pk.png'),(51,'TIEMPO FUERA DE RSI',4,'time_out_rsi',0,'','','N','TIEMPO FUERA DEL RSI','0','0',3,'A','0','=','0','/public/images/pdi_pk.png'),(52,'DETALLE DE RSI',4,'rsi_detalle_descrip',0,'','','S','DETALLE DE LA RSI','RSI DETALLE X','0',40,'T','0','=','0','/public/images/pdi_pk.png'),(53,'REVERSA RSI',4,'rsi_reverse',0,'','','N','EVENTO DE TRANSICIÓN SE ACTIVA SI EL VEHÍCULO VA CONTRARIO A LA RUTA','0','1',1,'A','0','=','0','/public/images/pdi_pk.png');
/*!40000 ALTER TABLE `ALERT_DICTIONARY_EXPRESION` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ALERT_HISTORY`
--

DROP TABLE IF EXISTS `ALERT_HISTORY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ALERT_HISTORY` (
  `COD_ENTITY` decimal(10,0) DEFAULT NULL,
  `COD_CONEC_APPL` decimal(10,0) DEFAULT NULL,
  `COD_EVENT` decimal(10,0) DEFAULT NULL,
  `COD_EQUIPMENT` decimal(10,0) DEFAULT NULL,
  `COD_TYPE_EQUIPMENT` decimal(10,0) DEFAULT NULL,
  `COD_FLEET` decimal(10,0) DEFAULT NULL,
  `EVENT_DESCRIPTION` varchar(100) DEFAULT NULL,
  `FLEET_DESCRIPTION` varchar(100) DEFAULT NULL,
  `ENTITY_DESCRIPTION` varchar(100) DEFAULT NULL,
  `EVENT_PRIORITY` decimal(1,0) DEFAULT NULL,
  `GPS_DATETIME` timestamp NULL DEFAULT NULL,
  `VELOCITY` decimal(8,2) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ALTITUDE` decimal(12,6) DEFAULT NULL,
  `ANGLE` decimal(5,2) DEFAULT NULL,
  `NRO_SATELLITE` decimal(3,0) DEFAULT NULL,
  `FLAG_ERROR` varchar(2) DEFAULT NULL,
  `FECHA_SAVE` timestamp NULL DEFAULT NULL,
  `MSN_OPERATOR` varchar(1500) DEFAULT NULL,
  `MSN_EQUIPMENT` varchar(1500) DEFAULT NULL,
  `MSN_INDEX` decimal(10,0) DEFAULT NULL,
  `PK_MSN_OPERATOR` decimal(10,0) DEFAULT NULL,
  `PK_MSN_EQUIPMENT` decimal(10,0) DEFAULT NULL,
  `MOTOR` varchar(4) DEFAULT NULL,
  `DISTANCIA` decimal(4,2) DEFAULT NULL,
  `ICON_CHAR` varchar(1) DEFAULT NULL,
  `ICON_COLOR` int(11) DEFAULT NULL,
  `INSTANCIA_PROCESADA` int(1) DEFAULT NULL,
  `TIME_MAX_WAIT_MINUTE` int(11) DEFAULT NULL,
  `VEL_MAX_STOP` int(11) DEFAULT NULL,
  `VEL_MAX_ALERT` int(11) DEFAULT NULL,
  `COD_USER_PACKAGE` int(20) NOT NULL AUTO_INCREMENT,
  `COD_CLIENT` int(11) NOT NULL,
  PRIMARY KEY (`COD_USER_PACKAGE`),
  UNIQUE KEY `COD_USER_PACKAGE` (`COD_USER_PACKAGE`),
  KEY `GPS_DATETIME` (`GPS_DATETIME`),
  KEY `FECHA_SAVE` (`FECHA_SAVE`),
  KEY `COD_EVENT` (`COD_EVENT`),
  KEY `COD_ENTITY` (`COD_ENTITY`),
  KEY `COD_OBJECT_MAP` (`COD_CONEC_APPL`),
  KEY `MOTOR` (`MOTOR`),
  KEY `FLAG_ERROR` (`FLAG_ERROR`),
  KEY `COD_APPL` (`COD_CONEC_APPL`),
  KEY `INSTANCIA` (`INSTANCIA_PROCESADA`),
  KEY `IDX_COMPUESTO` (`COD_CONEC_APPL`,`INSTANCIA_PROCESADA`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALERT_HISTORY`
--

LOCK TABLES `ALERT_HISTORY` WRITE;
/*!40000 ALTER TABLE `ALERT_HISTORY` DISABLE KEYS */;
/*!40000 ALTER TABLE `ALERT_HISTORY` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`sa`@`%`*/ /*!50003 TRIGGER `ALERTAS_PS1` AFTER INSERT ON `ALERT_HISTORY` FOR EACH ROW BEGIN
  DECLARE VTABLE VARCHAR(20);
  /*OBTIENE EL NOMBRE DE LA TABLA DE LA UNIDAD*/
  SELECT IF(DESCRIPTION IS NULL,'SIN TABLA', DESCRIPTION) INTO VTABLE
  FROM SAVL1470
  WHERE COD_ENTITY = NEW.COD_ENTITY
  LIMIT 1;
  IF (VTABLE <> 'SIN TABLA') THEN
  /*HACE UPDATE EN LA TABLA DE ALERT_ENTITY*/
  /*SET @QRY = CONCAT('UPDATE ',VTABLE,'     						SET GPS_DATETIME = "',NEW.GPS_DATETIME,'", 
                        COD_ENTITY = ',NEW.COD_ENTITY,',        						uni_pk_flota = ',NEW.COD_FLEET,',          						uni_pk_event = ',NEW.COD_EVENT,',             						uni_prio_event = ',NEW.EVENT_PRIORITY,',             						uni_descrip_event = "',NEW.EVENT_DESCRIPTION,'",             						uni_status_motor = "',NEW.MOTOR,'",             						uni_vel_stop = ',NEW.VEL_MAX_STOP,',             						uni_vel_tope = ',NEW.VEL_MAX_ALERT,',             						uni_descrip_flota = "',NEW.FLEET_DESCRIPTION,'",             						uni_status_gps = ',NEW.FLAG_ERROR,',             						uni_velocidad = ',NEW.VELOCITY,',             						uni_descrip_gral = "',NEW.ENTITY_DESCRIPTION,'",						longitude = ',NEW.LONGITUDE,',						latitude = ',NEW.LATITUDE,' 
                     WHERE "',NEW.GPS_DATETIME,'" > GPS_DATETIME;');*/
  SET @QRY = CONCAT('INSERT INTO ',VTABLE,' (    						 GPS_DATETIME, 
                        COD_ENTITY,        						uni_pk_flota ,          						uni_pk_event,             						uni_prio_event,             						uni_descrip_event,             						uni_status_motor ,             						uni_vel_stop ,             						uni_vel_tope,             						uni_descrip_flota ,             						uni_status_gps,             						uni_velocidad ,             						uni_descrip_gral ,						longitude ,						latitude ) 
                      VALUES ( "',NEW.GPS_DATETIME,'", 
                        ',NEW.COD_ENTITY,',        						',NEW.COD_FLEET,',          						',NEW.COD_EVENT,',             						',NEW.EVENT_PRIORITY,',             						"',NEW.EVENT_DESCRIPTION,'",             						"',NEW.MOTOR,'",             						',NEW.VEL_MAX_STOP,',             						',NEW.VEL_MAX_ALERT,',             						"',NEW.FLEET_DESCRIPTION,'",             						',NEW.FLAG_ERROR,',             						',NEW.VELOCITY,',             						"',NEW.ENTITY_DESCRIPTION,'",						',NEW.LONGITUDE,',						',NEW.LATITUDE,' )');
  INSERT INTO ALERT_UPDATE_ENTITY (INSTRUCCION) VALUES (@QRY);
  -- CALL  ALERTAS_PS2;
  END IF;END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `ALERT_MAIL_NOTIFICATION`
--

DROP TABLE IF EXISTS `ALERT_MAIL_NOTIFICATION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ALERT_MAIL_NOTIFICATION` (
  `COD_ALERT_NOTIFICATION` int(11) NOT NULL AUTO_INCREMENT,
  `COD_ALERT_MASTER` int(11) DEFAULT NULL,
  `FECHA_GENERADO` datetime DEFAULT NULL,
  `PROCESADO` enum('S','N') DEFAULT 'N' COMMENT '"N" NO, "S" SI ESTA PROCESADO',
  `EMAIL_SUBJECT` text COMMENT 'ASUNTO DEL CORREO',
  `EMAIL_TEXT` text COMMENT 'CONTENIDO DEL CORREO',
  `TIPO_ALERT` enum('E','S') DEFAULT 'E' COMMENT 'EMAIL O SMS',
  `SMS_TXT` varchar(150) DEFAULT NULL COMMENT 'SMS, SOLO CARATERES DE SMS',
  `EMAIL_CELPHONE` text COMMENT 'INTEGRA TODOS LOS CORREOS O CELULARES A LOS CUALES LE SERAN ENVIADOS LOS MENSAJES SEPARADOS POR COMA',
  `PK_HISTORY` int(20) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) NOT NULL,
  `LATITUDE` decimal(12,6) NOT NULL,
  `DESTINATARIOS` varchar(200) NOT NULL,
  `COD_ENTITY` int(11) NOT NULL,
  PRIMARY KEY (`COD_ALERT_NOTIFICATION`)
) ENGINE=MyISAM AUTO_INCREMENT=25506 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALERT_MAIL_NOTIFICATION`
--

LOCK TABLES `ALERT_MAIL_NOTIFICATION` WRITE;
/*!40000 ALTER TABLE `ALERT_MAIL_NOTIFICATION` DISABLE KEYS */;
/*!40000 ALTER TABLE `ALERT_MAIL_NOTIFICATION` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ALERT_MASTER`
--

DROP TABLE IF EXISTS `ALERT_MASTER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ALERT_MASTER` (
  `COD_ALERT_MASTER` int(16) NOT NULL AUTO_INCREMENT COMMENT 'CLAVE PRIMARIA DE LAS ALERTAS POR CLIENTE',
  `NAME_ALERT` varchar(60) NOT NULL,
  `COD_CLIENT` int(11) NOT NULL,
  `COD_USER_CREATE` int(11) NOT NULL COMMENT 'USUARIO CREADOR',
  `COD_EVENT_GENERATE` int(11) NOT NULL COMMENT 'EVENTO GENERADO, DEBE TENER INFORMACION SI FLAG_SAVE_HIST = 1 O FLAG_SHOW_CONSOLE = 1',
  `HORARIO_FLAG_LUNES` int(1) DEFAULT '0',
  `HORARIO_FLAG_MARTES` int(1) DEFAULT '0',
  `HORARIO_FLAG_MIERCOLES` int(1) DEFAULT '0',
  `HORARIO_FLAG_JUEVES` int(1) DEFAULT '0',
  `HORARIO_FLAG_VIERNES` int(1) DEFAULT '0',
  `HORARIO_FLAG_SABADO` int(1) DEFAULT '0',
  `HORARIO_FLAG_DOMINGO` int(1) DEFAULT '0',
  `HORARIO_HORA_INICIO` time DEFAULT '00:00:00' COMMENT 'FRACCIONES DE MEDIA HORA',
  `HORARIO_HORA_FIN` time DEFAULT '00:00:00' COMMENT 'FRACCIONES DE MEDIA HORA',
  `EMAIL_FROMTO` text COMMENT 'DESTINATARIOS DEL CORREO',
  `ACTIVE` int(11) NOT NULL,
  `FLAG_SAVE_HIST` int(1) DEFAULT '1' COMMENT 'SI ESTA EN 1, ALMACENA RESULTADO EN EL HISTÓRICO X FLOTA',
  `FLAG_SHOW_CONSOLE` int(1) DEFAULT '1' COMMENT 'SI ESTA EN 1, ALMACENA RESULTADO EN EL HISTÓRICO X USUARIO',
  `FECHA_CREATE` datetime DEFAULT NULL COMMENT 'FECHA HORA DE CREACIÓN DE ESTA ALERTA',
  `ALARM_EXPRESION` text COMMENT 'EXPRESION DE LA ALARMA, SI ES TRUE, SE APLICA; ESTA EXPRESION DEBE FUNCIONAR PARA SER EVALUADA POR UN WHERE DE UN SELECT DE MYSQL',
  `FLAG_SEND_SMS` int(1) DEFAULT '0',
  `SMS_EXPRESION` varchar(300) DEFAULT NULL,
  `FLAG_SAVE_EVENT_CRITIC` int(1) DEFAULT '0',
  `TYPE_EXPRESION` enum('P','R','G','U') DEFAULT NULL COMMENT 'P= PDI,R= RSI,G= GEOCERCAS,U = UNIDAD',
  `PK_EXPRESION` int(20) DEFAULT NULL COMMENT 'DEPENDE DEL TIPO DE EXPRESION, SI E P SE ALMACENA EL PK DEL PDI, SI ES R EL PK DEL RSI SI ES G EL PK DEL GEO, SI ES U EL PK DE LA UNIDAD',
  `FLAG_MSG_IN` int(1) DEFAULT NULL COMMENT '1 PARA ALMACENAR EN TABLA MENSAJES ENTRANTES',
  `EXPRESION_MSG_IN` varchar(300) DEFAULT NULL,
  `FLAG_MSG_OUT` int(1) DEFAULT NULL COMMENT '1 PARA ALMACENAR EN TABLA MENSAJES SALIENTES Y MANDARSELO A LA UNIDAD COM MENSAJE',
  `EXPRESION_MSG_OUT` varchar(300) DEFAULT NULL,
  `CORREOS_ASIGNADOS` int(2) DEFAULT NULL,
  `CORREOS_VALIDADOS` int(2) DEFAULT NULL,
  PRIMARY KEY (`COD_ALERT_MASTER`),
  UNIQUE KEY `COD_ALERT_MASTER` (`COD_ALERT_MASTER`)
) ENGINE=MyISAM AUTO_INCREMENT=708 DEFAULT CHARSET=latin1 COMMENT='prueba';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALERT_MASTER`
--

LOCK TABLES `ALERT_MASTER` WRITE;
/*!40000 ALTER TABLE `ALERT_MASTER` DISABLE KEYS */;
INSERT INTO `ALERT_MASTER` VALUES (707,'EDFAG',1,1,0,0,0,1,1,1,1,0,'06:00:00','16:00:00','edgar@danone.com',0,0,0,'2013-05-17 16:44:27','uni_vel_tope = 10 and uni_pk_event = 24',0,'',0,'U',0,0,'',0,'',1,0);
/*!40000 ALTER TABLE `ALERT_MASTER` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`sa`@`%`*/ /*!50003 TRIGGER `BORRA_DETALLE` AFTER DELETE ON `ALERT_MASTER` FOR EACH ROW BEGIN
  DELETE FROM ALERT_DETAIL WHERE COD_ALERT_MASTER = OLD.COD_ALERT_MASTER;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `ALERT_TIPO_VARIABLE`
--

DROP TABLE IF EXISTS `ALERT_TIPO_VARIABLE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ALERT_TIPO_VARIABLE` (
  `ID_TIPO_VARIABLE` int(11) NOT NULL,
  `DESCRIPCION` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALERT_TIPO_VARIABLE`
--

LOCK TABLES `ALERT_TIPO_VARIABLE` WRITE;
/*!40000 ALTER TABLE `ALERT_TIPO_VARIABLE` DISABLE KEYS */;
INSERT INTO `ALERT_TIPO_VARIABLE` VALUES (1,'GEOPUNTOS'),(2,'GEOCERCAS'),(3,'UNIDAD'),(4,'RUTA SEGURA');
/*!40000 ALTER TABLE `ALERT_TIPO_VARIABLE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ALERT_UNITY`
--

DROP TABLE IF EXISTS `ALERT_UNITY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ALERT_UNITY` (
  `COD_ENTITY` int(11) NOT NULL,
  `COD_FLEET` int(11) NOT NULL,
  `TABLA` int(11) NOT NULL,
  PRIMARY KEY (`COD_ENTITY`),
  UNIQUE KEY `IDX_COD_ENTITY` (`COD_ENTITY`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALERT_UNITY`
--

LOCK TABLES `ALERT_UNITY` WRITE;
/*!40000 ALTER TABLE `ALERT_UNITY` DISABLE KEYS */;
INSERT INTO `ALERT_UNITY` VALUES (19844,0,1),(19827,0,1);
/*!40000 ALTER TABLE `ALERT_UNITY` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ALERT_UPDATE_ENTITY`
--

DROP TABLE IF EXISTS `ALERT_UPDATE_ENTITY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ALERT_UPDATE_ENTITY` (
  `INSTRUCCION` varchar(25000) DEFAULT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TABLA` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `idx` (`TABLA`)
) ENGINE=MyISAM AUTO_INCREMENT=2651453 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALERT_UPDATE_ENTITY`
--

LOCK TABLES `ALERT_UPDATE_ENTITY` WRITE;
/*!40000 ALTER TABLE `ALERT_UPDATE_ENTITY` DISABLE KEYS */;
/*!40000 ALTER TABLE `ALERT_UPDATE_ENTITY` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SAVL1120`
--

DROP TABLE IF EXISTS `SAVL1120`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SAVL1120` (
  `COD_ENTITY` decimal(10,0) NOT NULL,
  `COD_COLOR` decimal(10,0) NOT NULL,
  `COD_FLEET` decimal(10,0) NOT NULL,
  `COD_TRADEMARK_MODEL` decimal(10,0) NOT NULL,
  `COD_TYPE_ENTITY` decimal(10,0) NOT NULL,
  `COD_DETAIL_STATUS` decimal(10,0) DEFAULT NULL,
  `PLAQUE` varchar(10) DEFAULT NULL,
  `BODYWORK_CODE` varchar(30) DEFAULT NULL,
  `MOTOR_CODE` varchar(30) DEFAULT NULL,
  `YEAR` decimal(4,0) DEFAULT NULL,
  `INITIAL_KM` decimal(10,0) DEFAULT NULL,
  `MAP_SYMBOL` varchar(10) DEFAULT NULL,
  `DESCRIPTION` varchar(100) NOT NULL,
  `ACTIVE` decimal(1,0) DEFAULT '0',
  `NRO_COLOR` float DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `ADDRESS` varchar(60) DEFAULT NULL,
  `ITEM_NUMBER_ENTITY` varchar(10) DEFAULT NULL,
  `FILE_NAME_IMAGE` varchar(30) DEFAULT NULL,
  `FONT_SYMBOL` varchar(60) DEFAULT NULL,
  `ITEM_NUMBER_UNITY` varchar(20) DEFAULT NULL,
  `OBSERVATIONS` varchar(100) DEFAULT NULL,
  `NAME_INSTALLER` varchar(30) DEFAULT NULL,
  `DATETIME_INSTALLER` datetime DEFAULT NULL,
  `CAPACITY_CARRY_KG` decimal(20,0) DEFAULT NULL,
  `COD_TYPE_CALENDAR` decimal(10,0) DEFAULT NULL,
  `COD_CFG_BD_CONNECT` decimal(10,0) DEFAULT NULL,
  `COD_PROTOCOLO` decimal(10,0) DEFAULT NULL,
  `FLAG_MARCA` decimal(1,0) DEFAULT NULL,
  `LAST_PKT` datetime DEFAULT NULL,
  `COD_DETAIL_STATUS_SAVL` decimal(10,0) DEFAULT NULL,
  `COD_BITA_STATUS` decimal(10,0) DEFAULT NULL,
  `FLAG_ERROR_HARDWARE` decimal(1,0) DEFAULT NULL,
  `FLAG_RESP_INFO` decimal(1,0) NOT NULL DEFAULT '0',
  `RESP_FECINIT` datetime DEFAULT NULL,
  `RESP_FECEND` datetime DEFAULT NULL,
  `LAST_VALUE_ODOMETER` varchar(35) DEFAULT NULL,
  `FLAG_ACUMULATE_ODOMETER` decimal(1,0) DEFAULT NULL,
  `ODOMETER_DATETIME_CHANGE` datetime DEFAULT NULL,
  `ODOMETER_USER_CHANGE` decimal(10,0) DEFAULT NULL,
  `ODOMETER_VALUE_CHANGE` decimal(10,0) DEFAULT NULL,
  `JOURNAL_LAST_DATETIME` datetime DEFAULT NULL,
  `JOURNAL_LAST_KM` decimal(10,0) DEFAULT NULL,
  `JOURNAL_LAST_EVENT_PALTA` decimal(10,0) DEFAULT NULL,
  `JOURNAL_LAST_EVENT_VEL` decimal(10,0) DEFAULT NULL,
  `GAS_LAST_DATETIME` datetime DEFAULT NULL,
  `GAS_LAST_KM` decimal(10,0) DEFAULT NULL,
  `PERFORMANCE_KM_GAS` decimal(10,2) DEFAULT NULL,
  `COD_CLIENT` decimal(10,0) DEFAULT NULL,
  `TIME_REPORT_FLAG` decimal(1,0) DEFAULT NULL,
  `TIME_REPORT_SEC` decimal(10,0) DEFAULT NULL,
  `TIME_REPORT_LAST_TIME` datetime DEFAULT NULL,
  `TIME_REPORT_NEXT_TIME` datetime DEFAULT NULL,
  `TIME_REPORT_QUALITY_OK` decimal(1,0) DEFAULT NULL,
  PRIMARY KEY (`COD_ENTITY`),
  UNIQUE KEY `UNIDAD_FLOTA_UNICO` (`COD_FLEET`,`DESCRIPTION`),
  UNIQUE KEY `UNIDAD_UNICA_FLOTA` (`COD_FLEET`,`DESCRIPTION`,`PLAQUE`,`ITEM_NUMBER_UNITY`),
  UNIQUE KEY `PLACAS_FLOTA_UNICA` (`COD_FLEET`,`PLAQUE`),
  KEY `COD_COLOR` (`COD_COLOR`),
  KEY `COD_FLEET` (`COD_FLEET`),
  KEY `COD_TRADEMARK_MODEL` (`COD_TRADEMARK_MODEL`),
  KEY `COD_TYPE_ENTITY` (`COD_TYPE_ENTITY`),
  KEY `COD_DETAIL_STATUS` (`COD_DETAIL_STATUS`),
  KEY `DESCRIPTION` (`DESCRIPTION`),
  KEY `ITEM_NUMBER_ENTITY` (`ITEM_NUMBER_ENTITY`),
  KEY `ITEM_NUMBER_UNITY` (`ITEM_NUMBER_UNITY`),
  KEY `COD_PROTOCOLO` (`COD_PROTOCOLO`),
  KEY `COD_CFG_BD_CONNECT` (`COD_CFG_BD_CONNECT`),
  KEY `COD_CLIENT` (`COD_CLIENT`),
  KEY `COD_BITA_STATUS` (`COD_BITA_STATUS`),
  KEY `PLAQUE` (`PLAQUE`),
  KEY `ACTIVE` (`ACTIVE`),
  KEY `UNIDAD_FLOTA_UNICA2` (`COD_FLEET`,`DESCRIPTION`,`ITEM_NUMBER_UNITY`),
  KEY `UNIDAD_FLOTA_UNICA3` (`COD_FLEET`,`DESCRIPTION`,`ITEM_NUMBER_ENTITY`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SAVL1120`
--

LOCK TABLES `SAVL1120` WRITE;
/*!40000 ALTER TABLE `SAVL1120` DISABLE KEYS */;
/*!40000 ALTER TABLE `SAVL1120` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`sa`@`%`*/ /*!50003 TRIGGER `SAVL1120_UPDATE_FLEET` AFTER UPDATE ON `SAVL1120` FOR EACH ROW BEGIN

UPDATE SAVL1340 
SET COD_FLEET = NEW.COD_FLEET 
WHERE COD_EQUIPMENT IN 
	(SELECT COD_EQUIPMENT 
    FROM SAVL1343 
    WHERE COD_ENTITY = NEW.COD_ENTITY);

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`sa`@`%`*/ /*!50003 TRIGGER `SAVL1120_after_del_tr` AFTER DELETE ON `SAVL1120` FOR EACH ROW BEGIN
DECLARE VUSER VARCHAR(20);

SELECT USER() INTO VUSER;
INSERT INTO `SAVL1120_LOG` (DATETIME_DELETED, ENTITY_DELETED, CURRENT_USER_DELETED, COD_ENTITY_DEL) VALUES (CURRENT_TIMESTAMP, OLD.DESCRIPTION, USER(), OLD.COD_ENTITY);

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `SAVL1470`
--

DROP TABLE IF EXISTS `SAVL1470`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SAVL1470` (
  `COD_TABLE` int(11) NOT NULL AUTO_INCREMENT,
  `COD_ENTITY` int(11) NOT NULL,
  `DESCRIPTION` varchar(50) DEFAULT NULL,
  `FLAG_TABLE_USER` int(1) DEFAULT '0',
  `COD_USER` int(11) DEFAULT NULL,
  `COD_FLEET` int(11) DEFAULT NULL,
  `LAST_CONNECT_USER` datetime DEFAULT NULL COMMENT 'FECHAHORA DE LA LTIMA CONEXIN',
  `FLAG_CONNECT_USER` int(1) DEFAULT NULL COMMENT '1 SI ESTA CONECTADO, 0 SI CERRO LA CONSOLA',
  `INSTANCIA_SH` int(20) NOT NULL,
  `INICIO` datetime NOT NULL,
  `FIN` datetime NOT NULL,
  PRIMARY KEY (`COD_TABLE`),
  KEY `COD_USER` (`COD_USER`),
  KEY `COD_FLEET` (`COD_FLEET`),
  KEY `DESCRIPTION` (`DESCRIPTION`),
  KEY `FLAG_CONNECT` (`FLAG_CONNECT_USER`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SAVL1470`
--

LOCK TABLES `SAVL1470` WRITE;
/*!40000 ALTER TABLE `SAVL1470` DISABLE KEYS */;
INSERT INTO `SAVL1470` VALUES (1,19844,'ALERTENTITY019844',2,NULL,0,NULL,NULL,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,19827,'ALERTENTITY019827',2,NULL,0,NULL,NULL,0,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `SAVL1470` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SAVL1471`
--

LOCK TABLES `SAVL1471` WRITE;
/*!40000 ALTER TABLE `SAVL1471` DISABLE KEYS */;
/*!40000 ALTER TABLE `SAVL1471` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SAVL_CLIENTS`
--

DROP TABLE IF EXISTS `SAVL_CLIENTS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SAVL_CLIENTS` (
  `COD_CLIENT` int(10) NOT NULL AUTO_INCREMENT,
  `NAME_CLIENT` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CREATE_DATE` datetime DEFAULT NULL,
  `CONTACT` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `TELEPHONE` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `EMAIL` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `STREET` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `COLONY` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `MUNICIPALITY` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `STATE` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ZIP` int(5) DEFAULT NULL,
  `STATUS` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CITY` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TYPE` enum('AVL','MOV','AMB') COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`COD_CLIENT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SAVL_CLIENTS`
--

LOCK TABLES `SAVL_CLIENTS` WRITE;
/*!40000 ALTER TABLE `SAVL_CLIENTS` DISABLE KEYS */;
/*!40000 ALTER TABLE `SAVL_CLIENTS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SAVL_G_PRIN`
--

DROP TABLE IF EXISTS `SAVL_G_PRIN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SAVL_G_PRIN` (
  `COD_COLOR` decimal(10,0) DEFAULT NULL COMMENT 'SAVL1200',
  `COD_USER_CREATE` decimal(10,0) DEFAULT NULL COMMENT 'SAVL1100',
  `COD_ZONE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_TYPE_GEO` decimal(10,0) DEFAULT NULL,
  `COD_CLIENT` decimal(10,0) DEFAULT NULL COMMENT 'SAVL1500',
  `DATETIME_CREATE` datetime DEFAULT NULL,
  `DESCRIPTION` varchar(60) NOT NULL,
  `TYPE_OBJECT_MAP` enum('P','G','R') DEFAULT NULL COMMENT 'P PUNTO DE INTERES, G GEOCERCA, R RSI',
  `TYPE_PUBLIC` enum('S','N') DEFAULT NULL COMMENT 'S = PUBLICO, N = PRIVADO',
  `ADD_MUNICIP` varchar(60) DEFAULT NULL,
  `ADD_STATE` varchar(60) DEFAULT NULL,
  `ADD_COLONY` varchar(60) DEFAULT NULL,
  `ADD_STREET` varchar(60) DEFAULT NULL,
  `ADD_COD_POSTAL` varchar(60) DEFAULT NULL,
  `ADD_DETAILS` varchar(60) DEFAULT NULL,
  `ADD_STREET_01` varchar(60) DEFAULT NULL,
  `ADD_STREET_02` varchar(60) DEFAULT NULL,
  `ITEM_NUMBER` varchar(30) DEFAULT NULL,
  `ITEM_NUMBER_2` varchar(30) DEFAULT NULL,
  `RADIO` decimal(6,0) DEFAULT NULL,
  `LONGITUDE` decimal(12,6) DEFAULT NULL,
  `LATITUDE` decimal(12,6) DEFAULT NULL,
  `COD_OBJECT_MAP` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`COD_OBJECT_MAP`),
  KEY `COD_USER_CREATE` (`COD_USER_CREATE`),
  KEY `TYPE_OBJECT_MAP` (`TYPE_OBJECT_MAP`),
  KEY `COD_CLIENT` (`COD_CLIENT`),
  KEY `COD_COLOR` (`COD_COLOR`),
  KEY `ITEM_NUMBER` (`ITEM_NUMBER`),
  KEY `ITEM_NUMBER_2` (`ITEM_NUMBER_2`)
) ENGINE=MyISAM AUTO_INCREMENT=1005972 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SAVL_G_PRIN`
--

LOCK TABLES `SAVL_G_PRIN` WRITE;
/*!40000 ALTER TABLE `SAVL_G_PRIN` DISABLE KEYS */;
/*!40000 ALTER TABLE `SAVL_G_PRIN` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ejemplo`
--

DROP TABLE IF EXISTS `ejemplo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ejemplo` (
  `campo` blob
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ejemplo`
--

LOCK TABLES `ejemplo` WRITE;
/*!40000 ALTER TABLE `ejemplo` DISABLE KEYS */;
/*!40000 ALTER TABLE `ejemplo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-06-28 11:22:43
