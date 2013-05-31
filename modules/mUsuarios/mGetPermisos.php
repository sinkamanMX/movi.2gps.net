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
	
	/*Se valida la variaable data, si esta viene y es diferente de 0 es uan edicion*/
	if(isset($_GET['data']) || $_GET['data'] !=0){
		$control  =0;
		$permisos ='';
		$sql = "SELECT ADM_SUBMENU.ID_MENU,ADM_MENU.DESCRIPCION AS MENU ,ADM_SUBMENU.DESCRIPTION AS SUBMENU, 
                       ADM_PERMISOS.DESCRIPCION AS NPERMISO					
				FROM ADM_PERFIL_PERMISOS
				INNER JOIN ADM_PERMISOS ON ADM_PERMISOS.ID_PERMISO = ADM_PERFIL_PERMISOS.ID_PERMISO
				INNER JOIN ADM_SUBMENU  ON ADM_SUBMENU.ID_SUBMENU  = ADM_PERFIL_PERMISOS.ID_SUBMENU
				INNER JOIN ADM_MENU     ON ADM_MENU.ID_MENU	 = ADM_SUBMENU.ID_MENU 
				WHERE ID_PERFIL = ".$_GET['data'];
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
	}else{
		$permisos = 'no-data';
	}
	echo $permisos;
?>