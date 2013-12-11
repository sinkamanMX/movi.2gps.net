<?php
/*
 *  @package             
 *  @name                Script para guardar datos en tabla PED_UNIDAD_MEDIDA
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Daniel Arazo	
 *  @modificado          2013-11-27
**/
 
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
			echo '<script>window.location="index.php?m=login"</script>';
			
	$db ->sqlQuery("SET NAMES 'utf8'");			
			
	$client   = $userAdmin->user_info['ID_CLIENTE'];
	
	$id;
	
	//$t =( $_GET['tip']=="PUB")?0:$client;
	
	
	$data = Array(
	        'ID_UNIDAD_MEDIDA'	=> $_GET['sel_uni'],
			'DESCRIPCION'		=> strtoupper($_GET['nom']),
			'REPRESENTACION'	=> strtoupper($_GET['repre']),
			'ID_CLIENTE'		=> $client
	);
	//$prs = $_GET['par'];

	if($_GET['op']==1){
		
		if($dbf-> insertDB($data,'PED_PATRON_MEDIDA',true) == true){
			echo 1;
		}else{
			echo 0;
		}			
	}
	if($_GET['op']==2){
		$id = $_GET['id'];
		$where = " ID_PATRON_MEDIDA  = ".$id;
		if(($dbf-> updateDB('PED_PATRON_MEDIDA',$data,$where,true)==true)){
			echo 1;
			
		}else{
			echo 0;
		}	
	}

?>