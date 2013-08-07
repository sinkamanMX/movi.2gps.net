<?php
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}

	 $idu   = $userAdmin->user_info['COD_USER'];
	 $idc	= $userAdmin->user_info['COD_CLIENT'];
	 
require('phpqrcode/phpqrcode.php');
$url = $_GET['cadena'];
$img = "codigo.png";
QRcode::png($url, $img);  // Crea y guarda un png con el código QR
//echo "<image src = 'codigo.png'>";
//$Fecha=date("H:i:s");
$n=date("H:i:s").$idu.$idc;
$nn=str_replace(":","_",$n);

$file ='codigo.png';
//echo $file;
header("Content-disposition: attachment; filename=$nn$file");
header("Content-type: application/octet-stream");
readfile($file);
	 

?>