<?php
/**  
 * Obtiene el formulario para configurar un widget 
 * @package dahsboard
 * @author	Enrique R. Peña Gonzalez
 * @since	2013-08-13
 */

	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],
							     	 $config_bd['user'],$config_bd['pass']);

	if(isset($_GET['data']) && isset($_GET['id'])){
		$idWidget	= $_GET['data'];  
		$idRow 	= $_GET['id'];
			
		$infoWidget = $dbf->getRow('WGT_WIDGETS','ID_WIDGET = '.$idWidget);					     	 
		$tpl->set_filenames(array('mConfigWidget'=>'configWidget'));
		
		$tpl->assign_vars(array(
			'PATH'			=> $dir_mod,
			'PATH_IMG'		=> $dir_pimages,
			'ID_ROW'		=> $idRow,
			'ID_WIDGET'		=> $infoWidget['ID_WIDGET'],
			'NOMBRE_WIDGET'	=> $infoWidget['NOMBRE']
		));
		
		$tpl->pparse('mConfigWidget');		
	}else{
		echo "<h2>Error al mostrar el Widget.</h2>";
	}