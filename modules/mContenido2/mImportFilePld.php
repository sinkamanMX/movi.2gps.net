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
$archi="";	
	
//BORRAR ARCHIVOS CARPETA CONTENEDORA
$dir = opendir("/public/Despacho/tmp");
$ruta = "/public/Despacho/tmp";
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



//Funciones
//validar el formato del archivo excel
function validar_formato_excel(){
global $mensaje, $archi;	
$extensiones_permitidas = array('xls','ccc'); 
$max_size = 0;

$archivo = @$_FILES['excel_pld'];
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
			pintar_data();
			//generar_data();
			//validar_data();		
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
//---------------------------------
function pintar_data(){
	global $archi,$mensaje;
	ini_set("display_errors",1);
	error_reporting(E_ALL);
	require_once 'excel_reader2.php';
	$excel = new Spreadsheet_Excel_Reader($archi);
	$data = "";
	
	//$mensaje .= count($excel->sheets);
	//Recorrer hojas
	if(is_readable($archi)) {
	for($s=0; $s<count($excel->sheets)-1; $s++) {
		//REcorrer contenido de la hoja.
		
		//Recorrer renglon
		for ($row=4;$row<=$excel->rowcount();$row++){
			$rdos='B';
			$pr = "";
			for($col=1; $col<$excel->colcount(); $col++){
				if($excel->val($row,$rdos,$s)!=""){
					$pr .= ($pr=="")
					?$excel->val(2,$rdos,$s)."¬".$excel->val($row,$rdos,$s)
					:"|".$excel->val(2,$rdos,$s)."¬".$excel->val($row,$rdos,$s);
					}
					$rdos++;
				}
				
				$data .= ($data=="")
				?"(".$excel->val(2,'A',$s).",".get_com($excel->val($row,'A',$s)).",'".$pr."','".date('Y-m-d H:i:s')."')"
				:",(".$excel->val(2,'A',$s).",".get_com($excel->val($row,'A',$s)).",'".$pr."','".date('Y-m-d H:i:s')."')";
				
				datos_previos($excel->val(2,'A',$s),get_com($excel->val($row,'A',$s)));
			}
		}
	//$mensaje .= $data;
	}
	else{
		$mensaje .= '<table border="0" width="100%">';
		$mensaje .= '<tr><td>';
		$mensaje .="El archivo ".$archi." no puede ser procesado por el sistema.";
		$mensaje .='</td></tr>';
		$mensaje .='</table>';
		}
	save_data($data);
	}	
//-----------------------------------
function datos_previos($idc,$pdi){
	global $db;
	$sql = "SELECT ID_CUESTIONARIO,COD_OBJECT_MAP FROM SAVL_G_PAYLOAD WHERE ID_CUESTIONARIO = ".$idc." AND COD_OBJECT_MAP = ".$pdi;
    $query = $db->sqlQuery($sql);
	$count=  $db->sqlEnumRows($query);	
	if($count>0){
		$sql_a = "DELETE FROM SAVL_G_PAYLOAD WHERE ID_CUESTIONARIO = ".$idc." AND COD_OBJECT_MAP = ".$pdi.";";
		$qry_a = $db->sqlQuery($sql_a);
		}
	
	}
//-----------------------------------
function get_com($item_number){
	global $db;
	$sql = "SELECT COD_OBJECT_MAP FROM SAVL_G_PRIN S WHERE ITEM_NUMBER='".trim($item_number)."'";
    $query = $db->sqlQuery($sql);
	$count=  $db->sqlEnumRows($query);	
	$row=$db->sqlFetchArray($query);
	return($row['COD_OBJECT_MAP']);
	}
//-----------------------------------	
function save_data($data){
	global $db,$mensaje;
	if($data!=""){
		
		
		$sql = "INSERT INTO SAVL_G_PAYLOAD (ID_CUESTIONARIO,COD_OBJECT_MAP,CADENA_PAYLOAD,FECHA_CREADO) VALUES".$data;
		$qry = $db->sqlQuery($sql);
		if($qry == true){		
				$mensaje .= '<table border="0" width="100%">';
				$mensaje .= '<tr><td>';
				$mensaje .="El payload ha sido almacenado satisfactoriamente.";
				$mensaje .='</td></tr>';
				$mensaje .='</table>';		
			}
		else{
			//echo  mysql_errno();
			if(mysql_errno()==1062){
				$mensaje .= '<table border="0" width="100%">';
				$mensaje .= '<tr><td>';
				$mensaje .="Los datos ya han sido almacenados anteriormente, revise su archivo excel y vuelva a intentarlo.";
				$mensaje .='</td></tr>';
				$mensaje .='</table>';
				}
			else{	
			$mensaje .= '<table border="0" width="100%">';
			$mensaje .= '<tr><td>';
			$mensaje .= "Los datos no han sido almacenados, vuelva a intentarlo mas tarde.";
			$mensaje .='</td></tr>';
			$mensaje .='</table>';		
			}
			}	
		}
		else{
			$mensaje .= '<table border="0" width="100%">';
			$mensaje .= '<tr><td>';
			$mensaje .="Revise los datos de su archivo excel.";
			$mensaje .='</td></tr>';
			$mensaje .='</table>';		
			}
	}
?>
<script language="JavaScript"> 
 	var m ='<?php echo $mensaje; ?>'; 
	var mensaje =m;
	parent.mensaje_pld(mensaje);
</script>


