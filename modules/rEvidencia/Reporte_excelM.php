<?php
$userData = new usersAdministration();
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

$rango_texto  = "Del: ".$_GET['f1'].' Al: '.$_GET['f2'];
$dti = $_GET['f1'];
$dtf = $_GET['f2'];
$usr = $_GET['usuarios'];
$qst = $_GET['cuestionario'];

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
				         'fill' 	  => array('type'	=> PHPExcel_Style_Fill::FILL_SOLID,'color' => array('argb' => '3EACD1')),
						 'font'       => array( 'bold' => true,'color'	=> array('argb' => 'FFFFFF'))
 					));							
			
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:K1");
			$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(75); // ADDNEW Altura de Fila 1
			/*Formato de Letras Blancas a B1*/
			$objPHPExcel->getActiveSheet()->mergeCells('B1:K1');
			//$objPHPExcel->getActiveSheet()->mergeCells('B2:K2');
			$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
			$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(24);
			
			//titulo del excel
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Reporte de evidencias');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Rango de fechas: ');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', $rango_texto);
			//Cabeceras
			$objPHPExcel->setActiveSheetIndex(0)
						 ->setCellValue('A3', 'Fecha')
						 ->setCellValue('B3', 'Cuestionario')
						 ->setCellValue('C3', 'Usuario');
			//Aplicar formato a cabeceras
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A2:K2");
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A3:K3");
			$data1 = data1($usr,$qst,$dti,$dtf);
			$row=4;
			
			for($x=0;$x<count($data1);$x++){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,  ($row), $data1[$x][1]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,  ($row), $data1[$x][2]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,  ($row), $data1[$x][3]);

				$row++;
				}
			$objPHPExcel->getActiveSheet()->setTitle("Reporte evidencias");
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			
			//obtener ids
			for($x=0;$x<count($data1);$x++){
				$id .= ($id=="")?$data1[$x][0]:",".$data1[$x][0];
				}
			//Crear nueva pestana
			$objWorkSheet = $objPHPExcel->createSheet(1); //Setting index when creating
			$objWorkSheet->setCellValue('A1', "Fecha");
			$objWorkSheet->setCellValue('B1', "Cuestionario");
			$objWorkSheet->setCellValue('C1', "Pregunta");
			$objWorkSheet->setCellValue('D1', "Respuesta");
			$objWorkSheet->setSharedStyle($sharedStyle2, "A1:D1");
			$objWorkSheet->setTitle("Detalle");
			
			$data2 = data2($id);
			$row2 = 2;
			for($x=0;$x<count($data2);$x++){
				$objWorkSheet->setCellValueByColumnAndRow(0,  ($row2), $data2[$x][0]);
				$objWorkSheet->setCellValueByColumnAndRow(1,  ($row2), $data2[$x][1]);
				$objWorkSheet->setCellValueByColumnAndRow(2,  ($row2), $data2[$x][2]);
				if($data2[$x][4]==0){
					$objWorkSheet->setCellValueByColumnAndRow(3,  ($row2), $data2[$x][3]);
					}
				if($data2[$x][4]==1){
					$e = explode("/",$data2[$x][3]);
					 
					$objWorkSheet->setCellValueByColumnAndRow(3,  ($row2), $e[count($e)-1]);
					$objWorkSheet->getCell('D'.$row2)
					->getHyperlink()
					->setUrl($data2[$x][3]);
					/*
				  	$objDrawing = new PHPExcel_Worksheet_Drawing();
					$objDrawing->setPath('http://movi.2gps.net/public/evidencia/foto_2.jpg');
					$objDrawing->setCoordinates('');
					$objDrawing->setResizeProportional(false);
					$objDrawing->setHeight(100);
					$objDrawing->setWidth(100);
					//	$objDrawing->getShadow()->setVisible(true);
					$objDrawing->setWorksheet($objWorkSheet);
					//$objWorkSheet->getCell('D'.$row2)
					//->getHyperlink()
					//->setUrl('http:/public/evidencia/foto_2.jpg');
					*/}

				$row2++;
				}			
			
			
			$objWorkSheet->getColumnDimension('A')->setAutoSize(true);
			$objWorkSheet->getColumnDimension('B')->setAutoSize(true);
			$objWorkSheet->getColumnDimension('C')->setAutoSize(true);
			$objWorkSheet->getColumnDimension('D')->setAutoSize(true);
			
			$objPHPExcel->setActiveSheetIndex(0);
			
			$filename = "rev_".date("His_Ymd").".xlsx";
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			//$objWriter->save('tmp/'.$filename); //Guardar
			$objWriter->save('php://output');  //Ver			
			
function data1($usr,$qst,$dti,$dtf){
	global $db;
	$c = 0;
	$arreglo = array();
	
	$sql = "SELECT R.ID_RES_CUESTIONARIO,R.FECHA,Q.DESCRIPCION AS QST,U.NOMBRE_COMPLETO,R.LATITUD,R.LONGITUD FROM CRM2_RESPUESTAS R
	INNER JOIN CRM2_CUESTIONARIOS Q ON Q.ID_CUESTIONARIO = R.ID_CUESTIONARIO
	INNER JOIN ADM_USUARIOS U ON U.ID_USUARIO = R.COD_USER
	WHERE U.ID_USUARIO IN(".$usr.") 
	AND Q.ID_CUESTIONARIO IN(".$qst.")
	AND R.FECHA BETWEEN '".$dti."' AND '".$dtf."' ORDER BY R.FECHA;";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);		
	if($cnt > 0){
		while($row = $db->sqlFetchArray($qry)){
			$arreglo[$c][0] = $row['ID_RES_CUESTIONARIO'];
			$arreglo[$c][1] = $row['FECHA'];
			$arreglo[$c][2] = $row['QST'];
			$arreglo[$c][3] = $row['NOMBRE_COMPLETO'];
			$c++;
				}
		}
	return $arreglo;	
	}
//--------------------------------------------------------
function data2($id){
	if($id!=""){
	global $db;
	$c = 0;
	$arreglo = array();
	
	 $sql = "SELECT R.ID_RES_CUESTIONARIO, R.FECHA, Q.DESCRIPCION AS QST, P.DESCRIPCION AS PREGUNTA,
IF(TP.MULTIMEDIA=0,PR.RESPUESTA,CONCAT('http://movi.2gps.net',PR.RESPUESTA)) AS RESPUESTA,
TP.MULTIMEDIA FROM CRM2_RESPUESTAS R
INNER JOIN CRM2_CUESTIONARIOS Q ON Q.ID_CUESTIONARIO = R.ID_CUESTIONARIO
INNER JOIN CRM2_PREG_RES PR ON PR.ID_RES_CUESTIONARIO = R.ID_RES_CUESTIONARIO
INNER JOIN CRM2_PREGUNTAS P ON P.ID_PREGUNTA = PR.ID_PREGUNTA
INNER JOIN CRM2_TIPO_PREG TP ON P.ID_TIPO = TP.ID_TIPO
WHERE R.ID_RES_CUESTIONARIO IN (".$id.")
ORDER BY R.FECHA,R.ID_RES_CUESTIONARIO;";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);		
	if($cnt > 0){
		while($row = $db->sqlFetchArray($qry)){
			$arreglo[$c][0] = $row['FECHA'];
			$arreglo[$c][1] = $row['QST'];
			$arreglo[$c][2] = $row['PREGUNTA'];
			$arreglo[$c][3] = $row['RESPUESTA'];
			$arreglo[$c][4] = $row['MULTIMEDIA'];
			$c++;
				}
		}
	return $arreglo;
	}
	}
?>