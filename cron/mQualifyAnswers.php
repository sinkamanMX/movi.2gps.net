  <?php
  
  $stepProcess='';
  $conexion = mysql_connect("localhost","root","root");  
  if($conexion){
    $dataBase = mysql_select_db("ALG_BD_CORPORATE_MOVI",$conexion);
    
    $sqlRespuestas = '';
    
    
    
    mysql_close($con);
  }
  /*if ($con){
    $base2 = mysql_select_db("sbri_slave",$con);
    echo "Paso 1 Inicia el proceso ... <br>";
    $sql = "SELECT ID AS IDROW
			 FROM data_out 
			WHERE ESTATUS = 0 
	 		AND ABS(TIMESTAMPDIFF(SECOND,NOW(),CREADO)) > 420 
			ORDER BY IDROW ASC ";
	if ($qry = mysql_query($sql,$con)){
		echo "Paso 2 Se ejecuta el proceso ... <br>";
		while ($row = mysql_fetch_object($qry)){
			
			"Paso 3 Se actualiza estatus en pendientes no enviados ... <br>";
			echo $sqlUpCommands = 'UPDATE data_out 
								SET ESTATUS = 2
								WHERE ID IN(
								'.$row->IDROW.')';
			if ($queryUp = mysql_query($sqlUpCommands,$con)){
				echo "Paso 3.1 Registro actualizados Correctamente ... <br>";
			}else{
				echo "No se pudieron actualizar los registros ".$commandsNoSend." ...<br>";	
			}			
		}
		
		echo "Paso 4 Se borran comandos enviados ... <br>";
		$queryDel = "DELETE FROM data_out WHERE ESTATUS IN (1,2)";

		if ($queryUp = mysql_query($queryDel,$con)){
			echo "Paso 5 Registro eliminados Correctamente ... <br>";
		}else{
			echo "Paso 5No se pudieron borrar los registros ".$commandsNoSend." ...<br>";	
		}
		
		echo "FIN...";		
		
		mysql_free_result($qry);
	}else{
		echo "no se ejecuto paso 3";
	}
    mysql_close($con);
  }
  */