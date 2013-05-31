<?php
/** * 
 *  @package             
 *  @name                Script que obtiene los datos a mostrar en la tabla
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	
	$result = array();
	/*
	* Se valida el tipo de usuario para mostrar los perfiles
	*/
	 $sql = "SELECT E.COD_EVENT, E.DESCRIPTION, E.PRIORITY, E.FLAG_VISIBLE_CONSOLE, E.FLAG_EVENT_ALERT
			FROM ADM_EVENTOS E LEFT JOIN ADM_CLIENTES C ON E.ID_CLIENTE = C.ID_CLIENTE";
		/* 	 LEFT JOIN ADM_GRUPOS_CLIENTES 	ON ADM_GRUPOS.ID_GRUPO 		  = ADM_GRUPOS_CLIENTES.ID_GRUPO
			 LEFT JOIN ADM_GRUPOS_REL       ON ADM_GRUPOS_REL.ID_GRUPO_HIJO	  = ADM_GRUPOS_CLIENTES.ID_GRUPO
			 LEFT JOIN ADM_CLIENTES			ON ADM_GRUPOS_CLIENTES.ID_CLIENTE = ADM_GRUPOS_CLIENTES.ID_CLIENTE
			 LEFT JOIN ADM_GRUPOS  AD_G		ON AD_G.ID_GRUPO 		  = ADM_GRUPOS_REL.ID_GRUPO_PADRE"; */
	
	 if($userAdmin->user_info['ID_TIPO_USUARIO']=='1'){
		$sql .= " WHERE C.ID_EMPRESA   = ".$userAdmin->user_info['ID_EMPRESA'];
	}else{
		$sql .= " WHERE C.ID_EMPRESA   = ".$userAdmin->user_info['ID_CLIENTE'];
	} 
	
	if($sql!=""){
		$query 	= $db->sqlQuery($sql);
		while($row = $db->sqlFetchAssoc($query)){
    		$result[] = $row; // Inside while loop
		}	
	}
	echo json_encode( $result = array('aaData'=>$result ) );	 	
$db->sqlClose();
?>