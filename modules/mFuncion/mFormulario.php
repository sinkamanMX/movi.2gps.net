<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
		
	$db ->sqlQuery("SET NAMES 'utf8'");
	
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	
	$tpl->set_filenames(array('mFormulario' => 'tFormulario'));
	
	if($_GET['op']==2){
		$fun = $dbf->getRow('ADM_FUNCION','ID_FUNCION = '.$_GET['id']);
		//````````
		$nom = @$fun['NOMBRE'];
		$des = @$fun['DESCRIPCION'];
		$fnc = @$fun['FUNCION'];
		$pub = (@$fun['TIPO']=="PUB")?'selected="selected"':'';
		$pri = (@$fun['TIPO']=="PRI")?'selected="selected"':'';
		$tpl->assign_vars(array(
			'NOM'      	=> $nom,
			'DES'		=> $des,
			'FNC'      	=> $fnc,
			'PUB'		=> $pub,
			'PRI'      	=> $pri
			));
		}

	$tpl->assign_vars(array(
	'ID'      	=> $_GET['id'],
	'OP'		=> $_GET['op']
	));
	$tpl->pparse('mFormulario');	
?>	