<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
 	
	$T=0;
	$ct='-';
	$cs='*';
	$directorio=dirname(__FILE__).'/Raiz/ragde18@hotmail.es';
	$cadena='';
	$down='/modules/mCloud/Raiz/ragde18@hotmail.es/';
	echo $utl= $_GET['url'];
	
	if ($_FILES['archivo']["error"] > 0)

  {

  echo "Error: " . $_FILES['archivo']['error'] . "<br>";
	$T=0;
  }

else

  {

$T=1;
move_uploaded_file($_FILES['archivo']['tmp_name'], 
$utl .'/'. $_FILES['archivo']['name']);



 }

?>
<script type="text/javascript">
var na= '<?php echo $T; ?>';
parent.hola(na);
</script>
