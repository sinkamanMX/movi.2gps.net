<?php


  $login['usuario']=$_REQUEST["usu"];
  $login['contrasena'  ]=$_REQUEST["con"];
  $login['imei'  ]=$_REQUEST["im"];
  $login['versionCode'  ]=$_REQUEST["versionCode"];


  function existe_usuario($login){
	global $base;
    $resultado =0;
	$sql = "SELECT COUNT(1) as CUENTA
            FROM SAVL1100
            WHERE USER_EMAIL='".$login['usuario']."'";	
	//echo $sql;
	$qry = mysql_query($sql);
	if($qry){
      $row = mysql_fetch_object($qry);
	  $resultado = $row->CUENTA;    
	  mysql_free_result($qry);
	}
	return $resultado;
  }



   function existe_contrasena($login){
	global $base;
    $resultado =0;
	$sql = "SELECT COD_USER
            FROM SAVL1100
            WHERE USER_EMAIL='".$login['usuario']."' AND
			      USER_SPASSWORD='".$login['contrasena']."'";	
	//echo $sql;
	$qry = mysql_query($sql);
	if($qry){
      $row = mysql_fetch_object($qry);
	  $resultado = $row->COD_USER;    
	  mysql_free_result($qry);
	}
	return $resultado;
  }
  
  
  
   function existe_grupo($login){
	global $base;
    $resultado =0;
	$sql = "SELECT COUNT(1) AS CUENTA
            FROM SAVL1101
            WHERE COD_USER=".$login['cod_user'];
			
	//echo $sql;
	$qry = mysql_query($sql);
	if($qry){
      $row = mysql_fetch_object($qry);
	  $resultado = $row->CUENTA;    
	  mysql_free_result($qry);
	}
	return $resultado;
  }
  
  
  function existe_dispositivo($login){
	global $base;
    $resultado =0;
	$sql = "SELECT COUNT(1) AS CUENTA
            FROM SAVL1120
            WHERE ITEM_NUMBER_UNITY='".$login['imei']."'";
			
	//echo $sql;
	$qry = mysql_query($sql);
	if($qry){
      $row = mysql_fetch_object($qry);
	  $resultado = $row->CUENTA;    
	  mysql_free_result($qry);
	}
	return $resultado;
  }
  
  
  
  function actualiza_vc($login){
    global $base;
	$resultado = false;
	$sql = "UPDATE SAVL1120 SET
  		      VERSION_CODE=" .$login['versionCode'  ]."
			WHERE ITEM_NUMBER_UNITY='".$login['imei']."'";
	$qry = mysql_query($sql);
	if ($qry){
		  $resultado = true;
	} 
	return $resultado;
  }

  $base = mysql_connect("localhost",'savl','397LUP');
  if (!$base) {
    echo "Error de conexion \n";
  }else{  
    mysql_select_db("movilidad",$base);
	
	if (existe_dispositivo($login)>0){
	
	   actualiza_vc($login);
		
	  if (existe_usuario($login)>0){
		$login['cod_user']=existe_contrasena($login);
		if ($login['cod_user']>0){
		  if(existe_grupo($login)>0){	
		    echo $login['cod_user'];
		  }else{
            echo "error3";			  
		  }
		}else{
		  echo "error2";	
		}
	  }else{
		echo "error1";
	  }
	}else{
	  echo "error4";
	}

  }


?>