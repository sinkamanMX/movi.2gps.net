<?php
/*
 *  @package             4TOGO
 *  @name               Query de Modificacion de Variables alerta
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author            Edgar Sanabria
 *  @modificado          03/05/2011 
**/
	set_time_limit(0);
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
		
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
					
	$userID   	      = $userAdmin->user_info['COD_USER'];	
	$cliente    = 0;

	
	$div=$_GET['q'];

	 $quers="DELETE FROM ALERT_MASTER WHERE COD_ALERT_MASTER IN (".$div.")";
	 $query_units=$Positions->elim_alertas($quers);
	
		
	if( $query_units==1){ 
	$quers1="DELETE FROM ALERT_DETAIL_VARIABLES WHERE COD_ALERT_MASTER IN (".$div.")";
	 $query_units1=$Positions->elim_alertas($quers1);
			if($query_units1==1){
				echo $na='Alerta Borrada Correctamente';
				}else{
				echo $na='No se borraron Unidades';
				}
	}else{
	echo $na='No se borro alerta';
	}
		
	?>