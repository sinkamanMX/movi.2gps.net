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
	


	
	$sql  = "SELECT G.LATITUDE, G.LONGITUDE FROM ADM_GEOREFERENCIAS G 
	INNER JOIN ADM_RH_PDI R ON R.ID_OBJECT_MAP = G.ID_OBJECT_MAP
	WHERE R.ID_RH = ".$_GET['idrh']." AND R.ORDEN = 1;";
										
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	
	if($cnt > 0){
		$row = $db->sqlFetchArray($qry);
		echo $latlon = $row['LATITUDE'].",".$row['LONGITUDE'];
		//return($latlon);
	}
	else{
		//return("0,0");
		echo "0,0";
		}
	
	$db->sqlClose();
?>
