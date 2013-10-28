<?php
/*
 *  @package             
 *  @name                Reporte 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Ing. Rodwyn Moreno 
 *  @modificado          2013-02-27
**/

// Redirect output to a client's web browser (Excel2007)
ini_set('memory_limit','512M');
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}
set_time_limit(600000);

$q = explode(",",$_GET['qs']);
$t = explode(",",$_GET['qt']);
$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("ALG")
									 ->setLastModifiedBy("ALG")
									 ->setTitle("Office 2007 XLSX")
									 ->setSubject("Office 2007 XLSX")
									 ->setDescription("Layout Puntos")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Layout Puntos");

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
						 'font'       => array( 'bold' => true,'color'	=> array('argb' => '4682B4'))
 					));
			$sharedStyle3->applyFromArray(
					array(	  
				         'fill' 	  => array('type'	=> PHPExcel_Style_Fill::FILL_SOLID,'color' => array('argb' => '3EACD1')),
						 'font'       => array( 'bold' => true,'color'	=> array('argb' => 'FFFFFF'))
 					));							
			
			
			


for($i=0; $i<count($q); $i++){
	$objPHPExcel->createSheet($i);
	$objPHPExcel->setActiveSheetIndex($i);
	$objPHPExcel->getActiveSheet()->setTitle($t[$i]);

	$sql = "SELECT P.ID_PREGUNTA, P.DESCRIPCION FROM CRM2_PREGUNTAS P
	INNER JOIN CRM2_CUESTIONARIO_PREGUNTAS C ON C.ID_PREGUNTA=P.ID_PREGUNTA
	INNER JOIN CRM2_TIPO_PREG TP ON TP.ID_TIPO = P.ID_TIPO
	WHERE C.ID_CUESTIONARIO= ".$q[$i]." AND TP.MULTIMEDIA = 0 ORDER BY C.ORDEN;";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	if($cnt>0){
		$col=1;
		$let='B';
		while($rw = $db->sqlFetchArray($qry)){
			//Cabeceras
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,$q[$i]);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,2, $rw['ID_PREGUNTA']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,3,"Clave cliente");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,3, $userAdmin->codif($rw['DESCRIPCION']));
			//Aplicar formato a cabeceras
			//$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A2:K2");
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension($let)->setAutoSize(true);
			$col++;
			$let++;
			}
			$let++;

			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A2:".$let."2");
			
			//titulo del excel
			$objPHPExcel->getActiveSheet()->setCellValue('A1', $t[$i]);
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:".$let."1");
			$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(75); // ADDNEW Altura de Fila 1
			/*Formato de Letras Blancas a B1*/
			$objPHPExcel->getActiveSheet()->mergeCells('A1:'.$let.'1');
			//$objPHPExcel->getActiveSheet()->mergeCells('B2:K2');
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(24);
		}
	}
$objPHPExcel->setActiveSheetIndex(0);
$filename = "layout_payload.xls";	
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');			
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save('tmp/'.$filename); //Guardar
$objWriter->save('php://output');  //Ver
			
			
			

			





?>