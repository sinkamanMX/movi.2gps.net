<?
  //procesa los eventos por unidad y completa la data de 
  //SE EJECUTA CADA 2 seg 
  
  function dia($con){
    $sql = "SELECT DAYOFWEEK(CURRENT_TIMESTAMP) AS DIA";
    $qry = mysql_query($sql,$con);
    $row = mysql_fetch_object($qry);
    switch ($row->DIA){
	  //domingo
	  case 1: 
		$campo = 'HORARIO_FLAG_DOMINGO';
	  break;
	  //lunes
	  case 2:
		$campo = 'HORARIO_FLAG_LUNES';
	  break;
	  //martes
      case 3:
		$campo = 'HORARIO_FLAG_MARTES';
	  break;
	  //miercoles
	  case 4:
		$campo = 'HORARIO_FLAG_MIERCOLES';
	  break;
	  //jueves
	  case 5:
		$campo = 'HORARIO_FLAG_JUEVES';
	  break;
	  //viernes
	  case 6:
		$campo = 'HORARIO_FLAG_VIERNES';
	  break;
	  //sabado
	  case 7:
		$campo = 'HORARIO_FLAG_SABADO';
	  break;
	  
	}
    mysql_free_result($qry);
    return $campo;
  }
  
  function marca_tablas($instancia,$con){
    $res = false;
    $sql = "UPDATE SAVL1470 
          SET INSTANCIA_SH = ".$instancia." 
          WHERE INSTANCIA_SH = 0 AND
                CURRENT_TIMESTAMP BETWEEN INICIO AND FIN
          LIMIT 20";
          //echo $sql;
    $res = mysql_query($sql,$con);
    return $res;
  }
  
  function libera_tabla($entity,$con){
    $res = false;
    $sql = "UPDATE SAVL1470 
          SET INSTANCIA_SH = 0 
          WHERE COD_ENTITY = ".$entity;
    $res = mysql_query($sql,$con);
    return $res;
  }
  
  function calcula_geopunto($latitude,$longitude,$cliente){
    $geo[0][0] = -1;
    $geo[0][1] = "SP";
    //$con2 = mysql_connect("192.168.6.111","sa","$0lstic3$");
    $con2 = mysql_connect("localhost","sa","$0lstic3$");
    if ($con2){
     $base2 = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con2);
     $sql = "SELECT P.ID_OBJECT_MAP, 
                   P.DESCRIPCION 
        FROM ADM_GEOREFERENCIAS P 
        WHERE P.ID_CLIENTE = ".$cliente." AND 
				  (DISTANCIA(P.LATITUDE,P.LONGITUDE,".$latitude.",".$longitude.") * 1000) <= P.RADIO 
			  LIMIT 1";
			//echo $sql."<br>";
     if ($qry = mysql_query($sql,$con2)){
       if (mysql_num_rows($qry) > 0){
         $row = mysql_fetch_object($qry);
         $geo[0][0] = $row->COD_OBJECT_MAP;
         $geo[0][1] = $row->DESCRIPTION;
       }
       mysql_free_result($qry);
     }
      mysql_close($con2);
    } else {
      echo mysql_error($con2);
    }
    return $geo;
  }
  
  function calcula_geocerca($latitude,$longitude,$cliente){
    $geo[0][0] = -1;
    $geo[0][1] = "SP";
    //$con2 = mysql_connect("192.168.6.111","sa","$0lstic3$");
    $con2 = mysql_connect("localhost","sa","$0lstic3$");
    if ($con2){
     $base2 = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con2);
      $sql = "SELECT P.ID_OBJECT_MAP, 
                   P.DESCRIPCION 
            FROM ADM_GEOREFERENCIAS_ESPACIAL A
              INNER JOIN ADM_GEOREFERENCIAS B ON A.ID_OBJECT_MAP = B.ID_OBJECT_MAP
            WHERE B.ID_CLIENTE = ".$cliente." AND
                  INTERSECTS(GEOMFROMTEXT ('POINT(".$latitude." ".$longitude.")'),A.geom);";
      //echo $sql."<br>";            
      if ($qry = mysql_query($sql,$con2)){
        
        $i = 0;
        while ($row = mysql_fetch_object($qry)){
          $geo[$i][0] = $row->COD_OBJECT_MAP;
          $geo[$i][1] = $row->DESCRIPTION;
          $i++;
        }
        mysql_free_result($qry);
      }
      mysql_close($con2);
    } else {
      echo mysql_error($con2);
    }
    return $geo;
  }
  
  function busca_unidad_alerta($entity,$con){
    $alertas = array();
    $columna = dia($con);
    $sql = "SELECT A.COD_ALERT_MASTER,
                    A.NAME_ALERT,
                    A.EMAIL_FROMTO,
                    A.ALARM_EXPRESION,
                    A.COD_CLIENT
             FROM ALERT_DETAIL_VARIABLES B
	           INNER JOIN ALERT_MASTER A ON A.COD_ALERT_MASTER = B.COD_ALERT_MASTER
             WHERE B.COD_ENTITY = ".$entity." AND 
                   A.".$columna." = 1 AND
	               CURRENT_TIME BETWEEN A.HORARIO_HORA_INICIO AND  A.HORARIO_HORA_FIN ";
	echo "<br> alertas programadas".$sql."<br>";
	if ($qry = mysql_query($sql,$con)){
	  $i = 0;
	  while ($row = mysql_fetch_object($qry)){
	    $alertas[$i][0] = $row->COD_ALERT_MASTER;
	    $alertas[$i][1] = $row->NAME_ALERT;
	    $alertas[$i][2] = $row->EMAIL_FROMTO;
	    $alertas[$i][3] = $row->ALARM_EXPRESION;
	    $alertas[$i][4] = $row->COD_CLIENT;
	    $i++;
	  }
	  mysql_free_result($qry);
	} 
	return $alertas;
  }
  
  function busca_clientes($entity,$con){
    $alertas = array();
    $columna = dia($con);
    $sql = "SELECT A.COD_CLIENT
             FROM ALERT_DETAIL_VARIABLES B
	           INNER JOIN ALERT_MASTER A ON A.COD_ALERT_MASTER = B.COD_ALERT_MASTER
             WHERE B.COD_ENTITY = ".$entity." AND 
                   A.".$columna." = 1 AND
	               CURRENT_TIME BETWEEN A.HORARIO_HORA_INICIO AND  A.HORARIO_HORA_FIN 
	        GROUP BY A.COD_CLIENT";
	//echo "<br> cientes programadas".$sql."<br>";
	if ($qry = mysql_query($sql,$con)){
	  $i = 0;
	  while ($row = mysql_fetch_object($qry)){
	    $alertas[$i][0] = $row->COD_CLIENT;
	    $i++;
	  }
	  mysql_free_result($qry);
	} 
	return $alertas;
  }
  
  function revisa_geo_last($last,$con,$id,$nombre,$tipo){
    $evt = "";
    $sql = "SELECT geo_descrip, 
                   geo_in,
                   geo_on,
                   geo_out,
                   IF(geo_pk IS NULL,0,geo_pk) AS geo_pk,
                   pdi_descrip, 
                   pdi_in,
                   pdi_on,
                   pdi_out,
                   IF(pdi_pk IS NULL,0,pdi_pk) AS pdi_pk
            FROM ".$last;
    //echo "revisa geo modo ".$tipo." : ".$sql."<br>";
    if ($qry = mysql_query($sql,$con)){
      $num = mysql_num_rows($qry);
      $row = mysql_fetch_object($qry);
      //modo geopunto
      if ($tipo == 'pdi'){
        if ((($row->pdi_pk == 0) and ($id > -1)) or 
            (($row->pdi_pk <> 0) and ($row->pdi_out == 1) and ($id > -1))){
          //falta un caso que es cuando la anterior fue out y ahora se trata de un in
          $evt = 'IN';
        } else {
          if ($row->pdi_pk == $id){
            $evt = 'ON';
          } else {
            $evt = 'OUT';
          }  
        } 
      }//fin modo geopunto
      if ($tipo == 'geo'){
        if ((($row->geo_pk == 0) and ($id > -1)) or 
            (($row->geo_pk <> 0) and ($row->geo_out == 1) and ($id > -1))){
          $evt = 'IN';
        } else {
          if ($row->geo_pk == $id){
            $evt = 'ON';
          } else {
            $evt = 'OUT';
          }  
        } 
      }//fin modo geocerca
      mysql_free_result($qry);
    }
    return $evt;
  }
  
  function valida_last($con,$last){
    $sql = "SELECT COUNT(*) AS EXISTE FROM ".$last;
    $qry = mysql_query($sql,$con);
    $row = mysql_fetch_object($qry);
    $res = $row->EXISTE;
    mysql_free_result($qry);
    return $res;
  }
  
  function update_last($last,$row,$con){
    if (valida_last($con,$last) > 0){
      $sql = "UPDATE ".$last."
              SET GPS_DATETIME 			= '".	((isset($row->GPS_DATETIME)) ? $row->GPS_DATETIME : 'NULL')	."', 
					 COD_ENTITY 		= ".	$row->COD_ENTITY		.",        
					 uni_pk_flota 		= ".	$row->uni_pk_flota		.",          
					 uni_pk_event 		= ".	$row->uni_pk_event		.",             
					 uni_prio_event 	= ".	$row->uni_prio_event	.",             
					 uni_descrip_event 	= '".	$row->uni_descrip_event	."',             
					 uni_status_motor 	= '".	((isset($row->uni_status_motor)) ? $row->uni_status_motor : 'NULL')."', 
					 uni_vel_stop 		= ".	((isset($row->uni_vel_stop)) ? $row->uni_vel_stop : 'NULL') .",
					 uni_vel_tope 		= ".	((isset($row->uni_vel_tope)) ? $row->uni_vel_tope : 'NULL') .",
					 uni_descrip_flota 	= '".	((isset($row->uni_descrip_flota)) ? $row->uni_descrip_flota :'NULL')."',
					 uni_status_gps 	= '".	((isset($row->uni_status_gps)) ? $row->uni_status_gps : 'NULL')."',
					 uni_velocidad 		= ".	$row->uni_velocidad		.",             
					 uni_descrip_gral 	= '".	$row->uni_descrip_gral	."',
					 longitude 			= ".	$row->longitude			.",
					 latitude 			= ".	$row->latitude.			"
			  WHERE GPS_DATETIME < '".$row->GPS_DATETIME."'"; 
    } else {
      $sql = "INSERT INTO ".$last."
              SET GPS_DATETIME 			= '".	((isset($row->GPS_DATETIME)) ? $row->GPS_DATETIME : 'NULL'	)."', 
					 COD_ENTITY 		= ".	$row->COD_ENTITY		.",        
					 uni_pk_flota 		= ".	$row->uni_pk_flota		.",          
					 uni_pk_event 		= ".	$row->uni_pk_event		.",             
					 uni_prio_event 	= ".	$row->uni_prio_event	.",             
					 uni_descrip_event 	= '".	$row->uni_descrip_event	."',             
					 uni_status_motor 	= '".	((isset($row->uni_status_motor)) ? $row->uni_status_motor : 'NULL')."', 
					 uni_vel_stop 		= ".	((isset($row->uni_vel_stop)) ? $row->uni_vel_stop : 'NULL' ).",
					 uni_vel_tope 		= ".	((isset($row->uni_vel_tope)) ? $row->uni_vel_tope : 'NULL' ).",
					 uni_descrip_flota 	= '".	((isset($row->uni_descrip_flota)) ? $row->uni_descrip_flota :'NULL')."',
					 uni_status_gps 	= '".	((isset($row->uni_status_gps)) ? $row->uni_status_gps : 'NULL')."',
					 uni_velocidad 		= ".	$row->uni_velocidad		.",             
					 uni_descrip_gral 	= '".	$row->uni_descrip_gral	."',
					 longitude 			= ".	$row->longitude			.",
					 latitude 			= ".	$row->latitude." ";     	
      /*$sql = "INSERT INTO ".$last." (
                COD_ALERT_HISTORY,
  				GPS_DATETIME, 
			    COD_ENTITY,        
				uni_pk_flota ,          
				uni_pk_event,             
				uni_prio_event,             
				uni_descrip_event,             
				uni_status_motor ,             
				uni_vel_stop ,             
				uni_vel_tope,             
				uni_descrip_flota ,             
				uni_status_gps,             
				uni_velocidad ,             
				uni_descrip_gral ,
				longitude ,
				latitude) 
			VALUES (
			  0,
			  '".$row->GPS_DATETIME."',
			  ".$row->COD_ENTITY.",
			  ".$row->uni_pk_flota.",
			  ".$row->uni_pk_event.",
			  ".$row->uni_prio_event.",             
			 '".$row->uni_descrip_event."',             
			 '".$row->uni_status_motor."',             
			  ".$row->uni_vel_stop.",             
			  ".$row->uni_vel_tope.",             
			 '".$row->uni_descrip_flota."',             
			 '".$row->uni_status_gps."',             
			  ".$row->uni_velocidad.",             
			 '".$row->uni_descrip_gral."',
			  ".$row->longitude.",
			  ".$row->latitude.")";*/
    }
    echo "<br><!--------".$sql."  ---------><br>";
    mysql_query($sql,$con);
  }
  
  function update_last_pdi($con,$evt,$last,$id,$nombre){
    switch ($evt){
      case "IN":
        $sql = "UPDATE ".$last." SET pdi_on = 0, pdi_out = 0, pdi_in = 1, pdi_pk = ".$id.", pdi_descrip = '".$nombre."'"; 
	    break;
      case "OUT":
	    $sql = "UPDATE ".$last." SET pdi_in = 0, pdi_out = 1, pdi_on = 0";
	    break;
      case "ON":
	    $sql = "UPDATE ".$last." SET pdi_in = 0, pdi_on = 1";
	    break;
	  case "RS":
	    $sql = "UPDATE ".$last." SET pdi_in = 0, pdi_on = 0, pdi_out = 0, pdi_pk = 0, pdi_descrip =''";
	    break;
    }
    mysql_query($sql,$con);   
  }
  
  function update_last_geo($con,$evt,$last,$id,$nombre){
    switch ($evt){
      case "IN":
        $sql = "UPDATE ".$last." SET geo_on = 0, geo_out = 0, geo_in = 1, geo_pk = ".$id.", geo_descrip = '".$nombre."'"; 
	    break;
      case "OUT":
	    $sql = "UPDATE ".$last." SET geo_in = 0, geo_out = 1, geo_on = 0";
	    break;
      case "ON":
	    $sql = "UPDATE ".$last." SET geo_in = 0, geo_on = 1";
	    break;
	  case "RS":
	    $sql = "UPDATE ".$last." SET geo_in = 0, geo_on = 0, geo_out = 0, geo_pk = 0, geo_descrip =''";
	    break;
    }
    mysql_query($sql,$con);   
  }
  
  function evalua_expresion($where,$con,$last){
    $res = false;
    $sql = "SELECT COUNT(*) AS EXISTE 
            FROM ".$last."
            WHERE ".$where;
    //echo $sql."<br>";
    if ($qry = mysql_query($sql,$con)){
      $row = mysql_fetch_object($qry);
      if ($row->EXISTE > 0){
        $res = true;
      }
      mysql_free_result($qry);
    } 
    return $res;
  }
  
  function borra_registro($id,$tabla,$con){
    $res = false;
    $sql = "DELETE FROM ".$tabla." WHERE COD_ALERT_HISTORY = ".$id;
    echo $sql."<br>";
    $res = mysql_query($sql,$con);
    return $res;
  }
  
  function inserta_aviso($con,$id,$alerta,$destinos,$unidad,$lat,$lon,$gps_datetime,$pkh,$entity){
    $sql = "INSERT INTO ALERT_MAIL_NOTIFICATION(
              COD_ALERT_NOTIFICATION,
              COD_ALERT_MASTER,
              FECHA_GENERADO,
              PROCESADO,
              EMAIL_SUBJECT,
              EMAIL_TEXT,
              PK_HISTORY,
              LONGITUDE,
              LATITUDE,
              DESTINATARIOS,
              COD_ENTITY
            ) VALUES (
              0,
              ".$id.",
              '".$gps_datetime."',
              'N',
              'ALERTA UNIDAD ".$unidad."',
              'Se cumplio la alerta: ".$alerta." de la unidad ".$unidad."',
              ".$pkh.",
              ".$lon.",
              ".$lat.",
              '".$destinos."',
              ".$entity."
            )";
            
    $qry = mysql_query($sql,$con);
  }
  
  function analiza_entidad($entity,$tabla,$last,$con){
    $alertas = array();
    $q = 0;
    //echo $entity."<br>";
    $alertas = busca_unidad_alerta($entity,$con); 
    $clientes = array();
    $clientes = busca_clientes($entity,$con); 
    $num_cli = count($clientes);
    $num = count($alertas);
    if ($num > 0){
      echo "si tiene alertas <br>";
      $sql = "SELECT COD_ALERT_HISTORY,
  				     GPS_DATETIME, 
					 COD_ENTITY,        
					 uni_pk_flota ,          
					 uni_pk_event,             
					 uni_prio_event,             
					 uni_descrip_event,             
					 uni_status_motor ,             
					 uni_vel_stop ,             
					 uni_vel_tope,             
					 uni_descrip_flota ,             
					 uni_status_gps,             
					 uni_velocidad ,             
					 uni_descrip_gral ,
					 longitude ,
					 latitude
				FROM ".$tabla." ORDER BY GPS_DATETIME DESC LIMIT 10";
	  if ($qry = mysql_query($sql,$con)){
	    while ($row = mysql_fetch_object($qry)){
	      // actualiza las variables de unidad en last
	      update_last($last,$row,$con);
	      //caso de geopuntos
	      for ($z=0; $z < $num_cli; $z++){
	        echo "<br><br> cliente ".$alertas[$z][4]."<br>";
	        $client = $clientes[$z][0];
	        $geo = calcula_geopunto($row->latitude,$row->longitude,$client);
		    // calcula en que geopunto esta
		    // revisa en last si estaba ya en el geopunto
		    echo "pdi ".$geo[0][0]." ".$geo[0][1]."<br>";
		    $evtp = revisa_geo_last($last,$con,$geo[0][0],$geo[0][1],'pdi');
		    echo "pdi cumple ".$evtp."<br>";
		    if ($evtp <> ""){
		      update_last_pdi($con,$evtp,$last,$geo[0][0],$geo[0][1]);    
		    }
		    $geo = calcula_geocerca($row->latitude,$row->longitude,$client);
		    $num_geo = count($geo);
		    //si hay geocerca, entonces comprueba dentro de cada geocerca las condiciones
		    if ($num_geo > 0){
		      for($x=0; $x < $num_geo; $x++){  
		        echo "geo ".$geo[0][0]." ".$geo[0][1]."<br>";
		        $evt = revisa_geo_last($last,$con,$geo[$x][0],$geo[$x][1],'geo');
		        echo "geo cumple ".$evt."<br>";
		        if ($evt <> ""){
			      update_last_geo($con,$evt,$last,$geo[$x][0],$geo[$x][1]);
			      //aqui estaba el for 
			      for ($y=0; $y < $num; $y++){
			        //evalua solo las alertas del cliente
			        if ($client == $alertas[$y][4]){
	                  if (evalua_expresion($alertas[$y][3],$con,$last)){
	                    echo "cumple alerta dentro de geo <br>";
	                    inserta_aviso($con,$alertas[$y][0],
	                          $alertas[$y][1],
	                          $alertas[$y][2],
	                          $row->uni_descrip_gral,
	                          $row->latitude,
	                          $row->longitude,
	                          $row->GPS_DATETIME,
	                          $row->COD_ALERT_HISTORY,
	                          $row->COD_ENTITY);
	                    $q++;
	                  }
	                } 
			      }
			      //SI EL EVENTO DE GEOCERCA DETECTADO FUE UNA SALIDA 
			      //REINICIA LA VARIABLE PARA QUE NO SE VUELVA A CUMPLIR
			      if ($evt == 'OUT'){
			        update_last_geo($con,"RS",$last,0,'');
			      }  
		        }
		      }
		    } else {
		      // si no hay geocercas, revisa las variables
		      for ($y=0; $y < $num; $y++){
		        if ($client == $alertas[$y][4]){
	              if (evalua_expresion($alertas[$y][3],$con,$last)){
	                echo "cumple alerta fuera de geo <br>";
	                inserta_aviso($con,$alertas[$y][0],
	                          $alertas[$y][1],
	                          $alertas[$y][2],
	                          $row->uni_descrip_gral,
	                          $row->latitude,
	                          $row->longitude,
	                          $row->GPS_DATETIME,
	                          $row->COD_ALERT_HISTORY,
	                          $row->COD_ENTITY);
	                $q++;
	              }
	            } 
		      }
		    }
		    //SI EL EVENTO DE GEOCERCA DETECTADO FUE UNA SALIDA 
			//REINICIA LA VARIABLE PARA QUE NO SE VUELVA A CUMPLIR
			if ($evtp == 'OUT'){
			  update_last_pdi($con,"RS",$last,0,'');
			}
		  }
		  borra_registro($row->COD_ALERT_HISTORY,$tabla,$con);
		} 
		mysql_free_result($qry);
	  }
	} else {
	  $sql = "TRUNCATE TABLE ".$tabla;
	  mysql_query($sql);
	}
	echo "<br>-----Se cumplieron: ".$q."--------<br>";
  }
  
  $con = mysql_connect("localhost","sa","$0lstic3$");
  if (!$con){
    $base2 = mysql_select_db("ALG_BD_CORPORATE_ALERTAS_MOVI",$con);
    //paso 1 marca tablas a revisar en grupos de 5
    //$instancia = time();
    $instancia = 1374785157;
    echo "inicio: ".date("G:i:s")."<br><br>";
    if (marca_tablas($instancia,$con)){
  
      $sql = "SELECT DESCRIPTION,
                 COD_TABLE,
                 COD_ENTITY,
                 LPAD(COD_ENTITY,6,'0') AS NOMBRE
              FROM SAVL1470
              WHERE INSTANCIA_SH = ".$instancia;
              //echo $sql;
      if ($qry = mysql_query($sql,$con)){
        while ($row = mysql_fetch_object($qry)){
	      $last = "ALERTLAST".$row->NOMBRE;
	      analiza_entidad($row->COD_ENTITY,$row->DESCRIPTION,$last,$con);
	      libera_tabla($row->COD_ENTITY,$con);
		}
		mysql_free_result($qry);
	  }
    }
    mysql_close($con);
    echo "<br><br>fin: ".date("G:i:s");
  }
?>
