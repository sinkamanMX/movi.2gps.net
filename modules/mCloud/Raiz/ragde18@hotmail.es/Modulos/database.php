<?php
/** * 
 *  @package             
 *  @name                Controla las solicitudes de la pagina
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          13/04/2011
**/

//'host'  => '201.131.96.34',		//Host o ip donde se ubica la base de datos
	$config_bd = array(
		'port'  => '3306',			//Puerto de la base de datos
		'host'  => 'localhost',		//Host o ip donde se ubica la base de datos
		'bname' => 'precisiongps2',	//Nombre  de la base de datos
		'user' 	=> 'savl',			//usuario de la base de datos 
		'pass' 	=> 'precision'			//Contraseña de la base de datos
	);
	$config_bd2 = array(
		'port'  => '3306',			//Puerto de la base de datos
		'host'  => '192.168.6.45',		//Host o ip donde se ubica la base de datos
		'bname' => 'ALG_BD_CORPORATE_SAVL',	//Nombre  de la base de datos
		'user' 	=> 'savl_mon',			//usuario de la base de datos 
		'pass' 	=> 'vaio15R'			//Contraseña de la base de datos
	);
	$config_bd3 = array(
		'port'  => '3306',			//Puerto de la base de datos
		'host'  => '192.168.6.236',		//Host o ip donde se ubica la base de datos
		'bname' => 'ALG_BD_CORPORATE_ALERTAS',	//Nombre  de la base de datos
		'user' 	=> 'sa',			//usuario de la base de datos 
		'pass' 	=> '$0lstic3$'			//Contraseña de la base de datos
	);
	
	$config_bd_sp = array(
		'port'  => '3306',			//Puerto de la base de datos
		'host'  => 'localhost',		//Host o ip donde se ubica la base de datos
		'bname' => 'precisiongps2',	//Nombre  de la base de datos
		'user' 	=> 'savl',			//usuario de la base de datos 
		'pass' 	=> 'precision'			//Contraseña de la base de datos
	);		
	
	$config_bd_spa = array(
		'port'  => '3306',			//Puerto de la base de datos
		'host'  => '192.168.6.110',		//Host o ip donde se ubica la base de datos
		'bname' => 'ALG_BD_SPATIAL_V3',	//Nombre  de la base de datos
		'user' 	=> 'sa',			//usuario de la base de datos 
		'pass' 	=> '$0lstic3$'			//Contraseña de la base de datos
	);	
?>
