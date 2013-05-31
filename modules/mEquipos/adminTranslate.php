<?php
/** *              
 *  @name                Muestra el formulario para migrar de cliente un equipo
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$id_client = $_GET['id_client'];
	
	if(isset($_GET['data'])){
		$id_equipment  = $_GET['data'];
		$id_client     = $_GET['id_client'];
		$id_company    = $_GET['id_company'];
		
		$data_row = $dbf->getRow('ADM_EQUIPOS','COD_EQUIPMENT = '.$id_equipment);
		
		$where_clientes = 'ID_CLIENTE != '.$id_client.'
 							AND ID_EMPRESA = '.$id_company;
		$clientes = $dbf->cbo_from('ID_CLIENTE','NOMBRE','ADM_CLIENTES',$where_clientes);
		
		$marca = $dbf->cbo_from('COD_TRADEMARK','DESCRIPTION','ADM_MARCA','1=1 ORDER BY DESCRIPTION');
		$tipo  = $dbf->cbo_from('COD_TYPE_ENTITY','DESCRIPTION','ADM_TIPO_UNIDAD','1=1 ORDER BY DESCRIPTION');
		
		$tpl->set_filenames(array('adminTranslate' => 'adminTranslate'));
		$tpl->assign_vars(array(
			'ID'	=> $id_equipment,
			'MARCA' => $marca,
			'TIPO'  => $tipo,
			'CLIENTES'=>$clientes,
			'EQP'	=>$data_row['ITEM_NUMBER']
		));	
		$tpl->pparse('adminTranslate');			
	}else{
		echo "no-data";
	}
?>