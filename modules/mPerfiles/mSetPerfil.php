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
	$id_perfil=0;
	$response = array('result' => 'no-data');
	if(isset($_GET['name']) && isset($_GET['estatus'])){
		$name	   = $_GET['name'];
		$estatus   = $_GET['estatus'];
		$id_perfil = $_GET['pro_id'];
		$permisos  = $_GET['permisos'];
		
		$data = Array(		
				'DESCRIPCION'	=> $name,
				'ESTATUS'		=> $estatus,
				'ID_ADM_USUARIO'=> $userAdmin->user_info['ID_USUARIO'],	
				'CREADO'	    => date('Y-m-d H:i:s')
		);
		
		if($id_perfil!=0){// Si es diferente de 0 entonces se debe de editar el registro
			if($userAdmin->permisos['UP']){
				$where = 'ID_PERFIL ='.$id_perfil; 
				$dbf->updateDB('ADM_PERFILES',$data,$where,true);
				$dbf->deleteDB('ADM_PERFIL_PERMISOS',$where);
			}else{
				$response = array('result' => 'no-perm');
				$problems++;
			}			
		}else{//Se debe de insertar nuevo registro
			if($userAdmin->permisos['WR']){
				$dbf-> insertDB($data,'ADM_PERFILES',true);
				$id_perfil = $dbf->get_last_insert();
				$data_empresa = Array(
					'ID_EMPRESA' => $userAdmin->user_info['ID_EMPRESA'],
					'ID_CLIENTE' => $userAdmin->user_info['ID_CLIENTE'],
					'ID_PERFIL'	 =>	$id_perfil 
				);				
				$dbf->insertDB($data_empresa,'ADM_PERFILES_CLIENTES',true);
			}else{
				$response = array('result' => 'no-perm');
				$problems++;
			}			
		}
		if($problems==0){
			for($i=0;$i<count($permisos);$i++){
				$info  = explode("|",$permisos[$i]);
				$id_permiso = $info[0];
				$id_submenu = str_replace("pro_select","",$info[1]);
				$data_permisos = Array(
					'ID_PERFIL'	 => $id_perfil,
					'ID_SUBMENU' => $id_submenu,
					'ID_PERMISO' => $id_permiso 
				);
				$dbf->insertDB($data_permisos,'ADM_PERFIL_PERMISOS',false);
			}
			$response = array('result' => 'edit');
		}
	}	
	echo json_encode($response);
?>
