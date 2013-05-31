<?php
/** * 
 *  @package             
 *  @name                Script que logea al usuario  
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          26/04/2011
**/
	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	if(isset($_GET['md'])){		
		if($_GET['md']=='lg'){//Login
			$response = array('result'=>'1');
			if(isset($_GET['vuname']) && isset($_GET['vpass'])){			
				$userName = $_GET['vuname'];
				$userPass = $_GET['vpass'];
				$response['result'] = $userAdmin->f_userlogin($userName,$userPass);
				if($response['result']==1){
					$response['url'] = $userAdmin->validar_menu();
				}
			}else{
				$response['result'] = 0;
			}
			echo json_encode( $response );
		}else if($_GET['md']=='lo'){//Logout
			$userAdmin->log_out();
            echo '<script>window.location="index.php?m=login"</script>';
		}	
	}
?>