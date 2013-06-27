<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$data = Array(
			'DESCRIPCION'   => $_GET['cli_des'],
			'ESTATUS'   		=> $_GET['cli_sta']
	);
	$where = " ID_CLIENTE  = ".$_GET['cli_id'];
	if(($dbf-> updateDB('ADM_CLIENTES',$data,$where,true)==true)){
		echo 1;
		}
	else{
		echo 0;
		}	
?>	