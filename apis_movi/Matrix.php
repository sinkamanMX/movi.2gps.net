<?php

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
                }else  return $a;
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

    function array_type($array){
        if (is_array($array)){
             $next = 0;
             $return_value = "vector";  // we have a vector until proved otherwise
             foreach ($array as $key => $value){
                 if ($key != $next){
                     $return_value = "map";  // we have a map
                     break;
                 }
                 $next++;
             }
             return $return_value;
        }
        return false;    // not array
    }

    function utf8_encode_array($array){
        if (is_array($array)){
            $result_array = array();
            foreach($array as $key => $value){
                if (array_type($array) == "map"){
                    // encode both key and value
                    if (is_array($value)){
                        // recursion
                        $result_array[utf8_encode($key)] = utf8_encode_array($value);
                    }else{
                        // no recursion
                        if (is_string($value)){
                            $result_array[utf8_encode($key)] = utf8_encode($value);
                        }else{
                            // do not re-encode non-strings, just copy data
                            $result_array[utf8_encode($key)] = $value;
                        }
                    }
                }else if (array_type($array) == "vector"){
                    //encode value only
                    if (is_array($value)) {
                        // recursion
                        $result_array[$key] = utf8_encode_array($value);
                    }else{
                        // no recursion
                        if (is_string($value)){
                            $result_array[$key] = utf8_encode($value);
                        }else{
                            //do not re-encode non-strings, just copy data
                            $result_array[$key] = $value;
                        }
                    }
                }
            }
            return $result_array;
        }
        return false;     // argument is not an array, return false
    }

     function existe_equipo_app($app,$imei){
         $result = -1;
         $sql ="SELECT COUNT(1) AS EXISTE
                FROM ADM_MATRIX
                WHERE IMEI='".$imei."' AND
                APLICACION='".$app."'";
         if ($qry = mysql_query($sql)){
             $row = mysql_fetch_object($qry);
             if ($row->EXISTE > 0){
                 $result = $row->EXISTE;
             }
             mysql_free_result($qry);
         }
         return $result;
    }
	
     function verifica_equipo_app($app,$imei){
        $result = "Sin registro de servidor";
        $cuenta=0;
        $con = mysql_connect("localhost","savl_movi","fr4de3");
        if (!$con){
            return "Error de conexión al verificar el equipo en matrix";
        }else{
            $base = mysql_select_db("ALG_BD_MATRIX",$con);
            $sql ="SELECT ADM_SERVIDORES.URL_SCRIPT,
                         ADM_SERVIDORES.IP_FTP,
                         ADM_SERVIDORES.USUARIO_FTP,
                         ADM_SERVIDORES.CONTRASENA_FTP
                   FROM  ADM_MATRIX
                   INNER JOIN ADM_SERVIDORES ON ADM_SERVIDORES.ID_SERVIDOR=ADM_MATRIX.SERVIDOR
                   WHERE ADM_MATRIX.IMEI='".$imei."' AND
                         ADM_MATRIX.APLICACION='".$app."'";
             if ($qry = mysql_query($sql)){
                while($e=mysql_fetch_assoc($qry)){
                    $output[]=utf8_encode_array($e);
                    $cuenta++;
                }
            }
            if($cuenta>0){
                $result = json_encode($output);
            }else{
                $result = "Sin Servidores disponibles";
            }
            return $result;
        }
    }

    function inserta_matrix($imei,$servidor,$app,$ver,$marca,$modelo){
        $resultado =0;
        $sql="INSERT INTO ADM_MATRIX (
                     IMEI,
                     SERVIDOR,
                     APLICACION,
                     VERSION,
                     MARCA,
                     MODELO,
                     FECHA_CREADO) 
              VALUES (
                      '".$imei."',
                      ".$servidor.",
                      '".$app."',
                      '".$ver."',
                      '".$marca."',
                      '".$modelo."',
                      CURRENT_TIMESTAMP)";
        $gene=mysql_query($sql);
        if($gene){
            $resultado= 1;
        }
        return $resultado;
    }
	
    function actualiza_matrix($servidor,$ver,$imei,$app){
        $resultado = 0;
        $sql = "UPDATE ADM_MATRIX SET
                       SERVIDOR =".$servidor.",
                       VERSION ='".$ver."'
                       WHERE IMEI='".$imei."' AND
                             APLICACION='".$app."'";	
        $qry = mysql_query($sql);
        if($qry){
            $resultado = 1;
        } 
        return $resultado;
    }

    function matrix_($imei,$servidor,$app,$ver,$marca,$modelo){
        $con = mysql_connect("localhost","savl_movi","fr4de3");
        if (!$con){
            return "Error de conexion de matrix";
        }else{
            $base = mysql_select_db("ALG_BD_MATRIX",$con);
            $resultado="Sin intento de registro";
            if(existe_equipo_app($app,$imei)>0){
                if(actualiza_matrix($servidor,$ver,$imei,$app)>0){
                    $resultado="OK";
                }else{
                    $resultado="Error al actualizar Matrix";
                }
            }else{
                if(inserta_matrix($imei,$servidor,$app,$ver,$marca,$modelo)>0){
                     $resultado="OK";
                }else{
                    $resultado="Error al insertar Matrix";
                }
            }
            return $resultado;
        }
    }

    function servidores(){ 
        $con = mysql_connect("localhost","savl_movi","fr4de3");
        if (!$con){
            return "Error de conexion al obtener el servidor de matrix";
        }else{
            $base = mysql_select_db("ALG_BD_MATRIX",$con);
            $sql="SELECT ID_SERVIDOR, 
                         DESCRIPCION,
                         URL_SCRIPT,
                         IP_FTP,
                         USUARIO_FTP,
                         CONTRASENA_FTP
                  FROM ADM_SERVIDORES";
            $query=mysql_query($sql);
            $cuenta=0;
            if ($query){
                while($e=mysql_fetch_assoc($query)){
                    $output[]=utf8_encode_array($e);
                    $cuenta++;
                }
            }
            if($cuenta>0){
                return json_encode($output);
            }else{
                return "Sin Servidores disponibles";
            }
        }
    }
    if($_REQUEST['fun'] == 'servidores'){
        echo servidores();
    }

    if($_REQUEST['fun'] == 'matrix'){
        echo matrix_($_REQUEST["imei"],$_REQUEST["servidor"],$_REQUEST["app"],$_REQUEST["ver"],$_REQUEST["marca"],$_REQUEST["modelo"]);
    }	

    if($_REQUEST['fun'] == 'matrix_v'){
        echo verifica_equipo_app($_REQUEST["app"],$_REQUEST["imei"]);
    }

?>