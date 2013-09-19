<?php
/**  
 * Obtiene
 * @package dahsboard
 * @author	Enrique R. Peña Gonzalez
 * @since	2013-07-22
 */

$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
    $result = 'no-data';
    if(isset($_GET['idWeek']) && isset($_GET['idGeo'])){
        $idWeek = $_GET['idWeek'];
        $idGeo  = $_GET['idGeo'];
        $sql = "SELECT 	CRM2_RESPUESTAS.ID_CUESTIONARIO, CRM2_CUESTIONARIOS.DESCRIPCION AS DES, 
                	CRM2_RESPUESTAS.NUM_SEMANA, 
                	CRM2_EJE_Z.ID_EJE_Z,
                	CRM2_EJE_Z.DESCRIPCION,
                	CRM2_RESPUESTAS.ID_EJE_Y, 
                	CRM2_EJE_Y.DESCRIPCION	,
                	CRM2_RESPUESTAS.ID_EJE_X,
                	CRM2_EJE_X.DESCRIPCION,	
                	CRM2_RESPUESTAS.ID_RES_CUESTIONARIO,
                	CRM2_RESPUESTAS.CALIFICACION,
                	CRM2_RESPUESTAS.*
                FROM CRM2_RESPUESTAS
                INNER JOIN CRM2_CUESTIONARIOS ON CRM2_RESPUESTAS.ID_CUESTIONARIO =  CRM2_CUESTIONARIOS.ID_CUESTIONARIO
                LEFT JOIN CRM2_EJE_X ON CRM2_RESPUESTAS.ID_EJE_X = CRM2_EJE_X.ID_EJE_X
                LEFT JOIN CRM2_EJE_Y ON CRM2_RESPUESTAS.ID_EJE_Y = CRM2_EJE_Y.ID_EJE_Y
                LEFT JOIN CRM2_EJE_Z ON CRM2_EJE_Y.ID_EJE_Z      = CRM2_EJE_Z.ID_EJE_Z
                LEFT JOIN ADM_GEOREFERENCIA_RESPUESTAS ON CRM2_RESPUESTAS.ID_RES_CUESTIONARIO = ADM_GEOREFERENCIA_RESPUESTAS.ID_RES_CUESTIONARIO
                LEFT JOIN ADM_GEOREFERENCIAS ON ADM_GEOREFERENCIAS.ID_OBJECT_MAP = ADM_GEOREFERENCIA_RESPUESTAS.ID_OBJECT_MAP
                WHERE NUM_SEMANA = ".$idWeek."
                AND CRM2_CUESTIONARIOS.ID_TIPO      = 3
                AND CRM2_CUESTIONARIOS.COD_CLIENT   = ".$userAdmin->user_info['ID_CLIENTE']."
                AND ADM_GEOREFERENCIA_RESPUESTAS.ID_OBJECT_MAP = ".$idGeo."
                ORDER BY CRM2_RESPUESTAS.NUM_SEMANA";
        $query = $db->sqlQuery($sql);
        $count = $db->sqlEnumRows($query);
        if($count>0){
            while($row = $db->sqlFetchAssoc($query)){
                $result = $row['DES'].'<br>'; 
            }
            /*$result = '	<table id="rspTableDet" border="0" cellpadding="0" cellspacing="0" class="pretty">
		<thead>
			<tr>
				<th>Tecnologia</th>
				<th>Area</th>
				<th>Capacitacion Resultados</th>
				<th>Post-Capacitacion (Mesa de Ayuda)</th>
				<th>Indicadores de Uso Post-Capacitacion</th>
			</tr>
			<!--<tr>
				<th>Programacion Logistica</th>
				<th>Conocimiento</th>
				<th>Competencias</th>
				<th>CRM</th>
				<th># Incidencias Facultador</th>
				<th>Personal</th>
				<th>Pacientes</th>
				<th>Promedio</th>
				<th>Última Semana</th>
			</tr>-->
		</thead></table>';     */    
        }else{
           $result = 'no-data-info'; 
        }
    }
    
    echo $result;