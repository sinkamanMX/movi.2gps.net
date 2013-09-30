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
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';  //Manda al login si no se ha Logeo.
	//--------------------------- Modificada BD y Encabezado------------------------
	$cod_client =  $userAdmin->user_info['COD_CLIENT'];

	$result = array();
	
	$sql  = "SELECT P.DESCRIPCION AS PREGUNTA,
	IF(TP.MULTIMEDIA=0,PR.RESPUESTA,CONCAT('<img src=\"',PR.RESPUESTA,'\" style=\"width:100px; height:100px;\" onclick=\"rev_ver_img(\'',PR.RESPUESTA,'\',this.id)\" id=\"', REPLACE(REPLACE(SUBSTRING(PR.RESPUESTA,19),\".\",\"\"),\" \",\"\"),'
	\">')) AS RESPUESTA
	FROM CRM2_PREGUNTAS P 
	INNER JOIN CRM2_TIPO_PREG TP ON P.ID_TIPO = TP.ID_TIPO
	INNER JOIN CRM2_PREG_RES  PR ON PR.ID_PREGUNTA=P.ID_PREGUNTA
	INNER JOIN CRM2_CUESTIONARIO_PREGUNTAS CP ON P.ID_PREGUNTA = CP.ID_PREGUNTA
	WHERE PR.ID_RES_CUESTIONARIO = ".$_GET['id']."
	GROUP BY P.ID_PREGUNTA
	ORDER BY CP.ORDEN;";
					
						
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	
	if($cnt > 0){ 
		while($row = $db->sqlFetchArray($qry)){
			$result[] = $dbf->utf8_encode_array($row); // Inside while loop
			}
	}
	echo json_encode( $result = array('aaData'=>$result ) );	 	
	$db->sqlClose();


	

	

?>
