<?php
    header('Content-Type: text/html; charset=UTF-8');
 	$db  = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

  
    if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';
	
    	$sqlX= "SELECT COD_EVENT,DESCRIPTION FROM ADM_EVENTOS
			WHERE ID_CLIENTE = ".$userAdmin->user_info['ID_CLIENTE'];
			
$queriX = $db->sqlQuery($sqlX);
//	    
	$count = $db->sqlEnumRows($queriX);

//
	if($count>0){
		$tpl->set_filenames(array('mCombo2' => 'tCombo2'));
	         while($rowX = $db->sqlFetchArray($queriX)){
	      	    $tpl->assign_block_vars('evento',array(
						'COD_EVENTO'   => $rowX['COD_EVENT'],
						'DESCRTIPCION'  => $rowX['DESCRIPTION']
				));
          }
		$tpl->pparse('mCombo2');
	}else{
		
		echo 0;
	}
     
		
?>
