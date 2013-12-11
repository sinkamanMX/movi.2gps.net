<?php


/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
$cadena=' ';

	global $config_bd;
	$conexion = mysqli_connect($config_bd['host'],$config_bd['user'],$config_bd['pass'],$config_bd['bname']);	
/** PHPExcel_IOFactory */

	//$idc   = $userAdmin->user_info['ID_CLIENTE'];
    $idu   = $_GET['id'];
	   
include 'PHPExcel/IOFactory.php';
 

$inputFileName =  dirname(__FILE__).'/PT1.xlsx';  // File to read
//echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}



$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
//print_r($sheetData);
$fechador=' ';
$fecx=array();
$fecy=array();

$listcod=array();
$codes=' ';
$arribo=' ';
$salida=' ';
$cadena2=' ';
$cadena3=' ';
$fechini= array();
$fechfin= array() ;
$valida=0;
$cont=0;
$artu=' ';
$envs=0;
		$f_in=' ';
	$f_fin=' ';
	
$super=count($sheetData)+1;
for($i=0;$i<$super;$i++){  //for
						//echo $i;
						if($i!=1 && $i!=0){ //if para filas no importantes
							$sheetData[$i]['A']=str_replace (' ','',$sheetData[$i]['A']);
							$sheetData[$i]['B']=str_replace (' ','',$sheetData[$i]['B']);
							$sheetData[$i]['C']=str_replace (' ','',$sheetData[$i]['C']);
							$sheetData[$i]['D']=str_replace (' ','',$sheetData[$i]['D']);
							
							$busqin = strstr($sheetData[$i]['E'], " ");
							$busqfi = strstr($sheetData[$i]['F'], " ");
							
							if($busqin&&$busqfi){
								$div=explode(' ',$sheetData[$i]['E']);
								$div1=explode(' ',$sheetData[$i]['F']);
								$arribo=$div[0];
								$salida=$div1[0];
							
							}else{
								$arribo=str_replace (' ','',$sheetData[$i]['E']);
								$salida=str_replace (' ','',$sheetData[$i]['F']);
							
							}
							
						
						if($sheetData[$i]['B']==$cadena2){
									
									$listcod[$cont]='\''.$sheetData[$i]['D'].'\'';
									$fechini[$cont]=$arribo;
									$fechfin[$cont]=$salida;
																
									if($busqin&&$busqfi){
										$fecx[$cont]='\''.$sheetData[$i]['E'].'\',\''.$sheetData[$i]['F'].'\',\''.$sheetData[$i]['A'].'\'';
										//$fecy[$cont]='\''.$sheetData[$i]['F'].'\'';
									}else{
										$fecx[$cont]='\''.$sheetData[$i]['E'].' 00:00\',\''.$sheetData[$i]['F'].' 00:00\',\''.$sheetData[$i]['A'].'\'';
										//$fecy[$cont]='\''.$sheetData[$i]['F'].' 00:00\'';
									
									}
									
										
									$cont++;
									
								$cadena3=$cadena3.'|'.implode(",", $sheetData[$i]);
							
							
							if($i==count($sheetData)){
							
							
											for($o=0;$o<count($fechini);$o++){
												$fi=$fechini[$o];
												
													if($f_in==' '){
														
														$f_in=$fi;	
														
														}else{
															
															if(date("Y-m-d",  strtotime($f_in)) > date("Y-m-d",  strtotime($fi))){
																$f_in=$fi;
																
																}
																
															
															}
												
												}
												
												for($x=0;$x<count($fechfin);$x++){
												
												$ff = $fechfin[$x];
												
													if($f_fin==' '){
														
														$f_fin=$ff;	
														
														}else{
															
															if(date("Y-m-d",  strtotime($f_fin)) < date("Y-m-d",  strtotime($ff))){
																
																$f_fin=$ff;
																
																}

															}
												
												}
										
												if($artu==' '){
												$fechador= implode("#", $fecx);
												$codes=implode(",", $listcod);
												$drs=str_replace ('-','',$f_in);
												$artu='\'1\''.',\''.$idu.'\',\''.$sheetData[$i]['B'].'_'.$drs.'\',\''.$sheetData[$i]['B'].'\',\''.$f_in.' 00:00\''.',\''.$f_fin.' 23:59\''.','.'CURRENT_TIMESTAMP';
												}else{
												$fechador= $fechador.'|'.implode("#", $fecx);
												$codes=$codes.'|'.implode(",", $listcod);
												$drs=str_replace ('-','',$f_in);
												$artu=$artu.'|'.'\'1\''.',\''.$idu.'\',\''.$sheetData[$i]['B'].'_'.$drs.'\',\''.$sheetData[$i]['B'].'\',\''.$f_in.' 00:00\''.',\''.$f_fin.' 23:59\''.','.'CURRENT_TIMESTAMP';
												}
												$f_in=' ';
												$f_fin=' ';
												$fechini= array();
												$listcod=array();
												$fechfin= array();
												$fecx=array();
												//$fecy=array();
												$cont=0;
							
							
							
							
							}
								
								
							}else{
									$cadena2=$sheetData[$i]['B'];
								
								
									
							
								
									
									if($cadena3==' '){
									
										$cadena3=implode(",", $sheetData[$i]);
										
									}else{
										
									
											
											for($o=0;$o<count($fechini);$o++){
												$fi=$fechini[$o];
												
													if($f_in==' '){
														
														$f_in=$fi;	
														
														}else{
															
															if(date("Y-m-d",  strtotime($f_in)) > date("Y-m-d",  strtotime($fi))){
																$f_in=$fi;
																
																}
																
															
															}
												
												}
												
												for($x=0;$x<count($fechfin);$x++){
												
												$ff = $fechfin[$x];
												
													if($f_fin==' '){
														
														$f_fin=$ff;	
														
														}else{
															
															if(date("Y-m-d",  strtotime($f_fin)) < date("Y-m-d",  strtotime($ff))){
																
																$f_fin=$ff;
																
																}

															}
												
												}
										
												if($artu==' '){
												$fechador=implode("#", $fecx);
												$codes=implode(",", $listcod);
												$drs=str_replace ('-','',$f_in);
												$artu='\'1\''.',\''.$idu.'\',\''.$sheetData[$i-1]['B'].'_'.$drs.'\',\''.$sheetData[$i-1]['B'].'\',\''.$f_in.' 00:00\''.',\''.$f_fin.' 23:59\''.','.'CURRENT_TIMESTAMP';
												}else{
												$fechador= $fechador.'|'.implode("#", $fecx) ;
												$codes=$codes.'|'.implode(",", $listcod);
												$drs=str_replace ('-','',$f_in);
												$artu=$artu.'|'.'\'1\''.',\''.$idu.'\',\''.$sheetData[$i-1]['B'].'_'.$drs.'\',\''.$sheetData[$i-1]['B'].'\',\''.$f_in.' 00:00\''.',\''.$f_fin.' 23:59\''.','.'CURRENT_TIMESTAMP';
												}
												$f_in=' ';
												$f_fin=' ';
												$listcod=array();
												$fechini= array();
												$fechfin= array();
												$fecx=array();
												//$fecy=array();
												$cont=0;
											$cadena3=$cadena3.'#'.implode(",", $sheetData[$i]);
										}
										
										//$busx = strstr($sheetData[$i]['E'], " ");
										//$busy = strstr($sheetData[$i]['F'], " ");									
										
										if($busqin&&$busqfi){
											$fecx[$cont]='\''.$sheetData[$i]['E'].'\',\''.$sheetData[$i]['F'].'\',\''.$sheetData[$i]['A'].'\'';
											//$fecy[$cont]='\''.$sheetData[$i]['F'].'\'';
										}else{
											$fecx[$cont]='\''.$sheetData[$i]['E'].' 00:00\',\''.$sheetData[$i]['F'].' 00:00\',\''.$sheetData[$i]['A'].'\'';
											//$fecy[$cont]='\''.$sheetData[$i]['F'].' 00:00\'';
										
										}
										
										$listcod[$cont]='\''.$sheetData[$i]['D'].'\'';
										$fechini[$cont]=$arribo;
									
										$fechfin[$cont]=$salida;
								
									$cont++;
									
									
								}
						
						
						
					
				
						
						
						}// termina if no importante
						
						
						
						
					
					
					}// fin for


$con=mysqli_connect("localhost","savl","397LUP","ALG_BD_CORPORATE_MOVI");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  
 $cadena_codes=' ';
 $cadena_codes2=' ';

//echo $codes;

$divi2= explode('|',$codes);
$divi4= explode('|',$fechador);

for($b=0;$b<count($divi2);$b++){
	
	$divi3=explode(',',$divi2[$b]);
	$divi5=explode('#',$divi4[$b]);

	
	for($c=0;$c<count($divi3);$c++){
		$datas = "SELECT ID_OBJECT_MAP,
				IF(TIPO='G','GP',TIPO)AS TIPO
				FROM ADM_GEOREFERENCIAS G
				WHERE ITEM_NUMBER=".$divi3[$c];
				
				$query = mysqli_query($con,$datas);
				$row = @mysqli_fetch_array($query);
				$count 	= @mysqli_num_rows($query);	
				
				if($count>0){	
				 
					 if($cadena_codes==' '){
					 		
							$cadena_codes='\'1\',\''.$row['ID_OBJECT_MAP'].'\',\''.$idu.'\','.$divi3[$c].','.$divi5[$c].',\'0\',CURRENT_TIMESTAMP ' .',\''.$row['TIPO'].'\'';
					 
					 }else{
					 
							 $cadena_codes= $cadena_codes.'|'.'\'1\',\''.$row['ID_OBJECT_MAP'].'\',\''.$idu.'\','.$divi3[$c].','.$divi5[$c].',\'0\',CURRENT_TIMESTAMP '.',\''.$row['TIPO'].'\'';
					 }
	
				}
				
	}
	
	if($cadena_codes2==' '){
	 $cadena_codes2= $cadena_codes;
	 $cadena_codes=' ';
	}else{
	$cadena_codes2= $cadena_codes2.'#'.$cadena_codes;
	 $cadena_codes=' ';
	}

}

//echo $cadena_codes2;
  
//echo $fechador;
$divi=explode('|',$artu);
$divi6=explode('#',$cadena_codes2);
for($a=0;$a<count($divi);$a++){

$datas1 = "SELECT ID_DESPACHO
FROM DSP_DESPACHO
ORDER BY ID_DESPACHO DESC
LIMIT 1";

$query_hist = mysqli_query($con,$datas1);
$row = @mysqli_fetch_array($query_hist);
$count 	= @mysqli_num_rows($query_hist);		

if($count>0){	 
			$enum=$row['ID_DESPACHO']+1;
				
			$datas2 = "INSERT INTO DSP_DESPACHO (ID_DESPACHO,ID_ESTATUS,COD_USER,DESCRIPCION,ITEM_NUMBER,FECHA_INICIO,FECHA_FIN, CREADO)
			VALUES ('".$enum."',".$divi[$a].")";
			$query_hist2 = mysqli_query($con,$datas2);
			
			$otdiv=explode(',',$divi[$a]);
			//$otdiv[3]
			 $datas5 = "SELECT CU.COD_ENTITY
					FROM DSP_CIRCUITO C
					INNER JOIN DSP_CIRCUITO_UNIDAD CU ON C.ID_CIRCUITO=CU.ID_CIRCUITO
					WHERE C.NOMBRE=".$otdiv[3]." AND C.ID_CLIENT=".$idu;
					
					$query_hist5 = mysqli_query($con,$datas5);
					//$row5 = @mysqli_fetch_array($query_hist5);
			
			while($row5 = mysqli_fetch_array($query_hist5))
  				{
		
			$datas6 = "INSERT INTO DSP_UNIDAD_ASIGNADA (ID_DESPACHO,COD_ENTITY,FECHA_ASIGNACION,COMENTARIO,ACTIVO, LIBRE)
			VALUES ('".$enum."',".$row5['COD_ENTITY'].",CURRENT_TIMESTAMP,' ','1','0')";
			$query_hist6 = mysqli_query($con,$datas6);
			
			}		
			if($query_hist2&&$query_hist6 ){
						
						
						
								$respuesta=' ';
								$exp=explode('|',$divi6[$a]);
								for($i=0;$i<count($exp);$i++){
								
									if($respuesta==' '){
										$respuesta='( \''.$enum.'\','.$exp[$i].')';
									}else{
										$respuesta=$respuesta.','.'( \''.$enum.'\','.$exp[$i].')';
									}
								
								}
							//echo $respuesta;
							$datas3 = "INSERT INTO DSP_ITINERARIO (ID_DESPACHO,ID_ESTATUS,COD_GEO,COD_USER,ITEM_NUMBER,FECHA_ENTREGA,FECHA_FIN,ORD_PRIO,VOLUMEN, CREADO,TIPO_RH)
								VALUES ". $respuesta;
					
							$query_hist3 = mysqli_query($con,$datas3);
							
							if($query_hist3){
								 $envs=1;
								}else{
									$envs=0;
								}
		
			
			}
	 
	 }
	

}
/*mysqli_query($con,"INSERT INTO Persons (FirstName, LastName, Age)
VALUES ('Peter', 'Griffin',35)");
echo
mysqli_query($con,"INSERT INTO Persons (FirstName, LastName, Age) 
VALUES ('Glenn', 'Quagmire',33)");*/
echo $envs;
mysqli_close($con);

//echo $fechador;
//echo $artu;
//echo $codes;



//echo $artu;





?>
