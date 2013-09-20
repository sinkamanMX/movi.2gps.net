<?php
/** * 
 *  @package             4togo
 *  @name                Muestra los grupos creados por el usuario
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Daniel Arazo
 *  @modificado          13-12-2010
**/	

header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

	if(isset($_GET['img']) && isset($_GET['grd'])){	
			ini_set("memory_limit","1000M");
			Header("Content-type: image/jpeg");
	//		$ang = 90;
		   //$fotos = '/var/www/vhosts/2gps.net/subdominios/movi/public/evidencia/211481116202.jpg';
		   
			 $ang = $_GET['grd'];
             $fotos = '/var/www/vhosts/2gps.net/subdominios/movi'.$_GET['img'];
		    
			$angulos = intval($ang);
			
			if($angulos < 0){
				$angulos = abs($angulos);
			}else{
				$angulos = (-1 * $angulos);
			}
			
			
			
			echo $angulos;
			
			$ruta_imagen = $fotos;
			$imagen_ori = imagecreatefromjpeg($ruta_imagen);
			$imagen_original = imagerotate($imagen_ori,$angulos,0);
			$ancho_original  = imagesx($imagen_original);
			$alto_original   = imagesy($imagen_original);
			$ancho_final = $ancho_original;
			$alto_final = $alto_original;//($ancho_final / $ancho_original) * $alto_original;
			$imagen_redimensionada = imagecreatetruecolor($ancho_final, $alto_final);
			
			imagecopyresampled($imagen_redimensionada, $imagen_original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho_original, $alto_original);
			imagejpeg($imagen_redimensionada,$fotos);
			imagedestroy($imagen_original);
			imagedestroy($imagen_redimensionada);
			//echo "se modifico 5 ".$fotos.'|'.$angulos.'|'.$imagen_ori;
	}else{
			echo 0;	
	}
?>