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
	$echoes = 0;
	$cad = str_replace("[","'",$_GET[txt]);
	$cad = str_replace("]","'",$cad);
	$exp = explode(";",$cad);
	for($i=0; $i<count($exp); $i++ ){
		//echo $exp[$i];
		$sql = "UPDATE CRM2_CUESTIONARIOS SET ".$exp[$i];
		if($qry = $db->sqlQuery($sql)){
			$echoes+0;
			}
		else{
			$echoes++;
			}
		}
	echo $echoes;
?>