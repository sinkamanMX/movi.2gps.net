<?php

    if (!function_exists('json_encode')){
        function json_encode($a=false){
            if (is_null($a)) return 'null';
            if ($a === false) return 'false';
            if ($a === true) return 'true';
            if (is_scalar($a)){
                if (is_float($a)){
                    // Siempre usa "." para floats.
                    return floatval(str_replace(",", ".", strval($a)));
                }
                if (is_string($a)){
                    static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
                    return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
                }else  return $a;
            }
            $isList = true;
            for ($i = 0, reset($a); $i < count($a); $i++, next($a)){
                if (key($a) !== $i){
                    $isList = false;
                    break;
                }
            }
            $result = array();
            if ($isList){
                 foreach ($a as $v) $result[] = json_encode($v);
                 return '[' . join(',', $result) . ']';
            }else{
                foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
                return '{' . join(',', $result) . '}';
            }
        }
    }

    function array_type($array){
        if (is_array($array)){
             $next = 0;
             $return_value = "vector";  // we have a vector until proved otherwise
             foreach ($array as $key => $value){
                 if ($key != $next){
                     $return_value = "map";  // we have a map
                     break;
                 }
                 $next++;
             }
             return $return_value;
        }
        return false;    // not array
    }

    function utf8_encode_array($array){
        if (is_array($array)){
            $result_array = array();
            foreach($array as $key => $value){
                if (array_type($array) == "map"){
                    // encode both key and value
                    if (is_array($value)){
                        // recursion
                        $result_array[utf8_encode($key)] = utf8_encode_array($value);
                    }else{
                        // no recursion
                        if (is_string($value)){
                            $result_array[utf8_encode($key)] = utf8_encode($value);
                        }else{
                            // do not re-encode non-strings, just copy data
                            $result_array[utf8_encode($key)] = $value;
                        }
                    }
                }else if (array_type($array) == "vector"){
                    //encode value only
                    if (is_array($value)) {
                        // recursion
                        $result_array[$key] = utf8_encode_array($value);
                    }else{
                        // no recursion
                        if (is_string($value)){
                            $result_array[$key] = utf8_encode($value);
                        }else{
                            //do not re-encode non-strings, just copy data
                            $result_array[$key] = $value;
                        }
                    }
                }
            }
            return $result_array;
        }
        return false;     // argument is not an array, return false
    }
   
    function existeUsuario($usName,$usPassword,$base){
        $result = -1;
        $sql = "SELECT ID_USUARIO AS EXISTE 
                FROM ADM_USUARIOS 
                WHERE USUARIO = '".$usName."' AND  
                      SHA1_PASSWORD = '".$usPassword."'";
        if ($qry = mysql_query($sql)){
            $row = mysql_fetch_object($qry);
            if($row->EXISTE > 0){
                $result = $row->EXISTE;
            }
            mysql_free_result($qry);
        }
        return $result;
    }

     function existe_equipo($base,$imei){
         $result = -1;
         $sql = "SELECT ITEM_NUMBER AS EXISTE 
                 FROM ADM_EQUIPOS 
                 WHERE IMEI = '".$imei."'";
         if ($qry = mysql_query($sql)){
             $row = mysql_fetch_object($qry);
             if ($row->EXISTE > 0){
                 $result = $row->EXISTE;
             }
             mysql_free_result($qry);
         }
         return $result;
    }
  
    function verifica_grupo($codUser,$base,&$s){
        $result = false;
        $sql = "SELECT count(1) AS EXISTE
                FROM ADM_USUARIOS_GRUPOS 
                WHERE ID_USUARIO = ".$codUser; 
        $s = $sql;
        if ($qry = mysql_query($sql)){
            $row = mysql_fetch_object($qry);
            if ($row->EXISTE >= 1){
                $result = true;
            }
            mysql_free_result($qry);
        }
        return $result;
    }

    function verificaVersion($base,&$version,&$url,$item_app,$codUser){
        $sql = " SELECT ADM_APLICACIONES_VERSION.VERSION,
                        ADM_APLICACIONES_EMPRESA.URL_PRIMARIO
                 FROM ADM_USUARIOS
                      INNER JOIN ADM_APLICACIONES_EMPRESA ON                
                                 ADM_USUARIOS.ID_EMPRESA=ADM_APLICACIONES_EMPRESA.ID_EMPRESA
                      INNER JOIN ADM_APLICACIONES_VERSION ON 
                                 ADM_APLICACIONES_VERSION.ID_VERSION=ADM_APLICACIONES_EMPRESA.ID_VERSION
                 WHERE  ADM_APLICACIONES_EMPRESA.ITEM_APP='".$item_app."' AND
                        ADM_USUARIOS.ID_USUARIO=".$codUser; 
        if($qry = mysql_query($sql)){
            $row = mysql_fetch_object($qry);
            $version = $row->VERSION;
            $url = $row->URL_PRIMARIO; 
            mysql_free_result($qry);
        }
    }

    function inserta_respuestas($reg){
        global $base;
        $resultado =0;
        if(strlen(trim($reg["dto_x"]))==0) $reg["dto_x"]="0";
        if(strlen(trim($reg["dto_y"]))==0) $reg["dto_y"]="0";
        $sql="INSERT INTO CRM2_RESPUESTAS (ID_RES_CUESTIONARIO,
                                           ID_CUESTIONARIO,
                                           COD_USER,
                                           FECHA,
                                           LATITUD,
                                           LONGITUD,
                                           BATERIA,
                                           FECHA_INICIO_CAPTURA,
                                           FECHA_RECEPCION,
                                           NUM_SEMANA,
                                           ID_EJE_X,
                                           ID_EJE_Y) 
              VALUES (0,
                      ".$reg['cuestionario'].",
                      ".$reg['cod_user'  ].",
                      '".$reg['feh' ]."',
                      ".$reg['lat'  ].",
                      ".$reg['lon'  ].",
                      ".$reg['bat'  ].",
                      '".$reg["fecha_ini_cap"]."',
                      CURRENT_TIMESTAMP,
                      WEEKOFYEAR('".$reg['feh' ]."'),
                      ".$reg["dto_x"].",
                      ".$reg["dto_y"].")";
                      $gene=mysql_query($sql);
        //echo $sql;
        if ($gene){
            $resultado= mysql_insert_id();
        }
        return $resultado;
    }

     function dame_tiempo_reporte_unidad($base,$imei){
         $result = 5;
         $sql = "SELECT TIME_REPORT AS TIEMPO 
                 FROM ADM_EQUIPOS 
                 WHERE IMEI = '".$imei."'";
         //echo $sql;
         if ($qry = mysql_query($sql)){
             $row = mysql_fetch_object($qry);
             if ($row->TIEMPO > 0){
                 $result = $row->TIEMPO;
             }
             mysql_free_result($qry);
         }
         return $result;
    }

    function dame_cod_entity($imei){
        global $base;
        $resultado =0;
        $sql = "SELECT ADM_UNIDADES_EQUIPOS.COD_ENTITY
                FROM ADM_EQUIPOS 
                INNER JOIN ADM_UNIDADES_EQUIPOS ON  ADM_UNIDADES_EQUIPOS.COD_EQUIPMENT=ADM_EQUIPOS.COD_EQUIPMENT
                WHERE ADM_EQUIPOS.IMEI = '".$imei."'";
        $qry = mysql_query($sql);
        if($qry){
            $row = mysql_fetch_object($qry);
            $resultado = $row->COD_ENTITY;    
            mysql_free_result($qry);
        }
        return $resultado;
    }
	
    function es_para_geopunto($id_p){
        global $base;
        $resultado ="NO";
        $sql = 'SELECT CASE WHEN  CRM2_PREGUNTAS.ID_TIPO=9  THEN "FOTO"
                        WHEN  CRM2_PREGUNTAS.ID_TIPO=17 THEN "GEOPUNTO"
                        WHEN  CRM2_PREGUNTAS.ID_TIPO=18 THEN "REFERENCIA"
                        ELSE "NO" END AS TIPO
                   FROM CRM2_PREGUNTAS
                   WHERE CRM2_PREGUNTAS.ID_PREGUNTA='.$id_p;	
        $qry = mysql_query($sql);
        if($qry){
            $row = mysql_fetch_object($qry);
            $resultado = $row->TIPO;    
            mysql_free_result($qry);
        }
        return $resultado;
    }

    function dame_cod_client_usuario($usuario){
        global $base;
        $resultado ="0";
        $sql = 'SELECT ID_CLIENTE
                    FROM ADM_USUARIOS
                    WHERE ID_USUARIO='.$usuario;
        $qry = mysql_query($sql);
        if($qry){
            $row = mysql_fetch_object($qry);
            $resultado = $row->ID_CLIENTE;
            mysql_free_result($qry);
        }
        return $resultado;
    }

    function dame_cod_client_equipo($imei){
        global $base;
        $resultado ="0";
        $sql = "SELECT ADM_EQUIPOS.ID_CLIENTE
                FROM ADM_EQUIPOS 
                WHERE ADM_EQUIPOS.IMEI = '".$imei."'";
        $qry = mysql_query($sql);
        if($qry){
            $row = mysql_fetch_object($qry);
            $resultado = $row->ID_CLIENTE;
            mysql_free_result($qry);
        }
        return $resultado;
    }

    function existe_geopunto($item_number,$cliente){
        global $base;
        $resultado =0;
        $sql = 'SELECT ID_OBJECT_MAP
                FROM ADM_GEOREFERENCIAS
                WHERE ITEM_NUMBER="'.$item_number.'" AND
                      ID_CLIENTE='.$cliente;
        $qry = mysql_query($sql);
        if($qry){
            $row = mysql_fetch_object($qry);
            $resultado = $row->ID_OBJECT_MAP;
            mysql_free_result($qry);
        }
        return $resultado;
    }

    function elimina_respuesta($reg){
        global $base;
        $sql1="DELETE FROM ADM_GEOREFERENCIA_RESPUESTAS WHERE ID_OBJECT_MAP=".$reg['geo_punto']." AND ID_RES_CUESTIONARIO=".$reg['respuesta'];
        mysql_query($sql1);
        $sql2="DELETE FROM CRM2_PREG_RES WHERE ID_RES_CUESTIONARIO=".$reg['respuesta'];
        mysql_query($sql2);
        $sql3="DELETE FROM CRM2_RESPUESTAS WHERE ID_RES_CUESTIONARIO=".$reg['respuesta'];
        mysql_query($sql3);
    }

    function inserta_geopunto($reg){
        global $base;
        $resultado =0;
        $sql="INSERT INTO ADM_GEOREFERENCIAS(
                ID_CLIENTE,
                ID_TIPO_GEO,
                DESCRIPCION,
                LONGITUDE,
                LATITUDE,
                ID_ADM_USUARIO,
                CREADO,
                ITEM_NUMBER) 
              VALUES (
                 ".$reg['cod_client' ].",
                 4,
                 '".$reg['descripcion']."',
                 ".$reg["lon"].",
                 ".$reg["lat"].",
                ".$reg["cod_user"].",
                CURRENT_TIMESTAMP,
                '".$reg['clave']."')";
        $gene=mysql_query($sql);
        if($gene){
            $resultado= mysql_insert_id();
        }
        return $resultado;
    }

    function inserta_cus_geop($reg){
        global $base;
        $resultado =0;
        $sql="INSERT INTO ADM_GEOREFERENCIA_RESPUESTAS(
                 ID_RES_CUESTIONARIO,
                 ID_OBJECT_MAP) 
              VALUES (".$reg['respuesta'].",
                      ".$reg['geo_punto'].")";
        $gene=mysql_query($sql);
        if ($gene){
            $resultado= true;
        }
        return $resultado;
    }
	
    function inserta_respuesta($reg){
        global $base;
        $resultado =0;
        $sql="INSERT INTO CRM2_PREG_RES (ID_PREGUNTA,
                                         ID_RES_CUESTIONARIO,
                                          RESPUESTA) 
              VALUES (".$reg['pregunta'].",
                      ".$reg['respuesta'  ].",
                      '".$reg['res_p']."')";
        $gene=mysql_query($sql);
        if($gene){
            $resultado= true;
        }
        return $resultado;
    }
    function geop_img($geop,$img){
        global $base;
        $resultado =0;
        $sql="INSERT INTO ADM_GEOREFERENCIA_IMG(
                     COD_IMAGEN,
                     ID_OBJECT_MAP,
                     IMG) 
              VALUES (0,
                      ".$geop.",
                      '".$img."')";
        $gene=mysql_query($sql);
        if($gene){
            $resultado= true;
        }
        return $resultado;
    }

    function get_tablename($id_client){
        $id_client = (int)$id_client; 
        $table_name = '';  
        if (strlen($id_client) < 5) {
            $table_name = str_repeat('0', (5-strlen($id_client)));
        }
        return $table_name . $id_client;
    }


    function existe_last($reg){
        global $base;
        $resultado =0;
        $tabla="LAST".get_tablename(trim($reg["cod_client"]));
        $sql = "SELECT COUNT(1) AS CUENTA
                FROM ".$tabla."
                WHERE COD_ENTITY='".$reg['cod_entity']."'";	
        $qry = mysql_query($sql);
        if($qry){
            $row = mysql_fetch_object($qry);
            $resultado = $row->CUENTA;    
            mysql_free_result($qry);
        }
        return $resultado;
    }

    function actualiza_last($reg){
        global $base;
        $resultado = false;
        $tabla="LAST".get_tablename(trim($reg["cod_client"]));
        $sql = "UPDATE ".$tabla." SET
                       GPS_DATETIME = '".$reg['feh']."',
                       VELOCITY="  .$reg["vel"].",
                       LONGITUDE=" .$reg["lon"].",
                       LATITUDE="  .$reg["lat"].",
                       ALTITUDE="  .$reg["alt"].",
                       ANGLE="     .$reg["ang"].",
                       BATTERY="  .$reg["bat"].",
                       COD_EVENT=" .$reg["cod_event"].",
                       FECHA_SAVE=CURRENT_TIMESTAMP,
                       GL_TYPE_LOC='".$reg["prov"]."',
                       DISTANCIA=". $reg["mts_error"].",
                       GL_GCI='". $reg["GC"]."',
                       GL_DBM_C=". $reg["senal"].",
                       GL_MAC_ADD='". $reg["macc"]."',
                       GL_DBM_W=". $reg["senal_w"]."
                WHERE COD_ENTITY=".$reg['cod_entity'];	
        //echo $sql;
        $qry = mysql_query($sql);
        if($qry){
            $resultado = true;
        } 
        return $resultado;
    }

    function inserta_last($reg){
        global $base;
        $resultado =0;
        $tabla="LAST".get_tablename(trim($reg["cod_client"]));
        $sql="INSERT INTO ".$tabla." (
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
                          FECHA_SAVE,
                          GL_TYPE_LOC,
                          DISTANCIA,
                          GL_GCI,
                          GL_DBM_C,
                          GL_MAC_ADD,
                          GL_DBM_W
               )VALUES (
                         0,
                         ".$reg['cod_entity'].",
                         '".$reg["feh"]."',
                         ".$reg['vel'].",
                         ".$reg['lon'].",
                         ".$reg['lat'].",
                         ".$reg['alt'].",
                         ".$reg['ang'].",
                         ".$reg['bat'].",
                         ".$reg['cod_event'].",
                         CURRENT_TIMESTAMP,
                        '".$reg["prov"]."',
                         ".$reg["mts_error"].",
                         '".$reg["GC"]."',
                         ".$reg["senal"].",
                         '".$reg["macc"]."',
                         ". $reg["senal_w"].")";
        $gene=mysql_query($sql);
        if ($gene){
            $resultado= mysql_insert_id();
        }
        return $resultado;
    }
	
    function inserta_hist($reg){
        global $base;
        $resultado =0;
        $tabla="HIST".get_tablename(trim($reg["cod_client"]));
        $sql="INSERT INTO ".$tabla." (
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
                          FECHA_SAVE,
                          GL_TYPE_LOC,
                          DISTANCIA,
                          GL_GCI,
                          GL_DBM_C,
                          GL_MAC_ADD,
                          GL_DBM_W
               )VALUES (
                         0,
                         ".$reg['cod_entity'].",
                         '".$reg["feh"]."',
                         ".$reg['vel'].",
                         ".$reg['lon'].",
                         ".$reg['lat'].",
                         ".$reg['alt'].",
                         ".$reg['ang'].",
                         ".$reg['bat'].",
                         ".$reg['cod_event'].",
                         CURRENT_TIMESTAMP,
                        '".$reg["prov"]."',
                         ".$reg["mts_error"].",
                         '".$reg["GC"]."',
                         ".$reg["senal"].",
                         '".$reg["macc"]."',
                         ". $reg["senal_w"].")";
        $gene=mysql_query($sql);
        if($gene){
             $resultado= mysql_insert_id();
        }else{
            echo mysql_error();	
        }
        return $resultado;
    }
	
    function inserta_respuestas_histo($reg){
        global $base;
        $resultado =0;
        $sql="INSERT INTO CRM2_RESPUESTAS_HISTORICO (
                     ID_RES_CUESTIONARIO,
                     COD_HISTORY) 
              VALUES (".$reg['respuesta'].",
                      ".$reg['cod_hist0'].")";
        $gene=mysql_query($sql);
        if($gene){
            $resultado= 1;
        }
        return $resultado;
    }

    function inserta_cuantitativo($reg){
        global $base;
        $resultado =0;
        $sql="INSERT INTO CRM2_RESPUESTAS_CUANTITATIVO (
                     ID_RES_CUESTIONARIO,
                     CADENA_CUANTITATIVO,
                     CALIFICADO) 
              VALUES (".$reg['respuesta'].",
                      '".$reg['dto_cuanti']."',
                      0)";
        $gene=mysql_query($sql);
        if($gene){
            $resultado= 1;
        }
        return $resultado;
    }

    function inserta_actualiza_last($reg){
        global $base;  
        $resultado=false;
        if(existe_last($reg)){
            if(actualiza_last($reg)) {$resultado=true;}
        }else{
            if(inserta_last($reg)) { $resultado=true;}
        }
        return $resultado;
  }

    function inst_evento($reg){
        $resultado=0;
        if (inserta_actualiza_last($reg)){
            $reg['cod_hist0']=inserta_hist($reg);
            if ($reg['cod_hist0']>0){
                if($reg['respuesta']>0 and $reg['cod_event']==10000){
                    if (inserta_respuestas_histo($reg)){
                        $resultado=1;
                    }else{
                        $resultado=-3;
                    }
                }else{
                    if($reg['cod_event']==10000){
                        $resultado=-4;
                    }else{
                        $resultado=1;
                    }
                }
            }else{
                $resultado=-2;
            }
        }else{
             $resultado=-1;
        }
        return $resultado;
    }
	
  function existeCodUser($cod_user){
    $result = -1;
	$sql = "SELECT ID_USUARIO AS EXISTE 
	        FROM ADM_USUARIOS 
		    WHERE ID_USUARIO = ".$cod_user; 
	if ($qry = mysql_query($sql)){
	  $row = mysql_fetch_object($qry);
	  if ($row->EXISTE > 0){
	    $result = $row->EXISTE;
	  }
	  mysql_free_result($qry);
	}
	return $result;
  }
  
  
   function valida_evento($evento){
	$res = 0;
    $sql = "SELECT 1 AS EXISTE 
	         FROM ADM_EVENTOS
			 WHERE COD_EVENT = ".$evento;
	if ($qry = mysql_query($sql)){
	  $row = mysql_fetch_object($qry);
	  $res = $row->EXISTE;
	  mysql_free_result($qry);	
	}
	return $res;
  }
  
function registraIncidente($imei,$user,$tipo,$entrega,$fecha,$comentarios,$latitud,$longitud,$evento,$bateria,$velocidad,$cod_client,$cod_entity){
    $res = "";
	
	     $reg['respuesta']=0;
        $reg["imei"]=$imei;
        $reg["feh"]=$fecha;
        $reg["bat"]=$bateria;
        $reg['cod_event']=$evento;
        $reg['cellid']="";
        $reg['lac']="";
        $reg['mcc_mnc']="";
        $reg['senal']="0";
        $reg['macc']="";
        $reg['senal_w']="-20";
        $reg["vel"]=$velocidad;
        $reg["lon"]=$longitud;
        $reg["lat"]=$latitud;
        $reg["alt"]="0";
        $reg["ang"]="0";
        $reg["prov"]="S/P";
        $reg["fecha_red"]=$fecha;
        $reg["mts_error"]="0";
        $reg["GC"]="";
        $reg["mcc"]= "";
        $reg["mnc"]= "";
		$reg['cod_client']=$cod_client;
	    $reg['cod_entity']=$cod_entity;
	
	$ok = 0;
	if ($tipo == 0){
      if (strlen($comentarios) > 0 ){
	    $sql = "INSERT INTO DSP_INCIDENCIA_ITINERARIO (ID_ENTREGA,ID_TIPO,COD_USER,COMENTARIOS,FECHA) 
		        VALUES (".$entrega.",1,".$user.",'".$comentarios."','".$fecha."');";
		$ok = 1;
	  } else {
	    $res = '<?xml version="1.0" encoding="UTF-8"?> 
	           <alert> 
				    <id>-50</id> 
					<msg>Debe incluir un comentario</msg>
                </alert>';
	  }
	} else if ($tipo == 1) {
	  $sql = "UPDATE DSP_ITINERARIO SET FECHA_ARRIBO = '".$fecha."', ID_ESTATUS = 4 WHERE ID_ENTREGA = ".$entrega;
	  $ok = 1;
	} else if ($tipo == 2){
	  $sql = "UPDATE DSP_ITINERARIO SET FECHA_SALIDA = '".$fecha."', ID_ESTATUS = 3 WHERE ID_ENTREGA = ".$entrega;
	  //REVISA SI ES EL ULTIMO, S
	  //$x = fin_viaje($entrega,$fecha);
	  $ok = 1; 	
	}
	//
	//echo $ok." tipo ".$tipo." sql ".$sql;
	
	
	if ($ok == 1){
      if ($qry = mysql_query($sql)){
		  //echo $ok;
		  if (inst_evento($reg)>0){
			$res = 'Guardada Correctamente';
		  } else {
		    $res = "Se registro incidencia, fallo evento";
		  }
	   /*  $res = '<?xml version="1.0" encoding="UTF-8"?> 
	             <alert> 
			  	      <id>1</id> 
					  <msg>Guardada Correctamente</msg>
                 </alert>';*/	
	  } else {
		  $res = 'No fue posible guardar incidencias';
	    /*$res = '<?xml version="1.0" encoding="UTF-8"?> 
	              <alert> 
				    <id>-50</id> 
					<msg>No fue posible guardar incidencias</msg>
                  </alert>';*/  
	  }
    } else {
		 $res = 'Sucedio un problema al guardar al guardar el evento';
	  /*$res = '<?xml version="1.0" encoding="UTF-8"?> 
	              <alert> 
				    <id>-50</id> 
					<msg>Sucedio un problema al guardar al guardar el evento</msg>
                  </alert>';  */
	}
	return $res;
  }  
  
?>