<?php
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';	

	$idc   = $userAdmin->user_info['ID_CLIENTE'];
	   $idu   = $userAdmin->user_info['ID_USUARIO'];
	   if($_GET['tip']==0){
	    $data = Array(
			'ID_ESTATUS'		=> 2, 
			'COD_USER'   		=> $idu,
			'DESCRIPCION'    	=> $_GET['dsc'],
			'ITEM_NUMBER'	    => $_GET['idv'],
			'FECHA_INICIO'	    => $_GET['dti'],
			'FECHA_FIN'	        => $_GET['dtf'],
			'TOLERANCIA'	    => $_GET['tol'],
			'PARADAS'	        => $_GET['stp'],
			'EXCESOS'	        => $_GET['exc'],
			'CREADO'	        => date('Y-m-d H:i:s')
		);


			if($dbf-> insertDB($data,'DSP_DESPACHO',true) == true){
				$sql_f="SELECT LAST_INSERT_ID() AS IDV;";
				$query_f = $db->sqlQuery($sql_f);
				$row=$db->sqlFetchArray($query_f);
				$data_b = Array(
					'ID_DESPACHO'		=> $row['IDV'], 
					'COD_ENTITY'   		=> $_GET['und'],
					'FECHA_ASIGNACION'  => date('Y-m-d H:i:s'),
					'ACTIVO'	    	=> 1,
					'LIBRE'	    		=> 0
				);
				if($dbf-> insertDB($data_b,'DSP_UNIDAD_ASIGNADA',true) == true){
					echo $row['IDV'];
				}
				else{
					echo 0;
					}
			}else{
				echo 0;
				}
				
	   }else{
		   $data = Array(
			'ID_ESTATUS'		=> 2, 
			'COD_USER'   		=> $idu,
			'DESCRIPCION'    	=> $_GET['dsc'],
			'ITEM_NUMBER'	    => $_GET['idv'],
			'FECHA_INICIO'	    => $_GET['dti'],
			'FECHA_FIN'	        => $_GET['dtf'],
			'TOLERANCIA'	    => $_GET['tol'],
			'PARADAS'	        => $_GET['stp'],
			'EXCESOS'	        => $_GET['exc'],
			'CREADO'	        => date('Y-m-d H:i:s')
		);
		$where = " ID_DESPACHO  = ".$_GET['tip'];
			$dbf-> updateDB('DSP_DESPACHO',$datas,$where,true);
		
		$data_b = Array(
					'COD_ENTITY'   		=> $_GET['und'],
					'FECHA_ASIGNACION'  => date('Y-m-d H:i:s'),
					'ACTIVO'	    	=> 1,
					'LIBRE'	    		=> 0
				);
				$where1 = " ID_DESPACHO  = ".$_GET['tip'];
		$dbf-> updateDB('DSP_UNIDAD_ASIGNADA',$data_b,$where1,true);
		   
		   }
		
$db->sqlClose();
?>