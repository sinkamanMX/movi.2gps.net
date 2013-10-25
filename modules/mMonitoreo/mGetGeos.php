<?php
/**
 *  @name                Obtiene las georeferencias a mostrar en el mapa
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          10/06/13
**/
	set_time_limit(0);
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$userId   	  = $userAdmin->user_info['ID_USUARIO'];	
	$idCliente    = $userAdmin->user_info['ID_CLIENTE'];
	$respuesta 	  = "";
	
	/** 
	* Obtiene los geo-puntos privados, asi como los publicos y los que pertenecen a su empresa 
	*/
    $sql = "SELECT ID_OBJECT_MAP AS ID, ADM_GEOREFERENCIAS.TIPO,ADM_GEOREFERENCIAS.DESCRIPCION AS NOMBRE, PRIVACIDAD, 
					LATITUDE,LONGITUDE,IF(COD_COLOR IS NULL, '0',COD_COLOR) AS COD_COLOR,
					IF(ADM_GEOREFERENCIAS_TIPO.IMAGE IS NULL,ADM_IMAGE.URL,ADM_GEOREFERENCIAS_TIPO.IMAGE) AS IMAGE
			FROM ADM_GEOREFERENCIAS
			LEFT JOIN ADM_GEOREFERENCIAS_TIPO ON ADM_GEOREFERENCIAS.ID_TIPO_GEO = ADM_GEOREFERENCIAS_TIPO.ID_TIPO
            LEFT JOIN ADM_IMAGE ON ADM_IMAGE.ID_IMG = ADM_GEOREFERENCIAS_TIPO.ID_IMAGE
			WHERE ADM_GEOREFERENCIAS.ID_ADM_USUARIO = ".$userId."
			  OR (ADM_GEOREFERENCIAS.PRIVACIDAD = 'C' AND ADM_GEOREFERENCIAS.ID_CLIENTE = ".$idCliente.")
			  OR (ADM_GEOREFERENCIAS.PRIVACIDAD = 'T' AND ADM_GEOREFERENCIAS.ID_CLIENTE = ".$idCliente.")";
 	$query = $db->sqlQuery($sql);
 	while($row = $db->sqlFetchArray($query)){
 		$color 		= $dbf->getRow('ADM_COLORES','COD_COLOR='.@$row['COD_COLOR']);
		$color_rgb  = $Functions->rgb2html($color['R'],$color['G'],$color['B']);
		 		
 		$respuesta .= ($respuesta=="") ? "": "|";
 		$respuesta .= $row['TIPO']."!".$color_rgb."!".$row['IMAGE']."!".$row['NOMBRE']."!".
				      $row['LATITUDE']."!".$row['LONGITUDE']."!";
 		
 		if($row['TIPO']!='G'){
 			$a_position='';
		 	$sql_spatial = "SELECT ASTEXT(GEOM) AS GEO
							FROM ADM_GEOREFERENCIAS_ESPACIAL
							WHERE ID_OBJECT_MAP = ".$row['ID'];
			$query_spatial = $db->sqlQuery($sql_spatial);
			$row_spatial   = $db->sqlFetchArray($query_spatial);
			if($row_spatial['GEO']!=NULL){
				$last = $row_spatial['GEO'].length - 3; 
				$mult = substr($row_spatial['GEO'] ,9 ,$last);
				$pre_positions=split(",",$mult);
				for($p=0;$p<count($pre_positions);$p++){	
					$a_position .= ($a_position=="") ? '':'&';					
					$fixed = str_replace(' ','*',$pre_positions[$p]); 
					$a_position .= ''.$fixed.'';
				}			
			}
			$respuesta .= $a_position; 
 		}else{
 			$respuesta .= "null";
 		}
 	}
 	echo $respuesta; 