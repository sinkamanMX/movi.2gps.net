<?php
/** * 
 *  @package             4TOGO
 *  @name                Obtiene la ultima pocision de las unidades de la BD 192.168.6.45
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          02-12-2010 
**/
class cCommands{
	public $id_usuario = 0;
	public $id_unidad  = 0;
	public $comentario = 0;
	public $id_comand  = 0;
	public $origen	   = 0;
	public $bd_params  = 0;
	public $conexion; 	
	public $nombre_comando  ='';
	public $sintaxis_comando='';
	public $imei_unit=0;
	public $cod_type_equipment=0;
	public $cod_equipment=0;

	public function set_config_bd($params=Array()){ $this->bd_params = $params;}
	
	public function set_usuario($value=0){ $this->id_usuario= $value; }	

	public function set_unidad($value=0){ $this->id_unidad= $value; }	
	
	public function set_comentario($value=0){ $this->comentario= $value;}	
	
	public function set_idcomando($value=0){ $this->id_comand= $value; }
	
	public function set_origen($value=0){ $this->origen= $value; }									
	
	public function start_conexion(){
	  $this->conexion = mysqli_connect($this->bd_params['host'],
	  			$this->bd_params['user'],$this->bd_params['pass'],$this->bd_params['bname']);	
	}
	
	public function close_conexion(){
		if($this->conexion){
			mysqli_close($this->conexion);	
		}		
	}
	
	function valida_usuario(){
		$permiso=false;
		$this->start_conexion();
		if($this->conexion){
			$sql = 'SELECT  F.DESCRIPCION,E.COMMAND_EQUIPMENT ,C.IMEI, B.COD_EQUIPMENT, D.COD_TYPE_EQUIPMENT 
					FROM ADM_UNIDADES A
					  INNER JOIN ADM_UNIDADES_EQUIPOS B 	ON B.COD_ENTITY 	= A.COD_ENTITY
					  INNER JOIN ADM_EQUIPOS C 		ON C.COD_EQUIPMENT 	= B.COD_EQUIPMENT
					  INNER JOIN ADM_EQUIPOS_TIPO D 	ON D.COD_TYPE_EQUIPMENT = C.COD_TYPE_EQUIPMENT
					  INNER JOIN ADM_COMANDOS_SALIDA E 	ON E.COD_TYPE_EQUIPMENT = D.COD_TYPE_EQUIPMENT
					  INNER JOIN ADM_COMANDOS_CLIENTE F 	ON F.COD_EQUIPMENT_PROGRAM = E.COD_EQUIPMENT_PROGRAM
					  INNER JOIN ADM_COMANDOS_USUARIO G 	ON G.ID_COMANDO_CLIENTE = F.ID_COMANDO_CLIENTE
					WHERE A.COD_ENTITY = '.$this->id_unidad.'
					  AND  G.ID_USUARIO = '.$this->id_usuario.'
					  AND  E.COD_EQUIPMENT_PROGRAM = '.$this->id_comand.' LIMIT 1';
			$query = mysqli_query($this->conexion, $sql);
			$count = @mysqli_num_rows($query);
			if($count>0){	
				$row = @mysqli_fetch_array($query);
				$this->nombre_comando   = $row['DESCRIPCION'];
				$this->sintaxis_comando = $row['COMMAND_EQUIPMENT'];
				$this->imei_unit		= $row['IMEI'];
				$this->cod_equipment    = $row['COD_EQUIPMENT'];
				$this->cod_type_equipment= $row['COD_TYPE_EQUIPMENT'];
				$permiso = true;
			}else{
				$permiso = false;
			}
			$this->close_conexion();
		}
		
		return $permiso;
	}	
	
	function guarda_comando(){
		$respuesta = 'no-send';
		if($this->valida_usuario()){
			$this->start_conexion();
			if($this->conexion){
				if(!$this->comandos_pendientes()){
					$sql = 'INSERT INTO ADM_COMANDOS_ENVIADOS
							SET ID_USUARIO = '. $this->id_usuario		.'	, 
								COMANDO	   = "'.$this->nombre_comando	.'",
								SINTAXIS   = "'.$this->sintaxis_comando	.'"	,
								IMEI	   = "'.$this->imei_unit		.'"	,
								CREADO     = CURRENT_TIMESTAMP	,
								COMENTARIOS= "'.$this->comentario		.'" ,
								ORIGEN     = "'.$this->origen			.'" ,
								COD_TYPE_EQUIPMENT = '.$this->cod_type_equipment.',
								COD_EQUIPMENT      = '.$this->cod_equipment;
					$query   = mysqli_query($this->conexion, $sql);	
					if($query){
						$respuesta = 'send';		
					}						
				}else{
					$respuesta = 'pending';			
				}
				$this->close_conexion();
			}						
		}else{
			$respuesta = 'no-perm';	
		}
		return $respuesta;
	}
	
	function comandos_pendientes(){
		$pendientes=false;
		$this->start_conexion();
		if($this->conexion){
			$sql = 'SELECT ENVIADO
 					FROM ADM_COMANDOS_ENVIADOS 
 					WHERE IMEI    = "'.$this->imei_unit.'"
   					  AND COMANDO = "'.$this->nombre_comando.'"
 					  AND ORIGEN  = "'.$this->origen.'" 
					  AND ENVIADO = 0';	  
			$query = mysqli_query($this->conexion, $sql);
			$count = @mysqli_num_rows($query);
			if($count>0){
				$pendientes = true;
			}else{
				$pendientes = false;
			}
		}
		return $pendientes;		
	}		
}