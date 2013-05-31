<?php
/** * 
 *  @package             Consola web
 *  @name                
 *  @version             1.1
 *  @copyright           Air Logistics & GPS S.A. de C.V.
 *  @author              Erick A. Calderón
 *  @modificado          30-08-2011
**/
	header('Content-Type: text/html; charset=iso-8859-1');
	set_time_limit(600000000);
	include('mFunciones_CV.php');
	
	//--------------------------- Modificada BD y Encabezado------------------------
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	$userData = new usersAdministration(); //Nueva Instancia de Admin.

	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';  //Manda al login si no se ha Logeo.
	//--------------------------- Modificada BD y Encabezado------------------------
	
	//$funciones_cv = new mFunciones_CV();
	//$dbf = new dbFunctions();	

	$id_unidad =  $_GET['unidad'];
	
	/*if($_GET['tipo']==1){//por semana obtener numero de la semana		
		$iYear    = date("Y");
		$iWeekNum = $_GET['semana'];
		$sStartTS =$funciones_cv-> WeekToDate ($iWeekNum, $iYear);
		$fechaInicio = date ("Y-m-d", $sStartTS);
		$fechaFin    = date ("Y-m-d", $sStartTS + (6*24*60*60));
		$rtime = " AND CAST(GPS_DATETIME AS DATE) BETWEEN '".$fechaInicio."' AND '".$fechaFin."'";
		$rango = " AND CAST(e.GPS_DATETIME AS DATE) BETWEEN '".$fechaInicio."' AND '".$fechaFin."'";
	}else{*/
		$fechaInicio = $_GET['fInicio'];
		$fechaFin    = $_GET['fFin'];
		$rtime = " AND GPS_DATETIME BETWEEN '".$fechaInicio.":00' AND '".$fechaFin.":00'";
		$rango = " AND e.GPS_DATETIME BETWEEN '".$fechaInicio.":00' AND '".$fechaFin.":00'";
	//}


	//global $db,$funciones,$recorrido;

	
	/*VARIABLES NUEVAS*/
	$rango_fechas = " AND e.GPS_DATETIME BETWEEN '".$fechaInicio."' AND '".$fechaFin."' ";

	$contador = 0;
	$recorrido = Array();
	$dias = Array();

	/*Obtiene nombre tabla HIST*/
	$table_hist	= $funciones_cv->get_table_hist($id_unidad);
	
	//echo "Rango: ".$rango_fechas." Unidad: ".$id_unidad." Hist: ".$table_hist.""<br>"";
	
	/*Obtiene el rango de fechas*/
	//$dias =	$funciones_cv->obtener_dias($rango_fechas,$id_unidad,$table_hist);
	//echo count($dias);
	//print_r($dias);

	$validacion = 0;
	$contador = 0;
	$opciones = "";
	$verificador = 0;
    $paginadorDET = 0;
	
	if(count($dias)>0){
		
                             /*EXCEL*/
                             $unidadesc = $Positions->get_data_unit($id_unidad);
                             $fechaActual = date("d-m-Y H:i:s");
                             
                    				$objPHPExcel = new PHPExcel();
                    				$objPHPExcel->getProperties()->setCreator("ALG")
                    							 				 ->setLastModifiedBy("ALG")
                    											 ->setTitle("Office 2007 XLSX")
                    								 			 ->setSubject("Office 2007 XLSX")
                    								 			 ->setDescription("Reporte de cumplimiento.")
                    								 			 ->setKeywords("office 2007 openxml php")
                    								 			 ->setCategory("Reporte");
                    				
                    				$sharedStyle1 = new PHPExcel_Style();
                    				$sharedStyle2 = new PHPExcel_Style();
                    
                    				$sharedStyle1->applyFromArray(
                    					array(  'fill' 	=> array(
                    							'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
                    							'color'	=> array('argb' => '191970')			
                    							)
                    		 			));
                    		 			
                    				$sharedStyle2->applyFromArray(
                    					array(	  
                    				         'fill' 	  => array('type'	=> PHPExcel_Style_Fill::FILL_SOLID,'color' => array('argb' => '4682B4')),
                    						 'font'     => array( 'bold' => true,'color'	=> array('argb' => 'FFFFFF'))
                     					));
                    							
                 			//$objPHPExcel->removeSheetByIndex(0);
                    		/*EXCEL*/
                        
                        
                        
                        
							/*EXCEL*/
							//$objPHPExcel->createSheet(0);
							$objPHPExcel->setActiveSheetIndex(0);
							$objPHPExcel->getActiveSheet()->setTitle('Resumen General');							
							
							$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:G1");
							$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A3:G3");
							$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(75);
				
							$objDrawing = new PHPExcel_Worksheet_Drawing();
        					$objDrawing->setPath('public/images/pepsico.jpg');;
        					$objDrawing->setCoordinates('A1');
        					$objDrawing->setHeight(100);
			  				$objDrawing->getShadow()->setVisible(true);
        					$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
					
							$objPHPExcel->getActiveSheet()->mergeCells('B1:G1');
							$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
							$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(29); 
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Reporte de Productividad');
                            

						
							$objPHPExcel->getActiveSheet()->mergeCells('D2:G2');
							$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', 'Generado el Dia : '.$fechaActual);
                            
							$objPHPExcel->getActiveSheet()->mergeCells('A2:C2');
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('A2', 'Unidad : '.$unidadesc);
										
							
							$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('A3', 'Fecha')
								->setCellValue('B3', 'Km. Recorridos')
								->setCellValue('C3', 'C. Programados')
            					->setCellValue('D3', 'C. Visitados')
                                ->setCellValue('E3', 'Bancos Vistados')
                                ->setCellValue('F3', 'Hrs. Manejo')
                                ->setCellValue('G3', 'Vel. Promedio');

							$row	= 4;	//Resumen Gral	
							/*EXCEL*/

		
		
		for($i=0; $i<count($dias);$i++){
			/*Regresa el Dia de la Semana 1 al 6*/
			$id_dia = $funciones_cv->calcula_dia($dias[$i]);
			/*Obtiene el No. Itinerario, usa Unidad y Dia*/
			$id_itn = $funciones_cv->obtener_distribucion($id_unidad,$id_dia);
            if($id_itn == ""){
                $id_itn = 0;
            }
                                    
			/*Desc Unidad*/
			$unidadesc = $Positions->get_data_unit($id_unidad);
					
				if($id_itn>0){//Si no tiene id itinerario no se hace nada

                        
                        $fecha_actual = date("Y-m-d", $i);
                        $c_programados = 0;
                        $c_visitados  = 0;
                        $b_visitados  = 0;
                        $kms_recorrido= 0;
                        $hrs_conduccion=0;
                        $vel_prom     = 0;
                        
						
                        
                        
                        
				/*DATOS DEL DETALLE*/
				/**********************************************************************************************/
				
						/*EXCEL DETAILS*/
						$paginadorDET++;
						
						$objPHPExcel->createSheet($paginadorDET);
						$objPHPExcel->setActiveSheetIndex($paginadorDET);
						$objPHPExcel->getActiveSheet()->setTitle($dias[$i]);							
						
						$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:D1");
						$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A4:D4");
						$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(75);
			
						$objDrawing = new PHPExcel_Worksheet_Drawing();
						$objDrawing->setPath('public/images/pepsico.jpg');;
						$objDrawing->setCoordinates('A1');
						$objDrawing->setHeight(100);
						$objDrawing->getShadow()->setVisible(true);
						$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
				
						$objPHPExcel->getActiveSheet()->mergeCells('B1:D1');
						$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
						$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(29); 
						$objPHPExcel->setActiveSheetIndex($paginadorDET)->setCellValue('B1', 'Reporte de Productividad');
					
						$objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
						$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						$objPHPExcel->setActiveSheetIndex($paginadorDET)->setCellValue('C2', 'Generado el Dia : '.$dias[$i]);
						
						$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
						$objPHPExcel->setActiveSheetIndex($paginadorDET)
									->setCellValue('A2', 'Unidad : '.$unidadesc);
									
						$objPHPExcel->setActiveSheetIndex($paginadorDET)
							->setCellValue('A4', 'Evento')
							->setCellValue('B4', 'Fecha')
							->setCellValue('C4', 'Velocidad')
							->setCellValue('D4', 'Ubicacion');

						$row2	= 5;	//Detalle

						/*EXCEL DETAILS*/
                        
                        

                        
                        $rango_fechas2 = " '".$dias[$i]." 00:00:00' AND '".$dias[$i]." 23:59:00' ";
                        
                        $detalle = $funciones_cv->get_res_recorrido($id_unidad,$rango_fechas2);	
                        if($detalle){
								
				            for($p=0;$p<count($detalle);$p++){
        
        					$vlat = $detalle[$p]['vplat'];
        					$vlon = $detalle[$p]['vplon'];
        					$vdate = $detalle[$p]['vpdate'];
        					$vvel = $detalle[$p]['vpvel'];
        					$veve = $detalle[$p]['vpevent'];
        					$vdireccion = $funciones_cv->direccion($vlat,$vlon);
        					$veved = $funciones_cv->evento($veve);
        					$veveDESC = $veved['DESCRIPTION'];
                                if($veveDESC == ""){
                                    $veveDESC = "Sin Evento";
                                }
                            
								if($vdireccion == ""){
									$vdireccion = "No Disponible";
								}
                                
                            $tpl->assign_block_vars('detalles',array(
    						'evento' =>$veveDESC,
    						'date' =>$vdate,
    						'vel' =>$vvel,
    						'lat' =>$vlat,
    						'lon' =>$vlon,
    						'dir' =>$vdireccion,
    						'cont' =>$verificador,
        					));
        					
        					$verificador++;
                            
                            	/*EXCEL DETAILS*/
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row2, $veveDESC);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row2, $vdate);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row2, $vvel);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row2, $vdireccion);
								$row2++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
								$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
								$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
								$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);                            
								/*EXCEL DETAILS*/
                            }
                            }
                        
                        
                        
                        
						
						
                        
                        
                        
                        
                        
						/*Amm, Obtiene los sucesos de paradas HIST de la Unidad*/
						$generate = $funciones_cv->obtener_recorrido($id_unidad,$table_hist,$opciones,$dias[$i],$id_itn);	
                        if($generate){
                            /*Visitas del ITN*/
                            $c_programados = $funciones_cv->gettotalVisitas($id_itn);
                            
                            $get_resumenc  = $funciones_cv->getVisitas_r($id_itn);//Obtiene el resumen de clientes visitados
                            if($get_resumenc!=false){
                                $c_visitados   = $get_resumenc['CLIENTES'];  
                                $b_visitados   = $get_resumenc['BANCOS'];                                
                            }
                            
                            $a_recorrido   = $funciones_cv->getRes_rec();//Pbtiene e resumen del recorrido
                            if($a_recorrido){
                                $hrs_conduccion = $a_recorrido['TIEMPO'];
                                $vel_prom       = round($a_recorrido['PROM'],2);
                                $kms_recorrido  = round($a_recorrido['DIST'],2);

                                }
                        
                               $tpl->assign_block_vars('reportes',array(
									'fecha' =>$dias[$i],
									'unidadDESC' =>$unidadesc,
									'visitasItn' =>$c_programados,
									'visitasReales' =>$c_visitados,
									'visitasBancos' =>$b_visitados,
									'porcentaje' =>$eficienciaR,
									'distrecorrida' =>$kms_recorrido,
									'hrsconducidas' =>$hrs_conduccion,
									'velpromedio' =>$vel_prom,
								));	  
                                
                               $contador++;
                               
                               /*Porcentaje de Visitas*/
                               if($contador>0){
                                    $c_visitadosciento = ($c_visitados/$c_programados)*100;
                                    $c_visitadoscientoR = $funciones_cv->redondeado ($c_visitadosciento, 1);
                               }
  
								/*EXCEL*/
								$objPHPExcel->setActiveSheetIndex(0);
	
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $dias[$i]);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $kms_recorrido." Km/h");
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $c_programados);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row,	$c_visitados);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row,	$b_visitados);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row,	$hrs_conduccion." hrs");
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row,	$vel_prom." Km/h");
								$row++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
								$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
								$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
								//$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(100);

                                //Se Introdujeron aqui pero forman parte de EXCEL DETAILS
                                $objPHPExcel->setActiveSheetIndex($paginadorDET);
                                
                                $objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
								$objPHPExcel->setActiveSheetIndex($paginadorDET)->setCellValue('A3', 'Visitas Programadas : '.$c_programados);
                                
                                $objPHPExcel->setActiveSheetIndex($paginadorDET)->setCellValue('C3', 'Visitas Totales : '.$c_visitados);
								
								$eficienciaR = $funciones_cv->redondeado($eficiencia,2);
								$objPHPExcel->setActiveSheetIndex($paginadorDET)->setCellValue('D3', 'Porcentaje de Cumplimiento : '.$c_visitadoscientoR.' %');
								
                                $objPHPExcel->setActiveSheetIndex(0);
								/*EXCEL*/
                        
                }//Fin Recorrido        

			}//Fin Itinerario
                
                
                
                











				if($id_itn==0){//Si no tiene id itinerario no se hace nada

                        
                        $fecha_actual = date("Y-m-d", $i);
                        $c_programados = 0;
                        $c_visitados  = 0;
                        $b_visitados  = 0;
                        $kms_recorrido= 0;
                        $hrs_conduccion=0;
                        $vel_prom     = 0;
                        
						
                        
                        
                        
				/*DATOS DEL DETALLE*/
				/**********************************************************************************************/
				
						/*EXCEL DETAILS*/
						$paginadorDET++;
						
						$objPHPExcel->createSheet($paginadorDET);
						$objPHPExcel->setActiveSheetIndex($paginadorDET);
						$objPHPExcel->getActiveSheet()->setTitle($dias[$i]);							
						
						$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:D1");
						$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A4:D4");
						$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(75);
			
						$objDrawing = new PHPExcel_Worksheet_Drawing();
						$objDrawing->setPath('public/images/pepsico.jpg');;
						$objDrawing->setCoordinates('A1');
						$objDrawing->setHeight(100);
						$objDrawing->getShadow()->setVisible(true);
						$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
				
						$objPHPExcel->getActiveSheet()->mergeCells('B1:D1');
						$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
						$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(29); 
						$objPHPExcel->setActiveSheetIndex($paginadorDET)->setCellValue('B1', 'Reporte de Productividad');
					
						$objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
						$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						$objPHPExcel->setActiveSheetIndex($paginadorDET)->setCellValue('C2', 'Generado el Dia : '.$dias[$i]);
						
						$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
						$objPHPExcel->setActiveSheetIndex($paginadorDET)
									->setCellValue('A2', 'Unidad : '.$unidadesc);
									
						$objPHPExcel->setActiveSheetIndex($paginadorDET)
							->setCellValue('A4', 'Evento')
							->setCellValue('B4', 'Fecha')
							->setCellValue('C4', 'Velocidad')
							->setCellValue('D4', 'Ubicacion');

						$row2	= 5;	//Detalle

						/*EXCEL DETAILS*/
                        
                        

                        
                        $rango_fechas2 = " '".$dias[$i]." 00:00:00' AND '".$dias[$i]." 23:59:00' ";
                        
                        $detalle = $funciones_cv->get_res_recorrido($id_unidad,$rango_fechas2);	
                        if($detalle){
								
				            for($p=0;$p<count($detalle);$p++){
        
        					$vlat = $detalle[$p]['vplat'];
        					$vlon = $detalle[$p]['vplon'];
        					$vdate = $detalle[$p]['vpdate'];
        					$vvel = $detalle[$p]['vpvel'];
        					$veve = $detalle[$p]['vpevent'];
        					$vdireccion = $funciones_cv->direccion($vlat,$vlon);
        					$veved = $funciones_cv->evento($veve);
        					$veveDESC = $veved['DESCRIPTION'];
                                if($veveDESC == ""){
                                    $veveDESC = "Sin Evento";
                                }
                            
								if($vdireccion == ""){
									$vdireccion = "No Disponible";
								}
                                
                            $tpl->assign_block_vars('detalles',array(
    						'evento' =>$veveDESC,
    						'date' =>$vdate,
    						'vel' =>$vvel,
    						'lat' =>$vlat,
    						'lon' =>$vlon,
    						'dir' =>$vdireccion,
    						'cont' =>$verificador,
        					));
        					
        					$verificador++;
                            
                            	/*EXCEL DETAILS*/
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row2, $veveDESC);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row2, $vdate);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row2, $vvel);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row2, $vdireccion);
								$row2++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
								$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
								$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
								$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);                            
								/*EXCEL DETAILS*/
                            }
                            }
                        
                        
                        
                        
						
						
                        
                        
                        
                        
                        
						/*Amm, Obtiene los sucesos de paradas HIST de la Unidad*/
						$generate = $funciones_cv->obtener_recorrido($id_unidad,$table_hist,$opciones,$dias[$i],$id_itn);	
                        if($generate){
                            /*Visitas del ITN*/
                            $c_programados = $funciones_cv->gettotalVisitas($id_itn);
                            
                            $get_resumenc  = $funciones_cv->getVisitas_r($id_itn);//Obtiene el resumen de clientes visitados
                            if($get_resumenc!=false){
                                $c_visitados   = $get_resumenc['CLIENTES'];  
                                $b_visitados   = $get_resumenc['BANCOS'];                                
                            }
                            
                            $a_recorrido   = $funciones_cv->getRes_rec();//Pbtiene e resumen del recorrido
                            if($a_recorrido){
                                $hrs_conduccion = $a_recorrido['TIEMPO'];
                                $vel_prom       = round($a_recorrido['PROM'],2);
                                $kms_recorrido  = round($a_recorrido['DIST'],2);

                                }
                        
                               $tpl->assign_block_vars('reportes',array(
									'fecha' =>$dias[$i],
									'unidadDESC' =>$unidadesc,
									'visitasItn' =>$c_programados,
									'visitasReales' =>$c_visitados,
									'visitasBancos' =>$b_visitados,
									'porcentaje' =>$eficienciaR,
									'distrecorrida' =>$kms_recorrido,
									'hrsconducidas' =>$hrs_conduccion,
									'velpromedio' =>$vel_prom,
								));	  
                                
                               $contador++;
                               
                               /*Porcentaje de Visitas*/
                               if($contador>0){
                                    $c_visitadosciento = ($c_visitados/$c_programados)*100;
                                    $c_visitadoscientoR = $funciones_cv->redondeado ($c_visitadosciento, 1);
                               }
  
								/*EXCEL*/
								$objPHPExcel->setActiveSheetIndex(0);
	
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $dias[$i]);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $kms_recorrido." Km/h");
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, 0);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row,	0);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row,	0);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row,	$hrs_conduccion." hrs");
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row,	$vel_prom." Km/h");
								$row++;
								
								$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
								$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
								$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
								//$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(100);

                                //Se Introdujeron aqui pero forman parte de EXCEL DETAILS
                                $objPHPExcel->setActiveSheetIndex($paginadorDET);
                                
                                $objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
								$objPHPExcel->setActiveSheetIndex($paginadorDET)->setCellValue('A3', 'Visitas Programadas : 0');
                                
                                $objPHPExcel->setActiveSheetIndex($paginadorDET)->setCellValue('C3', 'Visitas Totales : 0');
								
								$eficienciaR = $funciones_cv->redondeado($eficiencia,2);
								$objPHPExcel->setActiveSheetIndex($paginadorDET)->setCellValue('D3', 'Porcentaje de Cumplimiento : 0%');
								
                                $objPHPExcel->setActiveSheetIndex(0);
								/*EXCEL*/
                        
                }//Fin Recorrido        

			}//Fin Itinerario









                
                
                
                
                
                
                
                	
				
		}//FOR
			if($contador>0){
				//$tpl->set_filenames(array('mGet_Report'=>'tGet_Report'));
				//$tpl->pparse('mGet_Report');
				$filename  = "RepProductividad_".$unidad.'_'.date("His_Ymd").".xlsx";	
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="'.$filename.'"');
				header('Cache-Control: max-age=0');			
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				//$objWriter->save('tmp/'.$filename); //Guardar
				$objWriter->save('php://output');  //Ver
			}else{
				return 0;
			}
			
	}else{
		return 0;
	}
				







?>