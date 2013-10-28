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
/*$userData = new usersAdministration();
if( !$userData-> u_logged())
    echo '<script>window.location="index.php?mod=login&act=default"</script>';*/

if(isset($_GET['idd'])){
	$OK=0;
	//Obtener itinerarios del despacho.
	//-----------------------------------------------
	$ides="";
	$sql = "SELECT D.ID_ENTREGA FROM DSP_ITINERARIO D WHERE D.ID_DESPACHO=".$_GET['idd'];
	
	$query= $db->sqlQuery($sql);
	$count= $db->sqlEnumRows($query);
	if($count>0){ 
		while($row=$db->sqlFetchArray($query)){	
		$ides=($ides=="")?$row['ID_ENTREGA']:$ides.",".$row['ID_ENTREGA'];
	}
	}
	//echo $ides;
	//Obtener incidencias de las entregas.
	//-----------------------------------------------
	$idis="";
	$sql_a = "SELECT D.ID_INCIDENCIA FROM DSP_INCIDENCIA_ITINERARIO D WHERE D.ID_ENTREGA IN (".$ides.")";
	
	$qry_a = $db->sqlQuery($sql_a);
	$cnt_a = $db->sqlEnumRows($qry_a);
	if($cnt_a>0){ 
		while($row_a=$db->sqlFetchArray($qry_a)){	
		$idis=($idis=="")?$row_a['ID_INCIDENCIA']:$idis.",".$row_a['ID_INCIDENCIA'];
		}
	}
	//Obtener cuestionarios de las entregas.
	//-----------------------------------------------
	$idcs="";
	$sql_b = "SELECT D.ID_DOCUMENTACION FROM DSP_DOCUMENTA_ITINERARIO D WHERE D.ID_ENTREGA IN (".$ides.")";
	
	$qry_b = $db->sqlQuery($sql_b);
	$cnt_b = $db->sqlEnumRows($qry_b);
	if($cnt_b>0){ 
		while($row_b=$db->sqlFetchArray($qry_b)){
		$idcs=($idcs=="")?$row_b['ID_DOCUMENTACION']:$idcs.",".$row_b['ID_DOCUMENTACION'];
		}
	}	
	//Obtener unidades del despacho.
	//-----------------------------------------------
	$unds="";
	$sql_c = "SELECT D.ID_ASIGNACION FROM DSP_UNIDAD_ASIGNADA D WHERE D.ID_DESPACHO=".$_GET['idd'];
	
	$qry_c = $db->sqlQuery($sql_c);
	$cnt_c = $db->sqlEnumRows($qry_c);
	if($cnt_c>0){ 
		while($row_c=$db->sqlFetchArray($qry_c)){
		$unds=($unds=="")?$row_b['ID_DOCUMENTACION']:$unds.",".$row_b['ID_DOCUMENTACION'];
		}
	}
	
	//Obtener notas del despacho.
	//-----------------------------------------------
	$nts="";
	$sql_d = "SELECT D.ID_NOTA FROM DSP_NOTAS_DESPACHO D WHERE D.ID_DESPACHO=".$_GET['idd'];
	
	$qry_d = $db->sqlQuery($sql_d);
	$cnt_d = $db->sqlEnumRows($qry_d);
	if($cnt_d>0){ 
		while($row_d=$db->sqlFetchArray($qry_d)){
		$nts=($nts=="")?$row_d['ID_DOCUMENTACION']:$nts.",".$row_d['ID_DOCUMENTACION'];
		}
	}
	//proceso borrar
	//Borrar incidencias de las entregas.
	if($idis!=""){
		$where = " ID_INCIDENCIA IN (".$idis.")";
		if(!$dbf->deleteDB('DSP_INCIDENCIA_ITINERARIO',$where,true)){
			$OK++;
			}		
		}
	//Borrar cuestionarios de las entregas.
	if($idcs!=""){
		$where = " ID_DOCUMENTACION IN (".$idcs.")";
		if(!$dbf->deleteDB('DSP_DOCUMENTA_ITINERARIO',$where,true)){
			$OK++;
			}		
		}
	//Borrar entregas.
	if($ides!="" && $OK==0){
		$where = " ID_ENTREGA IN (".$ides.")";
		if(!$dbf->deleteDB('DSP_ITINERARIO',$where,true)){
			$OK++;
			}		
		}		
	//Borrar unidades asignadas.
	/*if($unds!=""){
		$where = " ID_ASIGNACION IN (".$unds.")";
		if(!$dbf->deleteDB('DSP_UNIDAD_ASIGNADA',$where,true)){
			$OK++;
			}		
		}*/
	//Borrar notas del despacho.
	if($nts!=""){
		$where = " ID_NOTA IN (".$nts.")";
		if(!$dbf->deleteDB('DSP_NOTAS_DESPACHO',$where,true)){
			$OK++;
			}		
		}						
	//Borrar despacho.
	if($OK==0){
		$where = " ID_DESPACHO =".$_GET['idd'];
		if(!$dbf->deleteDB('DSP_DESPACHO',$where,true)){
			$OK++;
			}		
		}	
		
	echo $OK;				
	//$cnt=0;
	//$exp = explode(",", $_GET['elementos']);	

	//for($x=0; $x < count($exp); $x++){

	//	}
	//echo $cnt;
}
?>