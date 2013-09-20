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



 $tpl->set_filenames(array('mQuery5' => 'tQuery5'));
 
	
////////////////////////////////////////////////////////////////////////////
$sql_g="SELECT D.FECHA_ENTREGA, D.FECHA_ARRIBO, D.FECHA_SALIDA, D.FECHA_FIN FROM DSP_ITINERARIO D WHERE  D.ID_ENTREGA=".$_GET['ide'];
	$query_g = $db->sqlQuery($sql_g);
	$count_g = $db->sqlEnumRows($query_g);		
	
	if($count_g>0){
		
		$row_g=$db->sqlFetchArray($query_g);
			 $tpl->assign_vars(array(
				'DTE'	=> $row_g['FECHA_ENTREGA'],
				'DTA'	=> $row_g['FECHA_ARRIBO'],
				'DTS'	=> $row_g['FECHA_SALIDA'],
				'DTF'	=> $row_g['FECHA_FIN']
										));	
		
		$tpl->pparse('mQuery5');
	}
	else{
	echo 0;}
			   

?>
