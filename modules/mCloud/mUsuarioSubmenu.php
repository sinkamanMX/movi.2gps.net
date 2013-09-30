<?php
    header('Content-Type: text/html; charset=UTF-8');
 	$db  = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

  
    if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	
    $sqlZ = "SELECT B.ID_USUARIO,B.NOMBRE_COMPLETO FROM CAT_USUARIO_SUBMENU A
		     INNER JOIN ADM_USUARIOS B ON A.ID_USUARIO=B.ID_USUARIO
			 WHERE A.ID_SUBMENU = ".$_GET['id_submenu']." AND B.ID_CLIENTE = ".$userAdmin->user_info['ID_CLIENTE'];
			
	$queri = $db->sqlQuery($sqlZ);
	$count = $db->sqlEnumRows($queri);

	if($count>0){
		$tpl->set_filenames(array('mUsuarioSubmenu' => 'tUsuSubMenu'));
	        while($rowZ = $db->sqlFetchArray($queri)){
		      	$tpl->assign_block_vars('submenu',array(
							'ID_SUBMENU' => $rowZ['ID_USUARIO'],
							'NOMBRE'     => $rowZ['NOMBRE_COMPLETO']
					));
	          }
		$tpl->pparse('mUsuarioSubmenu');
	}else{
	   echo 0;
	}
     
		
?>
