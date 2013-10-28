<?php
/** * 
 *  @package             4togo_Pepsico.
 *  @name                Obtiene los GeoPuntos.
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Erick A. Calderón
 *  @modificado          12-07-2011 
**/

	//--------------------------- Modificada BD y Encabezado------------------------
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';  //Manda al login si no se ha Logeo.
	//--------------------------- Modificada BD y Encabezado------------------------
	$db ->sqlQuery("SET NAMES 'utf8'");
	
	$tpl->set_filenames(array(
		'mMunicipio'=>'tMunicipio'
	));
	
	$sql  = "SELECT ID_MUNICIPIO,NOMBRE FROM ZZ_SPM_MUNICIPIOS WHERE ID_ESTADO = ".$_GET['id']." ORDER BY NOMBRE;";
					
						
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	
	if($cnt > 0){ 
		while($row = $db->sqlFetchArray($qry)){
		   
		
		$tpl->assign_block_vars('data',array(
		'IDM'	=>	$row['ID_MUNICIPIO'],
		'MUN'	=>	$row['NOMBRE']
		));
		}
	$tpl->pparse('mMunicipio');	
	}
	else{
		echo 0;
		}


	
	
	
	

?>
