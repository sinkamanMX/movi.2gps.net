<?php
/*
*/
      header('Content-Type: text/html; charset=UTF-8'); 
	 
	    ini_set('post_max_size','100M');
		ini_set('upload_max_filesize','100M');
		ini_set('max_execution_time','1000');
		ini_set('max_input_time','1000');
	 
	 $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
    if(!$userAdmin->u_logged()){
    		echo '<script>window.location="index.php?m=login"</script>';
    }
    $tipo_archivo = '';
  $mp4 = '';
    
     $UTF8 = "SET NAMES 'utf8'";
     $db->sqlQuery($UTF8);
    
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
    	
    
  //	if (copy('catalogos/enlace.url', $utl.'/enlace.url')) {
if (copy('catalogos/enlace.url',$utl.'/'.str_replace("/",'_',str_replace("http://"," ",$_POST['urls'])).'_'.$_GET['id_menu'])){
		   	$ACT2 = "UPDATE CAT_SUBMENU SET UBICACION = '".$_POST['urls']."' , ACCION= 'U' WHERE ID_SUBMENU =".$_GET['id_menu'];
			  $queria2 = $db->sqlQuery($ACT2); 
			  	if($queria2){
			  	echo "si jala ".$_POST['urls'].'-'.$_GET['id_menu'].''.$ACT2;	
		 	   echo 'Se ha copiado el archivo corretamente';
			  	$T = 1;
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
    }//else{//-----------------
//				
//			
//			
//			
//			if ($_FILES['archivo']["error"] > 0){
//			    echo "Error: " . $_FILES['archivo']['error'] . "<br>";
//				$T=0;
//			}else{
//			   
//			    
//	 $moved = move_uploaded_file($_FILES['archivo']['tmp_name'],$utl .'/'. reemplaza(str_replace(" ","_",utf8_decode($_FILES['archivo']['name']))));
//		   
//			        if($moved) {
//				      if(guardar($_FILES['archivo']['name'],$utl,$_POST['tip_archi'])){
//				      	$T=1;
//				      	if (empty($_FILES['foto']['name'])){ 
//				      		echo "llego vacio";
//				      	}else{
//				      			echo " foto nombre temporal".$_FILES['foto']['tmp_name'].'<br>';
//							    echo " foto nombre".$_FILES['foto']['name'].'<br>';
//							    echo " foto error".$_FILES['foto']['error'].'<br>';
//							    echo " foto tamanio".$_FILES['foto']['size'].'<br>';
//							    echo " foto tipo".$_FILES['foto']['type'].'<br>';  
//				      	}
//				      }else{
//				      	$T=0;
//				      }
//
//					 
//			    	} else {
//				      echo "Not uploaded";
//				      echo "Error: " . $_FILES['archivo']['error'] . "<br>";
//				      echo $utl .'/'. reemplaza(str_replace(" ","_",utf8_decode($_FILES['archivo']['name'])));
//				    }
//				
//			
//			 }
//	}
//-------------------------------------- funcion general guarda en cat_contenido y actualiza cat_submenu
function guardar($nom_ar,$utl,$tpa){
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
		   	     	if(guardar_detalle($row_ultimo['IDCONT'],$_POST['titulo'],$_POST['autor'],$_POST['resumen'],$_POST['tag'],$_POST['eventos'])){
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

 function guardar_detalle($id,$titulo,$autor,$resumen,$tag,$ev){
  	global $db;
  	$detalle = "INSERT INTO CAT_CONTENIDO_DETALLE 
				(ID_CONTENIDO,TITULO, 
		         NOMBRE_AUTOR, 
				 RESUMEN, 
				 TAG,ID_EVENTO)
                 VALUES('".$id."','".$titulo."','".$autor."','".$resumen."','".$tag."','".$ev."')";
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
		$a = array('á','Á','é','É','í','Í', 'ó','Ó', 'ú','Ú','ü','Ü', 'ñ', 'Ñ',' ');
		$b = array('a','A','e','E','i','I', 'o' ,'O', 'u','U','u','U', 'n', 'N', '_');
		
		$regresa = str_replace($a, $b,$cadena_x);
		return $regresa;
   }	
?>
<script type="text/javascript">
var na= '<?php echo $T; ?>';
parent.hola(na);
</script>
