<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$comando = $dbf->getRow('ADM_COMANDOS_SALIDA','COD_EQUIPMENT_PROGRAM = '.$_GET['data']);


	$fs = (@$comando['FLAG_INPUT_VARIABLE']=="1")?'selected="selected"':'';
	$fn = (@$comando['FLAG_INPUT_VARIABLE']=="0")?'selected="selected"':'';
	$ps = (@$comando['FLAG_PASS']=="1")?'selected="selected"':'';
	$pn = (@$comando['FLAG_PASS']=="0")?'selected="selected"':'';

	
	
	$tpl->set_filenames(array('mSetComando' => 'tSetComando'));
	$tpl->assign_vars(array(
	//``````````
		'DES'		=> @$comando['DESCRIPCION'],
		'COM'		=> @$comando['COMMAND_EQUIPMENT'],
		'BYT' 		=> @$comando['QUANTITY_BYTES_SENT'],
		'FLS' 		=> $fs,
		'FLN' 		=> $fn,
		'PAS' 		=> $ps,
		'PAN' 		=> $pn,
		'ID' 		=>  $_GET['data']
	));	
	$tpl->pparse('mSetComando');	
?>	