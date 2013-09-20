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

	$sql = "SELECT I.FECHA_ARRIBO, I.FECHA_SALIDA FROM DSP_ITINERARIO I WHERE I.ID_ENTREGA =".$_GET['punto'];
	$qry = $db->sqlQuery($sql);
	$row = $db->sqlFetchArray($qry);
	
	$da = ($row['FECHA_ARRIBO']=="0000-00-00 00:00:00")?date('Y-m-d H:i:s'):$row['FECHA_ARRIBO'];
	$ds = ($row['FECHA_SALIDA']=="0000-00-00 00:00:00")?date('Y-m-d H:i:s'):$row['FECHA_SALIDA'];

	if(isset($_GET['punto'])){
	$data = Array(
			'ID_ESTATUS'     	=> 5,
			'FECHA_ARRIBO'     	=> $da,
			'FECHA_SALIDA'     	=> $ds
	);
	$where = " ID_ENTREGA = ".$_GET['punto']; 
	if(($dbf-> updateDB('DSP_ITINERARIO',$data,$where,true)==true)){
		echo 1;
		//$cnt=$cnt+1;
		}
	//	}
	//echo $cnt;
	}
?>