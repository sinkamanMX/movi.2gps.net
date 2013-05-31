<?php
/** * 
 *  @package             
 *  @name                Script que obtiene los datos a mostrar en la tabla
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          03/05/13
**/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],
				  $config_bd['bname'],$config_bd['user'],$config_bd['pass']);
		
	$result = '';
	if(isset($_GET['id_client'])){
		$id_client = $_GET['id_client'];			  	
		
		$result = array();
		$sql = "SELECT COD_PROTOCOLO AS ID,DESCRIPCION AS NAME ,IF(ACTIVO='S','Si','No') AS ESTATUS,
				CREADO, COD_PROTOCOLO AS ID_P
				FROM ADM_PROTOCOLOS
				WHERE ID_CLIENTE = ".$id_client."
	  			ORDER BY NAME";
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