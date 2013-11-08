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
	
	function get_params($idf){
		global $db;
		$prs = "<table>";
		$sql = "SELECT * FROM ADM_PARAMETRO WHERE ID_FUNCION = ".$idf;
		$qry = $db->sqlQuery($sql);
		$cnt = $db->sqlEnumRows($qry);
		if($cnt>0){
			while($row = $db->sqlFetchArray($qry)){
				$prs .= '<tr>
				<td><label>'.$row['DESCRIPCION'].'</label></td>
				<td>
				<select id="qst_p'.$row['ID_PARAMETRO'].'" class="caja_txt" >
				
				</select>
				</td>
				</tr>';
				}
				//los options se llenan con las preguntas seleccionadas
			}
		$prs .= "</table>";
		return($lp);
		}
	
	
	
		
?>	