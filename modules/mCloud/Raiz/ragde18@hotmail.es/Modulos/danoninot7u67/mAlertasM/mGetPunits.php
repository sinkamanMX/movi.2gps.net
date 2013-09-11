<?php
/*
 *  @package             4TOGO
 *  @name                Obtiene las unidades a mostrar en el mapa
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          03/05/2011 
**/
	set_time_limit(0);
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
		
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
					
	$userID   	      = $userAdmin->user_info['COD_USER'];	
	$idCompany    = $userAdmin->user_info['COD_CLIENT'];
  	$cadena_envio = "";
	$cadena_envio2 = ' ';
    $id_unidad = "";
	$cadena_ids=' ';
 
		$query_units_cli="SELECT a.ID_GROUP,
									a.NAME_GROUP,
									b.COD_ENTITY ,
									c.DESCRIPTION
									FROM SAVL1220_G a 
									INNER JOIN SAVL1220_GDET b ON
									a.ID_GROUP = b.ID_GROUP 
									INNER JOIN SAVL1120 c ON b.COD_ENTITY=c.COD_ENTITY
									WHERE a.COD_CLIENT=".$idCompany." ORDER BY c.DESCRIPTION";
									$queryQ  = $db->sqlQuery($query_units_cli);
									$count     = $db->sqlEnumRows($queryQ);
			//$rowU = $db->sqlFetchArray($queryQ);						
           
      

	  while($rowU = $db->sqlFetchArray($queryQ)){	

								if($cadena_envio == ""){
									$cadena_ids=$rowU['COD_ENTITY'];
								  
                                   $cadena_envio = 	$rowU['ID_GROUP'].'|'.$rowU['NAME_GROUP'].'|'.$rowU['COD_ENTITY'].'|'.$userAdmin->codif($rowU['DESCRIPTION']);
							  
								}else{
									$cadena_ids=$cadena_ids.','.$rowU['COD_ENTITY'];
								 $cadena_envio =  $cadena_envio .'!'.$rowU['ID_GROUP'].'|'.$rowU['NAME_GROUP'].'|'.$rowU['COD_ENTITY'].'|'.$userAdmin->codif($rowU['DESCRIPTION']);
							  
								}

	   }
	   
	   $query_evets="SELECT DISTINCT EV.DESCRIPTION AS DES_EVENT,
	   				EV.COD_EVENT,
					UN.DESCRIPTION AS DES_UNID,
					UN.COD_ENTITY
	   					FROM SAVL1260 EV, SAVL1261 EVT, SAVL1340 EQ, SAVL1343 EU, SAVL1120 UN
					WHERE EV.COD_EVENT = EVT.COD_EVENT AND
						  EVT.`COD_EQUIPMENT` = EQ.COD_EQUIPMENT AND
						  EQ.COD_EQUIPMENT = EU.COD_EQUIPMENT AND
						  EU.COD_ENTITY = UN.COD_ENTITY AND
						  UN.COD_ENTITY IN (".$cadena_ids.") ORDER BY EV.COD_EVENT";
						
						$row = $Positions-> obtener_event_xu($query_evets);
						$count1 = count($row);
           
      

 for($i=0;$i<$count1;$i++){	

								if($cadena_envio2 == ' '){
									//$cadena_ids=$rowU['COD_ENTITY'];
								  
                                   $cadena_envio2 = 	$userAdmin->codif($row[$i][0]).'|'.$row[$i][1].'|'.$row[$i][2].'|'.$row[$i][3];
							  
								}else{
									//$cadena_ids=$cadena_ids.','.$rowU['COD_ENTITY'];
								 $cadena_envio2 =  $cadena_envio2 .'!'.$userAdmin->codif($row[$i][0]).'|'.$row[$i][1].'|'.$row[$i][2].'|'.$row[$i][3];
							  
								}

	   }
	   
	   
	   
	   
  
  
  	echo $cadena_envio.'?'.$cadena_envio2;
?>