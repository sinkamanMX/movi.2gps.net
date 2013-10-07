<?php
/*
ini_set("memory_limit", "1000M");
Header("Content-type: image/jpeg");
$imagen = 'img/no_diponible.jpg';
$grados = 90;

    $ruta_imagen     = $imagen;
    $imagen_ori      = imagecreatefromjpeg($imagen);
    $imagen_original = imagerotate($imagen_ori, $grados, 0);
    $ancho_original  = imagesx($imagen_original);
    $alto_original   = imagesy($imagen_original);
    $ancho_final     = $ancho_original;
    $alto_final      = $alto_original; //($ancho_final / $ancho_original) * $alto_original;
    
    $imagen_redimensionada = imagecreatetruecolor($ancho_final, $alto_final);

    imagecopyresampled($ruta_imagen, $imagen_original, 0, 0, 0, 0, $ancho_final,$alto_final, $ancho_original, $alto_original);
    imagejpeg($ruta_imagen);
  //  imagedestroy($imagen_original);
  //  imagedestroy($imagen_redimensionada);

*/
//------------------------------------------------


// El archivo
$nombre_archivo = 'img/1.jpg';

// Establecer un ancho y alto máximo
$ancho = 20;
$alto  = 20;
$grados = 90;

// Tipo de contenido
header('Content-Type: image/jpeg');
/*
// Obtener las nuevas dimensiones
list($ancho_orig, $alto_orig) = getimagesize($nombre_archivo);

$ratio_orig = $ancho_orig/$alto_orig;

if ($ancho/$alto > $ratio_orig) {
   $ancho = $alto*$ratio_orig;
} else {
   $alto = $ancho/$ratio_orig;
}

$image = imagecreatefromjpeg($nombre_archivo);
$rotar = imagerotate($image, $grados, 0);
$image_p = imagecreatetruecolor($ancho, $alto);
imagecopyresampled($image_p, $rotar, 0, 0, 0, 0, $ancho, $alto, $ancho_orig, $alto_orig);

imagejpeg($image_p,$nombre_archivo);
imagedestroy($image);
imagedestroy($image_p);
*/

//------------------------------------------------

    $fotos = 'img/1.jpg';
    $angulos = 90;
    $ruta_imagen = $fotos;
    $imagen_ori = imagecreatefromjpeg($ruta_imagen);
    $imagen_original = imagerotate($imagen_ori, $angulos, 0);
    $ancho_original = imagesx($imagen_original);
    $alto_original = imagesy($imagen_original);
    $ancho_final = 500;//($alto_original/2);
    $alto_final  = 600;//($ancho_original/2); //($ancho_final / $ancho_original) * $alto_original;
    $imagen_redimensionada = imagecreatetruecolor($alto_final, $ancho_final);

 //  imagecopyresampled($imagen_redimensionada, $imagen_original, 0, 0, 0, 0, $alto_final,$ancho_final, $ancho_original, $alto_original);
    imagecopyresized($imagen_redimensionada, $imagen_original, 0, 0, 0, 0, $alto_final, $ancho_final, $ancho_original, $alto_original);
    imagejpeg($imagen_redimensionada, $fotos);
    imagedestroy($imagen_original);
    imagedestroy($imagen_redimensionada);
    echo "se modifico 5 " . $fotos . '|' . $angulos . '|' . $imagen_ori;
?>