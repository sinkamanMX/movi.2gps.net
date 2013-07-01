<?
   
  //LIMPIA LAS TABLAS DE ENTIDAD QUE NO ESTAN EN USO
  // se ejecuta cada 8 hrs
  
  
  function optimiza_tabla($tabla,$con){
    $res = false;
    $sql = "OPTIMIZE TABLE ".$tabla;
    $res = mysql_query($sql);
    return $res;
  }
  
  function limpia_tabla($tabla,$con){
    $sql = "TRUNCATE TABLE ".$tabla;
    $res = mysql_query($sql);
  }
  
  function limpia_tablas_no_usables($con){
    //$columna = dia($con);
    $sql = "SELECT DESCRIPTION
             FROM SAVL1470
             WHERE INICIO = '0000-00-00 00:00:00' AND
                   FIN    = '0000-00-00 00:00:00'";
    if ($qry = mysql_query($sql)){
      while ($row = mysql_fetch_object($qry)){
        limpia_tabla($row->DESCRIPTION,$con);
        optimiza_tabla($row->DESCRIPTION,$con);
      } 
      mysql_free_result($qry);
    }
  }
  
  $con = mysql_connect("188.138.40.249","sa","$0lstic3$");
  if ($con){
    $base2 = mysql_select_db("ALG_BD_CORPORATE_ALERTAS_MOVI",$con);
    limpia_tablas_no_usables($con);
    mysql_close($con);
  }
?>
