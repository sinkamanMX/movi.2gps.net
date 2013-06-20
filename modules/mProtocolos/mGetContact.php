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
		array("id"=>"1",'name'=>'Si' ),
		array("id"=>"0",'name'=>'No' )
	);	
	$id_row=0;
	$id_protocolo = $_GET['id_proc'];
	/*Se valida la variable data, si esta viene y es diferente de 0 es uan edicion*/
	if(isset($_GET['data']) || $_GET['data'] !=0){
		$id_row    = $_GET['data'];
		$data_row  = $dbf->getRow('ADM_PROTOCOLO_CONTACTOS','ID_CONTACTO ='.$id_row);		  	
	}
	
	$consulta = $Functions->cbo_from_array($a_respuestas,@$data_row['CONTACTO_CONSULTA']);
	$autoriza = $Functions->cbo_from_array($a_respuestas,@$data_row['CONTACTO_AUTORIZA']);
	
	$hora_in = (@$data_row['HORA_INICIAL']) ? $data_row['HORA_INICIAL']: '00:00';
	$hora_fin= (@$data_row['HORA_INICIAL']) ? $data_row['HORA_INICIAL']: '23:59';
	
	$tpl->set_filenames(array('mGetContact' => 'tGetContact'));
	$tpl->assign_vars(array(
		'ID'		=> $id_row,
		'ID_PROT'	=> $id_protocolo,
		'NAME'		=> @$data_row['NOMBRE'],
		'HI'		=> $hora_in,
		'HF'		=> $hora_fin,
		'ROL'		=> @$data_row['ROL'],
		'CLAVE'		=> @$data_row['CLAVE_SEGURIDAD'],
		'CONSULTA'	=> $consulta,
		'AUTORIZA'	=> $autoriza,
		'PRIOR'		=> @$data_row['PRIORIDAD']
	));	
	$tpl->pparse('mGetContact');	
?>	