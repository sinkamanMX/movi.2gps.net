<?php
/*
*/

	 $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
    if(!$userAdmin->u_logged()){
    		echo '<script>window.location="index.php?m=login"</script>';
    }
//---------------------------------------   PREPARA LA BASE PARA RECIBIR CARACTERES ESPECIALES, SIN NECESIDAD DE FUNCIONES DECODIFICADORAS. 
     $UTF8 = "SET NAMES 'utf8'";
     $db->sqlQuery($UTF8);
    

//------------------------------------------- FUNCION GUARDA CAMBIOS EN LA TABLA CAT_CONTENIDO_DETALLE, LA NUEVA IMAGEN
  	  $cadena = '';
  	  $BUSCA = "SELECT * FROM CAT_IMAGENES WHERE ID_CATALOGO = ".$_GET['cat'];
  	  $query_busca = $db->sqlQuery($BUSCA); 
	  	if($query_busca){
	  	    $count = $db->sqlEnumRows($query_busca);
    	 if($count>0){	
	  		$row_busca = $db->sqlFetchArray($query_busca);
		  	$cadena = $row_busca['IMG_LOGIN'].'|'.$row_busca['IMG_PORTADA'].'|'.$row_busca['IMG_ICONO'];
            
			echo $cadena; 
		}else{
			echo 0;
		}				   
		     
  	   }else{
  	        echo 0;
  	   }
  	
  	 

  
  
?>
