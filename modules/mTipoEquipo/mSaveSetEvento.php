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


			'EVENT_REASON'   			=> $_GET['teq_rzn'],
			'SEARCH_CODE'   			=> $_GET['teq_cod'],
			'QUANTITY_BYTES_RECEIVE'   	=> $_GET['teq_byt'],
											
	);
	$where = " COD_EVENT_EQUIPMENT  = ".$_GET['teq_id'];
	if(($dbf-> updateDB('ADM_EVENTOS_EQUIPOS',$data,$where,true)==true)){
		echo 1;
		}
	else{
		echo 0;
		}	
?>	