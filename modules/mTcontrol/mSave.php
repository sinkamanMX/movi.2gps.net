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
$tabla = "";
$campo = "";
$data = Array();

if($_GET['typ']=='x' | $_GET['typ']=='z'){
	$data = Array(
		'DESCRIPCION'	=> $_GET['tit'],
		'ID_CLIENTE' 	=> $client
	);
	}
if($_GET['typ']=='y'){
	$data = Array(
		'DESCRIPCION'	=> $_GET['tit'],
		//'ID_CLIENTE' 	=> $client,
		'ID_EJE_Z'		=> $_GET['idz'],
		'ID_FUNCION'	=> $_GET['fun'],
		'PARAMETROS'	=> $_GET['par']
	);
	}


	if($_GET['typ']=='x'){
		//array_push($data,array('DESCRIPCION' => $_GET['tit'])); 
		$tabla = "CRM2_EJE_X";
		$campo = "ID_EJE_X"; 
		}
		
	if($_GET['typ']=='z'){
		$tabla = "CRM2_EJE_Z";
		$campo = "ID_EJE_Z";
		}

	if($_GET['typ']=='y'){
		$tabla = "CRM2_EJE_Y";
		$campo = "ID_EJE_Y";
		}
	//$data = Array(
		//	'DESCRIPTION'	=> $_GET['tit']
	//);
	
	if($_GET['op']==1){

		if($dbf-> insertDB($data,$tabla,true) == true){
			echo 1;
			}
		else{
			echo 0;
		}	
		
		
	}
	if($_GET['op']==2){
		$where = " ".$campo."  = ".$_GET['id'];
		if(($dbf-> updateDB($tabla,$data,$where,true)==true)){
			echo 1;
			}
		else{
			echo 0;
		}	
	}

?>