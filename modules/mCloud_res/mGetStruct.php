<?php
    header('Content-Type: text/html; charset=UTF-8');
 	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	if(!$userAdmin->u_logged())
	echo '<script>window.location="index.php?m=login"</script>';
    
	 $UTF8 = "SET NAMES 'utf8'";
     $db->sqlQuery($UTF8);

 $sqlZ = "SELECT CT.ID_CATALOGO,CT.DESCRIPCION AS URL,CT.DESCRIPCION_REAL AS NREAL,CLI.NOMBRE FROM 
		CAT_CATALOGO CT INNER JOIN 
		CAT_CLIENTE_CATALOGO CCT ON CT.ID_CATALOGO = CCT.ID_CATALOGO 
		INNER JOIN ADM_CLIENTES CLI ON CCT.ID_CLIENTE = CLI.ID_CLIENTE
		WHERE CCT.ID_CLIENTE = ".$userAdmin->user_info['ID_CLIENTE']." AND CT.ID_CATALOGO =".$_GET['catalogo'];
	
	$queri = $db->sqlQuery($sqlZ);
	$rowZ  = $db->sqlFetchArray($queri);
//----------------------------------------------------------

  $sqlx = "SELECT ID_MENU,DESCRIPTION,DESCRIPTION2 FROM CAT_MENU WHERE ID_CATALOGO = ".$_GET['catalogo'];
     $q = $db->sqlQuery($sqlx);
     $count = $db->sqlEnumRows($q);
	 $dato = '';
	 $arreglo = array();
	 $contador = -1;
	
	 while($ro = $db->sqlFetchArray($q)){
		  $contador = $contador +1;
	  	  $arreglo[$contador][0]=$ro['ID_MENU'];
		  $arreglo[$contador][1]=$ro['DESCRIPTION'];
		  $arreglo[$contador][2]=$ro['DESCRIPTION2'];	
	 } 

//---------------------------------------------------------- arreglo para submenu

$sqlY = "SELECT A.ID_MENU,A.ID_SUBMENU,A.DESCRIPTION,A.DESCRIPTION2 FROM CAT_SUBMENU A
		 INNER JOIN CAT_MENU B ON B.ID_MENU = A.ID_MENU
		 INNER JOIN CAT_CLIENTE_CATALOGO C ON C.ID_CATALOGO = B.ID_CATALOGO
		 WHERE C.ID_CLIENTE = ".$userAdmin->user_info['ID_CLIENTE']." AND B.ID_CATALOGO=".$_GET['catalogo'];
$qy = $db->sqlQuery($sqlY);
$arreglo2 = array();
	$contador2 = -1;
	
	 while($ro2 = $db->sqlFetchArray($qy)){
		  $contador2 = $contador2 +1;
	  	  $arreglo2[$contador2][0]=$ro2['ID_MENU'];
		  $arreglo2[$contador2][1]=$ro2['ID_SUBMENU'];	
		  $arreglo2[$contador2][2]=$ro2['DESCRIPTION'];	
		  $arreglo2[$contador2][3]=$ro2['DESCRIPTION2'];	  
	 } 
//----------------------------------------------------------


$sqlW = "SELECT A.ID_SUBMENU,A.UBICACION_REMOTA,A.ORDEN FROM CAT_CONTENIDO A 
		 INNER JOIN CAT_SUBMENU B ON A.ID_SUBMENU = B.ID_SUBMENU
		 INNER JOIN CAT_MENU C ON B.ID_MENU =C.ID_MENU
		 INNER JOIN CAT_CLIENTE_CATALOGO D ON C.ID_CATALOGO = D.ID_CATALOGO
		 WHERE D.ID_CLIENTE = ".$userAdmin->user_info['ID_CLIENTE'];

		$qw = $db->sqlQuery($sqlW);
		$arreglo3 = array();
		$contador3 = -1;
	
	 while($ro3 = $db->sqlFetchArray($qw)){
		  $contador3 = $contador3 +1;
	  	  $arreglo3[$contador3][0]=$ro3['ID_SUBMENU'];
		  $arreglo3[$contador3][1]=$ro3['UBICACION_REMOTA'];	
		  $arreglo3[$contador3][2]=$ro3['ORDEN'];		  
	 } 
//----------------------------------------------------------

    $directorio='catalogos/'.$rowZ['NREAL'];

	$T=1;
	$ct='-';
	$cs='*';
	//$directorio=dirname(__FILE__).'/Raiz/ragde18@hotmail.es';
	//$directorio='catalogos/ragde18@hotmail.es';
	$cadena='';
	$down='/modules/mCloud/Raiz/ragde18@hotmail.es/';
	
	$formatos=array('.avi,vid', 
					'.mp4,vid', 
					'.mpeg,vid', 
					'.mpg,vid', 
					'.mov,vid',
					'.wmv,vid', 
					'.flv,vid', 
					'.3gp,vid', 
					'.mp3,aud', 
					'.wma,aud', 
					'.wav,aud',
					 '.wav,aud',
					'.wav,aud',
					'.doc,doc',
					'.docx,doc',
					'.xls,xls',
					'.xlsx,xls',
					'.ppt,ppt',
					'.pptx,ppt',
					'.potm,ppt',
					'.pdf,pdf',
					'.css,css',
					'.php,php',
					'.js,js',
					'.htm,htm',
					'.html,htm',
					'.gif,imgs',
					'.jpg,imgs',
					'.jpeg,imgs',
					'.bmp,imgs',
					'.png,imgs',
					'.apk,imgs',
					'.dwt,dwt'
						 );
	

if ($handle = opendir($directorio)) {
	
//	$cadena.='<li><span class="uses">Edgar</span><ul>';
	$cadena.='<li><span class="uses">'.$rowZ['NOMBRE'].'</span><ul>';
    while (false !== ($file = readdir($handle))) {
       // if ($file != "." && $file != "..") {
			$pos = strrpos($file, ".");
			if ($pos===false)//verificamos si es o no un directorio
    			{
					$newcar=$directorio.'/'.$file;
					$T++;
					
$cadena.='<li class="closed"><span class="folder" onmouseup="menu_links(1),deta_default_ini(),change_m(1),change_ide(\''. base64_encode($directorio.'/'.$file).'\')" >C&aacute;talogo : '.($rowZ['URL'])."</span>"; // echo $file ." cas $file\n"; //de ser un directorio lo envolvemos entre corchetes
				    $cadena.=carpt($newcar,$formatos,1,$arreglo,$arreglo2,$arreglo3);
					$cadena.='</li>';
   				 }
 			   else
   			 	{
					if($file!='.' && $file!='..' ){
						$countar=0;
						$divide2=explode('.',$file);
						for($i=0;$i<count($formatos);$i++){
							$divide=explode(',',$formatos[$i]);
							//divide1=explode('.',$divide[0]);
							
							//echo $pos1 = strrpos($file,$divide[0] );
								if ($divide[0]=='.'.$divide2[count($divide2)-1]){
$cadena.='<li><span  onmouseup="deta_default(), change_id(\''. base64_encode($directorio.'/'.$file).'\')" class="'.$divide[1].'">'.$file . "</span></li>";
										$countar=$countar+1;
									}else{
										if(count($formatos)-1==$i&&$countar==0){
$cadena.='<li><span   onmouseup="deta_default(),change_id(\''. base64_encode($directorio.'/'.$file).'\')" class="file">'.$file . "</span></li>";
											}
										}
							}
     				 //  echo $file ."$file\n";
					
					
					}
				  }
          
    }
    closedir($handle);
	
	$cadena.='</ul></li>';
	echo $cadena;
}


// *************************************************  funcion que crea carpetas internas

$incremento = 1;
$codigo = 99;


function carpt($directorio,$formatos,$x,$arreglo,$arreglo2,$arreglo3){
      global $incremento,$db;
	$cads='';
	if ($handle = opendir($directorio)) {
 	 $cads.='<ul>';
       while (false !== ($file = readdir($handle))) {
            // if ($file != "." && $file != "..") {
			$pos = strrpos($file, ".");
			if ($pos===false)//verificamos si es o no un directorio 
    			{
					$newcar=$directorio.'/'.$file;
					$T++;
					//	$incremento = $incremento+1;
						$mm = 0;
						$mn = 0;
					$cachi = explode("/",$newcar);
					if(count($cachi)===4){
					   $codigo = 1;
					   $incremento++;
					   $link_dato = 2;
		             }	else{
		             	$codigo = 99;
						$link_dato = 3;
		             		for($c2=0;$c2<count($arreglo2);$c2++){
							 if(codif($arreglo2[$c2][3])=== ($file)){
	                     	   $mm = $arreglo2[$c2][1];
							   $ETIQUETA = $arreglo2[$c2][2];	
	                     	}	
		             		
		             	}
		             }
		             
		              for($c=0;$c<count($arreglo);$c++){
	                     	//echo $arreglo[$c][1].'-'.$file;
	                     	if(codif($arreglo[$c][2])===$file){
	                     	 $mm = $arreglo[$c][0];	
	                     	 $ETIQUETA = $arreglo[$c][1];
	                     	}
	                     }
					   $cads.='<li class="closed"><span class="folder" onmouseup="menu_links('.$link_dato.'),deta_default_ini(),change_idm('.$mm.'), change_n('.$codigo.
					   '),change_ide2(\''.base64_encode($directorio.'/'.$file).'\'),change_ide(\''. 
					   base64_encode($directorio.'/'.($ETIQUETA)).'\');">'.($ETIQUETA) ."</span>";
					  
					
 // echo $file ." cas $file\n"; //de ser un directorio lo envolvemos entre corchetes
				
					$cads.=carpt($newcar,$formatos,$incremento,$arreglo,$arreglo2,$arreglo3);
					$cads.='</li>';
             }else{
					if($file!='.' && $file!='..' ){
						$countar=0;
						$mmn='';
						$caos = '';
						$divide2=explode('.',$file);
					    	for($i=0;$i<count($formatos);$i++){
									$divide=explode(',',$formatos[$i]);
							//divide1=explode('.',$divide[0]);
							
							//echo $pos1 = strrpos($file,$divide[0] );
								   if ($divide[0]=='.'.$divide2[count($divide2)-1]){
								   		
								     for($c3=0;$c3<count($arreglo3);$c3++){
								   		$caos = explode("/",$arreglo3[$c3][1]);
					             	    if(codif($caos[count($caos)-1]) === ($file)){
				                     	 $mmn = 'ID_SUBMENU='.$arreglo3[$c3][0].' AND ORDEN ='.$arreglo3[$c3][2];
										  $jk = $arreglo3[$c3][0];
				                     	}	
					             		
					             	}
								   	
								  if($mmn === ''){
								     $mmn = 'url';
								     $jk =$file ;
								   }
			$cads.='<li><span  class="'.$divide[1].'"  onmouseup="muestra_deta(event,\''.$mmn.'\','.$jk.'),change_del(\''.$mmn.'\'),change_id(\''. 
							base64_encode($directorio.'/'.$file).'\')">'.$file."</span></li>";
										$countar=$countar+1;
									}else{
										
										for($c3=0;$c3<count($arreglo3);$c3++){
									   		$caos = explode("/",$arreglo3[$c3][1]);
						             	    if(codif($caos[count($caos)-1]) === ($file)){
					                     	 $mmn = 'ID_SUBMENU='.$arreglo3[$c3][0].' AND ORDEN ='.$arreglo3[$c3][2];		
					                     	}	
					             		
					             		}
										if(count($formatos)-1==$i&&$countar==0){
							 if($mmn === ''){
								     $mmn = 'url';
								     // $jk =0 ;
								     $jk = explode("_",$file);
								   }
					//$cads.='<li><span  class="file"  onmouseup="muestra_deta(\''.$mmn.'\','.$jk.'),change_del(\''.$mmn.'\'),change_id(\''. 			   
							$cads.='<li><span  class="file"  onmouseup="muestra_deta(event,\''.$mmn.'\','.$jk[count($jk)-1].'),change_del(\''.$mmn.'\'),change_id(\''. 
							base64_encode($directorio.'/'.$file).'\')">'.$file . "</span></li>";
			  							}
			 						}
							}
     				 //  echo $file ."$file\n";
					
					
					}
			  }
          
    }
	 $cads.='</ul>';
      closedir($handle);
	  return $cads;
     }
	
	
}
//-------------------------------------------------------------
		function codif($in_str) {
		$cur_encoding = mb_detect_encoding($in_str);
		if( $cur_encoding == 'utf-8' && mb_check_encoding($in_str,'utf-8') )
			return $in_str;
		else
			return utf8_encode($in_str);
	}

?>