<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          30/04/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$problems = 0;
	$id_row   = 0;
	$response = array('result' => 'no-data');
	
	if(isset($_GET['emp_des']) && isset($_GET['emp_sta']) && isset($_GET['emp_rzn']) && isset($_GET['emp_rfc']) 
				&& isset($_GET['emp_dir']) && isset($_GET['emp_tel']) && isset($_GET['emp_rep']) 
				&& isset($_GET['emp_mail']) && isset($_GET['emp_id']) ){
 				
 		$id_row = $_GET['emp_id'];
	
		$data = Array(
			'DESCRIPCION'   		=> $_GET['emp_des'],
			'ACTIVO'   				=> $_GET['emp_sta'],
			'RAZON_SOCIAL'   		=> $_GET['emp_rzn'],
			'RFC'   				=> $_GET['emp_rfc'],
			'DIRECCION'   			=> $_GET['emp_dir'],
			'TELEFONO'   			=> $_GET['emp_tel'],
			'EMAIL'					=> $_GET['emp_mail'],
			'OBSERVACIONES'			=> $_GET['emp_obs'],
			'REPRESENTANTE_LEGAL'   => $_GET['emp_rep'],	
			'CREADO'				=> date( "Y-m-d H:i:s" )								
		);	
		 
		if($id_row==0){
			$insert = $dbf->insertDB($data,'ADM_EMPRESAS',false);
			if($insert){
				$response = array('result' => 'edit');
			}else{
				$response = array('result' => 'problem');
			}			
		}else{
			$where = " ID_EMPRESA  = ".$id_row;
			$update = $dbf->updateDB('ADM_EMPRESAS',$data,$where,true);
			if($update){
				$response = array('result' => 'edit');
			}else{
				$response = array('result' => 'problem');
			}
		}			
	}else{
		$response = array('result' => 'no-data');
	}
	echo json_encode($response);	
?>	