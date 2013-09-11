CREATE TABLE `ALERT_MAIL_NOTIFICATION` (
  `COD_ALERT_NOTIFICATION` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `COD_ALERT_MASTER` INTEGER(11) DEFAULT NULL,
  `FECHA_GENERADO` DATETIME DEFAULT NULL,
  `PROCESADO` ENUM('S','N') DEFAULT 'N' COMMENT '"N" NO, "S" SI ESTA PROCESADO',
  `EMAIL_SUBJECT` TEXT COLLATE latin1_swedish_ci COMMENT 'ASUNTO DEL CORREO',
  `EMAIL_TEXT` TEXT COLLATE latin1_swedish_ci COMMENT 'CONTENIDO DEL CORREO',
  `TIPO_ALERT` ENUM('E','S') DEFAULT 'E' COMMENT 'EMAIL O SMS',
  `SMS_TXT` VARCHAR(150) COLLATE latin1_swedish_ci DEFAULT NULL COMMENT 'SMS, SOLO CARATERES DE SMS',
  `EMAIL_CELPHONE` TEXT COLLATE latin1_swedish_ci COMMENT 'INTEGRA TODOS LOS CORREOS O CELULARES A LOS CUALES LE SERAN ENVIADOS LOS MENSAJES SEPARADOS POR COMA',
  `PK_HISTORY` INTEGER(20) DEFAULT NULL,
  `LONGITUDE` DECIMAL(12,6) NOT NULL,
  `LATITUDE` DECIMAL(12,6) NOT NULL,
  `DESTINATARIOS` VARCHAR(500) COLLATE latin1_swedish_ci NOT NULL,
  `COD_ENTITY` INTEGER(11) NOT NULL
)ENGINE=MyISAM COMMENT='' CHECKSUM=0 DELAY_KEY_WRITE=0 PACK_KEYS=0 MIN_ROWS=0 MAX_ROWS=0 ROW_FORMAT=DYNAMIC CHARACTER SET 'latin1'
COLLATE 'latin1_swedish_ci';

COMMIT;



/* Data for the `ALERT_MAIL_NOTIFICATION` table  (Records 1 - 7) */

INSERT INTO `ALERT_MAIL_NOTIFICATION` (`COD_ALERT_NOTIFICATION`, `COD_ALERT_MASTER`, `FECHA_GENERADO`, `PROCESADO`, `EMAIL_SUBJECT`, `EMAIL_TEXT`, `TIPO_ALERT`, `SMS_TXT`, `EMAIL_CELPHONE`, `PK_HISTORY`, `LONGITUDE`, `LATITUDE`, `DESTINATARIOS`, `COD_ENTITY`) VALUES 
  (15085, 657, '2013-06-23 23:58:55', 'N', NULL, NULL, 'E', NULL, NULL, 780, -94.42905, 18.1319, 'morcillolj90@hotmail.com,arturo.piloto@grupo-riga.com.mx,ruby.sansores@grupo-riga.com.mx,willey.hadad@grupo-riga.com.mx,feliciano.campos@grupo-riga.com.mx,d-a.c-h@hotmail.com', 13824),
  (16103, 580, '2013-06-24 23:58:20', 'N', NULL, NULL, 'E', NULL, NULL, 873, -100.538672, 25.731475, 'dora.gonzalez@arzyz.com,sistemas.mty@grupouda.com.mx', 17265),
  (30473, 621, '2013-07-10 23:44:11', 'N', NULL, NULL, 'E', NULL, NULL, 884, -94.414633, 18.13635, 'morcillolj90@hotmail.com,willey.hadad@grupo-riga.com.mx,thalia_tepsa@hotmail.com,arturo.piloto@grupo-riga.com.mx,ruby.sansores@grupo-riga.com.mx,feliciano.campos@grupo-riga.com.mx,d-a.c-h@hotmail.com', 24300),
  (31403, 154, '2013-07-11 23:58:42', 'N', NULL, NULL, 'E', NULL, NULL, 416, -99.1895, 19.49175, 'monitoreo@opemantra.com', 13199),
  (41691, 155, '2013-07-23 23:58:50', 'N', NULL, NULL, 'E', NULL, NULL, 426, -99.181333, 19.489417, 'monitoreo@opemantra.com', 13232),
  (42511, 648, '2013-07-24 23:58:40', 'N', NULL, NULL, 'E', NULL, NULL, 953, -89.554217, 20.946017, 'morcillolj90@hotmail.com,arturo.piloto@grupo-riga.com.mx,ruby.sansores@grupo-riga.com.mx,willey.hadad@grupo-riga.com.mx,feliciano.campos@grupo-riga.com.mx,thalia_tepsa@hotmail.com,d-a.c-h@hotmail.com', 24302),
  (44827, 154, '2013-07-28 23:58:43', 'N', NULL, NULL, 'E', NULL, NULL, 63, -99.189483, 19.491, 'monitoreo@opemantra.com', 13279);


