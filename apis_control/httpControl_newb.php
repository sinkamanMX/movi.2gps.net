<?php

  //header('Content-type: application/json');
  include('functions_control_newb.php');
  
  
  function Login($usName,$usPassword,$imei,$vCode,$item_app){ 
    $con = mysql_connect("localhost","savl","397LUP");
	if ($con){
      $base = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con);
	    $cod_user = existeUsuario($usName,$usPassword,$base);
	    if ($cod_user > 0){
			
	      if (verifica_grupo($cod_user,$base,&$s)){
			$version="";
			$url="";
		    verificaVersion($cod_user,$base,&$version,&$url,$item_app);
	        if ( $version == $vCode){
		      $res =  $resultado["id"]=$cod_user;
  	          $resultado["Mensaje"]="OK";	
		    } else {
		      $resultado["id"]=$cod_user;
  	          $resultado["Mensaje"]="OK,".$version.','.$url;		
		    }
	      } else {
	        $resultado["id"]="-4";
  	        $resultado["Mensaje"]="El usuario no tiene asociado un grupo y/o unidades";		  
	      }
	    }else {
	      $resultado["id"]="-3";
	      $resultado["Mensaje"]="El usuario y/o password son inválidos";	
		  
	    }
    } else {
      $resultado["id"]="-1";
	  $resultado["Mensaje"]="No hay conexión a base de datos";
    }
	$output[]=$resultado;
    $res= json_encode($output);
    return $res;
  }
  
  function Lunidades($userID){
	$con = mysql_connect("localhost","savl","397LUP");
	if ($con){
	  if($userID>0){	
        $base = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con);	  
	    $unidades;
	    $unidades=unidades($userID);
		  if(count($unidades)>0){
	        $res=$unidades;
		  }else{
			$resultado["id_error"]="-3";
	        $resultado["Mensaje"]="Sin unidades disponibles";  
			$res[]=$resultado;
		  }
	  }else{
		$resultado["id_error"]="-2";
	    $resultado["Mensaje"]="El usuario es invalido";
		$res[]=$resultado;
	  }
	}else{
      $resultado["id_error"]="-1";
	  $resultado["Mensaje"]="No hay conexión a base de datos";
	  $res[]=$resultado;
    }
	return json_encode($res);
  }
  
  function Lcomandos($user,$cod_entity){
	 $con = mysql_connect("localhost","savl","397LUP");
	 
	  if ($con){
		  $base = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con);	
		  if($user<>"" && $cod_entity<>""){
		     $result=comandos($user,$cod_entity);
		  }else{
		   $resultado["PHONE"]="-3";
	       $resultado["DESCRIPCION"]="Usuario y/o unidad incorrectos";  
		   $res[]=$resultado;
		   $result=json_encode($res);
		  }
	  }else{
		   $resultado["PHONE"]="-2";
	       $resultado["DESCRIPCION"]="Sin conexión a la base de datos";  
		   $res[]=$resultado;
		   $result=json_encode($res);
	  }	  
	  return $result;
	  
  }
  
  function ult_posicion($cod_e,$Cod_client){
	 $con = mysql_connect("localhost","savl","397LUP");
	  if ($con){
		  if($cod_e<>""){
		  
	      $base = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con);	 
		  $result=posicion($cod_e,$Cod_client);
		  }else{
		   $resultado["ERROR"]="-3";
	       $resultado["MENSAJE"]="Imei Invalido";  
		   $res[]=$resultado;
		   $result=json_encode($res);
		  }
	  }else{
		   $resultado["ERROR"]="-2";
	       $resultado["MENSAJE"]="Sin ultima posición disponoble";  
		   $res[]=$resultado;
		   $result=json_encode($res);
	  }	  
	  return $result;
	  
  }
  
   function cambia_contrasena($imei,$usName,$nva_cont,$usPassword){
	 $cont = mysql_connect("localhost","savl","397LUP");
	 $base = mysql_select_db("ALG_BD_CORPORATE_MOVI",$cont);
	 //$id_cliente=0;
	 //if (existe_dispositivo($imei,&$id_cliente)>0){
	    $cod_user = existeUsuario($usName,$usPassword,$base);
		if ($cod_user>0){
	         $sql = "UPDATE ADM_USUARIOS 
	             SET SHA1_PASSWORD = '".SHA1($nva_cont)."', 
			     PASSWORD = '".$nva_cont."' 
			     WHERE ID_USUARIO = ".$cod_user;
			 
	         if ($qry = mysql_query($sql)){
		        $resultado["ERROR"]="0";
	            $resultado["MENSAJE"]="OK";  
		        $res[]=$resultado;
		        $result=json_encode($res);
	         }else{
		        $resultado["ERROR"]="-3";
	            $resultado["MENSAJE"]="Error al guardar la contraseña";  
		        $res[]=$resultado;
		        $result=json_encode($res);
	        }
		 }else{
			$resultado["ERROR"]="-2";
	        $resultado["MENSAJE"]="Contraseña actual no valida";  
		    $res[]=$resultado;
		    $result=json_encode($res);  
		 }
	 //}else{
	 //	$resultado["ERROR"]="-1";
	 //   $resultado["MENSAJE"]="Dispositivo no existe";  
	//	$res[]=$resultado;
	//	$result=json_encode($res); 
	 //}
	  return $result;
   }

 
  

  $funcion = $_REQUEST['fun'];

  if ($funcion == 'Login'){
	echo Login ($_REQUEST['usName'],$_REQUEST['usPassword'],$_REQUEST['imei'],$_REQUEST['vCode'],$_REQUEST['item_app']);
  }
  
  if ($funcion == 'Unidades'){
   echo Lunidades($_REQUEST['userID']);
  }
  
  if ($funcion == 'Comandos'){
   echo Lcomandos($_REQUEST['user'],$_REQUEST['cod_entity']);
  }
  
  if ($funcion == 'Posicion'){
   echo ult_posicion($_REQUEST['cod_e'],$_REQUEST['Cod_client']);
  }
  
  if ($funcion == 'Direccion'){
    echo dame_direccion($_REQUEST['lat'],$_REQUEST['lon']);
  }
  
  if ($funcion == 'contrasena'){
    echo cambia_contrasena($_REQUEST['imei'],$_REQUEST['usName'],$_REQUEST['nva_cont'],$_REQUEST['usPassword']);
  }
  
  if ($funcion == 'env_comando'){
    
	   $config_bd = array(
	   	'port'  => '3306',               //Puerto de la base de datos
	   	'host'  => 'localhost',    //Host o ip donde se ubica la base de datos
	   	'bname' => 'ALG_BD_CORPORATE_MOVI',//Nombre  de la base de datos
	   	'user'     => 'savl',              //usuario de la base de datos 
	   	'pass'     => '397LUP'        //Contraseña de la base de datos
       );

	   $Comandos =  new cCommands();
	   $Comandos->set_config_bd($config_bd);
	   $Comandos->set_unidad($_REQUEST['cod_entity']);
	   $Comandos->set_idcomando($_REQUEST['id_comando']);
	   $Comandos->set_usuario($_REQUEST['usuario']);
	   $Comandos->set_comentario("");
	   $Comandos->set_origen($_REQUEST['origen']);
	   $Comandos->set_enviado($_REQUEST['enviado']);
   
	   $save = $Comandos->guarda_comando();
	   if($save=='send'){
			if(trim($_REQUEST['enviado'])=="0"){
				$result="Comando Enviado";
			}
			if(trim($_REQUEST['enviado'])=="1"){
				$result="Log guardado";
			}
	   }else if($save=='no-perm'){
			$result="Comando no permitido";
	   }else if($save=='pending'){
			$result="Ya existe un comando para enviar";
	   }else{
			$result="Problemas al enviar el comando";
	   }
	   echo $result;
	
  }
  
  
?>
