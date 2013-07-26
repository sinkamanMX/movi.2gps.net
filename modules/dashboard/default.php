<?php
/**  
 * Vista por Dafault del modulo
 * @package dahsboard
 * @author	Enrique R. Peña Gonzalez
 * @since	2013-07-22
 */

$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
	$dashBoards = '';
	$categorias = '';
	$widgets	= '';
	
	$tpl->set_filenames(array('default'=>'default'));
	
	$widgetClass = new widgets();
	$widgetClass->setIdCliente($userAdmin->user_info['ID_CLIENTE']);
	$widgetClass->setIdUsuario($userAdmin->user_info['ID_USUARIO']);
	
	$widgetClass->getDashBoards();
	$widgetClass->getWidgetsAvailable();
	
	$arrayWidgets 	 	= $widgetClass->arrayDashBoards;
	$widgetsDisponibles	= $widgetClass->arrayWidgets;
		
	$totalDashBoards 	= count($arrayWidgets);
	$totalWidgets		= count($widgetsDisponibles);
		
	$categorias 	 	= $widgetClass->getWidgetsCategorias();
	
	if($totalDashBoards>0){
		for($i=0;$i<$totalDashBoards;$i++){
			$dashBoards.='<li><a href="#">'.$arrayWidgets[$i]['NOMBRE'].'</a></li>';
		}
				
		for($i=0;$i<$totalWidgets;$i++){
			$widgets.='<div class="widgetPanel">
                    <div class="widgetTittle">Widget 1</div>
                    <div class="widgetDesc">Este es un widget</div>
                    <div class="widgetImage4"></div>
                </div>';
		}				
	}	
		
	$tpl->assign_vars(array(
		'PATH'			=> $dir_mod,
		'PATH_IMG'		=> $dir_pimages,
		'USER'			=> $userAdmin->user_info['NOMBRE_COMPLETO'],
		'DASHBOARDS'	=> $dashBoards,
		'CATEGORIAS'	=> $categorias,
		'WIDGETS'		=> $widgets	
	));
	
	$tpl->pparse('default');