<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';
	

	$idc   = $userAdmin->user_info['ID_CLIENTE'];
       

        
    $tpl->set_filenames(array(
	   'mTabla_xc' => 'tTabla_xc'
    ));

	$T='';

//////////////////////////////////////////////////POR IDD///////////////////////////////////////////////////////////////////////	

if(isset($_GET['idd']) && $_GET['idd'] != "" ){
	if(isset($_GET['txtfil']) && $_GET['txtfil'] != "" ){
$sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPCION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_ENTREGA, ES.DESCRIPCION AS EST ,IF(D.ID_ESTATUS in (1,2,8),2,IF(D.ID_ESTATUS IN (9),3,IF(D.ID_ESTATUS = 4,1,0))) AS BOTON FROM DSP_ITINERARIO D
INNER JOIN ADM_GEOREFERENCIAS GP ON D.COD_GEO = GP.ID_TIPO_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN ADM_UNIDADES    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN DSP_DESPACHO DE ON DE.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN ADM_USUARIOS_GRUPOS GD ON GD.COD_ENTITY = UN.COD_ENTITY
INNER JOIN ADM_GRUPOS G ON G.ID_GRUPO = GD.ID_GRUPO
WHERE GD.ID_USUARIO=".$idc." AND 
    (D.ID_ESTATUS=2 OR D.ID_ESTATUS=1 OR D.ID_ESTATUS=4) AND
    (D.ITEM_NUMBER LIKE '%".$_GET['txtfil']."%' OR GP.DESCRIPCION  LIKE '%".$_GET['txtfil']."%' OR UN.DESCRIPTION LIKE '%".$_GET['txtfil']."%' OR D.COMENTARIOS LIKE '%".$_GET['txtfil']."%' OR D.FECHA_ENTREGA LIKE '%".$_GET['txtfil']."%') AND 
	NOW() < DATE_ADD(D.FECHA_ENTREGA, INTERVAL DE.TOLERANCIA MINUTE)  AND 
	D.ID_DESPACHO=".$_GET['idd']." AND CURRENT_TIMESTAMP BETWEEN DE.FECHA_INICIO AND DE.FECHA_FIN AND
    D.FECHA_ENTREGA >= CURRENT_TIMESTAMP AND
    ES.FINAL = 0 ORDER BY D.FECHA_ENTREGA ASC";		

//WHERE CURRENT_TIMESTAMP BETWEEN DE.FECHA_INICIO AND DE.FECHA_FIN AND
      //D.FECHA_ENTREGA >= CURRENT_TIMESTAMP AND
      //ES.FINAL = 0 AND G.COD_CLIENT=".$idc." ORDER BY D.FECHA_ENTREGA ASC";	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){
					$tpl->assign_block_vars('datosxc',array(
						'IDE'			=> $row['ID_ENTREGA'],
						'IDD'	        => $row['ID_DESPACHO'],
						'ENT'	        => $row['ITEM_NUMBER'],
						'CTE'			=> utf8_encode($row['CTE']),
						'UND'	        => utf8_encode($row['UND']),
						'OBS'	        => utf8_encode($row['COMENTARIOS']),
						'DTE'	        => $row['FECHA_ENTREGA'],
						'EST'	        => utf8_encode($row['EST']),
						'BTN'			=> $row['BOTON']
					)); 
				}
				$tpl->pparse('mTabla_xc');
			}else{
			 echo 0;	
			}
		
	}else{
		
$sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPCION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_ENTREGA, ES.DESCRIPCION AS EST  
,IF(D.ID_ESTATUS in (1,2,8),2,IF(D.ID_ESTATUS IN (9),3,IF(D.ID_ESTATUS = 4,1,0))) AS BOTON
FROM DSP_ITINERARIO D
INNER JOIN ADM_GEOREFERENCIAS GP ON D.COD_GEO = GP.ID_TIPO_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN ADM_UNIDADES    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN DSP_DESPACHO DE ON DE.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN ADM_USUARIOS_GRUPOS GD ON GD.COD_ENTITY = UN.COD_ENTITY
INNER JOIN ADM_GRUPOS G ON G.ID_GRUPO = GD.ID_GRUPO
WHERE  GD.ID_USUARIO=".$idc." AND CURRENT_TIMESTAMP BETWEEN DE.FECHA_INICIO AND DE.FECHA_FIN AND
      D.FECHA_ENTREGA >= CURRENT_TIMESTAMP AND
      ES.FINAL = 0
AND (D.ID_ESTATUS=2 OR D.ID_ESTATUS=1 OR D.ID_ESTATUS=4) AND NOW() < DATE_ADD(D.FECHA_ENTREGA, INTERVAL DE.TOLERANCIA MINUTE)  AND D.ID_DESPACHO=".$_GET['idd']." ORDER BY D.FECHA_ENTREGA ASC";

//WHERE CURRENT_TIMESTAMP BETWEEN DE.FECHA_INICIO AND DE.FECHA_FIN AND
     // D.FECHA_ENTREGA >= CURRENT_TIMESTAMP AND
      //ES.FINAL = 0 AND G.COD_CLIENT=".$idc." ORDER BY D.FECHA_ENTREGA ASC	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){					
				$tpl->assign_block_vars('datosxc',array(
						'IDE'			=> $row['ID_ENTREGA'],
						'IDD'	        => $row['ID_DESPACHO'],
						'ENT'	        => $row['ITEM_NUMBER'],
						'CTE'			=> utf8_encode($row['CTE']),
						'UND'	        => utf8_encode($row['UND']),
						'OBS'	        => utf8_encode($row['COMENTARIOS']),
						'DTE'	        => $row['FECHA_ENTREGA'],
						'EST'	        => utf8_encode($row['EST']),
						'BTN'			=> $row['BOTON']					
					));
					}
				$tpl->pparse('mTabla_xc');
			}else{
			 echo 0;	
			}		
	}
}
//////////////////////////////////////////////////////////////////////////////
else{
	if(isset($_GET['txtfil']) && $_GET['txtfil'] != "" ){
/*$sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPCION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_ENTREGA, ES.DESCRIPCION AS EST FROM DSP_ITINERARIO D
INNER JOIN SAVL_G_PRIN GP ON GP.COD_OBJECT_MAP=D.COD_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1120    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN DSP_DESPACHO DE ON DE.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1220_GDET DG ON DG.COD_ENTITY = UN.COD_ENTITY
INNER JOIN SAVL1220_G G ON G.ID_GROUP = DG.ID_GROUP 
WHERE (D.ID_ESTATUS=2 OR D.ID_ESTATUS=1 OR D.ID_ESTATUS=4) AND(D.ITEM_NUMBER LIKE '%".$_GET['txtfil']."%' OR GP.DESCRIPCION  LIKE '%".$_GET['txtfil']."%' OR UN.DESCRIPTION LIKE '%".$_GET['txtfil']."%' OR D.COMENTARIOS LIKE '%".$_GET['txtfil']."%' OR D.FECHA_ENTREGA LIKE '%".$_GET['txtfil']."%') AND NOW() < DATE_ADD(D.FECHA_ENTREGA, INTERVAL DE.TOLERANCIA MINUTE) AND G.COD_CLIENT=".$idc." ORDER BY D.FECHA_ENTREGA ASC";*/		
$sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPCION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_ENTREGA, ES.DESCRIPCION AS EST 
,IF(D.ID_ESTATUS in (1,2,8),2,IF(D.ID_ESTATUS IN (9),3,IF(D.ID_ESTATUS = 4,1,0))) AS BOTON
FROM DSP_ITINERARIO D
INNER JOIN ADM_GEOREFERENCIAS GP ON D.COD_GEO = GP.ID_TIPO_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN ADM_UNIDADES    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN DSP_DESPACHO DE ON DE.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN ADM_USUARIOS_GRUPOS DG ON DG.COD_ENTITY = UN.COD_ENTITY
INNER JOIN ADM_GRUPOS G ON G.ID_GRUPO = DG.ID_GRUPO
WHERE CURRENT_TIMESTAMP BETWEEN DE.FECHA_INICIO AND DE.FECHA_FIN AND
      D.FECHA_ENTREGA >= CURRENT_TIMESTAMP AND
      ES.FINAL = 0 AND(D.ITEM_NUMBER LIKE '%".$_GET['txtfil']."%' OR GP.DESCRIPCION  LIKE '%".$_GET['txtfil']."%' OR UN.DESCRIPTION LIKE '%".$_GET['txtfil']."%' OR D.COMENTARIOS LIKE '%".$_GET['txtfil']."%' OR D.FECHA_ENTREGA LIKE '%".$_GET['txtfil']."%') AND NOW() < DATE_ADD(D.FECHA_ENTREGA, INTERVAL DE.TOLERANCIA MINUTE) AND  DG.ID_USUARIO==".$idc." ORDER BY D.FECHA_ENTREGA ASC";		

	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){
					$tpl->assign_block_vars('datosxc',array(
						'IDE'			=> $row['ID_ENTREGA'],
						'IDD'	        => $row['ID_DESPACHO'],
						'ENT'	        => $row['ITEM_NUMBER'],
						'CTE'			=> utf8_encode($row['CTE']),
						'UND'	        => utf8_encode($row['UND']),
						'OBS'	        => utf8_encode($row['COMENTARIOS']),
						'DTE'	        => $row['FECHA_ENTREGA'],
						'EST'	        => utf8_encode($row['EST']),
						'BTN'			=> $row['BOTON']
					)); 
				}
				$tpl->pparse('mTabla_xc');
			}else{
			 echo 0;	
			}
		
	}else{
		
/*$sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPCION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_ENTREGA, ES.DESCRIPCION AS EST FROM DSP_ITINERARIO D
INNER JOIN SAVL_G_PRIN GP ON GP.COD_OBJECT_MAP=D.COD_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1120    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN DSP_DESPACHO DE ON DE.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1220_GDET DG ON DG.COD_ENTITY = UN.COD_ENTITY
INNER JOIN SAVL1220_G G ON G.ID_GROUP = DG.ID_GROUP 
WHERE (D.ID_ESTATUS=2 OR D.ID_ESTATUS=1 OR D.ID_ESTATUS=4) AND NOW() < DATE_ADD(D.FECHA_ENTREGA, INTERVAL DE.TOLERANCIA MINUTE) AND G.COD_CLIENT=".$idc." ORDER BY D.FECHA_ENTREGA ASC";*/

$sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPCION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_ENTREGA, ES.DESCRIPCION AS EST 
,IF(D.ID_ESTATUS in (1,2,8),2,IF(D.ID_ESTATUS IN (9),3,IF(D.ID_ESTATUS = 4,1,0))) AS BOTON
FROM DSP_ITINERARIO D
INNER JOIN ADM_GEOREFERENCIAS GP ON D.COD_GEO = GP.ID_TIPO_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN ADM_UNIDADES    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN DSP_DESPACHO DE ON DE.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN ADM_USUARIOS_GRUPOS DG ON DG.COD_ENTITY = UN.COD_ENTITY
INNER JOIN ADM_GRUPOS G ON G.ID_GRUPO = DG.ID_GRUPO 
WHERE CURRENT_TIMESTAMP BETWEEN DE.FECHA_INICIO AND DE.FECHA_FIN AND
      D.FECHA_ENTREGA >= CURRENT_TIMESTAMP AND
      ES.FINAL = 0 AND DG.ID_USUARIO=".$idc." ORDER BY D.FECHA_ENTREGA ASC";
	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){					
				$tpl->assign_block_vars('datosxc',array(
						'IDE'			=> $row['ID_ENTREGA'],
						'IDD'	        => $row['ID_DESPACHO'],
						'ENT'	        => $row['ITEM_NUMBER'],
						'CTE'			=> utf8_encode($row['CTE']),
						'UND'	        => utf8_encode($row['UND']),
						'OBS'	        => utf8_encode($row['COMENTARIOS']),
						'DTE'	        => $row['FECHA_ENTREGA'],
						'EST'	        => utf8_encode($row['EST']),
						'BTN'			=> $row['BOTON']					
					));
					}
				$tpl->pparse('mTabla_xc');
			}else{
			 echo 0;	
			}		
	}	
	}
	
$db->sqlClose();
?>