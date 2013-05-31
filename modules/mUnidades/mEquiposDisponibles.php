<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	
	$tpl->set_filenames(array('mEquiposDisponibles' => 'tEquiposDisponibles'));
	//Llenar select EquiposDisponibles
	$sql_ = "SELECT E.COD_EQUIPMENT,E.DESCRIPCION FROM ADM_EQUIPOS E WHERE E.ID_CLIENTE = ".$cte." ORDER BY E.DESCRIPCION";
	
	$qry_eqd = $db->sqlQuery($sql_eqd);
	$cnt_eqd = $db->sqlEnumRows($qry_eqd);
	if($cnt_eqd>0){ 
		while($row_eqd = $db->sqlFetchArray($qry_eqd)){	
		$tpl->assign_block_vars('disponuble',array(
		'IDEQ' =>$row_eqd['COD_EQUIPMENT'],
		'EQPO' =>$row_eqd['DESCRIPCION'],
		));
	}
	}
	//-----------------------------------------------	
	$tpl->pparse('mEquiposDisponibles');	
?>	