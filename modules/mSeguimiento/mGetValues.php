<?php
/**/
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
//$userData = new usersAdministration();	

if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}
set_time_limit(600000);

$tpl->set_filenames(array('mGetValues'=>'tGetValues'));

	$rtime = " AND GPS_DATETIME BETWEEN '".$_GET['dti']."' AND '".$_GET['dtf']."' ";
	$cliente = $userAdmin->user_info['ID_CLIENTE'];

	

	
	$tablaHistorico = $Positions->get_tablename($cliente);
	
	if($tablaHistorico != ""){
		$tablaHistorico="ACC_HIST".$tablaHistorico;
		$queryNumHistorico = $Positions->get_num_hist30($tablaHistorico, $_GET['und'], $rtime);
		$count = count($queryNumHistorico);
		if($count > 0){
			//$data = array();
			for($c=0;$c<count($queryNumHistorico);$c++){
				$tmp .= ($tmp=="")?$queryNumHistorico[$c][0]:",".$queryNumHistorico[$c][0];
				$rpm .= ($rpm=="")?$queryNumHistorico[$c][1]:",".$queryNumHistorico[$c][1];
				$vel .= ($vel=="")?$queryNumHistorico[$c][2]:",".$queryNumHistorico[$c][2];
				$kmr .= ($kmr=="")?$queryNumHistorico[$c][3]:",".$queryNumHistorico[$c][3];
				$kml .= ($kml=="")?$queryNumHistorico[$c][4]:",".$queryNumHistorico[$c][4];
				$tf  .= ($tf=="" )?$queryNumHistorico[$c][5]:",".$queryNumHistorico[$c][5];
				$ifu .= ($ifu=="")?$queryNumHistorico[$c][6]:",".$queryNumHistorico[$c][6];
				$pre .= ($pre=="")?$queryNumHistorico[$c][7]:",".$queryNumHistorico[$c][7];
				$cru .= ($cru=="")?$queryNumHistorico[$c][8]:",".$queryNumHistorico[$c][8];
				$det .= ($det=="")?$queryNumHistorico[$c][9]:",".$queryNumHistorico[$c][9];
				$car .= ($car=="")?$queryNumHistorico[$c][10]:",".$queryNumHistorico[$c][10];
				$tme .= ($tme=="")?$queryNumHistorico[$c][11]:",".$queryNumHistorico[$c][11];
				  }	
			$tpl->assign_vars(array(
					'TMP'      => $tmp,
					'RPM'      => $rpm,
					'VEL'      => $vel,
					'KMR'      => $kmr,
					'KML'      => $kml,
					'TF'       => $tf,
					'IFU'      => $ifu,
					'PRE'      => $pre,
					'CRU'      => $cru,
					'DET'      => $det,
					'CAR'      => $car,
					'TME'      => $tme
					));	
			$tpl->pparse('mGetValues');		
				
			}
		else{
			echo "0";
			
		}
	}else{
		echo "-1";
	}

?>