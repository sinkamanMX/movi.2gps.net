<?php
/** * 
 *  @package             4togo_Pepsico.
 *  @name                Obtiene los GeoPuntos.
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              rODWYN mORENO
 *  @modificado          12-07-2011 
**/

	//--------------------------- Modificada BD y Encabezado------------------------
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';  //Manda al login si no se ha Logeo.
	//--------------------------- Modificada BD y Encabezado------------------------
	$client   = $userAdmin->user_info['ID_CLIENTE'];
	$tpl->set_filenames(array(
		'mExport_Form'=>'tExport_Form'
	));
	
	for($i=0;$i<24;$i++){
		$hour = ($i < 10) ? '0'.$i : $i; 
		$chk  = ($i == 0) ? 'selected="selected"':'';
		$s = ($i==23)?'selected="selected"':'';
		$tpl->assign_block_vars('hrs',array(
			'NO'   => '<option '.$chk.' value="'.$hour.'">'.$hour.'</option>',
			'HF'   => '<option '.$chk.' value="'.$hour.'" '.$s.'>'.$hour.'</option>'			
 			));			
	}
		
	for($i=0;$i<60;$i++){
		$hour = ($i < 10) ? '0'.$i : $i; 
		$chk  = ($i == 0) ? 'selected="selected"':'';
		$s = ($i==59)?'selected="selected"':'';
		$tpl->assign_block_vars('min',array(
		'NO'   => '<option '.$chk.' value="'.$hour.'">'.$hour.'</option>',
		'MF'   => '<option '.$chk.' value="'.$hour.'" '.$s.'>'.$hour.'</option>'	
 		));			
	}	
	
	$sql = "SELECT ID_USUARIO,NOMBRE_COMPLETO FROM ADM_USUARIOS WHERE ID_CLIENTE  = ".$client." ORDER BY NOMBRE_COMPLETO;";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);		
	if($cnt > 0){
		while($row = $db->sqlFetchArray($qry)){
			$tpl->assign_block_vars('dt3',array(
				'IDU'	=> $row['ID_USUARIO'],
				'USR'	=> utf8_encode($row['NOMBRE_COMPLETO'])
				));	
				}
		}
	$sql_u  = "SELECT ID_CUESTIONARIO,DESCRIPCION FROM CRM2_CUESTIONARIOS WHERE COD_CLIENT = ".$client." ORDER BY DESCRIPCION;";
	$qry_u = $db->sqlQuery($sql_u);
	$cnt_u = $db->sqlEnumRows($qry_u);
	
	if($cnt_u > 0){ 
		while($row_u = $db->sqlFetchArray($qry_u)){
		
		$tpl->assign_block_vars('U',array(
		'ID'	=>	$row_u['ID_CUESTIONARIO'],
		'DES'	=>	$row_u['DESCRIPCION']
		));
		}
	}			
	/*$sql  = "SELECT ID_COLONIA,NOMBRE FROM ZZ_SPM_COLONIAS WHERE ID_MUNICIPIO = ".$_GET['id']." AND ID_ESTADO = ".$_GET['ide']."  ORDER BY NOMBRE;";
					
						
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	
	if($cnt > 0){ 
		while($row = $db->sqlFetchArray($qry)){
		   
		
		$tpl->assign_block_vars('data',array(
		'IDC'	=>	$row['ID_COLONIA'],
		'COL'	=>	$row['NOMBRE']
		));
		}*/
	$tpl->assign_vars(array(
		'DATE'			=> date("Y-m-d")
	));			
	$tpl->pparse('mExport_Form');	
	/*}
	else{
		echo 0;
		}*/


	
	
	
	

?>
