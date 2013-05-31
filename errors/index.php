<?php
/** * 
 *  @package             
 *  @name                Indice del modulo de errores
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          13/04/2011
**/
	error_reporting(0);
	include '../libs/tpl.lib.php';
	if(isset($_GET['e'])){
		$filename = $_GET['e'].'.php';
		if(file_exists($filename)){
			include $filename;
		}else{
			echo "<script>window.location='errors/index.php?e=error404';</script>";
		}
	}else{
		echo "<script>window.location='errors/index.php?e=error404';</script>";
	}	
?>