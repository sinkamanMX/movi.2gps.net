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
	
	$id;
	
	$t =( $_GET['tip']=="PUB")?0:$client;
	
	
	$data = Array(
			'NOMBRE'		=> $_GET['nom'],
			'DESCRIPCION'   => $_GET['des'],
			'FUNCION'    	=> $_GET['fun'],
			'TIPO'  		=> $_GET['tip'],
			'ID_CLIENTE'	=> $t
	);
	//$prs = $_GET['par'];

	if($_GET['op']==1){
		
	if($dbf-> insertDB($data,'ADM_FUNCION',true) == true){
		echo 1;
		$id = last_id();
		pars($_GET['par'],$id);
		}
	else{
		echo 0;
		}			
	}
	if($_GET['op']==2){
		$id = $_GET['id'];
		$where = " ID_FUNCION  = ".$id;
		if(($dbf-> updateDB('ADM_FUNCION',$data,$where,true)==true)){
			echo 1;
			pars($_GET['par'],$id);
			}
		else{
			echo 0;
			}	
		}
function last_id(){
	global $db;
	$sql = "SELECT LAST_INSERT_ID() AS ID";
		$qry = $db->sqlQuery($sql);
		$cnt = $db->sqlEnumRows($qry);
		$row = $db->sqlFetchArray($qry);
		$id  = ($cnt>0)?$row['ID']:0;
		return $id;
	}		
function pars($p,$id){
	global $db;
	
	$pars = explode(',',$p);
	
	
	for($i=0; $i<count($pars); $i++){
		$sql = "UPDATE ADM_PARAMETRO SET ID_FUNCION= ".$id." WHERE ID_PARAMETRO = ".$pars[$i];	
		if($qry = $db->sqlQuery($sql)){
			echo 2;
			}
		else{
			echo -1;
			}	
		}	
	
	}	
?>