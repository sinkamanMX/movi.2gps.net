<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
		
	$db ->sqlQuery("SET NAMES 'utf8'");
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	//
	$sql = "SELECT ID_ALMACEN FROM PED_ALMACEN WHERE ID_CLIENTE = ".$cte." AND ITEM_NUMBER_ALMACEN = '".$_GET['txt']."';";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	echo $cnt;	
?>	