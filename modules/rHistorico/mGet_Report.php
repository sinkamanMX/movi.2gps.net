<?php
/**/
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
//$userData = new usersAdministration();	

if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}
set_time_limit(600000);

$tpl->set_filenames(array('mGet_Report'=>'tGet_Report'));
if(isset($_GET['tag'])){
	if($_GET['tipo'] == '0'){
		$rtime = " AND GPS_DATETIME BETWEEN '".$_GET['fInicio']."' AND '".$_GET['fFin']."'";
	}
	else{
		$iWeekNum = $_GET['semana'];
		$iYear = date("Y");
		$sStartTS = $Positions->WeekToDate($iWeekNum, $iYear);
		$sStartDate = date ("Y-m-d", $sStartTS);
		$sEndDate   = date ("Y-m-d", $sStartTS + (6*24*60*60));		
		$rtime = " AND CAST(GPS_DATETIME AS DATE) BETWEEN '".$sStartDate."' AND '".$sEndDate."'";
	}
	
	//$id_usuario = $userAdmin->user_info['ID_CLIENTE'];
	/** CREAR FILTRO **/
	$filtro=" AND E.VELOCITY BETWEEN 0 AND ".$_GET['vel'];
//	if($_GET['evt'] > 0){
	//	$filtro = " AND f.COD_EVENT = ".$_GET['evt'];
	
//	}
		$cliente = $userAdmin->user_info['ID_CLIENTE'];
		$radio = $_GET['radio'];
		$velocidad = $_GET['vel'];
		//$filtro = " AND e.VELOCITY < 5 ";
//variables
$arreglo = array();
$counter = 0;
$paradastotal=0;
$paradas_aut=0;
$paradas_naut=0;
$tiempototalparadas = new DateTime("00:00:00");
$tiempototalparadas = date_format($tiempototalparadas, 'H:i:s');
$tiempototalparadasa = new DateTime("00:00:00");
$tiempototalparadasa = date_format($tiempototalparadasa, 'H:i:s');
$tiempototalparadasn = new DateTime("00:00:00");
$tiempototalparadasn = date_format($tiempototalparadasn, 'H:i:s');
$tiempomovimiento = new DateTime("00:00:00");
$tiempomovimiento = date_format($tiempomovimiento, 'H:i:s');
$velocidadmaxima=0;
$totalexcesos=0;
$distancia=0;
	
	
	/* LLAMAR FUNCIONES GLOBALES */
	
	$tablaHistorico = $Positions->get_tablename($cliente);
	
	if($tablaHistorico != ""){
		$tablaHistorico="HIST".$tablaHistorico;
		//echo $tablaHistorico;
		$queryNumHistorico = $Positions->get_num_hist26($tablaHistorico, $_GET['unidad'], $rtime, $filtro, $cliente, $radio);
		$count = count($queryNumHistorico);
		//echo "count".$count;
		if($count > 0){
 		   for($c=0;$c<count($queryNumHistorico);$c++){
				$a = ($c+1<count($queryNumHistorico))?$queryNumHistorico[$c+1][0]:$queryNumHistorico[$c][0];
				$b = ($c+1<count($queryNumHistorico))?$queryNumHistorico[$c+1][2]:$queryNumHistorico[$c][2];	   
			   if($queryNumHistorico[$c][0]==$a&& $queryNumHistorico[$c][2]==$b){
				   if($queryNumHistorico[$c][6]<5){
					   //Calcular Parada total paradas autorizadas y paradas no autorizadas
					   $p = ($c+1<count($queryNumHistorico))?$queryNumHistorico[$c+1][8]:$queryNumHistorico[$c][8];
						   if($queryNumHistorico[$c][8]!=$p){
							   $paradastotal++;
							   if($queryNumHistorico[$c][8]==1){
								   //Incremento paradas autorizadas
								  $paradas_aut++;
								  //Calcular tiempo detenido autorizado
								  $b = ($c+1<count($queryNumHistorico))?$queryNumHistorico[$c+1][9]:$queryNumHistorico[$c][9];
								  $sqla = "SELECT ABS(TIMEDIFF('".$queryNumHistorico[$c][9]."','".$b."')) AS T1";
						  		  $qrya = $db->sqlQuery($sqla);
						  		  $rowa = $db->sqlFetchArray($qrya);
								  
						  		  $sqlx = "SELECT ADDTIME('".$tiempototalparadasa."', '".$rowa['T1']."') AS TT";
						  		  $qryx = $db->sqlQuery($sqlx);
						  		  $rowx = $db->sqlFetchArray($qryx);
						  	  	  $tiempototalparadasa = $rowx['TT'];
								  } 
					   		   else{
								   //Incremento paradas no autorizadas
								   $paradas_naut++;
								   //Calcular tiempo detenido no autorizado
								   $b = ($c+1<count($queryNumHistorico))?$queryNumHistorico[$c+1][9]:$queryNumHistorico[$c][9];
								   $sqln = "SELECT ABS(TIMEDIFF('".$queryNumHistorico[$c][9]."','".$b."')) AS T1";
						  		   $qryn = $db->sqlQuery($sqln);
						  		   $rown = $db->sqlFetchArray($qryn);
						  
						  		   $sqly = "SELECT ADDTIME('".$tiempototalparadasn."', '".$rown['T1']."') AS TT";
						  		   $qryy = $db->sqlQuery($sqly);
						  		   $rowy = $db->sqlFetchArray($qryy);
						  		   $tiempototalparadasn = $rowy['TT'];
								   }
							   }
					   }
					   else{
						    //Calcular tiempo en movimiento
							$b = ($c+1<count($queryNumHistorico))?$queryNumHistorico[$c+1][9]:$queryNumHistorico[$c][9];
							$sqln = "SELECT ABS(TIMEDIFF('".$queryNumHistorico[$c][9]."','".$b."')) AS T1";
						  	$qryn = $db->sqlQuery($sqln);
						  	$rown = $db->sqlFetchArray($qryn);
							
							$sqly = "SELECT ADDTIME('".$tiempomovimiento."', '".$rown['T1']."') AS TT";
						  	$qryy = $db->sqlQuery($sqly);
						  	$rowy = $db->sqlFetchArray($qryy);
						  	$tiempomovimiento = $rowy['TT'];
						   }
					   $arreglo[$counter][0]=$queryNumHistorico[$c][0];
					   $arreglo[$counter][1]=$queryNumHistorico[$c][1];
					   $arreglo[$counter][2]=$queryNumHistorico[$c][2];
					   $arreglo[$counter][3]=$paradastotal;
					   $arreglo[$counter][4]=$paradas_aut;
					   $arreglo[$counter][5]=$paradas_naut;
					   $arreglo[$counter][6]=$tiempomovimiento;
					   $arreglo[$counter][7]=$tiempototalparadasa;
					   $arreglo[$counter][8]=$tiempototalparadasn;						   
					   
					
				   //Calcular velocidad maxima
					   $velocidadmaxima = ($queryNumHistorico[$c][6]>$velocidadmaxima)?$queryNumHistorico[$c][6]:$velocidadmaxima;
					   $arreglo[$counter][9]=$velocidadmaxima;					   
				   //Calcular número de excesos de velocidad
				      // $totalexcesos = ($queryNumHistorico[$c][6]>$velocidad)?$totalexcesos++:$totalexcesos;
					   if($queryNumHistorico[$c][6]>$velocidad){
						   $totalexcesos++;
						   }
					   $arreglo[$counter][10]=$totalexcesos;					   
				   //Calcular kilometros recorridos
				   		$distance= ($c+1<count($queryNumHistorico))?
						$Positions->distancia_entre_puntos($queryNumHistorico[$c+1][4],$queryNumHistorico[$c+1][5],$queryNumHistorico[$c][4],$queryNumHistorico[$c][5]):
						$Positions->distancia_entre_puntos($queryNumHistorico[$c][4],$queryNumHistorico[$c][5],$queryNumHistorico[$c][4],$queryNumHistorico[$c][5]);
						$distancia=$distancia+$distance;
						$arreglo[$counter][11]=$distancia;
						
				   
				   }
				   else{
				   //reiniciar variables
				   $paradastotal=0;
				   $paradas_aut=0;
				   $paradas_naut=0;
				   $tiempototalparadas="00:00:00";
				   $tiempototalparadasa="00:00:00";
				   $tiempototalparadasn="00:00:00";
				   $tiempomovimiento="00:00:00";
				   $velocidadmaxima=0;
				   $totalexcesos=0;
				   $distancia=0;			   
				   //incrementar contador   
				   $counter++;				   
					   }
			   
			   //}	
				   }
				   //$data="";
				  //echo "count arreglo".count($arreglo); 
				  $data = array();
				  for($x=0;$x<count($arreglo);$x++){
					  switch ($x){
						  case 0:
						  $fi = $_GET['fInicio'];
						  $ff = $arreglo[$x][0]." 23:59:59";
						  break;
						  case count($arreglo)-1:
						  $fi = $arreglo[$x][0]." 00:00:00";
						  $ff = $_GET['fFin'];
						  break;
						  default:
						  $fi = $arreglo[$x][0]." 00:00:00";
						  $ff = $arreglo[$x][0]." 23:59:59";
						  
						  }
					  $data[]=array(
					 'FI'     => $fi,
					 'FF'     => $ff,
					 'DATE'   => $arreglo[$x][0],
					 'UNIT'	  => $arreglo[$x][1],
					 'ID_U'	  => $arreglo[$x][2],
					 'PART'	  => $arreglo[$x][3],
					 'PARA'	  => $arreglo[$x][4],
					 'PARN'	  => $arreglo[$x][5],
					 'TMOV'	  => $arreglo[$x][6],
					 'TDEA'	  => $arreglo[$x][7],
					 'TDEN'	  => $arreglo[$x][8],
					 'VELM'	  => $arreglo[$x][9],
					 'TEXC'	  => $arreglo[$x][10],
					 'KREC'	  => $arreglo[$x][11]
					  );
					/*$tpl->assign_block_vars('reports',array(
					 'DATE'   => $arreglo[$x][0],
					 'UNIT'	  => $arreglo[$x][1],
					 'PART'	  => $arreglo[$x][3],
					 'PARA'	  => $arreglo[$x][4],
					 'PARN'	  => $arreglo[$x][5],
					 'TMOV'	  => $arreglo[$x][6],
					 'TDEA'	  => $arreglo[$x][7],
					 'TDEN'	  => $arreglo[$x][8],
					 'VELM'	  => $arreglo[$x][9],
					 'TEXC'	  => $arreglo[$x][10],
					 'KREC'	  => $arreglo[$x][11]
					));*/
					/*$result[$x][0] = $arreglo[$x][0];
					$result[$x][1] = $arreglo[$x][1];
					$result[$x][2] = $arreglo[$x][3];
					$result[$x][3] = $arreglo[$x][4];
					$result[$x][4] = $arreglo[$x][5];
					$result[$x][5] = $arreglo[$x][6];
					$result[$x][6] = $arreglo[$x][7];
					$result[$x][7] = $arreglo[$x][8];
					$result[$x][8] = $arreglo[$x][9];
					$result[$x][9] = $arreglo[$x][10];
					$result[$x][10] = $arreglo[$x][11];*/
					
					/*$data = ($data=="")?"
					[
					[
					'".$arreglo[$x][0]."',
					'".$arreglo[$x][1]."',
					'".$arreglo[$x][3]."',
					'".$arreglo[$x][4]."',
					'".$arreglo[$x][5]."',
					'".$arreglo[$x][6]."',
					'".$arreglo[$x][7]."',
					'".$arreglo[$x][8]."',
					'".$arreglo[$x][9]."',
					'".$arreglo[$x][10]."',
					'".$arreglo[$x][11]."'
					]
					":$data."
					,[
					'".$arreglo[$x][0]."',
					'".$arreglo[$x][1]."',
					'".$arreglo[$x][3]."',
					'".$arreglo[$x][4]."',
					'".$arreglo[$x][5]."',
					'".$arreglo[$x][6]."',
					'".$arreglo[$x][7]."',
					'".$arreglo[$x][8]."',
					'".$arreglo[$x][9]."',
					'".$arreglo[$x][10].",'
					'".$arreglo[$x][11]."'					
					]
					";*/
				  }	
				  	//$data['success']  =true;
					echo json_encode($data);
				  //$data = $data."]";
				//$tpl->pparse('mGet_Report');
				//echo json_encode( $result = $result );
				//header("content-type: text/plain");
				//header("Pragma: no-cache");
				//header("Expires: 0");
				//echo($data);
				//echo $data;
		}else{
			echo "0";
			//echo $tablaHistorico.",".$_GET['unidad'].",".$rtime.",".$filtro.",".$cliente.",".$radio;
		}
	}else{
		echo "-1";
	}
}else{
	echo "-2";
}
?>