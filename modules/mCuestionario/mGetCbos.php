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
	$cte = $userAdmin->user_info['ID_CLIENTE'];

	$tpl->set_filenames(array('mGetCbos'=>'tGetCbos'));	
	
	$sy = ($_GET['y']!="")?$_GET['y']:'';
	$sz = ($_GET['z']!="")?$_GET['z']:'';

	$z = $dbf->cbo_from("ID_EJE_Z","DESCRIPCION","CRM2_EJE_Z"," ID_CLIENTE = ".$cte." ORDER BY DESCRIPCION ",$option=$sz);
	$y = $dbf->cbo_from("ID_EJE_X","DESCRIPCION","CRM2_EJE_X"," ID_CLIENTE = ".$cte." ORDER BY DESCRIPCION ",$option=$sy);


	$tpl->assign_vars(array(
		'Z'	=> $z,
		'Y' => $y
	));		
	

	$tpl->pparse('mGetCbos');


	

	

?>
