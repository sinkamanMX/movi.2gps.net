<?php
/** *              
 *  @name                Script que elimina un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author             Edgar Sanabria Paredes
 *  @modificado          27/03/13
**/
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
$response = array('result' => 'no-data');
	$validate = $dbf->getRow('ADM_USUARIOS_SUPER',' ID_USUARIO = '.$userAdmin->user_info['ID_USUARIO']);	
	if(isset($_GET['data'])){
		if($userAdmin->permisos['DL']  || $validate){
		
		$id_row = $_GET['data'];
		$where_perfil= " COD_EVENT = ".$id_row;
		
		$where = $where_perfil;
					 		
					
			if($dbf->deleteDB('ADM_EVENTOS',$where_perfil,true)){
				$response = array('result' => 'delete');
				
			}else{
				$response = array('result' => 'problem');	
			}	
						
		}else{
			$response = array('result' => 'use');		
		}
		
	}else{
		$response = array('result' => 'no-perm');
	}					 		
	
echo json_encode( $response );
?>