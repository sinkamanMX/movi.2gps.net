<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
		
	$idc   = $userAdmin->user_info['COD_CLIENT'];
	
	$sql = "SELECT C.ID_CUESTIONARIO AS ID, C.DESCRIPCION AS CUE FROM CRM2_CUESTIONARIOS C 
	INNER JOIN CRM2_CUESTIONARIO_PREGUNTAS CP ON CP.ID_CUESTIONARIO=C.ID_CUESTIONARIO
	INNER JOIN CRM2_PREGUNTAS P ON P.ID_PREGUNTA = CP.ID_PREGUNTA
	INNER JOIN CRM2_TIPO_PREG TP ON TP.ID_TIPO = P.ID_TIPO
	WHERE C.COD_CLIENT= ".$idc." AND TP.MULTIMEDIA=0 GROUP BY C.ID_CUESTIONARIO;";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	if($cnt>0){
		$tpl->set_filenames(array('mCuestionario' => 'tCuestionario'));
		while($row = $db->sqlFetchArray($qry)){
			 $tpl->assign_block_vars('qst',array(
			 'Q'   => '<label><input type="checkbox" name="qst" value="'.$row['ID'].'" title="'.$row['CUE'].'">'.$row['CUE'].'</label><br>'
			 ));	
		}
		$tpl->pparse('mCuestionario');
		}

	
	

	
	

	
	
	

	
?>	