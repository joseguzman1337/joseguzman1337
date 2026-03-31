<?php
setlocale(LC_ALL,'es_ES');
require_once("../../../../clases/fpdf/fpdf.php");
require_once('datos_basicos_graduados.php');
require_once("imprimir_array.php");
require_once("cabecerafolio.php");
define('FPDF_FONTPATH','../../../../clases/fpdf/font/');
$fecha=$_GET['fechagrado'];
$codigocarrera=$_GET['codigocarrera'];
$folio_ini=$_GET['numerofolio'];
$estudiante_graduado=new estudiante_graduado($sala);
$row_lista_estudiantes_graduados=$estudiante_graduado->obtener_listado_estudiantes_graduados($fecha,$codigocarrera);
$row_incentivoacademicos=$estudiante_graduado->obtener_incentivos_academicos_estudiante();
$row_carreras_grados=$estudiante_graduado->obtener_datos_carreras_grados();
//listar($row_lista_estudiantes_graduados);
//listar($row_incentivoacademicos,"");
//print_r($row_carreras_grados);
?>
<?php
$pdf=new PDF('P','mm','Letter',$folio_ini); // se inicializa el contador
$pdf->SetAutoPageBreak(1,5);
$pdf->cabecera_carrera($row_carreras_grados,$fecha,$folio_ini);
$pdf->SetTopMargin(7);
$pdf->SetFont('Arial','B',8);
$pdf->AddPage();
$pdf->Cell(7);
$pdf->Cell(8,10,'REG.',1,0,'C');
$pdf->Cell(70,10,'NOMBRE DEL GRADUADO',1,0,'C');
$pdf->Cell(50,5,'DOCUMENTO DE IDENTIDAD',1,1,'C');
$pdf->Cell(85);
$pdf->Cell(15,5,'NUMERO',1,0,'C');
$pdf->Cell(35,5,'LUGAR DE EXPEDICION',1,0,'C');
$pdf->SetXY(145, 65);
$pdf->Cell(15,10,'DIPLOMA',1,0,'C');
$pdf->Cell(10,10,'ACTA',1,0,'C');
$pdf->Cell(17,10,'ACUERDO',1,0,'C');
$pdf->Cell(20,10,'PROMOCION',1,1,'C');
$pdf->Cell(7);
$pdf->SetFont('Arial','',8);
foreach ($row_lista_estudiantes_graduados as $clave => $valor)
{
	$expedicion=strtoupper($valor['expedicion']);
	$pdf->Cell(8,7,$valor['idregistrograduado'],1,0,'C');
	$pdf->Cell(70,7,$valor['nombre'],1,0,'L');
	$pdf->Cell(15,7,$valor['documento'],1,0,'C');
	$pdf->Cell(35,7,$expedicion,1,0,'C');
	$pdf->Cell(15,7,$valor['diploma'],1,0,'C');
	$pdf->Cell(10,7,$valor['acta'],1,0,'C');
	$pdf->Cell(17,7,$valor['acuerdo'],1,0,'C');
	$pdf->Cell(20,7,$valor['promocion'],1,1,'C');
	$pdf->Cell(7);
}
$pdf->Ln(12);
$pdf->Cell(7);
error_reporting(0);
foreach ($row_incentivoacademicos as $clave_incentivosacademicos => $valor_incentivosacademicos)
{
	if($valor_incentivosacademicos!="")
	{
		$incentivoacademico=strtoupper($valor_incentivosacademicos['nombreincentivoacademico']);
		$nombre=strtoupper($valor_incentivosacademicos['nombre']);
		$pdf->Cell(80,6,$incentivoacademico.":",0,0,'L');
		$pdf->Cell(80,6,$nombre,0,1,'L');
		$pdf->Cell(7);
	}

}
$pdf->Output();
?>
