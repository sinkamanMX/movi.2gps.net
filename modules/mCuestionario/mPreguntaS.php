<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe�a 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
		
	$emp = $userAdmin->user_info['ID_EMPRESA'];
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	

	$t = (isset($_GET['txt']))?$_GET['txt']:"";
	
	//$prg = $dbf->qst_preguntas($cte,$_GET['pre'],$t);
	
	$prg = $dbf->dragndrop("ID_PREGUNTA","DESCRIPCION","CRM2_PREGUNTAS"," WHERE ACTIVO=1 AND COD_CLIENT =".$cte,$_GET['pre'],$t);

	
	
	$tpl->set_filenames(array('mPreguntaS' => 'tPreguntaS'));
	$tpl->assign_vars(array(
	'PRG'      	=> $prg
	));	
	$tpl->pparse('mPreguntaS');	
?>	