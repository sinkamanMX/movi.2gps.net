<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$equipo = $dbf->getRow('ADM_EQUIPOS_TIPO','COD_TYPE_EQUIPMENT = '.$_GET['data']);

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
		//echo $row_mar['COD_TRADEMARK']."==".$mar."<br>"	;
		$s = ($row_mar['COD_TRADEMARK']==$mar)?'selected="selected"':'';
		$tpl->assign_block_vars('marca',array(
		'IDMAR' =>$row_mar['COD_TRADEMARK'],
		'MARCA' =>$row_mar['DESCRIPTION'],
		'SLTD' =>$s
		));
	}
	}
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
		'MODL' =>$row_mod['DESCRIPTION'],
		'SLTD' =>$s
		));
	}
	}
	//-----------------------------------------------	
	//Llenar select tipo de comunicación 
	$sql_com = "SELECT C.COD_TYPE_COMUNICATION, C.TYPE_COMUNICATION FROM ADM_TIPO_COMUNICACION C ORDER BY C.TYPE_COMUNICATION";
	$qry_com = $db->sqlQuery($sql_com);
	$cnt_com = $db->sqlEnumRows($qry_com);
	if($cnt_com > 0){ 
		while($row_com = $db->sqlFetchArray($qry_com)){	
		$s= ($row_com['COD_TYPE_COMUNICATION']==@$equipo['COD_TYPE_COMUNICATION'])?'selected="selected"':'';
		$tpl->assign_block_vars('com',array(
		'IDTC' =>$row_com['COD_TYPE_COMUNICATION'],
		'TCOM' =>$row_com['TYPE_COMUNICATION'],
		'SLTD' =>$s
		));
	}
	}
	//-----------------------------------------------			

	//$s = (@$empresa['ACTIVO']=="S")?'selected="selected"':'';
	//$n = (@$empresa['ACTIVO']=="N")?'selected="selected"':'';

	
	
	$tpl->set_filenames(array('mSetTequipo' => 'tSetTequipo'));
	$tpl->assign_vars(array(
	//`DESCRIPCION``ACTIVO``RAZON_SOCIAL``RFC``DIRECCION``TELEFONO``CREADO``REPRESENTANTE_LEGAL`
		'NAME'		=> @$equipo['DESCRIPTION'],
		'PORT'		=> @$equipo['PORT_DEFAULT'],
		'ID' 		=>  $_GET['data']
	));	
	$tpl->pparse('mSetTequipo');	
?>	