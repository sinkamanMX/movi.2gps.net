<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
 	$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);

	if(!$userAdmin->u_logged())
	echo '<script>window.location="index.php?m=login"</script>';

	$T=1;
	$ct='-';
	$cs='*';
	$directorio=dirname(__FILE__).'/Raiz/ragde18@hotmail.es';
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
					'.dwt,dwt'
						 );
	

if ($handle = opendir($directorio)) {
	
	$cadena.='<li><span class="uses">Edgar</span><ul>';
    while (false !== ($file = readdir($handle))) {
       // if ($file != "." && $file != "..") {
			$pos = strrpos($file, ".");
			if ($pos===false)//verificamos si es o no un directorio
    			{
					$newcar=$directorio.'/'.$file;
					$T++;
					
      				$cadena.='<li class="closed"><span class="folder" onmouseup="change_ide(\''. base64_encode($directorio.'/'.$file).'\')" >'.$file ."</span>"; // echo $file ." cas $file\n"; //de ser un directorio lo envolvemos entre corchetes
					$cadena.=carpt($newcar,$formatos);
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
										$cadena.='<li><span  onmouseup="change_id(\''. base64_encode($directorio.'/'.$file).'\')" class="'.$divide[1].'">'.$file . "</span></li>";
										$countar=$countar+1;
									}else{
										if(count($formatos)-1==$i&&$countar==0){
											$cadena.='<li><span   onmouseup="change_id(\''. base64_encode($directorio.'/'.$file).'\')" class="file">'.$file . "</span></li>";
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


function carpt($directorio,$formatos){
	
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
					
      				$cads.='<li class="closed"><span class="folder" onmouseup="change_ide(\''. base64_encode($directorio.'/'.$file).'\')">'.$file ."</span>"; // echo $file ." cas $file\n"; //de ser un directorio lo envolvemos entre corchetes
					$cads.=carpt($newcar,$formatos);
					$cads.='</li>';
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
										$cads.='<li><span  class="'.$divide[1].'"  onmouseup="change_id(\''. base64_encode($directorio.'/'.$file).'\')">'.$file . "</span></li>";
										$countar=$countar+1;
									}else{
										if(count($formatos)-1==$i&&$countar==0){
											$cads.='<li><span  class="file"  onmouseup="change_id(\''. base64_encode($directorio.'/'.$file).'\')">'.$file . "</span></li>";
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

	

?>