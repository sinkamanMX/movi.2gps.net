<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';
		
	$tpl->set_filenames(array('default'=>'default'));	
	$idc   = $userAdmin->user_info['ID_USUARIO'];
       

        
    $tpl->set_filenames(array(
	   'mTabla' => 'tTabla'
    ));

	$T='';
	if(isset($_GET['txtfil']) && $_GET['txtfil'] != "" ){
/*$sql = "SELECT UN.COD_ENTITY,UN.DESCRIPTION, (SELECT MAX(FECHA_ASIGNACION)  FROM DSP_UNIDAD_ASIGNADA WHERE COD_ENTITY= UN.COD_ENTITY) AS ULTIMO_VIAJE FROM SAVL1120 UN 
                     LEFT JOIN DSP_UNIDAD_ASIGNADA UA ON UA.COD_ENTITY=UN.COD_ENTITY  AND UA.LIBRE=1 WHERE UN.COD_CLIENT=".$idc." AND (UN.DESCRIPTION LIKE '%".$_GET['txtfil']."%' OR (SELECT MAX(FECHA_ASIGNACION)  FROM DSP_UNIDAD_ASIGNADA WHERE COD_ENTITY= UN.COD_ENTITY) LIKE '%".$_GET['txtfil']."%')";	*/
					 
$sql = "
SELECT UN.COD_ENTITY,UN.DESCRIPTION,
      (SELECT MAX(FECHA_ASIGNACION)
       FROM DSP_UNIDAD_ASIGNADA WHERE COD_ENTITY= UN.COD_ENTITY) AS
ULTIMO_VIAJE 
FROM ADM_UNIDADES UN 
     LEFT JOIN DSP_UNIDAD_ASIGNADA UA ON  UA.COD_ENTITY=UN.COD_ENTITY AND
UA.LIBRE=1 
     INNER JOIN ADM_USUARIOS_GRUPOS D ON D.COD_ENTITY = UN.COD_ENTITY
     INNER JOIN ADM_GRUPOS G ON G.ID_GRUPO = D.ID_GRUPO
WHERE D.ID_USUARIO=".$idc." AND (UN.DESCRIPTION LIKE '%".$_GET['txtfil']."%' OR (SELECT MAX(FECHA_ASIGNACION)  FROM DSP_UNIDAD_ASIGNADA WHERE COD_ENTITY= UN.COD_ENTITY) LIKE '%".$_GET['txtfil']."%')";						 	
		

	
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
		
/*		     $sql = "SELECT UN.COD_ENTITY,UN.DESCRIPTION, (SELECT MAX(FECHA_ASIGNACION)  FROM DSP_UNIDAD_ASIGNADA WHERE COD_ENTITY= UN.COD_ENTITY) AS ULTIMO_VIAJE FROM SAVL1120 UN 
                     LEFT JOIN DSP_UNIDAD_ASIGNADA UA ON UA.COD_ENTITY=UN.COD_ENTITY  AND UA.LIBRE=1 WHERE   UN.COD_CLIENT=".$idc;*/
$sql="
SELECT UN.COD_ENTITY,UN.DESCRIPTION,
      (SELECT MAX(FECHA_ASIGNACION)
       FROM DSP_UNIDAD_ASIGNADA WHERE COD_ENTITY= UN.COD_ENTITY) AS
ULTIMO_VIAJE 
FROM ADM_UNIDADES UN 
     LEFT JOIN DSP_UNIDAD_ASIGNADA UA ON  UA.COD_ENTITY=UN.COD_ENTITY AND
UA.LIBRE=1 
     INNER JOIN ADM_USUARIOS_GRUPOS D ON D.COD_ENTITY = UN.COD_ENTITY
     INNER JOIN ADM_GRUPOS G ON G.ID_GRUPO = D.ID_GRUPO
WHERE D.ID_USUARIO=".$idc;	
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
	}
$db->sqlClose();
?>