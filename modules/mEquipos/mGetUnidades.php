<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$result = 'null';
	if(isset($_GET['id_client'])){
		$id_client  = $_GET['id_client']; 
		$id_company = $_GET['id_company'];

		$where = 'COD_ENTITY NOT IN (
				    SELECT COD_ENTITY 
				    FROM ADM_UNIDADES_EQUIPOS
				    WHERE COD_CLIENT = '.$id_client.') AND COD_CLIENT = '.$id_client;
		$result = $dbf->cbo_from('COD_ENTITY','DESCRIPTION','ADM_UNIDADES',$where);	
		$result = ($result!="") ? $result: '<option value="-1">Sin Unidades</option>';
		
		$where_grupo = ' FROM ADM_GRUPOS G
							INNER JOIN ADM_GRUPOS_CLIENTES GC ON GC.ID_GRUPO=G.ID_GRUPO
							WHERE GC.ID_CLIENTE= '.$id_client.' ORDER BY G.NOMBRE';
		$result .= "!".$dbf->cbo_from_query('G.ID_GRUPO',' G.NOMBRE',$where_grupo);			
	}
	
	echo $result;	
?>	