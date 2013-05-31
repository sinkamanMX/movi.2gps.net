<?php
/** *              
 *  @name                Script que muestra los datos de una empresas
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$id_row=0;
	/*Se valida la variaable data, si esta viene y es diferente de 0 es uan edicion*/
	if(isset($_GET['data'])){
		$id_row  = $_GET['data'];
		$empresa = $dbf->getRow('ADM_EMPRESAS','ID_EMPRESA = '.$id_row);
	}
	
	$status = $dbf->cbo_from_enum('ADM_EMPRESAS','ACTIVO',@$empresa['ACTIVO']);
	
	$tpl->set_filenames(array('mGetRow' => 'tGetRow'));
	$tpl->assign_vars(array(
		'NAME'		=> @$empresa['DESCRIPCION'],
		'RZON'		=> @$empresa['RAZON_SOCIAL'],
		'RFC'		=> @$empresa['RFC'],
		'DIR'		=> @$empresa['DIRECCION'],
		'TEL'		=> @$empresa['TELEFONO'],
		'REP'		=> @$empresa['REPRESENTANTE_LEGAL'],
		'MAIL'		=> @$empresa['EMAIL'],
		'OBS'		=> @$empresa['OBSERVACIONES'],
		'STATUS'	=> $status,
		'ID' 		=> $id_row
	));	
	$tpl->pparse('mGetRow');	
?>	