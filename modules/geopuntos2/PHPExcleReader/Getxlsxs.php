<?php
/** Include path **/
//set_include_path('./Classes/');

/** PHPExcel_IOFactory */
include 'Classes/PHPExcel/IOFactory.php';
$nams='PHPExcleReader';
$inputFileName = '/PT1.xlsx';  

//echo __FILE__;
eliminarDir(dirname(__FILE__).'/PT1.xlsx');



if ($_FILES['geo_file_pay']["error"] > 0){
	  echo "Error: " . $_FILES['geo_file_pay']['error'] . "<br>";
	$T=0;
  }

else {

 $T=1;
$muve=move_uploaded_file($_FILES['geo_file_pay']["tmp_name"], dirname(__FILE__).'/PT1.xlsx');



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

parent.geo_exp(na);
</script>