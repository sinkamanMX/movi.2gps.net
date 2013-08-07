<?php
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}

	 $idu   = $userAdmin->user_info['ID_USUARIO'];
	 $idc	= $userAdmin->user_info['ID_CLIENTE'];
	 $idp = "";
	 



//Obetener cuestionarios asignados al punto
	$sql  = "SELECT ID_CUESTIONARIO FROM ADM_GEOREFERENCIA_CUESTIONARIO  WHERE ID_OBJECT_MAP = ".$_GET['id'];
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	if($cnt > 0){
		//BORRAR CUESTIONARIOS  some_value
		 $sql_c="DELETE FROM ADM_GEOREFERENCIA_CUESTIONARIO WHERE ID_OBJECT_MAP =".$_GET['id'];
				if ($qry_c= $db->sqlQuery($sql_c)){
					echo 1;
					}
				else{
					echo 0;
					}	
		}		
//obtener payload asignado al punto 
	$sql  = "SELECT ID_CUESTIONARIO FROM ADM_GEO_PAYLOAD WHERE ID_OBJECT_MAP = ".$_GET['id'];
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	if($cnt > 0){
		//Borrar payload
		 $sql_c="DELETE FROM ADM_GEO_PAYLOAD WHERE ID_OBJECT_MAP =".$_GET['id'];
				if ($qry_c= $db->sqlQuery($sql_c)){
					echo 1;
					}
				else{
					echo -1;
					}	
		}		
//Borrar geopunto.	
 $sql_d="DELETE FROM ADM_GEOREFERENCIAS WHERE ID_OBJECT_MAP =".$_GET['id'];
				if ($qry_d = $db->sqlQuery($sql_d)){
					echo 1;
					}
				else{
					echo -2;
					}			
$db->sqlClose();
?>