<?php

 	 $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
    if(!$userAdmin->u_logged()){
    		echo '<script>window.location="index.php?m=login"</script>';
    }
//---------------------------------------   PREPARA LA BASE PARA RECIBIR CARACTERES ESPECIALES, SIN NECESIDAD DE FUNCIONES DECODIFICADORAS. 
     $UTF8 = "SET NAMES 'utf8'";
     $db->sqlQuery($UTF8);
    
   echo "hola". $_POST['clv_cat_img'];
    $imagenes = "SELECT * FROM CAT_IMAGENES WHERE ID_CATALOGO = ".$_POST['clv_cat_img'];
    $query_imagenes = $db->sqlQuery($imagenes);
    
    if($query_imagenes){
    	$row   = $db->sqlFetchArray($query_imagenes);
    	echo $count = $db->sqlEnumRows($query_imagenes);
    	 if($count>0){
    	   $img_login   = $row['IMG_LOGIN']; 
    	   $img_portada = $row['IMG_PORTADA'];
		   $img_icono   = $row['IMG_ICONO'];	
    	 }else{
    	   $img_login   = $_POST['img_login']; 
    	   $img_portada = $_POST['img_portada']; 
		   $img_icono   = $_POST['img_icono']; 		
      	 }
    }
    
//---------------------------------------   SI  VIENE VACIA LA CAJA DE NOMBRE DE IMAGEN, MANDA ERRORES.	
	if (empty($_FILES['img_login']['name'])){ 
		echo "llego vacio";
        echo "Error: " . $_FILES['foto2']['error'] . "<br>"; 
		$T=0;

	}else{ //--------------------------------------- PROCEDE A REALIZAR OPERACIONES.
	    
	 $moved2 = move_uploaded_file($_FILES['img_login']['tmp_name'],'./catalogos/iconos/'.$_POST['clv_cat_img'].'_'.$_FILES['img_login']['name']);			      if($moved2) {
		 $moved3 = move_uploaded_file($_FILES['img_portada']['tmp_name'],'./catalogos/iconos/'.$_POST['clv_cat_img'].'_'.$_FILES['img_portada']['name']);			  if	               ($moved3) {		
		     	$moved4 = move_uploaded_file($_FILES['img_icono']['tmp_name'],'./catalogos/iconos/'.$_POST['clv_cat_img'].'_'.$_FILES['img_icono']['name']);			    			 if($moved4) {	
	    	             $res =  guardar_cambios($count,$_FILES['img_login']['name'],$_FILES['img_portada']['name'],$_FILES['img_icono']['name']);
					 if($res==1){
					    if($count>0){
						  $a1 = explode("/",$row['IMG_LOGIN']);
						  $a2 = explode("/",$row['IMG_PORTADA']);
						  $a3 = explode("/",$row['IMG_ICONO']);
						  
						  if(unlink('./catalogos/iconos/'.$a1[5])){
						  	echo "si borro 1";
						  }else{
						  		print_r(error_get_last());
						  }
						  
						   if(unlink('./catalogos/iconos/'.$a2[5])){
						   	   echo "si borro 2";
						   }else{
						  		print_r(error_get_last());
						   }
						  
						   if(unlink('./catalogos/iconos/'.$a3[5])){
						  	  echo "si borro 3";
						  }else{
						  		print_r(error_get_last());
						  }
						
						
						}
						
					 	$T = 1;
					 }	
		        }else{
		 	
		 				print_r(error_get_last());
		 			}
			 }else{
		 	
		 			print_r(error_get_last());
		 		}
		 }else{
		 	
		 	print_r(error_get_last());
		 }
    }//------------------------ fin  PROCEDE A REALIZAR OPERACIONES.
				      

					 
	
//------------------------------------------- FUNCION QUE CODIFICA EN UTF-8

	function codif($in_str) {
		$cur_encoding = mb_detect_encoding($in_str);
		if( $cur_encoding == 'utf-8' && mb_check_encoding($in_str,'utf-8') )
			return $in_str;
		else
			return utf8_encode($in_str);
	}

//------------------------------------------- FUNCION GUARDA CAMBIOS EN LA TABLA CAT_CONTENIDO_DETALLE, LA NUEVA IMAGEN
  function guardar_cambios($cnt,$logo,$portada,$icono){
  	global $db;
  	 if($cnt>0){ 
		     $ACT = "UPDATE CAT_IMAGENES 
					SET
					IMG_LOGIN = 'http://".$_SERVER['HTTP_HOST']."/catalogos/iconos/".$_POST['clv_cat_img'].'_'.$logo."' , 
					IMG_PORTADA = 'http://".$_SERVER['HTTP_HOST']."/catalogos/iconos/".$_POST['clv_cat_img'].'_'.$portada."' , 
					IMG_ICONO = 'http://".$_SERVER['HTTP_HOST']."/catalogos/iconos/".$_POST['clv_cat_img'].'_'.$icono."'
					
					WHERE
					ID_CATALOGO = ".$_POST['clv_cat_img'];
					
		     $queria = $db->sqlQuery($ACT); 
		  	   
			   if($queria){
			  		return 1;
		  	   }else{
		  	   	    return 0;
		  	   }
  	   
  	 }else{
	      $ACT = "INSERT INTO CAT_IMAGENES (
		          ID_CATALOGO,
				  IMG_LOGIN,
				  IMG_PORTADA,
				  IMG_ICONO) 
		          
				  VALUES( '".$_POST['clv_cat_img']."',
					 'http://".$_SERVER['HTTP_HOST']."/catalogos/iconos/".$_POST['clv_cat_img'].'_'.$logo."' , 
					 'http://".$_SERVER['HTTP_HOST']."/catalogos/iconos/".$_POST['clv_cat_img'].'_'.$portada."' , 
					 'http://".$_SERVER['HTTP_HOST']."/catalogos/iconos/".$_POST['clv_cat_img'].'_'.$icono."')";
					
		     $queria = $db->sqlQuery($ACT); 
		  	   
			   if($queria){
			  		return 1;
		  	   }else{
		  	   	    return 0;
		  	   }
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
