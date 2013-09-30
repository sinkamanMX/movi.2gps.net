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
	$db ->sqlQuery("SET NAMES 'utf8'");
	
	$tpl->set_filenames(array(
		'mPayload'=>'tPayload'
	));
	$scrp = '<script>

		$( ".down" ).button({
      icons: {
        primary: "ui-icon-circle-arrow-s"
      },
      text: false
    });

	</script>
		';
	$html = "";
	$sql  = "SELECT CP.ID_CUESTIONARIO, C.DESCRIPCION AS Q,P.ID_PREGUNTA AS IDP,P.DESCRIPCION AS PRE FROM CRM2_PREGUNTAS P
	INNER JOIN CRM2_CUESTIONARIO_PREGUNTAS CP ON CP.ID_PREGUNTA = P.ID_PREGUNTA
	INNER JOIN CRM2_CUESTIONARIOS C ON C.ID_CUESTIONARIO = CP.ID_CUESTIONARIO
	INNER JOIN CRM2_TIPO_PREG TP ON TP.ID_TIPO = P.ID_TIPO
	WHERE CP.ID_CUESTIONARIO IN (".$_GET['lay'].") AND TP.MULTIMEDIA=0 AND TP.PAYLOAD=1 ORDER BY CP.ID_CUESTIONARIO,CP.ORDEN;";
										
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	
	if($cnt > 0){
		$c  = 0;
		$pp = 0;
		$id = "";
		$tx = "";
		while($row = $db->sqlFetchArray($qry)){
			//$tx .= ($tx == "")?$row['Q']:",".$row['Q'];
		if($c == 0){
			$tx .= ($tx == "")?$row['Q']:"|".$row['Q'];
			$id = $row['ID_CUESTIONARIO'];
			$html .= '<h3 style="height:30px;">&nbsp;&nbsp;&nbsp;'.$row['Q'].'<input style="float: right;" type="image" src="public/images/qricon.png" width="25px" height="25px" onclick="payload('.$row['ID_CUESTIONARIO'].')"></h3>';
			$html .= '<div id="'.$row['ID_CUESTIONARIO'].'">';
			$html .= '<table width="100%" id="t'.$row['ID_CUESTIONARIO'].'">';
			
			$val = ($_GET['op']==2)?get_value($_GET['idg'],$id):"";
			$a = explode("|",$val);
			$b = explode("¬",$a[$pp]);
			
			
			$html .= '<tr><td><label>'.$row['PRE'].':</label></td><td><input type="text" class="caja" id="'.$row['IDP'].'" value="'.$b[1].'" /></td></tr>';
			$pp++;
			}
		else{
			
			if($id == $row['ID_CUESTIONARIO']){
				$val = ($_GET['op']==2)?get_value($_GET['idg'],$id):"";
				$a = explode("|",$val);
				$b = explode("¬",$a[$pp]);
				
				$html .= '<tr><td><label>'.$row['PRE'].':</label></td><td><input type="text" class="caja" id="'.$row['IDP'].'" value="'.$b[1].'" /></td></tr>';
				$pp++;
				}
			else{
				$pp = 0;
				$tx .= ($tx == "")?$row['Q']:"|".$row['Q'];
				$id = $row['ID_CUESTIONARIO'];
				$html .= '</table>';
				$html .= "</div>";
				$html .= '<h3 style="height:30px;">&nbsp;&nbsp;&nbsp;'.$row['Q'].'<input style="float: right;" type="image" src="public/images/qricon.png" width="25px" height="25px" onclick="payload('.$row['ID_CUESTIONARIO'].')"></h3>';
				$html .= '<div id="'.$row['ID_CUESTIONARIO'].'">';
				$html .= '<table width="100%" id="t'.$row['ID_CUESTIONARIO'].'">';
				$val = ($_GET['op']==2)?get_value($_GET['idg'],$id):""; 
				$a = explode("|",$val);
				$b = explode("¬",$a[$pp]);
				
				$html .= '<tr><td><label>'.$row['PRE'].':</label></td><td><input type="text" class="caja" id="'.$row['IDP'].'" value="'.$b[1].'" /></td></tr>';
				$pp++;
				}	
			}		
		$c++;
		}
	$tpl->assign_vars(array(
		'HTML'	=>	$html,
		'QTXT'	=>	$tx,
		'SCRP'	=>  $scrp
		));	
	$tpl->pparse('mPayload');	
	}
	else{
		echo 0;
		}

function get_value($pdi,$idc){
	global $db;
	 $sql  = "SELECT CADENA_PAYLOAD FROM ADM_GEO_PAYLOAD WHERE ID_OBJECT_MAP = ".$pdi." AND ID_CUESTIONARIO = ".$idc;
	//echo "\n";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	
	if($cnt > 0){
		$row = $db->sqlFetchArray($qry);
		return $row['CADENA_PAYLOAD'];
		}
	else{
		return "";
		}	
	}
	
	
	
	

?>
