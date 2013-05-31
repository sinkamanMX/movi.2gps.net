<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$evento = $dbf->getRow('ADM_EVENTOS_EQUIPOS','COD_EVENT_EQUIPMENT = '.$_GET['data']);


	//$s = (@$empresa['ACTIVO']=="S")?'selected="selected"':'';
	//$n = (@$empresa['ACTIVO']=="N")?'selected="selected"':'';

	
	
	$tpl->set_filenames(array('mSetEvento' => 'tSetEvento'));
	$tpl->assign_vars(array(
	//`DESCRIPCION``ACTIVO``RAZON_SOCIAL``RFC``DIRECCION``TELEFONO``CREADO``REPRESENTANTE_LEGAL`
		'RZON'		=> @$evento['EVENT_REASON'],
		'CODB'		=> @$evento['SEARCH_CODE'],
		'BYTE' 		=> @$evento['QUANTITY_BYTES_RECEIVE'],
		'ID' 		=>  $_GET['data']
	));	
	$tpl->pparse('mSetEvento');	
?>	