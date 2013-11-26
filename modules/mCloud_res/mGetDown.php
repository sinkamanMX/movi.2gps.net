<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
 	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	if(!$userAdmin->u_logged())
	echo '<script>window.location="index.php?m=login"</script>';


$utl= $_GET['ulr'];
$postTexto= $_GET['conten'];
	
	// ruta al archivo remoto
	if($fp = fopen($utl,"w+")){
		fwrite($fp,stripslashes($postTexto));
		fclose($fp);
	} else {
		die("Error de escritura");
	}

echo "<textarea name=\"Texto\" id=\"aredit\">$strContenido</textarea>
<a href=\"javascript:document.forms[0].submit()\">Guardar</a>
<!-- <input type=\"Submit\" value=\"Guardar\"> -->
</form>";

?>