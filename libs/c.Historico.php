<?php
/** * 
 *  @package             4TOGO
 *  @name                Obtiene la ultima pocision de las unidades de la BD 192.168.6.45
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          24-06-2013 
**/
class cHistorico{	
	public $idClient=0;
	public $idUnit  =0;
	public $aHistorico= Array();
	public $aHistorico2 = Array();
	public $aResumen  = Array();
	public $errorMessage='';
	
	public function setClient($idClient){
		$this->idClient = $idClient;
	}
	
	public function setUnit($idUnit){
		$this->idUnit = $idUnit;
	}
	
	public function getErrorMessage(){
		return $this->errorMessage;
	}
	
	public function getTableName(){
		$this->idClient = (int)$this->idClient;	
		$tableName = '';		
		if (strlen($this->idClient) < 5) {
	        $tableName = str_repeat('0', (5-strlen($this->idClient)));
	    }
    	return $tableName . $this->idClient;
	}
		
	public function getHitorico($sqlOptions=''){
		global $db,$Positions;
		$result = false;	
		$tableName = $this->getTableName();
		if($tableName!=""){			
			$this->aHistorico = Array();				
			$sqlHistorico = "SELECT 
							IF(f.PLAQUE IS NULL,'NP',f.PLAQUE) AS PLAQUE,
							IF(f.DESCRIPTION IS NULL,'',f.DESCRIPTION) AS DESCRIPTION, 
							f.COD_ENTITY,
							e.COD_EVENT,
							IF (e.GPS_DATETIME IS NULL, '0000-00-00 00:00:00',e.GPS_DATETIME) AS GPS_DATETIME,
							IF(g.DESCRIPTION IS NULL,'NO HA REPORTADO',g.DESCRIPTION) AS DESC_EVT,
							IF(e.VELOCITY IS NULL,0,e.VELOCITY) AS VELOCIDAD,        
							IF(e.LATITUDE IS NULL,0,e.LATITUDE) AS LATITUDE,
							IF(e.LONGITUDE IS NULL,0,e.LONGITUDE) AS LONGITUDE,
							IF (g.PRIORITY is null,0,g.PRIORITY) as PRIORITY,
							IF ((e.VELOCITY < 5) AND (e.MOTOR = 'ON'),'RALENTI',
							IF((e.VELOCITY = 0) AND (e.MOTOR = 'OFF'),'DETENIDO',
							IF((e.VELOCITY > 5) AND (e.MOTOR = 'ON'),'MOVIMIENTO','DESCONOCIDO'))) AS ESTATUS 
							FROM ADM_UNIDADES f  
							LEFT JOIN HIST".$tableName." e 
								ON e.COD_ENTITY = f.COD_ENTITY
							LEFT JOIN ADM_EVENTOS g 
								ON e.COD_EVENT  = g.COD_EVENT
							WHERE e.COD_ENTITY = ".$this->idUnit." ".$sqlOptions.
							" ORDER BY e.GPS_DATETIME";
			$query 	= $db->sqlQuery($sqlHistorico);
			while($row = $db->sqlFetchAssoc($query)){
				$hDireccion = $Positions->direccion_no_format($row['LATITUDE'],$row['LONGITUDE']);
				$row['direccion']   = ($hDireccion!="") ? $hDireccion: "S/D";
				$this->aHistorico[] = $row;
			}
			$this->errorMessage = "ok";
			$result =  true;
		}else{
			$this->errorMessage = "problem-table-name"; 
			$result = false;
		}
		return $result;		
	}
	
	
		function hist_geo($sqlOptions=''){
	    global $db,$Positions;
		$result = false;	
		$tableName = $this->getTableName();
		if($tableName!=""){		
		    $cont = -1;	
			$this->aHistorico2 = Array();				
			$sqlHistorico = "SELECT 
							IF(f.PLAQUE IS NULL,'NP',f.PLAQUE) AS PLAQUE,
							IF(f.DESCRIPTION IS NULL,'',f.DESCRIPTION) AS DESCRIPTION, 
							f.COD_ENTITY,
							e.COD_EVENT,
							IF (e.GPS_DATETIME IS NULL, '0000-00-00 00:00:00',e.GPS_DATETIME) AS GPS_DATETIME,
							IF(g.DESCRIPTION IS NULL,'NO HA REPORTADO',g.DESCRIPTION) AS DESC_EVT,
							IF(e.VELOCITY IS NULL,0,e.VELOCITY) AS VELOCIDAD,        
							IF(e.LATITUDE IS NULL,0,e.LATITUDE) AS LATITUDE,
							IF(e.LONGITUDE IS NULL,0,e.LONGITUDE) AS LONGITUDE,
							IF (g.PRIORITY is null,0,g.PRIORITY) as PRIORITY,
							IF ((e.VELOCITY < 5) AND (e.MOTOR = 'ON'),'RALENTI',
							IF((e.VELOCITY = 0) AND (e.MOTOR = 'OFF'),'DETENIDO',
							IF((e.VELOCITY > 5) AND (e.MOTOR = 'ON'),'MOVIMIENTO','DESCONOCIDO'))) AS ESTATUS 
							FROM ADM_UNIDADES f  
							LEFT JOIN HIST".$tableName." e 
								ON e.COD_ENTITY = f.COD_ENTITY
							LEFT JOIN ADM_EVENTOS g 
								ON e.COD_EVENT  = g.COD_EVENT
							WHERE e.COD_ENTITY = ".$this->idUnit." ".$sqlOptions.
							" ORDER BY e.GPS_DATETIME";
			$query 	= $db->sqlQuery($sqlHistorico);
			while($row = $db->sqlFetchAssoc($query)){
			$cont++;
			$this->aHistorico2[$cont][0] = $row['LATITUDE'];
			$this->aHistorico2[$cont][1] = $row['LONGITUDE'];
			
			}
			$this->errorMessage = "ok";
			//$result =  true;
		}else{
			$this->errorMessage = "problem-table-name"; 
			//$result = false;
		}
		return $this->aHistorico2;		
	}
	
	
	public function getResumen(){
		global $db,$Positions;
		$result		= false;
		$eventos 	= Array();
		$aControl	= Array();
		if(count($this->aHistorico)>0){
			$controlResumen = Array();
			
			foreach($this->aHistorico as $element){
				$aControl['unit'] = $element['DESCRIPTION'];
				//El evento es igual al anterior, por lo que se debe de sumar el tiempo
				if(count($controlResumen)<=0){
					$controlResumen = $element;
				}else{					
					$distancia = $Positions->distancia_entre_puntos($controlResumen['LATITUDE'],
										$controlResumen['LONGITUDE'],$element['LATITUDE'],$element['LONGITUDE']);		
					$aControl['recorrido'] += ($distancia>.05) ? $distancia : 0;
																			            
					//El evento tiene es el mismo, se debe de contar el tiempo
					if($controlResumen['COD_EVENT']==$element['COD_EVENT']){
						$diferenciaTiempo = $Positions->diferencia_tiempo($controlResumen['GPS_DATETIME'],
																			            $element['GPS_DATETIME']);
					}else{
						$diferenciaTiempo =  rand(0, 60);						
					}
					
					//Vehiculo Detenido
					if($element['VELOCIDAD'] == 0){
						$aControl['tiempoDetenido'] += $diferenciaTiempo; 
					//Vehiculo en Ralenti 	
					}else if($element['VELOCIDAD'] < 5 AND $element['VELOCIDAD'] >0){
						$aControl['tiempoRalenti'] += $diferenciaTiempo;
						$aControl['count']++;
						$aControl['total']+=$element['VELOCIDAD'];
					//Vehiculo en MOvimiento 	
					}else if($element['VELOCIDAD'] > 5){
						$aControl['tiempoMovimiento'] += $diferenciaTiempo;
						$aControl['count']++;
						$aControl['total']+=$element['VELOCIDAD'];	
					}
				}
				
				$aControl['maxima'] = ($aControl['maxima']<$element['VELOCIDAD']) 
											? $element['VELOCIDAD']: $aControl['maxima'];			
				/*Genera el resumen de los eventos generados*/	
				$eventos[$element['COD_EVENT']]['idEvent']  = $element['COD_EVENT'];			
				$eventos[$element['COD_EVENT']]['name']     = $element['DESC_EVT'];
				$eventos[$element['COD_EVENT']]['total']++;  	
				$controlResumen = $element;			
			}
			
			$aControl['tiempoMovimiento'] 	= $this->formatSeconds($aControl['tiempoMovimiento'] );
			$aControl['tiempoRalenti']		= $this->formatSeconds($aControl['tiempoRalenti']);
			$aControl['tiempoDetenido']		= $this->formatSeconds($aControl['tiempoDetenido']);
			
			$aControl['total'] 				= isset($aControl['total']) ? $aControl['total']: "0";
			
			$aControl['promedio'] 	   		= ($aControl['total']>0)?($aControl['total']/$aControl['count']) : 0;  
			$this->aResumen['resumen'] 		= $aControl;
			$this->aResumen['eventos'] 		= $eventos;
			$result = true;
		}else{
			$this->errorMessage = "problem-resumen-data";
			$result = false;
		}	
		return $result;
	}
	
	function formatSeconds($secs){
		if ($secs<0) return false;
		$m = (int)($secs / 60); $s = $secs % 60;
		$h = (int)($m / 60); $m = $m % 60;
		$h = ($h<10) ? "0".$h : $h;
		$m = ($m<10) ? "0".$m : $m;
		$s = ($s<10) ? "0".$s : $s;
		return $h.":".$m.":".$s;
	}	
	

		
}
	