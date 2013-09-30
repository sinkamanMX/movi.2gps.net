<?php
/** * 
 *  @package             4togo_Pepsico.
 *  @name                Obtiene los GeoPuntos.
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Erick A. Calderón
 *  @modificado          12-07-2011 
**/

	//--------------------------- Modificada BD y Encabezado------------------------
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';  //Manda al login si no se ha Logeo.
	//--------------------------- Modificada BD y Encabezado------------------------
	$db ->sqlQuery("SET NAMES 'utf8'");
	

	$cod_client = $userAdmin->user_info['ID_CLIENTE'];
	

	
	$tpl->set_filenames(array('mGeopunto'=>'tGeopunto'));

	if($_GET['op']==2){
		//DATOS GENERALES
		$sql_a  = "SELECT * FROM ADM_RH WHERE ID_OBJECT_MAP = ".$_GET['id'];
		$qry_a = $db->sqlQuery($sql_a);
		$cnt_a = $db->sqlEnumRows($qry_a);
		
		if($cnt_a > 0){
			$row_a = $db->sqlFetchArray($qry_a);
			

			
				$tpl->assign_vars(array(
				'IDG'	=>	$row_a['ID_OBJECT_MAP'],
				'DSC'	=>	$row_a['DESCRIPCION'],
				'NIP'	=>	$row_a['ITEM_NUMBER'],
				'COR'	=>	$row_a['CORREO'],
				'CEL'	=>	$row_a['CELULAR'],
				'TWT'	=>	$row_a['TWITTER'],
				
				'OP'	=>  $_GET['op']
				));
			
		}
		

		
		}else{
			$tpl->assign_vars(array(
				'OP'	=>  $_GET['op']
				));
			}
	

	
	//;
	if($_GET['op']==2){
		//Cuestionarios seleccionados
		$sql_d  = "SELECT ID_CUESTIONARIO FROM ADM_GEOREFERENCIA_CUESTIONARIO WHERE ID_OBJECT_MAP = ".$_GET['id'];
		$qry_d = $db->sqlQuery($sql_d);
		$cnt_d = $db->sqlEnumRows($qry_d);
	$comp ="";
	if($cnt_d > 0){
		$idq = "";
		while($row_d = $db->sqlFetchArray($qry_d)){
			$idq .= ($idq=="")?$row_d['ID_CUESTIONARIO']:",".$row_d['ID_CUESTIONARIO'];
			}
			$comp = "  AND ID_CUESTIONARIO NOT IN (".$idq.") ";
		 }
		 if($idq!=""){
		 $sql_e = "SELECT ID_CUESTIONARIO,DESCRIPCION FROM CRM2_CUESTIONARIOS WHERE COD_CLIENT = ".$cod_client." AND ID_CUESTIONARIO  IN (".$idq.") ORDER BY DESCRIPCION;";
		 $qry_e = $db->sqlQuery($sql_e);
		 $cnt_e = $db->sqlEnumRows($qry_e);
		 
		 if($cnt_e > 0){
			 while($row_e = $db->sqlFetchArray($qry_e)){
				 $tpl->assign_block_vars('U2',array(
					'ID'	=>	$row_e['ID_CUESTIONARIO'],
					'DES'	=>	$row_e['DESCRIPCION']
					));
				}		
			}
		 }
		//PDIs seleccionados
		$sql_s = "SELECT G.ID_OBJECT_MAP,G.DESCRIPCION,G.LATITUDE,G.LONGITUDE FROM ADM_GEOREFERENCIAS G 
		INNER JOIN ADM_RH_PDI P ON P.ID_OBJECT_MAP=G.ID_OBJECT_MAP
		WHERE P.ID_RH = ".$_GET['id']." ORDER BY P.ORDEN"; 
		$qry_s = $db->sqlQuery($sql_s);
		$cnt_s = $db->sqlEnumRows($qry_s);
		$ps = "";
		if($cnt_s > 0){
		$idp = "";
		while($row_s = $db->sqlFetchArray($qry_s)){
			$idp .= ($idp == "")?$row_s['ID_OBJECT_MAP']:",".$row_s['ID_OBJECT_MAP'];
			$tpl->assign_block_vars('PS',array(
				'ID'	=>	$row_s['ID_OBJECT_MAP'],
				'DES'	=>	$row_s['DESCRIPCION'],
				'LAT'	=>	$row_s['LATITUDE'],
				'LON'	=>	$row_s['LONGITUDE']
			));
			}
			$ps = "  AND ID_OBJECT_MAP NOT IN (".$idp.") ";
		 }
		}
	else{
		$comp = "";
		$idp  = "";
		}	
	$sql_u  = "SELECT ID_CUESTIONARIO,DESCRIPCION FROM CRM2_CUESTIONARIOS WHERE COD_CLIENT = ".$cod_client.$comp." ORDER BY DESCRIPCION;";
	$qry_u = $db->sqlQuery($sql_u);
	$cnt_u = $db->sqlEnumRows($qry_u);
	
	if($cnt_u > 0){ 
		while($row_u = $db->sqlFetchArray($qry_u)){
		
		$tpl->assign_block_vars('U',array(
		'ID'	=>	$row_u['ID_CUESTIONARIO'],
		'DES'	=>	$row_u['DESCRIPCION']
		));
		}
	}
	$sql_v  = "SELECT ID_OBJECT_MAP,DESCRIPCION,LATITUDE,LONGITUDE FROM ADM_GEOREFERENCIAS WHERE ID_CLIENTE = ".$cod_client.$ps." ORDER BY DESCRIPCION;";
	$qry_v = $db->sqlQuery($sql_v);
	$cnt_v = $db->sqlEnumRows($qry_v);
	
	if($cnt_v > 0){ 
		while($row_v = $db->sqlFetchArray($qry_v)){
		
		$tpl->assign_block_vars('PD',array(
		'ID'	=>	$row_v['ID_OBJECT_MAP'],
		'DES'	=>	$row_v['DESCRIPCION'],
		'LAT'	=>	$row_v['LATITUDE'],
		'LON'	=>	$row_v['LONGITUDE']
		));
		}	
	}
	//
	$sql_t = "SELECT ID_TIPO,DESCRIPCION FROM ADM_RH_TIPO WHERE ID_CLIENTE = ".$cod_client." ORDER BY DESCRIPCION;";
	$qry_t = $db->sqlQuery($sql_t);
	$cnt_t = $db->sqlEnumRows($qry_t);
	
	if($cnt_t > 0){ 
		while($row_t = $db->sqlFetchArray($qry_t)){
		if($_GET['op']==2){
			$s = ($row_t['ID_TIPO'] == $row_a['ID_TIPO_GEO'])?'selected="selected"':'';
		}
		else{
			$s="";
			}				
		$tpl->assign_block_vars('T',array(
		'ID'	=>	$row_t['ID_TIPO'],
		'DES'	=>	$row_t['DESCRIPCION'],
		'S' 	=>  $s
		));
		}
	}

	
	$tpl->pparse('mGeopunto');

function comparar($x,$y){
	global $db;

	if($y!=""){
	$i = trim($x);
	$j = trim($y);
	
	
	 $sql = "SELECT IF('".$i."' LIKE '%".$j."%',1,0) AS CMP;";
	//echo "<br>";
	$qry = $db->sqlQuery($sql);
	$row = $db->sqlFetchArray($qry);
	return $row['CMP'];
	}
	else{
		return 0;
		}
	}	

?>
