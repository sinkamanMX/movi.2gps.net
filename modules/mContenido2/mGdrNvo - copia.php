<?php
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

// obtenemos los datos del archivo
$tamano = $_FILES["rmt"]['size'];
$tipo = $_FILES["rmt"]['type'];
$archivo = $_FILES["rmt"]['name'];
$x=(explode(".",$archivo));
$extension=$x[count($x)-1];
$nombre=$x[count($x)-2];
///////////////////////////////////

//DATOS 
$sql_n="SELECT MAX(COD_SUBMENU_CONTENIDO)+1 AS B FROM SAVL4003";
$query_n = $db->sqlQuery($sql_n);
$row = $db->sqlFetchArray($query_n);

$sql_o="SELECT MAX(COD_SUBMENU_CONTENIDO)+1 AS C FROM SAVL4003 WHERE COD_SUBMENU=COD_SUCURSAL";
$query_o = $db->sqlQuery($sql_o);
$row_o = $db->sqlFetchArray($query_o);

if(is_null($row_o['C'])){$ORN=1;}else{$ORN=$row_o['C'];}
if(is_null($row['B'])){$CNT=1;}else{$CNT=$row['B'];}
if(isset($_POST['cnt'])){
	    $data = Array(
			'COD_SUBMENU_CONTENIDO'	=> $CNT, 
			'COD_SUBMENU'   		=> $_POST['smn'],
			'COD_SUCURSAL'    		=> $_POST['suc'],
			'UBICACION_LOCAL'	    => $_POST['lcl'],
			'UBICACION_REMOTA'	    => "",
			'DESCRIPCION'	        => $_POST['cnt'],
			'ORDEN'	                => $ORN
		);
}
//
	
			if($dbf-> insertDB($data,'SAVL4003',true) == true){
			//ALMACENAR ARCHIVO
			$prefijo=$_POST['suc'].$_POST['smn'];
			$destino =  "images_mobile/".$prefijo.$nombre.'.'.$extension;
			echo'<h1>'.$destino.'</h1>';
			if (copy($_FILES['rmt']['tmp_name'],$destino)) {
			$data = Array('UBICACION_REMOTA'  => $destino);	
			$where = " COD_SUBMENU_CONTENIDO = ".$CNT;
			if($dbf-> updateDB('SAVL4003',$data,$where,true)==true){
				?><script type='text/javascript'>parent.m1();</script><?
				echo 1;}
				}	
			} 
			else{
				?><script type='text/javascript'>parent.m1();</script><?
				echo 0;}
			
$db->sqlClose();
?>