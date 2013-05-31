<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$tpl->set_filenames(array('mModelo2' => 'tModelo2'));
	//Llenar select modelo
	$sql_cli = "SELECT M.COD_TRADEMARK_MODEL, M.DESCRIPTION FROM ADM_MARCA_MODELO M WHERE M.COD_TRADEMARK=".$_GET['eqp_marca']." ORDER BY M.DESCRIPTION";
	
	$qry_cli = $db->sqlQuery($sql_cli);
	$cnt_cli = $db->sqlEnumRows($qry_cli);
	if($cnt_cli>0){ 
		while($row_cli = $db->sqlFetchArray($qry_cli)){	
		$tpl->assign_block_vars('modelo',array(
		'IDMD' =>$row_cli['COD_TRADEMARK_MODEL'],
		'MODL' =>$row_cli['DESCRIPTION'],
		));
	}
	}
	//-----------------------------------------------	
	$tpl->pparse('mModelo2');	
?>	