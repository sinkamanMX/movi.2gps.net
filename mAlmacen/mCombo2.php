<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
		
	$db ->sqlQuery("SET NAMES 'utf8'");
	if($_GET['id']>0){
		$C2 = $dbf->cbo_from_string2("ID_PATRON_MEDIDA","DESCRIPCION","PED_PATRON_MEDIDA","ID_UNIDAD_MEDIDA = ".$_GET['id'],$option=$_GET['op']);
		echo '<select id="alm_c2" class="caja_stxt" >'.$C2.'</select>';
		}
	else{
		echo '';
		}	
	
?>	