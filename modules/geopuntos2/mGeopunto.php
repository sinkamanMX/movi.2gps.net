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
	

	$cod_client = $userAdmin->user_info['ID_CLIENTE'];
	

	
	$tpl->set_filenames(array('mGeopunto'=>'tGeopunto'));

	if($_GET['op']==2){
		$sql_a  = "SELECT * FROM ADM_GEOREFERENCIAS WHERE ID_OBJECT_MAP = ".$_GET['id'];
		$qry_a = $db->sqlQuery($sql_a);
		$cnt_a = $db->sqlEnumRows($qry_a);
		
		if($cnt_a > 0){
			$row_a = $db->sqlFetchArray($qry_a);
			
			$lus = ex_qry("ID_USUARIO","ADM_RH_USUARIO"," WHERE ID_RH = ".$_GET['id']);
			$lus = ($lus!="")?$lus:0;
			$lud = ex_qry("ID_USUARIO","ADM_USUARIOS"," WHERE ID_CLIENTE = ".$cod_client." AND ID_USUARIO NOT IN (".$lus.")");
			
			$usr_d = $dbf->dragndrop("ID_USUARIO","NOMBRE_COMPLETO","ADM_USUARIOS"," WHERE ESTATUS='Activo' AND ID_CLIENTE =".$cod_client,$lus,"");
			$usr_s = $dbf->dragndrop("ID_USUARIO","NOMBRE_COMPLETO","ADM_USUARIOS"," WHERE ESTATUS='Activo' AND ID_CLIENTE =".$cod_client,$lud,"");
			
			$aes = ($row_a['ITI_AUTO_E_S_GPS']=='S')?'checked="checked"':'';
			$nen = ($row_a['ITI_NOTI_ENTRADA']=='S')?'checked="checked"':'';
			$nsa = ($row_a['ITI_NOTI_SALIDA']=='S')?'checked="checked"':'';
			$nat = ($row_a['ITI_NOTI_ATRAZO']=='S')?'checked="checked"':'';
			$nvr = ($row_a['ITI_NOTI_VISTA_RUTA']=='S')?'checked="checked"':'';
			
				$tpl->assign_vars(array(
				'IDG'	=>	$row_a['ID_OBJECT_MAP'],
				'DSC'	=>	$row_a['DESCRIPCION'],
				'NIP'	=>	$row_a['ITEM_NUMBER'],
				'RES'	=>	$row_a['RESPONSABLE'],
				'COR'	=>	$row_a['CORREO'],
				'CEL'	=>	$row_a['CELULAR'],
				'TWT'	=>	$row_a['TWITTER'],
				'STR'	=>	$row_a['CALLE'],
				'C_P'	=>	$row_a['CP'],
				'LAT'	=>	$row_a['LATITUDE'],
				'LON'	=>	$row_a['LONGITUDE'],
				
				'AES'	=>	$aes,
				'NEN'	=>	$nen,
				'NSA'	=>	$nsa,
				'NAT'	=>	$nat,
				'NVR'	=>	$nvr,
				
				'USD'      	=> $usr_d,
				'USS'      	=> $usr_s,
				
				'OP'	=>  $_GET['op']
				));
			
		}
		
		$sql_b  = "SELECT M.ID_MUNICIPIO, M.NOMBRE AS MUN FROM ZZ_SPM_MUNICIPIOS M
		INNER JOIN ZZ_SPM_ENTIDADES E ON E.ID_ESTADO = M.ID_ESTADO
		WHERE E.NOMBRE = '".$row_a['ESTADO']."' ORDER BY M.NOMBRE;";
		$qry_b = $db->sqlQuery($sql_b);
		$cnt_b = $db->sqlEnumRows($qry_b);
		
		if($cnt_b > 0){
			while($row_b = $db->sqlFetchArray($qry_b)){
				if($_GET['op']==2){
					$f = comparar($row_b['MUN'],$row_a['MUNICIPIO']);
					$s = ($f == 1)?'selected="selected"':'';
				}
				else{
					$s="";
					}
				$tpl->assign_block_vars('mun',array(
				'ID'	=>	$row_b['ID_MUNICIPIO'],
				'DES'	=>	$row_b['MUN'],
				'S'		=>  $s 
				));
			}	
		}

		$sql_c  = "SELECT C.ID_COLONIA,C.NOMBRE AS COL FROM ZZ_SPM_COLONIAS C
		INNER JOIN ZZ_SPM_MUNICIPIOS M ON M.ID_MUNICIPIO = C.ID_MUNICIPIO
		INNER JOIN  ZZ_SPM_ENTIDADES E ON E.ID_ESTADO = C.ID_ESTADO
		WHERE (M.NOMBRE = '".$row_a['MUNICIPIO']."' OR M.NOMBRE LIKE '%".$row_a['MUNICIPIO']."%') AND E.NOMBRE = '".$row_a['ESTADO']."' ORDER BY C.NOMBRE;";
		$qry_c = $db->sqlQuery($sql_c);
		$cnt_c = $db->sqlEnumRows($qry_c);
		
		if($cnt_c > 0){
			while($row_c = $db->sqlFetchArray($qry_c)){
				
				if($_GET['op']==2){
					//echo $row_c['COL']." == ".$row_a['ADD_COLONY']."<br>";
					//echo $row_c['COL']."<br>";
					$f = comparar($row_c['COL'],$row_a['COLONIA']);
					//echo "<br>";
					$s = ($f == 1)?'selected="selected"':'';
				}		
				else{
					$s="";
					}
				$tpl->assign_block_vars('col',array(
				'ID'	=>	$row_c['ID_COLONIA'],
				'DES'	=>	$row_c['COL'],
				'S'		=>  $s 
				));
			}	
		}		
		
		}else{
			$usr = $dbf->dragndrop("ID_USUARIO","NOMBRE_COMPLETO","ADM_USUARIOS"," WHERE ESTATUS='Activo' AND ID_CLIENTE =".$cod_client,"","");
			$tpl->assign_vars(array(
				'OP'	=>  $_GET['op'],
				'USD'	=> $usr
				));
			}
	
	for($i=50;$i<=1000;$i+=50){
		
			if($_GET['op']==2){
				$s = ($i == $row_a['RADIO'])?'selected="selected"':'';
				}	
			else{
				$s="";
				}	
		
		$tpl->assign_block_vars('r',array(
			'R'   => '<option value="'.$i.'" '.$s.'>'.$i.'</option>'			
 			));			
	}
	
	$sql  = "SELECT ID_ESTADO,NOMBRE FROM ZZ_SPM_ENTIDADES ORDER BY NOMBRE;";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	
	if($cnt > 0){ 
		while($row = $db->sqlFetchArray($qry)){
		
		if($_GET['op']==2){
			//echo $row['NOMBRE']." == ".$row_a['ADD_STATE']."<br>";
			$f = comparar($row['NOMBRE'],$row_a['ESTADO']);
			$s = ($f == 1)?'selected="selected"':'';
		}
		else{
			$s="";
			}
		$tpl->assign_block_vars('data',array(
		'IDE'	=>	$row['ID_ESTADO'],
		'EDO'	=>	$row['NOMBRE'],
		'S'		=>  $s 
		));
		}
	}
	//;
	if($_GET['op']==2){
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
		}
	else{
		$comp = "";
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
	
	//
	$sql_t = "SELECT ID_TIPO,DESCRIPCION FROM ADM_GEOREFERENCIAS_TIPO ORDER BY DESCRIPCION;";
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
	 function ex_qry($id,$tbl,$w){
		global $db;
		$lp = "";
		$sql = "SELECT ".$id." AS ID FROM ".$tbl.$w;
		$qry = $db->sqlQuery($sql);
		$cnt = $db->sqlEnumRows($qry);
		if($cnt>0){
			while($row = $db->sqlFetchArray($qry)){
				$lp .= ($lp=="")?$row['ID']:",".$row['ID'];
				}
			}
		return($lp);	
		}
?>
