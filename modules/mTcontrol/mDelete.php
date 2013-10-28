<?
/** * 
 *  @package             
 *  @name                elimina usuario.
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author             Rodwyn Moreno
 *  @modificado          2012-10-02
**/

header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
if(!$userAdmin->u_logged())
			echo '<script>window.location="index.php?m=login"</script>';


	//Borrar pregunta
	$campo = "";
	$tabla = "";

	if($_GET['typ']=='x'){
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

$where = " ".$campo." = ".$_GET['id']; 
if($dbf->deleteDB($tabla,$where,true))	{
	echo 1;
	}
else{
	echo 0;
	}	

?>