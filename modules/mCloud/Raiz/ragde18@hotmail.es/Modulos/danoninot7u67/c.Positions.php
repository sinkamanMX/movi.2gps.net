<?php
/* 
 *  @package             4TOGO
 *  @name                Obtiene la ultima pocision de las unidades de la BD 192.168.6.45
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          02-12-2010 
**/
class cPositions{
	
	/***** NUEVAS FUNCIONES ******/
	/* FUNCION CAMBIADA 300811 * /

/*----------------------------------------------------------------------------*/


	
	function get_num_hist($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
		$sql = "SELECT CONCAT(g.DESCRIPTION,'-',g.PLAQUE) AS UNIT, e.GPS_DATETIME , f.DESCRIPTION AS EVT, e.LATITUDE, e.LONGITUDE, e.VELOCITY, e.ANGLE
				 FROM ".$hist." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE e.COD_ENTITY = ".$idunit."
				 ".$rtime."
				 ".$filtro."
				 ORDER BY GPS_DATETIME";
//			echo $sql."<br><br>"; exit();
			$query = mysqli_query($conexion, $sql);
			
			//$row   = @mysqli_fetch_array($query);
			//$count = @mysqli_num_rows($query);
			return $query;
			mysqli_close($conexion);
		}else{
			return false;
		}
	}
	
	
	function get_num_hist_2($hist, $idunit, $rtime, $filtro){
	global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){			
 $sql = "SELECT CAST(e.GPS_DATETIME AS DATE ) AS FECHA , f.DESCRIPTION AS EVT, COUNT(e.COD_EVENT) AS EVENTOS
				 FROM ".$cant_histo[$a]." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE e.COD_ENTITY IN (".$idunit.")
				 ".$rtime."
				 ".$filtro."
				  GROUP BY  FECHA, e.COD_EVENT  ORDER BY e.GPS_DATETIME DESC";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				
				
				$arreglo[$conta][0] = $row['FECHA'];
				$arreglo[$conta][1] = utf8_encode($row['EVT']);
				$arreglo[$conta][2] = $row['EVENTOS'];
								
				
				$conta = $conta+1;
			}			
}
			mysqli_close($conexion);
		}else{
			return false;
		}
		return $arreglo;
	}
//----------------------------------------------------------------------------------------------
public function obtener_ureporteChom($id_unit){
		global $config_bd2;
		$table_last = $this->get_table_upos($id_unit);
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
		if($conexion){
	 $sql	= "SELECT f.PLAQUE,f.YEAR,f.DESCRIPTION,    
			                  IF (e.GPS_DATETIME IS NULL, '0000-00-00 00:00:00',e.GPS_DATETIME) AS GPS_DATETIME ,
							  IF(g.DESCRIPTION IS NULL,'NO HA REPORTADO',g.DESCRIPTION) AS DESC_EVT,     
							  IF(e.VELOCITY IS NULL,0,e.VELOCITY) AS VELOCITY,
							  f.COD_FLEET,
                              IF(e.LATITUDE IS NULL,0,e.LATITUDE) AS LATITUDE,
						      IF(e.LONGITUDE IS NULL,0,e.LONGITUDE) AS LONGITUDE,
					          f.COD_ENTITY,
						      IF (g.PRIORITY is null,0,g.PRIORITY) as PRIORITY,
							  e.MOTOR,
							  e.VELOCITY AS TURN,
							  e.ANGLE
						FROM  SAVL1120 f
						LEFT JOIN ".$table_last." e ON e.COD_ENTITY = f.COD_ENTITY
						LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.`COD_EVENT`
						WHERE e.COD_ENTITY = ".$id_unit;				

			$query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);					 
			if($query){
				$result = mysqli_fetch_array($query);
				
				return $result;				
			}else{
			
			    $result = 0;
				return $result;
			}
			mysqli_close($conexion);			
		}else{
		$result = 0;
			return false;
		}
	}
//----------------------------------------------------------------------------------------------------------------		

	
	public function obtener_ureporte_2($id_unit,$fecha,$cliente){
		global $config_bd2;
		$table_last = $this->get_table_hist($id_unit);
		$conta=0;
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
		if($conexion){
$sql	= "SELECT f.PLAQUE,f.YEAR,f.DESCRIPTION,
			                  IF (e.GPS_DATETIME IS NULL, '0000-00-00 00:00:00',e.GPS_DATETIME) AS GPS_DATETIME ,
							  IF(g.DESCRIPTION IS NULL,'NO HA REPORTADO',g.DESCRIPTION) AS DESC_EVT,
							  IF(e.VELOCITY IS NULL,0,e.VELOCITY) AS VELOCITY,
							  f.COD_FLEET,
                              IF(e.LATITUDE IS NULL,0,e.LATITUDE) AS LATITUDE,
						      IF(e.LONGITUDE IS NULL,0,e.LONGITUDE) AS LONGITUDE,
					          f.COD_ENTITY,
							  TIME_TO_SEC(CAST(GPS_DATETIME AS TIME)) AS MINI,
						      IF (g.PRIORITY is null,0,g.PRIORITY) as PRIORITY,
							  e.MOTOR,
							  e.VELOCITY AS TURN,
							  e.ANGLE,
							  IF(g.DESCRIPTION LIKE '%ABIERTA%',3,
							    IF(g.DESCRIPTION LIKE '%ASISTENCIA%',2,
								  IF(g.DESCRIPTION LIKE '%MACROCENTRO%',5,
									  IF(g.DESCRIPTION LIKE '%EXCESO%',4,
									    IF(g.DESCRIPTION LIKE '%BOT%N%P%NICO%',1,6))))) AS PRIORIDAD,
							  IF(g.DESCRIPTION LIKE '%ABIERTA%','public/images/puerta.png',
							    IF(g.DESCRIPTION LIKE '%ASISTENCIA%','public/images/asistencia.png',
								  IF(g.DESCRIPTION LIKE '%MACROCENTRO%','public/images/base.jpg',
									  IF(g.DESCRIPTION LIKE '%EXCESO%','public/images/velocidad.jpg',
									    IF(g.DESCRIPTION LIKE '%BOT%N%P%NICO%','public/images/panico.jpg','public/images/Alert.png'))))) AS ICONO,
							  IF(g.DESCRIPTION LIKE '%ABIERTA%','SI','NO') AS PUERTA,
							  IF ((SELECT concat('A ',TRUNCATE(DISTANCIA(P.LATITUDE,P.LONGITUDE,e.LATITUDE,e.LONGITUDE),2),' km de ', P.DESCRIPTION) AS DIS FROM SAVL_G_PRIN P WHERE P.COD_CLIENT = ".$cliente." AND DISTANCIA(P.LATITUDE,P.LONGITUDE,e.LATITUDE,e.LONGITUDE) < .2 ORDER BY DIS ASC LIMIT 1) IS NULL AND g.DESCRIPTION LIKE '%ABIERTA%','SI','NO') AS ABIERTA_FUERA,
							 (SELECT concat('A ',TRUNCATE(DISTANCIA(P.LATITUDE,P.LONGITUDE,e.LATITUDE,e.LONGITUDE),2),
             				  ' km de ', P.DESCRIPTION) AS DIS
								 FROM SAVL_G_PRIN P
								 WHERE  P.COD_CLIENT = ".$cliente." AND
     							  DISTANCIA(P.LATITUDE,P.LONGITUDE,e.LATITUDE,e.LONGITUDE) < .2 ORDER BY DIS ASC LIMIT 1) AS PDI  
						
						FROM  SAVL1120 f
						LEFT JOIN ".$table_last." e ON e.COD_ENTITY = f.COD_ENTITY
						LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.COD_EVENT
						WHERE e.COD_ENTITY = ".$id_unit." AND
                        ((g.DESCRIPTION LIKE '%ASISTENCIA%') OR (g.DESCRIPTION LIKE '%MACROCENTRO%') OR
						 (g.DESCRIPTION LIKE '%EXCESO%') OR
						 (g.DESCRIPTION LIKE '%BOT%N%P%NICO%') OR (g.DESCRIPTION LIKE '%PUERTA%ABIERTA%')) AND
                        GPS_DATETIME BETWEEN '".$fecha." 00:00:00' AND '".$fecha." 23:59:00'
						ORDER BY GPS_DATETIME";				
			/*$sql   = "SELECT LONGITUDE,LATITUDE,COD_ENTITY
					 FROM ".$table_last."
				 	 WHERE COD_ENTITY = ".$id_unit."
					 LIMIT 1";	*/
			$query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);		
		
		
			while($row = @mysqli_fetch_array($query)){	
			  if($row['PUERTA']=='SI'){
			    if($row['ABIERTA_FUERA'] == 'SI'){
				  $arreglo[$conta][0] = $row['PLAQUE'];
				  $arreglo[$conta][1] = $row['DESCRIPTION'];
				  $arreglo[$conta][2] = $row['GPS_DATETIME'];
				  $arreglo[$conta][3] = $row['DESC_EVT'];
				  $arreglo[$conta][4] = $row['VELOCITY'];
				  $arreglo[$conta][5] = $row['LATITUDE'];
				  $arreglo[$conta][6] = $row['LONGITUDE'];
				  $arreglo[$conta][7] = $row['ANGLE'];
				  $arreglo[$conta][8] = $row['MINI'];
				  $arreglo[$conta][9] = $row['ICONO'];
				   $arreglo[$conta][10] = $row['PDI'];
				   $arreglo[$conta][11] = $row['PRIORIDAD'];
				  $conta++;
			    }
		      } else {
			      $arreglo[$conta][0] = $row['PLAQUE'];
				  $arreglo[$conta][1] = $row['DESCRIPTION'];
				  $arreglo[$conta][2] = $row['GPS_DATETIME'];
				  $arreglo[$conta][3] = $row['DESC_EVT'];
				  $arreglo[$conta][4] = $row['VELOCITY'];
				  $arreglo[$conta][5] = $row['LATITUDE'];
				  $arreglo[$conta][6] = $row['LONGITUDE'];
				  $arreglo[$conta][7] = $row['ANGLE'];
				  $arreglo[$conta][8] = $row['MINI'];
				  $arreglo[$conta][9] = $row['ICONO'];
				  $arreglo[$conta][10] = $row['PDI'];
				   $arreglo[$conta][11] = $row['PRIORIDAD'];
				  $conta++;
			  }
			}		 
			
				if($count>0){	
				return $arreglo;				
			}else{
				return false;
			}
			mysqli_close($conexion);			
		}else{
			return false;
		}
	}
	
	/*function get_hist_danone($id_unit,$fecha){
	  global $config_bd2;
		$table_last = $this->get_table_hist($id_unit);
		$conta=0;
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
		if($conexion){
	      $sql="SELECT e.COD_ENTITY,g.DESCRIPTION AS UNIT,
                       cast(e.GPS_DATETIME AS DATE) AS FECHA ,
                       f.DESCRIPTION AS EVT,
                       e.LATITUDE,
                       e.LONGITUDE,
                       e.VELOCITY,
                       e.ANGLE,
                       e.GPS_DATETIME,
                      (SELECT concat('A ',TRUNCATE(DISTANCIA(P.LATITUDE,P.LONGITUDE,e.LATITUDE,e.LONGITUDE),2),' km de ', P.DESCRIPTION) AS DIS
                       FROM SAVL_G_PRIN P
                       WHERE  P.COD_CLIENT = ".$client." AND
                       DISTANCIA(P.LATITUDE,P.LONGITUDE,e.LATITUDE,e.LONGITUDE) < .2 ORDER BY DIS ASC LIMIT 1) AS PDI

						 FROM ".$cant_histo[$a]." e
						 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
						 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
						 WHERE e.COD_ENTITY IN (".$idunit.")
						 ".$rtime."
						 ".$filtro."
						 ORDER BY e.GPS_DATETIME ASC";	
	  $query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);		
		
		
			while($row = @mysqli_fetch_array($query)){	
			
				 $arreglo[$conta][0] = $row['PLAQUE'];
				 $arreglo[$conta][1] = $row['DESCRIPTION'];
				 $arreglo[$conta][2] = $row['GPS_DATETIME'];
				 $arreglo[$conta][3] = $row['DESC_EVT'];
				 $arreglo[$conta][4] = $row['VELOCITY'];
				 $arreglo[$conta][5] = $row['LATITUDE'];
				 $arreglo[$conta][6] = $row['LONGITUDE'];
				 $arreglo[$conta][7] = $row['ANGLE'];
				 $arreglo[$conta][8] = $row['MINI'];
				 $conta++;
				
			
			}		 
			
				if($count>0){	
				return $arreglo;				
			}else{
				return false;
			}
			mysqli_close($conexion);			
		}else{
			return false;
		}
	}
    
	}*/
	
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
		///////////////////---------------------------------------------------------------------------------------------- Alertas nueva xc
	public function obtener_event_xu($queryx){
		global $config_bd2;
		$arreglo = array();
			$conta = 0;
		//$table_last = $this->get_table_upos($id_unit);
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
		if($conexion){
			
		$sql	= $queryx;				
		
			$query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			while($row = @mysqli_fetch_array($query)){					 
			
				 $arreglo[$conta][0] = $row['DES_EVENT'];
				 $arreglo[$conta][1] = $row['COD_EVENT'];
				  $arreglo[$conta][2] = $row['DES_UNID'];
				   $arreglo[$conta][3] = $row['COD_ENTITY'];
			$conta++;
			}
			return $arreglo;
			mysqli_close($conexion);			
		}else{
		    $result = 0;
			return false;
		}
	}
	
	
	
	
	
	
	
	
	///////////////////---------------------------------------------------------------------------------------------- Alertas
	
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
	
	
	
/** --------------------------------------------------------FUNCIONES PARA OBTENER HISTORICO **/

	function get_num_hist0($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);				
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){			
$sql = "SELECT e.COD_ENTITY, f.DESCRIPTION AS EVT, e.LATITUDE, e.LONGITUDE
				 FROM ".$cant_histo[$a]." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE e.COD_ENTITY IN (".$idunit.")
				 ".$rtime."
				 ".$filtro."
				 AND e.VELOCITY > 3";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				
				$arreglo[$conta][0] = utf8_encode($row['EVT']);
				$arreglo[$conta][1] = $row['FECHA'];
				$arreglo[$conta][2] = $row['LATITUDE'];
				$arreglo[$conta][3] = $row['LONGITUDE'];				
				
				$conta = $conta+1;
			}				
}
			mysqli_close($conexion);
		}else{
			return false;
		}
		return $arreglo;		
	}
/*----------------------------------------------------------------------------*/	
	function get_num_hist1($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){
 $sql = "SELECT e.COD_ENTITY,CONCAT(g.DESCRIPTION,'-',g.PLAQUE) AS UNIT, CAST(e.GPS_DATETIME AS DATE ) AS FECHA , f.DESCRIPTION AS EVT, e.LATITUDE, e.LONGITUDE, e.VELOCITY, e.ANGLE,COUNT(e.COD_EVENT) AS EVENTOS, e.COD_EVENT
				 FROM ".$cant_histo[$a]." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE e.COD_ENTITY IN (".$idunit.")
				 ".$rtime."
				 ".$filtro."
				  GROUP BY e.COD_ENTITY ,FECHA ORDER BY FECHA ASC";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				
				$arreglo[$conta][0] = $row['UNIT'];
				$arreglo[$conta][1] = $row['FECHA'];
				$arreglo[$conta][2] = utf8_encode($row['EVT']);
				$arreglo[$conta][3] = $row['EVENTOS'];
				$arreglo[$conta][4] = $row['LATITUDE'];
				$arreglo[$conta][5] = $row['LONGITUDE'];
				$arreglo[$conta][6] = $row['COD_ENTITY'];				
				
				$conta = $conta+1;
			}				
}
			mysqli_close($conexion);
		}else{
			return false;
		}
		natsort($arreglo);
		return $arreglo;
	}
	/*-----------------------------------------------------------------------------------------*/
	function get_num_hist_1($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){
 $sql = "SELECT e.COD_ENTITY, g.DESCRIPTION AS UNIT, CAST(e.GPS_DATETIME AS DATE ) AS FECHA , f.DESCRIPTION AS EVT, e.LATITUDE, e.LONGITUDE, e.VELOCITY, e.ANGLE,COUNT(e.COD_EVENT) AS EVENTOS, e.COD_EVENT
				 FROM ".$cant_histo[$a]." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE e.COD_ENTITY IN (".$idunit.")
				 ".$rtime."
				 ".$filtro."
				 GROUP BY e.COD_ENTITY, e.COD_EVENT, FECHA ORDER BY FECHA DESC";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				
				$arreglo[$conta][0] = $row['UNIT'];
				$arreglo[$conta][1] = $row['FECHA'];
				$arreglo[$conta][2] = utf8_encode($row['EVT']);
				$arreglo[$conta][3] = $row['EVENTOS'];
				$arreglo[$conta][4] = $row['LATITUDE'];
				$arreglo[$conta][5] = $row['LONGITUDE'];
				$arreglo[$conta][6] = $row['COD_ENTITY'];		
				$arreglo[$conta][7] = $row['VELOCITY'];			
				
				$conta = $conta+1;
			}				
}
			mysqli_close($conexion);
		}else{
			return false;
		}
		return $arreglo;
	}
//------------------------------------------------------------------------------------------------

function get_num_histX3($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){			
$sql = "SELECT e.COD_ENTITY,CONCAT(g.DESCRIPTION,'-',g.PLAQUE) AS UNIT, CAST(e.GPS_DATETIME AS DATE ) AS FECHA , f.DESCRIPTION AS EVT, e.LATITUDE, e.LONGITUDE, e.VELOCITY, e.ANGLE,e.GPS_DATETIME
						 FROM ".$cant_histo[$a]." e
						 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
						 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
						 WHERE e.COD_ENTITY IN (".$idunit.")
						 ".$rtime."
						 ".$filtro."
						 ORDER BY COD_ENTITY DESC, e.GPS_DATETIME ";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				
				$arreglo[$conta][0] = $row['UNIT'];
				$arreglo[$conta][1] = $row['FECHA'];
				$arreglo[$conta][2] = utf8_encode($row['EVT']);
				$arreglo[$conta][3] = $row['VELOCITY'];
				$arreglo[$conta][4] = $row['LATITUDE'];
				$arreglo[$conta][5] = $row['LONGITUDE'];				
				$arreglo[$conta][6] = $row['ANGLE'];
				$arreglo[$conta][7] = $row['GPS_DATETIME'];
				
				$conta = $conta+1;
			}				
}
			mysqli_close($conexion);
		}else{
			return false;
		}
		    return $arreglo;		
	}


/*-------------------------------------------------------------------------------------------------*/
function get_num_hist_x1x($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){
$sql = "SELECT e.COD_ENTITY, CONCAT(g.DESCRIPTION,'-',g.PLAQUE) AS UNIT, CAST(e.GPS_DATETIME AS DATE ) AS FECHA , f.DESCRIPTION AS EVT, e.LATITUDE, e.LONGITUDE, e.VELOCITY, e.ANGLE,COUNT(e.COD_EVENT) AS EVENTOS, e.COD_EVENT
				 FROM ".$cant_histo[$a]." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE e.COD_ENTITY IN (".$idunit.")
				 ".$rtime."
				 ".$filtro."
				 GROUP BY UNIT";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				
				$arreglo[$conta][0] = $row['UNIT'];
				$arreglo[$conta][1] = $row['FECHA'];
				$arreglo[$conta][2] = utf8_encode($row['EVT']);
				$arreglo[$conta][3] = $row['EVENTOS'];
				$arreglo[$conta][4] = $row['LATITUDE'];
				$arreglo[$conta][5] = $row['LONGITUDE'];
				$arreglo[$conta][6] = $row['COD_ENTITY'];				
				
				$conta = $conta+1;
			}				
}
			mysqli_close($conexion);
		}else{
			return false;
		}
		return $arreglo;
	}
	
	
	
function get_geos_new($cod_client, $tgeo){
global $config_bd2;

$arreglo = array();
//$conta = -1;
//$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
$CLIENTE   = $cod_client;
//

$enlace =  mysql_connect($config_bd2['host'], $config_bd2['user'], $config_bd2['pass']);
if (!$enlace) {
   $valor = 'fallo'. mysql_error();
}else{
   $valor = 'Conectado satisfactoriamente';
}


mysql_select_db($config_bd2['bname'], $enlace);

$sql = "SELECT  COD_OBJECT_MAP, DESCRIPTION FROM SAVL1160 WHERE COD_CLIENT = ".$cod_client." AND
	               TYPE_OBJECT_MAP = 'P' AND
	                COD_TYPE_GEO = ".$tgeo;
$result = mysql_query($sql);

while($row = mysql_fetch_array($result)){
	$conta = $conta +1;
 	$arreglo[$conta][0] = $row['COD_OBJECT_MAP'];
    $arreglo[$conta][1] = utf8_encode($row['DESCRIPTION']);
  }
  
  

mysql_close($enlace);

/*if($conexion){
		
	$sql = "SELECT  COD_OBJECT_MAP, DESCRIPTION FROM SAVL1160 WHERE COD_CLIENT = ".$CLIENTE." AND
	               TYPE_OBJECT_MAP = 'P' AND
	                COD_TYPE_GEO = ".$tgeo;
		$query =$db->sqlQuery($sql);
		$count= $db->sqlEnumRows($query);
		while($row = @mysqli_fetch_array($query)){
					$arreglo[$conta][0] = $row['COD_OBJECT_MAP'];
					$arreglo[$conta][1] = utf8_encode($row['DESCRIPTION']);
					
		
		}
		mysqli_close($conexion);
		$valor = "si se conecto";
}
else{
	$valor = mysqli_connect_error();
}
return ;*/
return $sql;
}
/** --------------------------------------------------------FUNCIONES PARA OBTENER HISTORICO2 **/

	function get_num_hist2($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){			
 $sql = "SELECT e.COD_ENTITY,CONCAT(g.DESCRIPTION,'-',g.PLAQUE) AS UNIT, CAST(e.GPS_DATETIME AS DATE ) AS FECHA , f.DESCRIPTION AS EVT, e.LATITUDE, e.LONGITUDE, e.VELOCITY, e.ANGLE,COUNT(e.COD_EVENT) AS EVENTOS
				 FROM ".$cant_histo[$a]." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE e.COD_ENTITY IN (".$idunit.")
				 ".$rtime."
				 ".$filtro."
				  GROUP BY FECHA ORDER BY FECHA ASC";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				
				$arreglo[$conta][0] = $row['UNIT'];
				$arreglo[$conta][1] = $row['FECHA'];
				$arreglo[$conta][2] = utf8_encode($row['EVT']);
				$arreglo[$conta][3] = $row['EVENTOS'];
				$arreglo[$conta][4] = $row['LATITUDE'];
				$arreglo[$conta][5] = $row['LONGITUDE'];				
				$arreglo[$conta][6] = $row['COD_ENTITY'];				
				
				$conta = $conta+1;
			}			
}
			mysqli_close($conexion);
		}else{
			return false;
		}
		return $arreglo;
	}

/** --------------------------------------------------------FUNCIONES PARA OBTENER HISTORICO2 **/

function get_num_hist3($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){			
$sql = "SELECT e.COD_ENTITY,
			CONCAT(g.DESCRIPTION,'-',g.PLAQUE) AS UNIT, 
			CAST(e.GPS_DATETIME AS DATE ) AS FECHA , 
			f.DESCRIPTION AS EVT, 
			e.LATITUDE, e.LONGITUDE, 
			e.VELOCITY, 
			e.ANGLE,
			e.GPS_DATETIME
						 FROM ".$cant_histo[$a]." e
						 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
						 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
						 WHERE e.COD_ENTITY IN (".$idunit.")
						 ".$rtime."
						 ".$filtro."
						 ORDER BY GPS_DATETIME ASC";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				
				$arreglo[$conta][0] = $row['UNIT'];
				$arreglo[$conta][1] = $row['FECHA'];
				$arreglo[$conta][2] = utf8_encode($row['EVT']);
				$arreglo[$conta][3] = $row['VELOCITY'];
				$arreglo[$conta][4] = $row['LATITUDE'];
				$arreglo[$conta][5] = $row['LONGITUDE'];				
				$arreglo[$conta][6] = $row['ANGLE'];
				$arreglo[$conta][7] = $row['GPS_DATETIME'];
				$arreglo[$conta][8] = $row['COD_ENTITY'];
				
				
				
				$conta = $conta+1;
			}				
}
			mysqli_close($conexion);
		}else{
			return false;
		}
		    return $arreglo;		
	}
	//----------------------------------------------------------------------
	
	function get_num_hist3_x($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){			
$sql = "SELECT e.COD_ENTITY,
			CONCAT(g.DESCRIPTION,'-',g.PLAQUE) AS UNIT, 
			CAST(e.GPS_DATETIME AS DATE ) AS FECHA , 
			f.DESCRIPTION AS EVT, 
			e.LATITUDE, 
			e.LONGITUDE, 
			e.VELOCITY, 
			e.ANGLE,
			e.GPS_DATETIME
						 FROM ".$cant_histo[$a]." e
						 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
						 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
						 WHERE e.COD_ENTITY IN (".$idunit.")
						 ".$rtime."
						 ".$filtro."
						 ORDER BY e.GPS_DATETIME ASC";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				
				$arreglo[$conta][0] = $row['UNIT'];
				$arreglo[$conta][1] = $row['FECHA'];
				$arreglo[$conta][2] = utf8_encode($row['EVT']);
				$arreglo[$conta][3] = $row['VELOCITY'];
				$arreglo[$conta][4] = $row['LATITUDE'];
				$arreglo[$conta][5] = $row['LONGITUDE'];				
				$arreglo[$conta][6] = $row['ANGLE'];
				$arreglo[$conta][7] = $row['GPS_DATETIME'];
				
				$conta = $conta+1;
			}				
}
			mysqli_close($conexion);
		}else{
			return false;
		}
		    return $arreglo;		
	}
	
	///--------------------------------------------------	
	function get_num_hist3_x2($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
			for($a=0;$a<count($cant_histo);$a++){			
					echo $sql = "SELECT f.PLAQUE,f.YEAR,f.DESCRIPTION,    
									IF (e.GPS_DATETIME IS NULL, '0000-00-00 00:00:00',e.GPS_DATETIME) AS GPS_DATETIME ,
									IF(g.DESCRIPTION IS NULL,'NO HA REPORTADO',g.DESCRIPTION) AS DESC_EVT,     
									IF(e.VELOCITY IS NULL,0,e.VELOCITY) AS VELOCITY,
									f.COD_FLEET,
									IF(e.LATITUDE IS NULL,0,e.LATITUDE) AS LATITUDE,
									IF(e.LONGITUDE IS NULL,0,e.LONGITUDE) AS LONGITUDE,
									f.COD_ENTITY,
									IF (g.PRIORITY is null,0,g.PRIORITY) as PRIORITY,
									e.MOTOR,
									e.VELOCITY AS TURN,
									e.ANGLE
						 FROM  SAVL1120 f
						 LEFT JOIN  ".$cant_histo[$a]." e ON e.COD_ENTITY = f.COD_ENTITY
						LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.`COD_EVENT`
						 WHERE e.COD_ENTITY IN (".$idunit.")
						 ".$rtime."
						 ".$filtro."
						 ORDER BY g.PRIORITY DESC";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				
				$arreglo[$conta][0] = $row['UNIT'];
				$arreglo[$conta][1] = $row['FECHA'];
				$arreglo[$conta][2] = utf8_encode($row['EVT']);
				$arreglo[$conta][3] = $row['VELOCITY'];
				$arreglo[$conta][4] = $row['LATITUDE'];
				$arreglo[$conta][5] = $row['LONGITUDE'];				
				$arreglo[$conta][6] = $row['ANGLE'];
				$arreglo[$conta][7] = $row['GPS_DATETIME'];
				
				$conta = $conta+1;
			}				
}
			mysqli_close($conexion);
		}else{
			return false;
		}
		    return $arreglo;		
	}
	
	
	
	
	///----------------------------------------------------------------------------------------------------------------------
	function get_num_hist3_x1($hist, $idunit, $rtime, $filtro, $client){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){			
$sql = "SELECT e.COD_ENTITY,g.DESCRIPTION AS UNIT,
cast(e.GPS_DATETIME AS DATE) AS FECHA ,
f.DESCRIPTION AS EVT,
e.LATITUDE,
e.LONGITUDE,
e.VELOCITY,
e.ANGLE,
e.GPS_DATETIME,
(SELECT concat('A ',TRUNCATE(DISTANCIA(P.LATITUDE,P.LONGITUDE,e.LATITUDE,e.LONGITUDE),2),
               ' km de ', P.DESCRIPTION) AS DIS
 FROM SAVL_G_PRIN P
 WHERE  P.COD_CLIENT = ".$client." AND
       DISTANCIA(P.LATITUDE,P.LONGITUDE,e.LATITUDE,e.LONGITUDE) < .2 ORDER BY DIS ASC LIMIT 1) AS PDI

						 FROM ".$cant_histo[$a]." e
						 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
						 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
						 WHERE e.COD_ENTITY IN (".$idunit.")
						 ".$rtime."
						 ".$filtro."
						 ORDER BY e.GPS_DATETIME ASC";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				
				$arreglo[$conta][0] = $row['UNIT'];
				$arreglo[$conta][1] = $row['FECHA'];
				$arreglo[$conta][2] = utf8_encode($row['EVT']);
				$arreglo[$conta][3] = $row['VELOCITY'];
				$arreglo[$conta][4] = $row['LATITUDE'];
				$arreglo[$conta][5] = $row['LONGITUDE'];				
				$arreglo[$conta][6] = $row['ANGLE'];
				$arreglo[$conta][7] = $row['GPS_DATETIME'];
				$arreglo[$conta][8] = $row['PDI'];
				
				$conta = $conta+1;
			}				
}
			mysqli_close($conexion);
		}else{
			return false;
		}
		    return $arreglo;		
	}
	
	////-------------------------------------------------------------------------------
	
	function get_pdi_panel($hist, $idunit, $rtime, $filtro, $client){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = $this->get_table_upos($idunit);
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){			
$sql = "SELECT e.COD_ENTITY,g.DESCRIPTION AS UNIT,
cast(e.GPS_DATETIME AS DATE) AS FECHA ,
f.DESCRIPTION AS EVT,
e.LATITUDE,
e.LONGITUDE,
e.VELOCITY,
e.ANGLE,
e.GPS_DATETIME,
(SELECT concat('A ',TRUNCATE(DISTANCIA(P.LATITUDE,P.LONGITUDE,e.LATITUDE,e.LONGITUDE),2),
               ' km de ', P.DESCRIPTION) AS DIS
 FROM SAVL_G_PRIN P
 WHERE  P.COD_CLIENT = ".$client." AND
       DISTANCIA(P.LATITUDE,P.LONGITUDE,e.LATITUDE,e.LONGITUDE) < .2 ORDER BY DIS ASC LIMIT 1) AS PDI

						 FROM ".$cant_histo[$a]." e
						 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
						 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
						 WHERE e.COD_ENTITY IN (".$idunit.")
						 ".$rtime."
						 ".$filtro."
						 ORDER BY e.GPS_DATETIME ASC";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				
				$arreglo[$conta][0] = $row['UNIT'];
				$arreglo[$conta][1] = $row['FECHA'];
				$arreglo[$conta][2] = utf8_encode($row['EVT']);
				$arreglo[$conta][3] = $row['VELOCITY'];
				$arreglo[$conta][4] = $row['LATITUDE'];
				$arreglo[$conta][5] = $row['LONGITUDE'];				
				$arreglo[$conta][6] = $row['ANGLE'];
				$arreglo[$conta][7] = $row['GPS_DATETIME'];
				$arreglo[$conta][8] = $row['PDI'];
				
				$conta = $conta+1;
			}				
}
			mysqli_close($conexion);
		}else{
			return false;
		}
		    return $arreglo;		
	}
	
	
	
	
	
//------------------------------------------------------------------------
function get_num_hist4($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
$sql="SELECT CAST(GPS_DATETIME AS DATE) AS FECHA, COUNT(COD_ENTITY) AS EVENTOS, MAX(VELOCITY) AS M , ROUND(AVG(VELOCITY),2) AS P
FROM ".$hist." H WHERE 
H.COD_ENTITY IN (".$idunit.")
".$rtime."
".$filtro."
GROUP BY FECHA ORDER BY FECHA";
			$query = mysqli_query($conexion, $sql);
			return $query;
			mysqli_close($conexion);
		}else{
			return false;
		}
	}
//------------------------------------------------------------------------
function get_num_hist5($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){			
$sql="SELECT U.COD_ENTITY AS UNIX, CAST(GPS_DATETIME AS DATE) AS FECHA,CONCAT(U.PLAQUE,' ',U.DESCRIPTION)  AS UNIT, COUNT(H.COD_ENTITY)AS EVENTOS, MAX(H.VELOCITY) AS MV, ROUND(AVG(H.VELOCITY),2) AS PV
FROM ".$cant_histo[$a]." H INNER JOIN SAVL1120 U ON U.COD_ENTITY = H.COD_ENTITY 
WHERE H.COD_ENTITY IN (".$idunit.")
".$rtime." 
".$filtro."
GROUP BY H.COD_ENTITY,FECHA ORDER BY FECHA ASC";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				$arreglo[$conta][0] = $row['FECHA'];
				$arreglo[$conta][1] = $row['UNIT'];
				$arreglo[$conta][2] = $row['EVENTOS'];
				$arreglo[$conta][3] = $row['MV'];
				$arreglo[$conta][4] = $row['PV'];
				$arreglo[$conta][5] = $row['UNIX'];				
				
				$conta = $conta+1;
			}				
}
			mysqli_close($conexion);
		}else{
			return false;
		}
		return $arreglo;
	}
//------------------------------------------------------------------------
function get_num_hist6($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);			
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){		
$sql="SELECT H.COD_ENTITY,CAST(H.GPS_DATETIME AS DATE) AS FECHA, CONCAT(U.PLAQUE,' ',U.DESCRIPTION)  AS UND, H.VELOCITY, H.LATITUDE, H.LONGITUDE,H.ANGLE,
V.DESCRIPTION AS EVT,GPS_DATETIME FROM  ".$cant_histo[$a]." H 
INNER JOIN SAVL1120 U ON U.COD_ENTITY = H.COD_ENTITY 
INNER JOIN SAVL1260 V ON V.COD_EVENT  = H.COD_EVENT
WHERE H.COD_ENTITY IN (".$idunit.") ".$rtime." 
".$filtro."  ORDER BY GPS_DATETIME ASC;";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				$arreglo[$conta][0] = ($row['EVT'] != "") ? utf8_encode($row['EVT']) : "Sin Evento";
				$arreglo[$conta][1] = $row['FECHA'];
				$arreglo[$conta][2] = $row['VELOCITY'];
				$arreglo[$conta][3] = $row['LATITUDE'];
				$arreglo[$conta][4] = $row['LONGITUDE'];
				$arreglo[$conta][5] = $row['UND'];
				$arreglo[$conta][6] = $row['ANGLE'];
				$arreglo[$conta][7] = $row['GPS_DATETIME'];
				
				$conta = $conta+1;
			}			
}
mysqli_close($conexion);
		}else{
			return false;
		}
			return $arreglo;	
	}
	
/*----------------------------------------------------------------------------*/	
	function get_num_hist7($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
			$sql = "SELECT CONCAT(g.DESCRIPTION,'-',g.PLAQUE) AS UNIT, e.GPS_DATETIME , f.DESCRIPTION AS EVT, e.LATITUDE, e.LONGITUDE, e.VELOCITY, e.ANGLE
				 FROM ".$hist." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE e.COD_ENTITY IN ".$idunit."
				 ".$rtime."
				 ".$filtro."
				 ORDER BY GPS_DATETIME";
//			echo $sql."<br><br>"; exit();
			$query = mysqli_query($conexion, $sql);
			
			//$row   = @mysqli_fetch_array($query);
			//$count = @mysqli_num_rows($query);
			return $query;
			mysqli_close($conexion);
		}else{
			return false;
		}
	}	
//------------------------------------------------------------------------
	function get_num_hist8($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){			
 $sql = "SELECT e.LATITUDE, e.LONGITUDE,e.GPS_DATETIME,e.COD_ENTITY,CAST(e.GPS_DATETIME AS DATE) AS FECHA
				 FROM ".$cant_histo[$a]." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE e.COD_ENTITY IN (".$idunit.")
				  AND ABS(e.LATITUDE)  BETWEEN 12 AND 33 
  				  AND ABS(e.LONGITUDE) BETWEEN 80 AND 117
				  AND e.VELOCITY >3
				 ".$rtime."
				 ".$filtro." ORDER BY e.GPS_DATETIME ASC";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				$arreglo[$conta][0] = $row['LATITUDE'];
				$arreglo[$conta][1] = $row['LONGITUDE'];
				$arreglo[$conta][2] = $row['COD_ENTITY'];
				$arreglo[$conta][3] = $row['FECHA'];				
				$conta = $conta+1;	
			}
}
			mysqli_close($conexion);
		}else{
			return false;
		}
			return $arreglo;		
	}
//------------------------------------------------------------------------
	function get_num_hist9($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){			
	  $sql = "SELECT e.COD_ENTITY,CONCAT(g.DESCRIPTION,'-',g.PLAQUE) AS UNIT, CAST(e.GPS_DATETIME AS DATE ) AS FECHA , f.DESCRIPTION AS EVT, e.LATITUDE, e.LONGITUDE, e.VELOCITY, e.ANGLE, e.COD_EVENT ,e.GPS_DATETIME
	  FROM ".$cant_histo[$a]." e 
	  LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT 
	  LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY 
	  WHERE e.COD_ENTITY IN (".$idunit.") ".$rtime." ".$filtro." 
	  AND e.VELOCITY >3 ORDER BY e.COD_ENTITY,e.GPS_DATETIME ASC";	
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				$arreglo[$conta][0] = $row['GPS_DATETIME'];
				$arreglo[$conta][1] = $row['UNIT'];
				$arreglo[$conta][2] = utf8_decode($row['EVT']);	
				$arreglo[$conta][3] = $row['LATITUDE'];
				$arreglo[$conta][4] = $row['LONGITUDE'];
				$arreglo[$conta][5] = $row['ANGLE'];
				$arreglo[$conta][6] = $row['VELOCITY'];
				$conta = $conta+1;	
			}			
}
			mysqli_close($conexion);
		}else{
			return false;
		}
			return $arreglo;		
	}		
//------------------------------------------------------------------------
	function get_num_hist10($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){		
  $sql="SELECT e.GPS_DATETIME,e.COD_ENTITY,CONCAT(g.DESCRIPTION,'-',g.PLAQUE) AS UNIT, CAST(e.GPS_DATETIME AS DATE ) AS FECHA ,  e.LATITUDE, e.LONGITUDE FROM ".$cant_histo[$a]." e
LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT 
LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY 
WHERE e.COD_ENTITY IN (".$idunit.") ".$rtime." ".$filtro." GROUP BY FECHA,COD_ENTITY ORDER BY FECHA,COD_ENTITY ASC";
//WHERE e.COD_ENTITY IN (".$idunit.") ".$rtime." ".$filtro." GROUP BY FECHA,COD_ENTITY ORDER BY COD_ENTITY,e.GPS_DATETIME DESC";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				//echo $row['COD_ENTITY']."|".$row['FECHA']."|";
				$arreglo[$conta][0] = $row['UNIT'];
				$arreglo[$conta][1] = $row['FECHA'];
				$arreglo[$conta][2] = $row['COD_ENTITY'];
				$arreglo[$conta][3] = $row['LATITUDE'];
				$arreglo[$conta][4] = $row['LONGITUDE'];				
				$conta = $conta+1;	
			}			
}
			mysqli_close($conexion);
		}else{
			return false;
		}
			return $arreglo;		
	}	
//------------------------------------------------------------------------ PARA UNIDADES DETENIDAS -- rDetenido---

	function get_num_hist11($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
      
	  for($a=0;$a<count($cant_histo);$a++){ 
		  $sql = "SELECT e.GPS_DATETIME,CAST(e.GPS_DATETIME AS DATE ) AS FECHA , e.COD_EVENT, f.DESCRIPTION AS EVT
				 FROM ".$cant_histo[$a]." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE e.COD_ENTITY IN (".$idunit.")
				 ".$rtime."
				 ".$filtro."
				  GROUP BY FECHA ORDER BY FECHA ASC";

			$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			
			if($count>0){
				
			while($row = @mysqli_fetch_array($query)){
				
				$conta = $conta+1;
				 $arreglo[$conta][0] = $row['FECHA'];
				 $arreglo[$conta][1] = $row['EVT'];
				 $arreglo[$conta][2] = $row['GPS_DATETIME'];
				}
			}

		
			
		}	
		}else{
			return false;
		}
			@mysqli_close($conexion);
			return $arreglo;

	}

/*----------------------------------------------------------------------------*/	
	function get_num_hist17($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		        
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
			
			 for($a=0;$a<count($cant_histo);$a++){ 		
				 $sql = "SELECT CONCAT(g.DESCRIPTION,'-',g.PLAQUE) AS UNIT, e.GPS_DATETIME , f.DESCRIPTION AS EVT, e.LATITUDE, e.LONGITUDE, e.VELOCITY, e.ANGLE
						 FROM ".$cant_histo[$a]." e
						 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
						 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
						 WHERE e.COD_ENTITY IN (".$idunit.")
						 ".$rtime."
						 ".$filtro."
						 ORDER BY GPS_DATETIME";
		
					$query = mysqli_query($conexion, $sql);
					
					while($row = @mysqli_fetch_array($query)){
						$conta = $conta+1;
						$arreglo[$conta][0] = $row['UNIT'];
						$arreglo[$conta][1] = $row['GPS_DATETIME'];
						$arreglo[$conta][2] = utf8_decode($row['EVT']);
						$arreglo[$conta][3] = $row['LATITUDE'];
						$arreglo[$conta][4] = $row['LONGITUDE'];
						$arreglo[$conta][5] = $row['VELOCITY'];
						$arreglo[$conta][6] = $row['ANGLE'];
					}
		
				
					
			}		
		}else{
			return false;
		}
		
			@mysqli_close($conexion);
			return $arreglo;
	}	
//---------------------------------------------------------------	

	function get_num_hist12($hist,$filtro,$fecha_x,$idunit){
		global $config_bd2;
        $incremento = 0; 
		$cant_histo = explode('|',$hist);
		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
	   for($a=0;$a<count($cant_histo);$a++){   			
 			$sql = "SELECT e.COD_ENTITY,CONCAT(g.DESCRIPTION,'-',g.PLAQUE) AS UNIT, CAST(e.GPS_DATETIME AS DATE ) AS FECHA , 
				 f.DESCRIPTION AS EVT, e.LATITUDE, e.LONGITUDE, e.VELOCITY, e.ANGLE,COUNT(e.COD_EVENT) AS EVENTOS, e.COD_EVENT
				 FROM ".$cant_histo[$a]." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE  CAST(GPS_DATETIME AS DATE) BETWEEN '".$fecha_x." 00:00:00' AND '".$fecha_x." 23:59:00'
				 AND f.COD_EVENT = 27 AND e.COD_ENTITY IN (".$idunit.")
				  GROUP BY e.COD_ENTITY ,FECHA ORDER BY FECHA,UNIT DESC";

			$query = mysqli_query($conexion, $sql);
			$incremento = $incremento+@mysqli_num_rows($query);
			//$TOT.= '-'.@mysqli_num_rows($query);
		}
			
		}else{
			return false;
		}
	//	return $hist.'-'.$filtro.'-'.$fecha_x;
	
	   return $incremento;
	  //return $sql;
	}
//---------------------------------------------------------------	

	function get_num_hist12_2($hist,$filtro,$fecha_x,$idunit){
		global $config_bd2;
        $incremento = 0; 
		$cant_histo = explode('|',$hist);
		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
	   for($a=0;$a<count($cant_histo);$a++){   			
 		 	$sql = "SELECT e.COD_ENTITY
				 FROM ".$cant_histo[$a]." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE  GPS_DATETIME ".$fecha_x." 
				 ".$filtro." AND e.COD_ENTITY IN (".$idunit.")
				  GROUP BY e.COD_ENTITY ";

			$query = mysqli_query($conexion, $sql);
			$incremento = $incremento+@mysqli_num_rows($query);
			//$TOT.= '-'.@mysqli_num_rows($query);
		}
			
		}else{
			return false;
		}
	//	return $hist.'-'.$filtro.'-'.$fecha_x;
	
	   return $incremento;
	  //return $sql;
	}	
//---------------------------------------------------------------	
function get_num_hist13($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
        
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
	   if($conexion){
		   for($a=0;$a<count($cant_histo);$a++){   			
  $sql = "SELECT e.COD_ENTITY,CONCAT(g.DESCRIPTION,'-',g.PLAQUE) AS UNIT, CAST(e.GPS_DATETIME AS DATE ) AS FECHA , f.DESCRIPTION AS EVT, e.LATITUDE, e.LONGITUDE, e.VELOCITY, e.ANGLE,COUNT(e.COD_EVENT) AS EVENTOS, e.COD_EVENT
			 FROM ".$cant_histo[$a]." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE e.COD_ENTITY IN (".$idunit.")
				 ".$rtime." 
				 ".$filtro."
			     GROUP BY e.COD_ENTITY ,FECHA ORDER BY FECHA ASC";
	
					$query = mysqli_query($conexion, $sql);
					while($row = @mysqli_fetch_array($query)){
						$conta = $conta+1;
						$arreglo[$conta][0] = $row['FECHA'];
						$arreglo[$conta][1] = $row['UNIT'];
						$arreglo[$conta][2] = $row['COD_ENTITY'];
						$arreglo[$conta][3] = $cant_histo[$a];
					}

			
			}
			
		}else{
			return false;
		}
	
	   return $arreglo;
	}

//---------------------------------------------------------------get_table_histX2

/*function get_num_hist14($hist, $idunit, $rtime){
		global $config_bd2;
        
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
	   if($conexion){
		   		
         $sql = "SELECT e.GPS_DATETIME AS FECHA 
			     FROM ".$hist." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE e.COD_ENTITY IN (".$idunit.")
				 ".$rtime." 
				 AND f.COD_EVENT = 27
			     GROUP BY e.COD_ENTITY ,FECHA ORDER BY FECHA DESC";
	
					$query = mysqli_query($conexion, $sql);
					while($row = @mysqli_fetch_array($query)){
						$conta = $conta+1;
						$arreglo[$conta] = $row['FECHA'];
					}

		}else{
			return false;
		}
	
	   return $sql;
	}	
	*/
//---------------------------------------------------------------get_table_histX2
function get_num_hist14($hist, $idunit, $rtime,$filtro){
		global $config_bd2;
        
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
	   if($conexion){
		   		
         $sql = "SELECT e.GPS_DATETIME AS FECHA 
			     FROM ".$hist." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE e.COD_ENTITY IN (".$idunit.")
				 ".$rtime." 
				 ".$filtro."
			     GROUP BY e.COD_ENTITY ,FECHA ORDER BY FECHA ASC";
	
					$query = mysqli_query($conexion, $sql);
					while($row = @mysqli_fetch_array($query)){
						$conta = $conta+1;
						$arreglo[$conta] = $row['FECHA'];
					}

		}else{
			return false;
		}
	  // return $sql;
	   return $arreglo;
	}		
//------------------------------------------------------------------------
function get_num_hist15($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){  			
$sql="SELECT CAST(GPS_DATETIME AS DATE) AS FECHA, COUNT(COD_ENTITY) AS EVENTOS, MAX(VELOCITY) AS M , ROUND(AVG(VELOCITY),2) AS P
FROM ".$cant_histo[$a]." H WHERE 
H.COD_ENTITY IN (".$idunit.")
".$rtime."
".$filtro."
GROUP BY FECHA ORDER BY FECHA ASC";
			$query = mysqli_query($conexion, $sql);
					while($row = @mysqli_fetch_array($query)){
						$arreglo[$conta][0] = $row['FECHA'];
						$arreglo[$conta][1] = $row['EVENTOS'];
						$arreglo[$conta][2] = $row['M'];
						$arreglo[$conta][3] = $row['P'];
						$conta = $conta+1;
					}			
}
			//$row   = @mysqli_fetch_array($query);
			//$count = @mysqli_num_rows($query);
			//return $query;
			mysqli_close($conexion);
		}else{
			return false;
		}
		return $arreglo;
	}	
//------------------------------------------------------------------------
function get_num_hist16($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = 0;
		$cant_histo = explode('|',$hist);			
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
for($a=0;$a<count($cant_histo);$a++){  			
$sql="SELECT U.COD_ENTITY AS UNIX, CAST(GPS_DATETIME AS DATE) AS FECHA,CONCAT(U.PLAQUE,' ',U.DESCRIPTION) AS UNIT, COUNT(H.COD_ENTITY)AS EVENTOS, MAX(H.VELOCITY) AS MV, ROUND(AVG(H.VELOCITY),2) AS PV
FROM ".$cant_histo[$a]." H INNER JOIN SAVL1120 U ON U.COD_ENTITY = H.COD_ENTITY 
WHERE H.COD_ENTITY IN (".$idunit.")
".$rtime." 
".$filtro."
GROUP BY H.COD_ENTITY,FECHA ORDER BY FECHA";
			$query = mysqli_query($conexion, $sql);
			while($row = @mysqli_fetch_array($query)){
				$arreglo[$conta][0] = $row['FECHA'];
				$arreglo[$conta][1] = $row['DESCRIPTION'];
				$arreglo[$conta][2] = $row['EVENTOS'];
				$arreglo[$conta][3] = $row['MV'];
				$arreglo[$conta][4] = $row['PV'];
				$conta = $conta+1;
			}	
}
			mysqli_close($conexion);
		}else{
			return false;
		}
		return $arreglo;
	}	

//---------------------------------------------------------------------------
	
	/** FUNCIONES PARA CALCULAR VELOCIDAD **/
	function get_res_vel($hist, $idunit, $rtime, $filtro){
			global $config_bd2;
			//$conexion = mysqli_connect("192.168.6.45", "savl_mon", "vaio15R", "ALG_BD_CORPORATE_SAVL");	
			$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);	
			$sql = "SELECT CONCAT(g.DESCRIPTION,'-',g.PLAQUE) AS UNIT, e.GPS_DATETIME , f.DESCRIPTION AS EVT, e.LATITUDE, e.LONGITUDE, e.VELOCITY, e.ANGLE
				 FROM ".$hist." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE e.COD_ENTITY = ".$idunit."
				 ".$rtime."
				 ".$filtro."
				 ORDER BY GPS_DATETIME";
			/*
			$sql = "SELECT e.GPS_DATETIME,e.VELOCITY,e.LONGITUDE,e.LATITUDE,f.DESCRIPTION AS EVT
					FROM ".$tabla_historico." e
   					LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
					WHERE COD_ENTITY = ".$idunidad."
  					AND ABS(e.LATITUDE)  BETWEEN 12 AND 33 
  					AND ABS(e.LONGITUDE) BETWEEN 80 AND 117					 	
      				".$rtime."
					ORDER BY e.GPS_DATETIME ASC";
			*/		
			$query 	= mysqli_query($conexion,$sql);
//			$count 	= @mysqli_num_rows($queryNumHistorico);
//			echo "<br>".$sql."<br>-> ".$count; exit();
//			$count 	= @mysqli_num_rows($query);
			return $query;
			mysqli_close($conexion);
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
	
    //**Obtiene la tabla donde se almacenan los ultimos eventos de las unidades*************-//
	function get_table_upos($idunit){
		global $config_bd2;
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
		if($conexion){		
			$sql = "SELECT COD_FLEET,CONCAT(PLAQUE,'-',DESCRIPTION) AS UNIDAD
					FROM SAVL1120 
					WHERE COD_ENTITY  = ".$idunit;					
			$query = mysqli_query($conexion, $sql);	
			$row   = @mysqli_fetch_array($query);
			$count = @mysqli_num_rows($query);			
			if($count > 0){
				if(strlen($row['COD_FLEET']) == 1){
					$tabla_pocisiones = "LAST0000".$row['COD_FLEET'];
				}else if(strlen($row['COD_FLEET']) == 2){
					$tabla_pocisiones = "LAST000".$row['COD_FLEET'];
				}else if(strlen($row['COD_FLEET']) == 3){
					$tabla_pocisiones = "LAST00".$row['COD_FLEET']; 
				}else if(strlen($row['COD_FLEET'])== 4){
					$tabla_pocisiones = "LAST0".$row['COD_FLEET'];
				}else if(strlen($row['COD_FLEET']) == 5){
					$tabla_pocisiones = "LAST".$row['COD_FLEET'];
				}
				
				return ($this->tabla_existe($tabla_pocisiones)) ? $tabla_pocisiones : false;
			}else{
				return false;
			}
			mysqli_close($conexion);
		}else{
			return false;
		}
	}
//---------------------------------------------------------------------------------

	function get_table_hist($idunit){
		global $config_bd2;
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){		
			$sql = "SELECT COD_FLEET,CONCAT(PLAQUE,'-',DESCRIPTION) AS UNIDAD
					FROM SAVL1120 
					WHERE COD_ENTITY  = ".$idunit;
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


//--------------------------------------------------------------------------

	function get_table_histX($idunit){
		global $config_bd2;
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){		
			 $sql = "SELECT COD_FLEET,CONCAT(PLAQUE,'-',DESCRIPTION) AS UNIDAD
					FROM SAVL1120 
					WHERE COD_ENTITY  IN (".$idunit.")";
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

//--------------------------------------------------------------------
function get_table_histX2($idunit){
		global $config_bd2;
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){		
			  $sql = "SELECT COD_FLEET,CONCAT(PLAQUE,'-',DESCRIPTION) AS UNIDAD
					FROM SAVL1120 
					WHERE COD_ENTITY  IN (".$idunit.") GROUP BY COD_FLEET";
			$query = mysqli_query($conexion, $sql);	
	
			$count = @mysqli_num_rows($query);
			$find=0;			
			if($count > 0){
				$concatenado = "";
			 while($row= @mysqli_fetch_array($query)){
			 	
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
				
			  if($concatenado == ""){
			  	$concatenado = $tabla_historico;
			  }	else{
			  	$concatenado = $concatenado .'|'.$tabla_historico;
			  }
			}	
				//return ($this->tabla_existe($tabla_historico)) ? $tabla_historico : false;
				return $concatenado;
			}else{
				return false;
			}
			mysqli_close($conexion);
		}else{
			return false;
		}
	}
		
//--------------------------------------------------------------------		
	function tabla_existe($nametable){
		global $config_bd2;
	
		$database = $config_bd2['bname'];
		$enlace = mysql_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass']); 
	    
	  /*  $tablas = mysql_list_tables($database);  
        while (list($tabla) = mysql_fetch_array($tablas)) {  
 			if ($nametable == $tabla){  
   				return true;  
   				break;  
  			}  
 		}  */
        
        $sql = "SHOW TABLES FROM ".$database;
        $result = mysql_query($sql);
        
        while ($row = mysql_fetch_row($result)) {
            if ($nametable == $row[0]){  
   				return true;  
   				break;  
  			}  
          }
		return false;  
	}		
/*----------------------------------------------------------------------------*/	
	public function obtener_ureporte($id_unit){
		global $config_bd2;
		$table_last = $this->get_table_upos($id_unit);
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
		if($conexion){
	 $sql	= "SELECT f.PLAQUE,f.YEAR,f.DESCRIPTION,    
			                  IF (e.GPS_DATETIME IS NULL, '0000-00-00 00:00:00',e.GPS_DATETIME) AS GPS_DATETIME ,
							  IF(g.DESCRIPTION IS NULL,'NO HA REPORTADO',g.DESCRIPTION) AS DESC_EVT,     
							  IF(e.VELOCITY IS NULL,0,e.VELOCITY) AS VELOCITY,
							  f.COD_FLEET,
                              IF(e.LATITUDE IS NULL,0,e.LATITUDE) AS LATITUDE,
						      IF(e.LONGITUDE IS NULL,0,e.LONGITUDE) AS LONGITUDE,
					          f.COD_ENTITY,
						      IF (g.PRIORITY is null,0,g.PRIORITY) as PRIORITY,
							  e.MOTOR,
							  e.VELOCITY AS TURN,
							  e.ANGLE
						FROM  SAVL1120 f
						LEFT JOIN ".$table_last." e ON e.COD_ENTITY = f.COD_ENTITY
						LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.`COD_EVENT`
						WHERE e.COD_ENTITY = ".$id_unit;				
			/*$sql   = "SELECT LONGITUDE,LATITUDE,COD_ENTITY
					 FROM ".$table_last."
				 	 WHERE COD_ENTITY = ".$id_unit."
					 LIMIT 1";	*/
			$query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);					 
			if($count>0){
				$result = mysqli_fetch_array($query);
				
				return $result;				
			}else{
			
			    $result = 0;
				return $result;
			}
			mysqli_close($conexion);			
		}else{
		$result = 0;
			return false;
		}
	}
	//////----------------------------------------------------------------------------
	public function obtener_ureporte_silv($id_unit){
		global $config_bd2;
		$table_last = $this->get_table_upos($id_unit);
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
		if($conexion){
		$sql	= "SELECT f.PLAQUE,   
					f.YEAR,     
					f.DESCRIPTION,
					IF (e.GPS_DATETIME IS NULL, '0000-00-00 00:00:00',e.GPS_DATETIME) AS GPS_DATETIME,
					IF(g.DESCRIPTION IS NULL,'NO HA REPORTADO',g.DESCRIPTION) AS DESC_EVT,
					IF(e.VELOCITY IS NULL,0,e.VELOCITY) AS VELOCIDAD,        
					f.COD_FLEET,
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
					IF((e.VELOCITY > 5) AND (e.MOTOR = 'ON'),'#00FF00','#999999'))) AS COLOR
					FROM SAVL1120 f  
					LEFT JOIN ".$table_last." e ON e.COD_ENTITY = f.COD_ENTITY
					LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.COD_EVENT
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
	
	////------------------------------------------------------------------------------
	public function obtener_ureporte_1($id_unit){
		global $config_bd2;
		$table_last = $this->get_table_hist($id_unit);
		$conta=0;
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
		if($conexion){
		$sql	= "SELECT f.PLAQUE,f.YEAR,f.DESCRIPTION,    
			                  IF (e.GPS_DATETIME IS NULL, '0000-00-00 00:00:00',e.GPS_DATETIME) AS GPS_DATETIME ,
							  IF(g.DESCRIPTION IS NULL,'NO HA REPORTADO',g.DESCRIPTION) AS DESC_EVT,     
							  IF(e.VELOCITY IS NULL,0,e.VELOCITY) AS VELOCITY,
							  f.COD_FLEET,
                              IF(e.LATITUDE IS NULL,0,e.LATITUDE) AS LATITUDE,
						      IF(e.LONGITUDE IS NULL,0,e.LONGITUDE) AS LONGITUDE,
					          f.COD_ENTITY,
						      IF (g.PRIORITY is null,0,g.PRIORITY) as PRIORITY,
							  e.ANGLE
						FROM  SAVL1120 f
						LEFT JOIN ".$table_last." e ON e.COD_ENTITY = f.COD_ENTITY
						LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.`COD_EVENT`
						WHERE e.COD_ENTITY = ".$id_unit."
						ORDER BY e.GPS_DATETIME DESC
						LIMIT 5";				
			/*$sql   = "SELECT LONGITUDE,LATITUDE,COD_ENTITY
					 FROM ".$table_last."
				 	 WHERE COD_ENTITY = ".$id_unit."
					 LIMIT 1";	*/
			$query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);		
		
		
			while($row = @mysqli_fetch_array($query)){	
			
				 $arreglo[$conta][0] = $row['PLAQUE'];
				 $arreglo[$conta][1] = $row['DESCRIPTION'];
				 $arreglo[$conta][2] = $row['GPS_DATETIME'];
				 $arreglo[$conta][3] = $row['DESC_EVT'];
				 $arreglo[$conta][4] = $row['VELOCITY'];
				 $arreglo[$conta][5] = $row['LATITUDE'];
				 $arreglo[$conta][6] = $row['LONGITUDE'];
				 $arreglo[$conta][7] = $row['ANGLE'];
				 
				 $conta++;
				
			
			}		 
			
				if($count>0){	
				return $arreglo;				
			}else{
				return false;
			}
			mysqli_close($conexion);			
		}else{
			return false;
		}
	}
	////----------------------------------------------------------------------------------------------
	
	public function obtener_reporte_det($id_unit){
		global $config_bd2;
		$table_last = $this->get_table_upos($id_unit);		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
		if($conexion){
		/*	$sql	= "SELECT f.PLAQUE,f.YEAR,f.DESCRIPTION,e.GPS_DATETIME,g.DESCRIPTION AS DESC_EVT,e.VELOCITY,f.COD_FLEET,
			                   e.LATITUDE,e.LONGITUDE
						FROM  ".$table_last." e
						LEFT JOIN SAVL1120 f ON e.COD_ENTITY = f.COD_ENTITY
						LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.`COD_EVENT`
						WHERE e.COD_ENTITY = ".$id_unit."
						LIMIT 1";		*/
	 $sql	= "SELECT f.PLAQUE,f.YEAR,f.DESCRIPTION,    
			                  IF (e.GPS_DATETIME IS NULL, '0000-00-00 00:00:00',e.GPS_DATETIME) AS GPS_DATETIME ,
							  IF(g.DESCRIPTION IS NULL,'NO HA REPORTADO',g.DESCRIPTION) AS DESC_EVT,     
							  IF(e.VELOCITY IS NULL,0,e.VELOCITY) AS VELOCITY,
							  f.COD_FLEET,
                              IF(e.LATITUDE IS NULL,0,e.LATITUDE) AS LATITUDE,
						      IF(e.LONGITUDE IS NULL,0,e.LONGITUDE) AS LONGITUDE,
					          f.COD_ENTITY,
						      IF (g.PRIORITY is null,0,g.PRIORITY) as PRIORITY,
							  e.MOTOR,e.VELOCITY AS TURN,
							  e.ANGLE
						FROM  SAVL1120 f
						LEFT JOIN ".$table_last." e ON e.COD_ENTITY = f.COD_ENTITY
						LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.`COD_EVENT`
						WHERE e.COD_ENTITY = ".$id_unit."
						ORDER BY g.PRIORITY DESC
						LIMIT 1";					
						
						
						
			$query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);					 
			if($count>0){
				$result = mysqli_fetch_array($query);
				return $result;				
			}else{
				return false;
			}
			mysqli_close($conexion);			
		}else{
			return false;
		}
	}
	

	
	
	public function obtener_rep_adet($id_unit){
		global $config_bd2;
		$table_last = $this->get_table_upos($id_unit);		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
		if($conexion){
			$sql	= "SELECT f.PLAQUE,f.YEAR,f.DESCRIPTION,e.GPS_DATETIME,g.DESCRIPTION AS DESC_EVT,e.VELOCITY,f.COD_FLEET,
			                   e.LATITUDE,e.LONGITUDE
						FROM  ".$table_last." e
						LEFT JOIN SAVL1120 f ON e.COD_ENTITY = f.COD_ENTITY
						LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.`COD_EVENT`
						WHERE e.COD_ENTITY = ".$id_unit."
						 WHERE g.PRIORITY = 1
						LIMIT 1";		
			$query   = mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);					 
			if($count>0){
				$result = mysqli_fetch_array($query);
				return $result;				
			}else{
				return false;
			}
			mysqli_close($conexion);			
		}else{
			return false;
		}
	}	

    //**Obtiene la tabla donde se almacenan los historicos de las unidades*************-//
	function direccion($lati,$longi){
		global $config_bd_sp;
		$conexion = mysqli_connect($config_bd_sp['host'],$config_bd_sp['user'],$config_bd_sp['pass'],$config_bd_sp['bname']);				
		if($conexion){
			$sql_stret	= "CALL SPATIAL_CALLES(".$longi.",".$lati.");";
			$query 		= mysqli_query($conexion, $sql_stret);
			$row_st   	= @mysqli_fetch_array($query);
                        $calle          = $row_st['CALLE'];
                        if ((strlen($calle) == 0) or ($calle == 'S/D')) {
                          $calle = '-'; 
                        }
                        $cp             = $row_st['CP'];
                        if (strlen($cp) > 0) {
                          $cp = 'CP.: '.$cp; 
                        }
			$direccion 	= $calle." ".$row_st['ASENTAMIENTO']."\n-".$row_st['MUNICIPIO']."-".$row_st['CIUDAD']."-".$cp."-".$row_st['ESTADO'];
			return $direccion;
			mysqli_close($conexion);
		}else{
			return false;
		}
	}
//	-----------------------------------------------------------------------------------------------------
	function direccion_s($lati,$longi){
		global $config_bd_spa;
		$conexion = mysqli_connect($config_bd_spa['host'],$config_bd_spa['user'],$config_bd_spa['pass'],$config_bd_spa['bname']);				
		if($conexion){
			$sql_stret	= "CALL PBA_DIR_NEW(".$lati.",".$longi.");";
			$query 		= mysqli_query($conexion, $sql_stret);
			$row_st   	= @mysqli_fetch_array($query);
                        
						$calle          = $row_st['NOMBRE'];
                        if ((strlen($calle) == 0) or ($calle == 'S/D')) {
                          $calle = ' '; 
                        }
                        $cp             = $row_st['CP'];
                        if (strlen($cp) > 0) {
                          $cp = 'CP.: '.$cp; 
                        }
			
			if((strlen($calle) != 0) and (strlen($row_st['COLONIA'])!=0) and (strlen($row_st['MUNICIPIO']) != 0)and (strlen($row_st['CIUDAD']) != 0)){
			$direccion 	= $calle." ".$row_st['COLONIA']."\n ".$row_st['MUNICIPIO']." ".$row_st['CIUDAD']." ".$cp." ".$row_st['ESTADO'];
			}else{
			$geoCodeURL = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$lati.",".$longi."&sensor=false"; 

    		$direccion = json_decode(file_get_contents($geoCodeURL), true); 

   
			}
			
			
			return $direccion;
			mysqli_close($conexion);
		}else{
			return 0;
		}
	}
    //**Obtiene la tabla donde se almacenan los historicos de las unidades*************-//
	function get_data_unit($idunit){
		global $config_bd2;
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
		if($conexion){		
			 $sql = "SELECT CONCAT(PLAQUE,'_',DESCRIPTION) AS UNIDAD
					FROM SAVL1120 
					WHERE COD_ENTITY  = ".$idunit."
					LIMIT 1";					
			$query = mysqli_query($conexion, $sql);	
			$row   = @mysqli_fetch_array($query);
			$count = @mysqli_num_rows($query);			
			if($count > 0){
				$unidad = str_replace('/','_',$row['UNIDAD']); 
				return $unidad;
			}else{
				return false;
			}
			mysqli_close($conexion);
		}else{
			return false;
		}
	}	
	//------------------------------------------------------------------------------
	function get_data_unit_1($idunit){
		global $config_bd2;
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);
		if($conexion){		
			$sql = "SELECT DESCRIPTION AS UNIDAD
					FROM SAVL1120 
					WHERE COD_ENTITY  IN (".$idunit.")";					
			$query = mysqli_query($conexion, $sql);	
			
			$count = @mysqli_num_rows($query);			
				while($row = @mysqli_fetch_array($query)){
		
				
			 $unidad .= $row['UNIDAD'].','; 
				
			}
				return $unidad;
				
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
		global $config_bd_sp;
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
		}
	}


//------------------------------------------------------------------------ PARA UNIDADES DETENIDAS -- rDetenido---

	function get_num_hist18($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
      $unidad=0;
	  for($a=0;$a<count($cant_histo);$a++){ 
  $sql = "SELECT e.LATITUDE,e.LONGITUDE,e.GPS_DATETIME , CAST(GPS_DATETIME AS DATE) AS FECHA,DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174) AS DISTANCIA,
		            COUNT(e.COD_ENTITY) AS unidades, e.COD_ENTITY,CONCAT(f.DESCRIPTION,'-',f.PLAQUE) AS UNIT
		            FROM ".$cant_histo[$a]." e
		            LEFT JOIN SAVL1120 f ON e.COD_ENTITY = f.COD_ENTITY
					WHERE DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174)<=0.05 
					".$rtime."
					AND e.COD_ENTITY IN (".$idunit.")
					GROUP BY e.COD_ENTITY
					ORDER BY e.GPS_DATETIME ASC";
		  
		  
		  /*
		       SELECT e.LATITUDE,e.LONGITUDE,e.GPS_DATETIME,ROUND(DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174),2) AS DISTANCIA 
		            FROM ".$cant_histo[$a]." e
					WHERE ROUND(DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174))<=0.05 
					AND e.GPS_DATETIME BETWEEN '".date(Y-m-d)." 07:30' AND ' ".date(Y-m-d)." 19:30'
					AND e.COD_ENTITY IN (".$idunit.")
					ORDER BY e.GPS_DATETIME ASC";*/

			$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			$unidad=$unidad+$count;	
			if($count>0){
				
			while($row = @mysqli_fetch_array($query)){
				
				$conta = $conta+1;
				 $arreglo[0][0] = $unidad;
				 $arreglo[$conta][1] = $row['FECHA'];
				 $arreglo[$conta][2] = $row['UNIT'];
				 $arreglo[$conta][3] = $row['COD_ENTITY'];
				 $arreglo[$conta][4] = $row['GPS_DATETIME'];
				}
			}

		
			
		}	
		}else{
			return false;
		}
			@mysqli_close($conexion);
			return $arreglo;

	}
	
	////---------------------
	function get_num_hist18_new($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
      $unidad=0;
	  for($a=0;$a<count($cant_histo);$a++){ 
  $sql = "SELECT e.LATITUDE,e.LONGITUDE,e.GPS_DATETIME , CAST(GPS_DATETIME AS DATE) AS FECHA,DISTANCIA(e.LATITUDE,e.LONGITUDE,".$filtro.") AS DISTANCIA,
		            COUNT(e.COD_ENTITY) AS unidades, e.COD_ENTITY,CONCAT(f.DESCRIPTION,'-',f.PLAQUE) AS UNIT
		            FROM ".$cant_histo[$a]." e
		            LEFT JOIN SAVL1120 f ON e.COD_ENTITY = f.COD_ENTITY
					WHERE DISTANCIA(e.LATITUDE,e.LONGITUDE,".$filtro.")<=0.05 
					".$rtime."
					AND e.COD_ENTITY IN (".$idunit.")
					GROUP BY e.COD_ENTITY
					ORDER BY e.GPS_DATETIME ASC";
		  
		  
		  /*
		       SELECT e.LATITUDE,e.LONGITUDE,e.GPS_DATETIME,ROUND(DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174),2) AS DISTANCIA 
		            FROM ".$cant_histo[$a]." e
					WHERE ROUND(DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174))<=0.05 
					AND e.GPS_DATETIME BETWEEN '".date(Y-m-d)." 07:30' AND ' ".date(Y-m-d)." 19:30'
					AND e.COD_ENTITY IN (".$idunit.")
					ORDER BY e.GPS_DATETIME ASC";*/

			$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			$unidad=$unidad+$count;	
			if($count>0){
				
			while($row = @mysqli_fetch_array($query)){
				
				$conta = $conta+1;
				 $arreglo[0][0] = $unidad;
				 $arreglo[$conta][1] = $row['FECHA'];
				 $arreglo[$conta][2] = $row['UNIT'];
				 $arreglo[$conta][3] = $row['COD_ENTITY'];
				 $arreglo[$conta][4] = $row['GPS_DATETIME'];
				}
			}

		
			
		}	
		}else{
			return false;
		}
			@mysqli_close($conexion);
			return $arreglo;

	}
	
	//--------------------------------------------------------------------------
	function get_repo_unit_off($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
      $unidad=0;
	  for($a=0;$a<count($cant_histo);$a++){ 
	  $sql1 ="SET @a:=0;";
	  $query1 = @mysqli_query($conexion, $sql1);
 $sql = "SELECT 
  e.VELOCITY,
  e.ANGLE,
  e.MOTOR,
  IF(e.LATITUDE IS NULL, 0, e.LATITUDE) AS LATITUDE,
  IF(e.LONGITUDE IS NULL, 0, e.LONGITUDE) AS LONGITUDE,
  e.GPS_DATETIME,
  Time_to_Sec(cast(e.GPS_DATETIME as time)) AS HORA,
  e.COD_EVENT,
  g.DESCRIPTION,
  e.COD_ENTITY,
  CONCAT(f.DESCRIPTION, '-', f.PLAQUE) AS UNIT, 
  DISTANCIA(e.LATITUDE,e.LONGITUDE,".$filtro.") as DIST,
  @a:= @a+ 1 AS CONTADOR
FROM
   ".$cant_histo[$a]." e
  LEFT JOIN SAVL1120 f ON (e.COD_ENTITY = f.COD_ENTITY)
  INNER JOIN SAVL1260 g ON (e.COD_EVENT = g.COD_EVENT)
WHERE
  e.COD_ENTITY IN (".$idunit.")
  ".$rtime."
  AND  g.DESCRIPTION <> 'ESTACIONADO DENTRO DE BASE'
ORDER BY
  GPS_DATETIME
 ";
		  
		  


			$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			$unidad=$unidad+$count;	
			if($count>0){
				
			while($row = @mysqli_fetch_array($query)){
				
				$conta = $conta+1;
				 $arreglo[0][0] = $unidad;
				 $arreglo[$conta][1] = $row['GPS_DATETIME'];
				 $arreglo[$conta][2] = $row['UNIT'];
				 $arreglo[$conta][3] = $row['COD_ENTITY'];
				 $arreglo[$conta][4] = $row['VELOCITY'];
				  $arreglo[$conta][5] = $row['ANGLE'];
				   $arreglo[$conta][6] = $row['MOTOR'];
				   $arreglo[$conta][7] = $row['LATITUDE'];
				    $arreglo[$conta][8] = $row['LONGITUDE'];
					 $arreglo[$conta][9] = $row['DESCRIPTION'];
					  $arreglo[$conta][10] = $row['COD_EVENT'];
				 	  $arreglo[$conta][11] = $row['DIST'];
					  $arreglo[$conta][12] = $row['CONTADOR'];
					  $arreglo[$conta][13] = $row['HORA'];
					  
				}
			}

		
			
		}	
		}else{
			return false;
		}
			@mysqli_close($conexion);
			return $arreglo;

	}
	
//-----------------------------------------------------------------------------

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

//------------------------------------------------------------------------ PARA UNIDADES DETENIDAS -- rDetenido---

	function get_num_hist19($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
      
	  for($a=0;$a<count($cant_histo);$a++){ 
     echo $sql = "SELECT e.LATITUDE,e.LONGITUDE,e.GPS_DATETIME,DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174) AS DISTANCIA,e.COD_ENTITY AS xx,g.DESCRIPTION AS DESC_EVT,CAST(e.GPS_DATETIME AS DATE) AS FECHA,CONCAT(h.DESCRIPTION,'-',h.PLAQUE) AS UNIT, e.ANGLE
			FROM ".$cant_histo[$a]." e
			LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.COD_EVENT
			LEFT JOIN SAVL1120 h ON e.COD_ENTITY = h.COD_ENTITY
			WHERE DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174)<=0.05 
			".$rtime."
			AND e.COD_ENTITY IN (".$idunit.")
			ORDER BY e.COD_ENTITY,e.GPS_DATETIME ASC";

			$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			
			if($count>0){
				
			while($row = @mysqli_fetch_array($query)){
				
				$conta = $conta+1;
				 $arreglo[$conta][0] = $row['FECHA'];
				 $arreglo[$conta][1] = $row['DESC_EVT'];
				 $arreglo[$conta][2] = $row['GPS_DATETIME'];
				 $arreglo[$conta][3] = $row['LATITUDE'];
				 $arreglo[$conta][4] = $row['LONGITUDE']; 
				 $arreglo[$conta][5] = $row['UNIT'];
				 $arreglo[$conta][6] = $row['ANGLE'];
				}
			}

		
			
		}	
		}else{
			return false;
		}
			@mysqli_close($conexion);
			return $arreglo;

	}
//----------------------------------

function get_num_hist19_new($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
      
	  for($a=0;$a<count($cant_histo);$a++){ 
     $sql = "SELECT e.LATITUDE,e.LONGITUDE,e.GPS_DATETIME,DISTANCIA(e.LATITUDE,e.LONGITUDE,".$filtro.") AS DISTANCIA,e.COD_ENTITY AS xx,g.DESCRIPTION AS DESC_EVT,CAST(e.GPS_DATETIME AS DATE) AS FECHA,CONCAT(h.DESCRIPTION,'-',h.PLAQUE) AS UNIT, e.ANGLE
			FROM ".$cant_histo[$a]." e
			LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.COD_EVENT
			LEFT JOIN SAVL1120 h ON e.COD_ENTITY = h.COD_ENTITY
			WHERE DISTANCIA(e.LATITUDE,e.LONGITUDE,".$filtro.")<=0.05 
			".$rtime."
			AND e.COD_ENTITY IN (".$idunit.")
			ORDER BY e.COD_ENTITY,e.GPS_DATETIME ASC";

			$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			
			if($count>0){
				
			while($row = @mysqli_fetch_array($query)){
				
				$conta = $conta+1;
				 $arreglo[$conta][0] = $row['FECHA'];
				 $arreglo[$conta][1] = $row['DESC_EVT'];
				 $arreglo[$conta][2] = $row['GPS_DATETIME'];
				 $arreglo[$conta][3] = $row['LATITUDE'];
				 $arreglo[$conta][4] = $row['LONGITUDE']; 
				 $arreglo[$conta][5] = $row['UNIT'];
				 $arreglo[$conta][6] = $row['ANGLE'];
				}
			}

		
			
		}	
		}else{
			return false;
		}
			@mysqli_close($conexion);
			return $arreglo;

	}
	/////____________________________________________________--
	function get_num_hist19_n($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
      
	  for($a=0;$a<count($cant_histo);$a++){ 
     $sql = "SELECT e.LATITUDE,e.LONGITUDE,e.GPS_DATETIME,DISTANCIA(e.LATITUDE,e.LONGITUDE,".$filtro.") AS DISTANCIA,e.COD_ENTITY AS xx,g.DESCRIPTION AS DESC_EVT,CAST(e.GPS_DATETIME AS DATE) AS FECHA,CONCAT(h.DESCRIPTION,'-',h.PLAQUE) AS UNIT, e.ANGLE
			FROM ".$cant_histo[$a]." e
			LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.COD_EVENT
			LEFT JOIN SAVL1120 h ON e.COD_ENTITY = h.COD_ENTITY
			WHERE DISTANCIA(e.LATITUDE,e.LONGITUDE,".$filtro.")<=0.05 
			".$rtime."
			AND e.COD_ENTITY IN (".$idunit.")
			ORDER BY e.COD_ENTITY,e.GPS_DATETIME ASC";

			$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			
			if($count>0){
				
			while($row = @mysqli_fetch_array($query)){
				
				$conta = $conta+1;
				 $arreglo[$conta][0] = $row['FECHA'];
				 $arreglo[$conta][1] = $row['DESC_EVT'];
				 $arreglo[$conta][2] = $row['GPS_DATETIME'];
				 $arreglo[$conta][3] = $row['LATITUDE'];
				 $arreglo[$conta][4] = $row['LONGITUDE']; 
				 $arreglo[$conta][5] = $row['UNIT'];
				 $arreglo[$conta][6] = $row['ANGLE'];
				}
			}

		
			
		}	
		}else{
			return false;
		}
			@mysqli_close($conexion);
			return $arreglo;

	}


///---------------------------


	function get_num_hist20($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
      
	  for($a=0;$a<count($cant_histo);$a++){ 
     $sql = "SELECT LATITUDE,LONGITUDE,GPS_DATETIME,DISTANCIA(LATITUDE,LONGITUDE,19.380996,-99.20174) AS DISTANCIA,COD_ENTITY AS xx
			 FROM ".$cant_histo[$a]." e
			 WHERE (DISTANCIA(LATITUDE,LONGITUDE,19.380996,-99.20174))>0.05 
			 ".$rtime."
		     AND e.COD_ENTITY IN (".$idunit.")
			 ORDER BY COD_ENTITY,GPS_DATETIME ASC
			 LIMIT 1;";
		  
	    	$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			
			if($count>0){
				
			while($row = @mysqli_fetch_array($query)){
				
				$conta = $conta+1;
				 $arreglo[$conta] = $row['GPS_DATETIME'];
				}
			}

		
			
		}	
		}else{
			return false;
		}
			@mysqli_close($conexion);
			return $arreglo;

	}
	
	///-----------------------------------------
	function get_num_hist20_new($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
      
	  for($a=0;$a<count($cant_histo);$a++){ 
     $sql = "SELECT LATITUDE,LONGITUDE,GPS_DATETIME,DISTANCIA(LATITUDE,LONGITUDE,".$filtro.") AS DISTANCIA,COD_ENTITY AS xx
			 FROM ".$cant_histo[$a]." e
			 WHERE (DISTANCIA(LATITUDE,LONGITUDE,".$filtro."))>0.05 
			 ".$rtime."
		     AND e.COD_ENTITY IN (".$idunit.")
			 ORDER BY COD_ENTITY,GPS_DATETIME ASC
			 LIMIT 1;";
		  
	    	$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			
			if($count>0){
				
			while($row = @mysqli_fetch_array($query)){
				
				$conta = $conta+1;
				 $arreglo[$conta] = $row['GPS_DATETIME'];
				}
			}

		
			
		}	
		}else{
			return false;
		}
			@mysqli_close($conexion);
			return $arreglo;

	}


//------------------------------------------------------------------------ PARA UNIDADES DETENIDAS -- rDetenido---
   public $cade;
   	
	function get_num_hist200($hist, $idunit, $rtime, $filtro,$llegada){
		global $config_bd2;
		$arreglo = array();
		$arregloX = array();
	
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
       
	 $x_t = "";
	    
	 if(date("H")>=19 && date("H")<=23){
	  	 if(date("m")>=00 && date("m")<=30){
             	 $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d",strtotime('-1day'))." 19:30' AND '".date("Y-m-d")." 07:30' ";
             
         }else{
         
	         $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d")." 19:30' AND '".date("Y-m-d",strtotime('+1day'))." 07:30' ";
         }
      }else{
         $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d",strtotime('-1day'))." 19:30' AND '".date("Y-m-d")." 07:30' ";	
      }
      
      $unidad=0;
	  for($a=0;$a<count($cant_histo);$a++){ 
    $sql = "SELECT MAX(GPS_DATETIME) AS DIA,e.COD_ENTITY,f.DESCRIPTION 
		            FROM ".$cant_histo[$a]." e
		            LEFT JOIN SAVL1120 f ON e.COD_ENTITY = f.COD_ENTITY
					WHERE DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174)>0.05 
					".$rtime."
					AND e.COD_ENTITY IN (".$idunit.")
					GROUP BY e.COD_ENTITY
					ORDER BY e.GPS_DATETIME DESC";
			
		  
			$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			$unidad=$unidad+$count;	
			$valores = 0;
			
			if($count>0){
		
			while($row = @mysqli_fetch_array($query)){
			  //if($row['unidades']>0){  	
				 $conta = $conta+1;
			    //if(!in_array($row['FECHA'],$arreglo)){
			     // $arreglo[$conta]= $row['FECHA'];
			     
			    //}
			     $arreglo[$conta][0] = $llegada;
                 $arreglo[$conta][1] = $row['DIA'];
                 $arreglo[$conta][2] = $row['DESCRIPTION'];
                 $arreglo[$conta][3] = $row['COD_ENTITY'];
		      //}	 
				}
			}

		
			
		}	
		}else{
			return false;
		}
		
		
			@mysqli_close($conexion);
			 
			return $arreglo;

	}
	///-----------------------------------------------------------

   	
	function get_num_hist200_n($hist, $idunit, $rtime, $filtro,$llegada){
		global $config_bd2;
		$arreglo = array();
		$arregloX = array();
	
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
       
	 $x_t = "";
	    
	 if(date("H")>=19 && date("H")<=23){
	  	 if(date("m")>=00 && date("m")<=30){
             	 $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d",strtotime('-1day'))." 19:30' AND '".date("Y-m-d")." 07:30' ";
             
         }else{
         
	         $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d")." 19:30' AND '".date("Y-m-d",strtotime('+1day'))." 07:30' ";
         }
      }else{
         $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d",strtotime('-1day'))." 19:30' AND '".date("Y-m-d")." 07:30' ";	
      }
      
      $unidad=0;
	  for($a=0;$a<count($cant_histo);$a++){ 
    $sql = "SELECT MAX(GPS_DATETIME) AS DIA,e.COD_ENTITY,f.DESCRIPTION 
		            FROM ".$cant_histo[$a]." e
		            LEFT JOIN SAVL1120 f ON e.COD_ENTITY = f.COD_ENTITY
					WHERE DISTANCIA(e.LATITUDE,e.LONGITUDE,".$filtro.")>0.05 
					".$rtime."
					AND e.COD_ENTITY IN (".$idunit.")
					GROUP BY e.COD_ENTITY
					ORDER BY e.GPS_DATETIME DESC";
			
		  
			$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			$unidad=$unidad+$count;	
			$valores = 0;
			
			if($count>0){
		
			while($row = @mysqli_fetch_array($query)){
			  //if($row['unidades']>0){  	
				 $conta = $conta+1;
			    //if(!in_array($row['FECHA'],$arreglo)){
			     // $arreglo[$conta]= $row['FECHA'];
			     
			    //}
			     $arreglo[$conta][0] = $llegada;
                 $arreglo[$conta][1] = $row['DIA'];
                 $arreglo[$conta][2] = $row['DESCRIPTION'];
                 $arreglo[$conta][3] = $row['COD_ENTITY'];
		      //}	 
				}
			}

		
			
		}	
		}else{
			return false;
		}
		
		
			@mysqli_close($conexion);
			 
			return $arreglo;

	}
  //------------------------------------------------------------------------ PARA UNIDADES DETENIDAS -- rDetenido---

	function get_num_hist21($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$arregloX = array();
		
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
       
	 $x_t = "";
	    
	  if(date("H")>=19 && date("H")<=23){
	  	 if(date("m")>=00 && date("m")<=30){
             	 $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d",strtotime('-1day'))." 19:30' AND '".date("Y-m-d")." 07:30' ";
             
         }else{
         
	         $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d")." 19:30' AND '".date("Y-m-d",strtotime('+1day'))." 07:30' ";
         }
      }else{
         $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d",strtotime('-1day'))." 19:30' AND '".date("Y-m-d")." 07:30' ";	
      }
     
      
      $unidad=0;
	  for($a=0;$a<count($cant_histo);$a++){ 
 /*
 $sql = "SELECT e.LATITUDE,e.LONGITUDE,CAST(GPS_DATETIME AS DATE) AS FECHA,DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174) AS DISTANCIA,       MAX(GPS_DATETIME) AS JT,COUNT(e.COD_ENTITY) AS unidades, e.COD_ENTITY,CONCAT(f.DESCRIPTION,'-',f.PLAQUE) AS UNIT
		            FROM ".$cant_histo[$a]." e
		            LEFT JOIN SAVL1120 f ON e.COD_ENTITY = f.COD_ENTITY
					WHERE DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174)>0.05 
					".$rtime."
					AND e.COD_ENTITY IN (".$idunit.")
				
					ORDER BY e.GPS_DATETIME DESC";
			*/
			
			
  $sql = "SELECT MAX(GPS_DATETIME),e.COD_ENTITY,f.DESCRIPTION 
		            FROM ".$cant_histo[$a]." e
		            LEFT JOIN SAVL1120 f ON e.COD_ENTITY = f.COD_ENTITY
					WHERE DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174)>0.05 
					".$rtime."
					AND e.COD_ENTITY IN (".$idunit.")
					GROUP BY e.COD_ENTITY
					ORDER BY e.GPS_DATETIME DESC";
		  
		  
		  /*	GROUP BY e.COD_ENTITY
		       SELECT e.LATITUDE,e.LONGITUDE,e.GPS_DATETIME,ROUND(DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174),2) AS DISTANCIA 
		            FROM ".$cant_histo[$a]." e
					WHERE ROUND(DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174))<=0.05 
					AND e.GPS_DATETIME BETWEEN '".date(Y-m-d)." 07:30' AND ' ".date(Y-m-d)." 19:30'
					AND e.COD_ENTITY IN (".$idunit.")
					ORDER BY e.GPS_DATETIME ASC";*/

			$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			$unidad=$unidad+$count;			
			if($count>0){
			$agregado = ""; 	
			while($row = @mysqli_fetch_array($query)){
			    	
				 $conta = $conta+1;
				   
				 $arreglo[0][0] = $unidad;
				 $arreglo[$conta][1] = $row['FECHA'];
				 $arreglo[$conta][2] = $row['UNIT'];
				 $arreglo[$conta][3] = $row['COD_ENTITY'];
				 $arreglo[$conta][4] = $count;
				 //$arreglo[$conta][5] = $row['GPS_DATETIME'];
				 //$arreglo[$conta][6] = $row['GPS_DATETIME'];
     			}
			}

		
			
		}	
		}else{
			return false;
		}
		
		
			@mysqli_close($conexion);
			return $arreglo;

	}
	//--------------------------------------------------------------------------------
	
	function get_num_hist21_n($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$arregloX = array();
		
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
       
	 $x_t = "";
	    
	  if(date("H")>=19 && date("H")<=23){
	  	 if(date("m")>=00 && date("m")<=30){
             	 $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d",strtotime('-1day'))." 19:30' AND '".date("Y-m-d")." 07:30' ";
             
         }else{
         
	         $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d")." 19:30' AND '".date("Y-m-d",strtotime('+1day'))." 07:30' ";
         }
      }else{
         $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d",strtotime('-1day'))." 19:30' AND '".date("Y-m-d")." 07:30' ";	
      }
     
      
      $unidad=0;
	  for($a=0;$a<count($cant_histo);$a++){ 
 /*
 $sql = "SELECT e.LATITUDE,e.LONGITUDE,CAST(GPS_DATETIME AS DATE) AS FECHA,DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174) AS DISTANCIA,       MAX(GPS_DATETIME) AS JT,COUNT(e.COD_ENTITY) AS unidades, e.COD_ENTITY,CONCAT(f.DESCRIPTION,'-',f.PLAQUE) AS UNIT
		            FROM ".$cant_histo[$a]." e
		            LEFT JOIN SAVL1120 f ON e.COD_ENTITY = f.COD_ENTITY
					WHERE DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174)>0.05 
					".$rtime."
					AND e.COD_ENTITY IN (".$idunit.")
				
					ORDER BY e.GPS_DATETIME DESC";
			*/
			
			
  $sql = "SELECT MAX(GPS_DATETIME),e.COD_ENTITY,f.DESCRIPTION 
		            FROM ".$cant_histo[$a]." e
		            LEFT JOIN SAVL1120 f ON e.COD_ENTITY = f.COD_ENTITY
					WHERE DISTANCIA(e.LATITUDE,e.LONGITUDE,".$filtro.")>0.05 
					".$rtime."
					AND e.COD_ENTITY IN (".$idunit.")
					GROUP BY e.COD_ENTITY
					ORDER BY e.GPS_DATETIME DESC";
		  
		  
		  /*	GROUP BY e.COD_ENTITY
		       SELECT e.LATITUDE,e.LONGITUDE,e.GPS_DATETIME,ROUND(DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174),2) AS DISTANCIA 
		            FROM ".$cant_histo[$a]." e
					WHERE ROUND(DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174))<=0.05 
					AND e.GPS_DATETIME BETWEEN '".date(Y-m-d)." 07:30' AND ' ".date(Y-m-d)." 19:30'
					AND e.COD_ENTITY IN (".$idunit.")
					ORDER BY e.GPS_DATETIME ASC";*/

			$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			$unidad=$unidad+$count;			
			if($count>0){
			$agregado = ""; 	
			while($row = @mysqli_fetch_array($query)){
			    	
				 $conta = $conta+1;
				   
				 $arreglo[0][0] = $unidad;
				 $arreglo[$conta][1] = $row['FECHA'];
				 $arreglo[$conta][2] = $row['UNIT'];
				 $arreglo[$conta][3] = $row['COD_ENTITY'];
				 $arreglo[$conta][4] = $count;
				 //$arreglo[$conta][5] = $row['GPS_DATETIME'];
				 //$arreglo[$conta][6] = $row['GPS_DATETIME'];
     			}
			}

		
			
		}	
		}else{
			return false;
		}
		
		
			@mysqli_close($conexion);
			return $arreglo;

	}

//------------------------------------------------------------------------ PARA UNIDADES DETENIDAS -- rDetenido---

	function get_num_hist22($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
      
       $x_t = "";
	    
	  if(date("H")>=19 && date("H")<=23){
         $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d")." 19:30' AND '".date("Y-m-d",strtotime('+1day'))." 07:30' ";
      }else{
         $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d",strtotime('-1day'))." 19:30' AND '".date("Y-m-d")." 07:30' ";	
      }
      
      
	  for($a=0;$a<count($cant_histo);$a++){ 
      $sql = "SELECT e.LATITUDE,e.LONGITUDE,e.GPS_DATETIME,DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174) AS DISTANCIA,g.DESCRIPTION AS DESC_EVT,CONCAT(h.DESCRIPTION,'-',h.PLAQUE) AS UNIT, e.ANGLE,CAST(e.GPS_DATETIME AS DATE) AS FECHA
			FROM ".$cant_histo[$a]." e
			LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.COD_EVENT
			LEFT JOIN SAVL1120 h ON e.COD_ENTITY = h.COD_ENTITY
			WHERE (DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174)>0.05) 
			 ".$rtime."
			AND e.COD_ENTITY IN (".$idunit.")
			ORDER BY e.COD_ENTITY,e.GPS_DATETIME ASC;";
	
	
	
	/*$sql = "SELECT e.LATITUDE,e.LONGITUDE,e.GPS_DATETIME,DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174) AS DISTANCIA,e.COD_ENTITY AS xx,g.DESCRIPTION AS DESC_EVT,CAST(e.GPS_DATETIME AS DATE) AS FECHA,CONCAT(h.DESCRIPTION,'-',h.PLAQUE) AS UNIT, e.ANGLE
			FROM ".$cant_histo[$a]." e
			LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.COD_EVENT
			LEFT JOIN SAVL1120 h ON e.COD_ENTITY = h.COD_ENTITY
			WHERE (DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174)<=0.05) 
			".$x_t."
			AND e.COD_ENTITY IN (".$idunit.")
			ORDER BY e.COD_ENTITY,e.GPS_DATETIME DESC";
		  
		*/
		  
		  
		  /*
		  SELECT e.GPS_DATETIME,CAST(e.GPS_DATETIME AS DATE ) AS FECHA , e.COD_EVENT, f.DESCRIPTION AS EVT
				 FROM ".$cant_histo[$a]." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE e.COD_ENTITY IN (".$idunit.")
				 ".$rtime."
				 ".$filtro."
				  GROUP BY FECHA ORDER BY FECHA DESC";*/

			$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			
			if($count>0){
				
			while($row = @mysqli_fetch_array($query)){
				
				$conta = $conta+1;
				 $arreglo[$conta][0] = $row['FECHA'];
				 $arreglo[$conta][1] = $row['DESC_EVT'];
				 $arreglo[$conta][2] = $row['GPS_DATETIME'];
				 $arreglo[$conta][3] = $row['LATITUDE'];
				 $arreglo[$conta][4] = $row['LONGITUDE']; 
				 $arreglo[$conta][5] = $row['UNIT'];
				 $arreglo[$conta][6] = $row['ANGLE'];
				}
			}

		
			
		}	
		}else{
			return false;
		}
			@mysqli_close($conexion);
			return $arreglo;

	}
	///--------------------------------------------------------------
	function get_num_hist22_n($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
      
       $x_t = "";
	    
	  if(date("H")>=19 && date("H")<=23){
         $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d")." 19:30' AND '".date("Y-m-d",strtotime('+1day'))." 07:30' ";
      }else{
         $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d",strtotime('-1day'))." 19:30' AND '".date("Y-m-d")." 07:30' ";	
      }
      
      
	  for($a=0;$a<count($cant_histo);$a++){ 
      $sql = "SELECT e.LATITUDE,e.LONGITUDE,e.GPS_DATETIME,DISTANCIA(e.LATITUDE,e.LONGITUDE,".$filtro.") AS DISTANCIA,g.DESCRIPTION AS DESC_EVT,CONCAT(h.DESCRIPTION,'-',h.PLAQUE) AS UNIT, e.ANGLE,CAST(e.GPS_DATETIME AS DATE) AS FECHA
			FROM ".$cant_histo[$a]." e
			LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.COD_EVENT
			LEFT JOIN SAVL1120 h ON e.COD_ENTITY = h.COD_ENTITY
			WHERE (DISTANCIA(e.LATITUDE,e.LONGITUDE,".$filtro.")>0.05) 
			 ".$rtime."
			AND e.COD_ENTITY IN (".$idunit.")
			ORDER BY e.COD_ENTITY,e.GPS_DATETIME ASC;";
	
	
	
	/*$sql = "SELECT e.LATITUDE,e.LONGITUDE,e.GPS_DATETIME,DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174) AS DISTANCIA,e.COD_ENTITY AS xx,g.DESCRIPTION AS DESC_EVT,CAST(e.GPS_DATETIME AS DATE) AS FECHA,CONCAT(h.DESCRIPTION,'-',h.PLAQUE) AS UNIT, e.ANGLE
			FROM ".$cant_histo[$a]." e
			LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.COD_EVENT
			LEFT JOIN SAVL1120 h ON e.COD_ENTITY = h.COD_ENTITY
			WHERE (DISTANCIA(e.LATITUDE,e.LONGITUDE,19.380996,-99.20174)<=0.05) 
			".$x_t."
			AND e.COD_ENTITY IN (".$idunit.")
			ORDER BY e.COD_ENTITY,e.GPS_DATETIME DESC";
		  
		*/
		  
		  
		  /*
		  SELECT e.GPS_DATETIME,CAST(e.GPS_DATETIME AS DATE ) AS FECHA , e.COD_EVENT, f.DESCRIPTION AS EVT
				 FROM ".$cant_histo[$a]." e
				 LEFT JOIN SAVL1260 f ON f.COD_EVENT = e.COD_EVENT
				 LEFT JOIN SAVL1120 g ON g.COD_ENTITY = e.COD_ENTITY
				 WHERE e.COD_ENTITY IN (".$idunit.")
				 ".$rtime."
				 ".$filtro."
				  GROUP BY FECHA ORDER BY FECHA DESC";*/

			$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			
			if($count>0){
				
			while($row = @mysqli_fetch_array($query)){
				
				$conta = $conta+1;
				 $arreglo[$conta][0] = $row['FECHA'];
				 $arreglo[$conta][1] = $row['DESC_EVT'];
				 $arreglo[$conta][2] = $row['GPS_DATETIME'];
				 $arreglo[$conta][3] = $row['LATITUDE'];
				 $arreglo[$conta][4] = $row['LONGITUDE']; 
				 $arreglo[$conta][5] = $row['UNIT'];
				 $arreglo[$conta][6] = $row['ANGLE'];
				}
			}

		
			
		}	
		}else{
			return false;
		}
			@mysqli_close($conexion);
			return $arreglo;

	}
//----------------------------------
function get_num_hist23_n($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
			
      $x_t = "";
	    
	 if(date("H")>=19 && date("H")<=23){
	  	 if(date("m")>=00 && date("m")<=30){
             	 $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d",strtotime('-1day'))." 19:30' AND '".date("Y-m-d")." 07:30' ";
             
         }else{
         
	         $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d")." 19:30' AND '".date("Y-m-d",strtotime('+1day'))." 07:30' ";
         }
      }else{
         $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d",strtotime('-1day'))." 19:30' AND '".date("Y-m-d")." 07:30' ";	
      }
      
	  for($a=0;$a<count($cant_histo);$a++){ 
     $sql = "SELECT LATITUDE,LONGITUDE,GPS_DATETIME,DISTANCIA(LATITUDE,LONGITUDE,".$filtro.") AS DISTANCIA,COD_ENTITY AS xx
			 FROM ".$cant_histo[$a]." e
			 WHERE (DISTANCIA(LATITUDE,LONGITUDE,".$filtro."))>0.05 
			 ".$rtime."
		     AND e.COD_ENTITY IN (".$idunit.")
			 ORDER BY COD_ENTITY,GPS_DATETIME DESC
			 LIMIT 1;";
		  
	    	$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			
			if($count>0){
				
			while($row = @mysqli_fetch_array($query)){
				
				$conta = $conta+1;
				 $arreglo[$conta] = $row['GPS_DATETIME'];
				}
			}

		
			
		}	
		}else{
			return false;
		}
			@mysqli_close($conexion);
			return $arreglo;

	}
//----------------------------------

	function get_num_hist23($hist, $idunit, $rtime, $filtro){
		global $config_bd2;
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
	
		$conexion = @mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
		if($conexion){
			
      $x_t = "";
	    
	 if(date("H")>=19 && date("H")<=23){
	  	 if(date("m")>=00 && date("m")<=30){
             	 $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d",strtotime('-1day'))." 19:30' AND '".date("Y-m-d")." 07:30' ";
             
         }else{
         
	         $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d")." 19:30' AND '".date("Y-m-d",strtotime('+1day'))." 07:30' ";
         }
      }else{
         $x_t = " AND e.GPS_DATETIME BETWEEN '".date("Y-m-d",strtotime('-1day'))." 19:30' AND '".date("Y-m-d")." 07:30' ";	
      }
      
	  for($a=0;$a<count($cant_histo);$a++){ 
     $sql = "SELECT LATITUDE,LONGITUDE,GPS_DATETIME,DISTANCIA(LATITUDE,LONGITUDE,19.380996,-99.20174) AS DISTANCIA,COD_ENTITY AS xx
			 FROM ".$cant_histo[$a]." e
			 WHERE (DISTANCIA(LATITUDE,LONGITUDE,19.380996,-99.20174))>0.05 
			 ".$rtime."
		     AND e.COD_ENTITY IN (".$idunit.")
			 ORDER BY COD_ENTITY,GPS_DATETIME DESC
			 LIMIT 1;";
		  
	    	$query = @mysqli_query($conexion, $sql);
			$count = @mysqli_num_rows($query);
			
			if($count>0){
				
			while($row = @mysqli_fetch_array($query)){
				
				$conta = $conta+1;
				 $arreglo[$conta] = $row['GPS_DATETIME'];
				}
			}

		
			
		}	
		}else{
			return false;
		}
			@mysqli_close($conexion);
			return $arreglo;

	}
//----------------------------------RODWYN

function get_num_hist24($idunit, $rtime, $filtro){
		//global $config_bd2;
		global $db;
		$arreglo = array();
		$conta = -1;
		
 $sql="SELECT  D.ID_DESPACHO,D.DESCRIPCION AS RUTA, U.DESCRIPTION AS UND, E.DESCRIPCION AS EST, D.FECHA_INICIO, D.FECHA_FIN, 
(SELECT COUNT(I.ID_ENTREGA)  FROM DSP_ITINERARIO I WHERE I.ID_DESPACHO = D.ID_DESPACHO) AS TPV, D.FECHA_REAL_INICIO, 
D.FECHA_REAL_FIN,D.DIF_INICIO, D.DIF_FIN,D.TOTAL_DISTANCIA,D.TOTAL_EXCESOS,D.TOTAL_PARADAS FROM DSP_DESPACHO D
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO = D.ID_DESPACHO
INNER JOIN SAVL1120 U ON U.COD_ENTITY = UA.COD_ENTITY
INNER JOIN DSP_ESTATUS E ON E.ID_ESTATUS = D.ID_ESTATUS
WHERE U.COD_ENTITY=".$idunit.$rtime.$filtro;

			$query=$db->sqlQuery($sql);
			$count =$db->sqlEnumRows($query);
			
			if($count>0){
			
			while($row=$db->sqlFetcharray($query)){
				
				$conta = $conta+1;
				 $arreglo[$conta][0] = $row['RUTA'];
				 $arreglo[$conta][1] = $row['UND'];
				 $arreglo[$conta][2] = $row['EST'];
				 $arreglo[$conta][3] = $row['FECHA_INICIO'];
				 $arreglo[$conta][4] = $row['FECHA_FIN']; 
				 $arreglo[$conta][5] = $row['TPV'];
				 $arreglo[$conta][6] = $row['FECHA_REAL_INICIO'];
				 $arreglo[$conta][7] = $row['FECHA_REAL_FIN'];
				 $arreglo[$conta][8] = $row['DIF_INICIO'];
				 $arreglo[$conta][9] = $row['DIF_FIN'];
				 $arreglo[$conta][10] = $row['TOTAL_DISTANCIA']; 
				 $arreglo[$conta][11] = $row['TOTAL_EXCESOS'];
				 $arreglo[$conta][12] = $row['TOTAL_PARADAS'];
				 $arreglo[$conta][13] = $row['TOTAL_PARADAS'];
				 $arreglo[$conta][14] = $row['ID_DESPACHO'];	
				}
			}
			
			return $arreglo;

	}
//---------------------------------
function get_num_hist25($rtime,$filtro){
		global $db;
		$arreglo = array();
		$conta = -1;
/*$sql="SELECT  D.DESCRIPCION AS RUTA, U.DESCRIPTION AS UND, E.DESCRIPCION AS EST, D.FECHA_INICIO, D.FECHA_FIN, 
(SELECT COUNT(I.ID_ENTREGA)  FROM DSP_ITINERARIO I WHERE I.ID_DESPACHO = D.ID_DESPACHO) AS TPV, D.FECHA_REAL_INICIO, 
D.FECHA_REAL_FIN,D.DIF_INICIO, D.DIF_FIN,D.TOTAL_DISTANCIA,D.TOTAL_EXCESOS,D.TOTAL_PARADAS FROM DSP_DESPACHO D
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO = D.ID_DESPACHO
INNER JOIN SAVL1120 U ON U.COD_ENTITY = UA.COD_ENTITY
INNER JOIN DSP_ESTATUS E ON E.ID_ESTATUS = D.ID_ESTATUS
WHERE U.COD_ENTITY=".$idunit.$rtime;*/

$sql="SELECT GP. DESCRIPTION AS PUNTO, E.DESCRIPCION AS EST, D.FECHA_ENTREGA, D.FECHA_ARRIBO, D.FECHA_SALIDA, D.VISITA_DURACION FROM DSP_ITINERARIO D
INNER JOIN SAVL_G_PRIN GP ON GP.COD_OBJECT_MAP = D.COD_GEO
INNER JOIN DSP_ESTATUS E  ON  E.ID_ESTATUS = D.ID_ESTATUS
WHERE D.ID_DESPACHO=".$filtro;

			$query=$db->sqlQuery($sql);
			$count =$db->sqlEnumRows($query);
			
			if($count>0){
			
			while($row=$db->sqlFetcharray($query)){
				
				$conta = $conta+1;
				 $arreglo[$conta][0] = $row['PUNTO'];
				 $arreglo[$conta][1] = $row['EST'];
				 $arreglo[$conta][2] = $row['FECHA_ENTREGA'];
				 $arreglo[$conta][3] = $row['FECHA_ARRIBO'];
				 $arreglo[$conta][4] = $row['FECHA_SALIDA']; 
				 $arreglo[$conta][5] = $row['VISITA_DURACION'];
				 		 
				}
			}
			
			return $arreglo;

	}
//---------------------------------
//---------------------------------------------------------------	
function get_num_hist26($hist, $idunit, $rtime, $filtro, $cliente,$radio){
		global $config_bd2;
        
		$arreglo = array();
		$conta = -1;
		$cant_histo = explode('|',$hist);
		
		$conexion = mysqli_connect($config_bd2['host'],$config_bd2['user'],$config_bd2['pass'],$config_bd2['bname']);		
	   if($conexion){
		   for($a=0;$a<count($cant_histo);$a++){   			
$sql="SELECT 
E.COD_ENTITY,
CAST(E.GPS_DATETIME AS DATE) AS FECHA, 
CONCAT(G.DESCRIPTION,'-',G.PLAQUE) AS UNIDAD,
E.LATITUDE, 
E.LONGITUDE,
E.VELOCITY,
E.GPS_DATETIME,

IF((SELECT MIN(DISTANCIA (P.LATITUDE,P.LONGITUDE,E.LATITUDE,E.LONGITUDE)) FROM SAVL_G_PRIN P WHERE  P.COD_CLIENT = 124)<".$radio.",1,0) AS PARADAS
FROM ".$cant_histo[$a]." E
LEFT JOIN SAVL1120 G ON G.COD_ENTITY = E.COD_ENTITY 
WHERE E.COD_ENTITY IN (".$idunit.")
".$rtime."
".$filtro."
ORDER BY E.COD_ENTITY,E.GPS_DATETIME ASC;";		
					$query = mysqli_query($conexion, $sql);
					while($row = @mysqli_fetch_array($query)){						
						$conta = $conta+1;
						$arreglo[$conta][0] = $row['FECHA'];
						$arreglo[$conta][1] = $row['UNIDAD'];
						$arreglo[$conta][2] = $row['COD_ENTITY'];
						$arreglo[$conta][3] = $cant_histo[$a];
						$arreglo[$conta][4] = $row['LATITUDE'];
						$arreglo[$conta][5] = $row['LONGITUDE'];
						$arreglo[$conta][6] = $row['VELOCITY'];						
						$arreglo[$conta][7] = $row['DISTANCE'];
						$arreglo[$conta][8] = $row['PARADAS'];
						$arreglo[$conta][9] = $row['GPS_DATETIME'];
					}

			
			}
			
		}else{
			return false;
		}
	
	   return $arreglo;
	} 
//---------------------------------------------------------------		
}
?>
