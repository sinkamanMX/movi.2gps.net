<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	
	/*Se valida la variaable data, si esta viene y es diferente de 0 es uan edicion*/
	//if(isset($_GET['data']) || $_GET['data'] !=0){		
	
		$s="";
		$n="";
		$cliente = $dbf->getRow('ADM_CLIENTES','ID_CLIENTE = '.$_GET['data']);
		//echo $status = $dbf->getRow('ADM_CLIENTES','ID_EMPRESA = '.$_GET['data']);
	//}else{
		$s = (@$cliente['ESTATUS']=="1")?'selected="selected"':'';
		$n = (@$cliente['ESTATUS']=="0")?'selected="selected"':'';
	//}
	
	
	
	
	
	
	$tpl->set_filenames(array('mSetCliente' => 'tSetCliente'));
	$tpl->assign_vars(array(
		'NAME'		=> @$cliente['DESCRIPCION'],
		'S'	 =>  $s,
		'N'	 =>  $n,
		'ID' =>  $_GET['data']
	));	
	$tpl->pparse('mSetCliente');	
?>	