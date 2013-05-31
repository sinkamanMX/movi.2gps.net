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
		$sql = "SELECT ADM_FORMA_CONTACTO.ID_FORMA_CONTACTO AS ID, ADM_MEDIOS_CONTACTO.DESCRIPCION AS NAME,
					ADM_FORMA_CONTACTO.MEDIO_CONTACTO AS DES ,IF(ACTIVO=1,'Si','No') AS STATUS, 
					ADM_FORMA_CONTACTO.PRIORIDAD
				FROM ADM_FORMA_CONTACTO
				INNER JOIN ADM_MEDIOS_CONTACTO     
					ON ADM_MEDIOS_CONTACTO.ID_FORMA = ADM_FORMA_CONTACTO.ID_FORMA
				WHERE ADM_FORMA_CONTACTO.ID_CONTACTO = ".$id_row.
				" ORDER BY ADM_FORMA_CONTACTO.PRIORIDAD ASC";
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