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


			'DESCRIPCION'   			=> $_GET['com_des'],
			'COMMAND_EQUIPMENT'   		=> $_GET['com_com'],
			'QUANTITY_BYTES_SENT'   	=> $_GET['com_byt'],
			'FLAG_INPUT_VARIABLE'   	=> $_GET['com_flg'],
			'FLAG_PASS'   				=> $_GET['com_pas']
											
	);
	$where = " COD_EQUIPMENT_PROGRAM  = ".$_GET['com_id'];
	if(($dbf-> updateDB('ADM_COMANDOS_SALIDA',$data,$where,true)==true)){
		echo 1;
		}
	else{
		echo 0;
		}	
?>	