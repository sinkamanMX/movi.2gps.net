<?php
/*
*/  header('Content-Type: text/html; charset=UTF-8');
   	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
    if(!$userAdmin->u_logged()){
    		echo '<script>window.location="index.php?m=login"</script>';
    }
    
     $UTF8 = "SET NAMES 'utf8'";
     $db->sqlQuery($UTF8);
    
	echo $_GET['cade'];
 	$cadenad = explode(",",$_GET['cade']);
 	
	$T=9999;
	$ct='-';
	$cs='*';
	
	$a = array('�','�','�','�','�','�', '�','�', '�','�', '�', '�',' ');
    $b = array('a','A','e','E','i','I', 'o' ,'O', 'u','U', 'n', 'N', '_');

	//echo $directorio=dirname(__FILE__).'/Raiz/ragde18@hotmail.es';
	$cadena='';
	$down='/modules/mCloud/Raiz/ragde18@hotmail.es/';
	$path=reemplaza(str_replace(" ","_",utf8_decode($_GET['ulr'])));
	$la_ruta  ='';
	
	if($cadenad[0] === '1' && $cadenad[1] ==='0'){
	  $la_ruta = $path; 
	}
	
	 if($cadenad[0]  ==='0' && $cadenad[1]  ==='1'){
	 	  $la_ruta = $path.'_'.$cadenad[4]; 
	 }
	
	if(!mkdir($la_ruta, 0777, true )){
	  $T=-8;
	}else{
	  chmod($la_ruta,0777);
	  
	  if($cadenad[0] === '1' && $cadenad[1] ==='0'){
	  	$d = crear_menu($path,$cadenad[2],$cadenad[3]);
	  	 if($d){
		    $T=$d;
	  	 }else{
	  	    $T = 0;	
	  	 }
	  }
	  if($cadenad[0]  ==='0' && $cadenad[1]  ==='1'){
	  	 $d = crear_sub_menu($cadenad[4],($cadenad[3]));
	  	 if($d){
		    $T=$d;
	  	 }else{
	  	    $T = -3;	
	  	 }
	  }
	}
	
echo $T.$path;

//**************************  funciones 

function crear_menu($path,$catalogo,$nombre){
	global $db;
 	$sqlZ = "INSERT INTO CAT_MENU(ID_CATALOGO,DESCRIPTION,URL,ACTIVO,ICONO,CREADO,TIPO,DESCRIPTION2)
	        VALUES ('".$catalogo."','".$nombre."','','S','CARPETA',CURRENT_TIMESTAMP,'M','".reemplaza(utf8_decode($nombre))."')";
  	$queri = $db->sqlQuery($sqlZ);
	  if($queri){
  		return 1;
  	  }else{
  		return -4;
  	  }
	
}

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
		 	$sqlZ = "INSERT INTO CAT_SUBMENU(ID_MENU,DESCRIPTION,ITEM_NUMBER,SECUENCIA,TIPO,ACCION,ACTIVO,ICONO_MOVIL,DESCRIPTION2)
                     VALUES ('".$idmenu."','".$nombre."','---','".$num_mayor.
					 "','M','F','S','http://".$_SERVER['HTTP_HOST']."/catalogos/iconos/icon_s.png','".reemplaza(utf8_decode($nombre.'_'.$idmenu))."')";
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
	
	//-----------------------------

function reemplaza($cadena_x){
$regresa = '';
$a = array('�','�','�','�','�','�', '�','�', '�','�', '�', '�',' ');
$b = array('a','A','e','E','i','I', 'o' ,'O', 'u','U', 'n', 'N', '_');

$regresa = str_replace($a, $b,$cadena_x);
return $regresa;
}	
//------------------------------------

function limpiar_caracteres_especiales($s) {
	$s = ereg_replace("[����]","a",$s);
	$s = ereg_replace("[����]","A",$s);
	$s = ereg_replace("[���]","e",$s);
	$s = ereg_replace("[���]","E",$s);
	$s = ereg_replace("[���]","i",$s);
	$s = ereg_replace("[���]","I",$s);
	$s = ereg_replace("[�����]","o",$s);
	$s = ereg_replace("[����]","O",$s);
	$s = ereg_replace("[���]","u",$s);
	$s = ereg_replace("[���]","U",$s);
	$s = str_replace(" ","_",$s);
	$s = str_replace("�","n",$s);
	$s = str_replace("�","N",$s);
	//para ampliar los caracteres a reemplazar agregar lineas de este tipo:
	//$s = str_replace("caracter-que-queremos-cambiar","caracter-por-el-cual-lo-vamos-a-cambiar",$s);
	return $s;
}

function normaliza ($cadena){ 
$originales = '�����������'; 
$modificadas = 'AEINOUaeino'; 
$cadena = utf8_decode($cadena); 
$cadena = strtr($cadena, utf8_decode($originales), $modificadas); 
$cadena = strtolower($cadena); 
return utf8_encode($cadena); 
} 
?>
