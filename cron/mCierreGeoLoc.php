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
    
}else{
    echo "<br> No se conecto a ninguna <br>";
}

function analizaGeocLaic(){
    global $conexion;   
    /**
     * Se buscan los registros no procesados
    */     
    $sqlControl="SELECT CONCAT(GEOLOC_MEDCEL.MCC,GEOLOC_MEDCEL.MNC,GEOLOC_MEDCEL.LAC) AS LAI,
           			  AVG(GEOLOC_MEDCEL.LATITUD) AS LATITUD,
                      AVG(GEOLOC_MEDCEL.LONGITUD) AS LONGITUD
               FROM GEOLOC_MEDCEL
               WHERE GEOLOC_MEDCEL.PROCESADO='N'
               GROUP BY LAI LIMIT 10";
    $queryControl = mysqli_query($conexion,$sqlControl);
    if($queryControl){
        while($rowControl = mysqli_fetch_object($queryControl)){
            
            $sqlLai="SELECT COUNT(GEOLOC_LAI.LAI) AS CUENTA
                    FROM GEOLOC_LAI
                    WHERE GEOLOC_LAI.LAI='".$rowControl->LAI."'";
            if($queryLai = mysqli_query($conexion,$sqlLai)){
                $rowLai  = mysqli_fetch_object($queryLai);
                
                if($rowLai->CUENTA > 0){
                    $dataLai = getMedCel($rowControl->LAI);
                    $dataLai['IDLAI'] = $rowControl->LAI;
                    
                    updateLai($dataLai,'update');
                }else{
                    $dataLai['IDLAI']  = $rowControl->LAI;
                    $dataLai['LAT']    = $rowControl->LATITUD;
                    $dataLai['LON']    = $rowControl->LONGITUD;                    
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
