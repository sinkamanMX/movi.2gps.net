<?php
    header('Content-Type: text/html; charset=UTF-8');
 	$db  = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

    
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	     $UTF8 = "SET NAMES 'utf8'";
     $db->sqlQuery($UTF8);
	
	$T=0;
   // $path=strtoupper($_GET['descripcion']);
    chmod('catalogos/',0777);
	$path= 'catalogos/'.strtoupper(reemplaza(utf8_decode($_GET['descripcion']))).'/'.strtoupper(reemplaza(utf8_decode($_GET['descripcion'])));
	
	if(mkdir(reemplaza($path), 0777, true )){
	  chmod('catalogos/'.strtoupper($_GET['descripcion']),0777); 
	  chmod($path,0777);
	 $T=GuardarCatalogo(strtoupper($_GET['descripcion']),strtoupper(reemplaza(utf8_decode($_GET['descripcion']))));
	}
	
echo $T;

function GuardarCatalogo($descripcion,$descripcion_real){
	global $db;
	
	$sql = "INSERT INTO CAT_CATALOGO (DESCRIPCION,DESCRIPCION_REAL) VALUES('".$descripcion."','".$descripcion_real."');";
	$query = $db->sqlQuery($sql);
	if($query){
		   
		    $max = "SELECT LAST_INSERT_ID() AS LID FROM CAT_CATALOGO";
	 		$qmax = $db->sqlQuery($max);
    		$reg  = $db->sqlFetchArray($qmax);
		
			$sqlx = "INSERT INTO CAT_CLIENTE_CATALOGO (ID_CATALOGO,ID_CLIENTE) VALUES('".$reg['LID']."','".$_GET['cliente']."');";
	        $queryx = $db->sqlQuery($sqlx);
		   	if($queryx){
		   		return 1;
	   		}
	}else{
		return 0;
	}
}

//------------- funciones 

function reemplaza($cadena_x){ // reemplaza caracteres especiales
$regresa = '';
$a = array('á','Á','é','É','í','Í','ó','Ó','ú','Ú','ü','Ü','ñ','Ñ',' ');
$b = array('a','A','e','E','i','I','o','O','u','U','u','U','n','N','_');
$regresa = str_replace($a, $b,$cadena_x);
return $regresa;
}
?>
