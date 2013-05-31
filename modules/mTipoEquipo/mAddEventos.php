<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	


	
	
	
	
	
	
	$tpl->set_filenames(array('mAddEventos' => 'tAddEventos'));
	/*$tpl->assign_vars(array(
		'NAME'		=> @$empresa['DESCRIPCION'],
		'S'	 =>  $s,
		'N'	 =>  $n,
		'ID' =>  $_GET['data']
	));*/	
	$tpl->pparse('mAddEventos');	
?>	