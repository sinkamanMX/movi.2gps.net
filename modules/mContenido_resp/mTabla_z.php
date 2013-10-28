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
	   'mTabla_z' => 'tTabla_z'
    ));

	$T='';
	if(isset($_GET['txtfil']) && $_GET['txtfil'] != "" ){
$sql = "SELECT D.ID_DESPACHO,D.DESCRIPCION AS VJE, UN.DESCRIPTION AS UND, D.ITEM_NUMBER, D.FECHA_INICIO, D.FECHA_FIN, D.TOLERANCIA FROM DSP_DESPACHO D
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN ADM_UNIDADES UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN ADM_USUARIOS_GRUPOS GD ON GD.COD_ENTITY = UN.COD_ENTITY
     INNER JOIN ADM_GRUPOS G ON G.ID_GRUPO = GD.ID_GRUPO
WHERE GD.ID_USUARIO=".$idc." AND(D.DESCRIPCION LIKE '%".$_GET['txtfil']."%' OR UN.DESCRIPTION  LIKE '%".$_GET['txtfil']."%' OR D.ITEM_NUMBER LIKE '%".$_GET['txtfil']."%' OR D.FECHA_INICIO LIKE '%".$_GET['txtfil']."%' OR D.FECHA_FIN LIKE '%".$_GET['txtfil']."%'  OR D.TOLERANCIA LIKE '%".$_GET['txtfil']."%') AND D.FECHA_FIN >= NOW() AND ID_ESTATUS=2 ORDER BY D.FECHA_INICIO DESC";		
	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){
					$tpl->assign_block_vars('datosz',array(
						'IDD'	        => $row['ID_DESPACHO'],
						'DSP'	        => utf8_encode($row['VJE']),
						'UND'			=> utf8_encode($row['UND']),
						'IDV'	        => utf8_encode($row['ITEM_NUMBER']),
						'DTI'	        => $row['FECHA_INICIO'],
						'DTF'	        => $row['FECHA_FIN'],
						'TLR'	        => $row['TOLERANCIA']
					)); 
				}
				$tpl->pparse('mTabla_z');
			}else{
			 echo 0;	
			}
		
	}else{
		
 $sql = "SELECT D.ID_DESPACHO,D.DESCRIPCION AS VJE, UN.DESCRIPTION AS UND, D.ITEM_NUMBER, D.FECHA_INICIO, D.FECHA_FIN, D.TOLERANCIA FROM DSP_DESPACHO D
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN ADM_UNIDADES UN ON UN.COD_ENTITY=UA.COD_ENTITY
     INNER JOIN ADM_USUARIOS_GRUPOS GD ON GD.COD_ENTITY = UN.COD_ENTITY
     INNER JOIN ADM_GRUPOS G ON G.ID_GRUPO = GD.ID_GRUPO
WHERE GD.ID_USUARIO=".$idc." AND D.FECHA_FIN >= NOW() AND ID_ESTATUS=2 ORDER BY D.FECHA_INICIO DESC";
	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){					
				$tpl->assign_block_vars('datosz',array(
						'IDD'	        => $row['ID_DESPACHO'],
						'DSP'	        => utf8_encode($row['VJE']),
						'UND'			=> utf8_encode($row['UND']),
						'IDV'	        => utf8_encode($row['ITEM_NUMBER']),
						'DTI'	        => $row['FECHA_INICIO'],
						'DTF'	        => $row['FECHA_FIN'],
						'TLR'	        => $row['TOLERANCIA']				
					));
					}
				$tpl->pparse('mTabla_z');
			}else{
			 echo 0;	
			}		
	}
$db->sqlClose();
?>