<?php
$userData = new usersAdministration();
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
$db ->sqlQuery("SET NAMES 'utf8'");



			//Crear Excel
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

			$sharedStyle1->applyFromArray(
				array(	'fill' 	=> array(
									'type' => PHPExcel_Style_Fill::FILL_SOLID,
									'color' => array('argb' => '191970')
								)
				));
				
			$sharedStyle2->applyFromArray(
					array(	  
				         'fill' 	  => array('type'	=> PHPExcel_Style_Fill::FILL_SOLID,'color' => array('argb' => '4682B4')),
						 'font'       => array( 'bold' => true,'color'	=> array('argb' => 'FFFFFF'))
 					));
			$sharedStyle3->applyFromArray(
					array(	  
				         'fill' 	  => array('type'	=> PHPExcel_Style_Fill::FILL_SOLID,'color' => array('argb' => '4682B4')),
						 'font'       => array( 'bold' => true,'color'	=> array('argb' => '4682B4'))
 					));							
			
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "B1:C1");
			
			$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $_GET['idq']);
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "A1");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "NIP GEOPUNTO");
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A2");
			//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Pregunta');
			//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Payload');
			//Cabeceras
			/*$objPHPExcel->setActiveSheetIndex(0)
						 ->setCellValue('A3', 'Fecha')
						 ->setCellValue('B3', 'Cuestionario')
						 ->setCellValue('C3', 'Usuario');*/
			//Aplicar formato a cabeceras
			//$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A2:K2");
			//$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A3:K3");
			$data1 = data1($_GET['idq']);
			//$row=2;
			$col = 1;
			$letra = 'B';
			
			for($x=0;$x<count($data1);$x++){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,  1, $data1[$x][0]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,  2, $data1[$x][1]);
				$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, $letra."1");
				$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, $letra."2");
				$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setAutoSize(true);
				//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,  ($row), $data1[$x][3]);

				//$row++;
				$col++;
				$letra++;
				}
			//$title = get_title($_GET['idq']);
			$title = substr(get_title($_GET['idq']), 0, 25);
			
			//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', $title);
			
			$objPHPExcel->getActiveSheet()->setTitle($title);
			//$objPHPExcel->getActiveSheet()->setTitle("Competencias para el uso de Ab");
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			//$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			//$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			

			
			

			$filename = "plantilla_payload.xlsx";
			//$filename = "plantilla_payload.xls";
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			//$objWriter->save('tmp/'.$filename); //Guardar
			$objWriter->save('php://output');  //Ver			
			
function data1($idq){
	global $db;
	$db ->sqlQuery("SET NAMES 'utf8'");
	$c = 0;
	$arreglo = array();
	
	$sql = "SELECT P.ID_PREGUNTA,P.DESCRIPCION FROM CRM2_PREGUNTAS P
	INNER JOIN CRM2_CUESTIONARIO_PREGUNTAS CP ON CP.ID_PREGUNTA = P.ID_PREGUNTA
	INNER JOIN CRM2_TIPO_PREG TP ON TP.ID_TIPO = P.ID_TIPO
	WHERE CP.ID_CUESTIONARIO = ".$idq." AND TP.MULTIMEDIA = 0 AND TP.PAYLOAD = 1 ORDER BY CP.ORDEN;";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);		
	if($cnt > 0){
		while($row = $db->sqlFetchArray($qry)){
			$arreglo[$c][0] = $row['ID_PREGUNTA'];
			$arreglo[$c][1] = $row['DESCRIPCION'];
			$c++;
				}
		}
	return $arreglo;	
	}
//--------------------------------------------------------
function get_title($idq){
	global $db;
	$db ->sqlQuery("SET NAMES 'utf8'");
	$sql = "SELECT DESCRIPCION FROM CRM2_CUESTIONARIOS WHERE ID_CUESTIONARIO = ".$idq.";";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);		
	if($cnt > 0){
		$row = $db->sqlFetchArray($qry);
		
			return $row['DESCRIPCION'];
			
				
		}
	else{
		return 'payload';
		}	

	}
?>