<?php

  $reg['cuestionario']=$_REQUEST["cu"];
  $reg['respuesta'  ]=$_REQUEST["rs"];
  
  $reg["imei"]=$_REQUEST["im"];
  $reg["lat"]=$_REQUEST["lat"];
  $reg["lon"]=$_REQUEST["lon"];
  $reg["alt"]=$_REQUEST["alt"];
  $reg["ang"]=$_REQUEST["ang"];
  $reg["vel"]=$_REQUEST["vel"];
  $reg["feh"]=$_REQUEST["feh"];
  
  
   function actualiza_respuesta($reg){
    global $base;
	$resultado = false;
	$sql = "UPDATE CRM2_RESPUESTAS SET
  		      FECHA='" .$reg["feh"]."',
			  LATITUD="  .$reg["lat"].",
			  LONGITUD="  .$reg["lon"]."
			WHERE ID_RES_CUESTIONARIO=".$reg['respuesta'];	
	$qry = mysql_query($sql);
	if ($qry){
		  $resultado = true;
	} 
	return $resultado;
  }
  

  function dame_respuestas($reg){
	global $base;
    $resultado ="";
	$sql = "SELECT COUNT(1) AS CUENTA
            FROM CRM2_PREG_RES
			WHERE ID_RES_CUESTIONARIO = ".$reg['respuesta'];	
	//echo $sql;
	$qry = mysql_query($sql);
	if($qry){
      $row = mysql_fetch_object($qry);
	  $resultado = $row->CUENTA;    
	  mysql_free_result($qry);
	}
	return $resultado;
  }
  
  
    function dame_preguntas($reg){
	global $base;
    $resultado ="";
	$sql = "SELECT count(1) AS CUENTA
            FROM CRM2_CUESTIONARIO_PREGUNTAS
            WHERE CRM2_CUESTIONARIO_PREGUNTAS.ID_CUESTIONARIO=".$reg['cuestionario'];	
	$qry = mysql_query($sql);
	if($qry){
      $row = mysql_fetch_object($qry);
	  $resultado = $row->CUENTA;    
	  mysql_free_result($qry);
	}
	return $resultado;
  }
  
  
  $base = mysql_connect("localhost",'savl','397LUP');
  if (!$base) {

    echo "Error de conexion \n";
  } else {  
    
//	echo dame_respuestas($preg)." ".dame_preguntas($preg)."<br>";
  //
    mysql_select_db("movilidad",$base);
	
	include("gps.php");
	
    if (dame_respuestas($reg)>=dame_preguntas($reg)){
		
		
		$reg['cod_entity']=dame_cod_entity($reg);
        $reg['cod_event']=10000;
	  if (actualiza_respuesta($reg)){	
		
		if ($reg['cod_entity']>0){
		  if (inserta_actualiza_1141($reg)){
		    $reg['cod_hist0']=inserta_hist00000($reg);
			if ($reg['cod_hist0']>0){
				if (inserta_respuestas_histo($reg)){
					echo "15";
				}else{
					echo "Error al escribir RESPUESTAS HISTORICO";
				}
			}else{
				echo "Error al escribir en HIST00000";
			}
		  }else{
			  echo "Error al escribir en 1141";
		  }
			
		}else{
	      echo "Error al buscar cod_entity";
	    }
	  }else{
	     echo "Error al actualizar la respuesta";
	  }
      
    }else{
	  echo "1";
    }
  }


?>