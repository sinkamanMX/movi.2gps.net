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

	if($_GET['op']==1){
	$data = Array(
			'DESCRIPCION'			=> $_GET['tit'],
			'ITEM_NUMBER'			=> $_GET['nip'],
			'COD_CLIENT'   			=> $client,
			'ID_TIPO'    			=> $_GET['typ'],
			'MULTIPLES_RESPUESTAS'  => $_GET['mlt'],
			'OFFLINE'	    		=> $_GET['off'],
			'TEMA'   				=> $_GET['tma'],
			'ID_EJE_X'				=> $_GET['x'],
			'ID_EJE_Y'				=> $_GET['y']			
	);
	if($dbf-> insertDB($data,'CRM2_CUESTIONARIOS',true) == true){
		$sql = "SELECT LAST_INSERT_ID() AS ID";
		$qry = $db->sqlQuery($sql);
		$cnt = $db->sqlEnumRows($qry);
		if($cnt>0){
			$row = $db->sqlFetchArray($qry);
			$q = $row['ID'];
			$p = explode(",",$_GET['pre']);
			$o = 1;
			for($i=0; $i<count($p); $i++){
				$pr .= ($pr=="")?"(".$p[$i].",".$q.",".$o.")":",(".$p[$i].",".$q.",".$o.")";
				$o++;
				}
			$sql_i = "INSERT INTO CRM2_CUESTIONARIO_PREGUNTAS VALUES ".$pr;	
			if($qry_i = $db->sqlQuery($sql_i)){
				echo 1;
				}
			else{echo -2;}
			$u = explode(",",$_GET['usr']);
			for($i=0; $i<count($u); $i++){
				$us .= ($us=="")?"(".$q.",".$u[$i].",0,0)":",(".$q.",".$u[$i].",0,0)";
				}
			$sql_c = "INSERT INTO CRM2_VENDEDOR_CUESTIONARIO VALUES ".$us;	
			if($qry_c = $db->sqlQuery($sql_c)){
				echo 1;
				}
			else{echo -3;}
			echo $res_ins_fp = insert_fun_par($q,$_GET['fun'],$_GET['prm']);
			}
			else{
				echo -1;
				}
		}
	else{
		echo 0;
		}			
	}
	if($_GET['op']==2){
		$cv = "";
		if($_GET['tit'] != $_GET['otit']){
			$cv .= ($cv=="")?" DESCRIPCION ='".$_GET['tit']."'":" ,DESCRIPCION ='".$_GET['tit']."'";
			}
		if($_GET['nip'] != $_GET['onip']){
			$cv .= ($cv=="")?" ITEM_NUMBER ='".$_GET['nip']."'":" ,ITEM_NUMBER ='".$_GET['nip']."'";
			}			
		if($_GET['typ'] != $_GET['otyp']){
			$cv .= ($cv=="")?" ID_TIPO =".$_GET['typ']:" ,ID_TIPO =".$_GET['typ'];
			}
		
		if($_GET['mlt'] != $_GET['omlt']){
			$cv .= ($cv=="")?" MULTIPLES_RESPUESTAS =".$_GET['mlt']:" ,MULTIPLES_RESPUESTAS =".$_GET['mlt'];
			}
		
		if($_GET['off'] != $_GET['ooff']){
			$cv .= ($cv=="")?" OFFLINE =".$_GET['off']:" ,OFFLINE =".$_GET['off'];
			}
		if($_GET['tma'] != $_GET['otma']){
			$cv .= ($cv=="")?" TEMA =".$_GET['tma']:" ,TEMA =".$_GET['tma'];
			}
		//echo $_GET['x']." != ".$_GET['ox'] 	;
		if($_GET['x'] != $_GET['ox'] && $_GET['x']!=""){
			$cv .= ($cv=="")?" ID_EJE_X =".$_GET['x']:" ,ID_EJE_X =".$_GET['x'];
			}
		//echo $_GET['y']." != ".$_GET['oy']	;
		if($_GET['y'] != $_GET['oy'] && $_GET['y']!=""){
			$cv .= ($cv=="")?" ID_EJE_Y =".$_GET['y']:" ,ID_EJE_Y =".$_GET['y'];
			}						
		
		if($cv != ""){
			$sql_u = "UPDATE CRM2_CUESTIONARIOS SET ".$cv." WHERE ID_CUESTIONARIO = ".$_GET['idq'];	
			if($qry_u = $db->sqlQuery($sql_u)){
				echo 1;
				}
			else{
				echo 0;
				}	
			
			}
		else{
			echo 2;	
			}	
						if($_GET['pre'] != $_GET['opre']){
							
					$where = " ID_CUESTIONARIO  = ".$_GET['idq'];
					if($dbf->deleteDB('CRM2_CUESTIONARIO_PREGUNTAS',$where)==true){
						$q = $_GET['idq'];
						$p = explode(",",$_GET['pre']);
						$o = 1;
						for($i=0; $i<count($p); $i++){
							$pr .= ($pr=="")?"(".$p[$i].",".$q.",".$o.")":",(".$p[$i].",".$q.",".$o.")";
							$o++;
						}
						$sql_p = "INSERT INTO CRM2_CUESTIONARIO_PREGUNTAS VALUES ".$pr;	
						if($qry_p = $db->sqlQuery($sql_p)){
							echo 1;
						}
						else{
							echo -1;
						}	
					}
					else{echo -2;}
					}
				if($_GET['usr'] != $_GET['ousr']){
					$whr = " ID_CUESTIONARIO  = ".$_GET['idq'];
					$dbf->deleteDB('CRM2_VENDEDOR_CUESTIONARIO',$whr);
					//echo "borro".'CRM2_VENDEDOR_CUESTIONARIO'.$whr;
					$q = $_GET['idq'];
					$un = explode(",",$_GET['usr']);
					for($i=0; $i<count($un); $i++){
						$us .= ($us=="")?"(".$q.",".$un[$i].",0,0)":",(".$q.",".$un[$i].",0,0)";
						}
					$sql_s = "INSERT INTO CRM2_VENDEDOR_CUESTIONARIO VALUES ".$us;
					if($qry_s = $db->sqlQuery($sql_s)){
						echo 1;
						}
					else{
						echo -1;
						}	
					}
				
				if($_GET['fun']>0){
					if($_GET['fun']!=$_GET['ofun'] | $_GET['prm']!=$_GET['oprm']){
						if($_GET['prm']!=""){
							echo $delete = delete($_GET['idq'],$_GET['fun']); 
							if($delete > 0){
								echo $res_ins_fp = insert_fun_par($_GET['idq'],$_GET['fun'],$_GET['prm']);
								}
							}
						}

					}
		}
function delete($idc,$idf){
	global $db;
	$sql = "DELETE FROM CRM2_CUESTIONARIO_FUNCION WHERE ID_CUESTIONARIO = ".$idc." AND ID_FUNCION = ".$idf;	
	if($qry = $db->sqlQuery($sql)){
		return 3;
		}
	else{
		return -3;
		}
	}
function insert_fun_par($idq,$idf,$pv){
	if($idf > -1){
		global $db;
		$exp = explode('|',$pv);
		$val = "";
		for($i=0; $i<count($exp); $i++){
			$ex = explode(',',$exp[$i]);
			$val .= ($val=="")?'('.$idq.','.$idf.','.$ex[0].','.$ex[1].')':',('.$idq.','.$idf.','.$ex[0].','.$ex[1].')';
			}
		$sql = "INSERT INTO CRM2_CUESTIONARIO_FUNCION (ID_CUESTIONARIO,ID_FUNCION,ID_PARAMETRO,ID_PREGUNTA) VALUES".$val;	
		if($qry = $db->sqlQuery($sql)){
			return 4;
			}
		else{
			return -4;
			}		
		}
	}		
?>