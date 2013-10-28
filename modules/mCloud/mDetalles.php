<?php
    header('Content-Type: text/html; charset=UTF-8');
 	$db  = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

  
    if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	
	
		$tpl->set_filenames(array('mDetalles' => 'tDetalles'));
		
    	$sqlX= "SELECT A.* FROM CAT_CONTENIDO_DETALLE A 
				INNER JOIN CAT_CONTENIDO B ON A.ID_CONTENIDO=B.ID_SUBMENU_CONTENIDO
				WHERE ".$_GET['deta'];
			
    $queriX = $db->sqlQuery($sqlX);
//	    
	$count = $db->sqlEnumRows($queriX);

//
	if($count>0){
	
	         while($rowX = $db->sqlFetchArray($queriX)){
			 
			 $valor_combo = $rowX['ID_EVENTO'];
			  $img_det = '';
			  $img_fuente = '';
			  
			    if($rowX['IMAGEN'] ==='NO' || $rowX['IMAGEN'] === NULL ){
				   $img_det = '<h4 style="position:relative; top:35%;">No disponible </h4>';
				    $img_fuente = '0';
				}else{
				
				 $img_det = '<img style=" border:#000000 solid 0px;" src="'.$rowX['IMAGEN'].'" width="200" height="260" />';
				 $img_fuente = $rowX['IMAGEN'];
				}
	      	    $tpl->assign_vars(array(
						'ID_DET'        => $rowX['ID_CONTENIDO_DETALLE'],
						'ID_CONTENIDO'  => $rowX['ID_CONTENIDO'],
						'TITULO'        => $rowX['TITULO'],
						'NOMBRE_AUTOR'  => $rowX['NOMBRE_AUTOR'],
						'RESUMEN'       => $rowX['RESUMEN'],
						'TAG'           => $rowX['TAG'],
						'ID_EVENTO'     => $rowX['ID_EVENTO'],
						'IMAGEN'        => $img_det,
						'FUENTE_IMG'    => $img_fuente,
						'GUERE'         => $_GET['deta']
				));
          }
		
	}else{
		
		echo 0;
	}
     
	//--------------------------------------
	
	$sqlz= "SELECT COD_EVENT,DESCRIPTION FROM ADM_EVENTOS
			WHERE ID_CLIENTE = ".$userAdmin->user_info['ID_CLIENTE'];
			
$queriz = $db->sqlQuery($sqlz);
//	    
	$countz = $db->sqlEnumRows($queriz);
    $OPCION ='';
//
	if($countz>0){
		
	         while($rowz = $db->sqlFetchArray($queriz)){
			 if($valor_combo== $rowz['COD_EVENT']){
			 $OPCION ='selected="selected"';
			 }else{
			  $OPCION ='';
			 }
	      	    $tpl->assign_block_vars('eventox',array(
						'COD_EVENTO'   => $rowz['COD_EVENT'],
						'DESCRTIPCION'  => $rowz['DESCRIPTION'],
						'SELEC' =>     $OPCION
				));
          }
		
	}else{
		
		echo 0;
	}	
	
	$tpl->pparse('mDetalles');
?>
