<?php
/** * 
 *  @package             4TOGO
 *  @name                Funciones comunes para utilizar 
 *  @copyright           Air Logistcs & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          24/03/2012
**/
class cFunctions{
	/*
	 * @Function Funcion que obtiene la fecha en formato definido
	 * @Params	
	 * @Return  String:fecha actual
	*/	
	function fecha(){
		date_default_timezone_set('UTC');
		
		$dia=date("l");
		if ($dia=="Monday") $dia="Lunes";
		if ($dia=="Tuesday") $dia="Martes";
		if ($dia=="Wednesday") $dia="Miércoles";
		if ($dia=="Thursday") $dia="Jueves";
		if ($dia=="Friday") $dia="Viernes";
		if ($dia=="Saturday") $dia="Sabado";
		if ($dia=="Sunday") $dia="Domingo";
			
		// Obtenemos el número del día
		$dia2=date("d");
			
		// Obtenemos y traducimos el nombre del mes
		$mes=date("F");
		if ($mes=="January") $mes="Enero";
		if ($mes=="February") $mes="Febrero";
		if ($mes=="March") $mes="Marzo";
		if ($mes=="April") $mes="Abril";
		if ($mes=="May") $mes="Mayo";
		if ($mes=="June") $mes="Junio";
		if ($mes=="July") $mes="Julio";
		if ($mes=="August") $mes="Agosto";
		if ($mes=="September") $mes="Setiembre";
		if ($mes=="October") $mes="Octubre";
		if ($mes=="November") $mes="Noviembre";
		if ($mes=="December") $mes="Diciembre";
			
		// Obtenemos el año
		$ano=date("Y");
	
		return $dia.' '.$dia2.' de '.$mes .' de '. $ano;
	}	
	  
	/*
	 * @Function Funcion que codifica en utf-8 alguna cadena
	 * @Params  String a codificar
	 * @Return  String codificado
	 */	
	function codif($in_str) {
		$cur_encoding = mb_detect_encoding($in_str);
		if( $cur_encoding == 'utf-8' && mb_check_encoding($in_str,'utf-8') )
			return $in_str;
		else
			return utf8_encode($in_str);
	}
	
	function cbo_select_padre($option='',$id_hijo='',$id_client){
		global $db,$userAdmin;
		$where_op = ($id_hijo!='') ? 'AND ADM_GRUPOS.ID_GRUPO <> '.$id_hijo: '';
		$first_op = ($id_hijo!='') ? '<option value="0" selected>Grupos</option>':'<option value="0" >Grupos</option>';
		$select = "".$first_op;
		$sql = "SELECT ADM_GRUPOS.ID_GRUPO AS ID, ADM_GRUPOS.NOMBRE,
				IF(AD_G.NOMBRE IS NULL ,'--',AD_G.NOMBRE) AS N_PADRE, ADM_CLIENTES.DESCRIPCION
				FROM ADM_GRUPOS
				 LEFT JOIN ADM_GRUPOS_CLIENTES 	ON ADM_GRUPOS.ID_GRUPO 		  = ADM_GRUPOS_CLIENTES.ID_GRUPO
				 LEFT JOIN ADM_GRUPOS_REL       ON ADM_GRUPOS_REL.ID_GRUPO_HIJO	  = ADM_GRUPOS_CLIENTES.ID_GRUPO
				 LEFT JOIN ADM_CLIENTES			ON ADM_GRUPOS_CLIENTES.ID_CLIENTE = ADM_GRUPOS_CLIENTES.ID_CLIENTE
				 LEFT JOIN ADM_GRUPOS  AD_G		ON AD_G.ID_GRUPO 		  = ADM_GRUPOS_REL.ID_GRUPO_PADRE
				 WHERE ADM_GRUPOS_CLIENTES.ID_CLIENTE  = ".$id_client."
					".$where_op."					  
			  	 GROUP BY ADM_GRUPOS.ID_GRUPO";		
		$query 	= $db->sqlQuery($sql);
		while($row = $db->sqlFetchArray($query)){
			$current = ($row['ID']==$option) ? 'selected': '';
			$select .= '<option '.$current.' value="'.$row['ID'].'" >'.$row['NOMBRE'].'</option>';
		}
		
		return $select;
	}	
	
	function rgb2html($r, $g=-1, $b=-1)
	{
    	if (is_array($r) && sizeof($r) == 3)
        	list($r, $g, $b) = $r;
	
    	$r = intval($r); $g = intval($g);
    	$b = intval($b);

    	$r = dechex($r<0?0:($r>255?255:$r));
    	$g = dechex($g<0?0:($g>255?255:$g));
    	$b = dechex($b<0?0:($b>255?255:$b));

    	$color = (strlen($r) < 2?'0':'').$r;
    	$color .= (strlen($g) < 2?'0':'').$g;
    	$color .= (strlen($b) < 2?'0':'').$b;
    	return '#'.$color;
	}	
	
	function cbo_from_array($array,$option=''){
		$options='';
		for($p=0;$p<count($array);$p++){
			$select='';
			if($array[$p][id]==@$option){$select='selected';}
			$options .= '<option '.$select.' value="'.$array[$p]['id'].'" >'.$array[$p]['name'].'</option>';
		}
		return $options;		
	}
	
  public function cbo_number($n,$option=''){
	  for($i=0; $i<$n; $i++){
		  $h = ($i<=9)?"0".$i:$i;
		  $current = ($h==$option) ? 'selected': '';
		  $select .= '<option '.$current.' value="'.$h.'" >'.$h.'</option>';
		  }
	  return $select;  		    
	  }		
}
?>