<?php
/** * 
 *  @package             
 *  @name                Script que obtiene los datos a mostrar en la tabla
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$problems =0;
	$id_row=0;
	$response = array('result' => 'no-data');

	if(isset($_GET['name']) && isset($_GET['lat']) && isset($_GET['lon']) && isset($_GET['radio']) && 
 			isset($_GET['privacidad']) && isset($_GET['geos_id']) && isset($_GET['tipo']) && isset($_GET['calle'])){
 				
 		$id_row   = $_GET['geos_id'];		
		$name	  = $_GET['name'];
        $geos_id	= $_GET['geos_id'];               
        $calle	  = $_GET['calle'];     
        $noint	  = $_GET['noint'];     
        $noext	  = $_GET['noext'];     
        $colonia	= $_GET['colonia'];   
        $municipio	= $_GET['municipio']; 
        $estado	  	= $_GET['estado'];    
        $cp	  		= $_GET['cp'];        
        $tipo	  = $_GET['tipo'];    
        $radio	  = $_GET['radio'];     
        $privacidad	= $_GET['privacidad']; 
        $lat	  = $_GET['lat'];   
        $lon	  = $_GET['lon'];
		$base     = 0;
		//if ($base == true)
        if ($_GET['base'] == 'true')
		{
		  $base = 1;   
		} 	
		if($id_row==0){
		 	$data = Array(				 
				'ID_TIPO_GEO' 	=> $tipo,
				'ID_ADM_USUARIO' => $userAdmin->user_info['ID_USUARIO'], 
				'DESCRIPCION' => $name,
				'LONGITUDE' => $lon,
				'LATITUDE' 	=> $lat,
				'CALLE' 	=> $calle,
				'NO_INT' 	=> $noint,
				'NO_EXT' 	=> $noext,
				'COLONIA' 	=> $colonia,
				'MUNICIPIO' => $municipio,
				'ESTADO' 	=> $estado,
				'CP' 		=> $cp,
				'RADIO' 	=> $radio,
				'TIPO' 		=> 'G',
				'PRIVACIDAD'=> $privacidad , 	 
				'ID_CLIENTE'=> $userAdmin->user_info['ID_CLIENTE'],
		 		'CREADO'=> date('Y-m-d H:i:s'),
				'BASE' => $base
		 	);	

			if($userAdmin->permisos['WR']){
  				$dbf->insertDB($data,'ADM_GEOREFERENCIAS',true);
  				$id_row = $dbf->get_last_insert();
  			}else{
  				$response = array('result' => 'no-perm');
  				$problems++;
  			}						 			
		}else{
		 	$data = Array(				 
				'ID_TIPO_GEO' 	=> $tipo, 
				'DESCRIPCION' => $name,
				'LONGITUDE' => $lon,
				'LATITUDE' 	=> $lat,
				'CALLE' 	=> $calle,
				'NO_INT' 	=> $noint,
				'NO_EXT' 	=> $noext,
				'COLONIA' 	=> $colonia,
				'MUNICIPIO' => $municipio,
				'ESTADO' 	=> $estado,
				'CP' 		=> $cp,
				'RADIO' 	=> $radio,
				'PRIVACIDAD'=> $privacidad,
				'BASE'      => $base
		 	);				
  			if($userAdmin->permisos['UP']){
  				$where = 'ID_OBJECT_MAP ='.$id_row; 
  				$dbf->updateDB('ADM_GEOREFERENCIAS',$data,$where,true);
  			}else{
  				$response = array('result' => 'no-perm');
  				$problems++;
  			}			
		}
		
  		if($problems==0){  			
  			$response = array('result' => 'edit');
  		}
  	}		  
	echo json_encode($response);
?>