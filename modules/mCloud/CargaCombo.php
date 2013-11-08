<?php
    header('Content-Type: text/html; charset=UTF-8');
 	$db  = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

  
    if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	
	 $UTF8 = "SET NAMES 'utf8'";
     $db->sqlQuery($UTF8);	
	
    $sqlZ = "SELECT CT.ID_CATALOGO,CT.DESCRIPCION FROM 
			CAT_CATALOGO CT INNER JOIN 
			CAT_CLIENTE_CATALOGO CCT ON CT.ID_CATALOGO = CCT.ID_CATALOGO 
			WHERE CCT.ID_CLIENTE = ".$userAdmin->user_info['ID_CLIENTE'];
			
	$queri = $db->sqlQuery($sqlZ);
	$count = $db->sqlEnumRows($queri);

	if($count>0){
		$tpl->set_filenames(array('CargaCombo' => 'tCombo'));
	        while($rowZ = $db->sqlFetchArray($queri)){
		      	$tpl->assign_block_vars('group',array(
							'ID_CATALOGO'   => $rowZ['ID_CATALOGO'],
							'DESCRTIPCION'  => $rowZ['DESCRIPCION']
					));
	          }
		$tpl->pparse('CargaCombo');
	}else{
		
		echo 0;
	}
     
		
?>
