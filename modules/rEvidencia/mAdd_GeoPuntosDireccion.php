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
				$es = ($row_edo['NOMBRE'] == $row_st['ESTADO'])?'selected="selected"':"";
	    		$tpl->assign_block_vars('states',array(
					'ID'   => $row_edo['ID_ESTADO'], 
					'NAME' => $row_edo['NOMBRE'],
					'S'	   => $es	
				));	
	    	}
			//
	    	/*---------Obtiene los MUNICIPIOS ----------------------------*/
	    	$sql_mun = "SELECT M.ID_MUNICIPIO,M.NOMBRE AS MUN FROM ZZ_SPM_MUNICIPIOS M
			INNER JOIN ZZ_SPM_ENTIDADES E ON E.ID_ESTADO = M.ID_ESTADO
			WHERE E.NOMBRE = '".$row_st['ESTADO']."' ORDER BY M.NOMBRE";
	    	$qry_mun = $db -> sqlQuery($sql_mun);
	    	while($row_mun = $db->sqlFetchArray($qry_mun)){
				$ms = ($row_mun['MUN'] == $row_st['MUNICIPIO'])?'selected="selected"':"";
	    		$tpl->assign_block_vars('mun',array(
					'ID'   => $row_mun['ID_MUNICIPIO'], 
					'NAME' => $row_mun['MUN'],
					'S'	   => $ms	
				));	
	    	}
	    	/*---------Obtiene las colonias ----------------------------*/
	    	$sql_col = "SELECT C.ID_COLONIA, C.NOMBRE AS COL FROM ZZ_SPM_COLONIAS C
			INNER JOIN ZZ_SPM_MUNICIPIOS M ON M.ID_MUNICIPIO = C.ID_MUNICIPIO
			INNER JOIN  ZZ_SPM_ENTIDADES E ON E.ID_ESTADO = C.ID_ESTADO
			WHERE M.NOMBRE = '".$row_st['MUNICIPIO']."' AND E.NOMBRE = '".$row_st['ESTADO']."' ORDER BY C.NOMBRE;";
	    	$qry_col = $db -> sqlQuery($sql_col);
	    	while($row_col = $db->sqlFetchArray($qry_col)){
				$sql = "SELECT IF('".$row_st['ASENTAMIENTO']."' LIKE '%".$row_col['COL']."%','SI','NO' ) AS C";
				$qry = $db -> sqlQuery($sql);
				$row = $db->sqlFetchArray($qry);
				//echo $row['C']."<br>";
				$cs = ($row['C'] == 'SI')?'selected="selected"':"";
	    		$tpl->assign_block_vars('col',array(
					'ID'   => $row_col['ID_COLONIA'], 
					'NAME' => $row_col['COL'],
					'S'	   => $cs	
				));	
	    	}			
	    	/*---------Fin de las fuciones que obtienen los estados ---*/	    		    	    	
	
			$tpl-> pparse('mAdd_GeoPuntosDireccion');
		}			
?>