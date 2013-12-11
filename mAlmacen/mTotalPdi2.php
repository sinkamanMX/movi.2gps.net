<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
		
	$db ->sqlQuery("SET NAMES 'utf8'");
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	$id_alamacen = $_GET['id'];

	//
	$tipo_unidad = "SELECT ID_TIPO_PDI_UNIDAD FROM PED_ALMACEN WHERE ID_ALMACEN = ".$id_alamacen;
	$kuery   = $db->sqlQuery($tipo_unidad);
	$renglon = $db->sqlFetchArray($kuery);


if($renglon['ID_TIPO_PDI_UNIDAD'] == '1'){
	//--------------------------------------------------------------------------------------------------------------	
	$sql = " SELECT V.ID_OBJECT_MAP,V.DESCRIPCION FROM PED_ALMACEN_PDI_UNIDAD Z 
			INNER JOIN PED_ALMACEN W ON Z.ID_ALMACEN = W.ID_ALMACEN
			INNER JOIN ADM_GEOREFERENCIAS V ON V.ID_OBJECT_MAP = Z.ID_PDI 
			WHERE Z.ID_CLIENTE = ".$cte." AND W.ID_TIPO_PDI_UNIDAD = ".$renglon['ID_TIPO_PDI_UNIDAD']." AND W.ID_ALMACEN =".$id_alamacen;

	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);

//--------------------------------------------------------------------------------------------------------------
	
	$sql2 = " SELECT ID_OBJECT_MAP, DESCRIPCION FROM ADM_GEOREFERENCIAS WHERE ID_OBJECT_MAP NOT IN(
			  SELECT V.ID_OBJECT_MAP FROM PED_ALMACEN_PDI_UNIDAD Z 
			  INNER JOIN PED_ALMACEN W ON Z.ID_ALMACEN = W.ID_ALMACEN
			  INNER JOIN ADM_GEOREFERENCIAS V ON V.ID_OBJECT_MAP = Z.ID_PDI 
			  WHERE Z.ID_CLIENTE =  ".$cte." AND W.ID_TIPO_PDI_UNIDAD = ".$renglon['ID_TIPO_PDI_UNIDAD']." AND W.ID_ALMACEN = ".$id_alamacen."
			) AND  TIPO = 'G' AND ID_CLIENTE =  ".$cte." ORDER BY DESCRIPCION";

	$qry2 = $db->sqlQuery($sql2);
	$cnt2 = $db->sqlEnumRows($qry2);
	
//--------------------------------------------------------------------------------------------------------------	
	
	$tpl->set_filenames(array('mTotalPdi2'=>'tTotalPdi2'));	
	
	          while($rowZ = $db->sqlFetchArray($qry)){
		      	$tpl->assign_block_vars('group',array(
							'ID_OBJECT_MAP'   => $rowZ['ID_OBJECT_MAP'],
							'DESCRIPCION'  => $rowZ['DESCRIPCION']
					));
	          }

	          
	          while($rowW = $db->sqlFetchArray($qry2)){
		      	$tpl->assign_block_vars('group2',array(
							'ID_OBJECT_MAP'   => $rowW['ID_OBJECT_MAP'],
							'DESCRIPCION'     => $rowW['DESCRIPCION']
					));
	          }
	          
	          
	$tpl->pparse('mTotalPdi2');
}

/*******************************************************************************************************/

if($renglon['ID_TIPO_PDI_UNIDAD'] == '2'){
	//--------------------------------------------------------------------------------------------------------------	
	$sql = "SELECT V.COD_ENTITY,V.DESCRIPTION FROM PED_ALMACEN_PDI_UNIDAD Z 
			INNER JOIN PED_ALMACEN W ON Z.ID_ALMACEN = W.ID_ALMACEN
			INNER JOIN ADM_UNIDADES V ON V.COD_ENTITY = Z.COD_ENTITY 
			WHERE Z.ID_CLIENTE = ".$cte." AND W.ID_TIPO_PDI_UNIDAD = ".$renglon['ID_TIPO_PDI_UNIDAD']." AND W.ID_ALMACEN = ".$id_alamacen;

	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);

//--------------------------------------------------------------------------------------------------------------
	
	 $sql2 = " SELECT COD_ENTITY, DESCRIPTION FROM ADM_UNIDADES WHERE COD_ENTITY NOT IN(
			  SELECT V.COD_ENTITY FROM PED_ALMACEN_PDI_UNIDAD Z 
			  INNER JOIN PED_ALMACEN W ON Z.ID_ALMACEN = W.ID_ALMACEN
			  INNER JOIN ADM_UNIDADES V ON V.COD_ENTITY = Z.COD_ENTITY 
			  WHERE Z.ID_CLIENTE = ".$cte." AND W.ID_TIPO_PDI_UNIDAD = ".$renglon['ID_TIPO_PDI_UNIDAD']." AND W.ID_ALMACEN = ".$id_alamacen."
			) AND COD_CLIENT = ".$cte." ORDER BY DESCRIPTION";

	$qry2 = $db->sqlQuery($sql2);
	$cnt2 = $db->sqlEnumRows($qry2);
	
//--------------------------------------------------------------------------------------------------------------	
	
	$tpl->set_filenames(array('mTotalPdi2'=>'tTotalUnidades2'));	
	
	          while($rowZ = $db->sqlFetchArray($qry)){
		      	$tpl->assign_block_vars('group',array(
							'COD_ENTITY'   => $rowZ['COD_ENTITY'],
							'DESCRIPTION'  => $rowZ['DESCRIPTION']
					));
	          }

	          
	          while($rowW = $db->sqlFetchArray($qry2)){
		      	$tpl->assign_block_vars('group2',array(
							'COD_ENTITY'   => $rowW['COD_ENTITY'],
							'DESCRIPTION'     => $rowW['DESCRIPTION']
					));
	          }
	          
	          
	$tpl->pparse('mTotalPdi2');
}

	

	
		
?>	