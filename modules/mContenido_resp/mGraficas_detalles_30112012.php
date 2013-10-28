 <?php
 
 	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
//	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	$tpl->set_filenames(array('mGraficas_detalles'=>'tGraficas_detalles'));
  
  //echo "---".$userAdmin->user_info['COD_CLIENT']."---";
  //$fecha = '2012-11-18';
  $fecha = date('Y-m-d');
  
   $sql ="SELECT a.ID_DESPACHO,c.COD_ENTITY,a.DESCRIPCION AS DES ,a.ITEM_NUMBER,c.DESCRIPTION,a.FECHA_INICIO,a.FECHA_FIN,a.FECHA_REAL_INICIO,a.FECHA_REAL_FIN,
			COUNT(b.COD_ENTITY) AS VISITAR,SUM(d.VOLUMEN) AS VOLUMEN,SUM(d.DISTANCIA) AS DISTANCIA,
			TIMEDIFF(a.FECHA_FIN ,a.FECHA_INICIO) AS TIEMPO1,
IF(a.FECHA_REAL_FIN = '0000-00-00 00:00:00',TIMEDIFF(CURRENT_TIMESTAMP,a.FECHA_REAL_INICIO),TIMEDIFF(a.FECHA_REAL_FIN,a.FECHA_REAL_INICIO)) AS TIEMPO2
			
			FROM DSP_DESPACHO a 
			INNER JOIN DSP_UNIDAD_ASIGNADA b ON a.ID_DESPACHO = b.ID_DESPACHO 
			INNER JOIN SAVL1120 c ON b.COD_ENTITY = c.COD_ENTITY 
			INNER JOIN DSP_ITINERARIO d ON a.ID_DESPACHO = d.ID_DESPACHO 
			INNER JOIN SAVL1100 k ON a.COD_USER = k.COD_USER
			WHERE a.FECHA_REAL_INICIO BETWEEN IF(a.FECHA_REAL_INICIO = '0000-00-00 00:00:00',CURRENT_TIMESTAMP,a.FECHA_REAL_INICIO) AND CURRENT_TIMESTAMP 
			AND a.ID_DESPACHO = ".$_GET['unidad']." AND k.COD_CLIENT = ".$_GET['cod_cli'];

 	    $query	 = $db->sqlQuery($sql);	
       	$count   = $db->sqlEnumRows($query);
        $cadena ='';
       
	    if($count>0){	
				while($row = $db->sqlFetchArray($query)){					 
				$tpl->assign_vars(array(
						'UNIDAD'			 => $row['DESCRIPTION'],
						'VIAJE'	    		 => $row['DES'].'- [ '.$row['ITEM_NUMBER'].' ]',
						'CLIENTES_VISITAR'	 => $row['VISITAR'],
						'CLIENTES_VISITADOS' => cumplidos($row['ID_DESPACHO'],$row['COD_ENTITY']),
						'VOLUMEN'			 => $row['VOLUMEN'],
						'100_OCUPACION'		 => 0,
						'DISTANCIA'			 => $row['DISTANCIA'],
						'TIEMPO1'			 => $row['TIEMPO1'],
						'TIEMPO2'			 => $row['TIEMPO2'],
						'100_CUMPLIMIENTO'	 => avance($row['ID_DESPACHO'],$row['COD_ENTITY'],$row['VISITAR'])
			  	));	
			  	
				}

	       }
$tpl->pparse('mGraficas_detalles');
//echo "hola";

function cumplidos($despacho,$unidad){
	global $db;
	
	$sql ="

SELECT a.ID_DESPACHO,a.DESCRIPCION,a.ITEM_NUMBER,b.COD_ENTITY,c.DESCRIPTION,d.COD_GEO,a.FECHA_REAL_INICIO,d.FECHA_ENTREGA,d.ID_ESTATUS 
FROM DSP_DESPACHO a 
INNER JOIN DSP_UNIDAD_ASIGNADA b ON a.ID_DESPACHO = b.ID_DESPACHO 
INNER JOIN SAVL1120 c ON b.COD_ENTITY = c.COD_ENTITY 
INNER JOIN DSP_ITINERARIO d ON a.ID_DESPACHO = d.ID_DESPACHO 
WHERE   d.ID_ESTATUS  = 3 AND a.ID_DESPACHO =".$despacho." AND b.COD_ENTITY =".$unidad;
 
 	    $query	 = $db->sqlQuery($sql);	
       	$count   = $db->sqlEnumRows($query);
	
	return $count;
}

function avance($despacho,$unidad,$totales){
	global $db;
	
	$sql ="SELECT a.ID_DESPACHO,a.DESCRIPCION,a.ITEM_NUMBER,b.COD_ENTITY,c.DESCRIPTION,d.COD_GEO,a.FECHA_REAL_INICIO,d.FECHA_ENTREGA,d.ID_ESTATUS 
FROM DSP_DESPACHO a 
INNER JOIN DSP_UNIDAD_ASIGNADA b ON a.ID_DESPACHO = b.ID_DESPACHO 
INNER JOIN SAVL1120 c ON b.COD_ENTITY = c.COD_ENTITY 
INNER JOIN DSP_ITINERARIO d ON a.ID_DESPACHO = d.ID_DESPACHO 
WHERE   d.ID_ESTATUS  = 3 AND a.ID_DESPACHO =".$despacho." AND b.COD_ENTITY =".$unidad;
 
 	    $query	 = $db->sqlQuery($sql);	
       	$count   = $db->sqlEnumRows($query);
	    $avance = ($count*100)/$totales;
	
	return $avance;
}
 ?>
 
 

