<?php
  $vn["cu"]=$_REQUEST["cu"];
  $vn["so"]=$_REQUEST["so"];

  // Sólo si la funcion no existe, entonces la crea
if (!function_exists('json_encode')){
    function json_encode($a=false){
        if (is_null($a)) return 'null';
        if ($a === false) return 'false';
        if ($a === true) return 'true';
        if (is_scalar($a)){
            if (is_float($a)){
                // Siempre usa "." para floats.
                return floatval(str_replace(",", ".", strval($a)));
            }
            if (is_string($a)){
                static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
                return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
            }else
              return $a;
        }

        $isList = true;
        for ($i = 0, reset($a); $i < count($a); $i++, next($a)){
            if (key($a) !== $i){
                $isList = false;
                break;
            }
        }

        $result = array();

        if ($isList){
            foreach ($a as $v) $result[] = json_encode($v);
            return '[' . join(',', $result) . ']';
        }else{
            foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
            return '{' . join(',', $result) . '}';
        }

    }

}


  $base = mysql_connect("localhost",'savl','397LUP');
  if (!$base) {
    echo "Error de conexion \n";
  } else {  
    mysql_select_db("movilidad",$base);
	
	
	
	$sql="SELECT CRM2_VENDEDOR_CUESTIONARIO.ID_CUESTIONARIO,
                 CRM2_VENDEDOR_CUESTIONARIO.ORDEN,
                 CRM2_VENDEDOR_CUESTIONARIO.COD_USER,
                 CRM2_CUESTIONARIOS.DESCRIPCION
         FROM    CRM2_VENDEDOR_CUESTIONARIO
         INNER JOIN CRM2_CUESTIONARIOS ON CRM2_CUESTIONARIOS.ID_CUESTIONARIO = CRM2_VENDEDOR_CUESTIONARIO.ID_CUESTIONARIO
         WHERE   CRM2_VENDEDOR_CUESTIONARIO.COD_USER=".$vn["cu"]." 
	     ORDER BY CRM2_VENDEDOR_CUESTIONARIO.ORDEN";
	   

	   
    $query=mysql_query($sql);

    if($vn["so"]=="android"){
	  if ($query){
        while($e=mysql_fetch_assoc($query)){
          $output[]=$e;
	    }
	  }
	   echo json_encode($output);
	}

	if($vn["so"]<>"android"){
     header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
      header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
      header("Cache-Control: no-cache, must-revalidate" );
      header("Pragma: no-cache" );
      header("Content-Type: text/xml; charset=utf-8");
      $XML = '<?xml version="1.0"?>';
      $XML .= "<ROOT>";
	  $xml_output = "<?xml version=\"1.0\"?>"; 
      $xml_output .= "<entries>" ; 
      for($x = 0 ; $x < mysql_num_rows($query) ; $x++){ 
        $row = mysql_fetch_assoc($query); 
        $xml_output .= "<registro>"; 
	    $xml_output .= "<idcuestionario>" . $row['ID_CUESTIONARIO'] . "</idcuestionario>"; 
        $xml_output .= "<orden >" . $row['ORDEN'] . "</orden>"; 
		$xml_output .= "<idvcu>" . $row['COD_USER'] . "</idcu>"; 
        $xml_output .= "</registro>"; 
      } 
      $xml_output .= "</entries>"; 
      echo $xml_output;
	}
  }
  mysql_close();
?>