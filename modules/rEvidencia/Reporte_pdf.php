<?php
$userData = new usersAdministration();
$db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
$db ->sqlQuery("SET NAMES 'utf8'");
$usuario = '';

ini_set ('error_reporting', E_ALL);

//require('PDF/fpdf.php');

class PDF extends FPDF{

	// Cabecera de página
	function Header(){
		global $config_bd;
		
	    // Logo
	    $this->SetFillColor(188,188,188);
	    $this->SetFont('Arial','B',10);
	    $this->Cell('',5,'Detalle de Cuestionario',0,0,'C');
	    $this->Ln(12);
	}

// Pie de página
	function Footer()
	{
	    // Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Número de página
	    $this->Cell(0,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
function FancyTable($header){
    // Colores, ancho de línea y fuente en negrita
    	//global $userData,$db,$usuario,$ids_res;
    
     //$partes = explode("|",$data);
     //$usuario = $partes[0];
     $this->SetFillColor(35,19,128);
     $this->SetTextColor(255);
     $this->SetDrawColor(188,188,188);
     $this->SetLineWidth(.2);
     $this->SetFont('Helvetica','I',7); 
   
    // Cabecera
      //$w  = array(65,65, 30, 25);
      //$w  = array(60,50, 30, 15,30);
	  	$w  = array(60,50,30,30);
    
    
    for($i=0;$i<count($header);$i++)
     $this->Cell($w[$i],5,$header[$i],1,0,'C',true);
     $this->Ln();
     // Restauración de colores y fuentes
     $this->SetFillColor(247,247,247);
     $this->SetTextColor(0);
     $this->SetFont('Helvetica','I',7); 
    // Datos
    $fill = false;
  

               

			  		   
			 	         $this->Cell(60,4,utf8_decode($_GET['usr']),'LR',0,'L',$fill);
						 //$this->Cell(50,4,$row_c['DESCRIPCION'],'LR',0,'R',$fill);
						 $this->Cell(50,4,utf8_decode($_GET['qst']),'LR',0,'R',$fill);
				         //$this->Cell(30,4,$row_c['FECHA'],'LR',0,'R',$fill);
						 $this->Cell(30,4,$_GET['date'],'LR',0,'R',$fill);
				         //$this->Cell(15,4,$row_c['BATTERY'].' %','LR',0,'R',$fill);
			             //$this->Cell(30,4,$fechas,'LR',0,'R',$fill);
						 $this->Cell(30,4,date("Y-m-d H:i:s"),'LR',0,'R',$fill);
				         $this->Ln();
				         $fill = !$fill;
		            
				 
 
   //-------------------------------------  aki va la cnx a la base para obtener los datos necesarios. 
	
    
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}

//---------------------  tabla 2

function FancyTable2($header2){
    // Colores, ancho de línea y fuente en negrita
    	global $userData,$db,$usuario;
    
     $this->SetFillColor(35,19,128);
     $this->SetTextColor(255);
     $this->SetDrawColor(247,247,247);
     $this->SetLineWidth(.2);
     $this->SetFont('Helvetica','I',7); 
   
    // Cabecera
    $w2  = array(40,90,55);
    
    
    for($j=0;$j<count($header2);$j++)
     $this->Cell($w2[$j],3,$header2[$j],1,0,'C',true);
     $this->Ln();
     // Restauración de colores y fuentes
     $this->SetFillColor(247,247,247);
     $this->SetTextColor(0);
     $this->SetFont('Helvetica','I',6); 
    // Datos

   //-------------------------------------  aki va la cnx a la base para obtener los datos necesarios. 
   

    $fill2 = false;
    $y_pos = 30;
	$data = array();
	$data = data($_GET['id']);
	//$this->Cell(40,3,count($data),1,0,'C',true);
	$this->Cell($w2[0],4,utf8_decode($_GET['qst']),'LR',0,'L',$fill2);
	for($x=0; $x<count($data); $x++){
		
		if($x>0){
			$this->Cell($w2[0],4,"",'LR',0,'L',$fill2);
			}
		
		$this->Cell($w2[1],24,$data[$x][0],'LR',0,'L',$fill2);
		if($data[$x][2]==0){
		$this->Cell($w2[2],24,$data[$x][1],'LR',0,'C',false);	
			}
		if($data[$x][2]==1){
		$this->Cell($w2[2],24,$this->Image($data[$x][1],$this->GetX(),$this->GetY(),20,25,'JPG'),'LR',0,'C',false);		
			}
		
		
		$this->Ln();
		$fill2 = !$fill2;
		}
	
    
    
    // Línea de cierre
    $this->Cell(array_sum($w2),0,'','T');
}
	
//--------------------------------------------------	
	   function dame_res($res){
				global $db;
				$db ->sqlQuery("SET NAMES 'utf8'");
				$arreglo3 = array();
				$contador = -1;
				
		      $user_x ="SELECT f.ID_TIPO, f.DESCRIPCION AS PREGUNTA, e.RESPUESTA
						FROM CRM2_PREG_RES e
						INNER JOIN CRM2_PREGUNTAS f ON e.ID_PREGUNTA = f.ID_PREGUNTA
						WHERE ID_RES_CUESTIONARIO = ".$res;
              $query_user_x 	= $db->sqlQuery($user_x);	
		 
		 	while($rowx = $db->sqlFetchArray($query_user_x)){
					$contador = $contador+1;
					$arreglo3[$contador][0]=utf8_decode($rowx['PREGUNTA']);
					$arreglo3[$contador][1]=utf8_decode($rowx['RESPUESTA']);
				}
			return $arreglo3;
		 
		
		}
//----------------------------------------  funcion cortar cadena , buscar jpg

 function buscarCadena($cadena,$palabra){
        if (strstr($cadena,$palabra))
            return 1;
        else
            return 0;
    }
	
	
}

//-------------------------------------
function data($id){
	global $db;
	$db ->sqlQuery("SET NAMES 'utf8'");
	$data = array();
	$contador = 0;
	
	$sql ="SELECT P.DESCRIPCION AS PREGUNTA,
	IF(TP.MULTIMEDIA=0,PR.RESPUESTA,CONCAT('http://movi.2gps.net',PR.RESPUESTA)) AS RESPUESTA,
	TP.MULTIMEDIA
	FROM CRM2_PREGUNTAS P 
	INNER JOIN CRM2_TIPO_PREG TP ON P.ID_TIPO = TP.ID_TIPO
	INNER JOIN CRM2_PREG_RES  PR ON PR.ID_PREGUNTA=P.ID_PREGUNTA
	INNER JOIN CRM2_CUESTIONARIO_PREGUNTAS CP ON P.ID_PREGUNTA = CP.ID_PREGUNTA
	WHERE PR.ID_RES_CUESTIONARIO = ".$id."
	GROUP BY P.ID_PREGUNTA
	ORDER BY CP.ORDEN;";
						
    $qry = $db->sqlQuery($sql);	
		 
	while($row = $db->sqlFetchArray($qry)){
		$data[$contador][0]=utf8_decode($row['PREGUNTA']);
		$data[$contador][1]=utf8_decode($row['RESPUESTA']);
		$data[$contador][2]=utf8_decode($row['MULTIMEDIA']);
		$contador++;
				}
	return $data;
	}

// Creación del objeto de la clase heredada

$ids_res = array();

$header  = array('Usuario', 'Cuestionario(s)', 'Evidencia Registrada','Reporte Generado');
$header2 = array('Cuestionario','Pregunta', 'Respuesta');

$pdf = new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 24);
$pdf->FancyTable($header);
$pdf->Ln(10);
$pdf->FancyTable2($header2);

$pdf->Output('rev_'.date('Ymd_His').'.pdf','D');
?>