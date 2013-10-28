<?php
/** * 
 *  @package             4togo_Pepsico.
 *  @name                Obtiene los GeoPuntos.
*   @version             1
*   @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Erick A. Calderón
 *  @modificado          02-08-2011 
**/

	//--------------------------- Modificada BD y Encabezado------------------------
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';  //Manda al login si no se ha Logeo.
	//--------------------------- Modificada BD y Encabezado------------------------
	
	$tpl->set_filenames(array(
		'mAdd_GeoPuntos'=>'tAdd_GeoPuntos'
	));
	
	
	//Llena la Lista de RADIO.
	//-----------------------------------------------
	$contradio = 10;
	while($contradio <= 1000){
		$tpl->assign_block_vars('numRadio',array(
		'vradio' =>$contradio,
		));
	$contradio = $contradio +10 ;
	}
	
	
	//Lena la Lista de TIPO DE CLIENTE.
	//-----------------------------------------------
	$sql = "SELECT COD_TYPE_GEO, DESCRIPTION FROM SAVL1164";
	
	$query= $db->sqlQuery($sql);
	$count= $db->sqlEnumRows($query);
	if($count>0){ 
		while($row=$db->sqlFetchArray($query)){	

		$tpl->assign_block_vars('numType',array(
		'vcode' =>$row['COD_TYPE_GEO'],
		'vdesc' =>$row['DESCRIPTION'],
		));
	}
	}
	
	
	//Lena la Lista de RUTA.
	//-----------------------------------------------
	$sql = "SELECT ID_ROUTE, DESCRIPTION FROM SAVL_ROUTES";
	
	$query= $db->sqlQuery($sql);
	$count= $db->sqlEnumRows($query);
	if($count>0){ 
		while($row=$db->sqlFetchArray($query)){	

		$tpl->assign_block_vars('numRute',array(
		'vcode' =>$row['ID_ROUTE'],
		'vdesc' =>$row['DESCRIPTION'],
		));
	}
	}
	
	
	//Lena la Lista de ESTADOS.
	//-----------------------------------------------
	$sql_edo = "SELECT 	ID_ESTADO,NOMBRE FROM ZZ_SPM_ENTIDADES ORDER BY NOMBRE";
	$query_edo = $db -> sqlQuery($sql_edo);
	
		while($row_edo = $db->sqlFetchArray($query_edo)){
		
		$tpl->assign_block_vars('states',array(
			'ID'   => $row_edo['ID_ESTADO'], 
			'NAME' => $row_edo['NOMBRE']
		));	
	}
	
	
	
	$tpl->pparse('mAdd_GeoPuntos');
?>
