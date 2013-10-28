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
	   'mTabla_xb' => 'tTabla_xb'
    ));

	$T='';

//////////////////////////////////////////////////POR IDD///////////////////////////////////////////////////////////////////////	

if(isset($_GET['idd']) && $_GET['idd'] != "" ){
	if(isset($_GET['txtfil']) && $_GET['txtfil'] != "" ){
$sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPTION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_ARRIBO, ES.DESCRIPCION AS EST FROM DSP_ITINERARIO D
INNER JOIN SAVL_G_PRIN GP ON GP.COD_OBJECT_MAP=D.COD_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1120    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
WHERE (D.ID_ESTATUS=3 OR D.ID_ESTATUS=5) AND (D.ITEM_NUMBER LIKE '%".$_GET['txtfil']."%' OR GP.DESCRIPTION  LIKE '%".$_GET['txtfil']."%' OR UN.DESCRIPTION LIKE '%".$_GET['txtfil']."%' OR D.COMENTARIOS LIKE '%".$_GET['txtfil']."%' OR D.FECHA_ARRIBO LIKE '%".$_GET['txtfil']."%') AND UN.COD_CLIENT=".$idc." AND D.ID_DESPACHO=".$_GET['idd'];		
		

	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){
					$tpl->assign_block_vars('datosxb',array(
						'IDE'			=> $row['ID_ENTREGA'],
						'IDD'	        => $row['ID_DESPACHO'],
						'ENT'	        => $row['ITEM_NUMBER'],
						'CTE'			=> utf8_encode($row['CTE']),
						'UND'	        => utf8_encode($row['UND']),
						'OBS'	        => utf8_encode($row['COMENTARIOS']),
						'DTA'	        => $row['FECHA_ARRIBO'],
						'EST'	        => utf8_encode($row['EST'])
					)); 
				}
				$tpl->pparse('mTabla_xb');
			}else{
			 echo 0;	
			}
		
	}else{
		
$sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPTION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_ARRIBO, ES.DESCRIPCION AS EST FROM DSP_ITINERARIO D
INNER JOIN SAVL_G_PRIN GP ON GP.COD_OBJECT_MAP=D.COD_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1120    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
WHERE (D.ID_ESTATUS=3 OR D.ID_ESTATUS=5)  AND UN.COD_CLIENT=".$idc." AND D.ID_DESPACHO=".$_GET['idd'];
	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){					
				$tpl->assign_block_vars('datosxb',array(
						'IDE'			=> $row['ID_ENTREGA'],
						'IDD'	        => $row['ID_DESPACHO'],
						'ENT'	        => $row['ITEM_NUMBER'],
						'CTE'			=> utf8_encode($row['CTE']),
						'UND'	        => utf8_encode($row['UND']),
						'OBS'	        => utf8_encode($row['COMENTARIOS']),
						'DTA'	        => $row['FECHA_ARRIBO'],
						'EST'	        => utf8_encode($row['EST'])						
					));
					}
				$tpl->pparse('mTabla_xb');
			}else{
			 echo 0;	
			}		
	}	
}
else{
	if(isset($_GET['txtfil']) && $_GET['txtfil'] != "" ){
$sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPTION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_ARRIBO, ES.DESCRIPCION AS EST FROM DSP_ITINERARIO D
INNER JOIN SAVL_G_PRIN GP ON GP.COD_OBJECT_MAP=D.COD_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1120    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
WHERE (D.ID_ESTATUS=3 OR D.ID_ESTATUS=5) AND (D.ITEM_NUMBER LIKE '%".$_GET['txtfil']."%' OR GP.DESCRIPTION  LIKE '%".$_GET['txtfil']."%' OR UN.DESCRIPTION LIKE '%".$_GET['txtfil']."%' OR D.COMENTARIOS LIKE '%".$_GET['txtfil']."%' OR D.FECHA_ARRIBO LIKE '%".$_GET['txtfil']."%') AND UN.COD_CLIENT=".$idc;		
		

	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){
					$tpl->assign_block_vars('datosxb',array(
						'IDE'			=> $row['ID_ENTREGA'],
						'IDD'	        => $row['ID_DESPACHO'],
						'ENT'	        => $row['ITEM_NUMBER'],
						'CTE'			=> utf8_encode($row['CTE']),
						'UND'	        => utf8_encode($row['UND']),
						'OBS'	        => utf8_encode($row['COMENTARIOS']),
						'DTA'	        => $row['FECHA_ARRIBO'],
						'EST'	        => utf8_encode($row['EST'])
					)); 
				}
				$tpl->pparse('mTabla_xb');
			}else{
			 echo 0;	
			}
		
	}else{
		
$sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPTION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_ARRIBO, ES.DESCRIPCION AS EST FROM DSP_ITINERARIO D
INNER JOIN SAVL_G_PRIN GP ON GP.COD_OBJECT_MAP=D.COD_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1120    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
WHERE (D.ID_ESTATUS=3 OR D.ID_ESTATUS=5)  AND UN.COD_CLIENT=".$idc;
	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){					
				$tpl->assign_block_vars('datosxb',array(
						'IDE'			=> $row['ID_ENTREGA'],
						'IDD'	        => $row['ID_DESPACHO'],
						'ENT'	        => $row['ITEM_NUMBER'],
						'CTE'			=> utf8_encode($row['CTE']),
						'UND'	        => utf8_encode($row['UND']),
						'OBS'	        => utf8_encode($row['COMENTARIOS']),
						'DTA'	        => $row['FECHA_ARRIBO'],
						'EST'	        => utf8_encode($row['EST'])						
					));
					}
				$tpl->pparse('mTabla_xb');
			}else{
			 echo 0;	
			}		
	}	
	}	
$db->sqlClose();
?>