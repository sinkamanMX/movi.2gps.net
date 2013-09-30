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
			'TWITTER'	    	=> $_GET['twt']
	);
		 
if($_GET['op']==1){
	//````````````````````````````````	

//``````````

			if($dbf-> insertDB($data,'ADM_RH',true) == true ){
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
				}

	
	}
if($_GET['op']==2){
	/*$data = Array(
			'ID_ADM_USUARIO'    => $idu,
			'ID_TIPO_GEO'    	=> $_GET['typ'],
			'ID_CLIENTE'	    => $idc,
			'CREADO'			=> date('Y-m-d H:i:s'),
			'DESCRIPCION'	    => $_GET['dsc'],
			'TIPO'				=> 'G',
			'PRIVACIDAD'	    => 'P',
			'MUNICIPIO'	    	=> $_GET['mun'],
			'ESTADO'	        => $_GET['edo'],
			'COLONIA'	    	=> $_GET['col'],
			'CALLE'	    		=> $_GET['str'],
			'CP'				=> $_GET['c_p'],
			'ITEM_NUMBER'	    => $_GET['nip'],
			'RADIO'	       		=> $_GET['rdo'],
			'LONGITUDE'	        => $_GET['lon'],
			'LATITUDE'	        => $_GET['lat'],
			'RESPONSABLE'	    => $_GET['res'],
			'CORREO'	    	=> $_GET['cor'],
			'CELULAR'	    	=> $_GET['cel'],
			'TWITTER'	    	=> $_GET['twt'],
			
			'ITI_AUTO_E_S_GPS'	    	=> $_GET['aes'],
			'ITI_NOTI_ENTRADA'	    	=> $_GET['nen'],
			'ITI_NOTI_SALIDA'	    	=> $_GET['nsa'],
			'ITI_NOTI_ATRAZO'	    	=> $_GET['nat'],
			'ITI_NOTI_VISTA_RUTA'	   	=> $_GET['nvr']	
	);*/
	
	$where = " ID_OBJECT_MAP  = ".$_GET['id'];
	if(($dbf-> updateDB('ADM_RH',$data,$where,true)==true)){
		echo 1;
		}
	else{
		echo 0;
		}
if($_GET['qst']!=""){
	$qs = explode(',',$_GET['qst']);
	$sgpc = "";
	for($i=0; $i<count($qs); $i++){
		$sgpc .= ($sgpc=="")?"(".$qs[$i].",".$_GET['id'].")":",(".$qs[$i].",".$_GET['id'].")";
	}
	
	$txt_pdi ="";
	$val_pdi = explode(',',$_GET['pdi']);
	$ordn = 1;
	for($i=0; $i<count($val_pdi); $i++){
		$txt_pdi .= ($txt_pdi=="")?'('.$_GET['id'].','.$val_pdi[$i].','.$idu.','.$idc.','.$ordn.')':
		',('.$_GET['id'].','.$val_pdi[$i].','.$idu.','.$idc.','.$ordn.')';
		$ordn++;
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
	
		}
	else{
		$sql_d = "INSERT INTO ADM_GEOREFERENCIA_CUESTIONARIO (ID_CUESTIONARIO,ID_OBJECT_MAP) VALUES ".$sgpc;  
		if ($qry_d = $db->sqlQuery($sql_d)){
			echo 2;
			}
		else{
			echo -1;
			}
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

if($_GET['p_r']!=""){
	$a =  explode("^",$_GET['p_r']);
					$sgp = "";
					for($j=0; $j<count($a); $j++){
						$b = explode("~",$a[$j]);
						
						$sgp .= ($sgp=="")?"(".$b[0].",".$_GET['id'].",'".utf8_decode($b[1])."','".date('Y-m-d H:i:s')."')":",(".$b[0].",".$_GET['id'].",'".utf8_decode($b[1])."','".date('Y-m-d H:i:s')."')";
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