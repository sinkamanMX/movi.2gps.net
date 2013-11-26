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
    $x_id_menu = '';
    //$path2=$_GET['ulr'];
	//$path    = ($_GET['ulr']);                               // ruta real a cambiar de nombre en el servidor
	//$cadena  = explode('/',$path);                           // cortar en partes la url por el caracter '/'
	//$cadena2 = explode('.',$cadena[count($cadena)-1]);
	//$cadena3 = str_replace($cadena2[0],$cs,$path);
	
	$la_nueva_ruta = '';
	
	if($_GET['v1']==='0' && $_GET['v2']==='1'){
		$la_nueva_ruta = $_GET['nuws'];
     }
	 if($_GET['v1']==='0' && $_GET['v2']==='99'){
	     $x_clave = explode("/",$_GET['ulr']);
		 $x_id_menu = explode("_",$x_clave[count($x_clave)-1]);
		 $la_nueva_ruta = $_GET['nuws'].'_'.$x_id_menu[count($x_id_menu)-1];
	 }
	
	
//	if(!rename( reemplaza(str_replace(" ","_",utf8_decode($path))), reemplaza(str_replace(" ","_",utf8_decode($cadena3))))){
if(!rename( $_GET['ulr'], reemplaza(str_replace(" ","_",utf8_decode($la_nueva_ruta))))){	
		echo "pos no se cambio";
		$x_id_menu = explode("_",$x_clave[count($x_clave)-1]);
echo 'v1= '.$_GET['v1'].' v2='.$_GET['v2'].' nombre'.$x_clave[count($x_clave)-1].' id_menu'.$x_id_menu[count($x_id_menu)-1].' | cambiar = '.$_GET['ulr'].' | por ='.$la_nueva_ruta;
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
//. $path .'|'.$cadena3;


function actualiza_menu($x,$dato){
	global $db;
	$sqlZ = "UPDATE CAT_MENU  SET DESCRIPTION2='".reemplaza(str_replace(" ","_",utf8_decode($dato)))."', DESCRIPTION='".$dato."'  WHERE ID_MENU = ".$x;
	$queri = $db->sqlQuery($sqlZ);

	if($queri){
	  if(actualiza_contenido($x,reemplaza(str_replace(" ","_",utf8_decode($dato))),1)){
   	      return 1;
	   }else{
	     return 0;
	   }
   	}else{
    return 0;	
   	}
	
}
function actualiza_submenu($x,$dato){
	global $db;
$sqlZ = "UPDATE CAT_SUBMENU SET DESCRIPTION2='".reemplaza(str_replace(" ","_",utf8_decode($dato.'_'.(count($x_id_menu)-1))))."' , DESCRIPTION='".$dato."' WHERE ID_SUBMENU = ".$x;
	$queri = $db->sqlQuery($sqlZ);

	if($queri){
	   if(actualiza_contenido($x,reemplaza(str_replace(" ","_",utf8_decode($dato.'_'.(count($x_id_menu)-1)))),2)){
   	      return 1;
	   }else{
	     return 0;
	   }
   	}else{
    return 0;	
   	}
	
}

function actualiza_contenido($x,$dato,$valor){
 global $db;
 $cont = 0;
 $bandera = 0;
 $complemento ='';

if($valor==1){
	$busca = "SELECT A.ID_SUBMENU, A.UBICACION_REMOTA,ORDEN FROM CAT_CONTENIDO A
				INNER JOIN CAT_SUBMENU B ON A.ID_SUBMENU = B.ID_SUBMENU
				INNER JOIN CAT_MENU C ON C.ID_MENU = B.ID_MENU
				WHERE C.ID_MENU = ".$x;
}else{
	$busca = "SELECT UBICACION_REMOTA,ORDEN,ID_SUBMENU FROM CAT_CONTENIDO WHERE ID_SUBMENU=".$x;
}
// $busca = "SELECT UBICACION_REMOTA,ORDEN,ID_SUBMENU FROM CAT_CONTENIDO WHERE ID_SUBMENU=".$x;
   $queriS = $db->sqlQuery($busca);
   if($queriS){
   	
     if($valor==1){ // menu
     //$rowa  = $db->sqlFetchArray($queriS);
     	
	    while($rowa  = $db->sqlFetchArray($queriS)){
		 	  $liga = explode("/",$rowa['UBICACION_REMOTA']);

			  for($z=0;$z<count($liga);$z++){
				 if($cont < (count($liga) -3)){
				  $cont = $cont +1;
				   if($complemento == ''){   
					$complemento = $liga[$z];
				   }else{
					$complemento = $complemento.'/'.$liga[$z];
				   }
				 }
			   }
			   
		   $CAMBIA = "UPDATE CAT_CONTENIDO SET UBICACION_REMOTA = '".
		              $complemento.'/'.$dato.'/'.$liga[count($liga) -2].'/'.$liga[count($liga) -1].
					  "' WHERE ID_SUBMENU =".$rowa['ID_SUBMENU']." AND ORDEN =".$rowa['ORDEN'];
	       $SI = $db->sqlQuery($CAMBIA);
		   
		   if($SI){
		   	 echo ' si se actualizo MENU ['.$x.'-'.$dato.'-'.$valor.'-'.$rowa['UBICACION_REMOTA'].']';
		     $bandera = 1;
			 $complemento = '';
		   }
		   				  
		}  
	 }else{   // submenu
	// echo ' si se actualizo SUBMENU ['.$x.'-'.$dato.'-'.$valor.'-'.$rowa['UBICACION_REMOTA'].']';
	   while($rowa  = $db->sqlFetchArray($queriS)){
		 	  $liga = explode("/",$rowa['UBICACION_REMOTA']);

			  for($z=0;$z<count($liga);$z++){
				 if($cont < (count($liga) -2)){
				  $cont = $cont +1;
				   if($complemento == ''){   
					$complemento = $liga[$z];
				   }else{
					$complemento = $complemento.'/'.$liga[$z];
				   }
				 }
			   }
			   
		   $CAMBIA = "UPDATE CAT_CONTENIDO SET UBICACION_REMOTA = '".
		    $complemento.'/'.$liga[count($liga) -3].'/'.$dato.'/'.$liga[count($liga) -1]."' WHERE ID_SUBMENU =".$x." AND ORDEN =".$rowa['ORDEN'];
	       $SI = $db->sqlQuery($CAMBIA);
		   if($SI){
		   		 echo ' si se actualizo SUBMENU ['.$x.'-'.$dato.'-'.$valor.'-'.$rowa['UBICACION_REMOTA'].']';
		     $bandera = 1;
			 $complemento = '';
		   }
		   		   
		
	 }
	
	// return 1;
   }
   

}else{
	echo 'fallo';
}

}
//_________________________________________________

function reemplaza($cadena_x){
$regresa = '';
$a = array('á','Á','é','É','í','Í', 'ó','Ó', 'ú','Ú', 'ñ', 'Ñ',' ');
$b = array('a','A','e','E','i','I', 'o' ,'O', 'u','U', 'n', 'N', '_');

$regresa = str_replace($a, $b,$cadena_x);
return $regresa;
}
	
?>
