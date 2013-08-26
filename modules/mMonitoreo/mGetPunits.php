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
	$bloqueo      = 0;
	$sql_units  = "SELECT ADM_GRUPOS.ID_GRUPO, ADM_GRUPOS.NOMBRE, ADM_USUARIOS_GRUPOS.COD_ENTITY
					FROM ADM_USUARIOS_GRUPOS
					INNER JOIN ADM_GRUPOS          
						ON ADM_GRUPOS.ID_GRUPO = ADM_USUARIOS_GRUPOS.ID_GRUPO
					WHERE ADM_USUARIOS_GRUPOS.ID_USUARIO = ".$userID."
					ORDER BY NOMBRE";
	$query_units= $db->sqlQuery($sql_units);
	
	while($row = $db->sqlFetchArray($query_units)){	
		$imemiUnit= '';	
		$commands_units="";
		$flagPosition=-1;
		$blockMotor=2;
		$sqlUnitsEquipment = "SELECT  C.IMEI, D.COD_TYPE_EQUIPMENT,D.DESCRIPTION, D.BLOQUEO, MM.TYPE
					FROM ADM_UNIDADES A
					  INNER JOIN ADM_UNIDADES_EQUIPOS B ON B.COD_ENTITY 	= A.COD_ENTITY
					  INNER JOIN ADM_EQUIPOS C 			ON C.COD_EQUIPMENT 	= B.COD_EQUIPMENT
					  INNER JOIN ADM_EQUIPOS_TIPO D 	ON D.COD_TYPE_EQUIPMENT = C.COD_TYPE_EQUIPMENT	
					  INNER JOIN ADM_MARCA_MODELO MM ON A.COD_TRADEMARK_MODEL = MM.COD_TRADEMARK_MODEL 
					WHERE A.COD_ENTITY = ".$row['COD_ENTITY'];
		$queryInfoUnits = $db->sqlQuery($sqlUnitsEquipment);
		$countInfoUnits	= $db->sqlEnumRows($queryInfoUnits);
		if($countInfoUnits>0){
			$rowEquipments = $db->sqlFetchArray($queryInfoUnits);
			$imemiUnit     = ($rowEquipments['IMEI']=="NULL") ? "": $rowEquipments['IMEI'];
			$flagPosition  = $rowEquipments['BLOQUEO'];  
			$sql_cmds="SELECT F.DESCRIPCION,F.COD_EQUIPMENT_PROGRAM 
					FROM ADM_COMANDOS_SALIDA E 	 
					  LEFT JOIN ADM_COMANDOS_CLIENTE F 	ON F.COD_EQUIPMENT_PROGRAM = E.COD_EQUIPMENT_PROGRAM
					  LEFT JOIN ADM_COMANDOS_USUARIO G 	ON G.ID_COMANDO_CLIENTE = F.ID_COMANDO_CLIENTE
					WHERE E.COD_TYPE_EQUIPMENT = ".$rowEquipments['COD_TYPE_EQUIPMENT']."
					 AND E.FLAG_SMS   = 0 
					 AND  G.ID_USUARIO = ".$userID;
			$query_cmds = $db->sqlQuery($sql_cmds);
			while($row_cmds = $db->sqlFetchArray($query_cmds)){
				$commands_units.= ($commands_units!="") ? "?" : "";
				$commands_units.= $row_cmds['COD_EQUIPMENT_PROGRAM']."_".$imemiUnit."_".
								  $row_cmds['DESCRIPCION']."_".$rowEquipments['DESCRIPTION'];
			}			
		}											
		
		$commands_units = ($commands_units=="") ? "SC": $commands_units;
		$imemiUnit		= ($imemiUnit=="") ? 'Sin IMEI asignado':$imemiUnit;
		$typeEquimpent	= ($rowEquipments['TYPE']=="") ? "SM": $rowEquipments['TYPE'];	
					
		$upos = $Positions->get_last_position($row['COD_ENTITY'],$idCliente,$flagPosition);
		if($upos != 0){
			$show	   	= ($upos['PRIORITY']) ? 1: 0; // PRIORIDAD DEL EVENTO
			$background	= $upos['BACKGROUND']; //COLOR DE PRIORIDAD
			$anglef		= $upos['ANGULO']; // ANGULO UTILIZADO PARA GIRAR OBJETO						
			$direccion1 = $Positions->direccion_no_format($upos['LATITUDE'],$upos['LONGITUDE']);				
			$estatus	= $upos['ESTATUS'];
			$color		= $upos['COLOR'];
			$blockMotor = (isset($upos['BLOQUEO_MOTOR']) ) ? $upos['BLOQUEO_MOTOR']: '2';
			$battery 	= $upos['BATTERY'];
			
			$querys="SELECT CONCAT('A ', TRUNCATE(DISTANCIA(".$upos['LONGITUDE'].",".$upos['LATITUDE'].
						", LONGITUDE, LATITUDE),2),' KM de ',DESCRIPCION) AS DISTANCIA ,".
						"TRUNCATE(DISTANCIA(".$upos['LONGITUDE'].",".$upos['LATITUDE'].
						", LONGITUDE, LATITUDE),2) AS RDIST
					FROM ADM_GEOREFERENCIAS 
					WHERE TIPO 	 = 'G' 
					  AND (ID_CLIENTE = ".$idCliente." 
					  AND (PRIVACIDAD ='C' OR (ID_ADM_USUARIO = ".$userID." AND  PRIVACIDAD ='P')))
					  OR  (ID_CLIENTE <> ".$idCliente." AND PRIVACIDAD ='T' )
					ORDER BY DISTANCIA ASC LIMIT 1";					
			$qsquery 	= $db->sqlQuery($querys);	
			$row_loc	= $db->sqlFetchArray($qsquery);	
			if($row_loc['DISTANCIA']!='' && $row_loc['RDIST'] < 5){				
				$pdi = $row_loc['DISTANCIA'];
			}else{
				$pdi = "Sin PDI cercano";
			}						
			
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
							$upos['LONGITUDE'].'|'.$show.'|'.@$ROW['ICONO'].'|'.
							$anglef."|".$commands_units.'|'.$imemiUnit.'|'.$blockMotor."|".$typeEquimpent."|".$battery;
		}else{
			$data_unit = $dbf->getRow('ADM_UNIDADES',' COD_ENTITY = '.$row['COD_ENTITY']);
			$descripcion = ($data_unit) ? $data_unit['DESCRIPTION'] : 'S/info.';
			
			$respuesta .= ($respuesta=="") ? "": "!";
			$respuesta .= $row['ID_GRUPO'].'|'.$row['NOMBRE'].'|'.$row['COD_ENTITY'].'|'.
			$Functions->codif($descripcion).'|0|0|0|0|0|0|0|0|0|0|0|0|0|'.$commands_units.'|'.
							$imemiUnit.'|'.$blockMotor."|".$typeEquimpent."|".$battery;
		}
	}	
	echo $respuesta;		
?>