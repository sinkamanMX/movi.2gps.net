<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
 *  @modificado          27042011
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	$tpl->set_filenames(array('default'=>'default'));		 
	
	$tpl->assign_vars(array(
		'PAGE_TITLE'	=> 'M&oacute;dulo Geo Referencias',	
		'PATH'			=> $dir_mod,
		'NAME'			=> $Functions->codif($userAdmin->user_info['NICK_NAME']),
		'MAIL'			=> $Functions->codif($userAdmin->user_info['E_MAIL']),
		'SUBMENU'		=> $userAdmin->obtener_submenu($_GET['m']),
		'B'	            => $row['BODY'],
		'TABS'          => $userAdmin->obtener_menu($_GET['m']),
		'HEADER'		=> $userAdmin->getHeaderAdmin('Administración Geo Referencias','geos')
	));	
	$tpl->pparse('default');
?>