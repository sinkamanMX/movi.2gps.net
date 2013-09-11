<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo silver 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Edgar Sanabria Paredes
 *  @modificado          05-04-2013
**/
//	include("public/php/date.php");

	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	

	
	
	$tpl->set_filenames(array('default'=>'default'));	
	$idProfile   = $userAdmin->user_info['ID_PROFILE'];	
	
	$menu = ''; 
	
	$tpl->assign_vars(array(
		'PAGE_TITLE'	=> "Alertas",	
		'PATH'			=> $dir_mod,
		'PATH_IMG'		=> $dir_pimages,
		'NAME'			=> $userAdmin->user_info['USER_NAME'],
		'MAIL'			=> $userAdmin->user_info['USER_EMAIL'],
		'TYPE'			=> $userAdmin->user_info['PRIVILEGES'],		
		'APIKEY'		=> $config['keyapi'],
		'COD_USER' 		=> $userAdmin->user_info['COD_USER'],
		'COD_CLI'	 	=> $userAdmin->user_info['COD_CLIENT']
		//'SUBMENU'		=> $userAdmin->obtener_submenu($_GET['m']),
		//'Tituño'		=> 'M&oacute;dulo Monitoreo'
	));	

	$tpl->pparse('default');
?>