<?php
header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
$userData = new usersAdministration();

if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}			

$tpl->set_filenames(array(
	'mEditar' => 'tEditar'
));
if(isset($_GET['id'])){
//--------------------------------------------------------------------------------
  
  $sql = "SELECT * FROM SAVL4003 WHERE COD_SUBMENU_CONTENIDO = ".$_GET['id'];
  
  $query = $db-> sqlQuery($sql);
  $count = $db-> sqlEnumRows($query);
  $row   = $db-> sqlFetchArray($query);
  if($count>0){
		$M=$row['COD_SUBMENU'];
		$suc=$row['COD_SUCURSAL'];  
		  
	$tpl-> assign_vars(array(		
			'CNT'   => utf8_encode($row['DESCRIPCION']),
			'LCL'   => $row['UBICACION_LOCAL'],
			'RMT'	=> $row['UBICACION_REMOTA'],
			'ID'	=> $_GET['id']
    ));
  }

//--------------------------------------------------------------------------------  
	
//////////////////////////////////MENU///////////////////////////////////////////
	$sql_e="SELECT B.COD_MENU, B.DESCRIPTION FROM SAVL4001 A
	INNER JOIN SAVL4000 B ON A.COD_MENU=B.COD_MENU
	WHERE A.COD_SUBMENU=".$M;
	$query_e = $db->sqlQuery($sql_e);
	$count_e = $db->sqlEnumRows($query_e);		
	$row_e=$db->sqlFetchArray($query_e);
	$MN=$row_e['COD_MENU'];

	$sql_f="SELECT COD_MENU, DESCRIPTION FROM SAVL4000";
	$query_f = $db->sqlQuery($sql_f);
	$count_f = $db->sqlEnumRows($query_f);
	
	if($count_f>0){
		
		while($row_f=$db->sqlFetchArray($query_f)){
			if($row_f['COD_MENU']==$MN){$S="selected='selected'";}else{$S="";}
			 $tpl->assign_block_vars('dt',array(
				'IDMN'	=> $row_f['COD_MENU'],
				'MN'	=> utf8_encode($row_f['DESCRIPTION']),
				'S'		=> $S
										));	
		}
	}
///////////////////////////////////SUBMENU/////////////////////////////////////////
	$sql_g="SELECT COD_SUBMENU, DESCRIPTION FROM SAVL4001 WHERE COD_MENU=".$MN;
	$query_g = $db->sqlQuery($sql_g);
	$count_g = $db->sqlEnumRows($query_g);
	if($count_g>0){
		while($row_g=$db->sqlFetchArray($query_g)){
			if($row_g['COD_SUBMENU']==$M){$S="selected='selected'";}else{$S="";}
			 $tpl->assign_block_vars('q',array(
				'IDSMN'	=> $row_g['COD_SUBMENU'],
				'SMN'	=> utf8_encode($row_g['DESCRIPTION']),
				'S'		=> $S
										));	
		}
	}
///////////////////////////////////EMPRESA/////////////////////////////////////////
	$sql_h="SELECT B.ID_EMPRESA, B.DESCRIPCION FROM ADMI1001 A
	INNER JOIN ADMI1000 B ON A.COD_EMPRESA=B.ID_EMPRESA
	WHERE A.COD_SUCURSAL =".$suc;
	$query_h = $db->sqlQuery($sql_h);
	$count_h = $db->sqlEnumRows($query_h);
	$row_h=$db->sqlFetchArray($query_h);
	$E=$row_h['ID_EMPRESA'];

	$sql_i="SELECT ID_EMPRESA, DESCRIPCION FROM ADMI1000";
	$query_i = $db->sqlQuery($sql_i);
	$count_i = $db->sqlEnumRows($query_i);
	
	if($count_i>0){
		
		while($row_i=$db->sqlFetchArray($query_i)){
			if($row_i['ID_EMPRESA']==$E){$S="selected='selected'";}else{$S="";}
			 $tpl->assign_block_vars('dt2',array(
				'IDEMP'	=> $row_i['ID_EMPRESA'],
				'EMP'	=> utf8_encode($row_i['DESCRIPCION']),
				'S'		=> $S
										));	
		}
	}
///////////////////////////////////SUCURSAL/////////////////////////////////////////	
	$sql_j="SELECT COD_SUCURSAL, DESCRIPTION FROM ADMI1001 WHERE COD_EMPRESA=".$E;
	$query_j = $db->sqlQuery($sql_j);
	$count_j = $db->sqlEnumRows($query_j);
	if($count_j>0){
		while($row_j=$db->sqlFetchArray($query_j)){
			if($row_j['COD_SUCURSAL']==$suc){$S="selected='selected'";}else{$S="";}
			 $tpl->assign_block_vars('q2',array(
				'IDSUC'	=> $row_j['COD_SUCURSAL'],
				'SUC'	=> utf8_encode($row_j['DESCRIPTION']),
				'S'		=> $S
										));	
		}
	}

$tpl->pparse('mEditar');
$db->sqlClose();
}
?>