<?php 

/** * 
 *  @package             
 *  @name                Inserta/Actualiza datos en la base a traves de excel.
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              daniel arazo
 *  @modificado          11-08-2011
**/


header( 'Content-Type: text/html;charset=iso-8859-1' );
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

 $caso = 0;
 $archivo_x ="";
 $total ="";
 $fecha = time();
 $usr1 = $_POST['usuario'];
 $cli1 = $_POST['cliente'];
 $fecha_con_formato = date("Y/m/d H:i:s",$fecha);
 $acumulado_actualizado = 0;
 $acumulado_insertados = 0;
 $total_aceptados  = 0;
 $total_rechazados = 0;
 $rechazados_localizados ="0";
 $cont_registros=0;
 $total_ac=0;
 $total_in=0;
 $ruta_x =$_POST['nom_ruta2'];
 $unidad_x= $_POST['conte_com2'];
 $nueva_ruta="";
 $cp =0;
 $existe_punto_detalle =0;
 $cpno=0;
 $h=0;
 $mensaje ="";
 $insertar_ruta_unidad = 0;
 
 //echo $_POST['combo_grupo2'].'--'.$_POST['conte_com2'].'--'.$_POST['nom_ruta2'];
 
 
 
//------------------------ se borra todo lo contenido en la carpeta formatos 

/*$dir = opendir("modules/AdRutas/template/formato");
$ruta = "modules/AdRutas/template/formato/";*/
$dir = opendir("public/rutas");
$ruta = "public/rutas/";



while (($file = readdir($dir)) !== false){
   if( $file != '.' && $file != '..'){ 
    if(is_file($ruta.$file)){
  	 	     chmod($ruta.$file,0777);
    	  if(unlink($ruta.$file)){
				  $hola = 1;
    		}else{
    		  $hola =0;
					$mensaje = "Ha ocurrido un error al procesar la informaci&oacuten;n; Comuniquese con su proveedor";
    		}
  	}
  }	
}
closedir($dir);


//------------------------

//$directorio = 'modules/AdRutas/template/formato/'; //Lugar donde se colocarán los archivos subidos
$directorio = 'public/rutas/'; //Lugar donde se colocarán los archivos subidos
//$extensiones_permitidas = array('doc', 'docx', 'exe', 'rar', 'jpg', 'jpeg', 'gif','xls'); 
$extensiones_permitidas = array('xls','ccc'); 
$max_size = 0;

$archivo = @$_FILES['excel'];
if (!$archivo){
  $hola = 2000;
	$mensaje = 'Ha Ocurrido un error al subir el archivo. Por favor, inténtelo de nuevo ó Comuniquese con su administrador';
}
$permiso = true; //Variable que utilizaremos para ir dando permiso a las diferentes acciones


$nombre_archivo = $archivo['name'];
$peso_archivo = $archivo['size'] / 1024;
$tmp_archivo = $archivo['tmp_name'];
$extension_archivo = extension($nombre_archivo);

if ($max_size > 0 and $peso_archivo > $max_size){
	 $permiso = false;
	 $h = 0;
	 $mensaje = 'El archivo excede los <b>' . $max_size . '</b> kb de peso. El archivo pesa <b>' . round($peso_archivo) . ' kb</b>';
}

//Si no se ha denegado el permiso en la operación anterior, nos aseguraremos de que el archivo tenga alguna de las extensiones permitidas.

if ($permiso){
	if (!in_array($extension_archivo, $extensiones_permitidas)){
		$permiso = false;
		$h = 0;

		$mensaje =  '<table border="0" width="100%">';
		$mensaje .= '<tr><td colspan="2" align="center">&nbsp;</td></tr>';
		$mensaje .= '<tr><td colspan="2" align="center">&nbsp;</td></tr>';
        $mensaje .= '<tr><td colspan="2" align="center" >El archivo: <b>'.$nombre_archivo.'</b></td></tr>';
		$mensaje .= '<tr><td colspan="2" align="center">No puede ser procesado</td></tr>';
		//$mensaje .= '<tr><td colspan="2" align="center">Descargue el formato en el siguiente enlace</td></tr>';
		//$mensaje .= '<tr><td colspan="2" align="center">&nbsp;</td></tr>';
	    //$mensaje .= '<tr><td colspan="2" align="center" style="cursor:pointer;" ><img src="modules/AdRutas/template/images/e_xls.png" onClick="down_format()" /></td></tr>';
		//$mensaje .= '<tr><td colspan="2" align="center" style="cursor:pointer;" onClick="down_format()">layout.xls</td></tr>';
		//$mensaje .= '<tr><td colspan="2" align="center">&nbsp;</td></tr>';
		//$mensaje .= '<tr><td colspan="2" align="center">&nbsp;</td></tr>';
		//$mensaje .= '<tr><td  align="right"> <input type="button" onClick="excel_layout(2)" value="volver" class="textb"></td><td align="left"> <input type="button" value="Cancelar" onClick="tb_remove();"  class="textb"/></td></tr>';

		$mensaje .= '</table>';
	
	
	}
}

if ($permiso){

	if (@move_uploaded_file($tmp_archivo, $directorio . $nombre_archivo)){
		   $h = 1;
			// $mensaje = 'El archivo <b>' . $nombre_archivo . '</b> ha sido subido correctamente';
			 
	   
			 if(isset( $_POST['chk'])){
			 //echo "caso = 1";
			   $caso = 1;
			 }else{
			   $caso = 0;
				 // echo "caso = 0";
			 }
			 
			   $archivo_x = $directorio . $nombre_archivo;
				   
				   
//------Rodwyn
////////////////////////////////////////////////////////////////////////////
//$sql_g="SELECT S.COD_OBJECT_MAP, S.DESCRIPTION, S.LONGITUDE, S.LATITUDE,S.RADIO FROM SAVL_G_PRIN S WHERE S.TYPE_OBJECT_MAP='P' AND S.COD_CLIENT=".$cli1;
 $sql_g="SELECT S.COD_OBJECT_MAP FROM SAVL_G_PRIN S WHERE S.TYPE_OBJECT_MAP='P' AND S.COD_CLIENT=".$idc;
	$query_g = $db->sqlQuery($sql_g);
	$count_g = $db->sqlEnumRows($query_g);		
	
	if($count_g>0){
		$pdib=array();
		while($row_g=$db->sqlFetchArray($query_g)){
			 $pdib[] = $row_g['COD_OBJECT_MAP'];
		}
		
	}
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
//ini_set("display_errors",1);
//error_reporting(E_ALL);
require_once 'excel_reader2.php';
$excel = new Spreadsheet_Excel_Reader($archivo_x);
$excel -> setOutputEncoding('CP1251');

	$errors=array();
	$exists=array();
	$cnt=0;
for ($row=2;$row<=$excel->sheets[2]['numRows'];$row++) {
	if($excel->val($row,'R',2)!=""){
		//$pdie[$excel->val($row,'R',2)]=($excel-> val($row,'S',2));
		$cnt++;
	if (!in_array($excel->val($row,'R',2), $pdib)){
		$errors[]=$excel-> val($row,'S',2)."<br>";
		}
	else{
		$exists[]=$excel->val($row,'R',2);
		}	
	}
	}

if(count($exists)>0){

	    $data = Array(
			'DESCRIPCION'		=> $_POST['cto_imp'], 
			'FECHA_CREACION'   	=> date('Y-m-d H:i:s'),
			'COD_USER'    		=> $idu,
			'COD_CLIENT'	    => $idc
		);
		
			if($dbf-> insertDB($data,'DSP_CIRCUITO',true) == true){
				$sql_f="SELECT LAST_INSERT_ID() AS IDC;";
				$query_f = $db->sqlQuery($sql_f);
				$row=$db->sqlFetchArray($query_f);
				$cto=$row['IDC'];
				
				$puntos = explode(",", $_GET['pts']);
				$values="";
				for($x=0;$x< count($exists); $x++){
					$values=($values=="")?" (".$cto.",".$exists[$x].",'".date('Y-m-d H:i:s')."',".$idu.",".$idc.") ": $values.",(".$cto.",".$exists[$x].",'".date('Y-m-d H:i:s')."',".$idu.",".$idc.")";
					}
				//
				$sql_ins = "INSERT INTO DSP_CIRCUITO_PDI (ID_CIRCUITO,COD_OBEJECT_MAP,FECHA_CREACION,COD_USER,COD_CLIENT) VALUES ".$values;
				$qry_ins = $db->sqlQuery($sql_ins);
	
					
					if($qry_ins == true){
						$mensaje =  '<table border="0" width="100%">';
						$mensaje .= '<tr bgcolor="#808080" style="color:#ffffff;" ><td  align="center"colspan="2" > Archivo Procesado &nbsp;<b>'.$nombre_archivo.'</b></td></tr>';
						$mensaje .= '<tr bgcolor="#e9e9e9" style="color:#ffffff;" ><td  align="center"colspan="2" > Circuito &nbsp;<b>'.$_POST['cto_imp'].'</b> almacenado correctamente</td></tr>';
						}
				else{
						$mensaje =  '<table border="0" width="100%">';
						$mensaje .= '<tr bgcolor="#808080" style="color:#ffffff;" ><td  align="center"colspan="2" > Archivo Procesado &nbsp;<b>'.$nombre_archivo.'</b></td></tr>';
						$mensaje .= '<tr bgcolor="#e9e9e9" style="color:#ffffff;" ><td  align="center"colspan="2" > El circuito &nbsp;<b>'.$_POST['cto_imp'].'</b> no ha sido almacenado correctamente</td></tr>';
					}
			}			
	}
	
//$mensaje= "Numero de registros:".count($pdie);
//$mensaje=count($pdib);
$e="";
$acp= $cnt - count($errors);

//$mensaje .= '<tr bgcolor="#808080" style="color:#ffffff;" ><td  align="center"colspan="2" > Archivo Procesado &nbsp;<b>'.$nombre_archivo.'</b></td></tr>';
$mensaje .= '<tr><td align="left">Total de reg(s) analizados:</td><td align="left">'.$cnt.'</td></tr>';
$mensaje .= '<tr><td align="left">Total de reg(s) aceptados:</td><td align="left">'.$acp.'</td></tr>';
$mensaje .= '<tr><td align="left" >Total de reg(s) rechazados:</td><td align="left" style="color:#990000;"><b>'.count($errors).'</b></td></tr>';
$mensaje .= '<tr bgcolor="#e9e9e9"><td align="left" valign="top">Registros Rechazados:</td><td align="left">';
for($x=1; $x<=count($errors); $x++){
	$e.=$errors[$x]."<br>";
	}
$mensaje .=$e.'</td></tr>';
$mensaje .= '</table>';		


		   
//------/Rodwyn/----
				   
			   echo $x_ban = valida_excel($archivo_x);
				 
				 if($x_ban==true){
    				   // echo "La estrucutra basica del excel esta bien";
						 ejecutar_excel($caso,$archivo_x,$usr1,$cli1);
    					 
    				    
    				  //echo "la nueva ruta es:".$nueva_ruta;
    					
    			if($h==1){
      				$mensaje =  '<table border="0" width="100%">';
          		    //$mensaje .= '<tr><td colspan="2" align="center">&nbsp;</td></tr>';
          		    //$mensaje .= '<tr bgcolor="#352d9f" style="color:#ffffff;"><th colspan="2" align="center">Resumen</th></tr>';
				    //$mensaje .= '<tr><td colspan="2" align="center">&nbsp;</td></tr>';
                    $mensaje .= '<tr bgcolor="#808080" style="color:#ffffff;" ><td  align="center"colspan="2" > Archivo Procesado &nbsp;<b>'.$nombre_archivo.'</b></td></tr>';
          		    $mensaje .= '<tr><td align="left">Total de reg(s) analizados:</td><td align="left">'.$cont_registros.'</td></tr>';
          		    $mensaje .= '<tr bgcolor="#e9e9e9"><td align="left" >Total de reg(s) aceptados:</td><td align="left" style="color:#008000;"><b>'.$total_aceptados.'</b></td></tr>';
          		    $mensaje .= '<tr><td align="left" >Total de reg(s) rechazados:</td><td align="left" style="color:#990000;"><b>'.$total_rechazados.'</b></td></tr>';
    				$mensaje .= '<tr bgcolor="#e9e9e9"><td align="left" >Lineas Rechazadas:</td><td align="left">'.$rechazados_localizados.'</td></tr>';
    				$mensaje .= '<tr><td align="left" >Total Puntos actualizados:</td><td align="left">'.$total_ac.'</td></tr>';
    				$mensaje .= '<tr bgcolor="#e9e9e9"><td align="left" >Total Puntos asignados a la nueva ruta:</td><td align="left">'.$cp.'</td></tr>';
					$mensaje .= '<tr bgcolor=""><td align="left" >Total Puntos ya existentes en otra ruta</td><td align="left">'.$existe_punto_detalle.'</td></tr>';
					//$mensaje .= '<tr><td colspan="2" align="center">&nbsp;</td></tr>';
    				//$mensaje .= '<tr><td colspan="2" align="center"><input type="button" value="Salir" onClick="tb_remove();" class="textb" /></td></tr>';
    		  		$mensaje .= '</table>';
    				  }else{
    					 //$h=0;
    					// $mensaje = "algubna fallaaaaa";
    					}
					
			   }else{
				  // echo "el excel esta mal";
					 
					  $h=0;
        	    $mensaje = "formato incompleto verifique o descargue layout";
        	    $mensaje =  '<table border="0" width="100%">';
        		$mensaje .= '<tr><td colspan="2" align="center">&nbsp;</td></tr>';
        		$mensaje .= '<tr><td colspan="2" align="center">&nbsp;</td></tr>';
                $mensaje .= '<tr><td colspan="2" align="center" >El archivo: <b>'.$nombre_archivo.'</b></td></tr>';
        		$mensaje .= '<tr><td colspan="2" align="center">No puede ser procesado; Formato Incorrecto Verifique ó</td></tr>';
        		//$mensaje .= '<tr><td colspan="2" align="center">Descargue el formato en el siguiente enlace</td></tr>';
        		//$mensaje .= '<tr><td colspan="2" align="center">&nbsp;</td></tr>';
        	    //$mensaje .= '<tr><td colspan="2" align="center" style="cursor:pointer;" ><img src="modules/AdRutas/template/images/e_xls.png" onClick="down_format()" /></td></tr>';
        		//$mensaje .= '<tr><td colspan="2" align="center" style="cursor:pointer;" onClick="down_format()">layout.xls</td></tr>';
				//$mensaje .= '<tr><td colspan="2" align="center">&nbsp;</td></tr>';
				//$mensaje .= '<tr><td colspan="2" align="center">&nbsp;</td></tr>';
	            //$mensaje .= '<tr><td  align="right"> <input type="button" onClick="excel_layout(2)" value="volver" class="textb"></td><td align="left"> <input type="button" value="Cancelar" onClick="tb_remove();"  class="textb"/></td></tr>';
  		        $mensaje .= '</table>';
					 
					// echo $mensaje;
				 }
				 
				
				
				
				  
				
							
		}else{
		
 	 $h = 0;
	 $mensaje = 'Ha Ocurrido un error al subir el archivo. Por favor, inténtelo de nuevo';
	}
}
	
	
//-------------------------------------------------------------------
 function extension($archivo){
 	$dat = explode('.', $archivo);
 	return $dat[count($dat)-1];
 }
	
//----------------------------------------------------------------------- FUNCION QUE VALIDA INICIALMENTE EL EXCEL


function valida_excel($archi){

ini_set("display_errors",1);
error_reporting(E_ALL);
require_once 'excel_reader2.php';
$excel = new Spreadsheet_Excel_Reader($archi);
  //													

	
    $cont  = 0;
    $conta = 0;
	$no_conta = 0;
	$arre = "";
	$item_bueno="";
	$item_malo="";
	$cadena_buenos = "";
	$columnas =0;

	$formato = array("Hora de salida","Numero de Grupo","Fecha de incicio","SAP ( Cliente)","Pedido","Kilos","Economico","Unidad Medida","Fecha estimada","Hora de Entrada","Hora de Salida","Comentarios","Hora de Llegada");
	$formato_actual = array();	
	$bandera = true;	
	$m = -1;
	

   for ($row=1;$row<2;$row++){
  	   for ($col=1;$col<=$excel->colcount();$col++) {
  		     $m = $m +1;
  		        if($excel->val($row,$col)!=""){
  				 	 $formato_actual[$m] = strtoupper($excel->val($row,$col));
  					 $columnas = $columnas +1; 
  				}else{
					  break;
				}
  		 }
   }

	 
  if($columnas == count($formato)){
   // Echo "formato completo";
  	 for ($col=0;$col<count($formato_actual);$col++) {
  	 
  	         if(in_array($formato_actual[$col],$formato)){
  				    if( $formato_actual[$col] == $formato[$col]){
					 //  echo ' no estan en la misma posicion <b style="color:#00ff00;">'.$formato_actual[$col] .'=='. $formato[$col].'</b><br />';
							 $bandera = true;
					 }else{
					   //  echo ' La posicion de las columnas no es correcta <b style="color:#993300;">'.$formato_actual[$col] .'=='. $formato[$col].'</b><br />';
							 $bandera = false;
  				     break;
					 }
  			 }else{
  				   //echo "segun este ".$formato_actual[$col].'<br />';
  					 $bandera = false;
  				     break;
  			 }
  		}
  	
  }else{
   	$bandera = false;
  }



return $bandera;
}
//---------------------------------------------------------------------- FUNCION QUE INGRESA INFO DEL EXCEL A LA BASE 

function  ejecutar_excel($case,$archi,$usr,$cli){
	
	
global $total_aceptados,$total_rechazados, $rechazados_localizados ,$cont_registros,$h,$mensaje,$nueva_ruta,$unidad_x,$ruta_x,$insertar_ruta_unidad;

ini_set("display_errors",1);
error_reporting(E_ALL);
require_once 'excel_reader2.php';
$excel = new Spreadsheet_Excel_Reader($archi);
   echo 
	
    $cont  = 0;
    $conta = 0;
	$no_conta = 0;
	$arre = "";
	$item_bueno="";
	$item_malo="";
	$cadena_buenos = "";
	$columnas =0;

	//$formato = array("NIP","CLIENTE","CALLE","COLONIA","DEL-MUN","ESTADO","CP","LATITUD","LONGITUD","ITINERARIOS");
	//$formato_actual = array();	
	$bandera = true;	
	
	$m = -1;
	

   for ($row=1;$row<2;$row++){
  	   for ($col=1;$col<=$excel->colcount();$col++) {
  		     $m = $m +1;
  		    if($excel->val($row,$col)!=""){
  				 	 $columnas = $columnas +1; 
  				}
  		 }
  }



//if($bandera == true){	 

//--------------------------------------------------
          for ($row=2;$row<=$excel->rowcount();$row++) {
             
        		 $cont_registros=$cont_registros+1;
        		 
        		 for ($col=1;$col<=$columnas;$col++) {
        		 
        		          if($excel->val($row,$col)!=""){
							  
							  
        					       $cont = $cont +1;
        						   $item_bueno = $excel->val($row,1);
        						 
          						   if($cadena_buenos ==""){
          						     $cadena_buenos = $excel->val($row,$col);
            						}else{
										
            					      if($col==8){
										  $rLatLon = validaLatLon($excel->val($row,8),$excel->val($row,9));
										  // echo "para".$excel->val($row,8).','.$excel->val($row,9)." la var latlon es = ".$rLatLon.'<br>'; 
										 
										  if($rLatLon==1){
											   $cadena_buenos = $cadena_buenos.'['.$excel->val($row,$col);
										  }else{
											   $cadena_buenos="";
        					                   break;
										  }
										  
										  
									  }else if($col==$columnas){
										  
									    
													  
											$semana = array("D","L","M","R","J","V","S");
											$dias = explode(",",strtoupper($excel->val($row,$col)));
												$day = "";
												//echo " semana".count($semana)."-- dias ".count($dias).'<br />';
												
												 for($d=0;$d<count($dias);$d++){
													for($s=0;$s<count($semana);$s++){
														 //echo "sem=".$semana[$s].'<br />';
															if($semana[$s]==$dias[$d]){
																 
																	 if($day == ""){
																	   if($semana[$s] == "D"){
																		 $day = '0';
																		}else{
																		  $day = $s;
																		}
																	 }else{
																	// echo $dias[$d].'=='.$semana[$s].$s.'<br />';
																	  $day = $day.'@'.$s;
																	 }
															}
													   }
														 
													}
														$cadena_buenos = $cadena_buenos.'['.$day;
										  
									   
									  }else{
										  $cadena_buenos = $cadena_buenos.'['.$excel->val($row,$col);
								      }
            						
									
									}
        						
        					
							
						  
						  }else{
							 
							 
							 
							  if($col == 7){
								//echo "columna ".$col.'-'.$excel->val($row,$col);  
								$cadena_buenos = $cadena_buenos.'[99999';
 							    $cont = $cont +1;
							  }else{
							 
							 	if( $item_malo == ""){
            					   $item_malo = $excel->val(1,$col);
            					}else{
            					   $item_malo =  $item_malo.','. $excel->val(1,$col);
            					}	
								
        						  $cadena_buenos="";
        					      break;
							 }
						
        				  }
        					
        		 }
                  
        		 if($cont == $columnas){
        		     $conta = $conta+1;
            			 echo $cadena_buenos.'<br />';
								
								/*-------------------------------  OPERACIONES  -----------------------*/
								
									insert_update($item_bueno,$cadena_buenos,$case,$usr,$cli);
								    if($insertar_ruta_unidad==0){
								     crear_ruta_unidad($unidad_x,$ruta_x,$usr,$cli);
									}
          				            crea_ruta_punto($item_bueno,$nueva_ruta);
								    crea_itn($nueva_ruta,$cadena_buenos,$usr);
									crea_pto_vis($nueva_ruta,$cadena_buenos);
								
        				       /*---------------------------------------------------------*/
								  
							$item_bueno="";
        				    $cadena_buenos="";
        		  }else{
        			   
        			   $no_conta = $no_conta+1;
        				   if($arre ==""){
          				     $arre=$row;
          				 }else{
          				     $arre= $arre.','.$row;
          				 }
        				 
        			}
        		 $cont =0; 
        }
         $total_aceptados =  $conta;
       echo "<br><br><br> rechazados = ".$total_rechazados = $no_conta; 
				 
           if($no_conta>0){
           echo  $rechazados_localizados = $arre;
           }
					 
  //  } //if bandera de formato correcto.
}	
//-----------------------------	

function insert_update($itn,$cade,$accion,$usr_x,$cli_x){
	
//  echo '<br /> mmmmcadenas '.$itn.'-'.$cade.'-'.$accion.'<br />';

 global $db,$dbf,$fecha_con_formato,$total,$acumulado_actualizado,$acumulado_insertados,$total_ac,$total_in;
 
 
  $descompone = "";
  $sql = "SELECT ITEM_NUMBER FROM SAVL_G_PRIN WHERE ITEM_NUMBER = '".$itn."'";
  $query = $db->sqlQuery($sql);
	$count=  $db->sqlEnumRows($query);	
	$descompone = explode("[",$cade);
	
	 if($count>0){
      	    if($accion==1){	
      	     
      				
      			               $data = Array(
										'DESCRIPTION'     => utf8_decode(strtoupper($descompone[1])),
										'ADD_STREET'      => utf8_decode(strtoupper($descompone[2])),
										'ADD_COLONY'      => utf8_decode(strtoupper($descompone[3])),
										'ADD_MUNICIP'     => utf8_decode(strtoupper($descompone[4])),
										'ADD_STATE'       => utf8_decode(strtoupper($descompone[5])),
										'ADD_COD_POSTAL'  => utf8_decode(strtoupper($descompone[6])),
										'LATITUDE'        => utf8_decode(strtoupper($descompone[7])),
										'LONGITUDE'       => utf8_decode(strtoupper($descompone[8])),
										'COD_TYPE_GEO'    => tipo_punto(strtoupper($descompone[9]))
										 );
                                 $where = "ITEM_NUMBER = '".$descompone[0]."'";
                                if($dbf-> updateDB('SAVL_G_PRIN',$data,$where)){
      							    $acumulado_actualizado = $acumulado_actualizado+1; 
        						 // echo "--existe en la base y caso es 1 se debe actualizar ".$descompone[0]." <br>";
        						}
      			} /*else{
      			 echo "-existe en la base y caso es 0 se debe ignorar ".$descompone[0]." <br>";
      			}*/
      			
	 }else{
	   if($accion==1 || $accion==0 ){
		   echo "el valor es 0 <br/>";
			           $data_2 = Array(
			   		 	 			         'COD_COLOR'       => 0,
											 'COD_USER_CREATE' => $usr_x,
											 'COD_ZONE_GEO'    => '',
											 'COD_TYPE_GEO'    => tipo_punto($descompone[9]),
											 'COD_CLIENT'      => $cli_x,
											 'DATETIME_CREATE' => $fecha_con_formato,
 			 				 	 			 'DESCRIPTION'     => utf8_decode(strtoupper($descompone[1])),
											 'TYPE_OBJECT_MAP' => 'P',
											 'TYPE_PUBLIC'     => 'S',
											 'ADD_MUNICIP'     => utf8_decode(strtoupper($descompone[4])),
											 'ADD_STATE'       => utf8_decode(strtoupper($descompone[5])),
											 'ADD_COLONY'      => utf8_decode(strtoupper($descompone[3])),
											 'ADD_STREET'      => utf8_decode(strtoupper($descompone[2])),
											 'ADD_COD_POSTAL'  => $descompone[6],
											 'ADD_DETAILS'     => '',
											 'ADD_STREET_01'   => '',
											 'ADD_STREET_02'   => '',
											 'ITEM_NUMBER'     => $descompone[0],
											 'ITEM_NUMBER_2'   => '',
											 'RADIO'           => 50,
 			 				 	 			 'LONGITUDE'       => $descompone[8],
											 'LATITUDE'        => $descompone[7]
                      );
											 
          				 if($dbf-> insertDB($data_2,'SAVL_G_PRIN',false) == true){
                    		  echo "no existe en la base, el  caso es ".$accion." se debe insertar ".$descompone[0]." en savl_g_prin <br>";
													 $acumulado_insertados =  $acumulado_insertados+1;
                  	}	else{
                    	   $h= 0;
												 $mensaje = "Ha ocurrido un error al cargar la informacion, comuniquese con su proveedor";	
                	 }	
			 }
	 }
 
 $total_ac = $acumulado_actualizado;
 $total_in = $acumulado_insertados;
  
}
//--------------------------------------------- funcion que crea la ruta_unidad_asignada

function crear_ruta_unidad($un_x,$r_x,$usu,$cli){
	
  global $db,$dbf,$fecha_con_formato,$nueva_ruta,$insertar_ruta_unidad;
	 

  $data = Array(
       	'DESCRIPTION' =>  utf8_decode(strtoupper($r_x)),
        'COD_USER'    =>  $usu,
        'COD_CLIENT'  =>  $cli,
        'CREATE_DATE' =>  $fecha_con_formato
          
    );
                   
      if($dbf-> insertDB($data,'SAVL_ROUTES',true) == true){
          echo "se genero la ruta, ahora se asigna unidad a ruta siempre y cuando sea diferente de -1 en el cod_entity";
				
				$ruta    = "SELECT ID_ROUTE FROM SAVL_ROUTES WHERE DESCRIPTION LIKE '%".strtoupper($r_x)."%'";
				    $query   = $db->sqlQuery($ruta);
				    $row     = $db->sqlFetchArray($query);
				 	$count_x =  $db->sqlEnumRows($query);	 
					
					 	
				if($un_x!=-1) {
					   $data_3 = Array(
									   'ID_ROUTE'    => $row['ID_ROUTE'],
									   'COD_ENTITY'  => $un_x,
									   'COD_USER'    => $usu,
									   'CREATE_DATE' => $fecha_con_formato
									   );
							 if($dbf-> insertDB($data_3,'SAVL_ROUTES_UNITS',true) == true){
              					 echo "info de la ruta".$row['ID_ROUTE'].'-'.$un_x.'-'.$usu.'-'.$fecha_con_formato.'<br />';
								 
							 }else{
              				 echo "fallo en ruta-unidad";	
                             }
							 
			  }				 			
			}		
			
			
	 $nueva_ruta = $row['ID_ROUTE'];		
     $insertar_ruta_unidad = $insertar_ruta_unidad + 1;
}

//-------------------------------------------- funcion que asigna un geopunto a la ruta creada con info contenida en excel.
 function  crea_ruta_punto($itm,$r){
	 

  global $db,$dbf,$fecha_con_formato,$cp,$cpno, $existe_punto_detalle;
  $cuenta_puntos=0;
	$cuenta_puntos_no = 0;
	$otra_ban = 0;
	$bandera =0;
 
				$usuario     = "SELECT COD_OBJECT_MAP FROM SAVL_G_PRIN WHERE ITEM_NUMBER = '".$itm."'";
			    $query_user  = $db->sqlQuery($usuario);
				$row_user    = $db->sqlFetchArray($query_user);
				$count_user  = $db->sqlEnumRows($query_user);	 	    
							 
					if($count_user > 0)	{		
				  
    					$punto     = "SELECT COD_OBJECT_MAP FROM SAVL_ROUTES_DETAIL WHERE COD_OBJECT_MAP =".$row_user['COD_OBJECT_MAP'];
    			    $query_punto  = $db->sqlQuery($punto);
    				  $count_punto  = $db->sqlEnumRows($query_punto);
				 
        				    if($count_punto>0){
        						            // $existe_punto =  $existe_punto +1;
        				                    echo "ya existe el geopunto en routes_detail, se guardara este mismo geopunto con otra ruta...";
											$otra_ban = 1;
        						 }
				 
    				  //if($count_punto==0){
    							 $data_2 = Array(
													'ID_ROUTE'       => $r,
													'COD_OBJECT_MAP' => $row_user['COD_OBJECT_MAP'],
													'CREATE_DATE'    => $fecha_con_formato
												 );
              				if($dbf-> insertDB($data_2,'SAVL_ROUTES_DETAIL',false) == true){
    									  $bandera = 1;
    									   echo 1;		
                      }	else{
                         echo 0;	
                      }	
    			    // }else{
    					   //		$bandera = 0;
    					 //}
				   
				  }

			if($bandera ==1){
			  $cp = $cp +1;
			}else{
			  $cpno = $cpno +1;
			}							
					 
			if($otra_ban ==1){
			  $existe_punto_detalle = $existe_punto_detalle +1;
			} 
 
 }// fin funcion que crea ruta,asigna unidad, y geopunto.
///---------------------------------------------------

function crea_itn($r,$string,$u){
	
       
			 global $db,$dbf,$fecha_con_formato;
       
       $cadena = explode("[",$string);
       $cadena2 = explode("@",$cadena[10]);
  
        for($c=0;$c<count($cadena2);$c++){
					   
						 $sql_z  = "SELECT ID_ITINERARIO,ID_DIA FROM ITN_DEFINICION WHERE ID_ROUTE = ".$r." AND ID_DIA = ".$cadena2[$c]; 
            			 $kuery  = $db->sqlQuery($sql_z);
            			 $con    = $db->sqlEnumRows($kuery);
						 $row    = $db->sqlFetchArray($kuery);
							
						 if($con > 0){
						    echo "no se hace algo <br>";
						 }else{
						   echo "insertar ".$r.','.$cadena2[$c].','.$u.'<br />';
    							  
										 $datos = Array(
                         							 'ID_ROUTE' => $r,
                         							 'ID_DIA'   => $cadena2[$c],
												  	 'COD_USER' => $u,
	                        						 'CREADO'   => $fecha_con_formato,
													 'ACTIVO'   => 1
                    								  );
              				if($dbf-> insertDB($datos,'ITN_DEFINICION',false) == true){
    									  $bandera = 1;
									 echo 1;		
							  }	else{
								echo 0;	
							  }
							 
						 
						 }
						 
						
						
					}
				 
} 
//------------------------------------

function crea_pto_vis($r,$string){
	

			 global $db,$dbf,$fecha_con_formato;
       
       $cadena = explode("[",$string);
       $cadena2 = explode("@",$cadena[10]);
      // $r=22222;
		 //  echo $cadena[0];  
			 
			       $sql_y  = "SELECT COD_OBJECT_MAP FROM SAVL_G_PRIN WHERE ITEM_NUMBER = '".$cadena[0]."'"; 
                   $kwery  = $db->sqlQuery($sql_y);
                     $cn    = $db->sqlEnumRows($kwery);
					 $rw    = $db->sqlFetchArray($kwery);
			 
			 
			 
 
  for($c=0;$c<count($cadena2);$c++){
             $sql_z  = "SELECT ID_ITINERARIO FROM ITN_DEFINICION WHERE ID_ROUTE = ".$r." AND ID_DIA = ".$cadena2[$c]; 
             $kuery  = $db->sqlQuery($sql_z);
             $con    = $db->sqlEnumRows($kuery);
						 $row    = $db->sqlFetchArray($kuery);
						 
						 if($con>0){
						   $sql  = "SELECT MAX(ORDEN)+1 AS SIG FROM ITN_PUNTOS_VISITA WHERE ID_ITINERARIO = ".$row['ID_ITINERARIO']; 
               $query  = $db->sqlQuery($sql);
               $cont    = $db->sqlEnumRows($query);
						   $rows    = $db->sqlFetchArray($query);
						   
							 echo "cont=".$cont.','.$rows['SIG'].'<br />';
							 
      						if($cont>0){ 
      							 if($rows['SIG']!=""){
      						      $max = $rows['SIG'];	 
      							 }else{
      							    $max = 1;
      							 }
      						}	 
							   
								  $dato = Array(
                          'ID_ITINERARIO'  => $row['ID_ITINERARIO'],
                          'COD_OBJECT_MAP' => $rw['COD_OBJECT_MAP'],
												  'FECHA_ARRIBO'   => '0000-00-00 00:00:00',
	                        'FECHA_SALIDA'   => '0000-00-00 00:00:00',
													'ORDEN'          => $max,
													'CREADO'         =>  $fecha_con_formato
                     );
              				if($dbf-> insertDB($dato,'ITN_PUNTOS_VISITA',false) == true){
    									  $bandera = 1;
											   echo 1;		
                      }	else{
                        echo 0;	
                      }
							    
							
							
						 }
						 
  }
}
//----------------------------------
function validaLatLon($lat_x,$lon_x){

$lat_f = abs(intval($lat_x));
$lon_f = abs(intval($lon_x));

	if($lat_f > 11 && $lat_f < 33 ){
		if($lon_f > 79  && $lon_f < 118){
		  $bandera = 1;
		}else{
		  $bandera = 0;
		}
	}else{
	  $bandera = 0;
	} 	
	
	return  $bandera;
}
//_----------------------------
function tipo_punto($abr){
	global $db;
	 $valor = 0; 
	
	 $sql = "SELECT COD_TYPE_GEO FROM SAVL1164 WHERE ITEM_NUMBER='".$abr."'";
     $query = $db->sqlQuery($sql);
	 $count=  $db->sqlEnumRows($query);	
	 $row   = $db->sqlFetchArray($query);
	 
	 if($count>0){
	   	 $valor = $row['COD_TYPE_GEO'];
	 }else{
		 $valor = 1;
	 }
	 
	return $valor;
}

?>

<script language="JavaScript"> 
 var f= '<?php echo $h; ?>';
 var m ='<?php echo $mensaje; ?>'; 
	if( f==1){
	  var mensaje = m;
	}else{
	  var mensaje =m;
	}
	//alert(m);
	parent.mensaje(mensaje,f);
</script> 
