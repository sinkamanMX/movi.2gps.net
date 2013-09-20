<?php
/** * 
 *  @package             
 *  @name                Obtiene las Geo-Cercas registrados
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          03-06-2011
**/
header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';



 $tpl->set_filenames(array('mDnotasdsp' => 'tDnotasdsp'));
	$idc   = $userAdmin->user_info['ID_CLIENTE'];

	/*$sql_f="SELECT S.TYPE FROM SAVL_CLIENTS S WHERE  S.COD_CLIENT=".$idc;
	$query_f = $db->sqlQuery($sql_f);
	$count_f = $db->sqlEnumRows($query_f);		
	
	if($count_f>0){
		
		$row=$db->sqlFetchArray($query_f);
		$dsp= ($row['TYPE']=='AVL') ? 'display:none' : ''; 
			 $tpl->assign_vars(array(
				'DSP_DOS'	=> $dsp
										));			
	}*/	
//if ($row['TYPE']=='AVL'){
$sql_f="SELECT D.FECHA, D.COMENTARIOS, T.DESCRIPCION AS TNT, U.NOMBRE_COMPLETO AS USR  FROM DSP_NOTAS_DESPACHO D
INNER JOIN DSP_TIPO_NOTA T ON T.ID_TIPO=D.ID_TIPO
INNER JOIN ADM_USUARIOS U ON U.ID_USUARIO=D.COD_USER
WHERE D.ID_DESPACHO=".$_GET['idd']."
ORDER BY FECHA DESC;";	
//	}
/*else{
$sql_f="SELECT D.ID_DESPACHO, D.ID_ENTREGA, D.ITEM_NUMBER, D.COMENTARIOS, D.FECHA_ENTREGA, C.DESCRIPCION AS CUEST, S.DESCRIPTION AS CTE, UN.DESCRIPTION AS UND FROM DSP_ITINERARIO D
INNER JOIN SAVL_G_PRIN S ON S.COD_OBJECT_MAP = D.COD_GEO
INNER JOIN DSP_DOCUMENTA_ITINERARIO DI ON DI.ID_ENTREGA=D.ID_ENTREGA
INNER JOIN CRM2_CUESTIONARIOS C ON C.ID_CUESTIONARIO=DI.ID_CUESTIONARIO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1120 UN ON UN.COD_ENTITY=UA.COD_ENTITY
WHERE D.ID_DESPACHO=".$_GET['idd']." AND D.ID_ESTATUS NOT IN (3,5)";	
	}*/	
	

			//echo $_GET['sgpo'];

	$query_f = $db->sqlQuery($sql_f);
	$count_f = $db->sqlEnumRows($query_f);		
	
	if($count_f>0){
		
		while($row=$db->sqlFetchArray($query_f)){
			 $tpl->assign_block_vars('q',array(
				'FDC'	=> $row['FECHA'],
				'NOT'	=> utf8_encode($row['COMENTARIOS']),
				'TNT'	=> utf8_encode($row['TNT']),
				'USR'	=> utf8_encode($row['USR'])
										));	
		}

	$tpl->pparse('mDnotasdsp');
	}
	
	else{
	echo 0;}
			   
	
?>