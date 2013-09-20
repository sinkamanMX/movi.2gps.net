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
                ORDER BY CRM2_EJE_Z.ID_EJE_Z, CRM2_RESPUESTAS.ID_EJE_X";
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
                    $aEjeY[] = Array(id=> $row['ID_EJE_Y'], name=>$row['NAMEY']); 
                    $controlX=$row['ID_EJE_Y'];
                }
                
                $amatriz[] = $row;  
            }
            
            $result  = '<table id="rspTableDet" border="0" cellpadding="0" cellspacing="0" class="pretty">';
            $result .= '<thead><tr><th>Tecnologia</th><th>Area</th>';
            
            for($i=0;$i<count($aEjeX);$i++){
                $result .=  '<th>'.$aEjeX[$i][name].'</th>';
            }

            $result .= '</thead><tbody>';
            
            $controlX = 0;
            $controlY = 0;
            $controlZ = 0;
                
            for($i=0;$i<count($aEjeZ);$i++){                
                $result .= '<tr>';
                if($controlZ!=$aEjeZ[$i][id]){
                    $dataFilter  = findIdZ($aEjeZ[$i][id]);
                    $totalFilter = $dataFilter['total'];    

                    $result .= '<th rowspan="'.$totalFilter.'">'.$aEjeZ[$i][name].'</th>';
                    $result .= $dataFilter['datos'];                     
                    
                    $controlZ=$row['ID_EJE_Z'];
                }
                $result .= '</tr>';
            }
            $result .= '</tbody></table>';
        }else{
           $result = 'no-data-info'; 
        }
    }
    
    echo $result;
        
    function findIdZ($idIndex){
        global $aEjeY, $aEjeX,$amatriz;
        $result = array();
        
        for($i=0;$i<count($amatriz);$i++){
            if($amatriz[$i]['ID_EJE_Z']==$idIndex){
                $result[] = $amatriz[$i];
            }
        }
        
        $controlY = 0;
        $controlX = 0;
        
        for($i=0;$i<count($aEjeY);$i++){ 
            $controlY = $aEjeY[$i][id];
            $result2['datos'] = "<td>".$aEjeY[$i][name]."</td>";
            
            for($ix=0;$ix<count($aEjeX);$ix++){
                $controlX = $aEjeX[$ix][id];                               
                
                $resultXTotal = 0;
                $resultX      = 0;
                for($ir=0;$ir<count($result);$ir++){
                    if($result[$ir]['ID_EJE_Y'] == $controlY && $result[$ir]['ID_EJE_X'] == $controlX){
                        $resultXTotal++;
                        $resultX         += $result[$ir]['CALIFICACION'];
                    }
                }
                
                $promedio  = ($resultX*10) / $resultXTotal;
                
                $result2['datos'] .= "<td>".$promedio."</td>";
                $result2['total'] = $resultXTotal;    
            }
        }        
        return $result2;   
    }