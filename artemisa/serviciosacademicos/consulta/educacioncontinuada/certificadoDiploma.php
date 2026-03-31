<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));
require_once (realpath(dirname(__FILE__) . "/../../../sala/assets/plugins/fpdf182/fpdf.php"));//ultima libreria actualizada de fpdf
require_once ("control/DiplomaControl.php");
require_once ("control/EncabezadoDiplomaControl.php");
require_once ("modelo/DiplomaModelo.php");

$ctrDiploma = new DiplomaControl($_REQUEST['iddiploma']);
$data = $ctrDiploma->ctrDiploma();

$orientacion = $data["orientacionDiploma"];
$unidad      = $data["unidadDiploma"];
$formato     = $data["formatoDiploma"];

$pdf = new FPDF($orientacion, $unidad, $formato);## orientacion de diploma tamaños
setlocale(LC_CTYPE, "es_ES");
#fuente predeterminada
$fuente = 'Arial';
$estiloFuente = 'I';
$tamanioFuente = 11;
$pdf->SetFont($fuente,$estiloFuente,$tamanioFuente);
$pdf->AddPage();
#Visualizacion de fondo de diploma
$positionX   = 0; // la idea es que estos datos vengan definidos por el array de diploma
$positionY   = 0;// la idea es que estos datos vengan definidos por el array de diploma
$whit   = 279;// la idea es que estos datos vengan definidos por el array de diploma
$heigth = 217;// la idea es que estos datos vengan definidos por el array de diploma
$pdf->Image($data["fondoImagen"], $positionX, $positionY, $whit, $heigth);
#Visualizacion de fondo de diploma.
######################################COMIENZO#####################################################
#encabezado del diploma
if ($data["encabezadoDiplomado"] !="dummy") {
    $ejeXCaja = 0;// dejar este eje en 0 para no alterar estructura
    $ejeYCaja = 10;
    $textEncabezadoDiploma = $data["encabezadoDiplomado"];
    $whitBoxEncabezado   = 280;// tampaño completo del pdf estatico
    $heigthBoxEncabezado = 5;//espacion entre lineas de texto
    $borderBoxEncabezado = 0;
    $alineacionTexto = 'C';
    $fuenteEncabezado = 'Arial';
    $estiloFuenteEncabezado = 'I';
    $tamanioFuenteEncabezado = 11;
    //colores en rgb encabezado
    $r = 129;
    $g = 186;
    $b = 38;

    $pdf->SetXY($ejeXCaja,$ejeYCaja);
    $pdf->SetFont($fuenteEncabezado,$estiloFuenteEncabezado,$tamanioFuenteEncabezado);
    $pdf->SetTextColor($r,$g,$b);
    $pdf->MultiCell($whitBoxEncabezado, $heigthBoxEncabezado, $data["encabezadoDiplomado"], $borderBoxEncabezado, $alineacionTexto);
}
#text de Otorgan el presente certificado a:
//if ($data["otorgaDiploma"]!="dummy"){
//
//}
#Fin text de Otorgan el presente certificado a:


#fin encabezado diploma
$pdf->Output();

