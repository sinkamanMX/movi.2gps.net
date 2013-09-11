<?php
/** * 
 *  @package             4TOGO
 *  @name                Obtiene la ultima pocision de las unidades de la BD 192.168.6.45
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          02-12-2010 
**/
class cPositions{
	public function get_tablename($id_client){
		$id_client = (int)$id_client;	
		$table_name = '';		
		if (strlen($id_client) < 5) {
	        $table_name = str_repeat('0', (5-strlen($id_client)));
	    }
    	return $table_name . $id_client;
	}
	
	public function get_last_position($id_unit,$id_client,$flagPosition=-1){
		global $config_bd;
		$name_table = $this->get_tablename($id_client);
		$conexion = mysqli_connect($config_bd['host'],$config_bd['user'],$config_bd['pass'],$config_bd['bname']);
		if($conexion){
		 $sql	= "SELECT f.PLAQUE,   
					f.YEAR,     
					f.DESCRIPTION,
					IF (e.GPS_DATETIME IS NULL, '0000-00-00 00:00:00',e.GPS_DATETIME) AS GPS_DATETIME,
					IF(g.DESCRIPTION IS NULL,'NO HA REPORTADO',g.DESCRIPTION) AS DESC_EVT,
					IF(e.VELOCITY IS NULL,0,e.VELOCITY) AS VELOCIDAD,        
					/*f.COD_FLEET,*/
					IF(e.LATITUDE IS NULL,0,e.LATITUDE) AS LATITUDE,
					  IF(e.LONGITUDE IS NULL,0,e.LONGITUDE) AS LONGITUDE,        
					  f.COD_ENTITY,
					  IF (g.PRIORITY is null,0,g.PRIORITY) as PRIORITY,
					  IF (g.PRIORITY = 1,'#FF2427','#FFFFFF') AS BACKGROUND,
					  IF ((e.ANGLE > 0) and (e.ANGLE <= 22.5),'N',
					  IF ((e.ANGLE > 22.5) and (e.ANGLE < 67.5),'NE',
					  IF ((e.ANGLE >= 67.5) and (e.ANGLE <= 112.5),'E',
					  IF ((e.ANGLE > 337.5),'N',
					  IF ((e.ANGLE > 112.5) and (e.ANGLE <= 157.5),'SE',
					  IF ((e.ANGLE > 157.5) AND (e.ANGLE <= 202.5),'S',
					  IF ((e.ANGLE > 202.5) AND (e.ANGLE <= 247.5),'SO',
					  IF ((e.ANGLE > 247.5) AND (e.ANGLE <= 292.5),'O',
					  IF ((e.ANGLE > 292.5) AND (e.ANGLE <= 337.5),'NO','N'))))))))) AS ANGULO,
					IF ((e.VELOCITY < 5) AND (e.MOTOR = 'ON'),'RALENTI',
					IF((e.VELOCITY = 0) AND (e.MOTOR = 'OFF'),'DETENIDO',
					IF((e.VELOCITY > 5) AND (e.MOTOR = 'ON'),'MOVIMIENTO','DESCONOCIDO'))) AS ESTATUS,
					IF ((e.VELOCITY < 5) AND (e.MOTOR = 'ON'),'#E86100',
					IF((e.VELOCITY = 0) AND (e.MOTOR = 'OFF'),'#000000',
					IF((e.VELOCITY > 5) AND (e.MOTOR = 'ON'),'#00FF00','#999999'))) AS COLOR,
					IF( -1 <> ".$flagPosition." , (SUBSTRING(e.DIG_INPUT, ".$flagPosition.", 1))   , '2') AS BLOQUEO_MOTOR, IF(e.BATTERY IS NULL,0,e.BATTERY) AS BATTERY  
					FROM ADM_UNIDADES f  
					LEFT JOIN LAST".$name_table." e ON e.COD_ENTITY = f.COD_ENTITY
					LEFT JOIN ADM_EVENTOS g ON e.COD_EVENT  = g.COD_EVENT
					WHERE e.COD_ENTITY = ".$id_unit;
			$query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);					 
			if($count>0){
				$result = mysqli_fetch_array($query);			
				return $result;				
			}else{
				return 0;
			}
			mysqli_close($conexion);			
	}	
	}
	
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
	
    //**Obtiene la tabla donde se almacenan los historicos de las unidades*************-//
	function direccion($lati,$longi){
		global $config_bd_sp;
$conexion = mysqli_connect($config_bd_sp['host'],$config_bd_sp['user'],$config_bd_sp['pass'],$config_bd_sp['bname']);				
		if($conexion){
			$sql_stret	= "CALL SPATIAL_CALLES(".$longi.",".$lati.");";
			$query 		= mysqli_query($conexion, $sql_stret);
			$row_st   	= @mysqli_fetch_array($query);
			$direccion 	= $row_st['ESTADO']." , ".$row_st['MUNICIPIO']."\n  , ".$row_st['ASENTAMIENTO']." , ".$row_st['CALLE'];
			return $direccion;
			mysqli_close($conexion);
		}else{
			return false;
		}
	}	

    //**Obtiene la tabla donde se almacenan los historicos de las unidades*************-//
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
	
	//**Calcula la distancia entre dos puntos, el valor lo regresa en kms**//
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
		
		$salida = round($salida*100)/100;
    	return $salida;
  }
	////------------------------------------------------------------------------------Alertas
	
	public function prob_nom($cli,$nam){
		global $config_bd3;
		$conta=0;
		$conexion = mysqli_connect($config_bd3['host'],$config_bd3['user'],$config_bd3['pass'],$config_bd3['bname']);
		if($conexion){
	 $sql	= "SELECT NAME_ALERT FROM ALERT_MASTER WHERE NAME_ALERT LIKE '%".$nam."%' AND COD_CLIENT=".$cli ;				
		
			$query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);					 
		
		
		/*while($row = @mysqli_fetch_array($query)){	
			
				 $arreglo[$conta][0] = $row['ID_TIPO_VARIABLE'];
				 $arreglo[$conta][1] = $row['COD_ALERT_DICTIONARY'];
				 $arreglo[$conta][2] = $row['DESCRIPTION'];
				 $arreglo[$conta][3] = $row['NAME_VARIABLE'];
				 $arreglo[$conta][4] = $row['METHOD_CALCULATION'];
				 $arreglo[$conta][5] = $row['DIC_DEFAULT_VALUE'];
				 $arreglo[$conta][6] = $row['DATA_TYPE'];
				 $arreglo[$conta][7] = $row['ICONO'];
				 $arreglo[$conta][8] = $row['DEPENDENCIA'];
				 $arreglo[$conta][9] = $row['COMBINATIONS'];
				 $arreglo[$conta][10] = $row['DATASOURCE'];
				 $arreglo[$conta][11] = $row['DATA_SQL'];
				 
				 $conta++;
				
			
			}		 */
	
			
				return $count ;
	
			mysqli_close($conexion);			
		}else{
		$result = 0;
			return false;
		}
	}
	
	///////////////////---------------------------------------------------------------------------------------------- Alertas
	
	public function obtener_alert_exp(){
		global $config_bd3;
		$conta=0;
		$conexion = mysqli_connect($config_bd3['host'],$config_bd3['user'],$config_bd3['pass'],$config_bd3['bname']);
		if($conexion){
	 $sql	= " SELECT *
FROM ALERT_DICTIONARY_EXPRESION WHERE FLAG_ACTIVE='1' 
ORDER BY ID_TIPO_VARIABLE ";				
		
			$query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);					 
		
		
		while($row = @mysqli_fetch_array($query)){	
			
				 $arreglo[$conta][0] = $row['ID_TIPO_VARIABLE'];
				 $arreglo[$conta][1] = $row['COD_ALERT_DICTIONARY'];
				 $arreglo[$conta][2] = $row['DESCRIPTION'];
				 $arreglo[$conta][3] = $row['NAME_VARIABLE'];
				 $arreglo[$conta][4] = $row['METHOD_CALCULATION'];
				 $arreglo[$conta][5] = $row['DIC_DEFAULT_VALUE'];
				 $arreglo[$conta][6] = $row['DATA_TYPE'];
				 $arreglo[$conta][7] = $row['ICONO'];
				 $arreglo[$conta][8] = $row['DEPENDENCIA'];
				 $arreglo[$conta][9] = $row['COMBINATIONS'];
				 $arreglo[$conta][10] = $row['DATASOURCE'];
				 $arreglo[$conta][11] = $row['DATA_SQL'];
				 
				 $conta++;
				
			
			}		 
			if($count>0){
				return $arreglo;	
			}else{
			
				return false;
			}
			mysqli_close($conexion);			
		}else{
		$result = 0;
			return false;
		}
	}
	////////----------------------------------------------------------------------------------------------------Alertas
	public function nue_prue_ser($quers){
		global $config_bd2;
		$conta=0;
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
		if($conexion){
	 $sql	=  $quers;				
		
			$query   = mysqli_query($conexion, $sql);
		//	$count = @mysqli_num_rows($query);					 
		 
			if($query){
				return 1;	
			}else{
			
				return 0;
			}
			mysqli_close($conexion);			
		}else{
		$result = 0;
			return false;
		}
	}
	///////_------------------------------------------------------------------------------------------------------Alertas
	
		public function nue_prueb_max($quers){
		global $config_bd2;
		$conta=0;
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
		if($conexion){
	 $sql	=  $quers;				
		
			$query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);					 
			$row = @mysqli_fetch_array($query);
		
			if($count>0){
				$data=$row ['MAXIMO'];
				return $data;	
			}else{
			
				return 0;
			}
			mysqli_close($conexion);			
		}else{
		$result = 0;
			return 0;
		}
	}
	
	
	///////-----------------------------------------------------------------------------------------------------aLERTA
		public function trae_alertas_here($quers){
		global $config_bd3;
		$conta=0;
		$cadena=' ';
		$conexion = mysqli_connect($config_bd3['host'],$config_bd3['user'],$config_bd3['pass'],$config_bd3['bname']);
		if($conexion){
		$sql	=  $quers;				
		
			$query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);					 
		 
		 while($row = @mysqli_fetch_array($query)){	
				$nueva=$row ['COD_ALERT_MASTER'].'?'.$row ['NAME_ALERT'].'?'.$row ['HORARIO_FLAG_LUNES'].'|'.$row ['HORARIO_FLAG_MARTES'].'|'.$row ['HORARIO_FLAG_MIERCOLES'].'|'.$row ['HORARIO_FLAG_JUEVES'].'|'.$row ['HORARIO_FLAG_VIERNES'].'|'.$row ['HORARIO_FLAG_SABADO'].'|'.$row ['HORARIO_FLAG_DOMINGO'].'?'.$row ['HORARIO_HORA_INICIO'].'?'.$row ['HORARIO_HORA_FIN'].'?'.$row ['EMAIL_FROMTO'].'?'.$row ['ACTIVE'].'?'.$row ['FECHA_CREATE'].'?'.$row ['ALARM_EXPRESION'].'?'.$row ['TYPE_EXPRESION'];
			if($cadena==' '){
				 $cadena=$nueva;
				 }else{
				 $cadena=$cadena.'#'.$nueva;
				 }
		 }
			if($count>0){
				return $cadena;	
			}else{
			
				return 0;
			}
			mysqli_close($conexion);			
		}else{
		$result = 0;
			return false;
		}
	}
	
	///////-----------------------------------------------------------------------------------------------------aLERTA
		public function trae_unidades_here($quers){
		global $config_bd3;
		$conta=0;
		$cadena=' ';
		$cadena2=' ';
		$conexion = mysqli_connect($config_bd3['host'],$config_bd3['user'],$config_bd3['pass'],$config_bd3['bname']);
		if($conexion){
		$sql	=  $quers;				
		
			$query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);					 
		 
			while($row = @mysqli_fetch_array($query)){
			
			
			if($cadena==' '){
			$cadena=$row['COD_ENTITY'];
			$cadena2=$row['uni_descrip_gral'];
			}else{
			$cadena=$cadena.'|'.$row['COD_ENTITY'];
			$cadena2=$cadena2.'|'.$row['uni_descrip_gral'];
			}
			//$conta++;
			}
		
		 
			if($count>0){
				return $cadena.'!'.$cadena2;	
			}else{
			
				return 0;
			}
			mysqli_close($conexion);			
		}else{
		$result = 0;
			return false;
		}
	}
		
	///////////////////---------------------------------------------------------------------------------------------- Alertas
		public function obtener_ureporte_alert($id_unit){
		global $config_bd;
		$table_last = $this->get_table_upos($id_unit);
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
		if($conexion){
		$sql	= "SELECT f.PLAQUE,   
					f.YEAR,     
					f.DESCRIPTION,
   
					f.COD_FLEET,
      
					  f.COD_ENTITY,
				
					FROM SAVL1120 f 
					WHERE e.COD_ENTITY = ".$id_unit;				
		
			$query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);					 
			if($count>0){
				$result = mysqli_fetch_array($query);
				
				return $result;				
			}else{
			
			    //$result = 0;
				return 0;
			}
			mysqli_close($conexion);			
		}else{
		    $result = 0;
			return false;
		}
	}
	
	
	
	

	///////////////////---------------------------------------------------------------------------------------------- Alertas
	
	public function obtener_list_alert(){
		global $config_bd3;
		$conta=0;
		$conexion = mysqli_connect($config_bd3['host'],$config_bd3['user'],$config_bd3['pass'],$config_bd3['bname']);
		if($conexion){
	 $sql	= " SELECT *
FROM ALERT_TIPO_VARIABLE
ORDER BY ID_TIPO_VARIABLE ";				
		
			$query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);					 
		
		
		while($row = @mysqli_fetch_array($query)){	
			
				 $arreglo[$conta][0] = $row['ID_TIPO_VARIABLE'];
				 $arreglo[$conta][1] = $row['DESCRIPCION'];
			
				 
				 $conta++;
				
			
			}		 
			if($count>0){
				return $arreglo;	
			}else{
			
				return false;
			}
			mysqli_close($conexion);			
		}else{
		$result = 0;
			return false;
		}
	}
	///////////////////---------------------------------------------------------------------------------------------- Alertas
	public function nue_gd_vari($quers){
		global $config_bd3;
		$conta=0;
		$conexion = mysqli_connect($config_bd3['host'],$config_bd3['user'],$config_bd3['pass'],$config_bd3['bname']);
		if($conexion){
$sql	=  $quers;				
		
			$query   = mysqli_query($conexion, $sql);
		//	$count = @mysqli_num_rows($query);					 
		 
			if($query){
				return 1;	
			}else{
			
				return 0;
			}
			mysqli_close($conexion);			
		}else{
		$result = 0;
			return false;
		}
	}
	///////////////////---------------------------------------------------------------------------------------------- Alertas
	public function elim_alertas($quers){
		global $config_bd3;
		$conta=0;
		$conexion = mysqli_connect($config_bd3['host'],$config_bd3['user'],$config_bd3['pass'],$config_bd3['bname']);
		if($conexion){
	 $sql	=  $quers;				
		
			$query   = mysqli_query($conexion, $sql);
		//	$count = @mysqli_num_rows($query);					 
		 
			if($query){
				return 1;	
			}else{
			
				return 0;
			}
			mysqli_close($conexion);			
		}else{
		$result = 0;
			return false;
		}
	}
	///////////////////---------------------------------------------------------------------------------------------- Alertas
	public function nue_gd_details($quers){
		global $config_bd3;
		$conta=0;
		$conexion = mysqli_connect($config_bd3['host'],$config_bd3['user'],$config_bd3['pass'],$config_bd3['bname']);
		if($conexion){
	 $sql	=  $quers;				
		
			$query   = mysqli_query($conexion, $sql);
		//	$count = @mysqli_num_rows($query);					 
		 
			if($query){
				return 1;	
			}else{
			
				return 0;
			}
			mysqli_close($conexion);			
		}else{
		$result = 0;
			return false;
		}
	}
	///////////////////---------------------------------------------------------------------------------------------- Alertas
	public function nue_gd_max($quers){
		global $config_bd3;
		$conta=0;
		$conexion = mysqli_connect($config_bd3['host'],$config_bd3['user'],$config_bd3['pass'],$config_bd3['bname']);
		if($conexion){
	 $sql	=  $quers;				
		
			$query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);					 
			$row = @mysqli_fetch_array($query);
		
			if($count>0){
				$data=$row ['COD_ALERT_MASTER'];
				return $data;	
			}else{
			
				return 0;
			}
			mysqli_close($conexion);			
		}else{
		$result = 0;
			return 0;
		}
	}
	
	
	
	////--------
  /***********************************/

  function WeekToDate($week, $year){
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
    //**Obtiene la tabla donde se almacenan los historicos de las unidades*************-//
	function queryDir($lati,$longi){
		return '';
		/*global $config_bd_sp;
		$conexion = mysqli_connect($config_bd_sp['host'],$config_bd_sp['user'],$config_bd_sp['pass'],$config_bd_sp['bname']);				
		if($conexion){
			$sql_stret	= "CALL SPATIAL_CALLES(".$longi.",".$lati.");";
//			echo $sql_stret; exit();
			$query 		= mysqli_query($conexion, $sql_stret);
			//$row_st   	= @mysqli_fetch_array($query);
			//$direccion 	= $row_st['ESTADO']." , ".$row_st['MUNICIPIO']."\n  , ".$row_st['ASENTAMIENTO']." , ".$row_st['CALLE'];
			return $query;
			mysqli_close($conexion);
		}else{
			return false;
		}*/
	}



 
 //---------------------------------------------------------------	
function get_num_hist26($hist, $idunit, $rtime, $filtro, $cliente,$radio){
		global $config_bd;
        
		$arreglo = array();
		$conta = -1;
		//$cant_histo = explode('|',$hist);
		
		$conexion = mysqli_connect($config_bd['host'],$config_bd['user'],$config_bd['pass'],$config_bd['bname']);		
	   if($conexion){
		   //for($a=0;$a<count($cant_histo);$a++){   			
$sql="SELECT 
E.COD_ENTITY,
CAST(E.GPS_DATETIME AS DATE) AS FECHA, 
G.DESCRIPTION,
E.LATITUDE, 
E.LONGITUDE,
E.VELOCITY,
E.GPS_DATETIME,
IF((SELECT MIN(DISTANCIA(P.LATITUDE,P.LONGITUDE,19.519437,-99.234427)) FROM ADM_GEOREFERENCIAS P WHERE P.ID_CLIENTE=1)<50,1,0)AS PARADAS
FROM ".$hist." E
LEFT JOIN ADM_UNIDADES G ON G.COD_ENTITY = E.COD_ENTITY 
WHERE E.COD_ENTITY IN (".$idunit.")
".$rtime."
".$filtro."
ORDER BY E.COD_ENTITY,E.GPS_DATETIME ASC;";		
					$query = mysqli_query($conexion, $sql);
					while($row = @mysqli_fetch_array($query)){						
						$conta = $conta+1;
						$arreglo[$conta][0] = $row['FECHA'];
						$arreglo[$conta][1] = $row['DESCRIPTION'];
						$arreglo[$conta][2] = $row['COD_ENTITY'];
						$arreglo[$conta][3] = $cant_histo[$a];
						$arreglo[$conta][4] = $row['LATITUDE'];
						$arreglo[$conta][5] = $row['LONGITUDE'];
						$arreglo[$conta][6] = $row['VELOCITY'];						
						$arreglo[$conta][7] = $row['DISTANCE'];
						$arreglo[$conta][8] = $row['PARADAS'];
						$arreglo[$conta][9] = $row['GPS_DATETIME'];
					}

			
			//}
			
		}else{
		return false;
		}
	
	   return $arreglo;
	} 
//---------------------------------------------------------------	
function get_num_hist27($hist, $idunit, $rtime){
		global $config_bd;
        
		$arreglo = array();
		$conta = -1;
		//$cant_histo = explode('|',$hist);
		
		$conexion = mysqli_connect($config_bd['host'],$config_bd['user'],$config_bd['pass'],$config_bd['bname']);		
	   if($conexion){
		   //for($a=0;$a<count($cant_histo);$a++){   			
$sql="SELECT 
E.COD_ENTITY,
G.DESCRIPTION AS UNIT,
CAST(E.GPS_DATETIME AS DATE) AS FECHA,
F.DESCRIPTION AS EVT,
E.LATITUDE,
E.LONGITUDE,
E.VELOCITY,
COUNT(E.COD_EVENT)AS EVENTOS
FROM ".$hist." E
LEFT JOIN ADM_EVENTOS F ON F.COD_EVENT = E.COD_EVENT
LEFT JOIN ADM_UNIDADES G ON G.COD_ENTITY = E.COD_ENTITY
WHERE E.COD_ENTITY IN (".$idunit.")
".$rtime."
GROUP BY E.COD_ENTITY, E.COD_EVENT, FECHA ORDER BY FECHA DESC, UNIT ASC;";		
					$query = mysqli_query($conexion, $sql);
					while($row = @mysqli_fetch_array($query)){						
						$conta = $conta+1;
						$arreglo[$conta][0] = $row['COD_ENTITY'];
						$arreglo[$conta][1] = $row['UNIT'];
						$arreglo[$conta][2] = $row['FECHA'];
						$arreglo[$conta][3] = $row['EVT'];
						$arreglo[$conta][4] = $row['LATITUDE'];
						$arreglo[$conta][5] = $row['LONGITUDE'];
						$arreglo[$conta][6] = $row['VELOCITY'];						
						$arreglo[$conta][7] = $row['EVENTOS'];
					}

			
			//}
			
		}else{
		return false;
		}
	
	   return $arreglo;
	} 
//---------------------------------------------------------------	
function get_num_hist28($hist, $idunit, $rtime,$cliente){
		global $config_bd;
        
		$arreglo = array();
		$conta = -1;
		//$cant_histo = explode('|',$hist);
		
		$conexion = mysqli_connect($config_bd['host'],$config_bd['user'],$config_bd['pass'],$config_bd['bname']);		
	   if($conexion){
		   //for($a=0;$a<count($cant_histo);$a++){   			
 $sql="SELECT 
E.COD_ENTITY,
G.DESCRIPTION AS UNIT,
CAST(E.GPS_DATETIME AS DATE) AS FECHA ,
F.DESCRIPTION AS EVT,
E.LATITUDE,
E.LONGITUDE,
E.VELOCITY,
E.ANGLE,
E.GPS_DATETIME,
(SELECT CONCAT('A ',TRUNCATE(DISTANCIA(P.LATITUDE,P.LONGITUDE,E.LATITUDE,E.LONGITUDE),2),' km de ', P.DESCRIPCION) AS DIS FROM  ADM_GEOREFERENCIAS P WHERE  P.ID_CLIENTE = ".$cliente." AND DISTANCIA(P.LATITUDE,P.LONGITUDE,E.LATITUDE,E.LONGITUDE) < .2 ORDER BY DIS ASC LIMIT 1) AS PDI
FROM ".$hist." E
LEFT JOIN ADM_EVENTOS  F ON F.COD_EVENT  = E.COD_EVENT
LEFT JOIN ADM_UNIDADES G ON G.COD_ENTITY = E.COD_ENTITY
WHERE E.COD_ENTITY IN (".$idunit.")
".$rtime."
ORDER BY E.GPS_DATETIME ASC;";		
					$query = mysqli_query($conexion, $sql);
					while($row = @mysqli_fetch_array($query)){						
						$conta = $conta+1;
						$arreglo[$conta][0] = $row['COD_ENTITY'];
						$arreglo[$conta][1] = $row['UNIT'];
						$arreglo[$conta][2] = $row['FECHA'];
						$arreglo[$conta][3] = $row['EVT'];
						$arreglo[$conta][4] = $row['LATITUDE'];
						$arreglo[$conta][5] = $row['LONGITUDE'];
						$arreglo[$conta][6] = $row['VELOCITY'];						
						$arreglo[$conta][7] = $row['ANGLE'];
						$arreglo[$conta][8] = $row['GPS_DATETIME'];
						$arreglo[$conta][9] = $row['PDI'];
						$arreglo[$conta][10]= $this->direccion_no_format($arreglo[$conta][4],$arreglo[$conta][5]);
					}

			
			//}
			
		}else{
		return false;
		}
	
	   return $arreglo;
	} 
//---------------------------------------------------------------	
function get_num_hist29($hist, $idunit, $rtime){
		global $config_bd;
        
		$arreglo = array();
		$conta = -1;
		//$cant_histo = explode('|',$hist);
		
		$conexion = mysqli_connect($config_bd['host'],$config_bd['user'],$config_bd['pass'],$config_bd['bname']);		
	   if($conexion){
		   //for($a=0;$a<count($cant_histo);$a++){   			
$sql="SELECT 
E.COD_ENTITY,
G.DESCRIPTION AS UNIT,
F.DESCRIPTION AS EVT,
E.LATITUDE,
E.LONGITUDE,
E.VELOCITY,
E.ANGLE,
E.GPS_DATETIME,
E.VELOCITY
FROM ".$hist." E
LEFT JOIN ADM_EVENTOS  F ON F.COD_EVENT  = E.COD_EVENT
LEFT JOIN ADM_UNIDADES G ON G.COD_ENTITY = E.COD_ENTITY
WHERE E.COD_ENTITY IN (".$idunit.")
".$rtime."
ORDER BY E.GPS_DATETIME DESC ";		
					$query = mysqli_query($conexion, $sql);
					while($row = @mysqli_fetch_array($query)){						
						$conta = $conta+1;
						$arreglo[$conta][0] = $row['COD_ENTITY'];
						$arreglo[$conta][1] = $row['UNIT'];
						$arreglo[$conta][2] = $row['GPS_DATETIME'];
						$arreglo[$conta][3] = $row['EVT'];
						$arreglo[$conta][4] = $row['LATITUDE'];
						$arreglo[$conta][5] = $row['LONGITUDE'];
						$arreglo[$conta][6] = $row['VELOCITY'];						
						$arreglo[$conta][7] = $row['ANGLE'];
						$arreglo[$conta][8] = $row['VELOCITY'];
						$arreglo[$conta][9] = $this->direccion_no_format($arreglo[$conta][4],$arreglo[$conta][5]);
						//$arreglo[$conta][9] = $row['PDI'];
					}

			
			//}
			
		}else{
		return false;
		}
	
	   return $arreglo;
	} 		
}
?>
