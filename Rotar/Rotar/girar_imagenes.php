<?php

/*
*  @package             4togo
*  @name                Muestra los grupos creados por el usuario
*  @version             1
*  @copyright           Air Logistics & GPS S.A. de C.V.   
*  @author              Daniel Arazo
*  @modificado          13-12-2010
**/
header('Content-type: image/jpeg');
$fotos = 'img/1.jpg';
$angulos = 90;


	$src_img = imagecreatefromjpeg($fotos);
    $srcsize = getimagesize($fotos);
   
  // if($srcsize[0]>1800){
    $dest_x = $srcsize[0] ;
    $dest_y = $srcsize[1] ;
    $dst_img = imagecreatetruecolor($dest_x, $dest_y);

    imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $dest_x, $dest_y, $srcsize[0], $srcsize[1]);
    imagejpeg($dst_img,$fotos);
    imagedestroy($src_img);
    imagedestroy($dst_img);
    //}
  
/*

    $ruta_imagen = $fotos;
    $imagen_ori = imagecreatefromjpeg($ruta_imagen);
    $imagen_original = imagerotate($imagen_ori, $angulos, 0);
    $ancho_original = imagesx($imagen_original);
    $alto_original = imagesy($imagen_original);
    $ancho_final = $alto_original;
    $alto_final  = $ancho_original; //($ancho_final / $ancho_original) * $alto_original;
    $imagen_redimensionada = imagecreatetruecolor($alto_final, $ancho_final);
*/
//imagejpeg($imagen_original);
?>