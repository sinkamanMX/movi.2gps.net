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

//Borrar comandos asociados
$sql_b="SELECT COUNT(*) AS N FROM ADM_COMANDOS_SALIDA WHERE COD_TYPE_EQUIPMENT =".$_GET['teq_id'];
$qry_b 	= $db->sqlQuery($sql_b);
$row_b = $db->sqlFetchArray($qry_b);
if($row_b['N'] > 0){
	$where_b = " COD_TYPE_EQUIPMENT = ".$_GET['teq_id']; 
	if(! $dbf->deleteDB('ADM_COMANDOS_SALIDA',$where_b,true))	{
		echo -2;
		}
	}

//Borrar 	
$sql_c="SELECT COUNT(*) AS N FROM ADM_EVENTOS_EQUIPOS WHERE COD_TYPE_EQUIPMENT =".$_GET['teq_id'];
$qry_c 	= $db->sqlQuery($sql_c);
$row_c = $db->sqlFetchArray($qry_c);
if($row_c['N'] > 0){
	$where_c = " COD_TYPE_EQUIPMENT = ".$_GET['teq_id']; 
	if(! $dbf->deleteDB('ADM_EVENTOS_EQUIPOS',$where_c,true))	{
		echo -3;
		}
	}	

	$where = " COD_TYPE_EQUIPMENT = ".$_GET['teq_id']; 
	if($dbf->deleteDB('ADM_EQUIPOS_TIPO',$where,true))	{
		echo 1;
		}
	else{
		echo 0;
		}	

?>