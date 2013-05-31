<?php
/**/
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
//$userData = new usersAdministration();	

if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}
set_time_limit(600000);

//$tpl->set_filenames(array('mGet_Detalle_Com'=>'tGet_Detalle_Com'));
if(isset($_GET['tag'])){
	$rtime = " AND GPS_DATETIME BETWEEN '".$_GET['fi']."' AND '".$_GET['ff']."' ";
	$cliente = $userAdmin->user_info['ID_CLIENTE'];
	$arreglo = array();
	$counter = 0;

	/* LLAMAR FUNCIONES GLOBALES */
	
	$tablaHistorico = $Positions->get_tablename($cliente);
	
	if($tablaHistorico != ""){
		$tablaHistorico="HIST".$tablaHistorico;
		$queryNumHistorico = $Positions->get_num_hist29($tablaHistorico, $_GET['idund'], $rtime);
		$count = count($queryNumHistorico);
		if($count > 0){
			//$data = array();
			for($c=0;$c<count($queryNumHistorico);$c++){
				$data[] = array(
					 'DATE'   => $queryNumHistorico[$c][2],
					 'UNIT'	  => $queryNumHistorico[$c][1],
					 'LATI'	  => $queryNumHistorico[$c][4],
					 'LONG'	  => $queryNumHistorico[$c][5],
					 'EVEN'	  => $queryNumHistorico[$c][3],
					 'VELO'	  => $queryNumHistorico[$c][8],
					 'DIRE'	  => $queryNumHistorico[$c][9]
				);
				
				  }	
				
				echo json_encode($data);
				
			}
		else{
			echo "0";
			
		}
	}else{
		echo "-1";
	}
}else{
	echo "-2";
}
?>