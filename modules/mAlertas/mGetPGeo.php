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
					
	$userID   	      =  $userAdmin->user_info['ID_USUARIO'];	
	$idCompany    = $userAdmin->user_info['ID_CLIENTE'];
  	$cadena_envio = "";
    $id_unidad = "";

 
		$query_units_cli="SELECT b.ID_GRUPO,
										a.NOMBRE
											FROM ADM_GRUPOS a
										INNER JOIN ADM_USUARIOS_GRUPOS b ON a.ID_GRUPO = b.ID_GRUPO
										WHERE b.ID_USUARIO=".$userID." GROUP BY b.ID_GRUPO";
									$queryQ  = $db->sqlQuery($query_units_cli);
									$count     = $db->sqlEnumRows($queryQ);
			//$rowU = $db->sqlFetchArray($queryQ);						
           
      

	  while($rowU = $db->sqlFetchArray($queryQ)){	
		  
	             
			if($cadena_envio == ""){
								  
                                   $cadena_envio = 	$rowU['ID_GRUPO'].'|'.$rowU['NOMBRE'];
							  
				}else{
								 $cadena_envio =  $cadena_envio .'!'.$rowU['.ID_GRUPO'].'|'.$rowU['NOMBRE'];
							  
			}
			
	
	   }
  
  
  	echo $cadena_envio;
?>