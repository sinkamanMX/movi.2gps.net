<?php
/** * 
 *  @package             
 *  @name                Pagina default del modulo silver 
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          23-04-2012
**/
 
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
			echo '<script>window.location="index.php?m=login"</script>';
			
	$db ->sqlQuery("SET NAMES 'utf8'");			
			
	$client   = $userAdmin->user_info['ID_CLIENTE'];
	
	$data = Array(
			'ID_CLIENTE'			=> $client,
			'ITEM_NUMBER_ALMACEN'   => $_GET['alm'],
			'DESCRIPCION_ALMACEN'   => $_GET['dsc'],
			'ITEM_NUMBER_TIENDA'  	=> $_GET['tda'],
			'ZONA'					=> $_GET['zon'],
			'MERCADO'   			=> $_GET['mer'],
			'CAPACIDAD'    			=> $_GET['cap'],
			'ID_PATRON_MEDIDA'  	=> $_GET['pat'],
			'OBSERVACIONES'			=> $_GET['obs'],
			'ID_TIPO_PDI_UNIDAD'    => $_GET['pdi_uni'] 
	);
	//$prs = $_GET['par'];

	if($_GET['op']==1){
		
	if($dbf-> insertDB($data,'PED_ALMACEN',true) == true){
	
	           $ultimo_insertado = lastid();
			   $cadenitas1 = explode("|",$_GET['cad']);
			   $cadenitas2 = explode(",",$cadenitas1[0]);
			  
			   $cabecera = 'INSERT INTO PED_ALMACEN_PDI_UNIDAD 
								(ID_ALMACEN, 
								ID_PDI, 
								ID_CLIENTE, 
								COD_ENTITY)	VALUES';
			   $cuerpo = '';
			   
			     for($k=0;$k<count($cadenitas2);$k++){
			     	if($cuerpo == ''){
			     		if($_GET['pdi_uni']=='1'){
			     				$cuerpo = '("'.$ultimo_insertado.'","'.$cadenitas2[$k].'","'.$client.'","")';
			     		}else{
			     				$cuerpo = '("'.$ultimo_insertado.'","","'.$client.'","'.$cadenitas2[$k].'")';
			     		}
			     	
			     	}else{
			     		
			     		if($_GET['pdi_uni']=='1'){
			     			$cuerpo = $cuerpo.',("'.$ultimo_insertado.'","'.$cadenitas2[$k].'","'.$client.'","")';
		     			}else{
		     				$cuerpo = $cuerpo.',("'.$ultimo_insertado.'","","'.$client.'","'.$cadenitas2[$k].'")';
		     			}
			     	}
			     }
			   
			     $cuerpo = $cabecera.$cuerpo .';';
			 	 $qry = $db->sqlQuery($cuerpo);
			    if($qry){
			    	 echo 1;
			    }else{
			    	echo 0;
			    //	echo $cuerpo;
			    }
	
	
		}
	else{
		echo 0;
		}			
	}
	if($_GET['op']==2){
		$id = $_GET['id'];
		$where = " ID_ALMACEN  = ".$id;
		if(($dbf-> updateDB('PED_ALMACEN',$data,$where,true)==true)){
				   
		    $SQL= "SELECT * FROM PED_ALMACEN_PDI_UNIDAD WHERE ID_ALMACEN = ".$id;
		   	$qry = $db->sqlQuery($SQL);
		    $cnt = $db->sqlEnumRows($qry);
		    echo $cnt;
//		    
		 if($cnt > 0){
		 	$borrar = "DELETE FROM PED_ALMACEN_PDI_UNIDAD WHERE ID_ALMACEN = ".$id;
		 	$qry_del = $db->sqlQuery($borrar);
		 	 if($qry_del){
		 	
		  
			   $ultimo_insertado = lastid();
			   $cadenitas1 = explode("|",$_GET['cad']);
			   $cadenitas2 = explode(",",$cadenitas1[0]);
			  
			   $cabecera = 'INSERT INTO PED_ALMACEN_PDI_UNIDAD 
								(ID_ALMACEN, 
								ID_PDI, 
								ID_CLIENTE, 
								COD_ENTITY)	VALUES';
			   $cuerpo = '';
			   
			     for($k=0;$k<count($cadenitas2);$k++){
			     	if($cuerpo == ''){
			     		if($_GET['pdi_uni']=='1'){
			     				$cuerpo = '("'.$id.'","'.$cadenitas2[$k].'","'.$client.'","")';
			     		}else{
			     				$cuerpo = '("'.$id.'","","'.$client.'","'.$cadenitas2[$k].'")';
			     		}
			     	
			     	}else{
			     		
			     		if($_GET['pdi_uni']=='1'){
			     			$cuerpo = $cuerpo.',("'.$id.'","'.$cadenitas2[$k].'","'.$client.'","")';
		     			}else{
		     				$cuerpo = $cuerpo.',("'.$id.'","","'.$client.'","'.$cadenitas2[$k].'")';
		     			}
			     	}
			     }
			   
			     $cuerpo = $cabecera.$cuerpo .';';
			 	 $qry = $db->sqlQuery($cuerpo);
			    if($qry){
			    	 echo 1;
			    }else{
			    	echo 0;
			    }	  
			 
		 	 }else{
		 	 	echo 0;
		 	 }
		 	
		 }
		
	echo 1;	
			}
		else{
			echo 0;
			}	
		}
		
//---------------------  funcion regresa el ultimo id registrado en la base

function lastid (){
 global $db;
 $sql = "SELECT LAST_INSERT_ID() AS ID FROM PED_ALMACEN;";
 $qry = $db->sqlQuery($sql);
 $row = $db->sqlFetchArray($qry);
 return $row['ID'];
 }				
		
?>