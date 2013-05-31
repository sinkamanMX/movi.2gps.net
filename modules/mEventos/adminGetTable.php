<?php
/** * 
 *  @package             
 *  @name                Script que obtiene los datos a mostrar en la tabla
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	
	$result = '';
	if(isset($_GET['id_client'])){
		$id_client = $_GET['id_client'];
		/*
		* Se valida el tipo de usuario para mostrar los perfiles
		*/
		$sql = "SELECT E.COD_EVENT, E.DESCRIPTION, E.PRIORITY, E.FLAG_VISIBLE_CONSOLE, E.FLAG_EVENT_ALERT
				FROM ADM_EVENTOS E 
				LEFT JOIN ADM_CLIENTES C ON E.ID_CLIENTE = C.ID_CLIENTE
				WHERE E.ID_CLIENTE = ".$id_client;	
		if($sql!=""){
			$query 	= $db->sqlQuery($sql);
			while($row = $db->sqlFetchAssoc($query)){
	    		$result[] = $row; // Inside while loop
			}	
		}	
	}	
	echo json_encode( $result = array('aaData'=>$result ) );	 	
	$db->sqlClose();
?>