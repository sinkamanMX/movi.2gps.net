<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	

	$userID   	      = $userAdmin->user_info['COD_USER'];	
	$idCompany    = $userAdmin->user_info['COD_CLIENT'];


	 $arrays=$_GET['q'];
	
	$manejar=explode(',',$arrays);
	
	$nombre=$manejar[0];
	$numst=0;//$Positions-> prob_nom($idCompany ,$nombre);	
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
	$num_correo=count(explode(',',$correo));
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
		$lasq4="SELECT MAX(COD_EVENT) AS MAXIMO FROM SAVL1260";
							$queryQ  = $db->sqlQuery($lasq4);
							$count3     = $db->sqlEnumRows($queryQ);
							$rowU = $db->sqlFetchArray($queryQ);
							$new_idvent=$rowU ['MAXIMO']+1;
							
		$unidades= explode('|',$manejar[6]);
		$unidades_name=explode('|',$manejar[8]);
		
	 $lasq="INSERT ALERT_MASTER VALUE (0,
	 UPPER('".$nombre."'),
	 ".$idCompany.",
	 ".$userID.",
	  ".$new_idvent.",
	 ".$lun.",
	 ".$mar.",
	 ".$mier.",
	 ".$jue.",
	 ".$vier.",
	 ".$sab.",
	 ".$dom.",
	 '".$horini."',
	 '".$horfin."',
	 '".$correo."',
	 ".$active.",
	 0,
	 0,
	 CURRENT_TIMESTAMP,
	 '".$cad_vari."',
	 0,
	 '',
	 0,
	 '".$tipo_geo."',
	 0,
	 0,
	 '',
	 0,
	 '',
	 ".$num_correo.",
	 0)";
	$prim=$Positions-> nue_gd_vari($lasq);
	//echo $prim;
		if($prim==1){
			
			$lasq2="SELECT COD_ALERT_MASTER FROM ALERT_MASTER WHERE NAME_ALERT='".$nombre."'";
			$cod_alert_mas=$Positions-> nue_gd_max($lasq2);
			
			if($cod_alert_mas!=0){
						
					
											$lasq5="INSERT INTO SAVL1260 (COD_EVENT, DESCRIPTION, PRIORITY, FLAG_VISIBLE_CONSOLE, COD_COLOR,KM,FLAG_EVENT_ALERT) 
							VALUES (".$new_idvent.",'".$nombre."',0,1,3,0,1)";
							//$query5  = $db->sqlQuery($lasq5);
							//$count4     = $db->sqlEnumRows($query5);
							$prueba=$Positions-> nue_prue_ser($lasq5);
							
								$lasq6="UPDATE SAVL1480 SET LAST_VALUE = ".$new_idvent." WHERE COD_TABLE = 1260";
							$query6  = $db->sqlQuery($lasq6);
							$count5     = $db->sqlEnumRows($query6);

				for($x=0;$x<count($unidades);$x++){
		
						 $lasq3="INSERT INTO ALERT_DETAIL_VARIABLES (COD_ALERT_ENTITY,COD_ALERT_MASTER, COD_FLEET, COD_ENTITY,".$listado.",uni_descrip_gral) VALUE(0,".$cod_alert_mas.",0,".$unidades[$x].",".$conun_lis.",'".$unidades_name[$x]."');";
						$second=$Positions-> nue_gd_details($lasq3);
						if($second==1){

							if($prueba==1){
							 $resu=1;
							}else{
							$resu=0;
							}
						
						
							
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