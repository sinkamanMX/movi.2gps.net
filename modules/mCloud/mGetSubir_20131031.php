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
	
	
	/*$servidor_ftp = "test.2gps.net";
	$ftp_usuario = "algtester";
	$ftp_clave = "AL6735teR";	
	*/ 
	 $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
    if(!$userAdmin->u_logged()){
    		echo '<script>window.location="index.php?m=login"</script>';
    }
    $tipo_archivo = '';
  $mp4 = '';
    
     $UTF8 = "SET NAMES 'utf8'";
     $db->sqlQuery($UTF8);
    
	
	$ruta_img = '';
	$T=0;
	$ct='-';
	$cs='*';
//	$directorio=dirname(__FILE__).'/Raiz/ragde18@hotmail.es';
	$cadena='';
//	$down='/modules/mCloud/Raiz/ragde18@hotmail.es/';

    $arreglo_archivos = array("doc"  => " Archivo DOC  ",
							  "docx" => " Archivo DOC  ",
							  "xls"  => " Archivo XLS  ",
							  "xlsx" => " Archivo XLSX ",	
	                          "pdf"  => " Archivo PDF  ",
	                          "mp4"  => " Video MP4",
	                          "url"  => " enlace url "
	                          );


	 $utl= $_GET['url'];
	
	
	 if($_POST['tip_archi'] == 'u'){
    	
    
		   	//  $ACT2 = "UPDATE CAT_SUBMENU SET UBICACION = '".$_POST['urls']."' , ACCION= 'U' WHERE ID_SUBMENU =".$_GET['id_menu'];
//			  $queria2 = $db->sqlQuery($ACT2); 
//			  	if($queria2){
//			  	echo "si jala ".$_POST['urls'].'-'.$_GET['id_menu'].''.$ACT2;
//			  	$T = 1;
//		  	   }else{
//		  	   		echo "pos aver si jala";
//		  	   }
		   	
		 
    	
//$nuevo_testo = rename("catalogos/archivo.url", "/home/user/login/docs/mi_archivo.txt");
   	if (copy('./catalogos/enlace.url', $utl.'/'.str_replace("/",'_',str_replace("http://"," ",$_POST['urls'])).'_'.$_GET['id_menu'])) {

		   	$ACT2 = "UPDATE CAT_SUBMENU SET UBICACION = '".$_POST['urls']."' , ACCION= 'U' WHERE ID_SUBMENU =".$_GET['id_menu'];
			  $queria2 = $db->sqlQuery($ACT2); 
			  	if($queria2){
			  	echo "si jala ".$_POST['urls'].'-'.$_GET['id_menu'].''.$ACT2;	
		 	   echo 'Se ha copiado el archivo corretamente';
			  	$T = 1;
		  	   }else{
		  	   		echo "pos no jala";
		  	   		$T=0;
		  	   }
		     //$T= guardar('enlace.url',$utl,'u');
		}
		else {
		   echo 'Se produjo un error al copiar el fichero';
		    print_r(error_get_last());
		   $T=0;
		}
    }else{
			
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
//				$ftp_carpeta_remota = "./catalogos/ICSS-ALG/ICSS-ALG/";
//				$ftp_carpeta_remota = "./catalogos/ICSS-ALG/ICSS-ALG/Mido_Portatil/asi_33/";
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
				   	
				   	
					  	if (empty($_FILES['foto']['name'])){ // si no se envia foto descriptiva  solo se guarda datos de detalle 
				         	        $T = 1;
				         	        $nombre_foto = $_FILES['archivo']['name'];
							  	    $direccion_carpeta = $utl;
							  	    $tipo_d_archivo = $_POST['tip_archi'];
							  	    $ruta_img = "NO";
							  	 $regresa_datos = $nombre_foto.'|'.$direccion_carpeta.'|'.$tipo_d_archivo.'|'.$ruta_img;
							 $datos_d_detalle = $_POST['titulo'].'|'.$_POST['autor'].'|'.$_POST['resumen'].'|'.$_POST['tag'].'|'.$_POST['eventos'];
							 
							        echo  $regresa_datos;
						  /*	echo "llego vacio";
							if(guardar($_FILES['archivo']['name'],$utl,$_POST['tip_archi'],'NO')){
				      	       $T=1;
							}else{
				      	        $T=0;
				            }*/
				      	}else{ // si llega dato de foto guardarla, y guardar detalle.
						
	                    $moved2 = move_uploaded_file($_FILES['foto']['tmp_name'],'archivos_imagenes_detalles/'. 
						$_GET['id_menu'].'_'.reemplaza(str_replace(" ","_",utf8_decode($_FILES['foto']['name']))));					
				      	  
							  if($moved2) { // confirma si se ha guarda
									$ftp_carpeta_local2  = "./archivos_imagenes_detalles/";
								    $ftp_carpeta_remota2 = "./catalogos/imagenes_detalles/";
						            $mi_nombredearchivo2 = $_GET['id_menu'].'_'.reemplaza(str_replace(" ","_",utf8_decode($_FILES['foto']['name'])));	 
									$nombre_archivo2  = $ftp_carpeta_local2.$mi_nombredearchivo2;
			    					$archivo_destino2 = $ftp_carpeta_remota2.$mi_nombredearchivo2;	
							  
							   	$upload2 = ftp_put($conexion_id, $archivo_destino2, $nombre_archivo2, FTP_BINARY);					
				                 if ($upload2) { 
							  	    $T = 1;
							  	    $nombre_foto = $_FILES['archivo']['name'];
							  	    $direccion_carpeta = $utl;
							  	    $tipo_d_archivo = $_POST['tip_archi'];
							  	    $ruta_img = "/catalogos/imagenes_detalles/".$mi_nombredearchivo2;
					  	        $regresa_datos = $nombre_foto.'|'.$direccion_carpeta.'|'.$tipo_d_archivo.'|'.$ruta_img; 
							    $datos_d_detalle = $_POST['titulo'].'|'.$_POST['autor'].'|'.$_POST['resumen'].'|'.$_POST['tag'].'|'.$_POST['eventos'];
								 
								     echo $archivo_destino2 .'--'.$nombre_archivo2.'<br>';
							         echo  $regresa_datos;
							  	}else{
							    	$T = 0;
			 	    		          echo "Ha ocurrido un error al subir el foto mediante ftp checar todo ".
							          $conexion_id.'-'.$archivo_destino2.'-'.$nombre_archivo2.'<br>';
									   print_r(error_get_last());				  
							    }
    /* $ruta_img = "http://".$_SERVER['HTTP_HOST']."/catalogos/imagenes_detalles/".$_GET['id_menu'].'_'.reemplaza(str_replace(" ","_",utf8_decode($_FILES['foto']['name'])));
							     
								 if(guardar($_FILES['archivo']['name'],$utl,$_POST['tip_archi'],$ruta_img)){
					      	       $T=1;
								    echo " foto nombre temporal".$_FILES['foto']['tmp_name'].'<br>';
								    echo " foto nombre".$_FILES['foto']['name'].'<br>';
								    echo " foto error".$_FILES['foto']['error'].'<br>';
								    echo " foto tamanio".$_FILES['foto']['size'].'<br>';
								    echo " foto tipo".$_FILES['foto']['type'].'<br>';  
								}else{
					      	        $T=0;
					            }
							*/		
					      	
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
	global $db,$mp4,$arreglo_archivos,$tipo_archivo;
	
    $mayor = " SELECT IF(MAX(ORDEN) IS NULL,1,MAX(ORDEN)+1) AS MAXIMO FROM CAT_CONTENIDO WHERE ID_SUBMENU  =".$_GET['id_menu'];
	$query_mayor = $db->sqlQuery($mayor);
	if($query_mayor){
	  $count = $db->sqlEnumRows($query_mayor);
	  $row_mayor = $db->sqlFetchArray($query_mayor);
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
             VALUES ('".$_GET['id_menu']."','/USUARIO1/','http://".$_SERVER['HTTP_HOST']."/".($utl)."/".reemplaza(str_replace(" ","_",utf8_decode($nom_ar)))."','".$tipo_archivo."','".$row_mayor['MAXIMO']."')";
		  	$queri = $db->sqlQuery($sqlZ); 
	      
		   if($queri){
		   	
		   	 $ultimo = "SELECT LAST_INSERT_ID() AS IDCONT FROM CAT_CONTENIDO;";
		   	   $query_ultimo = $db->sqlQuery($ultimo); 
		   	   if($query_ultimo){
		   	   	 $row_ultimo = $db->sqlFetchArray($query_ultimo);
		   	     	if(guardar_detalle($row_ultimo['IDCONT'],$_POST['titulo'],$_POST['autor'],$_POST['resumen'],$_POST['tag'],$_POST['eventos'],$img_deta)){
		   	     		  $T = 1;
		   	     	}else{
		   	     		  $T = 0;
		   	     	}
		   	     }
					if($row_mayor['MAXIMO']>'1'){
						$ACT = "UPDATE CAT_SUBMENU SET ACCION = 'D' WHERE ID_SUBMENU =".$_GET['id_menu'];
							$queria = $db->sqlQuery($ACT); 
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
	        }
    }
	
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
  	global $db;
  	$detalle = "INSERT INTO CAT_CONTENIDO_DETALLE 
				(ID_CONTENIDO,TITULO, 
		         NOMBRE_AUTOR, 
				 RESUMEN, 
				 TAG,ID_EVENTO,IMAGEN)
                 VALUES('".$id."','".$titulo."','".$autor."','".$resumen."','".$tag."','".$ev."','".$img_deta."')";
  	$queri_deta = $db->sqlQuery($detalle); 
	  	if($queri_deta){
	  	//  if($tpa === 'u'){
//		   	$ACT2 = "UPDATE CAT_SUBMENU SET UBICACION = '".$_POST['urls']."' AND ACCION= 'U' WHERE ID_SUBMENU =".$_GET['id_menu'];
//			  $queria2 = $db->sqlQuery($ACT2); 
//			  	if($queria2){
//			  		return 1;
//		  	   }else{
//		  	   	return 0;
//		  	   }
//		   	
//		   }else{
//		   	 return 1;
//		   }
  	      return 1;
		 }else{
  	   	return 0;
  	   }
  }
  
  //--------------------
   function reemplaza($cadena_x){
		$regresa = '';
		$a = array('á','Á','é','É','í','Í', 'ó','Ó', 'ú','Ú', 'ñ', 'Ñ',' ');
		$b = array('a','A','e','E','i','I', 'o' ,'O', 'u','U', 'n', 'N', '_');
		
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
<script type="text/javascript">
var na = '<?php echo $T; ?>';
var dr = '<?php echo $regresa_datos; ?>';
var ddet = '<?php echo $datos_d_detalle; ?>'; 
var id_m = '<?php echo $_GET['id_menu']; ?>'; 

parent.hola(na,dr,ddet,id_m);
</script>
