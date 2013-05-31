<?php
/**
 *  @name                Obtiene las unidades a mostrar en el mapa
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          08/04/13
**/
	set_time_limit(0);
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$userID   	  = $userAdmin->user_info['ID_USUARIO'];	
	$idCliente    = $userAdmin->user_info['ID_CLIENTE'];
	$respuesta 	  = '';
	
	$sql_units  = "SELECT ADM_GRUPOS.ID_GRUPO, ADM_GRUPOS.NOMBRE, ADM_USUARIOS_GRUPOS.COD_ENTITY
					FROM ADM_USUARIOS_GRUPOS
					INNER JOIN ADM_GRUPOS          
						ON ADM_GRUPOS.ID_GRUPO = ADM_USUARIOS_GRUPOS.ID_GRUPO
					WHERE ADM_USUARIOS_GRUPOS.ID_USUARIO = ".$userID;
	$query_units= $db->sqlQuery($sql_units);
	
	while($row = $db->sqlFetchArray($query_units)){	
		
		$commands_units=""; 				
		$sql_cmds="SELECT  F.DESCRIPCION,F.COD_EQUIPMENT_PROGRAM, C.IMEI
					FROM ADM_UNIDADES A
					  INNER JOIN ADM_UNIDADES_EQUIPOS B 	ON B.COD_ENTITY 	= A.COD_ENTITY
					  INNER JOIN ADM_EQUIPOS C 		ON C.COD_EQUIPMENT 	= B.COD_EQUIPMENT
					  INNER JOIN ADM_EQUIPOS_TIPO D 	ON D.COD_TYPE_EQUIPMENT = C.COD_TYPE_EQUIPMENT
					  INNER JOIN ADM_COMANDOS_SALIDA E 	ON E.COD_TYPE_EQUIPMENT = D.COD_TYPE_EQUIPMENT
					  INNER JOIN ADM_COMANDOS_CLIENTE F 	ON F.COD_EQUIPMENT_PROGRAM = E.COD_EQUIPMENT_PROGRAM
					  INNER JOIN ADM_COMANDOS_USUARIO G 	ON G.ID_COMANDO_CLIENTE = F.ID_COMANDO_CLIENTE
					WHERE E.FLAG_SMS   = 0 
 					  AND A.COD_ENTITY = ".$row['COD_ENTITY']." 
					 AND  G.ID_USUARIO = ".$userAdmin->user_info['ID_USUARIO'];
		$query_cmds = $db->sqlQuery($sql_cmds);
		while($row_cmds = $db->sqlFetchArray($query_cmds)){
			$commands_units.= ($commands_units!="") ? "?" : "";
			$commands_units.= $row_cmds['COD_EQUIPMENT_PROGRAM']."_".$row_cmds['IMEI']."_".
							  $row_cmds['DESCRIPCION'];
		}		
		
		$commands_units = ($commands_units=="") ? "SC": $commands_units;		
		
		$upos = $Positions->get_last_position($row['COD_ENTITY'],$idCliente);
		if($upos != 0){
			$show	   	= ($upos['PRIORITY']) ? 1: 0; // PRIORIDAD DEL EVENTO
			$background	= $upos['BACKGROUND']; //COLOR DE PRIORIDAD
			$anglef		= $upos['ANGULO']; // ANGULO UTILIZADO PARA GIRAR OBJETO						
			$direccion1 = $Positions->direccion_no_format($upos['LATITUDE'],$upos['LONGITUDE']);				
			$estatus	= $upos['ESTATUS'];
			$color		= $upos['COLOR'];								
			
//			$querys="SELECT CONCAT('A ', TRUNCATE(DISTANCIA(".$upos['LONGITUDE'].",".$upos['LATITUDE'].
//						", LONGITUDE, LATITUDE),2),' KM de ',DESCRIPTION) AS DISTANCIA 
//					FROM ADM_GEO_REFERENCIAS 
//					WHERE TIPO 	 = 'G' 
//					  AND (ID_CLIENTE = ".$idCliente." 
//					  AND (PRIVACIDAD ='C' OR (ID_ADM_USUARIO = ".$userID." AND  PRIVACIDAD ='P')))
//					  OR  (ID_CLIENTE <> ".$idCliente." AND PRIVACIDAD ='T' )
//					ORDER BY DISTANCIA ASC LIMIT 1";
//					die($querys);
//			$qsquery 	= $db->sqlQuery($querys);	
//			$row_loc	= $db->sqlFetchArray($qsquery);	
//			if($row_loc['DISTANCIA']!=''){
//				$pdi = $row_loc['DISTANCIA'];
//			}else{
//				$pdi = "Sin PDI cercano";
//			}			
			$pdi = "Sin PDI cercano";
			
//		   	$Q ="SELECT A.ICONO 
//			   	FROM SAVL1220_G A 
//				INNER JOIN SAVL1220_GDET B ON A.ID_GROUP = B.ID_GROUP
//				WHERE B.COD_ENTITY =". $rowU['COD_ENTITY']." 
//				  AND COD_CLIENT =".$idCompany;
//			$QWERY 	= $db->sqlQuery($Q);	
//			$ROW	    = $db->sqlFetchArray($QWERY);	// ICONO			
			
			if($Functions->codif($direccion1)==''){
			    $new_dir='Sin direccion';
			}else{
			    $new_dir=$Functions->codif($direccion1);
			}
			
			$respuesta .= ($respuesta=="") ? "": "!"; 	
			$respuesta .= 	$row['ID_GRUPO'].'|'.$row['NOMBRE'].'|'.$row['COD_ENTITY'].'|'.
							$Functions->codif($upos['DESCRIPTION']).'|'.$background.'|'.	 
							$upos['GPS_DATETIME'].'|'. $Functions->codif($upos['DESC_EVT']).'|'.$estatus.'|'.
							$color.'|'.$pdi.'|'.$upos['VELOCIDAD'].'|'.$new_dir.'|'.$upos['LATITUDE'].'|'.
							$upos['LONGITUDE'].'|'.$show.'|'.@$ROW['ICONO'].'|'.$anglef."|".$commands_units;
										
			/*if($respuesta == ""){
				$respuesta = 	$row['ID_GRUPO'].'|'.$row['NOMBRE'].'|'.$row['COD_ENTITY'].'|'.
								$Functions->codif($upos['DESCRIPTION']).'|'.$background.'|'.	 
								$upos['GPS_DATETIME'].'|'. $Functions->codif($upos['DESC_EVT']).'|'.$estatus.'|'.
								$color.'|'.$pdi.'|'.$upos['VELOCIDAD'].'|'.$new_dir.'|'.$upos['LATITUDE'].'|'.
								$upos['LONGITUDE'].'|'.$show.'|'.@$ROW['ICONO'].'|'.$anglef;  
			}else{
				$respuesta =  $respuesta .'!'.$row['ID_GRUPO'].'|'.$row['NOMBRE'].'|'.$row['COD_ENTITY'].'|'.
				$Functions->codif($upos['DESCRIPTION']).'|'.$background.'|'. $upos['GPS_DATETIME'].'|'. 
				$Functions->codif($upos['DESC_EVT']).'|'.$estatus.'|'.$color.'|'.$pdi.'|'.$upos['VELOCIDAD'].'|'.
				$new_dir.'|'.$upos['LATITUDE'].'|'.$upos['LONGITUDE'].'|'.$show.'|'.@$ROW['ICONO'].'|'.$anglef;
			}	*/
		}else{
			$data_unit = $dbf->getRow('ADM_UNIDADES',' COD_ENTITY = '.$row['COD_ENTITY']);
			$descripcion = ($data_unit) ? $data_unit['DESCRIPTION'] : 'S/info.';
			
			$respuesta .= ($respuesta=="") ? "": "!";
			$respuesta .= $row['ID_GRUPO'].'|'.$row['NOMBRE'].'|'.$row['COD_ENTITY'].'|'.
			$Functions->codif($descripcion).'|0|0|0|0|0|0|0|0|0|0|0|0|0|'.$commands_units;			
			/*if($respuesta == ""){	
				$respuesta = $row['ID_GRUPO'].'|'.$row['NOMBRE'].'|'.$row['COD_ENTITY'].
									'|0|0|0|0|0|0|0|0|0|0|0|0|0|0';	 
			}else{
				$respuesta =  $respuesta .'!'.$row['ID_GRUPO'].'|'.$row['NOMBRE'].'|'.$row['COD_ENTITY']
									.'|0|0|0|0|0|0|0|0|0|0|0|0|0|0'; 
			}*/				
		}
	}	
	echo $respuesta;		
?>