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
	
	$sqlX= "SELECT COD_EVENT,DESCRIPTION FROM ADM_EVENTOS
			WHERE ID_CLIENTE = ".$userAdmin->user_info['ID_CLIENTE'];
			
	$queriX = $db->sqlQuery($sqlX);
	      while($rowX = $db->sqlFetchArray($queriX)){
	      	$tpl->assign_block_vars('evento',array(
						'COD_EVENTO'   => $rowX['COD_EVENT'],
						'DESCRTIPCION'  => $rowX['DESCRIPTION']
				));
          }
	
	$conexiones_ftp_bd = "SELECT * FROM CAT_CATALOGO_BANDERA";
    $queri_conexiones_ftp_bd = $db->sqlQuery($conexiones_ftp_bd);	
	$row_ftp_bd = $db->sqlFetchArray($queri_conexiones_ftp_bd);
	
	$tpl->set_filenames(array('default'=>'default'));	
	$idProfile   = $userAdmin->user_info['ID_PROFILE'];	
	
	$menu = ''; 









	$tpl->assign_vars(array(
		//'URL'           => $row_pm['UBICACION'],
		'PAGE_TITLE'	=> "Cloud",	
		'PATH'			=> $dir_mod,
		'PATH_IMG'		=> $dir_pimages,
		'CLIENTE'       => $userAdmin->user_info['ID_CLIENTE'],
		'HOST'			=> $row_ftp_bd['HOST'],
		'USUARIO'		=> $row_ftp_bd['USUARIO'],
		'PASSWORD'		=> $row_ftp_bd['PASSWORD'],
		'BASE_NOMBRE'	=> $row_ftp_bd['BASE_NOMBRE'],
		'FTP_HOST'		=> $row_ftp_bd['FTP_HOST'],
		'FTP_USUARIO'	=> $row_ftp_bd['FTP_USUARIO'],
		'FTP_PASS'		=> $row_ftp_bd['FTP_PASS'],
		'FTP_PUERTO'	=> $row_ftp_bd['FTP_PUERTO'],
		'EXTENSIONES'	=> $row_ftp_bd['EXTENSIONES'],
		'EXTENSIONES_M'	=> $row_ftp_bd['EXTENSIONES_MULTIMEDIA'],
/*		'NAME'			=> $userAdmin->codif($userAdmin->user_info['USER_NAME']),
		'MAIL'			=> $userAdmin->codif($userAdmin->user_info['USER_EMAIL']),
		'TYPE'			=> $userAdmin->codif($userAdmin->user_info['PRIVILEGES']),		
		'MENU'			=> $userAdmin->codif($menu),
		'APIKEY'		=> $config['keyapi'],*/
		'FECHA'       	=> fecha()
	));	
	$tpl->pparse('default');
?>