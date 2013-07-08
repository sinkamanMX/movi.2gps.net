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
			
	$client   = $userAdmin->user_info['ID_CLIENTE'];
	
	$sql="SELECT HTML FROM CRM2_TIPO_PREG WHERE ID_TIPO = ".$_GET['idt'].";";
	$qry 	= $db->sqlQuery($sql);
	$row = $db->sqlFetchArray($qry);
	echo $row['HTML'];

	
	$db->sqlClose();
?>


