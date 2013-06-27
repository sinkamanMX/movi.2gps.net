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

if(isset($_GET['unidad']) && isset($_GET['fInicio']) && isset($_GET['fFin'])){
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
	//Variables para query cPositions
	$filtro=" AND E.VELOCITY BETWEEN 0 AND 160 ";
	$cliente = $userAdmin->user_info['ID_CLIENTE'];
	$radio = $_GET['radio'];
	$velocidad = $_GET['vel'];
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
	// Llamar funciones globales
	$tablaHistorico = $Positions->get_tablename($cliente);
	if($tablaHistorico != ""){
		$tablaHistorico="HIST".$tablaHistorico;
		$queryNumHistorico = $Positions->get_num_hist26($tablaHistorico, $_GET['unidad'], $rtime, $filtro, $cliente, $radio);
		$count = count($queryNumHistorico);
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
							}//endif parada!=parada+1
						}//endif velocidad<5
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
						
					}//endif fecha==fecha+1 y unidad==unidad+1 
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
				}//end for 
			}//endif count
			else{
				echo 0;
				}
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
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Reporte de productividad');
			//Cabeceras
			$objPHPExcel->setActiveSheetIndex(0)
						 ->setCellValue('A2', 'Fecha')
						 ->setCellValue('B2', 'Unidad')
						 ->setCellValue('C2', 'Total de paradas')
						 ->setCellValue('D2', 'Paradas autorizadas')
						 ->setCellValue('E2', 'Paradas no autorizadas')
						 ->setCellValue('F2', 'Tiempo en movimiento')
						 ->setCellValue('G2', 'Tiempo detenido autorizado')
						 ->setCellValue('H2', 'Tiempo detenido no autorizado')
						 ->setCellValue('I2', 'Velocidad maxima')
						 ->setCellValue('J2', 'Total excesos')
						 ->setCellValue('K2', 'Kilometros recorridos');
			//Aplicar formato a cabeceras
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A2:K2");
			$row=3;
			
			for($x=0;$x<count($arreglo);$x++){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,  ($row), $arreglo[$x][0]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,  ($row), $arreglo[$x][1]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,  ($row), $arreglo[$x][3]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,  ($row), $arreglo[$x][4]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,  ($row), $arreglo[$x][5]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,  ($row), $arreglo[$x][6]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,  ($row), $arreglo[$x][7]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,  ($row), $arreglo[$x][8]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,  ($row), $arreglo[$x][9]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,  ($row), $arreglo[$x][10]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, ($row), $arreglo[$x][11]);
				$row++;
				}
			//$objPHPExcel->getActiveSheet()->setTitle("Reporte productividad");
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
							
			/*$i=count($arreglo)+2;
			$objWorkSheet = $objPHPExcel->createSheet(1); //Setting index when creating
			$objWorkSheet->setCellValue('A1', "Grafica Paradas");
			$objWorkSheet->setSharedStyle($sharedStyle2, "A1:K1");
			$objWorkSheet->mergeCells('A1:K1');
			$objWorkSheet->getRowDimension('1')->setRowHeight(75); // ADDNEW Altura de Fila 1
			$objWorkSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objWorkSheet->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
			$objWorkSheet->getStyle('A1')->getFont()->setSize(24);*/
			
			//$objWorkSheet->setSharedStyle($sharedStyle3, "A2:E2");
			//grafica1
            //	Set the Labels for each dataset we want to plot
            /*$labels = array(
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$2', null, 1),	//	Notice
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$2', null, 1),	//	Inprogress
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$E$2', null, 1),	//	Error
            );*/
            //	Set the X-Axis Labels
            /*$categories = array(
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$3:$B$3', null, 2),	//	media types
            );*/
            //	Set the Data values for each dataset we want to plot
            /*$values = array(
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$3:$C$'.$i, null, 2),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$3:$D$'.$i, null, 2),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$3:$E$'.$i, null, 2),
            );*/

            //	Build the dataseries
            /*$series = new PHPExcel_Chart_DataSeries(
                PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
                PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,	// plotGrouping
                array(0, 1, 2),						            // plotOrder
                $labels,										// plotLabel
                $categories,									// plotCategory
                $values											// plotValues
            );*/
            //	Set additional data series parameters
            /*$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);*/

            //	Set the series in the plot area
            /*$plotarea = new PHPExcel_Chart_PlotArea(null, array($series));*/
            //	Set the chart legend
            /*$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);*/

            /*$title = new PHPExcel_Chart_Title( $value  . "Grafica Paradas" );*/


            //	Create the chart
            /*$chart = new PHPExcel_Chart(
                'chart1',		// name
                $title,			// title
                $legend,		// legend
                $plotarea,		// plotArea
                true,			// plotVisibleOnly
                0,				// displayBlanksAs
                null,			// xAxisLabel
                null			// yAxisLabel
            );*/

            //	Set the position where the chart should appear in the worksheet
            /*$chart->setTopLeftPosition('A2');
            $chart->setBottomRightPosition('L30');*/

            //	Add the chart to the worksheet
			/*$objPHPExcel->getActiveSheet()->addChart($chart);
            //$objPHPExcel->setActiveSheetIndex(1)->addChart($chart);
			$objWorkSheet = $objPHPExcel->createSheet(2); //Setting index when creating
			$objWorkSheet->setCellValue('A1', "Grafica Tiempo");
			$objWorkSheet->setSharedStyle($sharedStyle2, "A1:K1");
			$objWorkSheet->mergeCells('A1:K1');
			$objWorkSheet->getRowDimension('1')->setRowHeight(75); // ADDNEW Altura de Fila 1
			$objWorkSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objWorkSheet->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
			$objWorkSheet->getStyle('A1')->getFont()->setSize(24);*/			
			//grafica2
 			           //	Set the Labels for each dataset we want to plot
            /*$labelst = array(
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$F$2', null, 1),	//	Notice
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$G$2', null, 1),	//	Inprogress
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$H$2', null, 1),	//	Error
            );*/
            //	Set the X-Axis Labels
            /*$categoriest = array(
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$3:$B$3', null, 2),	//	media types
            );*/
            //	Set the Data values for each dataset we want to plot
            /*$valuest = array(
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$F$3:$F$'.$i, null, 2),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$G$3:$G$'.$i, null, 2),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$H$3:$H$'.$i, null, 2),
            );*/

            //	Build the dataseries
            /*$seriest = new PHPExcel_Chart_DataSeries(
                PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
                PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,	// plotGrouping
                array(0, 1, 2),						            // plotOrder
                $labelst,										// plotLabel
                $categoriest,									// plotCategory
                $valuest											// plotValues
            );*/
            //	Set additional data series parameters
            /*$seriest->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);*/

            //	Set the series in the plot area
            /*$plotareat = new PHPExcel_Chart_PlotArea(null, array($seriest));*/
            //	Set the chart legend
            /*$legendt = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);

            $titlet = new PHPExcel_Chart_Title( $value  . "graficat" );*/


            //	Create the chart
            /*$chartt = new PHPExcel_Chart(
                'chart2',		// name
                $titlet,			// title
                $legendt,		// legend
                $plotareat,		// plotArea
                true,			// plotVisibleOnly
                0,				// displayBlanksAs
                null,			// xAxisLabel
                null			// yAxisLabel
            );*/

            //	Set the position where the chart should appear in the worksheet
            /*$chartt->setTopLeftPosition('A2');
            $chartt->setBottomRightPosition('L30');*/

            //	Add the chart to the worksheet
			/*$objPHPExcel->getActiveSheet()->addChart($chartt);
            //$objPHPExcel->setActiveSheetIndex(1)->addChart($chart);
			$objWorkSheet = $objPHPExcel->createSheet(3); //Setting index when creating
			$objWorkSheet->setCellValue('A1', "Grafica Kilometros");
			$objWorkSheet->setSharedStyle($sharedStyle2, "A1:K1");
			$objWorkSheet->mergeCells('A1:K1');
			$objWorkSheet->getRowDimension('1')->setRowHeight(75); // ADDNEW Altura de Fila 1
			$objWorkSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objWorkSheet->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
			$objWorkSheet->getStyle('A1')->getFont()->setSize(24);			
			//grafica3
			//	Set the Labels for each dataset we want to plot
            $labelsk = array(
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$I$2', null, 1),	//	Notice
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$J$2', null, 1),	//	Inprogress
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$K$2', null, 1),	//	Error
            );
            //	Set the X-Axis Labels
            $categoriesk = array(
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$3:$B$3', null, 2),	//	media types
            );
            //	Set the Data values for each dataset we want to plot
            $valuesk = array(
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$I$3:$I$'.$i, null, 2),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$J$3:$J$'.$i, null, 2),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$K$3:$K$'.$i, null, 2),
            );

            //	Build the dataseries
            $seriesk = new PHPExcel_Chart_DataSeries(
                PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
                PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,	// plotGrouping
                array(1, 2, 0),						            // plotOrder
                $labelsk,										// plotLabel
                $categoriesk,									// plotCategory
                $valuesk											// plotValues
            );
            //	Set additional data series parameters
            $seriesk->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

            //	Set the series in the plot area
            $plotareak = new PHPExcel_Chart_PlotArea(null, array($seriesk));
            //	Set the chart legend
            $legendk = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);

            $titlek = new PHPExcel_Chart_Title( $value  . "Grafica kilometros" );


            //	Create the chart
            $chartk = new PHPExcel_Chart(
                'chart3',		// name
                $titlek,			// title
                $legendk,		// legend
                $plotareak,		// plotArea
                true,			// plotVisibleOnly
                0,				// displayBlanksAs
                null,			// xAxisLabel
                null			// yAxisLabel
            );

            //	Set the position where the chart should appear in the worksheet
            $chartk->setTopLeftPosition('A2');
            $chartk->setBottomRightPosition('L30');

            //	Add the chart to the worksheet
			$objPHPExcel->getActiveSheet()->addChart($chartk);*/
            //$objPHPExcel->setActiveSheetIndex(1)->addChart($chart);
			



			
			/*//Agregar pestaña(s)
			for($x=1; $x<=3; $x++){
			$objWorkSheet = $objPHPExcel->createSheet(($x)); //Setting index when creating
			
			//Formato Cabecera Titulo pestaña
			//$objPHPExcel->setActiveSheetIndex($x)->setTitle('G');
			$objPHPExcel->setActiveSheetIndex($x)->setSharedStyle($sharedStyle2, "A1:Z1");
			$objPHPExcel->setActiveSheetIndex($x)->mergeCells('A1:Z1');
			$objPHPExcel->setActiveSheetIndex($x)->getRowDimension('1')->setRowHeight(75); // ADDNEW Altura de Fila 1
			$objPHPExcel->setActiveSheetIndex($x)->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->setActiveSheetIndex($x)->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
			$objPHPExcel->setActiveSheetIndex($x)->getStyle('A1')->getFont()->setSize(24);
			$objPHPExcel->setActiveSheetIndex($x)->setSharedStyle($sharedStyle3, "A2:E2");
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			//$objPHPExcel->getActiveSheet()->setTitle("Grafica");
			//$objWorkSheet->setTitle("Grafica ");
			}
			

			

			

			
			//Titulo Cabecera pestaña
			$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', "Grafica Paradas");
			//$objPHPExcel->setActiveSheetIndex(1)->setTitle("Reporte productividad");
			$objPHPExcel->setActiveSheetIndex(1)
                ->setCellValue('A2', 'Fecha')
			  	->setCellValue('B2', 'Unidad')
				->setCellValue('C2', 'Total de paradas')
				->setCellValue('D2', 'Paradas autorizadas')
                ->setCellValue('E2', 'Paradas no autorizadas');
			$rwp=3;
			for($y=0;$y<count($arreglo);$y++){	
			$objPHPExcel->setActiveSheetIndex(1)
                    ->setCellValue('A3', $arreglo[$y][0])
                    ->setCellValue('B3', $arreglo[$y][1])
                    ->setCellValue('C3', $arreglo[$y][3])
                    ->setCellValue('D3', $arreglo[$y][4])
                    ->setCellValue('E3', $arreglo[$y][5]);
			$rwp++;
			}
	 
			$i=count($arreglo)+2;
            //	Set the Labels for each dataset we want to plot
            $labels = array(
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$2', null, 1),	//	Notice
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$2', null, 1),	//	Inprogress
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$E$2', null, 1),	//	Error
            );
            //	Set the X-Axis Labels
            $categories = array(
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$3:$B$'.$i, null, 2),	//	media types
            );
            //	Set the Data values for each dataset we want to plot
            $values = array(
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$3:$C$'.$i, null, 2),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$3:$D$'.$i, null, 2),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$3:$E$'.$i, null, 2),
            );

            //	Build the dataseries
            $series = new PHPExcel_Chart_DataSeries(
                PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
                PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,	// plotGrouping
                array(0, 1, 2),						            // plotOrder
                $labels,										// plotLabel
                $categories,									// plotCategory
                $values											// plotValues
            );
            //	Set additional data series parameters
            $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

            //	Set the series in the plot area
            $plotarea = new PHPExcel_Chart_PlotArea(null, array($series));
            //	Set the chart legend
            $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);

            $title = new PHPExcel_Chart_Title( $value  . $titulog );


            //	Create the chart
            $chart = new PHPExcel_Chart(
                'chart1',		// name
                $title,			// title
                $legend,		// legend
                $plotarea,		// plotArea
                true,			// plotVisibleOnly
                0,				// displayBlanksAs
                null,			// xAxisLabel
                null			// yAxisLabel
            );

            //	Set the position where the chart should appear in the worksheet
            $chart->setTopLeftPosition('H2');
            $chart->setBottomRightPosition('N17');

            //	Add the chart to the worksheet
            $objPHPExcel->setActiveSheetIndex(1)->addChart($chart);
//pestaña 2
			$objPHPExcel->setActiveSheetIndex(2)->setCellValue('A1', "Grafica Tiempo");
			//$objPHPExcel->setActiveSheetIndex(1)->setTitle("Reporte productividad");
			$objPHPExcel->setActiveSheetIndex(2)
                ->setCellValue('A2', 'Fecha')
			  	->setCellValue('B2', 'Unidad')
				->setCellValue('C2', 'Tiempo en movimiento')
				->setCellValue('D2', 'Tiempo detenido autorizado')
                ->setCellValue('E2', 'Tiempo detenido no autorizado');
			$rwp=3;
			for($y=0;$y<count($arreglo);$y++){	
			$objPHPExcel->setActiveSheetIndex(2)
                    ->setCellValue('A3', $arreglo[$y][0])
                    ->setCellValue('B3', $arreglo[$y][1])
                    ->setCellValue('C3', $arreglo[$y][6])
                    ->setCellValue('D3', $arreglo[$y][7])
                    ->setCellValue('E3', $arreglo[$y][8]);
			$rwp++;
			}
	 
			$i=count($arreglo)+2;
            //	Set the Labels for each dataset we want to plot
            $labels = array(
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$2', null, 1),	//	Notice
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$2', null, 1),	//	Inprogress
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$E$2', null, 1),	//	Error
            );
            //	Set the X-Axis Labels
            $categories = array(
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$3:$B$'.$i, null, 2),	//	media types
            );
            //	Set the Data values for each dataset we want to plot
            $values = array(
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$3:$C$'.$i, null, 2),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$3:$D$'.$i, null, 2),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$3:$E$'.$i, null, 2),
            );

            //	Build the dataseries
            $series = new PHPExcel_Chart_DataSeries(
                PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
                PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,	// plotGrouping
                array(0, 1, 2),						            // plotOrder
                $labels,										// plotLabel
                $categories,									// plotCategory
                $values											// plotValues
            );
            //	Set additional data series parameters
            $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

            //	Set the series in the plot area
            $plotarea = new PHPExcel_Chart_PlotArea(null, array($series));
            //	Set the chart legend
            $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);

            $title = new PHPExcel_Chart_Title( $value  . $titulog );


            //	Create the chart
            $chart = new PHPExcel_Chart(
                'chart2',		// name
                $title,			// title
                $legend,		// legend
                $plotarea,		// plotArea
                true,			// plotVisibleOnly
                0,				// displayBlanksAs
                null,			// xAxisLabel
                null			// yAxisLabel
            );

            //	Set the position where the chart should appear in the worksheet
            $chart->setTopLeftPosition('H2');
            $chart->setBottomRightPosition('N17');

            //	Add the chart to the worksheet
            $objPHPExcel->setActiveSheetIndex(2)->addChart($chart);
			//Agregar grafica
			//Titulo Cabecera pestaña
			$objPHPExcel->setActiveSheetIndex(3)->setCellValue('A1', "Grafica Kilometros");
			//$objPHPExcel->setActiveSheetIndex(1)->setTitle("Reporte productividad");
			$objPHPExcel->setActiveSheetIndex(3)
                ->setCellValue('A2', 'Fecha')
			  	->setCellValue('B2', 'Unidad')
				->setCellValue('C2', 'Kilometros recorridos')
				->setCellValue('D2', 'Velocidad maxima')
                ->setCellValue('E2', 'Total de excesos');
			$rwp=3;
			for($y=0;$y<count($arreglo);$y++){	
			$objPHPExcel->setActiveSheetIndex(3)
                    ->setCellValue('A3', $arreglo[$y][0])
                    ->setCellValue('B3', $arreglo[$y][1])
                    ->setCellValue('C3', $arreglo[$y][11])
                    ->setCellValue('D3', $arreglo[$y][9])
                    ->setCellValue('E3', $arreglo[$y][10]);
			$rwp++;
			}
	 
			$i=count($arreglo)+2;
            //	Set the Labels for each dataset we want to plot
            $labelsk = array(
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$K$2', null, 1),	//	Notice
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$I$2', null, 1),	//	Inprogress
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$J$2', null, 1),	//	Error
            );
            //	Set the X-Axis Labels
            $categoriesk = array(
                new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$3:$B$'.$i, null, 2),	//	media types
            );
            //	Set the Data values for each dataset we want to plot
            $valuesk = array(
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$K$3:$C$'.$i, null, 2),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$I$3:$D$'.$i, null, 2),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$J$3:$E$'.$i, null, 2),
            );

            //	Build the dataseries
            $seriesk = new PHPExcel_Chart_DataSeries(
                PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
                PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,	// plotGrouping
                array(0, 1, 2),						            // plotOrder
                $labelsk,										// plotLabel
                $categoriesk,									// plotCategory
                $valuesk										// plotValues
            );
            //	Set additional data series parameters
            $seriesk->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

            //	Set the series in the plot area
            $plotareak = new PHPExcel_Chart_PlotArea(null, array($series));
            //	Set the chart legend
            $legendk = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);

            $titlek  = new PHPExcel_Chart_Title( $value  . "Grafica kilometros" );


            //	Create the chart
            $chartk = new PHPExcel_Chart(
                'chart3',		// name
                $titlek,		// title
                $legendk,		// legend
                $plotareak,		// plotArea
                true,			// plotVisibleOnly
                0,				// displayBlanksAs
                null,			// xAxisLabel
                null			// yAxisLabel
            );

            //	Set the position where the chart should appear in the worksheet
            $chartk->setTopLeftPosition('H2');
            $chartk->setBottomRightPosition('N17');

            //	Add the chart to the worksheet
            $objPHPExcel->setActiveSheetIndex(3)->addChart($chartk);			
			
			 //autoajustar columnas
			 //$objWorkSheet->getColumnDimension('A')->setAutoSize(true);*/
			 

						
			 
			
			
			$objPHPExcel->setActiveSheetIndex(0);
			//$filename  = "Rproductividad_".date("His_Ymd").".xlsx";
			$filename = date("His_Ymd").".xlsx";
			//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			//header('Content-Disposition: attachment;filename="'.$filename.'"');
			//header('Cache-Control: max-age=0');			
			//Guardar
			//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			//Incluir grafica
			//$objWriter->setIncludeCharts(TRUE);
			//$objWriter->save('tmp/'.$filename);
			//$objWriter->save('php://output');
			//end phpexcel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			//$objWriter->save('tmp/'.$filename); //Guardar
			$objWriter->save('php://output');  //Ver



			
			
			
			
		}//endif tablaHistorico
		else{
			echo -1;
			}
}//endif isset
else{
	echo -2;
	}

?>