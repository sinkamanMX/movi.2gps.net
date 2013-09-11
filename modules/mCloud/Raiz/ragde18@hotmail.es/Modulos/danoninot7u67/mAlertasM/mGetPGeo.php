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
	$idCompany    = $userAdmin->user_info['COD_CLIENT'];
  	$cadena_envio = "";
    $id_unidad = "";

 
		$query_units_cli="SELECT a.ID_GROUP,a.NAME_GROUP,b.COD_ENTITY FROM SAVL1220_G a 
									INNER JOIN SAVL1220_GDET b ON
									a.ID_GROUP = b.ID_GROUP WHERE a.COD_CLIENT=".$idCompany." GROUP BY ID_GROUP";
									$queryQ  = $db->sqlQuery($query_units_cli);
									$count     = $db->sqlEnumRows($queryQ);
			//$rowU = $db->sqlFetchArray($queryQ);						
           
      

	  while($rowU = $db->sqlFetchArray($queryQ)){	
		  
	             
			if($cadena_envio == ""){
								  
                                   $cadena_envio = 	$rowU['ID_GROUP'].'|'.$rowU['NAME_GROUP'];
							  
				}else{
								 $cadena_envio =  $cadena_envio .'!'.$rowU['ID_GROUP'].'|'.$rowU['NAME_GROUP'];
							  
			}
			
	
	   }
  
  
  	echo $cadena_envio;
?>