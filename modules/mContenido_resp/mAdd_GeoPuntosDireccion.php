<?php
/** * 
 *  @package             4togo_Pepsico.
 *  @name                Obtiene la Dirección dependiando de CP.
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
	
		if(isset($_GET['lat']) && isset($_GET['lon'])){
			$userID   = $userData->userID;	
			$tpl-> set_filenames(array(
				'mAdd_GeoPuntosDireccion' => 'tAdd_GeoPuntosDireccion'
        	));
                
	    	/*---------Obiene la direccion----------------------------*/
			$qryDir = $Positions->queryDir($_GET['lat'], $_GET['lon']);
			$row_st   = @mysqli_fetch_array($qryDir);
			
//	    	$sql_stret = "CALL SPATIAL_CALLES(".$_GET['lon'].",".$_GET['lat'].");";
//	    	$query_st  = $db->sqlQuery($sql_stret);
//			$row_st    = $db->sqlFetchArray($query_st);
			
			$tpl-> assign_vars(array(
				'STREET'  => $row_st['CALLE'],
				'STA' => $row_st['ESTADO'],
				'MUN' => $row_st['MUNICIPIO'],
				'COL' => $row_st['ASENTAMIENTO'],
				'CP'  => $row_st['CP']
			));
			
			//$db->sqlClose();
			//$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
							    	
	    	/*---------Fin de las funciones que obienen la direccion---*/	    	

	    	
	    	/*---------Obtiene los estados ----------------------------*/
	    	$sql_edo = "SELECT 	ID_ESTADO,NOMBRE
						FROM ZZ_SPM_ENTIDADES
						ORDER BY NOMBRE";
	    	$query_edo = $db -> sqlQuery($sql_edo);
	    	while($row_edo = $db->sqlFetchArray($query_edo)){
	    		$tpl->assign_block_vars('states',array(
					'ID'   => $row_edo['ID_ESTADO'], 
					'NAME' => $row_edo['NOMBRE']
				));	
	    	}
	    	/*---------Fin de las fuciones que obtienen los estados ---*/	    		    	    	
	
			$tpl-> pparse('mAdd_GeoPuntosDireccion');
		}			
?>