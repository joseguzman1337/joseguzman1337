<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

ini_set('track_errors','Off');
//error_reporting(2047);

if(isset($_GET['graficar'])){
	$graficar=$_GET['graficar'];
	//session_start();
	session_cache_limiter('private');
}
else{
//	session_start();
	echo '<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">';
}
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
if(isset($_GET['graficar'])){
	include_once ("../../../funciones/clases/jpgraph/src/jpgraph.php");
	include_once ("../../../funciones/clases/jpgraph/src/jpgraph_pie.php");
	include_once ("../../../funciones/clases/jpgraph/src/jpgraph_pie3d.php");
	include_once ("../../../funciones/clases/jpgraph/src/jpgraph_bar.php");
	include ("../../../funciones/clases/jpgraph/src/jpgraph_line.php");
}
?>
<?php
$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
require_once('../matriculas/funciones/obtener_datos.php');
require_once('funciones/indicadoresMatriculas.php');
require_once("../../../funciones/clases/motorv2/motor.php");

$codigocarrera=$_GET['codigocarreraseleccion'];
$codigomodalidadacademica=$_GET['codigomodalidadacademica'];
$codigoperiodoini=$_GET['codigoperiodoini'];
$codigoperiodofin=$_GET['codigoperiodofin'];
$indicador=$_GET['indicador'];
$unidad=$_GET['unidad'];
?>
<?php
if(!empty($codigocarrera) and !empty($codigomodalidadacademica) and !empty($codigoperiodoini) and !empty($codigoperiodofin)){
	if($codigoperiodofin < $codigoperiodoini){ ?>
		<script language="javascript">alert('El periodo inicial no puede ser menor al final');history.go(-2)</script>
	<?php }

	else{
		$indicadores = new indicadoresMatriculas($codigoperiodoini,$codigoperiodofin,$codigomodalidadacademica,$codigocarrera,$indicador,&$sala);
		$arrayIndicadores=$indicadores->creaArrayInformeGlobal();
		if(!$graficar){
			$media=$indicadores->calculaMedia($arrayIndicadores);
			$desviacionEstandar=$indicadores->calculaDesviacionEstandar();
		}
	}

	if($graficar){
		$carrera=$indicadores->retornaArrayCarrera($codigocarrera);
		switch ($_GET['graficar']){
			case 'pie':
				foreach ($arrayIndicadores as $llave => $valor){

					if($codigocarrera=='todos' and $codigoperiodoini==$codigoperiodofin){
						$arrayEtiquetas[]=substr($valor['nombrecarrera'],0,11);
					}
					else{
						$arrayEtiquetas[]=$valor['codigoperiodo'];
					}

					$arrayValores[]=$valor['cantidad'];
				}
				$graph = new PieGraph(1024,768,'auto');
				$graph->SetShadow();
				if($codigoperiodoini = $codigoperiodofin){
					$graph->title->Set("Indicadores ".$indicador." periodo ".$codigoperiodoini);
				}
				else{
					$graph->title->Set("Indicadores ".$indicador." ".$carrera['nombrecarrera']);
				}

				$graph->title->SetFont(FF_FONT1,FS_BOLD);
				$p1 = new PiePlot3D(&$arrayValores);
				$p1->SetSize(0.5);
				$p1->SetLegends($arrayEtiquetas);

				if($unidad=='numero'){
					$p1->SetLabelType(1);
					$cadena="";
				}
				else{
					$p1->SetLabelType(0);
					$cadena="%%";
				}
				$p1->SetLabelPos(1);

				$p1->value->SetFormat("%d $cadena");
				$p1->SetCenter(0.45,0.5);
				$graph->Add($p1);
				$graph->StrokeCSIM('indicadoresPrincipal.php');
				break;
			case 'barras':
				foreach ($arrayIndicadores as $llave => $valor){
					if($codigocarrera=='todos' and $codigoperiodoini==$codigoperiodofin){
						$arrayEtiquetas[]=substr($valor['nombrecarrera'],0,4);
					}
					else{
						$arrayEtiquetas[]=$valor['codigoperiodo'];
					}

					$arrayValores[]=$valor['cantidad'];
				}
				// Some data

				// Create the graph and setup the basic parameters
				$graph = new Graph(1024,768,'auto');
				$graph->img->SetMargin(40,30,40,40);
				$graph->SetScale("textint");
				$graph->SetFrame(true,'blue',1);
				$graph->SetColor('lightblue');
				$graph->SetMarginColor('lightblue');

				// Add some grace to the top so that the scale doesn't
				// end exactly at the max value.
				$graph->yaxis->scale->SetGrace(20);

				// Setup X-axis labels
				//$a = $gDateLocale->GetShortMonth();
				$graph->xaxis->SetTickLabels($arrayEtiquetas);
				$graph->xaxis->SetFont(FF_FONT1);
				$graph->xaxis->SetColor('darkblue','black');

				// Stup "hidden" y-axis by given it the same color
				// as the background
				$graph->yaxis->SetColor('lightblue','darkblue');
				$graph->ygrid->SetColor('white');

				// Setup graph title ands fonts
				$graph->title->Set("Indicadores ".$indicador." ".$carrera['nombrecarrera']);
				$graph->title->SetFont(FF_FONT1,FS_BOLD);

				//$graph->subtitle->Set('(With "hidden" y-axis)');

				$graph->title->SetFont(FF_FONT2,FS_BOLD);
				if($codigocarrera=='todos' and $codigoperiodoini==$codigoperiodofin){
					$graph->xaxis->title->Set("Periodo ".$codigoperiodoini);
				}
				else{
					$graph->xaxis->title->Set("Periodo");
				}

				$graph->xaxis->title->SetFont(FF_FONT2,FS_BOLD);

				// Create a bar pot
				$bplot = new BarPlot($arrayValores);
				$bplot->SetFillColor('darkblue');
				$bplot->SetColor('darkblue');
				$bplot->SetWidth(0.5);
				$bplot->SetShadow('darkgray');

				// Setup the values that are displayed on top of each bar
				$bplot->value->Show();
				// Must use TTF fonts if we want text at an arbitrary angle
				$bplot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
				$bplot->value->SetFormat('%d');
				// Black color for positive values and darkred for negative values
				$bplot->value->SetColor("black","darkred");
				$graph->Add($bplot);

				// Finally stroke the graph
				$graph->Stroke();

				break;

			case 'lineas':
				foreach ($arrayIndicadores as $llave => $valor){

					if($codigocarrera=='todos' and $codigoperiodoini==$codigoperiodofin){
						$arrayEtiquetas[]=substr($valor['nombrecarrera'],0,15);
					}
					else{
						$arrayEtiquetas[]=$valor['codigoperiodo'];
					}

					$arrayValores[]=$valor['cantidad'];
				}


				$graph = new Graph(1024,768,"auto");
				$graph->img->SetMargin(40,40,40,40);

				$graph->img->SetAntiAliasing();
				$graph->SetScale("textlin");
				$graph->SetShadow();

				if($codigocarrera=='todos' and $codigoperiodoini==$codigoperiodofin){
					$graph->title->Set("Indicadores ".$indicador." periodo ".$codigoperiodoini);
				}
				else{
					$graph->title->Set("Indicadores ".$indicador." ".$carrera['nombrecarrera']);
				}

				$graph->title->SetFont(FF_FONT1,FS_BOLD);
				// Add 10% grace to top and bottom of plot
				if($codigocarrera=='todos' and $codigoperiodoini==$codigoperiodofin){
					$graph->yscale->SetGrace(10,15);
				}
				else {
					$graph->yscale->SetGrace(10,10);
				}

				$graph->xaxis->SetFont(FF_COURIER,FS_NORMAL,8);
				$graph->xaxis->SetTickLabels($arrayEtiquetas);
				$graph->xaxis->SetLabelAngle(45);

				$p1 = new LinePlot($arrayValores);
				$cadena="";
				$p1->value->SetFormat("%d $cadena");
				$p1->value->Show();
				$p1->mark->SetType(MARK_FILLEDCIRCLE);
				$p1->mark->SetFillColor("red");
				$p1->mark->SetWidth(4);
				$p1->SetColor("blue");
				$p1->SetCenter();
				$graph->Add($p1);

				$graph->Stroke();
				break;
		}
	}
	else{
		if(is_array($arrayIndicadores)){
			$matriz = new matriz($arrayIndicadores,"Indicadores ".$indicador,'indicadoresPrincipal.php','si','no','menu.php','',false,'si','../../');
			$matriz->jsVarios();
			$matriz->mostrarTitulo=true;
			$matriz->botonRecargar=false;
			$matriz->mostrar();
			echo "<li>Media: ".$media."<br></li>";
			echo "<li>Desviación Estándar: ".$desviacionEstandar.'</li>';
			?>
			<?php
			if($codigocarrera<>'todos' or ($codigocarrera=='todos' and $codigoperiodoini==$codigoperiodofin)){?>
			<form name="formulario" action="" method="GET">
			<table border="1">
			<tr>
				<td id="tdtitulogris">Tipo de gráfica</td>
				<td>
					<select name="graficar">
						<option value="">Seleccionar</option>
						<option value="pie">Pie</option>
						<option value="barras">Barras</option>
						<option value="lineas">Lineas</option>
					</select>
				</td>
			</tr>
			</table>
			<input name="codigomodalidadacademica" type="hidden" value="<?php echo $codigomodalidadacademica?>">
			<input name="codigocarreraseleccion" type="hidden" value="<?php echo $codigocarrera?>">
			<input name="codigoperiodoini" type="hidden" value="<?php echo $codigoperiodoini?>">
			<input name="codigoperiodofin" type="hidden" value="<?php echo $codigoperiodofin?>">
			<input name="indicador" type="hidden" value="<?php echo $indicador?>">
			<input name="unidad" type="hidden" value="numero">
			<input type="submit" value="Enviar" name="Enviar">
			</form>
			<?php }	?>
			<?php
		}
	}
}
?>