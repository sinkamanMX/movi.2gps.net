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
	
	if(isset($_POST['id_company'])){
		$id_company = $_POST['id_company'];
		
		$company = $dbf->getRow('ADM_EMPRESAS','ID_EMPRESA='.$id_company);
		$tpl->set_filenames(array('mClientes'=>'tClientes'));		 
		
		$tpl->assign_vars(array(
			'PAGE_TITLE'	=> 'M&oacute;dulo Clientes',	
			'PATH'			=> $dir_mod,
			'HEADER'		=> $userAdmin->getHeaderAdmin('Administración de Clientes','user'),
			'COMPANY'		=> $company['DESCRIPCION'],
			'COMPANY_ID'	=> $id_company,
			'ALL_PERMS'		=> '1'
		));	
		$tpl->pparse('mClientes');		
	}else{
		$validate = $dbf->getRow('ADM_USUARIOS_SUPER',' ID_USUARIO = '.$userAdmin->user_info['ID_USUARIO']);	
		$list_options='';
		if($validate){		
			if($validate['NIVEL']==0){
				echo '<script>window.location="index.php?m=mAdmin&c=mEmpresas"</script>';
			}else{		
				
				$id_company = $userAdmin->user_info['ID_EMPRESA'];
				
				$company = $dbf->getRow('ADM_EMPRESAS','ID_EMPRESA='.$id_company);				
				$tpl->set_filenames(array('mClientes'=>'tClientes'));		 
				
				$tpl->assign_vars(array(
					'PAGE_TITLE'	=> 'M&oacute;dulo Clientes',	
					'PATH'			=> $dir_mod,
					'HEADER'		=> $userAdmin->getHeaderAdmin('Administración de Clientes','user'),
					'COMPANY'		=> $company['DESCRIPCION'],
					'COMPANY_ID'	=> $id_company,
					'ALL_PERMS'		=> '0'
				));	
				$tpl->pparse('mClientes');					
			}				
		}else{
			echo '<script>window.location="index.php?m=login"</script>';	
		}
	}
?>