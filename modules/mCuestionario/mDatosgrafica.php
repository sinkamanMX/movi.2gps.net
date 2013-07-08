<?php
 
   function WeekToDate($week, $year){
  	$Jan1 = mktime (1, 1, 1, 1, 1, $year);
	$iYearFirstWeekNum = (int) strftime("%W",mktime (1, 1, 1, 1, 1, $year));
	if ($iYearFirstWeekNum == 1){
		$week = $week - 1;
	}

	$weekdayJan1 = date ('w', $Jan1);
	$FirstMonday = strtotime(((4-$weekdayJan1)%7-3) . ' days', $Jan1);
	$CurrentMondayTS = strtotime(($week) . ' weeks', $FirstMonday);
	return ($CurrentMondayTS);
  }

		$categoria = array('Fecha');
		$categoria[] = 'Respuestas';
		$valores   = array();
		$iWeekNum = Date('W') - 1;
		$iYear = date("Y");
		$sStartTS = WeekToDate($iWeekNum, $iYear);
		$sStartDate = date ("Y-m-d", $sStartTS);
		$sEndDate   = date ("Y-m-d", $sStartTS + (6*24*60*60));		
		$rtime = " AND CAST(R.FECHA AS DATE) BETWEEN '".$sStartDate."' AND '".$sEndDate."'";
		$dates = $sStartDate." - ".$sEndDate;
		//$datos = "";
		
		$conexion = mysqli_connect($_POST['dbh'],$_POST['dbuser'],$_POST['dbpass'],$_POST['dbname']);	
		if($conexion){
			$sql = "SELECT CAST(R.FECHA AS DATE) AS F,DAYOFWEEK(CAST(R.FECHA AS DATE)) AS D, COUNT(R.ID_CUESTIONARIO) AS N FROM
			 CRM2_RESPUESTAS R WHERE R.ID_CUESTIONARIO=".$_POST['id_qst']." ".$rtime."  GROUP BY  F;";
			$query = mysqli_query($conexion, $sql);	
	
			$count = @mysqli_num_rows($query);
			if($count > 0){
				while($row= @mysqli_fetch_array($query)){
					//$datos = ($datos=="")?$row['F']."|".$row['D']."|".$row['N']:$datos.",".$row['F']."|".$row['D']."|".$row['N'];
					//$categoria[]=$row['F'];
					$valores[]=$row['F'];
					$valores[]=(int)$row['N'];
					}
					echo json_encode( array($categoria,$valores) );
				}
			}
?>