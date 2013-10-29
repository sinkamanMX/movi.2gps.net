<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	$id_row	= 0;
	$control= 0;
	$u_unselected = '';
	$a_units_selected='';
	/*Se valida la variaable data, si esta viene y es diferente de 0 es uan edicion*/
	if(isset($_GET['data']) || $_GET['data'] !="0"){	
		$id_row 	= $_GET['data']; 
		$data_row 	= $dbf->getRow('ADM_USUARIOS','ID_USUARIO = '.$_GET['data']);
		
		$sql_units = "SELECT ADM_USUARIOS_GRUPOS.COD_ENTITY, 
							CONCAT(IF(PLAQUE IS NULL,'NP',PLAQUE),'-', IF(DESCRIPTION IS NULL,'',DESCRIPTION)) AS UNIDAD,
						ADM_USUARIOS_GRUPOS.ID_GRUPO
						FROM ADM_USUARIOS_GRUPOS 
						INNER JOIN ADM_UNIDADES ON ADM_UNIDADES.COD_ENTITY  = ADM_USUARIOS_GRUPOS.COD_ENTITY
						WHERE ID_USUARIO  =  ".$id_row;
		$query_units = $db->sqlQuery($sql_units);
		$units_count = $db->sqlEnumRows($query_units);  		
  		if($units_count){
  			while($data_units = $db->sqlFetchArray($query_units)){				
				$u_selected .= '<li id="'.$data_units['COD_ENTITY'].'" value="'.$data_units['ID_GRUPO']
							.'"  tittle="'.$data_units['ID_GRUPO'].'" class="ui-state-default">'.
							'<a href="javascript:void(0)">'.
								$data_units['UNIDAD'].
							'</a><span style="display:none;">'.$data_units['COD_ENTITY'].'|'.
															   $data_units['ID_GRUPO']
							.'</span></li>';		
  			}
  		}			 			
	}	
	
	$estatus = $dbf->cbo_from_enum('ADM_USUARIOS','ESTATUS',@$data_row['ESTATUS']);
	$where_module = 'ID_SUBMENU IN (SELECT ID_SUBMENU 
						FROM ADM_SUBMENU_CLIENTES WHERE ID_CLIENTE = '.$userAdmin->user_info['ID_CLIENTE'].')'.
						'AND TIPO ="M" ';
	$modulos = $dbf->cbo_from('ID_SUBMENU','DESCRIPTION','ADM_SUBMENU',$where_module);
	
	$where_perfil  = " ID_PERFIL IN (SELECT ID_PERFIL
						FROM ADM_PERFILES_CLIENTES
						WHERE ID_CLIENTE  = ".$userAdmin->user_info['ID_CLIENTE'].")";
	
	$perfil  = $dbf->cbo_from('ID_PERFIL','DESCRIPCION','ADM_PERFILES',$where_perfil,@$data_row['ID_PERFIL']);
	
	if(@$data_row['ID_PERFIL']>0){ //se pintan los permisos
		$control  =0;
		$permisos ='';
		$sql = "SELECT ADM_SUBMENU.ID_MENU,ADM_MENU.DESCRIPCION AS MENU ,ADM_SUBMENU.DESCRIPTION AS SUBMENU, 
                       ADM_PERMISOS.DESCRIPCION AS NPERMISO					
				FROM ADM_PERFIL_PERMISOS
				INNER JOIN ADM_PERMISOS ON ADM_PERMISOS.ID_PERMISO = ADM_PERFIL_PERMISOS.ID_PERMISO
				INNER JOIN ADM_SUBMENU  ON ADM_SUBMENU.ID_SUBMENU  = ADM_PERFIL_PERMISOS.ID_SUBMENU
				INNER JOIN ADM_MENU     ON ADM_MENU.ID_MENU	 = ADM_SUBMENU.ID_MENU 
				WHERE ID_PERFIL = ".@$data_row['ID_PERFIL'];
		$query = $db->sqlQuery($sql);		
	  	$count = $db->sqlEnumRows($query);
	  	if($count>0){
	  		while($row = $db->sqlFetchArray($query)){
	  			if($control!=$row['ID_MENU']){
	  				$permisos .= ($permisos!="") ? '</table></div>': '';
	  				$permisos .= '<h3>'.$Functions->codif($row['MENU']).'</h3><div><table class="total_width">';
	  				$control   = $row['ID_MENU'];
	  			}
	  			
				$permisos .= '<tr><td>'.$Functions->codif($row['SUBMENU']).'</td>'.
							 '<td  align="right"><div>'.$row['NPERMISO'].
			 				 '<div></td></tr>';
			}
			$permisos .= '</table></div>';
	  	}
	}
	$control_e=0;
	$excepciones = '';
	$sql_e = "SELECT ADM_MENU.DESCRIPCION,ADM_SUBMENU.ID_MENU,ADM_SUBMENU.ID_SUBMENU, ADM_SUBMENU.DESCRIPTION
			FROM ADM_MENU_TIPO 
			INNER JOIN ADM_MENU 	ON ADM_MENU_TIPO.ID_MENU = ADM_MENU.ID_MENU
			 LEFT JOIN ADM_SUBMENU 	ON ADM_SUBMENU.ID_MENU = ADM_MENU.ID_MENU
			 LEFT JOIN ADM_SUBMENU_CLIENTES ON ADM_SUBMENU_CLIENTES.ID_SUBMENU  = ADM_SUBMENU.ID_SUBMENU  
			WHERE ADM_MENU_TIPO.ID_TIPO_USUARIO 	= ".$userAdmin->user_info['ID_TIPO_USUARIO']."
			 AND  ADM_MENU.TIPO='W'
			 AND  ADM_SUBMENU_CLIENTES.ID_CLIENTE  	= ".$userAdmin->user_info['ID_CLIENTE']."
			ORDER BY ADM_MENU_TIPO.ORDEN ASC";
	$query_e = $db->sqlQuery($sql_e);		
  	$count_e = $db->sqlEnumRows($query_e);
  	if($count_e>0){
  		while($row_e = $db->sqlFetchArray($query_e)){
  			if($control_e!=$row_e['ID_MENU']){
  				$excepciones .= ($excepciones!="") ? '</table></div>': '';
  				$excepciones .= '<h3>'.$Functions->codif($row_e['DESCRIPCION']).
				  					'</h3><div><table class="total_width">';
  				$control_e   = $row_e['ID_MENU'];
  			}
  			
  			$info_permiso_e = $dbf->getRow('ADM_USUARIOS_PERMISOS','ID_USUARIO = '.$id_row.
			  												' AND ID_SUBMENU = '.$row_e['ID_SUBMENU']);
			  												
			$id_permiso_e   = ($info_permiso_e['ID_PERMISO']) ? $info_permiso_e['ID_PERMISO']: '';
			$selected_e     = ($info_permiso_e['ID_PERMISO']) ? 'icon_unit_selected': 'icon_unit_unselected';
 			$disabled_e     = (!$info_permiso_e['ID_PERMISO']) ? 'disabled=""': '';						
			  
  			$excepciones .= '<tr><td>'.
				'<div id="user_acordeon_icon_'.$row_e['ID_SUBMENU'].'" class="'.
					$selected_e.'" onclick="user_select_menu('.$row_e['ID_SUBMENU'].')">'.
			"<img class='total_width total_height' ".
			"src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"	  					.'</div>'.
                           '</td><td>'.$Functions->codif($row_e['DESCRIPTION']).'</td>'.
  						 '<td  align="right"><div>'.
			'<select id="user_select'.$row_e['ID_SUBMENU'].'" '.$disabled_e.' class="user_caja">';
			  
  			$excepciones .= $dbf->cbo_from('ID_PERMISO','DESCRIPCION','ADM_PERMISOS','1=1',$id_permiso_e);
  			$excepciones .= '</select><div></td></tr>';
		}
		$excepciones .= '</table></div>';
	}
	  
	$pass_disabled  = ($id_row!=0) ? 'disabled=""': '';
	$style_pass  	= ($id_row!=0) ? 'user_div_display': 'user_div_nodisplay';
	
	if($userAdmin->user_info['ID_TIPO']==3){
		$where_grupos   = "ID_GRUPO IN(
								SELECT ID_GRUPO
								FROM ADM_USUARIOS_GRUPOS 
								WHERE ID_USUARIO = ".$userAdmin->user_info['ID_USUARIO']."
								GROUP BY ADM_USUARIOS_GRUPOS.ID_GRUPO)";		
	}else{
		$where_grupos   = "ID_GRUPO IN(
							SELECT ID_GRUPO 
							FROM ADM_GRUPOS_CLIENTES
							WHERE ADM_GRUPOS_CLIENTES.ID_CLIENTE = ".$userAdmin->user_info['ID_CLIENTE'].")";		
	}

	$grupos			= $dbf->cbo_from('ID_GRUPO','NOMBRE','ADM_GRUPOS',$where_grupos);
	
	$tpl->set_filenames(array('mSetRow' => 'tSetRow'));
	$tpl->assign_vars(array(
		'ID'		=> $id_row,
		'NAME'		=> @$data_row['NOMBRE_COMPLETO'], 
		'EMAIL'		=> @$data_row['EMAIL'],
		'USUARIO'	=> @$data_row['USUARIO'],
		'PASS'		=> @$data_row['PASSWORD'],
		'PERFIL'	=> $perfil,
		'MODULOS'	=> $modulos,
		'ESTATUS'	=> $estatus,
		'EXCEPCIONES'=> $excepciones,
		'PAS_DIS'	=> $pass_disabled,
		'CLASS_PASS'=> $style_pass,
		'GRUPOS'	=> $grupos,
		'PERMISOS'	=> $permisos,
		'USELECT'	=> $u_selected,
		'UNSELECT'	=> $u_unselected		
	));	
	$tpl->pparse('mSetRow');	
?>