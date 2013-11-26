<?php
/** Include path **/
//set_include_path('./Classes/');

/** PHPExcel_IOFactory */



include 'Classes/PHPExcel/IOFactory.php';
$nams='PHPExcleReader';
$inputFileName = '/PT1.xlsx';  

 eliminarDir(dirname(__FILE__).'/PT1.xlsx');



if ($_FILES['excel']["error"] > 0)

  {
	  echo "Error: " . $_FILES['excel']['error'] . "<br>";
	$T=0;
  }

else

  {

 $T=1;
$muve=move_uploaded_file($_FILES['excel']["tmp_name"], dirname(__FILE__).'/PT1.xlsx');



 }




	//echo 'subio';
// File to read


//echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';

/* foreach($sheetData as $rec)
{
	print_r($rec);
}
 */
function eliminarDir($carpeta){
			
			 foreach(glob($carpeta."/*") as $archivos_carpeta) {
			 echo $archivos_carpeta; 
			 if(is_dir($archivos_carpeta)) eliminarDir($archivos_carpeta); 
			 else unlink($archivos_carpeta); 
			 }
			  $do = rmdir($carpeta); 
			  if($do == true){
					return 2;
				}
		  }
?>
<script type="text/javascript">
var na= '<?php echo $T; ?>';
parent.php_exvc(na);
</script>