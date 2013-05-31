<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	//``````````
	
	$data = Array(
			'COD_TYPE_EQUIPMENT'   		=> $_GET['teq_id'],
			'COD_EVENT_DEFAULT'   		=> 0,
			'EVENT_REASON'	    		=> $_GET['eve_rzn'],
			'SEARCH_CODE'   			=> $_GET['eve_cod'],
			'QUANTITY_BYTES_RECEIVE'	=> $_GET['eve_byt']
	);
	
	if($dbf-> insertDB($data,'ADM_EVENTOS_EQUIPOS',true) == true){
		echo 1;
		}
	else{
		echo 0;
		}	
?>	