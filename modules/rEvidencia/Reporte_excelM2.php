<?php

//reporte_unidad_excel();
$userData = new usersAdministration();
	//	function reporte_unidad_excel(){
		 //	global $db,$funciones,$excel,$path_config,;	
	
	        $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
		   
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
		

			
			/*$user_x ="SELECT COD_USER,USER_NAME, USER_EMAIL FROM SAVL1100 WHERE COD_USER IN (".$id_usuarios.");";
			$query_user_x 	= $db->sqlQuery($user_x);
		   
			while($row_x = $db->sqlFetchArray($query_user_x)){
				$contax = $contax +1;
			     $arreglo[$contax][0] = $row_x['COD_USER'];
			     $arreglo[$contax][1] = $row_x['USER_NAME'];
			     $arreglo[$contax][2] = $row_x['USER_EMAIL'];
			}
			
			
			$usuarios = explode(",",$id_usuarios);*/
			  
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
					$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						   $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);					
							$row++;
							
		 	//-----------------------------------------------------  inicio de pestañas	
		 	    
		 	  $objWorkSheet = $objPHPExcel->createSheet(($i2+1)); //Setting index when creating
	    	  
			    
			  
							       
	 	      $arre_preg= cuestionarios_x($arreglo[$i2][0]);  // preguntas (forma la cabecera)
			  $arre = preguntas($arreglo[$i2][0]);            // preguntas y respuestas (forma el cuerpo del excel)
			  
      $abc = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
	               'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
	               'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
                   'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ',
				   'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ',
				   'EA','EB','EC','ED','EE','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU','EV','EW','EX','EY','EZ',
				   'FA','FB','FC','FD','FE','FF','FG','FH','FI','FJ','FK','FL','FM','FN','FO','FP','FQ','FR','FS','FT','FU','FV','FW','FX','FY','FZ',
				   'GA','GB','GC','GD','GE','GF','GG','GH','GI','GJ','GK','GL','GM','GN','GO','GP','GQ','GR','GS','GT','GU','GV','GW','GX','GY','GZ',
	               'HA','HB','HC','HD','HE','HF','HG','HH','HI','HJ','HK','HL','HM','HN','HO','HP','HQ','HR','HS','HT','HU','HV','HW','HX','HY','HZ',
	               'IA','IB','IC','ID','IE','IF','IG','IH','II','IJ','IK','IL','IM','IN','IO','IP','IQ','IR','IS','IT','IU','IV','IW','IX','IY','IZ',
	               'JA','JB','JC','JD','JE','JF','JG','JH','JI','JJ','JK','JL','JM','JN','JO','JP','JQ','JR','JS','JT','JU','JV','JW','JX','JY','JZ',
	               'KA','KB','KC','KD','KE','KF','KG','KH','KI','KJ','KK','KL','KM','KN','KO','KP','KQ','KR','KS','KT','KU','KV','KW','KX','KY','KZ',
	               'LA','LB','LC','LD','LE','LF','LG','LH','LI','LJ','LK','LL','LM','LN','LO','LP','LQ','LR','LS','LT','LU','LV','LW','LX','LY','LZ',
	               'MA','MB','MC','MD','ME','MF','MG','MH','MI','MJ','MK','ML','MM','MN','MO','MP','MQ','MR','MS','MT','MU','MV','MW','MX','MY','MZ',
	               'NA','NB','NC','ND','NE','NF','NG','NH','NI','NJ','NK','NL','NM','NN','NO','NP','NQ','NR','NS','NT','NU','NV','NW','NX','NY','NZ',
	               'OA','OB','OC','OD','OE','OF','OG','OH','OI','OJ','OK','OL','OM','ON','OO','OP','OQ','OR','OS','OT','OU','OV','OW','OX','OY','OZ',
	               'PA','PB','PC','PD','PE','PF','PG','PH','PI','PJ','PK','PL','PM','PN','PO','PP','PQ','PR','PS','PT','PU','PV','PW','PX','PY','PZ',
	               'QA','QB','QC','QD','QE','QF','QG','QH','QI','QJ','QK','QL','QM','QN','QO','QP','QQ','QR','QS','QT','QU','QV','QW','QX','QY','QZ',
				   'RA','RB','RC','RD','RE','RF','RG','RH','RI','RJ','RK','RL','RM','RN','RO','RP','RQ','RR','RS','RT','RU','RV','RW','RX','RY','RZ',
				   'SA','SB','SC','SD','SE','SF','SG','SH','SI','SJ','SK','SL','SM','SN','SO','SP','SQ','SR','SS','ST','SU','SV','SW','SX','SY','SZ',
				   'TA','TB','TC','TD','TE','TF','TG','TH','TI','TJ','TK','TL','TM','TN','TO','TP','TQ','TR','TS','TT','TU','TV','TW','TX','TY','TZ',
				   'UA','UB','UC','UD','UE','UF','UG','UH','UI','UJ','UK','UL','UM','UN','UO','UP','UQ','UR','US','UT','UU','UV','UW','UX','UY','UZ',
				   'VA','VB','VC','VD','VE','VF','VG','VH','VI','VJ','VK','VL','VM','VN','VO','VP','VQ','VR','VS','VT','VU','VV','VW','VX','VY','VZ',
				   'WA','WB','WC','WD','WE','WF','WG','WH','WI','WJ','WK','WL','WM','WN','WO','WP','WQ','WR','WS','WT','WU','WV','WW','WX','WY','WZ',
                   'XA','XB','XC','XD','XE','XF','XG','XH','XI','XJ','XK','XL','XM','XN','XO','XP','XQ','XR','XS','XT','XU','XV','XW','XX','XY','XZ',
                   'YA','YB','YC','YD','YE','YF','YG','YH','YI','YJ','YK','YL','YM','YN','YO','YP','YQ','YR','YS','YT','YU','YV','YW','YX','YY','YZ',
                   'ZA','ZB','ZC','ZD','ZE','ZF','ZG','ZH','ZI','ZJ','ZK','ZL','ZM','ZN','ZO','ZP','ZQ','ZR','ZS','ZT','ZU','ZV','ZW','ZX','ZY','ZZ'
		           );	                        
									$objWorkSheet->setCellValueByColumnAndRow(0, 1, 'FECHA');						        //
							        for($l=0;$l<count($arre_preg);$l++){
							       //  $objWorkSheet->setCellValue($abc[$l].'1',  $userData->codif($arre_preg[$l]));
							         $objWorkSheet->setCellValueByColumnAndRow($l+1,1, $userData->codif($arre_preg[$l]));
							 	    }
							 	    $objWorkSheet->setCellValueByColumnAndRow(count($arre_preg)+1, 1, 'Posicion');
	                          	   // $objWorkSheet->setCellValue(3, ($row3), $arre[$i][2]);
                                    
							      	$objWorkSheet->setSharedStyle($sharedStyle2, "A1:".$abc[count($arre_preg)+1].'1');    
								  
								  
											
															    
									$row3 = 2;
									
										
										for($i=0;$i<count($arre);$i++){	
												$hola = dame_res($arre[$i][3],$arre[$i][4]);
													for($l3=0;$l3<count($hola);$l3++){
														$objWorkSheet->setCellValueByColumnAndRow(0, ($row3), $arre[$i][2]);	
														$objWorkSheet->getRowDimension($row3)->setRowHeight(70);
														$jpg = buscarCadena(utf8_decode($hola[$l3][1]),'jpg');
														  if($jpg==1){
														  	$cachito = explode("/",utf8_decode($hola[$l3][1]));
														  	$cachitox = $cachito[3];
														 					/*Area para colocar una imagen en la celde A1*/
			 									    $objDrawing = new PHPExcel_Worksheet_Drawing();
													$objDrawing->setPath('public/evidencia/'.$cachitox);
											       	$objDrawing->setCoordinates($abc[$l3+1].$row3);
											       	$objDrawing->setResizeProportional(false);
											    	$objDrawing->setHeight(90);
											    	$objDrawing->setWidth(145);
												  //	$objDrawing->getShadow()->setVisible(true);
												   	$objDrawing->setWorksheet($objWorkSheet);
								// $objWorkSheet->setCellValueByColumnAndRow($l3+1, $row3, "http://movilidad.2gps.net/public/evidencia/".$cachitox);
			 	                                            
 
														      
														   
														    //  $objWorkSheet->getCell("C".$row3)
															//			     ->getHyperlink()
														    //				 ->setUrl("http://movilidad.2gps.net/public/evidencia/".$cachitox);
					                                         $objWorkSheet->getCell($abc[$l3+1].$row3)
																		     ->getHyperlink()
														    				 ->setUrl("http://movilidad.2gps.net/public/evidencia/".$cachitox);																		                                         
														  }else{
						
					  $objWorkSheet->setCellValueByColumnAndRow($l3+1, $row3, $userData->codif($hola[$l3][1]));								   					  
														  }
														$direccion = $Positions->direccion($hola[$l3][3], $hola[$l3][4]);
  
														  if(($l3+1) == count($hola)){
															if(count($hola)<count($arre_preg)){
														     $objWorkSheet->setCellValueByColumnAndRow((count($arre_preg)+1), $row3, $direccion);
					                                         $objWorkSheet->getCell($abc[(count($arre_preg)+1)].$row3)
																		  ->getHyperlink()
														    			  ->setUrl($hola[$l3][2]);
																
															}else{
															 $objWorkSheet->setCellValueByColumnAndRow((count($hola)+1), $row3, $direccion);
					                                         $objWorkSheet->getCell($abc[(count($hola)+1)].$row3)
																		  ->getHyperlink()
														    			  ->setUrl($hola[$l3][2]);	
																
															}		
	      												 }
													}
													 $row3= $row3+1;
													
										}
									
													
						
		//--------------------------------------  PINTAR RESPUESTAS	
						
						
																		
			   		/*		   
						  	    $arre = preguntas($arreglo[$i2][0]);
							   	$row2 				= 2;
							   	$row3 				= 2;
								$velocidad 			= 0;
								$cnt 	   			= 1;	
								$tiempo_acumulado 	= 0;
								$max_velocidad 		= 0;       
									
							for($i=0;$i<count($arre);$i++){	
								
											
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
									   
									    $row3= $row3+1;
									  
									}   
								  
 
							}		
							          
						*/	
							
							//----------------------------------------------  Rename sheet
									    $objWorkSheet->setTitle($arreglo[$i2][1]);
									   
									  /*  $objWorkSheet->getColumnDimension('A')->setAutoSize(true);
					        			$objWorkSheet->getColumnDimension('B')->setAutoSize(true);
					        			$objWorkSheet->getColumnDimension('C')->setAutoSize(true);
				        				$objWorkSheet->getColumnDimension('D')->setAutoSize(true);*/
				        		   for($l2=0;$l2<count($arre_preg);$l2++){
							          // $objWorkSheet->setCellValueByColumnAndRow($l+1,1, $userData->codif($arre_preg[$l]));
							           $objWorkSheet->getColumnDimension($abc[$l2])->setAutoSize(true);
							 	    }
							 	   $objWorkSheet->getColumnDimension($abc[count($arre_preg)+1])->setAutoSize(50);  
						}
				}
			
		//-----------------------------------------------------  fin de pestañas	  	

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

function cuestionarios_x($usr){
	 
	global $db,$fecha_inicio,$fecha_final,$complex;
	$arreglo2 = array();
	$contador = -1;	
   
	$user_x ="SELECT A.* FROM CRM2_PREGUNTAS A INNER JOIN CRM2_CUESTIONARIO_PREGUNTAS e ON A.ID_PREGUNTA = e.ID_PREGUNTA 
	          WHERE 1 " .$complex. " ORDER BY e.ORDEN";
				
				
	    $query_user_x 	= $db->sqlQuery($user_x);	
	    
		while($rowx = $db->sqlFetchArray($query_user_x)){
			$contador = $contador+1;
			$arreglo2[$contador]=$rowx['DESCRIPCION'];

		 
		}
	return $arreglo2;
	
}
//---------------------- CREAR BASE DE PREGUNTAS

function preguntas($usr){
	 
	global $db,$fecha_inicio,$fecha_final,$complex;
	$arreglo2 = array();
	$contador = -1;	
   
	$user_x ="SELECT h.BATTERY,g.COD_HISTORY,f.DESCRIPCION , e.FECHA , IF(e.LATITUD IS NULL,19.519397 ,e.LATITUD) AS LAT, IF(e.LONGITUD IS NULL,-99.234288,e.LONGITUD) AS LON, e.ID_RES_CUESTIONARIO,f.ID_CUESTIONARIO 
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
		    $arreglo2[$contador][4]=$rowx['ID_CUESTIONARIO'];
		}
	return $arreglo2;
	
}

function dame_res($res,$cuestionario){
		global $db;
		$arreglo3 = array();
		$contador = -1;
		
		
/*		
$user_x ="SELECT f.ID_TIPO, f.DESCRIPCION AS PREGUNTA, e.RESPUESTA
				FROM CRM2_PREG_RES e
				INNER JOIN CRM2_PREGUNTAS f ON e.ID_PREGUNTA = f.ID_PREGUNTA
				WHERE ID_RES_CUESTIONARIO = ".$res;*/
				
$user_x ="SELECT f.ID_TIPO, f.DESCRIPCION AS PREGUNTA, e.RESPUESTA,e.ID_PREGUNTA,g.ORDEN,IF(h.LATITUD IS NULL,19.519397 ,h.LATITUD) AS LAT, IF(h.LONGITUD IS NULL,-99.234288,h.LONGITUD) AS LON							    
				FROM CRM2_PREG_RES e
				INNER JOIN CRM2_PREGUNTAS f ON e.ID_PREGUNTA = f.ID_PREGUNTA
				INNER JOIN CRM2_CUESTIONARIO_PREGUNTAS g ON e.ID_PREGUNTA = g.ID_PREGUNTA
				INNER JOIN CRM2_RESPUESTAS h ON  h.ID_RES_CUESTIONARIO = e.ID_RES_CUESTIONARIO
				WHERE e.ID_RES_CUESTIONARIO =".$res." AND g.ID_CUESTIONARIO IN (".$cuestionario.") ORDER BY g.ORDEN";	
				
           $query_user_x 	= $db->sqlQuery($user_x);	
 
 	while($rowx = $db->sqlFetchArray($query_user_x)){
			$contador = $contador+1;
			$arreglo3[$contador][0]=$rowx['PREGUNTA'];
			$arreglo3[$contador][1]=$rowx['RESPUESTA'];
			$arreglo3[$contador][2]='https://maps.google.com.mx/maps?q='.$rowx['LAT'].','.$rowx['LON'];
			$arreglo3[$contador][3]= $rowx['LAT'];
			$arreglo3[$contador][4]= $rowx['LON'];	
		}
	return $arreglo3;
 
 //$row_x = $db->sqlFetchArray($query_user_x);
 //return $row_x['PREGUNTA'].'|'.$row_x['RESPUESTA'];	

}

function dame_preguntas_2($res){
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
			$arreglo3[$contador]=$rowx['PREGUNTA'];
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