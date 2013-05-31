<?php
/*
 *  @package             4TOGO
 *  @name                Obtiene las unidades a mostrar en el mapa
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          03/05/2011 
**/
	set_time_limit(0);
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
		
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
					
	$userID   	      = $userAdmin->user_info['COD_USER'];	
	$idCompany    = 0;
  	$cadena_envio = "";
    $id_unidad = "";

 
		$query_units_cli="SELECT a.COD_FLEET AS ID_GROUP,
					a.DESCRIPTION AS NAME_GROUP,
					b.COD_ENTITY, b.DESCRIPTION 
		FROM SAVL1220 a 
		INNER JOIN SAVL1120 b ON a.COD_FLEET=b.COD_FLEET 
		INNER JOIN SAVL1343 c ON c.COD_ENTITY=b.COD_ENTITY 
		ORDER BY b.DESCRIPTION ASC ";
									$queryQ  = $db->sqlQuery($query_units_cli);
									$count     = $db->sqlEnumRows($queryQ);
			//$rowU = $db->sqlFetchArray($queryQ);						
           
      

	  while($rowU = $db->sqlFetchArray($queryQ)){	

								if($cadena_envio == ""){
								  
                                   $cadena_envio = 	$rowU['ID_GROUP'].'|'.$rowU['NAME_GROUP'].'|'.$rowU['COD_ENTITY'].'|'.$userAdmin->codif($rowU['DESCRIPTION']);
							  
								}else{
								 $cadena_envio =  $cadena_envio .'!'.$rowU['ID_GROUP'].'|'.$rowU['NAME_GROUP'].'|'.$rowU['COD_ENTITY'].'|'.$userAdmin->codif($rowU['DESCRIPTION']);
							  
								}

	
	   }
  
  
  	echo $cadena_envio;
?>