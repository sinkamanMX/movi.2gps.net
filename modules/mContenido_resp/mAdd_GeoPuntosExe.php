<?php
/** * 
 *  @package             4togo_Pepsico.
 *  @name                Agrega GeoPuntos.
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Erick A. Calderón
 *  @modificado          12-08-2011 
**/

	//--------------------------- Modificada BD y Encabezado------------------------
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';  //Manda al login si no se ha Logeo.
	//--------------------------- Modificada BD y Encabezado------------------------
	
	$userID   	 = $userAdmin->user_info['COD_USER'];	
	$idCompany   = $userAdmin->user_info['COD_CLIENT'];
	$fecha = CURRENT_TIMESTAMP;

	$NAME	=$_GET['nombre'];
	$TYPE	=$_GET['tipo'];
	$NIP	=$_GET['nip']; 
	$RUTE	=$_GET['ruta']; 
	$RADIO	=$_GET['radio']; 
	$CALLE	=$_GET['calle'];
	$ESTADO =$_GET['estado'];
	$MUNICIPIO	=$_GET['municipio']; 
	$COLONIA =$_GET['colonia']; 
	$CP =$_GET['cp']; 
	$LATITUDE =$_GET['lat']; 
	$LONGITUDE =$_GET['lon']; 

	$sql = "INSERT INTO SAVL_G_PRIN 
			VALUES (13,".$userID.",'',".$TYPE.",".$idCompany.",CURRENT_TIMESTAMP,'".$NAME."','P','S','".$MUNICIPIO."','".$ESTADO."','".$COLONIA."','".$CALLE."',".$CP.",'','','','".$NIP."','',".$RADIO.",".$LONGITUDE.",".$LATITUDE.",'')";

	$query = $db->sqlQuery($sql);
	$row = $db->sqlFetchArray($query);
	
	if($query){
	   
        if($RUTE != 0){
	  
	   
        $sql_id 	= "SELECT LAST_INSERT_ID() as idp";
    		$query_id 	= $db->sqlQuery($sql_id);
    		$row_id 	= $db->sqlFetchArray($query_id);
    		
    		//Ultimo registro.
    		if($row_id['idp']  != ''){
				 $rutas = explode("|",$RUTE);
    			 $ultimate = $row_id['idp'];
    			for($r=0;$r<count($rutas);$r++){
					$sqlx = "INSERT INTO SAVL_ROUTES_DETAIL  
					VALUES (".$rutas[$r].",".$ultimate.",CURRENT_TIMESTAMP)";
					$queryx = $db->sqlQuery($sqlx);
					$rowx = $db->sqlFetchArray($queryx);
					echo 1;
				}
    
    			
    		
    		}else{
    			echo 0;  // Bye Ultimo registro.
    		}
                        
        }else{
            echo 1;
        }//fin Ruta
                            
	}else{
		echo 0;
	}


?>
