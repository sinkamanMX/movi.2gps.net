<?php
/*
 *  @package             4TOGO
 *  @name                Obtiene las unidades a mostrar en el mapa
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          03/05/2011 
**/

	//set_time_limit(600);
	$con = mysql_connect('188.138.40.249','savl','397LUP');
	mysql_select_db("movilidad", $con);		
			$info_unit='';
	
  			$name='';
  
  
  
  $query1= mysql_query("SELECT E.COD_CLIENT,
						COUNT(E.COD_ENTITY) AS SUMA
 						FROM SAVL_CLIENTS_UNITS E
						GROUP BY COD_CLIENT");
 	
				
	while($row1 = mysql_fetch_array($query1)){
				
			$info_unit='';
			
			
		$name=$row1['COD_CLIENT'].'.txt'; 
		
		//$info_unit.="$".$row1['COD_CLIENT'].chr(13).chr(10)."";
	
  
  
  
  
				$querys= mysql_query("SELECT E.COD_ENTITY
						FROM SAVL_CLIENTS_UNITS E
						WHERE COD_CLIENT=".$row1['COD_CLIENT']); 
						
				
				
				while($row_loc = mysql_fetch_array($querys)){
				
				
				$Q = mysql_query("SELECT f.PLAQUE,f.YEAR,f.DESCRIPTION,    
			                  IF (e.GPS_DATETIME IS NULL, '0000-00-00 00:00:00',e.GPS_DATETIME) AS GPS_DATETIME ,
							  IF(g.DESCRIPTION IS NULL,'NO HA REPORTADO',g.DESCRIPTION) AS DESC_EVT,     
							  IF(e.VELOCITY IS NULL,0,e.VELOCITY) AS VELOCITY,
							  f.COD_FLEET,
                              IF(e.LATITUDE IS NULL,0,e.LATITUDE) AS LATITUDE,
						      IF(e.LONGITUDE IS NULL,0,e.LONGITUDE) AS LONGITUDE,
					          f.COD_ENTITY,
						      IF (g.PRIORITY is null,0,g.PRIORITY) as PRIORITY,
							  e.ANGLE,
							  e.BATTERY,
							  f.ACTIVE,
							  (SELECT concat('A ',TRUNCATE(DISTANCIA(P.LATITUDE,P.LONGITUDE,e.LATITUDE,e.LONGITUDE),2),
               					' km de ', P.DESCRIPTION) AS DIS
							 FROM SAVL_G_PRIN P
 								WHERE  P.COD_CLIENT = ".$row1['COD_CLIENT']." AND
       							DISTANCIA(P.LATITUDE,P.LONGITUDE,e.LATITUDE,e.LONGITUDE) < .2 ORDER BY DIS ASC LIMIT 1) AS PDI
							  
							  FROM  SAVL1120 f
							LEFT JOIN SAVL1141 e ON e.COD_ENTITY = f.COD_ENTITY
							LEFT JOIN SAVL1260 g ON e.COD_EVENT  = g.`COD_EVENT`
							WHERE e.COD_ENTITY = ".$row_loc['COD_ENTITY']."
							ORDER BY g.PRIORITY DESC LIMIT 1");
						
						
				 $count=mysql_num_rows($Q);
						if($count==1){
						while($row = mysql_fetch_array($Q)){
							
							if($row['ACTIVE']=='1'){
								if($row['PDI']!=''){
				$pdi=$row['PDI'];
				}else{
				$pdi="Sin PDI cercano";
				}
								
								
								
					$info_unit.="|".$row['COD_ENTITY']."!".$row['DESCRIPTION']."!".$row['GPS_DATETIME']."!".$row['DESC_EVT']."!".$row['LONGITUDE'].','.$row['LATITUDE']."!".$row['PRIORITY']."!".$row['ANGLE']."!".$row['BATTERY']."!".$pdi."!".$row['VELOCITY']."#".chr(13).chr(10)."";
							}
						}
						}else{
							$info_unit.="|".$row_loc['COD_ENTITY']."!"."NADA"."#".chr(13).chr(10)."";
							}
				}
				
			if (is_writable($name)) { 
				$gestor = fopen($name, 'w+');
				fwrite($gestor, $info_unit);
				 
				 fclose($gestor); 
				
				}else{
					$gestor = fopen($name, 'w+');
					fwrite($gestor, $info_unit);
					 fclose($gestor); 
				
					}
	
	}		

mysql_free_result($query1); 
mysql_free_result($querys); 
mysql_free_result($Q); 
mysql_close();
?>