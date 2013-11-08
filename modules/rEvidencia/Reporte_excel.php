<?php

//reporte_unidad_excel();
$userData = new usersAdministration();
	//	function reporte_unidad_excel(){
		 //	global $db,$funciones,$excel,$path_config,;	
	
	        $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
			$db ->sqlQuery("SET NAMES 'utf8'");
		   
		    $arreglo = array();
		   
		    $contax = -1;
		 
		  //  $fecha_inicio = '2012-06-15';
		  //  $fecha_final =  '2012-06-15';
		 //   
		//	$id_usuarios = '43,45';
		   // $eventos   = $_GET['cuestionario'];
          //  $eventos   = '0';
		 
		 
             $fecha_inicio = $_GET['f1'];
		     $fecha_final  = $_GET['f2'];
			 $rango_texto  = $_GET['f1'].' al '.$_GET['f2'];
			 $id_usuarios  = $_GET['usuarios'];
			 $eventos      = $_GET['cuestionario'];
		     $complex = '';
		  
		   if($eventos!='0'){
		   	  $complex ='AND e.ID_CUESTIONARIO IN ('.$eventos.')';
		   }else{
		   	  $complex ='';
		   }
		

			
			$user_x ="SELECT COD_USER,USER_NAME, USER_EMAIL FROM SAVL1100 WHERE COD_USER IN (".$id_usuarios.");";
			$query_user_x 	= $db->sqlQuery($user_x);
		   
			while($row_x = $db->sqlFetchArray($query_user_x)){
				$contax = $contax +1;
			     $arreglo[$contax][0] = $row_x['COD_USER'];
			     $arreglo[$contax][1] = $row_x['USER_NAME'];
			     $arreglo[$contax][2] = $row_x['USER_EMAIL'];
			}
			
			
			$usuarios = explode(",",$id_usuarios);
			  
 				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator("ALG")
							 			 ->setLastModifiedBy("ALG")
										 ->setTitle("Office 2007 XLSX")
							 			 ->setSubject("Office 2007 XLSX")
							 			 ->setDescription("Reporte Unidades en Movimiento.")
							 			 ->setKeywords("office 2007 openxml php")
							 			 ->setCategory("Reporte Velocidad");

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
						 'font'       => array( 'bold' => true,'color'	=> array('argb' => 'FFFFFF'))
 					));
				
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->setTitle('Reporte de Cuestionarios');							
							
				$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:D1");
				$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A4:D4");
				$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(50);
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
			/*	$objDrawing = new PHPExcel_Worksheet_Drawing();
        		$objDrawing->setPath($path_config.'pepsico.jpg');;
        		$objDrawing->setCoordinates('A1');
        		$objDrawing->setHeight(100);
			  	$objDrawing->getShadow()->setVisible(true);
        		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet(0));*/
					
				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(29); 
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Cuestionarios');
			
				// $unidad    	  = '12345';
				
				//$unidad    	  = $funciones->get_data_unit($id_unidad);					
			    //$flotas       = $this->get_data_fleet($id_unidad);
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Fechas : '.$rango_texto);
				
				$objPHPExcel->getActiveSheet()->mergeCells('A4:B4');
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->mergeCells('C4:D4');
				$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);					
				$objPHPExcel->setActiveSheetIndex(0)
				            ->setCellValue('A4', 'Usuario')  
							->setCellValue('C4', 'Cuestionario');
            							
   				
   				$row 				= 5;
				$velocidad 			= 0;
				$cnt 	   			= 0;	
				$tiempo_acumulado 	= 0;
				$max_velocidad 		= 0;
		        $hrs_conduccion     = 0;
			  	
			  
				for($i2=0;$i2<count($arreglo);$i2++){
				   
				$tot_evi =  tot_evidencias($arreglo[$i2][0]);  	
					if($tot_evi>0){	   	
							$objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);		
							$objPHPExcel->getActiveSheet()->mergeCells('C'.$row.':D'.$row);		
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $userData->codif($arreglo[$i2][1]));	  
			                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row,'');
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $tot_evi.' Cuestionario(s) Generado(s)');
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, '');
						$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
						$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);					
							$row++;
					     
							       $objWorkSheet = $objPHPExcel->createSheet(($i2+1)); //Setting index when creating
			                        
								
							       $objWorkSheet->setCellValue('A1', 'CUESTIONARIO')
														->setCellValue('B1', 'PREGUNTA')
							            				->setCellValue('C1', 'RESPUESTA')	
							         				    ->setCellValue('D1', 'FECHA DE ENVIO');
							      	$objWorkSheet->setSharedStyle($sharedStyle2, "A1:D1");    
								    				
						
						//----------------------------------------------------------------------------													
			   				   
						  	    $arre = preguntas($arreglo[$i2][0]);
							   	$row2 				= 2;
							   	$row3 				= 2;
								$velocidad 			= 0;
								$cnt 	   			= 1;	
								$tiempo_acumulado 	= 0;
								$max_velocidad 		= 0;       
									
							for($i=0;$i<count($arre);$i++){	
								
							//	if($this->recorrido[$i]['vel']>0){
								   // echo " ".$this->recorrido[$i]['lat'].",".$this->recorrido[$i]['lon']."-------------------";
								//	$direccion = $funciones->direccion($this->recorrido[$i]['lat'],$this->recorrido[$i]['lon']);						
									
									//$evento = ($this->recorrido[$i]['evt'] != "") ? $this->recorrido[$i]['evt'] : "Sin Evento";						
									
									$hola = dame_res($arre[$i][3]);
									$objWorkSheet->setCellValueByColumnAndRow(0, ($row3), $arre[$i][1]);
									$objWorkSheet->setCellValueByColumnAndRow(3, ($row3), $arre[$i][2]);
									$cachito = '';	  
									for($l=0;$l<count($hola);$l++){
									   // $objWorkSheet->setCellValueByColumnAndRow(0, $row3, $arre[$i][1]);
									  	$objWorkSheet->setCellValueByColumnAndRow(1, $row3, $userData->codif($hola[$l][0]));
									  	$jpg = buscarCadena(utf8_decode($hola[$l][1]),'jpg');
									  	
									  if($jpg==1){
									  	$cachito = explode("/",utf8_decode($hola[$l][1]));
									  	$cachitox = $cachito[3];
									  	 $objWorkSheet->setCellValueByColumnAndRow(2, $row3, $cachitox);
                                        $objWorkSheet->getCell("C".$row3)
													 ->getHyperlink()
													 ->setUrl("http://movilidad.2gps.net/public/evidencia/".$cachitox);
                                         
									  }	else{
								  	    $objWorkSheet->setCellValueByColumnAndRow(2, $row3, $userData->codif($hola[$l][1]));	
									  }
									   
									   // $objWorkSheet->setCellValueByColumnAndRow(3, $row3, $row3);	
									    $row3= $row3+1;
									  
									}   
								  
 
									   // $objWorkSheet->setCellValueByColumnAndRow(4, $row3, $row3);	
									   // $objWorkSheet->insertNewRowBefore($row3, 1);
									    //$objWorkSheet->insertNewRowBefore($row3, 1);	
							           // ;
			                        //$k = $row3;
								//}	//---------------------		
							}		
							          
							
							
							//----------------------------------------------------------------------------				
									    // Rename sheet
									    $objWorkSheet->setTitle($arreglo[$i2][1]);
									   
									    $objWorkSheet->getColumnDimension('A')->setAutoSize(true);
					        			$objWorkSheet->getColumnDimension('B')->setAutoSize(true);
					        			$objWorkSheet->getColumnDimension('C')->setAutoSize(true);
				        				$objWorkSheet->getColumnDimension('D')->setAutoSize(true);
						}
				}
			
			
			    //	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        		//	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        		//	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        		//	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);				
				//    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);	
				//    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);	
				    
				    $objPHPExcel->getActiveSheet()->setTitle('Reporte de Cuestionarios');			
					$objPHPExcel->setActiveSheetIndex(0);
					
					//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				
					
						$filename  = "Rep_evidencias_".date("His_Ymd").".xlsx";
						header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
						header('Content-Disposition: attachment;filename="'.$filename.'"');
						header('Cache-Control: max-age=0');			
						
						/*Guardar*/
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
						
						$objWriter->save('php://output');
			
	//	}




//---------------  funciones 

function tot_evidencias($usr){
	global $db,$fecha_inicio,$fecha_final,$complex;	

$user_x ="SELECT h.BATTERY,g.COD_HISTORY,f.DESCRIPCION , e.FECHA , IF(e.LATITUD IS NULL,19.519397 ,e.LATITUD) AS LAT, IF(e.LONGITUD IS NULL,-99.234288,e.LONGITUD) AS LON, e.ID_RES_CUESTIONARIO 
				FROM CRM2_RESPUESTAS e 
				INNER JOIN CRM2_CUESTIONARIOS f ON e.ID_CUESTIONARIO = f.ID_CUESTIONARIO 
				INNER JOIN CRM2_RESPUESTAS_HISTORICO g ON e.ID_RES_CUESTIONARIO = g.ID_RES_CUESTIONARIO 
				INNER JOIN HIST00000 h ON g.COD_HISTORY = h.COD_HISTORY
							WHERE e.COD_USER = ".$usr." 
								AND CAST(e.FECHA AS DATE) BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'
								".$complex."
							    ORDER BY e.FECHA DESC";
	$query_user_x 	= $db->sqlQuery($user_x);
	$count_c= $db->sqlEnumRows($query_user_x);	
	//$row_x = $db->sqlFetchArray($query_user_x);
	return $count_c;

}

//---------------------- CREAR BASE DE PREGUNTAS

function preguntas($usr){
	 
	global $db,$fecha_inicio,$fecha_final,$complex;
	$arreglo2 = array();
	$contador = -1;	
   
	$user_x ="SELECT h.BATTERY,g.COD_HISTORY,f.DESCRIPCION , e.FECHA , IF(e.LATITUD IS NULL,19.519397 ,e.LATITUD) AS LAT, IF(e.LONGITUD IS NULL,-99.234288,e.LONGITUD) AS LON, e.ID_RES_CUESTIONARIO 
				FROM CRM2_RESPUESTAS e 
				INNER JOIN CRM2_CUESTIONARIOS f ON e.ID_CUESTIONARIO = f.ID_CUESTIONARIO 
				INNER JOIN CRM2_RESPUESTAS_HISTORICO g ON e.ID_RES_CUESTIONARIO = g.ID_RES_CUESTIONARIO 
				INNER JOIN HIST00000 h ON g.COD_HISTORY = h.COD_HISTORY
							WHERE e.COD_USER = ".$usr." 
								AND CAST(e.FECHA AS DATE) BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'
								".$complex."
							    ORDER BY e.FECHA DESC";
				
				
	    $query_user_x 	= $db->sqlQuery($user_x);	
	    
		while($rowx = $db->sqlFetchArray($query_user_x)){
			$contador = $contador+1;
			$arreglo2[$contador][0]=$rowx['BATTERY'];
			$arreglo2[$contador][1]=$rowx['DESCRIPCION'];
			$arreglo2[$contador][2]=$rowx['FECHA'];
			$arreglo2[$contador][3]=$rowx['ID_RES_CUESTIONARIO'];
		 
		}
	return $arreglo2;
	
}

function dame_res($res){
		global $db;
		$arreglo3 = array();
		$contador = -1;
		
$user_x ="SELECT f.ID_TIPO, f.DESCRIPCION AS PREGUNTA, e.RESPUESTA
				FROM CRM2_PREG_RES e
				INNER JOIN CRM2_PREGUNTAS f ON e.ID_PREGUNTA = f.ID_PREGUNTA
				WHERE ID_RES_CUESTIONARIO = ".$res;
           $query_user_x 	= $db->sqlQuery($user_x);	
 
 	while($rowx = $db->sqlFetchArray($query_user_x)){
			$contador = $contador+1;
			$arreglo3[$contador][0]=$rowx['PREGUNTA'];
			$arreglo3[$contador][1]=$rowx['RESPUESTA'];
		}
	return $arreglo3;
 
 //$row_x = $db->sqlFetchArray($query_user_x);
 //return $row_x['PREGUNTA'].'|'.$row_x['RESPUESTA'];	

}

//------------------------------------------

 function buscarCadena($cadena,$palabra){
        if (strstr($cadena,$palabra))
            return 1;
        else
            return 0;
    }

?>