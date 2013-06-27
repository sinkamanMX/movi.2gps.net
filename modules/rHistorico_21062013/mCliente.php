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

$sql='SELECT C.ID_CLIENTE, C.DESCRIPCION AS CLIENTE, IF(C.ESTATUS = 1,"Activo","Inactivo") AS ESTATUS, C.FECHA_CREACION FROM ADM_CLIENTES C';

$query 	= $db->sqlQuery($sql);
while($row = $db->sqlFetchArray($query)){
	$result[] = $row; // Inside while loop
	}	
		
echo json_encode( $result = array('aaData'=>$result ) );	 	
$db->sqlClose();



?>