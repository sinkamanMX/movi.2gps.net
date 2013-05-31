<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$id_row=0;
	$id_client = $_GET['id_client'];
	
	$a_respuestas = array(
		array("id"=>"1",'name'=>'Si' ),
		array("id"=>"0",'name'=>'No' )
	);
	/*Se valida la variaable data, si esta viene y es diferente de 0 es uan edicion*/
	if(isset($_GET['data']) || $_GET['data'] !=0){
		$id_row = $_GET['data'];			  	
		$data_row 	 = $dbf->getRow('ADM_EQUIPOS','COD_EQUIPMENT = '.$id_row);
		$unit_assign = $dbf->getRow('ADM_UNIDADES_EQUIPOS','COD_EQUIPMENT = '.$id_row);
	}
	
	$mensajes= $Functions->cbo_from_array($a_respuestas,@$data_row['FLAG_MENSAJES']);
	$video	= $Functions->cbo_from_array($a_respuestas,@$data_row['FLAG_VIDEO']);
	$voz	= $Functions->cbo_from_array($a_respuestas,@$data_row['FLAG_VOZ']);
	$dchp	= $Functions->cbo_from_array($a_respuestas,@$data_row['FLAG_DHCP_ON']);		
	
	$equipo=$dbf->cbo_from('COD_TYPE_EQUIPMENT','DESCRIPTION','ADM_EQUIPOS_TIPO','1=1',@$data_row['COD_TYPE_EQUIPMENT']);
		
	if(@$unit_assign['COD_ENTITY']!=NULL){
		$unit_info = $dbf->getRow('ADM_UNIDADES','COD_ENTITY = '.@$unit_assign['COD_ENTITY']);
		$unidad  = '<option selected value="'.$unit_info['COD_ENTITY'].'">'.$unit_info['DESCRIPTION'].'</option>';
	}
	$unidad  .= '<option value="-1">Sin Unidad</option>';
	
	$where = 'COD_ENTITY NOT IN (
			    SELECT COD_ENTITY 
			    FROM ADM_UNIDADES_EQUIPOS
			    WHERE COD_CLIENT = '.$id_client.') AND COD_CLIENT = '.$id_client;
	$unidad  .= $dbf->cbo_from('COD_ENTITY','DESCRIPTION','ADM_UNIDADES',$where);		
	
	$query_evts_eq = ' FROM ADM_EVENTOS_EQUIPOS A
		LEFT OUTER JOIN ADM_EVENTOS_SISTEMA B 
  				ON B.COD_EVENT_EQUIPMENT = A.COD_EVENT_EQUIPMENT AND B.COD_EQUIPMENT = '.$id_row.'
  		INNER JOIN ADM_EQUIPOS_TIPO C ON C.COD_TYPE_EQUIPMENT = A.COD_TYPE_EQUIPMENT
  		INNER JOIN ADM_EQUIPOS      D 
		  		ON C.COD_TYPE_EQUIPMENT = C.COD_TYPE_EQUIPMENT AND D.COD_EQUIPMENT = '.$id_row.'
		WHERE B.COD_EVENT_EQUIPMENT IS NULL';
	$evts_equipo = $dbf->cbo_from_query('A.COD_EVENT_EQUIPMENT','A.EVENT_REASON',$query_evts_eq);
	
	$query_sistema = ' FROM ADM_EVENTOS A
		LEFT OUTER JOIN ADM_EVENTOS_SISTEMA B ON B.COD_EVENT = A.COD_EVENT AND B.COD_EQUIPMENT = '.$id_row.'
		WHERE B.COD_EVENT IS NULL AND
      	A.ID_CLIENTE = '.$id_client;		
	$evts_sistema= $dbf->cbo_from_query('A.COD_EVENT','A.DESCRIPTION',$query_sistema);
	
	$query_evts_assign = 'SELECT A.EVENT_REASON AS EVENTO_HARDWARE, A.COD_EVENT_EQUIPMENT AS ID_E  
								,B.DESCRIPTION AS EVENTO_SISTEMA, B.COD_EVENT AS ID_S
							FROM ADM_EVENTOS_SISTEMA C
  							INNER JOIN ADM_EVENTOS  B ON B.COD_EVENT = C.COD_EVENT
  							INNER JOIN ADM_EVENTOS_EQUIPOS A ON A.COD_EVENT_EQUIPMENT = C.COD_EVENT_EQUIPMENT
							WHERE C.COD_EQUIPMENT = '.$id_row;
	$query_evts_a = $db->sqlquery($query_evts_assign);
	$count_evts_a = $db->sqlEnumRows($query_evts_a);
	if($count_evts_a>0){
		while($row_evts = $db->sqlFetchArray($query_evts_a)){
			$evts_rel .= ($evts_rel!="") ? ', ': '';
			$evts_rel .= '{"IDS"   : "'.$row_evts['ID_S'] 		   .'" , '.
						 ' "NAMES" : "'.$row_evts['EVENTO_SISTEMA'].'" , '.
						 ' "IDE"   : "'.$row_evts['ID_E']		   .'" , '.
					  	 ' "NAME"  : "'.$row_evts['EVENTO_HARDWARE'].'" }';
		}
	}	
	
	$marca = $dbf->cbo_from('COD_TRADEMARK','DESCRIPTION','ADM_MARCA','1=1 ORDER BY DESCRIPTION');
	$tipo  = $dbf->cbo_from('COD_TYPE_ENTITY','DESCRIPTION','ADM_TIPO_UNIDAD','1=1 ORDER BY DESCRIPTION');
	$grupo = $dbf->cbo_from_query('G.ID_GRUPO',' G.NOMBRE',' FROM ADM_GRUPOS G
									INNER JOIN ADM_GRUPOS_CLIENTES GC ON GC.ID_GRUPO=G.ID_GRUPO
									WHERE GC.ID_CLIENTE= '.$id_client.' ORDER BY G.NOMBRE');

	$tpl->set_filenames(array('mGetRow' => 'tSetRow'));
	$tpl->assign_vars(array(
		'ID'	=> $id_row,
		'DESC'	=> @$data_row['DESCRIPCION'], 
		'ITEM'	=> @$data_row['ITEM_NUMBER'], 
		'SECOND'=> @$data_row['SECOND_ITEM_NUMBER'], 
		'TX'	=> @$data_row['PORT_TX'], 
		'RX'	=> @$data_row['PORT_RX'], 
		'PHONE'	=> @$data_row['PHONE'], 
		'IMEI'	=> @$data_row['IMEI'], 
		'MSG'	=> $mensajes, 
		'VIDEO'	=> $video, 
		'VOZ'	=> $voz, 
		'REPORT'=> @$data_row['TIME_REPORT'], 
		'DHCP'	=> $dchp, 
		'EQUIPO'=> $equipo,
		'UNIDAD'=> $unidad,
		'EVTS_E'=> $evts_equipo,
		'EVTS_S'=> $evts_sistema,
		'EVTS_REL'=> $evts_rel,
		'MARCA' => $marca,
		'TIPO'  => $tipo,
		'GRUPO' => $grupo
	));	
	$tpl->pparse('mGetRow');	
?>	