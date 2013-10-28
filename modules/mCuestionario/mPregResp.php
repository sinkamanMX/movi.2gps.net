<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo silver 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          23-04-2012
**/
header("Content-Type: text/html;charset=utf-8");


 
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
			echo '<script>window.location="index.php?m=login"</script>';
			
	$db ->sqlQuery("SET NAMES 'utf8'");			
	$client   = $userAdmin->user_info['ID_CLIENTE'];
	

	
	
	$result = '';

	$sql="SELECT P.DESCRIPCION AS PREGUNTA,
	IF(TP.MULTIMEDIA=0,PR.RESPUESTA,CONCAT('<img src=\"',PR.RESPUESTA,'\" style=\"width:100px; height:100px;\" onclick=\"qst_ver_img(\'',PR.RESPUESTA,'\',this.id)\" id=\"',".$_GET['idrc'].",'
	\">')) AS RESPUESTA
	FROM CRM2_PREGUNTAS P 
	INNER JOIN CRM2_TIPO_PREG TP ON P.ID_TIPO = TP.ID_TIPO
	INNER JOIN CRM2_PREG_RES  PR ON PR.ID_PREGUNTA=P.ID_PREGUNTA
	INNER JOIN CRM2_CUESTIONARIO_PREGUNTAS CP ON P.ID_PREGUNTA = CP.ID_PREGUNTA
	WHERE PR.ID_RES_CUESTIONARIO = ".$_GET['idrc']."
	GROUP BY P.ID_PREGUNTA
	ORDER BY CP.ORDEN";
		$query 	= $db->sqlQuery($sql);
		while($row = $db->sqlFetchArray($query)){
			$result[] = $row; // Inside while loop
		}			
	echo json_encode( $result = array('aaData'=>$result ) );	 	
	$db->sqlClose();
	
?>


