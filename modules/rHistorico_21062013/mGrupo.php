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
	
$id_usuario = $userAdmin->user_info['ID_CLIENTE'];

//$sql='SELECT G.ID_GRUPO, G.NOMBRE FROM ADM_GRUPOS G WHERE G.ID_ADM_USUARIO='.$id_usuario;
 $sql = "SELECT G.ID_GRUPO, G.NOMBRE,GC.ID_GRUPO_CLIENTE FROM ADM_GRUPOS G 
INNER JOIN ADM_GRUPOS_CLIENTES GC ON GC.ID_GRUPO=G.ID_GRUPO
WHERE GC.ID_CLIENTE=".$id_usuario." AND (SELECT COUNT(COD_ENTITY) FROM ADM_GRUPOS_UNIDADES WHERE ID_GRUPO = G.ID_GRUPO GROUP BY ID_GRUPO)>0 ";
$query = $db->sqlQuery($sql);
$count = $db->sqlEnumRows($query);
if($count>0){
$tpl->set_filenames(array('mGrupo' => 'tGrupo'));	
while($row = $db->sqlFetchArray($query)){
	$tpl->assign_block_vars('gpo',array(				
				'IDG'    => $row['ID_GRUPO'],
				'GPO'    => $row['NOMBRE']
 			));
	}	
$tpl->pparse('mGrupo');	
}
else{
	echo 0;
	}
//echo json_encode( $result = array('aaData'=>$result ) );	 	
$db->sqlClose();



?>