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

/*$sql_a="SELECT COUNT(*) AS N FROM ADM_USUARIOS_UNIDADES WHERE COD_ENTITY=".$_GET['eqp_id'];
$qry_a 	= $db->sqlQuery($sql_a);
$row_a = $db->sqlFetchArray($qry_a);
if($row_a['N'] > 0){
	$where_a = " COD_ENTITY = ".$_GET['eqp_id']; 
	if(! $dbf->deleteDB('ADM_USUARIOS_UNIDADES',$where_a,true))	{
		echo -1;
		}
	}*/
	
$sql_b="SELECT COUNT(*) AS N FROM ADM_UNIDADES_EQUIPOS WHERE COD_ENTITY=".$_GET['eqp_id'];
$qry_b 	= $db->sqlQuery($sql_b);
$row_b = $db->sqlFetchArray($qry_b);
if($row_b['N'] > 0){
	$where_b = " COD_ENTITY = ".$_GET['eqp_id']; 
	if(! $dbf->deleteDB('ADM_UNIDADES_EQUIPOS',$where_b,true))	{
		echo -2;
		}
	}


$sql_c="SELECT COUNT(*) AS N FROM ADM_UNIDADES_EQUIPOS WHERE COD_ENTITY=".$_GET['eqp_id'];
$qry_c 	= $db->sqlQuery($sql_c);
$row_c = $db->sqlFetchArray($qry_c);
if($row_c['N'] > 0){
	$where_c = " COD_ENTITY = ".$_GET['eqp_id']; 
	if(! $dbf->deleteDB('ADM_GRUPOS_UNIDADES',$where_c,true))	{
		echo -3;
		}
	}

	$where = " COD_ENTITY = ".$_GET['eqp_id']; 
	if($dbf->deleteDB('ADM_UNIDADES',$where,true))	{
		echo 1;
		}
	else{
		echo 0;
		}	

?>