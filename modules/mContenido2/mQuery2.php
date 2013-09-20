<?php
/** * 
 *  @package             
 *  @name                Obtiene las Geo-Cercas registrados
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          03-06-2011
**/
header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

if(!$userAdmin->u_logged()){
		echo '<script>window.location="index.php?m=login"</script>';
}
	
	$sql_f="SELECT D.ITEM_NUMBER FROM DSP_ITINERARIO D WHERE D.ITEM_NUMBER= '".$_GET['it']."'";
	$query_f = $db->sqlQuery($sql_f);
	$count_f = $db->sqlEnumRows($query_f);		
	
	if($count_f>0){
		echo $count_f;
	}
	else{
	echo 0;}
			   

?>
