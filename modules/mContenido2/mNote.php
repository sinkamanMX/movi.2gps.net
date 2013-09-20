<?php
header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}		
		
$tpl->set_filenames(array('mNote' => 'tNote'));

////////////////////////////////////////////////////////////////////////////
//echo $_GET['op'];
 $sql_m="SELECT D.ID_TIPO, D.DESCRIPCION FROM DSP_TIPO_NOTA D";
	$query_m = $db->sqlQuery($sql_m);
	$count_m = $db->sqlEnumRows($query_m);
			
				 $tpl->assign_vars(array(
				'OP'	=> $_GET['op']
										));	
										
	if($count_m>0){
		
		while($row_m=$db->sqlFetchArray($query_m)){
			 $tpl->assign_block_vars('tn',array(
				'IDT'	=> $row_m['ID_TIPO'],
				'TNT'	=> utf8_encode($row_m['DESCRIPCION'])
										));	
		}
	}	
$tpl->pparse('mNote');
$db->sqlClose();
?>