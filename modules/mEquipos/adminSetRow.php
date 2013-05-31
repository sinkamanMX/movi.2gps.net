<?php
/** * 
 *  @package             
 *  @name                Script que obtiene los datos a mostrar en la tabla
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$problems =0;
	$id_row=0;
	$response = array('result' => 'no-data');
	if(isset($_GET['desc']) && isset($_GET['itemn']) && isset($_GET['itemn2']) && isset($_GET['tel'])
	 	&& isset($_GET['imei']) && isset($_GET['time']) && isset($_GET['vid']) && isset($_GET['epo_equp'])  
  		&& isset($_GET['tx']) && isset($_GET['tr'])){	
	 	
 		$id_row = $_GET['epo_id'];	
		$desc	= $_GET['desc'];
		$itemn  = $_GET['itemn'];
		$itemn2 = $_GET['itemn2'];
		$tel    = $_GET['tel'];
		$imei   = $_GET['imei'];
 		$time   = $_GET['time'];
    	$msg    = $_GET['msg'];
    	$vid    = $_GET['vid'];
  		$voz    = $_GET['voz'];
  		$dchp   = $_GET['dchp'];
     	$unit   = $_GET['unit'];
     	$epo_equp= $_GET['epo_equp'];
     	$tx		= $_GET['tx'];
     	$tr		= $_GET['tr'];
		$eventos= $_GET['eventos'];
		$id_client = $_GET['id_client'];
		$id_company = $_GET['id_company'];	
		$id_tipo  = $_GET['epo_type'];
		
 		$data = Array(	 		
			'ID_CLIENTE' 		=> $id_client, 
			'COD_TYPE_EQUIPMENT'=> $epo_equp, 
			'DESCRIPCION'		=> $desc, 
			'ITEM_NUMBER'		=> $itemn, 
			'SECOND_ITEM_NUMBER'=> $itemn2, 
			'PORT_TX'			=> $tx, 
			'PORT_RX'			=> $tr,
			'PHONE'				=> $tel,
			'IMEI'				=> $imei,
			'FLAG_MENSAJES'		=> $msg, 
			'FLAG_VIDEO'		=> $vid,
			'FLAG_VOZ'			=> $voz,
			'TIME_REPORT'		=> $time,
			'FLAG_DHCP_ON'		=> $dchp
		);	
							
		if($id_row==0){				
			$dbf->insertDB($data,'ADM_EQUIPOS',true);
			$id_row = $dbf->get_last_insert();  			
		}else{
			$where = 'COD_EQUIPMENT ='.$id_row; 
			$dbf->updateDB('ADM_EQUIPOS',$data,$where,true);
			$dbf->deleteDB('ADM_UNIDADES_EQUIPOS',$where);
			$dbf->deleteDB('ADM_EVENTOS_SISTEMA',$where);						
		}

		if($id_tipo==0){			
			if($unit!="" && $unit!="null" ){
				$data_unit = Array(
		  			'COD_EQUIPMENT'	=> $id_row,
					'COD_ENTITY'    => $unit
		  		);
		  		$dbf->insertDB($data_unit,'ADM_UNIDADES_EQUIPOS',false);
			}			
		}else{
			$data_unitc = Array(
					'COD_TRADEMARK_MODEL'	=> $_GET['eqp_mod'],
					'COD_TYPE_ENTITY'   	=> $_GET['eqp_tip'],
					'DESCRIPTION'   		=> $_GET['eqp_des'],
					'PLAQUE'	    		=> $_GET['eqp_pla'],
					'BODYWORK_CODE'   		=> $_GET['eqp_ser'],
					'MOTOR_CODE'   			=> $_GET['eqp_mot'],
					'COD_CLIENT'	    	=> $id_client,
					'ID_EMPRESA'    		=> $id_company,
			);
			$dbf->insertDB($data_unitc,'ADM_UNIDADES',true);
			$id_unit = $dbf->get_last_insert();
			$data_unit = Array(
	  			'COD_EQUIPMENT'	=> $id_row,
				'COD_ENTITY'    => $id_unit
	  		);
	  		$dbf->insertDB($data_unit,'ADM_UNIDADES_EQUIPOS',false);	  		
			$data_gpo = array(
				'ID_GRUPO'		=> $_GET['eqp_gpo'],
				'COD_ENTITY'   	=> $id_unit,
				'FECHA_VIGENCIA'=> '00-00-00 00:00:00'
			);
			$dbf-> insertDB($data_gpo,'ADM_GRUPOS_UNIDADES',true);			  			  				
		}	
		
		if($eventos!=""){
  			for($i=0;$i<count($eventos);$i++){
  				$info  = explode("|",$eventos[$i]);
  				$id_sistema = $info[0];
  				$id_equipo  = $info[1];
  				
  				$data_eventos = Array(
  					'COD_EQUIPMENT'	=> $id_row, 
					'COD_EVENT'		=> $id_sistema,
					'COD_EVENT_EQUIPMENT'=> $id_equipo 
  				);
  				$dbf->insertDB($data_eventos,'ADM_EVENTOS_SISTEMA',false);
  			}			
		}
				
  		if($problems==0){  		
  			$response = array('result' => 'edit');
  		}
  	}		  
	echo json_encode($response);
?>