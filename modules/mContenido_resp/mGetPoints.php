<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	

	$idc   = $userAdmin->user_info['COD_CLIENT'];	
    
	   

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
       D.DESCRIPTION,
	   UN.DESCRIPTION AS NOMUNI
FROM DSP_DESPACHO A
  INNER JOIN DSP_ITINERARIO B      ON B.ID_DESPACHO = A.ID_DESPACHO
  INNER JOIN DSP_UNIDAD_ASIGNADA C ON C.ID_DESPACHO = A.ID_DESPACHO
  INNER JOIN SAVL_G_PRIN D         ON D.COD_OBJECT_MAP = B.COD_GEO
  INNER JOIN SAVL1220_GDET GD ON GD.COD_ENTITY = C.COD_ENTITY
  INNER JOIN SAVL1220_G G ON G.ID_GROUP = GD.ID_GROUP
  INNER JOIN SAVL1120 UN ON UN.COD_ENTITY=C.COD_ENTITY     
WHERE
'".$dayhr."' BETWEEN CAST(A.FECHA_INICIO AS DATE) AND CAST(A.FECHA_FIN AS DATE)
AND G.COD_CLIENT=".$idc."
ORDER BY B.FECHA_ENTREGA ASC";	
	/*AND (ID_ESTATUS=1 OR ID_ESTATUS=4)    rowspan='3'*/
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){
					
					$data_arr[$counta]  =  array(ident => '0',
											unitd		  => $row['COD_ENTITY'], // ID DE UNIDAD 
				                            dunit		  => $userAdmin->codif($row['DESCRIPTION']), // NOMBRE 
											nomunid		  => $userAdmin->codif($row['NOMUNI']),
											estatus       => $row['ESTATUS'],
				                            fecha		  => $row['FECHA_ENTREGA'].','.$row['FECHA_SALIDA'].'!!'.$row['FECHA_ARRIBO'].','.$row['FECHA_FIN'], //FECHA
				                             evt 		  => 'nada', 
											color         => $row['COLOR'],
				                             vel		  => 'nada', //VELOCIDAD
				                             dire		  => 'nada', // DIRECCION
											 unitLatitude => $row['LATITUDE'], //LATITUD
											 unitLong 	  => $row['LONGITUDE'], //LONGITUD 
											icono        => 'nada', //ICONO 
											 angle        => 'nada'  //ANGULO
											 );
				$counta++;
					
					
					
					
					$upos = $Positions->obtener_ureporte($row['COD_ENTITY']);
					
					$direccion  = $Positions->direccion_s($upos['LATITUDE'],$upos['LONGITUDE']);
					if($userAdmin->codif($direccion)==''){
					    $direccion1  = $Positions->direccion($upos['LATITUDE'],$upos['LONGITUDE']);
							if($userAdmin->codif($direccion1)==''){
							$new_dir='Sin direccion';
							}else{
							$new_dir=$userAdmin->codif($direccion1);
							}
					}else
					{
					$new_dir=$userAdmin->codif($direccion);
					}
					
					$angle = $upos['ANGLE'];
					$anglef= $Positions->direccion_flecha($angle);
					
		
				
						$units_data[$counta1]=$row['COD_ENTITY'];
					$data_arr[$counta]  =  array(ident => '1',
											unitd		  => $row['COD_ENTITY'], // ID DE UNIDAD 
											nomunid		  => $userAdmin->codif($row['NOMUNI']),
				                            dunit		  => $userAdmin->codif($upos['DESCRIPTION']), // NOMBRE 
											estatus       => 'nada',
				                            fecha		  => $upos['GPS_DATETIME'], //FECHA
				                             evt 		  => $userAdmin->codif($upos['DESC_EVT']), 
											color         => 'nada',
				                             vel		  => $upos['VELOCITY'], //VELOCIDAD
				                             dire		  => $new_dir, // DIRECCION
											 unitLatitude => $upos['LATITUDE'], //LATITUD
											 unitLong 	  => $upos['LONGITUDE'], //LONGITUD 
											icono        => $ROW['ICONO'], //ICONO 
											 angle        => $anglef  //ANGULO
											 );
				$counta++;
					
				
					
					
					
					}
					echo '{"items" :'.json_encode($data_arr).'}';
					}else{
							echo '{"items" :'.json_encode('0').'}';
						}
?>