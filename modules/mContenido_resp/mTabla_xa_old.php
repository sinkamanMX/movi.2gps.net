<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	
	$tpl->set_filenames(array('default'=>'default'));	
	$idc   = $userAdmin->user_info['COD_CLIENT'];	
       

        
    $tpl->set_filenames(array(
	   'mTabla_xa' => 'tTabla_xa'
    ));

	$T='';

//////////////////////////////////////////////////POR IDD///////////////////////////////////////////////////////////////////////	

if(isset($_GET['idd']) && $_GET['idd'] != "" ){
	if(isset($_GET['txtfil']) && $_GET['txtfil'] != "" ){
/*$sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPTION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_ENTREGA, ES.DESCRIPCION AS EST FROM DSP_ITINERARIO D
INNER JOIN SAVL_G_PRIN GP ON GP.COD_OBJECT_MAP=D.COD_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1120    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN DSP_DESPACHO DE ON DE.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1220_GDET DG ON DG.COD_ENTITY = UN.COD_ENTITY
INNER JOIN SAVL1220_G G ON G.ID_GROUP = DG.ID_GROUP 
WHERE (D.ID_ESTATUS=2 OR D.ID_ESTATUS=1 OR D.ID_ESTATUS=4) AND (D.ITEM_NUMBER LIKE '%".$_GET['txtfil']."%' OR GP.DESCRIPTION  LIKE '%".$_GET['txtfil']."%' OR UN.DESCRIPTION LIKE '%".$_GET['txtfil']."%' OR D.COMENTARIOS LIKE '%".$_GET['txtfil']."%' OR D.FECHA_ENTREGA LIKE '%".$_GET['txtfil']."%' ) AND NOW() > DATE_ADD(D.FECHA_ENTREGA, INTERVAL DE.TOLERANCIA MINUTE) AND G.COD_CLIENT=".$idc." AND D.ID_DESPACHO=".$_GET['idd'];	*/	
$sql = "SELECT D.ID_ENTREGA, 
               D.ID_DESPACHO, 
			   D.ITEM_NUMBER, 
			   GP.DESCRIPTION AS CTE, 
			   UN.DESCRIPTION AS UND, 
			   D.COMENTARIOS, 
			   D.FECHA_ENTREGA, 
			   IF(D.FECHA_ARRIBO = '0000-00-00 00:00:00','No ha llegado',
			     IF(D.FECHA_ARRIBO > D.FECHA_ENTREGA,'Llego fuera de tiempo','En proceso de entrega')) AS EST
FROM DSP_ITINERARIO D
INNER JOIN SAVL_G_PRIN GP ON GP.COD_OBJECT_MAP=D.COD_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1120    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN DSP_DESPACHO DE ON DE.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1220_GDET DG ON DG.COD_ENTITY = UN.COD_ENTITY
INNER JOIN SAVL1220_G G ON G.ID_GROUP = DG.ID_GROUP 
WHERE CURRENT_DATE BETWEEN CAST(DE.FECHA_INICIO AS DATE) AND CAST(DE.FECHA_FIN AS DATE) AND
      D.FECHA_ENTREGA < CURRENT_TIMESTAMP AND(D.ID_ESTATUS=2 OR D.ID_ESTATUS=1 OR D.ID_ESTATUS=4) AND (D.ITEM_NUMBER LIKE '%".$_GET['txtfil']."%' OR GP.DESCRIPTION  LIKE '%".$_GET['txtfil']."%' OR UN.DESCRIPTION LIKE '%".$_GET['txtfil']."%' OR D.COMENTARIOS LIKE '%".$_GET['txtfil']."%' OR D.FECHA_ENTREGA LIKE '%".$_GET['txtfil']."%' ) AND NOW() > DATE_ADD(D.FECHA_ENTREGA, INTERVAL DE.TOLERANCIA MINUTE)  AND G.COD_CLIENT=".$idc." AND D.ID_DESPACHO=".$_GET['idd'];			

	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){
					$tpl->assign_block_vars('datosxa',array(
						'IDE'			=> $row['ID_ENTREGA'],
						'IDD'	        => $row['ID_DESPACHO'],
						'ENT'	        => $row['ITEM_NUMBER'],
						'CTE'			=> utf8_encode($row['CTE']),
						'UND'	        => utf8_encode($row['UND']),
						'OBS'	        => utf8_encode($row['COMENTARIOS']),
						'DTE'	        => $row['FECHA_ENTREGA'],
						'EST'	        => utf8_encode($row['EST'])
					)); 
				}
				$tpl->pparse('mTabla_xa');
			}else{
			 echo 0;	
			}
		
	}else{
		
/*$sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPTION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_ENTREGA, ES.DESCRIPCION AS EST FROM DSP_ITINERARIO D
INNER JOIN SAVL_G_PRIN GP ON GP.COD_OBJECT_MAP=D.COD_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1120    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN DSP_DESPACHO DE ON DE.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1220_GDET DG ON DG.COD_ENTITY = UN.COD_ENTITY
INNER JOIN SAVL1220_G G ON G.ID_GROUP = DG.ID_GROUP 
WHERE (D.ID_ESTATUS=2 OR D.ID_ESTATUS=1 OR D.ID_ESTATUS=4) AND NOW() > DATE_ADD(D.FECHA_ENTREGA, INTERVAL DE.TOLERANCIA MINUTE) AND G.COD_CLIENT=".$idc." AND D.ID_DESPACHO=".$_GET['idd'];*/
$sql = "SELECT  D.ID_ENTREGA, 
               D.ID_DESPACHO, 
			   D.ITEM_NUMBER, 
			   GP.DESCRIPTION AS CTE, 
			   UN.DESCRIPTION AS UND, 
			   D.COMENTARIOS, 
			   D.FECHA_ENTREGA, 
			   IF(D.FECHA_ARRIBO = '0000-00-00 00:00:00','No ha llegado',
			     IF(D.FECHA_ARRIBO > D.FECHA_ENTREGA,'Llego fuera de tiempo','En proceso de entrega')) AS EST
FROM DSP_ITINERARIO D
INNER JOIN SAVL_G_PRIN GP ON GP.COD_OBJECT_MAP=D.COD_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1120    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN DSP_DESPACHO DE ON DE.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1220_GDET DG ON DG.COD_ENTITY = UN.COD_ENTITY
INNER JOIN SAVL1220_G G ON G.ID_GROUP = DG.ID_GROUP 
WHERE (D.ID_ESTATUS=2 OR D.ID_ESTATUS=1 OR D.ID_ESTATUS=4) AND NOW() > DATE_ADD(D.FECHA_ENTREGA, INTERVAL DE.TOLERANCIA MINUTE) AND  CURRENT_DATE BETWEEN CAST(DE.FECHA_INICIO AS DATE) AND CAST(DE.FECHA_FIN AS DATE) AND
      D.FECHA_ENTREGA < CURRENT_TIMESTAMP AND G.COD_CLIENT=".$idc." AND D.ID_DESPACHO=".$_GET['idd'];	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){					
				$tpl->assign_block_vars('datosxa',array(
						'IDE'			=> $row['ID_ENTREGA'],
						'IDD'	        => $row['ID_DESPACHO'],
						'ENT'	        => $row['ITEM_NUMBER'],
						'CTE'			=> utf8_encode($row['CTE']),
						'UND'	        => utf8_encode($row['UND']),
						'OBS'	        => utf8_encode($row['COMENTARIOS']),
						'DTE'	        => $row['FECHA_ENTREGA'],
						'EST'	        => utf8_encode($row['EST'])						
					));
					}
				$tpl->pparse('mTabla_xa');
			}else{
			 echo 0;	
			}		
	}	
}	
else{
	if(isset($_GET['txtfil']) && $_GET['txtfil'] != "" ){
/*$sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPTION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_ENTREGA, ES.DESCRIPCION AS EST FROM DSP_ITINERARIO D
INNER JOIN SAVL_G_PRIN GP ON GP.COD_OBJECT_MAP=D.COD_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1120    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN DSP_DESPACHO DE ON DE.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1220_GDET DG ON DG.COD_ENTITY = UN.COD_ENTITY
INNER JOIN SAVL1220_G G ON G.ID_GROUP = DG.ID_GROUP 
WHERE (D.ID_ESTATUS=2 OR D.ID_ESTATUS=1 OR D.ID_ESTATUS=4) AND (D.ITEM_NUMBER LIKE '%".$_GET['txtfil']."%' OR GP.DESCRIPTION  LIKE '%".$_GET['txtfil']."%' OR UN.DESCRIPTION LIKE '%".$_GET['txtfil']."%' OR D.COMENTARIOS LIKE '%".$_GET['txtfil']."%' OR D.FECHA_ENTREGA LIKE '%".$_GET['txtfil']."%' ) AND NOW() > DATE_ADD(D.FECHA_ENTREGA, INTERVAL DE.TOLERANCIA MINUTE) AND G.COD_CLIENT=".$idc;	*/	
		
$sql = "SELECT  D.ID_ENTREGA, 
               D.ID_DESPACHO, 
			   D.ITEM_NUMBER, 
			   GP.DESCRIPTION AS CTE, 
			   UN.DESCRIPTION AS UND, 
			   D.COMENTARIOS, 
			   D.FECHA_ENTREGA, 
			   IF(D.FECHA_ARRIBO = '0000-00-00 00:00:00','No ha llegado',
			     IF(D.FECHA_ARRIBO > D.FECHA_ENTREGA,'Llego fuera de tiempo','En proceso de entrega')) AS EST
FROM DSP_ITINERARIO D
INNER JOIN SAVL_G_PRIN GP ON GP.COD_OBJECT_MAP=D.COD_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1120    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN DSP_DESPACHO DE ON DE.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1220_GDET DG ON DG.COD_ENTITY = UN.COD_ENTITY
INNER JOIN SAVL1220_G G ON G.ID_GROUP = DG.ID_GROUP 
WHERE (D.ID_ESTATUS=2 OR D.ID_ESTATUS=1 OR D.ID_ESTATUS=4) AND (D.ITEM_NUMBER LIKE '%".$_GET['txtfil']."%' OR GP.DESCRIPTION  LIKE '%".$_GET['txtfil']."%' OR UN.DESCRIPTION LIKE '%".$_GET['txtfil']."%' OR D.COMENTARIOS LIKE '%".$_GET['txtfil']."%' OR D.FECHA_ENTREGA LIKE '%".$_GET['txtfil']."%' ) AND NOW() > DATE_ADD(D.FECHA_ENTREGA, INTERVAL DE.TOLERANCIA MINUTE) AND  CURRENT_DATE BETWEEN CAST(DE.FECHA_INICIO AS DATE) AND CAST(DE.FECHA_FIN AS DATE) AND
      D.FECHA_ENTREGA < CURRENT_TIMESTAMP AND G.COD_CLIENT=".$idc;	
	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){
					$tpl->assign_block_vars('datosxa',array(
						'IDE'			=> $row['ID_ENTREGA'],
						'IDD'	        => $row['ID_DESPACHO'],
						'ENT'	        => $row['ITEM_NUMBER'],
						'CTE'			=> utf8_encode($row['CTE']),
						'UND'	        => utf8_encode($row['UND']),
						'OBS'	        => utf8_encode($row['COMENTARIOS']),
						'DTE'	        => $row['FECHA_ENTREGA'],
						'EST'	        => utf8_encode($row['EST'])
					)); 
				}
				$tpl->pparse('mTabla_xa');
			}else{
			 echo 0;	
			}
		
	}else{
		
 $sql = "SELECT  D.ID_ENTREGA, 
               D.ID_DESPACHO, 
			   D.ITEM_NUMBER, 
			   GP.DESCRIPTION AS CTE, 
			   UN.DESCRIPTION AS UND, 
			   D.COMENTARIOS, 
			   D.FECHA_ENTREGA, 
			   IF(D.FECHA_ARRIBO = '0000-00-00 00:00:00','No ha llegado',
			     IF(D.FECHA_ARRIBO > D.FECHA_ENTREGA,'Llego fuera de tiempo','En proceso de entrega')) AS EST
 FROM DSP_ITINERARIO D
INNER JOIN SAVL_G_PRIN GP ON GP.COD_OBJECT_MAP=D.COD_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1120    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN DSP_DESPACHO DE ON DE.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1220_GDET DG ON DG.COD_ENTITY = UN.COD_ENTITY
INNER JOIN SAVL1220_G G ON G.ID_GROUP = DG.ID_GROUP 
WHERE (D.ID_ESTATUS=2 OR D.ID_ESTATUS=1 OR D.ID_ESTATUS=4) AND NOW() > DATE_ADD(D.FECHA_ENTREGA, INTERVAL DE.TOLERANCIA MINUTE) AND  
CURRENT_DATE BETWEEN CAST(DE.FECHA_INICIO AS DATE) AND CAST(DE.FECHA_FIN AS DATE) AND
      D.FECHA_ENTREGA < CURRENT_TIMESTAMP AND
      ES.FINAL = 0 AND G.COD_CLIENT=".$idc;

/*SELECT A.*
FROM DSP_ITINERARIO A
  INNER JOIN DSP_ESTATUS B ON B.ID_ESTATUS = A.ID_ESTATUS
INNER JOIN DSP_DESPACHO C ON C.ID_DESPACHO = A.ID_DESPACHO
WHERE CURRENT_TIMESTAMP BETWEEN C.FECHA_INICIO AND C.FECHA_FIN AND
      A.FECHA_ENTREGA < CURRENT_TIMESTAMP AND
      B.FINAL = 0*/
	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){					
				$tpl->assign_block_vars('datosxa',array(
						'IDE'			=> $row['ID_ENTREGA'],
						'IDD'	        => $row['ID_DESPACHO'],
						'ENT'	        => $row['ITEM_NUMBER'],
						'CTE'			=> utf8_encode($row['CTE']),
						'UND'	        => utf8_encode($row['UND']),
						'OBS'	        => utf8_encode($row['COMENTARIOS']),
						'DTE'	        => $row['FECHA_ENTREGA'],
						'EST'	        => utf8_encode($row['EST'])						
					));
					}
				$tpl->pparse('mTabla_xa');
			}else{
			 echo 0;	
			}		
	}	
	}
$db->sqlClose();
?>