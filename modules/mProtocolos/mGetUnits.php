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
		$sql = "SELECT ADM_UNIDADES.COD_ENTITY AS ID, DESCRIPTION AS NAME 
				FROM ADM_UNIDADES
				LEFT JOIN ADM_PROTOCOLO_UNIDADES 
					ON ADM_UNIDADES.COD_ENTITY = ADM_PROTOCOLO_UNIDADES.COD_ENTITY
				WHERE COD_CLIENT = ".$id_row."
  				  AND ADM_PROTOCOLO_UNIDADES.COD_ENTITY IS NULL
  				ORDER BY DESCRIPTION";
		if($sql!=""){
			$query 	= $db->sqlQuery($sql);
			while($row = $db->sqlFetchAssoc($query)){
				$result[] = $row; // Inside while loop
			}	
		}
	}			  
	echo json_encode( $result = array('units'=>$result ) );	 	
	$db->sqlClose();
?>