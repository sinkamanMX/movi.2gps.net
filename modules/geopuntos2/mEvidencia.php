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
	$db ->sqlQuery("SET NAMES 'utf8'");
	$cod_client =  $userAdmin->user_info['COD_CLIENT'];

	$result = array();
	$sql = "SELECT R.ID_RES_CUESTIONARIO,
       R.FECHA,Q.DESCRIPCION AS QST,U.NOMBRE_COMPLETO,
       R.LATITUD,R.LONGITUD 
FROM  ADM_GEOREFERENCIA_RESPUESTAS GR
      INNER JOIN CRM2_RESPUESTAS R ON R.ID_RES_CUESTIONARIO = GR.ID_RES_CUESTIONARIO
      INNER JOIN CRM2_CUESTIONARIOS Q ON Q.ID_CUESTIONARIO = R.ID_CUESTIONARIO
      INNER JOIN ADM_USUARIOS U ON U.ID_USUARIO = R.COD_USER
WHERE GR.ID_OBJECT_MAP = ".$_GET['id']." AND U.ID_USUARIO IN(".$_GET['usr'].") 
      AND R.FECHA BETWEEN '".$_GET['dti']."' AND '".$_GET['dtf']."'";
	  

	
					
						
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
