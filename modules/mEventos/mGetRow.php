<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Edgar Sanabria Paredes
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$id_grupo=0;
	$u_selected='';
	$u_unselected = '';
	$a_units_selected='';
	$name='';
	$prio='';
	$valida='';
	$ico='';
	
	$id_grupo = $_GET['data'];
		
	/*Se valida la variaable data, si esta viene y es diferente de 0 es uan edicion*/
	 if($id_grupo!=0){
		
	
		$sql_units = "SELECT COLOR, DESCRIPTION, PRIORITY, FLAG_VISIBLE_CONSOLE, ICONO, FLAG_EVENT_ALERT
						FROM ADM_EVENTOS
						WHERE COD_EVENT = ".$id_grupo;
		$query_units = $db->sqlQuery($sql_units);
		$units_count = $db->sqlEnumRows($query_units);  		
  		if($units_count!=0){
  			while($data_units = $db->sqlFetchArray($query_units)){
  				
				
  				  	
					if($data_units['PRIORITY']==0){
						$prio='<option value="0" selected="selected">Baja</option><option value="1">Alta</option>';
					}else{
						$prio='<option value="0">Baja</option><option value="1" selected="selected">Alta</option>';
					}
	
				//	$prio='<option value="0">Baja</option><option value="1">Alta</option>';
				
					if($data_units['FLAG_EVENT_ALERT']==0){
						$u_selected='<option value="0" selected="selected">No</option><option value="1" >Si</option>';
					}else{
						$u_selected='<option value="0" >No</option><option value="1"  selected="selected">Si</option>';
					}
					
						if($data_units['FLAG_VISIBLE_CONSOLE']==0){
						$valida='<option value="0" selected="selected">No</option><option value="1" >Si</option>';
					}else{
						$valida='<option value="0" >No</option><option value="1"  selected="selected">Si</option>';
					}

					$ico = $data_units['ICONO'];
					$name = $data_units['DESCRIPTION'];
					
					$sql_unselect = "SELECT DESCRIPTION, R, G, B FROM ADM_COLORES";
					$query_unselect = $db->sqlQuery($sql_unselect);					
					$count_unselect = $db->sqlEnumRows($query_unselect);  	
				
					while($datau_units = $db->sqlFetchArray($query_unselect)){
					$hexa=$Functions-> rgb2html($datau_units['R'],$datau_units['G'],$datau_units['B']);
				// selected="selected"	$hexa=rgb_hex($datau_units['R'].','.$datau_units['G'].','.$datau_units['B']);
								if($data_units['COLOR']==$hexa){	
									$u_unselected .= '<option value="'.$hexa.'" selected="selected" style="background-color:'.$hexa.';" >'.$datau_units['DESCRIPTION'].'</option>';
								}else{
									$u_unselected .= '<option value="'.$hexa.'" style="background-color:'.$hexa.';" >'.$datau_units['DESCRIPTION'].'</option>';
								}
							}
		
				}  	
  		}			
			
	}
	
		
		if($id_grupo==0){
				$prio='<option value="0">Baja</option><option value="1">Alta</option>';
			$valida='<option value="0" >No</option><option value="1">Si</option>';
			$u_selected='<option value="0" >No</option><option value="1" >Si</option>';
		 	$name='';
			$ico='';
			
			$sql_unselect = "SELECT DESCRIPTION, R, G, B FROM ADM_COLORES";
			$query_unselect = $db->sqlQuery($sql_unselect);					
			$count_unselect = $db->sqlEnumRows($query_unselect);  	
		
			while($datau_units = $db->sqlFetchArray($query_unselect)){
			$hexa=$Functions-> rgb2html($datau_units['R'],$datau_units['G'],$datau_units['B']);
		// selected="selected"	$hexa=rgb_hex($datau_units['R'].','.$datau_units['G'].','.$datau_units['B']);
				$u_unselected .= '<option value="'.$hexa.'" style="background-color:'.$hexa.';" >'.$datau_units['DESCRIPTION'].'</option>';
			}
		}
		 
	$tpl->set_filenames(array('mGetRow' => 'tSetRow'));
	$tpl->assign_vars(array(
		'ID'		=> $id_grupo,
		'NAME'		=> $name,
		'PRIO'		=>  $prio,
		'ICO'		=>  $ico,
		'VALIDA'	=> $valida,
		'USELECT'	=> $u_selected,
		'UNSELECT'	=> $u_unselected
	));	
	$tpl->pparse('mGetRow');	
?>	