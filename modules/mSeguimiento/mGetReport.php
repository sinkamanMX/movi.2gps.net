<?php
$userData = new usersAdministration();
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

$rango_texto  = "Del: ".$_GET['f1'].' Al: '.$_GET['f2'];
$dti = $_GET['f1'];
$dtf = $_GET['f2'];
$rtime = " AND GPS_DATETIME BETWEEN '".$_GET['dti']."' AND '".$_GET['dtf']."' ";
$cliente = $userAdmin->user_info['ID_CLIENTE'];
$idunit = $_GET['und'];

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
			$objPHPExcel->getActiveSheet()->mergeCells('B1:N1');
			//$objPHPExcel->getActiveSheet()->mergeCells('B2:M2');
			$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
			$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(24);
			
			//titulo del excel
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Reporte de seguimiento');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Rango de fechas: ');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', $rango_texto);
			//Cabeceras
			$objPHPExcel->setActiveSheetIndex(0)
						 ->setCellValue('A3', 'Fecha')
						 ->setCellValue('B3', 'Kilometros recorridos')
						 ->setCellValue('C3', 'Velocidad (km/l)')
						 ->setCellValue('D3', 'Revoluciones por minuto')
						 ->setCellValue('E3', 'Rendimiento combustible (km/l)')
						 ->setCellValue('F3', 'Temperatura del motor (&deg;c)')
						 ->setCellValue('G3', 'Combustible usado (l)')
						 ->setCellValue('H3', 'Horas de uso de combustible')
						 ->setCellValue('I3', 'Presi&oacute;n de aceite')
						 ->setCellValue('J3', 'Tiempo total crucero')
						 ->setCellValue('K3', 'Tiempo motor detenido')
						 ->setCellValue('L3', 'Porcentaje carag motor')
						 ->setCellValue('M3', 'Tiempo total trabajo motor')
						 ->setCellValue('N3', 'Direcci&oacute;n');
			//Aplicar formato a cabeceras
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A2:N2");
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A3:N3");
			$data1 = data1($cliente,$idunit,$rtime);
			$row=4;
			
			for($x=0;$x<count($data1);$x++){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,  ($row), $data1[$x][0]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,  ($row), $data1[$x][2]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,  ($row), $data1[$x][3]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,  ($row), $data1[$x][4]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,  ($row), $data1[$x][5]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,  ($row), $data1[$x][6]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,  ($row), $data1[$x][7]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,  ($row), $data1[$x][8]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,  ($row), $data1[$x][9]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,  ($row), $data1[$x][10]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, ($row), $data1[$x][11]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, ($row), $data1[$x][12]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, ($row), $data1[$x][13]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, ($row), $data1[$x][1]);
				

				$row++;
				}
			$objPHPExcel->getActiveSheet()->setTitle("Reporte Seguimiento");
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

			
			//obtener ids
			//for($x=0;$x<count($data1);$x++){
				//$id .= ($id=="")?$data1[$x][0]:",".$data1[$x][0];
				//}
			//Crear nueva pestana
			/*$objWorkSheet = $objPHPExcel->createSheet(1); //Setting index when creating
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
					}

				$row2++;
				}			
			
			
			$objWorkSheet->getColumnDimension('A')->setAutoSize(true);
			$objWorkSheet->getColumnDimension('B')->setAutoSize(true);
			$objWorkSheet->getColumnDimension('C')->setAutoSize(true);
			$objWorkSheet->getColumnDimension('D')->setAutoSize(true);*/
			
			$objPHPExcel->setActiveSheetIndex(0);
			
			$filename = "seg_".date("His_Ymd").".xlsx";
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			//$objWriter->save('tmp/'.$filename); //Guardar
			$objWriter->save('php://output');  //Ver			
			
function data1($cte,$und,$rtime){
	global $db;
	$c = 0;
	
	$arreglo = array();
	$tablaHistorico = get_tablename($cte);
	$hst = "ACC_HIST".$tablaHistorico;
	
	
	$sql = "SELECT GPS_DATETIME,LATITUDE,LONGITUDE,E_TEMP,E_RPM,VS,TOD,F_ECO,TF,IFU,OIL_PRE,T_CRU,E_IDLE,E_LOAD,E_TIME
	FROM ".$hst." WHERE COD_ENTITY= ".$und.$rtime." ORDER BY GPS_DATETIME;";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);		
	if($cnt > 0){
		while($row = $db->sqlFetchArray($qry)){
			$arreglo[$c][0]  = $row['GPS_DATETIME'];
			$arreglo[$c][1]  = direccion_no_format($row['LATITUDE'],$row['LONGITUDE']);
			$arreglo[$c][2]  = $row['TOD'];
			$arreglo[$c][3]  = $row['VS'];
			$arreglo[$c][4]  = $row['E_RPM'];
			$arreglo[$c][5]  = $row['F_ECO'];
			$arreglo[$c][6]  = $row['E_TEMP'];
			$arreglo[$c][7]  = $row['TF'];
			$arreglo[$c][8]  = $row['IFU'];
			$arreglo[$c][9] = $row['OIL_PRE'];
			$arreglo[$c][10] = $row['T_CRU'];
			$arreglo[$c][11] = $row['E_IDLE'];
			$arreglo[$c][12] = $row['E_LOAD'];
			$arreglo[$c][13] = $row['E_TIME'];

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
//------------------------------------------------------------
	function get_tablename($id_client){
		$id_client = (int)$id_client;	
		$table_name = '';		
		if (strlen($id_client) < 5) {
	        $table_name = str_repeat('0', (5-strlen($id_client)));
	    }
    	return $table_name . $id_client;
	}	
//------------------------------------------------------------
	function direccion_no_format($lati,$longi){
		global $config_bd_sp;
	$conexion = mysqli_connect( $config_bd_sp['host'],$config_bd_sp['user'],
								$config_bd_sp['pass'],$config_bd_sp['bname']);				
		if($conexion){
			$sql_stret	= "CALL SPATIAL_CALLES(".$longi.",".$lati.");";
			$query 		= mysqli_query($conexion, $sql_stret);
			$row_st   	= @mysqli_fetch_array($query);
			$direccion 	= $row_st['ESTADO'].", ".$row_st['MUNICIPIO'].", ".$row_st['ASENTAMIENTO'].", ".
			              $row_st['CALLE'];
			return $direccion;
			mysqli_close($conexion);
		}else{
			return false;
		}
	}	
?>