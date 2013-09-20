<?php 

/** * 
 *  @package             
 *  @name                Inserta/Actualiza datos en la base a traves de excel.
 *  @version             1
 *  @copyright           Air Logistics & GPS S.A. de C.V.   
 *  @author              daniel arazo
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
//$dir = opendir("public/rutas");
$dir = opendir("public/Despacho");
//$ruta = "public/rutas/";
$ruta = "public/Despacho/";



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
//$directorio = 'public/rutas/'; //Lugar donde se colocarán los archivos subidos
$directorio = 'public/Despacho/';
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
		//$mensaje .= '<tr><td colspan="2" align="center">&nbsp;</td></tr>';
		$mensaje .= '<tr><td colspan="2" align="center">&nbsp; </td></tr>';
        $mensaje .= '<tr><td colspan="2" align="center" >El archivo: <b>'.$nombre_archivo.'</b></td></tr>';
		$mensaje .= '<tr><td colspan="2" align="center">No puede ser procesado</td></tr>';
		$mensaje .= '<tr><td colspan="2" align="center">Descargue el formato en el icono de descarga</td></tr>';
		$mensaje .= '<tr><td colspan="2" align="center">Y copie sus datos en el</td></tr>';
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
				 
			   $x_ban = valida_excel($archivo_x);
				 
				 if($x_ban==true){
					 //validar datos del excel
					  validar_data($archivo_x);
					  //rodwyn

		
	

					  //end rodwyn
					 
    				   // echo "La estrucutra basica del excel esta bien";
						 //ejecutar_excel($caso,$archivo_x,$usr1,$cli1);
    					 
    				    
    				  //echo "la nueva ruta es:".$nueva_ruta;
    					
    			if($h==1){/*
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
    				  */}else{
    					 //$h=0;
    					// $mensaje = "algubna fallaaaaa";
    					}
					
			   }else{
				  // echo "el excel esta mal";
					 
					  $h=0;
        	    $mensaje = "formato incompleto verifique o descargue layout";
        	    $mensaje =  '<table border="0" width="100%">';
        		$mensaje .= '<tr><td colspan="2" align="center">&nbsp; </td></tr>';
        		//$mensaje .= '<tr><td colspan="2" align="center">&nbsp;</td></tr>';
                $mensaje .= '<tr><td colspan="2" align="center" >El archivo: <b>'.$nombre_archivo.'</b></td></tr>';
        		$mensaje .= '<tr><td colspan="2" align="center">No puede ser procesado</td></tr>';
				$mensaje .= '<tr><td colspan="2" align="center">Formato Incorrecto</td></tr>';
        		$mensaje .= '<tr><td colspan="2" align="center">Descargue el formato en el icono de descarga</td></tr>';
				$mensaje .= '<tr><td colspan="2" align="center">Y copie sus datos en el</td></tr>';
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
  
	
    $cont  = 0;
    $conta = 0;
	$no_conta = 0;
	$arre = "";
	$item_bueno="";
	$item_malo="";
	$cadena_buenos = "";
	$columnas =0;
//													

	$formato = array("Hora de salida","Numero de Grupo","Fecha de incicio","SAP ( Cliente)","Pedido","Kilos","Economico","Prioridad","Unidad Medida","Fecha estimada","Hora de Entrada","Hora de Salida","Comentarios","Hora de Llegada");
	$formato_actual = array();	
	$bandera = true;	
	//$m = -1;
	$m=0;
	

   //for ($row=1;$row<2;$row++){
	   $row=1;
	   
  	   //for ($col=1;$col<=$excel->colcount();$col++) {
		for ($col=1;$col<=$excel->colcount($sheet_index=0);$col++) {   
  		        if($excel->val($row,$col)!=""){
  				 	 $formato_actual[$m] = strtoupper($excel->val($row,$col));
  					 $columnas = $columnas +1; 
  				}else{
					  break;
				}
			$m = $m +1;	
  		 }
   //}

	 //echo $columnas." == ".count($formato);
  if($columnas == count($formato)){
	  $bandera=true;
	  /*
   //echo "formato completo";
   $d=0;
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
  	
  */}else{
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
////funcion validar datos del excel
function validar_data($archi){
global $db, $idc, $idu, $mensaje;
$sap_it = array();
$sap_id = array();
$sap_no = array();
$sap_in = array();
//$mensaje="";
$und_id = array();
$und_nm = array();
$und_no = array();
$und_ok = array();
$ent_it = array();
$ent_ex = array();
ini_set("display_errors",1);
error_reporting(E_ALL);
require_once 'excel_reader2.php';
$excel = new Spreadsheet_Excel_Reader($archi);
	//OBTENER SAP CLIENTE
	 $sql = "SELECT S.COD_OBJECT_MAP, S.ITEM_NUMBER FROM SAVL_G_PRIN S WHERE S.COD_CLIENT=".$idc;
     $query = $db->sqlQuery($sql);
	 $count=  $db->sqlEnumRows($query);	
		while($row=$db->sqlFetchArray($query)){
			$sap_it [] = $row['ITEM_NUMBER'];
			$sap_id [] = $row['ITEM_NUMBER']."¬".$row['COD_OBJECT_MAP'];
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
	 $sql_b = "SELECT D.ITEM_NUMBER FROM DSP_ITINERARIO D INNER JOIN SAVL1100 U ON U.COD_USER=D.COD_USER WHERE U.COD_CLIENT=".$idc;
     $qry_b = $db->sqlQuery($sql_b);
	 $cnt_b =  $db->sqlEnumRows($qry_b);	
		while($row_b=$db->sqlFetchArray($qry_b)){
			$ent_it [] = $row_b['ITEM_NUMBER'];
			//$und_nm [] = $row_b['DESCRIPTION'];
		}
	//OBTENER TIPO VOLUMEN
	 $tv = array();
	 $sql_k="SELECT D.ABREVIATURA FROM DSP_TIPO_VOLUMEN D";
     $qry_k = $db->sqlQuery($sql_k);
	 $cnt_k =  $db->sqlEnumRows($qry_k);
		while($row_k=$db->sqlFetchArray($qry_k)){
			$tv [] = $row_k['ABREVIATURA'];
			//$und_nm [] = $row_b['DESCRIPTION'];
		}
	
//VALIDAR CLIENTE
for ($row=2;$row<=$excel->rowcount();$row++) {
	if($excel->val($row,'D')!=""){
		if (!in_array($excel->val($row,'D'), $sap_it)){
		$sap_no[]=$excel-> val($row,'D');
		}
		else{
			if(!in_array($excel->val($row,'D'), $sap_in)){
		$sap_in	[] = $excel-> val($row,'D');
			}
			}
	}
}
$cte = array();
for($x=0; $x<count($sap_id); $x++){
	$n=explode("¬",$sap_id[$x]);
	if(in_array($n[0],$sap_in)){
		$cte[]=$n[1];
		}
	
	}


if(count($sap_no)>0){
	$h=0;
		$mensaje .=  '<table border="0" width="100%">';
        $mensaje .= '<tr><td align="center">SAP Cliente(s) Inexistente(s)</td></tr>';	 
		$mensaje .= '<tr><td>';
for($x=0; $x<count($sap_no); $x++){
	$mensaje.=$sap_no[$x]."<br>";
	}
	$mensaje.='</td></tr>';
	$mensaje.='</table>';
 }
//VALIDAR UNIDADES
for ($row=2;$row<=$excel->rowcount();$row++) {
	if($excel->val($row,'G')!=""){
		if (!in_array($excel->val($row,'G'), $und_nm) && !in_array($excel->val($row,'G'), $und_no)){
		$und_no[]=$excel-> val($row,'G');
		}
		else{
			//if(!in_array($excel->val($row,'G'), $und_ok)){
		$und_ok [] = $excel-> val($row,'G');
			//}
			}
	}
}
$und = array();
for($x=0; $x<count($und_ok); $x++){
	$n=explode("¬",$und_id[$x]);
	if(in_array($n[0],$und_ok)){
		$und[]=$n[1];
		}
	}
if(count($und_no)>0){
	$h=0;
		$mensaje .= '<table border="0" width="100%">';
        $mensaje .= '<tr><td align="center">Unidad(es) Inexistente(s)</td></tr>';	 
		$mensaje .= '<tr><td>';
for($x=0; $x<count($und_no); $x++){
	$mensaje.=$und_no[$x]."<br>";
	}
	$mensaje.='</td></tr>';
	$mensaje.='</table>';
 }
//VALIDAR ENTREGAS		
for ($row=2;$row<=$excel->rowcount();$row++) {
	if($excel->val($row,'E')!=""){
		if (in_array($excel->val($row,'E'), $ent_it)){
		$ent_ex[]=$excel-> val($row,'E');
		}
	}
}


if(count($ent_ex)>0){
	$h=0;
		$mensaje .= '<table border="0" width="100%">';
        $mensaje .= '<tr><td align="center">Pedido(s) registarado(s) previamente</td></tr>';	 
		$mensaje .= '<tr><td>';
for($x=0; $x<count($ent_ex); $x++){
	$mensaje.=$ent_ex[$x]."<br>";
	}
	$mensaje.='</td></tr>';
	$mensaje.='</table>';
 }
		//echo $mensaje;
		
//VALIDAR DESPACHO X UNIDAD
$du=0;
$vn="";
$un="";
for ($row=2;$row<=$excel->rowcount();$row++) {
	if($excel->val($row,'B')!=""){
		if($excel->val($row,'B')==$vn){
			//echo $excel->val($row,'B')."==".$vn."<br>";
			if($excel->val($row,'G')!=$un){
				//echo "unidad".$excel->val($row,'G')."!=".$un."<br>";
				$du++;
				}
				else{
					//echo "unidad".$excel->val($row,'G')."==".$un."<br>";
					$un=$excel->val($row,'G');
					}
			}
		else{
			$vn=$excel->val($row,'B');
			$un=$excel->val($row,'G');
			}	
		/*if($excel->val($row,'B') == $excel->val($row-1,'B')){
			echo $excel->val($row+1,'G')."!=".$excel->val($row,'G');
			if($excel->val($row,'G')!=$excel->val($row-1,'G')){
				$du++;
				}
			}*/
		}
}
//echo $du;
if($du>0){
	$h=0;
		$mensaje .= '<table border="0" width="100%">';
        $mensaje .= '<tr><td align="center">Viaje asignado a dos o mas unidades</td></tr>';	 
		$mensaje .= '</table>';	
		//echo $mensaje;
	}
//VALIDAR TIPO VOLUMEN
$tv_no = array();		
for ($row=2;$row<=$excel->rowcount();$row++) {
	if($excel->val($row,'I')!=""){
		if (!in_array($excel->val($row,'I'), $tv) && !in_array($excel->val($row,'I'), $tv_no)){
		$tv_no[]=$excel-> val($row,'I');
		}
	}
}


if(count($tv_no)>0){
	$h=0;
		$mensaje .= '<table border="0" width="100%">';
        $mensaje .= '<tr><td align="center">Unidad(es) de medida inexistente(s)</td></tr>';	 
		$mensaje .= '<tr><td>';
for($x=0; $x<count($tv_no); $x++){
	$mensaje.=$tv_no[$x]."<br>";
	}
	$mensaje.='</td></tr>';
	$mensaje.='</table>';
 }
		//echo $mensaje;
			
if(count($sap_no)==0 && count($und_no)==0 && count($ent_ex)==0 && $du==0 && count($tv_no)==0){
//OBTENGO IDS
//ID SAP CLIENTE
	
	//VALIDAR DESPACHO
	// OBTENER DESPACHOS 
	 $dsp = array();
	 $dsp_in = array();
	 $sql_c = "SELECT D.ID_DESPACHO, D.ITEM_NUMBER FROM DSP_DESPACHO D INNER JOIN SAVL1100 U ON U.COD_USER=D.COD_USER WHERE U.COD_CLIENT=".$idc;
     $qry_c = $db->sqlQuery($sql_c);
	 $cnt_c =  $db->sqlEnumRows($qry_c);	
		while($row_c=$db->sqlFetchArray($qry_c)){
			$dsp [] = $row_c['ITEM_NUMBER'];
			$did [] = $row_c['ITEM_NUMBER']."¬".$row_c['ID_DESPACHO'];
		}
	//Validar despachos
		$vls="";
		$dsp2=array();
		$r=0;
				
		for ($row=2;$row<=$excel->rowcount();$row++) {
			$c=0;
			if($excel->val($row,'B')!=""){
				if ((!in_array($excel->val($row,'B'), $dsp)) && (!in_array($excel->val($row,'B'), $dsp2))){
					$dsp2[]=$excel-> val($row,'B');
					//$f=explode(".",$excel->val($row,'J'));
					//$h=explode(" ",$excel->val($row,'A'));
					//$hi=($h[1]=="a.m.")?substr($excel->val($row,'A'),0,7):(substr($excel->val($row,'A'),0,1)+12).substr($excel->val($row,'A'),2,7);
					//$dti="'".$f[2]."-".$f[1]."-".$f[0]." ".$hi."'";
					$dti = new DateTime($excel->val($row,'J')." ".$excel->val($row,'A'));
					$dti = date_format($dti, 'Y-m-d H:i:s');
					//str_replace(" a.m.","",$dti);
					//str_replace(" p.m.","",$dti);
					
					//$f2=explode(".",$excel->val($row,'J'));
					//$h2=explode(" ",$excel->val($row,'N'));
					//$hf=($h2[1]=="a.m.")?$h2[0]:substr($h2[0],0,2)+12;
					//$dtf="'".$f2[2]."-".$f2[1]."-".$f2[0]." ".$excel->val($row,'N').":00'";
					//str_replace(" a.m.","",$dtf);
					//str_replace(" p.m.","",$dtf);
					$dtf = new DateTime($excel->val($row,'J')." ".$excel->val($row,'N'));
					$dtf = date_format($dtf, 'Y-m-d H:i:s');
										
				$vls=($vls=="")?"(4,".$idu.",'".$excel->val($row,'B')."','".$excel->val($row,'B')."',0,'".date('Y-m-d H:i:s')."','".$dti."','".$dtf."')":$vls.",(4,".$idu.",'".$excel->val($row,'B')."','".$excel->val($row,'B')."',0,'".date('Y-m-d H:i:s')."','".$dti."','".$dtf."')";
				$r++;
				//$sap_no[]=$excel-> val($row,'B');
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
			$sql_d = "INSERT INTO DSP_DESPACHO (ID_ESTATUS, COD_USER, DESCRIPCION, ITEM_NUMBER, TOLERANCIA, CREADO, FECHA_INICIO, FECHA_FIN) VALUES".$vls;
			$qry_d = $db->sqlQuery($sql_d);
			if($qry_d==true){
				$h=1;

				$mensaje .= '<table border="0" width="100%">';
				//$mensaje .= '<tr><td align="center">Pedido(s) Inexistente(s)</td></tr>';	 
				$mensaje .= '<tr><td>';
				$mensaje .="Se insertaron ".$r." viaje(s) con exito";
				$mensaje .='</td></tr>';
				$mensaje .='</table>';
				
				//echo $mensaje;
				}
			}
//INGRESAR DATA DSP_ITINERARIO
$vls_i="";
$valus="";
$d=0;
$ce=array();
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
				$ob=($excel->val($row,'M')==""| $excel->val($row,'M')==" " | count($excel->val($row,'M'))==0 | $excel->val($row,'M')==NULL)?"'.'":$excel->val($row,'M');
				
				//$dt="'".$excel->val($row,'J')." ".$excel->val($row,'N')."'";
				$dt = new DateTime($excel->val($row,'J')." ".$excel->val($row,'L'));
				$dtx= date_format($dt, 'Y-m-d H:i:s');
				
				
				
				if ((!in_array($excel->val($row,'B'), $ce))){
				$valus = ($valus=="")?"(".$row_h['ID_DESPACHO'].",".$row_j['COD_ENTITY'].",'".date('Y-m-d H:i:s')."',1,0)":$valus.",(".$row_h['ID_DESPACHO'].",".$row_j['COD_ENTITY'].",'".date('Y-m-d H:i:s')."',1,0)";	
				$ce[] = $excel->val($row,'B');
				}
				
				$vls_i = ($vls_i=="")?"(".$row_h['ID_DESPACHO'].",4,".$row_i['COD_OBJECT_MAP'].",".$idu.",".$excel->val($row,'E').",".$ob.",".$dte.",'".date('Y-m-d H:i:s')."',".$excel->val($row,'F').",".$row_l['ID_TIPO_VOLUMEN'].",'".$dtx."')":$vls_i.",(".$row_h['ID_DESPACHO'].",4,".$row_i['COD_OBJECT_MAP'].",".$idu.",".$excel->val($row,'E').",".$ob.",".$dte.",'".date('Y-m-d H:i:s')."',".$excel->val($row,'F').",".$row_l['ID_TIPO_VOLUMEN'].",'".$dtx."')";
				$d++;
				}
		}
		/*for ($x=0;$x<=count($und_ok);$x++) {
			
			}*/
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
		
	}

?>
<blockquote>&nbsp;</blockquote>
<script language="JavaScript"> 
 var f= '<?php echo $h; ?>';
 var m ='<?php echo $mensaje; ?>'; 
	if( f==1){
	  var mensaje = m;
	}else{
	  var mensaje =m;
	}
	//alert(m+" "+f);
	parent.mensaje(mensaje,f);
</script>
