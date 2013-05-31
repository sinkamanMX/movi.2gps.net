<?
  //crea las tablas de las unidades de las que hay que crear alertas
  //SE EJECUTA CADA 10 SEG
  function crea_tabla($nombre,$con){
    $res = false;
	$sql = "CREATE TABLE `".$nombre."` (
	`COD_FLEET` decimal(10,0) default NULL,
	`GPS_DATETIME` timestamp NULL default NULL,
	`geo_descrip` varchar(30) default NULL,
	`geo_in` decimal(1,0) default NULL,
	`geo_on` decimal(1,0) default NULL,
	`geo_out` decimal(1,0) default NULL,
	`geo_pk` decimal(10,0) default NULL,
	`time_geo` decimal(3,0) default NULL,
	`pdi_descrip` varchar(30) default NULL,
	`pdi_in` decimal(1,0) default NULL,
	`pdi_on` decimal(1,0) default NULL,
	`pdi_out` decimal(1,0) default NULL,
	`pdi_pk` decimal(10,0) default NULL,
	`time_pdi` decimal(3,0) default NULL,
	`pk_rsi` decimal(10,0) default NULL,
	`rsi_begin` decimal(1,0) default NULL,
	`rsi_cancel` decimal(1,0) default NULL,
	`rsi_descrip` varchar(30) default NULL,
	`rsi_detalle_descrip` varchar(40) default NULL,
	`rsi_distance_acumulate_km` decimal(10,0) default NULL,
	`rsi_distance_less_km` decimal(10,0) default NULL,
	`rsi_end` decimal(1,0) default NULL,
	`rsi_in` decimal(1,0) default NULL,
	`rsi_last_status` decimal(1,0) default NULL,
	`rsi_on` decimal(1,0) default NULL,
	`rsi_order_apparition` decimal(10,0) default NULL,
	`rsi_out` decimal(1,0) default NULL,
	`rsi_percent_progress` decimal(5,0) default NULL,
	`rsi_reverse` decimal(1,0) default NULL,
	`rsi_type_point_rsi` decimal(2,0) default NULL,
	`time_out_rsi` decimal(3,0) default NULL,
	`time_rsi` decimal(3,0) default NULL,
	`ana_in1` decimal(6,0) default NULL,
	`ana_in2` decimal(6,0) default NULL,
	`ana_in3` decimal(6,0) default NULL,
	`ana_in4` decimal(6,0) default NULL,
	`time_exceso_vel` decimal(3,0) default NULL,
	`time_motor_off` decimal(3,0) default NULL,
	`time_motor_on` decimal(3,0) default NULL,
	`time_move` decimal(3,0) default NULL,
	`time_stop_all` decimal(3,0) default NULL,
	`time_stop_motor_on` decimal(3,0) default NULL,
	`uni_descrip_event` varchar(30) default NULL,
	`uni_descrip_flota` varchar(30) default NULL,
	`uni_descrip_gral` varchar(30) default NULL,
	`uni_pk_event` decimal(10,0) default NULL,
	`uni_prio_event` decimal(1,0) default NULL,
	`uni_status_gps` varchar(2) default NULL,
	`uni_status_motor` varchar(3) default NULL,
	`uni_vel_stop` decimal(3,0) default NULL,
	`uni_vel_tope` decimal(3,0) default NULL,
	`uni_velocidad` decimal(7,0) default NULL,
	`latitude` decimal(12,6) default NULL,
	`longitude` decimal(12,6) default NULL,
	`COD_ALERT_HISTORY` int(20) NOT NULL auto_increment,
	`uni_pk_flota` int(11) NOT NULL,
	`uni_pk_gral` int(11) NOT NULL,
	`COD_ENTITY` int(11) NOT NULL,
	PRIMARY KEY  (`COD_ALERT_HISTORY`),
	UNIQUE KEY `COD_HISTORY` (`COD_ALERT_HISTORY`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
	//echo $sql."<br>";
	if ($qry = mysql_query($sql)){
	  $res = true;
	}
	return $res;
  }
  
  function crea_tabla_last($nombre,$con){
    $res = false;
	$sql = "CREATE TABLE `".$nombre."` (
	`COD_FLEET` decimal(10,0) default NULL,
	`GPS_DATETIME` timestamp NULL default NULL,
	`geo_descrip` varchar(30) default NULL,
	`geo_in` decimal(1,0) default NULL,
	`geo_on` decimal(1,0) default NULL,
	`geo_out` decimal(1,0) default NULL,
	`geo_pk` decimal(10,0) default NULL,
	`time_geo` decimal(3,0) default NULL,
	`pdi_descrip` varchar(30) default NULL,
	`pdi_in` decimal(1,0) default NULL,
	`pdi_on` decimal(1,0) default NULL,
	`pdi_out` decimal(1,0) default NULL,
	`pdi_pk` decimal(10,0) default NULL,
	`time_pdi` decimal(3,0) default NULL,
	`pk_rsi` decimal(10,0) default NULL,
	`rsi_begin` decimal(1,0) default NULL,
	`rsi_cancel` decimal(1,0) default NULL,
	`rsi_descrip` varchar(30) default NULL,
	`rsi_detalle_descrip` varchar(40) default NULL,
	`rsi_distance_acumulate_km` decimal(10,0) default NULL,
	`rsi_distance_less_km` decimal(10,0) default NULL,
	`rsi_end` decimal(1,0) default NULL,
	`rsi_in` decimal(1,0) default NULL,
	`rsi_last_status` decimal(1,0) default NULL,
	`rsi_on` decimal(1,0) default NULL,
	`rsi_order_apparition` decimal(10,0) default NULL,
	`rsi_out` decimal(1,0) default NULL,
	`rsi_percent_progress` decimal(5,0) default NULL,
	`rsi_reverse` decimal(1,0) default NULL,
	`rsi_type_point_rsi` decimal(2,0) default NULL,
	`time_out_rsi` decimal(3,0) default NULL,
	`time_rsi` decimal(3,0) default NULL,
	`ana_in1` decimal(6,0) default NULL,
	`ana_in2` decimal(6,0) default NULL,
	`ana_in3` decimal(6,0) default NULL,
	`ana_in4` decimal(6,0) default NULL,
	`time_exceso_vel` decimal(3,0) default NULL,
	`time_motor_off` decimal(3,0) default NULL,
	`time_motor_on` decimal(3,0) default NULL,
	`time_move` decimal(3,0) default NULL,
	`time_stop_all` decimal(3,0) default NULL,
	`time_stop_motor_on` decimal(3,0) default NULL,
	`uni_descrip_event` varchar(30) default NULL,
	`uni_descrip_flota` varchar(30) default NULL,
	`uni_descrip_gral` varchar(30) default NULL,
	`uni_pk_event` decimal(10,0) default NULL,
	`uni_prio_event` decimal(1,0) default NULL,
	`uni_status_gps` varchar(2) default NULL,
	`uni_status_motor` varchar(3) default NULL,
	`uni_vel_stop` decimal(3,0) default NULL,
	`uni_vel_tope` decimal(3,0) default NULL,
	`uni_velocidad` decimal(7,0) default NULL,
	`latitude` decimal(12,6) default NULL,
	`longitude` decimal(12,6) default NULL,
	`COD_ALERT_HISTORY` int(20) NOT NULL auto_increment,
	`uni_pk_flota` int(11) NOT NULL,
	`uni_pk_gral` int(11) NOT NULL,
	`COD_ENTITY` int(11) NOT NULL,
	PRIMARY KEY  (`COD_ALERT_HISTORY`),
	UNIQUE KEY `COD_HISTORY` (`COD_ALERT_HISTORY`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
	//echo $sql."<br>";
	if ($qry = mysql_query($sql)){
	  $res = true;
	}
	return $res;
  }
  
  function marca_creados($entity,$con){
    $sql = "UPDATE ALERT_UNITY SET TABLA = 1 WHERE COD_ENTITY = ".$entity;
    //echo $sql;
	$qry = mysql_query($sql);
  }
  
  function registra_1470($entity,$flota,$nombre,$con){
    $sql = "INSERT INTO SAVL1470 (
              COD_TABLE,
              DESCRIPTION,
              FLAG_TABLE_USER,
              COD_FLEET,
              COD_ENTITY
            ) VALUES (
              0,
              '".$nombre."',
              2,
              ".$flota.",
              ".$entity."
            );";
	$qry = mysql_query($sql);
  }
  
  $con = mysql_connect("localhost","sa","$0lstic3$");
  if ($con){
    $base2 = mysql_select_db("ALG_BD_CORPORATE_ALERTAS",$con);
	//lee las unidades pendientes de tabla
	$sql = "SELECT LPAD(COD_ENTITY,6,'0') AS NOMBRE, COD_ENTITY,COD_FLEET
	          FROM ALERT_UNITY
	          WHERE TABLA = 0";
	$qry = mysql_query($sql);
	while ($row = mysql_fetch_object($qry)){
      $nombre = "ALERTENTITY".$row->NOMBRE;
  	  if (crea_tabla($nombre,$con)){
  	    marca_creados($row->COD_ENTITY,$con);
  	    registra_1470($row->COD_ENTITY,$row->COD_FLEET,$nombre,$con);
  	    crea_tabla_last("ALERTLAST".$row->NOMBRE,$con);
  	  }
	}
    //mysql_close($base2);
    mysql_close($con);
  }
  
?>
