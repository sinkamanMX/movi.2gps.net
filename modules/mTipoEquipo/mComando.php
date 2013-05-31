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
$result = '';
$sql="SELECT COD_EQUIPMENT_PROGRAM,DESCRIPCION,QUANTITY_BYTES_SENT 
		FROM ADM_COMANDOS_SALIDA 
		WHERE COD_TYPE_EQUIPMENT= ".$_GET["teq_id"]."
 		ORDER BY DESCRIPCION;";

$query 	= $db->sqlQuery($sql);
while($row = $db->sqlFetchArray($query)){
	$result[] = $row; // Inside while loop
	}	
echo json_encode( $result = array('aaData'=>$result ) );	 	
$db->sqlClose();



?>