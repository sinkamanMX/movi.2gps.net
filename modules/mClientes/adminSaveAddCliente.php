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
	//````
	$id_usuario = $userAdmin->user_info['ID_USUARIO'];
	$id_company = $_GET['id_company'];
	$pregunta   = $_GET['cli_preg'];
	$respuesta  = $_GET['cli_resp'];	
	//````````````````````````````
	$data = Array(
			'ID_EMPRESA'   			=> $id_company,
			'ID_USUARIO_CREO'   	=> $id_usuario,	
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
			'ACTIVO'   				=> $_GET['cli_act']
	);
	
	if($dbf-> insertDB($data,'ADM_CLIENTES',true) == true){
		$id_client = $dbf->get_last_insert();
		$sql_submenus = "INSERT INTO ADM_SUBMENU_CLIENTES (ID_SUBMENU, ID_CLIENTE, ORDEN	)
						(SELECT 	ID_SUBMENU, ".$id_client.", 0
						FROM ADM_SUBMENU
						WHERE ADM_SUBMENU.ISDEFAULT = 1 )";
		$query_submenus = $db->sqlQuery($sql_submenus);
		$sql_comandos = "INSERT INTO ADM_COMANDOS_CLIENTE(ID_CLIENTE,COD_EQUIPMENT_PROGRAM,DESCRIPCION,CREADO)
						(SELECT ".$id_client.",								 
								COD_EQUIPMENT_PROGRAM, 
								DESCRIPCION, 
								CREADO
						FROM ADM_COMANDOS_CLIENTE
						WHERE ID_CLIENTE = ".$userAdmin->user_info['ID_CLIENTE'].")";
		$query_comandos = $db->sqlQuery($sql_comandos);		
		$data_val = Array(
			'ID_CLIENTE' => $id_client, 
			'PREGUNTA'	 =>	$pregunta, 
			'RESPUESTA'  => $respuesta,  
			'CREADO'	 =>	date('Y-m-d H:i:s')
		);
		$dbf-> insertDB($data_val,'ADM_CLIENTES_VALIDACION',true);
		
 		$data_nvo_grp = Array(	
			'NOMBRE'		=> $_GET['cli_des'],
			'ABREVIATURA' 	=> "",
			'TEMPORAL'		=> 0,
	 		'ID_ADM_USUARIO'=> $userAdmin->user_info['ID_USUARIO']
		);
		$dbf->insertDB($data_nvo_grp,'ADM_GRUPOS',false);	
		$id_grp = $dbf->get_last_insert();
		
  		$data_grupo = Array(
  			'ID_GRUPO'	=> $id_grp,
			'ID_CLIENTE'=> $id_client
  		); 
  		$dbf->insertDB($data_grupo,'ADM_GRUPOS_CLIENTES',false);						
						 				
		echo 1;
	}else{
		echo 0;
	}	
?>	