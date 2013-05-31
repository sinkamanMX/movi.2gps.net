<?php
/** * 
 *  @package             
 *  @name                Script que obtiene los datos a mostrar en la tabla
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          03/05/13
**/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],
				  $config_bd['user'],$config_bd['pass']);	
	
	$result = array();
	/*
	* Se valida el tipo de usuario para mostrar los perfiles
	*/
	$sql = "SELECT COD_PROTOCOLO AS ID,DESCRIPCION AS NAME ,IF(ACTIVO='S','Si','No') AS ESTATUS,CREADO
			FROM ADM_PROTOCOLOS
			WHERE ID_CLIENTE IN (			
				SELECT ADM_CLIENTES.ID_CLIENTE
				FROM ADM_CLIENTES
				WHERE ADM_CLIENTES.ID_EMPRESA =  ".$userAdmin->user_info['ID_EMPRESA']."		
			)
			ORDER BY NAME";
	if($sql!=""){
		$query 	= $db->sqlQuery($sql);
		while($row = $db->sqlFetchAssoc($query)){
    		$result[] = $row; // Inside while loop
		}	
	}
	echo json_encode( $result = array('aaData'=>$result ) );	 	
	$db->sqlClose();
?>