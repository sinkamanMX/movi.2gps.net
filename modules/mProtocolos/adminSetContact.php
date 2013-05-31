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
			$dbf->insertDB($data,'ADM_PROTOCOLO_CONTACTOS',true);
			$id_row = $dbf->get_last_insert();				
		}else{
			$where = 'ID_CONTACTO ='.$id_row; 
			$dbf->updateDB('ADM_PROTOCOLO_CONTACTOS',$data,$where,true);
		}		  	
		
  		if($problems==0){  		
  			$response = array('result' => 'edit','id_row'=>$id_row);
  		}
  	}		  
	echo json_encode($response);
?>