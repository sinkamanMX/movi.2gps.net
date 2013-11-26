<?php
    header('Content-Type: text/html; charset=UTF-8');
 	$db  = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

    	$sqlX= "SELECT * FROM CAT_CATALOGO_BANDERA";
        $queriX = $db->sqlQuery($sqlX);
    	$count = $db->sqlEnumRows($queriX);

	if($count>0){
  	   $rowX = $db->sqlFetchArray($queriX);
	    if($rowX['BANDERA']=='1'){
		    	$sql= "UPDATE CAT_CATALOGO_BANDERA SET BANDERA = 0";
                $queri = $db->sqlQuery($sql);
		         if($queri){
				 echo 1;
				 }else{
				   echo 0;
				 }
		   
		}else{
		   echo 0;
		}   
	
	}else{
		echo 99;
	}
?>
