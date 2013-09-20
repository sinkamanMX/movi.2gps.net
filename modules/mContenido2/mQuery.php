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



 $tpl->set_filenames(array('mQuery' => 'tQuery'));
 $idc   = $userAdmin->user_info['ID_CLIENTE'];


		$row='';
		$dsp= ($row=='AVL') ? 'display:none' : ''; 
			 $tpl->assign_vars(array(
				'DSP_DOS'	=> $dsp
										));			
	
//if ($row['TYPE']=='AVL'){
/*$sql_f="SELECT D.ID_DESPACHO, D.ID_ENTREGA, D.ITEM_NUMBER, D.COMENTARIOS, D.FECHA_ENTREGA, S.DESCRIPTION AS CTE, UN.DESCRIPTION AS UND FROM DSP_ITINERARIO D
INNER JOIN SAVL_G_PRIN S ON S.COD_OBJECT_MAP = D.COD_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN SAVL1120 UN ON UN.COD_ENTITY=UA.COD_ENTITY
WHERE D.ID_DESPACHO=".$_GET['idd']." AND D.ID_ESTATUS NOT IN (3,5) ORDER BY D.FECHA_ENTREGA ASC";	*/

$sql_f="SELECT D.ID_DESPACHO, D.ID_ENTREGA, D.ITEM_NUMBER, D.COMENTARIOS, D.FECHA_ENTREGA, S.DESCRIPCION AS CTE, UN.DESCRIPTION AS UND FROM DSP_ITINERARIO D
INNER JOIN ADM_GEOREFERENCIAS S ON  S.ID_OBJECT_MAP = D.COD_GEO
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN ADM_UNIDADES UN ON UN.COD_ENTITY=UA.COD_ENTITY
WHERE D.ID_DESPACHO=".$_GET['idd']." AND D.ID_ESTATUS NOT IN (3,5) GROUP BY D.ID_ENTREGA ORDER BY D.FECHA_ENTREGA ASC";
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
				'IDD'	=> $row['ID_DESPACHO'],
				'IDE'	=> $row['ID_ENTREGA'],
				'IDP'	=> $row['ITEM_NUMBER'],
				'OBS'	=> utf8_encode($row['COMENTARIOS']),				
				'DTD'	=> $row['FECHA_ENTREGA'],
				'CUE'	=> utf8_encode($row['CUEST']),
				'CTE'	=> utf8_encode($row['CTE']),
				'UND'	=> utf8_encode($row['UND'])			
										));	
		}

	$tpl->pparse('mQuery');
	}
	
	else{
	echo 0;}
			   
	
?>