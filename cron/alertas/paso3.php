<?
   
  //marca las entidades que tienen alertas el día de hoy, para que se evaluen solamente esas
  // se ejecuta cada 10 mins
  function dia($con){
    $sql = "SELECT DAYOFWEEK(CURRENT_TIMESTAMP) AS DIA";
    $qry = mysql_query($sql);
    $row = mysql_fetch_object($qry);
    switch ($row->DIA){
	  //domingo
	  case 1: 
		$campo = 'HORARIO_FLAG_DOMINGO';
	  break;
	  //lunes
	  case 2:
		$campo = 'HORARIO_FLAG_LUNES';
	  break;
	  //martes
      case 3:
		$campo = 'HORARIO_FLAG_MARTES';
	  break;
	  //miercoles
	  case 4:
		$campo = 'HORARIO_FLAG_MIERCOLES';
	  break;
	  //jueves
	  case 5:
		$campo = 'HORARIO_FLAG_JUEVES';
	  break;
	  //viernes
	  case 6:
		$campo = 'HORARIO_FLAG_VIERNES';
	  break;
	  //sabado
	  case 7:
		$campo = 'HORARIO_FLAG_SABADO';
	  break;
	  
	}
    mysql_free_result($qry);
    return $campo;
  }
  
  function libera_tablas($con){
    $res = false;
    $sql = "UPDATE SAVL1470 
            SET INICIO = '0000-00-00 00:00:00',
                FIN = '0000-00-00 00:00:00'
            WHERE CURRENT_TIMESTAMP NOT BETWEEN INICIO AND FIN";
    $res = mysql_query($sql);
    return $res;
  }
  
  function marca_tabla($entity,$con,$inicio,$fin){
    $sql = "UPDATE SAVL1470 
            SET INICIO = '".$inicio."',
                FIN = '".$fin."'
            WHERE COD_ENTITY = ".$entity;
    echo $sql;
    $res = mysql_query($sql);
  }
  
  function marca_tablas_usables($con){
    $columna = dia($con);
    $sql = "SELECT B.COD_ENTITY,
                    MIN(A.HORARIO_HORA_INICIO) AS HORARIO_HORA_INICIO,
                    MAX(A.HORARIO_HORA_FIN) AS HORARIO_HORA_FIN,
                    CURRENT_DATE AS DIA
             FROM ALERT_DETAIL_VARIABLES B
	           INNER JOIN ALERT_MASTER A ON A.COD_ALERT_MASTER = B.COD_ALERT_MASTER
             WHERE A.".$columna." = 1 AND
	               CURRENT_TIME BETWEEN A.HORARIO_HORA_INICIO AND  A.HORARIO_HORA_FIN
	         GROUP BY B.COD_ENTITY";
	echo $sql."<br>";
    if ($qry = mysql_query($sql)){
      while ($row = mysql_fetch_object($qry)){
        $inicio = $row->DIA." ".$row->HORARIO_HORA_INICIO;
        $fin = $row->DIA." ".$row->HORARIO_HORA_FIN;
        echo $inicio."<br>";
        marca_tabla($row->COD_ENTITY,$con,$inicio,$fin); 
      } 
      mysql_free_result($qry);
    }
  }
  
  $con = mysql_connect("188.138.40.249","sa","$0lstic3$");
  if ($con){
    $base2 = mysql_select_db("ALG_BD_CORPORATE_ALERTAS_MOVI",$con);
    marca_tablas_usables($con);
    libera_tablas($con);
    mysql_close($con);
  }
?>
