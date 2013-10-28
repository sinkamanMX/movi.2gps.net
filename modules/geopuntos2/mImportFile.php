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
$db ->sqlQuery("SET NAMES 'utf8'");

$idc   = $userAdmin->user_info['ID_CLIENTE'];
$idu   = $userAdmin->user_info['ID_USUARIO'];
$mensaje ="";
$archi = "";
$directorio = "public/tmp/geopunto/";
$a_itm = array();
$a_dsc = array();
$a_itm_no = array();
$a_dsc_no = array();

//BORRAR ARCHIVOS CARPETA CONTENEDORA
 $dir = opendir("public/tmp/geopunto");
$ruta = "public/tmp/geopunto/";
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

//Validar formato archivo
validar_formato_excel();



//Funciones
//validar el formato del archivo excel
function validar_formato_excel(){
global $mensaje, $archi, $directorio;	
$extensiones_permitidas = array('xls','ccc'); 
$max_size = 0;

$archivo = @$_FILES['geo_excel'];
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
		$mensaje .= '<tr><td colspan="2" align="center">Este debe tener la extensi&oacute;n xls</td></tr>';
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
	global $db,$idc,$a_itm,$a_dsc;
	//OBTENER descricpión e item de los geopuntos del cliente
	$sql = "SELECT ITEM_NUMBER,DESCRIPCION FROM ADM_GEOREFERENCIAS WHERE ID_CLIENTE = ".$idc;
    $qry = $db->sqlQuery($sql);
	$cnt=  $db->sqlEnumRows($qry);	
		while($row = $db->sqlFetchArray($qry)){
			$a_itm [] = "".$row['ITEM_NUMBER']."";
			$a_dsc [] = "".$row['DESCRIPCION']."";
		}
}
//--------------------------------------------------------------------
function validar_data(){
	global $archi,$a_itm,$a_dsc,$a_itm_no,$a_dsc_no;
	ini_set("display_errors",1);
	error_reporting(E_ALL);
	require_once 'excel_reader2.php';
	$excel = new Spreadsheet_Excel_Reader($archi);
	
	for ($row=2;$row<=$excel->rowcount();$row++) {
		//Validar item
		if ($excel->val($row,'A')!="" && in_array("".$excel->val($row,'A')."", $a_itm)){
			$a_itm_no[]=$excel-> val($row,'A');
			}
		//Validar descripción	
		if ($excel->val($row,'B')!="" && in_array("".$excel->val($row,'B')."", $a_dsc)){
			$a_dsc_no[]=$excel-> val($row,'B');
			}			
		}
	if(count($a_itm_no)==0 && count($a_dsc_no)==0){
		almacenar_data();
		}
	else{
		mensaje_error();
		}			
	}
//--------------------------------------------------------------------
function mensaje_error(){
	global $mensaje,$a_itm_no,$a_dsc_no;
	//Mensajes de error items
	if(count($a_itm_no)>0){
		$mensaje .=  '<table border="0" width="100%">';
		$mensaje .= '<tr><td align="center">Identificador de geopunto previamente registrado.</td></tr>';	 
		$mensaje .= '<tr><td>';
		for($x=0; $x<count($a_itm_no); $x++){
			$mensaje.=$a_itm_no[$x]."<br>";
			}
			$mensaje.='</td></tr>';
			$mensaje.='</table>';
	}
	//Mensajes de error descripciones
	if(count($a_dsc_no)>0){
		$mensaje .=  '<table border="0" width="100%">';
		$mensaje .= '<tr><td align="center">Descripci&oacute;n de geopunto previamente registrada.</td></tr>';	 
		$mensaje .= '<tr><td>';
		for($x=0; $x<count($a_dsc_no); $x++){
			$mensaje.=$a_dsc_no[$x]."<br>";
			}
			$mensaje.='</td></tr>';
			$mensaje.='</table>';
	}	
}	
//-----------------------------------------------------------------
function almacenar_data(){
	global $db, $mensaje;
	$cad_geo = generar_data_geo();
	if($cad_geo != ""){
		$sql_e = "INSERT INTO ADM_GEOREFERENCIAS
		(ID_CLIENTE,ID_TIPO_GEO,DESCRIPCION,LONGITUDE,LATITUDE,CALLE,NO_INT,NO_EXT,COLONIA,MUNICIPIO,ESTADO,CP,RADIO,TIPO,PRIVACIDAD,ID_ADM_USUARIO,CREADO,ITEM_NUMBER,RESPONSABLE,CORREO,CELULAR,TWITTER) VALUES ".$cad_geo;
		$qry_e = $db->sqlQuery($sql_e);
			if($qry_e==true){
				$r = explode("(",$cad_geo);
				$mensaje .= '<table border="0" width="100%">';
				$mensaje .= '<tr><td>';
				$mensaje .="Se insertaron ".(count($r)-1)." geopunto(s) con exito";
				$mensaje .='</td></tr>';
				$mensaje .='</table>';
				}		
		}	
	}
//-----------------------------------------------------------------
function generar_data_geo(){
	global $archi,$idu,$idc;
	$data = "";
	require_once 'excel_reader2.php';
	$excel = new Spreadsheet_Excel_Reader($archi);
	$excel->setColumnFormat ("A", 'string');
	for ($row=2;$row<=$excel->rowcount();$row++) {
		echo "el val de A es: ".$excel->val($row,'A');
		echo "<br>";
		/*echo "el raw de A es: ".$excel->raw($row,'A');
		echo "<br>";
		echo "el type de A es: ".$excel->type($row,'A');
		echo "<br>";
		//if($excel->type($row,'A'))
		echo "el valor de B es: ".$excel->value($row,'B');
		echo "<br>";*/
		if($excel->val($row,'A')!="" && $excel->val($row,'B')!=""){
		$lon = ($excel->val($row,'K')=="")?0:$excel->val($row,'K');
		$lat = ($excel->val($row,'J')=="")?0:$excel->val($row,'J');
		//Generar cadena
		//`ID_CLIENTE``ID_TIPO_GEO``DESCRIPCION``LONGITUDE``LATITUDE``CALLE``NO_INT``NO_EXT``COLONIA``MUNICIPIO``ESTADO``CP``RADIO``TIPO``PRIVACIDAD``ID_ADM_USUARIO``CREADO``ITEM_NUMBER``RESPONSABLE``CORREO``CELULAR``TWITTER`
		$data .= ($data=="")
		?" (".$idc.",1,'".utf8_encode($excel->val($row,'B'))."',".$lon.",".$lat.",'".utf8_encode($excel->val($row,'C'))."','".$excel->val($row,'D')."','".$excel->val($row,'E')."','".utf8_encode($excel->val($row,'F'))."','".utf8_encode($excel->val($row,'G'))."','".utf8_encode($excel->val($row,'H'))."','".$excel->val($row,'I')."',50,'G','P',".$idu.",'".date('Y-m-d H:i:s')."','".$excel->val($row,'A')."','".utf8_encode($excel->val($row,'L'))."','".$excel->val($row,'M')."','".$excel->val($row,'N')."','".$excel->val($row,'o')."')"
		:",(".$idc.",1,'".utf8_encode($excel->val($row,'B'))."',".$lon.",".$lat.",'".utf8_encode($excel->val($row,'C'))."','".$excel->val($row,'D')."','".$excel->val($row,'E')."','".utf8_encode($excel->val($row,'F'))."','".utf8_encode($excel->val($row,'G'))."','".utf8_encode($excel->val($row,'H'))."','".$excel->val($row,'I')."',50,'G','P',".$idu.",'".date('Y-m-d H:i:s')."','".$excel->val($row,'A')."','".utf8_encode($excel->val($row,'L'))."','".$excel->val($row,'M')."','".$excel->val($row,'N')."','".$excel->val($row,'o')."')";
		}
		}
	echo $data;
	return $data;	
	}	
?>
<script language="JavaScript"> 
 	var m ='<?php echo $mensaje; ?>'; 
	var mensaje =m;
	parent.mensaje(mensaje);
</script>