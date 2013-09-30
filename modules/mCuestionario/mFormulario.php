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
	
	$emp = $userAdmin->user_info['ID_EMPRESA'];
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	
	 function ex_qry($id,$tbl,$w){
		global $db;
		$lp = "";
		$sql = "SELECT ".$id." AS ID FROM ".$tbl.$w;
		$qry = $db->sqlQuery($sql);
		$cnt = $db->sqlEnumRows($qry);
		if($cnt>0){
			while($row = $db->sqlFetchArray($qry)){
				$lp .= ($lp=="")?$row['ID']:",".$row['ID'];
				}
			}
		return($lp);	
		}
	
	$tpl->set_filenames(array('mFormulario' => 'tFormulario'));
	
	$id = ( $_GET['cuestionario']!="")?$_GET['cuestionario']:"";
	
	$qst = ( $_GET['cuestionario']!="")?$dbf->getRow('CRM2_CUESTIONARIOS','ID_CUESTIONARIO = '.$_GET['cuestionario']):"";
	
	$tit = ( $_GET['cuestionario']!="")?@$qst['DESCRIPCION']:"";
	
	$tma = ( $_GET['cuestionario']!="")?@$qst['TEMA']:"";
	
	$typ = ( $_GET['cuestionario']!="")?@$qst['ID_TIPO']:"";
	
	$mlv = ( $_GET['cuestionario']!="")?@$qst['MULTIPLES_RESPUESTAS']:"";
	
	$ofv = ( $_GET['cuestionario']!="")?@$qst['OFFLINE']:"";
	
	$x = ( $_GET['cuestionario']!="" && @$qst['ID_EJE_X']!="")?@$qst['ID_EJE_X']:0;
	
	$y = ( $_GET['cuestionario']!="" && @$qst['ID_EJE_Y']!="")?@$qst['ID_EJE_Y']:0;

	$grz = ( $_GET['cuestionario']!="" && $x!=0)?$dbf->getRow('CRM2_EJE_Y','ID_EJE_Y = '.$y):0;

	$z = ( $_GET['cuestionario']!="" && @$grz['ID_EJE_Z']!="")?@$grz['ID_EJE_Z']:0;
	
	if( $_GET['cuestionario']!=""){
		$mul = (@$qst['MULTIPLES_RESPUESTAS']!="")?'checked="checked"':"";
		$off = (@$qst['OFFLINE']!="")?'checked="checked"':"";
		$lps = ex_qry("ID_PREGUNTA"," CRM2_CUESTIONARIO_PREGUNTAS "," WHERE ID_CUESTIONARIO = ".$_GET['cuestionario']." ORDER BY ORDEN");
		$lpd = ($lps!="")?ex_qry("ID_PREGUNTA"," CRM2_PREGUNTAS "," WHERE COD_CLIENT = ".$cte." AND ID_PREGUNTA NOT IN (".$lps.") GROUP BY ID_PREGUNTA ORDER BY DESCRIPCION "):'';
		
		$pgd = $dbf->dragndropF("ID_PREGUNTA","DESCRIPCION","CRM2_PREGUNTAS"," WHERE ACTIVO=1 AND COD_CLIENT =".$cte,$lps,"",'ondblclick="form_preg(this.id,2)"',' ORDER BY DES;');
		$pgs = $dbf->dragndropF("P.ID_PREGUNTA","P.DESCRIPCION"," CRM2_PREGUNTAS P"," LEFT JOIN CRM2_CUESTIONARIO_PREGUNTAS CP ON CP.ID_PREGUNTA = P.ID_PREGUNTA WHERE ACTIVO=1 AND COD_CLIENT =".$cte,$lpd,"",'ondblclick="form_preg(this.id,2)"'," GROUP BY P.ID_PREGUNTA ORDER BY CP.ORDEN;");
		
		$lus = ex_qry("COD_USER","CRM2_VENDEDOR_CUESTIONARIO"," WHERE ID_CUESTIONARIO = ".$_GET['cuestionario']);
		$lud = ex_qry("ID_USUARIO","ADM_USUARIOS"," WHERE ID_CLIENTE = ".$cte." AND ID_USUARIO NOT IN (".$lus.")");
		$usd = $dbf->dragndrop("ID_USUARIO","NOMBRE_COMPLETO","ADM_USUARIOS"," WHERE ESTATUS='Activo' AND ID_CLIENTE =".$cte,$lus,"");
		$uss = $dbf->dragndrop("ID_USUARIO","NOMBRE_COMPLETO","ADM_USUARIOS"," WHERE ESTATUS='Activo' AND ID_CLIENTE =".$cte,$lud,"");
		
		$tpl->assign_vars(array(
		'PRG'      	=> $pgd,
		'PRS'      	=> $pgs,
		'O_P'      	=> 2,
		'LPS'      	=> $lps,
		'LUS' 		=> $lus,
		'USD'      	=> $usd,
		'USS'      	=> $uss
		));
		}
	else{
		//vacia
		$prg = $dbf->dragndropF("P.ID_PREGUNTA","P.DESCRIPCION","CRM2_PREGUNTAS P "," LEFT JOIN CRM2_CUESTIONARIO_PREGUNTAS CP ON CP.ID_PREGUNTA = P.ID_PREGUNTA WHERE ACTIVO=1 AND COD_CLIENT =".$cte,"","",'ondblclick="form_preg(this.id,2)"'," GROUP BY P.ID_PREGUNTA ORDER BY CP.ORDEN;");
		$usr = $dbf->dragndrop("ID_USUARIO","NOMBRE_COMPLETO","ADM_USUARIOS"," WHERE ESTATUS='Activo' AND ID_CLIENTE =".$cte,"","");
		$tpl->assign_vars(array(
		'PRG'      	=> $prg,
		'O_P'      	=> 1,
		'USD'		=> $usr
		));
		}	
	

	$tp = $dbf->cbo_from_notit("ID_TIPO","DESCRIPCION","CRM2_TIPO_CUES","",$option=@$qst['ID_TIPO']);
	

	$tms = $dbf->tabla_temas($tma);
	


	
	
	
	$tpl->assign_vars(array(
	'IDQ'      	=> $id,
	'TMS'      	=> $tms,
	'T_P'      	=> $tp,
	'TIT'      	=> $tit,
	'MUL'      	=> $mul,
	'OFF'      	=> $off,
	'IDT'      	=> $tma,
	'TYP'      	=> $typ,
	'MLV'      	=> $mlv,
	'OFV'      	=> $ofv,
	'X'      	=> $x,
	'Y'      	=> $y,
	'Z'      	=> $z
	));
	$tpl->pparse('mFormulario');	
?>	