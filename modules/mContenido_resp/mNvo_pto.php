<?php
header('Content-Type: text/html; charset=UTF-8');
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

if(!$userAdmin->u_logged()){echo '<script>window.location="index.php?m=login"</script>';}		
		
$tpl->set_filenames(array('mNvo_pto' => 'tNvo_pto'));


$tpl->pparse('mNvo_pto');
$db->sqlClose();
?>