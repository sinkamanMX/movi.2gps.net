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
						
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("ALG")
									 ->setLastModifiedBy("ALG")
									 ->setTitle("Office 2007 XLSX")
									 ->setSubject("Office 2007 XLSX")
									 ->setDescription("Reporte Productividad")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Reporte Historico");

			$sharedStyle1 = new PHPExcel_Style();
			$sharedStyle2 = new PHPExcel_Style();
			$sharedStyle3 = new PHPExcel_Style();
			
			$sharedStyle1->applyFromArray(array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('argb' => '191970')
				)
			));
				
			$sharedStyle2->applyFromArray(array(	  
				'fill' 	  => array(
					'type'	=> PHPExcel_Style_Fill::FILL_SOLID,'color' => array('argb' => '4682B4')),
					'font'  => array( 'bold' => true,'color'	=> array('argb' => 'FFFFFF'))
			));
			
			$sharedStyle3->applyFromArray(array(	  
				'fill' 	  => array(
					'type'	=> PHPExcel_Style_Fill::FILL_SOLID,'color' => array('argb' => '3EACD1')),
					'font'       => array( 'bold' => true,'color'	=> array('argb' => 'FFFFFF'))
			));	
			
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:C1");
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A2:C2");
			$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(75);
			/*Formato de Letras Blancas a B1*/
			$objPHPExcel->getActiveSheet()->mergeCells('B1:C1');
			$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()
				->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
			$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(24);			
			//titulo del excel
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Resumen  ');
			//Cabeceras
			$objPHPExcel->setActiveSheetIndex(0)
						 ->setCellValue('A2', 'Unidad: ')
						 ->setCellValue('B2', $aesumen['unit']);
			$objPHPExcel->setActiveSheetIndex(0)
						 ->setCellValue('A3', 'Fecha')
						 ->setCellValue('B3', 'Evento')
						 ->setCellValue('C3', 'Total');			 

			//Aplicar formato a cabeceras
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A3:C3");
			$rowControl=4;
		 	foreach($aeventos as $eventos){
		 		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,  ($rowControl), $fBegin."-".$fEnd );
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,  ($rowControl), $eventos['name']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,  ($rowControl), $eventos['total']);	
				$rowControl++;
			}

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			// Renombrar Hoja
			$objPHPExcel->getActiveSheet()->setTitle('Resumen');

			//Crear pestana detalle
			$objWorkSheet = $objPHPExcel->createSheet(1); //Setting index when creating
			//Cabeceras
			//Titulo
			$objWorkSheet->setCellValue('A1', "Detalle");
			$objWorkSheet->setSharedStyle($sharedStyle1, "A1:F1");
			$objWorkSheet->mergeCells('A1:F1');
			$objWorkSheet->getRowDimension('1')->setRowHeight(75); // ADDNEW Altura de Fila 1
			$objWorkSheet->getStyle('A1')->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objWorkSheet->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
			$objWorkSheet->getStyle('A1')->getFont()->setSize(24);
			//subtitulo -> unidad
			$objWorkSheet->setSharedStyle($sharedStyle2, "A2:F2");
			$objWorkSheet
					 ->setCellValue('A2', 'Unidad: ')
					 ->setCellValue('B2', $aesumen['unit']);
			$objWorkSheet		 
					 ->setCellValue('A3', 'Fecha')
					 ->setCellValue('B3', 'Latitud')
					 ->setCellValue('C3', 'Longitud')
					 ->setCellValue('D3', 'Evento')
					 ->setCellValue('E3', 'Velocidad km/h')
					 ->setCellValue('F3', 'Direccion');
			$objWorkSheet->setSharedStyle($sharedStyle2, "A3:F3");
			$rowControlDet=4;			
			foreach($rhistorico->aHistorico as $reporte){
				$objWorkSheet->setCellValueByColumnAndRow(0,  ($rowControlDet), $reporte['GPS_DATETIME']);
				$objWorkSheet->setCellValueByColumnAndRow(1,  ($rowControlDet), $reporte['LATITUDE']);
				$objWorkSheet->setCellValueByColumnAndRow(2,  ($rowControlDet), $reporte['LONGITUDE']);
				$objWorkSheet->setCellValueByColumnAndRow(3,  ($rowControlDet), $reporte['DESC_EVT']);
				$objWorkSheet->setCellValueByColumnAndRow(4,  ($rowControlDet), $reporte['VELOCIDAD']);
				$objWorkSheet->setCellValueByColumnAndRow(5,  ($rowControlDet), $reporte['direccion']);		
				$row2++;
			}//end for 			
			//Redimencionar 
			$objWorkSheet->getColumnDimension('A')->setAutoSize(true);
			$objWorkSheet->getColumnDimension('B')->setAutoSize(true);
			$objWorkSheet->getColumnDimension('C')->setAutoSize(true);
			$objWorkSheet->getColumnDimension('D')->setAutoSize(true);
			$objWorkSheet->getColumnDimension('E')->setAutoSize(true);
			$objWorkSheet->getColumnDimension('F')->setAutoSize(true);
			// Renombrar Hoja
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