<?php
/** * 
 *  @package             
 *  @name                Las clases que  
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          13/04/2011
**/

	if(file_exists('config/config.php')){
		include 'config/config.php';
	}else{
		die('404 File etc/general.conf.php not found.');
	}
	
	if(file_exists('config/database.php')){
		include 'config/database.php';
	}else{
		die($lang['DB']['DB_ISSUES']['CONFIG_FILE_NOT_FOUND']);
	}
	
	if(file_exists('config/themes.php')){
		include 'config/themes.php';
	}else{
		die('404 File etc/themes.php not found.');
	}	
	
	//function __autoload($class_name){		
		global $config;
		$classes = array(
			'db' 	   		=> $config['libPath'].'db.lib.php', 
			'tpl'		   	=> $config['libPath'].'tpl.lib.php',
			'gd'  		   	=> $config['libPath'].'gd.lib.php', 
			'dbf'   		=> $config['libPath'].'dbFunctions.php',
			'userData'   	=> $config['libPath'].'user.administration.php',
			'Positions'		=> $config['libPath'].'c.Positions.php',
			'Functions'		=> $config['libPath'].'cFunctions.php',					
			'PHPMailer'   	=> $config['libPath'].'phpmailer.php',
			'PHPExcel'		=> $config['libPath'].'PHPExcel.php',
			'pData'	   		=> $config['libPath'].'/charts/pData.php',
			'pChart' 	   	=> $config['libPath'].'/charts/pChart.php',
			'pdf'		   	=> $config['libPath'].'/pdf/fpdf.php',
			'comands'	   	=> $config['libPath'].'c.Commands.php'
			);

		foreach($classes AS $i => $v){
			if(file_exists($v)){
				require_once($v);
			}else{
				echo $lang['MODULE']['MODULE_ISSUES']['MODULE_NOT_FOUND'];
			}
		}
	//}	
?>