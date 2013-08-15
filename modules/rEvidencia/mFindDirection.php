<?php
/** * 
 *  @package             4togo_Pepsico.
 *  @name                Obtiene la Direccion decuardo ala BD.
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Erick A. Calderón
 *  @modificado          16-08-2011 
**/

	//--------------------------- Modificada BD y Encabezado------------------------
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';  //Manda al login si no se ha Logeo.
	//--------------------------- Modificada BD y Encabezado------------------------
	
	 
 	if(isset($_GET['cp'])){
		$sql = "SELECT e.NOMBRE AS COLONIA,f.NOMBRE AS MUNI, g.NOMBRE AS ESTADO, f.ID_MUNICIPIO, g.ID_ESTADO
				FROM ZZ_SPM_COLONIAS   e,
     				 ZZ_SPM_MUNICIPIOS f,	
     			 	 ZZ_SPM_ENTIDADES  g
				WHERE e.CODIGO = '".$_GET['cp']."'
 			 	 AND  e.ID_MUNICIPIO = f.ID_MUNICIPIO
 			 	 AND  e.ID_ESTADO    = g.ID_ESTADO
 			 	 AND  f.ID_ESTADO    = e.ID_ESTADO
		   		 LIMIT 1 ";
 		$query = $db-> sqlQuery($sql);
 		$count = $db-> sqlEnumRows($query);
 		$row = $db-> sqlFetchArray($query);
 		
		$data_arr[0]  =  array(edo => $row['ESTADO'],
							   mun => $row['MUNI'],
							   col => $row['COLONIA']);
		echo '{"items" :'.json_encode($data_arr).'}';
 	}
	$db->sqlClose();
?>