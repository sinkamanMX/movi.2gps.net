<?php

  function dame_cod_entity($gps){
	global $base;
    $resultado =0;
	$sql = "SELECT COD_ENTITY
            FROM SAVL1120
            WHERE ITEM_NUMBER_UNITY='".$gps["imei"]."'";
			
	//echo $sql;
	$qry = mysql_query($sql);
	if($qry){
      $row = mysql_fetch_object($qry);
	  $resultado = $row->COD_ENTITY;    
	  mysql_free_result($qry);
	}
	return $resultado;
  }


  function existe_1141($gps){
	global $base;
    $resultado =0;
	$sql = "SELECT COUNT(1) AS CUENTA
            FROM SAVL1141
            WHERE SAVL1141.COD_ENTITY='".$gps['cod_entity']."'";	
	//echo $sql;
	$qry = mysql_query($sql);
	if($qry){
      $row = mysql_fetch_object($qry);
	  $resultado = $row->CUENTA;    
	  mysql_free_result($qry);
	}
	return $resultado;
  }


   function actualiza_1141($gps){
    global $base;
	$resultado = false;
	$sql = "UPDATE SAVL1141 SET
              GPS_DATETIME = '".$gps['feh']."',
			  VELOCITY="  .$gps["vel"].",
			  LONGITUDE=" .$gps["lon"].",
			  LATITUDE="  .$gps["lat"].",
			  ALTITUDE="  .$gps["alt"].",
			  ANGLE="     .$gps["ang"].",
			  BATTERY="	  .$gps["bat"].",
			  ID_RES_CUESTIONARIO=" .$gps["respuesta"].",
			  COD_EVENT=" .$gps["cod_event"].",
			  EVENT_TIMESTAMP=CURRENT_TIMESTAMP
			  WHERE COD_ENTITY=".$gps['cod_entity'];	
	$qry = mysql_query($sql);
	if ($qry){
		  $resultado = true;
	} 
	return $resultado;
  }

  function inserta_1141($gps){
	global $base;
    $resultado =0;
    $sql="INSERT INTO SAVL1141 (
	                      COD_LAST_PACKAGE,
						  COD_ENTITY,
						  GPS_DATETIME,
						  VELOCITY,
						  LONGITUDE,
						  LATITUDE,
						  ALTITUDE,
						  ANGLE,
						  BATTERY,
						  COD_EVENT,
						  ID_RES_CUESTIONARIO,
						  EVENT_TIMESTAMP) 
	             VALUES (0,
						 ".$gps['cod_entity'].",
						 '".$gps["feh"]."',
						 ".$gps['vel'].",
						 ".$gps['lon'].",
						 ".$gps['lat'].",
						 ".$gps['alt'].",
						 ".$gps['ang'].",
						 ".$gps['bat'].",
						 ".$gps['cod_event'].",
						 ".$gps['respuesta'].",
						 CURRENT_TIMESTAMP)";
	
	$gene=mysql_query($sql);
	if ($gene){
	  $resultado= mysql_insert_id();
	}
    return $resultado;
  }
  
  
  function inserta_actualiza_1141($gps){
	global $base;  
	$resultado=false;
	if(existe_1141($gps)){
		if(actualiza_1141($gps)) {$resultado=true;}
		
	}else{
		if(inserta_1141($gps)) { $resultado=true;}
	}
	return $resultado;
  }
  
  
  
  
  function inserta_respuestas_histo($gps){
	global $base;
    $resultado =0;
    $sql="INSERT INTO CRM2_RESPUESTAS_HISTORICO (
	                      ID_RES_CUESTIONARIO,
						  COD_HISTORY) 
	             VALUES (".$gps['respuesta'].",
						 ".$gps['cod_hist0'].")";
						 
	
	$gene=mysql_query($sql);
    if ($gene){
	  $resultado= 1;
	}
    return $resultado;
  }
  
 
  
  
   function inserta_hist00000($gps){
	global $base;
    $resultado =0;
    $sql="INSERT INTO HIST00000 (
	                      COD_HISTORY,
						  COD_ENTITY,
						  GPS_DATETIME,
						  VELOCITY,
						  LONGITUDE,
						  LATITUDE,
						  ALTITUDE,
						  ANGLE,
						  BATTERY,
						  COD_EVENT,
						  FECHA_SAVE) 
	             VALUES (0,
						 ".$gps['cod_entity'].",
						 '".$gps["feh"]."',
						 ".$gps['vel'].",
						 ".$gps['lon'].",
						 ".$gps['lat'].",
						 ".$gps['alt'].",
						 ".$gps['ang'].",
						 ".$gps['bat'].",
						 ".$gps['cod_event'].",
						 CURRENT_TIMESTAMP)";
	$gene=mysql_query($sql);
    if($gene){
	  $resultado= mysql_insert_id();
	}
    return $resultado;
  }
  
 

?>