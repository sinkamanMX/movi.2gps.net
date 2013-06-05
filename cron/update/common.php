<?php
	function getTablename($id_client){
		$id_client = (int)$id_client;
		$table_name = '';	
		if (strlen($id_client) < 5) {
	        $table_name = str_repeat('0', (5-strlen($id_client)));
	    }
    	return $table_name.$id_client;
	}
	
	function getListEquipments(){
		global $conexion;		
		$respuesta = Array();		
		$sql 	= "SELECT ue.COD_ENTITY, ue.COD_EQUIPMENT, e.IMEI, u.COD_CLIENT
					FROM ADM_UNIDADES_EQUIPOS ue
					INNER JOIN ADM_EQUIPOS e ON e.COD_EQUIPMENT = ue.COD_EQUIPMENT
					INNER JOIN ADM_UNIDADES u ON u.COD_ENTITY   = ue.COD_ENTITY";
		$query 	= mysqli_query($conexion,$sql);
		if($query){
			while($row = mysqli_fetch_assoc($query)){
    			$respuesta[] = $row; // Inside while loop
			}
		}else{
			echo mysqli_error($conexion);
		}
		return $respuesta;
	}
	
	function getInfoUnit($itemNumber){
		global $conexion_movi;
		$row='null';
		$sql = "SELECT EN.COD_ENTITY AS MOV_ENTITY, EN.COD_FLEET AS MOV_FLEET
				FROM SAVL1340 EQ
				INNER JOIN SAVL1343 EE ON EE. COD_EQUIPMENT = EQ.COD_EQUIPMENT
				INNER JOIN SAVL1120 EN ON EN.COD_ENTITY = EE.COD_ENTITY
				WHERE EQ.SECOND_ITEM_NUMBER = ".$itemNumber;
		$query 	= mysqli_query($conexion_movi,$sql);
		if($query){
			$row = mysqli_fetch_assoc($query);			
		}else{
			echo mysqli_error($conexion_movi);
		}
		return $row;	
	}
		
	function getPositions(){
		global $conexion_movi,$listEquipments;
		for($i=0;$i<count($listEquipments);$i++){
			$unit_info = getInfoUnit($listEquipments[$i]['IMEI']);
			if($unit_info!="null"){
				$listEquipments[$i]['MOV_TABLE'] = getTablename($listEquipments[$i]['COD_CLIENT']);
				$listEquipments[$i]['MOV_ENTITY']  = $unit_info['MOV_ENTITY'];
				$listEquipments[$i]['MOV_FLEET']   = $unit_info['MOV_FLEET'];
				$listEquipments[$i]['MOV_TABLE_P'] = getTablename($unit_info['MOV_FLEET']);				
				$listEquipments[$i]['MOV_LAST_P']  = getLastPositions($listEquipments[$i]['MOV_TABLE_P'],$unit_info['MOV_ENTITY']);
				$listEquipments[$i]['MOV_HIST_P']  = getHistPositions($listEquipments[$i]['MOV_TABLE_P'],$unit_info['MOV_ENTITY']);
			}
		}
	}
	
	function getLastPositions($tableName,$codEntityMov){
		global $conexion_movi;
		$sql = "SELECT * FROM LAST".$tableName." WHERE COD_ENTITY = ".$codEntityMov." LIMIT 1";
		$query 	= mysqli_query($conexion_movi,$sql);
		if($query){
			$row = mysqli_fetch_assoc($query);
		}else{
			echo mysqli_error($conexion_movi);
		}
		return $row;
	}	
	
	function getHistPositions($tableName,$codEntityMov){
		global $conexion_movi;
		$historial=array();
		$sql = "SELECT * FROM HIST".$tableName." 
				WHERE COD_ENTITY = ".$codEntityMov." 
				AND COD_UID_ADDRESS IS NULL 
				ORDER BY GPS_DATETIME DESC  
				LIMIT 50";
		$query 	= mysqli_query($conexion_movi,$sql);
		if($query){
			while($row = mysqli_fetch_assoc($query)){
    			$historial[] = $row; // Inside while loop
			}			
		}else{
			echo mysqli_error($conexion_movi);
		}
		return $historial;
	}

	function setPositions(){
		global $conexion,$listEquipments;
		for($i=0;$i<count($listEquipments);$i++){
			setLastPositions($listEquipments[$i]['MOV_TABLE'],$listEquipments[$i]['COD_ENTITY'],$listEquipments[$i]['MOV_LAST_P']);
			setHistPositions($listEquipments[$i]['MOV_TABLE'],$listEquipments[$i]['MOV_TABLE_P'],$listEquipments[$i]['COD_ENTITY'],$listEquipments[$i]['MOV_HIST_P']);
		}		
	}
		
	function setLastPositions($tableName,$codEntity,$dataInfo){
		global $conexion;
		$sql = "UPDATE LAST".$tableName."
				SET COD_UID_ADDRESS	= 'NULL',
					GPS_DATETIME	= '".$dataInfo['GPS_DATETIME']."',
					VELOCITY		= ".$dataInfo['VELOCITY'].",
					LONGITUDE		= ".$dataInfo['LONGITUDE'].",
					LATITUDE		= ".$dataInfo['LATITUDE'].",
					ALTITUDE		= ".$dataInfo['ALTITUDE'].",
					ANGLE			= ".$dataInfo['ANGLE'].",				
					COD_EVENT		= ".$dataInfo['COD_EVENT'].",
					FECHA_SAVE		= 'CURRENT_TIMESTAMP'
				WHERE COD_ENTITY	= ".$codEntity;
		$query 	= mysqli_query($conexion,$sql);
		if($query){
			echo "actualizado <br>";
		}else{
			echo mysqli_error($conexion);
		}			
	}
	
	function setHistPositions($tableName,$tableNameMov,$codEntity,$dataInfo){
		global $conexion;		
		foreach($dataInfo as $row){
			$sql = "INSERT INTO HIST".$tableName."
					SET COD_UID_ADDRESS	= 'NULL',
						GPS_DATETIME	= '".$row['GPS_DATETIME']."',
						VELOCITY		= ".$row['VELOCITY'].",
						LONGITUDE		= ".$row['LONGITUDE'].",
						LATITUDE		= ".$row['LATITUDE'].",
						ALTITUDE		= ".$row['ALTITUDE'].",
						ANGLE			= ".$row['ANGLE'].",				
						COD_EVENT		= ".$row['COD_EVENT'].",
						FECHA_SAVE		= 'CURRENT_TIMESTAMP',
					    COD_ENTITY		= ".$codEntity." ";
			$query 	= mysqli_query($conexion,$sql);
			if($query){
				echo "insertado <br>";
				upHistpositions($tableNameMov,$row['COD_HISTORY']);
			}else{
				echo mysqli_error($conexion);
			}				
		}
	}
	
	function upHistpositions($tableName,$codHistory){
		global $conexion_movi;
		$sql = "UPDATE HIST".$tableName." 
				SET COD_UID_ADDRESS = 1 
				WHERE COD_HISTORY = ".$codHistory."  LIMIT 1";				
		$query 	= mysqli_query($conexion_movi,$sql);
		if($query){
			echo "Marcado <br>";
		}else{
			echo mysqli_error($conexion);
		}	
	}