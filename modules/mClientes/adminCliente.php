<?php
/** * 
 *  @package             
 *  @name                Pagina default de clientes 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña
 *  @modificado          23-04-2012
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],
				  $config_bd['user'],$config_bd['pass']);
	$result = '';
	if(!$userAdmin->u_logged())
			echo '<script>window.location="index.php?m=login"</script>';

	if(isset($_GET['id_company'])){
		$id_company   = $_GET['id_company'];	
	
		$sql="SELECT C.ID_CLIENTE,C.NOMBRE, C.TELEFONO, C.NOMBRE_CONTACTO,
				IF(C.ACTIVO = 'S','Activo','Inactivo') AS ESTATUS   
				FROM ADM_CLIENTES C 
				WHERE C.ID_EMPRESA=".$id_company;
		$query 	= $db->sqlQuery($sql);
		while($row = $db->sqlFetchArray($query)){
			$result[] = $row; // Inside while loop
		}		
	}		
	
	echo json_encode( $result = array('aaData'=>$result ) );	 	
	$db->sqlClose();
?>