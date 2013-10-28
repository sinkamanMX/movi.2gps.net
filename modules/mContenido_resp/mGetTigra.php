<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
    $userData = new usersAdministration();
    if( !$userData-> u_logged() )
        echo '<script>window.location="index.php?mod=login&act=default"</script>';
        

	$tgr="SELECT TIGRA FROM SAVL4030 WHERE ACTIVO=1";
	$qry = $db->sqlQuery($tgr);
	$row_tgr = $db->sqlFetchArray($qry);
	echo $row_tgr['TIGRA'];
	

$db->sqlClose();
?>