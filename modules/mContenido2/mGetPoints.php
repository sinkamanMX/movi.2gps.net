<?php
/*
*/
   header("Content-Type: text/html;charset=utf-8");
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	

	$idc   = $userAdmin->user_info['ID_CLIENTE'];	
    
	   

      include('mFunciones_CV.php');
	  $funciones_cv = new mFunciones_CV();  
	  


	$T='';
	
/*$sql = "SELECT UN.COD_ENTITY,UN.DESCRIPTION, (SELECT MAX(FECHA_ASIGNACION)  FROM DSP_UNIDAD_ASIGNADA WHERE COD_ENTITY= UN.COD_ENTITY) AS ULTIMO_VIAJE FROM SAVL1120 UN 
                     LEFT JOIN DSP_UNIDAD_ASIGNADA UA ON UA.COD_ENTITY=UN.COD_ENTITY  AND UA.LIBRE=1 WHERE UN.COD_CLIENT=".$idc." AND (UN.DESCRIPTION LIKE '%".$_GET['txtfil']."%' OR (SELECT MAX(FECHA_ASIGNACION)  FROM DSP_UNIDAD_ASIGNADA WHERE COD_ENTITY= UN.COD_ENTITY) LIKE '%".$_GET['txtfil']."%')";	*/
/*	if(isset($_GET['txtfil']) && $_GET['txtfil'] != "" ){				 
$sql = "
SELECT UN.COD_ENTITY,UN.DESCRIPTION,
      (SELECT MAX(FECHA_ASIGNACION)
       FROM DSP_UNIDAD_ASIGNADA WHERE COD_ENTITY= UN.COD_ENTITY) AS
ULTIMO_VIAJE 
FROM SAVL1120 UN 
     LEFT JOIN DSP_UNIDAD_ASIGNADA UA ON  UA.COD_ENTITY=UN.COD_ENTITY AND
UA.LIBRE=1 
     INNER JOIN SAVL1220_GDET D ON D.COD_ENTITY = UN.COD_ENTITY
     INNER JOIN SAVL1220_G G ON G.ID_GROUP = D.ID_GROUP
WHERE G.COD_CLIENT=".$idc." AND (UN.DESCRIPTION LIKE '%".$_GET['txtfil']."%' OR (SELECT MAX(FECHA_ASIGNACION)  FROM DSP_UNIDAD_ASIGNADA WHERE COD_ENTITY= UN.COD_ENTITY) LIKE '%".$_GET['txtfil']."%')";						 	
		

	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){
					if($row['ULTIMO_VIAJE']==""){
						$v="Sin viajes asignados previamente";
						}
					else{
						$v=utf8_encode($row['ULTIMO_VIAJE']);
						}	
					$tpl->assign_block_vars('datos2',array(
						'IDU'			=> $row['COD_ENTITY'],
						'UND'	        => utf8_encode($row['DESCRIPTION']),
						'VJE'	        => $v
					)); 
				}
				$tpl->pparse('mTabla');
			}else{
			 echo 0;	
			}
		
	}else{
		

$sql="
SELECT UN.COD_ENTITY,UN.DESCRIPTION,
      (SELECT MAX(FECHA_ASIGNACION)
       FROM DSP_UNIDAD_ASIGNADA WHERE COD_ENTITY= UN.COD_ENTITY) AS
ULTIMO_VIAJE 
FROM SAVL1120 UN 
     LEFT JOIN DSP_UNIDAD_ASIGNADA UA ON  UA.COD_ENTITY=UN.COD_ENTITY AND
UA.LIBRE=1 
     INNER JOIN SAVL1220_GDET D ON D.COD_ENTITY = UN.COD_ENTITY
     INNER JOIN SAVL1220_G G ON G.ID_GROUP = D.ID_GROUP
WHERE G.COD_CLIENT=".$idc;	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){
					if($row['ULTIMO_VIAJE']==""){
						$v="Sin viajes asignados previamente";
						}
					else{
						$v=utf8_encode($row['ULTIMO_VIAJE']);
						}	
					$tpl->assign_block_vars('datos2',array(
						'IDU'			=> $row['COD_ENTITY'],
						'UND'	        => utf8_encode($row['DESCRIPTION']),
						'VJE'	        => $v
					)); 
				}
				$tpl->pparse('mTabla');
			}else{
			 echo 0;	
			}		
	}*/
	//-----------------------------------------------------------------------------UNIDADES EN DESPACHADOR
	
	$data_arr 	= array();
	$units_data 	= array();
	$cadena=' ';
	$counta		= 0;
	$counta1		= 0;
		$fecha=$_GET['date'];
			//$dayhr=date("Y-m-d");
			if($fecha=='undefined'){
			$dayhr=date("Y-m-d");
						
			}else{
			$dayhr=$_GET['date'];
			
			
			}
	
	
	
 $sql = "SELECT C.COD_ENTITY,
       A.DESCRIPCION AS VIAJE,
       B.ITEM_NUMBER AS ENTREGA,
       B.FECHA_ENTREGA,
       B.FECHA_ARRIBO,
       B.FECHA_SALIDA,
       B.FECHA_FIN,
       CURRENT_TIMESTAMP,
       IF(B.FECHA_ARRIBO = '0000-00-00 00:00:00' AND B.FECHA_ENTREGA < CURRENT_TIMESTAMP,'ACTIVIDAD SE HARA FUERA DE TIEMPO',
         IF(B.FECHA_ARRIBO = '0000-00-00 00:00:00' AND B.FECHA_ENTREGA > CURRENT_TIMESTAMP,'ACTIVIDAD PENDIENTE',
         IF(B.FECHA_ARRIBO > B.FECHA_ENTREGA AND B.FECHA_SALIDA > B.FECHA_FIN,'ACTIVIDAD REALIZADA FUERA DE TIEMPO',
         IF(B.FECHA_ARRIBO <= B.FECHA_ENTREGA AND B.FECHA_SALIDA <=B.FECHA_FIN,'ACTIVIDAD REALIZADA A TIEMPO',
         IF(B.FECHA_ARRIBO <= B.FECHA_ENTREGA AND B.FECHA_SALIDA = '0000-00-00 00:00:00' AND B.FECHA_FIN < CURRENT_TIMESTAMP,'ACTIVIDAD EN PROCESO: ARRIBO A TIEMPO, TIEMPO DE ESTANCIA NORMAL',
         IF(B.FECHA_ARRIBO <= B.FECHA_ENTREGA AND B.FECHA_SALIDA = '0000-00-00 00:00:00' AND B.FECHA_FIN > CURRENT_TIMESTAMP,'ACTIVIDAD EN PROCESO: ARRIBO A TIEMPO, TIEMPO DE ESTANCIA EXCEDIDO',
         IF(B.FECHA_ARRIBO > B.FECHA_ENTREGA AND B.FECHA_SALIDA = '0000-00-00 00:00:00' AND B.FECHA_FIN < CURRENT_TIMESTAMP,'ACTIVIDAD EN PROCESO: ARRIBO FUERA DE TIEMPO, TIEMPO DE ESTANCIA EXCEDIDO',
         IF(B.FECHA_ARRIBO > B.FECHA_ENTREGA AND B.FECHA_SALIDA = '0000-00-00 00:00:00' AND B.FECHA_FIN > CURRENT_TIMESTAMP,'ACTIVIDAD EN PROCESO: ARRIBO FUERA DE TIEMPO, TIEMPO DE ESTANCIA NORMAL',
         IF(B.FECHA_ARRIBO > B.FECHA_ENTREGA AND B.FECHA_SALIDA < B.FECHA_FIN,'ACTIVIDAD REALIZADA FUERA DE TIEMPO, TIEMPO DE ESTANCIA NORMAL',
         'ACTIVIDAD PENDIENTE'))))))))) AS ESTATUS,
       IF(B.FECHA_ARRIBO = '0000-00-00 00:00:00' AND B.FECHA_ENTREGA < CURRENT_TIMESTAMP,'ROJO',
         IF(B.FECHA_ARRIBO = '0000-00-00 00:00:00' AND B.FECHA_ENTREGA > CURRENT_TIMESTAMP,'VERDE',
         IF(B.FECHA_ARRIBO > B.FECHA_ENTREGA AND B.FECHA_SALIDA > B.FECHA_FIN,'NARANJA',
         IF(B.FECHA_ARRIBO <= B.FECHA_ENTREGA AND B.FECHA_SALIDA <=B.FECHA_FIN,'AZUL',
         IF(B.FECHA_ARRIBO <= B.FECHA_ENTREGA AND B.FECHA_SALIDA = '0000-00-00 00:00:00' AND B.FECHA_FIN < CURRENT_TIMESTAMP,'AZUL/GRIS',
         IF(B.FECHA_ARRIBO <= B.FECHA_ENTREGA AND B.FECHA_SALIDA = '0000-00-00 00:00:00' AND B.FECHA_FIN > CURRENT_TIMESTAMP,'AZUL/NARANJA',
         IF(B.FECHA_ARRIBO > B.FECHA_ENTREGA AND B.FECHA_SALIDA = '0000-00-00 00:00:00' AND B.FECHA_FIN < CURRENT_TIMESTAMP,'AZUL/ROJO',
         IF(B.FECHA_ARRIBO > B.FECHA_ENTREGA AND B.FECHA_SALIDA = '0000-00-00 00:00:00' AND B.FECHA_FIN > CURRENT_TIMESTAMP,'AZUL/AMARILLO',
         IF(B.FECHA_ARRIBO > B.FECHA_ENTREGA AND B.FECHA_SALIDA < B.FECHA_FIN,'NARANJA',
         'VERDE'))))))))) AS COLOR,
       D.LATITUDE,
       D.LONGITUDE,
       D.DESCRIPCION,
	   UN.DESCRIPTION AS NOMUNI
FROM DSP_DESPACHO A
  INNER JOIN DSP_ITINERARIO B      ON B.ID_DESPACHO = A.ID_DESPACHO
  INNER JOIN DSP_UNIDAD_ASIGNADA C ON C.ID_DESPACHO = A.ID_DESPACHO
  INNER JOIN ADM_GEOREFERENCIAS D         ON D.ID_OBJECT_MAP = B.COD_GEO
  INNER JOIN ADM_USUARIOS GD ON GD.ID_USUARIO = A.COD_USER
  INNER JOIN ADM_UNIDADES UN ON UN.COD_ENTITY=C.COD_ENTITY     
WHERE
'".$dayhr."' BETWEEN CAST(A.FECHA_INICIO AS DATE) AND CAST(A.FECHA_FIN AS DATE)
AND GD.ID_CLIENTE=".$idc."
ORDER BY B.FECHA_ENTREGA ASC";	
	/*AND (ID_ESTATUS=1 OR ID_ESTATUS=4)    rowspan='3'*/
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			$consta=0;
			if($count>0){
				while($row = $db->sqlFetchArray($query)){
					
					$data_arr[$counta]  =  array(ident => '0', //0
											unitd		  => $row['COD_ENTITY'], // ID DE UNIDAD 1
				                            dunit		  => $row['DESCRIPCION'], // NOMBRE 2
											nomunid		  => $row['NOMUNI'], // 3
											estatus       => $row['ESTATUS'],//4
				                            fecha		  => $row['FECHA_ENTREGA'].'#'.$row['FECHA_SALIDA'].'!!'.$row['FECHA_ARRIBO'].'#'.$row['FECHA_FIN'], //FECHA
				                             evt 		  => 'nada', //6
											color         => $row['COLOR'],//7
				                             vel		  => 'nada', //VELOCIDAD 8 
				                             dire		  => 'nada', // DIRECCION  9 
											 unitLatitude => $row['LATITUDE'], //LATITUD 10
											 unitLong 	  => $row['LONGITUDE'], //LONGITUD 11
											icono        => 'nada', //ICONO 
											 angle        => 'nada'  //ANGULO
											 );
				$counta++;
					
					
					if($consta==0){
					 $table_h= 'HIST'.$Positions->get_tablename($idc);
					 $upos= $funciones_cv->obtener_ureporte($row['COD_ENTITY'],$table_h);
					//$upos =  $funciones_cv->obtener_ureporte($row['COD_ENTITY']);
					
					$direccion  = $Positions->direccion($upos['LATITUDE'],$upos['LONGITUDE']);
					
					$new_dir= str_replace(',','-',$direccion);
					
					
					$angle = $upos['ANGLE'];
					$anglef= $funciones_cv->direccion_flecha($angle);
					
		
				
						$units_data[$counta1]=$row['COD_ENTITY'];
					$data_arr[$counta]  =  array(ident => '1', //0
											unitd		  => $row['COD_ENTITY'], // ID DE UNIDAD 1
											nomunid		  => $row['NOMUNI'], //2
				                            dunit		  => $upos['DESCRIPTION'], // NOMBRE 3
											estatus       => 'nada', // 4
				                            fecha		  => $upos['GPS_DATETIME'], //FECHA 5
				                             evt 		  => $upos['DESC_EVT'],  //6
											color         => 'nada',   //7
				                             vel		  => $upos['VELOCITY'], //VELOCIDAD 8
				                             dire		  => $new_dir, // DIRECCION 9
											 unitLatitude => $upos['LATITUDE'], //LATITUD 10
											 unitLong 	  => $upos['LONGITUDE'], //LONGITUD  11
											icono        => $ROW['ICONO'], //ICONO 12
											 angle        => $anglef  //ANGULO 13
											 );
											  $counta1++;
				$counta++;
				$consta=1;
					}else{
						for($i=0;$i<count($units_data);$i++){
							
							if(in_array($row['COD_ENTITY'], $units_data)!=true){
								
								 	$table_h= 'HIST'.$Positions->get_tablename($idc);
									 $upos= $funciones_cv->obtener_ureporte($row['COD_ENTITY'],$table_h);
									//$upos =  $funciones_cv->obtener_ureporte($row['COD_ENTITY']);
									
									$direccion  = $Positions->direccion($upos['LATITUDE'],$upos['LONGITUDE']);
									
									$new_dir= str_replace(',','-',$direccion);
									
									
									$angle = $upos['ANGLE'];
									$anglef= $funciones_cv->direccion_flecha($angle);
								
								
										$units_data[$counta1]=$row['COD_ENTITY'];
										$data_arr[$counta]  =  array(ident => '1', //0
											unitd		  => $row['COD_ENTITY'], // ID DE UNIDAD 1
											nomunid		  => $row['NOMUNI'], //2
				                            dunit		  => $upos['DESCRIPTION'], // NOMBRE 3
											estatus       => 'nada', // 4
				                            fecha		  => $upos['GPS_DATETIME'], //FECHA 5
				                             evt 		  => $upos['DESC_EVT'],  //6
											color         => 'nada',   //7
				                             vel		  => $upos['VELOCITY'], //VELOCIDAD 8
				                             dire		  => $new_dir, // DIRECCION 9
											 unitLatitude => $upos['LATITUDE'], //LATITUD 10
											 unitLong 	  => $upos['LONGITUDE'], //LONGITUD  11
											icono        => $ROW['ICONO'], //ICONO 12
											 angle        => $anglef  //ANGULO 13
											 );
											 $counta1++;
									$counta++;
								}
							
							}
						
						
						}
				
					
					
					
					}
					
					for($i=0;$i<count($data_arr);$i++){
						
						if($cadena==' '){
						 $cadena=implode(",", $data_arr[$i]);
						}else{
							
							 $cadena=$cadena.'|'.implode(",", $data_arr[$i]);
							}
					
					}
					echo $cadena;
					//echo '{"items" :'.json_encode($data_arr).'}';
					}else{
						echo 0;
						//	echo '{"items" :'.json_encode('0').'}';
						}
?>