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
	
	$iWeekNum = Date('W') - 1;
	$iYear = date("Y");
	$sStartTS = $Positions->WeekToDate($iWeekNum, $iYear);
	$sStartDate = date ("Y-m-d", $sStartTS);
	$sEndDate   = date ("Y-m-d", $sStartTS + (6*24*60*60));		
	$rtime = " AND CAST(R.FECHA AS DATE) BETWEEN '".$sStartDate."' AND '".$sEndDate."'";
	
	$result = '';
	$sql="SELECT
	C.ID_CUESTIONARIO, 
	C.DESCRIPCION,
	(SELECT COUNT(R.ID_CUESTIONARIO) FROM CRM2_RESPUESTAS R WHERE R.ID_CUESTIONARIO=C.ID_CUESTIONARIO ".$rtime.") AS RESP 
	FROM CRM2_CUESTIONARIOS C
	WHERE C.COD_CLIENT = ".$client." ORDER BY RESP DESC, C.DESCRIPCION ASC;";
		$query 	= $db->sqlQuery($sql);
		while($row = $db->sqlFetchArray($query)){
			$result[] = $row; // Inside while loop
		}			
	echo json_encode( $result = array('aaData'=>$result ) );	 	
	$db->sqlClose();
?>


