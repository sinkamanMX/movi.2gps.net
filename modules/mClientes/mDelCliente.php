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
	$where = " ID_CLIENTE = ".$_GET['cli_id'];
	$where2 = " COD_CLIENT = ".$_GET['cli_id'];  
	if($dbf->deleteDB('ADM_CLIENTES',$where,false)){
		$dbf->deleteDB('ADM_COMANDOS_CLIENTE',$where,false);
		$dbf->deleteDB('ADM_USUARIOS',$where,false);
		$dbf->deleteDB('ADM_UNIDADES',$where2,false);
		$dbf->deleteDB('ADM_EQUIPOS',$where,false);
		$dbf->deleteDB('ADM_PROTOCOLOS',$where,false);
		$dbf->deleteDB('ADM_GEOREFERENCIAS',$where,false);
		/* Falta agregar estos
			ADM_GRUPOS_CLIENTES
			ADM_PERFILES_CLIENTES
			ADM_SUBMENU_CLIENTES
		*/
		echo 1;
	}else{
		echo 0;
	}	
?>