<?php
/**
* Evalua los datos para ir alimentando GEOLOC_WIFI,GEOLOC_LAI,GEOLOC_GCI
*/
/**
 * Datos de Conexion
 * 
*/
$Database = array(
	'port'  => '3306',			       //Puerto de la base de datos
	'host'  => '188.138.40.249',       //Host o ip donde se ubica la base de datos
	'bname' => 'ALG_BD_CORPORATE_GEOLOC',	           //Nombre  de la base de datos
	'user' 	=> 'savl',			       //usuario de la base de datos 
	'pass' 	=> '397LUP'			   //Contraseña de la base de datos
);

/**
 * Realiza la conexion Origen
 * */
$conexion = mysqli_connect( $Database['host'],
                            $Database['user'],
                            $Database['pass'],
                            $Database['bname']);

/**
* Inicia el proceso , validando la conexion
*/                            

if($conexion){
    /**
    * PROCESO PARA GEOLOC_LAI
    * */
    analizaGeocLaic();

    /**
    * PROCESO PARA GEOLOC_GCI
    * */    
    //analizaGeocGci();
    
    /**
    * PROCESO PARA WIFI
    * */    
    //analizaGeocWifi();    
    
}else{
    echo "<br> No se conecto a ninguna <br>";
}

function analizaGeocLaic(){
    global $conexion;   
    /**
     * Se buscan los registros no procesados
    */     
    $sqlControl="SELECT DISTINCT CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC) AS LAI
                 FROM GEOLOC_MEDCEL
                 WHERE GEOLOC_MEDCEL.PROCESADO='N' 
                 LIMIT 100";
    $queryControl = mysqli_query($conexion,$sqlControl);
    if($queryControl){
        while($rowControl = mysqli_fetch_object($queryControl)){
            
            $sqlLai="SELECT COUNT(1) AS CUENTA
                    FROM GEOLOC_LAI
                    WHERE GEOLOC_LAI.LAI='".$rowControl->LAI."'";
            if($queryLai = mysqli_query($conexion,$sqlLai)){
                $rowLai  = mysqli_fetch_object($queryLai);
                //Promedio de lai para lat y lon
                $dataLai = getMedCel($rowControl->LAI);
                $dataLai['IDLAI'] = $rowControl->LAI;
                if($rowLai->CUENTA > 0){
                    updateLai($dataLai,'update');
                }else{
                    updateLai($dataLai,'insert');
                }
            }else{
                echo "<br> Ocurrio un problema al ejecutar ".$sqlLai." <br>";
            }     
        }
        echo "<br> Se termino de ejecutar el proceso para MEDCEL <br>";
    }else{
        echo "<br> Problema al ejecutar el query control <br>";
    }                     
}

function getMedCel($lai){
    global $conexion;
    $response = Array();   
    /**
     * Se buscan el registro en base al campo LAI
    */     
    $sqlLai ="SELECT AVG(GEOLOC_MEDCEL.LATITUD) AS PROM_LATITUD,
                AVG(GEOLOC_MEDCEL.LONGITUD) AS PROM_LONGITUD
                FROM GEOLOC_MEDCEL
                WHERE CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC)='".$lai."'";
    if($queryLai = mysqli_query($conexion,$sqlLai)){
        $rowLai  = mysqli_fetch_object($queryLai);
        
        $response['LAT'] =  $rowLai->PROM_LATITUD;
        $response['LON'] =  $rowLai->PROM_LONGITUD;       
    }
    
    return $response;          
}

function updateLai($data,$operation){
    global $conexion;
   
    if($operation='insert'){
        $sqlUpdate="INSERT INTO GEOLOC_LAI 
                    SET LAI  = ".$data['IDLAI'].", 
				    LATITUD  = ".$data['LAT'].", 
				    LONGITUD = ".$data['LON'];
    }else{
        $sqlUpdate="UPDATE GEOLOC_LAI 
                    SET LATITUD  = ".$data['LAT'].",
                        LONGITUD = ".$data['LON']."
                    WHERE CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC)='".$data['IDLAI']."'";        
    }
                  
    $queryUpdate = mysqli_query($conexion,$sqlUpdate);
    if($queryUpdate){
        marcarProcesadoMedCel($data['IDLAI']);
    } 
}

function marcarProcesadoMedCel($lai){
    global $conexion;
    $sqlUpdate="UPDATE GEOLOC_MEDCEL 
                SET PROCESADO='L' 
                WHERE CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC)='".$lai."'";                  
    $queryUpdate = mysqli_query($conexion,$sqlUpdate);
}

function analizaGeocGci(){
    global $conexion;   
    /**
     * Se buscan los registros no procesados
    */     
    $sqlControl="SELECT DISTINCT CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC,GEOLOC_MEDCEL.CELLID) AS GCI
                 FROM GEOLOC_MEDCEL
                 WHERE GEOLOC_MEDCEL.PROCESADO='L'";
    $queryControl = mysqli_query($conexion,$sqlControl);
    if($queryControl){
        while($rowControl = mysqli_fetch_object($queryControl)){
           $sqlGci="SELECT COUNT(1) AS CUENTA
                    FROM GEOLOC_GCI
                    WHERE GEOLOC_GCI.GCI='".$rowControl->GCI."'";
           if($queryGci = mysqli_query($conexion,$sqlGci)){
                $rowGci  = mysqli_fetch_object($queryGci);
                
                $dataCgi = getMedCelCgi($rowControl->GCI);
                $dataCgi['GCI'] = $rowControl->GCI;
                if($rowGci->CUENTA > 0){
                    updateCgi($dataCgi,'update');
                }else{
                    updateCgi($dataCgi,'insert');
                }
            }else{
                echo "<br> Ocurrio un problema al ejecutar ".$sqlGci." <br>";
            }     
        }
        echo "<br> Se termino de ejecutar el proceso para CGI <br>";
    }else{
        echo "<br> Problema al ejecutar el query control CGI <br>";
    }      
}

function getMedCelCgi($cgi){
    global $conexion;
    $response = Array();   
    /**
     * Se buscan el registro en base al campo LAI
    */     
    $sql ="SELECT AVG(GEOLOC_MEDCEL.LATITUD) AS PROM_LATITUD,
                  AVG(GEOLOC_MEDCEL.LONGITUD) AS PROM_LONGITUD
           FROM GEOLOC_MEDCEL
           WHERE CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC,GEOLOC_MEDCEL.CELLID)='".$cgi."'";
    if($query = mysqli_query($conexion,$sql)){
        $row  = mysqli_fetch_object($query);
        
        $response['LAT'] =  $row->PROM_LATITUD;
        $response['LON'] =  $row->PROM_LONGITUD;       
    }
    
    return $response;          
}

function updateCgi($data,$operation){
    global $conexion;
   
    if($operation='insert'){
        $sqlUpdate="INSERT INTO GEOLOC_GCI 
                    GCI      = '".$data['GCI']."',
                    LATITUD  = ".$data['LAT'].", 
                    LONGITUD = ".$data['LON'];
    }else{
        $sqlUpdate="UPDATE GEOLOC_GCI 
                    SET LATITUD  = ".$data['LAT'].",
                        LONGITUD = ".$data['LON']."
                    WHERE  CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC,GEOLOC_MEDCEL.CELLID)='".$data['GCI']."'";        
    }
                  
    $queryUpdate = mysqli_query($conexion,$sqlUpdate);
    if($queryUpdate){
        marcarProcesadoCgi($data['GCI']);
    } 
}

function marcarProcesadoCgi($cgi){
    global $conexion;
    $sqlUpdate="UPDATE GEOLOC_MEDCEL 
                SET PROCESADO='G'
                WHERE PROCESADO='L'  AND 
                CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC,GEOLOC_MEDCEL.CELLID)= '".$cgi."'";                  
    $queryUpdate = mysqli_query($conexion,$sqlUpdate);
}

function analizaGeocWifi(){
    global $conexion;   
    /**
     * Se buscan los registros no procesados
    */     
    $sqlControl="SELECT DISTINCT MAC_ADD
                FROM GEOLOC_MEDWIFI
                WHERE PROCESADO = 'N'
                LIMIT 1000";
    $queryControl = mysqli_query($conexion,$sqlControl);
    if($queryControl){
        while($rowControl = mysqli_fetch_object($queryControl)){
           $sqlGci="SELECT COUNT(ID_WIFI) AS CUENTA
                    FROM GEOLOC_WIFI
                    WHERE MAC_ADD ='".$rowControl->MAC_ADD."'";
           if($queryGci = mysqli_query($conexion,$sqlGci)){
                $rowGci  = mysqli_fetch_object($queryGci);
                $dataWifi = getMedCelWifi($rowControl->MAC_ADD);
                $dataWifi['MAC'] = $rowControl->MAC_ADD;
                if($rowGci->CUENTA > 0){
                    updateWifi($dataWifi,'update');
                }else{
                    updateWifi($dataWifi,'insert');
                }
            }else{
                echo "<br> Ocurrio un problema al ejecutar ".$sqlGci." <br>";
            }   
        }
        echo "<br> Se termino de ejecutar el proceso para WIFI <br>";
    }else{
        echo "<br> Problema al ejecutar el query control WIFI <br>";
    }      
}

function getMedCelWifi($mac){
    global $conexion;
    $response = Array();   
    /**
     * Se buscan el registro en base al campo LAI
    */     
    $sql ="SELECT AVG(LATITUD)  AS PROM_LATITUD,
                  AVG(LONGITUD) AS PROM_LONGITUD
           FROM GEOLOC_MEDWIFI
           WHERE MAC_ADD ='".$mac."'";
    if($query = mysqli_query($conexion,$sql)){
        $row  = mysqli_fetch_object($query);
        
        $response['LAT'] =  $row->PROM_LATITUD;
        $response['LON'] =  $row->PROM_LONGITUD;       
    }
    
    return $response;     
}

function updateWifi($data,$operation){
    global $conexion;
   
    if($operation='insert'){
        $sqlUpdate="INSERT INTO GEOLOC_WIFI 
                    SET MAC_ADD = '".$data['MAC']."',                         
                    	LATITUD = ".$data['LAT'].",
                    	LONGITUD= ".$data['LON']; 
    }else{
        $sqlUpdate="UPDATE GEOLOC_WIFI 
                    SET LATITUD  = ".$data['LAT'].",
                        LONGITUD = ".$data['LON']."
                    WHERE MAC_ADD ='".$data['MAC']."'";        
    }                   
    $queryUpdate = mysqli_query($conexion,$sqlUpdate);
    if($queryUpdate){
        marcarProcesadoWifi($data['MAC']);
    } 
}

function marcarProcesadoWifi($mac){
    global $conexion;
    $sqlUpdate="UPDATE GEOLOC_MEDWIFI 
                SET PROCESADO='Y'
                WHERE PROCESADO='N'  AND 
                MAC_ADD = '".$mac."' ";                  
    $queryUpdate = mysqli_query($conexion,$sqlUpdate);
}