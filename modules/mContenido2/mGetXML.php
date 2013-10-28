<?php
/**/
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
$userData = new usersAdministration();	

if(!$userAdmin->u_logged()){
	echo '<script>window.location="index.php?m=login"</script>';
}
set_time_limit(600000);

    include('mFunciones_CV.php');
	  $funciones_cv = new mFunciones_CV();  
	  
$idc   = $userAdmin->user_info['ID_CLIENTE'];	

	$cadena=' ';
	$fecha=$_GET['day'];
			//$dayhr=date("Y-m-d");
			if($fecha=='undefined'){
			$dayhr=date("Y-m-d");

			
			}else{
			$dayhr=$_GET['day'];
			}
		$rtime = " CAST(e.GPS_DATETIME AS DATE) BETWEEN '".$dayhr." 00:00:00' AND '".$dayhr." 23:59:00'";
	
	/* LLAMAR FUNCIONES GLOBALES */
	
	
	$tablaHistorico= 'HIST'.$Positions->get_tablename($idc);
	
	if($tablaHistorico != ""){
		echo $queryNumHistorico = $funciones_cv->obtener_his_iterio( $_GET['idunit'], $tablaHistorico, $rtime);
		$count = count($queryNumHistorico);
		if($queryNumHistorico !=0){
  			$data_arr = array();
   			$cnt=0;			
  			for($c=0;$c<count($queryNumHistorico);$c++){
			
			
			
				$angle = $queryNumHistorico[$c][6];
				$anglef= $funciones_cv->direccion_flecha($angle);
	
			  $data_arr[$cnt]  = array(
			  			'evt'	=> $queryNumHistorico[$c][2],
						'dunit'	=> $queryNumHistorico[$c][0],
						'date'	=> $queryNumHistorico[$c][1],
						'vel'	=> $queryNumHistorico[$c][3],
						'fecha'	=> $queryNumHistorico[$c][7],
						'lat'	=> $queryNumHistorico[$c][4],
						'lon'	=> $queryNumHistorico[$c][5],
						'angle'	=> $anglef,
						'ico'	=> 'public/images/carold_'.$anglef.'.png',
						'entity'	=> $queryNumHistorico[$c][8]
				  );
															
				$cnt++;
			}

			for($i=0;$i<count($data_arr);$i++){
						
						if($cadena==' '){
						 $cadena=implode(",", $data_arr[$i]);
						}else{
							
							 $cadena=$cadena.'|'.implode(",", $data_arr[$i]);
							}
					
					}
					echo $cadena;
		}else{
			echo "0";
		}
	}else{
		echo "2";
	}
?>