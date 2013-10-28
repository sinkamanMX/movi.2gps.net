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
		
	$emp = $userAdmin->user_info['ID_EMPRESA'];
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	
	$db ->sqlQuery("SET NAMES 'utf8'");
	
	$tpl->set_filenames(array('mFormulario_x' => 'tFormulario_x'));
	
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
		//SELECT DESCRIPCION,ID_EJE_Z FROM CRM2_EJE_Y WHERE ID_EJE_Y=12
		$tabla = "CRM2_EJE_Y";
		$campo = "ID_EJE_Y";
		}
	
	$sql = "SELECT * FROM ".$tabla." WHERE ".$campo." = ".$_GET['id'];
	$qry = $db->sqlQuery($sql);
	$row = $db->sqlFetchArray($qry);
	$idz = ($_GET['typ']=='y')?$row['ID_EJE_Z']:0;
	$eje_z =($_GET['typ']=='y')?$dbf->cbo_from_notit("ID_EJE_Z","DESCRIPCION","CRM2_EJE_Z"," ID_CLIENTE = ".$cte,$option=@$row['ID_EJE_Z']):'';
	//`````` 
	$fun = ($_GET['typ']=='y')?$dbf->cbo_from_notit("ID_FUNCION","DESCRIPCION","ADM_FUNCION"," ID_CLIENTE = ".$cte,$option=@$row['ID_FUNCION']):'';
	
	$dsp = ($_GET['typ']=='y')?'':'style="display:none;"';
		
	 
	
	$tpl->assign_vars(array(
			'OP'      	=> $_GET['op'],
			'ID'      	=> $_GET['id'],
			'DSC'      	=> $row['DESCRIPCION'],
			'PAR'      	=> $row['PARAMETROS'],
			'IDZ'      	=> $idz,
			'E_Z'      	=> $eje_z,
			'FUN'		=> $fun,
			'DSP'		=> $dsp
	));	
	


	$tpl->pparse('mFormulario_x');	
	

?>	