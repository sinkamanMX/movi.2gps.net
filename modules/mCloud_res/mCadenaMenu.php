<?php
    header('Content-Type: text/html; charset=UTF-8');
 	$db  = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

  
    if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
		
	$retornar = '';
 $sqlx = "SELECT ID_MENU,DESCRIPTION FROM CAT_MENU WHERE ID_CATALOGO = ".$_GET['catalogo'];
 $q = $db->sqlQuery($sqlx);
 if($q){
 //	echo $_GET['catalogo'];
 	 while($r = $db->sqlFetchArray($q)){
	  	  if($retornar ===''){
	  	  	  	$retornar = $r['ID_MENU'].','.$r['DESCRIPTION'];
	  	    }else{
	  	  	    	$retornar = $retornar .'|'.$r['ID_MENU'].','.$r['DESCRIPTION'];
	  	  }	
 	 }
 	 echo $retornar;
 }else{
 	echo 0;
 }

     
		
?>
