<?php
/**  
 * Script encargado de evaluar las peticiones
 * @package dahsboard
 * @author	Enrique R. Peña Gonzalez
 * @since	2013-07-22
 */
 
$tpl = new Template('modules/'.$_GET['m'].'/template');
$dir_pimages = "public/images";
$dir_mod 	 = 'modules/'.$_GET['m'].'/template';
$dbf         = new dbFunctions();


$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);		
if(!$userAdmin->u_logged())
	echo '<script>window.location="index.php?m=login"</script>';
	
if(isset($_GET['c'])){
	$filename = $config['modules']."".$_GET['m']."/".$_GET['c'].'.php';
	if(file_exists($filename)){
		include $filename;
	}else{
		echo "<script>window.location='errors/index.php?e=error404';</script>";
	}
}else{
	echo "<script>window.location='index.php?m=".$_GET['m']."&c=default';</script>";
}	
?>