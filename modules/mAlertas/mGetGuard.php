<?php



    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	

	$userID   	      =  $userAdmin->user_info['ID_USUARIO'];	
	$idCompany    = $userAdmin->user_info['ID_CLIENTE'];


	 $arrays=$_GET['q'];
	
	$manejar=explode(',',$arrays);
	
	$nombre=$manejar[0];
	$numst=0;//$Positions-> prob_nom($userID  ,$nombre);	
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

		$lasq4="SELECT MAX(COD_EVENT) AS MAXIMO FROM ADM_EVENTOS";
							$queryQ  = $db->sqlQuery($lasq4);
							
								$rowU = $db->sqlFetchArray($queryQ);
								$qurt=$rowU['MAXIMO'];
			
		$resu=0;
		$cont_ema=explode(',',$correo);
		$unidades= explode('|',$manejar[6]);
		$unidades_name=explode('|',$manejar[8]);
	 $lasq="INSERT ALERT_MASTER VALUE (0,UPPER('".$nombre."'),
	 ".$idCompany.",
	 ".$userID.",
	 0,
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
	 '',
	 '',
	 '',
	 '',
	 ".count($cont_ema).",
	 0)";
	 
	 $prim=$Positions-> nue_gd_vari($lasq);
	
		if($prim==1){
			 $lasq2="SELECT COD_ALERT_MASTER FROM ALERT_MASTER WHERE NAME_ALERT='".$nombre."'";
			$cod_alert_mas=$Positions-> nue_gd_max($lasq2);
			if($cod_alert_mas!=0){


$new_idvent=$qurt+1;
											
											$lasq5="INSERT INTO ADM_EVENTOS (COD_EVENT,ID_CLIENTE, DESCRIPTION, PRIORITY, FLAG_VISIBLE_CONSOLE) 
											VALUES (".$new_idvent.",".$idCompany.",'".$nombre."',0,0)";
											$query5  = $db->sqlQuery($lasq5);
											
				for($x=0;$x<count($unidades);$x++){
		
						$lasq3="INSERT INTO ALERT_DETAIL_VARIABLES (COD_ALERT_ENTITY,COD_ALERT_MASTER, COD_FLEET, COD_ENTITY,".$listado.",uni_descrip_gral) VALUE(0,".$cod_alert_mas.",0,".$unidades[$x].",".$conun_lis.",'".$unidades_name[$x]."');";
						$second=$Positions-> nue_gd_details($lasq3);
						if($second==1){
						
							
								if($qurt!=0){
											
											
											
											
											
											
											if($query5){
											 $resu=1;
											}else{
											$resu=0;
											}

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