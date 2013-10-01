<?php

 
  $base = mysql_connect("188.138.40.249",'savl','397LUP');
  if (!$base) {
    echo "Error de conexion \n";
  } else {  
     mysql_select_db("ALG_BD_CORPORATE_GEOLOC",$base);

    echo conectado." \n";	 

	 
	 // ***********************************PROCESO PARA GEOLOC_LAI******************************************************************
	 
	 $sql="SELECT CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC) AS LAI,
       			  AVG(GEOLOC_MEDCEL.LATITUD) AS LATITUD,
                  AVG(GEOLOC_MEDCEL.LONGITUD) AS LONGITUD
           FROM GEOLOC_MEDCEL
           WHERE GEOLOC_MEDCEL.PROCESADO='N'
           GROUP BY LAI LIMIT 10";
		   
		   
    echo "primer qry ".	$sql." \n";	   
	 
	 $query=mysql_query($sql);

     if ($query){
       while($row = mysql_fetch_assoc($query)){
		   
		    $sql_lai="SELECT COUNT(GEOLOC_LAI.LAI) AS CUENTA
						FROM GEOLOC_LAI
                        WHERE GEOLOC_LAI.LAI='".$row["LAI"]."'";
			echo $sql_lai;		
			$query_lai=mysql_query($sql_lai);
			$row_lai = mysql_fetch_row($query_lai);
            var_dump($row_lai);
			if($row_lai["CUENTA"]>0){
				
				 $sql_p_lai="SELECT AVG(GEOLOC_MEDCEL.LATITUD) AS PROM_LATITUD,
                              AVG(GEOLOC_MEDCEL.LONGITUD) AS PROM_LONGITUD
                       FROM GEOLOC_MEDCEL
                       WHERE CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC)='".$row["LAI"]."'";
				$query_p_lai=mysql_query($sql_p_lai);
			    $row_p_lai = mysql_fetch_row($query_p_lai);
				
				$sql_update_lai="UPDATE GEOLOC_LAI SET LATITUD=".$row_p_lai["PROM_LATITUD"].",
				                                       LONGITUD=".$row_p_lai["PROM_LONGITUD"].
								" WHERE CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC)='".$row["LAI"]."'";
			    $query_update=mysql_query($sql_update_lai);
				
				if($query_update){
				 $sql_update_medcell="UPDATE GEOLOC_MEDCEL SET PROCESADO='L' WHERE CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC)='".$row["LAI"]."'";
			     $$query_update_medcell=mysql_query($sql_update_medcell);
				}
			}else{
				
				$sql_insert_lai="INSERT INTO GEOLOC_LAI (
				ID_LAI,
  				LAI,
				LATITUD,
				LONGITUD) VALUES (
				0,
				'".$row["LAI"]."',
				".$row["LATITUD"].",
				".$row["LONGITUD"].")";
			    $query_insert=mysql_query($sql_insert_lai);
				
				if($query_insert){
				 $sql_update_medcell="UPDATE GEOLOC_MEDCEL SET PROCESADO='L' WHERE CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC)='".$row["LAI"]."'";
			     $$query_update_medcell=mysql_query($sql_update_medcell);
				}
			}
	   }
	 }
	 
	  // ***********************************PROCESO PARA GEOLOC_GCI*******************************************************************
	 /*
      echo "fin lai \n ";
	  $sql="SELECT CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC,GEOLOC_MEDCEL.CELLID) AS GCI,
	               CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC) AS LAI,
       			   AVG(GEOLOC_MEDCEL.LATITUD) AS LATITUD,
                   AVG(GEOLOC_MEDCEL.LONGITUD) AS LONGITUD
           FROM GEOLOC_MEDCEL
           WHERE GEOLOC_MEDCEL.PROCESADO='L'
           GROUP BY GCI";
	 
	 $query=mysql_query($sql);

     if ($query){
       while($row = mysql_fetch_assoc($query)){
		   
		    $sql_gci="SELECT COUNT(GEOLOC_GCI.GCI) AS CUENTA
						FROM GEOLOC_GCI
                        WHERE GEOLOC_GCI.GCI='".$row["GCI"]."'";
						
						
			echo 	$sql_gci;		
						
			$query_gci=mysql_query($sql_gci);
			$row_gci = mysql_fetch_row($query_gci);
			if($row_gci["CUENTA"]>0){
				
				 $sql_p_gci="SELECT AVG(GEOLOC_MEDCEL.LATITUD) AS PROM_LATITUD,
                              AVG(GEOLOC_MEDCEL.LONGITUD) AS PROM_LONGITUD
                       FROM GEOLOC_MEDCEL
                       WHERE CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC,GEOLOC_MEDCEL.CELLID)='".$row["GCI"]."'";
				$query_p_gci=mysql_query($sql_p_gci);
			    $row_p_gci = mysql_fetch_row($query_p_gci);
				
				$sql_update_gci="UPDATE GEOLOC_GCI SET LATITUD=".$row_p_gci["PROM_LATITUD"].",
				                                       LONGITUD=".$row_p_gci["PROM_LONGITUD"].
								" WHERE CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC,GEOLOC_MEDCEL.CELLID)='".$row["GCI"]."'";
			    $query_update=mysql_query($sql_update_gci);
				
				if($query_update){
				  $sql_update_medcell="UPDATE GEOLOC_MEDCEL SET PROCESADO='G' WHERE CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC,GEOLOC_MEDCEL.CELLID)='".$row["GCI"]."' AND PROCESADO='L' ";
			      $$query_update_medcell=mysql_query($sql_update_medcell);
				}
				
			}else{
				
		
				$sql_insert_gci="INSERT INTO GEOLOC_GCI (
				ID_GCI,
  				LAI,
				GCI,
				LATITUD,
				LONGITUD) VALUES (
				0,
				'".$row["LAI"]."',
				'".$row["GCI"]."',
				".$row["LATITUD"].",
				".$row["LONGITUD"].")";
			    $query_insert=mysql_query($sql_insert_gci);
				
				if($query_insert){
				  $sql_update_medcell="UPDATE GEOLOC_MEDCEL SET PROCESADO='G' WHERE CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC,GEOLOC_MEDCEL.CELLID)='".$row["GCI"]."' AND PROCESADO='L' ";
			      $$query_update_medcell=mysql_query($sql_update_medcell);
				}
			}
						
						
	   }
	   
	 }*/
	
	  echo "fin gci \n ";
	
	
  }
?>