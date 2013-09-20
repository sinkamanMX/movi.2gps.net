<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';	
		
	
	$tpl->set_filenames(array('default'=>'default'));	
	$idc   = $userAdmin->user_info['ID_CLIENTE'];
    
	   

      include('mFunciones_CV.php');
	  
	  //include('cliente_temperatura.php');
	  
	  $funciones_cv = new mFunciones_CV();  
	  
/*$tpl->set_filenames(array(
	   'mViajeConst' => 'tViajeConst'
    ));*/

	$T='';
	$sumata='';

	//-----------------------------------------------------------------------------UNIDADES EN DESPACHADOR
	$unidad='';
	
		$cadentab3='';
			$segmento=array();
			$contseg=0;
			$marc=0;
			$marc1=0;
			$marc2=0;
			echo $fecha=$_GET['date'];
			//$dayhr=date("Y-m-d");
			if($fecha=='undefined'){
			$dayhr=date("Y-m-d");
			$time=date("H:i:s");	
			 $time2='23:30:00';
			
			}else{
			$dayhr=$_GET['date'];
			$time='23:30:00';
			$time2='23:30:00';
			
			}
			$oper=0;

	

	
  $sql = "SELECT UA.COD_ENTITY,
  D.ID_DESPACHO,D.DESCRIPCION AS VJE,
UN.DESCRIPTION AS UND, 
D.ITEM_NUMBER, 
D.FECHA_INICIO, 
D.FECHA_FIN,
D.TOLERANCIA,
(SELECT COUNT(X.ID_DESPACHO)
  FROM DSP_ITINERARIO X
  WHERE X.ID_DESPACHO = D.ID_DESPACHO AND
      ((X.FECHA_ARRIBO > X.FECHA_ENTREGA) OR
       ((X.FECHA_ARRIBO = '0000-00-00 00:00:00') AND (X.FECHA_ENTREGA <=
CURRENT_TIMESTAMP)))) AS PENDIENTES
FROM
   DSP_DESPACHO D
INNER JOIN DSP_UNIDAD_ASIGNADA UA ON UA.ID_DESPACHO=D.ID_DESPACHO
INNER JOIN ADM_UNIDADES UN ON UN.COD_ENTITY=UA.COD_ENTITY
INNER JOIN ADM_USUARIOS_GRUPOS GD ON GD.COD_ENTITY = UN.COD_ENTITY
INNER JOIN ADM_GRUPOS G ON G.ID_GRUPO = GD.ID_GRUPO
WHERE GD.ID_USUARIO=".$idc." AND
FECHA_INICIO BETWEEN '".$dayhr." 00:00:00' AND '".$dayhr." 23:59:00'
  ORDER BY PENDIENTES DESC";


  
	/*AND (ID_ESTATUS=1 OR ID_ESTATUS=4)    rowspan='3'*/
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){
	
	//	$unidad.= "<tr><th width='15%'  bgcolor='#DBDBDB' rowspan='2' >".utf8_encode($row['VJE'])."<br>".utf8_encode($row['UND'])."</th> </tr>";
		$segmento[$contseg][0]=utf8_encode($row['VJE']);
		$segmento[$contseg][1]=utf8_encode($row['UND']);
		$segmento[$contseg][2]=utf8_encode($row['COD_ENTITY']);
		$segmento[$contseg][3]=utf8_encode($row['ID_DESPACHO']);
					

			$contseg++;					
				}
				
			}else{
			$unidad.="<tr><td>No se tienen viajes programados actualmente</td></tr>";
			}	
			
			
	
	//----------------------------------------------------------------------------CALCULO DE HORA Y TAMAÑO DE TABLA
	$secday=86400;
	$contfrac=0;
	$secfrac=900;
	$limit=0;
	$lim=0;
	$flag=0;
	$fla1=0;
	$frac=array();
	$sechoour=1800;
	$cont_count=0;
	for($i=0;$i<48;$i++){
		
		
		if($contfrac<=$secday){
		$frac[$i]=$contfrac;
		
		}
		$contfrac=$contfrac+$sechoour;
		}
	

	$sql="SELECT TIME_TO_SEC('".$time2."') AS TIME, TIME_TO_SEC('".$time."') AS TIMES ";
	$query = $db->sqlQuery($sql);
	$row = $db->sqlFetchArray($query);
 	$real=$row['TIMES'];
	$second2=$row['TIME'];
	
	for($ii=0;$ii<count($frac);$ii++){
		
		if(($frac[$ii]>=$real)&&($fla1==0)){
			$lim=$ii+1;
			$fla1=1;
			}
		
		}
		
	for($i=0;$i<count($frac);$i++){
		
		if(($frac[$i]>=$second2)&&($flag==0)){
			$limit=$i+1;
			$flag=1;
			}
		
		}
		$cadentab='';
		$cadentab2='';
		$cnt=-1;
		$cnt1=0;
		$divisor='';
		$conta=0;
		///------------------------------------------------------------------- construir tabla 
		for($i=0;$i<($limit/2);$i++){
			$cnt++;
			$cnt1=$i+$cnt;
			$divisor=explode(':',$funciones_cv->convierte_horas($frac[$cnt1]));
			$cadentab.="<th align='center' colspan='2' bgcolor='#DBDBDB' style='border:#FFFFFF solid 1px;'>".$divisor[0]."</th>";
		}
		for($i=0;$i<$limit;$i++){
			$marc2=$marc2+1;
			$divisor=explode(':',$funciones_cv->convierte_horas($frac[$i]));
			$cadentab2.="<th align='center' style='width:10px; border:#FFFFFF solid 1px;' bgcolor='#999999' >".$divisor[1]."</th>";
		}


	//________________________________________________________________________________ VISITAS ESTABLECIDAS
	$limit1=0;
	$cantidad=0;
	$sombra=0;
	$rest1=0;
	$band1=0;
	$band2=0;
	
	for($i=0;$i<count($segmento);$i++){	
	$cad_plan='';
	
	//-----------------------------------------------------------------------------------UNIDAD EN CUESTION 
	 $unidad.= "<tr class='inf_viaj'><th width='15%'  bgcolor='#DBDBDB' rowspan='3' style='border:#FFFFFF solid 1px;' >".utf8_encode($segmento[$i][0])."<br>".utf8_encode($segmento[$i][1])."</th> ";
	

////--------------------------------------------------------------------------------TIEMPOS 
  $sql1 = "SELECT CONCAT(PG.DESCRIPCION,' - ',P.VOLUMEN,' ',V.DESCRIPCION) AS
DESCRIPTION,
   AU.COD_ENTITY,
   P.COD_GEO,
   P.ID_DESPACHO,
   P.FECHA_ENTREGA,
   P.FECHA_FIN,
  TIME_TO_SEC(CAST(P.FECHA_ENTREGA AS TIME)) AS MINI,
  TIME_TO_SEC(CAST(P.FECHA_FIN AS TIME)) AS MAXI,
  PG.ITEM_NUMBER
FROM
   DSP_ITINERARIO P
   INNER JOIN DSP_UNIDAD_ASIGNADA AU ON (P.ID_DESPACHO = AU.ID_DESPACHO)
   INNER JOIN DSP_TIPO_VOLUMEN V ON P.ID_TIPO_VOLUMEN = V.ID_TIPO_VOLUMEN
   LEFT OUTER JOIN ADM_GEOREFERENCIAS PG ON (P.COD_GEO = PG.ID_TIPO_GEO)
   INNER JOIN DSP_DESPACHO NS ON (P.ID_DESPACHO=NS.ID_DESPACHO)
WHERE
   (FECHA_ENTREGA BETWEEN '".$dayhr." 00:00:00' AND '".$dayhr." 23:59:00')
AND
	P.ID_DESPACHO IN (".$segmento[$i][3].")

GROUP BY
  FECHA_ENTREGA ASC";
 
 $query1 = $db->sqlQuery($sql1);
	$count = $db->sqlEnumRows($query1);
			if($count>0){
				//echo $count.',';
				while($row1 = $db->sqlFetchArray($query1)){
					
				 $cantidad=$cantidad+1;
				
				for($o=$limit1;$o<$limit;$o++){
					
					$rest=$row1['MINI']-$frac[$o];
					
				
					if(($row1['MINI']==$frac[$o])||$rest<1800){
						
						if(($row1['MINI']==$frac[$o])&& $marc==0 ||$band1==1 && $marc==0){
							$marc1=$marc1+1;
							$rest1=$row1['MAXI']-$frac[$o];
							$band1=1;
							$cad_plan.='|'.$o.',';
							
							
							if(($row1['MAXI']==$frac[$o])&& $band2==0 ){
								$band2=1;
								$marc=1;
								 $da=$marc1-1;
								$sombra=$sombra+$da;
								
								 $unidad.="<td  align='center' class='car2' style=' background-color:#336699; border-style: dashed; border-left-color:#336699; border-width: 1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' colspan='". $da."'>".$row1['ITEM_NUMBER']."<br><a href='#' class='tooltip' > <input type='text' style=' background-color:#336699; border-style:hidden; width:".$da ."0px;' readonly='readonly' ><span  class='ui-corner-all' style='left:250px; font-size:10px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$Functions->codif($row1['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row1['FECHA_ENTREGA']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row1['FECHA_FIN']."</td></tr></table></span></a></td>";
								$limit1=$o+1;
								
							}
						if(($rest1<=1800)&& $band2==0  ){
							
							$band2=1;
							$marc=1;
							 $da=$marc1;
							$sombra=$sombra+$marc1;
							
				$unidad.="<td   align='center' class='car2' style=' background-color:#336699; border-style: dashed; border-left-color:#336699; border-width: 1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' colspan='". $da."'>".$row1['ITEM_NUMBER']."<br><a href='#' class='tooltip' > <input type='text' style=' background-color:#336699; border-style:hidden; width:".$da ."0px;' readonly='readonly' ><span  class='ui-corner-all' style=' font-size:10px; left:250px; height:inherit; top:340px; z-index:999; position:absolute;'><table boder='0' style='z-index:99; position:relative;'><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$Functions->codif($row1['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row1['FECHA_ENTREGA']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row1['FECHA_FIN']."</td></tr></table></span></a></td>";
							$limit1=$o+1;
								}
							
							}else{
						if(($row1['MINI']<$frac[$o]) && $marc==0 && $band1==0|| $rest<1800 && $marc==0 && $band1==0){
						 $marc1=$marc1+1;
						$cad_plan.='|'.$o.',';
						$rest1=$row1['MAXI']-$frac[$o];
					
							
							if(($rest1<1800) ){
							$marc=1;
							 $da=$marc1;
							$sombra=$sombra+$da;
						
				$unidad.="<td  align='center' class='car2' style=' background-color:#336699; border-style: dashed; border-left-color:#336699; border-width: 1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' colspan='". $da."'>".$row1['ITEM_NUMBER']."<br><a href='#' class='tooltip' > <input type='text' style=' background-color:#336699; border-style:hidden; width:".$da ."0px;' readonly='readonly' ><span  class='ui-corner-all' style=' font-size:10px; left:250px; top:340px; z-index:999;  position:absolute;'><table boder='0' style='z-index:99; position:absolute;'><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$Functions->codif($row1['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row1['FECHA_ENTREGA']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row1['FECHA_FIN']."</td></tr></table></span></a></td>";
							$limit1=$o+1;
							}else{
									
								if($o==$limit-1){
									
								$marc=1;
							 $da=$marc1;
							$sombra=$sombra+$da;
						
				$unidad.="<td  align='center' class='car2' style=' background-color:#336699; border-style: dashed; border-left-color:#336699; border-width: 1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' colspan='". $da."'>".$row1['ITEM_NUMBER']."<br><a href='#' class='tooltip' > <input type='text' style=' background-color:#336699; border-style:hidden; width:".$da ."0px;' readonly='readonly' ><span  class='ui-corner-all' style='font-size:10px; left:250px; top:340px; z-index:999; height:inherit; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$Functions->codif($row1['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row1['FECHA_ENTREGA']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row1['FECHA_FIN']."</td></tr></table></span></a></td>";
							$limit1=$o+1;
							
									}
									
							}
								
						
							}
							}
						
						
						}else{
							$conta++;
							
							if($conta>=$limit+1){
								break;
								}
							$unidad.="<td align='center' bgcolor='#DBDBDB' style=' border-style: dashed; border-left : 0px dashed #DBDBDB; border-width: 1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' ><input type='text' style=' background-color:#DBDBDB; border-style:hidden; width:3px;' readonly='readonly' ></td>";
							}
							
							
					
					}
			
							
				$marc1=0;
				$marc=0;
				$band1=0;
			$band2=0;
				if($cantidad==$count){
			$sumar=$conta+$sombra;
					if($sumar<$limit){
					$restar=$limit-$sumar;
			
				for($com=0;$com<$restar;$com++){
					$unidad.="<td align='center' bgcolor='#DBDBDB' style=' border-style: dashed; border-left : 0px dashed #DBDBDB; border-width: 1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' ><input type='text' style=' background-color:#DBDBDB; border-style:hidden; width:3px;' readonly='readonly' ></td>";
					
					}
					}
				
					
					}
				
				
				}
				
			}else{
					for($l=0;$l<$limit;$l++){
			$unidad.="<td align='center' bgcolor='#DBDBDB' style=' border-style: dashed; border-left : 0px dashed #DBDBDB; border-width: 1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' ><input type='text' style=' background-color:#DBDBDB; border-style:hidden; width:3px;' readonly='readonly' ></td>";	}
			}	
			
		$unidad.="</tr><tr>";
			//////-------------------------------------------------------------------------------------TIEMPOS REALES
					 $unidad.= " ";
			$conta=0;
			$limit1=0;
			$marc=0;
			$marc1=0;
			$cantidad=0;
			$sombra=0; $rest1=0;
			$band1=0;
			$band2=0;
			$bands=0;
			$cont_part=-1;
			$data_new='';
			$repet='';
			$put_ban=0;
	////--------------------------------------------------------------------------------TIEMPOS 

$sql2 = "SELECT PG.DESCRIPCION,
  AU.COD_ENTITY,
  P.COD_GEO,
  P.ID_DESPACHO,
 P.FECHA_ARRIBO,
 IF(P.FECHA_SALIDA = '0000-00-00 00:00:00', 'SIGUE EN EL PUNTO', P.FECHA_SALIDA) AS FECHA_SALIDA,
 TIME_TO_SEC(CAST(FECHA_ARRIBO AS TIME)) AS MINI,
 IF(P.FECHA_SALIDA = '0000-00-00 00:00:00',TIME_TO_SEC(CAST(CURRENT_TIMESTAMP AS TIME)) , TIME_TO_SEC(CAST(FECHA_SALIDA AS TIME))) AS MAXI,
 P.ID_ENTREGA
FROM
  DSP_ITINERARIO P
  INNER JOIN DSP_UNIDAD_ASIGNADA AU ON (P.ID_DESPACHO = AU.ID_DESPACHO)
  LEFT OUTER JOIN ADM_GEOREFERENCIAS PG ON (P.COD_GEO = PG.ID_TIPO_GEO)
  INNER JOIN DSP_DESPACHO NS ON (P.ID_DESPACHO=NS.ID_DESPACHO)
WHERE
  (FECHA_ARRIBO BETWEEN '".$dayhr." 00:00:00' AND '".$dayhr." 23:59:00') AND
P.ID_DESPACHO IN (".$segmento[$i][3].")
GROUP BY
 FECHA_ARRIBO ASC";	
 
 $query2 = $db->sqlQuery($sql2);
	$count2 = $db->sqlEnumRows($query2);
			if($count2>0){
				while($row2 = $db->sqlFetchArray($query2)){
				$cantidad=$cantidad+1;
				$color1='';
				$color='';$cuenta=0;
				for($k=$limit1;$k<$lim;$k++){
					$rest=$row2['MINI']-$frac[$k];
					
					
					
					if(($row2['MINI']<$frac[$k]) || ($row2['MINI']==$frac[$k])||$rest<1800){
						
							
							if(($row2['MINI']==$frac[$k])&& $marc==0 ||$band1==1 && $marc==0){
							 $marc1=$marc1+1;
							 //echo $row2['MAXI'].'-'.$frac[$k].'=';
							 $rest1=$row2['MAXI']-$frac[$k];
					
							$band1=1;
							//temperatura
							//obtiene la temperatura
							//$ip = $funciones_cv->dame_ip($row2['COD_ENTITY'],$frac[$k],&$hora);
						    //echo $ip." ---" .$dayhr.'-- '.$hora;
						   // $temperatura.= $funciones_cv->dame_temperatura($dayhr.' '.$hora,$ip).",";
							/////------------------------------------------QUERY
							$qry="SELECT ID_ENTREGA, FECHA_ENTREGA, FECHA_FIN, FECHA_ARRIBO,
								FECHA_SALIDA, TIME_TO_SEC(CAST(FECHA_ENTREGA AS TIME)) AS EP,
								TIME_TO_SEC(CAST(FECHA_FIN AS TIME)) AS FP,
								TIME_TO_SEC(CAST(FECHA_ARRIBO AS TIME)) AS ER,
								TIME_TO_SEC(CAST(FECHA_SALIDA AS TIME)) AS AFR, 
								IF((".$frac[$k]." <= TIME_TO_SEC(CAST(FECHA_ENTREGA AS TIME))) AND 
								  (".$frac[$k]." <= TIME_TO_SEC(CAST(FECHA_ARRIBO AS TIME))) AND 
								  (".$frac[$k]." <= TIME_TO_SEC(CAST(FECHA_FIN AS TIME))) AND (".$frac[$k]." <= TIME_TO_SEC(CAST(IF(FECHA_SALIDA='0000-00-00 00:00:00',CURRENT_TIMESTAMP,FECHA_SALIDA) AS TIME))),'#336600',
							
							IF((".$frac[$k]." <= TIME_TO_SEC(CAST(FECHA_ENTREGA AS TIME))) AND 
								  (".$frac[$k]." >= TIME_TO_SEC(CAST(FECHA_ARRIBO AS TIME))) AND 
								  (".$frac[$k]." <= TIME_TO_SEC(CAST(FECHA_FIN AS TIME))) AND (".$frac[$k]." <= TIME_TO_SEC(CAST(IF(FECHA_SALIDA='0000-00-00 00:00:00',CURRENT_TIMESTAMP,FECHA_SALIDA) AS TIME))),'#336600',
							   IF((".$frac[$k]." > TIME_TO_SEC(CAST(FECHA_ENTREGA AS TIME))) AND 
								  (".$frac[$k]." = TIME_TO_SEC(CAST(FECHA_ARRIBO AS TIME))) AND 
								  (".$frac[$k]." <= TIME_TO_SEC(CAST(FECHA_FIN AS TIME))) AND (".$frac[$k]." <= TIME_TO_SEC(CAST(IF(FECHA_SALIDA='0000-00-00 00:00:00',CURRENT_TIMESTAMP,FECHA_SALIDA) AS TIME))),'#b12300',  
							  IF((".$frac[$k]." > TIME_TO_SEC(CAST(FECHA_ENTREGA AS TIME))) AND 
								  (".$frac[$k]." > TIME_TO_SEC(CAST(FECHA_ARRIBO AS TIME))) AND 
								  (".$frac[$k]." < TIME_TO_SEC(CAST(FECHA_FIN AS TIME))) AND (".$frac[$k]." < TIME_TO_SEC(CAST(IF(FECHA_SALIDA='0000-00-00 00:00:00',CURRENT_TIMESTAMP,FECHA_SALIDA) AS TIME))),'#336600', 
							  IF((".$frac[$k]." > TIME_TO_SEC(CAST(FECHA_ENTREGA AS TIME))) AND 
								  (".$frac[$k]." > TIME_TO_SEC(CAST(FECHA_ARRIBO AS TIME))) AND 
								  (".$frac[$k]." <= TIME_TO_SEC(CAST(FECHA_FIN AS TIME))) AND (".$frac[$k]." = TIME_TO_SEC(CAST(IF(FECHA_SALIDA='0000-00-00 00:00:00',CURRENT_TIMESTAMP,FECHA_SALIDA) AS TIME))),'#336600', '#b12300'
							))
							)
							)) as RESULTADO FROM DSP_ITINERARIO WHERE
								ID_ENTREGA =".$row2['ID_ENTREGA'];
							
							$query5 = $db->sqlQuery($qry);
							$count5 = $db->sqlEnumRows($query5);
			
							while($row5 = $db->sqlFetchArray($query5)){
								
								 $color.=$row5['RESULTADO'].',';
								
								}
							
							/////-----------------------------------------------
							if(($row2['MAXI']==$frac[$k])&& $band2==0 ){
								$marc=1;
								$band2=1;
								 $da=$marc1;
								$sombra=$sombra+$da;
								$color1=explode(',',$color);
						        //$temp1=explode(',',$temperatura);
								 
								for($p=0;$p<$da;$p++){
								
								$cuenta=$cuenta+1;
								if($da!=1){
									if($cuenta<$da){
										if($cuenta==1){
								
								$unidad.="<td  align='center'   class='car'  style=' background-color:".$color1[$p]."; border-right:1px dashed black; border-style: dashed; border-left:0px; border-width: 0px; border-top : 0px dashed white;  border-bottom : 0px dashed white;'  id='toltip'><a href='#' class='tooltip' > <input type='text' style=' background-color:".$color1[$p]."; border-style:hidden; width:5px;' readonly='readonly' ><span  class='ui-corner-all' style='left:250px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row2['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row2['FECHA_ARRIBO']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row2['FECHA_SALIDA']."</td></tr></table></span></a></td>";
											
											}else{
											
									$unidad.="<td  align='center'    style=' background-color:".$color1[$p]."; border-right:1px dashed black; border-style: dashed; border-left:0px; border-width: 0px; border-top : 0px dashed white;  border-bottom : 0px dashed white;'  id='toltip'><a href='#' class='tooltip' > <input type='text' style=' background-color:".$color1[$p]."; border-style:hidden; width:5px;' readonly='readonly' ><span  class='ui-corner-all' style='left:250px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row2['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row2['FECHA_ARRIBO']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row2['FECHA_SALIDA']."</td></tr></table></span></a></td>";
											}
										}else{
											$unidad.="<td  align='center' class='car1'   style=' background-color:".$color1[$p]."; border-right:1px dashed black; border-style: dashed; border-left:0px; border-width: 0px; border-top : 0px dashed white;  border-bottom : 0px dashed white;'  id='toltip'><a href='#' class='tooltip' > <input type='text' style=' background-color:".$color1[$p]."; border-style:hidden; width:5px;' readonly='readonly' ><span  class='ui-corner-all' style='left:250px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row2['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row2['FECHA_ARRIBO']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row2['FECHA_SALIDA']."</td></tr></table></span></a></td>";

										} }else{
											$unidad.="<td  align='center' class='car2'    style=' background-color:".$color1[$p]."; border-right:1px dashed black; border-style: dashed; border-left:0px; border-width: 0px; border-top : 0px dashed white;  border-bottom : 0px dashed white;'  id='toltip'><a href='#' class='tooltip' > <input type='text' style=' background-color:".$color1[$p]."; border-style:hidden; width:5px;' readonly='readonly' ><span  class='ui-corner-all' style='font-size:10px; left:250px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row2['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row2['FECHA_ARRIBO']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row2['FECHA_SALIDA']."</td></tr></table></span></a></td>";

											
								}
								
								
								}
								 
								$limit1=$k+1;
							}	
							
							if(($rest1<=1800)&& $band2==0 ){
							$band2=1;
							$marc=1;

							 $da=$marc1;
							$sombra=$sombra+$da;
							$color1=explode(',',$color);
				  for($p=0;$p<$da;$p++){
								
								$cuenta=$cuenta+1;
								if($da!=1){
									if($cuenta<$da){
										if($cuenta==1){
								
								$unidad.="<td  align='center'   class='car'  style=' background-color:".$color1[$p]."; border-right:1px dashed black; border-style: dashed; border-left:0px; border-width: 0px; border-top : 0px dashed white;  border-bottom : 0px dashed white;'  id='toltip'><a href='#' class='tooltip' > <input type='text' style=' background-color:".$color1[$p]."; border-style:hidden; width:5px;' readonly='readonly' ><span  class='ui-corner-all' style='left:250px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row2['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row2['FECHA_ARRIBO']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row2['FECHA_SALIDA']."</td></tr></table></span></a></td>";
											
											}else{
											
									$unidad.="<td  align='center'    style=' background-color:".$color1[$p]."; border-right:1px dashed black; border-style: dashed; border-left:0px; border-width: 0px; border-top : 0px dashed white;  border-bottom : 0px dashed white;'  id='toltip'><a href='#' class='tooltip' > <input type='text' style=' background-color:".$color1[$p]."; border-style:hidden; width:5px;' readonly='readonly' ><span  class='ui-corner-all' style='left:250px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row2['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row2['FECHA_ARRIBO']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row2['FECHA_SALIDA']."</td></tr></table></span></a></td>";
											}
										}else{
											$unidad.="<td  align='center' class='car1'   style=' background-color:".$color1[$p]."; border-right:1px dashed black; border-style: dashed; border-left:0px; border-width: 0px; border-top : 0px dashed white;  border-bottom : 0px dashed white;'  id='toltip'><a href='#' class='tooltip' > <input type='text' style=' background-color:".$color1[$p]."; border-style:hidden; width:5px;' readonly='readonly' ><span  class='ui-corner-all' style='left:250px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row2['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row2['FECHA_ARRIBO']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row2['FECHA_SALIDA']."</td></tr></table></span></a></td>";

										} }else{
											$unidad.="<td  align='center' class='car2'    style=' background-color:".$color1[$p]."; border-right:1px dashed black; border-style: dashed; border-left:0px; border-width: 0px; border-top : 0px dashed white;  border-bottom : 0px dashed white;'  id='toltip'><a href='#' class='tooltip' > <input type='text' style=' background-color:".$color1[$p]."; border-style:hidden; width:5px;' readonly='readonly' ><span  class='ui-corner-all' style='font-size:10px; left:250px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row2['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row2['FECHA_ARRIBO']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row2['FECHA_SALIDA']."</td></tr></table></span></a></td>";

											
								}
								
								
								}
								 		$limit1=$o+1;
								}
							
							}else{
						
						if(($row2['MINI']<$frac[$k]) && $marc==0 && $band1==0|| $rest<1800 && $marc==0 && $band1==0 ){
						  $marc1=$marc1+1;
						   //	echo $row2['MAXI'].'-'.$frac[$k].'=';
						//	echo 
							//echo '!!';
						$rest1=$row2['MAXI']-$frac[$k];
						
						// temperatura
						//obtiene la temperatura
							//$ip = $funciones_cv->dame_ip($row2['COD_ENTITY'],$frac[$k],&$hora);
						    //echo $ip." ---" .$dayhr.'-- '.$hora;
						    //$temperatura.= $funciones_cv->dame_temperatura($dayhr.' '.$hora,$ip).",";
						
						/////------------------------------------------QUERY
				 $qry1="SELECT ID_ENTREGA, FECHA_ENTREGA, FECHA_FIN, FECHA_ARRIBO,
								FECHA_SALIDA, TIME_TO_SEC(CAST(FECHA_ENTREGA AS TIME)) AS EP,
								TIME_TO_SEC(CAST(FECHA_FIN AS TIME)) AS FP,
								TIME_TO_SEC(CAST(FECHA_ARRIBO AS TIME)) AS ER,
								TIME_TO_SEC(CAST(FECHA_SALIDA AS TIME)) AS AFR, 
								IF((".$frac[$k]." <= TIME_TO_SEC(CAST(FECHA_ENTREGA AS TIME))) AND 
								  (".$frac[$k]." <= TIME_TO_SEC(CAST(FECHA_ARRIBO AS TIME))) AND 
								  (".$frac[$k]." <= TIME_TO_SEC(CAST(FECHA_FIN AS TIME))) AND (".$frac[$k]." <= TIME_TO_SEC(CAST(IF(FECHA_SALIDA='0000-00-00 00:00:00',CURRENT_TIMESTAMP,FECHA_SALIDA) AS TIME))),'#336600',
							
							IF((".$frac[$k]." <= TIME_TO_SEC(CAST(FECHA_ENTREGA AS TIME))) AND 
								  (".$frac[$k]." >= TIME_TO_SEC(CAST(FECHA_ARRIBO AS TIME))) AND 
								  (".$frac[$k]." <= TIME_TO_SEC(CAST(FECHA_FIN AS TIME))) AND (".$frac[$k]." <= TIME_TO_SEC(CAST(IF(FECHA_SALIDA='0000-00-00 00:00:00',CURRENT_TIMESTAMP,FECHA_SALIDA) AS TIME))),'#336600',
							   IF((".$frac[$k]." > TIME_TO_SEC(CAST(FECHA_ENTREGA AS TIME))) AND 
								  (".$frac[$k]." = TIME_TO_SEC(CAST(FECHA_ARRIBO AS TIME))) AND 
								  (".$frac[$k]." <= TIME_TO_SEC(CAST(FECHA_FIN AS TIME))) AND (".$frac[$k]." <= TIME_TO_SEC(CAST(IF(FECHA_SALIDA='0000-00-00 00:00:00',CURRENT_TIMESTAMP,FECHA_SALIDA) AS TIME))),'#b12300',  
							  IF((".$frac[$k]." > TIME_TO_SEC(CAST(FECHA_ENTREGA AS TIME))) AND 
								  (".$frac[$k]." > TIME_TO_SEC(CAST(FECHA_ARRIBO AS TIME))) AND 
								  (".$frac[$k]." < TIME_TO_SEC(CAST(FECHA_FIN AS TIME))) AND (".$frac[$k]." < TIME_TO_SEC(CAST(IF(FECHA_SALIDA='0000-00-00 00:00:00',CURRENT_TIMESTAMP,FECHA_SALIDA) AS TIME))),'#336600', 
							  IF((".$frac[$k]." > TIME_TO_SEC(CAST(FECHA_ENTREGA AS TIME))) AND 
								  (".$frac[$k]." > TIME_TO_SEC(CAST(FECHA_ARRIBO AS TIME))) AND 
								  (".$frac[$k]." <= TIME_TO_SEC(CAST(FECHA_FIN AS TIME))) AND (".$frac[$k]." = TIME_TO_SEC(CAST(IF(FECHA_SALIDA='0000-00-00 00:00:00',CURRENT_TIMESTAMP,FECHA_SALIDA) AS TIME))),'#336600', '#b12300'
							))
							)
							)) as RESULTADO FROM DSP_ITINERARIO WHERE
								ID_ENTREGA =".$row2['ID_ENTREGA'];
							
							$query4 = $db->sqlQuery($qry1);
							$count4 = $db->sqlEnumRows($query4);
			
							while($row4 = $db->sqlFetchArray($query4)){
								
								 $color.=$row4['RESULTADO'].',';
								
								}
							
							/////-----------------------------------------------
						
						
						
						
							if(($rest1<1800) ){
							$marc=1;
							 $da=$marc1;
							 $sombra=$sombra+$da;
								//$temperatura=',';
								$color1=explode(',',$color);
								//$temp1=explode(',',$temperatura);
								for($p=0;$p<$da;$p++){
								
								$cuenta=$cuenta+1;
								if($da!=1){
									if($cuenta<$da){
										if($cuenta==1){
								
								$unidad.="<td  align='center'   class='car'  style=' background-color:".$color1[$p]."; border-right:1px dashed black; border-style: dashed; border-left:0px; border-width: 0px; border-top : 0px dashed white;  border-bottom : 0px dashed white;'  id='toltip'><a href='#' class='tooltip' > <input type='text' style=' background-color:".$color1[$p]."; border-style:hidden; width:5px;' readonly='readonly' ><span  class='ui-corner-all' style='left:250px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row2['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row2['FECHA_ARRIBO']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row2['FECHA_SALIDA']."</td></tr></table></span></a></td>";
											
											}else{
											
									$unidad.="<td  align='center'    style=' background-color:".$color1[$p]."; border-right:1px dashed black; border-style: dashed; border-left:0px; border-width: 0px; border-top : 0px dashed white;  border-bottom : 0px dashed white;'  id='toltip'><a href='#' class='tooltip' > <input type='text' style=' background-color:".$color1[$p]."; border-style:hidden; width:5px;' readonly='readonly' ><span  class='ui-corner-all' style='left:250px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row2['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row2['FECHA_ARRIBO']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row2['FECHA_SALIDA']."</td></tr></table></span></a></td>";
											}
										}else{
											$unidad.="<td  align='center' class='car1'   style=' background-color:".$color1[$p]."; border-right:1px dashed black; border-style: dashed; border-left:0px; border-width: 0px; border-top : 0px dashed white;  border-bottom : 0px dashed white;'  id='toltip'><a href='#' class='tooltip' > <input type='text' style=' background-color:".$color1[$p]."; border-style:hidden; width:5px;' readonly='readonly' ><span  class='ui-corner-all' style='left:250px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row2['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row2['FECHA_ARRIBO']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row2['FECHA_SALIDA']."</td></tr></table></span></a></td>";

										} }else{
											$unidad.="<td  align='center' class='car2'    style=' background-color:".$color1[$p]."; border-right:1px dashed black; border-style: dashed; border-left:0px; border-width: 0px; border-top : 0px dashed white;  border-bottom : 0px dashed white;'  id='toltip'><a href='#' class='tooltip' > <input type='text' style=' background-color:".$color1[$p]."; border-style:hidden; width:5px;' readonly='readonly' ><span  class='ui-corner-all' style='font-size:10px; left:250px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row2['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row2['FECHA_ARRIBO']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row2['FECHA_SALIDA']."</td></tr></table></span></a></td>";

											
								}
								
								
								}
								 
							
							$limit1=$k+1;
							}else{
								if($k==$lim-1){
								$marc=1;
								 $da=$marc1;
								 $sombra=$sombra+$da;
							
								$color1=explode(',',$color);
								//echo $color1;
								for($p=0;$p<$da;$p++){
								
								$cuenta=$cuenta+1;
								if($da!=1){
									if($cuenta<$da){
										if($cuenta==1){
								
								            $unidad.="<td  align='center'   class='car'  style=' background-color:".$color1[$p]."; border-right:1px dashed black; border-style: dashed; border-left:0px; border-width: 0px; border-top : 0px dashed white;  border-bottom : 0px dashed white;'  id='toltip'><a href='#' class='tooltip' > <input type='text' style=' background-color:".$color1[$p]."; border-style:hidden; width:5px;' readonly='readonly' ><span  class='ui-corner-all' style='left:250px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row2['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row2['FECHA_ARRIBO']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row2['FECHA_SALIDA']."</td></tr></table></span></a></td>";
											
											}else{
											
									$unidad.="<td  align='center'    style=' background-color:".$color1[$p]."; border-right:1px dashed black; border-style: dashed; border-left:0px; border-width: 0px; border-top : 0px dashed white;  border-bottom : 0px dashed white;'  id='toltip'><a href='#' class='tooltip' > <input type='text' style=' background-color:".$color1[$p]."; border-style:hidden; width:5px;' readonly='readonly' ><span  class='ui-corner-all' style='left:250px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row2['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row2['FECHA_ARRIBO']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row2['FECHA_SALIDA']."</td></tr></table></span></a></td>";
											}
										}else{
											$unidad.="<td  align='center' class='car1'   style=' background-color:".$color1[$p]."; border-right:1px dashed black; border-style: dashed; border-left:0px; border-width: 0px; border-top : 0px dashed white;  border-bottom : 0px dashed white;'  id='toltip'><a href='#' class='tooltip' > <input type='text' style=' background-color:".$color1[$p]."; border-style:hidden; width:5px;' readonly='readonly' ><span  class='ui-corner-all' style='left:250px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row2['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row2['FECHA_ARRIBO']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row2['FECHA_SALIDA']."</td></tr></table></span></a></td>";

										} }else{
											$unidad.="<td  align='center' class='car2'    style=' background-color:".$color1[$p]."; border-right:1px dashed black; border-style: dashed; border-left:0px; border-width: 0px; border-top : 0px dashed white;  border-bottom : 0px dashed white;'  id='toltip'><a href='#' class='tooltip' > <input type='text' style=' background-color:".$color1[$p]."; border-style:hidden; width:5px;' readonly='readonly' ><span  class='ui-corner-all' style='font-size:10px; left:250px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row2['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row2['FECHA_ARRIBO']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row2['FECHA_SALIDA']."</td></tr></table></span></a></td>";

											
								}
								
								
								}
								 
								 
								$limit1=$k+1;
								}
							
								}
						
							}
							}
						
						
						}else{
							
							
					$conta++;
							//$nup=$limit-$da;
							//echo $da.'s'.$conta.'!|';
							if($conta>=$lim+1){
								break;
								}
						//if($userAdmin->codif($row2['DESCRIPTION'])!=$data_new) {$cont_part=$cont_part+1;}
						
						
							//$parte3=explode(',',$cad_plan);
							//$num_part3=count($parte3);
							//for($y=0;$y<$num_part3-1;$y++){
								$valor='|'.$k.',';
			
						
							 if (strstr($cad_plan,$valor)){
       						  
							     $unidad.="<td align='center' bgcolor='#b12300' style=' border-style: dashed; border-left : 0px dashed #b12300; border-width:1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' ><input type='text' style=' background-color:#b12300; border-style:hidden; width:3px;' readonly='readonly' ></td>";	
							
  							  }else{
						
							
						
						if($put_ban==0){
							if($conta==$lim){
							$unidad.="<td align='center' bgcolor='#A0A0A0' style='border-color:#FF0000; border-style: solid; border-left : 0px dashed #A0A0A0; border-width: 2px; border-top : 0px dashed white;   border-bottom : 0px dashed white;' ><input type='text' style=' background-color:#A0A0A0; border-style:hidden; width:3px;' readonly='readonly' ></td>";

							}else{
								$unidad.="<td align='center' bgcolor='#A0A0A0' style=' border-style: dashed; border-left : 0px dashed #A0A0A0; border-width:1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' ><input type='text' style=' background-color:#A0A0A0; border-style:hidden; width:3px;' readonly='readonly' ></td>";	
								}
							}
							//$user =true;
						//	$pass =true;

							}
		
							
							}
					

					}
					
				$marc1=0;
				$marc=0;
				$band1=0;
			$band2=0;
				if($cantidad==$count2){
					$sumar=$conta+$sombra;
					
				
				if($sumar<$lim){
					$restar=$lim-$sumar;
					//echo $restar.'s'.$limit.'!|'.$conta.'*'. $sombra.'*';
				for($com=0;$com<$restar;$com++){
					if($com==$restar-1){
							$unidad.="<td align='center' bgcolor='#A0A0A0' style='border-color:#FF0000; border-style: solid; border-left : 0px dashed #A0A0A0; border-width: 2px; border-top : 0px dashed white;   border-bottom : 0px dashed white;' ><input type='text' style=' background-color:#A0A0A0; border-style:hidden; width:3px;' readonly='readonly' ></td>";

					}else{
		$unidad.="<td align='center' bgcolor='#A0A0A0' style=' border-style: dashed; border-left : 0px dashed #A0A0A0; border-width: 1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' ><input type='text' style=' background-color:#A0A0A0; border-style:hidden; width:3px;' readonly='readonly' ></td>";	}
				}
					
					}
				
					}
				
				}
				
			}else{
			
		
				
			
			for($l=0;$l<$lim;$l++){
			
			$valor='|'.$l.',';
			
						
		if (strstr($cad_plan,$valor)){
       						  
							     $unidad.="<td align='center' bgcolor='#b12300' style=' border-style: dashed; border-left : 0px dashed #b12300; border-width:1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' ><input type='text' style=' background-color:#b12300; border-style:hidden; width:3px;' readonly='readonly' ></td>";	
							
  							  }else{
			
				if($l==$lim-1){
				
				
						$unidad.="<td align='center' bgcolor='#A0A0A0' style='border-color:#FF0000; border-style: solid; border-left : 0px dashed #A0A0A0; border-width: 2px; border-top : 0px dashed white;   border-bottom : 0px dashed white;' ><input type='text' style=' background-color:#A0A0A0; border-style:hidden; width:3px;' readonly='readonly' ></td>";

				}else{
					$unidad.="<td align='center' bgcolor='#A0A0A0' style=' border-style: dashed; border-left : 0px dashed #A0A0A0; border-width: 1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' ><input type='text' style=' background-color:#A0A0A0; border-style:hidden; width:3px;' readonly='readonly' ></td>";	
				}
				
				
				}
				
				}
			
			}	
			
			if($lim<$limit){
			
					$restar=$limit-$lim;
					//echo $restar.'s'.$limit.'!|'.$conta.'*'. $sombra.'*';
				for($com=0;$com<$restar;$com++){
					
					$unidad.="<td align='center' bgcolor='#A0A0A0' style=' border-style: dashed; border-left : 0px dashed #A0A0A0; border-width: 1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' ><input type='text' style=' background-color:#A0A0A0; border-style:hidden; width:3px;' readonly='readonly' ></td>";	
					}

						
				}
			
			
			$unidad.="</tr><tr>";
		
			///////-----------------------------------------------------------------------------------------------tercera linea
			
			 $unidad.= " ";
			$conta=0;
			$limit1=0;
			$marc=0;
			$marc1=0;
			$cantidad=0;
			$sombra=0; $rest1=0;
			$band1=0;
			$band2=0;
			$datalert=array();
			$po=0;
			$flagss=0;
			$numer=1;
			$iconof=array();

	///////-----------------------------------------------------------------------------------------------tercera linea

		$upos = $Positions->obtener_ureporte_222($segmento[$i][2],$dayhr,$idc);
		//echo $upos;
	
	if($upos != 0){
		
				for($q=0;$q<count($upos);$q++){
					
				$cantidad=$cantidad+1;
				
				for($k=$limit1;$k<$lim;$k++){
					 $rest=$upos[$q][8]-$frac[$k];
						
					if(($upos[$q][8]<$frac[$k]) || ($upos[$q][8]==$frac[$k])||$rest<1800){
				
					if($rest<1800 && $k!=0 && $upos[$q][10]!=24){
	
								$direccion  = $Positions->direccion_s1($upos[$q][5],$upos[$q][6]);
									if($Functions->codif($direccion)==''){
												$new_dir='Sin direccion';
										}else{
												$new_dir=$Functions->codif($direccion);
											} 
					echo $upos[$q][5].','.$upos[$q][6];
						/*if($upos[$q][10]!=''){
						$pdi=$upos[$q][10];
							}else{
						$pdi="Sin PDI cercano";
							}*/
						
							//echo $Functions->codif($upos[$q][3]);
								$message= "<tr><td><img src='".$upos[$q][9]."' width='20px' heigth='20px'> </td>".
								      "<td>" .$segmento[$i][1]."</td>".
									  "<td>".$Functions->codif($upos[$q][3])."</td>".
									  "<td>".$upos[$q][2]."</td>".
									  "<td>".$Functions->codif($new_dir)."</td>".
									  "<td>".$pdi."</td></tr>";
									 
									 if($po==$k){
									  $datalert[$k].=$message;
									
									 }else{
									 $datalert[$k]=$message;
									
									 }
									 
									
								    $po=$k;
									 
									   
								
							//echo '!!'.$k.'!';
					
								
								//if($marc==0){
								$limit1=$k;
								$marc=1;
								break;
								break;
								//}
					}
						
						}else{
					
					if($datalert[$k]!=0){
					
					}else{
					if($k<$lim-1){
					$datalert[$k+1]=0;
					}
						}
							//$nup=$limit-$da;
							//echo $da.'s'.$conta.'!|';
						if($conta>=$lim){
							//	break;
								$conta=0;
								}
							
							
							}
					
						
					}
					
				$marc1=0;
			
				$band1=0;
			$band2=0;
			
			
				
				
				}
				
				}else{
		
		
			for($l=0;$l<$lim;$l++){
							
				if($l<$lim-2){
					$unidad.="<td align='center' bgcolor='#FFFFFF' style=' border-style: dashed; border-left : 0px dashed #FFFFFF; border-width: 1px; border-top : 0px dashed white;  border-bottom : 1px dashed black;' ><input type='text' style=' background-color:#FFFFFF; border-style:hidden; width:3px;' readonly='readonly' ></td>";
					}else{
						$unidad.="<td align='center' bgcolor='#FFFFFF' style='border-color:#FF0000; border-style: solid; border-left : 0px dashed #FFFFFF; border-width: 2px; border-top : 0px dashed white;  border-bottom : 1px dashed black;' ><input type='text' style=' background-color:#FFFFFF; border-style:hidden; width:3px;' readonly='readonly' ></td>";
						}
				}
	$unidad.="</tr>";
			}	
		
///////////////////////////////////////////////////7777777777		-----------------------------------------------------------------------
 $conta_alert=count($datalert); 
		if($conta_alert!=0){
			for($u=0;$u<$conta_alert+1;$u++){
				$datalert[0]='0';
				if($datalert[$u]=='0'){
				 $unidad.="<td align='center'  style='border-style: dashed; border-left : 0px dashed white; border-width: 1px; border-top : 0px dashed white;  border-bottom : 1px dashed black;' ><input type='text' style=' background-color:#FFFFFF; border-style:hidden; width:3px;' readonly='readonly' ></td>";
				 	}else{ //if($datalert[$u]!=0){
						
					$val=explode("'",$datalert[$u]);	
				 $unidad.="<td align='center'  style='border-style: dashed; border-left : 0px dashed white; border-width: 1px; border-top : 0px dashed white;  border-bottom : 1px dashed black;' ><a href='#' class='tooltip' > <img src='".$val[1]."' width='20px' heigth='20px' ><span  class='ui-corner-all' style='left:650px; top:340px; height:inherit; width:500px; z-index:999; position:absolute;'><table boder='0'  ><tr><th>Icono</th><th width='100px' >Unidad</th><th>Evento</th><th>Fecha/Hora</th><th>Direcccion</th><th>PDI</th></tr>".$datalert[$u]."</table></span></a></td>";
					
					}//}else{
				// 
				// }
				 
				}
			
					
					
				
				if($conta_alert<$lim){
					$restar=$lim-$conta_alert;
					//echo $restar.'s'.$limit.'!|'.$conta.'*'. $sombra.'*';
				for($com=0;$com<$restar-1;$com++){
								
					if($com==$restar-2){
						$unidad.="<td align='center' bgcolor='#FFFFFF' style='border-color:#FF0000; border-style: solid; border-left : 0px dashed #FFFFFF; border-width: 2px; border-top : 0px dashed white;  border-bottom : 1px dashed black;' ><input type='text' style=' background-color:#FFFFFF; border-style:hidden; width:3px;' readonly='readonly' ></td>";

						}else{
								$unidad.="<td align='center'  style='border-style: dashed; border-left : 0px dashed white; border-width: 1px; border-top : 0px dashed white;  border-bottom : 1px dashed black;' ><input type='text' style=' background-color:#FFFFFF; border-style:hidden; width:3px;' readonly='readonly' ></td>";}

							}
				}
				
				if($lim<$limit){
					$restar=$limit-$lim;
					//echo $restar.'s'.$limit.'!|'.$conta.'*'. $sombra.'*';
				for($com=0;$com<$restar;$com++){
					
					$unidad.="<td align='center'  style='border-style: dashed; border-left : 0px dashed white; border-width: 1px; border-top : 0px dashed white;  border-bottom : 1px dashed black;' ><input type='text' style=' background-color:#FFFFFF; border-style:hidden; width:3px;' readonly='readonly' ></td>";}

						
				}
				
				
				
					$unidad.="</tr>";
				}
	
			////--------------------------------------------------------------------------------------reiniciando variables
			
		 $unidad.= " ";
			$conta=0;
			$limit1=0;
			$marc=0;
			$marc1=0;
			$cantidad=0;
			$sombra=0; $rest1=0;
			$band1=0;
			$band2=0;
			unset($datalert);
		
	}
	
			//-------------------------------------------------------------------------------------

	echo $cadentab.'?'.$cadentab2.'?'.$unidad;
	
	
					/*$tpl->assign_block_vars('datos2',array(
						'HRS'			=> $cadentab,
						'FRAC'			=> $cadentab2,
						'UNI'			=> $unidad,
						'HIST'          => $cadentab3
						
					)); 
						$tpl->pparse('mViajeConst');*/
$db->sqlClose();
?>