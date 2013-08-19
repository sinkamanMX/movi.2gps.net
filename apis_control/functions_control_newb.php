<?php


  if (!function_exists('json_encode')){
    function json_encode($a=false){
        if (is_null($a)) return 'null';
        if ($a === false) return 'false';
        if ($a === true) return 'true';
        if (is_scalar($a)){
            if (is_float($a)){
                // Siempre usa "." para floats.
                return floatval(str_replace(",", ".", strval($a)));
            }
            if (is_string($a)){
                static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
                return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
            }else
              return $a;
        }

        $isList = true;
        for ($i = 0, reset($a); $i < count($a); $i++, next($a)){
            if (key($a) !== $i){
                $isList = false;
                break;
            }
        }

        $result = array();

        if ($isList){
            foreach ($a as $v) $result[] = json_encode($v);
            return '[' . join(',', $result) . ']';
        }else{
            foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
            return '{' . join(',', $result) . '}';
        }

    }

  }
  
  function array_type($array){
    if (is_array($array)){
      $next = 0;
      $return_value = "vector";  // we have a vector until proved otherwise
      foreach ($array as $key => $value){
        if ($key != $next){
          $return_value = "map";  // we have a map
          break;
        }
        $next++;
      }
      return $return_value;
    }
    return false;    // not array
   }

   function utf8_encode_array($array){
     if (is_array($array)){
       $result_array = array();
       foreach($array as $key => $value){
         if (array_type($array) == "map"){
           // encode both key and value
           if (is_array($value)){
             // recursion
             $result_array[utf8_encode($key)] = utf8_encode_array($value);
           }else{
             // no recursion
             if (is_string($value)){
               $result_array[utf8_encode($key)] = utf8_encode($value);
             }else{
               // do not re-encode non-strings, just copy data
               $result_array[utf8_encode($key)] = $value;
             }
           }
         }else if (array_type($array) == "vector"){
           // encode value only
           if (is_array($value)) {
             // recursion
             $result_array[$key] = utf8_encode_array($value);
           }else{
             // no recursion
             if (is_string($value)){
               $result_array[$key] = utf8_encode($value);
             }else{
               // do not re-encode non-strings, just copy data
               $result_array[$key] = $value;
             }
           }
         }
       }
       return $result_array;
     }
     return false;     // argument is not an array, return false
   }

  function existe_dispositivo($imei,&$id_cliente){
	global $base;
    $resultado =0;
	$sql = "SELECT COUNT(1) AS CUENTA,COD_CLIENT
            FROM SAVL1120
            WHERE ITEM_NUMBER_UNITY='".$imei."'";

	$qry = mysql_query($sql);
	if($qry){
      $row = mysql_fetch_object($qry);
	  $resultado = $row->CUENTA;    
	  $id_cliente= $row->COD_CLIENT; 
	  mysql_free_result($qry);
	}
	return $resultado;
  }
  
  function existeUsuario($usName,$usPassword,$base){
    $result = -1;
	$sql = "SELECT ID_USUARIO AS EXISTE 
	        FROM ADM_USUARIOS 
		    WHERE USUARIO = '".$usName."' AND  
		          SHA1_PASSWORD = '".$usPassword."'";
	if ($qry = mysql_query($sql)){
	  $row = mysql_fetch_object($qry);
	  if ($row->EXISTE > 0){
	    $result = $row->EXISTE;
	  }
	  mysql_free_result($qry);
	}
	return $result;
  }

  function verifica_grupo($codUser,$base,&$s){
    $result = false;
	$sql = "SELECT count(1) AS EXISTE
			FROM ADM_USUARIOS_GRUPOS 
			WHERE ID_USUARIO = ".$codUser; 
	$s = $sql;
	if ($qry = mysql_query($sql)){
	  $row = mysql_fetch_object($qry);
	  if ($row->EXISTE >= 1){
	    $result = true;
	  }
	  mysql_free_result($qry);
	}
	return $result;
  }
  
   function verificaVersion($codUser,$base,&$version,&$url,$item_app){
	$sql = " SELECT ADM_APLICACIONES_VERSION.VERSION,
	                ADM_APLICACIONES_EMPRESA.URL_PRIMARIO
	         FROM ADM_USUARIOS
			 INNER JOIN ADM_APLICACIONES_EMPRESA ON                
			            ADM_USUARIOS.ID_EMPRESA=ADM_APLICACIONES_EMPRESA.ID_EMPRESA
			 INNER JOIN ADM_APLICACIONES_VERSION ON 
			            ADM_APLICACIONES_VERSION.ID_VERSION=ADM_APLICACIONES_EMPRESA.ID_VERSION
	         WHERE 	ADM_APLICACIONES_EMPRESA.ITEM_APP='".$item_app."' AND
			        ADM_USUARIOS.ID_USUARIO=".$codUser; 
			 
					
	if ($qry = mysql_query($sql)){
	  $row = mysql_fetch_object($qry);
	  $version = $row->VERSION;
	  $url = $row->URL_PRIMARIO; 
	  mysql_free_result($qry);
	}
  }
  
  
  
  /************************************************************************************************************/
  
  
	
	  function unidades($cod_user){
		$total=1;
		$sql  = "SELECT e.ID_GRUPO,
 		                f.COD_CLIENT,
		                g.NOMBRE,
		                q.IMEI as PLAQUE,
		                f.DESCRIPTION, 
						f.COD_ENTITY
				 FROM  ADM_USUARIOS_GRUPOS e
				 INNER JOIN ADM_UNIDADES f ON e.COD_ENTITY = f.COD_ENTITY
				 INNER JOIN ADM_UNIDADES_EQUIPOS u ON u.COD_ENTITY=f.COD_ENTITY
				 INNER JOIN ADM_EQUIPOS q ON q.COD_EQUIPMENT=u.COD_EQUIPMENT
				 INNER JOIN ADM_GRUPOS g ON g.ID_GRUPO = e.ID_GRUPO
				 WHERE  f.ACTIVE =1 AND e.ID_USUARIO =".$cod_user;
		$query=mysql_query($sql);
		if($query){

		   while($row=mysql_fetch_array($query)){
			   $unidad["id_error"]=$row['ID_GRUPO'];
			   $unidad['Grupo']=$row['NOMBRE'];
			   $unidad['Cod_entity']=$row['COD_ENTITY'];
			   $unidad['Cod_client']=$row['COD_CLIENT'];
			   $unidad['Plaque']=$row['PLAQUE'];
			   $unidad['Descrip']=$row['DESCRIPTION'];
			   $unidades[]=$unidad;
		  }
	    }
	    return $unidades;
	  }
	
	
	
    
	
  /*******************************************************************************************************/
  
  
  function comandos($user,$cod_entity){
		$total=1;
		 $sql  = "SELECT C.IMEI as SECOND_ITEM_NUMBER,
					   D.DESCRIPTION,
					   C.PHONE,
					   F.DESCRIPCION,
					   E.COMMAND_EQUIPMENT,
					   E.COD_EQUIPMENT_PROGRAM,
					   E.FlAG_SMS
				FROM ADM_UNIDADES A
				  INNER JOIN ADM_UNIDADES_EQUIPOS B  ON B.COD_ENTITY  = A.COD_ENTITY
				  INNER JOIN ADM_EQUIPOS C   ON C.COD_EQUIPMENT  = B.COD_EQUIPMENT
				  INNER JOIN ADM_EQUIPOS_TIPO D  ON D.COD_TYPE_EQUIPMENT = C.COD_TYPE_EQUIPMENT
				  INNER JOIN ADM_COMANDOS_SALIDA E  ON E.COD_TYPE_EQUIPMENT = D.COD_TYPE_EQUIPMENT
				  INNER JOIN ADM_COMANDOS_CLIENTE F  ON F.COD_EQUIPMENT_PROGRAM = E.COD_EQUIPMENT_PROGRAM
				  INNER JOIN ADM_COMANDOS_USUARIO G  ON G.ID_COMANDO_CLIENTE = F.ID_COMANDO_CLIENTE
				WHERE A.COD_ENTITY =".$cod_entity."
				 AND  G.ID_USUARIO = ".$user;
		$query=mysql_query($sql);
		$cuenta=0;
		if($query){
		   while($row=mysql_fetch_assoc($query)){
			   $cuenta++;
			   $output[]=utf8_encode_array($row);
		  }
		  if($cuenta<=0){
			  $resultado["PHONE"]="-1";
	          $resultado["DESCRIPCION"]="Sin comandos disponibles";  
			  $resultado["SECOND_ITEM_NUMBER"]="-1";
			  $resultado["COMMAND_EQUIPMENT"]="-1";
			  $resultado["COD_EQUIPMENT_PROGRAM"]="-1";
			  $output[]=$resultado;
		  }
	    }else{
		  $resultado["PHONE"]="-1";
	      $resultado["DESCRIPCION"]="Sin poder ejecutar Query"; 
		  $resultado["SECOND_ITEM_NUMBER"]="-1";
		  $resultado["COMMAND_EQUIPMENT"]="-1"; 
		  $resultado["COD_EQUIPMENT_PROGRAM"]="-1";
		  $output[]=$resultado;
		}
		return json_encode($output);
   }

	function get_tablename($id_client){
	  
	  $id_client = (int)$id_client; 
	  //$id_client=0;
	  $table_name = '';  
	  if (strlen($id_client) < 5) {
			 $table_name = str_repeat('0', (5-strlen($id_client)));
		 }
		 return $table_name . $id_client;
	 }

   function posicion($cod_e,$Cod_client){
		$total=1;
		$tabla="LAST".get_tablename($Cod_client);
		$sql="SELECT IF(".$tabla.".LATITUDE IS NOT NULL,".$tabla.".LATITUDE,0) AS LATITUDE,
				   IF(".$tabla.".LONGITUDE IS NOT NULL,".$tabla.".LONGITUDE,0) AS LONGITUDE ,
				   ADM_EVENTOS.DESCRIPTION AS EVENTO,
				   ".$tabla.".GPS_DATETIME,
				   'OK' AS MENSAJE,
				   1 AS ERROR
			FROM ".$tabla."
				  INNER JOIN ADM_EVENTOS ON ADM_EVENTOS.COD_EVENT = ".$tabla.".COD_EVENT
				  WHERE ".$tabla.".COD_ENTITY=".$cod_e;
		$query=mysql_query($sql);
		$cuenta=0;
		if($query){
		   while($row=mysql_fetch_assoc($query)){
			   $cuenta++;
			   $output[]=utf8_encode_array($row);
		  }
		  
		  if($cuenta<=0){
			  $resultado["ERROR"]="-1";
	          $resultado["MENSAJE"]="Sin posición disponible";  
			  $output[]=$resultado;
		  }
	    }
		return json_encode($output);
    }
	
	function dame_direccion($latitud, $longitud){
      $direccion = 'No es posible determinar la dirección';
      $link = mysqli_connect("localhost", "savl", "397LUP", "ALG_BD_SP");
    //$mysqli = new mysqli(DBURI,DBUSER,DBPASS,DBNAME);
      if($link){
        $sqlbc  = "CALL SPATIAL_CALLES(".$longitud.",".$latitud.")";
     // echo $sqlbc.'\n';
        if ($result  = mysqli_query($link, $sqlbc)){
        //echo $countbc = mysqli_num_rows($result).'<br>';
		  $direccion = '';
          while($rowbc =  mysqli_fetch_object($result)){
            $direccion = $direccion .$rowbc->CALLE.','.
                           $rowbc->CIUDAD.','.
                           $rowbc->CP.','.
                           $rowbc->MUNICIPIO.','.
                           $rowbc->ASENTAMIENTO.','.
                           $rowbc->ESTADO;
        }
      } else {
        $direccion ="no ejecuta el query";
      }
      mysqli_close($link);
    } else {
      $direccion ="no se conecto";
    }
    return $direccion;
  }
  
  
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
	public $enviado    = 0;
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
	
	public function set_enviado($value=0){ $this->enviado= $value; }
	
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
					$procesado="";
					if(trim($this->enviado)=="1"){
						$procesado=" PROCESADO = CURRENT_TIMESTAMP, ";
					}else{
						$procesado="";
					}
					
					$sql = 'INSERT INTO ADM_COMANDOS_ENVIADOS
							SET ID_USUARIO = '. $this->id_usuario		.'	, 
								COMANDO	   = "'.$this->nombre_comando	.'",
								SINTAXIS   = "'.$this->sintaxis_comando	.'"	,
								IMEI	   = "'.$this->imei_unit		.'"	,
								CREADO     = CURRENT_TIMESTAMP	,
								COMENTARIOS= "'.$this->comentario		.'" ,
								'.$procesado.'
								ENVIADO    ='.$this->enviado.',
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
  
  
?>

