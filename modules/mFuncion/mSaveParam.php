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
			
	$db ->sqlQuery("SET NAMES 'utf8'");			
			
	$client   = $userAdmin->user_info['ID_CLIENTE'];
	//`DESCRIPCION``TIPO``ADM_PARAMETRO`
	$data = Array(
			'DESCRIPCION'   => $_GET['des'],
			'TIPO'  		=> $_GET['typ'],
			'ID_FUNCION'	=> $_GET['idf']
	);

	if($_GET['op']==1){
		//``````````
	if($dbf-> insertDB($data,'ADM_PARAMETRO',true) == true){
		echo 1;
		}
	else{
		echo 0;
		}			
	}
	if($_GET['op']==2){
		$where = " ID_PARAMETRO  = ".$_GET['id'];
		if(($dbf-> updateDB('ADM_PARAMETRO',$data,$where,true)==true)){
			echo 1;
			}
		else{
			echo 0;
			}	
		}
?>