<?php
header("Content-Type: text/html;charset=utf-8");
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';  //Manda al login si no se ha Logeo.
	//--------------------------- Modificada BD y Encabezado------------------------
	$db ->sqlQuery("SET NAMES 'utf8'");
	
	$idc   = $userAdmin->user_info['ID_CLIENTE'];
	$idu   = $userAdmin->user_info['ID_USUARIO'];

	 $idp = "";
	 $data = Array(
			'ID_ADM_USUARIO'   	=> $idu,
			'ID_TIPO_GEO'    	=> $_GET['typ'],
			'ID_CLIENTE'	    => $idc,
			'CREADO'			=> date('Y-m-d H:i:s'),
			'DESCRIPCION'	    => $_GET['dsc'],
			'ITEM_NUMBER'	    => $_GET['nip'],
			'CORREO'	    	=> $_GET['cor'],
			'CELULAR'	    	=> $_GET['cel'],
			'TWITTER'	    	=> $_GET['twt'],
			'TIPO'				=> 'RH'
	);
		 
if($_GET['op']==1){
	//````````````````````````````````	

//``````````

			//if($dbf-> insertDB($data,'ADM_RH',true) == true ){
			if($dbf-> insertDB($data,'ADM_GEOREFERENCIAS',true) == true ){
				$idg = lastid();
				echo 1;
				if($_GET['qst']!=""){
					
					
					$qs = explode(',',$_GET['qst']);
					$sgpc = "";
				
				//Almacenar relación rh cuestionarios
				for($i=0; $i<count($qs); $i++){
					$sgpc .= ($sgpc=="")?"(".$qs[$i].",".$idg.")":",(".$qs[$i].",".$idg.")";
					}
					
				$sql_c="INSERT INTO ADM_GEOREFERENCIA_CUESTIONARIO (ID_CUESTIONARIO,ID_OBJECT_MAP) VALUES ".$sgpc;  
				if ($qry_c= $db->sqlQuery($sql_c)){
					echo 1;
					}

				else{
					echo -1;
					}
				//Almacenar relación rh-pdi
				$txt_pdi ="";
				$val_pdi = explode(',',$_GET['pdi']);
				$ordn = 1;
				for($i=0; $i<count($val_pdi); $i++){
					$txt_pdi .= ($txt_pdi=="")?'('.$idg.','.$val_pdi[$i].','.$idu.','.$idc.','.$ordn.')':
					',('.$idg.','.$val_pdi[$i].','.$idu.','.$idc.','.$ordn.')';
					$ordn++;
					}
				$sql_e = "INSERT INTO ADM_RH_PDI (ID_RH,ID_OBJECT_MAP,ID_USUARIO,ID_CLIENTE,ORDEN) VALUES ".$txt_pdi;	
				if($qry_e = $db->sqlQuery($sql_e)){echo 2;}
				}
			if($_GET['car']!=""){
				$dcar = "";
				$ecar = explode(",",$_GET['car']);
				for($k=0; $k<count($ecar); $k++){
					$dcar .= ($dcar=="")?'('.$idg.','.$ecar[$k].',"'.date('Y-m-d H:i:s').'")':',('.$idg.','.$ecar[$k].',"'.date('Y-m-d H:i:s').'")';
					}
				$sql_g = "INSERT INTO ADM_RH_USUARIO (ID_RH,ID_USUARIO,FECHA) VALUES ".$dcar;	
				if($qry_g = $db->sqlQuery($sql_g)){echo 3;}else{echo -3;}
				}
				
			if($_GET['p_r']!=""){
				$a =  explode("^",$_GET['p_r']);
				
				$sgp = "";
				for($j=0; $j<count($a); $j++){
					$b = explode("~",$a[$j]);
					
					$sgp .= ($sgp=="")?"(".$b[0].",".$idg.",'".$b[1]."','".date('Y-m-d H:i:s')."')":",(".$b[0].",".$idg.",'".$b[1]."','".date('Y-m-d H:i:s')."')";
					}
				//Almacenar relación payload pregunta respuesta 
						$sql_d = "INSERT INTO ADM_GEO_PAYLOAD (ID_CUESTIONARIO,ID_OBJECT_MAP,CADENA_PAYLOAD,FECHA_CREADO) VALUES ".$sgp; 
						if ($qry_d = $db->sqlQuery($sql_d)){
							echo 1;
							}
						else{
							echo -2;
							}
						}	
				}else{
					echo -1;
					}

	
	}
if($_GET['op']==2){
	
	$where = " ID_OBJECT_MAP  = ".$_GET['id'];
	//if(($dbf-> updateDB('adm_rh',$data,$where,true)==true)){
	if(($dbf-> updateDB('ADM_GEOREFERENCIAS',$data,$where,true)==true)){
		echo 1;
		}
	else{
		echo 0;
		}
		
	if($_GET['pdi']!=""){
	//generar data rh-pdi
	$txt_pdi ="";
	$val_pdi = explode(',',$_GET['pdi']);
	$ordn = 1;
	for($i=0; $i<count($val_pdi); $i++){
		$txt_pdi .= ($txt_pdi=="")?'('.$_GET['id'].','.$val_pdi[$i].','.$idu.','.$idc.','.$ordn.')':
		',('.$_GET['id'].','.$val_pdi[$i].','.$idu.','.$idc.','.$ordn.')';
		$ordn++;
		}
	//Obtener pdi asignados al rh
	$sql_b = "SELECT G.ID_OBJECT_MAP,G.DESCRIPCION,G.LATITUDE,G.LONGITUDE FROM ADM_GEOREFERENCIAS G 
		INNER JOIN ADM_RH_PDI P ON P.ID_OBJECT_MAP=G.ID_OBJECT_MAP
		WHERE P.ID_RH = ".$_GET['id']." ORDER BY P.ORDEN;";
	$qry_b = $db->sqlQuery($sql_b);
	$cnt_b = $db->sqlEnumRows($qry_b);
	if($cnt_b > 0){
		//BORRAR PDIs
		$sql_a="DELETE FROM ADM_RH_PDI WHERE ID_RH =".$_GET['id'];
				if ($qry_a = $db->sqlQuery($sql_a)){
					//insertar nuevos PDIs
					$sql_f = "INSERT INTO ADM_RH_PDI (ID_RH,ID_OBJECT_MAP,ID_USUARIO,ID_CLIENTE,ORDEN) VALUES ".$txt_pdi;
					if ($qry_f = $db->sqlQuery($sql_f)){
						echo 2;
						}
					else{
						echo -1;
						}	
					}
		}	

	else{
		//insertar nuevos PDIs
		$sql_f = "INSERT INTO ADM_RH_PDI (ID_RH,ID_OBJECT_MAP,ID_USUARIO,ID_CLIENTE,ORDEN) VALUES ".$txt_pdi;
		if ($qry_f = $db->sqlQuery($sql_f)){
			echo 2;
		}
		else{
			echo -1;
			}		
		}			
	}
	
	if($_GET['car']!=""){
	//generar data rh-usuario
	$dcar = "";
	$ecar = explode(",",$_GET['car']);
	for($k=0; $k<count($ecar); $k++){
		$dcar .= ($dcar=="")?'('.$_GET['id'].','.$ecar[$k].',"'.date('Y-m-d H:i:s').'")':',('.$_GET['id'].','.$ecar[$k].',"'.date('Y-m-d H:i:s').'")';
		}
	//Obtener usuarios asignados al rh 
	$sql_h = "SELECT ID_USUARIO FROM ADM_RH_USUARIO WHERE  ID_RH = ".$_GET['id'];
	$qry_h = $db->sqlQuery($sql_h);
	$cnt_h = $db->sqlEnumRows($qry_h);
	if($cnt_h > 0){
		//borrar usuarios
		$sql_c="DELETE FROM ADM_RH_USUARIO WHERE ID_RH =".$_GET['id'];
				if ($qry_c= $db->sqlQuery($sql_c)){
					//INSERTAR NUEVOS CUESTIONARIOS
					 $sql_d = "INSERT INTO ADM_RH_USUARIO (ID_RH,ID_USUARIO,FECHA) VALUES ".$dcar;  
					if ($qry_d = $db->sqlQuery($sql_d)){
						echo 2;
						}
					else{
						echo -1;
						}	
					}
		}
	else{
		$sql_g = "INSERT INTO ADM_RH_USUARIO (ID_RH,ID_USUARIO,FECHA) VALUES ".$dcar;	
				if($qry_g = $db->sqlQuery($sql_g)){echo 3;}else{echo -3;}	
		}		
	}
	
	if($_GET['qst']!=""){
			
	//genrar data rh - cuestionario
	$qs = explode(',',$_GET['qst']);
	$sgpc = "";
	for($i=0; $i<count($qs); $i++){
		$sgpc .= ($sgpc=="")?"(".$qs[$i].",".$_GET['id'].")":",(".$qs[$i].",".$_GET['id'].")";
	}
	//Obetener cuestionarios asignados al punto
	$sql  = "SELECT ID_CUESTIONARIO FROM ADM_GEOREFERENCIA_CUESTIONARIO  WHERE ID_OBJECT_MAP = ".$_GET['id'];
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	if($cnt > 0){
		//BORRAR CUESTIONARIOS  some_value
		$sql_c="DELETE FROM ADM_GEOREFERENCIA_CUESTIONARIO WHERE ID_OBJECT_MAP =".$_GET['id'];
				if ($qry_c= $db->sqlQuery($sql_c)){
					//INSERTAR NUEVOS CUESTIONARIOS
					$sql_d = "INSERT INTO ADM_GEOREFERENCIA_CUESTIONARIO (ID_CUESTIONARIO,ID_OBJECT_MAP) VALUES ".$sgpc;  
					if ($qry_d = $db->sqlQuery($sql_d)){
						echo 2;
						}
					else{
						echo -1;
						}	
					}
		}
	else{
		$sql_d = "INSERT INTO ADM_GEOREFERENCIA_CUESTIONARIO (ID_CUESTIONARIO,ID_OBJECT_MAP) VALUES ".$sgpc;  
		if ($qry_d = $db->sqlQuery($sql_d)){
			echo 2;
			}
		else{
			echo -1;
			}	
		}			
}

if($_GET['p_r']!=""){
	$a =  explode("^",$_GET['p_r']);
					$sgp = "";
					for($j=0; $j<count($a); $j++){
						$b = explode("~",$a[$j]);
						
						$sgp .= ($sgp=="")?"(".$b[0].",".$_GET['id'].",'".$b[1]."','".date('Y-m-d H:i:s')."')":",(".$b[0].",".$_GET['id'].",'".$b[1]."','".date('Y-m-d H:i:s')."')";
					}
					//echo $sgp;
//obtener payload asignado al punto 
	$sql  = "SELECT ID_CUESTIONARIO FROM ADM_GEO_PAYLOAD WHERE ID_OBJECT_MAP = ".$_GET['id'];
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	if($cnt > 0){
		//Borrar payload
		$sql_c="DELETE FROM ADM_GEO_PAYLOAD WHERE ID_OBJECT_MAP =".$_GET['id'];
				if ($qry_c= $db->sqlQuery($sql_c)){
					
					
					//Almacenar relación payload pregunta respuesta 
					$sql_d = "INSERT INTO ADM_GEO_PAYLOAD (ID_CUESTIONARIO,ID_OBJECT_MAP,CADENA_PAYLOAD,FECHA_CREADO) VALUES ".$sgp; 
					if ($qry_d = $db->sqlQuery($sql_d)){
							echo 1;
							}
						else{
							echo -2;
							}
					}
		
		}
	else{
		//Almacenar relación payload pregunta respuesta 
		$sql_d = "INSERT INTO ADM_GEO_PAYLOAD (ID_CUESTIONARIO,ID_OBJECT_MAP,CADENA_PAYLOAD,FECHA_CREADO) VALUES ".$sgp; 
					if ($qry_d = $db->sqlQuery($sql_d)){
							echo 1;
							}
						else{
							echo -2;
							}
		
		}	
}

	
	}

					
					
							
				
function lastid (){
	global $db;
	$sql = "SELECT LAST_INSERT_ID() AS ID;";
	$qry = $db->sqlQuery($sql);
	$row = $db->sqlFetchArray($qry);
	return $row['ID'];
	}		
$db->sqlClose();
?>