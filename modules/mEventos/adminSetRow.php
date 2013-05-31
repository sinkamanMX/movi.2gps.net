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
 		$id_row    = $_GET['id'];		
		$name	   = $_GET['name'];
		$prio	   = $_GET['prio'];
		$color	   = $_GET['color'];	 	
	 	$icono	   = $_GET['icono'];
		$visible   = $_GET['visible'];
		$alerta    = $_GET['alerta'];
		$id_client = $_GET['id_client'];
		
 		$data = Array(	
			'PRIORITY' 		=> $prio,
			'COLOR'			=> $color,
			'DESCRIPTION'	=> $name,
			'FLAG_VISIBLE_CONSOLE'		=> $visible,
			'ICONO'			=> $icono,
			'FLAG_EVENT_ALERT'		=> $alerta,
	 		'ID_CLIENTE'=> $id_client
		);
	
	if($id_row==0){
		if($dbf->insertDB($data,'ADM_EVENTOS',true)){
			$response = array('result' => 'edit');
		}else{
			$response = array('result' => 'no-data');
		}		
	}else{
		$where='COD_EVENT ='.$id_row;
		if($dbf->updateDB('ADM_EVENTOS',$data,$where,true)){  		
			$response = array('result' => 'edit');
		}else{
			$response = array('result' => 'no-data');
		}
	}
	echo json_encode($response);
?>