<?php
/** * 
 *  @package             movi
 *  @name                Obtiene la pocision en basado en radioBase 
 *  @copyright           Air Logistics & GPS S.A. de C.V.
 *  @author              Enrique Peña 
 *  @modificado          04-10-2013 
**/

/**
 * Clase de Localizacion en base a Servicios
 * 
*/
class LocationBasedService{
    /**
     * Parametros de Conexion
     * @var Array
    */
	public $bdParametros  = Array();
    /**
     * Variable de Conexion a BD
     * @var Conexion
    */ 
    public $conexion=null;       
    /**
     * Parametros de Conexion Espacial
     * @var Array
    */    
    public $bdParametrosSp  = Array();
    /**
     * Variable de Conexion a BD Espacial
     * @var Conexion
    */ 
    public $conexionSpatial=null;       
    /**
     * Indica la Mac Address a buscar.
     * @var String
    */     
    public $lbsMacAddress = '';
    /**
     * Indica la clave CGI a buscar.
     * @var String
    */      
    public $lbsGci        = '';
    /**
     * Indica la clave LAI a buscar.
     * @var String
    */     
    public $lbsLai        = '';
    /**
     * Indica si se desea mostrar la direccion completa.
     * @var Boolean
    */     
    public $getDireccion  = false;
                      
    /**
     * Establece los datos de conexion a la bd.
     * @var $params Array 
     * @return void
    */        
    public function setConfigBdParams($iparams=Array()){$this->bdParametros = $iparams;}

    /**
     * Establece los datos de conexion a la bd Espacial.
     * @var $params Array 
     * @return void
    */            
    public function setConfigBdSpParams($iparams=Array()){$this->bdParametrosSp = $iparams;}
    
    /**
     * Establece la Mac Address
     * @var $iMac String 
     * @return void
    */            
    public function setLbsMac($iMac=false){ $this->lbsMacAddress = $iMac; }
    
    /**
     * Establece la clave GCI
     * @var $iGci String 
     * @return void
    */    
    public function setLbsGCI($iGci=false){ $this->lbsGci = $iGci; }
        
    /**
     * Establece la clave LAI
     * @var $iLai String 
     * @return void
    */                
    public function setLbsLAI($iLai=false){ $this->lbsLai = $iLai; }
    
    /**
     * Establece si en las busquedas se mostrara la direccion.
     * @var $getDireccion Boolean 
     * @return void
    */            
    public function setGetDireccion($iBuscarDireccion=false){ $this->getDireccion = $iBuscarDireccion; }
      
    /**
     * Establece la conexion a la BD.
     * @return conexion
    */     
	public function startConexion(){
	  $this->conexion = mysqli_connect($this->bdParametros['host'],
	  			$this->bdParametros['user'],$this->bdParametros['pass'],$this->bdParametros['bname']);     	
	}
	
    /**
     * Cierra la conexion  a la BD
     * @return conexion
    */      
	public function closeConexion(){
		if($this->conexion){
			mysqli_close($this->conexion);	
		}		
	} 
    
    /**
     * Establece la conexion a la BD Espacial.
     * @return conexion
    */     
	public function startConexionSp(){
	  $this->conexionSpatial = mysqli_connect($this->bdParametrosSp['host'],
	  			$this->bdParametrosSp['user'],$this->bdParametrosSp['pass'],$this->bdParametrosSp['bname']);
	}
	
    /**
     * Cierra la conexion  a la BD Espacial
     * @return conexion
    */      
	public function closeConexionSp(){
		if($this->conexionSpatial){
			mysqli_close($this->conexionSpatial);	
		}		
	}
    
    /**
     * Busca la pocision requerida.
     * @return Array
    */       
    public function buscarPosicion(){
        $result = Array();
        $this->startConexion(); 
        if($this->conexion){
            $sql = "CALL POSICION('".$this->lbsMacAddress."',".$this->lbsGci.",".$this->lbsLai.");";
            $query = mysqli_query($this->conexion, $sql);
            if($query){
               if(!$query){echo mysqli_error();}            
                $row = @mysqli_fetch_array($query);  
                if($row['ORIGEN'] != 'no-info1'){
                    $result['status']   = 'ok-info';  
                    $result['origen']   = $row['ORIGEN'];
                    $result['latittud'] = $row['LATITUD'];
                    $result['longitud'] = $row['LONGITUD'];
                    if($this->getDireccion){
                        $direccion = $this->getDireccionResult($row['LATITUD'],$row['LONGITUD']);
                        $result['DIRECCION'] = $direccion;
                    }                  
                }else{
                    $result['status'] = 'no-info2';
                } 
            }else{
                $result['status'] = 'error-query';    
            } 
            $this->closeConexion();                
        }else{
            $result['status'] = 'error-conexion';
        }
        return $result;
    }
    
    /**
     * Busca la Direccion en base a latitud y longitud.
     * @var $iLatitud   decimal
     * @var $iLongitud  decimal
     * @return Array
    */
	function getDireccionResult($iLatitud,$iLongitud){
        $result = Array();
        $this->startConexionSp();
        if($this->conexionSpatial){
            $sql   = "CALL SPATIAL_CALLES(".$iLatitud.",".$iLongitud.");";
			$query = mysqli_query($this->conexionSpatial, $sql);
			$row   = @mysqli_fetch_object($query);  
            
            $result['ESTADO']       = $row->ESTADO;
            $result['MUNICIPIO']    = $row->MUNICIPIO;
            $result['ASENTAMIENTO'] = $row->ASENTAMIENTO; 
            $result['CALLE']        = $row->CALLE;
            
            $this->closeConexionSp();            
        }
        return $result;
	}    
}