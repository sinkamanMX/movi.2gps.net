<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';
		

	$idc   = $userAdmin->user_info['ID_USUARIO'];

        
    $tpl->set_filenames(array(
	   'mTabla_y' => 'tTabla_y'
    ));

	$T='';
$dayhr=date("Y-m-d");

$sql = "SELECT D.ID_DESPACHO,
D.DESCRIPCION AS VJE,
UN.DESCRIPTION AS UND,
D.ITEM_NUMBER,
D.FECHA_INICIO,
D.FECHA_FIN,
D.TOLERANCIA,
        IF(P.FECHA_ARRIBO = '0000-00-00 00:00:00', '0', '1')AS ARRIBO,
         IF(P.FECHA_SALIDA = '0000-00-00 00:00:00', '0', '1') AS SALIDA
FROM
  DSP_ITINERARIO P
  INNER JOIN DSP_UNIDAD_ASIGNADA AU ON (P.ID_DESPACHO = AU.ID_DESPACHO)
  INNER JOIN ADM_UNIDADES UN ON UN.COD_ENTITY=AU.COD_ENTITY
  LEFT OUTER JOIN ADM_GEOREFERENCIAS PG ON (P.COD_GEO = PG.ID_OBJECT_MAP)
  INNER JOIN DSP_DESPACHO D ON (P.ID_DESPACHO=D.ID_DESPACHO)
  INNER JOIN DSP_ESTATUS EST ON ( EST.ID_ESTATUS = P.ID_ESTATUS)
WHERE
(P.FECHA_ARRIBO = '0000-00-00 00:00:00' OR P.FECHA_SALIDA = '0000-00-00 00:00:00') AND
P.COD_USER=".$idc."
GROUP BY
D.ID_DESPACHO";		
	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){
					$tpl->assign_block_vars('datosy',array(
						'IDD'	        => $row['ID_DESPACHO'],
						'DSP'	        => utf8_encode($row['VJE']),
						'UND'			=> utf8_encode($row['UND']),
						'IDV'	        => utf8_encode($row['ITEM_NUMBER']),
						'DTI'	        => $row['FECHA_INICIO'],
						'DTF'	        => $row['FECHA_FIN'],
						'TLR'	        => $row['TOLERANCIA']
					)); 
				}
				
				
				
			
			}else{
			
			
$sql = "SELECT D.ID_DESPACHO,
D.DESCRIPCION AS VJE,
UN.DESCRIPTION AS UND,
D.ITEM_NUMBER,
D.FECHA_INICIO,
D.FECHA_FIN,
D.TOLERANCIA
FROM
 DSP_DESPACHO D
  INNER JOIN DSP_UNIDAD_ASIGNADA AU ON (D.ID_DESPACHO = AU.ID_DESPACHO)
  INNER JOIN ADM_UNIDADES UN ON UN.COD_ENTITY=AU.COD_ENTITY
WHERE
D.FECHA_INICIO BETWEEN '".$dayhr." 00:00:00' AND '".$dayhr." 23:59:00' AND
D.COD_USER=".$idc."
ORDER BY
D.FECHA_INICIO";		
	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){
					$tpl->assign_block_vars('datosy',array(
						'IDD'	        => $row['ID_DESPACHO'],
						'DSP'	        => utf8_encode($row['VJE']),
						'UND'			=> utf8_encode($row['UND']),
						'IDV'	        => utf8_encode($row['ITEM_NUMBER']),
						'DTI'	        => $row['FECHA_INICIO'],
						'DTF'	        => $row['FECHA_FIN'],
						'TLR'	        => $row['TOLERANCIA']
					)); 
				}
				
				
				
			
			}else{
			 echo 0;	
			}
			}
			
			
			
		
	$tpl->pparse('mTabla_y');
$db->sqlClose();
?>