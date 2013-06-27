<?php
/** * 
 *  @package             
 *  @name                Controla las solicitudes de la pagina
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          13/04/2011
**/
	include 'config/on_load.php';
	include "public/libs/MobileDetect/Mobile_Detect.php";	
	$detect = new Mobile_Detect();

	header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );  // disable IE caching
	header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" ); 
	header( "Cache-Control: no-cache, must-revalidate" ); 
	header( "Pragma: no-cache" );	
	if($detect->isMobile() | $detect->isTablet() ){
		header('Location: http://'.$config['domain']);
	}else{	
		$userAdmin = new usersAdministration();
		$Positions = new cPositions();
		$Functions = new cFunctions();
		
		if(isset($_GET['m'])){		
			$file = "modules/".$_GET['m']."/index.php";		
			if(file_exists($file)){
				include $file;
			}else{
				include 'errors/index.php';
			}
		}else{
			echo "<script>window.location='index.php?m=".$config['mlogin']."'</script>";
		}	
	}	
?>