<?php
/** *  
 *  @name                Pagina default del modulo para administradores 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña
 *  @modificado          23-04-2012
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],
			      $config_bd['user'],$config_bd['pass']);
	
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	
	$validate = $dbf->getRow('ADM_USUARIOS_SUPER',' ID_USUARIO = '.$userAdmin->user_info['ID_USUARIO']);	
	$list_options='';
	if($validate){		
		if($validate['NIVEL']==0){
			echo '<script>window.location="index.php?m=mAdmin&c=mEmpresas"</script>';
		}else{			
			echo '<script>window.location="index.php?m=mAdmin&c=mClientes"</script>';	
		}				
	}else{
		echo '<script>window.location="index.php?m=login"</script>';	
	}
?>