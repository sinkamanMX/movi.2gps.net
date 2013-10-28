<?php
header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';
$idc   = $userAdmin->user_info['ID_CLIENTE'];

 if(isset($_GET['dsp'])){


	$data = Array(
			'DESCRIPCION'   => $_GET['dsp'],
			'ITEM_NUMBER'   => $_GET['idv'],
			'FECHA_INICIO'	=> $_GET['dti'],
			'FECHA_FIN'	    => $_GET['dtf'],
			'TOLERANCIA'    => $_GET['tl'],
			'PARADAS'	    => $_GET['st'],
			'EXCESOS'	    => $_GET['ex']			
	);
	
	$where = " ID_DESPACHO  = ".$_GET['idd'];
	if(($dbf-> updateDB('DSP_DESPACHO',$data,$where,true)==true)){
		if($_GET['cu']==1){
		
			$data_x = Array(
					'COD_ENTITY'   		 => $_GET['und'],
					'FECHA_ASIGNACION'   => date('Y-m-d H:i:s')	
			);
			$where_x = " ID_DESPACHO  = ".$_GET['idd'];
			if(($dbf-> updateDB('DSP_UNIDAD_ASIGNADA',$data_x,$where_x,true)==true)){
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