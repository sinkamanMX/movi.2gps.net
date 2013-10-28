<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Ing. Rodwyn Moreno
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
		
	$db ->sqlQuery("SET NAMES 'utf8'");
	
	$emp = $userAdmin->user_info['ID_EMPRESA'];
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	

	$t = (isset($_GET['txt']))?$_GET['txt']:"";
	
	echo $qst = $dbf->dragndropF("ID_CUESTIONARIO","DESCRIPCION","CRM2_CUESTIONARIOS"," WHERE COD_CLIENT =".$cte,$_GET['pre'],$t,""," ORDER BY DESCRIPCION;");
//	$prg = $dbf->dragndropF("P.ID_PREGUNTA","P.DESCRIPCION","CRM2_PREGUNTAS P "," LEFT JOIN CRM2_CUESTIONARIO_PREGUNTAS CP ON CP.ID_PREGUNTA = P.ID_PREGUNTA WHERE ACTIVO=1 AND COD_CLIENT =".$cte,$_GET['pre'],$t,'ondblclick="form_preg(this.id,2)"'," GROUP BY P.ID_PREGUNTA ORDER BY CP.ORDEN;");

	
	
	/*$tpl->set_filenames(array('mCuestionarioS' => 'tCuestionarioS'));
	$tpl->assign_vars(array(
	'QST'      	=> $qst
	));	
	$tpl->pparse('mCuestionarioS');	*/
?>	