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
	$sqlx = "SELECT P.ID_PREGUNTA, P.DESCRIPCION,TP.TIPO,IF(P.ACTIVO=1,'SI','NO') AS ACTIVO,P.COMPLEMENTO FROM CRM2_PREGUNTAS P
	INNER JOIN CRM2_TIPO_PREG TP ON TP.ID_TIPO = P.ID_TIPO
	WHERE P.COD_CLIENT =".$client." ORDER BY P.DESCRIPCION";
					
						
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
