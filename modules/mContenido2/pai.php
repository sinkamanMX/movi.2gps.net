<?php // Ejemplo con gráfica de pastel con círculo central
 
 
 /* require_once ("jpgraph/jpgraph.php");
  require_once ("jpgraph/jpgraph_pie.php");
  */
  

						
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
								
								 $unidad.="<td  align='center' class='car2' style=' background-color:#336699; border-style: dashed; border-left-color:#336699; border-width: 1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' colspan='". $da."'>".$row1['ITEM_NUMBER_2']."<br><a href='#' class='tooltip' > <input type='text' style=' background-color:#336699; border-style:hidden; width:".$da ."0px;' readonly='readonly' ><span  class='ui-corner-all' style='left:250px; font-size:10px; top:340px; height:inherit; z-index:999; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row1['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row1['FECHA_ENTREGA']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row1['FECHA_FIN']."</td></tr></table></span></a></td>";
								$limit1=$o+1;
								
							}



						if(($rest1<=1800)&& $band2==0  ){
							echo $o.'!'.$row1['MINI'].'-'.$frac[$o].'='.$rest.'|';
							$band2=1;
							$marc=1;
							 $da=$marc1;
							$sombra=$sombra+$marc1;
							
				$unidad.="<td   align='center' class='car2' style=' background-color:#336699; border-style: dashed; border-left-color:#336699; border-width: 1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' colspan='". $da."'>".$row1['ITEM_NUMBER_2']."<br><a href='#' class='tooltip' > <input type='text' style=' background-color:#336699; border-style:hidden; width:".$da ."0px;' readonly='readonly' ><span  class='ui-corner-all' style=' font-size:10px; left:250px; height:inherit; top:340px; z-index:999; position:absolute;'><table boder='0' style='z-index:99; position:relative;'><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row1['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row1['FECHA_ENTREGA']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row1['FECHA_FIN']."</td></tr></table></span></a></td>";
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
						
				$unidad.="<td  align='center' class='car2' style=' background-color:#336699; border-style: dashed; border-left-color:#336699; border-width: 1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' colspan='". $da."'>".$row1['ITEM_NUMBER_2']."<br><a href='#' class='tooltip' > <input type='text' style=' background-color:#336699; border-style:hidden; width:".$da ."0px;' readonly='readonly' ><span  class='ui-corner-all' style=' font-size:10px; left:250px; top:340px; z-index:999;  position:absolute;'><table boder='0' style='z-index:99; position:absolute;'><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row1['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row1['FECHA_ENTREGA']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row1['FECHA_FIN']."</td></tr></table></span></a></td>";
							$limit1=$o+1;
							}else{
									
								if($o==$limit-1){
									
								$marc=1;
							 $da=$marc1;
							$sombra=$sombra+$da;
						
				$unidad.="<td  align='center' class='car2' style=' background-color:#336699; border-style: dashed; border-left-color:#336699; border-width: 1px; border-top : 0px dashed white;  border-bottom : 0px dashed white;' colspan='". $da."'>".$row1['ITEM_NUMBER_2']."<br><a href='#' class='tooltip' > <input type='text' style=' background-color:#336699; border-style:hidden; width:".$da ."0px;' readonly='readonly' ><span  class='ui-corner-all' style='font-size:10px; left:250px; top:340px; z-index:999; height:inherit; position:absolute;'><table boder='0' ><tr><th>Unidad:</th><td>".$segmento[$i][1]."</td></tr><tr><th>GeoPunto:</th><td>".$userAdmin->codif($row1['DESCRIPTION'])."</td></tr><tr><th>Fecha/Hora llegada:</th><td>".$row1['FECHA_ENTREGA']."</td></tr><tr><th>Fecha/Hora salida:</th><td>".$row1['FECHA_FIN']."</td></tr></table></span></a></td>";
							$limit1=$o+1;
							
									}
									
							}
								
						
							}
							}
						
						
						
?>