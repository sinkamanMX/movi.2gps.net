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
    
    //$path2=$_GET['ulr'];
	$path    = ($_GET['ulr']);
	$cadena  = explode('/',$path);
	$cadena2 = explode('.',$cadena[count($cadena)-1]);
	$cadena3 = str_replace($cadena2[0],$cs,$path);
	
	
	
	 if($_GET['v1']==='0' && $_GET['v2']==='99'){
	     $x_clave = explode("/",$_GET['ulr']);
		 $x_id_menu = explode("_",$x_clave[count($x_clave)-1]);
	     $cadena3 = $cadena3.'_'.$x_id_menu[count($x_id_menu)-1];
	 }
	
	echo '****'.$_GET['v1'].'****'.$_GET['v2'].'******'.$path.'++++++'.$cadena3.'******';
	
	if(!rename( reemplaza(str_replace(" ","_",utf8_decode($path))), reemplaza(str_replace(" ","_",utf8_decode($cadena3))))){
		echo "pos no se cambio";
		$T=0;
		}else{
		 echo 'segun su cambio';
		 
		 if($_GET['v1']==='0' && $_GET['v2']==='1'){
		    $T = actualiza_menu($_GET['id_menu'],$cs);
		 }
		 if($_GET['v1']==='0' && $_GET['v2']==='99'){
		    $id_ss = $x_id_menu[count($x_id_menu)-1];
		 	$T = actualiza_submenu($_GET['id_menu'],$cs,$id_ss);
		 }
			
		}
	
echo $T;    //. $path .'|'.$cadena3;


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
function actualiza_submenu($x,$dato,$ids){
	global $db;
$sqlZ = "UPDATE CAT_SUBMENU SET DESCRIPTION2='".reemplaza(str_replace(" ","_",utf8_decode($dato.'_'.$ids)))."' , DESCRIPTION='".$dato."' WHERE ID_SUBMENU = ".$x;
	$queri = $db->sqlQuery($sqlZ);

	if($queri){
	   if(actualiza_contenido($x,reemplaza(str_replace(" ","_",utf8_decode($dato.'_'.$ids))),2)){
   	      return 1;
	   }else{
	     return 'NO CONTENIDO'.$x.'|'.reemplaza(str_replace(" ","_",utf8_decode($dato.'_'.$ids)));
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
	$busca = "SELECT A.ID_MENU ,A.DESCRIPTION,B.DESCRIPTION,C.ID_SUBMENU,C.UBICACION_REMOTA,C.DESCRIPCION,C.ORDEN FROM CAT_CONTENIDO C
				INNER JOIN CAT_SUBMENU B ON B.ID_SUBMENU = C.ID_SUBMENU
				INNER JOIN CAT_MENU A ON A.ID_MENU = B.ID_MENU
				WHERE A.ID_MENU =".$x;
}else{
	$busca = "SELECT UBICACION_REMOTA,ORDEN,ID_SUBMENU FROM CAT_CONTENIDO WHERE ID_SUBMENU=".$x;
}
// $busca = "SELECT UBICACION_REMOTA,ORDEN,ID_SUBMENU FROM CAT_CONTENIDO WHERE ID_SUBMENU=".$x;
   $queriS = $db->sqlQuery($busca);
   	$count = $db->sqlEnumRows($queriS);

  if($count>0){	
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
   
//			   $complemento.'|'.'***** aki va menu *****|'.$liga[count($liga) -2].'|'.$liga[count($liga) -1]
		   $CAMBIA = "UPDATE CAT_CONTENIDO SET UBICACION_REMOTA = '".
		              $complemento.'/'.$dato.'/'.$liga[count($liga) -2].'/'.$liga[count($liga) -1].
					  "' WHERE ID_SUBMENU =".$rowa['ID_SUBMENU']." AND ORDEN =".$rowa['ORDEN'];
	       $SI = $db->sqlQuery($CAMBIA);
		   
		   if($SI){
		   	 echo ' si se actualizo MENU ['.$x.'-'.$dato.'-'.$valor.'-'.$rowa['UBICACION_REMOTA'].'] con ******* '.
			        $complemento.'/'.$dato.'/'.$liga[count($liga) -2].'/'.$liga[count($liga) -1].'****';
		     $bandera = 1;
			 //$complemento = '';
		   }else{
		    echo 'fallo update ne ubicacion remota'.$CAMBIA;
		   }
		   				  
		}  
	 }else{   // submenu
	// echo ' si se actualizo SUBMENU ['.$x.'-'.$dato.'-'.$valor.'-'.$rowa['UBICACION_REMOTA'].']';
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
			   
			   
			   //$complemento.'|'.$liga[count($liga) -3].'|'.'**** aki submenu ***** |'.$liga[count($liga) -1]
			   
		   $CAMBIA = "UPDATE CAT_CONTENIDO SET UBICACION_REMOTA = '".
		    $complemento.'/'.$liga[count($liga) -3].'/'.$dato.'/'.$liga[count($liga) -1].
			"' WHERE ID_SUBMENU =".$x." AND ORDEN =".$rowa['ORDEN'];
	    
		   $SI = $db->sqlQuery($CAMBIA);
		   if($SI){
		   		 echo ' si se actualizo SUBMENU ['.$x.'-'.$dato.'-'.$valor.'-'.$rowa['UBICACION_REMOTA'].'] con '.
				 $complemento.'/'.$liga[count($liga) -3].'/'.$dato.'/'.$liga[count($liga) -1];
		     $bandera = 1;
			 $complemento = '';
		   }else{
		    echo 'fallo update 2 ne ubicacion remota'.$CAMBIA;
		   }
		   		   
		
	 }
	
	// return 1;
   }
   

     }else{
	  echo 'fallo';
     }
  }else{
    return 1;
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
