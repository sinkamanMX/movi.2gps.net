<?php
/** * 
 *  @package             
 *  @name                Script que obtiene los datos a mostrar en la tabla
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
 *  @modificado          27/03/13
**/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	
	$response = array('result' => 'no-data');
	if(isset($_GET['valor']) && isset($_GET['tipo']) && isset($_GET['epo_id'])){
		$id_row = $_GET['epo_id'];
		$tipo   = $_GET['tipo'];
		$valor  = $_GET['valor'];
		$data_row = "";
		
		if($tipo == 't'){
			$where = " PHONE = '".$valor."' ";			
		}else if($tipo == 'i'){
		 	$where = " IMEI = '".$valor."' ";
		}else if($tipo == 'n'){
			$where = " ITEM_NUMBER = '".$valor."' ";			
		}	
		
		$data_row = $dbf->getRow('ADM_EQUIPOS',$where);	
		if($data_row){
			if(@$data_row['COD_EQUIPMENT']==$id_row){
				$response = array('result' => 'ok');
			}else if(@$data_row['COD_EQUIPMENT']!=$id_row){
				$response = array('result' => 'nok');
			}			
		}else{
			$response = array('result' => 'ok');	
		}		
	}			
	echo json_encode( $response); 	
?>