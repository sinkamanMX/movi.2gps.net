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
$where = " ID_TIPO = ".$_GET['id']; 
if($dbf->deleteDB('ADM_GEOREFERENCIAS_TIPO',$where,true))	{
	echo 1;
	}
else{
	echo 0;
	}	

?>