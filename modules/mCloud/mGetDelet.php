<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
 	
	$T=$_GET['tipo'];
	$ct='-';
	$utl= $_GET['ulr'];
	
	if($T==1){
	
	$do = unlink($utl);
 
if($do != true){
 echo 0;
 }else{
	 echo 1;
	 }
	}else{
		
		echo eliminarDir($utl);
		
		}
	
	
	function eliminarDir($carpeta){
			
			 foreach(glob($carpeta."/*") as $archivos_carpeta) {
			 echo $archivos_carpeta; 
			 if(is_dir($archivos_carpeta)) eliminarDir($archivos_carpeta); 
			 else unlink($archivos_carpeta); 
			 }
			  $do = rmdir($carpeta); 
			  if($do == true){
					return 2;
				}
		  }


/*	if ($_FILES['archivo']["error"] > 0)

  {

  echo "Error: " . $_FILES['archivo']['error'] . "<br>";
	$T=0;
  }

else

  {

$T=1;
move_uploaded_file($_FILES['archivo']['tmp_name'], 
$utl .'/'. $_FILES['archivo']['name']);



 }*/

?>
