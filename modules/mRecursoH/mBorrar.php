<?php
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}

	 $idu   = $userAdmin->user_info['ID_USUARIO'];
	 $idc	= $userAdmin->user_info['ID_CLIENTE'];
	 $idp = "";
	 



//Obetener cuestionarios asignados al rh
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
//obtener payload asignado al rh 
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
//Obtener PDIs asignados al rh			
	$sql  = "SELECT G.ID_OBJECT_MAP,G.DESCRIPCION,G.LATITUDE,G.LONGITUDE FROM ADM_GEOREFERENCIAS G 
		INNER JOIN ADM_RH_PDI P ON P.ID_OBJECT_MAP=G.ID_OBJECT_MAP
		WHERE P.ID_RH = ".$_GET['id']." ORDER BY P.ORDEN;";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	if($cnt > 0){
		//Borrar PDIs
		 $sql_c = "DELETE FROM ADM_RH_PDI WHERE ID_RH =".$_GET['id'];
				if ($qry_c= $db->sqlQuery($sql_c)){
					echo 1;
					}
				else{
					echo -1;
					}	
		}

//Borrar rh.	
 $sql_d="DELETE FROM ADM_RH WHERE ID_OBJECT_MAP =".$_GET['id'];
				if ($qry_d = $db->sqlQuery($sql_d)){
					echo 1;
					}
				else{
					echo -2;
					}			
$db->sqlClose();
?>