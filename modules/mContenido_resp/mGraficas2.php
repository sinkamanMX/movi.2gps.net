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
 // $fecha = '2012-11-20';
  $fecha = date('Y-m-d');
  
			
 $sql2 ="SELECT a.ID_DESPACHO,c.COD_ENTITY,a.DESCRIPCION AS DES ,a.ITEM_NUMBER,c.DESCRIPTION,a.FECHA_INICIO,a.FECHA_FIN,a.FECHA_REAL_INICIO,a.FECHA_REAL_FIN,
			COUNT(b.COD_ENTITY) AS VISITAR,SUM(d.VOLUMEN) AS VOLUMEN,SUM(d.DISTANCIA) AS DISTANCIA,
			TIMEDIFF(a.FECHA_FIN ,a.FECHA_INICIO) AS TIEMPO1,
IF(a.FECHA_REAL_FIN = '0000-00-00 00:00:00',TIMEDIFF(CURRENT_TIMESTAMP,a.FECHA_REAL_INICIO),TIMEDIFF(a.FECHA_REAL_FIN,a.FECHA_REAL_INICIO)) AS TIEMPO2
			
			FROM DSP_DESPACHO a 
			INNER JOIN DSP_UNIDAD_ASIGNADA b ON a.ID_DESPACHO = b.ID_DESPACHO 
			INNER JOIN ADM_UNIDADES c ON b.COD_ENTITY = c.COD_ENTITY 
			INNER JOIN DSP_ITINERARIO d ON a.ID_DESPACHO = d.ID_DESPACHO 
			INNER JOIN ADM_USUARIOS k ON a.COD_USER = k.ID_USUARIO
		    WHERE  IF(a.FECHA_REAL_INICIO = '0000-00-00 00:00:00',a.FECHA_INICIO,a.FECHA_REAL_INICIO) 
		    BETWEEN IF(a.FECHA_REAL_INICIO = '0000-00-00 00:00:00',a.FECHA_INICIO,a.FECHA_REAL_INICIO)
			AND CURRENT_TIMESTAMP  
			AND a.ID_DESPACHO = ".$_GET['cod_entity'];		
			 

       	$query2	 = mysql_query($sql2);	
        $total_entregas = mysql_num_rows($query2);
        $row2 = mysql_fetch_array($query2);
        $visitados = cumplidos($row2['ID_DESPACHO'],$row2['COD_ENTITY']);
		$total	=
			   
			  // echo '<br>----'.$row2['COD_GEO'].'----<br>';
			   	
		   		$cadena = $row2['DESCRIPCION'].','.$row2['ITEM_NUMBER'].','.$visitados.','.($row2['VISITAR']-$visitados).','.$row2['VISITAR'];
		   	
			
		
 //echo $cadena.'<br>';
 

 
 
 function cumplidos($despacho,$unidad){

$conx = mysql_connect( $_GET['dbh'],$_GET['dbuser'],$_GET['dbpass']);
if (!$conx)
  {
  die('falla en la conexion: ' . mysql_error());
  }

mysql_select_db($_GET['dbname'], $conx);	
	$sql =" SELECT a.ID_DESPACHO,a.DESCRIPCION,a.ITEM_NUMBER,b.COD_ENTITY,c.DESCRIPTION,d.COD_GEO,a.FECHA_REAL_INICIO,d.FECHA_ENTREGA,d.ID_ESTATUS 
FROM DSP_DESPACHO a 
INNER JOIN DSP_UNIDAD_ASIGNADA b ON a.ID_DESPACHO = b.ID_DESPACHO 
INNER JOIN ADM_UNIDADES c ON b.COD_ENTITY = c.COD_ENTITY 
INNER JOIN DSP_ITINERARIO d ON a.ID_DESPACHO = d.ID_DESPACHO 
WHERE   d.ID_ESTATUS  = 3 AND a.ID_DESPACHO =".$despacho." AND b.COD_ENTITY =".$unidad;
 
 	  
	   /*  $query	 = $db->sqlQuery($sql);	
       	$count   = $db->sqlEnumRows($query);
       	*/
       	$query	 = mysql_query($sql);	
        $count = mysql_num_rows($query);
 mysql_close($conx);
 	
	return $count;
}
 
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
				          title: " ",
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

echo '<div id="chart_div"   style="border:#CCF solid 1px; margin-left:25%; width: 300px; height: 250px; float:left;"></div>';	
 ?>     
  </body>
</html>


