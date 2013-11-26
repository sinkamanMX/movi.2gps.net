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
	
	$db ->sqlQuery("SET NAMES 'utf8'");
	
	$tpl->set_filenames(array('mFormulariop' => 'tFormulariop'));
	if($_GET['op']==2){
		$par = $dbf->getRow('ADM_PARAMETRO','ID_PARAMETRO = '.$_GET['id']);
		//````````
		$des = @$par['DESCRIPCION'];
		$int = (@$par['TIPO']=="I")?'selected="selected"':'';
		$str = (@$par['TIPO']=="S")?'selected="selected"':'';
		$tpl->assign_vars(array(
			'DES'		=> $des,
			'INT'		=> $int,
			'STR'      	=> $str
			));
		}	
	


	$tpl->assign_vars(array(
	'OP'      	=> $_GET['op'],
	'ID'      	=> $_GET['id'],
	));	
	$tpl->pparse('mFormulariop');	
?>	