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
	
	if(isset($_GET['data']) && isset($_GET['des']) && isset($_GET['forma'])){	
 		$id_row    = $_GET['data'];
		$id_contact= $_GET['id_contact']; 	
        $id_forma  = $_GET['forma'];
		$status    = $_GET['status']; 	
		$desc  	   = $_GET['des']; 	
		$prior     = $_GET['prior'];
		        	
 		$data = Array( 		
			'ID_FORMA'		=> $id_forma, 
			'ID_CONTACTO'	=> $id_contact, 
			'MEDIO_CONTACTO'=> $desc, 
			'ACTIVO'		=> $status,  
			'PRIORIDAD' 	=> $prior	
		);
		
		if($id_row==0){				
			$dbf->insertDB($data,'ADM_FORMA_CONTACTO',true);
			$id_row = $dbf->get_last_insert();							
		}else{
			$where = 'ID_FORMA_CONTACTO ='.$id_row; 
			$dbf->updateDB('ADM_FORMA_CONTACTO',$data,$where,true);
		}		  	
		
  		if($problems==0){  		
  			$response = array('result' => 'edit');
  		}
  	}
	echo json_encode($response);
?>