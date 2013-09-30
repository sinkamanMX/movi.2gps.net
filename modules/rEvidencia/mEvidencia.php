<?php
/** * 
 *  @package             movi.2gps.net
 *  @name                Obtiene la evidencia de un geopunto.
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          05/08/2013
**/

	//--------------------------- Modificada BD y Encabezado------------------------
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';  //Manda al login si no se ha Logeo.
	//--------------------------- Modificada BD y Encabezado------------------------
	$cod_client =  $userAdmin->user_info['COD_CLIENT'];

	$result = array();
	
	$sql = "SELECT R.ID_RES_CUESTIONARIO,Q.DESCRIPCION AS QST,U.NOMBRE_COMPLETO,R.LATITUD,R.LONGITUD, 
	R.FECHA_INICIO_CAPTURA AS FIC, R.FECHA AS FFC, R.FECHA_RECEPCION AS FR, TIMEDIFF(R.FECHA,R.FECHA_INICIO_CAPTURA) AS TC,
	TIMEDIFF(R.FECHA,R.FECHA_RECEPCION) AS TE
	FROM CRM2_RESPUESTAS R
	INNER JOIN CRM2_CUESTIONARIOS Q ON Q.ID_CUESTIONARIO = R.ID_CUESTIONARIO
	INNER JOIN ADM_USUARIOS U ON U.ID_USUARIO = R.COD_USER
	WHERE U.ID_USUARIO IN(".$_GET['usr'].") 
	AND R.FECHA BETWEEN '".$_GET['dti']."' AND '".$_GET['dtf']."' ORDER BY R.FECHA";
	

					
						
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	
	if($cnt > 0){ 
		while($row = $db->sqlFetchArray($qry)){
			$result[] = $row; // Inside while loop
			}
	}
	echo json_encode( $result = array('aaData'=>$result ) );	 	
	$db->sqlClose();


	

	

?>
