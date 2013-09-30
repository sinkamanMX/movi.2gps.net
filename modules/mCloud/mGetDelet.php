<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
 	$db  = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	$T=$_GET['tipo'];
	$ct='-';
	$utl= $_GET['ulr'];
	
	if($T==1){
    	$do = unlink($utl);
 		if($do != true){
		   echo 0;
		}else{
	      // echo 1;
	      if($_GET['where'] != '0'){
	      	 $sqlZ = "DELETE FROM CAT_CONTENIDO WHERE ".$_GET['where'];
			 $queri = $db->sqlQuery($sqlZ);
		
			if($queri){
				$j = explode("AND",$_GET['where']);
				 $mayor = " SELECT COUNT(ID_SUBMENU) AS MAXIMO FROM CAT_CONTENIDO WHERE ".$j[0];
				 $query_mayor = $db->sqlQuery($mayor);
				if($query_mayor){
					  $row_mayor = $db->sqlFetchArray($query_mayor);
		   		    if($row_mayor['MAXIMO']=='1'){
		   		    		$ACT = "UPDATE CAT_SUBMENU SET ACCION = 'F' WHERE ".$j[0];
							$queria = $db->sqlQuery($ACT); 
	       					if($queria){
	       							$ACT2 = "UPDATE CAT_CONTENIDO SET ORDEN = '".$row_mayor['MAXIMO']."' WHERE ".$j[0];
										$queria2 = $db->sqlQuery($ACT2); 
				       					if($queria2){
				       						echo 1;
							            }else{
							    		    echo 0;		
							   			}
				            }else{
				    		echo 0;		
				   			}
		   		    }
					   
		   		}else{
		    		echo 0;		
		   		}
		 //------------------------------------------------------------------------------------------  		
		   		 $ITNM = " SELECT ITEM_NUMBER AS ITN FROM CAT_SUBMENU WHERE ".$j[0];
				 $query_itnm = $db->sqlQuery($ITNM);
				 if($query_itnm){
				 	    $row_itnm = $db->sqlFetchArray($query_itnm);
				 	  if($row_itnm['ITN']==='m_vc'){
				        $ACT3 = "UPDATE CAT_SUBMENU SET ITEM_NUMBER = '----' WHERE ".$j[0];
						$queria3 = $db->sqlQuery($ACT3); 
    		            if($queria3){
				       		echo $ITNM;
						 }else{
							 echo $ITNM;		
						}	
				 	  	
				 	  }

				 }
		   		 //------------------------------------------------------------------------------------------  	
		   		
		   	}else{
		    	echo 0;		
		   	}
	      }else{
	      	echo 1;
	      }
		   
	    }
	}else{
		if(eliminarDir($utl)){
			$borar = explode(",",$_GET['where']);
			 $CORTA = '';
			
			if($borar[1]=='0'){ // borrar dato de la tabla 
			  $sqlZ0 = "SELECT ID_SUBMENU FROM  CAT_SUBMENU WHERE ID_MENU = ".$borar[0];
			   $queri0 = $db->sqlQuery($sqlZ0);
			   	if($queri0){
		   		    while($rowZ = $db->sqlFetchArray($queri0)){
		   		   	  if($CORTA == ''){
		   		   	  	$CORTA = $rowZ['ID_SUBMENU'];
		   		   	  }else{
   		   	  		    $CORTA = $CORTA .','.$rowZ['ID_SUBMENU'];
		   		   	  }
		   		   	}
			    }
			
						   	$sqlZ3 = "DELETE FROM CAT_CONTENIDO WHERE ID_SUBMENU IN (".$CORTA.")"; // borra contenido
						    $queri3 = $db->sqlQuery($sqlZ3);
					
							if($queri3){
								 $sqlZ2 = "DELETE FROM CAT_SUBMENU WHERE ID_MENU =".$borar[0]; // borra submenu
					             $queri2 = $db->sqlQuery($sqlZ2);
				
								    if($queri2){
								    $sqlZ = "DELETE FROM CAT_MENU WHERE ID_MENU = ".$borar[0];  // borrar menu
								   $queri = $db->sqlQuery($sqlZ);
							
									if($queri){ 	
								   		echo 1;
								   	}else{
								    	echo 0;		
								   	}	
					   	}else{
					    	echo 0;		
					   	}	
			   	}else{
			    	echo 0;		
			   	}	
			}else{
			
			                $sqlZ3 = "DELETE FROM CAT_CONTENIDO WHERE ID_SUBMENU IN (".$borar[1].")";
						    $queri3 = $db->sqlQuery($sqlZ3);
					
							if($queri3){
						   		$sqlZ2 = "DELETE FROM CAT_SUBMENU WHERE ID_SUBMENU =".$borar[1];
					             $queri2 = $db->sqlQuery($sqlZ2);
					             if($queri2){
					             	echo 1;
							   	}else{
							    	echo 0;		
							   	}	
					   	}else{
					    	echo 0;		
					   	}	
				
			}
		}
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
