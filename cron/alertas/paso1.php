<?
  //procesa los updates con los ultimos valores de la unidad
  // SE DEBE EJECUTAR CADA 10 SEG
  function borra_procesados($id,$con){
    $sql = "DELETE FROM ALERT_UPDATE_ENTITY WHERE ID = ".$id;
    $qry = mysql_query($sql);
  }
  
  function marca_procesados($instancia,$con){
    $sql = "UPDATE ALERT_UPDATE_ENTITY SET TABLA = '".$instancia."' WHERE TABLA IS NULL or TABLA = 0 LIMIT 200";
    echo $sql;
	$qry = mysql_query($sql);
  }
  
  function ejecuta_sentencia($sql,$con){
    $res = false;
    //echo $sql."<br>";
    if ($qry = mysql_query($sql)){
      //mysql_free_result($qry); 
      $res = true;
      //echo "si lo ejecuta";
    }
    return $res;
  }
  

  $con = mysql_connect("188.138.40.249","sa","$0lstic3$");
  if ($con){
    $base2 = mysql_select_db("ALG_BD_CORPORATE_ALERTAS_MOVI",$con);
	//Aparta los registros de la ejecucion
	$instancia = date("Y-m-d H:i:s");
	marca_procesados($instancia,$con);
	//lee los registros
	$sql = "SELECT ID,INSTRUCCION 
	          FROM ALERT_UPDATE_ENTITY
	          WHERE TABLA = '".$instancia."'";
	$qry = mysql_query($sql);
	while ($row = mysql_fetch_object($qry)){
	  ejecuta_sentencia($row->INSTRUCCION,$con); 
	  borra_procesados($row->ID,$con);
	}
    //mysql_close($base2);
    mysql_close($con);
  }
?>
