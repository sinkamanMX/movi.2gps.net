<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	

	$idc   = $userAdmin->user_info['COD_CLIENT'];	
    
	   

  
	  


	$T='';
	

	//-----------------------------------------------------------------------------UNIDADES EN DESPACHADOR
	
	$data_arr 	='';
		$data_arr1='';
	$units_data 	= array();
	$counta		= 0;
	$counta1		= 0;
	
	
	$row1 = $Positions-> obtener_list_alert();
	
	$count1= count($row1);
			if($count1>0){
				for($i=0;$i<$count1;$i++){
						
						if($data_arr1==''){
								$data_arr1=$row1[$i][0].'{'.$row1[$i][1] ;
						}else{
								$data_arr1=$data_arr1.'|'.$row1[$i][0].'{'.$row1[$i][1];
						}
				
				
						}
						
					
			}

	
			
			$row = $Positions-> obtener_alert_exp();
	$count = count($row);
			if($count>0){
				for($x=0;$x<$count;$x++){
						
						if($data_arr==''){
								$data_arr=$row[$x][0].'{'.$row[$x][1] .'{'.$row[$x][2].'{'.$row[$x][3].'{'.$row[$x][8].'{'. $userAdmin->codif($row[$x][4]).'{'.$row[$x][5].'{'.$row[$x][6].'{'.$row[$x][7].'{'.$row[$x][9].'{'.$row[$x][10].'{'.$row[$x][11];
						}else{
								$data_arr=$data_arr.'|'.$row[$x][0].'{'.$row[$x][1] .'{'.$row[$x][2].'{'.$row[$x][3].'{'. $row[$x][8].'{'.$userAdmin->codif($row[$x][4]).'{'.$row[$x][5].'{'.$row[$x][6].'{'.$row[$x][7].'{'.$row[$x][9].'{'.$row[$x][10].'{'.$row[$x][11];
						}
				
				
						}
						
					
			}
				echo $data_arr1.'!'.$data_arr;
?>