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
if(!$userAdmin->u_logged())
			echo '<script>window.location="index.php?m=login"</script>';

$client   = $userAdmin->user_info['ID_CLIENTE'];

$sql = "UPDATE CRM2_PREGUNTAS SET ACTIVO = 0 WHERE ID_PREGUNTA = ".$_GET['id'];
if($qry = $db->sqlQuery($sql)){
		echo 1;
	}

/*
//validar si tiene cuestionarios asignados
$qa = get_qst($client,$_GET['id']);
if($qa>0){
	//Borrar asiganación de cuestionarios
	echo $qb = delete_qst($client,$_GET['id']);
	}
//Borrar pregunta
$where = " ID_PREGUNTA = ".$_GET['id']; 
if($dbf->deleteDB('CRM2_PREGUNTAS',$where,true))	{
	echo 1;
	}
else{
	echo 0;
	}	*/


function get_qst($cte,$idp){
	global $db;
	$sql = "SELECT Q.ID_CUESTIONARIO, Q.DESCRIPCION FROM CRM2_CUESTIONARIOS Q
	INNER JOIN CRM2_CUESTIONARIO_PREGUNTAS QP ON QP.ID_CUESTIONARIO = Q.ID_CUESTIONARIO
	WHERE COD_CLIENT = ".$cte." AND QP.ID_PREGUNTA = ".$idp." ORDER BY Q.DESCRIPCION;";
	$qry = $db->sqlQuery($sql);
	$row = $db->sqlFetchArray($qry);
	$cnt = $db->sqlEnumRows($qry);
	return $cnt;
	}
function delete_qst($cte,$idp){
	global $db;
	$sql = "DELETE QP.* FROM CRM2_CUESTIONARIO_PREGUNTAS QP 
	INNER JOIN CRM2_PREGUNTAS P ON P.ID_PREGUNTA = QP.ID_PREGUNTA
	WHERE P.COD_CLIENT = ".$cte." AND QP.ID_PREGUNTA = ".$idp;
	if ($qry = $db->sqlQuery($sql)){
		return 2;
		}
	else{
		return -2;
		}
	}	
?>