<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	$id_row	= '';
	$control= 0;
	$u_unselected ='';	
	/*Se valida la variaable data, si esta viene y es diferente de 0 es uan edicion*/
	if(isset($_GET['data']) || $_GET['data'] !=0 && $_GET['grupo_id']){
		$control  =0;

		$sql_units = "SELECT ADM_GRUPOS_UNIDADES.COD_ENTITY, 
						CONCAT(IF(ADM_UNIDADES.PLAQUE IS NULL,'NP',ADM_UNIDADES.PLAQUE),'-', IF(ADM_UNIDADES.DESCRIPTION IS NULL,'',ADM_UNIDADES.DESCRIPTION)) AS UNIDAD
						FROM ADM_GRUPOS_UNIDADES
						INNER JOIN ADM_UNIDADES ON ADM_UNIDADES.COD_ENTITY  = ADM_GRUPOS_UNIDADES.COD_ENTITY
						WHERE ID_GRUPO = ".$_GET['grupo_id']." AND ADM_GRUPOS_UNIDADES.COD_ENTITY  NOT IN (
							SELECT COD_ENTITY
							FROM ADM_USUARIOS_GRUPOS WHERE ID_USUARIO = ".$_GET['data']." )";
		$query_units = $db->sqlQuery($sql_units);
		$units_count = $db->sqlEnumRows($query_units);  		
  		if($units_count){
  			while($data_units = $db->sqlFetchArray($query_units)){				
				$u_unselected .= '<li  id="'.$data_units['COD_ENTITY'].'" value="'.$_GET['grupo_id']
							.'" class="ui-state-default">'.
							'<a href="javascript:void(0)">'.
								$data_units['UNIDAD'].
							'</a><span style="display:none;">'.$data_units['COD_ENTITY'].'|'.
															   $_GET['grupo_id'].'</span></li>';	
  			}
  		}
	}
	echo $u_unselected;
?>