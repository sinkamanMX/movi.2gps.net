<?php
header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}


		

$idc   = $userAdmin->user_info['COD_CLIENT'];

$userID   	 = $userAdmin->user_info['COD_USER'];	



////////////////////////////////////////////////////////////////////////////


	$sql_k="SELECT COD_ENTITY FROM DSP_UNIDAD_ASIGNADA WHERE ID_DESPACHO=".$_GET['ide'];
	$query_k = $db->sqlQuery($sql_k);
	$count_k = $db->sqlEnumRows($query_k);
	$row_k   = $db->sqlFetchArray($query_k);
	
			$data_arr 	= array();
    		$counta		= 0;
            $id_unidad = $row_k['COD_ENTITY'];
			$result= $Positions->obtener_ureporte_1($row_k['COD_ENTITY']);
			$upos = array_reverse($result);
			$count = count($upos);
		
			for($c=0;$c<$count;$c++){
			if($upos != false){
				
	 $Q ="SELECT A.ICONO FROM SAVL1220_G A 
				INNER JOIN SAVL1220_GDET B ON A.ID_GROUP = B.ID_GROUP
				WHERE B.COD_ENTITY =". $id_unidad;
			$QWERY 	= $db->sqlQuery($Q);	
			$ROW	= $db->sqlFetchArray($QWERY);	
				
				$show	   = ($upos['PRIORITY']) ? 1: 0;
				
				
			//	$direccion = $Positions->direccion($upos['LATITUDE'],$upos['LONGITUDE']);
			
					$angle = $upos[$c][7];
					$anglef= $Positions->direccion_flecha($angle);
					
				$direccion = "EN MANTENIMIENTO...";
				$data_arr[$counta]  =  array(unit		  => $a_units[$i],
				                             dunit		  => $upos[$c][1]." (".$upos[$c][0].")",
				                             fecha		  => $upos[$c][2],
				                             evt 		  => $upos[$c][3],
				                             vel		  => $upos[$c][4], 
				                             dir		  => $direccion,
											 unitLatitude => $upos[$c][5],
											 unitLong 	  => $upos[$c][6],
											 show		  => $show,
											 icono        => $ROW['ICONO'],
											 angle        => $anglef
											
											 );
				$counta++;
			}
			
			}
			echo '{"items" :'.json_encode($data_arr).'}';  
			
		



?>