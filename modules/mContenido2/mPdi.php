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



 $tpl->set_filenames(array('mPdi' => 'tPdi'));
 $idc   = $userAdmin->user_info['COD_CLIENT'];
 
 ////////////////////////////////////////////////////////////////////////////
 $sql_g="SELECT S.COD_OBJECT_MAP, S.DESCRIPTION, S.LONGITUDE, S.LATITUDE,S.RADIO FROM SAVL_G_PRIN S WHERE S.TYPE_OBJECT_MAP='P' AND S.COD_CLIENT=".$idc." AND S.DESCRIPTION LIKE '%".$_GET['txtfil']."%'";
	$query_g = $db->sqlQuery($sql_g);
	$count_g = $db->sqlEnumRows($query_g);		
	
	if($count_g>0){
		
		while($row_g=$db->sqlFetchArray($query_g)){
			 $tpl->assign_block_vars('dt2',array(
				'IDC'	=> $row_g['COD_OBJECT_MAP'],
				'CTE'	=> utf8_encode($row_g['DESCRIPTION']),
				'LAT'	=> $row_g['LATITUDE'],
				'LON'	=> $row_g['LONGITUDE'],
				'RDO'	=> $row_g['RADIO']
										));	
		}
			$tpl->pparse('mPdi');
	}
	else{
	echo 0;
	}

?>