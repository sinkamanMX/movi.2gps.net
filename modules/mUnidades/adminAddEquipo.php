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
	$cte = $_GET['id_client'];
    $emp = $_GET['id_company'];

	$tpl->set_filenames(array('mAddEquipo' => 'tAddEquipo'));
	//Llenar select marca
	$sql_mar = "SELECT * FROM ADM_MARCA ORDER BY DESCRIPTION";
	
	$qry_mar = $db->sqlQuery($sql_mar);
	$cnt_mar = $db->sqlEnumRows($qry_mar);
	if($cnt_mar>0){ 
		while($row_mar=$db->sqlFetchArray($qry_mar)){	
		$tpl->assign_block_vars('marca',array(
		'IDMAR' => $row_mar['COD_TRADEMARK'],
		'MARCA' => $Functions->codif($row_mar['DESCRIPTION']),
		));
	}
	}
	//-----------------------------------------------	
	
	//Llenar select tipo unidad
	$sql_tip = "SELECT T.COD_TYPE_ENTITY, T.DESCRIPTION FROM ADM_TIPO_UNIDAD T ORDER BY T.DESCRIPTION";
	
	$qry_tip = $db->sqlQuery($sql_tip);
	$cnt_tip = $db->sqlEnumRows($qry_tip);
	if($cnt_tip>0){ 
		while($row_tip = $db->sqlFetchArray($qry_tip)){	
		$tpl->assign_block_vars('tipo',array(
		'IDTP' =>$row_tip['COD_TYPE_ENTITY'],
		'TIPO' =>$Functions->codif($row_tip['DESCRIPTION']),
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
		$tpl->assign_block_vars('cliente',array(
		'IDCL' =>$row_cli['ID_CLIENTE'],
		'CLIE' =>$Functions->codif($row_cli['NOMBRE']),
		));
	}
	}
	//-----------------------------------------------	
	//Llenar select grupo
	$sql_gpo = "SELECT G.ID_GRUPO, G.NOMBRE FROM ADM_GRUPOS G
	INNER JOIN ADM_GRUPOS_CLIENTES GC ON GC.ID_GRUPO=G.ID_GRUPO
	WHERE GC.ID_CLIENTE= ".$cte." ORDER BY G.NOMBRE";
	
	$qry_gpo = $db->sqlQuery($sql_gpo);
	$cnt_gpo = $db->sqlEnumRows($qry_gpo);
	if($cnt_gpo >0){ 
		while($row_gpo = $db->sqlFetchArray($qry_gpo)){	
		$tpl->assign_block_vars('grupo',array(
		'IDGPO' =>$row_gpo['ID_GRUPO'],
		'GRUPO' =>$Functions->codif($row_gpo['NOMBRE']),
		));
	}
	}

	$sql_eqd = " FROM ADM_EQUIPOS E 
				WHERE E.ID_CLIENTE = ".$cte." 
				AND E.COD_EQUIPMENT NOT IN (SELECT COD_EQUIPMENT 
											FROM ADM_UNIDADES_EQUIPOS ) ORDER BY E.DESCRIPCION";
	$eq_disponibles = $dbf->cbo_from_query('E.COD_EQUIPMENT','E.DESCRIPCION',$sql_eqd,'',false); 
	$status = $Functions->cbo_from_array($a_respuestas,@$equipo['ACTIVE']);
	
	$tpl->assign_vars(array(
		'NOASIG' => $eq_disponibles,
		'STATUS'	=> $status
	));	
	//-----------------------------------------------			
	$tpl->pparse('mAddEquipo');	
?>	