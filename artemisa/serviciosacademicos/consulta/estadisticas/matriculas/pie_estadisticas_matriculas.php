<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);


session_cache_limiter('private');
//session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php');
include_once ("../../../funciones/clases/jpgraph/src/jpgraph.php");
include_once ("../../../funciones/clases/jpgraph/src/jpgraph_pie.php");
include_once ("../../../funciones/clases/jpgraph/src/jpgraph_pie3d.php");

//$gJpgBrandTiming=true;

// Some data
foreach ($_SESSION['datos_pie'] as $llave => $valor)
{
	$array_label[]=substr($valor['etiquetas'],0,30)."(%d%%)";
	$array_datos[]=$valor['valores'];
}
$data=$array_datos;
//print_r($array_etiquetas)
//$data = array(40,21,17,27,23);

// Create the Pie Graph.
$graph = new PieGraph(1024,768,'auto');
$graph->SetShadow();

// Set A title for the plot
$graph->title->Set("Estadísticas x Programa: Columna ".$_GET['columna']." Periodo ".$_SESSION['codigoperiodo_reporte']."");
$graph->title->SetFont(FF_FONT1,FS_BOLD);

// Create
$p1 = new PiePlot3D($data);
$p1->SetSize(0.5);
//$p1->SetLegends(array("Jan (%d)","Feb","Mar","Apr","May","Jun","Jul"));
$p1->SetLegends($array_label);

//$targ=array("pie_estadisticas_matriculas.php?v=1","pie_estadisticas_matriculas.php?v=2","pie_estadisticas_matriculas.php?v=3","pie_estadisticas_matriculas.php?v=4","pie_estadisticas_matriculas.php?v=5","pie_estadisticas_matriculas.php?v=6");
//$alts=array("val=%d","val=%d","val=%d","val=%d","val=%d","val=%d");
//$p1->SetCSIMTargets($targ,$alts);

// Use absolute labels
$p1->SetLabelType(0);
$p1->SetLabelPos(1);
$cadena="%%";
$p1->value->SetFormat("%d $cadena");

// Move the pie slightly to the left
$p1->SetCenter(0.35,0.5);

$graph->Add($p1);


// Send back the HTML page which will call this script again
// to retrieve the image.
$graph->StrokeCSIM('pie_estadisticas_matriculas.php');

/**
$p1 = new PiePlot3D($data); 
$p1->SetSize(0.35); 
$p1->SetCenter(0.5); 

// Setup slice labels and move them into the plot 
$p1->value->SetFont(FF_FONT1,FS_BOLD); 
$p1->value->SetColor("black"); 
$p1->SetLabelPos(0.2); 

$nombres=array("pepe","luis","miguel","alberto"); 
$p1->SetLegends($nombres); 

// Explode all slices 
$p1->ExplodeAll(); 

$graph->Add($p1); 
$graph->Stroke();
*/
?>


