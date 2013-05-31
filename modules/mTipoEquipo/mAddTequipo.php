<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	//Llenar select marca
	$sql_mar = "SELECT * FROM ADM_MARCA ORDER BY DESCRIPTION";
	
	$qry_mar = $db->sqlQuery($sql_mar);
	$cnt_mar = $db->sqlEnumRows($qry_mar);
	if($cnt_mar>0){ 
		while($row_mar=$db->sqlFetchArray($qry_mar)){	
		$tpl->assign_block_vars('marca',array(
		'IDMAR' =>$row_mar['COD_TRADEMARK'],
		'MARCA' =>$row_mar['DESCRIPTION'],
		));
	}
	}
	//-----------------------------------------------

	//Llenar select tipo de comunicación
	$sql_com = "SELECT COD_TYPE_COMUNICATION,TYPE_COMUNICATION FROM ADM_TIPO_COMUNICACION ORDER BY TYPE_COMUNICATION;";
	
	$qry_com = $db->sqlQuery($sql_com);
	$cnt_com = $db->sqlEnumRows($qry_com);
	if($cnt_com > 0){ 
		while($row_com = $db->sqlFetchArray($qry_com)){	
		$tpl->assign_block_vars('com',array(
		'IDTC' =>$row_com['COD_TYPE_COMUNICATION'],
		'TCOM' =>$row_com['TYPE_COMUNICATION'],
		));
	}
	}
	//-----------------------------------------------		

	
	
	
	
	
	$tpl->set_filenames(array('mAddTequipo' => 'tAddTequipo'));
	/*$tpl->assign_vars(array(
		'NAME'		=> @$empresa['DESCRIPCION'],
		'S'	 =>  $s,
		'N'	 =>  $n,
		'ID' =>  $_GET['data']
	));*/	
	$tpl->pparse('mAddTequipo');	
?>	