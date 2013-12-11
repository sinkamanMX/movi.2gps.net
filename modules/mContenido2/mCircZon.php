<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';
		
	$tpl->set_filenames(array('default'=>'default'));	
	$idc   = $userAdmin->user_info['ID_CLIENTE'];
    
	$sql = "SELECT ID_ZONA,
	DESCRIPCION	
	FROM DSP_ZONA WHERE ID_CLIENTE=".$idc;						 	
		
			$cadena=' ';
	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){
					
					if($cadena==' '){
						$cadena= '<option id="'.$row['ID_CIRCUITO'].'" >'. $row['DESCRIPCION'].'</option>';
					}else{
					
						$cadena= $cadena.'<option id="'.$row['ID_CIRCUITO'].'" >'. $row['DESCRIPCION'].'</option>';
							
						}
				}
				
						
			}else{
			 $cadena=0;	
			}
		
		echo $cadena;
	
	
	
	
$db->sqlClose();
?>