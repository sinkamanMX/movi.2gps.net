<?php
/** * 
 *  @package             
 *  @name                Script que obtiene los datos a mostrar en la tabla
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
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
		$sql = "SELECT ADM_PERFILES.ID_PERFIL  AS ID, ADM_PERFILES.DESCRIPCION, ADM_PERFILES.ESTATUS
				FROM ADM_PERFILES_CLIENTES
				INNER JOIN ADM_PERFILES ON ADM_PERFILES_CLIENTES.ID_PERFIL = ADM_PERFILES.ID_PERFIL
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
