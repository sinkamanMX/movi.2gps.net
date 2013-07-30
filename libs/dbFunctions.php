<?php
/** * 
 *  @package             
 *  @name                Indice del modulo  
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Enrique Peña 
 *  @modificado          13/04/2011
**/

class dbFunctions{
	//public $conexion;
	
	/*public function connect_bd($conexion){
		global $config;
		$conexion = @mysqli_connect($config_bd['host'],$config_bd['user'],$config_bd['pass'],$config_bd['name']);
		return $conexion;	
	}
	
	public function disconnect_bd($conexion){
		@mysqli_close($conexion);
	}	*/
	
  public function insertDB($items, $table, $sleep){
    global $db;
    if(!is_array($items)){
      echo 'Parametros Invalidos para Insertar en la Base de Datos';
      return false;
    }else{
      $itemsv = "";
      $values = "";
      foreach($items As $i => $v){
        $itemsv .= $i.",";
        $values .= "'".$v."',";
      }
      $itemsv = substr($itemsv, 0, -1);
      $values = substr($values, 0, -1);

      $sql = "INSERT INTO ".$table." (".$itemsv.") VALUES (".$values.")";

      if($sleep) sleep(2);
	  
      if($db-> sqlQuery($sql)){
          return true;
      }else{
          return false;
      }
    }
  }
  public function deleteDB($table, $where){
    global $db;

    if($where != null || $table != null){
        $sql = 'DELETE FROM '.$table.' WHERE '.$where.'';
        if($db-> sqlQuery($sql)){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
  }

  public function updateDB($table, $items, $where){
    global $db;

    if(is_array($items)){
        $it = '';
        foreach($items AS $i => $v){
            $it .= $i." = '".$v."',";
        }
        $it = substr($it, 0, -1);

        $sql = "UPDATE ".$table." SET ".$it." WHERE ".$where;

        if($db-> sqlQuery($sql)){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
  }
  
  public function updateDBi($table, $items, $where){
    global $db;

    if(is_array($items)){
        $it = '';
        foreach($items AS $i => $v){
            $it .= $i." = ".$v.",";
        }
        $it = substr($it, 0, -1);

        $sql = "UPDATE ".$table." SET ".$it." WHERE ".$where;

        if($db-> sqlQuery($sql)){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
  }
  
  public function getRow($table,$where){
  	global $db;
  	$sql = "SELECT * FROM ".$table." WHERE ".$where." LIMIT 1";
  	$query = $db->sqlQuery($sql);
  	return $row   = $db->sqlFetchArray($query);
  }
  
  public function cbo_from($id,$desc,$table,$where,$option=''){
	global $db,$Functions;
	$select = '';
	$sql = "SELECT ".$id." AS ID,".$desc." AS DES
			FROM ".$table." WHERE ".$where;	
	$query = $db->sqlQuery($sql);
	$count = $db->sqlEnumRows($query);
	if($count>0){
		$currentdefault = ($option!="")?'selected':'';
		$select .= '<option value="-1" '.$currentdefault.'>Seleccionar</option>';
		while($row = $db->sqlFetchArray($query)){
			$current = ($row['ID']==$option) ? 'selected': '';
			$select .= '<option '.$current.' value="'.$row['ID'].'" >'.$Functions->codif($row['DES']).'</option>';
		}
	}	
	return $select;  	
  }

  public function cbo_from_all($id,$desc,$table,$where,$option=''){
	global $db,$Functions;
	$select = '';
	$sql = "SELECT ".$id." AS ID,".$desc." AS DES
			FROM ".$table." WHERE ".$where;	
	$query = $db->sqlQuery($sql);
	$count = $db->sqlEnumRows($query);
	if($count>0){
		$currentdefault = ($option!="")?'selected':'';
		$select .= '<option value="-1" '.$currentdefault.'>Todos</option>';
		while($row = $db->sqlFetchArray($query)){
			$current = ($row['ID']==$option) ? 'selected': '';
			$select .= '<option '.$current.' value="'.$row['ID'].'" >'.$Functions->codif($row['DES']).'</option>';
		}
	}	
	return $select;  	
  }
  
  public function tabla_temas($stema){
	  global $db;
	  $tr =1;
	  $s = "";
	  $tbl = '<table align="center"><tr>';
	  $sql = "SELECT * FROM CRM2_TEMA";
	  $qry = $db->sqlQuery($sql);
	  $cnt = $db->sqlEnumRows($qry);
	  if($cnt>0){
		  while($row = $db->sqlFetchArray($qry)){
			  if($stema!=""){
				  $s = ($row['ID_TEMA']==$stema)?'checked="checked"':"";
				  }
			  else{
				  $s = ($tr==1)?'checked="checked"':"";
				  }
				  $tbl.= '<td>
				  		 <div style="width:100px; height:140px;">
						 <div style="width:100%; height:35px; background:'.$row['CABECERA'].';"></div>
						 <div style="width:100%; height:15px; background:'.$row['BARRA'].';"></div>
						 <div style="width:100%; height:50px; background:'.$row['CUERPO'].';"></div>
						 <div style="width:100%; height:40px;"><input type="radio" name="tema" '.$s.'  
						 value="'.$row['ID_TEMA'].'"/>
						 <label>'.$row['NOMBRE'].'</label></div>
						 </div>
						 </td>';
					$tbl.= (($tr%3)==0)?'<tr>':'';
					$tr++;

			  }
			  $tbl.= '</table>';
			  return $tbl;
		  }
	  }
	  
public function dragndrop($id,$des,$tbl,$whr,$pr,$txt){
	global $db;
	$p = '';
	$com = ($pr=="")?"":" AND ".$id." NOT IN (".$pr.") ";
	$w = ($txt=="")?"":" AND ".$des." LIKE '%".$txt."%' ";
	$sql = "SELECT ".$id." AS ID, ".$des." AS DES FROM ".$tbl.$whr.$com.$w." ORDER BY DES;";
	$qry = $db->sqlQuery($sql);
	$cnt = $db->sqlEnumRows($qry);
	if($cnt>0){
		while($row = $db->sqlFetchArray($qry)){
			$p.= '<div class="ui-corner-all" id="'.$row['ID'].'">'.$row['DES'].'</div>';
			}
		
		return $p;	
		}
	}
	
  public function cbo_from_notit($id,$desc,$table,$where,$option=''){
	  global $db;
	  $w = ($where=="")?"":" WHERE ".$where;
	   $sql = "SELECT ".$id." AS ID,".$desc." AS DES
	  		  FROM ".$table.$w;
	  $query = $db->sqlQuery($sql);
	  $count = $db->sqlEnumRows($query);
	  if($count>0){
		  $currentdefault = ($option!="")?'selected':'';
		  while($row = $db->sqlFetchArray($query)){
			  $current = ($row['ID']==$option) ? 'selected': '';
			  $select .= '<option '.$current.' value="'.$row['ID'].'" >'.$row['DES'].'</option>';
			  }
		  }
	  return $select;
	  }	
  
  public function cbo_from_string($id,$desc,$table,$where,$option=''){
	global $db,$Functions;
	$select = '';
	$sql = "SELECT ".$id." AS ID,".$desc." AS DES
			FROM ".$table." WHERE ".$where;	
	$query = $db->sqlQuery($sql);
	$count = $db->sqlEnumRows($query);
	if($count>0){
		$currentdefault = ($option!="")?'selected':'';
		$select .= '<option value="-1" '.$currentdefault.'>Seleccionar</option>';
		while($row = $db->sqlFetchArray($query)){
			$current = ($row['DES']==$option) ? 'selected': '';
			$select .= '<option '.$current.' value="'.$row['ID'].'" >'.$Functions->codif($row['DES']).'</option>';
		}
	}	
	return $select;  	
  }  
  
  public function cbo_from_enum($table,$column,$option=''){
	global $db;
	$select = '';
	$sql = "DESCRIBE  ".$table." ".$column;
		
	$query = $db->sqlQuery($sql);
	$count = $db->sqlEnumRows($query);
	if($count>0){
		$row = $db->sqlFetchArray($query);
		$data_column = substr($row['Type'], 0,-1);// se elimina el ultimo caracter 		
		$data_column = str_replace("enum(","",$data_column);				
		$data_column = str_replace("'","",$data_column);
		
		$a_data = explode(",",$data_column);
		for($i=0;$i<count($a_data);$i++){
  			$current = ($a_data[$i]==$option) ? 'selected': '';
  			$select .= '<option '.$current.' value="'.$a_data[$i].'" >'.$a_data[$i].'</option>';			
		}
	}	
	return $select;  	
  }
  
  public function cbo_from_query($id,$desc,$s_query,$option='',$showtext=true){
 	global $db,$Functions;
	$select = '';
	$sql = "SELECT ".$id." AS ID,".$desc." AS DES ".$s_query;
	$query = $db->sqlQuery($sql);
	$count = $db->sqlEnumRows($query);
	if($count>0){
		$currentdefault = ($option!="")?'selected':'';
		if($showtext){$select .= '<option value="-1" '.$currentdefault.'>Seleccionar</option>';}
		while($row = $db->sqlFetchArray($query)){
			$current = ($row['DES']==$option) ? 'selected': '';
			$select .= '<option '.$current.' value="'.$row['ID'].'" >'.$Functions->codif($row['DES']).'</option>';
		}
	}else{
		if($showtext){$select .= '<option value="-1" '.$currentdefault.'>Vacio</option>';}		
	}	
	return $select;  	
  }
  
  public function get_last_insert(){
	global $db;
		$sql 	= "SELECT LAST_INSERT_ID() AS ID;";
		$query 	= $db->sqlQuery($sql);
		$row 	= $db->sqlFetchArray($query);	
	return $row['ID'];  	
  }
  
}
?>