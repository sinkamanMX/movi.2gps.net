<?php
header("Content-Type: text/html;charset=utf-8");
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';  //Manda al login si no se ha Logeo.
	//--------------------------- Modificada BD y Encabezado------------------------
	$db ->sqlQuery("SET NAMES 'utf8'");
	
	$cte   = $userAdmin->user_info['ID_CLIENTE'];
	
	$exp_a = explode("|",$_POST['str']);
	$pdi_error = "";
	$char= "";
	$array_idp = array();
	$ok = 0;
	$pdi = "";

	for($i=0; $i<count($exp_a); $i++){
		$exp_b = explode(",",$exp_a[$i]);
		//echo count($exp_b)."\n";
		if($i==0){
			$idc = $exp_b[0];
			for($j=1; $j<count($exp_b); $j++){
				//echo $exp_b[$j]."|".$j."\n";
				$array_idp[] = $exp_b[$j];
				}
			}
		else if($i>1){
			$pr = "";
			//echo $exp_b[0]."\n";
			$gidp = get_idpunto($exp_b[0],$cte);
			$pdi .= ($pdi=="")?$gidp:",".$gidp;
			
			for($j=0; $j<count($array_idp); $j++){
				if($exp_b[$j+1] != "" ){
					$pr .= ($pr=="")?$array_idp[$j]."¬".$exp_b[$j+1]:"|".$array_idp[$j]."¬".$exp_b[$j+1];
					}
				
				}
			if($gidp > 0){
				$char .= ($char=="")?"(".$idc.",".$gidp.",'".$pr."','".date('Y-m-d H:i:s')."')":",(".$idc.",".$gidp.",'".$pr."','".date('Y-m-d H:i:s')."')";
				$ok++;
				}
			else{
				$pdi_error .= ($pdi_error=="")?$exp_b[0]:"|".$exp_b[0];
				}
			}	
		
		}
	
	$cp =  get_count($idc,$pdi);
	if($cp>0){
		delete_pays($idc,$pdi);
		}
	$char;	
	$ins = insert_pays($char);
	echo $ins .= ($ins==1)?"¬".$pdi_error."¬".$ok:"¬".$pdi_error;
	/*$sql = "INSERT INTO ADM_GEO_PAYLOAD (ID_CUESTIONARIO,ID_OBJECT_MAP,CADENA_PAYLOAD,FECHA_CREADO) VALUES ".$char;
	if ($qry = $db->sqlQuery($sql)){
		echo "1¬".$pdi_error."¬".$ok;
		}
	else{
		echo "-1¬".$pdi_error;
		}*/
function get_idpunto($nip,$cte){
	global $db;
	$sql = "SELECT ID_OBJECT_MAP FROM ADM_GEOREFERENCIAS WHERE ITEM_NUMBER = '".$nip."' AND ID_CLIENTE = ".$cte;
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	if($cnt > 0){
		$row = $db->sqlFetchArray($qry);
		return $row['ID_OBJECT_MAP'];
				}
	else{
		return 0; 
		}			
	}
function get_count($idq,$idp){
	global $db;
	$sql = "SELECT CADENA_PAYLOAD FROM ADM_GEO_PAYLOAD WHERE ID_CUESTIONARIO = ".$idq." AND ID_OBJECT_MAP IN (".$idp.")";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	if($cnt > 0){
		return $cnt;
				}
	else{
		return 0; 
		}
	}	
function delete_pays($idq,$idp){
	global $db;
	$sql = "DELETE FROM ADM_GEO_PAYLOAD WHERE ID_CUESTIONARIO = ".$idq." AND ID_OBJECT_MAP IN (".$idp.")";
	if ($qry = $db->sqlQuery($sql)){
		return 1;
		}
	else{
		return 0;
		}
	}
function insert_pays($cadena){
	global $db;
	$sql = "INSERT INTO ADM_GEO_PAYLOAD (ID_CUESTIONARIO,ID_OBJECT_MAP,CADENA_PAYLOAD,FECHA_CREADO) VALUES ".$cadena;
	if ($qry = $db->sqlQuery($sql)){
		return 1;
		}
	else{
		return -1;
		}
	}
$db->sqlClose();
?>