<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	//````````
	$data = Array(
			'COD_TRADEMARK_MODEL'   		=> $_GET['teq_mod'],
			'COD_TYPE_COMUNICATION'   		=> $_GET['teq_com'],
			'PORT_DEFAULT'	    			=> $_GET['teq_por'],
			'DESCRIPTION'   				=> $_GET['teq_des']
	);
	
	if($dbf-> insertDB($data,'ADM_EQUIPOS_TIPO',true) == true){
		echo 1;
		}
	else{
		echo 0;
		}	
?>	