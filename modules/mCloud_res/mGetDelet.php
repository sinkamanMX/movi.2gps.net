<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
 	$db  = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	$T=$_GET['tipo'];
	$ct='-';
	$utl= $_GET['ulr'];
   	$j = explode("AND",$_GET['where']);
	if($T=='1'){
    	$do = unlink($utl);
 		if($do != true){
		   echo -1 .'-'.$utl;
		}else{
	      // echo 1;
	      if($_GET['where'] != '0'){
	      	
	      //	$j = explode("AND",$_GET['where']);
	      	 $sqlA = "SELECT A.ID_CONTENIDO_DETALLE FROM CAT_CONTENIDO_DETALLE A
					  INNER JOIN CAT_CONTENIDO B ON A.ID_CONTENIDO= B.ID_SUBMENU_CONTENIDO
					  WHERE B.".$j[0];
			//	echo	$sqlA;		
			        $queriA = $db->sqlQuery($sqlA);	
					 $rowI = $db->sqlFetchArray($queriA);
				   	if($queriA){
				   	
				   	    $QL = "DELETE FROM CAT_CONTENIDO_DETALLE WHERE ID_CONTENIDO_DETALLE =".$rowI['ID_CONTENIDO_DETALLE'];	
				   		$queriB = $db->sqlQuery($QL);
				     	if($queriB){
			   		      echo 1;
			   		    }
				    }
	      	
	      	
	      	 $sqlZ = "DELETE FROM CAT_CONTENIDO WHERE ".$_GET['where'];
			 $queri = $db->sqlQuery($sqlZ);
		
			if($queri){
			
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
							    		    echo -2;		
							   			}
				            }else{
				    		echo -3;		
				   			}
		   		    }
		   		    
		   	
		   		    
					echo 1;
		   		}else{
		    		echo -4;		
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
		    	echo -5;		
		   	}
	      }else{
	      	echo 1;
	      }
		   
	    }
	}else{
		if(eliminarDir($utl)){
			 $borar = explode(",",$_GET['where']);
			 $CORTA = '';
		     $cant_submenu = 0;
		     $cant_contenidos = 0;
		//	echo "where = ".$_GET['where'].'|'.$borar[1];
		
			if($borar[1]=='0'){ // borrar dato de la tabla para cuando se quiere borrar menu 	/**********************************************/
	  
		$sqlZ0 = "SELECT ID_SUBMENU FROM  CAT_SUBMENU WHERE ID_MENU = ".$borar[0];  // 1) se busca todos los submenus que pertenezcan a este menu
			   $queri0 = $db->sqlQuery($sqlZ0);
			   	if($queri0){
	   			    $cant_submenu = $db->sqlEnumRows($queri0);
		   		    while($rowZ = $db->sqlFetchArray($queri0)){
		   		   	  if($CORTA == ''){
		   		   	  	$CORTA = $rowZ['ID_SUBMENU'];
		   		   	  }else{
   		   	  		    $CORTA = $CORTA .','.$rowZ['ID_SUBMENU'];
		   		   	  }
		   		   	}
			    }
			    
		
				
		if($cant_submenu>0){  // si existen submenus, se debe de buscar contenidos dados de alta para los submenus
		
				$sqlAx = "SELECT A.ID_CONTENIDO_DETALLE FROM CAT_CONTENIDO_DETALLE A
					      INNER JOIN CAT_CONTENIDO B ON A.ID_CONTENIDO= B.ID_SUBMENU_CONTENIDO
					      WHERE B.ID_SUBMENU IN(".$CORTA.")";
				
			            $queriAx = $db->sqlQuery($sqlAx);	
					    $cant_contenidos = $db->sqlEnumRows($queriAx);
				
				
				        if($cant_contenidos>0){ // si existen contenidos en cualquier submenu 
								
								while($rowIx = $db->sqlFetchArray($queriAx)){
					   		   	  if($no == ''){
					   		   	  	$no = $rowIx['ID_CONTENIDO_DETALLE'];
					   		   	  }else{
			   		   	  		    $no = $no .','.$rowIx['ID_CONTENIDO_DETALLE'];
					   		   	  }
					        	}  
		
	//	echo $no;
	
	// despues de buscar contenidos se deben de borrar los datos de las tablas correspondientes.
	 $sql_borrar_usu_sub = "DELETE FROM CAT_USUARIO_SUBMENU WHERE ID_SUBMENU IN (".$CORTA.")";
	 $queri_sub_usu = $db->sqlQuery($sql_borrar_usu_sub);
	 if($queri_sub_usu){
			$QLx = "DELETE FROM CAT_CONTENIDO_DETALLE WHERE ID_CONTENIDO_DETALLE IN (".$no.")";	
				   		$queriBx = $db->sqlQuery($QLx);
				     	if($queriBx){
				     		$sqlZ3 = "DELETE FROM CAT_CONTENIDO WHERE ID_SUBMENU IN (".$CORTA.")";
						    $queri3 = $db->sqlQuery($sqlZ3);
							if($queri3){
								
						
							//----------------------		
								 $sqlZ2 = "DELETE FROM CAT_SUBMENU WHERE ID_MENU =".$borar[0]; // borra submenu
					             $queri2 = $db->sqlQuery($sqlZ2);
				
								    if($queri2){
									    $sqlZ = "DELETE FROM CAT_MENU WHERE ID_MENU = ".$borar[0];  // borrar menu
									   $queri = $db->sqlQuery($sqlZ);
								
										if($queri){ 	
									   		echo "pos acabo todo";
									   	}else{
									    	echo -6;		
									   	}	
								   	}else{
								    	echo -7;		
								   	}
							//----------------------	
							     }	   	
							}
			     		}
				}else{
					 $aja_submenu = '';
					 $busca_usu_submenu =  "SELECT * FROM CAT_SUBMENU WHERE ID_MENU =".$borar[0];
					 $queri_busca_su = $db->sqlQuery($busca_usu_submenu);
					 if($queri_busca_su){
					  		while($rowIBUS = $db->sqlFetchArray($queri_busca_su)){
					   		   	  if($aja_submenu == ''){
					   		   	  	$aja_submenu = $rowIBUS['ID_SUBMENU'];
					   		   	  }else{
			   		   	  		    $aja_submenu = $aja_submenu .','.$rowIBUS['ID_SUBMENU'];
					   		   	  }
					        	}  
				  	 }
					
	 $sql_borrar_usu_sub = "DELETE FROM CAT_USUARIO_SUBMENU WHERE ID_SUBMENU IN (".$aja_submenu.")";
	 $queri_sub_usu = $db->sqlQuery($sql_borrar_usu_sub);
	 if($queri_sub_usu){
					 $sqlZ2 = "DELETE FROM CAT_SUBMENU WHERE ID_MENU =".$borar[0]; // borra submenu
					             $queri2 = $db->sqlQuery($sqlZ2);
				              
								    if($queri2){
										    $sqlZ = "DELETE FROM CAT_MENU WHERE ID_MENU = ".$borar[0];  //se borro una carpeta sub menu vacia y de menu
											   $queri = $db->sqlQuery($sqlZ);
					
												if($queri){ 
									    	      echo "SE ELIMINO UNA CARPETA SUBMENU CON URL O VACIA y CARPETA MENU";
											    }
						    	
								
								}
				  }	
				}
					    

		}else{
			$sqlZ = "DELETE FROM CAT_MENU WHERE ID_MENU = ".$borar[0];  // borrar menu vacio
									   $queri = $db->sqlQuery($sqlZ);
								
										if($queri){ 
							    	 echo "se borro una carpeta menu vacia";
									}
			
		}
			

			}else{    /**********************************  en esta opcion se evalua cuando llega (0,X) si X>0 ES DECIR, ES SUBMENU *************/
				echo "-- where = ".$_GET['where']."-------";
				$k = explode(",",$_GET['where']);
				$no = '';
            $sqlAx = "SELECT A.ID_CONTENIDO_DETALLE FROM CAT_CONTENIDO_DETALLE A
					  INNER JOIN CAT_CONTENIDO B ON A.ID_CONTENIDO= B.ID_SUBMENU_CONTENIDO
					  WHERE B.ID_SUBMENU =".$k[1];
				echo	$sqlAx;		
			            $queriAx = $db->sqlQuery($sqlAx);	
					   $cant_contenidos = $db->sqlEnumRows($queriAx);
					   
					if($cant_contenidos>0){
						 while($rowIx = $db->sqlFetchArray($queriAx)){
					   		   	  if($no == ''){
					   		   	  	$no = $rowIx['ID_CONTENIDO_DETALLE'];
					   		   	  }else{
			   		   	  		    $no = $no .','.$rowIx['ID_CONTENIDO_DETALLE'];
					   		   	  }
					   	}  
					    
			        
			 $sql_borrar_usu_sub = "DELETE FROM CAT_USUARIO_SUBMENU WHERE ID_SUBMENU =".$borar[1];
			 $queri_sub_usu = $db->sqlQuery($sql_borrar_usu_sub);
				 if($queri_sub_usu){	
						$QLx = "DELETE FROM CAT_CONTENIDO_DETALLE WHERE ID_CONTENIDO_DETALLE IN (".$no.")";	
				   		$queriBx = $db->sqlQuery($QLx);
				     	if($queriBx){
				     		    	
			                $sqlZ3 = "DELETE FROM CAT_CONTENIDO WHERE ID_SUBMENU IN (".$borar[1].")";
						    $queri3 = $db->sqlQuery($sqlZ3);
					
							if($queri3){
						   		$sqlZ2 = "DELETE FROM CAT_SUBMENU WHERE ID_SUBMENU =".$borar[1];
					             $queri2 = $db->sqlQuery($sqlZ2);
					             if($queri2){
					              	echo 1;
							   	}else{
							    	echo -10;		
							   	}
								   
								   
				   				}else{
							    	echo -9;		
							   	}	
					   	}else{
					    	echo -10;		
					   	}
						   
				     }
				}else{
					
				    $BUSCA_OTR_SUB = "SELECT * FROM CAT_USUARIO_SUBMENU WHERE ID_SUBMENU =".$borar[1];
				    $QUERY_BUSCA = $db->sqlQuery($BUSCA_OTR_SUB);
				    
				    if($QUERY_BUSCA){
				    	 $countzz = $db->sqlEnumRows($QUERY_BUSCA);
				    	 if($countzz>0){
				  		$sql_borrar_usu_sub = "DELETE FROM CAT_USUARIO_SUBMENU WHERE ID_SUBMENU =".$borar[1];
			 			$queri_sub_usu = $db->sqlQuery($sql_borrar_usu_sub);
							 if($queri_sub_usu){
				    	        $sqlZ2 = "DELETE FROM CAT_SUBMENU WHERE ID_SUBMENU =".$borar[1];
					             $queri2 = $db->sqlQuery($sqlZ2);
					             if($queri2){
					             	echo 1;
							   	}else{
							    	echo -9;		
							   	}	
							 } 	
				    	 }else{
				    	 	$sqlZ2 = "DELETE FROM CAT_SUBMENU WHERE ID_SUBMENU =".$borar[1];
					             $queri2 = $db->sqlQuery($sqlZ2);
					             if($queri2){
					             	echo 1;
							   	}else{
							    	echo -9;		
							   	}	
				    	 	
				    	 }
				    }
					
				   	
				}   
		   	
				
			}
		}else{
			echo "pos fallo desde aqui";
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