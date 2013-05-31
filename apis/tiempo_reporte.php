<?php

  $tiempo['imei'  ]=$_REQUEST["im"];

  function dame_tiempo($tiempo){
	global $base;
    $resultado =0;
	$sql = "SELECT TIME_REPORT_SEC
            FROM SAVL1120
            WHERE ITEM_NUMBER_UNITY='".$tiempo['imei']."'";
			
	//echo $sql;
	$qry = mysql_query($sql);
	if($qry){
      $row = mysql_fetch_object($qry);
	  $resultado = $row->TIME_REPORT_SEC;    
	  mysql_free_result($qry);
	}
	return $resultado;
  }
  
   $base = mysql_connect("localhost",'savl','397LUP');
  if (!$base) {
    echo "Error de conexion \n";
  }else{  
    mysql_select_db("movilidad",$base);
	
	$tiempo=dame_tiempo($tiempo);
	
	if($tiempo>0){
	  $tiempo=$tiempo/60;
		
	  echo $tiempo;
	}else{
	  echo "5";
	}

  }
  
?>