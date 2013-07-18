<?php
/** * 
 *  @package             
 *  @name                Script que obtiene los datos a mostrar en la tabla
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
		
	$result = '';
	if(isset($_GET['id_client'])){
		$id_client = $_GET['id_client'];
		/*
		* Se valida el tipo de usuario para mostrar los perfiles
		*/
		$sql = "SELECT COD_EQUIPMENT AS ID ,ITEM_NUMBER AS ITEM ,PHONE AS PHONE,IMEI ,
				ADM_EQUIPOS_TIPO.DESCRIPTION AS TIPO
				FROM ADM_EQUIPOS
				LEFT JOIN ADM_EQUIPOS_TIPO ON ADM_EQUIPOS_TIPO.COD_TYPE_EQUIPMENT = ADM_EQUIPOS.COD_TYPE_EQUIPMENT
				WHERE ID_CLIENTE = ".$id_client;	
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