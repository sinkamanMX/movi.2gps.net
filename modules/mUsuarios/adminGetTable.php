<?php
/** * 
 *  @package             
 *  @name                Script que obtiene los datos a mostrar en la tabla
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
 *  @modificado          27/03/13
**/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	
	$result = '';
	if(isset($_GET['id_client'])){
		$id_client = $_GET['id_client'];
		/*
		* Se valida el tipo de usuario para mostrar los perfiles
		*/
		$sql = "SELECT ID_USUARIO AS ID, ADM_EMPRESAS.DESCRIPCION AS EMPRESA, ADM_CLIENTES.DESCRIPCION AS CLIENTE, 
					NOMBRE_COMPLETO AS NOMBRE, USUARIO, ADM_USUARIOS.ESTATUS,
				DATE(ADM_USUARIOS.FECHA_CREACION) 	AS CREADO
				FROM ADM_USUARIOS
				LEFT JOIN ADM_EMPRESAS ON ADM_USUARIOS.ID_EMPRESA = ADM_EMPRESAS.ID_EMPRESA
 				LEFT JOIN ADM_CLIENTES ON ADM_USUARIOS.ID_CLIENTE = ADM_CLIENTES.ID_CLIENTE
				WHERE ADM_USUARIOS.ID_CLIENTE = ".$id_client;	
		if($sql!=""){
			$query 	= $db->sqlQuery($sql);
			while($row = $db->sqlFetchAssoc($query)){
	    		$result[] = $row; // Inside while loop
			}	
		}	
	}	
	echo json_encode( $result = array('aaData'=>$result ) );	 	
	$db->sqlClose();
?>