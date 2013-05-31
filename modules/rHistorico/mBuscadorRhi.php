<?php
/** *              
 *  @name                Script que muestra los datos de un perfil
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          27/03/13
**/
	header('Content-Type: text/html; charset=UTF-8');
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	
	/*Se valida la variaable data, si esta viene y es diferente de 0 es uan edicion*/
	//if(isset($_GET['data']) || $_GET['data'] !=0){		
	
		//$s="";
		//$n="";
		//$empresa = $dbf->getRow('ADM_EMPRESAS','ID_EMPRESA = '.$_GET['data']);
		//echo $status = $dbf->getRow('ADM_EMPRESAS','ID_EMPRESA = '.$_GET['data']);
	//}else{
		//$s = (@$empresa['ACTIVO']=="S")?'selected="selected"':'';
		//$n = (@$empresa['ACTIVO']=="N")?'selected="selected"':'';
	//}
	
	
	
	
	
	
	$tpl->set_filenames(array('mBuscadorRhi' => 'tBuscadorRhi'));
	for($i=0;$i<24;$i++){		
			$hour = ($i < 10) ? '0'.$i : $i; 
			$chk  =  ($i == $d2[0]) ? 'selected="selected"':'';
			$chk2  = ($i == 23) ? 'selected="selected"':'';
			$tpl->assign_block_vars('hri',array(				
				'HR'    => '<option '.$chk.' value="'.$hour.'">'.$hour.'</option>',
				'HR2'   => '<option '.$chk2.' value="'.$hour.'">'.$hour.'</option>'
 			));			
		}
		
		for($i=0;$i<60;$i++){	
			$hour = ($i < 10) ? '0'.$i : $i; 
			$chk  =  ($i == $d2[1]) ? 'selected="selected"':'';
			$chk2  = ($i == 59) ? 'selected="selected"':'';
			$tpl->assign_block_vars('mni',array(
				'MN'    => '<option '.$chk.' value="'.$hour.'">'.$hour.'</option>',
				'MN2'   => '<option '.$chk2.' value="'.$hour.'">'.$hour.'</option>'				
 			));			
		}

		$week = Date('W') - 1;	
		
		for($i=1;$i<52;$i++){
			$chkw  = ($week == $i) ? 'selected="selected"':'';
			$tpl->assign_block_vars('weeks',array(
				'NO'   => '<option '.$chkw.' value="'.$i.'">'.$i.'</option>'			
 			));			
		}
		$rch="";
		for($i=10;$i<=1000;$i+=10){
			$rch = ($i == 100)?'selected="selected"':'';
			$tpl->assign_block_vars('rdo',array(
				'NO'   => '<option value="'.$i.'" '.$rch.'>'.$i.'</option>'			
 			));			
		}		
	$tpl->pparse('mBuscadorRhi');	
?>	