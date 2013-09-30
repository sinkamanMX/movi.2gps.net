<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';
	

	$idc   = $userAdmin->user_info['ID_CLIENTE'];
     $idu   = $userAdmin->user_info['ID_USUARIO'];

        
    $tpl->set_filenames(array(
	   'mTabla_xb' => 'tTabla_xb'
    ));

	$T='';
	$dayhr=date("Y-m-d");
//////////////////////////////////////////////////POR IDD///////////////////////////////////////////////////////////////////////	

if($_GET['idd'] == "" ){

$sql = "SELECT  P.ID_ENTREGA,
        P.ITEM_NUMBER,
        P.ID_DESPACHO,
        PG.DESCRIPCION AS CLIENTE,
       UN.DESCRIPTION AS UNIDAD,
       P.COMENTARIOS,
       EST.DESCRIPCION AS ESTADO,
       P.FECHA_SALIDA
FROM
  DSP_ITINERARIO P
  INNER JOIN DSP_UNIDAD_ASIGNADA AU ON (P.ID_DESPACHO = AU.ID_DESPACHO)
  INNER JOIN ADM_UNIDADES UN ON UN.COD_ENTITY=AU.COD_ENTITY
  LEFT OUTER JOIN ADM_GEOREFERENCIAS PG ON (P.COD_GEO = PG.ID_OBJECT_MAP)
  INNER JOIN DSP_DESPACHO NS ON (P.ID_DESPACHO=NS.ID_DESPACHO)
  INNER JOIN DSP_ESTATUS EST ON ( EST.ID_ESTATUS = P.ID_ESTATUS)
WHERE
 NS.COD_USER=".$idc." AND
  (P.ID_ESTATUS=3 OR P.ID_ESTATUS=5) AND
  FECHA_ENTREGA BETWEEN '".$dayhr." 00:00:00' AND '".$dayhr." 23:59:00'
 GROUP BY
 FECHA_ARRIBO ASC";
	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){	
				
			
				$tpl->assign_block_vars('datosxb',array(
						'IDE'			=> $row['ID_ENTREGA'],
						'IDD'	        => $row['ID_DESPACHO'],
						'ENT'	        => $row['ITEM_NUMBER'],
						'CTE'			=> utf8_encode($row['CLIENTE']),
						'UND'	        => utf8_encode($row['UNIDAD']),
						'OBS'	        => utf8_encode($row['COMENTARIOS']),
						'DTA'	        => $row['FECHA_SALIDA'],
						'EST'	        => utf8_encode($row['ESTADO'])						
					));
					}
				$tpl->pparse('mTabla_xb');
				
				
				
			}else{
			 echo 0;	
			}
}else{
	$sql = " SELECT P.ID_ENTREGA,
        P.ITEM_NUMBER,
        P.ID_DESPACHO,
        PG.DESCRIPCION AS CLIENTE,
       UN.DESCRIPTION AS UNIDAD,
       P.COMENTARIOS,
       EST.DESCRIPCION AS ESTADO,
       P.FECHA_SALIDA
FROM
  DSP_ITINERARIO P
  INNER JOIN DSP_UNIDAD_ASIGNADA AU ON (P.ID_DESPACHO = AU.ID_DESPACHO)
  INNER JOIN ADM_UNIDADES UN ON UN.COD_ENTITY=AU.COD_ENTITY
  LEFT OUTER JOIN ADM_GEOREFERENCIAS PG ON (P.COD_GEO = PG.ID_OBJECT_MAP)
  INNER JOIN DSP_DESPACHO NS ON (P.ID_DESPACHO=NS.ID_DESPACHO)
  INNER JOIN DSP_ESTATUS EST ON ( EST.ID_ESTATUS = P.ID_ESTATUS)
WHERE
 NS.COD_USER=".$idc." AND
 (P.ID_ESTATUS=3 OR P.ID_ESTATUS=5) AND
 P.ID_DESPACHO IN (".$_GET['idd'].")
 GROUP BY
 FECHA_ARRIBO ASC";
	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){		
				
					
				$tpl->assign_block_vars('datosxb',array(
						'IDE'			=> $row['ID_ENTREGA'],
						'IDD'	        => $row['ID_DESPACHO'],
						'ENT'	        => $row['ITEM_NUMBER'],
						'CTE'			=> utf8_encode($row['CLIENTE']),
						'UND'	        => utf8_encode($row['UNIDAD']),
						'OBS'	        => utf8_encode($row['COMENTARIOS']),
						'DTA'	        => $row['FECHA_SALIDA'],
						'EST'	        => utf8_encode($row['ESTADO'])						
					));
					}
				$tpl->pparse('mTabla_xb');
				
				
			}else{
			 echo 0;	
			}
	
	
	
	
	}	

$db->sqlClose();
?>