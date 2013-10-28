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

//---------------------------------------   PREPARA LA BASE PARA RECIBIR CARACTERES ESPECIALES, SIN NECESIDAD DE FUNCIONES DECODIFICADORAS. 
     $UTF8 = "SET NAMES 'utf8'";
     $db->sqlQuery($UTF8);
    
//---------------------------------------	
	$ruta_img = '';
	$T=0;
	$ct='-';
	$cs='*';
	$cadena='';

    $arreglo_archivos = array("doc"  => " Archivo DOC  ",
							  "docx" => " Archivo DOC  ",
							  "xls"  => " Archivo XLS  ",
							  "xlsx" => " Archivo XLSX ",	
	                          "pdf"  => " Archivo PDF  ",
	                          "mp4"  => " Video MP4",
	                          "url"  => " enlace url "
	                          );


	 $utl= $_GET['url'];
//---------------------------------------   SI  VIENE VACIA LA CAJA DE NOMBRE DE IMAGEN, MANDA ERRORES.	
	if (empty($_FILES['foto2']['name'])){ 
		echo "llego vacio";
        echo "Error: " . $_FILES['foto2']['error'] . "<br>"; 
		$T=0;

	}else{ //--------------------------------------- PROCEDE A REALIZAR OPERACIONES.
	
	if($_POST['origen_img']!='0'){
		
		$d2 = explode("/",$_POST['origen_img']);
		$d3 = '';
		
		for($z=3;$z<count($d2);$z++){
		  if($d3 === ''){
		  	$d3 = $d2[$z];
		  }	else{
		  	$d3 = $d3.'/'.$d2[$z];
		  }
			
		}
		
	    if (unlink($d3)){ 
		
		     $moved2 = move_uploaded_file($_FILES['foto2']['tmp_name'],'catalogos/imagenes_detalles/'. 
			                              $_GET['id_menu'].'_'.reemplaza(str_replace(" ","_",utf8_decode($_FILES['foto2']['name']))));					
				      	  
						  if($moved2) {
		                     $ruta_img = "http://".$_SERVER['HTTP_HOST']."/catalogos/imagenes_detalles/".
							         $_GET['id_menu'].'_'.reemplaza(str_replace(" ","_",utf8_decode($_FILES['foto2']['name'])));
						     
							 if(guardar_cambios($ruta_img,$_POST['uere_origen'])){
				      	       $T=1;
							    echo " foto nombre temporal".$_FILES['foto2']['tmp_name'].'<br>';
							    echo " foto nombre".$_FILES['foto2']['name'].'<br>';
							    echo " foto error".$_FILES['foto2']['error'].'<br>';
							    echo " foto tamanio".$_FILES['foto2']['size'].'<br>';
							    echo " foto tipo".$_FILES['foto2']['type'].'<br>';  
							}else{
				      	        $T=0;
				            }
								
				      	
						}else{
						  $T=0;
						
						}
		}else{
			echo "no se borro el archivo ". $_POST['origen_img'];
			
		}				
	}else{
	  $moved2 = move_uploaded_file($_FILES['foto2']['tmp_name'],'catalogos/imagenes_detalles/'. 
			                              $_GET['id_menu'].'_'.reemplaza(str_replace(" ","_",utf8_decode($_FILES['foto2']['name']))));					
				      	  
						  if($moved2) {
		                     $ruta_img = "http://".$_SERVER['HTTP_HOST']."/catalogos/imagenes_detalles/".
							         $_GET['id_menu'].'_'.reemplaza(str_replace(" ","_",utf8_decode($_FILES['foto2']['name'])));
						     
							 if(guardar_cambios($ruta_img,$_POST['uere_origen'])){
				      	       $T=1;
							    echo " foto nombre temporal".$_FILES['foto2']['tmp_name'].'<br>';
							    echo " foto nombre".$_FILES['foto2']['name'].'<br>';
							    echo " foto error".$_FILES['foto2']['error'].'<br>';
							    echo " foto tamanio".$_FILES['foto2']['size'].'<br>';
							    echo " foto tipo".$_FILES['foto2']['type'].'<br>';  
							}else{
				      	        $T=0;
				            }
								
				      	
						}else{
						  $T=0;
						
						}	
		
		
	}					
  }
				      

					 
	
//------------------------------------------- FUNCION QUE CODIFICA EN UTF-8

	function codif($in_str) {
		$cur_encoding = mb_detect_encoding($in_str);
		if( $cur_encoding == 'utf-8' && mb_check_encoding($in_str,'utf-8') )
			return $in_str;
		else
			return utf8_encode($in_str);
	}

//------------------------------------------- FUNCION GUARDA CAMBIOS EN LA TABLA CAT_CONTENIDO_DETALLE, LA NUEVA IMAGEN
  function guardar_cambios($ruta,$id_sub){
  	global $db,$mp4;
  	  
  	  $BUSCA = "SELECT ID_SUBMENU_CONTENIDO FROM CAT_CONTENIDO WHERE ".$id_sub;
  	  $query_busca = $db->sqlQuery($BUSCA); 
	  	if($query_busca){
	  		$row_busca = $db->sqlFetchArray($query_busca);
		  	 
		     $ACT = "UPDATE CAT_CONTENIDO_DETALLE SET IMAGEN = '".$ruta."' WHERE ID_CONTENIDO =".$row_busca['ID_SUBMENU_CONTENIDO'];
		     $queria = $db->sqlQuery($ACT); 
		  	   
			   if($queria){
			  		return 1;
		  	   }else{
		  	   	    return 0;
		  	   }
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
?>
<script type="text/javascript">
var na= '<?php echo $T; ?>';
parent.hola(na);
</script>
