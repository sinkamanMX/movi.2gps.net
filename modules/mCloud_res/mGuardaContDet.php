<?php

     header('Content-Type: text/html; charset=UTF-8');
 	 $db  = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

     $UTF8 = "SET NAMES 'utf8'";
     $db->sqlQuery($UTF8);
     
     if(!$userAdmin->u_logged()){
    		echo '<script>window.location="index.php?m=login"</script>';
    }


   $a_contenido = explode("|",$_GET['contenido']);
   $b_detalle   = explode("|",$_GET['detalle']);
   $c_IdMenu    = $_GET['id_menus'];
  						
	                   //	if(isset($_GET['detalle'])){
                        if(guardar($a_contenido[0],$a_contenido[1],$a_contenido[2],$a_contenido[3])){
				    
						      //   echo count($a_contenido).'-'.count($b_detalle).'-'.$c_IdMenu;
						      echo 1;
						}else{
                              echo 0;
				        }



function guardar($nom_ar,$utl,$tpa,$img_deta){
  global $db,$mp4,$arreglo_archivos,$tipo_archivo,$b_detalle;
  $bandera = 0;
  
    $mayor = " SELECT IF(MAX(ORDEN) IS NULL,1,MAX(ORDEN)+1) AS MAXIMO FROM CAT_CONTENIDO WHERE ID_SUBMENU  =".$_GET['id_menus'];
	$query_mayor = $db->sqlQuery($mayor);

	if($query_mayor){  // --------------------------------------------query mayor
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
                 VALUES ('".$_GET['id_menus']."','/USUARIO1/','http://".$_SERVER['HTTP_HOST']."/".
				           ($utl)."/".reemplaza(str_replace(" ","_",utf8_decode($nom_ar)))."','".
						    $tipo_archivo."','".$row_mayor['MAXIMO']."')";
		  	
			  $queri = $db->sqlQuery($sqlZ); 
	      
		          if($queri){ // se ejecuta el query de insercion en la tabla de contenido
					    
						$ultimo = "SELECT LAST_INSERT_ID() AS IDCONT FROM CAT_CONTENIDO;";
		   	            $query_ultimo = $db->sqlQuery($ultimo); 
		   	   
				       if($query_ultimo){ // si se ejecuta el querry $query_ultimo
		   	   	          $row_ultimo = $db->sqlFetchArray($query_ultimo);
						   if(guardar_detalle($row_ultimo['IDCONT'],$b_detalle[0],$b_detalle[1],$b_detalle[2],$b_detalle[3],$b_detalle[4],$img_deta)){
			   	     		  $bandera = 1;
			   	     	   }else{
			   	     		  $bandera = 0;
			   	     	   }
		   	    	  }else{ // si no se ejecuta el querry $query_ultimo
		              	 $bandera = 0;
		              }
		              
		              	if($row_mayor['MAXIMO']>'1'){
					    	$ACT = "UPDATE CAT_SUBMENU SET ACCION = 'D' WHERE ID_SUBMENU =".$_GET['id_menus'];
							$queria = $db->sqlQuery($ACT); 
		       					if($queria){
	       						    $bandera = 1;
					            }else {
					            	$bandera = 0;
					            }
				    	}
					if($mp4==='mp4'){
					  actualiza_mp4();
					}
					  
	              }else{
	              	 $bandera = 0;
	              }
	
	
	   
	}else{  // ------------------ si no se ejecuto el query : $query_mayor
	    $bandera = 0;
	}

 if($bandera ==1){
   return true; 	
 }else{
 	return false;
 }
}	

//----------------------- funcion que reemplaza caracteres 

function reemplaza($cadena_x){
		$regresa = '';
		$a = array('á','Á','é','É','í','Í', 'ó','Ó', 'ú','Ú', 'ñ', 'Ñ',' ');
		$b = array('a','A','e','E','i','I', 'o' ,'O', 'u','U', 'n', 'N', '_');
		
		$regresa = str_replace($a, $b,$cadena_x);
		return $regresa;
   }	
/*
//_-----------------------------------------------------  funciones 
function guardar($nom_ar,$utl,$tpa,$img_deta){
	global $db,$mp4,$arreglo_archivos,$tipo_archivo,$b_detalle;
	
    $mayor = " SELECT IF(MAX(ORDEN) IS NULL,1,MAX(ORDEN)+1) AS MAXIMO FROM CAT_CONTENIDO WHERE ID_SUBMENU  =".$_GET['id_menus'];
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
             VALUES ('".$_GET['id_menus']."','/USUARIO1/','http://".$_SERVER['HTTP_HOST']."/".($utl)."/".reemplaza(str_replace(" ","_",utf8_decode($nom_ar)))."','".$tipo_archivo."','".$row_mayor['MAXIMO']."')";
		  	$queri = $db->sqlQuery($sqlZ); 
	      
		          if($queri){
		   	
		   	            $ultimo = "SELECT LAST_INSERT_ID() AS IDCONT FROM CAT_CONTENIDO;";
		   	            $query_ultimo = $db->sqlQuery($ultimo); 
		   	   
				       if($query_ultimo){
		   	   	          $row_ultimo = $db->sqlFetchArray($query_ultimo);
	//	if(guardar_detalle($row_ultimo['IDCONT'],$b_detalle[0],$b_detalle[1],$b_detalle[2],$b_detalle[3],$b_detalle[4],$img_deta)){
		   	     		  $T = 1;
		   	     	   }else{
		   	     		  $T = 0;
		   	     	   }
		   	     }
					//if($row_mayor['MAXIMO']>'1'){
//						$ACT = "UPDATE CAT_SUBMENU SET ACCION = 'D' WHERE ID_SUBMENU =".$_GET['id_menus'];
//							$queria = $db->sqlQuery($ACT); 
//	       					if($queria){
//       						    $T = 1;
//				            }else {
//				            	$T = 0;
//				            }
//					}
//					if($mp4==='mp4'){
//						actualiza_mp4();
//					}
					  // $T = 1;
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

*/
//-------------------------------------------
  function actualiza_mp4(){
  	global $db,$mp4;
  	  $ACT = "UPDATE CAT_SUBMENU SET ITEM_NUMBER = 'm_vc', ACCION = 'V'  WHERE ID_SUBMENU =".$_GET['id_menus'];
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


?>