<?php
/** * 
 *  @package             4togo_Pepsico.
 *  @name                Obtiene los GeoPuntos.
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              ING RODWYN MORENO
 *  @modificado          01/08/2013
**/

	//--------------------------- Modificada BD y Encabezado------------------------
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';  //Manda al login si no se ha Logeo.
	//--------------------------- Modificada BD y Encabezado------------------------
	$db ->sqlQuery("SET NAMES 'utf8'");
	$client   = $userAdmin->user_info['ID_CLIENTE'];

	$eje = "";
	if($_GET['typ']=='x' | $_GET['typ']=='z'){
	if($_GET['typ']=='x'){
		$eje = "CRM2_EJE_X";
		}
	if($_GET['typ']=='z'){
		$eje = "CRM2_EJE_Z";
		}
	$sql = "SELECT COUNT(DESCRIPCION) AS DES FROM ".$eje." WHERE DESCRIPCION = '".$_GET['txt']."' AND ID_CLIENTE = ".$client;
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	
	if($cnt>0){
		$row=$db->sqlFetchArray($qry);
		echo $row['DES'];
	}
	else{
		echo 0;
		}
	}
	else{
		echo 0;
		}
	//echo json_encode( $result = array('aaData'=>$result ) );	 	
	$db->sqlClose();
?>
