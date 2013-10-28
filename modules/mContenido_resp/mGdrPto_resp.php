<?php
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}
$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';
$idc   = $userAdmin->user_info['ID_CLIENTE'];


	 $idu   = $userAdmin->user_info['ID_USUARIO'];
	
	
	$row_t='';
if($_GET['datap']==""){	

		if($_GET['rh']==0){
				$data = Array(
					'ID_DESPACHO'		=> $_GET['idd'], 
					'ID_ESTATUS'   		=> 2,
					'COD_GEO'    		=> $_GET['cte'],
					'COD_USER'	    	=> $idu,
					'ITEM_NUMBER'	    => $_GET['idp'],
					'COMENTARIOS'	    => $_GET['obs'],
					'FECHA_ENTREGA'	    => $_GET['dte'],
					'FECHA_FIN'			=> $_GET['dts'],
					'TOLERANCIA'		=> $_GET['tol'],
					'ID_TIPO_VOLUMEN'		=> 1,
					'CREADO'	        => date('Y-m-d H:i:s'),
					'TIPO_RH'	        => 'GP',
					'COD_RH'	        => '0'
				);
		}else{
			
			$data = Array(
					'ID_DESPACHO'		=> $_GET['idd'], 
					'ID_ESTATUS'   		=> 2,
					'COD_GEO'    		=> $_GET['cte'],
					'COD_USER'	    	=> $idu,
					'ITEM_NUMBER'	    => $_GET['idp'],
					'COMENTARIOS'	    => $_GET['obs'],
					'FECHA_ENTREGA'	    => $_GET['dte'],
					'FECHA_FIN'			=> $_GET['dts'],
					'TOLERANCIA'		=> $_GET['tol'],
					'ID_TIPO_VOLUMEN'		=> 1,
					'CREADO'	        => date('Y-m-d H:i:s'),
					'TIPO_RH'	        => 'RH',
					'COD_RH'	        => $_GET['cte']
				);
			
			}

			if($dbf-> insertDB($data,'DSP_ITINERARIO',true) == true){
				if(isset($_GET['cst'])){
				$sql_f="SELECT LAST_INSERT_ID() AS IDE;";
				$query_f = $db->sqlQuery($sql_f);
				$row_f=$db->sqlFetchArray($query_f);
				
				$sql = "SELECT D.ID_ESTATUS FROM DSP_DESPACHO D WHERE D.ID_DESPACHO=".$_GET['idd'];
				$query = $db->sqlQuery($sql);
				$row = $db->sqlFetchArray($query);
				
				if($row['ID_ESTATUS']== 2){
					$datas = Array(
							'ID_ESTATUS'   => 4
					);
					$where = " ID_DESPACHO  = ".$_GET['idd'];
					$dbf-> updateDB('DSP_DESPACHO',$datas,$where,true)==true;
					}
					//echo $row_t['TYPE'];
				if($row_t!='AVL' && $_GET['cst']!=0){
				$data_b = Array(
					'ID_ENTREGA'	    => $row_f['IDE'],
					'ID_CUESTIONARIO'	    => $_GET['cst']
					//'ID_PAYLOAD'	    => $_GET['pld'],					
				);
				$dbf-> insertDB($data_b,'DSP_DOCUMENTA_ITINERARIO',true);
				 }
				}
				echo 1;
			}else{
				echo 0;
				}
}
else{
	$pts=explode("~",$_GET['datap']);
	//echo $_GET['datap'];
	$values="";
	$err=1;
	for($x=0;$x<count($pts);$x++){
		$dts=explode("|",$pts[$x]);
		/*$ob=($dts[2]=="")?"' '":"'".$dts[2]."'";
		$it=($dts[3]=="")?"' '":"'".$dts[3]."'";
		$tl=($dts[6]=="")?0:"'".$dts[6]."'";*/
		$ob=($dts[2]=="")?"' '":$dts[2];
		$it=($dts[3]=="")?"' '":$dts[3];
		$tl=($dts[6]=="")?0:$dts[6];
		//$values=($values=="")?"(".$_GET['idd'].",2,".$dts[0].",".$idu.",".$it.",".$ob.",'".$dts[1]."','".date('Y-m-d H:i:s')."','".$dts[5]."',".$dts[6].")":$values.",(".$_GET['idd'].",2,".$dts[0].",".$idu.",".$it.",".$ob.",'".$dts[1]."','".date('Y-m-d H:i:s')."','".$dts[5]."',".$dts[6].")";
	    $datax = Array(
			'ID_DESPACHO'		=> $_GET['idd'], 
			'ID_ESTATUS'   		=> 2,
			'COD_GEO'    		=> $dts[0],
			'COD_USER'	    	=> $idu,
			'ITEM_NUMBER'	    => $it,
			'COMENTARIOS'	    => $ob,
			'FECHA_ENTREGA'	    => $dts[1],
			'FECHA_FIN'			=> $dts[5],
			'TOLERANCIA'		=> $tl,
			'CREADO'	        => date('Y-m-d H:i:s')
		);
		if($dbf-> insertDB($datax,'DSP_ITINERARIO',true) == true){
			
				$sql_f="SELECT LAST_INSERT_ID() AS IDE;";
				$query_f = $db->sqlQuery($sql_f);
				$row_f=$db->sqlFetchArray($query_f);
				
				$sql = "SELECT D.ID_ESTATUS FROM DSP_DESPACHO D WHERE D.ID_DESPACHO=".$_GET['idd'];
				$query = $db->sqlQuery($sql);
				$row = $db->sqlFetchArray($query);
				
				if($row['ID_ESTATUS']== 2){
					$datas = Array(
							'ID_ESTATUS'   => 4
					);
					$where = " ID_DESPACHO  = ".$_GET['idd'];
					$dbf-> updateDB('DSP_DESPACHO',$datas,$where,true)==true;
					}
					//echo $row_t['TYPE'];
				//echo $dts[4];	
				if($dts[4]!=0){
				$data_b = Array(
					'ID_ENTREGA'	    => $row_f['IDE'],
					'ID_CUESTIONARIO'	=> $dts[4]
					//'ID_PAYLOAD'	    => $_GET['pld'],					
				);
				$dbf-> insertDB($data_b,'DSP_DOCUMENTA_ITINERARIO',true);
				 }
					
			}
			else{
				$err--;
				}
		}

	 //$sql="INSERT INTO DSP_ITINERARIO (ID_DESPACHO,ID_ESTATUS,COD_GEO,COD_USER,ITEM_NUMBER,COMENTARIOS,FECHA_ENTREGA,CREADO,FECHA_FIN,TOLERANCIA) VALUES ".$values;
	//$qry= $db->sqlQuery($sql);		
	
	/*if($qry==true){
		
		echo 1;
		}
	else{
		echo -1;
		}*/	
		echo $err;
	}
$db->sqlClose();
?>