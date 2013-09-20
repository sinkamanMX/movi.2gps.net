<?php
/** * 
 *  @package             4togo_Pepsico.
 *  @name                Obtiene los Municipios.
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Erick A. Calderón
 *  @modificado          16-08-2011 
**/

	//--------------------------- Modificada BD y Encabezado------------------------
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';  //Manda al login si no se ha Logeo.
	//--------------------------- Modificada BD y Encabezado------------------------
    
	$tpl->set_filenames(array(
		'mGetMuni_f' => 'tGetMuni_f'
	));
		header('Content-Type: text/html; charset=iso-8859-1');
	if(isset($_GET['idstat'])){
		$sql = "SELECT 	ID_MUNICIPIO,NOMBRE
				FROM ZZ_SPM_MUNICIPIOS
				WHERE ID_ESTADO = ".$_GET['idstat']."
				ORDER BY NOMBRE";
		$query = $db->sqlQuery($sql);
		while($row = $db->sqlFetchArray($query)){
			$tpl->assign_block_vars('munis',array(
				'ID'   => $row['ID_MUNICIPIO'] ,
				'NAME' => $row['NOMBRE']
 			));
		}
		$tpl->pparse('mGetMuni_f');
		$db->sqlClose();
	}
?>