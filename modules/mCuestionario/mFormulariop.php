<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
		
	$emp = $userAdmin->user_info['ID_EMPRESA'];
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	
	//$tp = $dbf->cbo_from_notit("ID_TIPO","TIPO","CRM2_TIPO_PREG","",$option='');
	
	//$tms = $dbf->tabla_temas();
	//$prg = $dbf->qst_preguntas($cte);
	$idt = "";
	$com = "";
	$sql_m="SELECT ID_TIPO, TIPO,HTML FROM CRM2_TIPO_PREG WHERE ACTIVO = 1 ORDER BY ID_TIPO ";
	$query_m = $db->sqlQuery($sql_m);
	while($row_m = $db->sqlFetchArray($query_m)){
		$idt .= ($idt=="")?$row_m['ID_TIPO']:"|".$row_m['ID_TIPO'];
		$com .= ($com=="")?$row_m['HTML']:"|".$row_m['HTML'];
	$tpl->assign_block_vars('tipo',array(
		'TP'     => $row_m['TIPO'],
		'IDTP'   => $row_m['ID_TIPO']
	));	
	}

	//echo $com;

	
	
	$tpl->set_filenames(array('mFormulariop' => 'tFormulariop'));
	$tpl->assign_vars(array(
	//'TMS'      	=> $tms,
	//'PRG'      	=> $prg,
	//'T_P'      	=> $tp
	'IDT'      	=> $idt,
	'COM'      	=> $com,
	));	
	$tpl->pparse('mFormulariop');	
?>	