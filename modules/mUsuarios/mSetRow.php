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
	
	if(isset($_GET['name']) && isset($_GET['pass']) && isset($_GET['perfil']) && isset($_GET['grupo']) && 
 			isset($_GET['user']) && isset($_GET['user_id']) && isset($_GET['estatus']) && isset($_GET['email'])){
 		$id_user   = $_GET['user_id'];		
		$name	   = $_GET['name'];
		$email     = $_GET['email'];
		$user	   = $_GET['user'];
		$pass	   = $_GET['pass'];
	 	$estatus   = $_GET['estatus'];
	 	$id_perfil = $_GET['perfil'];	 	
	 	$permisos  = $_GET['permisos'];
	 	$id_grupo  = $_GET['grupo'];	
		$units     = $_GET['units'];
		$coman     = $_GET['com'];
		
		$validate_user  = $dbf->getRow('ADM_USUARIOS','USUARIO  = "'.$user.'"');
		
		if($id_user==0){	
			$tipo_user  	= $userAdmin->user_info['ID_TIPO'];
			$tipo_usuario  	= ($tipo_user+1);
		 	$data = Array(		
			 	'ID_PERFIL'		=> $id_perfil,
				'ID_EMPRESA'	=> $userAdmin->user_info['ID_EMPRESA'],
				'ID_CLIENTE'	=> $userAdmin->user_info['ID_CLIENTE'],
				'ID_PAIS'		=> $userAdmin->user_info['ID_PAIS'],
				'ID_TIPO_USUARIO'=> $tipo_usuario, 
				'NOMBRE_COMPLETO'=> $name,
				'EMAIL'			=> $email,
				'USUARIO'		=> $user,
				'PASSWORD'		=> $pass,
				'SHA1_PASSWORD'	=> SHA1($pass),
		 		'ESTATUS'		=> $estatus,
		 		'ID_ADM_USUARIO'=> $userAdmin->user_info['ID_USUARIO'],	
		 		'FECHA_CREACION'=> date('Y-m-d H:i:s')
		 	);	

			if(@$validate_user['USUARIO'] != $user){
				if($userAdmin->permisos['WR']){
	  				$dbf->insertDB($data,'ADM_USUARIOS',true);
	  				$id_user = $dbf->get_last_insert();
	  			}else{
	  				$response = array('result' => 'no-perm');
	  				$problems++;
	  			}				
			}else{
				$response = array('result' => 'on-use');
	  			$problems++;				
			}		 			
		}else{
			if($pass==""){
			 	$data = Array(		
				 	'ID_PERFIL'		=> $id_perfil,
					'NOMBRE_COMPLETO'=> $name,
					'EMAIL'			=> $email,
					'USUARIO'		=> $user,
			 		'ESTATUS'		=> $estatus
			 	);				
			}else{
			 	$data = Array(		
				 	'ID_PERFIL'		=> $id_perfil, 
					'NOMBRE_COMPLETO'=> $name,
					'EMAIL'			=> $email,
					'USUARIO'		=> $user,
					'PASSWORD'		=> $pass,
					'SHA1_PASSWORD'	=> SHA1($pass),
			 		'ESTATUS'		=> $estatus			 		
			 	);				
			}
			
			if(@$validate_user['USUARIO'] == $user && $id_user != @$validate_user['ID_USUARIO']){
				$response = array('result' => 'on-use');
	  			$problems++;							
			}else{			
	  			if($userAdmin->permisos['UP']){
	  				$where = 'ID_USUARIO ='.$id_user; 
	  				$dbf->updateDB('ADM_USUARIOS',$data,$where,true);
	 				$dbf->deleteDB('ADM_USUARIOS_PERMISOS',$where);
	 				$dbf->deleteDB('ADM_USUARIOS_GRUPOS',$where);
	 				$dbf->deleteDB('ADM_COMANDOS_USUARIO',$where);
	  			}else{
	  				$response = array('result' => 'no-perm');
	  				$problems++;
	  			}								
			}		 			
		}
		
  		if($problems==0){
  			for($i=0;$i<count($permisos);$i++){
  				$info  = explode("|",$permisos[$i]);
  				$id_permiso = $info[0];
  				$id_submenu = str_replace("user_select","",$info[1]);
  				$data_permisos = Array(
  					'ID_SUBMENU' => $id_submenu,
					'ID_USUARIO' => $id_user,
					'ID_PERMISO' => $id_permiso, 
  				);
  				$dbf->insertDB($data_permisos,'ADM_USUARIOS_PERMISOS',false);
  			}
  			
  			for($i=0;$i<count($units);$i++){
  				$info  = explode("|",$units[$i]);
  				$id_grupo  = $info[0];
  				$id_entity = $info[1];
  				$data_units = Array(
	  				'ID_USUARIO' => $id_user,
					'ID_GRUPO'	 => $id_grupo,
					'COD_ENTITY' => $id_entity, 
  				);
  				$dbf->insertDB($data_units,'ADM_USUARIOS_GRUPOS',false);
  			}  			
  			
  			$response = array('result' => 'edit');
  		}
  		
  		if($coman && count($units)>0){
			$datos_com= explode(",",$coman);
			for($o=0;$o<count($datos_com);$o++){
				$data = Array(		
				 	'ID_COMANDO_CLIENTE' => $datos_com[$o],
			 		'ID_USUARIO' => $id_user,	
			 		'CREADO'=> date('Y-m-d H:i:s')
			 	);
				
				if($dbf->insertDB($data,'ADM_COMANDOS_USUARIO',true)){
					$response = array('result' => 'edit');
				}else{					
					$response = array('result' => 'no-perm');					
				}				
			}  			
  		} 
  	}		  
	echo json_encode($response);
?>