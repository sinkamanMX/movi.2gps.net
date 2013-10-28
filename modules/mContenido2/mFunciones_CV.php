<?php
/** * 
 *  @package             Consola web
 *  @name                
 *  @version             1.1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          25-03-2011
**/
class mFunciones_CV{
	public $array_geos;
    public $recorrido;
    public $recorrido_2;
    
	/*Funcion para Obtener fecha inicial y final por medio del no de semana*/
	function WeekToDate ($week, $year){
		$Jan1 = mktime (1, 1, 1, 1, 1, $year);
		$iYearFirstWeekNum = (int) strftime("%W",mktime (1, 1, 1, 1, 1, $year));

		if ($iYearFirstWeekNum == 1){
			$week = $week - 1;
		}

		$weekdayJan1 = date ('w', $Jan1);
		$FirstMonday = strtotime(((4-$weekdayJan1)%7-3) . ' days', $Jan1);
		$CurrentMondayTS = strtotime(($week) . ' weeks', $FirstMonday);
		return ($CurrentMondayTS);
	} 
	
	/*Funcion que calcula la diferencia de tiempo entre una fecha y otra*/
	function diferencia_tiempo($fecha_inicial, $fecha_final){
		global $db;
    	$result = '00:00:00';
		$sql_dif = "SELECT ABS(TIMESTAMPDIFF(SECOND,'".$fecha_inicial."','".$fecha_final."')) AS DIFERENCIA;";
		if ($query_dif = $db->sqlQuery($sql_dif)){
	  		$row_dif   = $db->sqlFetchArray($query_dif);
	  		$result    = $row_dif['DIFERENCIA'];
	  		$db->sqlFreeResult($query_dif);
    	}
		return $result;
  	}
	
	/*Funcion para convertir segundos a horas*/  
	function convierte_horas($seg){
		$hours     = floor($seg / 3600);
  		$minutes   = floor($seg % 3600 / 60);
    	$seconds   = $seg % 60;
		$min_trans = sprintf("%d:%02d", $hours, $minutes); 
		return $min_trans;	 
	}
	
	
	
	
	/*Funcion que actualiza la fecha de salida, asi como los segundos que esta la unidad en el geo punto*/
	function aumenta_segundos($idres,$segs,$nametable,$date,$lat,$lon){
		global $db,$dbf;
		$data = array(
			'SEG'			=> $segs,
			'GPS_SALIDA'    => $date,
			'latitud' 		=> $lat,
			'longitud'		=> $lon,
		);
		$where = "ID_RESUMEN = ".$idres;
		if($dbf-> updateDB($nametable,$data,$where)){
			return true;	
		}else{
				return true;
		}
	}
	

	
	/*Determina el numero de semana para ver la ruta a la que pertenece*/
	function calcula_dia($fecha){		
		$dia	= substr($fecha,8,2);
		$mes	= substr($fecha,5,2);
		$anio	= substr($fecha,0,4);
		return date("w",mktime(0,0,0,$mes,$dia,$anio));		
	}	

	/*Funcion que calcula la distancia entre dos puntos*/
	function distancia_entre_puntos($lat_a,$lon_a,$lat_b,$lon_b){
    	$lat_a = $lat_a * pi() / 180;
    	$lat_b = $lat_b * pi() / 180;
    	$lon_a = $lon_a * pi() / 180;
    	$lon_b = $lon_b * pi() / 180;
    	/**/
    	$angle = cos($lat_a) * cos($lat_b);
    	$xx = sin(($lon_a - $lon_b)/2);
    	$xx = $xx*$xx;
    	/**/
    	$angle = $angle * $xx;
    	$aa = sin(($lat_a - $lat_b)/2);
    	$aa = $aa*$aa;
    	$angle = sqrt($angle + $aa);
        //$salida = arco_seno($angle);
        $salida = asin($angle);
        /*gps_earth_radius = 6371*/
    	$salida = $salida * 2;
    	$salida = $salida * 6371;

    	return $salida;
  }	
  

  
  function geopunto($CLIENTE,$coor){
	global $db;
	$arreglo = array();
		$conta=0;
	 $sql = "SELECT  ID_OBJECT_MAP, DESCRIPTION, LATITUDE, LONGITUDE FROM ADM_GEOREFERENCIAS WHERE ID_CLIENTE= ".$CLIENTE." AND
               TIPO='G' AND
                ID_TIPO_GEO = ".$coor;
	$query=$db->sqlQuery($sql);
	$count =$db->sqlEnumRows($query);
	if($count>0){
			while($row = $db->sqlFetchArray($query)){
				
				
				 $arreglo[$conta][0] = $row['DESCRIPTION'];
				 $arreglo[$conta][1] = $row['LATITUDE'];
				  $arreglo[$conta][2] = $row['LONGITUDE'];
				 $conta = $conta+1;
				
		}
		return $arreglo;
	}else{
		return -1;
	}	  
	  }
  
  function datos_unidad($unidad){
  	global $db;
	
  	$sql = "SELECT DESCRIPTION AS UNIDAD
			FROM ADM_UNIDADES 			
			WHERE COD_ENTITY = ".$unidad."
	  		LIMIT 1";
	$query=$db->sqlQuery($sql);
	$count =$db->sqlEnumRows($query);
	if($count==1){
		$row=$db->sqlFetcharray($query);
		return $row['UNIDAD'];
	}else{
		return false;
	}
  }
 
 function calcular_por($total,$reales){
	 if($reales>0){
		 $prom = round(($reales*100)/$total,2);
	 }else{
	 	 $prom = 0;
	 }	 
	 return $prom;
 }
 
 

  function envia_mail($file,$usermail){
	global $db,$mail;
	$mail->ClearAttachments();  
	$mail->ClearAddresses();  
	$mail->ClearAllRecipients();  		
	$mail->IsSMTP(); // set mailer to use SMTP
	$mail->Host 	 = "192.168.6.184"; // specify main and backup server
	$mail->SMTPAuth  = true; // turn on SMTP authentication
	$mail->Username  = "avl.4togo"; // SMTP username
	$mail->Password  = "qazwsx"; // SMTP password
	$mail->From 	 = "info@4togo.net";
	$mail->FromName  = "4togo.net";
  	$mail->Subject 	 = "Reporte (Reporte de Productividad) ";
  	$mail->Body 	 = "Se ha generado un reporte de Productividad \nEl archivo viene adjunto.";  				
  	$dest=split(",",$usermail);
  	for($i = 0 ; $i < count($dest) ; $i++){
		if($dest[$i] != ""){
			$mail->AddCC($dest[$i],''); 	
		}			
	}	
	$mail->AddAttachment($file,'');  		
 	return $mail-> send() ? true:false; 	
  }	
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  

function obtener_dias($rango,$idunit,$table_hist){
	global $config_bd2,$funciones,$path_config;			
	//$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
	if($table_hist!=false){
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
		//$conexion = mysqli_connect("192.168.6.45", "savl_mon", "vaio15R", "ALG_BD_CORPORATE_SAVL");	
		if($conexion){
			 $sql = "SELECT DISTINCT CAST(e.GPS_DATETIME AS DATE) AS FECHA
					FROM ".$table_hist." e
					WHERE e.COD_ENTITY IN (".$idunit.")
					".$rango."
					ORDER BY e.GPS_DATETIME";
			
					
			$query = mysqli_query($conexion, $sql);
			$count = mysqli_num_rows($query);
			$data = array();
			$cont=0;
			if($count>0){
				while($row = mysqli_fetch_array($query)){
					$data[$cont] = $row['FECHA'];
					$cont++;
				}
				return $data;
			}else{
				return false;
			}	
			mysqli_close($conexion);	
		}else{
			return false;
		}
	}else{
		return false;
	}		
}



function obtener_distribucion($unidad,$id_dia){
	global $db;
	 $sql = "SELECT i.ID_ITINERARIO AS ID_DISTRIBUTION,i.ID_ROUTE,i.ID_DIA
			FROM ITN_DEFINICION i, ITN_PUNTOS_VISITA v, SAVL_ROUTES_UNITS r
			WHERE i.ID_ITINERARIO = v.ID_ITINERARIO
			AND r.ID_ROUTE = i.ID_ROUTE
			AND r.COD_ENTITY IN (".$unidad.")
			AND i.ID_DIA  = ".$id_dia."
			LIMIT 1";
	$query=$db->sqlQuery($sql);
	$count =$db->sqlEnumRows($query);
	if($count==1){
		$row=$db->sqlFetcharray($query);
		return $row['ID_DISTRIBUTION'];
	}else{
		return 0;
	}	  		  			
}



function gettotalVisitas($id_itn){
	global $db;
	
	$sql = "SELECT g.COD_OBJECT_MAP AS geoID, g.LATITUDE AS geoLatitude, g.LONGITUDE AS geoLong, g.DESCRIPTION AS geoDescription
			FROM ITN_PUNTOS_VISITA e
			INNER JOIN SAVL_G_PRIN	g ON g.COD_OBJECT_MAP = e.COD_OBJECT_MAP
			WHERE e.ID_ITINERARIO = ".$id_itn.""; 
	$query=$db->sqlQuery($sql);
	$count =$db->sqlEnumRows($query);
	if($count>0){		
		return $count;
	}else{
		return -1;
	}	  
}  		



//function obtener_recorrido($idunidad,$tabla_historico,$opciones,$rango_fechas,$id_itn){
//	global $config_bd2,$funciones,$this->recorrido,$contador;		
//	$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
//	if($conexion){
//		$cargar_geos = $this->carga_geos($id_itn);
//		if($cargar_geos){
//			$sql = "SELECT e.GPS_DATETIME,e.VELOCITY,e.LONGITUDE,e.LATITUDE,f.DESCRIPTION AS EVT,e.COD_EVENT
//					FROM ".$tabla_historico." e
//					LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
//					WHERE COD_ENTITY = ".$idunidad."
//					AND ABS(e.LATITUDE)  BETWEEN 12 AND 33 
//					AND ABS(e.LONGITUDE) BETWEEN 80 AND 117						  	 	
//					AND e.GPS_DATETIME BETWEEN '".$rango_fechas." 00:00:00' AND '".$rango_fechas." 23:59:59'
//					
//					ORDER BY e.GPS_DATETIME ASC";
//			$query 		= mysqli_query($conexion,$sql);
//			$count 		= @mysqli_num_rows($query);
//			
//			
//			if($count>0){
//				$this->recorrido = Array();
//				while($row   = @mysqli_fetch_array($query)){
//					
//					$geo = $this->busca_geos($row['LATITUDE'],$row['LONGITUDE']);
//					$idgeo = ($geo['geoID']>0) ? $geo['geoID']: 0;
//					$descgeo = ($geo['geoDescription']!="") ? $geo['geoDescription']: "S/D";
//							
//					if(count($this->recorrido)==0){
//						//echo "es el primero";
//						$this->recorrido[$contador] = array(
//							'lat'		=> $row['LATITUDE'],
//							'lon'		=> $row['LONGITUDE'],
//							'gpsd'		=> $row['GPS_DATETIME'],
//							'vel'		=> $row['VELOCITY'],
//							'idevt'		=> $row['COD_EVENT'],
//							'geoID'		=> $idgeo,
//							'geoDESC'	=> $descgeo,
//							'gpss'		=> $row['GPS_DATETIME'],
//							'segs'		=> 0,
//							'evt'		=> $row['EVT']);
//						$contador++;
//					}else{
//						//echo "es mas de uno ";
//						$latitud_1  	= $this->recorrido[$contador-1]['lat'];
//						$longitud_1 	= $this->recorrido[$contador-1]['lon'];
//						
//						$latitud_2  	= $row['LATITUDE'];
//						$longitud_2 	= $row['LONGITUDE'];
//								
//						$fecha_dia_1 	= substr($row['GPS_DATETIME'], 8, 2);
//						$fecha_dia_2 	= substr($this->recorrido[$contador-1]['gpsd'], 8, 2);
//						
//						if($fecha_dia_1 == $fecha_dia_2){
//							//echo "el dia es igual <br>";
//							$distancia = $this->distancia_entre_puntos($latitud_1,$longitud_1,$latitud_2,$longitud_2);
//							//echo "distancia :".$distancia."<>>>  <br>";
//							if($distancia<.05){
//								//echo "la distancia es menor a .05kms<<<<<<<<<  <br>";
//								if($this->recorrido[$contador-1]['geoID']==$idgeo){
//									//echo "es el mismo geo p <br>";
//									$d_tiempo = $this->diferencia_tiempo($this->recorrido[$contador-1]['gpsd'],$row['GPS_DATETIME']);
//									//echo "dif de tiempo ".$d_tiempo."<br>"; 		
//									$this->recorrido[$contador-1]['gpss'] = $row['GPS_DATETIME'];
//									$this->recorrido[$contador-1]['segs'] = $d_tiempo;
//								}else{
//									//echo "es otro geo p <br>";
//									$this->recorrido[$contador] = array(
//										'lat'		=> $row['LATITUDE'],
//										'lon'		=> $row['LONGITUDE'],
//										'gpsd'		=> $row['GPS_DATETIME'],
//										'vel'		=> $row['VELOCITY'],
//										'idevt'		=> $row['COD_EVENT'],
//										'geoID'		=> $idgeo,
//										'geoDESC'		=> $descgeo,
//										'gpss'		=> $row['GPS_DATETIME'],
//										'segs'		=> 0,
//										'evt'		=> $row['EVT']);
//									$contador++;
//									//echo "---".$contador."se aumento <br>"; 	
//								}
//							}else{
//								//echo "la distancia es mayor a .05kms<<<<<<<<<  <br>";
//								$this->recorrido[$contador] = array(
//									'lat'		=> $row['LATITUDE'],
//									'lon'		=> $row['LONGITUDE'],
//									'gpsd'		=> $row['GPS_DATETIME'],
//									'vel'		=> $row['VELOCITY'],
//									'idevt'		=> $row['COD_EVENT'],
//									'geoID'		=> $idgeo,
//									'geoDESC'		=> $descgeo,
//									'gpss'		=> $row['GPS_DATETIME'],
//									'segs'		=> 0,
//									'evt'		=> $row['EVT']);
//									$contador++;										
//								//echo "---".$contador."se aumento <br>"; 		
//							}
//						}else{
//							//echo "el dia es diferente <<>>";
//							$this->recorrido[$contador] = array(
//								'lat'		=> $row['LATITUDE'],
//								'lon'		=> $row['LONGITUDE'],
//								'gpsd'		=> $row['GPS_DATETIME'],
//								'vel'		=> $row['VELOCITY'],
//								'idevt'		=> $row['COD_EVENT'],
//								'geoID'		=> $idgeo,
//								'geoDESC'		=> $descgeo,
//								'gpss'		=> $row['GPS_DATETIME'],
//								'segs'		=> 0,
//								'evt'		=> $row['EVT']);
//							$contador++;
//							//echo "---".$contador."se aumento <br>"; 									
//						}
//					}	
//				}
//				//echo " El recorrido tiene: ".count($this->recorrido)." <br>";
//				//return ($contador>0) ? true : false;
//				
//				
//				
//				return $this->recorrido;
//			}else{
//				echo 0;
//			}					
//		}else{
//			return false;
//		}
//		mysqli_close($conexion);//Se cierra la conexion	
//	}else{
//		//echo "no se pudo conectar a la bd <br>";
//		return false;
//	}			
//}


function get_num_raleti($hist,$idunit,$rango_fechas,$id_itn,$h1,$h2){
global $config_bd2,$funciones;				
			$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
			if($conexion){
			
			$cadena = '';
				
			
			    $contador=0;
		$sql = "SELECT *, @a:=@a +1 AS VALOR FROM ".$hist." WHERE COD_ENTITY IN (".$idunit.")  AND GPS_DATETIME BETWEEN '".$rango_fechas." ".$h1."' AND '".$rango_fechas." ".$h2."'";
				$sql1 = "set @a:=0;";
				$query1		= mysqli_query($conexion,$sql1);
				$query 		= mysqli_query($conexion,$sql);
					$count 		= @mysqli_num_rows($query);					
					if($count>0){
                        $this->recorrido = Array();
                        $contador = 0;
                        
                        while($row   = @mysqli_fetch_array($query)){
						
					 			
								if($row['MOTOR']=='ON'&& $row['VELOCITY']<'10'){
								
							 $time=explode(" ",$row['GPS_DATETIME']);
							$dat.=$time[1].'/'.$row['VALOR'].'#';
							
										
							
									}else{
									
									if($row['MOTOR']=='OFF'){
									
									 $time1=explode(" ",$row['GPS_DATETIME']);
									$off.=$time1[1].'/'.$row['VALOR'].'#';
									}
									
									if($row['MOTOR']=='ON'&& $row['VELOCITY']>10){
									$time2=explode(" ",$row['GPS_DATETIME']);
									$activ.=$time2[1].'/'.$row['VALOR'].'#';
									}
									
									
									}
									
						}
				
						
						}else{
						echo 0;
					}	
						
						$data = Array(
				    'ON' 	=> $dat,
					'OFF'=> $off,
					'ACT'=> $activ
                );							
					return $data;
			
				mysqli_close($conexion);//Se cierra la conexion	
			}else{
				return false;
			}			
				
				
}

function obtener_recorrido($idunidad,$tabla_historico,$opciones,$rango_fechas,$id_itn,$h1,$h2){
    
			global $config_bd2,$funciones;				
			$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
			if($conexion){
			
			$cadena = '';
				
			
			    $contador=0;
			$sql = "SELECT e.COD_ENTITY,e.GPS_DATETIME,e.VELOCITY,e.LONGITUDE,e.LATITUDE,f.DESCRIPTION AS EVT,e.COD_EVENT
						 	FROM ".$tabla_historico." e
   					 		LEFT JOIN ADM_EVENTOS f ON f.COD_EVENT = e.COD_EVENT
					 		WHERE COD_ENTITY IN (".$idunidad.")
  					  	  	AND ABS(e.LATITUDE)  BETWEEN 12 AND 33 
  					  	  	AND ABS(e.LONGITUDE) BETWEEN 80 AND 117						  	 	
      				 	     AND e.GPS_DATETIME BETWEEN '".$rango_fechas." ".$h1."' AND '".$rango_fechas." ".$h2."'	 
      				 	  
					 		ORDER BY COD_ENTITY ASC, e.GPS_DATETIME ASC";
            //     AND e.GPS_DATETIME BETWEEN '".$rango_fechas." 00:00' AND '".$rango_fechas." 23:59'           
					$query 		= mysqli_query($conexion,$sql);
					$count 		= @mysqli_num_rows($query);					
					if($count>0){
                        $this->recorrido = Array();
                        $contador = 0;
                        
                        while($row   = @mysqli_fetch_array($query)){
                            //echo $row['GPS_DATETIME'].'<br>';
//                            if(count($this->recorrido)==0){
//                                $this->recorrido[$contador] = array(
//								    'lat'		=> $row['LATITUDE'],
//								    'lon'		=> $row['LONGITUDE'],
//								    'gpsd'		=> $row['GPS_DATETIME'],
//								    'vel'		=> $row['VELOCITY'],
//                                    'idevt'     => $row['COD_EVENT'],
//								    'evt'		=> $row['EVT']);
//                                $contador++;
//                            }else{
//                                $latitud_1  	= $this->recorrido[$contador-1]['lat'];
//                                $longitud_1 	= $this->recorrido[$contador-1]['lon'];
//						
//                                $latitud_2  	= $row['LATITUDE'];
//                                $longitud_2 	= $row['LONGITUDE'];							
//							
//                                $distancia = $funciones->distancia_entre_puntos($latitud_1,$longitud_1,$latitud_2,$longitud_2);
                                //if($distancia<10){
                                  $this->recorrido[$contador] = array(
												'unid'      => $row['COD_ENTITY'],
												'lat'		=> $row['LATITUDE'],
												'lon'		=> $row['LONGITUDE'],
												'gpsd'		=> $row['GPS_DATETIME'],
												'vel'		=> $row['VELOCITY'],
                                                'idevt'     => $row['COD_EVENT'],
												'evt'		=> $row['EVT']);
								    $contador++;									
                               // }
                            }
//                        }
                       
					    return ($contador>0) ? true : false;					
					}else{
						echo 0;
					}					
				mysqli_close($conexion);//Se cierra la conexion	
			}else{
				return false;
			}			
		}


 function segundos_tiempo($segundos){
   $minutos=$segundos/60;
   $horas=floor($minutos/60);
   $minutos2=$minutos%60;
   $segundos_2=$segundos%60%60%60;
   if($minutos2<10)$minutos2='0'.$minutos2;
   if($segundos_2<10)$segundos_2='0'.$segundos_2;
   if($segundos<60){ /* segundos */
     if (strlen ($segundos) == 1){
       $resultado= '00:00:0'.round($segundos);
     } else {
	  $resultado= '00:00:'.round($segundos);
     }
   }elseif($segundos>60 && $segundos<3600){/* minutos */
      $resultado= '00:'.$minutos2.':'.$segundos_2;
	  
    }else{/* horas */
	   if (strlen ($horas) == 1){
        $resultado= '0'.$horas.':'.$minutos2.':'.$segundos_2;
	  } else {
		$resultado= $horas.':'.$minutos2.':'.$segundos_2;
	  }

    }
    return $resultado;
  }

/*Obtiene los GeoPuntos del Itinerario*/
function carga_geos($id_itn){	
	global $db;
	if($id_itn!=0){	
		$this->array_geos=Array();		
	 	$sql = "SELECT g.COD_OBJECT_MAP AS geoID, g.LATITUDE AS geoLatitude, g.LONGITUDE AS geoLong, g.DESCRIPTION AS geoDescription
			FROM ITN_PUNTOS_VISITA e
			INNER JOIN SAVL_G_PRIN	g ON g.COD_OBJECT_MAP = e.COD_OBJECT_MAP
			WHERE e.ID_ITINERARIO = ".$id_itn."";  				
		$query    = $db->sqlQuery($sql);
		$contador = $db->sqlEnumRows($query);
		$count	  = 0;
		if($contador > 0){
			while($row = $db->sqlFetchArray($query)){
				$this->array_geos[$count] = $row;
				$count++;
			}			
			if(count($this->array_geos) == $contador){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}else{
		return true;
	}			
}	


/*Funcion que busca el geopunto cercano al reporte.*/
function busca_geos($lat,$lon){
	global $funciones;
	$total		= count($this->array_geos); //GeoPuntos [Tiendas]
	$counta		= 0;
	$cfiltro	= 0;
	$geo_find	= 0;	
	$i=0;
	if($total>0){
		while($i<$total){
			$geo_lat = $this->array_geos[$i]['geoLatitude']; //Latitud
			$geo_lon = $this->array_geos[$i]['geoLong']; //Longitud
			$distancia = round($this->distancia_entre_puntos($lat,$lon,$geo_lat,$geo_lon),2);
		
			if($distancia<=0.05){
				$geo_find = $this->array_geos[$i];
				return  $geo_find;
			}else{
				$i++;
			}
			if($i==$total){
				return  $geo_find;
			}
	}
	}else{
		return  $geo_find;
	}
}



function get_info_geop($idgeo){
	global $db;
	$sql = "SELECT DESCRIPTION, ITEM_NUMBER, COD_TYPE_GEO
			FROM SAVL_G_PRIN 
			WHERE COD_OBJECT_MAP = ".$idgeo."
			LIMIT 1";
	$query = $db->sqlQuery($sql);
	$row   = $db->sqlFetchArray($query);
	return $row;
}




	function get_table_hist($idunit){
		global $config_bd2;
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){		
			$sql = "SELECT COD_FLEET,CONCAT(PLAQUE,'-',DESCRIPTION) AS UNIDAD
					FROM SAVL1120 
					WHERE  COD_ENTITY  IN (".$idunit.") GROUP BY COD_FLEET";
			$query = mysqli_query($conexion, $sql);	
			$row   = @mysqli_fetch_array($query);
			$count = @mysqli_num_rows($query);
			$find=0;			
			if($count > 0){
				if(strlen($row['COD_FLEET']) == 1){
					$tabla_historico = "HIST0000".$row['COD_FLEET'];
				}else if(strlen($row['COD_FLEET']) == 2){
					$tabla_historico = "HIST000".$row['COD_FLEET'];
				}else if(strlen($row['COD_FLEET']) == 3){
					$tabla_historico = "HIST00".$row['COD_FLEET']; 
				}else if(strlen($row['COD_FLEET'])== 4){
					$tabla_historico = "HIST0".$row['COD_FLEET'];
				}else if(strlen($row['COD_FLEET']) == 5){
					$tabla_historico = "HIST".$row['COD_FLEET'];
				}
				
				return ($this->tabla_existe($tabla_historico)) ? $tabla_historico : false;
			}else{
				return false;
			}
			mysqli_close($conexion);
		}else{
			return false;
		}
	}
	
	
	
	function tabla_existe($nametable){
		global $config_bd2;
		$database = $config_bd2['bname'];
		$enlace = mysql_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass']); 
		$tablas = mysql_list_tables($database);  

		while (list($tabla) = mysql_fetch_array($tablas)) {  
 			if ($nametable == $tabla){  
   				return true;  
   				break;  
  			}  
 		}  

		return false;  
	}		
	
	function direccion_flecha($angle){
	$res = 'N';
	
	if (($angle > 0) and ($angle <= 22.5)){
      $res = 'N';
	}
	
	if (($angle > 22.5) and ($angle < 67.5)){
      $res = 'NE';
	}
	
    if (($angle >= 67.5) and ($angle <= 112.5)){
      $res = 'E';
	}
	if (($angle > 337.5)){
      $res = 'N';
	}
	if (($angle > 112.5) and ($angle <= 157.5)){
      $res = 'SE';
	}
    if (($angle > 157.5) and ($angle <= 202.5)){
      $res = 'S';
	}
	if (($angle > 202.5) and ($angle <= 247.5)){
      $res = 'SO';
	}
	if (($angle > 247.5) and ($angle <= 292.5)){
      $res = 'O';
	}
	if (($angle > 292.5) and ($angle <= 337.5)){
      $res = 'NO';
	}
	return $res;
  }

	
	
function direccion($lati,$longi){
	global $config_bd_sp;
	$conexion = mysqli_connect($config_bd_sp['host'],$config_bd_sp['user'],$config_bd_sp['pass'],$config_bd_sp['bname']);				
	if($conexion){
		$sql_stret	= "CALL SPATIAL_CALLES(".$longi.",".$lati.");";
		$query 		= mysqli_query($conexion, $sql_stret);
		$row_st   	= @mysqli_fetch_array($query);
		$direccion 	= $row_st['ESTADO'].",".$row_st['MUNICIPIO'].",".$row_st['ASENTAMIENTO'].",".$row_st['CALLE'];
		return $direccion;
		mysqli_close($conexion);
	}else{
		return false;
	}
}
	
	
function redondeado ($numero, $decimales) {
   $factor = pow(10, $decimales);
   return (round($numero*$factor)/$factor); 
}

	
	
function envia_archivo($file,$totaldest){
	global $db,$funciones,$mail;
	$mail  		= new PHPMailer();
	$mail->ClearAttachments();  
	$mail->ClearAddresses();  
	$mail->ClearAllRecipients();  		
	$mail->IsSMTP(); 								 
	$mail->Host 	 = "mail2.grupouda.com.mx"; 	
	$mail->SMTPAuth  = true;
	$mail->Username  = "avl.4togo";
	$mail->Password  = "qazwsx";
	$mail->From 	 = "4togo@grupouda.com.mx";
	$mail->FromName  = "Precisiongps";
	$mail->Subject 	 = "Reporte de Productividad";
	$mail->Body 	 = "Reporte de Productividad";
							
	$dest=split(",",$totaldest);
	
	$mail->AddAddress($dest[0],'');
	
	for($i=1;$i< count($dest);$i++){
		$mail->AddCC($dest[$i],'');
	}
	
	$mail->AddAttachment('tmp/'.$file,'');
	return $mail-> send() ? true:false;
}




/*Funcion que obtiene los kilometrios recorridos, horas de conduccion y velocidad promedio*/
function get_res_recorrido($unit,$rango_fechas){
	
	/*Conexion a la BD2*/
	global $config_bd2;
	$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
	if($conexion){
	
	/*Nombre de la tabla HIST*/
	$table_h= $this->get_table_hist($unit);
	
	if($table_h!=false){
			$sql_hist = "SELECT GPS_DATETIME,LATITUDE,LONGITUDE,VELOCITY,COD_EVENT
						FROM ".$table_h." 							
						WHERE COD_ENTITY IN (".$unit.")
						AND GPS_DATETIME BETWEEN ".$rango_fechas."
						AND ABS(LATITUDE) BETWEEN 12 AND 33 
						AND ABS(LONGITUDE) BETWEEN 80 AND 117
						ORDER BY GPS_DATETIME";
			$query_hist = mysqli_query($conexion,$sql_hist);
			$count_hist = @mysqli_num_rows($query_hist);

			$contador=0;
			$data = Array();

			while($row_hist = @mysqli_fetch_array($query_hist)){
				
				//Datos Recorrido
				$data[$contador] = array(
					'vplat' => $row_hist['LATITUDE'],
					'vplon' => $row_hist['LONGITUDE'],
					'vpdate' => $row_hist['GPS_DATETIME'],
					'vpvel' => $row_hist['VELOCITY'],
					'vpevent' => $row_hist['COD_EVENT']
				);
					
				$contador++;
				
				}							
			}
			return $data;
			mysqli_close($conexion);
	}else{
		return false;
	}			
}




/*Funcion que obtiene los kilometrios recorridos, horas de conduccion y velocidad promedio*/
function get_res_recorridoGral($unit,$rango_fechas){
	
	/*Conexion a la BD2*/
	global $config_bd2;
	$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
	if($conexion){
	
	/*Nombre de la tabla HIST*/
	$table_h= $this->get_table_hist($unit);
	
	if($table_h!=false){
			$sql = "SELECT e.GPS_DATETIME,e.VELOCITY,e.LONGITUDE,e.LATITUDE,f.DESCRIPTION AS EVT,e.COD_EVENT
					FROM ".$table_h." e
					LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
					WHERE COD_ENTITY = ".$unit."
					AND ABS(e.LATITUDE)  BETWEEN 12 AND 33 
					AND ABS(e.LONGITUDE) BETWEEN 80 AND 117						  	 	
					AND GPS_DATETIME BETWEEN ".$rango_fechas."
					ORDER BY e.GPS_DATETIME ASC";
       
       
       
//			$sql_hist = "SELECT GPS_DATETIME,LATITUDE,LONGITUDE,VELOCITY,COD_EVENT
//						FROM ".$table_h." 							
//						WHERE COD_ENTITY = ".$unit."
//						AND ABS(LATITUDE) BETWEEN 12 AND 33 
//						AND ABS(LONGITUDE) BETWEEN 80 AND 117
//						AND GPS_DATETIME BETWEEN ".$rango_fechas."
//						ORDER BY GPS_DATETIME";
			$query_hist = mysqli_query($conexion,$sql_hist);
			$count_hist = @mysqli_num_rows($query_hist);
			$total_distance=0;
			$total_time=0;
			$datetime=0;
			
			$lat1=0;
			$lon1=0;
			$tot=0;
			$contador=0;
			$contadoresumen=0;
			$vel_acum=0;
			$tot_vel=0;
			$dataresumen = Array();
			while($row_hist = @mysqli_fetch_array($query_hist)){
				$dif_tiempo=0;
				if($contador==0){
					$datetime=$row_hist['GPS_DATETIME'];
					$lat1=$row_hist['LATITUDE'];
					$lon1=$row_hist['LONGITUDE'];
				}
				if($contador>0){
					$distancia = $this->distancia_entre_puntos($lat1,$lon1,$row_hist['LATITUDE'],$row_hist['LONGITUDE']);
					
					if($distancia>.05 && $distancia < 10){
						$lat1=$row_hist['LATITUDE'];
						$lon1=$row_hist['LONGITUDE'];				
									
						$total_distance=$total_distance+$distancia;
						$dif_tiempo=$this->diferencia_tiempo($datetime,$row_hist['GPS_DATETIME']);
						
						$total_time=$total_time+$dif_tiempo;
						$datetime=$row_hist['GPS_DATETIME'];
						if($row_hist['VELOCITY'] >0){
							$vel_acum=$vel_acum+$row_hist['VELOCITY'];
							$tot_vel++;	
						}							
					}else{
						$contador=1;
						$datetime=$row_hist['GPS_DATETIME'];
						$lat1=$row_hist['LATITUDE'];
						$lon1=$row_hist['LONGITUDE'];	
					}
				}
					//Datos Recorrido
//					$data[$contador] = array(
//						'vplat'		=> $row_hist['LATITUDE'],
//						'vplon'		=> $row_hist['LONGITUDE'],
//						'vpdate'		=> $row_hist['GPS_DATETIME'],
//						'vpvel'		=> $row_hist['VELOCITY'],
//						'vpevent'		=> $row_hist['COD_EVENT']
//						
//					);
					
				$contador++;
				$tot++;		
				if($tot==$count_hist){
					if($tot_vel>0){
						$prom = ($total_distance>0) ? ($vel_acum/$tot_vel): 0;	
					}else{
						$prom = 0;
					}
					
					//Datos Resumidos
					$dataresumen[$contadoresumen] = array(
						'vpdistrecorrida'		=> $total_distance,
						'vphrsconducidas'		=> $this->convierte_horas($total_time),
						'vpvelpromedio'		=> $prom				
					);

					
				}							
			}
			return $dataresumen;
			mysqli_close($conexion);
		}else{
			//return "error 2";
			return false;
		}
	}else{
		///return "error 1";
		return false;
	}			
}





function evento($idevento){
	global $db;
	$sql = "SELECT COD_EVENT, DESCRIPTION
			FROM SAVL1260 
			WHERE COD_EVENT = ".$idevento."
			LIMIT 1";
	$query = $db->sqlQuery($sql);
	$row   = $db->sqlFetchArray($query);
	return $row;
}


function typeGeoInfo($idtype){
	global $db;
	$sql = "SELECT COD_TYPE_GEO, DESCRIPTION
			FROM SAVL1164 
			WHERE COD_TYPE_GEO = ".$idtype."
			LIMIT 1";
	$query = $db->sqlQuery($sql);
	$row   = $db->sqlFetchArray($query);
	return $row;
}



        function getVisitas_r($id_itn){
            $bancos_v   = 0;
            $clientes_v = 0;
            if($id_itn>0){
                //echo "el itinerario es mayor a 0 ".$id_itn."**-";
                $carga_g = $this->carga_geos($id_itn);
                if($carga_g){
                    //echo "se cargaron los geopuntos-----";
                    $carga_r2 = $this->llena_rec_2();
                    if($carga_r2){
                        //echo "---Se cargaron El recorrido-----------";
                        
                        for($p=0;$p<count($this->recorrido_2);$p++){
                            $this->recorrido_2[$p]['segs']."--";
                            $this->recorrido_2[$p]['lat']." ";
                            $this->recorrido_2[$p]['lon']."  ";
                            $this->recorrido_2[$p]['gpsd']." ";
                            $this->recorrido_2[$p]['vel']." ";
                            $this->recorrido_2[$p]['idevt']." ";
                            $this->recorrido_2[$p]['geoID']." ";
                            $this->recorrido_2[$p]['gpss']." ";
                            $this->recorrido_2[$p]['segs']." ";
                            $this->recorrido_2[$p]['evt']." \n";
                            
                            if($this->recorrido_2[$p]['segs']>300 && $this->recorrido_2[$p]['geoID']>0){
                                $info_geo = $this->get_info_geop($this->recorrido_2[$p]['geoID']);
                                if($info_geo['COD_TYPE_GEO']==98){
                                    $bancos_v++;
                                }else{
                                    $clientes_v++;
                                }
                                
                            }
                            	
                        }
                        $data = Array(
				            'BANCOS'	=> $bancos_v,
					       'CLIENTES'	=> $clientes_v
				        );
				        return $data;
                    }else{
                        //echo "---NO SE CARGO INFO-------------";
                        $data = Array(
				            'BANCOS'	=> 0,
                            'CLIENTES'	=> 0
				        );	 	
				        return $data;                        
                    }
                }else{
                    //echo "---NO SE CARGO GEOPUNTOS-------------";
                    $data = Array(
				        'BANCOS'	=> 0,
                        'CLIENTES'	=> 0
				    );	 	
				    return $data;                    
                }
            }else{
                $data = Array(
				    'BANCOS'	=> 0,
					'CLIENTES'	=> 0
				);	 	
				return $data;                
            }
        }



        function llena_rec_2(){
            //echo "---Entro sa enro a llena_rec_2O-------------";
            $this->recorrido_2 = Array();
            $contador_2=0;
            
            for($p=0;$p<count($this->recorrido);$p++){
                
                $geo 		= $this->busca_geos($this->recorrido[$p]['lat'],$this->recorrido[$p]['lon']);			
				$idgeo 		= ($geo['geoID']>0) ? $geo['geoID']: 0;
														
                if(count($this->recorrido_2)==0){
                    //echo "es el primero \n";
                    $this->recorrido_2[$contador_2] = array(
					   'lat'		=> $this->recorrido[$p]['lat'],
					   'lon'		=> $this->recorrido[$p]['lon'],
					   'gpsd'		=> $this->recorrido[$p]['gpsd'],
					   'vel'		=> $this->recorrido[$p]['vel'],
					   'idevt'		=> $this->recorrido[$p]['idevt'],
					   'geoID'		=> $idgeo,
					   'gpss'		=> $this->recorrido[$p]['gpsd'],
					   'segs'		=> 0,
					   'evt'		=> $this->recorrido[$p]['evt']);
					$contador_2++;
                    
                }else{
                    $indice_ant     = ($contador_2 - 1);
                    //echo "indice anterior ".$indice_ant."\n";
                    $latitud_1  	= $this->recorrido_2[$indice_ant]['lat'];
					$longitud_1 	= $this->recorrido_2[$indice_ant]['lon'];
                    
					//echo "latitud b ".$latitud_1;
                    //echo "latitud b ".$longitud_1;
                    			
					$latitud_2  	= $this->recorrido[$p]['lat'];
					$longitud_2 	= $this->recorrido[$p]['lon'];
                    
					//echo "latitud a ".$latitud_2;
                    //echo "latitud a ".$longitud_2."\n";
                    					
                    $fecha_dia_1 	= substr($this->recorrido[$p]['gpsd'], 8, 2);
		            $fecha_dia_2 	= substr($this->recorrido_2[$indice_ant]['gpsd'], 8, 2);
                    
                    if($fecha_dia_1 == $fecha_dia_2){
                        //echo "la fecha es igual \n";
                        $distancia = $this->distancia_entre_puntos($latitud_1,$longitud_1,$latitud_2,$longitud_2);
                        //echo "la distancia es ".$distancia."\n";
                        if($distancia<.05){
                            if($this->recorrido_2[$indice_ant]['geoID']==$idgeo){
                                //echo "es el mismo geopunto \n";
                                $d_tiempo = $this->diferencia_tiempo($this->recorrido_2[$indice_ant]['gpsd'],$this->recorrido[$p]['gpsd']);
                                //echo " diferencia de tiempo".$d_tiempo." \n";
								$this->recorrido_2[$indice_ant]['gpss'] = $this->recorrido[$p]['gpsd'];
   								$this->recorrido_2[$indice_ant]['segs'] = $d_tiempo;
							}else{
							     //echo "no es el mismo punto  ".$contador_2."\n";
                                $this->recorrido_2[$contador_2] = array(
					               'lat'		=> $this->recorrido[$p]['lat'],
					               'lon'		=> $this->recorrido[$p]['lon'],
					               'gpsd'		=> $this->recorrido[$p]['gpsd'],
					               'vel'		=> $this->recorrido[$p]['vel'],
					               'idevt'		=> $this->recorrido[$p]['idevt'],
					               'geoID'		=> $idgeo,
					               'gpss'		=> $this->recorrido[$p]['gpsd'],
					               'segs'		=> 0,
					               'evt'		=> $this->recorrido[$p]['evt']);
                                $contador_2++;
							}                            
                        }else{
                            //echo "La distancia es mayor ".$contador_2."\n";
                            $this->recorrido_2[$contador_2] = array(
					           'lat'		=> $this->recorrido[$p]['lat'],
					           'lon'		=> $this->recorrido[$p]['lon'],
					           'gpsd'		=> $this->recorrido[$p]['gpsd'],
					           'vel'		=> $this->recorrido[$p]['vel'],
					           'idevt'		=> $this->recorrido[$p]['idevt'],
					           'geoID'		=> $idgeo,
					           'gpss'		=> $this->recorrido[$p]['gpsd'],
					           'segs'		=> 0,
					           'evt'		=> $this->recorrido[$p]['evt']);
                            $contador_2++;
                        }
                    }else{
                        //echo "La fehca no es igual ".$contador_2."\n";
                        $this->recorrido_2[$contador_2] = array(
					       'lat'		=> $this->recorrido[$p]['lat'],
					       'lon'		=> $this->recorrido[$p]['lon'],
					       'gpsd'		=> $this->recorrido[$p]['gpsd'],
					       'vel'		=> $this->recorrido[$p]['vel'],
					       'idevt'		=> $this->recorrido[$p]['idevt'],
					       'geoID'		=> $idgeo,
					       'gpss'		=> $this->recorrido[$p]['gpsd'],
					       'segs'		=> 0,
					       'evt'		=> $this->recorrido[$p]['evt']);
                        $contador_2++; 
                    }
                }	
            }//Fin del recorrido de la unidad
            return ($contador_2>0) ? true: false;
        }


        function getRes_rec(){
           if(count($this->recorrido)>0){
				$total_distance = 0;				
				$vel_acum       = 0;
				$tot_vel        = 0;                
                $total_time     = 0;
                
                for($p=0;$p<count($this->recorrido);$p++){                    
                    if($this->recorrido[$p]['vel'] >0){
                        $vel_acum=$vel_acum+$this->recorrido[$p]['vel'];
                        $tot_vel++;	
                    }
                    
                    if($p>0){
                        $datetime       = $this->recorrido[$p-1]['gpsd'];
                        $latitud_1  	= $this->recorrido[$p-1]['lat'];
                        $longitud_1 	= $this->recorrido[$p-1]['lon'];
                        
    			$distancia = $this->distancia_entre_puntos($latitud_1,$longitud_1,$this->recorrido[$p]['lat'],$this->recorrido[$p]['lon']);
                       // if($distancia>.05 && $distancia < 10){
                            $total_distance = $total_distance+$distancia; 
                            $dif_tiempo     = 0;                            
                            $dif_tiempo     = $this->diferencia_tiempo($datetime,$this->recorrido[$p]['gpsd']);
                            $total_time     = $total_time+$dif_tiempo;                         
                       // }                        
                    }
                }
                
                $prom = ($tot_vel>0) ? ($vel_acum/$tot_vel) : 0;        
				$data = Array(
				    'DIST' 	=> $total_distance,
					'TIEMPO'=> $this->convierte_horas($total_time),
					'PROM'	=> $prom
                );										
                return $data;
            }else{
				return false;				  
            }
        }
        


function trae_his_s($unit,$cliente,$rango_fechas,$maestre_array){
	
	/*Conexion a la BD2*/
	global $config_bd;
	$conexion = mysqli_connect($config_bd['host'],$config_bd['user'],$config_bd['pass'],$config_bd['bname']);		
	if($conexion){
	
	/*3 Y 13*/
	$table_h= $cliente;
	
	
	$doub_array=array();
	$coun_array=0;
	

			echo $sql = "SELECT e.GPS_DATETIME,
				e.VELOCITY,
				e.LONGITUDE,
				e.LATITUDE,
				f.DESCRIPTION AS EVT,
				e.COD_EVENT
					FROM ".$table_h." e
				INNER JOIN ADM_EVENTOS f ON e.COD_EVENT=f.COD_EVENT
				WHERE
					e.COD_ENTITY=".$unit."
					AND ".$rango_fechas."
					ORDER BY e.GPS_DATETIME ASC";
       
       
       				$contase=count($maestre_array);
							
						$query_hist = mysqli_query($conexion,$sql);
						$count_hist = @mysqli_num_rows($query_hist);
							
					while($row = @mysqli_fetch_array($query_hist)){		
						
					if($row['COD_EVENT']==3){
							for($i=0;$i<$contase;$i++){
									$div=explode(',',$maestre_array[$i]);
								$dist=$this->point_at_point($div[2],$div[3],$row['LATITUDE'],$row['LONGITUDE']);
						
								if($dist<=0.1){
										if($div[5]=='0'){
									
									 $datas ='UPDATE DSP_ITINERARIO SET
											FECHA_ARRIBO = \''.$row['GPS_DATETIME'].
											'\' WHERE ID_ENTREGA  = '.$div[4];
								//	echo 'entro';
										if(mysqli_query($conexion,$datas)){
											$coun_array=1;
											//$maestre_array[$i]=$maestre_array[$i].',1';
										}
									
									
										}
									
									}
						
								}//for
					
						} 
						
						if($row['COD_EVENT']=='13'){
								for($o=0;$o<$contase;$o++){
									$div2=explode(',',$maestre_array[$o]);
									$num=count($div);
									
										$dist=$this->point_at_point($div[2],$div[3],$row['LATITUDE'],$row['LONGITUDE']);
										if($dist<=0.1){
												if(($div[5]=='1' && $div[6]=='0')||$coun_array==1){
												
												 $datas ='UPDATE DSP_ITINERARIO SET
												FECHA_SALIDA = \''.$row['GPS_DATETIME'].
												'\' WHERE ID_ENTREGA  = '.$div[4];
	
														if(mysqli_query($conexion,$datas)){
															$coun_array=0;
															$maestre_array[$i]=$div[0].','.$div[1].','.$div[2].','.$div[3].','.$div[4].','.'2';
														}
										
													}
												}//if dist
								
										}//for 1239
						}
						
							
							
							if($row['COD_EVENT']=='1239'){
								echo $row['COD_EVENT'].',';
								for($o=0;$o<$contase;$o++){
									$div2=explode(',',$maestre_array[$o]);
									$num=count($div);
									
									
										
												if(($div[5]=='1' && $div[6]=='0')||$coun_array==1){
												
												 $datas ='UPDATE DSP_ITINERARIO SET
												FECHA_SALIDA = \''.$row['GPS_DATETIME'].
												'\' WHERE ID_ENTREGA  = '.$div[4];
	
														if(mysqli_query($conexion,$datas)){
															$coun_array=0;
															
														}
										
													}
											
								
										}//for 1239
						}
							
							
											
									
						
					
					
					
					
					}
	
	}
}
     
function obtener_ureporte($unit,$cliente){
	
	/*Conexion a la BD2*/
	global $config_bd;
	$conexion = mysqli_connect($config_bd['host'],$config_bd['user'],$config_bd['pass'],$config_bd['bname']);		
	if($conexion){
	
	/*3 Y 13*/
	$table_h= $cliente;
	
	
	$doub_array=array();
	$coun_array=0;
	

		 $sql = "SELECT f.PLAQUE,f.YEAR,f.DESCRIPTION,    
			                  IF (e.GPS_DATETIME IS NULL, '0000-00-00 00:00:00',e.GPS_DATETIME) AS GPS_DATETIME ,
							  IF(g.DESCRIPTION IS NULL,'NO HA REPORTADO',g.DESCRIPTION) AS DESC_EVT,     
							  IF(e.VELOCITY IS NULL,0,e.VELOCITY) AS VELOCITY,
							  
                              IF(e.LATITUDE IS NULL,0,e.LATITUDE) AS LATITUDE,
						      IF(e.LONGITUDE IS NULL,0,e.LONGITUDE) AS LONGITUDE,
					          f.COD_ENTITY,
						      IF (g.PRIORITY is null,0,g.PRIORITY) as PRIORITY,
							  e.ANGLE
						FROM  ADM_UNIDADES f
						LEFT JOIN ".$table_h." e ON e.COD_ENTITY = f.COD_ENTITY
						LEFT JOIN ADM_EVENTOS g ON e.COD_EVENT  = g.COD_EVENT
						WHERE e.COD_ENTITY = ".$unit."
						ORDER BY g.PRIORITY DESC
						LIMIT 1";
       
       
       				//$contase=count($maestre_array);
							
						$query_hist = mysqli_query($conexion,$sql);
						$count = @mysqli_num_rows($query_hist);					 
						if($count>0){
							$result = mysqli_fetch_array($query_hist);
							return $result;				
						}else{
							return false;
						}
			
	
	}
}	 
	 
	 function obtener_his_iterio($unit,$cliente,$sfech){
	
	/*Conexion a la BD2*/
	global $config_bd;
	$conexion = mysqli_connect($config_bd['host'],$config_bd['user'],$config_bd['pass'],$config_bd['bname']);		
	if($conexion){
	
	/*3 Y 13*/
	$table_h= $cliente;
	
	
	$doub_array=array();
	$coun_array=0;
	

		 $sql = "SELECT f.DESCRIPTION,    
			                  IF (e.GPS_DATETIME IS NULL, '0000-00-00 00:00:00',e.GPS_DATETIME) AS GPS_DATETIME ,
							  IF(g.DESCRIPTION IS NULL,'NO HA REPORTADO',g.DESCRIPTION) AS DESC_EVT,     
							  IF(e.VELOCITY IS NULL,0,e.VELOCITY) AS VELOCITY,
							 	CAST(e.GPS_DATETIME AS DATE ) AS FECHA,
                              IF(e.LATITUDE IS NULL,0,e.LATITUDE) AS LATITUDE,
						      IF(e.LONGITUDE IS NULL,0,e.LONGITUDE) AS LONGITUDE,
					          f.COD_ENTITY,
						      IF (g.PRIORITY is null,0,g.PRIORITY) as PRIORITY,
							  e.ANGLE
						FROM  ".$table_h." e 
						LEFT JOIN ADM_UNIDADES f ON e.COD_ENTITY = f.COD_ENTITY
						LEFT JOIN ADM_EVENTOS g ON e.COD_EVENT  = g.`COD_EVENT`
						WHERE e.COD_ENTITY = ".$unit." AND
						 ".$sfech."
						ORDER BY g.PRIORITY DESC";
       
       
       				//$contase=count($maestre_array);
							
						$query_hist = mysqli_query($conexion,$sql);
						$count = @mysqli_num_rows($query_hist);					 
						if($count>0){
							$result = mysqli_fetch_array($query_hist);
							return $result;				
						}else{
							return 0;
						}
			
	
	}
}	
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	    
function point_at_point($lat1, $lon1, $lat2, $lon2) { 

$theta = $lon1 - $lon2;
$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
$dist = acos($dist);
$dist = rad2deg($dist);
$miles = $dist * 60 * 1.1515;


return ($miles * 1.609344);

}   

function terminada_visita($des){
	
	global $config_bd;
	$conexion = mysqli_connect($config_bd['host'],$config_bd['user'],$config_bd['pass'],$config_bd['bname']);
	if($conexion){
		
		$datas1 ="SELECT 
			 	IF(ID_ESTATUS = 3,1,IF(ID_ESTATUS = 5,1,0)) AS ESTADO,
				 IF(P.FECHA_SALIDA = '0000-00-00 00:00:00', '0', '1') AS FECHA_SALIDA 
				FROM DSP_ITINERARIO 
				WHERE ID_ENTREGA  = ".$des;
			 $query_hist = mysqli_query($conexion,$datas1);
	 		$row = @mysqli_fetch_array($query_hist);
			
			//echo $row['ESTADO'];
		if($row['ESTADO']=='0'&& $row['FECHA_SALIDA']=='0'){
			$datas ='UPDATE DSP_ITINERARIO SET
				 ID_ESTATUS = 3 WHERE ID_ENTREGA  = '.$des;
												
			mysqli_query($conexion,$datas);
		}
	}
	
	}





} 
?>