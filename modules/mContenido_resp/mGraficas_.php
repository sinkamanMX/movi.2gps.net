<?php // Ejemplo con gráfica de pastel con círculo central
 
 
 /* require_once ("jpgraph/jpgraph.php");
  require_once ("jpgraph/jpgraph_pie.php");
  */
  
ini_set("memory_limit", "120M");
require_once('public/jpgraph/src/jpgraph.php');
require_once('public/jpgraph/src/jpgraph_pie.php');
require_once ("public/jpgraph/src/jpgraph_pie3d.php");
 
 
  $datos = array(16, 30); // Datos
  
  $grafica = new PieGraph(600,400,'auto'); // Crear Gráfico
  $grafica->SetFrame(true); // Despliega el borde
  $grafica->SetShadow();
  $grafica->title->Set("DETALLE DE ENTREGAS POR RUTA");
  $grafica->title->SetMargin(8); // Add a little bit more margin from the top
 
  // Crea la gráfica
  $genero = new PiePlotC($datos);
  $genero->SetSize(0.35);
  $genero->value->SetColor('white');
  $genero->value->Show();
  $genero->midtitle->Set("Ruta 1 - Eco 2");
  $genero->SetMidColor('yellow');
  $genero->SetLabelType(PIE_VALUE_PER);
 
   $lbl = array("Cumplidas \n%.1f%%","No cumplidas\n%.1f%%");
   $genero->SetLabels($lbl);
   $genero->SetShadow();
   
   $genero->ExplodeAll(15); // Explode all slices 15 pixels
   $grafica->Add($genero);  // Add plot to pie graph
   $grafica->Stroke(); //Despliega la gráfica
?>