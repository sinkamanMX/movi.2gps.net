<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],
	              $config_bd['user'],$config_bd['pass']);
	
	if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}
	
	$rtime = " AND GPS_DATETIME BETWEEN '".$_GET['fi']."' AND '".$_GET['ff']."' ";
	$cliente = $userAdmin->user_info['ID_CLIENTE'];
	$arreglo = array();
	$counter = 0;

	$tablaHistorico = $Positions->get_tablename($cliente);	
	if($tablaHistorico != ""){
		$tablaHistorico="HIST".$tablaHistorico;
		$queryNumHistorico = $Positions->get_num_hist29($tablaHistorico, $_GET['idund'], $rtime, $cliente);
		$count = count($queryNumHistorico);
		if($count > 0){
			$data = "";
			for($c=0;$c<count($queryNumHistorico);$c++){
				$data .= ($data!="") ? ', ': '';
				$data .= '{"FECHA"   : "'.$queryNumHistorico[$c][2].'" , '.
						 ' "LATIT"   : "'.$queryNumHistorico[$c][4].'" , '.						 
						 ' "LONGI"   : "'.$queryNumHistorico[$c][5].'" , '.
						 ' "VEL"     : "'.$queryNumHistorico[$c][8].'" , '.
						 ' "EVENT"   : "'.$queryNumHistorico[$c][3].'" , '.
					  	 ' "DIREC"   : "'.$queryNumHistorico[$c][9].'" }';		
			}
		}
	}
	             
	$und = $dbf->getRow('ADM_UNIDADES','COD_ENTITY = '.$_GET['idund']);
	$tpl->set_filenames(array('mDetalle' => 'tDetalle'));
	
	$tpl->assign_vars(array(
				'UND'    => $_GET['idund'],
				'FI'     => $_GET['fi'],
				'FF'     => $_GET['ff'],
				'U'      => @$und['DESCRIPTION'],
				'DATA'	 => $data
	));
	$tpl->pparse('mDetalle');	
?>	