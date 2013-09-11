<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
 	
	$T=0;
	$ct='-';
	$cs=$_GET['nuws'];

	 $path=$_GET['ulr'];
	$cadena=explode('/',$path);
	$cadena2=explode('.',$cadena[count($cadena)-1]);
	 $cadena3=str_replace($cadena2[0],$cs,$path);
	
	if(!rename( $path,  $cadena3 )){
		
		$T=0;
		}else{
			
			$T=1;
			}
	
echo $T;
?>
