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


//Borrar cuestionario
	$where = " ID_ALMACEN = ".$_GET['id']; 
	if($dbf->deleteDB('PED_ALMACEN',$where,true))	{
		$borrar = "DELETE FROM PED_ALMACEN_PDI_UNIDAD WHERE ID_ALMACEN = ".$_GET['id'];
		 	$qry_del = $db->sqlQuery($borrar);
		 	 if($qry_del){   
			   echo 1;
			 }else{
			   	echo 0;
			 }
 	}
	else{
		echo 0;
		}	

?>