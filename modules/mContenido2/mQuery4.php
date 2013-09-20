<?php
/** * 
 *  @package             
 *  @name                Obtiene las Geo-Cercas registrados
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          03-06-2011
**/
header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

if(!$userAdmin->u_logged()){
		echo '<script>window.location="index.php?m=login"</script>';
}



 //$tpl->set_filenames(array('mQuery3' => 'tQuery3'));
 //$idc   = $userAdmin->user_info['COD_CLIENT'];
	
////////////////////////////////////////////////////////////////////////////
$sql = "SELECT U.COD_ENTITY,I.FECHA_ENTREGA,D.ID_DESPACHO FROM DSP_UNIDAD_ASIGNADA U
INNER JOIN DSP_DESPACHO D ON D.ID_DESPACHO=U.ID_DESPACHO
INNER JOIN DSP_ITINERARIO I ON I.ID_DESPACHO=D.ID_DESPACHO
WHERE D.ID_DESPACHO=".$_GET['idd']." AND I.FECHA_ENTREGA='".$_GET['dte']."'";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);		
	
	if($cnt > 0){
		echo $cnt;
	}
	else{
	echo 0;
	
	}
			   

?>
