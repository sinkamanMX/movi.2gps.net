<?php
/*             
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          03/12/13
 *  @by					 Daniel Arazo
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged())
		echo '<script>window.location="index.php?m=login"</script>';	
		
	$db ->sqlQuery("SET NAMES 'utf8'");
	
	$cte = $userAdmin->user_info['ID_CLIENTE'];
	
	$tpl->set_filenames(array('mFormulario' => 'tFormulario'));
	
	$data_alm = $dbf->getRow('PED_ALMACEN','ID_ALMACEN = '.$_GET['id']);
	
	$dsc = @$data_alm['DESCRIPCION_ALMACEN'];
	$alm = @$data_alm['ITEM_NUMBER_ALMACEN'];
	$tda = @$data_alm['ITEM_NUMBER_TIENDA'];
	$zon = @$data_alm['ZONA'];
	$mer = @$data_alm['MERCADO'];
	$alo = @$data_alm['CAPACIDAD'];
	$obs = @$data_alm['OBSERVACIONES'];
	$pat = @$data_alm['ID_PATRON_MEDIDA'];
	$tipo = @$data_alm['ID_TIPO_PDI_UNIDAD'];
	
	$opt= get_id($pat);
	$C1 = $dbf->cbo_from_string2("ID_UNIDAD_MEDIDA","DESCRIPCION_UNIDAD","PED_UNIDAD_MEDIDA","1=1",$option=$opt);
	
	$opciones = '';
	$elegido  = 'selected="selected"';
	$sql = "SELECT * FROM PED_TIPO_UNIDAD_PDI";
	$queri = $db->sqlQuery($sql);
	
	if( $_GET['id'] != '0'){
	    
		while($rows = $db->sqlFetchArray($queri)){
		 /* if($opciones == ''){
		    if($rows['ID_TIPO']==$tipo){
		      $opciones = '<option value="'.$rows['ID_TIPO'].'" '.$elegido.' >'.$rows['DESCRIPCION'].' </option>';
		    }else{
		      $opciones = '<option value="'.$rows['ID_TIPO'].'" >'.$rows['DESCRIPCION'].' </option>';	
		    }
		  }else{
		  	if($rows['ID_TIPO']==$tipo){
		      $opciones = $opciones.'<option value="'.$rows['ID_TIPO'].'" '.$elegido.' >'.$rows['DESCRIPCION'].' </option>';
		    }else{
		      $opciones = $opciones.'<option value="'.$rows['ID_TIPO'].'" >'.$rows['DESCRIPCION'].' </option>';	
		    }
		  	
		  }*/
		  
		  if($opciones == ''){
		    if($rows['ID_TIPO']==$tipo){
		      $opciones = '<option value="'.$rows['ID_TIPO'].'" '.$elegido.' >'.$rows['DESCRIPCION'].' </option>';
		    }
		  }
		  
        }
	
	}else{
		while($rows = $db->sqlFetchArray($queri)){
		  if($opciones == ''){
		    $opciones = '<option value="-1"> Elija Opci&oacute;n</option>
			             <option value="'.$rows['ID_TIPO'].'" >'.$rows['DESCRIPCION'].' </option>';
		  }else{
		  	$opciones = $opciones.'<option value="'.$rows['ID_TIPO'].'" >'.$rows['DESCRIPCION'].' </option>';	
		  }
	  	}
	}
	
	
	
	$tpl->assign_vars(array(
	'ID'      	=> $_GET['id'],
	'OP'		=> $_GET['op'],
	'C1'		=> $C1,
	'DSC'		=> $dsc,
	'ALM'		=> $alm,
	'TDA'		=> $tda,
	'ZON'		=> $zon,
	'MER'		=> $mer,
	'ALO'		=> $alo,
	'OBS'		=> $obs,
	'PAT'		=> $pat,
	'OPT'		=> $opt,
	'TIP'       => $opciones
	));
	$tpl->pparse('mFormulario');	


	function get_id($pat){
		if($pat!=""){
			global $db;
			$sql = "SELECT ID_UNIDAD_MEDIDA FROM PED_PATRON_MEDIDA WHERE ID_PATRON_MEDIDA = ".$pat;
			$qry = $db->sqlQuery($sql);
			$cnt = $db->sqlEnumRows($qry);
			if($cnt>0){
				$row = $db->sqlFetchArray($qry);
				return $row['ID_UNIDAD_MEDIDA'];
				}
			else{
				return -1;
				}				
			}
		else{
			return -1;
			}
		}
?>	