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
	if(!$userAdmin->u_logged())
			echo '<script>window.location="index.php?m=login"</script>';
			
	$db ->sqlQuery("SET NAMES 'utf8'");			
			
	$client   = $userAdmin->user_info['ID_CLIENTE'];
		
	$result = '';

	$sql = "SELECT ID_FUNCION,NOMBRE,DESCRIPCION, IF(TIPO='PUB','Pública','Privada') AS TP FROM ADM_FUNCION WHERE TIPO='PUB' OR ID_CLIENTE = ".$client." ORDER BY NOMBRE";
		$query 	= $db->sqlQuery($sql);
		while($row = $db->sqlFetchArray($query)){
			$result[] = $row; // Inside while loop
		}			
	echo json_encode( $result = array('aaData'=>$result ) );	 	
	$db->sqlClose();
?>


