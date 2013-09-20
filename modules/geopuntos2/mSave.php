<?php
header("Content-Type: text/html;charset=utf-8");
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';  //Manda al login si no se ha Logeo.
	//--------------------------- Modificada BD y Encabezado------------------------
	$idc   = $userAdmin->user_info['ID_CLIENTE'];
	$idu   = $userAdmin->user_info['ID_USUARIO'];

	 $idp = "";
	 
if($_GET['op']==1){
	//````````````````````````````````	
	    $data = Array(
			'ID_ADM_USUARIO'   => $idu,
			'ID_TIPO_GEO'    	=> $_GET['typ'],
			'ID_CLIENTE'	    => $idc,
			'CREADO'	=> date('Y-m-d H:i:s'),
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
			
		);
//``````````

			if($dbf-> insertDB($data,'ADM_GEOREFERENCIAS',true) == true ){
				echo 1;
				if($_GET['qst']!=""){
					$idg = lastid();
				$qs = explode(',',$_GET['qst']);
				$sgpc = "";
				
				//Almacenar relación pdi cuestionarios
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
	$data = Array(
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
	);
	
	$where = " ID_OBJECT_MAP  = ".$_GET['id'];
	if(($dbf-> updateDB('ADM_GEOREFERENCIAS',$data,$where,true)==true)){
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