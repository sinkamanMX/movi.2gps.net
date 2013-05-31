<?php

  $pre["cuestionario"]=$_REQUEST["cu"];
  $pre["vendedor"]=$_REQUEST["vn"];
  $pre["so"]=$_REQUEST["so"];
  $pre["lat"]=$_REQUEST["lat"];
  $pre["lon"]=$_REQUEST["lon"];
  $pre["feh"]=$_REQUEST["feh"];


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


  function inserta_respuestas($reg){
	global $base;
    $resultado =0;
    $sql="INSERT INTO CRM2_RESPUESTAS (ID_RES_CUESTIONARIO,
						  ID_CUESTIONARIO,
						  COD_USER,
						  FECHA,
                          LATITUD,
                          LONGITUD) 
	             VALUES (0,
						 ".$reg['cuestionario'].",
						 ".$reg['vendedor'  ].",
						 '".$reg['feh']."',
						 ".$reg['lat'  ].",
						 ".$reg['lon'  ].")";
	$gene=mysql_query($sql);
    if ($gene){
	  $resultado= mysql_insert_id();
	}
    return $resultado;
  }

  $base = mysql_connect("localhost",'savl','397LUP');
  if (!$base) {
    echo "Error de conexion \n";
  } else {  
    mysql_select_db("movilidad",$base);
	
	
	$p=inserta_respuestas($pre);
	
	if($p>0){
		echo $p;
	}else{
		echo "0";
	}
  }
?>