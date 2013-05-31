<?php
/** * 
 *  @package             
 *  @name                Indice del modulo
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27-04-2011
**/
	$tpl = new Template('modules/'.$_GET['m'].'/template');
	$dir_mod 	 = 'modules/'.$_GET['m'].'/template';
	$dbf         = new dbFunctions();
	
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$userData = new usersAdministration();
	if(!$userAdmin->u_logged()){
			echo '<script>window.location="index.php?m=login"</script>';
	}
	$validate = $dbf->getRow('ADM_USUARIOS_SUPER',' ID_USUARIO = '.$userAdmin->user_info['ID_USUARIO']);
	$s_admin  = ($validate) ? true: false;
	
	if(isset($_GET['c'])){
		$filename = $config['modules']."".$_GET['m']."/".$_GET['c'].'.php';
		if(file_exists($filename)){
			if($userAdmin->validar_submenu($_GET['m'],null,$s_admin)){
				include $filename;
			}else{
				echo "<script>window.location='errors/index.php?e=error444';</script>";	
			}
		}else{
			echo "<script>window.location='errors/index.php?e=error404';</script>";
		}
	}else{
		echo "<script>window.location='index.php?m=".$_GET['m']."&c=default';</script>";
	}	
?>