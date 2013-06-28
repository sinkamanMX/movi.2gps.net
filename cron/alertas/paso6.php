<?
  /*************** SAVL WEB   *****************************/
  /* SCRIPT: avl_revisa_politicas                         */
  /* BD: 192.168.6.45                                     */
  /* SERVER DE APLICACION: 192.168.6.140 - 4TOGO          */
  /* SE EJECUTA POR CRONTAB                               */
  /* FUNCION: Revisar las politicas de las alertas, con el
              fin de habilitar o inhabilitar las politicas 
			  a evaluar con la llegada de paquetes        */
  /* CREADO: 02 - 03 - 2011                               */
  /* AUTOR: CESAR SANCHEZ                                 */
  
  include 'lib/phpmailer.php';
  
  /*Funciones*/
  
  function marca_envio($id){
	/*marca inicio de proceso*/
    $sql = "DELETE FROM  ALERT_MAIL_NOTIFICATION WHERE COD_ALERT_NOTIFICATION = ".$id;
	$qry = mysql_query($sql);
  }
   
  
  function envia_mail_alerta($archivo,$destinatarios, $asunto, $mensaje){
	  $mail  = new PHPMailer();
	  $mail->IsSMTP(); // set mailer to use SMTP
	  $mail->Host 	 = "188.138.40.249"; // specify main and backup server
	  $mail->SMTPAuth  = true; // turn on SMTP authentication
	  $mail->Username  = "alertas@2gps.net"; // SMTP username
	  $mail->Password  = "4l3rt452695"; // SMTP password
	  $mail->From 	 = "alertas@2gps.net";
	  $mail->FromName  = "Alertas";
  	  $mail->Subject 	 = $asunto;
  	  $mail->Body 	 = $mensaje;
	  $mail->AddAttachment($archivo,'');
	  $dest = explode(';',$destinatarios);
	  $n = count($dest);
          for ($i=0; $i<$n; $i++){
            $mail->AddAddress($dest[$i],$dest[$i]);
	  }

	  //$mail->AddAddress($destinatarios,'');
	  $mail->AddAttachment($archivo,'');
	  $exito = $mail->Send();
          //Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho 
          //para intentar enviar el mensaje, cada intento se hara 5 segundos despues 
          //del anterior, para ello se usa la funcion sleep	
          $intentos=1; 
          while ((!$exito) && ($intentos < 2)) {
	    sleep(5);
	    //este error deberia guardarlo en un log
            echo $mail->ErrorInfo."/n \n";
            $exito = $mail->Send();
            $intentos=$intentos+1;	
          }
	  return $exito;
 	  //return $mail-> send() ? true:false;
	}


  /*programa*/
  
  //$base = mysql_connect("192.168.6.45",'savl_reportes','uda');
  $base = mysql_connect("localhost",'sa','$0lstic3$');
  if ($base){
    mysql_select_db("ALG_BD_CORPORATE_ALERTAS_MOVI",$base);
	/*BUSCA LAS ALERTAS A EVALUAR ACTIVAR*/
    $sql = "SELECT A.COD_ALERT_NOTIFICATION,
       		       A.EMAIL_SUBJECT,
       			   A.EMAIL_TEXT,
       			   A.FECHA_GENERADO,
				   A.LATITUDE,
				   A.LONGITUDE,
				   A.DESTINATARIOS
		FROM ALERT_MAIL_NOTIFICATION A
		WHERE A.PROCESADO = 'N' LIMIT 20";
	if ($qry = mysql_query($sql)) {
	  $existe = mysql_num_rows($qry);
	  if ($existe > 0){
		while ($row = mysql_fetch_object($qry)){
	      $id_notificacion = $row->COD_ALERT_NOTIFICATION;
		  $latitude = $row->LATITUDE;
		  $longitude = $row->LONGITUDE;
		  //$asunto = $row->NAME_ALERT.' de la unidad '.$row->EMAIL_SUBJECT;
		  $asunto = $row->EMAIL_SUBJECT;
		  $mensaje = $row->EMAIL_TEXT;
          //$asunto = str_replace('de la unidad',' de la unidad ',$asunto);
          //$mensaje = str_replace('de la unidad',' de la unidad ',$mensaje);
          //$mensaje = str_replace('en la Geocerca',' en la Geocerca ',$mensaje); 
          $mensaje = $mensaje." , el dia: ".$row->FECHA_GENERADO;
		  if (strlen($mensaje) == 0){
            $mensaje = $asunto." , el dia: ".$row->FECHA_GENERADO;
          }
          //$emails = dame_correo($id_alerta);
          $emails = $row->DESTINATARIOS;
          echo "\n /n...".$asunto." destino:  ".$emails."\n";
          // $ress = Send_Email($smtp,'Alertas SAVL',"alertas@grupouda.com.mx",$emails.",csanchez@airlogisticsgps.com",$asunto,$mensaje);
          $emails = str_replace(',',';',$emails);
          $emails = str_replace(' ','',$emails);
          $emails = $emails.";csanchez@airlogisticsgps.com";
          echo "corregido...".$asunto." destino:  ".$emails."\n";
          if (strlen($emails) > 0){
		    //https://maps.google.com/?q=42.501845+-5.73967
			$mensaje = $mensaje.'. Ver en el mapa: https://maps.google.com/?q='.urlencode($latitude.' '.$longitude);
            if (envia_mail_alerta('',$emails, $asunto, $mensaje)){
		      //marca como enviado
			  marca_envio($id_notificacion);
		    }
          }
		}
	  }
	  mysql_free_result($qry);
	}
	mysql_close($base);
  }
  

?>
