  <?php
  
  $stepProcess='';
  $conexion = mysql_connect("188.138.40.249","savl","397LUP");  
  if($conexion){
    $dataBase = mysql_select_db("ALG_BD_CORPORATE_MOVI",$conexion);
    
    echo "Paso 1 Inicia el proceso ... <br>";
    
    $sqlRespuestas = 'SELECT ID_RES_CUESTIONARIO,CADENA_CUANTITATIVO,CALIFICADO 
                       FROM CRM2_RESPUESTAS_CUANTITATIVO
                       WHERE CALIFICADO = 0';
    if ($queryRespuestas = mysql_query($sqlRespuestas,$conexion)){ 
        echo "Paso 2 - Hay preguntas sin calificar<br>";
		//echo "Paso 2 Se ejecuta el proceso ... <br>";        
		while ($rowRespuestas = mysql_fetch_object($queryRespuestas)){
            //echo "Cadena 1.- ".$rowRespuestas->CADENA_CUANTITATIVO."<br>";
            //  echo "<br>";
            $aCadena = explode("|", $rowRespuestas->CADENA_CUANTITATIVO);                          
            //echo "*****<br>";
            $sPreguntas = '';
            for($i=0;$i<count($aCadena);$i++){                     
                $sString = explode("¬", $aCadena[$i]);     
                if($sString[0]!=""){                               
                    $sPreguntas .= ($sPreguntas!="") ? ",": "";
                    $sPreguntas .= $sString[0];
                }
            }
                         
            $sqlValidate = "SELECT ID_PREGUNTA,RESPUESTA 
                            FROM CRM2_RESPUESTAS                       
                            INNER JOIN CRM2_PREG_RES  
                               ON CRM2_RESPUESTAS.ID_RES_CUESTIONARIO = CRM2_PREG_RES.ID_RES_CUESTIONARIO
                            WHERE CRM2_RESPUESTAS.ID_RES_CUESTIONARIO = ".$rowRespuestas->ID_RES_CUESTIONARIO.
                            "  AND CRM2_PREG_RES.ID_PREGUNTA IN (".$sPreguntas.")";
            if ($queryValidate = mysql_query($sqlValidate,$conexion)){
                while ($rowValidate = mysql_fetch_object($queryValidate)){
                    $registerAnswer = findIdQuestion($aCadena,$rowValidate->ID_PREGUNTA,$rowValidate->RESPUESTA);
                    
                    $updateCalificacion = "UPDATE CRM2_PREG_RES 
                                                SET CALIFICACION = ".$registerAnswer."
                                                WHERE ID_RES_CUESTIONARIO = ".$rowRespuestas->ID_RES_CUESTIONARIO."
                                                  AND ID_PREGUNTA         = ".$rowValidate->ID_PREGUNTA;                       
                    if ($queryCalificacion = mysql_query($updateCalificacion,$conexion)){                        
                        $updateCalificado = "UPDATE CRM2_RESPUESTAS_CUANTITATIVO SET CALIFICADO = 1
                                            WHERE ID_RES_CUESTIONARIO = ".$rowRespuestas->ID_RES_CUESTIONARIO;
                        if ($queryCCalificado = mysql_query($updateCalificado,$conexion)){
                            echo "ok <br>";
                        }else{
                            echo "No se pudo Marcar".$rowValidate->ID_PREGUNTA." ".$rowRespuestas->ID_RES_CUESTIONARIO."<br>";    
                        }
                    }else{
                        echo "No se pudo calificar ".$rowValidate->ID_PREGUNTA." ".$rowRespuestas->ID_RES_CUESTIONARIO."<br>";   
                    }           
                }
            }
            echo "<br>***********************************************<br> ";
        }
        echo "Paso 3 - Proceso terminado.<br>";
    }else{
        echo "No hay preguntas por calificar.";
    }
    mysql_close($conexion);
  }
  
    function findIdQuestion($aAnswers,$idQuestion,$answer){
        $sPreguntas = '';
        $validacion = 0;
        for($i=0;$i<count($aAnswers);$i++){                     
            $sString = explode("¬", $aAnswers[$i]);  
            if($idQuestion== $sString[0]){
                if($answer == $sString[1]){
                    $validacion = 1;
                }    
            }   
        }
        return $validacion;
    }