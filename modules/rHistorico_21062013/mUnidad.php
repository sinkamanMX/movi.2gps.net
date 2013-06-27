<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo silver 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          23-04-2012
**/
 
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
	
$id_usuario = $userAdmin->user_info['ID_USUARIO'];

$sql='SELECT U.COD_ENTITY,U.DESCRIPTION FROM ADM_UNIDADES U 
INNER JOIN ADM_GRUPOS_UNIDADES GU ON GU.COD_ENTITY=U.COD_ENTITY
INNER JOIN ADM_USUARIOS_GRUPOS UG ON UG.COD_ENTITY=U.COD_ENTITY
WHERE GU.ID_GRUPO = '.$_GET['gpo']." AND UG.ID_USUARIO = ".$id_usuario." GROUP BY U.COD_ENTITY";

$query = $db->sqlQuery($sql);
$count = $db->sqlEnumRows($query);
if($count>0){
$tpl->set_filenames(array('mUnidad' => 'tUnidad'));	
while($row = $db->sqlFetchArray($query)){
	$tpl->assign_block_vars('und',array(				
				'IDU'    => $row['COD_ENTITY'],
				'UND'    => $row['DESCRIPTION']
 			));
	}	
$tpl->pparse('mUnidad');	
}
else{
	echo 0;
	}
//echo json_encode( $result = array('aaData'=>$result ) );	 	
$db->sqlClose();



?>