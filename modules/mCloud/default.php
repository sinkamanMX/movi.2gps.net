<?php
/* 
 *  @package             
 *  @name                Módulo Catalogos 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Daniel Arazo
 *  @modificado          23-04-2012
**/
	include("public/php/date.php");
	date_default_timezone_set('UTC');  
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	
	$sqlZ = "SELECT CT.ID_CATALOGO,CT.DESCRIPCION FROM 
			CAT_CATALOGO CT INNER JOIN 
			CAT_CLIENTE_CATALOGO CCT ON CT.ID_CATALOGO = CCT.ID_CATALOGO 
			WHERE CCT.ID_CLIENTE = ".$userAdmin->user_info['ID_CLIENTE'];
			
	$queri = $db->sqlQuery($sqlZ);


	      while($rowZ = $db->sqlFetchArray($queri)){
	      	$tpl->assign_block_vars('group',array(
						'ID_CATALOGO'   => $rowZ['ID_CATALOGO'],
						'DESCRTIPCION'  => $rowZ['DESCRIPCION']
				));
          }
	
	
	
	
	$tpl->set_filenames(array('default'=>'default'));	
	$idProfile   = $userAdmin->user_info['ID_PROFILE'];	
	
	$menu = ''; 

	$tpl->assign_vars(array(
		//'URL'           => $row_pm['UBICACION'],
		'PAGE_TITLE'	=> "Cloud",	
		'PATH'			=> $dir_mod,
		'PATH_IMG'		=> $dir_pimages,
		'CLIENTE'       => $userAdmin->user_info['ID_CLIENTE'],
/*		'NAME'			=> $userAdmin->codif($userAdmin->user_info['USER_NAME']),
		'MAIL'			=> $userAdmin->codif($userAdmin->user_info['USER_EMAIL']),
		'TYPE'			=> $userAdmin->codif($userAdmin->user_info['PRIVILEGES']),		
		'MENU'			=> $userAdmin->codif($menu),
		'APIKEY'		=> $config['keyapi'],*/
		'FECHA'       	=> fecha()
	));	
	$tpl->pparse('default');
?>