<?php
/** * 
 *  @package             
 *  @name                Obtiene el reporte historico de una unidad 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @modificado          08-08-2013
**/
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}

$aRespuesta = '';

if(isset($_GET['idUnit']) && isset($_GET['idGroup']) && isset($_GET['fBegin']) && isset($_GET['fEnd'])){
	$idUnit	= $_GET['idUnit'];
	$idGroup= $_GET['idGroup'];
	$fBegin	= $_GET['fBegin'].":00";
	$fEnd 	= $_GET['fEnd'].":00";
	$idClient= $userAdmin->user_info['ID_CLIENTE'];
	
   
   	$rhistorico = new cHistorico();
	$rhistorico->setClient($idClient);
	$rhistorico->setUnit($idUnit); 
	
	$sqlOptions = "AND e.GPS_DATETIME BETWEEN '".$fBegin."' AND '".$fEnd."'";
	
	$rReporte = $rhistorico->hist_geo($sqlOptions);
		//$resumen = $rhistorico->getResumen();
		if(count($rReporte)>0){
			$sResumen	= '';
			$sEventos	= '';
			$sHistorico	= '';
			//$aesumen    = $rhistorico->aResumen['resumen'];
			echo count($rReporte).'||'.$idUnit.'||'.$idGroup.'||'.$fBegin.'||'.$fEnd.'||';			
			//Se Crea la cadena a enviar
			//Resumen General
			/*$aesumen    = $rhistorico->aResumen['resumen'];
			$aeventos   = $rhistorico->aResumen['eventos'];
			
			$sResumen = round($aesumen['recorrido'], 2)."!".round($aesumen['maxima'], 2)."!".
					    round($aesumen['promedio'], 2)."!".$aesumen['tiempoMovimiento']."!".
						$aesumen['tiempoDetenido']."!".$aesumen['tiempoRalenti']."!".$aesumen['unit'];
			 
		 	foreach($aeventos as $eventos){
		 		$sEventos .= ($sEventos != "") ? "!" : ""; 
				$sEventos .= $eventos['idEvent']."#".$eventos['name']."#".$eventos['total'];  	
			}
			
			foreach($rhistorico->aHistorico as $reporte){
				$sHistorico .= ($sHistorico != "") ? "!" : ""; 
				$sHistorico .= $reporte['COD_EVENT']."#".$reporte['DESCRIPTION']."#".$reporte['GPS_DATETIME']."#".
					$reporte['DESC_EVT']."#".$reporte['VELOCIDAD']."#".$reporte['LATITUDE']."#".
					$reporte['LONGITUDE']."#".$reporte['PRIORITY']."#".$reporte['ESTATUS']."#".
					$reporte['PLAQUE']."#".$reporte['direccion'];
			}
			
			//echo $aRespuesta = $sResumen."||".$sEventos."||".$sHistorico;
			echo $sResumen."||".$sHistorico."||".$sEventos;*/
		}else{
			echo "No||está";
			//echo $rhistorico->getErrorMessage();	
		}
	
	//echo $idUnit.'||'.$idGroup.'||'.$fBegin.'||'.$fEnd;
}else{
	echo "No||está";
}

