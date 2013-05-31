<?php
/** * 
 *  @package             
 *  @name                Script que obtiene los datos a mostrar en la tabla
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],
				  $config_bd['bname'],$config_bd['user'],$config_bd['pass']);
		
	$result = '';
	if(isset($_GET['id_client'])){
		$id_client = $_GET['id_client'];			  	
		
		$result = array();
		$sql = "SELECT ADM_GRUPOS.ID_GRUPO AS ID, ADM_GRUPOS.NOMBRE,
				IF(AD_G.NOMBRE IS NULL ,'--',AD_G.NOMBRE) AS N_PADRE, ADM_CLIENTES.DESCRIPCION
				FROM ADM_GRUPOS
				 LEFT JOIN ADM_GRUPOS_CLIENTES 	ON ADM_GRUPOS.ID_GRUPO 		  = ADM_GRUPOS_CLIENTES.ID_GRUPO
				 LEFT JOIN ADM_GRUPOS_REL       ON ADM_GRUPOS_REL.ID_GRUPO_HIJO	  = ADM_GRUPOS_CLIENTES.ID_GRUPO
				 LEFT JOIN ADM_CLIENTES		ON ADM_GRUPOS_CLIENTES.ID_CLIENTE = ADM_GRUPOS_CLIENTES.ID_CLIENTE
				 LEFT JOIN ADM_GRUPOS  AD_G		ON AD_G.ID_GRUPO 		  = ADM_GRUPOS_REL.ID_GRUPO_PADRE
				 WHERE ADM_GRUPOS_CLIENTES.ID_CLIENTE  = ".$id_client."
				  	GROUP BY ADM_GRUPOS.ID_GRUPO";
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