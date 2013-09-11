<?php
/**/
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
//$userData = new usersAdministration();	

if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}
set_time_limit(600000);

$tpl->set_filenames(array('mGetValues'=>'tGetValues'));

	$rtime = " AND GPS_DATETIME BETWEEN '".$_GET['dti']."' AND '".$_GET['dtf']."' ";
	$cliente = $userAdmin->user_info['ID_CLIENTE'];
	$idunit = $_GET['und'];

	

	
	$tablaHistorico = $Positions->get_tablename($cliente);
	
	if($tablaHistorico != ""){
		$hst = "ACC_HIST".$tablaHistorico;
		
		$result = array();
		
		$sql = "SELECT E_TEMP,E_RPM,VS,TOD,F_ECO,GPS_DATETIME,LATITUDE,LONGITUDE FROM ".$hst." WHERE COD_ENTITY= ".$idunit.$rtime." ORDER BY GPS_DATETIME;";
		
		$qry = $db->sqlQuery($sql);
		$cnt = $db->sqlEnumRows($qry);
		
		if($cnt > 0){
			while($row = $db->sqlFetchArray($qry)){
				$result[] = $row; // Inside while loop
			}
		}
		echo json_encode( $result = array('aaData'=>$result ) );
		$db->sqlClose();
		}else{
		echo "-1";
	}

?>