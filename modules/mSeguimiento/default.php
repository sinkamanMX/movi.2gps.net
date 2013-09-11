<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo silver 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          23-04-2012
**/
	//include("public/php/date.php");
	
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';  //Manda al login si no se ha Logeo.
	//--------------------------- Modificada BD y Encabezado------------------------
	$client   = $userAdmin->user_info['ID_CLIENTE'];
	
	$tpl->set_filenames(array('default'=>'default'));	

	
	
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
	
	$sql = "SELECT COD_ENTITY,DESCRIPTION FROM ADM_UNIDADES WHERE COD_CLIENT=".$client." ORDER BY DESCRIPTION;";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);		
	if($cnt > 0){
		while($row = $db->sqlFetchArray($qry)){
			$tpl->assign_block_vars('dt3',array(
				'I_D'	=> $row['COD_ENTITY'],
				'DSC'	=> utf8_encode($row['DESCRIPTION'])
				));	
				}
		}
	
		 
	$tpl->assign_vars(array(
		//'URL'           => $row_pm['UBICACION'],
		'PAGE_TITLE'	=> "Geopuntos",
		'PATH'			=> $dir_mod,
		'PATH_IMG'		=> $dir_pimages,
		//'COD_USER' 		=> $userAdmin->user_info['COD_USER'],
		//'COD_CLI'	 	=> $userAdmin->user_info['COD_CLIENT'],
		'APIKEY'		=> $config['keyapi'],
		//'FECHA'       	=> fecha(),
		'COD_USER' 		=> $userAdmin->user_info['COD_USER'],
		'COD_CLI'	 	=> $userAdmin->user_info['COD_CLIENT'],
		'DATE'			=> date("Y-m-d")
	));	

	$tpl->pparse('default');
?>