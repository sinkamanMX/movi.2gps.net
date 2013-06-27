<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
	
	$id_usuario = $userAdmin->user_info['ID_USUARIO'];
	$id_empresa = $userAdmin->user_info['ID_USUARIO'];
	
	$data = Array(
			'ID_EMPRESA'   		=> $id_empresa,
			'DESCRIPCION'   	=> $_GET['cli_des'],	
			'ID_ADM_USUARIO'    => $id_usuario,
			'FECHA_CREACION'   	=> date('Y-m-d H:i:s'),
			'ESTATUS'	    	=> $_GET['cli_sta']
	);
	
	if($dbf-> insertDB($data,'ADM_CLIENTES',true) == true){
		echo 1;
		}
	else{
		echo 0;
		}	
?>	