<?php
/*
 *  @package             
 *  @name                Pagina default del modulo silver 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          23-04-2012
**/
	include("public/php/date.php");
	date_default_timezone_set('UTC');  
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	
	$tpl->set_filenames(array('default'=>'default'));	
	$idProfile   = $userAdmin->user_info['ID_PROFILE'];	
	
	$menu = ''; 
	////////////////////OBTENER MENU/PERMISO////////////////////
	/*$sql_mp="SELECT COD_PERMISSION FROM SAVL4002 WHERE ID_PROFILE=".$idProfile." AND COD_SUBMENU ='".$_GET['j']."'";
	$query_mp = $db->sqlQuery($sql_mp);
	$row_mp = $db->sqlFetchArray($query_mp);*/
	///////////////////////////////////////////////////////


	////////////////////OBTENER permisos////////////////////
	/*$sql_p="SELECT A.RD, A.WR, A.EX,A.UP,A.DL FROM SAVL4011 A WHERE COD_PERMISSION=".$row_mp['COD_PERMISSION'];
	$query_p = $db->sqlQuery($sql_p);
	$row_p = $db->sqlFetchArray($query_p);
	if($row_p['RD']=='1'){$R=''; $RM=1;}else{$R='disabled="disabled"'; $RM=0;}
	if($row_p['WR']=='1'){$W='';}else{$W='none';}
	if($row_p['EX']=='1'){$E='';}else{$E='none';}
	if($row_p['UP']=='1'){$U='';$UB='meditar()';}else{$U='none'; $UB='';}
	if($row_p['DL']=='1'){$D='';}else{$D='none';}*/
	///////////////////////////////////////////////////////


	///////////////////////CSS///////////////////////
	/*$sql="SELECT  * FROM SAVL4030 WHERE ACTIVO=1";
	$query = $db->sqlQuery($sql);
	$row = $db->sqlFetchArray($query);*/
	//////////////////////PATH MODULO///////////////
	/*$sql_pm="SELECT * FROM SAVL4001 WHERE COD_SUBMENU=".$_GET['j'];
	$query_pm = $db->sqlQuery($sql_pm);
	$row_pm = $db->sqlFetchArray($query_pm);*/
	
/*SELECT c.READ,c.WRITE,c.EXPORT,c.UPDATE,c.DELETE
FROM SAVL4001 a
INNER JOIN SAVL4002 b ON a.COD_SUBMENU = b.COD_SUBMENU
INNER JOIN SAVL4011 c ON c.COD_PERMISSION =b.COD_PERMISSION
WHERE a.COD_SUBMENU = $row_pm['URL'];*/	

//CONDICIONES
/*if($rowx['READ']==1){
		 $x=' ';
}
else{$x='none';}*/
		 

	$tpl->assign_vars(array(
		//'URL'           => $row_pm['UBICACION'],
		'PAGE_TITLE'	=> "Despachador",	
		'PATH'			=> $dir_mod,
		'PATH_IMG'		=> $dir_pimages,
		'NAME'			=> $userAdmin->codif($userAdmin->user_info['USER_NAME']),
		'MAIL'			=> $userAdmin->codif($userAdmin->user_info['USER_EMAIL']),
		'TYPE'			=> $userAdmin->codif($userAdmin->user_info['PRIVILEGES']),		
		'MENU'			=> $userAdmin->codif($menu),
		'APIKEY'		=> $config['keyapi'],
		'FECHA'       	=> fecha(),
		'DB_H'            => $config_bd['host'],
		'DB_PORT'         =>$config_bd['port'],
		'DB_BN'           =>$config_bd['bname'],
		'DB_U'            =>$config_bd['user'],
		'DB_PASS'         =>$config_bd['pass'],
		'COD_CLIENT'      =>$userAdmin->codif($userAdmin->user_info['COD_CLIENT'])
		/*'B'			    => $row['BODY'],
		'PIE'			=> $row['FOOT'],
		'PIEC'			=> $row['FOOT_CONTENT'], 
		'READ'			=> $R, 
		'WRITE'			=> $W, 
		'EXPORT'		=> $E, 
		'DELETE'		=> $D, 
		'UPDATE'		=> $U,
		'RM'			=> $RM,
		'UP'			=> $UB*/
	));	
	
	
	 // $fecha = '2012-11-18';
    $fecha = date('Y-m-d');
	
	$sql = "SELECT M.ID_DESPACHO, CONCAT(E.DESCRIPTION, ' - ',M.DESCRIPCION) AS VIAJE
			FROM DSP_DESPACHO M 
   			INNER JOIN DSP_UNIDAD_ASIGNADA U ON U.ID_DESPACHO = M.ID_DESPACHO
  			INNER JOIN SAVL_CLIENTS_UNITS N ON N.COD_ENTITY = U.COD_ENTITY
  			INNER JOIN SAVL1120 E ON E.COD_ENTITY = N.COD_ENTITY
  			WHERE M.FECHA_INICIO BETWEEN '".$fecha." 00:00:00' AND '".$fecha." 23:59:59' 
	        AND N.COD_CLIENT  =  ".$userAdmin->user_info['COD_CLIENT']." ORDER BY VIAJE";
			
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){	
				while($row = $db->sqlFetchArray($query)){					 
				$tpl->assign_block_vars('dato_x',array(
						'ID'	=> $row['ID_DESPACHO'],
						'UNIT'	=> utf8_encode($row['VIAJE'])
			  	));	
				}

	       }
	
	
	$tpl->pparse('default');
?>