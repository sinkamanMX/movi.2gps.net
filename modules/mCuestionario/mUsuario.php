<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
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
	
	$usr = $dbf->dragndrop("ID_USUARIO","NOMBRE_COMPLETO","ADM_USUARIOS"," WHERE ESTATUS='Activo' AND ID_CLIENTE =".$cte,$_GET['us'],$t);

	
	
	$tpl->set_filenames(array('mUsuario' => 'tUsuario'));
	$tpl->assign_vars(array(
	'USR'      	=> $usr
	));	
	$tpl->pparse('mUsuario');	
?>	