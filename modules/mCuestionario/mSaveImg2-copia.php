<?php	
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

ini_set("memory_limit","1000M");
Header("Content-type: image/jpeg");
// Tipo de contenido




//------------------------------------------------
///echo $_GET['img'].",".$_GET['grd'];
   echo $fotos = '/var/www/vhosts/2gps.net/subdominios/movi'.$_GET['img'];
    $angulos = -1*$_GET['grd'];
    $ruta_imagen = $fotos;
    $imagen_ori = imagecreatefromjpeg($ruta_imagen);
    //$imagen_original = imagerotate($imagen_ori, $angulos, 0);
	$imagen_rotada = imagerotate($imagen_ori, $angulos, 0);
    //$ancho_original = imagesx($imagen_original);
    //$alto_original = imagesy($imagen_original);
    //$ancho_final = 500;//($alto_original/2);
    //$alto_final  = 600;//($ancho_original/2); //($ancho_final / $ancho_original) * $alto_original;
    //$imagen_redimensionada = imagecreatetruecolor($alto_final, $ancho_final);


    //imagecopyresized($imagen_redimensionada, $imagen_original, 0, 0, 0, 0, $alto_final, $ancho_final, $ancho_original, $alto_original);
	//imagecopyresized($imagen_redimensionada, $imagen_original, 0, 0, 0, 0, $alto_final, $ancho_final, $ancho_original, $alto_original);
    //if(imagejpeg($imagen_redimensionada, $fotos)){
	
	if(imagejpeg($imagen_rotada, $fotos)){	
		imagedestroy($imagen_original);
		//imagedestroy($imagen_redimensionada);
		imagedestroy($imagen_rotada);
		echo 1;
		}
    else{
		echo 0;
		}
    
?>