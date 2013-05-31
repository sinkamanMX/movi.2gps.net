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
					
	$userID   	      = $userAdmin->user_info['ID_USUARIO'];	
	$cliente    = $userAdmin->user_info['ID_CLIENTE'];
  	$cadena_envio = "";
	$cadena_envio2 = " ";
    $id_unidad = "";
	
	$div=$_GET['q'];
	$pxploid=explode('$cliente',$div);
	$num=count($pxploid);
	$cad='';
	if($num!=1){
		$cad=$pxploid[0].$cliente.$pxploid[1];
		}else{
			 $cad=$div;
			}
	
	$query_units_cli=$cad;
			$queryQ  = $db->sqlQuery($query_units_cli);
			$count     = $db->sqlEnumRows($queryQ);
		
	  while($rowU = $db->sqlFetchArray($queryQ)){	
	  
	  if($cadena_envio2==" "){
		$cadena_envio2=$rowU['ID'].','.$rowU['DESCRIPTION'];
	  }else{
			$cadena_envio2=$cadena_envio2.'|'.$rowU['ID'].','.$rowU['DESCRIPTION'];
	  }
	  
	   $cadena_envio=$cadena_envio.'<option value="'.$rowU['ID'].'">'.$rowU['DESCRIPTION'].'</option>';
	  
	  }
		echo $cadena_envio2.'?'.$cadena_envio;
	?>