<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	

	$userID   	      = $userAdmin->user_info['COD_USER'];	
	$idCompany    = 0;
    
	  
$cadena_final=' ';
$quers1="SELECT
							COD_ALERT_MASTER,
							NAME_ALERT,
							HORARIO_FLAG_LUNES,
							HORARIO_FLAG_MARTES,
							HORARIO_FLAG_MIERCOLES,
							HORARIO_FLAG_JUEVES,
							HORARIO_FLAG_VIERNES,
							HORARIO_FLAG_SABADO,
							HORARIO_FLAG_DOMINGO,
							HORARIO_HORA_INICIO,
							HORARIO_HORA_FIN,
							EMAIL_FROMTO,
							ACTIVE,
							FECHA_CREATE,
							ALARM_EXPRESION,
							TYPE_EXPRESION
			FROM ALERT_MASTER
			WHERE
			COD_CLIENT=".$idCompany."
			ORDER BY COD_ALERT_MASTER ";

	
	 $row1 = $Positions-> trae_alertas_here($quers1);
	if($row1!=0){
	$alerta=explode('#',$row1);
	$count1= count($alerta);
	
	for($i=0;$i<$count1;$i++){
				$exp1=' ';
				$expc=' ';
				$mindata=explode('?',$alerta[$i]);
				$correo= str_replace(",","|",$mindata[5]);
			
				$exp=explode("and",$mindata[8]);
				  $num=count($exp);
					for($x=0;$x<$num;$x++){
							
							$exp1=explode("<",$exp[$x]);
							$exp1=explode(">",$exp[$x]);
							$exp1=explode("=",$exp[$x]);
							if($expc==' '){
								$expc=$exp1[0];
							}else{
								$expc=$expc.','.$exp1[0];
							}
						}
			$quers2="SELECT 
								COD_ALERT_MASTER,
								COD_ENTITY,
								uni_descrip_gral
							FROM ALERT_DETAIL_VARIABLES
							WHERE
							COD_ALERT_MASTER=".$mindata[0]." ORDER BY uni_descrip_gral";
							 $row2 = $Positions-> trae_unidades_here($quers2);
							$rompe=explode('!',$row2);
							if($cadena_final==' '){
								$cadena_final=$mindata[0].','.$mindata[1].','.$mindata[6].','.$correo.','.$mindata[2].','.$mindata[3].','.$mindata[4].','.$rompe[0].','.$mindata[8].','.$rompe[1].','.$mindata[9].','.$mindata[7];
								}else{
								$cadena_final=$cadena_final.'!'.$mindata[0].','.$mindata[1].','.$mindata[6].','.$correo.','.$mindata[2].','.$mindata[3].','.$mindata[4].','.$rompe[0].','.$mindata[8].','.$rompe[1].','.$mindata[9].','.$mindata[7];
								}		
				}
	
		echo $cadena_final;
}else{
echo 0;
}
	/*$count1= count($row1);
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
				echo $data_arr1.'!'.$data_arr;*/
?>