<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$id_client = 0;
	$show_text = true;
	$a_respuestas = array(
		array("id"=>"S",'name'=>'Si' ),
		array("id"=>"N",'name'=>'No' )
	);	
	$id_row=0;
	/*Se valida la variaable data, si esta viene y es diferente de 0 es uan edicion*/
	if(isset($_GET['data']) || $_GET['data'] !=0){
		$id_row    = $_GET['data'];
		$id_client = $_GET['id_client'];
		$data_row  = $dbf->getRow('ADM_PROTOCOLOS','COD_PROTOCOLO = '.$id_row);
		$unit_assign = $dbf->getRow('ADM_PROTOCOLO_UNIDADES','COD_PROTOCOLO = '.$id_row);	  	
	}
	
	if(@$unit_assign['COD_ENTITY']!=NULL){
		$unit_info = $dbf->getRow('ADM_UNIDADES','COD_ENTITY = '.@$unit_assign['COD_ENTITY']);
		$units     = '<option selected value="'.$unit_info['COD_ENTITY'].'">'.$unit_info['DESCRIPTION']
                    .'</option>';
        $show_text = false;            
	}
	
	$query_u = 'FROM ADM_UNIDADES
				LEFT JOIN ADM_PROTOCOLO_UNIDADES ON ADM_UNIDADES.COD_ENTITY = ADM_PROTOCOLO_UNIDADES.COD_ENTITY
				WHERE COD_CLIENT = '.$id_client.'
  				  AND ADM_PROTOCOLO_UNIDADES.COD_ENTITY IS NULL
  				ORDER BY DESCRIPTION';
	$units.= $dbf->cbo_from_query('ADM_UNIDADES.COD_ENTITY','DESCRIPTION',$query_u,@$units['COD_ENTITY'],$show_text);
		
	$estatus = $Functions->cbo_from_array($a_respuestas,@$data_row['ACTIVO']);		
	$tpl->set_filenames(array('adminGetRow' => 'admintSetRow'));
	$tpl->assign_vars(array(
		'ID'		=> $id_row,
		'NAME'		=> @$data_row['DESCRIPCION'],
		'OBS'		=> @$data_row['OBSERVACION'],
		'STATUS'	=> $estatus,
		'UNITS'		=> $units
	));	
	$tpl->pparse('adminGetRow');	
?>	