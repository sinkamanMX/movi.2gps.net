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

$sql='SELECT E.COD_EVENT_EQUIPMENT, E.EVENT_REASON, E.SEARCH_CODE, E.QUANTITY_BYTES_RECEIVE 
FROM ADM_EVENTOS_EQUIPOS E WHERE E.COD_TYPE_EQUIPMENT= '.$_GET["teq_id"].'
ORDER BY E.EVENT_REASON';

$query 	= $db->sqlQuery($sql);
while($row = $db->sqlFetchArray($query)){
	$result[] = $row; // Inside while loop
	}	
echo json_encode( $result = array('aaData'=>$result ) );	 	
$db->sqlClose();



?>