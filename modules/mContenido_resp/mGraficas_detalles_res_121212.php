 <?php
 
 	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);	
//	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	$tpl->set_filenames(array('mGraficas_detalles'=>'tGraficas_detalles'));
  
  //echo "---".$userAdmin->user_info['COD_CLIENT']."---";
  //$fecha = '2012-11-18';
  $fecha = date('Y-m-d');
  
  /* $sql ="SELECT a.ID_DESPACHO,c.COD_ENTITY,a.DESCRIPCION AS DES ,a.ITEM_NUMBER,c.DESCRIPTION,a.FECHA_INICIO,a.FECHA_FIN,a.FECHA_REAL_INICIO,a.FECHA_REAL_FIN,
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
*/


$sl = "SELECT *,CURRENT_TIMESTAMP AS T1 FROM DSP_DESPACHO a
       INNER JOIN SAVL1100 k ON a.COD_USER = k.COD_USER
       AND a.ID_DESPACHO = ".$_GET['unidad']." AND k.COD_CLIENT = ".$_GET['cod_cli'];
       
 	    $query0	  = $db->sqlQuery($sl);	
       	$count0   = $db->sqlEnumRows($query0);   
        $fechita = date('Y-m-d h:m:s');    
        $cadenita = "";
        
        
	   if($count0>0){
       	  $row0 = $db->sqlFetchArray($query0);
       	  $row0['FECHA_REAL_INICIO'];
       	   if($row0['FECHA_REAL_INICIO'] == '0000-00-00 00:00:00'){
                if($row0['FECHA_INICIO'] > $row0['T1'] ){
                	$cadenita = "BETWEEN CURRENT_TIMESTAMP AND FECHA_INICIO ";
                }else{
                	$cadenita = "BETWEEN a.FECHA_INICIO AND CURRENT_TIMESTAMP";
                }
		   }else{
		   	   if($row0['FECHA_REAL_INICIO'] > $row0['T1'] ){
                	$cadenita = "BETWEEN CURRENT_TIMESTAMP AND FECHA_REAL_INICIO ";
                }else{
                	$cadenita = "BETWEEN a.FECHA_REAL_INICIO AND CURRENT_TIMESTAMP";
                }
		   	
		   }
       	  
       }
       

  $sql ="SELECT a.ID_DESPACHO,c.COD_ENTITY,a.DESCRIPCION AS DES ,
       a.ITEM_NUMBER,c.DESCRIPTION,a.FECHA_INICIO,a.FECHA_FIN,a.FECHA_REAL_INICIO,a.FECHA_REAL_FIN,
			COUNT(b.COD_ENTITY) AS VISITAR,SUM(d.VOLUMEN) AS VOLUMEN,SUM(d.DISTANCIA) AS DISTANCIA,
			TIMEDIFF(a.FECHA_FIN ,a.FECHA_INICIO) AS TIEMPO1,
IF(a.FECHA_REAL_FIN = '0000-00-00 00:00:00',TIMEDIFF(CURRENT_TIMESTAMP,a.FECHA_INICIO),TIMEDIFF(a.FECHA_REAL_FIN,a.FECHA_REAL_INICIO)) AS TIEMPO2
			FROM DSP_DESPACHO a 
			INNER JOIN DSP_UNIDAD_ASIGNADA b ON a.ID_DESPACHO = b.ID_DESPACHO 
			INNER JOIN SAVL1120 c ON b.COD_ENTITY = c.COD_ENTITY 
            INNER JOIN DSP_ITINERARIO d ON a.ID_DESPACHO = d.ID_DESPACHO
            INNER JOIN SAVL1100 k ON a.COD_USER = k.COD_USER
            WHERE  IF(a.FECHA_REAL_INICIO = '0000-00-00 00:00:00',a.FECHA_INICIO,a.FECHA_REAL_INICIO) 
		    ".$cadenita." 
			AND a.ID_DESPACHO = ".$_GET['unidad']." AND k.COD_CLIENT = ".$_GET['cod_cli'];


 	    $query	 = $db->sqlQuery($sql);	
       	$count   = $db->sqlEnumRows($query);
        $cadena ='';
       
	    if($count>0){	
				while($row = $db->sqlFetchArray($query)){
				//	echo "es".$row['ID_DESPACHO'];
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
//echo " aki".$despacho.'|'.$unidad.'|' ;
	$sql ="

SELECT a.ID_DESPACHO,a.DESCRIPCION,a.ITEM_NUMBER,b.COD_ENTITY,c.DESCRIPTION,d.COD_GEO,a.FECHA_REAL_INICIO,d.FECHA_ENTREGA,d.ID_ESTATUS 
FROM DSP_DESPACHO a 
INNER JOIN DSP_UNIDAD_ASIGNADA b ON a.ID_DESPACHO = b.ID_DESPACHO 
INNER JOIN SAVL1120 c ON b.COD_ENTITY = c.COD_ENTITY 
INNER JOIN DSP_ITINERARIO d ON a.ID_DESPACHO = d.ID_DESPACHO 
WHERE   d.ID_ESTATUS  = 3 AND a.ID_DESPACHO =".$despacho." AND b.COD_ENTITY =".$unidad;
 
 	    $query	 = $db->sqlQuery($sql);	
       	$count   = $db->sqlEnumRows($query);
	if($count > 0){
	  return $count;	
	}else{
	 return 0;	
	}
	
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
 
 

