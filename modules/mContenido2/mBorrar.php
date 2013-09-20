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
/*$userData = new usersAdministration();
if( !$userData-> u_logged())
    echo '<script>window.location="index.php?mod=login&act=default"</script>';*/

	if(isset($_GET['punto'])){
	//$cnt=0;
	//$exp = explode(",", $_GET['elementos']);	

	//for($x=0; $x < count($exp); $x++){
	$where = " ID_ENTREGA = ".$_GET['punto']; 
	if($dbf->deleteDB('DSP_ITINERARIO',$where,true))	{
		echo 1;
		//$cnt=$cnt+1;
		}
	//	}
	//echo $cnt;
	}
?>