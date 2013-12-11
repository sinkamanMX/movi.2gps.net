<?
/* 
 *  @package             
 *  @name                elimina unidad de medida.
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Daniel Arazo
 *  @modificado          2013-11-27
**/

header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);


//Borrar cuestionario
	$where = " ID_UNIDAD_MEDIDA = ".$_GET['fun_id']; 
	if($dbf->deleteDB('PED_UNIDAD_MEDIDA',$where,true))	{
		echo 1;
		}
	else{
		echo 0;
		}	

?>