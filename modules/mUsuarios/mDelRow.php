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
			$id_usuario = $_GET['data'];
			$where_usuario= " ID_USUARIO = ".$id_usuario;
			
			$user_info = $dbf->getRow('ADM_USUARIOS',$where_usuario);
			
			if($user_info['ID_TIPO']>=$userAdmin->user_info['ID_TIPO']){				
				if($dbf->deleteDB('ADM_USUARIOS_PERMISOS',$where_usuario,true)){
					if($dbf->deleteDB('ADM_USUARIOS_GRUPOS',$where_usuario,true)){
						if($dbf->deleteDB('ADM_USUARIOS',$where_usuario,true)){
								if($dbf->deleteDB('ADM_COMANDOS_USUARIO',$where_usuario,true)){
										$response = array('result' => 'delete');	
								
								}else{
								$response = array('result' => 'problem');
								}

						}else{
							$response = array('result' => 'problem');
						}
					}else{
						$response = array('result' => 'problem');
					}
				}else{
					$response = array('result' => 'problem');
				}
			}else{
				$response = array('result' => 'no-perm');
			}
		}else{
			$response = array('result' => 'no-perm');
		}					 		
	}	
	echo json_encode( $response );
?>
