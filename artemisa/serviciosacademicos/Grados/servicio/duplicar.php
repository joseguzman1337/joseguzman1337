<?php

/**
 * @author Carlos Alberto Suarez Garrido <c.csuarez@sic.gov.co>
 * @copyright Subdireccion de Innovacion y Desarrollo Tecnologico
 * @package servicio
 */
header('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

ini_set('display_errors', 'On');
set_time_limit(0);

session_start();

require_once("../../funciones/clases/fpdf/fpdf.php");
require_once("../../funciones/clases/fpdf/cellfit.php");

require_once '../lib/pdf/dompdf/dompdf_config.inc.php';

include '../lib/phpMail/class.phpmailer.php';
include '../lib/phpMail/class.smtp.php';

include '../lib/radicacion/numtoletras.php';

include '../tools/includes.php';

include '../control/ControlCarrera.php';
include '../control/ControlItem.php';
include '../control/ControlPeriodo.php';
include '../control/ControlFacultad.php';
include '../control/ControlTipoDocumento.php';
include '../control/ControlContacto.php';
include '../control/ControlEstudiante.php';
include '../control/ControlTrabajoGrado.php';
include '../control/ControlConcepto.php';
include '../control/ControlDocumentacion.php';
include '../control/ControlFechaGrado.php';
include '../control/ControlPazySalvoEstudiante.php';
include '../control/ControlPreMatricula.php';
include '../control/ControlClienteWebService.php';
include '../control/ControlCarreraPeople.php';
include '../control/ControlActaAcuerdo.php';
include '../control/ControlIncentivoAcademico.php';
include '../control/ControlClienteCorreo.php';
include '../control/ControlRegistroGrado.php';
include '../control/ControlLocalidad.php';
include '../control/ControlFolioTemporal.php';
include '../control/ControlDocumentoDuplicado.php';
include '../control/ControlDirectivo.php';

function unserializeForm($str) {
    $strArray = explode("&", $str);
    foreach ($strArray as $item) {
        $array = explode("=", $item);
        $returndata[] = $array[1];
    }
    return $returndata;
}

function mes($fecha) {
    $fecha = strtotime($fecha);
    $mes = date("F", ($fecha));
    if ($mes == "January") {
        $mes = "Enero";
    }
    if ($mes == "February") {
        $mes = "Febrero";
    }
    if ($mes == "March") {
        $mes = "Marzo";
    }
    if ($mes == "April") {
        $mes = "Abril";
    }
    if ($mes == "May") {
        $mes = "Mayo";
    }
    if ($mes == "June") {
        $mes = "junio";
    }
    if ($mes == "July") {
        $mes = "Julio";
    }
    if ($mes == "August") {
        $mes = "Agosto";
    }
    if ($mes == "September") {
        $mes = "Septiembre";
    }
    if ($mes == "October") {
        $mes = "Octubre";
    }
    if ($mes == "November") {
        $mes = "Noviembre";
    }
    if ($mes == "December") {
        $mes = "Diciembre";
    }

    return $mes;
}

if ($_POST) {
    $keys_post = array_keys($_POST);
    foreach ($keys_post as $key_post) {
        $$key_post = $_POST[$key_post];
    }
}

if ($_GET) {
    $keys_get = array_keys($_GET);
    foreach ($keys_get as $key_get) {
        $$key_get = $_GET[$key_get];
    }
}

if (isset($_SESSION["datoSesion"])) {
    $user = $_SESSION["datoSesion"];
    $idPersona = $user[0];
    $luser = $user[1];
    $lrol = $user[3];
    $persistencia = new Singleton( );
    $persistencia = $persistencia->unserializar($user[4]);
    $persistencia->conectar();
} else {
    header("Location:error.php");
}


$controlCarrera = new ControlCarrera($persistencia);
$controlEstudiante = new ControlEstudiante($persistencia);
$controlRegistroGrado = new ControlRegistroGrado($persistencia);
$controlFolioTemporal = new ControlFolioTemporal($persistencia);

$duplicados = $_POST["ckDuplicado"];
$txtCodigoCarrera = $_POST["cmbCarreraDuplicar"];
$txtCodigoEstudiante = $_POST["txtIdEstudiante"];



$carrera = $controlCarrera->buscarCarrera($txtCodigoCarrera);
$nombreCarrera = $carrera->getNombreCarrera();
$estudiante = $controlEstudiante->buscarEstudiante($txtCodigoEstudiante);

$tituloProfesion = $controlCarrera->buscarTituloProfesion($txtCodigoCarrera);

$registroGrado = $controlRegistroGrado->buscarRegistroGradoCarreraEstudiante($txtCodigoCarrera, $txtCodigoEstudiante);


foreach ($duplicados as $duplicado) {

    switch ($duplicado) {

        case "5":
            $documentoDuplicado = new ControlDocumentoDuplicado($persistencia);
            $controlDirectivo = new ControlDirectivo($persistencia);
            $txtIdReferenciaGrado = $duplicado;
            $txtIdRegistroGrado = $registroGrado->getIdRegistroGrado();
            $txtIdUsuario = $idPersona;
            $directivo = $controlDirectivo->buscarSecretarioGeneralId();
            $idDirectivo= $directivo->getIdDirectivo();
            $documentoDuplicado->crearDocumentoDigital($txtIdReferenciaGrado, $txtCodigoEstudiante, $txtIdRegistroGrado, $txtNumeroDiplomaDuplicado, $idDirectivo, $txtIdUsuario);
            
            if ($txtCodigoCarrera == 10) {



                $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Documento sin título</title>
						<style type="text/css">
							body {
								font-family: univernb, DejaVu Sans, sans-serif;
								margin-top: 8.4cm;
								margin-bottom: 1.4cm;
								background: url("../css/images/duplicar.png") no-repeat;
							}
						</style>
						</head>
						<body>
						<div>
							<div align="center">
						    <table width="100%" border="0" cellspacing=0 cellpadding=0 style="border-collapse:collapse; padding:0cm 5.4pt 0cm 5.4pt;">
                            	<tr style="height:3.51cm">
                                	<td valign="bottom" width="34.94cm" style="max-width: 34.94cm; padding:0cm 5.4pt 0cm 5.4pt; height:3.51cm;"><div align="center"><p style="text-align:center; font-weight: normal; font-size: 50pt;"><b>' . pasarMayusculas($estudiante->getNombreEstudiante() . " " . $estudiante->getApellidoEstudiante()) . '</b></p>
                                	</div></td>

                                </tr>
                              <tr style="height:1.77cm">
                                	<td width="34.94cm" style="width:auto; padding:0cm 5.4pt 0cm 5.4pt; height:1.77cm;" ><div align="center">
                                	  <p style="margin-bottom:24pt; text-align:center; font-weight: normal; font-size: 14pt; text-indent: 326.05cm 15.0cm;"><b>' . $estudiante->getTipoDocumento()->getDescripcion() . ' No. ' . $estudiante->getNumeroDocumento() . ' Expedida en ' . $estudiante->getExpedicion() . '</b></p></div></td>
                                </tr>
                                <tr style="height:4.48cm;">
                                	<td width="34.94cm" valign="bottom" style="padding:0cm 5.4pt 0cm 5.4pt; height:4.48cm;"><div align="center"><p style="text-align:center; font-weight: normal; font-size: 48pt;"><b>&nbsp;</b></p></div></td>
                                </tr>
                                <tr style="height:2.76cm;">
                                	<td width="34.94cm" valign="bottom" style="padding:0cm 5.4pt 0cm 5.4pt; height: 2.76cm;"><h2 style="margin-top:0cm;margin-right:3cm;margin-bottom:23.0pt;margin-left: 531.55pt; text-align:right; text-indent: 531.6cm 666.25cm;"><span style="font-weight: normal; font-size: 20pt;"><b>26&nbsp;&nbsp;&nbsp;&nbsp;ENERO&nbsp;&nbsp;&nbsp;&nbsp;2016</b></span></h2></td>
                                </tr>
                                <tr style="height: 0.98cm;">
                                	<td width="34.94cm" valign="bottom" style="padding:0cm 5.4pt 0cm 5.4pt; height: 0.98cm;"><p align="center" style="text-align:center; font-size: 16pt;"><b>&nbsp;</b></p></td>
                                </tr>
                                <tr style="height: 3.53m;">
                                	<td width="34.94cm" valign="bottom" style="height: 3.53cm;"><p style="font-weight: normal; font-size: 16pt; text-indent: 21cm;"><b>13960&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FOLIO: 626</b></p></td>
                                </tr>
                            </table>
                            <p></p>
                            </div>
					</div>
				<div style="page-break-before: always;"></div>
				</body>
				</html>';



                $nombreArchivo = "duplicado" . $nombreCarrera . ".pdf";

                //$txtFechaGrado = "55";

                $dompdf = new DOMPDF();
                $paper = array(0, 0, 893.05, 1162);
                $dompdf->set_paper($paper, "landscape");
                $dompdf->load_html($html); //cargamos el html
                $dompdf->render(); //renderizamos
                $dompdf->stream($nombreArchivo);
            } elseif ($txtCodigoCarrera == 90 || $txtCodigoCarrera == 93) {



                $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Documento sin título</title>
						<style type="text/css">
							body {
								font-family: univernb, DejaVu Sans, sans-serif;
								margin-top: 10.4cm;
								margin-bottom: 0.5cm;
								background: url("../css/images/duplicar.png") no-repeat;
							}
						</style>
						</head>
						<body>
						<div >
						    <table width="100%" border="0" cellspacing=0 cellpadding=0 style="border-collapse:collapse; padding:0cm 0.1905cm 0cm 0.1905cm">
							 <tr style="height:3cm">
							  <td width="30.44cm" valign="bottom" style="max-width:30.44cm; height:3cm">
							  <p align=center style="text-align:center;"><b style="font-weight:bold; font-size:50.0pt;">' . pasarMayusculas($estudiante->getNombreEstudiante() . " " . $estudiante->getApellidoEstudiante()) . '</b></p>
							  </td>
							 </tr>
							 <tr style="height:1.52cm">
							  <td width="30.44cm" style="width:30.44cm; height:1.52cm">
							  <p style="margin-bottom:4.0pt; text-indent:11.50cm"><b style="font-weight:bold; font-size:16.0pt;">1.076.656.465                                      Ubaté</b></p>
							  </td>
							 </tr>
							 <tr style="height:2.74cm">
							  <td width="30.44cm" valign="bottom" style="width:30.44cm; height:2.74cm">
							  <p align=center style="text-align:center"><b style="font-weight:bold; font-size:48.0pt;">Facultad de Educación</b></p>
							  </td>
							 </tr>
							 <tr style="height:3.53cm">
							  <td width="30.44cm" valign="bottom" style="width:30.44cm; height:3.53cm">
							  <h2 align=center style="margin-bottom:2.0pt;text-align:center; font-size:36.0pt;">' . $tituloProfesion->getTituloProfesion()->getNombreTitulo() . '</h2>
							  </td>
							 </tr>
							 <tr style="height:2.75cm">
							  <td width="30.44cm" valign="bottom" style="width:30.44cm; height:2.75cm">
							  <p align=center style="text-align:center"><b style="font-weight:bold; font-size:16.0pt;">a los dieciocho (18) días del mes de febrero del año dos mil
							  dieciséis (2016)</b></p>
							  </td>
							 </tr>
							 <tr style="height:2.25cm">
							  <td width="30.44cm" style="width:30.44cm; height:2.25cm">
							  <p style="text-align:center; margin-bottom: -30pt; text-indent:19.50cm"><b style="font-weight:bold; font-size:11.0pt;">14045809&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;787</b></p>
							  </td>
							 </tr>
							</table>
					</div>
					<div style="page-break-before: always;"></div>
				</body>
				</html>';

                $nombreArchivo = "duplicado" . $nombreCarrera . ".pdf";

                //$txtFechaGrado = "55";


                $dompdf = new DOMPDF();
                $paper = array(0, 0, 1165, 895.74);
                $dompdf->set_paper($paper, "portrait");
                $dompdf->load_html($html); //cargamos el html
                $dompdf->render(); //renderizamos
                $dompdf->stream($nombreArchivo);
            } else {
                $orientacion = "L";
                $unidad = "mm";
                $formato = "Pregrado";

                $pdf = new FPDF_CellFit($orientacion, $unidad, $formato);
                $pdf->SetMargins(0, 0, 0);
                $pdf->SetAutoPageBreak(true, 9);

                $pdf->AddFont('TrajanPro', '', 'TrajanPro.php');
                $pdf->AddFont('Humanst521BTRoman', '', 'Humanst521BTRoman.php');
                $pdf->AddFont('UniversityRomanBoldBT', '', 'UniversityRomanBoldBT.php');
                $pdf->AddFont('Dauphin', '', 'Dauphin.php');



                $estudiante = $controlEstudiante->buscarEstudiante($txtCodigoEstudiante);
                $folioTemporal = $controlFolioTemporal->buscarFolioTemporal($registroGrado->getIdRegistroGrado());
                $contarRegistroGrado = $controlRegistroGrado->contarRegistroGradoCarreraEstudiante($txtCodigoCarrera, $txtCodigoEstudiante);

                if ($contarRegistroGrado != 0) {

                    $registroGrado = $controlRegistroGrado->buscarRegistroGradoCarreraEstudiante($txtCodigoCarrera, $txtCodigoEstudiante);
                    $anioGrado = date("Y", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo()));
                    $diaGrado = date("d", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo()));


                    $mesGrado = mes(date("Y-m-d", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo())));

                    $pdf->AddPage();

                    $pdf->SetFont('Dauphin', '', 25);
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->Rotate(40, 35, 60);
                    $pdf->Text(35, 60, "DUPLICADO");
                    $pdf->Rotate(0);


                    $pdf->SetFont('TrajanPro', '', 50);
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetY(115);
                    $pdf->SetX(45);
                    $pdf->CellFit(330, 0, utf8_decode($estudiante->getNombreEstudiante() . " " . $estudiante->getApellidoEstudiante()), 0, 0, 'C', '', '', true, false);

                    $pdf->SetFont('Humanst521BTRoman', '', 12);
                    $pdf->SetY(127);
                    $search = array('á', 'é', 'í', 'ó', 'ú');
                    $replace = array('Á', 'É', 'Í', 'Ó', 'Ú');


                    $nombreDocumento = pasarMayusculas($estudiante->getTipoDocumento()->getNombreDocumento());

                    $expedidoDocumento = pasarMayusculas($estudiante->getExpedicion());


                    if ($estudiante->getTipoDocumento()->getIniciales() == "05") {
                        $pdf->Cell(0, 0, utf8_decode($nombreDocumento) . ' No. ' . number_format($estudiante->getNumeroDocumento(), 0, '', '.') . ' EXPEDIDO EN ' . utf8_decode($expedidoDocumento), 0, 2, 'C');
                    } else {
                        $pdf->Cell(0, 0, utf8_decode($nombreDocumento) . ' No. ' . number_format($estudiante->getNumeroDocumento(), 0, '', '.') . ' EXPEDIDA EN ' . utf8_decode($expedidoDocumento), 0, 2, 'C');
                    }

                    $pdf->SetFont('TrajanPro', '', 50);
                    $pdf->SetY(177);
                    $pdf->SetX(30);

                    if ($txtCodigoCarrera == 8 && $estudiante->getGenero()->getCodigo() == 200) {
                        $pdf->CellFit(360, 0, 'ENFERMERO', 0, 0, 'C', '', '', true, false);
                    } else if ($txtCodigoCarrera == 8 && $estudiante->getGenero()->getCodigo() == 100) {
                        $pdf->CellFit(360, 0, 'ENFERMERA', 0, 0, 'C', '', '', true, false);
                    } else if ($txtCodigoCarrera == 125 && $estudiante->getGenero()->getCodigo() == 200) {
                        $pdf->CellFit(360, 0, 'INGENIERO AMBIENTAL', 0, 0, 'C', '', '', true, false);
                    } else if ($txtCodigoCarrera == 125 && $estudiante->getGenero()->getCodigo() == 100) {
                        $pdf->CellFit(360, 0, 'INGENIERA AMBIENTAL', 0, 0, 'C', '', '', true, false);
                    } else if ($txtCodigoCarrera == 133 && $estudiante->getGenero()->getCodigo() == 200) {
                        $pdf->CellFit(360, 0, strtoupper(utf8_decode('PSICÓLOGO')), 0, 0, 'C', '', '', true, false);
                    } else if ($txtCodigoCarrera == 133 && $estudiante->getGenero()->getCodigo() == 100) {
                        $pdf->CellFit(360, 0, strtoupper(utf8_decode('PSICÓLOGA')), 0, 0, 'C', '', '', true, false);
                    } else if ($txtCodigoCarrera == 134 && $estudiante->getGenero()->getCodigo() == 200) {
                        $pdf->CellFit(360, 0, strtoupper(utf8_decode('PSICÓLOGO')), 0, 0, 'C', '', '', true, false);
                    } else if ($txtCodigoCarrera == 134 && $estudiante->getGenero()->getCodigo() == 100) {
                        $pdf->CellFit(360, 0, strtoupper(utf8_decode('PSICÓLOGA')), 0, 0, 'C', '', '', true, false);
                    } else {
                        $pdf->CellFit(360, 0, utf8_decode($tituloProfesion->getTituloProfesion()->getNombreTitulo()), 0, 0, 'C', '', '', true, false);
                    }

                    $pdf->SetFont('Humanst521BTRoman', '', 12);
                    $pdf->SetY(197);
                    $mesesanio = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    /**
                     * @modified Andres Ariza <arizaandres@unbosque.edu.co>
                     * DADO EN BOGOTÁ D.C., REPÚBLICA DE COLOMBIA, EL DÍA 17 DE AGOSTO DE 2016.  ELABORACIÓN DUPLICADO: NOVIEMBRE 03 DE 2016.
                     * Se agrego el ":" despues de Elaboración Duplicado
                     * @since  November 3, 2016
                     */
                    $pdf->Cell(0, 0, str_replace($search, $replace, strtoupper(utf8_decode('DADO EN BOGOTÁ D.C., REPÚBLICA DE COLOMBIA, EL DÍA '))) . $diaGrado . ' DE ' . strtoupper($mesGrado) . ' DE ' . $anioGrado . '. ' . utf8_decode('ELABORACIÓN') . ' DUPLICADO: ' . strtoupper($mesesanio[date('n') - 1]) . ' ' . date('d') . ' DE ' . date('Y') . '.', 0, 2, 'C');
                    //$pdf->Cell(0,0, str_replace($search, $replace, strtoupper(utf8_decode('DADO EN BOGOTÁ D.C., REPÚBLICA DE COLOMBIA, EL DÍA'))).' '.$diaGrado.' DE '.strtoupper($mesGrado).' DE '.$anioGrado.' ',0,2,'C');



                    $pdf->SetFont('TrajanPro', '', 12);
                    $pdf->SetY(227);
                    $pdf->SetX(45);
                    $pdf->Cell(0, 0, 'RECTORA', 0, 0, 'L');

                    $pdf->SetFont('TrajanPro', '', 12);
                    $pdf->SetY(227);
                    $pdf->SetX(157);
                    if ($carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 200) {
                        $pdf->Cell(0, 0, 'PRESIDENTE DE EL CLAUSTRO', 0, 0, 'L');
                    } else if ($carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 300 || $carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 600) {
                        $pdf->Cell(0, 0, 'DIRECTOR DE POSTGRADOS', 0, 0, 'L');
                    }

                    $pdf->SetFont('TrajanPro', '', 12);
                    $pdf->SetY(227);
                    $pdf->SetX(294);
                    $pdf->Cell(0, 0, 'PRESIDENTE DE El CONSEJO DIRECTIVO', 0, 0, 'L');

                    $pdf->SetFont('TrajanPro', '', 12);
                    $pdf->SetY(254);
                    //$pdf->SetX(107);
                    if ($carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 200) {
                        $pdf->SetX(107);
                        $pdf->Cell(0, 0, 'DECANO', 0, 0, 'L');
                    } else if ($carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 300 || $carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 600) {
                        $pdf->SetX(82);
                        $pdf->Cell(0, 0, 'DIRECTOR DEL PROGRAMA', 0, 0, 'L');
                    }
                    $pdf->SetFont('TrajanPro', '', 12);
                    $pdf->SetY(254);
                    $pdf->SetX(231);
                    $pdf->Cell(0, 0, 'SECRETARIO GENERAL', 0, 0, 'L');

                    $pdf->SetFont('Humanst521BTRoman', '', 10);
                    $pdf->SetY(285);
                    $pdf->SetX(314);
                    $pdf->Cell(0, 0, 'Registro  ' . $registroGrado->getIdRegistroGrado(), 0, 0, 'L');

                    $pdf->SetFont('Humanst521BTRoman', '', 10);
                    $pdf->SetY(285);
                    $pdf->SetX(344);
                    $pdf->Cell(0, 0, 'Folio ' . $folioTemporal->getNumeroFolio(), 0, 0, 'L');

                    $pdf->SetFont('Humanst521BTRoman', '', 10);
                    $pdf->SetY(285);
                    $pdf->SetX(364);
                    $pdf->Cell(0, 0, utf8_decode('Vigilada Mineducación'), 0, 0, 'L');

                    ob_end_clean();
                    $pdf->Output();
                } else {
                    echo "No existe Registro de Grado del estudiante seleccionado";
                }
            }

            break;


        case "6":

            $anioAcuerdo = date("Y", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo()));
            $diaAcuerdo = date("d", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo()));


            $mes = mes(date("Y-m-d", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo())));


            $anioGraduacion = date("Y", strtotime($registroGrado->getActaAcuerdo()->getFechaGrado()->getFechaGraduacion()));
            $diaGraduacion = date("d", strtotime($registroGrado->getActaAcuerdo()->getFechaGrado()->getFechaGraduacion()));

            $mesGraduacion = mes(date("Y-m-d", strtotime($registroGrado->getActaAcuerdo()->getFechaGrado()->getFechaGraduacion())));


            //$registroGrado = $controlRegistroGrado->buscarRegistroGradoId( $txtCodigoEstudiante, $txtIdActa );

            $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Documento sin título</title>
						<style type="text/css">
							body {
								font-family: Arial, Helvetica, sans-serif;
								font-size: 12pt;
							margin-left: 1cm;
						    margin-top: 1cm;
						    margin-right: 1cm;
						    margin-bottom: 1cm;
						}
						@page { margin: 120px 50px; }
						#header { position: fixed; left: 0px; top: -120px; right: 0px; height: 50px; text-align: center; }
						#footer { position: fixed; left: 0px; bottom: -100px; right: 0px; height: 100px; }
						#footer .page:after { content: counter(page, upper-roman); }
						</style>
						</head>

						<body>
						<div id="header">
							    <p ><img src="../css/images/encabezadoBosque.jpg" width="100%" height="85"/></p>
							</div>
							<div align="right" id="footer">
								<p ><img width="400" height="52" src="../css/images/piePagina.jpg" /></p>
						  	</div>
					        <div id="content" align="center">
							    <p><strong style="font-size:22px;">UNIVERSIDAD EL BOSQUE</strong><br />
								Personería Jurídica: Resolución No. 11153 de 1978 Reconocimiento institucional como Universidad: Resolución No. 327 de 1997 del Ministerio de Educación Nacional.
								</p>
							    <br>
							    <p align="center"><strong>ACTA DE GRADO</strong></p>
							    <p align="justify">El Consejo Directivo de la Universidad El Bosque, en su sesión del día ' . $diaAcuerdo . ' de ' . $mes . ' de ' . $anioAcuerdo . ', según consta en el Acta No. ' . $registroGrado->getActaAcuerdo()->getNumeroActa() . ' y Acuerdo No. ' . $registroGrado->getActaAcuerdo()->getNumeroAcuerdo() . ' de fecha ' . date("Y-m-d", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo())) . ', estudió y aprobó la solicitud del aspirante a grado, alumno(a)</p>
							    <p align="center"><strong>' . pasarMayusculas($estudiante->getNombreEstudiante() . " " . $estudiante->getApellidoEstudiante()) . '<br />
					            ' . $estudiante->getTipoDocumento()->getDescripcion() . ' No. ' . $estudiante->getNumeroDocumento() . ' de ' . $estudiante->getExpedicion() . '</strong></p>
							    <p align="justify">Quién cumplió satisfactoriamente con todos los requisitos académicos y legales exigidos por la Institución, conforme al concepto previo emitido por el Consejo Académico, motivo por el cuál autorizó se le otorgué el título de</p>
							    <br>
					            <p align="center"><strong>' . pasarMayusculas($tituloProfesion->getTituloProfesion()->getNombreTitulo()) . '</strong></p>
							    <p align="justify">En ceremonia solemne del día ' . $diaGraduacion . ' de ' . $mesGraduacion . ' del año ' . $anioGraduacion . ', se le hace entrega del diploma No. ' . $registroGrado->getNumeroDiploma() . ', el cual aparece registrado con el No. 4578, al folio 792, del libro de registro de títulos de la Universidad, correspondiente al año ' . $anioGraduacion . '.</p>
					            <p align="justify">En testimonio de lo anterior, se firma el presente extracto de Acta de Grado, en Bogotá, D.C, a los ' . numtoletras($diaGraduacion) . ' (' . $diaGraduacion . ') días del mes de ' . $mesGraduacion . ' del año ' . numtoletras($anioGraduacion) . ' (' . $anioGraduacion . ').</p>
							    <p align="left">&nbsp;</p>
							    <br>
							    <br>
							    <table width="100%" border="0">
	                            	<tr>
	                                	<td width="50%">MARÍA CLARA RANGEL GALVIS</td>
	                                    <td width="50%">LUIS ARTURO RODRÍGUEZ BUITRAGO</td>
	                                </tr>
	                                <tr>
	                                	<td>RECTORA</td>
	                                    <td>SECRETARIO GENERAL</td>
	                                </tr>
	                            </table>
							  </div>
							  <p style="page-break-before: always;"></p>
							  </body>
							</html>';

            //	echo $html."<br />";
            $filename = "actaGrado" . $nombreCarrera . ".pdf";

            $dompdf = new DOMPDF();
            $dompdf->set_paper("letter", "portrait");
            $dompdf->load_html($html); //cargamos el html
            $dompdf->render(); //renderizamos
            //$pdf = $dompdf->output();//asignamos la salida a una variable
            $dompdf->stream($filename);
            break;
    }
}
?>