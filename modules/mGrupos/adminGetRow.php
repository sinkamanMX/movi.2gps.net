<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$id_grupo=0;
	$u_selected='';
	$u_unselected = '';
	$a_units_selected='';
	$id_client = 0;
	/*Se valida la variaable data, si esta viene y es diferente de 0 es uan edicion*/
	if(isset($_GET['data']) || $_GET['data'] !=0){
		$id_grupo  = $_GET['data'];
		$id_client = $_GET['id_client'];
		
		$sql = "SELECT ADM_GRUPOS.*, AD_G.ID_GRUPO AS IDGP, AD_G.NOMBRE AS N_PADRE
				FROM ADM_GRUPOS
				LEFT JOIN ADM_GRUPOS_REL  ON ADM_GRUPOS.ID_GRUPO = ADM_GRUPOS_REL.ID_GRUPO_HIJO
				LEFT JOIN ADM_GRUPOS AD_G ON AD_G.ID_GRUPO 	 = ADM_GRUPOS_REL.ID_GRUPO_PADRE
				WHERE ADM_GRUPOS.ID_GRUPO = ".$id_grupo;
  		$query = $db->sqlQuery($sql);
  		$data_perfil = $db->sqlFetchArray($query);
		  
		$sql_units = "SELECT ADM_GRUPOS_UNIDADES.COD_ENTITY, CONCAT(PLAQUE,'-', DESCRIPTION) AS UNIDAD
						FROM ADM_GRUPOS_UNIDADES 
						INNER JOIN ADM_UNIDADES ON ADM_UNIDADES.COD_ENTITY  = ADM_GRUPOS_UNIDADES.COD_ENTITY
						WHERE ADM_GRUPOS_UNIDADES.ID_GRUPO = ".$id_grupo;
		$query_units = $db->sqlQuery($sql_units);
		$units_count = $db->sqlEnumRows($query_units);  		
  		if($units_count){
  			while($data_units = $db->sqlFetchArray($query_units)){
  				$a_units_selected .= ($a_units_selected=='') ? '' : ',';
				$a_units_selected .= $data_units['COD_ENTITY'];
				
				$u_selected .= '<li value="'.$data_units['COD_ENTITY'].'" class="ui-state-default">'.
							'<a href="javascript:void(0)">'.
								$data_units['UNIDAD'].'</a></li>';	
  			}  	
  		}				  	
	}
	
	$and_unselect = ($a_units_selected!="") ? 'AND COD_ENTITY NOT IN ('.$a_units_selected.')': '';
	$sql_unselect = "SELECT COD_ENTITY, CONCAT(PLAQUE,'-', DESCRIPTION) AS UNIDAD
					FROM ADM_UNIDADES
						WHERE COD_CLIENT = ".$id_client." ".$and_unselect;
	$query_unselect = $db->sqlQuery($sql_unselect);					
	$count_unselect = $db->sqlEnumRows($query_unselect);  		
	if($count_unselect){		
		while($datau_units = $db->sqlFetchArray($query_unselect)){
			$u_unselected .= '<li value="'.$datau_units['COD_ENTITY'].'" class="ui-state-default">'.
							'<a href="javascript:void(0)">'.
								$datau_units['UNIDAD'].'</a></li>';	
		}
	}
		
	$tpl->set_filenames(array('mGetRow' => 'tSetRow'));
	$tpl->assign_vars(array(
		'ID'		=> @$data_perfil['ID_GRUPO'],
		'NAME'		=> @$data_perfil['NOMBRE'],
		'ABREV'		=> @$data_perfil['ABREVIATURA'],
		'PADRE'		=> $Functions->cbo_select_padre(@$data_perfil['IDGP'],@$data_perfil['ID_GRUPO'],$id_client),
		'USELECT'	=> $u_selected,
		'UNSELECT'	=> $u_unselected
	));	
	$tpl->pparse('mGetRow');	
?>	