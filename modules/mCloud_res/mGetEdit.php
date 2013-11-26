<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
 	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	if(!$userAdmin->u_logged())
	echo '<script>window.location="index.php?m=login"</script>';


$utl= $_GET['ulr'];
	
	// ruta al archivo remoto
$remote_file = $utl;

$divi=explode('/',$utl);

$local_file = $divi[count($divi)-1];

if($fp = fopen($utl,"r")) {
	if (filesize ($utl) > 0) {
		$strContenido = fread ($fp, filesize ($utl));
	}
	fclose($fp);
} else {
	die("Error de lectura");
}

echo "<textarea name=\"Texto\" id=\"aredit\">$strContenido</textarea>
<a href=\"#\" onclick=\"guar_php('$utl')\">Guardar</a>";

?>