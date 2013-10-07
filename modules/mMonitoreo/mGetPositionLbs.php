<?php
/**
 *  @name                Obtiene las georeferencias a mostrar en el mapa
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          10/06/13
**/
    include('c.LocationBasedService.php');
	set_time_limit(0);
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

    $resultado = '';
    if(isset($_GET['MAC']) && isset($_GET['GCI']) && isset($_GET['LAI']) ){
        
    	$configBdLbs = array(
    		'port'  => '3306',			        //Puerto de la base de datos
    		'host'  => '188.138.40.249',		        //Host o ip donde se ubica la base de datos
    		'bname' => 'ALG_BD_CORPORATE_GEOLOC',	//Nombre  de la base de datos
    		'user' 	=> 'savl',			        //usuario de la base de datos 
    		'pass' 	=> '397LUP'			        //Contraseña de la base de datos
    	);    
           
        $iMac    = ($_GET['MAC']  !="" ) ? $_GET['MAC'] : 0;
        $iGci    = ($_GET['GCI'] !="" )  ? $_GET['GCI'] : 0;
        $iLai    = ($_GET['LAI'] !="" )  ? $_GET['LAI'] : 0;        
        
        $PosicionLbs =  new LocationBasedService();
        $PosicionLbs->setConfigBdParams($configBdLbs);
        $PosicionLbs->setConfigBdSpParams($config_bd_sp);
        $PosicionLbs->setLbsMac($iMac);
        $PosicionLbs->setLbsGCI($iGci);
        $PosicionLbs->setLbsLAI($iLai);
        
        $PocisionObtenida = $PosicionLbs->buscarPosicion();
        
        echo json_encode($PocisionObtenida);
    }else{
        echo $resultado = 'no-data';               
    }