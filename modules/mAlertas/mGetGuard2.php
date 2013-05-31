<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	

	$userID   	      =  $userAdmin->user_info['ID_USUARIO'];	
	$idCompany    = $userAdmin->user_info['ID_CLIENTE'];


	 $arrays=$_GET['q'];
	 $exist=$_GET['d'];
	
	$manejar=explode(',',$arrays);
	
	$nombre=$manejar[0];
	$numst=0;
	if($numst==0){
	$active=$manejar[1];
	$semana=explode('|',$manejar[3]);
	$lun=$semana[0];
	$mar=$semana[1];
	$mier=$semana[2];
	$jue=$semana[3];
	$vier=$semana[4];
	$sab=$semana[5];
	$dom=$semana[6];
	
	$correo= str_replace("|",",",$manejar[2]);
	$horini=$manejar[4];
	$horfin=$manejar[5];
	
	
	$nuop=explode('|',$manejar[7]);
	$cad_vari=' ';
	$listado=' ';
	$conun_lis=' ';
	for($i=0;$i<count($nuop);$i++){
	$da=' = ';
	$vark=explode('-',$nuop[$i]);
	if($listado==' '){$listado=$vark[3]; $conun_lis=$vark[1]; }else{$listado=$listado.','.$vark[3];  $conun_lis=$conun_lis.','.$vark[1];  }
	$variable=$vark[3]; 
	
	$vari_conf=$vark[1];
	if($cad_vari==' '){
	$cad_vari=$variable.$da.$vari_conf;
	}else{
	$cad_vari=$cad_vari.' and '.$variable.$da.$vari_conf;
	}
	}
	
	$ti_g=explode('_',$vark[0]);
	$tipo_geo=''; 
	if($ti_g[1]=='1'){
		$tipo_geo='P';
		}
		if($ti_g[1]=='2'){
		$tipo_geo='G';
		}
		if($ti_g[1]=='3'){
		$tipo_geo='U';
		}
		if($ti_g[1]=='4'){
		$tipo_geo='R';
		}

		$resu=0;
		
		$unidades= explode('|',$manejar[6]);
		$unidades_name=explode('|',$manejar[8]);
	  $lasq="UPDATE ALERT_MASTER SET 
	 		NAME_ALERT='".$nombre."',
				HORARIO_FLAG_LUNES=".$lun.",
				HORARIO_FLAG_MARTES=".$mar.",
				HORARIO_FLAG_MIERCOLES=".$mier.",
				HORARIO_FLAG_JUEVES=".$jue.",
				HORARIO_FLAG_VIERNES=".$vier.",
				HORARIO_FLAG_SABADO=".$sab.",
				HORARIO_FLAG_DOMINGO=".$dom.",
				HORARIO_HORA_INICIO='".$horini."',
				HORARIO_HORA_FIN='".$horfin."',
				EMAIL_FROMTO='".$correo."',
				ACTIVE=".$active.",
				FECHA_CREATE= CURRENT_TIMESTAMP,
				ALARM_EXPRESION='".$cad_vari."',
				TYPE_EXPRESION='".$tipo_geo."',
				CORREOS_ASIGNADOS=0
			WHERE
				COD_ALERT_MASTER=".$exist;
		
		$prim=$Positions-> nue_gd_vari($lasq);
		
	//	 echo 'mensaje';
		if($prim==1){
				$quers1="DELETE FROM ALERT_DETAIL_VARIABLES WHERE COD_ALERT_MASTER IN (".$exist.")";
	 			$query_units1=$Positions->elim_alertas($quers1);
			
			if($query_units1==1){

				for($x=0;$x<count($unidades);$x++){
		
						$lasq3="INSERT INTO ALERT_DETAIL_VARIABLES (COD_ALERT_ENTITY,COD_ALERT_MASTER, COD_FLEET, COD_ENTITY,".$listado.",uni_descrip_gral) VALUE(0,".$exist.",0,".$unidades[$x].",".$conun_lis.",'".$unidades_name[$x]."');";
						$second=$Positions-> nue_gd_details($lasq3);
						if($second==1){
							 $resu=1;
							}else{
								$resu=0; 
								}
					}
					}else{
					$resu=0;
					}
				
		}else{
			$resu=0;
			}
			}else{
			$resu=0;
			}
		if($resu==1){
				 echo "1";
				}else{
					 echo "0";
					}

?>