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
			
$db ->sqlQuery("SET NAMES 'utf8'");
			
	$client   = $userAdmin->user_info['ID_CLIENTE'];
	
	$data = Array(
			'ID_TIPO'		=> $_GET['typ'],
			'COD_CLIENT'   	=> $client,
			'DESCRIPCION'   => $_GET['tit'],
			'ACTIVO'  		=> $_GET['act'],
			'COMPLEMENTO'	=> $_GET['com'],
			'RECORDADO'   	=> $_GET['rec'],
			'REQUERIDO'   	=> $_GET['req'],
			'EDITABLE'		=> $_GET['edt']
	);
	
	if($_GET['op']==1){

		if($dbf-> insertDB($data,'CRM2_PREGUNTAS',true) == true){
			echo 1;
			if($_GET['qst']!=""){
				$id = get_insert_id();
				
				$pex = explode(',',$_GET['qst']);
				$dpre = "";
				for($i=0; $i<count($pex); $i++){
					$ord = get_max_orden($pex[$i])+1;
					$dpre .= ($dpre=="")?'('.$id.','.$pex[$i].','.$ord.')':',('.$id.','.$pex[$i].','.$ord.')';
					}
				$rins = intval(insert_preg_qst($dpre));
				echo $rins;
			}
		}
		else{
			echo 0;
		}	
		
		
	}
	if($_GET['op']==2){
		$where = " ID_PREGUNTA  = ".$_GET['id'];
		if(($dbf-> updateDB('CRM2_PREGUNTAS',$data,$where,true)==true)){
			echo 1;
			
			if($_GET['qst']!='' && $_GET['qst']!=$_GET['oqst']){
				//validar si tiene cuestionarios asignados
				$qa = get_qst($client,$_GET['id']);
				if($qa>0){
					//Borrar asiganación de cuestionarios
					echo $qb = delete_qst($client,$_GET['id']);
					if($qb>0){
						//insertar cuestionarios
						$pex = explode(',',$_GET['qst']);
						$dpre = "";
						for($i=0; $i<count($pex); $i++){
							$ord = get_max_orden($pex[$i])+1;
							$dpre .= ($dpre=="")?'('.$_GET['id'].','.$pex[$i].','.$ord.')':',('.$_GET['id'].','.$pex[$i].','.$ord.')';
							}
						$rins = intval(insert_preg_qst($dpre));
						echo $rins;
						}
					}
				else{
					//insertar cuestionarios
					$pex = explode(',',$_GET['qst']);
					$dpre = "";
					for($i=0; $i<count($pex); $i++){
						$ord = get_max_orden($pex[$i])+1;
						$dpre .= ($dpre=="")?'('.$_GET['id'].','.$pex[$i].','.$ord.')':',('.$_GET['id'].','.$pex[$i].','.$ord.')';
						}
					$rins = intval(insert_preg_qst($dpre));
					echo $rins;
					}	
				}
		}
		else{
			echo 0;
		}	
	}
function get_insert_id(){
	global $db;
	$sql = "SELECT LAST_INSERT_ID() AS ID";
	$qry = $db->sqlQuery($sql);
	$row = $db->sqlFetchArray($qry);
	//$cnt = $db->sqlEnumRows($qry);
	return $row['ID'];
	}	
function get_max_orden($id){
	global $db;
	$sql = "SELECT MAX(ORDEN) AS ORDN FROM CRM2_CUESTIONARIO_PREGUNTAS WHERE ID_CUESTIONARIO = ".$id;
	$qry = $db->sqlQuery($sql);
	$row = $db->sqlFetchArray($qry);
	$cnt = $db->sqlEnumRows($qry);
	if($cnt>0){
		return $row['ORDN'];
		}
	else{
		return 0;
		}	
	}
function insert_preg_qst($data){
	global $db;
	$sql = "INSERT INTO CRM2_CUESTIONARIO_PREGUNTAS (ID_PREGUNTA,ID_CUESTIONARIO,ORDEN) VALUES ".$data;  
	if ($qry = $db->sqlQuery($sql)){
		return 1;
		}
	else{
		return 0;
		}
	}
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