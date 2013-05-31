<?php
/** * 
 *  @package             
 *  @name                Script que obtiene los datos a mostrar en la tabla
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe?a 
 *  @modificado          27/03/13
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$problems = 0;
	$id_row	  = 0;
	$response = array('result' => 'no-data');

	if(isset($_GET['epo_type']) && isset($_GET['id_client']) && isset($_GET['id_company']) 
  								&& isset($_GET['epo_id']) ){
  									
		$id_client 	= $_GET['id_client'];
		$id_company = $_GET['id_company'];	 	
 		$id_row 	= $_GET['epo_id'];	
  							
		$where = 'COD_EQUIPMENT ='.$id_row; 				
		$dbf->deleteDB('ADM_UNIDADES_EQUIPOS',$where);									
		$data_unitc = Array(
			'ID_CLIENTE'	    	=> $id_client
		);				
		$dbf->updateDB('ADM_EQUIPOS',$data_unitc,$where);  									
  									
		if($_GET['epo_type']==0){
			if(isset($_GET['id_unit'])){
				
				$data_unit = Array(
		  			'COD_EQUIPMENT'	=> $id_row,
					'COD_ENTITY'    => $id_unit
		  		);
		  		$dbf->insertDB($data_unit,'ADM_UNIDADES_EQUIPOS',false);
		  		
			}else{
				$response = array('result' => 'no-data');
				$problems++;
			}			
		}else{
			if(isset($_GET['eqp_mar']) && isset($_GET['eqp_mod']) && isset($_GET['eqp_tip'])    
				&&  isset($_GET['eqp_des'])  
		  		&& isset($_GET['eqp_pla']) && isset($_GET['eqp_gpo'])){	
		
				$eqp_mar = $_GET['eqp_mar'];
				$eqp_mod = $_GET['eqp_mod'];
				$eqp_tip = $_GET['eqp_tip'];
		 		$eqp_cli = $_GET['eqp_cli'];
		    	$eqp_des = $_GET['eqp_des'];
		    	$eqp_pla = $_GET['eqp_pla'];
		  		$eqp_ser = $_GET['eqp_ser'];
		  		$eqp_mot = $_GET['eqp_mot'];
		     	$eqp_gpo = $_GET['eqp_gpo'];
								
				$data_unitc = Array(
						'COD_TRADEMARK_MODEL'	=> $eqp_mod,
						'COD_TYPE_ENTITY'   	=> $eqp_tip,
						'DESCRIPTION'   		=> $eqp_des,
						'PLAQUE'	    		=> $eqp_pla,
						'BODYWORK_CODE'   		=> $eqp_ser,
						'MOTOR_CODE'   			=> $eqp_mot,
						'COD_CLIENT'	    	=> $id_client,
						'ID_EMPRESA'    		=> $id_company
				);
				$dbf->insertDB($data_unitc,'ADM_UNIDADES',true);
				$id_unit = $dbf->get_last_insert();
				$data_unit = Array(
		  			'COD_EQUIPMENT'	=> $id_row,
					'COD_ENTITY'    => $id_unit
		  		);
		  		$dbf->insertDB($data_unit,'ADM_UNIDADES_EQUIPOS',false);	  		
				$data_gpo = array(
					'ID_GRUPO'		=> $eqp_gpo,
					'COD_ENTITY'   	=> $id_unit,
					'FECHA_VIGENCIA'=> '00-00-00 00:00:00'
				);
				$dbf-> insertDB($data_gpo,'ADM_GRUPOS_UNIDADES',true);
			}else{
				$response = array('result' => 'no-data');
				$problems++;
			}
		}	
	}
	if($problems==0){  		
		$response = array('result' => 'edit');
	}			  
	echo json_encode($response);
?>