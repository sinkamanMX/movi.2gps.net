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
		'mImage'=>'tImage'
	));

	$tpl->assign_vars(array(
		'IMG'			=> $_GET['img'],
		'ID'			=> $_GET['id']
	));			
	$tpl->pparse('mImage');	
?>
