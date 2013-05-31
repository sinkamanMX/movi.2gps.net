<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$s="";
	$n="";
	$f="";
	$m="";
	$cliente = $dbf->getRow('ADM_CLIENTES','ID_CLIENTE = '.$_GET['data']);
	$s = (@$cliente['ACTIVO']=="S")?'selected="selected"':'';
	$n = (@$cliente['ACTIVO']=="N")?'selected="selected"':'';
	$f = (@$cliente['PERSONA']=="FISICA")?'selected="selected"':'';
	$m = (@$cliente['PERSONA']=="MORAL")?'selected="selected"':'';

	$validacion = $dbf->getRow('ADM_CLIENTES_VALIDACION','ID_CLIENTE = '.$_GET['data']);
	
	$tpl->set_filenames(array('mSetCliente' => 'tSetCliente'));
	$tpl->assign_vars(array(
		'NAME'		=> @$cliente['NOMBRE'],
		'RFC'		=> @$cliente['RFC'],
		'RZN'		=> @$cliente['RAZON_SOCIAL'],
		'TEL'		=> @$cliente['TELEFONO'],
		'DIR'		=> @$cliente['DIRECCION'],
		'CON'		=> @$cliente['NOMBRE_CONTACTO'],
		'EMA'		=> @$cliente['EMAIL'],
		'MOV'		=> @$cliente['MOVIL'],
		'A_S'	 	=>  $s,
		'A_N'	 	=>  $n,
		'P_F'	 	=>  $f,
		'P_M'	 	=>  $m,
		'ID' 		=>  $_GET['data'],
		'PREG'		=> @$validacion['PREGUNTA'],
		'RESP'		=> @$validacion['RESPUESTA']
	));	
	$tpl->pparse('mSetCliente');	
?>	