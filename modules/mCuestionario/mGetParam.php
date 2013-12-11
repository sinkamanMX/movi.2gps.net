<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
		
	$db ->sqlQuery("SET NAMES 'utf8'");
	
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	
	$pregs = $_GET['pr'];
	
	if($pregs!=''){
		echo $params = get_params($_GET['id'],$pregs,$_GET['idq']);
		}
	else{
		echo 0;
		}
	
	
	
	
	function get_params($idf,$pregs,$idq){
		global $db;
		
		$prs = "<table>";
		$sql = "SELECT * FROM ADM_PARAMETRO WHERE ID_FUNCION = ".$idf;
		$qry = $db->sqlQuery($sql);
		$cnt = $db->sqlEnumRows($qry);
		if($cnt>0){
			
			while($row = $db->sqlFetchArray($qry)){
				$arroba = strpos($row['DESCRIPCION'],'@');
				if($arroba===false){
					$p = get_value($idf,$pregs,$row['ID_PARAMETRO'],$idq);
					$prs .= '<tr>
					<td><label>'.$row['DESCRIPCION'].':</label></td>
					<td>
					<select id="qst_p'.$row['ID_PARAMETRO'].'" class="qst_selpar caja_txt" >
					'.$p.'
					</select>
					</td>
					</tr>';
					}
				}
				//los options se llenan con las preguntas seleccionadas
			}
		$prs .= "</table>";
		return $prs;
		}
	
	function get_value($idf,$pregs,$par,$idq){
		global $db;
		
		
		$opt = "";
		$sql = "SELECT ID_PREGUNTA,DESCRIPCION FROM CRM2_PREGUNTAS WHERE ID_PREGUNTA IN (".$pregs.")";
		$qry = $db->sqlQuery($sql);
		$cnt = $db->sqlEnumRows($qry);
		if($cnt>0){
			while($row = $db->sqlFetchArray($qry)){
				$idp = exe_query($idf,$par,$idq);
				//echo $idp." == ".$row['ID_PREGUNTA']."<br>";
				$sel = ($idp == $row['ID_PREGUNTA'])?'selected="selected"':'';
				$opt .= '<option value="'.$row['ID_PREGUNTA'].'" '.$sel.'>'.$row['DESCRIPCION'].'</option>';
				}
			}
		return $opt;
		}
	function exe_query($idf,$par,$idq){
		global $db;
		$comp = ($idq>0 | $idq!="")?" AND ID_CUESTIONARIO = ".$idq:"";
		$sql = "SELECT ID_PREGUNTA FROM CRM2_CUESTIONARIO_FUNCION WHERE ID_FUNCION = ".$idf." AND ID_PARAMETRO = ".$par.$comp;
		$qry = $db->sqlQuery($sql);
		
		$cnt = $db->sqlEnumRows($qry);
		if($cnt>0){
			$row = $db->sqlFetchArray($qry);
			return $row['ID_PREGUNTA'];	
			}
		return 0;
		}
	
		
?>	