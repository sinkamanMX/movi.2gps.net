<?php
    header('Content-Type: text/html; charset=UTF-8');
 	$db  = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

    if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	
	$T=0;
   // $path=strtoupper($_GET['descripcion']);
	$path= 'catalogos/'.strtoupper($_GET['descripcion']).'/'.strtoupper($_GET['descripcion']);
	if(mkdir( $path, 0777, true )){
	 $T=GuardarCatalogo(strtoupper($_GET['descripcion']));
	}else{
	
	}
	
echo $T;

function GuardarCatalogo($descripcion){
	global $db;
	
	$sql = "INSERT INTO CAT_CATALOGO (DESCRIPCION) VALUES('".$descripcion."');";
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
?>
