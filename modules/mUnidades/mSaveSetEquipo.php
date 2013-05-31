<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	$data = Array(
			'COD_TRADEMARK_MODEL'	=> $_GET['eqp_mod'],
			'COD_TYPE_ENTITY'   	=> $_GET['eqp_tip'],
			'DESCRIPTION'   		=> $_GET['eqp_des'],
			'PLAQUE'   				=> $_GET['eqp_pla'],	
			'BODYWORK_CODE'    		=> $_GET['eqp_ser'],
			'MOTOR_CODE'   			=> $_GET['eqp_mot'],
			'ACTIVE'				=> $_GET['eqp_status']
	);
	$where = " COD_ENTITY  = ".$_GET['eqp_id'];
	if(($dbf->updateDB('ADM_UNIDADES',$data,$where,true)==true)){
		$dbf->deleteDB('ADM_GRUPOS_UNIDADES',$where);
		$data_gpo = array(
			'ID_GRUPO'	 => $_GET['eqp_gpo'],
			'COD_ENTITY' => $_GET['eqp_id']
			);
		$where_gpo = " COD_ENTITY  = ".$_GET['eqp_id'];
		if($dbf->insertDB($data_gpo,'ADM_GRUPOS_UNIDADES',true)){
			if($_GET['eqp_eqp']==""){
				echo 1;
			}else{
					$unis='';
					$exp = explode(",", $_GET['eqp_eqp']);
					for($x=0; $x < count($exp); $x++){
					if($unis==""){
						$unis="(".$exp[$x].",'".$_GET['eqp_id']."')";
						}else{
							$unis.=",(".$exp[$x].",'".$_GET['eqp_id']."')";
							}
			}
			$sql_d = "DELETE FROM ADM_UNIDADES_EQUIPOS WHERE COD_ENTITY = ".$_GET['eqp_id'];
			if($query_d = $db->sqlQuery($sql_d)){
				$sql_c = "INSERT INTO ADM_UNIDADES_EQUIPOS (COD_EQUIPMENT,COD_ENTITY) VALUES ".$unis;
				if($query_c = $db->sqlQuery($sql_c)){
					echo 1;
					}	
				}
			}
		}
	}else{
		echo 0;
	}	
?>	