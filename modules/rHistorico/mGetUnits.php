<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo silver 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          23-04-2012
**/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	
	$result = array();
	if(isset($_GET['datagroup'])){
		$idGroup 	= $_GET['datagroup'];
		$idUsuario 	= $userAdmin->user_info['ID_USUARIO'];
		$sql = "SELECT U.COD_ENTITY AS ID,U.DESCRIPTION AS NAME 
				FROM ADM_UNIDADES U 
				INNER JOIN ADM_GRUPOS_UNIDADES GU ON GU.COD_ENTITY=U.COD_ENTITY
				INNER JOIN ADM_USUARIOS_GRUPOS UG ON UG.COD_ENTITY=U.COD_ENTITY
				WHERE GU.ID_GRUPO = ".$idGroup." 
				AND UG.ID_USUARIO = ".$idUsuario." GROUP BY U.COD_ENTITY";	
		$query 	= $db->sqlQuery($sql);
		while($row = $db->sqlFetchArray($query)){
			$result[] = array(
				'id' 	=> $row['ID'], 
				'name'	=> $Functions->codif($row['NAME'])
			); 
		}	
	}			
	echo json_encode( array('items'=>$result) ); 	