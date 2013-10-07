<?php
// El archivo
$nombre_archivo = 'prueba.jpg';
$porcentaje = 2.9;

// Tipo de contenido
header('Content-Type: image/jpeg');

// Obtener nuevas dimensiones
list($ancho, $alto) = getimagesize($nombre_archivo);
$nuevo_ancho = $ancho * $porcentaje;
$nuevo_alto = $alto * $porcentaje;

// Redimensionar
$imagen_p = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
$imagen = imagecreatefromjpeg($nombre_archivo);
imagecopyresampled($imagen_p, $imagen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);

// Imprimir
imagejpeg($imagen_p, null, 100);
?>