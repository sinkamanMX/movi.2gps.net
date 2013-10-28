<?php
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}

//$db ->sqlQuery("SET NAMES 'utf8'");

//echo utf8_decode($_GET['cadena']);
	 //$idu   = $userAdmin->user_info['COD_USER'];
	 //$idc	= $userAdmin->user_info['COD_CLIENT'];

//echo $n=date("Y_m_d_H_i_s");
	$db ->sqlQuery("SET NAMES 'utf8'"); 
require('phpqrcode/phpqrcode.php');
/*$url = utf8_decode($_GET['cadena']);
$img = "codigo.png";
QRcode::png($url, $img);  // Crea y guarda un png con el código QR
//echo "<image src = 'codigo.png'>";
//$Fecha=date("H:i:s");
//$n=date("H:i:s").$idu.$idc;
$n=date("Ymd_His");
//$nn=str_replace(":","_",$n);

$file = $n.'codigo.png';
//echo $file;
header("Content-disposition: attachment; filename=$file");
header("Content-type: application/octet-stream");
readfile($file);*/

 //$param = $_GET['id']; // remember to sanitize that - it is user input! 
     
    // we need to be sure ours script does not output anything!!! 
    // otherwise it will break up PNG binary! 
     
    ob_start("callback"); 
     
    // here DB request or some processing 
    //$codeText = 'DEMO - '.$param; 
	$codeText = $_GET['cadena'];
     
    // end of processing here 
    $debugLog = ob_get_contents(); 
    ob_end_clean(); 
     
    // outputs image directly into browser, as PNG stream 
    QRcode::png($codeText);
	 
	//
	$file = date("Ymd_His").'codigo.png';
	
	header("Content-disposition: attachment; filename=$file");
	//header("Content-type: application/octet-stream");
	header('Content-Type: image/png');
	readfile($file); 

?>