<?php
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}

	$idc   = $userAdmin->user_info['ID_USUARIO'];

	$sql_f="SELECT ID_NOTA FROM DSP_NOTAS_DESPACHO ORDER BY ID_NOTA LIMIT 1";
	$query_f = $db->sqlQuery($sql_f);
	$count_f = $db->sqlEnumRows($query_f);	
	$row=$db->sqlFetchArray($query_f);
	$mas=$row['ID_NOTA']+1;
		

if($_GET['op']==1){
	    $data = Array(
			'ID_ENTREGA'		=> $_GET['idd'], 
			'ID_TIPO'   		=> $_GET['tnote'],
			'COD_USER'    		=> $idc,
			'COMENTARIOS'	    => $_GET['note'],
			'FECHA'	    		=>  date('Y-m-d H:i:s')
		);


			if($dbf-> insertDB($data,'DSP_INCIDENCIA_ITINERARIO',true) == true){
				echo 1;
				}else{
				echo 0;
				}
}
////////////////////////////////////////////////////////////////////////////////////
if($_GET['op']==2){
	    $data = Array(
			'ID_DESPACHO'		=> $_GET['idd'], 
			'ID_NOTA'		=> $mas, 
			'ID_TIPO'   		=> $_GET['tnote'],
			'COD_USER'    		=> $idc,
			'COMENTARIOS'	    => $_GET['note'],
			'FECHA'	    		=>  date('Y-m-d H:i:s')
		);


			if($dbf-> insertDB($data,'DSP_NOTAS_DESPACHO',true) == true){
				echo 1;
				}else{
				echo 0;
				}
}
$db->sqlClose();
?>