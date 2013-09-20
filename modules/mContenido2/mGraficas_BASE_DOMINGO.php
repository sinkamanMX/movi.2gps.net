 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    
     var a1 = new Array('Ruta 33 - ECO 2e34 [ 50 entregas ]','Ruta 73 - ECO 22 [ 510 entregas ]')
     var a2 = new Array(10,90)   
	  
	  google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
	  
	  function drawChart() {
        
      //  
       
        for(a=0;a<2;a++){
        	         var data = google.visualization.arrayToDataTable([
			          ['Task', 'xxxxx'],
			          ['No Cumplidas',    a2[0]],
			          ['Cumplidas',     a2[1]]
			
			        ]);
			        var options = {
				         title: a1[a],
						  legend: {
				                    position: 'bottom'
				          }
				        };
				        
				    var g = new google.visualization.PieChart(document.getElementById('chart_div'+a));
        	            g.draw(data,  options);
						
						 //alert(a1.length);
        	        
        }
      }
    </script>
  </head>
  <body>
  
  <table border="1" style="border-collapse:collapse; border:#CCF;">
   <tr><td> <div id="chart_div0"  style="width: 300px; height: 200px; "></div></td>
       <td> <div id="chart_div1" style="width: 300px; height: 200px;"></div></td>
  </tr>
  </table>
      
      
      
      
  </body>
</html>


