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
	
	$sql = "SELECT ITEM_NUMBER FROM CRM2_CUESTIONARIOS WHERE COD_CLIENT= ".$client." AND ITEM_NUMBER ='".$_GET['nip']."';";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	echo $cnt;
	/*if($cnt > 0){
		echo $cnt;
		}
	else{
		echo 0;
		}	*/
	$db->sqlClose();
?>


