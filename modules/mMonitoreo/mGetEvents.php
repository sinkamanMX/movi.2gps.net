<?php
/** * 
 *  @package             
 *  @name                Muestra los ultimos eventos de las unidades 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          12-06-2013
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	/*$userAdmin->user_info['ID_USUARIO'] = 1;*/
	$result=Array();
	$sql="SELECT h.COD_HISTORY,u.DESCRIPTION AS UNIT, h.GPS_DATETIME AS DATE, 
				 e.DESCRIPTION AS EVENTO, h.LATITUD, h.LONGITUD
		FROM HIST1143_LOCK h
		INNER JOIN ADM_UNIDADES u ON h.COD_ENTITY = u.COD_ENTITY
		INNER JOIN ADM_EVENTOS  e ON e.COD_EVENT  = h.COD_EVENT
		WHERE h.COD_ENTITY IN (SELECT COD_ENTITY FROM ADM_USUARIOS_GRUPOS WHERE ID_USUARIO = ".
		$userAdmin->user_info['ID_USUARIO'].")
		AND   h.GPS_DATETIME < NOW()-INTERVAL 1 HOUR
		/*AND CAST(h.GPS_DATETIME AS DATE) < CURRENT_DATE()*/
		ORDER BY h.FECHA_SAVE DESC ";
	$query = $db->sqlQuery($sql);
	$count = $db->sqlEnumRows($query);
	while($row = $db->sqlFetchArray($query)){		
		$direction = $Positions->direccion_no_format($row['LATITUD'],$row['LONGITUD']);
		$result[] = Array(
					"ID"   		=> $row['COD_HISTORY'],
				  	"UNIT"   	=> $row['UNIT'],
				  	"DATE"   	=> $row['DATE'],						 
				  	"EVENT"		=> $row['EVENTO'],
				  	"LAT"   	=> $row['LATITUD'],
				  	"LON"   	=> $row['LONGITUD'],
			  	  	"DIR"   	=> $direction);
	}	
	echo json_encode( $result );
?>