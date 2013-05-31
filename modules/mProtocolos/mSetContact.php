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
	
	if(isset($_GET['proc_id']) && isset($_GET['name']) && isset($_GET['clave'])){	
 		$id_row    = $_GET['data'];	
        $id_protocolo = $_GET['proc_id'];	
		$name	   = $_GET['name'];
		$h_ini     = $_GET['hi'];
        $h_fin     = $_GET['hf'];
        $rol       = $_GET['rol'];
        $clave     = $_GET['clave'];
        $prior     = $_GET['prior'];
        $consulta  = $_GET['consul'];
        $autoriza  = $_GET['aut']; 
        
				
 		$data = Array(	 
			'COD_PROTOCOLO' => $id_protocolo, 
			'NOMBRE'     	=> $name,
			'HORA_INICIAL'  => $h_ini, 
			'HORA_FINAL'	=> $h_fin, 
			'ROL'			=> $rol,
			'CLAVE_SEGURIDAD'=> $clave,
			'CONTACTO_CONSULTA'=> $consulta,
			'CONTACTO_AUTORIZA'=> $autoriza, 
			'ID_ADM_USUARIO'=> $userAdmin->user_info['ID_USUARIO'],
			'CREADO'		=> date('Y-m-d H:i:s'), 
			'PRIORIDAD' 	=> $prior
		);
		
		if($id_row==0){				
			if($userAdmin->permisos['WR']){
  				$dbf->insertDB($data,'ADM_GRUPOS',true);
  				$id_row = $dbf->get_last_insert();
  			}else{
  				$response = array('result' => 'no-perm');
  				$problems++;
  			}				
		}else{
			if($userAdmin->permisos['UP']){
				$where = 'ID_GRUPO ='.$id_row; 
				$dbf->updateDB('ADM_GRUPOS',$data,$where,true);
				$dbf->deleteDB('ADM_GRUPOS_CLIENTES',$where);
				$dbf->deleteDB('ADM_GRUPOS_UNIDADES',$where);
				$dbf->deleteDB('ADM_GRUPOS_REL'," ID_GRUPO_HIJO = ".$id_row);
			}else{
				$response = array('result' => 'no-perm');
				$problems++;
			}			
		}
		
  		$data_grupo = Array(
  			'ID_GRUPO'	=> $id_row,
			'ID_CLIENTE'=> $userAdmin->user_info['ID_CLIENTE']
  		); 
  		$dbf->insertDB($data_grupo,'ADM_GRUPOS_CLIENTES',false);		
		$id_grupo_cliente = $dbf->get_last_insert();
		
		if($padre>0){
	  		$data_grupo2 = Array(
				'ID_GRUPO_PADRE'=> $padre,
				'ID_GRUPO_HIJO'	=> $id_row,
	  		); 
	  		$dbf->insertDB($data_grupo2,'ADM_GRUPOS_REL',false);		
		}
		
  		if($problems==0){
  			for($i=0;$i<count($units);$i++){
  				$data_permisos = Array(
  					'ID_GRUPO'		=> $id_row,
					'COD_ENTITY'	=> $units[$i]
  				);
  				$dbf->insertDB($data_permisos,'ADM_GRUPOS_UNIDADES',false);
  			}
  			$response = array('result' => 'edit');
  		}
  	}		  
	echo json_encode($response);
?>