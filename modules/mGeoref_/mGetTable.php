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

	$sql = "SELECT ID_OBJECT_MAP AS ID, IF(TIPO='G','GEOPUNTO',IF(TIPO='C','GEOCERCA','RSI')) AS TIPO,
				DESCRIPCION AS NOMBRE , ADM_GEOREFERENCIAS.TIPO AS TIPO2,
				IF(PRIVACIDAD='T','PUBLICO',IF(PRIVACIDAD='C','CLIENTES','PRIVADO')) AS PRIVACIDAD ,
				DATE(CREADO) AS FECHA 
			FROM ADM_GEOREFERENCIAS
			WHERE ID_CLIENTE = ".$userAdmin->user_info['ID_CLIENTE'];			
	
	$query 	= $db->sqlQuery($sql);
	while($row = $db->sqlFetchAssoc($query)){
		$result[] = $row; // Inside while loop
	}	
		
	echo json_encode( $result = array('aaData'=>$result ) );	 	
	$db->sqlClose();
?>