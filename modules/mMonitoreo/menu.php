<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo silver 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27-04-2011
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
		
	/*if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';*/
	
	$tpl->set_filenames(array('menu'=>'menu'));	
	$idProfile   = $userAdmin->user_info['ID_PROFILE'];	
	
	$tpl->assign_vars(array(
		'PAGE_TITLE'	=> 'Modulo Rastreo',
		'PATH'			=> $dir_mod,
		'PATH_IMG'		=> $dir_pimages,
		'NAME'			=> $userAdmin->codif($userAdmin->user_info['USER_NAME']),
		'MAIL'			=> $userAdmin->codif($userAdmin->user_info['USER_EMAIL']),
		//'MENU'			=> $userAdmin->get_menu(),
		'APIKEY'		=> $config['keyapi']
	));
	
	$tpl->pparse('menu');
?>