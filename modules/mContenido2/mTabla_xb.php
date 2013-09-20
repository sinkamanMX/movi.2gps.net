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
	   'mTabla_xb' => 'tTabla_xb'
    ));

	$T='';

//////////////////////////////////////////////////POR IDD///////////////////////////////////////////////////////////////////////	

if(isset($_GET['idd']) && $_GET['idd'] != "" ){
	if(isset($_GET['txtfil']) && $_GET['txtfil'] != "" ){
 $sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPCION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_SALIDA, ES.DESCRIPCION AS EST FROM DSP_ITINERARIO D
INNER JOIN ADM_GEOREFERENCIAS GP ON D.COD_GEO = GP.ID_TIPO_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN ADM_UNIDADES    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN ADM_USUARIOS_GRUPOS DG ON DG.COD_ENTITY = UN.COD_ENTITY
INNER JOIN ADM_GRUPOS G ON G.ID_GRUPO = DG.ID_GRUPO
INNER JOIN DSP_DESPACHO C ON C.ID_DESPACHO = D.ID_DESPACHO
WHERE (D.ID_ESTATUS=3 OR D.ID_ESTATUS=5) AND (D.ITEM_NUMBER LIKE '%".$_GET['txtfil']."%' OR  GP.DESCRIPCION  LIKE '%".$_GET['txtfil']."%' OR UN.DESCRIPTION LIKE '%".$_GET['txtfil']."%' OR D.COMENTARIOS LIKE '%".$_GET['txtfil']."%' OR D.FECHA_ARRIBO LIKE '%".$_GET['txtfil']."%') AND CURRENT_TIMESTAMP BETWEEN C.FECHA_INICIO AND C.FECHA_FIN AND
      ES.FINAL = 1 AND  DG.ID_USUARIO=".$idc." AND D.ID_DESPACHO=".$_GET['idd'];		
		

	
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
						'DTA'	        => $row['FECHA_SALIDA'],
						'EST'	        => utf8_encode($row['EST'])
					)); 
				}
				$tpl->pparse('mTabla_xb');
			}else{
			 echo 0;	
			}
		
	}else{
		

$sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPCION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_SALIDA, ES.DESCRIPCION AS EST FROM DSP_ITINERARIO D
INNER JOIN ADM_GEOREFERENCIAS GP ON D.COD_GEO = GP.ID_TIPO_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN ADM_UNIDADES    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN ADM_USUARIOS_GRUPOS DG ON DG.COD_ENTITY = UN.COD_ENTITY
INNER JOIN ADM_GRUPOS G ON G.ID_GRUPO = DG.ID_GRUPO
INNER JOIN DSP_DESPACHO C ON C.ID_DESPACHO = D.ID_DESPACHO
WHERE (D.ID_ESTATUS=3 OR D.ID_ESTATUS=5) AND 
CURRENT_DATE BETWEEN CAST(C.FECHA_INICIO AS DATE) AND CAST(C.FECHA_FIN AS DATE) AND
      ES.FINAL = 1  AND  DG.ID_USUARIO=".$idc." AND D.ID_DESPACHO=".$_GET['idd'];
	
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
						'DTA'	        => $row['FECHA_SALIDA'],
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
		
$sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPCION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_SALIDA, ES.DESCRIPCION AS EST FROM DSP_ITINERARIO D
INNER JOIN ADM_GEOREFERENCIAS GP ON D.COD_GEO = GP.ID_TIPO_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN ADM_UNIDADES    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN ADM_USUARIOS_GRUPOS DG ON DG.COD_ENTITY = UN.COD_ENTITY
INNER JOIN ADM_GRUPOS G ON G.ID_GRUPO = DG.ID_GRUPO
INNER JOIN DSP_DESPACHO C ON C.ID_DESPACHO = D.ID_DESPACHO
WHERE (D.ID_ESTATUS=3 OR D.ID_ESTATUS=5) AND 
CURRENT_DATE BETWEEN CAST(C.FECHA_INICIO AS DATE) AND CAST(C.FECHA_FIN AS DATE) AND
      ES.FINAL = 1 AND (D.ITEM_NUMBER LIKE '%".$_GET['txtfil']."%' OR GP.DESCRIPCION  LIKE '%".$_GET['txtfil']."%' OR UN.DESCRIPTION LIKE '%".$_GET['txtfil']."%' OR D.COMENTARIOS LIKE '%".$_GET['txtfil']."%' OR D.FECHA_ARRIBO LIKE '%".$_GET['txtfil']."%') AND  DG.ID_USUARIO=".$idc;		

	
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
						'DTA'	        => $row['FECHA_SALIDA'],
						'EST'	        => utf8_encode($row['EST'])
					)); 
				}
				$tpl->pparse('mTabla_xb');
			}else{
			 echo 0;	
			}
		
	}else{
		

	  
$sql = "SELECT D.ID_ENTREGA, D.ID_DESPACHO, D.ITEM_NUMBER, GP.DESCRIPCION AS CTE, UN.DESCRIPTION AS UND, D.COMENTARIOS, D.FECHA_SALIDA, ES.DESCRIPCION AS EST FROM DSP_ITINERARIO D
INNER JOIN ADM_GEOREFERENCIAS GP ON D.COD_GEO = GP.ID_TIPO_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN ADM_UNIDADES    UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN DSP_ESTATUS ES ON ES.ID_ESTATUS=D.ID_ESTATUS
INNER JOIN ADM_USUARIOS_GRUPOS DG ON DG.COD_ENTITY = UN.COD_ENTITY
INNER JOIN ADM_GRUPOS G ON G.ID_GRUPO = DG.ID_GRUPO
INNER JOIN DSP_DESPACHO C ON C.ID_DESPACHO = D.ID_DESPACHO
WHERE (D.ID_ESTATUS IN (3,5,6)) AND 
CURRENT_DATE BETWEEN CAST(C.FECHA_INICIO AS DATE) AND CAST(C.FECHA_FIN AS DATE) AND
      ES.FINAL = 1 AND  DG.ID_USUARIO=".$idc;
	  
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
						'DTA'	        => $row['FECHA_SALIDA'],
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