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
	   'mDatac' => 'tDatac'
    )); 

$sql_a = "SELECT CAST(D.FECHA_INICIO AS DATE) AS FDI FROM DSP_DESPACHO D WHERE D.ID_DESPACHO=".$_GET['idd'];
$qry_a = $db->sqlQuery($sql_a);
$row_a = $db->sqlFetchArray($qry_a);


$sql_b = "SELECT C.ID_CUESTIONARIO, C.DESCRIPCION AS CUE FROM CRM2_CUESTIONARIOS C WHERE C.COD_CLIENT=".$idc;
$qry_b = $db->sqlQuery($sql_b);
while($row_b = $db->sqlFetchArray($qry_b)){
	$cst.='<option '.$chk.' value="'.$row_b['ID_CUESTIONARIO'].'">'.$row_b['CUE'].'</option>';
		}
		
//	
$sql_c = "SELECT S.TYPE FROM SAVL_CLIENTS S WHERE S.COD_CLIENT=".$idc;
$qry_c = $db->sqlQuery($sql_c);
$row_c = $db->sqlFetchArray($qry_c);
$stl=($row_c['TYPE']=='AVL')?"display:none":"";

$tpl->assign_vars(array(
'IDD'			=> $row_a['FDI'],
'CST'			=> $cst,
'STL'			=> $stl
));	
		
/*$sql = "SELECT D.COD_OBEJECT_MAP, Z.DESCRIPCION AS ZONA, GP.DESCRIPTION AS PUNTO FROM DSP_CIRCUITO_PDI D
INNER JOIN DSP_ZONA_PDI ZP ON ZP.COD_OBJECT_MAP=D.COD_OBEJECT_MAP
INNER JOIN DSP_ZONA Z ON Z.ID_ZONA=ZP.ID_ZONA
INNER JOIN SAVL_G_PRIN GP ON GP.COD_OBJECT_MAP=D.COD_OBEJECT_MAP
WHERE D.ID_CIRCUITO=".$_GET['cto']."
GROUP BY D.COD_OBEJECT_MAP ORDER BY GP.DESCRIPTION;";*/
$cmp=($_GET['punto']=="")?"":" AND D.COD_OBEJECT_MAP NOT IN (".$_GET['punto'].") ";
$sql = "SELECT D.COD_OBEJECT_MAP, Z.DESCRIPCION AS ZONA, GP.DESCRIPTION AS PUNTO FROM DSP_CIRCUITO_PDI D
INNER JOIN DSP_ZONA_PDI ZP ON ZP.COD_OBJECT_MAP=D.COD_OBEJECT_MAP
INNER JOIN DSP_ZONA Z ON Z.ID_ZONA=ZP.ID_ZONA
INNER JOIN SAVL_G_PRIN GP ON GP.COD_OBJECT_MAP=D.COD_OBEJECT_MAP
WHERE D.ID_CIRCUITO=".$_GET['cto'].$cmp."
GROUP BY D.COD_OBEJECT_MAP ORDER BY GP.DESCRIPTION;";
	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				$tpl->assign_vars(array(
						'CNT'	        => $count
					));
				$c=0;
				while($row = $db->sqlFetchArray($query)){	
					$h ='<select id="hr'.$c.'" class="mcaja">';
					$h2='<select id="hrf'.$c.'" class="mcaja">';
					
						for($i=0;$i<24;$i++){		
								$hour = ($i < 10) ? '0'.$i : $i; 				
									$h.='<option '.$chk.' value="'.$hour.'">'.$hour.'</option>';
									$h2.='<option '.$chk.' value="'.$hour.'">'.$hour.'</option>';
							}
					$h.='</select>';
					$h2.='</select>';
					
					$m='<select id="mn'.$c.'" class="mcaja">';
					$m2='<select id="mnf'.$c.'" class="mcaja">';
					for($i=0;$i<60;$i++){	
						$hour = ($i < 10) ? '0'.$i : $i; 
						$m.='<option '.$chk.' value="'.$hour.'">'.$hour.'</option>';
						$m2.='<option '.$chk.' value="'.$hour.'">'.$hour.'</option>';
					}
					$m.='</select>';
					$m2.='</select>';
				$tpl->assign_block_vars('datac',array(
						'COM'	        => $row['COD_OBEJECT_MAP'],
						'ZNA'	        => utf8_encode($row['ZONA']),
						'PTO'			=> utf8_encode($row['PUNTO']),
						'C'				=> $c,
						'H'				=> $h,
						'M'				=> $m,
						'HF'			=> $h2,
						'MF'			=> $m2
					));
					$c++;
					}
					
////////////////////////////////////////////////////////////////////////////

		          

        

////////////////////////////////////////////////////////////////////////////					
					
				$tpl->pparse('mDatac');
			}else{
			 echo 0;	
			}		
$db->sqlClose();
?>