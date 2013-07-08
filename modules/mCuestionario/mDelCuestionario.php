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


//Borrar datos cuestionarios preguntas.	
$sql_b="SELECT COUNT(*) AS N FROM CRM2_CUESTIONARIO_PREGUNTAS WHERE ID_CUESTIONARIO=".$_GET['qst_id'];
$qry_b 	= $db->sqlQuery($sql_b);
$row_b = $db->sqlFetchArray($qry_b);
if($row_b['N'] > 0){
	$where_b = " ID_CUESTIONARIO = ".$_GET['qst_id']; 
	if(! $dbf->deleteDB('CRM2_CUESTIONARIO_PREGUNTAS',$where_b,true))	{
		echo -2;
		}
	}
//Borrar datos vendedor cuestionario.
$sql_c = "SELECT COUNT(*) AS N FROM CRM2_VENDEDOR_CUESTIONARIO WHERE ID_CUESTIONARIO=".$_GET['qst_id'];
$qry_c = $db->sqlQuery($sql_c);
$row_c = $db->sqlFetchArray($qry_c);
if($row_c['N'] > 0){
	$where_c = " ID_CUESTIONARIO = ".$_GET['qst_id']; 
	if(! $dbf->deleteDB('CRM2_VENDEDOR_CUESTIONARIO',$where_c,true))	{
		echo -1;
		}
	}	

//Borrar cuestionario
	$where = " ID_CUESTIONARIO = ".$_GET['qst_id']; 
	if($dbf->deleteDB('CRM2_CUESTIONARIOS',$where,true))	{
		echo 1;
		}
	else{
		echo 0;
		}	

?>