<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],
 			      $config_bd['bname'],$config_bd['user'],$config_bd['pass']);
 			      	
	$pregunta   = $_GET['cli_preg'];
	$respuesta  = $_GET['cli_resp']; 			      
	$id_company = $_GET['id_company'];
	
	$data = Array(
			'ID_EMPRESA'   			=> $id_company,
			//'ID_USUARIO_CREO'   	=> $id_usuario,	
			'NOMBRE'    			=> $_GET['cli_des'],
			'RFC'   				=> $_GET['cli_rfc'],
			'RAZON_SOCIAL'	    	=> $_GET['cli_rzn'],
			'PERSONA'   			=> $_GET['cli_per'],
			'TELEFONO'   			=> $_GET['cli_tel'],	
			'DIRECCION'    			=> $_GET['cli_dir'],
			'NOMBRE_CONTACTO'   	=> $_GET['cli_con'],
			'EMAIL'	    			=> $_GET['cli_ema'],
			'MOVIL'   				=> $_GET['cli_mov'],
			'FECHA_CREACION'   		=> date('Y-m-d H:i:s'),	
			//'COMENTARIOS'    		=> $id_usuario,
			'ACTIVO'   				=> $_GET['cli_act']
	);
	$where = " ID_CLIENTE  = ".$_GET['cli_id'];
	if(($dbf-> updateDB('ADM_CLIENTES',$data,$where,true)==true)){
		$dbf->deleteDB('ADM_CLIENTES_VALIDACION',$where);
		
		$data_val = Array(
			'ID_CLIENTE' => $_GET['cli_id'], 
			'PREGUNTA'	 =>	$pregunta, 
			'RESPUESTA'  => $respuesta,  
			'CREADO'	 =>	date('Y-m-d H:i:s')
		);
		$dbf-> insertDB($data_val,'ADM_CLIENTES_VALIDACION',true);		
		echo 1;
	}else{
		echo 0;
	}	
?>	