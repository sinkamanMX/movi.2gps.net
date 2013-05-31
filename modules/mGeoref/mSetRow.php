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

	if(isset($_GET['name']) && isset($_GET['color']) &&  
 			isset($_GET['privacidad']) && isset($_GET['geos_id']) && isset($_GET['points']) ){
 				
 		$id_row     = $_GET['geos_id'];		
		$name	    = $_GET['name'];     
        $privacidad	= $_GET['privacidad']; 
		$color      = $_GET['color']; 	
		$points 	= $_GET['points'];
		
		if($id_row==0){
		 	$data = Array(				 
				'ID_TIPO' 	=> 0,
				'ID_USUARIO_CREO' => $userAdmin->user_info['ID_USUARIO'], 
				'DESCRIPCION' => $name,				
				'TIPO' 		=> 'G',
				'PRIVACIDAD'=> $privacidad , 	 
				'ID_CLIENTE'=> $userAdmin->user_info['ID_CLIENTE'],
				'COD_COLOR' => $color, 
		 		'CREADO'=> date('Y-m-d H:i:s')
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
				'DESCRIPCION' => $name,				
				'PRIVACIDAD'=> $privacidad,
				'COD_COLOR' => $color 
		 	);				
  			if($userAdmin->permisos['UP']){
  				$where = 'ID_OBJECT_MAP ='.$id_row; 
  				$dbf->updateDB('ADM_GEOREFERENCIAS',$data,$where,true);
  				$dbf->deleteDB('ADM_GEOREFERENCIAS_ESPACIAL',$where);
  			}else{
  				$response = array('result' => 'no-perm');
  				$problems++;
  			}			
		}
		$s_points = "";
  		if($problems==0){  			
  			for($i=0;$i<count($points);$i++){
  				$s_points .= ($s_points=="") ? '': ',';
  				$s_points .= $points[$i];							
  			} 
	        $s_points .= ",".$points[0];			
			$sql_patial = "INSERT INTO adm_georeferencias_espacial (ID_OBJECT_MAP,GEOM)
								VALUES (".$id_row.",GEOMFROMTEXT('POLYGON((".$s_points."))'))";				
			$query  = $db->sqlQuery($sql_patial);  			
  			$response = array('result' => 'edit');
  		}
  	}		  
	echo json_encode($response);
?>