<?php
$status = "";
if ($_POST["action"] == "upload") {
    // obtenemos los datos del archivo
    $tamano = $_FILES["archivo"]['size'];
    $tipo = $_FILES["archivo"]['type'];
    $archivo = $_FILES["archivo"]['name'];
    $prefijo = substr(md5(uniqid(rand())),0,6);
   
    if ($archivo != "") {
        // guardamos el archivo a la carpeta files
        $destino =  "archivos/".$prefijo."_".$archivo;
        if (copy($_FILES['archivo']['tmp_name'],$destino)) {
             $status = "ok";
    //        if (copy('archivos/'.$prefijo."_".$archivo,'http://tablerocasalud.org/archivos/'.$prefijo."_".$archivo)) {
//		         $status = "Archivo enviado a tablero en archivos";
//            }else{
//            	$status ="fallo al copiar a remoto"; 
//            }
        } else {
            $status = "Error al copiar el archivo";
        }
    } else {
        $status = "Error no hay dato de nombre";
    }
}

echo $status;
?>