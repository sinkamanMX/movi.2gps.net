<?php
/*
*/
      header('Content-Type: text/html; charset=UTF-8'); 
	 
	    ini_set('post_max_size','100M');
		ini_set('upload_max_filesize','100M');
		ini_set('max_execution_time','1000');
		ini_set('max_input_time','1000');
	
	//$ruta_ftp_config = $_SERVER['DOCUMENT_ROOT'].'/modules/mCloud/ftp_conf.php';
	
//	include("ftp_conf.php");
    $d_ftp = explode("|",$_GET['ftp']);
	
	$servidor_ftp = $d_ftp[0]; 
	$ftp_usuario  = $d_ftp[1];
	$ftp_clave    = $d_ftp[2];	
	
	 $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
   
     $UTF8 = "SET NAMES 'utf8'";
     $db->sqlQuery($UTF8);
  
// ---------------------------------------- variables y arreglos
    $tipo_archivo = '';
    $mp4 = '';
  	$ruta_img = '';
	$T=0;
	$Padre = 0;
	$ct='-';
	$cs='*';
	$cadena='';


    $arreglo_archivos = array("doc"  => " Archivo DOC  ",
							  "docx" => " Archivo DOC  ",
							  "xls"  => " Archivo XLS  ",
							  "xlsx" => " Archivo XLSX ",	
	                          "pdf"  => " Archivo PDF  ",
	                          "mp4"  => " Video MP4",
	                          "apk"  => " Archivo APP",
	                          "url"  => " enlace url "
	                          );


	 $utl= $_GET['url'];
	
//-------------------------------------------------------------- datos iniciales

	
	 if($_POST['tip_archi'] == 'u'){  //----------------------  si es url desde local
		  
		    if (copy('catalogos/enlace.url',$utl.'/'.str_replace("/",'_',str_replace("http://"," ",$_POST['urls'])).'_'.$_GET['id_menu'])){
				   	$ACT2 = "UPDATE CAT_SUBMENU SET UBICACION = '".$_POST['urls']."' , ACCION= 'U' WHERE ID_SUBMENU =".$_GET['id_menu'];
					  $queria2 = $db->sqlQuery($ACT2); 
					  	if($queria2){
					  	echo "si jala ".$_POST['urls'].'-'.$_GET['id_menu'].''.$ACT2;	
				 	   echo 'Se ha copiado el archivo corretamente';
					  	$T = 1;
					  	$Padre = 1;
				  	   }else{
				  	   		echo "pos aver si jala";
				  	   		$T=0;
				  	   }
				     //$T= guardar('enlace.url',$utl,'u');
				}
				else {
				   echo 'Se produjo un error al copiar el fichero';
				   $T=0;
				}	
    
   }else{                  //----------------------------  fin de opcion url  e inicio d otra opcion
	
			
			if ($_FILES['archivo']["error"] > 0){
			    echo "Error: " . $_FILES['archivo']['error'] . "<br>";
				$T=0;
			}else{
	 			borra_archivos();		   
	 			$destino = "archivos/".reemplaza(str_replace(" ","_",utf8_decode($_FILES['archivo']['name'])));
		 		$moved   = copy($_FILES['archivo']['tmp_name'],$destino);
		   
             if($moved) { // si se envio la imagen a 2gps.net/archivo
				//---------------------------------------	proceso ftp  	     
				
				$ftp_carpeta_local  = "./archivos/";
			    $ftp_carpeta_remota = "/".$utl."/";
				$mi_nombredearchivo = reemplaza(str_replace(" ","_",utf8_decode($_FILES['archivo']['name'])));	 
			
				$nombre_archivo  = $ftp_carpeta_local.$mi_nombredearchivo;
			    $archivo_destino = $ftp_carpeta_remota.$mi_nombredearchivo;
			    
			    $conexion_id = ftp_connect($servidor_ftp);    // se realiza la conexion ftp hacia el servidor destino	
			
			    $resultado_login = ftp_login($conexion_id, $ftp_usuario, $ftp_clave); // se realiza autentificacion con usuario y password
 
				if ((!$conexion_id) || (!$resultado_login)) {
					echo "La conexion ha fallado! al conectar con $servidor_ftp para usuario $ftp_usuario".$_GET['ftp'];
					exit;
				} else {
					echo "Conectado con $servidor_ftp, para usuario $ftp_usuario";
				}
				
				$upload = ftp_put($conexion_id, $archivo_destino, $nombre_archivo, FTP_BINARY);			
				   if ($upload) { 
				   	//echo " pos si se subieron a".$archivo_destino;
				   	
				   	//---------------------------------------- cnx a la base de origen
				   	$base_datos = explode("|",$_GET['bdatos']);
				   	
					//$host = '173.224.120.179';
//					$usuario = 'savl_movi';
//					$contra  = 'fr4de3';
				
				

				   	
				   
				   	//----------------------------------------
					  	if (empty($_FILES['foto']['name'])){ // si no se envia foto descriptiva  solo se guarda datos de detalle 
   	                          $T = 1;
				         	  $nombre_foto = $_FILES['archivo']['name'];
							  $direccion_carpeta = $utl;
							  $tipo_d_archivo = $_POST['tip_archi'];
							  $ruta_img = "NO";
							  $regresa_datos   = $nombre_foto.'|'.$direccion_carpeta.'|'.$tipo_d_archivo.'|'.$ruta_img;
							  $datos_d_detalle = $_POST['titulo'].'|'.$_POST['autor'].'|'.$_POST['resumen'].'|'.$_POST['tag'].'|'.$_POST['eventos'];
							 
							        echo  $regresa_datos;
							   //--------------
							   
							    if(guardar($nombre_foto,$utl,$tipo_d_archivo,$ruta_img)){
				      	        $T=1;
				      	        echo "se guardoooooooo";
								}else{
					      	        $T=0;
					      	        echo "no se guardoooooo";
					            }
							   
							   //--------------     
							        
							        
							        

				      	}else{ // si llega dato de foto, guardarla, y guardar detalle.
						
	                    $moved2 = move_uploaded_file($_FILES['foto']['tmp_name'],'archivos_imagenes_detalles/'. 
						$_GET['id_menu'].'_'.reemplaza(str_replace(" ","_",utf8_decode($_FILES['foto']['name']))));					
				      	  
							  if($moved2) { // confirma si se ha guarda
									$ftp_carpeta_local2  = "./archivos_imagenes_detalles/";
								    $ftp_carpeta_remota2 = "./catalogos/imagenes_detalles/";
						            $mi_nombredearchivo2 = $_GET['id_menu'].'_'.reemplaza(str_replace(" ","_",utf8_decode($_FILES['foto']['name'])));	 
									$nombre_archivo2  = $ftp_carpeta_local2.$mi_nombredearchivo2;
			    					$archivo_destino2 = $ftp_carpeta_remota2.$mi_nombredearchivo2;	
							  
							   	$upload2 = ftp_put($conexion_id, $archivo_destino2, $nombre_archivo2, FTP_BINARY);					
				                if ($upload2) {  // si ha subido la imagen de detalle
							  	    $T = 1;
							  	    $nombre_foto = $_FILES['archivo']['name'];
							  	    $direccion_carpeta = $utl;
							  	    $tipo_d_archivo = $_POST['tip_archi'];
							  	    $ruta_img = "/catalogos/imagenes_detalles/".$mi_nombredearchivo2;
					  	        $regresa_datos = $nombre_foto.'|'.$direccion_carpeta.'|'.$tipo_d_archivo.'|'.$ruta_img; 
							    $datos_d_detalle = $_POST['titulo'].'|'.$_POST['autor'].'|'.$_POST['resumen'].'|'.$_POST['tag'].'|'.$_POST['eventos'];
								 
								     echo $archivo_destino2 .'--'.$nombre_archivo2.'<br>';
							         echo  $regresa_datos;
							         
							           if(guardar($nombre_foto,$utl,$tipo_d_archivo,$ruta_img)){
						      	        $T=1;
						      	        echo "se guardoooooooo todo y con foto descripctiva";
										}else{
							      	        $T=0;
							      	        echo "no se guardoooooo";
							            }
							         
							         
							  	}else{
							    	$T = 0;
			 	    		          echo "Ha ocurrido un error al subir el foto mediante ftp checar todo ".
							          $conexion_id.'-'.$archivo_destino2.'-'.$nombre_archivo2.'<br>';
									   print_r(error_get_last());				  
							    }
							}else{
								$T = 0;
							    echo "No subio foto ";
					      		echo "Error: " . $_FILES['foto']['error'] . "<br>";
					      								
							}
						
						}
				
				    }else{
				    	$T = 0;
 	    		          echo "Ha ocurrido un error al subir el archivo mediante ftp checar todo ".
				               $conexion_id.'-'.$archivo_destino.'-'.$nombre_archivo.'<br>';
							   print_r(error_get_last());				  
				    }
					ftp_close($conexion_id);
					 //--------------------------------------- proceso ftp
			    } else {
				   echo "No se subio el archivo ";
				   echo "Error: " . $_FILES['archivo']['error'] . "<br>";
				   echo $utl .'/'. reemplaza(str_replace(" ","_",utf8_decode($_FILES['archivo']['name'])));
			    }
				
			
			 }
	}
//-------------------------------------- funcion general guarda en cat_contenido y actualiza cat_submenu
function guardar($nom_ar,$utl,$tpa,$img_deta){
	global $db,$mp4,$arreglo_archivos,$tipo_archivo,$base_datos;
	
					$host    = $base_datos[0];
					$usuario = $base_datos[1];
					$contra  = $base_datos[2];
					$base_nombre = $base_datos[3];
					$servilleta  = $base_datos[4];
					
					$enlace =  mysql_connect($host,$usuario,$contra);
					if (!$enlace) {
					    die('No pudo conectarse: ' . mysql_error());
					}else{   //si se conecto correctamente
							echo 'Conectado satisfactoriamente';
				   
	
	mysql_select_db($base_nombre, $enlace); 
	
    $mayor = " SELECT IF(MAX(ORDEN) IS NULL,1,MAX(ORDEN)+1) AS MAXIMO FROM CAT_CONTENIDO WHERE ID_SUBMENU  =".$_GET['id_menu'];
	$query_mayor =  mysql_query($mayor,$enlace);
	if($query_mayor){
	  //$count = $db->sqlEnumRows($query_mayor);
	  $row_mayor = mysql_fetch_array($query_mayor);
	  $userfile_extn = explode(".",strtolower($nom_ar));
	  
	    foreach ($arreglo_archivos as $item => $value){
		    if($item === $userfile_extn[count($userfile_extn)-1]){
		    	 $tipo_archivo = "Archivo ".$item;
		    	 if($item === 'mp4'){
		    	 	$mp4 = $item;
		    	 }
		    }
		}
			
	$sqlZ = "INSERT INTO CAT_CONTENIDO(ID_SUBMENU,UBICACION_LOCAL,UBICACION_REMOTA,DESCRIPCION,ORDEN)
             VALUES ('".$_GET['id_menu']."','/USUARIO1/','http://".$servilleta."/".
			 ($utl)."/".reemplaza(str_replace(" ","_",utf8_decode($nom_ar)))."','".$tipo_archivo."','".$row_mayor['MAXIMO']."')";
		  	
			   $queri = mysql_query($sqlZ); 
	      
		   if($queri){
		   	
		   	 $ultimo = "SELECT LAST_INSERT_ID() AS IDCONT FROM CAT_CONTENIDO;";
		   	   $query_ultimo = mysql_query($ultimo); 
	      if($query_ultimo){
		   	$row_ultimo = mysql_fetch_array($query_ultimo);
   			if(guardar_detalle($row_ultimo['IDCONT'],$_POST['titulo'],$_POST['autor'],$_POST['resumen'],$_POST['tag'],$_POST['eventos'],$img_deta)){
		   	$T = 1;
		   	}else{
		   	     		  $T = 0;
		   	     	}
		   	     }else{
		   	     	
		   	     	echo 'No pudo query_ultimo' . mysql_error();
		   	     }
					if($row_mayor['MAXIMO']>'1'){
						$ACT = "UPDATE CAT_SUBMENU SET ACCION = 'D' WHERE ID_SUBMENU =".$_GET['id_menu'];
							$queria = mysql_query($ACT); 
	       					if($queria){
       						    echo '<br>'."Successfully uploaded y saved".'<br>'; 
								echo "nombre temporal".$_FILES['archivo']['tmp_name'].'<br>';
							    echo "nombre".$_FILES['archivo']['name'].'<br>';
							    echo "error".$_FILES['archivo']['error'].'<br>';
							    echo "tamanio".$_FILES['archivo']['size'].'<br>';
							    echo "tipo".$_FILES['archivo']['type'].'<br>';     
								echo "id_menu".$_GET['id_menu'].'<br>';
								echo "maximo".$row_mayor['MAXIMO'].'<br>';
								echo $sqlZ;  
				                echo $row_ultimo['IDCONT'];
				                echo $_POST['titulo'].$_POST['autor'].$_POST['resumen'].$_POST['tag'].$_POST['tip_archi'].'<br>';
				                $T = 1;
				            }else {
				            	echo 0;
				            }
					}
					if($mp4==='mp4'){
						actualiza_mp4();
					}
				/*	 echo $row_ultimo['IDCONT'].'<br>';
					 echo $_POST['titulo'].$_POST['autor'].$_POST['resumen'].$_POST['tag'].$_POST['tip_archi'].'<br>';*/
					   $T = 1;
				//	 $T=1;
	        }else{
	        	$T=0;
	        		echo 'No pudo $queri' . mysql_error();
	        }
    }else{
	        	$T=0;
	        		echo 'Nooooo $queri' . mysql_error();
	        }

 }   //si se conecto correctamente

	mysql_close($enlace);
	if ($T ===1){
		
		return 1;
	}else{
		return 0;
	}	
}



//--------------------------------------------

	function codif($in_str) {
		$cur_encoding = mb_detect_encoding($in_str);
		if( $cur_encoding == 'utf-8' && mb_check_encoding($in_str,'utf-8') )
			return $in_str;
		else
			return utf8_encode($in_str);
	}

//-------------------------------------------
  function actualiza_mp4(){
  	global $db,$mp4;
  	  $ACT = "UPDATE CAT_SUBMENU SET ITEM_NUMBER = 'm_vc', ACCION = 'V'  WHERE ID_SUBMENU =".$_GET['id_menu'];
	  $queria = $db->sqlQuery($ACT); 
	  	if($queria){
	  		return 1;
  	   }else{
  	   	return 0;
  	   }
  }

//------------------------------ guarda en cat_contenido-detalle, y actualiza en cat_submenu si es url

 function guardar_detalle($id,$titulo,$autor,$resumen,$tag,$ev,$img_deta){
  	global $db,$base_datos;
  	
  	$host    = $base_datos[0];
					$usuario = $base_datos[1];
					$contra  = $base_datos[2];
					$base_nombre = $base_datos[3];
					
					$enlace =  mysql_connect($host,$usuario,$contra);
					if (!$enlace) {
					    die('No pudo conectarse: ' . mysql_error());
					}else{   //si se conecto correctamente
							echo 'Conectado para detalle satisfactoriamente';	
  	
	  $detalle = "INSERT INTO CAT_CONTENIDO_DETALLE 
				(ID_CONTENIDO,TITULO, 
		         NOMBRE_AUTOR, 
				 RESUMEN, 
				 TAG,ID_EVENTO,IMAGEN)
                 VALUES('".$id."','".$titulo."','".$autor."','".$resumen."','".$tag."','".$ev."','".$img_deta."')";
  	$queri_deta = mysql_query($detalle); 
	  	if($queri_deta){
	  		  $bandera_sino ="UPDATE CAT_CATALOGO_BANDERA SET BANDERA = 1";
	  		  $query_sino = mysql_query($bandera_sino); 
	  		  if($query_sino){
	  		  	echo "pos segun si se actualizo bandera";
	 	        return 1;
	 	      }else{
	 	      	return 0;
	 	      }
		 }else{
  	       	  return 0;
  	   }
  	   
  	   }
  }
  
  //--------------------
   function reemplaza($cadena_x){
		$regresa = '';
		$a = array('á','Á','é','É','í','Í', 'ó','Ó', 'ú','Ú','ü','Ü', 'ñ', 'Ñ',' ');
		$b = array('a','A','e','E','i','I', 'o' ,'O', 'u','U', 'u','U', 'n', 'N', '_');
		
		$regresa = str_replace($a, $b,$cadena_x);
		return $regresa;
   }
   //------------------------- funcion que elimina todos los archivos en carpeta archivos/
   	function borra_archivos(){
	 $dir = "./archivos/";
	$ficheroseliminados= 0;
	$handle = opendir($dir);
	while ($file = readdir($handle)) {
		 if (is_file($dir.$file)) {
		  if ( unlink($dir.$file) ){
		   $ficheroseliminados++;
		  }
		 }
	}
     
	
   	}
?>
 <div id="dialog_j" title="Subir">hola</div>
<script type="text/javascript">
var na = '<?php echo $T; ?>';
var dr = '<?php echo $regresa_datos; ?>';
var ddet = '<?php echo $datos_d_detalle; ?>'; 
var id_m = '<?php echo $_GET['id_menu']; ?>'; 

if(na == '1'){
	//alert('todo se guardo correctamente');
}
var papa= '<?php echo $Padre; ?>';
if(papa == '1'){
	parent.hola(na);
}

</script>
