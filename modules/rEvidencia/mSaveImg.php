<?php	
// Tipo de contenido
header('Content-Type: image/jpeg');


//------------------------------------------------
//echo $_GET['img'].",".$_GET['grd'];
    $fotos = '/var/www/vhosts/2gps.net/subdominios/movi/'.$_GET['img'];
    $angulos = -1*$_GET['grd'];
    $ruta_imagen = $fotos;
    $imagen_ori = imagecreatefromjpeg($ruta_imagen);
    $imagen_original = imagerotate($imagen_ori, $angulos, 0);
    $ancho_original = imagesx($imagen_original);
    $alto_original = imagesy($imagen_original);
    $ancho_final = 500;//($alto_original/2);
    $alto_final  = 600;//($ancho_original/2); //($ancho_final / $ancho_original) * $alto_original;
    $imagen_redimensionada = imagecreatetruecolor($alto_final, $ancho_final);


    imagecopyresized($imagen_redimensionada, $imagen_original, 0, 0, 0, 0, $alto_final, $ancho_final, $ancho_original, $alto_original);
    if(imagejpeg($imagen_redimensionada, $fotos)){
		imagedestroy($imagen_original);
		imagedestroy($imagen_redimensionada);
		echo 1;
		}
    else{
		echo 0;
		}
    
?>