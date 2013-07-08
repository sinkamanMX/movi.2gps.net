<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo silver 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          23-04-2012
**/
 
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
			echo '<script>window.location="index.php?m=login"</script>';
	$client   = $userAdmin->user_info['ID_CLIENTE'];
	
	/*$iWeekNum = Date('W') - 1;
	$iYear = date("Y");
	$sStartTS = $Positions->WeekToDate($iWeekNum, $iYear);
	$sStartDate = date ("Y-m-d", $sStartTS);
	$sEndDate   = date ("Y-m-d", $sStartTS + (6*24*60*60));		
	$rtime = " AND CAST(R.FECHA AS DATE) BETWEEN '".$sStartDate."' AND '".$sEndDate."'";*/
	
	$rtime = " AND R.FECHA BETWEEN '".$_GET['st_dt']."' AND '".$_GET['nd_dt']."' ";
	
	//$result = '';
	$arreglo = array();
	$c=0;
	$sql="SELECT
	R.ID_RES_CUESTIONARIO AS IDRC,
	R.FECHA, 
	U.NOMBRE_COMPLETO AS USR, 
	R.LATITUD, 
	R.LONGITUD 
	FROM CRM2_RESPUESTAS R
	INNER JOIN ADM_USUARIOS U ON U.ID_USUARIO = R.COD_USER
	WHERE R.ID_CUESTIONARIO= ".$_GET['qst']."
	".$rtime."  ORDER BY R.FECHA,R.ID_RES_CUESTIONARIO;";
		$query 	= $db->sqlQuery($sql);
		while($row = $db->sqlFetchArray($query)){
			$arreglo[$c][0] = $row['IDRC'] ;
			$arreglo[$c][1] = $row['FECHA'] ;
			$arreglo[$c][2] = $row['USR'];
			$arreglo[$c][3] = $row['LATITUD'];
			$arreglo[$c][4] = $row['LONGITUD'];
			$arreglo[$c][5] = $Positions->direccion_no_format($row['LATITUD'],$row['LONGITUD']);
			$c++;
		}			
		for($i=1; $i<count($arreglo); $i++){
			$data .= ($data!="") ? ', ': '';
			$data .= '{"IDRC"  : "'.$arreglo[$i][0].'" , '.
					 ' "FECHA" : "'.$arreglo[$i][1].'" , '.
					 ' "USR"   : "'.$arreglo[$i][2].'" , '.
					 ' "LATIT" : "'.$arreglo[$i][3].'" , '.
					 ' "LONGI" : "'.$arreglo[$i][4].'" , '.
				  	 ' "DIREC" : "'.$arreglo[$i][5].'" }';
			}
			$tpl->set_filenames(array('mFechas' => 'tFechas'));
			$tpl->assign_vars(array(
					'DATA' => $data
					));	
		$tpl->pparse('mFechas');
	//echo json_encode( $result = array('aaData'=>$result ) );	 	
	$db->sqlClose();
?>


