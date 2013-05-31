<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo silver 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          23-04-2012
**/
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$result='';
	
	$sql = 'SELECT E.ID_EMPRESA, E.DESCRIPCION, IF(E.ACTIVO="S","SI","NO") AS ACTIVO, E.CREADO 
			FROM ADM_EMPRESAS E';

	$query 	= $db->sqlQuery($sql);
	while($row = $db->sqlFetchArray($query)){
		$result[] = $row; // Inside while loop
	}		
	echo json_encode( $result = array('aaData'=>$result ) );	 	
	$db->sqlClose();
?>