<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	$id_row	= 0;
	$control= 0;
	$u_unselected = '';
	$a_units_selected='';
	$radio='';
	$pivacidad='';
	$a_position='';
	$a_pivacidad = array(
			array("tipo"=>"T",'val'=>$Functions->codif('Público') ),
			array("tipo"=>"C",'val'=>'Mi Empresa' ),
			array("tipo"=>"P",'val'=>'Pivado' )
	);
	/*Se valida la variaable data, si esta viene y es diferente de 0 es uan edicion*/
	if(isset($_GET['data']) || $_GET['data'] !="0"){
		$id_row 	= $_GET['data']; 
		$data_row 	= $dbf->getRow('ADM_GEOREFERENCIAS','ID_OBJECT_MAP = '.$_GET['data']);				
	}
	
	
	$tipo  = $dbf->cbo_from('ID_TIPO','DESCRIPCION','ADM_GEOREFERENCIAS_TIPO','1=1',@$data_row['ID_TIPO_GEO']);
	
	if($_GET['type']=="g"){		
		$tpl->set_filenames(array('mGetRow' => 'tGetRow'));		
		
		if($id_row>0){
			
			$color = $dbf->getRow('ADM_COLORES','COD_COLOR='.@$data_row['COD_COLOR']);
			$color_rgb = $Functions->rgb2html($color['R'],$color['G'],$color['B']);
			
		 	$sql_spatial = "SELECT ASTEXT(GEOM) AS GEO
							FROM ADM_GEOREFERENCIAS_ESPACIAL
							WHERE ID_OBJECT_MAP = ".$id_row;
			$query_spatial = $db->sqlQuery($sql_spatial);
			$row_spatial   = $db->sqlFetchArray($query_spatial);
			if($row_spatial['GEO']!=NULL){
				$last = $row_spatial['GEO'].length - 3; 
				$mult = substr($row_spatial['GEO'] ,9 ,$last);
				$pre_positions=split(",",$mult);
				
				for($p=0;$p<count($pre_positions);$p++){	
					$a_position .= ($a_position=="") ? '':',';
					$fixed = str_replace(' ',', ',$pre_positions[$p]); 
					$a_position .= '
									new google.maps.LatLng('.$fixed.')';	
				}			
			}		
			
		}
	}else{
		$tpl->set_filenames(array('mGetRow' => 'tGetRowp'));			
	}
	
	for($r=10;$r<=1000;$r=$r+10){
		$radio_select='';
		if($r==@$data_row['RADIO']){$radio_select='selected';}
		$radio .= '<option '.$radio_select.' value="'.$r.'" >'.$r.'</option>';
	}
	
	for($p=0;$p<count($a_pivacidad);$p++){
		$priv_select='';
		if($a_pivacidad[$p][tipo]==@$data_row['TIPO']){$priv_select='selected';}
		$pivacidad .= '<option '.$priv_select.' value="'.$a_pivacidad[$p]['tipo'].'" >'.$a_pivacidad[$p]['val'].'</option>';
	}	
	//echo @$data_row['ESTADO'];
	$estados   = $dbf->cbo_from_string('ID_ESTADO','NOMBRE','ZZ_SPM_ENTIDADES','1=1',@$data_row['ESTADO']);	
	$municipio = '<option selected value="-1" >'.$Functions->codif(@$data_row['MUNICIPIO']).'</option>';
	$colonia   = '<option selected value="-1" >'.$Functions->codif(@$data_row['COLONIA']).'</option>';
	
	$colores   = $dbf->cbo_from('COD_COLOR','DESCRIPTION','ADM_COLORES','1=1',@$data_row['COD_COLOR']);
	
	$tpl->assign_vars(array(
		'ID'		=>  $id_row,
		'DESCRIPCION'=> @$data_row['DESCRIPCION'],
		'LONGITUDE'	=> @$data_row['LONGITUDE'],
		'LATITUDE'	=> @$data_row['LATITUDE'],
		'CALLE'		=> @$data_row['CALLE'],
		'NO_INT'	=> @$data_row['NO_INT'],
		'NO_EXT'	=> @$data_row['NO_EXT'],
		'COLONIA'	=> $colonia,
		'MUNICIPIO'	=> $municipio,
		'ESTADOS'	=> $estados,
		'CP'		=> @$data_row['CP'],
		'RADIO'		=> $radio,
		'TIPO'		=> $tipo,
		'COLOR'		=> @$data_row['COLOR'],
		'PRIVACIDAD'=> $pivacidad,
		'COLORES'	=> $colores	,
		'POSITIONS' => $a_position,
		'COLOR_HEX' => $color_rgb		
	));	
	$tpl->pparse('mGetRow');
?>