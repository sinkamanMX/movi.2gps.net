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
	
	$result = array();
	if(isset($_GET['data'])){
		$sql = "SELECT ID_MUNICIPIO AS ID,NOMBRE AS NAME
				FROM ZZ_SPM_MUNICIPIOS
				WHERE ID_ESTADO = ".$_GET['data']."
				ORDER BY NOMBRE";	
		$query 	= $db->sqlQuery($sql);
		while($row = $db->sqlFetchArray($query)){
			$result[] = array(
				'id' 	=> $row['ID'], 
				'name'	=> $row['NAME']
			); 
		}	
	}			
	echo json_encode( array('items'=>$result) ); 	
?>