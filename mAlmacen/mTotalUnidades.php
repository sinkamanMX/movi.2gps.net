<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
		
	$db ->sqlQuery("SET NAMES 'utf8'");
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	//
	
	
	$sql = "SELECT * FROM ADM_UNIDADES WHERE  COD_CLIENT = ".$cte;
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
//	echo $cnt;
	$tpl->set_filenames(array('mTotalUnidades'=>'tTotalUnidades'));	
	
	  while($rowZ = $db->sqlFetchArray($qry)){
		      	$tpl->assign_block_vars('group',array(
							'COD_ENTITY'   => $rowZ['COD_ENTITY'],
							'DESCRIPTION'  => $rowZ['DESCRIPTION']
					));
	          }

	
	$tpl->pparse('mTotalUnidades');
	
		
?>	