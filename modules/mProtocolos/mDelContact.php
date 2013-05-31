<?php
/** *              
 *  @name                Script que elimina un contacto
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe�a 
 *  @modificado          27/03/13
**/
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
$response = array('result' => 'no-data');
	$validate = $dbf->getRow('ADM_USUARIOS_SUPER',' ID_USUARIO = '.$userAdmin->user_info['ID_USUARIO']);	
	if(isset($_GET['data'])){
		if($userAdmin->permisos['DL']  || $validate){
		
		$id_row = $_GET['data'];
		$where  = " ID_CONTACTO = ".$id_row;
		
		if($dbf->deleteDB('ADM_PROTOCOLO_CONTACTOS',$where,true)){
			$response = array('result' => 'delete');	
		}else{
			$response = array('result' => 'problem');	
		}	
	}else{
		$response = array('result' => 'no-perm');
	}					 		
}	
echo json_encode( $response );
?>