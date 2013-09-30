<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
 	$db  = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

     $UTF8 = "SET NAMES 'utf8'";
     $db->sqlQuery($UTF8);
    

	$T=0;
	$ct='-';
	$cs=$_GET['nuws'];
    
	 $path=$_GET['ulr'];
	$cadena=explode('/',$path);
	$cadena2=explode('.',$cadena[count($cadena)-1]);
	 $cadena3=str_replace($cadena2[0],$cs,$path);
	
	if(!rename( $path, str_replace(" ","-",$cadena3) )){
		
		$T=0;
		}else{
		 if($_GET['v1']==='0' && $_GET['v2']==='1'){
		  $T = actualiza_menu($_GET['id_menu'],$cs);
		 }
		 if($_GET['v1']==='0' && $_GET['v2']==='99'){
		 	$T = actualiza_submenu($_GET['id_menu'],$cs);
		 }
			
		}
	
echo $T;


function actualiza_menu($x,$dato){
	global $db;
	$sqlZ = "UPDATE CAT_MENU  SET DESCRIPTION='".str_replace(" ","-",$dato)."'  WHERE ID_MENU = ".$x;
	$queri = $db->sqlQuery($sqlZ);

	if($queri){
   	return 1;
   	}else{
    return 0;	
   	}
	
}
function actualiza_submenu($x,$dato){
	global $db;
	$sqlZ = "UPDATE CAT_SUBMENU SET DESCRIPTION='".str_replace(" ","-",$dato)."' WHERE ID_SUBMENU = ".$x;
	$queri = $db->sqlQuery($sqlZ);

	if($queri){
   	return 1;
   	}else{
    return 0;	
   	}
	
}


?>
