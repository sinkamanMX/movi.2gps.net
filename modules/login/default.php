<?php
/*
 *  @package             
 *  @name                Pagina default del modulo login  
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27-04-2011
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
		
	if($userAdmin->u_logged()){
		echo '<script>window.location="index.php?m=mMonitoreo"</script>';
	}

	$tpl->set_filenames(array('default'=>'default'));
	
	$tpl->assign_vars(array(
		'PAGE_TITLE'	=> 'Bienvenido',
		'B'			    => $row['BODY']
	));

	$tpl->pparse('default');
?>