<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	

	$userID   	      =  $userAdmin->user_info['ID_USUARIO'];	
	$idCompany    = $userAdmin->user_info['ID_CLIENTE'];
    
	  
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
			AND COD_USER_CREATE=".$userID."
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
							COD_ALERT_MASTER=".$mindata[0]." ORDER BY uni_descrip_gral";;
							  $row2 = $Positions-> trae_unidades_here($quers2);
							$rompe=explode('!',$row2);
							if($cadena_final==' '){
							$todo=$Functions->codif( $mindata[1]);
								$cadena_final=$mindata[0].','.$todo.','.$mindata[6].','.$correo.','.$mindata[2].','.$mindata[3].','.$mindata[4].','.$rompe[0].','.$mindata[8].','.$rompe[1].','.$mindata[9].','.$mindata[7];
								}else{
								$cadena_final=$cadena_final.'!'.$mindata[0].','.$todo.','.$mindata[6].','.$correo.','.$mindata[2].','.$mindata[3].','.$mindata[4].','.$rompe[0].','.$mindata[8].','.$rompe[1].','.$mindata[9].','.$mindata[7];
								}		
				}
	
		echo $cadena_final;
}else{
echo 0;
}

?>