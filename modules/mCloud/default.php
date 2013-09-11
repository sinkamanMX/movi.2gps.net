<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo silver 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          04-09-2012
**/
	include("public/php/date.php");
	date_default_timezone_set('UTC');  
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	
	$tpl->set_filenames(array('default'=>'default'));	
	$idProfile   = $userAdmin->user_info['ID_PROFILE'];	
	
	$menu = ''; 

	$tpl->assign_vars(array(
		//'URL'           => $row_pm['UBICACION'],
		'PAGE_TITLE'	=> "Cloud",	
		'PATH'			=> $dir_mod,
		'PATH_IMG'		=> $dir_pimages,
/*		'NAME'			=> $userAdmin->codif($userAdmin->user_info['USER_NAME']),
		'MAIL'			=> $userAdmin->codif($userAdmin->user_info['USER_EMAIL']),
		'TYPE'			=> $userAdmin->codif($userAdmin->user_info['PRIVILEGES']),		
		'MENU'			=> $userAdmin->codif($menu),*/
		'APIKEY'		=> $config['keyapi'],
		'FECHA'       	=> fecha()

	));	
	$tpl->pparse('default');
?>