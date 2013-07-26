<?php
/** *              
 *  @name                Script que registra un comando
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
 *  @modificado          17-04-2013
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$id_row	= 0;
	$response = array('result' => 'no-data');
	if(isset($_GET['data']) && isset($_GET['comment']) && isset($_GET['unit'])){
		$id_row = $_GET['data']; 
		$comment= $_GET['comment'];
		$unit   = $_GET['unit'];
		
		$Comandos =  new cCommands();
		$Comandos->set_config_bd($config_bd);
		$Comandos->set_idcomando($id_row);
		$Comandos->set_usuario($userAdmin->user_info['ID_USUARIO']);
		$Comandos->set_comentario($comment);
		$Comandos->set_origen('movilidad');		
		
		$aunits = explode(",", $unit);
		$totalU = count($aunits);
		$totalok= 0;
		$totalp = 0;		
		for($i=0;$i<count($aunits);$i++){			
			$Comandos->set_unidad($aunits[$i]);
				
			$save = $Comandos->guarda_comando();
			
			if($save=='send'){
				$totalok++;
			}else{
				$totalp++;
			}						
		}

		if($totalok>0){
			$response = array('result' => 'send');	
		}else{
			$response = array('result' => 'problem');
		}								
	}
	echo json_encode( $response );
?>