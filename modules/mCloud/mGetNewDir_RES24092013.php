<?php
/*
*/  header('Content-Type: text/html; charset=UTF-8');
   	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
    if(!$userAdmin->u_logged()){
    		echo '<script>window.location="index.php?m=login"</script>';
    }
    
    
    $host    = $config_bd['host'];
    $usuario = $config_bd['user'];
    $contra  = $config_bd['pass'];
    
    $enlace =  mysql_connect($host,$usuario,$contra);
	if (!$enlace) {
	    die('No pudo conectarse: ' . mysql_error());
	}
	   mysql_query("SET NAMES 'utf8'");
	   mysql_select_db($config_bd['bname'], $enlace);  
	   
	echo $_GET['cade'];
 	$cadenad = explode(",",$_GET['cade']);
 	
	$T=9999;
	$ct='-';
	$cs='*';
	//echo $directorio=dirname(__FILE__).'/Raiz/ragde18@hotmail.es';
	$cadena='';
	$down='/modules/mCloud/Raiz/ragde18@hotmail.es/';
	$path=$_GET['ulr'];
	
	if(!mkdir( $path, 0777, true )){
	  $T=-8;
	}else{
	 
	  if($cadenad[0] === '1' && $cadenad[1] ==='0'){
	  	$d = crear_menu($path,$cadenad[2],$cadenad[3],$enlace);
	  	 if($d){
		    $T=$d;
	  	 }else{
	  	    $T = 0;	
	  	 }
	  }
	  if($cadenad[0]  ==='0' && $cadenad[1]  ==='1'){
	  	 $d = crear_sub_menu($cadenad[4],codif($cadenad[3]));
	  	 if($d){
		    $T=$d;
	  	 }else{
	  	    $T = -3;	
	  	 }
	  }
	}
	
echo $T;
mysql_close($enlace);
//**************************  funciones 

function crear_menu($path,$catalogo,$nombre,$enlace){
	global $db,$enlace;
 	$sqlZ = "INSERT INTO CAT_MENU(ID_CATALOGO,DESCRIPTION,URL,ACTIVO,ICONO,CREADO,TIPO)
	        VALUES ('".$catalogo."','".$nombre."','','S','CARPETA',CURRENT_TIMESTAMP,'M')";
  	//$queri = $db->sqlQuery($sqlZ);
  	if (mysql_query($sqlZ,$enlace)){
  		return 1;
  	  }else{
  		return -4;
  	  }
	
}



//---------------------------------------

function crear_sub_menu($idmenu,$nombre){
	global $db;
	$num_mayor = 0;

	$mayor = "SELECT IF(MAX(SECUENCIA) IS NULL,1,MAX(SECUENCIA)+1) AS MAXIMO FROM CAT_SUBMENU WHERE ID_MENU  =".$idmenu;
	$query_mayor = $db->sqlQuery($mayor);
	if($query_mayor){
		$count = $db->sqlEnumRows($query_mayor);
	
		if($count>0){
			$row_mayor = $db->sqlFetchArray($query_mayor);
			$num_mayor = $row_mayor['MAXIMO'];
			
	    }		
		 	$sqlZ = "INSERT INTO CAT_SUBMENU(ID_MENU,DESCRIPTION,ITEM_NUMBER,SECUENCIA,TIPO,ACCION,ACTIVO,ICONO_MOVIL)
             VALUES ('".$idmenu."','".$nombre."','---','".$num_mayor."','M','F','S','http://movi.2gps.net/catalogos/iconos/icon_s.png')";
		  	$queri = $db->sqlQuery($sqlZ);
		  	
			  if($queri){
			    return 1;
		      }else{
		  		return -1;
		  	  }
       	  
	}else{
		return -2;
	}
}

//---------------------

	function codif($in_str) {
		$cur_encoding = mb_detect_encoding($in_str);
		if( $cur_encoding == 'utf-8' && mb_check_encoding($in_str,'utf-8') )
			return $in_str;
		else
			return utf8_encode($in_str);
	}
	
	
?>
