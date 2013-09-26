<?php
/**  
 * Obtiene
 * @package dahsboard
 * @author	Enrique R. Peña Gonzalez
 * @since	2013-07-22
 */

$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
    $result  = 'no-data';
    $amatriz = Array();
     
    $aEjeX   = Array();
    $aEjeY   = Array();
    $aEjeZ   = Array();
    $cEjeZ   = Array();
    
    if(isset($_GET['idWeek']) && isset($_GET['idGeo'])){
        $idWeek = $_GET['idWeek'];
        $idGeo  = $_GET['idGeo'];
        
        
        $sql = "SELECT 	CRM2_RESPUESTAS.ID_CUESTIONARIO, CRM2_CUESTIONARIOS.DESCRIPCION AS DES, 
                	CRM2_RESPUESTAS.NUM_SEMANA, 
                	CRM2_EJE_Z.ID_EJE_Z,
                	CRM2_EJE_Z.DESCRIPCION AS NAMEZ,
                	CRM2_RESPUESTAS.ID_EJE_Y, 
                	CRM2_EJE_Y.DESCRIPCION AS NAMEY	,
                	CRM2_RESPUESTAS.ID_EJE_X,
                	CRM2_EJE_X.DESCRIPCION AS NAMEX,	
                	CRM2_RESPUESTAS.ID_RES_CUESTIONARIO,
                	CRM2_RESPUESTAS.CALIFICACION,
                	CRM2_RESPUESTAS.*
                FROM CRM2_RESPUESTAS
                INNER JOIN CRM2_CUESTIONARIOS ON CRM2_RESPUESTAS.ID_CUESTIONARIO =  CRM2_CUESTIONARIOS.ID_CUESTIONARIO
                LEFT JOIN CRM2_EJE_X ON CRM2_RESPUESTAS.ID_EJE_X = CRM2_EJE_X.ID_EJE_X
                LEFT JOIN CRM2_EJE_Y ON CRM2_RESPUESTAS.ID_EJE_Y = CRM2_EJE_Y.ID_EJE_Y
                LEFT JOIN CRM2_EJE_Z ON CRM2_EJE_Y.ID_EJE_Z      = CRM2_EJE_Z.ID_EJE_Z
                LEFT JOIN ADM_GEOREFERENCIA_RESPUESTAS ON CRM2_RESPUESTAS.ID_RES_CUESTIONARIO = ADM_GEOREFERENCIA_RESPUESTAS.ID_RES_CUESTIONARIO
                LEFT JOIN ADM_GEOREFERENCIAS ON ADM_GEOREFERENCIAS.ID_OBJECT_MAP = ADM_GEOREFERENCIA_RESPUESTAS.ID_OBJECT_MAP
                WHERE NUM_SEMANA = ".$idWeek."
                AND CRM2_CUESTIONARIOS.ID_TIPO      = 3
                AND CRM2_CUESTIONARIOS.COD_CLIENT   = ".$userAdmin->user_info['ID_CLIENTE']."
                AND ADM_GEOREFERENCIA_RESPUESTAS.ID_OBJECT_MAP = ".$idGeo."
                AND CRM2_EJE_Z.ID_EJE_Z IS NOT NULL
                ORDER BY  CRM2_RESPUESTAS.ID_EJE_X, CRM2_EJE_Y.ID_EJE_Y";
        $query = $db->sqlQuery($sql);
        $count = $db->sqlEnumRows($query);
        if($count>0){
            $controlX = 0;
            $controlY = 0;
            $controlZ = 0;            
                 
            while($row = $db->sqlFetchAssoc($query)){
                if($controlZ!=$row['ID_EJE_Z']){                    
                    $aEjeZ[] = Array(id=> $row['ID_EJE_Z'], name=>$row['NAMEZ']); 
                    $controlZ=$row['ID_EJE_Z'];
                }
                                  
                if($controlX!=$row['ID_EJE_X']){                    
                    $aEjeX[] = Array(id=> $row['ID_EJE_X'], idz=> $row['ID_EJE_Z'],name=>$row['NAMEX']); 
                    $controlX=$row['ID_EJE_X'];
                }
                
                if($controlY!=$row['ID_EJE_Y']){      
                    $aRes    = Array(id=> $row['ID_EJE_Y'], idz=> $row['ID_EJE_Z'], name=>$row['NAMEY']); 
                    $aEjeY[] = $aRes;
                    $controlY=$row['ID_EJE_Y'];
                }
                
                $amatriz[] = $row;
                  
            }
            //die();
            $result  = '<table id="rspTableDet" border="0" cellpadding="0" cellspacing="0" class="pretty">';
            $result .= '<thead><tr><th>Tecnologia</th><th>Area</th>';
            
            $controlXX = 0;            
            for($i=0;$i<count($aEjeX);$i++){
                if($controlXX != $aEjeX[$i][id]){
                    $result .=  '<th>'.$aEjeX[$i][name].'</th>';
                    $controlXX  = $aEjeX[$i][id];
                }                
            }

            $result .= '</thead><tbody>';
            
            $controlX = 0;
            $controlY = 0;
            $controlZ = 0;
                
            for($i=0;$i<count($aEjeZ);$i++){                
                $result .= '<tr>';                
                if($controlZ!=$aEjeZ[$i][id]){
                    if(!validateZ($aEjeZ[$i][id])){
                        $dataFilter  = findIdZ($aEjeZ[$i][id]); 
                        $result .= '<th rowspan="'.$totalFilter.'">'.utf8_encode($aEjeZ[$i][name]).'</th>';
                        $result .= $dataFilter;
                        
                        $controlZ=$row['ID_EJE_Z'];                        
                    }
                }
                $result .= '</tr>';
            }
            $result .= '</tbody></table>';
        }else{
           $result = 'no-data-info'; 
        }
    }
    
    echo $result;
    
    function validateZ($idIndex){
       global $cEjeZ;
       $respuesta = false;
       for($i=0;$i<count($cEjeZ);$i++){
            if($cEjeZ[$i]==$idIndex){
                $respuesta = true;
            }
       }
       return $respuesta;
    }    
        
    function findIdZ($idIndex){
        global $aEjeY, $aEjeX,$amatriz,$idWeek,$db,$cEjeZ;
        $cEjeZ[] = $idIndex;        
        $aFilterY = array();
        $sDatos   = '';
        for($i=0;$i<count($aEjeY);$i++){            
            if($aEjeY[$i][idz]==$idIndex){
                $aFilterY[] = $aEjeY[$i];
            }
        }
        
        $controlY = 0;
        $controlX = 0;
        
        for($i=0;$i<count($aFilterY);$i++){
            $sDatos = "<td>".utf8_encode($aFilterY[$i][name])."</td>";
            for($ix=0;$ix<count($aEjeX);$ix++){
                $sqlObtainR = "SELECT TRUNCATE( (( SUM(CRM2_PREG_RES.CALIFICACION) * 10 )/ COUNT(CRM2_PREG_RES.CALIFICACION))  ,2)  AS CALIFICA
                                FROM CRM2_PREG_RES
                                INNER JOIN CRM2_RESPUESTAS ON CRM2_PREG_RES.ID_RES_CUESTIONARIO = CRM2_RESPUESTAS.ID_RES_CUESTIONARIO
                                WHERE NUM_SEMANA = ".$idWeek." 
                                 AND ID_EJE_X    = ".$aEjeX[$ix][id]."
                                 AND ID_EJE_Y    = ".$aFilterY[$i][id];
                $query = $db->sqlQuery($sqlObtainR);
                $count = $db->sqlEnumRows($query);
                if($count>0){
                    $rowResult = $db->sqlFetchAssoc($query);
                    $sDatos  .= "<td>".$rowResult['CALIFICA']."</td>";
                }else{ 
                    $sDatos .= 'N/R'; 
                }
            }
        }
          
        return $sDatos;
    }