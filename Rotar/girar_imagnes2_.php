<?php



// Establecer un ancho y alto máximo
$ancho = 20;
$alto  = 20;
$grados = 90;

// Tipo de contenido
header('Content-Type: image/jpeg');


//------------------------------------------------

    $fotos = 'http://movi.2gps.net/public/evidencia/foto_4.jpg';
    $angulos = 90;
    $ruta_imagen = $fotos;
    $imagen_ori = imagecreatefromjpeg($ruta_imagen);
    $imagen_original = imagerotate($imagen_ori, $angulos, 0);
    $ancho_original = imagesx($imagen_original);
    $alto_original = imagesy($imagen_original);
    $ancho_final = 500;//($alto_original/2);
    $alto_final  = 600;//($ancho_original/2); //($ancho_final / $ancho_original) * $alto_original;
    $imagen_redimensionada = imagecreatetruecolor($alto_final, $ancho_final);


    imagecopyresized($imagen_redimensionada, $imagen_original, 0, 0, 0, 0, $alto_final, $ancho_final, $ancho_original, $alto_original);
    imagejpeg($imagen_redimensionada, $fotos);
    imagedestroy($imagen_original);
    imagedestroy($imagen_redimensionada);
    echo "se modifico 5 " . $fotos . '|' . $angulos . '|' . $imagen_ori;
?>