<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$r=0;	
	$arreglo = array();
	$data="";
	$sql = "SELECT 
	R.ID_RES_CUESTIONARIO AS IDRC,
	R.FECHA,
	P.DESCRIPCION AS PREGUNTA,
	PR.RESPUESTA 
	FROM CRM2_PREG_RES PR 
	INNER JOIN CRM2_PREGUNTAS P ON P.ID_PREGUNTA=PR.ID_PREGUNTA 
	INNER JOIN CRM2_RESPUESTAS R ON R.ID_RES_CUESTIONARIO=PR.ID_RES_CUESTIONARIO  
	WHERE  R.ID_CUESTIONARIO=174 
	AND R.FECHA BETWEEN '".$_GET['st_dt']."' AND '".$_GET['nd_dt']."'  ORDER BY R.FECHA,R.ID_RES_CUESTIONARIO;";
	$qry = $db->sqlquery($sql);
	$cnt = $db->sqlEnumRows($qry);
	if($cnt > 0){
		while($row = $db->sqlFetchArray($qry)){
			if($r==0){
				$arreglo[$r][0] = $row['IDRC'];
				$arreglo[$r][1] = $row['FECHA'];
				$arreglo[$r][2] = $row['PREGUNTA'].": ".$row['RESPUESTA']."<br> ";
				}
			
				//echo  $arreglo[$r][0]."==".$row['IDRC']."<br>";
			if($arreglo[$r][0]==$row['IDRC'] && $r > 0){
				$arreglo[$r][2].= "<strong>".$row['PREGUNTA']."</strong>: ".$row['RESPUESTA']."<br> ";
				}
			else{
				$r++;
				$arreglo[$r][0] = $row['IDRC'];
				$arreglo[$r][1] = $row['FECHA'];
				$arreglo[$r][2] = "<strong>".$row['PREGUNTA']."</strong>: ".$row['RESPUESTA']."<br> ";
				}
			
		}
		for($i=1; $i<count($arreglo); $i++){
			$data .= ($data!="") ? ', ': '';
			$data .= '{"IDRC"  : "'.$arreglo[$i][0]		   .'" , '.
					 ' "FECHA" : "'.$arreglo[$i][1].'" , '.
				  	 ' "DATOS" : "'.$arreglo[$i][2].'" }';
					 }
		$tpl->set_filenames(array('mRespuesta' => 'tRespuesta'));
			$tpl->assign_vars(array(
					'DATA' => $data
					));	
		$tpl->pparse('mRespuesta');	
	}
	else{
		echo 0;
		}	
?>	