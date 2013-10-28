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

 
  //
  //$fecha = '2012-11-20';
  $fecha = date('Y-m-d');
  
	     	$sql2 ="SELECT L.*,N.COD_CLIENT 
					FROM DSP_ITINERARIO L 
  					INNER JOIN DSP_DESPACHO M ON L.ID_DESPACHO = M.ID_DESPACHO 
   					INNER JOIN DSP_UNIDAD_ASIGNADA U ON U.ID_DESPACHO = M.ID_DESPACHO
  					INNER JOIN ADM_UNIDADES N ON N.COD_ENTITY = U.COD_ENTITY
	        		WHERE CURRENT_DATE BETWEEN CAST(M.FECHA_INICIO AS DATE)  AND CAST(M.FECHA_FIN AS DATE)
        			AND N.COD_CLIENT = ".$_GET['CLI']."
            		ORDER BY ID_DESPACHO, ID_ESTATUS";	
			 

       	$query2	 = mysql_query($sql2);	
        $total_entregas = mysql_num_rows($query2);
		   
		   	        
			 $entregados =0;
			 $no_entregados =0;
			 $total =0;
			 

			while($row2 = mysql_fetch_array($query2)){	
			   
			  // echo '<br>----'.$row2['COD_GEO'].'----<br>';
			    $total++;
			    if($row2['ID_ESTATUS']!='3'){
			      $no_entregados++;
				}else{
				  $entregados++;	
				}	
			}
	
		   		$cadena = 'X,Y,'.$entregados.','.$no_entregados.','.$total;
		   	
			
		
// echo $cadena.'<br>';
 
 mysql_close($con);
 ?>
 
 
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    
	 var cadena = ' <?php echo $cadena;?>'; 
	// var a1 = cadena.split('@'); 
	 
	  google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  
	  function drawChart() {
       // for(a=0;a<a1.length;a++){
        	
        	var a2 = cadena.split(',');
        	var tot_e = ((a2[2]*100)/a2[4]);
        	var tot_ne = ((a2[3]*100)/a2[4]);
        	
        	         var data = google.visualization.arrayToDataTable([
			          ['Task', 'xxxxx'],
			          ['Cumplidas :'+a2[2],   tot_e],
			          ['No Cumplidas:'+a2[3],  tot_ne]
			
			        ]);
			        var options = {
				          title: "Total de Entregas a Realizar [ "+a2[4]+" ]",
						  legend: {
				                    position: 'bottom'
				          }
				        };
				        
				    var g = new google.visualization.PieChart(document.getElementById('chart_div'));
        	            g.draw(data,  options);
						
						 //alert(a1[a]);
        	        
        //}
      }
    </script>
  </head>
  <body>
 <?php 
//for($div=0;$div<$total_despachos;$div++){
//	echo '<div id="chart_div'.$div.'"  style="border:#CCF solid 1px; margin:2px; width: 300px; height: 200px; float:left;"></div>';	
//}

echo '<div id="chart_div"   style="border:#CCF solid 1px; margin-left:10%; width: 450px; height: 450px; float:left;"></div>';	
 ?>     
  </body>
</html>


