<?php
/** * 
 *  @package             
 *  @name                Inserta datos en la base a traves de excel.
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              Rodwyn Moreno
 *  @modificado          11-08-2011
**/

header("Expires: Mon, 20 Mar 1998 12:01:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	if(!$userAdmin->u_logged()){
		echo '<script>window.location="index.php?m=login"</script>';
	}

$idc   = $userAdmin->user_info['COD_CLIENT'];
$idu   = $userAdmin->user_info['COD_USER'];
$mensaje ="";
$sap_it = array();
$und_id = array();
$und_nm = array();
$ent_it = array();
$sap_in = array();
$sap_no = array();
$und_no = array();
$und_ok = array();
$tv = array();
$ent_ex = array();
$tv_no = array();
$hr_no = array();	
$archi="";
$du=0;
$emi = array();
$imh = array();
$emf = array();
$ems = array();
$smf = array();
$smi = array();
$sme = array();
$dsp = array();
$dsp_in = array();
$dates=0;
$vls="";
$dsp2=array();
$r=0;
$vls_i="";
$valus="";
$d=0;
$ce=array();

//BORRAR ARCHIVOS CARPETA CONTENEDORA
 $dir = opendir("public/Despacho");
$ruta = "public/Despacho/";
while (($file = readdir($dir)) !== false){
   if( $file != '.' && $file != '..'){ 
    if(is_file($ruta.$file)){
  	 	     chmod($ruta.$file,0777);
    	  if(!unlink($ruta.$file)){
			  $mensaje = "Ha ocurrido un error al procesar la informaci&oacuten;n;";
    		}
  	}
  }	
}
closedir($dir);

validar_formato_excel();
//generar_data();
//validar_data();


	
	


//Funciones
//validar el formato del archivo excel
function validar_formato_excel(){
global $mensaje, $archi;	
$extensiones_permitidas = array('xls','ccc'); 
$max_size = 0;

$archivo = @$_FILES['excel'];
if (!$archivo){
	$mensaje = 'Ha Ocurrido un error al subir el archivo.';
}
$permiso = true; //Variable que utilizaremos para ir dando permiso a las diferentes acciones


$nombre_archivo = $archivo['name'];
$peso_archivo = $archivo['size'] / 1024;
$tmp_archivo = $archivo['tmp_name'];
$extension_archivo = extension($nombre_archivo);

if ($max_size > 0 and $peso_archivo > $max_size){
	 $permiso = false;
	 $mensaje = 'El archivo excede los <b>' . $max_size . '</b> kb de peso. El archivo pesa <b>' . round($peso_archivo) . ' kb</b>';
}
//Si no se ha denegado el permiso en la operación anterior, nos aseguraremos de que el archivo tenga alguna de las extensiones permitidas.

if ($permiso && !in_array($extension_archivo, $extensiones_permitidas)){
		$permiso = false;
		$mensaje =  '<table border="0" width="100%">';
		$mensaje .= '<tr><td colspan="2" align="center">&nbsp; </td></tr>';
        $mensaje .= '<tr><td colspan="2" align="center" >El archivo: <b>'.$nombre_archivo.' tiene un formato no aceptado</b></td></tr>';
		$mensaje .= '<tr><td colspan="2" align="center">No puede ser procesado</td></tr>';
		$mensaje .= '<tr><td colspan="2" align="center">Descargue el formato en el icono de descarga</td></tr>';
		$mensaje .= '<tr><td colspan="2" align="center">Y copie sus datos en el</td></tr>';
		$mensaje .= '</table>';
}
	if ($permiso && @move_uploaded_file($tmp_archivo, $directorio . $nombre_archivo)){
		$archi=$directorio . $nombre_archivo;
			$mensaje =  '<table border="0" width="100%">';
			$mensaje .= '<tr><td align="center"> Archivo Procesado &nbsp;<b>'.$nombre_archivo.'</b></td></tr>';
			$mensaje .= '</table>';	
			generar_data();
			validar_data();		
		}else{
			$mensaje .=  '<table border="0" width="100%">';
			$mensaje .= '<tr><td align="center" >El archivo: <b>'.$nombre_archivo.'</b></td></tr>';
			$mensaje .= '<tr><td align="center">No puede ser procesado</td></tr>';
			$mensaje .= '<tr><td align="center">Formato Incorrecto</td></tr>';
			$mensaje .= '<tr><td align="center">Descargue el formato en el icono de descarga</td></tr>';
			$mensaje .= '<tr><td align="center">Y copie sus datos en el</td></tr>';
			$mensaje .= '</table>';
		}
}
//-------------------------------------------------------------------
 function extension($archivo){
 	$dat = explode('.', $archivo);
 	return $dat[count($dat)-1];
 }
//--------------------------------------------------------------------
function generar_data(){
	global $db,$idc,$idu,$sap_it,$und_id,$und_nm,$ent_it,$tv,$dsp,$dsp_in;
	//OBTENER SAP CLIENTE
	$sql = "SELECT S.COD_OBJECT_MAP, S.ITEM_NUMBER FROM SAVL_G_PRIN S WHERE S.COD_CLIENT=".$idc;
    $query = $db->sqlQuery($sql);
	$count=  $db->sqlEnumRows($query);	
		while($row=$db->sqlFetchArray($query)){
			$sap_it [] = $row['ITEM_NUMBER'];
			//$sap_id [] = $row['ITEM_NUMBER']."¬".$row['COD_OBJECT_MAP'];
		}
	//OBTENER UNIDADES
	$sql_a = "SELECT S.COD_ENTITY,S.DESCRIPTION FROM SAVL1120 S
	INNER JOIN SAVL1220_GDET B ON B.COD_ENTITY = S.COD_ENTITY 
	INNER JOIN SAVL1220_G A ON A.ID_GROUP = B.ID_GROUP 
	WHERE A.COD_CLIENT =".$idc;
    $qry_a = $db->sqlQuery($sql_a);
	$cnt_a=  $db->sqlEnumRows($qry_a);	
		while($row_a=$db->sqlFetchArray($qry_a)){
			$und_id [] = $row_a['DESCRIPTION']."¬".$row_a['COD_ENTITY'];
			$und_nm [] = $row_a['DESCRIPTION'];
		}
	//OBTENER ENTREGAS 
	 $sql_b = "SELECT D.ITEM_NUMBER FROM DSP_ITINERARIO D INNER JOIN SAVL1100 U  WHERE U.COD_CLIENT=".$idc." GROUP BY D.ID_ENTREGA";
	 //$sql_b = "SELECT D.ITEM_NUMBER FROM DSP_ITINERARIO D INNER JOIN SAVL1100 U ON U.COD_USER=D.COD_USER WHERE U.COD_CLIENT=".$idc;
     $qry_b = $db->sqlQuery($sql_b);
	 $cnt_b =  $db->sqlEnumRows($qry_b);	
		while($row_b=$db->sqlFetchArray($qry_b)){
			$ent_it [] = $row_b['ITEM_NUMBER'];
					}
	//OBTENER TIPO VOLUMEN
	 $tv = array();
	 $sql_k="SELECT D.ABREVIATURA FROM DSP_TIPO_VOLUMEN D";
     $qry_k = $db->sqlQuery($sql_k);
	 $cnt_k =  $db->sqlEnumRows($qry_k);
		while($row_k=$db->sqlFetchArray($qry_k)){
			$tv [] = $row_k['ABREVIATURA'];
					}
	// OBTENER DESPACHOS 
	 $sql_c = "SELECT D.ID_DESPACHO, D.ITEM_NUMBER FROM DSP_DESPACHO D INNER JOIN SAVL1100 U ON U.COD_USER=D.COD_USER WHERE U.COD_CLIENT=".$idc;
     $qry_c = $db->sqlQuery($sql_c);
	 $cnt_c =  $db->sqlEnumRows($qry_c);	
		while($row_c=$db->sqlFetchArray($qry_c)){
			$dsp [] = $row_c['ITEM_NUMBER'];
			$did [] = $row_c['ITEM_NUMBER']."¬".$row_c['ID_DESPACHO'];
		}						
	}
//--------------------------------------------------------------------
function validar_data(){
	global $archi,$sap_it,$und_id,$und_nm,$ent_it,$tv,$sap_in,$sap_no,$und_no,$und_ok,$ent_ex,$du,$tv_no,$hr_no,$emi,$mensaje,$dates,$emf,$ems,$smf,$smi,$sme,$imh;
	$ert="/(0[1-9]|1[0-9]|2[0-3]):([0-5][0-9]):?([0-5][0-9])? ?/i";
	$erf="/(0[1-9]|1[0-9]|2[0-9]|3[0-1]).(0[1-9]|1[0-2]).?(\d{4})?/i";
	$vn="";
	$un="";
	ini_set("display_errors",1);
	error_reporting(E_ALL);
	require_once 'excel_reader2.php';
	$excel = new Spreadsheet_Excel_Reader($archi);
	
	for ($row=2;$row<=$excel->rowcount();$row++) {
		//Validar Cliente
	//if($excel->val($row,'D')!=""){
		if ($excel->val($row,'D')!="" && !in_array($excel->val($row,'D'), $sap_it)){
		$sap_no[]=$excel-> val($row,'D');
		}
		//else{
			if($excel->val($row,'D')!="" && !in_array($excel->val($row,'D'), $sap_in)){
		$sap_in	[] = $excel-> val($row,'D');
			}
			//}
	//}	
		//Validar unidades
	//if($excel->val($row,'G')!=""){
		if ($excel->val($row,'G')!="" && !in_array($excel->val($row,'G'), $und_nm) && !in_array($excel->val($row,'G'), $und_no)){
		$und_no[]=$excel-> val($row,'G');
		}
		else{
			//if(!in_array($excel->val($row,'G'), $und_ok)){
		$und_ok [] = $excel-> val($row,'G');
			//}
			}
	//}	
		//Validar entregas
		//if($excel->val($row,'E')!=""){
			if ($excel->val($row,'E')!="" && in_array($excel->val($row,'E'), $ent_it)){
			$ent_ex[]=$excel-> val($row,'E');
			}
		//}
		//Validar despacho x unidad
		//if($excel->val($row,'B')!=""){
			if($excel->val($row,'B')!="" && $excel->val($row,'B')==$vn){
				if($excel->val($row,'G')!=$un){
					$du++;
					}
					else{
						$un=$excel->val($row,'G');
						}
				}
			else{
				$vn=$excel->val($row,'B');
				$un=$excel->val($row,'G');
				}	
			//}		
		//Validar tipo de volumen
	//if($excel->val($row,'I')!=""){
		if ($excel->val($row,'I')!="" && !in_array($excel->val($row,'I'), $tv) && !in_array($excel->val($row,'I'), $tv_no)){
		$tv_no[]=$excel-> val($row,'I');
		}
	//}
		//Validar fechas y horas
		//Validar hora inicio del viaje
		//////////////////////////////////////////////////////	
		//if($excel->val($row,'A')!=""){
			if ($excel->val($row,'A')!="" && !preg_match($ert, $excel->val($row,'A'))){
			$hr_no[]=$excel-> val($row,'A');
			}
		//}
		//Validar fecha inicio del viaje
		//if($excel->val($row,'K')!=""){
			if ($excel->val($row,'C')!="" && !preg_match($erf, $excel->val($row,'C'))){
			$hr_no[]=$excel-> val($row,'C');
			}
		//}		
		//Validar fecha estimada arribo
			if ($excel->val($row,'J')!="" && !preg_match($erf, $excel->val($row,'J'))){
			$hr_no[]=$excel-> val($row,'J');
			}		
		//Validar hora de entrada
			if ($excel->val($row,'K')!="" && !preg_match($ert, $excel->val($row,'K'))){
			$hr_no[]=$excel-> val($row,'K');
			}
		//Validar fecha estimada de salida
			if ($excel->val($row,'L')!="" && !preg_match($erf, $excel->val($row,'L'))){
			$hr_no[]=$excel-> val($row,'L');
			}
		//Validar hora de salida
			if ($excel->val($row,'M')!="" && !preg_match($ert, $excel->val($row,'M'))){
			$hr_no[]=$excel-> val($row,'M');
			}
		//Validar fecha fin del viaje
			if ($excel->val($row,'O')!="" && !preg_match($erf, $excel->val($row,'O'))){
			$hr_no[]=$excel-> val($row,'O');
			}			
		//Validar hora de llegada
			if ($excel->val($row,'P')!="" && !preg_match($ert, $excel->val($row,'P'))){
			$hr_no[]=$excel-> val($row,'P');
			}
		//Comparación de fechas
			if(count($hr_no)==0){
			//Formato a las fechas.
			$date_a = new DateTime($excel->val($row,'C')." ".$excel->val($row,'A'));
			$date_a = date_format($date_a, 'Y-m-d H:i:s');	
			$date_b = new DateTime($excel->val($row,'O')." ".$excel->val($row,'P'));
			$date_b = date_format($date_b, 'Y-m-d H:i:s');
			$date_c = new DateTime($excel->val($row,'J')." ".$excel->val($row,'K'));
			$date_c = date_format($date_c, 'Y-m-d H:i:s');	
			$date_d = new DateTime($excel->val($row,'L')." ".$excel->val($row,'M'));
			$date_d = date_format($date_d, 'Y-m-d H:i:s');
			
			//Validar fechas mayores o iguales a la fecha actual
			//$mensaje .=  $date_a." <= ".date('Y-m-d H:i:s')."<br>";
			/*if($date_a < date('Y-m-d H:i:s')){
				$dates++;
				$imh[]=$date_a;
				}
			if($date_b < date('Y-m-d H:i:s')){
				$dates++;
				$imh[]=$date_b;
				}
			if($date_c < date('Y-m-d H:i:s')){
				$dates++;
				$imh[]=$date_c;
				}
			if($date_d< date('Y-m-d H:i:s')){
				$dates++;
				$imh[]=$date_d;
				}	*/					
			//Validar fecha de entrega no debe ser menor a la fecha de inicio del viaje
			if($date_c < $date_a){
			$dates++;
			$emi[]=$date_c;
				}	
			//Validar fecha de entrega no debe ser mayor a la fecha de fin de viaje
			if($date_c > $date_b){
				$dates++;
				$emf[]=$date_c;
					}
			//Validar fecha de entrega no debe ser mayor a fecha de salida 
			if($date_c > $date_d){
				$dates++;
				$ems[]=$date_c;
					}
			//Validar fecha de salida no debe ser mayor a fecha fin de viaje
			if($date_d > $date_b){
				$dates++;
				$smf[]=$date_d;
					}
			//Validar fecha de salida no debe ser menor a fecha inicio de viaje
			if($date_d < $date_a){
				$dates++;
				$smi[]=$date_d;
					}
			//Validar fecha de salida no debe ser menor a fecha de entrega
			if($date_d < $date_c){
				$dates++;
				$sme[]=$date_d;
					}									
				}
				
	}
	if(count($sap_no)==0 && count($und_no)==0 && count($ent_ex)==0 && $du==0 && count($tv_no)==0 && count($hr_no)==0 && $dates==0){
		almacenar_data();
		}
	else{
		mensaje_error();
		}	
}
//--------------------------------------------------------------------
function mensaje_error(){
	global $mensaje,$sap_no,$und_no,$ent_ex,$du,$tv_no,$hr_no,$emi,$emf,$ems,$smf,$smi,$sme,$imh;
	//Mensajes de error unidades
		if(count($sap_no)>0){
				$mensaje .=  '<table border="0" width="100%">';
				$mensaje .= '<tr><td align="center">SAP Cliente(s) Inexistente(s)</td></tr>';	 
				$mensaje .= '<tr><td>';
		for($x=0; $x<count($sap_no); $x++){
			$mensaje.=$sap_no[$x]."<br>";
			}
			$mensaje.='</td></tr>';
			$mensaje.='</table>';
		 }
	//Mensajes de error unidades	 
		if(count($und_no)>0){
				$mensaje .= '<table border="0" width="100%">';
				$mensaje .= '<tr><td align="center">Unidad(es) Inexistente(s)</td></tr>';	 
				$mensaje .= '<tr><td>';
		for($x=0; $x<count($und_no); $x++){
			$mensaje.=$und_no[$x]."<br>";
			}
			$mensaje.='</td></tr>';
			$mensaje.='</table>';
		 }		 
	//Mensajes de error entregas
		if(count($ent_ex)>0){
				$mensaje .= '<table border="0" width="100%">';
				$mensaje .= '<tr><td align="center">Pedido(s) registarado(s) previamente</td></tr>';	 
				$mensaje .= '<tr><td>';
		for($x=0; $x<count($ent_ex); $x++){
			$mensaje.=$ent_ex[$x]."<br>";
			}
			$mensaje.='</td></tr>';
			$mensaje.='</table>';
		 }
	//Mensaje de error despacho X unidad
		if($du>0){
				$mensaje .= '<table border="0" width="100%">';
				$mensaje .= '<tr><td align="center">Viaje asignado a dos o mas unidades</td></tr>';	 
				$mensaje .= '</table>';	
			}
	//Mensaje de error tipo de entrega
		if(count($tv_no)>0){
			$h=0;
				$mensaje .= '<table border="0" width="100%">';
				$mensaje .= '<tr><td align="center">Unidad(es) de medida incorrecto(s)</td></tr>';	 
				$mensaje .= '<tr><td>';
		for($x=0; $x<count($tv_no); $x++){
			$mensaje.=$tv_no[$x]."<br>";
			}
			$mensaje.='</td></tr>';
			$mensaje.='</table>';
		 }
	//Mensaje de error tiempo fecha
		if(count($hr_no)>0){
			$h=0;
				$mensaje .= '<table border="0" width="100%">';
				$mensaje .= '<tr><td align="center">Fecha(s) Incorrecta(s)</td></tr>';	 
				$mensaje .= '<tr><td>';
		for($x=0; $x<count($hr_no); $x++){
			$mensaje.=$hr_no[$x]."<br>";
			}
			$mensaje.='</td></tr>';
			$mensaje.='</table>';
		 }
	//Mensaje error fecha inicio
		if(count($emi)>0){
			$h=0;
				$mensaje .= '<table border="0" width="100%">';
				$mensaje .= '<tr><td align="center">Fecha(s) de entrega menor(es) a la fecha de inicio del viaje.</td></tr>';	 
				$mensaje .= '<tr><td>';
		for($x=0; $x<count($emi); $x++){
			$mensaje.=$emi[$x]."<br>";
			}
			$mensaje.='</td></tr>';
			$mensaje.='</table>';
		 }
	//Mensaje error fecha entrega viaje mayor a fecha finn viaje
		if(count($emf)>0){
			$h=0;
				$mensaje .= '<table border="0" width="100%">';
				$mensaje .= '<tr><td align="center">Fecha(s) de entrega mayor(es) a la fecha de fin de viaje</td></tr>';	 
				$mensaje .= '<tr><td>';
		for($x=0; $x<count($emf); $x++){
			$mensaje.=$emf[$x]."<br>";
			}
			$mensaje.='</td></tr>';
			$mensaje.='</table>';
		 }
	//Mensaje error fecha entrega mayor a fecha salida
		if(count($ems)>0){
		$h=0;
			$mensaje .= '<table border="0" width="100%">';
			$mensaje .= '<tr><td align="center">Fecha(s) de entrega mayor(es) a la fecha de salida</td></tr>';	 
			$mensaje .= '<tr><td>';
		for($x=0; $x<count($ems); $x++){
			$mensaje.=$ems[$x]."<br>";
			}
			$mensaje.='</td></tr>';
			$mensaje.='</table>';
	 	}	
	//Mensaje error fecha salida mayor a fecha fin de viaje
		if(count($smf)>0){
			$h=0;
				$mensaje .= '<table border="0" width="100%">';
				$mensaje .= '<tr><td align="center">Fecha(s) de salida mayor(es) a la fecha de fin de viaje</td></tr>';	 
				$mensaje .= '<tr><td>';
		for($x=0; $x<count($smf); $x++){
			$mensaje.=$smf[$x]."<br>";
			}
			$mensaje.='</td></tr>';
			$mensaje.='</table>';
		 }
	//Mensaje error fecha salida mayor a fecha de inicio de viaje
		if(count($smi)>0){
			$h=0;
				$mensaje .= '<table border="0" width="100%">';
				$mensaje .= '<tr><td align="center">Fecha(s) de salida menor(es) a la fecha de inicio del viaje</td></tr>';	 
				$mensaje .= '<tr><td>';
		for($x=0; $x<count($smi); $x++){
			$mensaje.=$smi[$x]."<br>";
			}
			$mensaje.='</td></tr>';
			$mensaje.='</table>';
		 }
	//Mensaje error fecha salida mayor a fecha de entrega
		if(count($sme)>0){
			$h=0;
				$mensaje .= '<table border="0" width="100%">';
				$mensaje .= '<tr><td align="center">Fecha(s) de salida menor(es) a la fecha de entrega</td></tr>';	 
				$mensaje .= '<tr><td>';
		for($x=0; $x<count($sme); $x++){
			$mensaje.=$sme[$x]."<br>";
			}
			$mensaje.='</td></tr>';
			$mensaje.='</table>';
		 }
	//Mensaje error fechas menores a fecha actual
		if(count($imh)>0){
			$h=0;
				$mensaje .= '<table border="0" width="100%">';
				$mensaje .= '<tr><td align="center">Fecha(s) menor(es) a la fecha actual</td></tr>';	 
				$mensaje .= '<tr><td>';
		for($x=0; $x<count($imh); $x++){
			$mensaje.=$imh[$x]."<br>";
			}
			$mensaje.='</td></tr>';
			$mensaje.='</table>';
		 }		 		 		 		 
	}
///////////////////////////////////////////////////////////////////
function almacenar_data(){
	global $sap_no,$und_no,$ent_ex,$du,$tv_no,$hr_no,$dates,$mensaje,$archi,$dsp,$dsp2,$vls,$idu,$db,$r,$vls_i,$valus,$d,$ce;
	require_once 'excel_reader2.php';
	$excel = new Spreadsheet_Excel_Reader($archi);
		
		for ($row=2;$row<=$excel->rowcount();$row++) {
			$c=0;
			if($excel->val($row,'B')!=""){
				if ((!in_array($excel->val($row,'B'), $dsp)) && (!in_array($excel->val($row,'B'), $dsp2))){
					$dsp2[]=$excel-> val($row,'B');
					$dti = new DateTime($excel->val($row,'J')." ".$excel->val($row,'A'));
					$dti = date_format($dti, 'Y-m-d H:i:s');
					$dtf = new DateTime($excel->val($row,'O')." ".$excel->val($row,'P'));
					$dtf = date_format($dtf, 'Y-m-d H:i:s');
										
				 $vls=($vls=="")?"(4,".$idu.",'".$excel->val($row,'B')."',0,'".$excel->val($row,'B')."','".$dti."','".$dtf."','".date('Y-m-d H:i:s')."')":$vls.",(4,".$idu.",'".$excel->val($row,'B')."',0,'".$excel->val($row,'B')."','".$dti."','".$dtf."','".date('Y-m-d H:i:s')."')";
				$r++;
				}
				else{
					$sql_g="SELECT D.ID_DESPACHO FROM DSP_DESPACHO D WHERE D.ITEM_NUMBER = '".$excel->val($row,'B')."'";
					$qry_g = $db->sqlQuery($sql_g);
					$row_g=$db->sqlFetchArray($qry_g);
					$dsp_in [] = $row_g['ID_DESPACHO'];
					$c++;
					}
			}
		}
		if($vls!=""){
			$sql_d = "INSERT INTO DSP_DESPACHO (ID_ESTATUS,COD_USER,DESCRIPCION,TOLERANCIA, ITEM_NUMBER,FECHA_INICIO,FECHA_FIN, CREADO)VALUES".$vls;
			$qry_d = $db->sqlQuery($sql_d);
			if($qry_d==true){
				//$h=1;

				$mensaje .= '<table border="0" width="100%">';
				$mensaje .= '<tr><td>';
				$mensaje .="Se insertaron ".$r." viaje(s) con exito";
				$mensaje .='</td></tr>';
				$mensaje .='</table>';
				}
			}		
		//INGRESAR DATA DSP_ITINERARIO
		for ($row=2;$row<=$excel->rowcount();$row++) {
			if($excel->val($row,'B')!=""){
				$sql_h = "SELECT D.ID_DESPACHO FROM DSP_DESPACHO D WHERE D.ITEM_NUMBER='".$excel->val($row,'B')."'";
				$qry_h = $db->sqlQuery($sql_h);
				$row_h = $db->sqlFetchArray($qry_h);
				
				
				
				$sql_i = "SELECT S.COD_OBJECT_MAP FROM SAVL_G_PRIN S WHERE S.ITEM_NUMBER =".$excel->val($row,'D');
				$qry_i = $db->sqlQuery($sql_i);
				$row_i = $db->sqlFetchArray($qry_i);
				
				$sql_j = "SELECT S.COD_ENTITY FROM SAVL1120 S INNER JOIN SAVL1220_GDET B ON B.COD_ENTITY = S.COD_ENTITY INNER JOIN SAVL1220_G A ON A.ID_GROUP = B.ID_GROUP WHERE S.DESCRIPTION ='".$excel->val($row,'G')."'";
				$qry_j = $db->sqlQuery($sql_j);
				$row_j = $db->sqlFetchArray($qry_j);

				$sql_l = "SELECT D.ID_TIPO_VOLUMEN FROM DSP_TIPO_VOLUMEN D WHERE D.ABREVIATURA='".$excel->val($row,'I')."'";
				$qry_l = $db->sqlQuery($sql_l);
				$row_l = $db->sqlFetchArray($qry_l);
				
				
				$f= explode(".",$excel->val($row,'J'));
				$hs = explode(" ",$excel->val($row,'K'));
				
				//$he = ($hs[1]=="a.m." | $hs[1]=="am")?substr($excel->val($row,'K'),0,7):(substr($excel->val($row,'K'),0,1)+12).substr($excel->val($row,'K'),2,7);
				//str_replace(" ","",$he);
				$fecha = date_create($excel->val($row,'K'));
				$he=date_format($fecha, 'H:i:s');
				$dte= "'".$f[2]."-".$f[1]."-".$f[0]." ".$he."'";
				$ob=($excel->val($row,'N')==""| $excel->val($row,'N')==" " | count($excel->val($row,'N'))==0 | $excel->val($row,'N')==NULL)?"''":"'".$excel->val($row,'N')."'";
				
				//$dt="'".$excel->val($row,'J')." ".$excel->val($row,'N')."'";
				$dt = new DateTime($excel->val($row,'L')." ".$excel->val($row,'M'));
				$dtx= date_format($dt, 'Y-m-d H:i:s');

				
				
				
				if ((!in_array($excel->val($row,'B'), $ce))){
				$valus = ($valus=="")?"(".$row_h['ID_DESPACHO'].",".$row_j['COD_ENTITY'].",'".date('Y-m-d H:i:s')."',1,0)":$valus.",(".$row_h['ID_DESPACHO'].",".$row_j['COD_ENTITY'].",'".date('Y-m-d H:i:s')."',1,0)";	
				$ce[] = $excel->val($row,'B');
				}
				
				$vls_i = ($vls_i=="")?"(".$row_h['ID_DESPACHO'].",4,".$row_i['COD_OBJECT_MAP'].",".$idu.",".$excel->val($row,'E').",".$ob.",".$dte.",'".date('Y-m-d H:i:s')."',".$excel->val($row,'F').",".$row_l['ID_TIPO_VOLUMEN'].",'".$dtx."')":$vls_i.",(".$row_h['ID_DESPACHO'].",4,".$row_i['COD_OBJECT_MAP'].",".$idu.",".$excel->val($row,'E').",".$ob.",".$dte.",'".date('Y-m-d H:i:s')."',".$excel->val($row,'F').",".$row_l['ID_TIPO_VOLUMEN'].",'".$dtx."')";
				$d++;
				}
		}
		
		$sql_f = "INSERT INTO DSP_UNIDAD_ASIGNADA (ID_DESPACHO, COD_ENTITY, FECHA_ASIGNACION, ACTIVO, LIBRE) VALUES ".$valus;
		$qry_f = $db->sqlQuery($sql_f);
			if($qry_f==true){
				
		$sql_e = "INSERT INTO DSP_ITINERARIO (ID_DESPACHO, ID_ESTATUS, COD_GEO, COD_USER, ITEM_NUMBER, COMENTARIOS, FECHA_ENTREGA, CREADO, VOLUMEN, ID_TIPO_VOLUMEN,FECHA_FIN) VALUES ".$vls_i;
		$qry_e = $db->sqlQuery($sql_e);
		if($qry_e==true){
			$h=1;			
				$mensaje .= '<table border="0" width="100%">';
				//$mensaje .= '<tr><td align="center">Pedido(s) Inexistente(s)</td></tr>';	 
				$mensaje .= '<tr><td>';
				$mensaje .="Se insertaron ".$d." entrega(s)";
				$mensaje .='</td></tr>';
				$mensaje .='</table>';
				//echo $mensaje;		
			}
		}
	}	
?>
<script language="JavaScript"> 
 	var m ='<?php echo $mensaje; ?>'; 
	var mensaje =m;
	parent.mensaje(mensaje);
</script>