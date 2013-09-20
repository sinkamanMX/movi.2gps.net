<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	
	$tpl->set_filenames(array('mGraficas'=>'tGraficas'));	
	$idc   = $userAdmin->user_info['COD_CLIENT'];	
       

/*        
    $tpl->set_filenames(array(
	   'mTabla_xa' => 'tTabla_xa'
    ));
*/


//////////////////////////////////////////////////POR IDD///////////////////////////////////////////////////////////////////////	

//WHERE  FECHA_REAL_INICIO BETWEEN '".$fecha." 00:00:00' AND '".$fecha." 23:59:59'	

$fecha = date("Y-m-d");
		
$sql = "SELECT a.ID_DESPACHO,a.DESCRIPCION,a.ITEM_NUMBER,b.COD_ENTITY,c.DESCRIPTION,d.COD_GEO,a.FECHA_REAL_INICIO,d.FECHA_ENTREGA   FROM DSP_DESPACHO a
INNER JOIN DSP_UNIDAD_ASIGNADA b 
ON a.ID_DESPACHO = b.ID_DESPACHO
INNER JOIN SAVL1120 c
ON b.COD_ENTITY = c.COD_ENTITY
INNER JOIN DSP_ITINERARIO d
ON a.ID_DESPACHO = d.ID_DESPACHO
WHERE  FECHA_REAL_INICIO BETWEEN '2012-10-25 00:00:00' AND '2012-10-25 23:59:59'
GROUP BY d.COD_GEO ORDER BY a.ID_DESPACHO,d.FECHA_ENTREGA ASC";
	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				$vieja = "";
				$conta = 0;
				$arreglos = array();
				
				while($row = $db->sqlFetchArray($query)){					
			        

			           if($vieja == $row['ID_DESPACHO']){
			            // $vieja =$row['ID_DESPACHO'];
					   	 $conta = $conta+1;
					   }else{
					     $vieja =$row['ID_DESPACHO'];
			        	 $conta = 1;
			           }
			             $arreglos[] = $conta;
			      
				    /*if($nueva == ""){
			          $nueva =	$conta;
			        }else{
			          $nueva = $nueva.','.$conta;
		            }*/
			    }
	
	
		$tpl->pparse('mGraficas');
		//	echo count($arreglos);
			$columnas =  max($arreglos);
			$vieja2 = "";
		
		
	/*	
  		echo'<table border=1 cellpadding=4 cellspacing=0>';
		for($ren=0;$ren<2;$ren++){
		    echo '<tr>';
			for($col=0;$col<$columnas;$col++){
			  	echo '<td>'.$col.'</td>';
			}
				echo '</tr>';
		}
	    echo '</table>';
		
				
			
			  	while($row2 = $db->sqlFetchArray($query)){					
			          
					   if($vieja2 == $row2['ID_DESPACHO']){
					   	 $conta = $conta+1;
					   }else{
					     $vieja =$row['ID_DESPACHO'];
			        	 $conta = 1;
			           }
			    }
		*/
			
				
			}else{
			 //echo 0;
			 $tpl->pparse('mGraficas');	
			}		
	

$db->sqlClose();
?>