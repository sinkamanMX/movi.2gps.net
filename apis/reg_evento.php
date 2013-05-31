<?php

  $reg['respuesta']=0;
  $reg["imei"]=$_REQUEST["im"];
  $reg["lat"]=$_REQUEST["lat"];
  $reg["lon"]=$_REQUEST["lon"];
  $reg["alt"]=$_REQUEST["alt"];
  $reg["ang"]=$_REQUEST["ang"];
  $reg["vel"]=$_REQUEST["vel"];
  $reg["feh"]=$_REQUEST["feh"];
  $reg['cod_event']=$_REQUEST["cd_ev"];
  
  



  $base = mysql_connect("localhost",'savl','397LUP');
  if (!$base) {

    echo "Error de conexion \n";
  } else {  

    mysql_select_db("movilidad",$base);
	
	include("gps.php");
	
	$reg['cod_entity']=dame_cod_entity($reg);
	if ($reg['cod_entity']>0){
		  if (inserta_actualiza_1141($reg)){
		    $reg['cod_hist0']=inserta_hist00000($reg);
			if ($reg['cod_hist0']>0){
					echo "15";
			}else{
				echo "Error al escribir en HIST00000";
			}
		  }else{
			  echo "Error al escribir en 1141";
		  }
			
		}else{
	      echo "Error al buscar cod_entity";
	    }
	
	
    }

  
  
  
?>