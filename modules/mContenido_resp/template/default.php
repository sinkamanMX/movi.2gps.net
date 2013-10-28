<?php
/*
 *  @package             
 *  @name                Pagina default del modulo silver 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          23-04-2012
**/
	//include("public/php/date.php");
	//date_default_timezone_set('UTC');  
		$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	$tpl->set_filenames(array('default'=>'default'));	
	
	$menu = ''; 
	

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 

		 

	$tpl->assign_vars(array(
		//'URL'           => $row_pm['UBICACION'],
		'PAGE_TITLE'	=> "Despachador",	
		'PATH'			=> $dir_mod,
		'APIKEY'		=> 'ABQIAAAAo3OJjDVWIGNrslnkRZpcgRSRgLzHXViMfqgitSqJvOSm8AEP4hTHlkP8AmvkEqD4MrhYfIsUk45EYQ',
		'FECHA'       	=> $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y'),
		'DB_H'            => $config_bd['host'],
		'DB_PORT'         =>$config_bd['port'],
		'DB_BN'           =>$config_bd['bname'],
		'DB_U'            =>$config_bd['user'],
		'DB_PASS'         =>$config_bd['pass'],
		'COD_CLIENT'      =>$Functions->codif($userAdmin->user_info['ID_CLIENTE'])
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
	
	
	 // $fecha = '2012-11-18'; WHERE M.FECHA_INICIO BETWEEN '".$fecha." 00:00:00' AND '".$fecha." 23:59:59' 
    $fecha = date('Y-m-d');
	
	$sql = "SELECT M.ID_DESPACHO, CONCAT(E.DESCRIPTION, ' - ',M.DESCRIPCION) AS VIAJE
			FROM DSP_DESPACHO M 
   			INNER JOIN DSP_UNIDAD_ASIGNADA U ON U.ID_DESPACHO = M.ID_DESPACHO
  			INNER JOIN SAVL_CLIENTS_UNITS N ON N.COD_ENTITY = U.COD_ENTITY
  			INNER JOIN SAVL1120 E ON E.COD_ENTITY = N.COD_ENTITY
  			WHERE CURRENT_DATE BETWEEN CAST(M.FECHA_INICIO AS DATE)  AND CAST(M.FECHA_FIN AS DATE)
	        AND N.COD_CLIENT  =  ".$userAdmin->user_info['ID_CLIENTE']." ORDER BY VIAJE";
			
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