<?php
/**  
 * Vista por Dafault del modulo
 * @package dahsboard
 * @author	Enrique R. Peña Gonzalez
 * @since	2013-07-22
 */

$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	
    $currentWeek = date("W"); 
	
	$tpl->set_filenames(array('default'=>'default'));
    
    /*Centros de Salud*/
    $sqlGeos = "FROM ADM_GEOREFERENCIA_RESPUESTAS ge
                INNER JOIN ADM_GEOREFERENCIAS gr ON ge.ID_OBJECT_MAP = gr.ID_OBJECT_MAP
                WHERE ID_CLIENTE = ".$userAdmin->user_info['ID_CLIENTE']."
                GROUP BY gr.ID_OBJECT_MAP";    
    $resultQuery = $dbf->cbo_from_query("gr.ID_OBJECT_MAP","gr.DESCRIPCION",$sqlGeos,'',true);               
    
    /*Numeros de Semana*/
    $sqlWeek = "FROM CRM2_RESPUESTAS 
                INNER JOIN CRM2_CUESTIONARIOS 
                   ON CRM2_RESPUESTAS.ID_CUESTIONARIO =  CRM2_CUESTIONARIOS.ID_CUESTIONARIO
                WHERE CRM2_CUESTIONARIOS.ID_TIPO  = 3
                AND CRM2_CUESTIONARIOS.COD_CLIENT = ".$userAdmin->user_info['ID_CLIENTE']."
                AND  NUM_SEMANA IS NOT NULL
                GROUP BY NUM_SEMANA";
    $resultWeek = $dbf->cbo_from_query("NUM_SEMANA","NUM_SEMANA",$sqlWeek,$currentWeek,true);    
        
	$tpl->assign_vars(array(
		'PATH'			=> $dir_mod,
		'PATH_IMG'		=> $dir_pimages,
        'CBO_GEOS'      => $resultQuery,
        'CBO_WEEKS'     => $resultWeek
	));
	
	$tpl->pparse('default');