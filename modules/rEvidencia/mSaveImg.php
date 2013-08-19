<?php
//define image path
$filename = $_GET['img'];
$degrees = $_GET['grd'];
// Load the image
if($source = imagecreatefromjpeg($filename)){echo 1;}else{echo 0;}


// Rotate
if($rotate = imagerotate($source, $degrees, 0)){echo 2;}else{echo -1;}

//and save it on your server...

//if(file_put_contents($filename,$rotate)){
if(file_put_contents("prueba.jpg",$rotate)){	
	echo 1;
	}
else{
	echo 0;
	}	
?>