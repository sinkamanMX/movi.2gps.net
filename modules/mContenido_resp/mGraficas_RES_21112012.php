 <?php
 
    //$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	//$userData = new usersAdministration(); //Nueva Instancia de Admin.
/*	
echo $_GET['dbh'];
echo $_GET['dbport'];
echo $_GET['dbname'];
echo $_GET['dbuser'];
echo $_GET['dbpass'];*/


$con = mysql_connect( $_GET['dbh'],$_GET['dbuser'],$_GET['dbpass']);
if (!$con)
  {
  die('falla en la conexion: ' . mysql_error());
  }

mysql_select_db($_GET['dbname'], $con);

 
  //$fecha = '2012-11-18';
  $fecha = date('Y-m-d');
  
  /*$sql ="   SELECT a.ID_DESPACHO,a.DESCRIPCION AS RUTA,b.COD_ENTITY AS UNIDAD,c.DESCRIPTION AS ECONOMICO   
			FROM DSP_DESPACHO a
			INNER JOIN DSP_UNIDAD_ASIGNADA b 
			ON a.ID_DESPACHO = b.ID_DESPACHO
			INNER JOIN SAVL1120 c
			ON b.COD_ENTITY = c.COD_ENTITY
			WHERE  a.FECHA_REAL_INICIO BETWEEN '".$fecha." 00:00:00' AND '".$fecha." 23:59:59'
			ORDER BY a.ID_DESPACHO";
			*/
			
$sql ="   SELECT a.ID_DESPACHO,a.DESCRIPCION AS RUTA,b.COD_ENTITY AS UNIDAD,c.DESCRIPTION AS ECONOMICO   
			FROM DSP_DESPACHO a
			INNER JOIN DSP_UNIDAD_ASIGNADA b 
			ON a.ID_DESPACHO = b.ID_DESPACHO
			INNER JOIN SAVL1120 c
			ON b.COD_ENTITY = c.COD_ENTITY
			WHERE  a.FECHA_REAL_INICIO BETWEEN a.FECHA_REAL_INICIO AND '".$fecha." 23:59:59'
			ORDER BY a.ID_DESPACHO";			
 
 	    /*
		 $query	 = $db->sqlQuery($sql);	
       	$total_despachos = $db->sqlEnumRows($query);
       	*/
       	$query	 = mysql_query($sql);	
       	$total_despachos = mysql_num_rows($query);
        $cadena ='';
       
	   // while( $row  = $db->sqlFetchArray($query)){
	    	while($row = mysql_fetch_array($query)){
			
/*	$sql2 ="SELECT a.ID_DESPACHO,a.DESCRIPCION,a.ITEM_NUMBER,b.COD_ENTITY,c.DESCRIPTION,d.COD_GEO,a.FECHA_REAL_INICIO,d.FECHA_ENTREGA,d.ID_ESTATUS 
			FROM DSP_DESPACHO a
			INNER JOIN DSP_UNIDAD_ASIGNADA b 
			ON a.ID_DESPACHO = b.ID_DESPACHO
			INNER JOIN SAVL1120 c
			ON b.COD_ENTITY = c.COD_ENTITY
			INNER JOIN DSP_ITINERARIO d
			ON a.ID_DESPACHO = d.ID_DESPACHO
			WHERE  a.FECHA_REAL_INICIO BETWEEN '".$fecha." 00:00:00' AND '".$fecha." 23:59:59'
			AND  a.ID_DESPACHO =".$row['ID_DESPACHO'];*/
			
	$sql2 ="SELECT a.ID_DESPACHO,a.DESCRIPCION,a.ITEM_NUMBER,b.COD_ENTITY,c.DESCRIPTION,d.COD_GEO,a.FECHA_REAL_INICIO,d.FECHA_ENTREGA,d.ID_ESTATUS 
			FROM DSP_DESPACHO a
			INNER JOIN DSP_UNIDAD_ASIGNADA b 
			ON a.ID_DESPACHO = b.ID_DESPACHO
			INNER JOIN SAVL1120 c
			ON b.COD_ENTITY = c.COD_ENTITY
			INNER JOIN DSP_ITINERARIO d
			ON a.ID_DESPACHO = d.ID_DESPACHO
			WHERE  a.FECHA_REAL_INICIO BETWEEN a.FECHA_REAL_INICIO AND '".$fecha." 23:59:59'
			AND  a.ID_DESPACHO =".$row['ID_DESPACHO'];		
			 
	 	   // $query2	 = $db->sqlQuery($sql2);	
	       	//$total_entregas = $db->sqlEnumRows($query2);
       	$query2	 = mysql_query($sql2);	
       	$total_entregas = mysql_num_rows($query2);
		   
		   	        
			 $entregados =0;
			 $no_entregados =0;
			 $total =0;
			 
		//	while( $row2  = $db->sqlFetchArray($query2)){
			while($row2 = mysql_fetch_array($query2)){	
			   $total++;
			  // echo '<br>----'.$row2['COD_GEO'].'----<br>';
			  
			    if($row2['ID_ESTATUS']!='3'){
			      $no_entregados++;
				}else{
				  $entregados++;	
				}	
			}
		   	if($cadena == ""){
		   		$cadena = $row['RUTA'].','.$row['ECONOMICO'].','.$entregados.','.$no_entregados.','.$total;
		   	}else{
		    	$cadena = $cadena .'@'.$row['RUTA'].','.$row['ECONOMICO'].','.$entregados.','.$no_entregados.','.$total;	
		   	}
		   	//$cadena = $row['RUTA'].','.$row['ECONOMICO'].','.$entregados.','.$no_entregados.','.$total;
			//echo "entregados=".$entregados." no entregados=".$no_entregados." de un total de =".$total.'<br>';
			
		}
 //echo $cadena.'<br>';
 
 mysql_close($con);
 ?>
 
 
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    
	 var cadena = ' <?php echo $cadena;?>'; 
	 var a1 = cadena.split('@'); 
	 
	  google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  
	  function drawChart() {
        for(a=0;a<a1.length;a++){
        	
        	var a2 = a1[a].split(',');
        	var tot_e = ((a2[2]*100)/a2[4]);
        	var tot_ne = ((a2[3]*100)/a2[4]);
        	
        	         var data = google.visualization.arrayToDataTable([
			          ['Task', 'xxxxx'],
			          ['Cumplidas',   tot_e],
			          ['No Cumplidas',  tot_ne]
			
			        ]);
			        var options = {
				          title: "Ruta: "+a2[0]+" - "+a2[1]+" ["+a2[4]+" Entregas]",
						  legend: {
				                    position: 'bottom'
				          }
				        };
				        
				    var g = new google.visualization.PieChart(document.getElementById('chart_div'+a));
        	            g.draw(data,  options);
						
						 //alert(a1[a]);
        	        
        }
      }
    </script>
  </head>
  <body>
 <?php 
for($div=0;$div<$total_despachos;$div++){
	echo '<div id="chart_div'.$div.'"  style="border:#CCF solid 1px; margin:2px; width: 300px; height: 200px; float:left;"></div>';	
}
 ?>     
  </body>
</html>


