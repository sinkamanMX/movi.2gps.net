<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$id_client = 0;
	$a_respuestas = array(
		array("id"=>"S",'name'=>'Si' ),
		array("id"=>"N",'name'=>'No' )
	);	
	$id_row=0;
	$id_contacto = $_GET['id_contacto'];
	/*Se valida la variable data, si esta viene y es diferente de 0 es uan edicion*/
	if(isset($_GET['data']) || $_GET['data'] !=0){
		$id_row    = $_GET['data'];
		$data_row  = $dbf->getRow('ADM_FORMA_CONTACTO','ID_FORMA_CONTACTO ='.$id_row);		  	
	}
	
	$estatus = $Functions->cbo_from_array($a_respuestas,@$data_row['ACTIVO']);
	$medios  = $dbf->cbo_from('ID_FORMA','DESCRIPCION','ADM_MEDIOS_CONTACTO','1=1',@$data_row['ID_FORMA']);

	$tpl->set_filenames(array('mGetMedio' => 'tGetMedio'));
	$tpl->assign_vars(array(
		'ID'		=> $id_row,
		'ID_CONTACT'=> $id_contacto,
		'NAME'		=> @$data_row['MEDIO_CONTACTO'],
		'PRIOR'		=> @$data_row['PRIORIDAD'],
		'STATUS'	=> $estatus,
		'MEDIOS'	=> $medios
	));	
	$tpl->pparse('mGetMedio');	
?>	