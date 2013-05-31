<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	$id_perfil='';
	$control  =0;
	$id_client = $_GET['id_client'];
	/*Se valida la variaable data, si esta viene y es diferente de 0 es uan edicion*/
	if(isset($_GET['data']) || $_GET['data'] !=0){	
		$id_perfil = $_GET['data']; 
		$data_perfil = $dbf->getRow('ADM_PERFILES','ID_PERFIL = '.$_GET['data']);		
	}
	
	$estatus = $dbf->cbo_from_enum('ADM_PERFILES','ESTATUS',@$data_perfil['ESTATUS']);
	$permisos='';
	
	$sql = "SELECT ADM_MENU.DESCRIPCION,ADM_SUBMENU.ID_MENU,ADM_SUBMENU.ID_SUBMENU, ADM_SUBMENU.DESCRIPTION
			FROM ADM_MENU_TIPO 
			INNER JOIN ADM_MENU 	ON ADM_MENU_TIPO.ID_MENU = ADM_MENU.ID_MENU
			 LEFT JOIN ADM_SUBMENU 	ON ADM_SUBMENU.ID_MENU = ADM_MENU.ID_MENU
			 LEFT JOIN ADM_SUBMENU_CLIENTES ON ADM_SUBMENU_CLIENTES.ID_SUBMENU  = ADM_SUBMENU.ID_SUBMENU  
			WHERE ADM_MENU_TIPO.ID_TIPO_USUARIO 	= ".$userAdmin->user_info['ID_TIPO_USUARIO']."
			 AND  ADM_MENU.TIPO='W'
			 AND  ADM_SUBMENU_CLIENTES.ID_CLIENTE  	= ".$id_client."
			ORDER BY ADM_MENU_TIPO.ORDEN ASC";
	$query = $db->sqlQuery($sql);
  	$count = $db->sqlEnumRows($query);
  	if($count>0){
  		while($row = $db->sqlFetchArray($query)){
  			if($control!=$row['ID_MENU']){
  				$permisos .= ($permisos!="") ? '</table></div>': '';
  				$permisos .= '<h3>'.$Functions->codif($row['DESCRIPCION']).'</h3><div><table class="total_width">';
  				$control   = $row['ID_MENU'];
  			}
  			
  			$info_permiso = $dbf->getRow('ADM_PERFIL_PERMISOS','ID_PERFIL = '.$id_perfil.
			  												' AND ID_SUBMENU = '.$row['ID_SUBMENU']);
			$id_permiso   = ($info_permiso['ID_PERMISO']) ? $info_permiso['ID_PERMISO']: '';
			$selected     = ($info_permiso['ID_PERMISO']) ? 'icon_unit_selected': 'icon_unit_unselected';
			$disabled     = (!$info_permiso['ID_PERMISO']) ? 'disabled=""': '';
			
			$permisos .= '<tr><td>'.
							'<div id="pro_acordeon_icon_'.$row['ID_SUBMENU'].'" class="'.$selected.
								'" onclick="pro_select_menu('.$row['ID_SUBMENU'].')">'.
			"<img class='total_width total_height' ".
			"src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>".
			'</div>'.
                         '</td><td>'.$Functions->codif($row['DESCRIPTION']).'</td>'.
						 '<td  align="right"><div>'.
				 				'<select id="pro_select'.$row['ID_SUBMENU'].'" '.$disabled.' class="pro_caja">';
			$permisos .= $dbf->cbo_from('ID_PERMISO','DESCRIPCION','ADM_PERMISOS','1=1',$id_permiso);
			$permisos .= '</select><div></td></tr>';
		}
  	}
	  	
	$tpl->set_filenames(array('mSetPerfil' => 'tEdit'));
	$tpl->assign_vars(array(
		'ID'		=> $id_perfil,
		'NAME'		=> @$data_perfil['DESCRIPCION'],
		'ESTATUS'	=> $estatus,
		'PERMISOS'	=> $permisos
	));	
	$tpl->pparse('mSetPerfil');	
?>