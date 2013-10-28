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
	

	$db ->sqlQuery("SET NAMES 'utf8'");


	$tpl->set_filenames(array('mPregrespE'=>'tPregrespE'));	

	$sql = "SELECT P.ID_PREGUNTA, P.DESCRIPCION AS PREGUNTA,
	PR.RESPUESTA AS RESPUESTA
	FROM CRM2_PREGUNTAS P 
	INNER JOIN CRM2_TIPO_PREG TP ON P.ID_TIPO = TP.ID_TIPO
	INNER JOIN CRM2_PREG_RES  PR ON PR.ID_PREGUNTA=P.ID_PREGUNTA
	INNER JOIN CRM2_CUESTIONARIO_PREGUNTAS CP ON P.ID_PREGUNTA = CP.ID_PREGUNTA
	WHERE PR.ID_RES_CUESTIONARIO = ".$_GET['idq']."
	AND TP.MULTIMEDIA = 0 AND TP.P_PANTALLA = 1
	GROUP BY P.ID_PREGUNTA
	ORDER BY CP.ORDEN;";
	

	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	
	if($cnt > 0){ 
		while($row = $db->sqlFetchArray($qry)){
			$pr = '<div><label>'.$row['PREGUNTA'].': </label><input type="text" title="'.$row['PREGUNTA'].'" name="'.$row['ID_PREGUNTA'].'"  id="'.$row['ID_PREGUNTA'].'" value="'.$row['RESPUESTA'].'" class="pr caja_txt"></div>'; 
			$tpl->assign_block_vars('R',array(
				'PR'      	=> $pr
			));	
			
			}
	}	
	
	$sqli = "SELECT 	CONCAT('<img src=\"',PR.RESPUESTA,'\" style=\"height:100%; width:100%;\">') AS RESPUESTA
	FROM CRM2_PREGUNTAS P 
	INNER JOIN CRM2_TIPO_PREG TP ON P.ID_TIPO = TP.ID_TIPO
	INNER JOIN CRM2_PREG_RES  PR ON PR.ID_PREGUNTA=P.ID_PREGUNTA
	INNER JOIN CRM2_CUESTIONARIO_PREGUNTAS CP ON P.ID_PREGUNTA = CP.ID_PREGUNTA
	WHERE PR.ID_RES_CUESTIONARIO = ".$_GET['idq']."
	AND TP.MULTIMEDIA = 1
	GROUP BY P.ID_PREGUNTA
	ORDER BY CP.ORDEN;";
	
	$qryi = $db->sqlQuery($sqli);
	$cnti = $db->sqlEnumRows($qryi);
	
	if($cnti > 0){ 
		while($rowi = $db->sqlFetchArray($qryi)){
			
			$tpl->assign_block_vars('I',array(
				'IMG'      	=> $rowi['RESPUESTA']
			));	
			
			}
	}	
	else{
		$img = '<img src="public/images/Sin_imagen_disponible.jpg" style=" height:100%; width:100%;">';
		$tpl->assign_block_vars('I',array(
				'IMG'      	=> $img
			));
		} 
	
	$db->sqlClose();
	$tpl->pparse('mPregrespE');


	

	

?>
