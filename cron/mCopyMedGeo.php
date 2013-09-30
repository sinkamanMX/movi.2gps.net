<?php
/**
* Copia los registros de las antenas WIFI registradas 
*/
/**
 * Datos de Conexion
 * 
*/
$Database = array(
	'port'  => '3306',			       //Puerto de la base de datos
	'host'  => '188.138.40.249',       //Host o ip donde se ubica la base de datos
	'bname' => 'movilidad',	           //Nombre  de la base de datos
	'user' 	=> 'savl',			       //usuario de la base de datos 
	'pass' 	=> '397LUP',			   //Contraseña de la base de datos
    'bdname2'=> 'ALG_BD_CORPORATE_GEOLOC'
);

/**
 * Realiza la conexion Origen
 * */
$conexion = mysqli_connect( $Database['host'],
                            $Database['user'],
                            $Database['pass'],
                            $Database['bname']);

/**
 * Realiza la conexion Destino
 * */
$conexionGeo = mysqli_connect($Database['host'],
                            $Database['user'],
                            $Database['pass'],
                            $Database['bdname2']);
                            
                            
/**
* Inicia el proceso , validando las dos conexiones
*/                            

if($conexion && $conexionGeo){
    /**
     * Se copian los registros de WIFI
    */
    copyWifiRows();
    
    /**
     * Se copian los registros de GEO
    */    
    copyGeoRows();
    
}else{
    echo "<br> No se conecto a ninguna <br>";
}

function copyWifiRows(){
    global $conexion, $conexionGeo;
    /**
     * Se busca cual fue el ultimo id copiado
    */
    $sqlControl = 'SELECT ID_PK, ID_CONTROL
                   FROM TABLE_CONTROL_WIFI';
    $queryControl = mysqli_query($conexionGeo,$sqlControl);
    if($queryControl){
        $rowControl = mysqli_fetch_object($queryControl);
        
        $rowsWifi = getWifiRows($rowControl->ID_CONTROL);
        if(count($rowsWifi)>0){
              if(insertWifiRows($rowsWifi)){
                echo "<br> Se actualizaron los registros de wifi. <br>";
              }else{
                echo "<br> Hubo un problema al actualizar los registros de wifi. <br>";
              }  
        }else{
            echo "<br> Hubo un problema al actualizar los registros de wifi (NO-DATA). <br>";
        }        
        echo "<br> Termina el proceso WIFI. <br>";
    }else{
        echo "<br> Problema al ejecutar el query control <br>";
    }    
}

function getWifiRows($limitFrom=0){
    global $conexion, $conexionGeo;
    $aResult = Array();
    
    $sqlWifi = 'SELECT 	ID_MED, 
            	MAC_ADD, 
            	DBM, 
            	LATITUD, 
            	LONGITUD, 
            	PROCESADO            	 
            	FROM GEOLOC_MEDWIFI 
            	LIMIT '.$limitFrom.', 5000';  
    $queryWifi = mysqli_query($conexion,$sqlWifi);
    if($queryWifi){
        while($rowWifi = mysqli_fetch_array($queryWifi)){
             $aResult[] =  $rowWifi;    
        }
    }
    return $aResult;  
}

function insertWifiRows($aRowsWifi){
    global $conexion, $conexionGeo;
    $result= false;
    $last_id = 0;
    if(count($aRowsWifi)>0){        
        for($i=0;$i<count($aRowsWifi);$i++){
            $insertWifi = "INSERT INTO GEOLOC_MEDWIFI 
                        SET ID_MED      = ".$aRowsWifi[$i]['ID_MED'].", 
                            MAC_ADD     = '".$aRowsWifi[$i]['MAC_ADD']."',
                            DBM         = ".$aRowsWifi[$i]['DBM'].",
                            LATITUD     = ".$aRowsWifi[$i]['LATITUD'].",
                            LONGITUD    = ".$aRowsWifi[$i]['LONGITUD'].",
                            PROCESADO   = '".$aRowsWifi[$i]['PROCESADO']."' ";
            $queryWifi = mysqli_query($conexionGeo,$insertWifi);
            if($queryWifi){
                $last_id = $aRowsWifi[$i]['ID_MED'];
            }else{
                markError('WIFI',$insertWifi,$aRowsWifi[$i]['ID_MED']);
            }
        }
        
        if($last_id!=0){
            updateLastIdCopy($last_id,'TABLE_CONTROL_WIFI');
            $result = true;
        }
    }
    return $result;
}

function markError($origen,$cadena,$idMed){
    global $conexion, $conexionGeo;
   
    $sqlError = 'INSERT INTO CONTROL_ERROR (ORIGEN, SQL, ID)
                VALUES ("'.$origen.'","'.$cadena.'", '.$idMed.' )';  
    $queryError = mysqli_query($conexion,$sqlError);   
}

function updateLastIdCopy($idLastInsert,$table){
    global $conexion, $conexionGeo;
    
    $updateWifi = 'UPDATE '.$table.' SET ID_CONTROL = '.$idLastInsert;
    $queryUpdate = mysqli_query($conexionGeo,$updateWifi);   
    if(!$queryUpdate){
        echo mysqli_errno($conexion);
        echo mysqli_error($conexion);
    }
}


function copyGeoRows(){
    global $conexion, $conexionGeo;
    /**
     * Se busca cual fue el ultimo id copiado
    */
    $sqlControl = 'SELECT ID_PK, ID_CONTROL
                   FROM TABLE_CONTROL';
    $queryControl = mysqli_query($conexionGeo,$sqlControl);
    if($queryControl){
        $rowControl = mysqli_fetch_object($queryControl);
        
        $rowsGeo = getGeoRows($rowControl->ID_CONTROL);
        if(count($rowsGeo)>0){
              if(insertGeoRows($rowsGeo)){
                echo "<br> Se actualizaron los registros de GEO. <br>";
              }else{
                echo "<br> Hubo un problema al actualizar los registros de GEO. <br>";
              }  
        }else{
            echo "<br> Hubo un problema al actualizar los registros de GEO (NO-DATA). <br>";
        }        
        echo "<br> Termina el proceso GEO. <br>";
    }else{
        echo "<br> Problema al ejecutar el query control <br>";
    }    
}

function getGeoRows($limitFrom=0){
    global $conexion, $conexionGeo;
    $aResult = Array();
    
    $sqlGeo = 'SELECT 	ID_MED, 
                	MCC, 
                	MNC, 
                	LAC, 
                	CELLID, 
                	IF(DBM IS NULL,0,DBM) AS DBM, 
                	LATITUD, 
                	LONGITUD, 
                	PROCESADO
                FROM GEOLOC_MEDCEL 
            	LIMIT '.$limitFrom.', 5000';  
    $queryGeo = mysqli_query($conexion,$sqlGeo);
    if($queryGeo){
        while($rowGeo = mysqli_fetch_array($queryGeo)){
             $aResult[] =  $rowGeo;    
        }
    }
    return $aResult;  
}

function insertGeoRows($aRowsGeo){
    global $conexion, $conexionGeo;
    $result= false;
    $last_id = 0;
    if(count($aRowsGeo)>0){        
        for($i=0;$i<count($aRowsGeo);$i++){
            $insertGeo = "INSERT INTO GEOLOC_MEDCEL
                            SET     ID_MED     = ".$aRowsGeo[$i]['ID_MED'].", 
                        	       MCC         = '".$aRowsGeo[$i]['MCC']."',  
                        	       MNC         = '".$aRowsGeo[$i]['MNC']."', 
                        	       LAC         = '".$aRowsGeo[$i]['LAC']."',  
                        	       CELLID      = '".$aRowsGeo[$i]['CELLID']."', 
                        	       DBM         = ".$aRowsGeo[$i]['DBM'].", 
                        	       LATITUD     = ".$aRowsGeo[$i]['LATITUD'].", 
                        	       LONGITUD    = ".$aRowsGeo[$i]['LONGITUD'].", 
                        	       PROCESADO   = '".$aRowsGeo[$i]['PROCESADO']."' ";                            
            $queryGeo = mysqli_query($conexionGeo,$insertGeo);
            if($queryGeo){
                $last_id = $aRowsGeo[$i]['ID_MED'];
            }else{
                markError('GEO',$insertGeo,$aRowsGeo[$i]['ID_MED']);
            }
        }
        
        if($last_id!=0){
            updateLastIdCopy($last_id,'TABLE_CONTROL');
            $result = true;
        }
    }
    return $result;
}