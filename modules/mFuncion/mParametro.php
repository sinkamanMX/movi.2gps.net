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
			
	//$client   = $userAdmin->user_info['ID_CLIENTE'];
	$id = $_GET['id'];
		
	$result = '';

	$sql = "SELECT ID_PARAMETRO,DESCRIPCION,IF(TIPO='I','Entero','Texto') AS TIPO FROM ADM_PARAMETRO WHERE ID_FUNCION = ".$id;
		$query 	= $db->sqlQuery($sql);
		while($row = $db->sqlFetchArray($query)){
			$result[] = $row; // Inside while loop
		}			
	echo json_encode( $result = array('aaData'=>$result ) );	 	
	$db->sqlClose();
?>


