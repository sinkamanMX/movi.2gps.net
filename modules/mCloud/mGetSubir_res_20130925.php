<?php
/*
*/
      header('Content-Type: text/html; charset=UTF-8'); 
	 $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
    if(!$userAdmin->u_logged()){
    		echo '<script>window.location="index.php?m=login"</script>';
    }
    
    
     $UTF8 = "SET NAMES 'utf8'";
     $db->sqlQuery($UTF8);
    
	$T=0;
	$ct='-';
	$cs='*';
	$directorio=dirname(__FILE__).'/Raiz/ragde18@hotmail.es';
	$cadena='';
	$down='/modules/mCloud/Raiz/ragde18@hotmail.es/';

    $arreglo_archivos = array("doc"  => " Archivo DOC  ",
							  "docx" => " Archivo DOC  ",
							  "xls"  => " Archivo XLS  ",
							  "xlsx" => " Archivo XLSX ",	
	                          "pdf"  => " Archivo PDF  ",
	                          "mp4"  => " Video MP4"
	                          );


	 $utl= $_GET['url'];
	
if ($_FILES['archivo']["error"] > 0){
    echo "Error: " . $_FILES['archivo']['error'] . "<br>";
	$T=0;
}else{
    $T=1;
    
    $moved = move_uploaded_file($_FILES['archivo']['tmp_name'],$utl .'/'. $_FILES['archivo']['name']);
   
   if($moved) {
	   
	   
	 $tipo_archivo = '';
	 $mp4 = '';
	  
    $mayor = " SELECT IF(MAX(ORDEN) IS NULL,1,MAX(ORDEN)+1) AS MAXIMO FROM CAT_CONTENIDO WHERE ID_SUBMENU  =".$_GET['id_menu'];
	$query_mayor = $db->sqlQuery($mayor);
	if($query_mayor){
	  $count = $db->sqlEnumRows($query_mayor);
	  $row_mayor = $db->sqlFetchArray($query_mayor);
	  $userfile_extn = explode(".",strtolower($_FILES['archivo']['name']));
	  
	    foreach ($arreglo_archivos as $item => $value){
		    if($item === $userfile_extn[count($userfile_extn)-1]){
		    	 $tipo_archivo = "Archivo ".$item;
		    	 if($item === 'mp4'){
		    	 	$mp4 = $item;
		    	 }
		    }
		}
			
	$sqlZ = "INSERT INTO CAT_CONTENIDO(ID_SUBMENU,UBICACION_LOCAL,UBICACION_REMOTA,DESCRIPCION,ORDEN)
             VALUES ('".$_GET['id_menu']."','/USUARIO1/','".($utl)."/". $_FILES['archivo']['name']."','".$tipo_archivo."','".$row_mayor['MAXIMO']."')";
		  	$queri = $db->sqlQuery($sqlZ); 
	      
		   if($queri){		
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
				            }else {
				            	echo 0;
				            }
					}
					if($mp4==='mp4'){
						actualiza_mp4();
					}
	        }
    }
   
	} else {
	  echo "Not uploaded";
	}
	

 }


	function codif($in_str) {
		$cur_encoding = mb_detect_encoding($in_str);
		if( $cur_encoding == 'utf-8' && mb_check_encoding($in_str,'utf-8') )
			return $in_str;
		else
			return utf8_encode($in_str);
	}


  function actualiza_mp4(){
  	global $db,$mp4;
  	  $ACT = "UPDATE CAT_SUBMENU SET ITEM_NUMBER = 'm_vc' WHERE ID_SUBMENU =".$_GET['id_menu'];
	  $queria = $db->sqlQuery($ACT); 
	  	if($queria){
	  		return 1;
  	   }else{
  	   	return 0;
  	   }
  }


?>
<script type="text/javascript">
var na= '<?php echo $T; ?>';
parent.hola(na);
</script>
