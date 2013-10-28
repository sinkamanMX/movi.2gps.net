<?php
header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);


 if(isset($_GET['id'])){
//echo $_GET['id'];
/*if($_GET['st']==8){
	$data = Array(
			'ID_ESTATUS'   	=> 4,
			'FECHA_ARRIBO'  => $_GET['dt']
			
	);
}
if($_GET['st']==9){
	$data = Array(
			'ID_ESTATUS'   	=> 3,
			'FECHA_ARRIBO'  => $_GET['dt'],
			'FECHA_SALIDA'  => $_GET['dt2']	
	);
}*/
	$data = Array(
			'ID_ESTATUS'   	=> 3,
			'FECHA_SALIDA'  => $_GET['dt']
			
	);

	$where = " ID_ENTREGA  = ".$_GET['id'];
	if(($dbf-> updateDB('DSP_ITINERARIO',$data,$where,true)==true)){
		echo 1;
		}
	else{echo 0;}
	 }else{echo -1;}
$db->sqlClose();
?>