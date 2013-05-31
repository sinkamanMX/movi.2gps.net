<?
/** * 
 *  @package             
 *  @name                elimina usuario.
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author             Rodwyn Moreno
 *  @modificado          2012-10-02
**/

header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	$where = " COD_EQUIPMENT_PROGRAM = ".$_GET['com_id']; 
	if($dbf->deleteDB('ADM_COMANDOS_SALIDA',$where,true))	{
		echo 1;
		}
	else{
		echo 0;
		}	

?>