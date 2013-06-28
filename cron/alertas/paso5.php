<?
  //borra la tabla de ALERT_HISTORY para mantener la BD pequeña
  //EJECUTARLO CADA HORA
  $con = mysql_connect("localhost","sa","$0lstic3$");
  if ($con){
    $base2 = mysql_select_db("ALG_BD_CORPORATE_ALERTAS_MOVI",$con);
	//lee las unidades pendientes de tabla
	$sql = "TRUNCATE TABLE ALERT_HISTORY";
	$qry = mysql_query($sql);
	$sql = "OPTIMIZE TABLE ALERT_HISTORY";
	$qry = mysql_query($sql);
    //mysql_close($base2);
    mysql_close($con);
  }
?>
