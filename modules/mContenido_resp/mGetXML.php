<?php
/**/
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
$userData = new usersAdministration();	

if(!$userAdmin->u_logged()){
	echo '<script>window.location="index.php?m=login"</script>';
}
set_time_limit(600000);

//$tpl->set_filenames(array('mGetXML'=>'tGetXML'));

	/** CREAR FILTRO **/
	$filtro="";
	
	//if($_GET['vel']){
		//$filtro = " AND  H.VELOCITY> ".$_GET['vel'];
	//}
	/*if($_GET['evt'] > 0){
		$filtro = " AND f.COD_EVENT = ".$_GET['evt'];
	}*/
	
	$fecha=$_GET['day'];
			//$dayhr=date("Y-m-d");
			if($fecha=='undefined'){
			$dayhr=date("Y-m-d");

			
			}else{
			$dayhr=$_GET['day'];
			}
		$rtime = " AND CAST(GPS_DATETIME AS DATE) BETWEEN '".$dayhr." 00:00:00' AND '".$dayhr." 23:59:00'";
	
	/* LLAMAR FUNCIONES GLOBALES */
	
	
	$tablaHistorico = $Positions->get_table_histX2($_GET['idunit']);
	
	if($tablaHistorico != ""){
		$queryNumHistorico = $Positions->get_num_hist3($tablaHistorico, $_GET['idunit'], $rtime, $filtro);
		$count = count($queryNumHistorico);
		if($count > 0){
  			$data_arr = array();
   			$cnt=0;			
  			for($c=0;$c<count($queryNumHistorico);$c++){
			
			$Q ="SELECT A.ICONO FROM SAVL1220_G A 
				INNER JOIN SAVL1220_GDET B ON A.ID_GROUP = B.ID_GROUP
				WHERE B.COD_ENTITY =". $queryNumHistorico[$c][8];
			$QWERY 	= $db->sqlQuery($Q);	
			$ROW	= $db->sqlFetchArray($QWERY);	
			
				$angle = $queryNumHistorico[$c][6];
				$anglef= $Positions->direccion_flecha($angle);
			
			  $data_arr[$cnt]  = array(
			  			'evt'	=> $queryNumHistorico[$c][2],
						'dunit'	=> $queryNumHistorico[$c][0],
						'date'	=> $queryNumHistorico[$c][1],
						'vel'	=> $queryNumHistorico[$c][3],
						'fecha'	=> $queryNumHistorico[$c][7],
						'lat'	=> $queryNumHistorico[$c][4],
						'lon'	=> $queryNumHistorico[$c][5],
						'angle'	=> $anglef,
						'ico'	=> $ROW['ICONO'],
						'entity'	=> $queryNumHistorico[$c][8]
				  );
															
				$cnt++;
			}

			echo '{"items" :'.json_encode($data_arr).'}'; 
		}else{
			echo "0";
		}
	}else{
		echo "2";
	}
?>