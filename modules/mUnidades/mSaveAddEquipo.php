<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
	//````
	$id_usuario = $userAdmin->user_info['ID_USUARIO'];
	$id_empresa = $userAdmin->user_info['ID_EMPRESA'];
	//````````````````
	$data = Array(
			'COD_TRADEMARK_MODEL'	=> $_GET['eqp_mod'],
			'COD_TYPE_ENTITY'   	=> $_GET['eqp_tip'],
			'COD_CLIENT'    		=> $userAdmin->user_info['ID_CLIENTE'],
			'DESCRIPTION'   		=> $_GET['eqp_des'],
			'PLAQUE'	    		=> $_GET['eqp_pla'],
			'BODYWORK_CODE'   		=> $_GET['eqp_ser'],
			'MOTOR_CODE'   			=> $_GET['eqp_mot'],
			'ID_EMPRESA'    		=> $id_empresa,
			'ACTIVE'				=> $_GET['eqp_status']
	);
	
	if($dbf-> insertDB($data,'ADM_UNIDADES',true) == true){
		//
		$sql = "SELECT LAST_INSERT_ID() AS ID";
		$qry = $db->sqlQuery($sql);
		$cnt = $db->sqlEnumRows($qry);
		if($cnt>0){
			$row = $db->sqlFetchArray($qry);
			$cod_entity = $row['ID'];
			$data_gpo = array(
			'ID_GRUPO'	=> $_GET['eqp_gpo'],
			'COD_ENTITY'   		=> $cod_entity,
			'FECHA_VIGENCIA'    => date('Y-12-31 23:59:59')
			);
			if($dbf-> insertDB($data_gpo,'ADM_GRUPOS_UNIDADES',true) == true){
				if($_GET['eqp_eqp']==""){
					echo 1;
				}else{
					$unis='';
					$exp = explode(",", $_GET['eqp_eqp']);
					for($x=0; $x < count($exp); $x++){
					if($unis==""){
						$unis="(".$exp[$x].",'".$cod_entity."')";
						}else{
							$unis.=",(".$exp[$x].",'".$cod_entity."')";
							}
				}
				$sql_c="INSERT INTO ADM_UNIDADES_EQUIPOS (COD_EQUIPMENT,COD_ENTITY) VALUES ".$unis;
					if($query_c = $db->sqlQuery($sql_c)){
						echo 1;
						}	
					}
			}
			else{
				echo -2;
				}
		}
		else{
			echo -1;
			}
		}
	else{
		echo 0;
		}	
?>	