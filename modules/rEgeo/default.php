<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @modificado          08-08-2013
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	$sqlGroups = "FROM ADM_USUARIOS_GRUPOS
				INNER JOIN ADM_GRUPOS          
					ON ADM_GRUPOS.ID_GRUPO = ADM_USUARIOS_GRUPOS.ID_GRUPO
				WHERE ADM_USUARIOS_GRUPOS.ID_USUARIO = ".$userAdmin->user_info['ID_USUARIO']."
				GROUP BY ADM_GRUPOS.ID_GRUPO";
	$groups = $dbf->cbo_from_query('ADM_GRUPOS.ID_GRUPO','ADM_GRUPOS.NOMBRE',$sqlGroups,'',true);
	
	$tpl->set_filenames(array('default'=>'default'));		 
	
	$tpl->assign_vars(array(
		'PAGE_TITLE'	=> 'Reporte de Estancia en Geopuntos',	
		'PATH'			=> $dir_mod,
		'GROUPS'		=> $groups
	));	
	$tpl->pparse('default');
?>