<?php
/*              
 *  @name                Formulario para unidad de medida
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Daniel Arazo
 *  @modificado          2013-11-27
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
		
	$db ->sqlQuery("SET NAMES 'utf8'");
	
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	
	$tpl->set_filenames(array('mFormulario' => 'tFormulario'));
	
	if($_GET['op']==2){
		$fun = $dbf->getRow('PED_UNIDAD_MEDIDA','ID_UNIDAD_MEDIDA = '.$_GET['id']);
		//````````
		$nom = @$fun['DESCRIPCION_UNIDAD'];
		$tpl->assign_vars(array(
			'NOM'      	=> $nom,
		  ));
		}

	$tpl->assign_vars(array(
	'ID'      	=> $_GET['id'],
	'OP'		=> $_GET['op']
	));
	$tpl->pparse('mFormulario');	
?>	