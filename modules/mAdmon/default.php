<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo silver 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          23-04-2012
**/
	
	date_default_timezone_set('UTC');  
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	/*if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';*/
	
	$tpl->set_filenames(array('default'=>'default'));	
	$idProfile   = $userAdmin->user_info['ID_PROFILE'];	
	

		 

	$tpl->assign_vars(array(
		//'URL'           => $row_pm['UBICACION'],
		'PAGE_TITLE'	=> "Planeaci&oacute;n de rutas",	
		'PATH'			=> $dir_mod,
		'PATH_IMG'		=> $dir_pimages,
		'NAME'			=> $userAdmin->user_info['USER_NAME'],
		'MAIL'			=> $userAdmin->user_info['USER_EMAIL'],
		'TYPE'			=> $userAdmin->user_info['PRIVILEGES'],		
		//'MENU'			=> $menu),
		'APIKEY'		=> $config['keyapi'],
		//'FECHA'       	=> fecha(),
		'COD_USER' 		=> $userAdmin->user_info['COD_USER'],

		'COD_CLI'	 	=> $userAdmin->user_info['COD_CLIENT']
		/*'B'			    => $row['BODY'],
		'PIE'			=> $row['FOOT'],
		'PIEC'			=> $row['FOOT_CONTENT'], 
		'READ'			=> $R, 
		'WRITE'			=> $W, 
		'EXPORT'		=> $E, 
		'DELETE'		=> $D, 
		'UPDATE'		=> $U,
		'RM'			=> $RM,
		'UP'			=> $UB*/
	));	

	$tpl->pparse('default');
?>