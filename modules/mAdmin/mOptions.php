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

	if(isset($_POST['id_company']) && isset($_POST['id_client'])){
		$id_company = $_POST['id_company'];
		$id_client  = $_POST['id_client'];
		
		$company = $dbf->getRow('ADM_EMPRESAS','ID_EMPRESA='.$id_company);
		$client  = $dbf->getRow('ADM_CLIENTES','ID_CLIENTE='.$id_client);		 
		$menu    = $userAdmin->obtener_menu_admin();
		
		$tpl->assign_vars(array(
			'PAGE_TITLE'	=> 'M&oacute;dulo Clientes',	
			'PATH'			=> $dir_mod,
			'HEADER'		=> $userAdmin->getHeaderAdmin('Administración de Clientes','user'),
			'COMPANY'		=> $company['DESCRIPCION'],
			'COMPANY_ID'	=> $id_company,
			'CLIENT'		=> $client['NOMBRE'],
			'CLIENT_ID'		=> $id_client,
			'MENU'			=> $menu
		));	
	}else{
		echo '<script>window.location="index.php?m=mAdmin&c=mEmpresas"</script>';
	}

	$tpl->set_filenames(array('mOptions'=>'tOptions'));		 
	
	$tpl->pparse('mOptions');
?>