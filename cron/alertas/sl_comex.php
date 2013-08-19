<?

   //require_once('./lib/nusoap.php'); 
   
   function envia_posiciones($imei,$eco,$gpsdate,$lon,$lat,$vel,$angulo,$ubicacion,$evento){
   	/*echo "entra a la funcion <br>";*/
    //$soap_client = new SoapClient("http://200.69.211.179/wsSimon/service.asmx?WSDL");
    //$soap_client = new SoapClient("http://200.78.219.208/UNGIS_Mapi/SOAP/Logistic/LogisticServices.asmx?WSDL");
    //http://200.78.219.208/UNGIS_Mapi/SOAP/Logistic/LogisticServices.asmx
    $param = array('SystemUser' => 'Tracker',
                   'Password' => 'kurtz',
                   'Dominio' => $imei,
                   'NroSerie' => $eco,
                   'Codigo' => $evento,
                   'Latitud' => $lat,
                   'Longitud' => $lon,
                   'Altitud' => 0,
                   'Velocidad' => $vel,
                   'FechaHoraEvento' => $gpsdate,
                   'FechaHoraRecepcion' => $gpsdate);
                   
    print_r($param);
    //$result=$soap_client->LoginYInsertarEvento($param);
	//echo '<br>:'.$result.'<br>';
    
    //echo debe devolver un 0 o mayor a 0 si el dato fue recibido, si hay algun problema manda -1  
    
  }

  	//$hourNow = date('Y-m-d h:i:s');
  	/*$now = getdate();
  	$hourPetition =strtotime( $now ) - 600;
  	echo $hourPetition;*/
	/*$hourNow = date("Y-m-d H:i:s");

	$date_return = $_POST['date_return']; //Returns a date like this 2007-05-25

	$hourPetition = mktime(date("Y", $hourNow), date("m", $hourNow), date("d", $hourNow)-1);  	
  	echo $hourPetition;*/
    /*Paso 1 hace peticion hacia el servicio de foresight*/
    $soap_client = new SoapClient("http://wsapps.foresightgps.com/SecureTrackServices.asmx?WSDL"); 
    /*arma arreglo con variables
     Falta una funcion que calcule la fecha con menos díez minutos y la mande en el formato
     YYYY-mm-ddThh:mm:ss la T es importante por que asi la toma como fecha ISO
    */
    $param = array('webServiceUsername' => 'comex',
                   'webServicePassword' => 'c0mex2013',
                   'fromDate' => '2013-07-25T16:24:00',
		           'groupName' => 'COMEX',
                   'ConnectionCode' => 'SateqMx');
    //print_r($param);
    /*toma el resultado*/
    $result=$soap_client->Get1000VehicleGroupHistoryFromDate($param);  
    //print_r($result);
    if (is_object($result)){  
      $x = get_object_vars($result);
      $str = $x[Get1000VehicleGroupHistoryFromDateResult];
      //parsea los valores que devuelve la peticion
      if (is_string($x[Get1000VehicleGroupHistoryFromDateResult]) and (strlen($x[Get1000VehicleGroupHistoryFromDateResult]) > 0)){
        //print_r ($result);    
        $str = str_replace('}]}}','',$str);
        $str = substr($str,67,strlen($str));
        $str = str_replace('},{','|',$str);
        $str = str_replace(', ',' ',$str);
        //
        
        $str = str_replace('{','',$str);
        $str = str_replace('":"','@',$str);
        $array_out = explode('|',$str);
        //print_r($array_out);
        $a = '';
        echo "Unidades a enviar: ".count($array_out);
        for($i = 0 ; $i < count($array_out) ; $i++){
          $a = explode(',',$array_out[$i]);
          $b='';
          $c='';
          for($x = 0 ; $x < count($a) ; $x++){
            if ($x == 0){
              $b = str_replace('"','',$a[$x]);
              $c = explode('@',$b);
              $eco = substr($c[1],-10); 
                    
            }
            if ($x == 1){
              $b = str_replace('"','',$a[$x]);
              $c = explode('@',$b);
              $gpsdate = $c[1]; 
              $gdate = substr($gpsdate,0,10);
              $gtime = substr($gpsdate,11,8);
              $gdiferencia = substr($gpsdate,20,2);
            }
            if ($x == 2){
              $b = str_replace('"','',$a[$x]);
              $c = explode('@',$b);
              $lon = $c[1];       
            }
            if ($x == 3){
              $b = str_replace('"','',$a[$x]);
              $c = explode('@',$b);
              $lat = $c[1];      
            }
            if ($x == 4){
              $b = str_replace('"','',$a[$x]);
              $c = explode('@',$b);
              $vel = $c[1];        
            }
            if ($x == 5){
              $b = str_replace('"','',$a[$x]);
              $c = explode('@',$b);
              $angulo = $c[1];         
            }
            if ($x == 6){
              $b = str_replace('"','',$a[$x]);
              $c = explode('@',$b);
              $ubicacion = utf8_decode($c[1]);         
            }
            if ($x == 10){
              $b = str_replace('"','',$a[$x]);
              $c = explode('@',$b);
              $evento = $c[1]; 
                  
            }
          }
		  //echo "<br><br>";
          //echo $eco." - ".$gpsdate." - ".$lon." - ".$lat." - ".$vel." - ".$angulo." - ".$ubicacion." - ".$evento."<br>";
          //echo "antes de invocar <br>";
          //envia las peticiones hacia el server de unigis-comex
          envia_posiciones($eco,$eco,$gpsdate,$lon,$lat,$vel,$angulo,$ubicacion,$evento);
          //guarda_posiciones($imei,$gdate,$gtime,$gdiferencia,$lon,$lat,$vel,$angulo,$ubicacion,$evento);
        }
        //echo $str;
      } else {
        echo "error: ".$str;
      } 
    }
  
  
?>

