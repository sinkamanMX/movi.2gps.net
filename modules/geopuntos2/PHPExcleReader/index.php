<?php


/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
$cadena="";
/** PHPExcel_IOFactory */
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
//echo count($sheetData);
//echo "\n";

for($i=0;$i<=count($sheetData);$i++){
	$cadena .= ($cadena=="")?implode(",", $sheetData[$i]):'|'.implode(",",$sheetData[$i]);
	}
	
	


					


echo $cadena;

?>
