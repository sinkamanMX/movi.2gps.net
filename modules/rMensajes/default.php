<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
 *  @modificado          29-08-2013
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	$sqlUnits = "SELECT ADM_GRUPOS.ID_GRUPO, ADM_GRUPOS.NOMBRE, ADM_USUARIOS_GRUPOS.COD_ENTITY,	
					ADM_UNIDADES.COD_ENTITY, ADM_UNIDADES.DESCRIPTION
					FROM ADM_USUARIOS_GRUPOS
						INNER JOIN ADM_GRUPOS          
							ON ADM_GRUPOS.ID_GRUPO = ADM_USUARIOS_GRUPOS.ID_GRUPO
						INNER JOIN ADM_UNIDADES 
						ON ADM_UNIDADES.COD_ENTITY = ADM_USUARIOS_GRUPOS.COD_ENTITY	
					WHERE ADM_USUARIOS_GRUPOS.ID_USUARIO = ".$userAdmin->user_info['ID_USUARIO']."
					ORDER BY ID_GRUPO";
	$query = $db->sqlQuery($sqlUnits);
	$count = $db->sqlEnumRows($query);
	$idControl=0;
	if($count>0){
		while($row = $db->sqlFetchArray($query)){
			$units .= ($idControl!=$row['ID_GRUPO'] && $units!="") ? "</optgroup>": "";
			$units .= ($idControl!=$row['ID_GRUPO']) ? "<optgroup label='".$row['NOMBRE']."'>": "";
			
			$units .= "<option value='".$row['COD_ENTITY']."'>".$row['DESCRIPTION']."</option>";
			$idControl = $row['ID_GRUPO'];
		}
		$units .= "</optgroup>";
	}
	
	$tpl->set_filenames(array('default'=>'default'));		 
	
	$tpl->assign_vars(array(
		'PAGE_TITLE'	=> 'Reporte Historico',	
		'PATH'			=> $dir_mod,
		'UNITS'			=> $units
	));	
	$tpl->pparse('default');
?>