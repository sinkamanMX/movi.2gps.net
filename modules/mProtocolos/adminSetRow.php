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
	
	if(isset($_GET['name']) && isset($_GET['unit']) && isset($_GET['status'])){	
 		$id_row    = $_GET['data'];		
		$name	   = $_GET['name'];		
		$obs	   = $_GET['obs'];
		$unit	   = $_GET['unit'];	 	
	 	$status	   = $_GET['status'];
		$id_cliente= $_GET['id_client'];
		
 		$data = Array(
	 		'ID_CLIENTE'	=> $id_cliente,
			'DESCRIPCION'	=> $name,
			'OBSERVACION'	=> $obs,
			'ACTIVO'		=> $status,
			'CREADO'		=> date('Y-m-d H:i:s')
		);
		
		if($id_row==0){				
			$insert = $dbf->insertDB($data,'ADM_PROTOCOLOS',true);
			if($insert){
				$id_row = $dbf->get_last_insert();	
			}else{
				$response = array('result' => 'problem');$problems++;
			}
		}else{
			$where = 'COD_PROTOCOLO ='.$id_row; 
			$update = $dbf->updateDB('ADM_PROTOCOLOS',$data,$where,true);
			if(!$update){
				$response = array('result' => 'problem');$problems++;	
			}		
		}
		
		if($unit && $problems==0){
			$data_unit = Array(
				'COD_PROTOCOLO'	=> $id_row,
				'COD_ENTITY'	=> $unit,
				'PRIORIDAD'		=> 1 	
			);
			$dbf->insertDB($data_unit,'ADM_PROTOCOLO_UNIDADES',true);
		}
		if($problems==0){
			$response = array('result' => 'edit','id_row'=>$id_row);
		}
  	}		  
	echo json_encode($response);
?>