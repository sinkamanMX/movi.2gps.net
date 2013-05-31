<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author             Edgar Sanabria Paredes 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	$id_row	= 0;
	$control= 0;
	$u_unselected = array();
	$u_selected = array();
	$aray=array();
	$aray1=array();
	$contars=0;
	$contars1=0;
	$contars2=0;
	$columna_unse=' ';
	$columna_sele=' ';
	$id_row = $_GET['data']; 
	/*Se valida la variaable data, si esta viene y es diferente de 0 es uan edicion*/
	$cod_entis=$_GET['cod_enty']; 

	$sql = "SELECT F.ID_COMANDO_CLIENTE,
					 	   F.DESCRIPCION
					FROM ADM_UNIDADES_EQUIPOS B 
					  INNER JOIN ADM_EQUIPOS C ON C.COD_EQUIPMENT = B.COD_EQUIPMENT
					  INNER JOIN ADM_EQUIPOS_TIPO D ON D.COD_TYPE_EQUIPMENT = C.COD_TYPE_EQUIPMENT
					  INNER JOIN ADM_COMANDOS_SALIDA E ON E.COD_TYPE_EQUIPMENT = D.COD_TYPE_EQUIPMENT
					  INNER JOIN ADM_COMANDOS_CLIENTE F ON F.COD_EQUIPMENT_PROGRAM = E.COD_EQUIPMENT_PROGRAM
					WHERE F.ID_CLIENTE = ".$userAdmin->user_info['ID_CLIENTE']." AND
						  B.COD_ENTITY IN (".$cod_entis.") 
					GROUP BY F.ID_COMANDO_CLIENTE";
 	$query = $db->sqlQuery($sql);		
   	$count = $db->sqlEnumRows($query);
	if($count>0){
		while($row = $db->sqlFetchArray($query)){
			$where = ' ID_COMANDO_CLIENTE = '.$row['ID_COMANDO_CLIENTE'].' 
					   AND ID_USUARIO     = '.$id_row;
			$u_assign = $dbf->getRow('ADM_COMANDOS_USUARIO',$where);
			if($u_assign){ 
				$columna_sele .= '<li id="'.$row['ID_COMANDO_CLIENTE'].'" value="'.$cod_entis
					.'" class="ui-state-default">'.
					'<a href="javascript:void(0)">'.
						$row['DESCRIPCION'].
					'</a></li>';	
					/*'</a><span style="display:none;">'.$row['ID_COMANDO_CLIENTE'].' '.$row['DESCRIPCION']
					.'</span></li>';*/				
			}else{
				$columna_unse .= '<li id="'.$row['ID_COMANDO_CLIENTE'].'" value="'.$cod_entis
					.'" class="ui-state-default">'.
					'<a href="javascript:void(0)">'.
						$row['DESCRIPCION'].
					'</a></li>';	
					/*'</a><span style="display:none;">'.$row['ID_COMANDO_CLIENTE'].' '.$row['DESCRIPCION']
					.'</span></li>';*/
			}
		}
	}	
	echo $columna_unse.'|'.$columna_sele;

?>