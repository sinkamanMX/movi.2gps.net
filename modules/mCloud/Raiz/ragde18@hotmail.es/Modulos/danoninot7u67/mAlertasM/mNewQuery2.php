<?php
/*
 *  @package             4TOGO
 *  @name               Query de Modificacion de Variables alerta
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author            Edgar Sanabria
 *  @modificado          03/05/2011 
**/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
					
	$userID   	      = $userAdmin->user_info['COD_USER'];	
	$cliente    = $userAdmin->user_info['COD_CLIENT'];
  	$cadena_envio = "";
    $id_unidad = "";
	$cs='0';
	
	$div=$_GET['q'];

		$row1 = $Positions-> prob_nom($cliente ,$div);
		
		echo $row1;
	?>