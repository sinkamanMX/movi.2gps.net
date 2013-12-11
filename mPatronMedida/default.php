<?php
/*
 *  @package             
 *  @name                Pagina default del modulo unidad de medida 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Daniel Arazo
 *  @modificado          11-26-2013
**/
 
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	/*if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';*/
	
	$tpl->set_filenames(array('default'=>'default'));	
	$idProfile   = $userAdmin->user_info['ID_PROFILE'];	

	$tpl->assign_vars(array(
		'PAGE_TITLE'	=> "Patron de Medida",	
		'PATH'			=> $dir_mod,
		'PATH_IMG'		=> $dir_pimages,	
		'APIKEY'		=> $config['keyapi'],
		'COD_USER' 		=> $userAdmin->user_info['COD_USER'],
		'COD_CLI'	 	=> $userAdmin->user_info['COD_CLIENT']
	));	

	$tpl->pparse('default');
?>