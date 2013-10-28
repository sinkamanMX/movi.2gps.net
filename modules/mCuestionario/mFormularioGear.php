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
	
	$emp = $userAdmin->user_info['ID_EMPRESA'];
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	

	
	$tpl->set_filenames(array('mFormularioGear' => 'tFormularioGear'));
	
	
	//dragndropF($id,$des,$tbl,$whr,$pr,$txt,$fun,$ord)
	//ORDEN,XDEFECTO,XDEFECTO
	$qst = $dbf->dragndropF2("ID_CUESTIONARIO","DESCRIPCION","CRM2_CUESTIONARIOS"," WHERE COD_CLIENT = ".$cte,"","",""," ORDER BY  ORDEN ASC");
	
	$tpl->assign_vars(array(
		'QST'      	=> $qst
		));
	

	$tpl->pparse('mFormularioGear');	
?>	