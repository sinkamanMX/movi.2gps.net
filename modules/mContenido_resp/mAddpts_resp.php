<?php
header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';

		
$tpl->set_filenames(array('mAddpts' => 'tAddpts'));
$idc   = $userAdmin->user_info['ID_CLIENTE'];


		$row='';


		$dsp=  ''; 
		  /*$a= ($row['TYPE']=='AVL') ? '100px' : '75px'; 
		  $b= ($row['TYPE']=='AVL') ? '265px' : '210px'; 
		  $c= ($row['TYPE']=='AVL') ? '265px' : '210px'; 
		  $d= ($row['TYPE']=='AVL') ? '55px'  : '50px'; 
		  $e= ($row['TYPE']=='AVL') ? '100px' : '90px'; */
		  $tbl= '<th width="75px" align="center">PDI</th>
<th width="210px" align="center">Fecha de entrega</th>
<th width="210px" align="center">Fecha fin</th>
<th width="50px"  align="center">Tol</th>
<th width="90px" align="center">Identificador</th>
<th width="175px" align="center">Observaciones</th>
<th width="" align="center">Cuestionario</th>
<th width="" align="left"></th>'; 
			 $tpl->assign_vars(array(
				'DSP_DOS'	=> $dsp,
				'TBL'		=> $tbl
				/*'A'         => $a,
				'B'         => $b,
				'C'         => $c,
				'D'         => $d,
				'F'         => $e*/
										));			
	
//////////////////////////////////////////////////////////////////////////// 

if($row!='AVL'){
	$sql_h="SELECT C.ID_CUESTIONARIO, C.DESCRIPCION AS CUE FROM CRM2_CUESTIONARIOS C WHERE C.COD_CLIENT=".$idc;
	$query_h = $db->sqlQuery($sql_h);
	$count_h = $db->sqlEnumRows($query_h);
	
	if($count_h>0){
		
		while($row_h=$db->sqlFetchArray($query_h)){
			 $tpl->assign_block_vars('dt4',array(
			 'OP'   => '<option  value="'. $row_h["ID_CUESTIONARIO"].'">'.$row_h['CUE'].'</option>'
										));	
		}
	}
}	
	
	for($i=0;$i<24;$i++){		
			$hour = ($i < 10) ? '0'.$i : $i; 
			$chk  = ($i == 0) ? 'selected="selected"':'';
			$tpl->assign_block_vars('hrs',array(				
				'NO'   => '<option '.$chk.' value="'.$hour.'">'.$hour.'</option>'			
 			));			
		}
		
		for($i=0;$i<60;$i++){	
			$hour = ($i < 10) ? '0'.$i : $i; 
			$chk  = ($i == 0) ? 'selected="selected"':'';
			$tpl->assign_block_vars('min',array(
				'NO'   => '<option '.$chk.' value="'.$hour.'">'.$hour.'</option>'	
 			));			
		}


			 $tpl->assign_vars(array(
				//'UND'	=> $row['DESCRIPTION'],
				'IDD'	=> $_GET['idd']
										));	
	
////////////////////////////////////////////////////////////////////////////
 $sql_g="SELECT S.ID_OBJECT_MAP, S.DESCRIPCION, S.LONGITUDE, S.LATITUDE,S.RADIO FROM ADM_GEOREFERENCIAS S WHERE S.TIPO='G' AND S.ID_CLIENTE=".$idc;
	$query_g = $db->sqlQuery($sql_g);
	$count_g = $db->sqlEnumRows($query_g);		
	
	if($count_g>0){
		
		while($row_g=$db->sqlFetchArray($query_g)){
			 $tpl->assign_block_vars('dt2',array(
				'IDC'	=> $row_g['ID_OBJECT_MAP'],
				'CTE'	=> utf8_encode($row_g['DESCRIPCION']),
				'LAT'	=> $row_g['LATITUDE'],
				'LON'	=> $row_g['LONGITUDE'],
				'RDO'	=> $row_g['RADIO']
										));	
		}
	}

////////////////////////////////////////////////////////////////////////////
$sql_k="SELECT COD_ENTITY FROM DSP_UNIDAD_ASIGNADA WHERE ID_DESPACHO=".$_GET['idd'];
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
$sql_j="SELECT D.DESCRIPCION, D.ITEM_NUMBER, D.FECHA_INICIO, D.FECHA_FIN, D.TOLERANCIA, D.PARADAS, D.EXCESOS FROM DSP_DESPACHO D WHERE  D.ID_DESPACHO=".$_GET['idd'];
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
	for($i=0;$i<24;$i++){		
			$hour = ($i < 10) ? '0'.$i : $i; 
			$chk  =  ($i == $d2[0]) ? 'selected="selected"':'';
			$chk2  = ($i == $e2[0]) ? 'selected="selected"':'';
			$tpl->assign_block_vars('hri',array(				
				'HR'    => '<option '.$chk.' value="'.$hour.'">'.$hour.'</option>',
				'HR2'   => '<option '.$chk2.' value="'.$hour.'">'.$hour.'</option>'
 			));			
		}
		
		for($i=0;$i<60;$i++){	
			$hour = ($i < 10) ? '0'.$i : $i; 
			$chk  =  ($i == $d2[1]) ? 'selected="selected"':'';
			$chk2  = ($i == $e2[1]) ? 'selected="selected"':'';
			$tpl->assign_block_vars('mni',array(
				'MN'    => '<option '.$chk.' value="'.$hour.'">'.$hour.'</option>',
				'MN2'   => '<option '.$chk2.' value="'.$hour.'">'.$hour.'</option>'				
 			));			
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
 $sql_n="SELECT D.ID_CTO, D.DESCRIPCION FROM DSP_CIRCUITO D WHERE COD_CLIENT=".$idc;
	$query_n = $db->sqlQuery($sql_n);
	$count_n = $db->sqlEnumRows($query_n);		
	
	if($count_n>0){
		
		while($row_n=$db->sqlFetchArray($query_n)){
			 $tpl->assign_block_vars('C',array(
				'CTO'	=> $row_n['ID_CTO'],
				'DSC'	=> utf8_encode($row_n['DESCRIPCION'])
										));	
		}
	}			
$tpl->pparse('mAddpts');
$db->sqlClose();
?>