<?php
/** * 
 *  @package             
 *  @name                error 404 pagina no encontrada  
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Pe�a 
 *  @modificado          27-04-2011
**/
	$tpl = new Template('../errors/template');	
	$tpl->set_filenames(array('error404'=>'error404'));	
	$tpl->pparse('error404');
?>