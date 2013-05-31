<?php
/** *              
 *  @name                Script que elimina un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$response = array('result' => 'no-data');
	if(isset($_GET['data'])){
		if($userAdmin->permisos['DL']){
			$id_row = $_GET['data'];
			$where = " ID_OBJECT_MAP = ".$id_row;

			if($dbf->deleteDB('ADM_GEOREFERENCIAS',$where,true)){
				$dbf->deleteDB('ADM_GEOREFERENCIAS_ESPACIAL',$where);
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
