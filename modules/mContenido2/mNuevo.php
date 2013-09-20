<?php
header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';	
		
$tpl->set_filenames(array('mNuevo' => 'tNuevo'));

$idc   = $userAdmin->user_info['ID_CLIENTE'];

	for($i=0;$i<24;$i++){		
			$hour = ($i < 10) ? '0'.$i : $i; 
			$chk  = ($i == 0) ? 'selected="selected"':'';
			$tpl->assign_block_vars('hrs',array(				
				'NO'   => '<option '.$chk.' value="'.$hour.'">'.$hour.'</option>'			
 			));			
		}
		
		for($i=0;$i<60;$i++){	
			$hour = ($i < 10) ? '0'.$i : $i; 
			$chk  = ($i == 0) ? 'selected="selected"':'';
			$tpl->assign_block_vars('min',array(
				'NO'   => '<option '.$chk.' value="'.$hour.'">'.$hour.'</option>'	
 			));			
		}

	 /*$sql_f="SELECT UN.COD_ENTITY,UN.DESCRIPTION FROM SAVL1120 UN
LEFT JOIN DSP_UNIDAD_ASIGNADA UA ON UA.COD_ENTITY=UN.COD_ENTITY  AND UA.LIBRE=1 WHERE   UN.COD_CLIENT=".$idc;*/
	$sql_f="
SELECT UN.COD_ENTITY, UN.DESCRIPTION,
      (SELECT MAX(FECHA_ASIGNACION) FROM DSP_UNIDAD_ASIGNADA WHERE COD_ENTITY= UN.COD_ENTITY) AS ULTIMO_VIAJE 
FROM ADM_UNIDADES UN 
     LEFT JOIN DSP_UNIDAD_ASIGNADA UA ON  UA.COD_ENTITY=UN.COD_ENTITY AND UA.LIBRE = 1 
     INNER JOIN ADM_USUARIOS_GRUPOS D ON D.COD_ENTITY = UN.COD_ENTITY
     INNER JOIN ADM_GRUPOS G ON G.ID_GRUPO = D.ID_GRUPO
WHERE D.ID_USUARIO=".$idc;
	$query_f = $db->sqlQuery($sql_f);
	$count_f = $db->sqlEnumRows($query_f);		
	
	if($count_f>0){
		
		
			if(isset($_GET['und'])){
				while($row=$db->sqlFetchArray($query_f)){
				$s=($row['COD_ENTITY']==$_GET['und'])?'selected="selected"':'';
			 $tpl->assign_block_vars('dt3',array(
				'IDU'	=> $row['COD_ENTITY'],
				'UND'	=> utf8_encode($row['DESCRIPTION']),
				'STD'	=> $s
										));	
				}
			}
			else{
				while($row=$db->sqlFetchArray($query_f)){
			 	$tpl->assign_block_vars('dt3',array(
				'IDU'	=> $row['COD_ENTITY'],
				'UND'	=> utf8_encode($row['DESCRIPTION']),
				'STD'	=> ''
										));		
					}
				}
		}
	
////////////////////////////////////////////////////////////////////////////
/*	$sql_g="SELECT ID_EMPRESA, DESCRIPCION FROM ADMI1000 ";
	$query_g = $db->sqlQuery($sql_g);
	$count_g = $db->sqlEnumRows($query_g);		
	
	if($count_g>0){
		
		while($row_g=$db->sqlFetchArray($query_g)){
			 $tpl->assign_block_vars('dt2',array(
				'IDEMP'	=> $row_g['ID_EMPRESA'],
				'EMP'	=> utf8_encode($row_g['DESCRIPCION'])
										));	
		}
	}
*/

$tpl->pparse('mNuevo');
$db->sqlClose();
?>