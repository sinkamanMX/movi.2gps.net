<?php
header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';
	

	$idc   = $userAdmin->user_info['ID_CLIENTE'];
		
$tpl->set_filenames(array('mEdtpts' => 'tEdtpts'));


	

	$sql_f="SELECT S.TYPE FROM ADM_CLIENTES S WHERE  S.ID_CLIENTE=".$idc;
	$query_f = $db->sqlQuery($sql_f);
	$count_f = $db->sqlEnumRows($query_f);		
	

		

		$dsp= ''; 
			 $tpl->assign_vars(array(
				'DSP_DOS'	=> $dsp
										));			
	

			 


////////////////////////////////////////////////////////////////////////////

   
    $sql_d="SELECT D.ID_DESPACHO, D.ID_ESTATUS FROM DSP_ITINERARIO D WHERE D.ID_ENTREGA=".$_GET['ide'];
	$query_d = $db->sqlQuery($sql_d);
	$count_d = $db->sqlEnumRows($query_d);
	$row_d   = $db->sqlFetchArray($query_d);
	/*if($row_d['ID_ESTATUS']==8){
		$titulo="Confirmar Arribo";
		$icono="check";
		$funcion="confirmar(".$row_d['ID_ESTATUS'].",".$_GET['ide'].")";
		}
	if($row_d['ID_ESTATUS']==9){
		$titulo="Confirmar Entrega";
		$icono="check";
		$funcion="confirmar(".$row_d['ID_ESTATUS'].",".$_GET['ide'].")";
		}	
	if($row_d['ID_ESTATUS']!=9 && $row_d['ID_ESTATUS']!=8){
		$titulo="Cancelar Entrega";
		$icono="closethick";
		$funcion="klr(".$_GET['ide'].")";
		}*/			
	$tpl->assign_vars(array(
		'IDE'	=> $_GET['ide'],
		'BTN'	=> $_GET['btn'],
		'EST'	=> $row_d['ID_ESTATUS']
				));
	$tpl->assign_vars(array(
				//'UND'	=> $row['DESCRIPTION'],
				'IDD'	=> $row_d['ID_DESPACHO'],
				'TTL'	=> $titulo,
				'ICN'	=> $icono,
				'FCN'	=> $funcion
										));	
																				
////////////////////////////////////////////////////////////////////////////

    $sql_k="SELECT COD_ENTITY FROM DSP_UNIDAD_ASIGNADA WHERE ID_DESPACHO=".$row_d['ID_DESPACHO'];
	$query_k = $db->sqlQuery($sql_k);
	$count_k = $db->sqlEnumRows($query_k);
	$row_k   = $db->sqlFetchArray($query_k);
////////////////////////////////////////////////////////////////////////////
$sql_i="SELECT UN.COD_ENTITY,UN.DESCRIPTION FROM ADM_UNIDADES UN
LEFT JOIN DSP_UNIDAD_ASIGNADA UA ON UA.COD_ENTITY=UN.COD_ENTITY  AND UA.LIBRE=1 WHERE   UN.COD_CLIENT=".$idc;
	$query_i = $db->sqlQuery($sql_i);
	$count_i = $db->sqlEnumRows($query_i);		
	
	if($count_i>0){
		
		while($row_i=$db->sqlFetchArray($query_i)){
			 $s = ($row_k['COD_ENTITY']==$row_i['COD_ENTITY']) ? 'selected="selected"' : '';
			
			 $tpl->assign_block_vars('dt3',array(
				'IDU'	=> $row_i['COD_ENTITY'],
				'UND'	=> utf8_encode($row_i['DESCRIPTION']),
				'STD'	=> $s
										));	
		}
	}
	
////////////////////////////////////////////////////////////////////////////
$sql_j="SELECT D.DESCRIPCION, D.ITEM_NUMBER, D.FECHA_INICIO, D.FECHA_FIN, D.TOLERANCIA, D.PARADAS, D.EXCESOS FROM DSP_DESPACHO D WHERE  D.ID_DESPACHO=".$row_d['ID_DESPACHO'];
	$query_j = $db->sqlQuery($sql_j);
	$count_j = $db->sqlEnumRows($query_j);
	
	if($count_j>0){
		
		$row_j=$db->sqlFetchArray($query_j);
		$d=explode(" ",$row_j['FECHA_INICIO']);
		$e=explode(" ",$row_j['FECHA_FIN']);
		$d2=explode(":",$d[1]);
		$e2=explode(":",$e[1]);
		$stp = ($row_j['PARADAS']==1) ? 'checked="checked"' : ''; 
		$exc = ($row_j['EXCESOS']==1) ? 'checked="checked"' : ''; 
			 $tpl->assign_vars(array(
				'DSP'	=> utf8_encode($row_j['DESCRIPCION']),
				'IDV'	=> $row_j['ITEM_NUMBER'],
				'DTI'	=> $d[0],
				'DTF'	=> $e[0],
				'TOL'	=> $row_j['TOLERANCIA'],
				'STP'	=> $stp,
				'EXC'	=> $exc
										));	
		
	}
////////////////////////////////////////////////////////////////////////////
if($row!='AVL'){
$sql_l="SELECT D.COD_GEO, D.ITEM_NUMBER,
CAST(D.FECHA_ENTREGA AS TIME) AS T1,
CAST(D.FECHA_SALIDA  AS TIME) AS T2,
IF(D.FECHA_ENTREGA='0000-00-00 00:00:00','',CAST(D.FECHA_ENTREGA AS DATE)) AS DTE,
IF(D.FECHA_SALIDA='0000-00-00 00:00:00','',CAST(D.FECHA_SALIDA AS DATE)) AS DTS,
D.COMENTARIOS, DI.ID_CUESTIONARIO, DI.ID_PAYLOAD, GP.RADIO, GP.LONGITUDE, GP.LATITUDE FROM DSP_ITINERARIO D
LEFT JOIN ADM_GEOREFERENCIAS GP ON D.COD_GEO = GP.ID_TIPO_GEO
LEFT JOIN DSP_DOCUMENTA_ITINERARIO DI ON DI.ID_ENTREGA=D.ID_ENTREGA WHERE D.ID_ENTREGA=".$_GET['ide'];
}
else{
$sql_l="SELECT D.COD_GEO, D.ITEM_NUMBER,
CAST(D.FECHA_ENTREGA AS TIME) AS T1,
CAST(D.FECHA_SALIDA  AS TIME) AS T2,
IF(D.FECHA_ENTREGA='0000-00-00 00:00:00','',CAST(D.FECHA_ENTREGA AS DATE)) AS DTE,
IF(D.FECHA_SALIDA='0000-00-00 00:00:00','',CAST(D.FECHA_SALIDA AS DATE)) AS DTS, D.COMENTARIOS, GP.RADIO, GP.LONGITUDE, GP.LATITUDE FROM DSP_ITINERARIO D
INNER JOIN ADM_GEOREFERENCIAS GP ON D.COD_GEO = GP.ID_TIPO_GEO
WHERE D.ID_ENTREGA=".$_GET['ide'];
}
	$query_l = $db->sqlQuery($sql_l);
	$count_l = $db->sqlEnumRows($query_l);
	
	if($count_l>0){
		
		$row_l=$db->sqlFetchArray($query_l);
		 //$dt= explode(" ", $row_l['FECHA_ENTREGA']);
		 //$dt[0];
		 //$dt2=explode(" ", $row_l['FECHA_SALIDA']);
		 $t  = explode(":",$row_l['T1']);
		 $t2 = explode(":",$row_l['T2']);
		 $ptl = ($row_l['ID_PAYLOAD']!=0) ? $row_l['ID_PAYLOAD'] :'';
			 $tpl->assign_vars(array(
				'IDV'	=> $row_l['ITEM_NUMBER'],
				'DTE'	=> $row_l['DTE'],
				'DTS'	=> $row_l['DTS'],
				'OBS'	=> $row_l['COMENTARIOS'],
				'PTL'	=> $ptl,
				'LAT'	=> $row_l['LATITUDE'],
				'LON'	=> $row_l['LONGITUDE'],
				'RDO'	=> $row_l['RADIO']
										));	
		
	}	
////////////////////////////////////////////////////////////////////////////
if($row!='AVL'){
	 $sql_h="SELECT C.ID_CUESTIONARIO, C.DESCRIPCION AS CUE FROM CRM2_CUESTIONARIOS C WHERE C.COD_CLIENT=".$idc;
	$query_h = $db->sqlQuery($sql_h);
	$count_h = $db->sqlEnumRows($query_h);
	
	if($count_h>0){
		
		while($row_h=$db->sqlFetchArray($query_h)){
			$sl= ($row_h["ID_CUESTIONARIO"] == $row_l['ID_CUESTIONARIO']) ? 'selected="selected"':'';
			 $tpl->assign_block_vars('dt4',array(
			 'OP'   => '<option  value="'. $row_h["ID_CUESTIONARIO"].' "'.$sl.'>'.$row_h['CUE'].'</option>'
										));	
		}
	}			
}
////////////////////////////////////////////////////////////////////////////
	for($i=0;$i<24;$i++){		
			$hour = ($i < 10) ? '0'.$i : $i; 
			$chk  = ($i == $t[0] ) ? 'selected="selected"':'';
			$chk2 = ($i == $t2[0]) ? 'selected="selected"':'';
			$tpl->assign_block_vars('hrs',array(				
				'NO'   => '<option '.$chk.'  value="'.$hour.'">'.$hour.'</option>',
				'N2'   => '<option '.$chk2.' value="'.$hour.'">'.$hour.'</option>'
 			));			
		}
		
		for($i=0;$i<60;$i++){	
			$hour = ($i < 10) ? '0'.$i : $i; 
			$chk  = ($i == $t[1]) ? 'selected="selected"':'';
			$chk2 = ($i == $t2[1]) ? 'selected="selected"':'';
			$tpl->assign_block_vars('min',array(
				'NO'   => '<option '.$chk.' value="'.$hour.'">'.$hour.'</option>',
				'N2'   => '<option '.$chk2.' value="'.$hour.'">'.$hour.'</option>'	
 			));			
		}
////////////////////////////////////////////////////////////////////////////		
	$sql_g="SELECT S.ID_OBJECT_MAP, S.DESCRIPCION, S.LONGITUDE, S.LATITUDE,S.RADIO FROM ADM_GEOREFERENCIAS S WHERE S.TIPO='G' AND S.ID_CLIENT=".$idc;
	$query_g = $db->sqlQuery($sql_g);
	$count_g = $db->sqlEnumRows($query_g);		
	
	if($count_g>0){
		
		while($row_g=$db->sqlFetchArray($query_g)){
			$slc= ($row_g["ID_OBJECT_MAP"] == $row_l['COD_GEO']) ? 'selected="selected"':'';
			 $tpl->assign_block_vars('dt2',array(
				'IDC'	=> $row_g['ID_OBJECT_MAP'],
				'CTE'	=> utf8_encode($row_g['DESCRIPCION']),
				'LAT'	=> $row_g['LATITUDE'],
				'LON'	=> $row_g['LONGITUDE'],
				'RDO'	=> $row_g['RADIO'],
				'STD'	=> $slc
										));	
		}
	}

////////////////////////////////////////////////////////////////////////////
 $sql_m="SELECT D.ID_TIPO, D.DESCRIPCION FROM DSP_TIPO_NOTA D";
	$query_m = $db->sqlQuery($sql_m);
	$count_m = $db->sqlEnumRows($query_m);		
	
	if($count_m>0){
		
		while($row_m=$db->sqlFetchArray($query_m)){
			 $tpl->assign_block_vars('tn',array(
				'IDT'	=> $row_m['ID_TIPO'],
				'TNT'	=> utf8_encode($row_m['DESCRIPCION'])
										));	
		}
	}

////////////////////////////////////////////////////////////////////////////
		
$tpl->pparse('mEdtpts');
$db->sqlClose();
?>