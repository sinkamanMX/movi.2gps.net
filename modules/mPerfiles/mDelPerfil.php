<?php
/** *              
 *  @name                Script que elimina un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$response = array('result' => 'no-data');
	$validate = $dbf->getRow('ADM_USUARIOS_SUPER',' ID_USUARIO = '.$userAdmin->user_info['ID_USUARIO']);	
	if(isset($_GET['data'])){
		if($userAdmin->permisos['DL']  || $validate){
			$id_perfil = $_GET['data'];
			$where_perfil= " ID_PERFIL = ".$id_perfil;
			
			$where = $where_perfil.
	   					 " AND ID_EMPRESA = ".$userAdmin->user_info['ID_EMPRESA'].
						 " AND ID_CLIENTE = ".$userAdmin->user_info['ID_CLIENTE'];
						 		
			$sql = "SELECT ID_PERFIL FROM ADM_USUARIOS WHERE ID_PERFIL=".$id_perfil;
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count==0){
				if($dbf->deleteDB('ADM_PERFILES_CLIENTES',$where,true)){
					if($dbf->deleteDB('ADM_PERFIL_PERMISOS',$where_perfil,true)){
						if($dbf->deleteDB('ADM_PERFILES',$where_perfil,true)){
							$response = array('result' => 'delete');
						}
					}
				}else{
					$response = array('result' => 'problem');	
				}
			}else{
				$response = array('result' => 'use');		
			}
		}else{
			$response = array('result' => 'no-perm');
		}					 		
	}	
	echo json_encode( $response );
?>
