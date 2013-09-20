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
$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';	



 $tpl->set_filenames(array('mQuery3' => 'tQuery3'));
 $idc   = $userAdmin->user_info['ID_CLIENTE'];
	
////////////////////////////////////////////////////////////////////////////
$sql_g="SELECT S.ID_OBJECT_MAP, S.DESCRIPCION, S.LONGITUDE, S.LATITUDE,S.RADIO FROM ADM_GEOREFERENCIAS S WHERE S.TIPO='G' AND S.ID_CLIENTE=".$idc;
	$query_g = $db->sqlQuery($sql_g);
	$count_g = $db->sqlEnumRows($query_g);		
	
	if($count_g>0){
		
		while($row_g=$db->sqlFetchArray($query_g)){
			 $tpl->assign_block_vars('dt2',array(
				'IDC'	=> $row_g['ID_OBJECT_MAP'],
				'CTE'	=> utf8_encode($row_g['DESCRIPCION']),
				'LAT'	=> $row_g['LATITUDE'],
				'LON'	=> $row_g['LONGITUDE'],
				'RDO'	=> $row_g['RADIO']
										));	
		}
		$tpl->pparse('mQuery3');
	}
	else{
	echo 0;}
			   

?>
