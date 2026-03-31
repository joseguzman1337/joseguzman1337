<?php

header('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

ini_set('display_errors', 'On');
set_time_limit(0);

session_start();

require_once '../lib/pdf/dompdf/dompdf_config.inc.php';

include '../lib/phpMail/class.phpmailer.php';
include '../lib/phpMail/class.smtp.php';

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
include '../control/ControlDeudaPeople.php';
include '../control/ControlEstudianteDocumento.php';
include '../control/ControlDocumentoPeople.php';
include '../control/ControlGeneroPeople.php';
include '../control/ControlLocalidad.php';
include '../control/ControlFolioTemporal.php';
include '../control/ControlDirectivo.php';

function mesActual() {
    $fechaActual = date("Y-m-d");
    $fechaActual = strtotime($fechaActual);
    $mes = date("F", ($fechaActual));
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
        $mes = "0ctubre";
    }
    if ($mes == "November") {
        $mes = "Noviembre";
    }
    if ($mes == "December") {
        $mes = "Diciembre";
    }

    return $mes;
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
        $mes = "0ctubre";
    }
    if ($mes == "November") {
        $mes = "Noviembre";
    }
    if ($mes == "December") {
        $mes = "Diciembre";
    }

    return $mes;
}

function fechaActual() {
    $fechaActual = date("Y-m-d");
    $fechaActual = strtotime($fechaActual);
    return $fechaActual;
}

function fecha($fecha) {
    $fecha = strtotime($fecha);
    return $fecha;
}

if ($_POST) {
    $keys_post = array_keys($_POST);
    foreach ($keys_post as $key_post) {
        $$key_post = strip_tags(trim($_POST[$key_post]));
    }
}

if ($_GET) {
    $keys_get = array_keys($_GET);
    foreach ($keys_get as $key_get) {
        $$key_get = strip_tags(trim($_GET[$key_get]));
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

$controlActaAcuerdo = new ControlActaAcuerdo($persistencia);
$controlCarrera = new ControlCarrera($persistencia);
$controlFacultad = new ControlFacultad($persistencia);
$controlUsuario = new ControlUsuario($persistencia);
$controlClienteCorreo = new ControlClienteCorreo($persistencia);

$mesActual = mesActual();
$diaActual = date("j", fechaActual());
$anioActual = "20" . date("y", fechaActual());

function fechas($fecha) {

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
        $mes = "0ctubre";
    }
    if ($mes == "November") {
        $mes = "Noviembre";
    }
    if ($mes == "December") {
        $mes = "Diciembre";
    }
    $diaGrado = date("j", $fecha);
    $anioGrado = date("Y", $fecha);

    return $mes . ' ' . $diaGrado . ' de ' . $anioGrado;
}

if (strlen($diaActual) == 1) {
    $diaActual = "0" . $diaActual;
}

switch ($tipoOperacion) {

    case "generarAcuerdo":

        include '../lib/radicacion/numtoletras.php';
        $actaAcuerdos = $controlActaAcuerdo->consultarActaAcuerdosAgrupada($txtFechaGrado);
        $controlDirectivos = new ControlDirectivo($persistencia);
        $controlIncentivoAcademico = new ControlIncentivoAcademico($persistencia);

        if ($txtIdTipoGrado == 1) {
            $txtIdTipoGrado = "CEREMONIA";
        } else {
            $txtIdTipoGrado = "SECRETARIA";
        }

        $directivos = $controlDirectivos->consultarDirectivosActuales();

        foreach ($directivos as $directivo) {
            $nombre = $directivo->getNombreDirectivo();
            $directivosActuales[] = $nombre;
        }

        $html = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Documento sin titulo</title>
		<style type="text/css">
		body{
			font-family: Arial Black, Gadget, sans-serif;
			font-size: 10pt;
			margin-left: 1cm;
                        margin-top: 1cm;
                        margin-right: 1cm;
                        margin-bottom: 1cm; 
		}
		@page { margin: 100px 40px; }
		#header { position: fixed; left: 0px; top: -100px; right: 0px; height: 50px; text-align: center; }
		</style>
		</head>
		
		<body>';
        foreach ($actaAcuerdos as $actaAcuerdo) {

            if ($actaAcuerdo->getNumeroAcuerdo() != 0) {
                $anioAcuerdo = date("Y", strtotime($actaAcuerdo->getFechaAcuerdo()));
                $diaAcuerdo = date("d", strtotime($actaAcuerdo->getFechaAcuerdo()));
                $mesAcuerdo = mes(date("Y-m-d", strtotime($actaAcuerdo->getFechaAcuerdo())));
                $txtCodigoCarrera = $actaAcuerdo->getFechaGrado()->getCarrera()->getCodigoCarrera();
                $tituloProfesion = $controlCarrera->buscarTituloProfesion($txtCodigoCarrera);
                $facultad = $controlFacultad->buscarFacultad($txtCodigoCarrera);

                $html .= '<div id="header"></div>
                            <div align="right" id="footer">
                            </div>
                            <div align="center">
                                <p><strong>ACUERDO N° ' . $actaAcuerdo->getNumeroAcuerdo() . ' DE ' . $anioAcuerdo . '</strong></p>
                                <br />
                                <p align="justify"><strong>Por el cual se autoriza el otorgamiento de unos t&iacute;tulos</strong></p>
                                <p align="justify">El Consejo Directivo, en uso de sus atribuciones legales, en especial las conferidas por el Estatuto General, en sesi&oacute;n del d&iacute;a ' . $diaAcuerdo . ' de ' . $mesAcuerdo . ' de ' . $anioAcuerdo . ', acta No.' . $actaAcuerdo->getNumeroActaConsejoDirectivo() . ' y,</p>
                                <br />
                                <p align="center"><strong>CONSIDERANDO</strong></p>
                                <p align="justify">
                                Que el Decano de la   ' . pasarMayusculas($facultad->getNombreFacultad()) . ', por conducto de la Verrector&iacute;a Acad&eacute;mica, solicit&oacute; al consejo
                                Directivo, autorizaci&oacute;n de grado por <strong>' . $txtIdTipoGrado . '</strong> para los estudiantes de &uacute;ltimo semestre  del programa de 
                                <strong>' . pasarMayusculas($actaAcuerdo->getFechaGrado()->getCarrera()->getNombreCortoCarrera()) . '</strong>, debidamente autorizados por el 
                                    Consejo de Facultad, que cumplen con los requisitos legales y acad&eacute;micos exigidos para el efecto.<br><br>
                                    Que el cumplimiento de tales requisitos, se entiende verificado previamente, por parte de las instancias correspondientes, como son la Facultad y
                                    la Oficina de Registro y Control de la Universidad, seg&uacute;n la relaci&oacute;n de estudiantes aprobada por el presente acuerdo, en su art&iacute;culo primero.<br><br>
                                    Que por lo anteriormente expuesto,</p>
                                    <p align="center"><strong>ACUERDA:</strong></p>
                                    <p align="justify">
                                    <strong>ART&Iacute;CULO PRIMERO</strong>. Autorizar y en consecuencia OTORGAR el t&iacute;tulo de 
                                    <strong>' . pasarMayusculas($tituloProfesion->getTituloProfesion()->getNombreTitulo()) . '</strong>, a los siguientes estudiantes:
                                    </p>
 
                                <table width="100%" border="1" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Estudiante</th>
                                            <th>Documento de Identificaci&oacute;n</th>
                                            <th>Expedido</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                $txtActaAcuerdoNumero = $actaAcuerdo->getNumeroAcuerdo();
                $txtIdActaAcuerdo = $actaAcuerdo->getIdActaAcuerdo();
                $detalleActaAcuerdos = $controlActaAcuerdo->consultarAcuerdoPDFNumero($txtFechaGrado, $txtActaAcuerdoNumero);

                $i = 1;
                $j = 0;
                $estudiantes = array();

                foreach ($detalleActaAcuerdos as $detalleActaAcuerdo) {
                    $incentivos = $controlIncentivoAcademico->VerIncentivoEstudiantes($detalleActaAcuerdo->getEstudiante()->getCodigoEstudiante(), $txtCodigoCarrera);

                    if (count($incentivos) <> 0) {
                        $estudiantes[] = array("codigo" => $detalleActaAcuerdo->getEstudiante()->getCodigoEstudiante(), "nombre" => $detalleActaAcuerdo->getEstudiante()->getNombreEstudiante());
                    }

                    $html .= '	 
                                                 <tr>
                                                    <td>' . $i++ . '</td>
                                                    <td>' . $detalleActaAcuerdo->getEstudiante()->getNombreEstudiante() . '</td>
                                                    <td>' . $detalleActaAcuerdo->getEstudiante()->getNumeroDocumento() . '</td>
                                                    <td>' . $detalleActaAcuerdo->getEstudiante()->getExpedicion() . '</td>
                                                 </tr>';
                }

                $html .= '</tbody> 
                                </table><br/>';

                if (count($estudiantes) > 0) {
                    $html .= '<p align="justify"><strong>ART&Iacute;CULO SEGUNDO.</strong> Autorizar el otorgamiento de los siguientes incentivos acad&eacute;micos:</p>';
                    $html .= '<table width="100%" border="1" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Estudiante</th>
                                        <th>Incentivo</th>
                                    </tr>
                                </thead>
                                <tbody>';
                    $k = 1;

                    foreach ($estudiantes as $codigo) {

                        $incentivos = $controlIncentivoAcademico->VerIncentivoEstudiantes($codigo["codigo"], $txtCodigoCarrera);
                        foreach ($incentivos as $incentivoAcademico) {

                            $html .= '<tr>
                                        <td>' . $k++ . '</td>
                                        <td>' . $codigo["nombre"] . '</td>
                                        <td>' . $incentivoAcademico->getNombreIncentivo() . '</td>
                                    </tr>';
                        }
                    }

                    $html .= '</tbody></table><br/><p align="justify">';
                    $html .= '<strong>ART&Iacute;CULO TERCERO.</strong> Enti&eacute;ndase como fecha de grado, la fecha de la sesi&oacute;n del Consejo Directivo que lo autoriza.<br><br>';
                    $html .= '<strong>ART&Iacute;CULO CUARTO.</strong> Disponer la entrega de los respectivos diplomas, en ceremonia que se efectuar&aacute; seg&uacute;n la programaci&oacute;n prevista por la Universidad.<br><br>';
                    $html .= '<strong>ART&Iacute;CULO QUINTO.</strong> El presente Acuerdo rige a partir de la fecha de su expedici&oacute;n.</p>';
                } else {
                    $html .= '<br/><p align="justify"><strong>ART&Iacute;CULO SEGUNDO.</strong> Enti&eacute;ndase como fecha de grado, la fecha de la sesi&oacute;n del Consejo Directivo que lo autoriza.<br><br>';
                    $html .= '<strong>ART&Iacute;CULO TERCERO.</strong> Disponer la entrega de los respectivos diplomas, en ceremonia que se efectuar&aacute; seg&uacute;n la programaci&oacute;n prevista por la Universidad.<br><br>';
                    $html .= '<strong>ART&Iacute;CULO CUARTO.</strong> El presente Acuerdo rige a partir de la fecha de su expedici&oacute;n.</p>';
                }

                $html .= '<p align="left">COMUN&Iacute;QUESE Y CUMPLASE</p>';
                if ($diaAcuerdo == 1) {
                    $html .= '    <p align="left">Dado en Bogot&aacute; el d&iacute;a primero ( ' . $diaAcuerdo . ' )  del mes de ' . $mesAcuerdo . ' de ' . numtoletras($anioAcuerdo) . ' (' . $anioAcuerdo . ')</p>';
                } else {
                    $html .= '    <p align="left">Dado en Bogot&aacute; a los  ' . numtoletras($diaAcuerdo) . ' ( ' . $diaAcuerdo . ' )  d&iacute;as del mes de ' . $mesAcuerdo . ' de ' . numtoletras($anioAcuerdo) . ' (' . $anioAcuerdo . ')</p>';
                }

                $html .= '<br /><br /><br /><br />
                                <table width="100%" border="0">
                                    <tr style="font-size:12px">
                                        <td width="60%"><strong>' . $directivosActuales[0] . '<br/>Presidente</strong></td>
                                        <td><strong>' . $directivosActuales[1] . '<br/>Secretaria</strong></td>
                                        
                                    </tr>
                                </table>
                              </div>
                            <p style="page-break-before: always;"></p>
                            ';
            }
        }
        $html .= '</body>
		</html>';


        $filename = "acuerdo" . $txtFechaGrado . ".pdf";

        $dompdf = new DOMPDF();
        $dompdf->set_paper("letter", "portrait");
        $dompdf->load_html($html); //cargamos el html
        $dompdf->render(); //renderizamos
        $dompdf->stream($filename);
        $controlClienteCorreo->enviarSecretarioGeneral($txtFechaGrado, $anioActual, $mesActual, $diaActual);

        break;

    case "generarActa":
        $controlIncentivoAcademico = new ControlIncentivoAcademico($persistencia);
        $actaAcuerdos = $controlActaAcuerdo->consultarActaAcuerdos($txtFechaGrado);

        if ($txtCodigoModalidadAcademica == 200) {
            $trato = "Doctora";
            $emailUsuario = "viceacademica@unbosque.edu.co";
            $cargo = "Vicerrectora Acad&eacute;mica";
            $nombre = "RITA CECILIA PLATA DE SILVA";
        } else {
            $trato = "Doctor";
            $emailUsuario = "dir.postgrados@unbosque.edu.co";
            $cargo = "Direcci&oacute;n de postgrados";
            $nombre = "DIRECTOR DE POSTGRADOS";
        }

        $tipoGrado = "";

        if ($txtIdTipoGrado == 1) {
            $tipoGrado = "CEREMONIA";
        } else {
            $tipoGrado = "SECRETARIA";
        }

        $html = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Documento sin titulo</title>
		<style type="text/css">
		body{
			font-family: Arial Black, Gadget, sans-serif;
			font-size: 12pt;
			margin-left: 1cm;
                        margin-top: 1cm;
                        margin-right: 1cm;
                        margin-bottom: 1cm; 
		}
		@page { margin: 118px 50px; }
		#header { position: fixed; left: 0px; top: -100px; right: 0px; text-align: center; }
		#footer { position: fixed; left: 0px; bottom: -110px; right: 0px; height: 90px; }
		#footer .page:after { content: counter(page, upper-roman); }
		</style>
		</head>
		<body>';
        foreach ($actaAcuerdos as $actaAcuerdo) {


            $fecha = $actaAcuerdo->getFechaActa();
            $txtCodigoCarrera = $actaAcuerdo->getFechaGrado()->getCarrera()->getCodigoCarrera();

            $mes = mes($fecha);
            $dia = date("j", fecha($fecha));
            $anio = "20" . date("y", fecha($fecha));

            if (strlen($dia) == 1) {
                $dia = "0" . $dia;
            }

            $html .= '
                    <div id="header">
                        <p ><img src="../css/images/encabezadoBosque.jpg" width="100%"/></p>
                    </div>
                    <div align="right" id="footer">
                            <p ><img width="400" height="52" src="../css/images/piePagina.jpg" /></p>   
                    </div>
                    <div id="content" align="center">
                        <p align="right">Bogot&aacute; ' . $diaActual . ' de ' . $mesActual . ' de ' . $anioActual . '</p>
                        <p align="justify">' . $trato . '<br /><strong>' . $nombre . '</strong><br />' . $cargo . '<br /><strong>UNIVERSIDAD EL BOSQUE</strong><br />
                          Bogot&aacute;</p>
                        <p align="justify" style="font-size: 11pt;"><strong>ASUNTO: POSTULACI&Oacute;N CONSEJO DIRECTIVO - GRADO</strong></p>
                        <p align="justify">El Consejo de Facultad, en su sesi&oacute;n del d&iacute;a ' . $dia . ' de ' . $mes . ' de ' . $anio . ', Acta No. ' . $actaAcuerdo->getNumeroActa() . ', emiti&oacute; concepto favorable para tr&aacute;mite de otorgamiento de t&iacute;tulo a los estudiantes que se relacionan a continuaci&oacute;n:</p>
                        <p align="center" style="font-size: 10pt;"><strong>POSTULADOS A GRADO EN ' . $tipoGrado . ' - ' . $actaAcuerdo->getFechaGrado()->getCarrera()->getNombreCarrera() . '</strong></p>
                        <table width="100%" border="1" cellpadding="0" cellspacing="0" style="font-size: 10pt;"  >
                           <thead>
                               <tr>
                                   <th>No</th>
                                   <th>Estudiante</th>
                                   <th>Documento de Identificaci&oacute;n</th>
                                   <th>Expedido</th>
                                </tr>
                           </thead>
                           <tbody>';
            $txtIdActaAcuerdo = $actaAcuerdo->getIdActaAcuerdo();
            $detalleActaAcuerdos = $controlActaAcuerdo->consultarActaPDF($txtFechaGrado, $txtIdActaAcuerdo);
            $i = 1;
            $cantidadIncentivos = 0;
            foreach ($detalleActaAcuerdos as $detalleActaAcuerdo) {
                $txtCodigoEstudiante = $detalleActaAcuerdo->getEstudiante()->getCodigoEstudiante();
                $incentivos = $controlIncentivoAcademico->VerIncentivoEstudiantes($txtCodigoEstudiante, $txtCodigoCarrera);

                foreach ($incentivos as $verIncentivos) {
                    $tipoIncentivo = $verIncentivos->getNombreIncentivo();

                    if ($tipoIncentivo != "") {
                        $cantidadIncentivos = $cantidadIncentivos + 1;
                    }
                }


                if ($detalleActaAcuerdo->getEstadoEnvioVicerrectoria() == null) {
                    $controlActaAcuerdo->actualizarEnvioVicerrectoria($txtIdActaAcuerdo, $txtCodigoEstudiante);
                }
                $html .= '	 
                                 <tr>
                                        <td>' . $i++ . '</td>
                                        <td>' . $detalleActaAcuerdo->getEstudiante()->getNombreEstudiante() . '</td>
                                        <td>' . $detalleActaAcuerdo->getEstudiante()->getNumeroDocumento() . '</td>
                                        <td>' . $detalleActaAcuerdo->getEstudiante()->getExpedicion() . '</td>
                                 </tr>';
            }
            $html .= '</tbody> 
                        </table>';


            if ($cantidadIncentivos > 0) {

                $html .= '<br />
                        <p align="center"><strong>ESTUDIANTES CANDIDATOS A GRADO CON INCENTIVOS</strong></p>
			<table width="100%" border="1" cellpadding="0" cellspacing="0" style="font-size: 10pt;"  >
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Estudiante</th>
                                    <th>Documento de Identificaci&oacute;n</th>
                                    <th>Tipo Incentivo</th>
                                    <th>Descripci&oacute;n</th>
                                </tr>
                            </thead>
                            <tbody>';
                $e = 1;
                foreach ($detalleActaAcuerdos as $detalleActaAcuerdo) {

                    $cargaIncentivos = "";
                    $txtCodigoEstudiante = $detalleActaAcuerdo->getEstudiante()->getCodigoEstudiante();
                    $incentivos = $controlIncentivoAcademico->VerIncentivoEstudiantes($txtCodigoEstudiante, $txtCodigoCarrera);

                    foreach ($incentivos as $verIncentivos) {
                        $tipoIncentivo = $verIncentivos->getNombreIncentivo();
                        $observacion = $verIncentivos->getObservacionIncentivo();

                        $html .= '	 
                                                <tr>
                                                    <td>' . $e++ . '</td>
                                                    <td>' . $detalleActaAcuerdo->getEstudiante()->getNombreEstudiante() . '</td>
                                                    <td>' . $detalleActaAcuerdo->getEstudiante()->getNumeroDocumento() . '</td>
                                                    <td>' . $tipoIncentivo . '</td>
                                                    <td>' . $observacion . '</td>							 	
                                                </tr>';
                    }
                }
                $html .= '</tbody>
                        </table>';
            }

            $html .= '<br /><br /><br />
                        <p align="justify">Muy respetuosamente, le solicito presentarla al pr&oacute;ximo Consejo Directivo para grado ceremonial, habiendo cumplido con todos los requisitos acad&eacute;micos, administrativos y financieros del Reglamento Estudiantil.</p>
                        <p align="justify">
                        <br />
                        Mar&iacute;a del Consuelo Mart&iacute;nez Rinc&oacute;n 
                        </p>
                    </div>
		    <div style="page-break-before: always;"></div>';
        }
        $html .= '</body>
		</html>';


        $filename = "acta" . $txtFechaGrado . ".pdf";

        $dompdf = new DOMPDF();
        $dompdf->set_paper("letter", "portrait");
        $dompdf->load_html($html); //cargamos el html
        $dompdf->render(); //renderizamos
        $dompdf->stream($filename);
        $controlClienteCorreo->enviarVicerrectoria($txtFechaGrado, $anioActual, $mesActual, $diaActual, $txtCodigoModalidadAcademica, $txtIdTipoGrado);

        break;

    case "enviarComunicado":

        $ruta = "../documentos/actas/" . $txtFechaGrado . "/*.pdf";
        $cuentaArchivos = count(glob($ruta));

        if ($cuentaArchivos > 0) {
            $controlClienteCorreo->enviarComunicado($txtFechaGrado, $txtTipoGrado);
        } else {
            echo "No hay Documentos para Enviar";
        }

        break;

    case "exportar":

        $controlRegistroGrado = new ControlRegistroGrado($persistencia);
        $controlFolioTemporal = new ControlFolioTemporal($persistencia);

        header("Content-type: application/vnd.ms-excel; name='excel'");
        header("Content-Disposition: filename=ficheroExcel.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        if ($txtCodigoReferencia == 1 || $txtCodigoReferencia == 2) {


            $filtro = "";

            if ($cmbFacultadTReporte != -1) {
                $filtro .= " AND FT.codigofacultad = " . $cmbFacultadTReporte . "";
            }

            if ($cmbCarreraTReporte != -1) {

                if ($cmbCarreraTReporte == 'pregrados') {

                    $filtro .= " AND C.codigomodalidadacademica = 200";
                } else if ($cmbCarreraTReporte == 'posgrados') {

                    $filtro .= " AND C.codigomodalidadacademica = 300";
                } else {

                    $filtro .= " AND C.codigocarrera = " . $cmbCarreraTReporte . "";
                }
            }

            if ($cmbTipoGradoTReporte != -1) {
                $filtro .= " AND F.TipoGradoId = " . $cmbTipoGradoTReporte . "";
            }

            if ($cmbPeriodoTReporte != -1) {
                $filtro .= " AND F.CodigoPeriodo = " . $cmbPeriodoTReporte . "";
            }

            $registroGrados = $controlRegistroGrado->consultarCeremoniaEgresados($filtro);
            $i = 1;
            if (count($registroGrados) != 0) {
?>
                <?php

                $html = "
			<p>Estudiantes Graduados: </p>
			<br />
			<div>
                            <table id=\"estudianteCeremoniaEgresados\" width=\"100%\" border=\"1\"  >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>T&iacute;tulo</th>
                                        <th>Tipo</th>
                                        <th>N.Documento</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Fecha Grado</th>
                                        <th>Incentivo</th>
                                        <th>Registro</th>
                                        <th>Acta</th>
                                        <th>Acuerdo</th> 
                                        <th>Diploma</th>
                                        <th>Folio</th>
                                    </tr>
                                </thead>
                                <tbody class=\"listaEstudiantes\">";
                foreach ($registroGrados as $registroGrado) {

                    $estadoIncentivo = $registroGrado->getIncentivoAcademico()->getEstadoIncentivo();

                    $folioTemporal = $controlFolioTemporal->buscarFolioTemporal($registroGrado->getIdRegistroGrado());

                    if ($estadoIncentivo == 100 or $estadoIncentivo == '') {
                        $html .= "<tr>
                                                    <td align=\"center\">" . $i++ . "</td>
                                                    <td>" . $registroGrado->getActaAcuerdo()->getFechaGrado()->getCarrera()->getTituloProfesion()->getNombreTitulo() . "</td>
                                                    <td>" . $registroGrado->getEstudiante()->getTipoDocumento()->getIniciales() . "</td>
                                                    <td>" . $registroGrado->getEstudiante()->getNumeroDocumento() . "</td>
                                                    <td>" . $registroGrado->getEstudiante()->getNombreEstudiante() . "</td>
                                                    <td>" . $registroGrado->getEstudiante()->getApellidoEstudiante() . "</td>
                                                    <td>" . date("Y-m-d", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo())) . "</td>
                                                    <td>" . $registroGrado->getIncentivoAcademico()->getNombreIncentivo() . "</td>
                                                    <td>" . $registroGrado->getIdRegistroGrado() . "</td>
                                                    <td>" . $registroGrado->getActaAcuerdo()->getNumeroActaConsejoDirectivo() . "</td>
                                                    <td>" . $registroGrado->getActaAcuerdo()->getNumeroAcuerdo() . "</td>
                                                    <td>" . $registroGrado->getNumeroDiploma() . "</td>
                                                    <td>" . $folioTemporal->getNumeroFolio() . "</td>
                                                </tr>";
                    }
                }
                $html .= "</tbody>
                            </table>
                            <br />
                        </div>";
            }
        } else if ($txtCodigoReferencia == 3) {
            $filtro = "";
            $filtroSubConsulta = "";

            if ($cmbFacultadTReporte != -1) {
                $filtro .= " AND FT.codigofacultad = " . $cmbFacultadTReporte . "";
                $filtroSubConsulta .= " AND FT.codigofacultad = " . $cmbFacultadTReporte . "";
            }

            if ($cmbCarreraTReporte != -1) {
                $filtro .= " AND C.codigocarrera = " . $cmbCarreraTReporte . "";
            }

            if ($cmbPeriodoTReporte != -1) {
                $filtro .= " AND F.CodigoPeriodo = " . $cmbPeriodoTReporte . "";
                $filtroSubConsulta .= " AND F.CodigoPeriodo = " . $cmbPeriodoTReporte . "";
            }

            if ($cmbTipoGradoTReporte != -1) {
                $filtro .= " AND F.TipoGradoId = " . $cmbTipoGradoTReporte . "";
                $filtroSubConsulta .= " AND F.TipoGradoId = " . $cmbTipoGradoTReporte . "";
            }

            $registroGrados = $controlRegistroGrado->consultarNumeroGraduados($filtro, $filtroSubConsulta);
            $i = 1;

            if (count($registroGrados) != 0) {
                $html = "
			<div>
                            <table id=\"estudianteCeremoniaEgresados\" width=\"100%\" border=\"1\"  >
                                <thead>
                                    <tr align='center' >
                                        <th style=\"width: 5%;\" >No</th>
                                        <th style=\"width: 45%;\">Nombre Carrera</th>
                                        <th>Mujeres</th>
                                        <th>Hombres</th>
                                        <th>Total Estudiantes</th>
                                    </tr>
                                </thead>
                                <tbody class=\"listaEstudiantes\">";
                foreach ($registroGrados as $registroGrado) {

                    if ($registroGrado->getconteoGradosMujer() == '') {

                        $mujer = 0;
                    } else {

                        $mujer = $registroGrado->getconteoGradosMujer();
                    }

                    if ($registroGrado->getconteoGradosHombre() == '') {

                        $hombre = 0;
                    } else {

                        $hombre = $registroGrado->getconteoGradosHombre();
                    }

                    $html .= "<tr align='center'>
                                                <td>" . $i++ . "</td>
                                                <td>" . utf8_decode($registroGrado->getActaAcuerdo()->getFechaGrado()->getCarrera()->getNombreCarrera()) . "</td>
                                                <td>" . $mujer . "</td>
                                                <td>" . $hombre . "</td>
                                                <td>" . $registroGrado->getIdRegistroGrado() . "</td>
                                            </tr>";
                }

                $html .= "</tbody>
                            </table><br />
                        </div>";
            }
        } else if ($txtCodigoReferencia == 4) {

            $filtro = "";

            if ($cmbFacultadTReporte != -1) {
                $filtro .= " AND FT.codigofacultad = " . $cmbFacultadTReporte . "";
            }

            if ($cmbCarreraTReporte != -1) {
                $filtro .= " AND C.codigocarrera = " . $cmbCarreraTReporte . "";
            }

            if ($cmbPeriodoTReporte != -1) {
                $filtro .= " AND F.CodigoPeriodo = " . $cmbPeriodoTReporte . "";
            }

            if ($cmbTipoGradoTReporte != -1) {
                $filtro .= " AND F.TipoGradoId = " . $cmbTipoGradoTReporte . "";
            }

            $registroGrados = $controlRegistroGrado->consultarCeremoniaEgresados($filtro);
            $txtFechaGrado = $registroGrados[0]->getActaAcuerdo()->getFechaGrado()->getIdFechaGrado();

            $controlActaAcuerdo = new ControlActaAcuerdo($persistencia);
            $actaAcuerdos = $controlActaAcuerdo->consultarActaAcuerdosPeriodo($txtFechaGrado, $cmbPeriodoTReporte);

            $i = 1;
            $cuentaAcuerdo = 0;
            $cuentaAcuerdo2 = 0;
            $cuentaAcuerdo3 = 0;

            $fechaHoy = date("Y-m-d");
            $anioHoy = date("Y", strtotime($fechaHoy));
            $diaHoy = date("d", strtotime($fechaHoy));
            $mesHoy = mes($fechaHoy);


            if (count($registroGrados) != 0) {

                $html = "	
			<div>
			<br />		
                        <table width=\"100%\" border=\"0\">
                            <tr>
				<td>Fecha de Grado:";
                if (count($actaAcuerdos) > 1) {
                    foreach ($actaAcuerdos as $actaAcuerdo) {
                        $anioGrado = date("Y", strtotime($actaAcuerdos[$cuentaAcuerdo]->getFechaAcuerdo()));
                        $diaGrado = date("d", strtotime($actaAcuerdos[$cuentaAcuerdo]->getFechaAcuerdo()));
                        $mes = mes($actaAcuerdos[$cuentaAcuerdo]->getFechaAcuerdo());
                        $html .= $mes . " " . $diaGrado . " " . "de" . " " . $anioGrado . " ";
                        $cuentaAcuerdo = $cuentaAcuerdo + 1;
                    }
                } else {

                    $anioGrado = date("Y", strtotime($actaAcuerdos[0]->getFechaAcuerdo()));
                    $diaGrado = date("d", strtotime($actaAcuerdos[0]->getFechaAcuerdo()));
                    $mes = mes($actaAcuerdos[0]->getFechaAcuerdo());
                    $html .= $mes . " " . $diaGrado . " " . "de" . " " . $anioGrado . " ";
                }

                $html .= "</td>
                                <td>Acuerdo:";
                if (count($actaAcuerdos) > 1) {
                    foreach ($actaAcuerdos as $actaAcuerdo) {
                        $html .= $actaAcuerdos[$cuentaAcuerdo2]->getNumeroAcuerdo() . " ";
                        $cuentaAcuerdo2 = $cuentaAcuerdo2 + 1;
                    }
                } else {
                    echo $actaAcuerdos[0]->getNumeroAcuerdo();
                }
                $html .= "</td>
				<td>Acta: ";
                if (count($actaAcuerdos) > 1) {
                    foreach ($actaAcuerdos as $actaAcuerdo) {
                        $html .= $actaAcuerdos[$cuentaAcuerdo3]->getNumeroActaConsejoDirectivo() . " ";
                        $cuentaAcuerdo3 = $cuentaAcuerdo3 + 1;
                    }
                } else {
                    $html .= $actaAcuerdos[0]->getNumeroActaConsejoDirectivo();
                }
                $html .= "</td>
				    <td>Fecha: " . $mesHoy . " " . $diaHoy . " de " . $anioHoy . "</td>
                            </tr>
                        </table>
                        <br />
                        <table width=\"100%\" id=\"estudianteCeremoniaEgresados\" border=\"0\" style=\"text-align:center\">
                            <thead>
                              <tr>
                                  <th>Reg.</th>
                                  <th>Apellidos y Nombres</th>
                                  <th>Documento de Identidad</th>
                                  <th>Programa</th>
                                  <th>T&iacute;tulo Otorgado</th>
                                  <th>Diploma</th>
                                  <th>Folio</th>
                              </tr>
                            </thead>
                            <tbody>";

                foreach ($registroGrados as $registroGrado) {

                    $folioTemporal = $controlFolioTemporal->buscarFolioTemporal($registroGrado->getIdRegistroGrado());
                    $html .= "<tr>";
                    $html .= "<td align=\"center\">" . $registroGrado->getIdRegistroGrado() . "</td>
                                                <td>" . $registroGrado->getEstudiante()->getApellidoEstudiante() . " " . $registroGrado->getEstudiante()->getNombreEstudiante() . "</td>
                                                <td>" . utf8_decode($registroGrado->getEstudiante()->getNumeroDocumento()) . "</td>
                                                <td>" . utf8_decode($registroGrado->getActaAcuerdo()->getFechaGrado()->getCarrera()->getNombreCarrera()) . "</td>
                                                <td>" . utf8_decode($registroGrado->getActaAcuerdo()->getFechaGrado()->getCarrera()->getTituloProfesion()->getNombreTitulo()) . "</td>
                                                <td>" . $registroGrado->getNumeroDiploma() . "</td>
                                                <td>" . $folioTemporal->getNumeroFolio() . "</td>
                                        </tr>";
                }

                $html .= "</tbody>
			</table>
		    	<br />
                        </div>";
            }
        }


        $filename = "reporte.pdf";

        $dompdf = new DOMPDF();
        $dompdf->set_paper("letter", "landscape");
        $dompdf->load_html($html); //cargamos el html
        $dompdf->render(); //renderizamos
        $dompdf->stream($filename, array("Attachment" => false));

        break;

    case "generarExportarAF":

        $controlEstudiante = new ControlEstudiante($persistencia);
        $controlIncentivoAcademico = new ControlIncentivoAcademico($persistencia);
        $tipoGrado = "";
        $txtCodigoEstudiantes = unserialize(stripslashes($_POST["txtCodigoEstudiantes"]));

        $html = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Documento sin titulo</title>
		<style type="text/css">
		body{
			font-family: Arial Black, Gadget, sans-serif;
			font-size: 12pt;
			margin-left: 1cm;
                        margin-top: 1cm;
                        margin-right: 1cm;
                        margin-bottom: 1cm; 
		}
		@page { margin: 120px 50px; }
		#header { position: fixed; left: 0px; top: -110px; right: 0px; text-align: center; }
		#footer { position: fixed; left: 0px; bottom: -120px; right: 0px; height: 90px; }
		#footer .page:after { content: counter(page, upper-roman); }
		</style>
		</head>
		<body>';
        $carrera = $controlCarrera->buscarCarrera($txtCodigoCarrera);

        if ($txtTipoGrado == 1) {
            $tipoGrado = "CEREMONIA";
        } else {
            $tipoGrado = "SECRETARIA";
        }

        $fecha = fechaActual();

        $mes = mes($fecha);
        $dia = date("j", fecha($fecha));
        $anio = "20" . date("y", fecha($fecha));

        if (strlen($dia) == 1) {
            $dia = "0" . $dia;
        }

        $html .= '
                <div id="header">
                    <p ><img src="../css/images/encabezadoBosque.jpg" width="100%"/></p>
                </div>
                <div align="right" id="footer">
                        <p ><img width="400" height="52" src="../css/images/piePagina.jpg" /></p>   
                </div>
		<div id="content" align="center">
		    <p align="right">Bogot&aacute; ' . $diaActual . ' de ' . $mesActual . ' de ' . $anioActual . '</p>
		    <p align="justify">Señores<br /><strong>CONSEJO DE FACULTAD</strong><br />' . pasarMayusculas($carrera->getNombreCortoCarrera()) . '<br /><strong>UNIVERSIDAD EL BOSQUE</strong><br />
			Bogot&aacute;</p>
                    <p align="justify" style="font-size: 11pt;"><strong>ASUNTO: ESTUDIANTES CANDIDATOS A GRADO</strong></p>
                    <p align="justify">Los siguientes estudiantes, han cumplido con el 100% de los requisitos de grado:</p>
		    <p align="center"><strong>POSTULADOS A GRADO EN ' . $tipoGrado . '</strong></p>
		    <p align="center">' . pasarMayusculas($carrera->getNombreCarrera()) . '</p>
                    <table width="100%" border="1" cellpadding="0" cellspacing="0" style="font-size: 10pt;"  >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Estudiante</th>
                                <th>Documento de Identificaci&oacute;n</th>
                                <th>Expedido</th>
                            </tr>
                        </thead>
			<tbody>';
        $i = 1;
        $cantidadIncentivos = 0;
        foreach ($txtCodigoEstudiantes as $txtCodigoEstudiante) {

            $acuerdo = $controlActaAcuerdo->buscarDetalleActaAcuerdoId($txtCodigoEstudiante, $txtFechaGrado, $txtCodigoCarrera);

            if ($acuerdo->getIdActaAcuerdo() == "") {
                $estudiante = $controlEstudiante->buscarEstudiante($txtCodigoEstudiante);
                $nombreEstudiante = $estudiante->getNombreEstudiante() . " " . $estudiante->getApellidoEstudiante();

                $incentivos = $controlIncentivoAcademico->VerIncentivoEstudiantes($txtCodigoEstudiante, $txtCodigoCarrera);

                foreach ($incentivos as $verIncentivos) {
                    $tipoIncentivo = $verIncentivos->getNombreIncentivo();

                    if ($tipoIncentivo != "") {
                        $cantidadIncentivos = $cantidadIncentivos + 1;
                    }
                }

                $html .= '	 
                                        <tr>
                                            <td>' . $i++ . '</td>
                                            <td>' . $nombreEstudiante . '</td>
                                            <td>' . $estudiante->getNumeroDocumento() . '</td>
                                            <td>' . pasarMayusculas($estudiante->getExpedicion()) . '</td>
                                        </tr>';
            }
        }
        $html .= '</tbody> 
		    </table>';

        if ($cantidadIncentivos > 0) {

            $html .= '<br />
                        <p align="center">ESTUDIANTES CANDIDATOS A GRADO CON INCENTIVOS</p>
			<table width="100%" border="1" cellpadding="0" cellspacing="0" style="font-size: 10pt;"  >
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Estudiante</th>
                                    <th>Documento de Identificaci&oacute;n</th>
                                    <th>Tipo Incentivo</th>
                                    <th>Descripci&oacute;n</th>
                                </tr>
                            </thead>
                            <tbody>';
            $i = 1;
            $cargaIncentivos = "";
            foreach ($txtCodigoEstudiantes as $txtCodigoEstudiante) {

                $acuerdo = $controlActaAcuerdo->buscarDetalleActaAcuerdoId($txtCodigoEstudiante, $txtFechaGrado, $txtCodigoCarrera);

                if ($acuerdo->getIdActaAcuerdo() == "") {
                    $estudiante = $controlEstudiante->buscarEstudiante($txtCodigoEstudiante);
                    $nombreEstudiante = $estudiante->getNombreEstudiante() . " " . $estudiante->getApellidoEstudiante();

                    $incentivos = $controlIncentivoAcademico->VerIncentivoEstudiantes($txtCodigoEstudiante, $txtCodigoCarrera);

                    foreach ($incentivos as $verIncentivos) {
                        $tipoIncentivo = $verIncentivos->getNombreIncentivo();
                        $observacion = $verIncentivos->getObservacionIncentivo();

                        $html .= '	 
                                                <tr>
                                                    <td>' . $i++ . '</td>
                                                    <td>' . $nombreEstudiante . '</td>
                                                    <td>' . $estudiante->getNumeroDocumento() . '</td>
                                                    <td>' . $tipoIncentivo . '</td>
                                                    <td>' . $observacion . '</td>							 	
                                                </tr>';
                    }
                }
            }
            $html .= '</tbody>
                        </table>';
        }

        $html .= '<br /><p align="justify">Muy respetuosamente, le solicito presentarla al pr&oacute;ximo Consejo de Facultad para grado ' . strtolower($tipoGrado) . ', habiendo cumplido con todos los requisitos acad&eacute;micos, administrativos y financieros del Reglamento Estudiantil.</p>
		<br />
		</div>
		<p style="page-break-before: always;"></p>';
        $html .= '</body>
                </html>';


        $filename = "exportar.pdf";

        $dompdf = new DOMPDF();
        $dompdf->set_paper("letter", "portrait");
        $dompdf->load_html($html); //cargamos el html
        $dompdf->render(); //renderizamos
        $dompdf->stream($filename);

        break;

    case "generarCartaEntidades":

        /**
         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Se cambia la libreria DOMPDF por Html2pdf para que permita hacer la paginacion.
         * Y se hacen los demas ajustes de Cambiar Fecha Grado, por Fecha Ceremonia, en el caso de grados por ceremonia, 
         * en Fecha de Aprobación, adicionarle (Grado). Y dejar un enunciado general para varias carreras de una facultad determinada, 
         * con el nombre de la institucion a la cual vaya dirigido el informe y paginacion solicitados en el Req:4 por el area de diplomas. 
         * @since Marzo 11, 2019
         */
        require_once("../lib/html2pdf/html2pdf.class.php");

        $nombres = strtoupper($_REQUEST['nombres']);
        $apellidos = strtoupper($_REQUEST['apellidos']);
        $cargo = $_REQUEST['cargo'];
        $entidad = $_REQUEST['entidad'];
        $controlRegistroGrado = new ControlRegistroGrado($persistencia);
        $carrera = new ControlCarrera($persistencia);

        $filtro = "";

        if ($txtCartaCarrera == 'pregrados') {

            $filtro .= " AND C.codigomodalidadacademica = 200";
        } else if ($txtCartaCarrera == 'posgrados') {

            $filtro .= " AND C.codigomodalidadacademica = 300";
        } else if ($txtCartaCarrera == 123 or $txtCartaCarrera == 124) {

            $filtro .= " AND C.codigocarrera in( 123 , 124 ) ";
        } else if ($txtCartaCarrera == 118 or $txtCartaCarrera == 119) {

            $filtro .= " AND C.codigocarrera in( 118 , 119 ) ";
        } else if ($txtCartaCarrera == 133 or $txtCartaCarrera == 134 or $txtCartaCarrera == 143) {

            $filtro .= " AND C.codigocarrera in( 133 , 134 , 143 ) ";
        } else {

            $filtro .= " AND C.codigocarrera = " . $txtCartaCarrera;
        }


        $filtro .= " AND FT.codigofacultad = " . $txtCartaFacultad . "";
        $filtro .= " AND F.CodigoPeriodo = " . $txtCartaPeriodo . "";
        $filtro .= " AND F.TipoGradoId = " . $TxtCartaTipoGrado . "";

        if (isset($cbmEgresados)) {

            if ($cbmEgresados == 'todos') {
                
            } else {

                $filtro .= " AND R.RegistroGradoId = " . $cbmEgresados;
            }
        }

        $fechaGrado = "";
        $acta = "";
        $acuerdo = "";
        $fechaAprobacion = "";
        $html = '
                <page backtop="40mm" backbottom="30mm" backleft="20mm" backright="25mm" >
                <page_header>
                    <div></div>
                </page_header>
                <page_footer>
                    <div>
                    <table style="width: 100%;">
                        <tr>
                            <td style="text-align: right; width: 50%;"></td>
                            <td style="text-align: right; width: 40%;"><font style="text-align: right; font-weight: bold; font-size:8px;">' . $entidad . '<br>Pagina [[page_cu]] de [[page_nb]]<br><br><br><br><br><br><br><br><br><br><br></font></td>
                            <td style="text-align: right; width: 10%;"></td>
                        </tr>
                    </table>
                    </div>
                </page_footer>
		Bogot&aacute;, D.C.,' . $mesActual . ' ' . $diaActual . ' de ' . $anioActual;
        $html .= '<br><br><br><br>Doctor(a)<br/>' . $nombres . ' ' . $apellidos . '<br/>' . $cargo . '<br/>' . $entidad . '<br/>' . 'Ciudad<br><br><br>';
        $html .= 'Ref: Informe de Registro de T&iacute;tulos.<br><br><br>';
        $html .= 'Respetado(a) doctor(a) ' . $apellidos . ':<br><br>';

        $html .= '<p align="justify"> De manera atenta me permito certificar que las personas relacionadas a continuaci&oacute;n, cursaron y aprobaron sus estudios ';
        $html .= ' y obtuvieron el respectivo t&iacute;tulo ';
        $html .= ' en esta institucion, conforme a la siguiente informaci&oacute;n:</p><br><br>';

        if ($txtCartaCarrera != "pregrados" && $txtCartaCarrera != "posgrados") {

            $consultaActas = $controlRegistroGrado->consultarActaAcuerdos($filtro);
            $nombreCarrera = $carrera->buscarCarrera($txtCartaCarrera);
            $tituloCarrera = $carrera->buscarTituloProfesion($txtCartaCarrera);
            foreach ($consultaActas as $detalleConsulta) {

                $html .= 'UNIVERSDAD EL BOSQUE  Codigo Snies: 1729<br/>';

                $snies = $controlCarrera->Snies($txtCartaCarrera);

                $html .= 'Programa: ' . $nombreCarrera->getNombreCortoCarrera() . ' Codigo Snies: ' . $snies->getCodigoCarrera() . '<br/>';
                $html .= 'Titulo: ' . $tituloCarrera->getTituloProfesion()->getNombreTitulo() . '<br/>';

                $filtroActa = "";
                $fechaGrado = substr($detalleConsulta->getActaAcuerdo()->getFechaGrado()->getFechaGraduacion(), 0, 10);
                $fechaGradoId = substr($detalleConsulta->getActaAcuerdo()->getFechaGrado()->getIdFechaGrado(), 0, 10);

                $acta = $detalleConsulta->getActaAcuerdo()->getNumeroActaConsejoDirectivo();
                $acuerdo = $detalleConsulta->getActaAcuerdo()->getNumeroAcuerdo();

                $fechaAprobacion = substr($detalleConsulta->getActaAcuerdo()->getFechaAcuerdo(), 0, 10);

                $filtroActa .= " AND A.NumeroActaAcuerdo = " . $acta . "";
                $filtroActa .= " AND A.NumeroAcuerdo = " . $acuerdo . "";
                $filtroActa .= " AND A.FechaAcuerdo = '" . $detalleConsulta->getActaAcuerdo()->getFechaAcuerdo() . "'";
                $filtros = $filtroActa . $filtro;

                $detalleActas = $controlRegistroGrado->detalleConsultarActaAcuerdos($filtros);

                if ($TxtCartaTipoGrado == 2) {
                    $fechaGrado = $fechaAprobacion;
                    $gradcer = 'Grado';
                } else {
                    $gradcer = 'Ceremonia';
                }

                $html .= '<table style="width: 100%;" border="1" cellspacing="0" cellpadding="0">
                                <tr align="center" >
                                    <td style="width: 30%;">Fecha ' . $gradcer . ':<br>' . fechas(strtotime($fechaGrado)) . '</td>
                                    <td style="width: 20%;">Acta:<br>' . $acta . '</td>
                                    <td style="width: 20%;">Acuerdo:<br>' . $acuerdo . '</td>
                                    <td style="width: 30%;">Fecha de Aprobaci&oacute;n<br>(Grado):<br>' . fechas(strtotime($fechaAprobacion)) . '</td>
                                </tr>
                            </table><br>';

                $html .= '<table style="width: 100%;" border="1" cellspacing="0" cellpadding="0">
                            <tr align="center">
                                    <td style="width: 7.5%;">N°</td>
                                    <td style="width: 7.5%;">Reg</td>
                                    <td style="width: 32.5%;">Apellidos Nombres</td>
                                    <td style="width: 18%;">Documento de<br>Identidad</td>
                                    <td style="width: 17%;">Lugar de<br>Expedici&oacute;n</td>
                                    <td style="width: 10%;">No.<br>Diploma</td>
                                    <td style="width: 7.5%;">Folio</td>
                            </tr>';
                $contador = 1;
                foreach ($detalleActas as $detalleActa) {

                    $numeroRegistro = $detalleActa->getIdRegistroGrado();
                    $nombreCompleto = $detalleActa->getEstudiante()->getNombreEstudiante() . ' ' . $detalleActa->getEstudiante()->getApellidoEstudiante();
                    $numeroDocumento = $detalleActa->getEstudiante()->getNumeroDocumento();
                    $expedido = $detalleActa->getEstudiante()->getExpedicion();
                    $diploma = $detalleActa->getNumeroDiploma();
                    $folio = $detalleActa->getFolio();

                    $html .= '<tr>
                                            <td align="center">' . $contador . '</td>
                                            <td align="center">' . $numeroRegistro . '</td>
                                            <td>' . wordwrap($nombreCompleto, 22, "<br>", TRUE) . '</td>
                                            <td align="center">' . $numeroDocumento . '</td>
                                            <td align="center">' . wordwrap($expedido, 13, "<br>", TRUE) . '</td>
                                            <td align="center">' . $diploma . '</td>
                                            <td align="center">' . $folio . '</td>
                                        </tr>';
                    $contador++;
                }

                $html .= '</table><br><br>';
            }
        } else {

            $consultarCarreras = $controlRegistroGrado->consultarCarrerasActaAcuerdos($filtro);

            foreach ($consultarCarreras as $carreras) {
                $txtCartaCarrera = $carreras->getActaAcuerdo()->getFechaGrado()->getCarrera()->getCodigoCarrera();
                $filtro = "";

                if ($txtCartaCarrera == 123 or $txtCartaCarrera == 124) {

                    $filtro .= " AND C.codigocarrera in( 123 , 124 ) ";
                } else if ($txtCartaCarrera == 118 or $txtCartaCarrera == 119) {

                    $filtro .= " AND C.codigocarrera in( 118 , 119 ) ";
                } else {

                    $filtro .= " AND C.codigocarrera = " . $txtCartaCarrera;
                }

                $filtro .= " AND FT.codigofacultad = " . $txtCartaFacultad . "";
                $filtro .= " AND F.CodigoPeriodo = " . $txtCartaPeriodo . "";
                $filtro .= " AND F.TipoGradoId = " . $TxtCartaTipoGrado . "";


                $consultaActas = $controlRegistroGrado->consultarActaAcuerdos($filtro);
                $nombreCarrera = $carrera->buscarCarrera($txtCartaCarrera);
                $tituloCarrera = $carrera->buscarTituloProfesion($txtCartaCarrera);



                foreach ($consultaActas as $detalleConsulta) {
                    $html .= 'UNIVERSDAD EL BOSQUE Codigo Snies: 1729<br/>';

                    $snies = $controlCarrera->Snies($txtCartaCarrera);

                    $html .= 'Programa: ' . $nombreCarrera->getNombreCortoCarrera() . ' Codigo Snies: ' . $snies->getCodigoCarrera() . '<br/>';
                    $html .= 'Titulo: ' . $tituloCarrera->getTituloProfesion()->getNombreTitulo() . '<br/>';

                    $filtroActa = "";
                    $fechaGrado = substr($detalleConsulta->getActaAcuerdo()->getFechaGrado()->getFechaGraduacion(), 0, 10);
                    $fechaGradoId = substr($detalleConsulta->getActaAcuerdo()->getFechaGrado()->getIdFechaGrado(), 0, 10);

                    $acta = $detalleConsulta->getActaAcuerdo()->getNumeroActaConsejoDirectivo();
                    $acuerdo = $detalleConsulta->getActaAcuerdo()->getNumeroAcuerdo();
                    $fechaAprobacion = substr($detalleConsulta->getActaAcuerdo()->getFechaAcuerdo(), 0, 10);

                    $filtroActa .= " AND A.NumeroActaAcuerdo = " . $acta . "";
                    $filtroActa .= " AND A.NumeroAcuerdo = " . $acuerdo . "";
                    $filtroActa .= " AND A.FechaAcuerdo = '" . $detalleConsulta->getActaAcuerdo()->getFechaAcuerdo() . "'";
                    $filtros = $filtroActa . $filtro;

                    $detalleActas = $controlRegistroGrado->detalleConsultarActaAcuerdos($filtros);
                    if ($TxtCartaTipoGrado == 2) {
                        $fechaGrado = $fechaAprobacion;
                        $gradcer = 'Grado';
                    } else {
                        $gradcer = 'Ceremonia';
                    }

                    $html .= '<table style="width: 100%;" border="1" cellspacing="0" cellpadding="0">
                                <tr align="center" >
                                        <td style="width: 30%;">Fecha ' . $gradcer . ':<br>' . fechas(strtotime($fechaGrado)) . '</td>
                                        <td style="width: 20%;">Acta:<br>' . $acta . '</td>
                                        <td style="width: 20%;">Acuerdo:<br>' . $acuerdo . '</td>
                                        <td style="width: 30%;">Fecha de Aprobaci&oacute;n<br>(Grado):<br>' . fechas(strtotime($fechaAprobacion)) . '</td>
                                </tr>
                            </table><br>';

                    $html .= '<table style="width: 100%;" border="1" cellspacing="0" cellpadding="0">
                                <tr align="center">
                                        <td style="width: 7.5%;">Reg</td>
                                        <td style="width: 38%;">Apellidos Nombres</td>
                                        <td style="width: 20%;">Documento de<br>Identidad</td>
                                        <td style="width: 17%;">Lugar de<br>Expedici&oacute;n</td>
                                        <td style="width: 10%;">No.<br>Diploma</td>
                                        <td style="width: 7.5%;">Folio</td>
                                </tr>';
                    foreach ($detalleActas as $detalleActa) {

                        $numeroRegistro = $detalleActa->getIdRegistroGrado();
                        $nombreCompleto = $detalleActa->getEstudiante()->getNombreEstudiante() . ' ' . $detalleActa->getEstudiante()->getApellidoEstudiante();
                        $numeroDocumento = $detalleActa->getEstudiante()->getNumeroDocumento();
                        $expedido = $detalleActa->getEstudiante()->getExpedicion();
                        $diploma = $detalleActa->getNumeroDiploma();
                        $folio = $detalleActa->getFolio();

                        $html .= '<tr>
                                                <td align="center">' . $numeroRegistro . '</td>
                                                <td>' . wordwrap($nombreCompleto, 22, "<br>", TRUE) . '</td>
                                                <td align="center">' . $numeroDocumento . '</td>
                                                <td align="center">' . wordwrap($expedido, 13, "<br>", TRUE) . '</td>
                                                <td align="center">' . $diploma . '</td>
                                                <td align="center">' . $folio . '</td>
                                            </tr>';
                    }
                    $html .= '</table><br><br>';
                }
            }
        }

        $html .= 'Cualquier informaci&oacute;n adicional sobre el particular, con gusto le ser&aacute; suministrada, si asi se requiere<br><br>Atentamente,<br><br><br><br><br><br>';
        $html .= 'CRISTINA MATIZ MEJ&Iacute;A<br>Secretaria General<br><br>';
        $html .= '</page>';
        $filename = "carta.pdf";
        $html2pdf = new HTML2PDF('P', 'letter', 'es'); // L,A4,fr,true,'ISO-8859-1'
        $html2pdf->WriteHTML($html);
        $html2pdf->Output($filename, 'D');

        break;
}
                ?>