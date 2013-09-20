<?php
header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);


 if(isset($_GET['cte'])){


	$data = Array(
			'COD_GEO'   	=> $_GET['cte'],
			'ITEM_NUMBER'   => $_GET['idp'],
			'FECHA_ENTREGA'	=> $_GET['dte'],
			'FECHA_SALIDA'  => $_GET['dts'],
			'COMENTARIOS'	=> $_GET['obs']		
	);
	
	$where = " ID_ENTREGA  = ".$_GET['ide'];
	if(($dbf-> updateDB('DSP_ITINERARIO',$data,$where,true)==true)){
		if($_GET['cst']!=0){
		
			$data_x = Array(
					'ID_CUESTIONARIO'   => $_GET['cst'],
					'ID_PAYLOAD'   		=> $_GET['pld']
			);
			$where_x = " ID_ENTREGA  = ".$_GET['ide'];
			if(($dbf-> updateDB('DSP_DOCUMENTA_ITINERARIO',$data_x,$where_x,true)==true)){
					echo 1;
				}
			else{
				echo -2;
				}	
			}	
			echo 1;
			}
	else{echo 0;}
	 }else{echo -1;}
$db->sqlClose();
?>