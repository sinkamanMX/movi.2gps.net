<?php
/** * 
 *  @package             
 *  @name                Obtiene las Geo-Cercas registrados
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          03-06-2011
**/
header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

if(!$userAdmin->u_logged()){
		echo '<script>window.location="index.php?m=login"</script>';
}



 $tpl->set_filenames(array('mQuery7' => 'tQuery7'));
 
	 
	
////////////////////////////////////////////////////////////////////////////
$sql_g="SELECT D.ID_ESTATUS, 
IF(D.FECHA_SALIDA = '0000-00-00 00:00:00',CURDATE(),CAST(D.FECHA_SALIDA AS DATE))AS DTS, 
IF(D.FECHA_SALIDA = '0000-00-00 00:00:00',CURTIME(),CAST(D.FECHA_SALIDA AS TIME)) AS HDTS 
FROM DSP_ITINERARIO D WHERE D.ID_ENTREGA =".$_GET['ide'];
	$query_g = $db->sqlQuery($sql_g);
	$count_g = $db->sqlEnumRows($query_g);		
	
	if($count_g>0){		
		
		$row_g=$db->sqlFetchArray($query_g);
		
////////////////////////////////////////////////////////////////////////////
/*$t = explode(":", $row_g['HDTA']);
	for($i=0;$i<24;$i++){		
			$hour = ($i < 10) ? '0'.$i : $i; 
			$chk  = ($i == $t[0]) ? 'selected="selected"':'';
			$tpl->assign_block_vars('hrs',array(				
				'NO'   => '<option '.$chk.' value="'.$hour.'">'.$hour.'</option>'			
 			));			
		}
		
		for($i=0;$i<60;$i++){	
			$hour = ($i < 10) ? '0'.$i : $i; 
			$chk  = ($i == $t[1]) ? 'selected="selected"':'';
			$tpl->assign_block_vars('min',array(
				'NO'   => '<option '.$chk.' value="'.$hour.'">'.$hour.'</option>'	
 			));			
		}*/
		
$t2 = explode(":", $row_g['HDTS']);
	for($i=0;$i<24;$i++){		
			$hour = ($i < 10) ? '0'.$i : $i; 
			$chk  = ($i == $t2[0]) ? 'selected="selected"':'';
			$tpl->assign_block_vars('hrs2',array(				
				'NO'   => '<option '.$chk.' value="'.$hour.'">'.$hour.'</option>'			
 			));			
		}
		
		for($i=0;$i<60;$i++){	
			$hour = ($i < 10) ? '0'.$i : $i; 
			$chk  = ($i == $t2[1]) ? 'selected="selected"':'';
			$tpl->assign_block_vars('min2',array(
				'NO'   => '<option '.$chk.' value="'.$hour.'">'.$hour.'</option>'	
 			));			
		}		
////////////////////////////////////////////////////////////////////////////		
		
		//$v1=($row_g['ID_ESTATUS']==9)?"display:none":"";
		//$v2=($row_g['ID_ESTATUS']==8)?"display:none":"";
			 $tpl->assign_vars(array(
				//'DTE'	=> $row_g['FECHA_ENTREGA'],
				//'DTA'	=> $row_g['DTA'],
				'EST'	=> $row_g['ID_ESTATUS'],
				'IDE'	=> $_GET['ide'],
				//'V_1'	=> $v1,
				//'V_2'	=> $v2,
				'DTS'	=> $row_g['DTS'],
				
				
				//'DTF'	=> $row_g['FECHA_FIN']
										));	
		
		$tpl->pparse('mQuery7');
	}
	else{
	echo 0;}
			   

?>
