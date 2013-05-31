<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo silver 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          23-04-2012
**/
 
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
			echo '<script>window.location="index.php?m=login"</script>';
	$client   = $userAdmin->user_info['ID_CLIENTE'];
	
	$result = '';
		$sql="SELECT U.COD_ENTITY, U.DESCRIPTION AS UNIDAD,U.PLAQUE, U.BODYWORK_CODE AS SERIE,
				E.ITEM_NUMBER AS IP  FROM ADM_UNIDADES U
				LEFT JOIN ADM_UNIDADES_EQUIPOS UE ON U.COD_ENTITY = UE.COD_ENTITY
				LEFT JOIN ADM_EQUIPOS E ON E.COD_EQUIPMENT = UE.COD_EQUIPMENT
				WHERE U.COD_CLIENT = ".$client;
		$query 	= $db->sqlQuery($sql);
		while($row = $db->sqlFetchArray($query)){
			$result[] = $row; // Inside while loop
		}			
	echo json_encode( $result = array('aaData'=>$result ) );	 	
	$db->sqlClose();
?>