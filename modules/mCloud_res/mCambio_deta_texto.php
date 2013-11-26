<?php
    header('Content-Type: text/html; charset=UTF-8');
 	$db  = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

  
    if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	
	     $UTF8 = "SET NAMES 'utf8'";
         $db->sqlQuery($UTF8);
    
	
	$ima_a = explode("|",$_GET['pakete']);
	
	
	
    	$sqlX= "UPDATE CAT_CONTENIDO_DETALLE 
				SET
				TITULO = '".$ima_a[0]."' , 
				NOMBRE_AUTOR = '".$ima_a[1]."' , 
				RESUMEN = '".$ima_a[2]."' , 
				TAG = '".$ima_a[3]."' , 
				ID_EVENTO = '".$ima_a[4]."' 
				
				WHERE
				ID_CONTENIDO_DETALLE = ".$_GET['id_contenido'];
			
     $queriX = $db->sqlQuery($sqlX);

	if($queriX){
		echo $sqlX;
	}else{
		
		echo 0;
	}
     
?>
