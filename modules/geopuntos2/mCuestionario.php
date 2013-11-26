<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Ing. Rodwyn Moreno
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
	
	$db ->sqlQuery("SET NAMES 'utf8'");	
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	

	$t = (isset($_GET['txt']))?$_GET['txt']:"";
	
	//$prg = $dbf->qst_preguntas($cte,$_GET['pre'],$t);
	
	$qst = $dbf->dragndrop("ID_CUESTIONARIO","DESCRIPCION","CRM2_CUESTIONARIOS"," WHERE COD_CLIENT =".$cte,$_GET['q'],$t);
	
	/*$sql = "SELECT ID_CUESTIONARIO,DESCRIPCION FROM CRM2_CUESTIONARIOS WHERE COD_CLIENT = ".$cod_client.$comp." ORDER BY DESCRIPCION;";
	$qry = $db->sqlQuery($sql_u);
	$cnt = $db->sqlEnumRows($qry_u);
	
	if($cnt > 0){ 
		while($row = $db->sqlFetchArray($qry)){
		
		$tpl->assign_block_vars('U',array(
		'ID'	=>	$row['ID_CUESTIONARIO'],
		'DES'	=>	$row['DESCRIPCION']
		));
		}
	}
*/
	
	
	$tpl->set_filenames(array('mCuestionario' => 'tCuestionario'));
	$tpl->assign_vars(array(
	'QST'      	=> $qst
	));	
	$tpl->pparse('mCuestionario');	
?>	