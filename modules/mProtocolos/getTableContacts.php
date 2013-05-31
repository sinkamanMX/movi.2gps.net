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
	if(isset($_GET['data'])){
		$id_row = $_GET['data'];			  	
		
		$result = array();
		$sql = "SELECT 	ID_CONTACTO AS ID, NOMBRE, CONCAT(HORA_INICIAL,'-',HORA_FINAL) AS HORARIO, 
				ROL, IF(CONTACTO_CONSULTA = 1,'Si','No') AS CONSULTA, 
				IF(CONTACTO_AUTORIZA = 1,'Si','No') AS AUTORIZA,PRIORIDAD
				FROM ADM_PROTOCOLO_CONTACTOS
				WHERE COD_PROTOCOLO =".$id_row;
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