<?php
/** * 
 *  @package             
 *  @name                Obtiene el reporte historico de una unidad en formato excel 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pena 
 *  @modificado          27-06-2013
**/
ini_set('memory_limit','512M');
set_time_limit(600000);

$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}

if(isset($_GET['idUnit']) && isset($_GET['fBegin']) && isset($_GET['fEnd'])){
	$idUnit	= $_GET['idUnit'];
	$idGroup= $_GET['idGroup'];
	$fBegin	= $_GET['fBegin'].":00";
	$fEnd 	= $_GET['fEnd'].":00";
	$idClient= $userAdmin->user_info['ID_CLIENTE'];
	
	$dataClient = $dbf->getRow('ADM_CLIENTES','ID_CLIENTE='.$idClient);
	$nameClient = $dataClient['NOMBRE']; 
	$dateCreate = date("d-m-Y H:i");
	$createdBy	= $userAdmin->user_info['NOMBRE_COMPLETO'];
	$fechInicio = $_GET['fBegin'];
	$fechaFinal = $_GET['fEnd'];
	
	
	$rhistorico = new cHistorico();
	$rhistorico->setClient($idClient);
	$rhistorico->setUnit($idUnit); 
	
	$sqlOptions = "AND e.GPS_DATETIME BETWEEN '".$fBegin."' AND '".$fEnd."'";
	
	$rReporte = $rhistorico->getHitorico($sqlOptions);
	if($rReporte){
		$resumen = $rhistorico->getResumen();
		if($resumen){
			//Resumen General
			$aesumen    = $rhistorico->aResumen['resumen'];
			$aeventos   = $rhistorico->aResumen['eventos'];
			$descUnit 	= $aesumen['unit'];
				
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("ALG")
									 ->setLastModifiedBy("ALG")
									 ->setTitle("Office 2007 XLSX")
									 ->setSubject("Office 2007 XLSX")
									 ->setDescription("Reporte Historico")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Reporte Historico");
			/**
			 * Estilos 
			 * */	
			 
			$styleHeader = new PHPExcel_Style();
			$stylezebraTable = new PHPExcel_Style();  
			
			$styleHeader->applyFromArray(array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('argb' => '459ce6')
				)
			));
			
			$stylezebraTable->applyFromArray(array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('argb' => 'e7f3fc')
				)
			));	
			
			$zebraTable = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('argb' => 'e7f3fc')
				)
			);	
			
			$objPHPExcel->getActiveSheet()->mergeCells('A1:A3');
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(230);
				
			$gdImage = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . '/public/images/logoReporte.png');
			$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
			$objDrawing->setName('Sample image');
			$objDrawing->setDescription('Logo');
			$objDrawing->setImageResource($gdImage);
			$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
			$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
			$objDrawing->setHeight(76.34);
			$objDrawing->setWidth(78.99);	
			$objDrawing->setOffsetX(50);
			$objDrawing->setOffsetY(0);	
			$objDrawing->setCoordinates('A1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:A3')
					->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A1:A3')
					->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);			
		
		  	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			
			/**
			 * Header del Reporte
			 * */
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', $nameClient);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', 'Reporte Historico ');
			$objPHPExcel->getActiveSheet()->getStyle("B2")->getFont()->setSize(20);
			$objPHPExcel->getActiveSheet()->getStyle("B2")->getFont()->setBold(true);
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B3', 'Reporte Creado '.$dateCreate.' por '.$createdBy);	
			$objPHPExcel->getActiveSheet()->mergeCells('B1:D1');
			$objPHPExcel->getActiveSheet()->getStyle('B1:D1')
					->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->mergeCells('B2:D2');
			$objPHPExcel->getActiveSheet()->getStyle('B2:D2')
					->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$objPHPExcel->getActiveSheet()->mergeCells('B3:D3');	
			$objPHPExcel->getActiveSheet()->getStyle('B3:D3')
					->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', 'Unidad');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B5', $descUnit);
			$objPHPExcel->getActiveSheet()->mergeCells('B5:D5');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', 'Fecha');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B6', $fechInicio.' Al '.$fechaFinal);
			$objPHPExcel->getActiveSheet()->mergeCells('B6:D6');	
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
			
			/**
			 * Resumen del Recorrido
			 * */	
			$objPHPExcel->getActiveSheet()->setSharedStyle($styleHeader, "A8:D8");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', 'Resumen del Reccorrido');
			$objPHPExcel->getActiveSheet()->getStyle("A8")->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle("A8")->getFont()->setBold(true);	
			$objPHPExcel->getActiveSheet()->mergeCells('A8:D8');	
			$objPHPExcel->getActiveSheet()->getStyle('A8:D8')
						->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A9', 'Tiempo en Movimiento');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A10', 'Tiempo en Ralenti');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A11', 'Tiempo Detenido');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C9', 'Distancia Recorrida');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C10', 'Velocidad Promedio');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C11', 'Velocidad Maxima');
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B9', $aesumen['tiempoMovimiento']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B10', $aesumen['tiempoRalenti']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B11', $aesumen['tiempoDetenido']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D9', round($aesumen['recorrido'], 2).' kms.');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D10',round($aesumen['promedio'], 2).' km/h');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D11', round($aesumen['maxima'], 2).' km/h');
			
			$objPHPExcel->getActiveSheet()->setSharedStyle($stylezebraTable, "A9:D9");
			$objPHPExcel->getActiveSheet()->setSharedStyle($stylezebraTable, "A11:D11");
			$objPHPExcel->getActiveSheet()->getStyle('B9:B11')
						->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('D9:D11')
						->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			
			/**
			* Resumen de los Eventos	
			* */	
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A13', 'Resumen de Eventos');	
			$objPHPExcel->getActiveSheet()->mergeCells('A13:D13');
			$objPHPExcel->getActiveSheet()->setSharedStyle($styleHeader, "A13:D13");
			$objPHPExcel->getActiveSheet()->getStyle('A13:D13')
				->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle("A13")->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle("A13")->getFont()->setBold(true);				
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A14', 'No.');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B14', 'Evento');
			$objPHPExcel->getActiveSheet()->mergeCells('B14:C14');	
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D14', 'Total');
			$objPHPExcel->getActiveSheet()->setSharedStyle($stylezebraTable, "A14:D14");
			$objPHPExcel->getActiveSheet()->getStyle('A14:D14')
						->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
						
			$rowControlDet=15;
			$zebraControl=0;
		 	foreach($aeventos as $eventos){
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,  ($rowControlDet),$zebraControl+1);		
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(1,  ($rowControlDet), $eventos['name']);
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(3,  ($rowControlDet), $eventos['total']);
				if($zebraControl++%2==1){
					$objPHPExcel->getActiveSheet()
						->setSharedStyle($stylezebraTable, 'A'.$rowControlDet.':D'.$rowControlDet);
				}		
				$objPHPExcel->getActiveSheet()->mergeCells('B'.$rowControlDet.':C'.$rowControlDet);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$rowControlDet)
						->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$rowControlDet)
						->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
				$rowControlDet++;
			}
			
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->setTitle('Resumen');
			
			/**
			 * Crear pestana detalle
			 * */
		 	$objWorkSheet = $objPHPExcel->createSheet(1);	
			$objWorkSheet->mergeCells('A1:A3');	 	
			$objWorkSheet->getColumnDimension('A')->setWidth(25);
			$objPHPExcel->setActiveSheetIndex(1);
				 
			$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
			$objDrawing->setName('Sample image');
			$objDrawing->setDescription('Logo');
			$objDrawing->setImageResource($gdImage);
			$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
			$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
			$objDrawing->setHeight(76.34);
			$objDrawing->setWidth(78.99);	
			$objDrawing->setOffsetX(50);
			$objDrawing->setOffsetY(0);	
			$objDrawing->setCoordinates('A1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:A3')
					->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A1:A3')
					->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	
		  	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			  
			/**
			 * Header del Reporte
			 * */  
			$objWorkSheet->setCellValue('B1', $nameClient);
			$objWorkSheet->setCellValue('B2', 'Reporte Historico ');
			$objWorkSheet->getStyle("B2")->getFont()->setSize(20);
			$objWorkSheet->getStyle("B2")->getFont()->setBold(true);
			$objWorkSheet->setCellValue('B3', 'Reporte Creado '.$dateCreate.' por '.$createdBy);
			$objWorkSheet->mergeCells('B1:F1');
			$objWorkSheet->getStyle('B1:F1')
					->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objWorkSheet->mergeCells('B2:F2');
			$objWorkSheet->getStyle('B2:F2')
					->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$objWorkSheet->mergeCells('B3:F3');	
			$objWorkSheet->getStyle('B3:F3')
					->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$objWorkSheet->setCellValue('A5', 'Unidad');
			$objWorkSheet->setCellValue('B5', $descUnit);
			$objWorkSheet->mergeCells('B5:F5');
			$objWorkSheet->setCellValue('A6', 'Fecha');
			$objWorkSheet->setCellValue('B6', $fechInicio.' Al '.$fechaFinal);
			$objWorkSheet->mergeCells('B6:F6');
			
			/**
			 * Historial Completo
			 * */
			$objWorkSheet->setCellValue('A8', 'Fecha');
			$objWorkSheet->setCellValue('B8', 'Latitud');
			$objWorkSheet->setCellValue('C8', 'Longitud');
			$objWorkSheet->setCellValue('D8', 'Evento');
			$objWorkSheet->setCellValue('E8', 'Velocidad');
			$objWorkSheet->setCellValue('F8', 'Direccion');
			$objWorkSheet->setSharedStyle($styleHeader, 'A8:F8');
			$objPHPExcel->getActiveSheet()->getStyle("A8:F8")->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle("A8:F8")->getFont()->setBold(true);
			
			$rowControlHist=9;
			$zebraControl=0;				
			foreach($rhistorico->aHistorico as $reporte){				
				$objWorkSheet->setCellValueByColumnAndRow(0,  ($rowControlHist), $reporte['GPS_DATETIME']);
				$objWorkSheet->setCellValueByColumnAndRow(1,  ($rowControlHist), $reporte['LATITUDE']);
				$objWorkSheet->setCellValueByColumnAndRow(2,  ($rowControlHist), $reporte['LONGITUDE']);
				$objWorkSheet->setCellValueByColumnAndRow(3,  ($rowControlHist), $reporte['DESC_EVT']);
				$objWorkSheet->setCellValueByColumnAndRow(4,  ($rowControlHist), $reporte['VELOCIDAD']);
				$objWorkSheet->setCellValueByColumnAndRow(5,  ($rowControlHist), $reporte['direccion']);	
				if($zebraControl++%2==1){
					$objWorkSheet->setSharedStyle($stylezebraTable, 'A'.$rowControlHist.':F'.$rowControlHist);			
				}				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$rowControlHist.':C'.$rowControlHist)
						->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
				$objPHPExcel->getActiveSheet()->getStyle('E'.$rowControlHist)
						->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
				$rowControlHist++;
			}	
	
			$objWorkSheet->getColumnDimension('B')->setAutoSize(true);
			$objWorkSheet->getColumnDimension('C')->setAutoSize(true);
			$objWorkSheet->getColumnDimension('D')->setAutoSize(true);
			$objWorkSheet->getColumnDimension('E')->setAutoSize(true);
			$objWorkSheet->getColumnDimension('F')->setAutoSize(true);		
			$objWorkSheet->setTitle('Detalle');

			$objPHPExcel->setActiveSheetIndex(0);
			$filename  = "RHistorico_".$aesumen['unit']."_".date("His_Ymd").".xlsx";
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
		}else{
			echo "no-info";
			//echo $rhistorico->getErrorMessage();	
		}
	}else{
		echo "no-info";
		//echo $rhistorico->getErrorMessage();	
	}
}else{
	echo "no-data";
}