<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$sql="SELECT MAX(FLAG_INDEX_MENU) AS M FROM ADM_COMANDOS_SALIDA WHERE COD_TYPE_EQUIPMENT= ".$_GET["teq_id"];
	$query 	= $db->sqlQuery($sql);
	$row = $db->sqlFetchArray($query);
	$m = ($row['M']!="")?$row['M']+1:1;
	
	$data = Array(
			'COD_TYPE_EQUIPMENT'   	=> $_GET['teq_id'],
			'DESCRIPCION'   		=> $_GET['com_des'],
			'COMMAND_EQUIPMENT'	    => $_GET['com_com'],
			'FLAG_INPUT_VARIABLE'   => $_GET['com_flg'],
			'QUANTITY_BYTES_SENT'	=> $_GET['com_byt'],
			'FLAG_INDEX_MENU'   	=> $m,
			'FLAG_PASS'	    		=> $_GET['com_pas'],
			'FLAG_EXPERT_MODE'   	=> 0,
			'FLAG_SMS'				=> 0
	);
	
	if($dbf-> insertDB($data,'ADM_COMANDOS_SALIDA',true) == true){
		echo 1;
		}
	else{
		echo 0;
		}	
?>	