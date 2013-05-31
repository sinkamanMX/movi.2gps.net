<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
 *  @modificado          27042011
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],
				  $config_bd['user'],$config_bd['pass']);
	
	$userData = new usersAdministration();
	if(!$userAdmin->u_logged()){
			echo '<script>window.location="index.php?m=login"</script>';
	}

	$validate = $dbf->getRow('ADM_USUARIOS_SUPER',' ID_USUARIO = '.$userAdmin->user_info['ID_USUARIO']);	
	$list_options='';
	if($validate){		
		if($validate['NIVEL']==0){	
			$tpl->set_filenames(array('mEmpresas'=>'tEmpresas'));		 
			
			$tpl->assign_vars(array(
				'PAGE_TITLE'	=> 'M&oacute;dulo Empresas',	
				'PATH'			=> $dir_mod,
				'HEADER'		=> $userAdmin->getHeaderAdmin('Administración de Empresas','emp',true)
			));	
			$tpl->pparse('mEmpresas');				
		}else{		
			echo '<script>window.location="index.php?m=mAdmin&c=mClientes"</script>';
		}				
	}else{
		echo '<script>window.location="index.php?m=login"</script>';	
	}
?>