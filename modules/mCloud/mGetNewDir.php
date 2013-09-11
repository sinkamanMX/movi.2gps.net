<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
 	
	$T=0;
	$ct='-';
	$cs='*';
	//echo $directorio=dirname(__FILE__).'/Raiz/ragde18@hotmail.es';
	$cadena='';
	$down='/modules/mCloud/Raiz/ragde18@hotmail.es/';
	echo $path=$_GET['ulr'];
	
	if(!mkdir( $path, 0777, true )){
		
		$T=0;
		}else{
			
			$T=1;
			}
	
echo $T;
?>
