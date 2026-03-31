<?php
session_cache_limiter('private');
session_start();
ini_set("display_errors", "0");
error_reporting(0);
?>
<?php
/*echo "<pre>";
print_r($_SESSION['resultadosvotaciones']['datos_pie']);
echo "</pre>";
exit();*/
include_once ("../../funciones/clases/jpgraph/src/jpgraph.php");
include_once ("../../funciones/clases/jpgraph/src/jpgraph_pie.php");
include_once ("../../funciones/clases/jpgraph/src/jpgraph_pie3d.php");

//if(is_array($_SESSION['resultadosvotaciones']['datos_pie'])){
//echo "ENTRO?";
/*echo "<pre>";
print_r($_SESSION['resultadosvotaciones']['datos_pie']);
echo "</pre>";*/
foreach($_SESSION['resultadosvotaciones']['datos_pie'] as $llave => $valor)
	$sumavalores+=$valor['valores'];

if(is_array($_SESSION['resultadosvotaciones']['datos_pie']))
	foreach ($_SESSION['resultadosvotaciones']['datos_pie'] as $llave => $valor)
	{
		$porcentaje=round(($valor['valores']/$sumavalores),2)*100;
		
		$array_label[]=substr($valor['etiquetas'],0,30)." ".$porcentaje."%%";
		$array_datos[]=$valor['valores'];
		$targ[]="pieEscrutinio.php#".$llave;
		$alts[]=$valor['etiquetas'];
		
	}
	
$totalvalores=0;	
for($i=0;$i<count($array_datos);$i++)
$totalvalores += $array_datos[$i];

if(!is_array($array_label)||($totalvalores==0)){
	unset($array_label);
	unset($array_datos);
	unset($alts);
	$array_label[0]="NO HAY RESULTADOS";
	$array_datos[0]=1;
	$alts[0]="NO HAY RESULTADOS";
}


// Some data
//$data = array(20,27,45,75,90);

$data=$array_datos;
// Create the Pie Graph.
$graph = new PieGraph(700,300,"auto");
$graph->SetShadow();

// Set A title for the plot
//$graph->title->Set("Diagrama Porcentual de Votacion \n en  ".$_SESSION['resultadosvotaciones']['nombrecarrera']);
//$graph->title->SetFont(FF_VERDANA,FS_BOLD,10); 
$graph->title-> SetFont( FF_FONT1, FS_BOLD); 
$graph->title->SetColor("darkblue");
$graph->legend->Pos(0,0);

// Create 3D pie plot
$p1 = new PiePlot3d($data);
$p1->SetTheme("sand");
$p1->SetCenter(0.3);
$p1->SetSize(150);

// Adjust projection angle
$p1->SetAngle(45);

// Adjsut angle for first slice
$p1->SetStartAngle(45);

// Display the slice values
//$p1->value->SetFont(FF_ARIAL,FS_BOLD,10);
$p1->value->SetColor("navy");

// Add colored edges to the 3D pie
// NOTE: You can't have exploded slices with edges!
$p1->SetEdge("navy");

//$p1->SetLegends(array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct"));
$p1->SetLegends($array_label);
//$graph->title-> SetFont( FF_FONT0, FS_BOLD); 
$graph ->legend->SetFont( FF_FONT1, FS_BOLD);
//$graph ->legend->Pos(0.00,0.2,"right","center");
 //$graph-> legend-> SetColumns(3);
$p1->SetCSIMTargets($targ,$alts);

$graph->Add($p1);
//$graph->Stroke();

$_SESSION['resultadosvotaciones']['imagenpieescrutinio']="imagenes/pieescrutinio".rand(1,1000).".png";
$graph-> Stroke($_SESSION['resultadosvotaciones']['imagenpieescrutinio']);
//echo "".rand(1,1000)."<br>";
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
echo "<img src='".$_SESSION['resultadosvotaciones']['imagenpieescrutinio']."' />";
//$graph->StrokeCSIM("pieEscrutinio.php");
//}
?>