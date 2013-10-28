<?php
/** * 
 *  @package             4togo_Pepsico.
 *  @name                Obtiene los GeoPuntos.
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          12-07-2011 
**/

	//--------------------------- Modificada BD y Encabezado------------------------
	header('Content-type: text/html; charset=UTF-8') ;
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';  //Manda al login si no se ha Logeo.
	//--------------------------- Modificada BD y Encabezado------------------------
	

	$db ->sqlQuery("SET NAMES 'utf8'");


	$tpl->set_filenames(array('mGetLog'=>'tGetLog'));	
	$data = "";

	$sql = "SELECT L.FECHA,L.OBSERVACIONES, U.NOMBRE_COMPLETO FROM CRM2_LOG L
	INNER JOIN ADM_USUARIOS U ON U.ID_USUARIO = L.ID_USER 
	WHERE L.ID_RES_CUESTIONARIO = ".$_GET['idq']." ORDER BY L.FECHA;";
	

	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	
	if($cnt > 0){ 
		while($row = $db->sqlFetchArray($qry)){
			$data .= ($data!="") ? ', ': '';
			$data .= '{"FECHA"   : "'.$row['FECHA'] 		   .'" , '.
					 ' "USER"    : "'.$row['NOMBRE_COMPLETO'].'" , '.
					 ' "OBS"     : "'.$row['OBSERVACIONES'].'" }';}
	}	
	$tpl->assign_vars(array(
		'LOG'	=> $data
	));		
	
	$db->sqlClose();
	$tpl->pparse('mGetLog');


	

	

?>
