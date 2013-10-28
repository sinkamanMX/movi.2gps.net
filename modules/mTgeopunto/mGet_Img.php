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
	//$sqlx = "SELECT ID_IMG, CONCAT('<img src=\"public/iconos/',URL,'\" alt=\"',DESCRIPCION,'\" title=\"',DESCRIPCION,'\" height=\"32\" width=\"32\" />') AS IMG, IS_DEFAULT FROM ADM_IMAGE WHERE TIPO = 'TG' AND ID_CLIENTE=1 ORDER BY IS_DEFAULT,DESCRIPCION;";
	$sqlx = "SELECT ID_IMG, CONCAT('<img src=\"public/images/',URL,'\" alt=\"',DESCRIPCION,'\" title=\"',DESCRIPCION,'\" height=\"32\" width=\"32\" />') AS IMG, IS_DEFAULT FROM ADM_IMAGE WHERE TIPO = 'TG' AND ID_CLIENTE= ".$client." ORDER BY IS_DEFAULT,DESCRIPCION;";
					
						
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
