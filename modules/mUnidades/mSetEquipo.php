<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}
	
	$a_respuestas = array(
		array("id"=>"1",'name'=>'Activo' ),
		array("id"=>"0",'name'=>'Inactivo' )
	);
		
	$emp = $userAdmin->user_info['ID_EMPRESA'];
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	
	$equipo = $dbf->getRow('ADM_UNIDADES','COD_ENTITY = '.$_GET['data']);

	//Llenar select tipo unidad
	$sql_tip = "SELECT T.COD_TYPE_ENTITY, T.DESCRIPTION FROM ADM_TIPO_UNIDAD T ORDER BY T.DESCRIPTION";
	
	$qry_tip = $db->sqlQuery($sql_tip);
	$cnt_tip = $db->sqlEnumRows($qry_tip);
	if($cnt_tip>0){ 	
		while($row_tip = $db->sqlFetchArray($qry_tip)){	
		$s= ($row_tip['COD_TYPE_ENTITY']==@$equipo['COD_TYPE_ENTITY'])?'selected="selected"':'';
		$tpl->assign_block_vars('tipo',array(
		'IDTP' =>$row_tip['COD_TYPE_ENTITY'],
		'TIPO' =>$Functions->codif($row_tip['DESCRIPTION']),
		'SLTD' =>$s
		));
	}
	}
	//-----------------------------------------------
	//Llenar select cliente
	$sql_cli = "SELECT C.ID_CLIENTE,C.NOMBRE FROM ADM_CLIENTES C WHERE C.ID_EMPRESA = ".$emp." ORDER BY C.NOMBRE";
	
	$qry_cli = $db->sqlQuery($sql_cli);
	$cnt_cli = $db->sqlEnumRows($qry_cli);
	if($cnt_cli>0){ 
		while($row_cli = $db->sqlFetchArray($qry_cli)){	
		$s= ($row_cli['ID_CLIENTE']==@$equipo['COD_CLIENT'])?'selected="selected"':'';
		$tpl->assign_block_vars('cliente',array(
		'IDCL' =>$row_cli['ID_CLIENTE'],
		'CLIE' =>$Functions->codif($row_cli['NOMBRE']),
		'SLTD' =>$s
		));
	}
	}
	//-----------------------------------------------		
	//Obtener grupo
	//$sql_obt_gpo = "SELECT ID_GRUPO_CLIENTE FROM ADM_GRUPOS_UNIDADES WHERE COD_ENTITY=".$_GET['data'];
	$sql_obt_gpo = "SELECT ID_GRUPO FROM ADM_GRUPOS_UNIDADES WHERE COD_ENTITY=".$_GET['data'];
	$qry_obt_gpo = $db->sqlQuery($sql_obt_gpo);	
	$row_obt_gpo = $db->sqlFetchArray($qry_obt_gpo);
	
	//Llenar select grupo
	$sql_gpo = "SELECT G.ID_GRUPO, G.NOMBRE FROM ADM_GRUPOS G
	INNER JOIN ADM_GRUPOS_CLIENTES GC ON GC.ID_GRUPO=G.ID_GRUPO
	WHERE GC.ID_CLIENTE= ".$cte." ORDER BY G.NOMBRE";
	
	$qry_gpo = $db->sqlQuery($sql_gpo);
	$cnt_gpo = $db->sqlEnumRows($qry_gpo);
	if($cnt_gpo >0){ 
		while($row_gpo = $db->sqlFetchArray($qry_gpo)){
		//echo	$row_gpo['ID_GRUPO']."==".$row_obt_gpo['ID_GRUPO'];
		$s= ($row_gpo['ID_GRUPO']==$row_obt_gpo['ID_GRUPO'])?'selected="selected"':'';	
		$tpl->assign_block_vars('grupo',array(
		'IDGPO' =>$row_gpo['ID_GRUPO'],
		'GRUPO' =>$Functions->codif($row_gpo['NOMBRE']),
		'SLTD' =>$s
		));
	}
	}
	//-----------------------------------------------
	//Obtener id marca
	$sql_obt_mar = "SELECT M.COD_TRADEMARK FROM ADM_MARCA M
	INNER JOIN ADM_MARCA_MODELO MM ON M.COD_TRADEMARK = MM.COD_TRADEMARK
	WHERE MM.COD_TRADEMARK_MODEL= ".@$equipo['COD_TRADEMARK_MODEL'];
	$qry_obt_mar = $db->sqlQuery($sql_obt_mar);	
	$row_obt_mar = $db->sqlFetchArray($qry_obt_mar);	
	$mar = $row_obt_mar['COD_TRADEMARK'];
	//Llenar select marca
	$sql_mar = "SELECT * FROM ADM_MARCA ORDER BY DESCRIPTION";
	
	$qry_mar = $db->sqlQuery($sql_mar);
	$cnt_mar = $db->sqlEnumRows($qry_mar);
	if($cnt_mar>0){ 
		while($row_mar=$db->sqlFetchArray($qry_mar)){
		$s = ($row_mar['COD_TRADEMARK']==$mar)?'selected="selected"':'';
		$tpl->assign_block_vars('marca',array(
		'IDMAR' =>$row_mar['COD_TRADEMARK'],
		'MARCA' =>$Functions->codif($row_mar['DESCRIPTION']),
		'SLTD' =>$s
		));
	}
	}
	//-----------------------------------------------		
	//-----------------------------------------------
	//Llenar select modelo
	$sql_mod = "SELECT M.COD_TRADEMARK_MODEL, M.DESCRIPTION FROM ADM_MARCA_MODELO M 
	WHERE M.COD_TRADEMARK=".$mar." ORDER BY M.DESCRIPTION";
	
	$qry_mod = $db->sqlQuery($sql_mod);
	$cnt_mod = $db->sqlEnumRows($qry_mod);
	if($cnt_mod>0){ 
		while($row_mod = $db->sqlFetchArray($qry_mod)){	
		$s= ($row_mod['COD_TRADEMARK_MODEL']==@$equipo['COD_TRADEMARK_MODEL'])?'selected="selected"':'';
		$tpl->assign_block_vars('modelo',array(
		'IDMD' =>$row_mod['COD_TRADEMARK_MODEL'],
		'MODL' =>$Functions->codif($row_mod['DESCRIPTION']),
		'SLTD' =>$s
		));
	}
	}
	$sql_eqd = " FROM ADM_EQUIPOS E 
				WHERE E.ID_CLIENTE = ".$cte." 
				AND E.COD_EQUIPMENT NOT IN (SELECT COD_EQUIPMENT 
											FROM ADM_UNIDADES_EQUIPOS ) ORDER BY E.DESCRIPCION";
	$eq_disponibles = $dbf->cbo_from_query('E.COD_EQUIPMENT','E.DESCRIPCION',$sql_eqd,'',false); 

	$sql_eqnd = " FROM ADM_EQUIPOS E
  				INNER JOIN ADM_UNIDADES_EQUIPOS UE ON UE.COD_EQUIPMENT = E.COD_EQUIPMENT
  				WHERE UE.COD_ENTITY = ".$_GET['data'];
	$eq_nodisponibles = $dbf->cbo_from_query('E.COD_EQUIPMENT','E.DESCRIPCION',$sql_eqnd,'',false); 
	
	$status = $Functions->cbo_from_array($a_respuestas,@$equipo['ACTIVE']);
	
	//-----------------------------------------------			
	$tpl->set_filenames(array('mSetEquipo' => 'tSetEquipo'));
	$tpl->assign_vars(array(
		'UND'		=> @$equipo['DESCRIPTION'],
		'PLA'		=> @$equipo['PLAQUE'],
		'SER'		=> @$equipo['BODYWORK_CODE'],
		'MOT'		=> @$equipo['MOTOR_CODE'],
		'ID' 		=> $_GET['data'],
		'NOASIG' 	=> $eq_disponibles,
		'ASIG'   	=> $eq_nodisponibles,
		'STATUS'	=> $status
	));	
	$tpl->pparse('mSetEquipo');	
?>	