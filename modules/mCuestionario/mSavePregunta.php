<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo silver 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          23-04-2012
**/
 
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
			echo '<script>window.location="index.php?m=login"</script>';
			
	$client   = $userAdmin->user_info['ID_CLIENTE'];

	//``````````````
	$data = Array(
			'ID_TIPO'		=> $_GET['typ'],
			'COD_CLIENT'   	=> $client,
			'DESCRIPCION'   => $_GET['tit'],
			'ACTIVO'  		=> $_GET['act'],
			'COMPLEMENTO'	=> $_GET['com'],
			'RECORDADO'   	=> $_GET['rec'],
			'REQUERIDO'   	=> $_GET['req']
	);
	if($dbf-> insertDB($data,'CRM2_PREGUNTAS',true) == true){
		echo 1;
		}
	else{
		echo 0;
		}	
?>