<?php
/*              
 *  @name                Formulario para unidad de medida
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Daniel Arazo
 *  @modificado          2013-11-27
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
		
	$db ->sqlQuery("SET NAMES 'utf8'");
	
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	
	$tpl->set_filenames(array('mFormulario' => 'tFormulario'));
	

	//----------------------------------------------------------------------------------
	
	if($_GET['op']==2){  
		$fun = $dbf->getRow('PED_PATRON_MEDIDA','ID_PATRON_MEDIDA = '.$_GET['id']);
		//````````
		$id_patron =  @$fun['ID_PATRON_MEDIDA']; 
		$id_unidad_medida =  @$fun['ID_UNIDAD_MEDIDA']; 
		$nom = @$fun['DESCRIPCION'];
		$rep = @$fun['REPRESENTACION'];
		
		
			
		$tpl->assign_vars(array(
		    'PATRON'  => $id_patron,
		    'UNIDAD'  => $id_unidad_medida,
			'NOM'     => $nom,
			'REP'     => $rep,
			'ID'      	=> $_GET['id'],
			'OP'		=> $_GET['op'],
			'RESTO'   => cargar_combo($id_unidad_medida)
			 ));
		}else{
				$tpl->assign_vars(array(
				'ID'      	=> $_GET['id'],
				'OP'		=> $_GET['op'],
				'RESTO'     => cargar_combo(0)
				));
		}
   //----------------------------------------------------------------------------------- 
   	
	$tpl->pparse('mFormulario');
	
	//------------------------------
	
	function cargar_combo($clave){
		global $db;
		$opciones = '';
	    $selec = '';
	 
    	$sql = "SELECT * FROM PED_UNIDAD_MEDIDA";
		$queri = $db->sqlQuery($sql);
		while($rows = $db->sqlFetchArray($queri)){
		  if($clave > 0){
		       if($opciones === ''){
		         if($rows['ID_UNIDAD_MEDIDA'] == $clave){
		         	$selec = ' selected="selected"';
		         }else{
		         	$selec = '';
		         }	
			   	 $opciones = ' <option value="'.$rows['ID_UNIDAD_MEDIDA'].'" '.$selec.'>'.$rows['DESCRIPCION_UNIDAD'].'</option>';
			   
			   }else{
			     if($rows['ID_UNIDAD_MEDIDA'] == $clave){
		         	$selec = ' selected="selected"';
		         }else{
		         	$selec = '';
		         }	
			   	 $opciones = $opciones.' <option value="'.$rows['ID_UNIDAD_MEDIDA'].'" '.$selec.'>'.$rows['DESCRIPCION_UNIDAD'].'</option>';
			   
			   }
		  
		  }else{
		  		if($opciones === ''){
			   	 $opciones = ' <option value="'.$rows['ID_UNIDAD_MEDIDA'].'">'.$rows['DESCRIPCION_UNIDAD'].'</option>';
			   }else{
			   	 $opciones = $opciones.' <option value="'.$rows['ID_UNIDAD_MEDIDA'].'">'.$rows['DESCRIPCION_UNIDAD'].'</option>';
			   }
		  } 
		   
	    
		}
		
		return $opciones;
	}
	
		
?>	