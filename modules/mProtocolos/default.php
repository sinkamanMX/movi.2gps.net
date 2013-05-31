<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
 *  @modificado          27042011
**/
	$db = new sql($config_bd['host'],$config_bd['port'],
				  $config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	$tpl->set_filenames(array('default'=>'default'));		 
	
	$tpl->assign_vars(array(
		'PAGE_TITLE'	=> 'M&oacute;dulo Protocolos',	
		'PATH'			=> $dir_mod,
		'HEADER'		=> $userAdmin->getHeaderAdmin('Administración de Protocolos','proc')
	));	
	$tpl->pparse('default');
?>