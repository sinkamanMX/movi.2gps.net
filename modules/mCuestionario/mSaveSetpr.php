<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo silver 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          23-04-2012
**/
 
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
			echo '<script>window.location="index.php?m=login"</script>';

$usr   = $userAdmin->user_info['ID_USUARIO'];			
$cv = "";
$mns = "";			

$vls = explode("|",$_GET['vls']);
$vl2 = explode("|",$_GET['vl2']);

for($i=0; $i < count($vls); $i++){
	$vl = explode(",",$vls[$i]);
	$v2 = explode(",",$vl2[$i]);
	if($vls[$i]!=$vl2[$i]){
		

		$d = trim($v2[1],'"');
		$a = trim($vl[1],'"');
		$mns.= ($mns=="")?'El valor de la pregunta '.get_preg($vl[0]).' se modifico de '.$d.' a '.$a:'<br>El valor de la pregunta '.get_preg($vl[0]).' se modifico de '.$d.' a '.$a;
		}
	$cv .= ($cv=="")?'('.$vls[$i].')':',('.$vls[$i].')';	
	}
	//$mns = str_replace('\"','',$mns);
	//$mns = str_replace("\'",'',$mns);


			
$where = " ID_RES_CUESTIONARIO  = ".$_GET['idq'];
$dbf->deleteDB('CRM2_PREG_RES',$where);
$sql_s = "INSERT INTO CRM2_PREG_RES VALUES ".$cv;
if($qry_s = $db->sqlQuery($sql_s)){
	echo 2;
	$sql_t = "INSERT INTO CRM2_LOG  (ID_RES_CUESTIONARIO,ID_USER,FECHA,OBSERVACIONES)VALUES(".$_GET['idq'].",".$usr.",'".date('Y-m-d H:i:s')."','".utf8_encode($mns)."');";
	if($qry_t = $db->sqlQuery($sql_t)){
		echo 1;
	}
}
else{
	echo -1;
}
//---------------------------------
function get_preg($idp){
	global $db;
	$sql = "SELECT DESCRIPCION FROM CRM2_PREGUNTAS WHERE ID_PREGUNTA = ".$idp;
	
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	
	if($cnt > 0){ 
		$row = $db->sqlFetchArray($qry);
		return($row['DESCRIPCION']);
	}
	}
?>