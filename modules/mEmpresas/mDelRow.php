<?
/** * 
 *  @package             
 *  @name                elimina usuario.
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author             Rodwyn Moreno
 *  @modificado          2012-10-02
**/
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	$response = array('result' => 'no-data');
	if(isset($_GET['data'])){
		$id_row = $_GET['data'];
		$where  = " ID_EMPRESA = ".$id_row; 
		$delete = $dbf->deleteDB('ADM_EMPRESAS',$where,true);
		if($delete){
			$response = array('result' => 'delete');
		}else{
			$response = array('result' => 'problem');
		}
	}
	echo json_encode( $response );
?>