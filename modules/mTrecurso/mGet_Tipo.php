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

	$result = array();
	//$sqlx = "SELECT * FROM ADM_GEOREFERENCIAS_TIPO WHERE ID_CLIENTE= ".$client." ORDER BY DESCRIPCION;";
	$sqlx = "SELECT T.ID_TIPO, T.DESCRIPCION, CONCAT('<img src=\"public/images/',I.URL,'\" alt=\"',I.DESCRIPCION,'\" title=\"',I.DESCRIPCION,'\" height=\"32\" width=\"32\" />') AS IMG 
	FROM ADM_RH_TIPO T 
	INNER JOIN ADM_IMAGE I ON I.ID_IMG = T.ID_IMAGE
	WHERE T.ID_CLIENTE = ".$client." ORDER BY T.DESCRIPCION";
					
						
	$queryx= $db->sqlQuery($sqlx);
	$contador= $db->sqlEnumRows($queryx);
	
	if($contador>0){ 
		while($rowx=$db->sqlFetchArray($queryx)){
			$result[] = $rowx; // Inside while loop
			}
	}
	echo json_encode( $result = array('aaData'=>$result ) );	 	
	$db->sqlClose();
?>
