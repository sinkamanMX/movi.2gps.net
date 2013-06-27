<?php
/**/
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
//$userData = new usersAdministration();	

if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}
set_time_limit(600000);

//$tpl->set_filenames(array('mGet_Detalle_Com'=>'tGet_Detalle_Com'));
if(isset($_GET['tag'])){
	$rtime = " AND GPS_DATETIME BETWEEN '".$_GET['fecha']." 00:00:00' AND '".$_GET['fecha']." 23:59:00' ";
	$cliente = $userAdmin->user_info['ID_CLIENTE'];
	$arreglo = array();
	$counter = 0;

	/* LLAMAR FUNCIONES GLOBALES */
	
	$tablaHistorico = $Positions->get_tablename($cliente);
	
	if($tablaHistorico != ""){
		$tablaHistorico="HIST".$tablaHistorico;
		$queryNumHistorico = $Positions->get_num_hist28($tablaHistorico, $_GET['idund'], $rtime, $cliente);
		$count = count($queryNumHistorico);
		if($count > 0){
			//$data = array();
			for($c=0;$c<count($queryNumHistorico);$c++){
				/*$tpl->assign_block_vars('reports',array(
					 'DATE'   => $queryNumHistorico[$c][8],
					 'UNIT'	  => $queryNumHistorico[$c][1],
					 'LATI'	  => $queryNumHistorico[$c][4],
					 'LONG'	  => $queryNumHistorico[$c][5],
					 'EVEN'	  => $queryNumHistorico[$c][3],
					 'DIRE'	  => $queryNumHistorico[$c][9]
					));*/
				$data[] = array(
					 'DATE'   => $queryNumHistorico[$c][8],
					 'UNIT'	  => $queryNumHistorico[$c][1],
					 'LATI'	  => $queryNumHistorico[$c][4],
					 'LONG'	  => $queryNumHistorico[$c][5],
					 'EVEN'	  => $queryNumHistorico[$c][3],
					 'DIRE'	  => $queryNumHistorico[$c][9]
				);
				
				  }	
				//echo '{"items" :'.json_encode($data).'}'; 
				echo json_encode($data);
				//echo json_encode( $result = array('aaData'=>$data ) );
				//$tpl->pparse('mGet_Detalle_Com');
			}
		else{
			echo "0";
			//echo $tablaHistorico.",".$_GET['idund'].",".$rtime.",".$cliente;
		}
	}else{
		echo "-1";
	}
}else{
	echo "-2";
}
?>