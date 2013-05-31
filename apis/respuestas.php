<?php

  $preg['pregunta'   ]=$_REQUEST["pr"];
  $preg['cuestionario']=$_REQUEST["cu"];
  $preg['respuesta'  ]=$_REQUEST["rs"];
  
  function inserta_pregunta($preg){
	global $base;
    $resultado =0;
    $sql="INSERT INTO CRM2_PREG_RES (ID_PREGUNTA,
						  ID_RES_CUESTIONARIO,
						  RESPUESTA) 
	             VALUES (".$preg['pregunta'].",
						 ".$preg['cuestionario'  ].",
						 '".$preg['respuesta'   ]."')";
	$gene=mysql_query($sql);
    if ($gene){
	  $resultado= true;
	}
    return $resultado;
  }
  
  
   
  function actualiza_pregunta($preg){
    global $base;
	$resultado = false;
	$sql = "UPDATE CRM2_PREG_RES SET
              ID_PREGUNTA = ".$preg['pregunta'].",
			  ID_RES_CUESTIONARIO=".$preg["cuestionario"].",
			  RESPUESTA='".$preg["respuesta"]."'
		     WHERE ID_RES_CUESTIONARIO = ".$preg['cuestionario'   ]." and
			      ID_PREGUNTA=".$preg['pregunta'];	
	$qry = mysql_query($sql);
	if ($qry){
	  $resultado = true;
	} 
	return $resultado;
  }
  
  
  function existe($preg){
	global $base;
    $resultado ="";
	$sql = "SELECT COUNT(1) AS CUENTA
            FROM CRM2_PREG_RES
			WHERE ID_RES_CUESTIONARIO = ".$preg['cuestionario'   ]." and
			      ID_PREGUNTA=".$preg['pregunta'];	
				  
			
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
    mysql_select_db("movilidad",$base);
    if (existe($preg) >0){
	  if (actualiza_pregunta($preg)){
	    echo "15";
	  }else{
		echo "1";
	  }
	}else{
	  if(inserta_pregunta($preg)){
	    echo "15";
	  }else{
		echo "1";
	  }
	}
  }
  ?>