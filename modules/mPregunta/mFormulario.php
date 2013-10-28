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
	
	$db ->sqlQuery("SET NAMES 'utf8'");
	
	$tpl->set_filenames(array('mFormulario' => 'tFormulario'));
	

	
	$idt = "";
	$com = "";
	//if($_GET['op']==2){
		$sql = "SELECT P.ID_PREGUNTA,P.COMPLEMENTO, P.ID_TIPO,P.DESCRIPCION,P.ACTIVO,P.RECORDADO,P.REQUERIDO,TP.HTML FROM CRM2_PREGUNTAS P
		INNER JOIN CRM2_TIPO_PREG TP ON TP.ID_TIPO = P.ID_TIPO
		WHERE ID_PREGUNTA = ".$_GET['idp'];
		$qry = $db->sqlQuery($sql);
		$row = $db->sqlFetchArray($qry);
		$cnt = $db->sqlEnumRows($qry);
		if($cnt>0){$src = ($row['RECORDADO']==1)?'selected="selected"':'';}
		if($cnt>0){$srq = ($row['REQUERIDO']==1)?'selected="selected"':'';}
		
		$nrc = ($row['RECORDADO']==0)?'selected="selected"':'';
		$nrq = ($row['REQUERIDO']==0)?'selected="selected"':'';
		if($cnt>0){$nac = ($row['ACTIVO']==0)?'selected="selected"':'';}
		$cmp = $row['COMPLEMENTO'];
		//echo $cnt;
		if($cnt>0){
			$sac = ($row['ACTIVO']==1)?'selected="selected"':'';
			}
		else{
			$sac = 'selected="selected"';
			}	
		$html = ($cnt > 0)?$row['HTML']:'<input type="text" class="caja_txt" readonly="readonly"/>';
		
		if($_GET['op']==2){
			$lqs = ex_qry("Q.ID_CUESTIONARIO"," CRM2_CUESTIONARIOS Q "," INNER JOIN CRM2_CUESTIONARIO_PREGUNTAS QP ON QP.ID_CUESTIONARIO = Q.ID_CUESTIONARIO WHERE COD_CLIENT = ".$cte." AND QP.ID_PREGUNTA = ".$_GET['idp']." ORDER BY Q.DESCRIPCION ");
			$lqs = ($lqs!="")?$lqs:0;
			$lqd = ex_qry("ID_CUESTIONARIO","CRM2_CUESTIONARIOS"," WHERE COD_CLIENT = ".$cte." AND ID_CUESTIONARIO NOT IN (".$lqs.")");
			$qst_d = $dbf->dragndropF("ID_CUESTIONARIO","DESCRIPCION","CRM2_CUESTIONARIOS"," WHERE COD_CLIENT =".$cte,$lqs,"",""," ORDER BY DESCRIPCION;");
			$qst_s = $dbf->dragndropF("ID_CUESTIONARIO","DESCRIPCION","CRM2_CUESTIONARIOS"," WHERE COD_CLIENT =".$cte,$lqd,"",""," ORDER BY DESCRIPCION;");
			$tpl->assign_vars(array(
			'Q_D'	=> $qst_d,
			'Q_S'	=> $qst_s
			));
			}
		else{
			$q_d = $dbf->dragndropF("ID_CUESTIONARIO","DESCRIPCION","CRM2_CUESTIONARIOS"," WHERE COD_CLIENT =".$cte,"","",""," ORDER BY DESCRIPCION;");
			$tpl->assign_vars(array(
			'Q_D'	=> $q_d
			));
		}		
		$tpl->assign_vars(array(
		'CMP'		=> $cmp,
		'DSC'      	=> $row['DESCRIPCION'],
		'SRC'      	=> $src,
		'SRQ'      	=> $srq,
		'SAC'      	=> $sac,
		'NRC'      	=> $nrc,
		'NRQ'      	=> $nrq,
		'NAC'      	=> $nac,
		'HTML'		=> $html
		
		));	
		//}
		
	$sql_m="SELECT ID_TIPO, TIPO,HTML FROM CRM2_TIPO_PREG WHERE ACTIVO = 1 ORDER BY ID_TIPO ";
	$query_m = $db->sqlQuery($sql_m);
	while($row_m = $db->sqlFetchArray($query_m)){
		$idt .= ($idt=="")?$row_m['ID_TIPO']:"|".$row_m['ID_TIPO'];
		$com .= ($com=="")?$row_m['HTML']:"|".$row_m['HTML'];
		$t_s = ($row_m['ID_TIPO']==$row['ID_TIPO'])?'selected="selected"':'';
	$tpl->assign_block_vars('tipo',array(
		'TP'     => $row_m['TIPO'],
		'IDTP'   => $row_m['ID_TIPO'],
		'S'		 => $t_s
		
	));	
	}


	$tpl->assign_vars(array(
	'OP'      	=> $_GET['op'],
	'ID'      	=> $_GET['idp'],
	'IDT'      	=> $idt,
	'COM'      	=> $com,
	));	
	$tpl->pparse('mFormulario');	
	
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
?>	