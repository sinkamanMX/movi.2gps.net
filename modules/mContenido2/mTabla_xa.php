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
	   'mTabla_xa' => 'tTabla_xa'
    ));

	$T='';

//////////////////////////////////////////////////POR IDD///////////////////////////////////////////////////////////////////////	


	
	if($_GET['idd'] == "" ){

$sql = "SELECT  P.ID_ENTREGA,
        P.ITEM_NUMBER,
        P.ID_DESPACHO,
        PG.DESCRIPCION AS CLIENTE,
       UN.DESCRIPTION AS UNIDAD,
       P.COMENTARIOS,
       P.FECHA_ENTREGA,
        P.ID_ESTATUS,
         IF(P.FECHA_ARRIBO = '0000-00-00 00:00:00','No ha llegado',EST.DESCRIPCION) AS ESTADO,
         IF(P.ID_ESTATUS in (1,2,8),2,IF(P.ID_ESTATUS IN (9),3,IF(P.ID_ESTATUS = 4,1,0))) AS BOTON
FROM
  DSP_ITINERARIO P
  INNER JOIN DSP_UNIDAD_ASIGNADA AU ON (P.ID_DESPACHO = AU.ID_DESPACHO)
  INNER JOIN ADM_UNIDADES UN ON UN.COD_ENTITY=AU.COD_ENTITY
  LEFT OUTER JOIN ADM_GEOREFERENCIAS PG ON (P.COD_GEO = PG.ID_OBJECT_MAP)
  INNER JOIN DSP_DESPACHO NS ON (P.ID_DESPACHO=NS.ID_DESPACHO)
  INNER JOIN DSP_ESTATUS EST ON ( EST.ID_ESTATUS = P.ID_ESTATUS)
WHERE
 NS.COD_USER=".$idc." AND CURRENT_DATE BETWEEN CAST(NS.FECHA_INICIO AS DATE) AND CAST(NS.FECHA_FIN AS DATE) AND
      P.FECHA_ENTREGA < CURRENT_TIMESTAMP AND(P.ID_ESTATUS=2 OR P.ID_ESTATUS=1 OR P.ID_ESTATUS=4 OR P.ID_ESTATUS=8 OR P.ID_ESTATUS=9)
      AND NOW() > DATE_ADD(P.FECHA_ENTREGA, INTERVAL NS.TOLERANCIA MINUTE)
GROUP BY
 FECHA_ARRIBO ASC";
	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){	
				
			$tpl->assign_block_vars('datosxa',array(
						'IDE'			=> $row['ID_ENTREGA'],
						'IDD'	        => $row['ID_DESPACHO'],
						'ENT'	        => $row['ITEM_NUMBER'],
						'CTE'			=> utf8_encode($row['CLIENTE']),
						'UND'	        => utf8_encode($row['UNIDAD']),
						'OBS'	        => utf8_encode($row['COMENTARIOS']),
						'DTE'	        => $row['FECHA_ENTREGA'],
						'EST'	        => utf8_encode($row['ESTADO']),	
						'BTN'			=> $row['BOTON']
					)); 
				}
				$tpl->pparse('mTabla_xa');
				
				
				
				
				
			}else{
			 echo 0;	
			}
}else{
	 $sql = "SELECT  P.ID_ENTREGA,
        P.ITEM_NUMBER,
        P.ID_DESPACHO,
        PG.DESCRIPCION AS CLIENTE,
       UN.DESCRIPTION AS UNIDAD,
       P.COMENTARIOS,
       P.FECHA_ENTREGA,
        P.ID_ESTATUS,
         IF(P.FECHA_ARRIBO = '0000-00-00 00:00:00','No ha llegado',EST.DESCRIPCION) AS ESTADO,
         IF(P.ID_ESTATUS in (1,2,8),2,IF(P.ID_ESTATUS IN (9),3,IF(P.ID_ESTATUS = 4,1,0))) AS BOTON
FROM
  DSP_ITINERARIO P
  INNER JOIN DSP_UNIDAD_ASIGNADA AU ON (P.ID_DESPACHO = AU.ID_DESPACHO)
  INNER JOIN ADM_UNIDADES UN ON UN.COD_ENTITY=AU.COD_ENTITY
  LEFT OUTER JOIN ADM_GEOREFERENCIAS PG ON (P.COD_GEO = PG.ID_OBJECT_MAP)
  INNER JOIN DSP_DESPACHO NS ON (P.ID_DESPACHO=NS.ID_DESPACHO)
  INNER JOIN DSP_ESTATUS EST ON ( EST.ID_ESTATUS = P.ID_ESTATUS)
WHERE
 NS.COD_USER=".$idc." 
 AND P.FECHA_ENTREGA < CURRENT_DATE
 AND(P.ID_ESTATUS=2 OR P.ID_ESTATUS=1 OR P.ID_ESTATUS=4 OR P.ID_ESTATUS=8 OR P.ID_ESTATUS=9)
      AND NOW() > DATE_ADD(P.FECHA_ENTREGA, INTERVAL NS.TOLERANCIA MINUTE) AND P.ID_DESPACHO IN (".$_GET['idd'].")";
	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){		
				
			$tpl->assign_block_vars('datosxa',array(
						'IDE'			=> $row['ID_ENTREGA'],
						'IDD'	        => $row['ID_DESPACHO'],
						'ENT'	        => $row['ITEM_NUMBER'],
						'CTE'			=> utf8_encode($row['CLIENTE']),
						'UND'	        => utf8_encode($row['UNIDAD']),
						'OBS'	        => utf8_encode($row['COMENTARIOS']),
						'DTE'	        => $row['FECHA_ENTREGA'],
						'EST'	        => utf8_encode($row['ESTADO']),	
						'BTN'			=> $row['BOTON']
					)); 
				}
				$tpl->pparse('mTabla_xa');
				
				
			}else{
			 echo 0;	
			}

	}	

	
	
	
	
	
	
$db->sqlClose();
?>