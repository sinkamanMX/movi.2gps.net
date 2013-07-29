  <?php
  $commandsNoSend='';
  $con = mysql_connect("188.138.40.249","sa","$0lstic3$");
  if ($con){
    $base2 = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con);
    echo "Paso 1 Inicia el proceso ... <br>";
    $sql = " SELECT ID_ENVIADO
			 FROM ADM_COMANDOS_ENVIADOS 
			WHERE ENVIADO = 0 
	 		AND ABS(TIMESTAMPDIFF(SECOND,NOW(),CREADO)) > 420 
			ORDER BY ID_ENVIADO DESC";
	if ($qry = mysql_query($sql,$con)){
		echo "Paso 2 Se ejecuta el proceso ... <br>";
		while ($row = mysql_fetch_object($qry)){
			$commandsNoSend.= ($commandsNoSend=="") ? "": ",";
			$commandsNoSend.= $commandsNoSend+$row->ID_ENVIADO;
		}
		
		if($commandsNoSend!=""){
			echo "Paso 3 Se actualiza estatus en pendientes no enviados ... <br>";
			$sqlUpCommands = 'UPDATE ADM_COMANDOS_ENVIADOS 
								SET ENVIADO = 2
								WHERE ID_ENVIADO IN(
								'.$commandsNoSend.')';
			if ($queryUp = mysql_query($sqlUpCommands,$con)){
				echo "Paso 3.1 Registro actualizados Correctamente ... <br>";
			}else{
				echo "No se pudieron actualizar los registros ".$commandsNoSend." ...<br>";	
			}
		}else{
			echo "No hay Pendientes por enviar con mas de 7 minutos...<br>";	
		}
		
		echo "Paso 4 Se borran comandos enviados ... <br>";
		$queryDel = "DELETE FROM ADM_COMANDOS_ENVIADOS WHERE ENVIADO IN (1,2)";

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