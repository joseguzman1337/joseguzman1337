<?php

header('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once("../../../kint/Kint.class.php");
require_once("../../../sala/assets/plugins/fpdf182/fpdf.php");
require_once('../../../sala/assets/plugins/fpdf182/cellfit.php');

require_once '../lib/pdf/dompdf/dompdf_config.inc.php';

include '../tools/includes.php';

include '../lib/radicacion/numtoletras.php';
include '../lib/radicacion/numtoordinal.php';

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
include '../control/ControlRegistroGrado.php';
include '../control/ControlDeudaPeople.php';
include '../control/ControlEstudianteDocumento.php';
include '../control/ControlDocumentoPeople.php';
include '../control/ControlGeneroPeople.php';
include '../control/ControlLocalidad.php';
include '../control/ControlFolioTemporal.php';

function unserializeForm($str) {
    $strArray = explode("&", $str);
    foreach ($strArray as $item) {
        $array = explode("=", $item);
        $returndata[] = $array[1];
    }
    return $returndata;
}

function pasarMayusculas($cadena) {
    $cadena = strtoupper($cadena);
    $cadena = str_replace("á", "Á", $cadena);
    $cadena = str_replace("é", "É", $cadena);
    $cadena = str_replace("í", "Í", $cadena);
    $cadena = str_replace("ó", "Ó", $cadena);
    $cadena = str_replace("ú", "Ú", $cadena);
    $cadena = str_replace("ñ", "Ñ", $cadena);
    return ($cadena);
}

function convertirBogota($cadena) {
    $cadena = str_replace("d.c", "D.C", $cadena);
    $cadena = str_replace("d.c.", "D.C.", $cadena);
    $cadena = str_replace("Bogota", "Bogotá", $cadena);
    $cadena = str_replace("bogota", "Bogotá", $cadena);
    $cadena = str_replace("dc", "D.C.", $cadena);
    $cadena = str_replace("Santafe", "Santafé", $cadena);
    $cadena = str_replace("Ingenieria", "Ingeniería", $cadena);
    $cadena = str_replace("Administracion", "Administración", $cadena);
    $cadena = str_replace("Educacion", "Educación", $cadena);
    $cadena = str_replace("Ingles", "Inglés", $cadena);
    $cadena = str_replace("Enfasis", "Énfasis", $cadena);
    $cadena = str_replace("Enfermeria", "Enfermería", $cadena);
    $cadena = str_replace("Quirurgica", "Quirúrgica", $cadena);
    $cadena = str_replace("Instrumentacion", "Instrumentación", $cadena);
    $cadena = str_replace("Biologia", "Biología", $cadena);
    $cadena = str_replace("Psicologia", "Psicología", $cadena);
    $cadena = str_replace("Plasticas", "Plásticas", $cadena);
    $cadena = str_replace("Formacion", "Formación", $cadena);
    $cadena = str_replace("énfasis", "Énfasis", $cadena);
    $cadena = str_replace("DRAMATICO", "DRAMÁTICO", $cadena);
    $cadena = str_replace("PLASTICAS", "PLÁSTICAS", $cadena);
    $cadena = str_replace("FORMACION", "FORMACIÓN", $cadena);
    $cadena = str_replace("Maestria", "Maestría", $cadena);
    $cadena = str_replace("Publica", "Pública", $cadena);
    $cadena = str_replace("Gestion", "Gestión", $cadena);
    $cadena = str_replace("Bioetica", "Bioética", $cadena);
    $cadena = str_replace("Epidemiologia", "Epidemiología", $cadena);
    $cadena = str_replace("Psiquiatria", "Psiquiatría", $cadena);
    $cadena = str_replace("Basicas", "Básicas", $cadena);
    $cadena = str_replace("Biomedicas", "Biomédicas", $cadena);
    $cadena = str_replace("Republica", "República", $cadena);
    $cadena = str_replace("veintitres", "veintitrés", $cadena);
    $cadena = str_replace("veintiseis", "veintiséis", $cadena);
    return ($cadena);
}

function strtolower_utf8($cadena) {
    $convertir_a = array(
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u",
        "v", "w", "x", "y", "z", "à", "á", "â", "ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë", "ę", "ì", "í", "î", "ï",
        "ð", "ñ", "ò", "ó", "ô", "õ", "ö", "ø", "ù", "ú", "û", "ü", "ý", "а", "б", "в", "г", "д", "е", "ё", "ж",
        "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ы",
        "ь", "э", "ю", "я"
    );
    $convertir_de = array(
        "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U",
        "V", "W", "X", "Y", "Z", "À", "Á", "Â", "Ã", "Ä", "Å", "Æ", "Ç", "È", "É", "Ê", "Ë", "Ę", "Ì", "Í", "Î", "Ï",
        "Ð", "Ñ", "Ò", "Ó", "Ô", "Õ", "Ö", "Ø", "Ù", "Ú", "Û", "Ü", "Ý", "А", "Б", "В", "Г", "Д", "Е", "Ё", "Ж",
        "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ъ", "Ъ",
        "Ь", "Э", "Ю", "Я"
    );
    return str_replace($convertir_de, $convertir_a, $cadena);
}

function capitalizar($nombre) {
    // aca definimos un array de articulos (en minuscula) 
    // aunque lo puedes definir afuera y declararlo global aca 
    $articulos = array(
        '0' => 'a',
        '1' => 'de',
        '2' => 'del',
        '3' => 'la',
        '4' => 'los',
        '5' => 'las',
        '6' => 'con',
        '7' => 'en',
    );

    // explotamos el nombre 
    $palabras = explode(' ', $nombre);

    // creamos la variable que contendra el nombre 
    // formateado 
    $nuevoNombre = '';

    // parseamos cada palabra 
    foreach ($palabras as $elemento) {
        // si la palabra es un articulo 
        if (in_array(trim(strtolower($elemento)), $articulos)) {
            // concatenamos seguido de un espacio 
            $nuevoNombre .= strtolower($elemento) . " ";
        } else {
            // sino, es un nombre propio, por lo tanto aplicamos 
            // las funciones y concatenamos seguido de un espacio 
            $nuevoNombre .= ucfirst(strtolower($elemento)) . " ";
        }
    }

    return trim($nuevoNombre);
}

function capitalizar2($nombre) {
    // aca definimos un array de articulos (en minuscula) 
    // aunque lo puedes definir afuera y declararlo global aca 
    $articulos = array(
        '0' => 'a',
        '1' => 'de',
        '2' => 'del',
        '3' => 'la',
        '4' => 'los',
        '5' => 'las',
        '6' => 'con',
        '7' => 'en',
        '8' => 'desde',
        '9' => 'una',
        '10' => 'y',
    );

    // explotamos el nombre 
    $palabras = explode(' ', $nombre);

    // creamos la variable que contendra el nombre 
    // formateado 
    $nuevoNombre = '';

    // parseamos cada palabra 
    foreach ($palabras as $elemento) {
        // si la palabra es un articulo 
        if (in_array(trim(($elemento)), $articulos)) {
            // concatenamos seguido de un espacio 
            $nuevoNombre .= $elemento . " ";
        } else {
            // sino, es un nombre propio, por lo tanto aplicamos 
            // las funciones y concatenamos seguido de un espacio 
            $nuevoNombre .= ucfirst($elemento) . " ";
        }
    }

    return trim($nuevoNombre);
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
        $mes = "Junio";
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

function DocumentoCedulaCiudadania($nombreDocumento, $numerodocumento, $expedidoDocumento, $pdf) {
    $numeroprimero = substr($numerodocumento, 0, 1);
    if ($numeroprimero == 0) {
        return $pdf -> Cell(0, 0, utf8_decode($nombreDocumento).
            ' No. '.$numerodocumento.
            ' EXPEDIDA EN '.utf8_decode($expedidoDocumento), 0, 2, 'C');

    } else {
        return $pdf -> Cell(0, 0, utf8_decode($nombreDocumento).
            ' No. '.number_format($numerodocumento, 0, '', '.').
            ' EXPEDIDA EN '.utf8_decode($expedidoDocumento), 0, 2, 'C');
    }
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

$controlIncentivo = new ControlIncentivoAcademico($persistencia);
$controlEstudiante = new ControlEstudiante($persistencia);
$controlCarrera = new ControlCarrera($persistencia);
$controlTrabajoGrado = new ControlTrabajoGrado($persistencia);
$controlActaAcuerdo = new ControlActaAcuerdo($persistencia);
$controlRegistroGrado = new ControlRegistroGrado($persistencia);
$controlFolioTemporal = new ControlFolioTemporal($persistencia);

$txtCodigoImprimir = $_POST["ckImprimirDocumentos"];
$numeroactagrado = $_POST['NumeroActaGrado'];

$txtCodigoEstudiantes = unserialize(stripslashes($_POST["txtCodigoEstudiantes"]));

$numeroestudiantes = count($txtCodigoEstudiantes);
$txtCodigoCarrera = $_POST["txtCodigoCarrera"];
$txtFechaGrado = $_POST["txtFechaGrado"];

$actaAcuerdos = $controlActaAcuerdo->consultarActaAcuerdos($txtFechaGrado);

$tituloProfesion = $controlCarrera->buscarTituloProfesion($txtCodigoCarrera);
$carrera = $controlCarrera->buscarCarrera($txtCodigoCarrera);
$nombreCarrera = $carrera->getNombreCarrera();

foreach ($txtCodigoImprimir as $txtCodigoImprimi) {

    switch ($txtCodigoImprimi) {
        //DIPLOMA
        case "1":
        case "9":
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

            foreach ($txtCodigoEstudiantes as $txtCodigoEstudiante) {
                $estudiante = $controlEstudiante->buscarEstudiante($txtCodigoEstudiante);
                $registroGrado = $controlRegistroGrado->buscarRegistroGradoCarreraEstudiante($txtCodigoCarrera, $txtCodigoEstudiante);
                $folioTemporal = $controlFolioTemporal->buscarFolioTemporal($registroGrado->getIdRegistroGrado());
                $anioGrado = date("Y", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo()));
                $diaGrado = date("d", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo()));
                $mesGrado = mes(date("Y-m-d", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo())));
                $pdf->AddPage();

                if ($txtCodigoCarrera == 10) {
                    $pdf->SetFont('TrajanPro', '', 30);
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetY(80);
                    $pdf->SetX(45);
                    $pdf->CellFit(330, 0, utf8_decode("ESCUELA COLOMBIANA DE MEDICINA"), 0, 0, 'C', '', '', true, false);
                }

                $pdf->SetFont('TrajanPro', '', 50);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetY(115);
                $pdf->SetX(45);
                $apellido = str_replace("´", "'", $estudiante->getApellidoEstudiante());

                $pdf->CellFit(330, 0, utf8_decode($estudiante->getNombreEstudiante() . " " . $apellido), 0, 0, 'C', '', '', true, false);
                $pdf->SetFont('Humanst521BTRoman', '', 12);
                $pdf->SetY(127);
                $search = array('á', 'é', 'í', 'ó', 'ú');
                $replace = array('Á', 'É', 'Í', 'Ó', 'Ú');
                $nombreDocumento = pasarMayusculas($estudiante->getTipoDocumento()->getNombreDocumento());
                $expedidoDocumento = pasarMayusculas($estudiante->getExpedicion());

                if ($estudiante->getTipoDocumento()->getIniciales() == "05") {
                    $pdf->Cell(0, 0, utf8_decode($nombreDocumento) . ' No. ' . $estudiante->getNumeroDocumento() . ' EXPEDIDO EN ' . utf8_decode($expedidoDocumento), 0, 2, 'C');
                } else {
                    if ($estudiante->getTipoDocumento()->getIniciales() == "03") {
                        $pdf->Cell(0, 0, utf8_decode($nombreDocumento) . ' No. ' . $estudiante->getNumeroDocumento() . ' EXPEDIDA EN ' . utf8_decode($expedidoDocumento), 0, 2, 'C');
                    } else {
                        DocumentoCedulaCiudadania($nombreDocumento,$estudiante->getNumeroDocumento() ,$expedidoDocumento,$pdf);
                    }
                }

                $pdf->SetFont('TrajanPro', '', 50);
                $pdf->SetY(177);
                $pdf->SetX(30);
                
                if ($estudiante->getGenero()->getCodigo() == 100) {
                    $pdf->CellFit(360, 0, utf8_decode($tituloProfesion->getTituloProfesion()->getNombreTituloGenero()), 0, 0, 'C', '', '', true, false);
                }
                else {
                    $pdf->CellFit(360, 0, utf8_decode($tituloProfesion->getTituloProfesion()->getNombreTitulo()), 0, 0, 'C', '', '', true, false);
                }

                $pdf->SetFont('Humanst521BTRoman', '', 12);
                $pdf->SetY(197);
                $pdf->Cell(0, 0, str_replace($search, $replace, strtoupper(utf8_decode('DADO EN BOGOTÁ D.C., REPÚBLICA DE COLOMBIA, EL DÍA'))) . ' ' . $diaGrado . ' DE ' . strtoupper($mesGrado) . ' DE ' . $anioGrado . ' ', 0, 2, 'C');
                

            if($txtCodigoImprimi == 1){

                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(227);
                $pdf->SetX(45);
                $pdf->Cell(0, 0, 'RECTORA', 0, 0, 'L');
                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(227);
                $pdf->SetX(157);
                
                if ($carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 200 || $carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 800) {
                    /**
                     * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
                     * Se Mdifica PRESIDENTE por PRESIDENTA Req Aranda 934
                     * @since Abril 9, 2019
                     */ 
                    $pdf->Cell(0, 0, 'PRESIDENTA DE EL CLAUSTRO', 0, 0, 'L');
                } else if ($carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 300 || $carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 600) {
                    $pdf->Cell(0, 0, 'DIRECTOR DE POSTGRADOS', 0, 0, 'L');
                }
            
                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(227);
                $pdf->SetX(294);
                $pdf->Cell(0, 0, 'PRESIDENTE DE El CONSEJO DIRECTIVO', 0, 0, 'L');

                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(254);
                if ($carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 200 || $carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 800) {
                    $pdf->SetX(107);
                    $pdf->Cell(0, 0, 'DECANO', 0, 0, 'L');
                } else if ($carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 300 || $carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 600) {
                    $pdf->SetX(82);
                    $pdf->Cell(0, 0, 'DIRECTOR DEL PROGRAMA', 0, 0, 'L');
                }
                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(254);
                $pdf->SetX(231);
                $pdf->Cell(0, 0, 'SECRETARIA GENERAL', 0, 0, 'L');

            }else{
                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(227);
                $pdf->SetX(125);
                $pdf->Cell(0, 0, 'RECTORA', 0, 0, 'L');
                $pdf->SetFont('TrajanPro', '', 12);
            
                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(227);
                $pdf->SetX(270);
                $pdf->Cell(0, 0, 'PRESIDENTE DE El CONSEJO DIRECTIVO', 0, 0, 'L');

                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(254);
                if ($carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 200 || $carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 800) {
                    $pdf->SetX(65);
                    $pdf->Cell(0, 0, 'DECANO', 0, 0, 'L');
                } else if ($carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 300 || $carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 600) {
                    $pdf->SetX(31);
                    $pdf->Cell(0, 0, 'DIRECTOR DE POSTGRADOS', 0, 0, 'L');
                }
                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(254);
                $pdf->SetX(190);
                $pdf->Cell(0, 0, 'SECRETARIA GENERAL', 0, 0, 'L');
            }

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
            }
            ob_end_clean();
            $pdf->Output();
            break;
        //ACTA DE GRADO
        case "2":

            $html = '';
            $html .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Documento sin título</title>
						<style type="text/css">
							body {
								font-family: "Times New Roman", Georgia, Serif;
								font-size: 12pt;
								margin-left: 1.4cm;
								margin-top: 1.2cm;
								margin-right: 1.4cm;
							}
						</style>
						</head>
						<body>';
            foreach ($txtCodigoEstudiantes as $txtCodigoEstudiante) {

                $estudiante = $controlEstudiante->buscarEstudiante($txtCodigoEstudiante);

                $registroGradoEstudiante = $controlRegistroGrado->buscarRegistroGradoCarreraEstudiante($txtCodigoCarrera, $txtCodigoEstudiante);

                $txtIdTipoGrado = $registroGradoEstudiante->getActaAcuerdo()->getFechaGrado()->getTipoGrado()->getIdTipoGrado();
                
                if ($estudiante->getGenero()->getCodigo() == 100) {
                    $profesion = $tituloProfesion->getTituloProfesion()->getNombreTituloGenero();
                } else {
                    $profesion = $tituloProfesion->getTituloProfesion()->getNombreTitulo();
                }

                $anioAcuerdo = date("Y", strtotime($registroGradoEstudiante->getActaAcuerdo()->getFechaAcuerdo()));
                $diaAcuerdo = date("d", strtotime($registroGradoEstudiante->getActaAcuerdo()->getFechaAcuerdo()));
                $mes = mes(date("Y-m-d", strtotime($registroGradoEstudiante->getActaAcuerdo()->getFechaAcuerdo())));
                $anioGraduacion = date("Y", strtotime($registroGradoEstudiante->getActaAcuerdo()->getFechaGrado()->getFechaGraduacion()));
                $diaGraduacion = date("d", strtotime($registroGradoEstudiante->getActaAcuerdo()->getFechaGrado()->getFechaGraduacion()));
                $mesGraduacion = mes(date("Y-m-d", strtotime($registroGradoEstudiante->getActaAcuerdo()->getFechaGrado()->getFechaGraduacion())));

                $txtIdActa = $registroGradoEstudiante->getActaAcuerdo()->getIdActaAcuerdo();

                $registroGrado = $controlRegistroGrado->buscarRegistroGradoId($txtCodigoEstudiante, $txtIdActa);

                $folioTemporal = $controlFolioTemporal->buscarFolioTemporal($registroGrado->getIdRegistroGrado());

                $txtCodigoModalidadAcademicaSic = $registroGradoEstudiante->getActaAcuerdo()->getFechaGrado()->getCarrera()->getModalidadAcademicaSic()->getCodigoModalidadAcademicaSic();

                $html .= '
                        <div align="center">
                        <br />';
                if ($txtCodigoModalidadAcademicaSic != 301) {
                    $html .= '<br />';
                }
                
                $html .= '<p align="center">';
                if ($txtCodigoCarrera == 10) {
                    $html .= '<br/>ESCUELA COLOMBIANA DE MEDICINA';
                }
                $html .= '</p>      
                            <br />
                            <br />
                            <p align="center"><strong>ACTA DE GRADO</strong></p>  <br />
                            <p align="justify">El Consejo Directivo de la Universidad El Bosque, en su sesión del día ' . $diaAcuerdo . ' de ' . strtolower($mes) . ' del año ' . $anioAcuerdo . ', según consta en el Acta No. ' . $registroGradoEstudiante->getActaAcuerdo()->getNumeroActaConsejoDirectivo() . ' y Acuerdo No. ' . $registroGradoEstudiante->getActaAcuerdo()->getNumeroAcuerdo() . ' de la misma fecha, estudió y aprobó la solicitud del aspirante a grado, alumno (a)</p>
                            <br />
                            <br />
                          <p align="center"><strong>' . pasarMayusculas($estudiante->getNombreEstudiante() . " " . str_replace("´", "'", $estudiante->getApellidoEstudiante())) . '<br />';
                if ($estudiante->getTipoDocumento()->getIniciales() == "05") {
                    $html .= '' . $estudiante->getTipoDocumento()->getNombreDocumento() . ' No. ' . $estudiante->getNumeroDocumento() . ' de ' . convertirBogota(capitalizar2(strtolower_utf8($estudiante->getExpedicion()))) . '</strong></p>';
                } else {
                    if ($estudiante->getTipoDocumento()->getIniciales() == "03") {
                        $html .= '' . substr($estudiante->getTipoDocumento()->getDescripcion(), 0, 1) . '.' . substr($estudiante->getTipoDocumento()->getDescripcion(), 1, 1) . '. No. ' . $estudiante->getNumeroDocumento() . ' DE ' . pasarMayusculas($estudiante->getExpedicion()) . '</strong></p>';
                    } else {
                        $numeroprimero = substr($estudiante->getNumeroDocumento(), 0,1); 
                        if($numeroprimero == 0){
                            $html .= '' . substr($estudiante->getTipoDocumento()->getDescripcion(), 0, 1) . '.' . substr($estudiante->getTipoDocumento()->getDescripcion(), 1, 1) . '. No. ' . $estudiante->getNumeroDocumento() . ' DE ' . pasarMayusculas($estudiante->getExpedicion()) . '</strong></p>';    
                        }else{
                            $html .= '' . substr($estudiante->getTipoDocumento()->getDescripcion(), 0, 1) . '.' . substr($estudiante->getTipoDocumento()->getDescripcion(), 1, 1) . '. No. ' . number_format($estudiante->getNumeroDocumento(), 0, '', '.') . ' DE ' . pasarMayusculas($estudiante->getExpedicion()) . '</strong></p>';    
                        }
                    }
                }
                $html .= '<br />
									    <p align="justify">';
                if ($txtCodigoModalidadAcademicaSic == 301) {
                    $html .= 'del programa de ' . convertirBogota(capitalizar2(strtolower_utf8($registroGradoEstudiante->getActaAcuerdo()->getFechaGrado()->getCarrera()->getNombreCortoCarrera()))) . ', ';
                }
                $html .= 'quien cumplió satisfactoriamente con todos los requisitos académicos y legales exigidos por la Institución, motivo por el cual autorizó se le otorgue el título de:</p>
                          <br />
                          <p align="center"><strong>' . pasarMayusculas($profesion) . '</strong></p>
									    ';
                if ($txtCodigoModalidadAcademicaSic == 301) {
                    $incentivo = $controlIncentivo->buscarIncentivoEstudiante($txtCodigoEstudiante, $txtCodigoCarrera);
                    if ($incentivo->getIdIncentivo() != "") {
                        $txtCodigoIncentivo = $incentivo->getCodigoIncentivo();
                        $mencion = $controlIncentivo->buscarIncentivoId($txtCodigoIncentivo);
                        $trabajoGrado = $controlTrabajoGrado->buscarTGradoEstudiante($txtCodigoEstudiante);
                        if ($estudiante->getGenero()->getCodigo() == 200) {
                            $tratoEstudiante = "lo hizo merecedor";
                        } else {
                            $tratoEstudiante = "la hizo merecedora";
                        }

                        $html .= '<p align="justify">El graduando, para optar al título de magíster, presento y aprobó el trabajo de investigación denominado "<strong>' . pasarMayusculas($trabajoGrado->getNombreTrabajoGrado()) . '</strong>", el cuál ' . $tratoEstudiante . ' de la ' . $mencion->getNombreIncentivo() . '.</p>';
                    } else {
                        $html .= '<br />';
                    }
                } else {
                    $html .= '<br />';
                }


                $diaActual = date("d");
                $mesActual = mes(date("Y-m-d"));
                $anioActual = date("Y");


                if ($txtIdTipoGrado == 2) {
                    
                    $html .= '<p align="justify">En la Secretaría General de la Universidad, se le hace entrega del diploma No. ' . $registroGrado->getNumeroDiploma() . ', el cual aparece registrado con el No. ' . $registroGrado->getIdRegistroGrado() . ', al folio ' . $folioTemporal->getNumeroFolio() . ' del libro de registro de títulos de la Universidad, correspondiente al año ' . $anioAcuerdo . '.</p>';
                    
                    if ($diaActual == 1) {
                        $html .= '<p align="justify">En testimonio de lo anterior, se firma el presente extracto de acta de grado, en Bogotá, D.C, el día primero (' . $diaActual . ') del mes de ' . strtolower($mesActual) . ' del año ' . numtoletras($anioActual) . ' (' . $anioActual . ').</p>';
                    } else {

                        $html .= '<p align="justify">En testimonio de lo anterior, se firma el presente extracto de acta de grado, en Bogotá, D.C, a los ' . numtoletras($diaActual) . ' (' . $diaActual . ') días del mes de ' . strtolower($mesActual) . ' del año ' . numtoletras($anioActual) . ' (' . $anioActual . ').</p>';
                    }
                   
                } else {
                   
                    if ($diaGraduacion == 1) {
                        $html .= '<p align="justify">En ceremonia solemne del día primero (' . $diaGraduacion . ') de ' . strtolower($mesGraduacion) . ' del año ' . $anioGraduacion . ', se le hará entrega del diploma No. ' . $registroGrado->getNumeroDiploma() . ', el cual aparece registrado con el No. ' . $registroGrado->getIdRegistroGrado() . ', al folio ' . $folioTemporal->getNumeroFolio() . ' del libro de registro de títulos de la Universidad, correspondiente al año ' . $anioAcuerdo . '.</p>';

                        if ($diaActual == 1) {
                            $html .= '<p align="justify">En testimonio de lo anterior, se firma el presente extracto de acta de grado, en Bogotá, D.C, el día primero (' . $diaActual . ') del mes de ' . strtolower($mesActual) . ' del año ' . numtoletras($anioActual) . ' (' . $anioActual . ').</p>';
                        } else {

                            $html .= '<p align="justify">En testimonio de lo anterior, se firma el presente extracto de acta de grado, en Bogotá, D.C, a los ' . numtoletras($diaActual) . ' (' . $diaActual . ') días del mes de ' . strtolower($mesActual) . ' del año ' . numtoletras($anioActual) . ' (' . $anioActual . ').</p>';
                        }
                    } else {
                        $html .= '<p align="justify">En ceremonia solemne del día ' . numtoletras($diaGraduacion, false, true, false) . ' (' . $diaGraduacion . ') de ' . strtolower($mesGraduacion) . ' del año ' . $anioGraduacion . ', se le hará entrega del diploma No. ' . $registroGrado->getNumeroDiploma() . ', el cual aparece registrado con el No. ' . $registroGrado->getIdRegistroGrado() . ', al folio ' . $folioTemporal->getNumeroFolio() . ' del libro de registro de títulos de la Universidad, correspondiente al año ' . $anioAcuerdo . '.</p>';

                        if ($diaActual == 1) {
                            $html .= '<p align="justify">En testimonio de lo anterior, se firma el presente extracto de acta de grado, en Bogotá, D.C, el día primero (' . $diaActual . ') del mes de ' . strtolower($mesActual) . ' del año ' . numtoletras($anioActual) . ' (' . $anioActual . ').</p>';
                        } else {

                            $html .= '<p align="justify">En testimonio de lo anterior, se firma el presente extracto de acta de grado, en Bogotá, D.C, a los ' . numtoletras($diaActual) . ' (' . $diaActual . ') días del mes de ' . strtolower($mesActual) . ' del año ' . numtoletras($anioActual) . ' (' . $anioActual . ').</p>';
                        }
                    }
                }
                $html .= '<p align="left">&nbsp;</p>
                          <br />';
                if ($txtCodigoModalidadAcademicaSic != 301) {
                    $html .= '<br />';
                }
                $html .= '<table width="100%" border="0">
			  <tr>';
                if ($registroGradoEstudiante->getActaAcuerdo()->getFechaAcuerdo() == "2017-03-15 00:00:00") {
                    $html .= '	<td width="50%"><b style="font-size:11pt;">MARÍA CLARA RANGEL GALVIS</b></td>';
                } else {
                    $html .= '	<td width="50%"><b style="font-size:11pt;">MARÍA CLARA RANGEL GALVIS</b></td>';
                }

                $html .= '    <td width="50%"><b style="font-size:11pt;">CRISTINA MATIZ MEJIA</b></td>
                        </tr>
                        <tr>';
                if ($registroGradoEstudiante->getActaAcuerdo()->getFechaAcuerdo() == "2017-03-15 00:00:00") {
                    $html .= '	<td><span style="font-size:11pt;">RECTOR (E)</span></td>';
                } else {
                    $html .= '	<td><span style="font-size:11pt;">RECTORA</span></td>';
                }
                $html .= '    <td><span style="font-size:11pt;">SECRETARIA GENERAL</span></td>
			    </tr>
			</table>
                        </div>
                        <div style="page-break-after: always;"></div>
                        ';
            }
            $html .= '</body>
                     </html>';
            $filename = "actaGrado" . $nombreCarrera . ".pdf";
            $html .= ob_get_clean();

            $dompdf = new DOMPDF();
            $dompdf->set_paper("letter", "portrait");
            $dompdf->load_html($html); //cargamos el html
            $dompdf->render(); //renderizamos
            $dompdf->stream($filename);
            break;
        //HITORICO DE NOTAS
        case "3":

            $txtCodigoEstudiantes2 = serialize($txtCodigoEstudiantes);

            header("Location: ../../consulta/facultades/certificados/certificadosformularioperiodosGrados.php?txtCodigoEstudiantes=" . $txtCodigoEstudiantes2 . "");

            break;
        //CERTIFICADO DE INCENTIVOS
        case "4":
        case "10":

            $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>Documento sin título</title>
					<style type="text/css">
						body {
							font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
							background: url("../css/images/marcaAgua5.png");
						    background-repeat: no-repeat;
							background-attachment: fixed;
   							background-position: center; 
						}
					@page { margin: 55px 55px; }
					#footer { position: fixed; left: 0px; bottom: 150px; right: 0px; height: 15px; }
					</style>
					</head>
					<body>';

            function uc_first_aux($str) {
                return ucfirst($str[1]);
            }

            function uc_first($str) {
                return preg_replace_callback('/([a-z]){1}/i', "uc_first_aux", $str, 1);
            }

            foreach ($txtCodigoEstudiantes as $txtCodigoEstudiante) {

                $estudiante = $controlEstudiante->buscarEstudiante($txtCodigoEstudiante);
                $trabajoGrado = $controlTrabajoGrado->buscarTGradoEstudiante($txtCodigoEstudiante);
                $incentivos = $controlRegistroGrado->listarIncentivoEstudianteRegistroGrado($txtCodigoEstudiante, $txtCodigoCarrera);
                
                if ($estudiante->getGenero()->getCodigo() == 100) {
                    $profesion = $tituloProfesion->getTituloProfesion()->getNombreTituloGenero();
                } else {
                    $profesion = $tituloProfesion->getTituloProfesion()->getNombreTitulo();
                }

                if (count($incentivos) != 0) {
                    $i = 1;
                    foreach ($incentivos as $incentivo) {

                        $anioAcuerdo = date("Y", strtotime($incentivo->getIncentivoAcademico()->getFechaAcuerdoIncentivo()));
                        $diaAcuerdo = date("d", strtotime($incentivo->getIncentivoAcademico()->getFechaAcuerdoIncentivo()));
                        $mes = mes(date("Y-m-d", strtotime($incentivo->getIncentivoAcademico()->getFechaAcuerdoIncentivo())));
                        $anioGraduacion = date("Y", strtotime($incentivo->getIncentivoAcademico()->getFechaAcuerdoIncentivo()));
                        $diaGraduacion = date("d", strtotime($incentivo->getIncentivoAcademico()->getFechaAcuerdoIncentivo()));
                        $mesGraduacion = mes(date("Y-m-d", strtotime($incentivo->getIncentivoAcademico()->getFechaAcuerdoIncentivo())));

                        $html .= '
							
                            <div align="center">
                              <div align="center"><br>
                                <p style="margin-top: -15px;"><img src="../css/images/logo2.png" width="170"  align="center" /></p>
                                <br />
                                <p align="center" style="font-size:18px;"><strong>El Consejo  Directivo de la Universidad El Bosque, en su sesión del día ' . $diaAcuerdo . ' <br />
                                  de ' . strtolower($mes) . ' del  año ' . $anioAcuerdo . ', según consta en el acta N° ' . $incentivo->getIncentivoAcademico()->getNumeroActaAcuerdoIncentivo() . ' y acuerdo<br />
                                N° ' . $incentivo->getIncentivoAcademico()->getNumeroAcuerdoIncentivo() . ' de la  misma fecha,</strong></p>
                                <br />
                                <p style="font-size:18px;"><strong>confiere a:</strong></p>
                                <br/>
                                <p><span style="font-size:24px;"><strong>' . pasarMayusculas($estudiante->getNombreEstudiante() . " " . $estudiante->getApellidoEstudiante()) . '</strong></span><br />';
                        if ($estudiante->getTipoDocumento()->getIniciales() == "05") {
                            $html .= '<span style="font-size:16px;">' . $estudiante->getTipoDocumento()->getDescripcion() . ' No. ' . $estudiante->getNumeroDocumento() . ' de ' . $estudiante->getExpedicion() . '</span></p>';
                        } else {
                            $numeroprimero = substr($estudiante->getNumeroDocumento(), 0,1); 
                            if($numeroprimero == 0){
                               $html .= '<span style="font-size:16px;">' . substr($estudiante->getTipoDocumento()->getDescripcion(), 0, 1) . '.' 
                               . substr($estudiante->getTipoDocumento()->getDescripcion(), 1, 1) . '. No. ' . $estudiante->getNumeroDocumento() . ' de ' . $estudiante->getExpedicion() . '</span></p>';      
                            }else{
                               $html .= '<span style="font-size:16px;">' . substr($estudiante->getTipoDocumento()->getDescripcion(), 0, 1) . '.' . substr($estudiante->getTipoDocumento()->getDescripcion(), 1, 1) . '. No. ' . number_format($estudiante->getNumeroDocumento(), 0, '', '.') . ' de ' . $estudiante->getExpedicion() . '</span></p>'; 
                            }
                        }
                        $html .= '<br><br>
							    <p align="center" style="font-size:26px;"><strong>' . pasarMayusculas($incentivo->getIncentivoAcademico()->getNombreIncentivo()) . '</strong></p><br />';
                        if ($incentivo->getIncentivoAcademico()->getCodigoIncentivo() == 3) {
                            $html .= '<p align="center" style="line-height:175%;font-size:14px;">Por haber obtenido el promedio de calificaciones más alto,  de la <br />
							    ' . num2toordinal($incentivo->getNumeroPromocion()) . ' promoción del programa de ' . convertirBogota(capitalizar(strtolower_utf8($carrera->getNombreCortoCarrera()))) . '.</p>';
                        } else {
                            $html .= '<p align="center" style="line-height:175%;font-size:14px;">En reconocimiento por su trabajo de investigación denominado: <br />';

                            $nombreIncentivoObservacion = $incentivo->getIncentivoAcademico()->getObservacionIncentivo();
                            $identificadorPunto = substr($nombreIncentivoObservacion, -1);

                            if ($identificadorPunto == '.') {
                                $nombreIncentivoObservacion = substr($nombreIncentivoObservacion, 0, -1);
                            }

                            $html .= $nombreIncentivoObservacion . ', <br />
                                    presentado para optar al título de ' . convertirBogota(capitalizar(strtolower_utf8($profesion))) . '.</p>';
                        }
                       $html .= '<p style="font-size:16px;" ><i>Dado en Bogotá, D.C., a los ' . numtoletras($diaGraduacion) . ' (' . $diaGraduacion . ') días del mes de ' . strtolower($mesGraduacion) . ' del año ' . numtoletras($anioGraduacion) . ' (' . $anioGraduacion . ')</i></p>
                  		 <br /><br />';

                        $html .= '';
                    if($txtCodigoImprimi == 4){
                        if ($incentivo->getIncentivoAcademico()->getCodigoIncentivo() == 3) {
                            $html .= '<br />
									<br />';
                        }
                        $html .= '<div id="footer"><br>
							<table width="100%" style="font-size:12px; text-align= center;">
				                	<tr>
				                        <td><div align="center"><span>___________________</span></div></td>
				                      <td><div align="center"><span>___________________</span></div></td>
				                        <td><div align="center"><span>___________________</span></div></td>
				                    </tr>
				                    <tr>
				                        <td ><div align="center"><strong>Rectora</strong></div></td>
				                        <td><div align="center"><strong>Presidente de el <br />Consejo Directivo</strong></div></td>
				                        <td ><div align="center">';
                        if ($incentivo->getIncentivoAcademico()->getCodigoIncentivo() == 2 || $incentivo->getIncentivoAcademico()->getCodigoIncentivo() == 3) {
                            $html .= '<strong>Vicerrectora<br />Académica</strong>';
                        } else {
                            $html .= '<strong>Director de Postgrados</strong>';
                        }
                        $html .= '</div></td>
				                    </tr>
			                    </table>
								<table width="100%" style="font-size:12px; text-align= center;">
				                    <tr>
				                        <td>&nbsp;</td>
				                        <td>&nbsp;</td>
				                        <td>&nbsp;</td>
				                    </tr>
				                    <tr>
				                        <td>&nbsp;</td>
				                        <td>&nbsp;</td>
				                        <td>&nbsp;</td>
				                    </tr>
				                    <tr>
				                        <td><div align="center"><span>___________________</span></div></td>
				                      <td><div align="center"><span>___________________</span></div></td>
				                        <td>&nbsp;</td>
				                    </tr>
				                    <tr>
				                        <td><div align="center">';
                        if ($incentivo->getIncentivoAcademico()->getCodigoIncentivo() == 2 || $incentivo->getIncentivoAcademico()->getCodigoIncentivo() == 3) {
                            $html .= '<strong>Decano</strong>';
                        } else {
                            $html .= '<strong>Director del Programa</strong>';
                        }
                        $html .= '</div></td>
				                        <td><div align="center"><strong>Secretaria General</strong></div></td>
				                        <td>&nbsp;</td>
				                    </tr>
			                	</table>';
                    }else{
                        $html .= '<div id="footer"><br>
                            <table width="100%" style="font-size:12px; text-align= center;">
                                    <tr>
                                        <td><div align="center"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></div></td>
                                        <td><div align="center"><span>___________________</span></div></td>
                                      <td><div align="center"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div></td>
                                        <td><div align="center"><span>___________________</span></div></td>
                                    </tr>
                                    <tr>
                                        <td><div align="center"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></div></td>
                                        <td ><div align="center"><strong>Rectora</strong></div></td>
                                        <td><div align="center"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></div></td>
                                        <td><div align="center"><strong>Presidente de el <br />Consejo Directivo</strong></div></td>
                                        <td ><div align="center">';
                        if ($incentivo->getIncentivoAcademico()->getCodigoIncentivo() == 2 || $incentivo->getIncentivoAcademico()->getCodigoIncentivo() == 3) {
                           // $html .= '<strong>Vicerrectora<br />Académica</strong>';
                        } else {
                            //$html .= '<strong>Director de Postgrados</strong>';
                        }
                        $html .= '</div></td>
                                    </tr>
                                </table>
                                <table width="100%" style="font-size:12px; text-align= center;">
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><div align="center"><span>___________________</span></div></td>
                                      <td><div align="center"><span>___________________</span></div></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><div align="center">';
                        if ($incentivo->getIncentivoAcademico()->getCodigoIncentivo() == 2 || $incentivo->getIncentivoAcademico()->getCodigoIncentivo() == 3) {
                            $html .= '<strong>Decano</strong>';
                        } else {
                           $html .= '<strong>Director de Postgrados</strong>';
                        }
                        $html .= '</div></td>
                                        <td><div align="center"><strong>Secretaria General</strong></div></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>';
                    }

			                $html .= '<table width="100%" style="font-size:10px; text-align= center;">
				                    <tr>
				                        <td ><div align="center"><strong></strong></div></td>
				                        <td><div align="center"><strong>' . $incentivo->getIncentivoAcademico()->getNumeroConsecutivoIncentivo() . '</strong></div></td>
				                        <td ><div align="center"><strong></strong></div></td>
				                    </tr>
			                    </table>
			                    <br />
								<p align="justify" style="font-size: 8px;">Personería Jurídica Resolución N° 11153 del 4 de agosto de 1978 expedida por el Ministerio de Educación Nacional. - Vigilada Mineducación</p>
							</div>
				  			</div>
						</div>
					<div style="page-break-after: always;"></div>';
                    }
                }
            }
            $html .= '</body>
		      </html>';
            $filename = "mencionHonor" . $nombreCarrera . ".pdf";

            $dompdf = new DOMPDF();
            $dompdf->set_paper("letter", "portrait");
            $dompdf->load_html($html); //cargamos el html
            $dompdf->render(); //renderizamos
            $dompdf->stream($filename);
            break;
        //LINEA DE ENFASIS
        case "5":

            $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
							<html xmlns="http://www.w3.org/1999/xhtml">
							<head>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							<title>Documento sin título</title>
							<style type="text/css">
								body {
									font-family: human, sans-serif;
									background: url("../css/images/marcaAgua5.png") no-repeat center center fixed;
								}
							@page { margin: 50px 120px; }
							#footer { position: fixed; left: 0px; bottom: -35px; right: 0px; height: 30px; }
							</style>
							</head>
							<body>';
            foreach ($txtCodigoEstudiantes as $txtCodigoEstudiante) {
                    
                $planEstudioEstudiante = $controlEstudiante->buscarPlanEstudioEstudiante($txtCodigoEstudiante);
                $estudiante = $controlEstudiante->buscarEstudiante($txtCodigoEstudiante);
                
                if ($estudiante->getGenero()->getCodigo() == 100) {
                    $profesion = $tituloProfesion->getTituloProfesion()->getNombreTituloGenero();
                } else {
                    $profesion = $tituloProfesion->getTituloProfesion()->getNombreTitulo();
                }

                $html .= '<div id="footer">
				<p align="justify" style="font-size: 8pt;">Personería Jurídica Resolución N° 11153 del 4 de agosto de 1978 expedida por el Ministerio de Educación Nacional - Vigilada Mineducación.</p>
			  </div>
			  <div>
                            <div align="center">
                                <p style="margin-top: -35px;"><img src="../css/images/LogoBosque.png" width="205" height="168" align="center" /></p>
                                <br />
                                <p style="font-size:24pt; font-family: humanbold, sans-serif;"><strong>CERTIFICA</strong></p>
                                <p style="font-size:14pt; line-height: 200%;">QUE <strong style="font-family: humanbold, sans-serif;">' . pasarMayusculas($estudiante->getNombreEstudiante() . " " . $estudiante->getApellidoEstudiante()) . ',</strong> CURSÓ LOS ESTUDIOS <br />CORRESPONDIENTES AL PROGRAMA DE ' . convertirBogota($carrera->getNombreCortoCarrera()) . ' Y OBTUVO EL TÍTULO DE:</p>
                                <br />
                                <p style="font-size:16pt; font-family: humanbold, sans-serif;"><strong>' . $profesion . '</strong></p>';
                if ($planEstudioEstudiante->getIdPlanEstudioEstudiante() != "") {
                    $html .= '<p style="font-size:14pt; font-family: human, sans-serif">PROFUNDIZACIÓN EN ' . pasarMayusculas($planEstudioEstudiante->getNombreLineaEnfasis()) . '</p>';
                }
                $html .= '<br />
			<p><i>DADO EN BOGOTÁ, D.C., a los veintinueve (29) días del mes de junio del año dos mil dieciséis (2016).</i></p>
			<p>&nbsp;</p>
			<table width="100%">
                            <tr>
                                <td><div align="center"><span>___________________</span></div></td>
                                <td><div align="center"><span>&nbsp;</span></div></td>
                                <td><div align="center"><span>___________________</span></div></td>
                            </tr>
                            <tr>
                                <td ><div align="center">Rectora</div></td>
                                <td><div align="center">&nbsp;</div></td>
                                <td ><div align="center">Decano</div></td>
                            </tr>
                        </table>
                        </div>
			</div>
			<div style="page-break-before: always;"></div>';
            }
            $html .= '</body>
                      </html>';
            $filename = "enfasis" . $nombreCarrera . ".pdf";

            $dompdf = new DOMPDF();
            $dompdf->set_paper("letter", "landscape");
            $dompdf->load_html($html); //cargamos el html
            $dompdf->render(); //renderizamos
            $dompdf->stream($filename);
            break;
        //DIPLOMA CON PLANTILLA
        case "6":
        case "12":
            $orientacion = "L";
            $unidad = "mm";
            $formato = "pregrado";

            foreach ($txtCodigoEstudiantes as $txtCodigoEstudiante) {

                $pdf = new FPDF_CellFit($orientacion, $unidad, $formato);
                $pdf->SetMargins(0, 0, 0);
                $pdf->SetAutoPageBreak(true, 9);
                $pdf->AddFont('TrajanPro', '', 'TrajanPro.php');
                $pdf->AddFont('Humanst521BTRoman', '', 'Humanst521BTRoman.php');
                $pdf->AddFont('UniversityRomanBoldBT', '', 'UniversityRomanBoldBT.php');
                $pdf->AddFont('Dauphin', '', 'Dauphin.php');

                $estudiante = $controlEstudiante->buscarEstudiante($txtCodigoEstudiante);
                $registroGrado = $controlRegistroGrado->buscarRegistroGradoCarreraEstudiante($txtCodigoCarrera, $txtCodigoEstudiante);
                $folioTemporal = $controlFolioTemporal->buscarFolioTemporal($registroGrado->getIdRegistroGrado());
                $anioGrado = date("Y", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo()));
                $diaGrado = date("d", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo()));
                $mesGrado = mes(date("Y-m-d", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo())));

                $pdf->AddPage();

                //marca de agua
                $pdf->Image('../css/images/marcaagua.png', '153','80','110','130');
                //logo
                $pdf->Image('../css/images/logo_Diploma.png', '175', '12', '71', '61');

                if ($txtCodigoCarrera == 10) {
                    $pdf->SetFont('TrajanPro', '', 30);
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetY(80);
                    $pdf->SetX(45);
                    $pdf->CellFit(330, 0, utf8_decode("ESCUELA COLOMBIANA DE MEDICINA"), 0, 0, 'C', '', '', true, false);
                }

                $pdf->SetFont('Humanst521BTRoman', '', 12);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetY(95);
                $pdf->SetX(45);
                $pdf->CellFit(330, 0, utf8_decode("EN ATENCIÓN A QUE:"), 0, 0, 'C', '', '', true, false);

                $pdf->SetFont('TrajanPro', '', 50);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetY(115);
                $pdf->SetX(45);
                $apellido = str_replace("´", "'", $estudiante->getApellidoEstudiante());

                $pdf->CellFit(330, 0, utf8_decode($estudiante->getNombreEstudiante() . " " . $apellido), 0, 0, 'C', '', '', true, false);
                $pdf->SetFont('Humanst521BTRoman', '', 12);
                $pdf->SetY(127);
                $search = array('á', 'é', 'í', 'ó', 'ú');
                $replace = array('Á', 'É', 'Í', 'Ó', 'Ú');
                $nombreDocumento = pasarMayusculas($estudiante->getTipoDocumento()->getNombreDocumento());
                $expedidoDocumento = pasarMayusculas($estudiante->getExpedicion());

                if ($estudiante->getTipoDocumento()->getIniciales() == "05") {
                    $pdf->Cell(0, 0, utf8_decode($nombreDocumento) . ' No. ' . $estudiante->getNumeroDocumento() . ' EXPEDIDO EN ' . utf8_decode($expedidoDocumento), 0, 2, 'C');
                } else {
                    if ($estudiante->getTipoDocumento()->getIniciales() == "03") {
                        $pdf->Cell(0, 0, utf8_decode($nombreDocumento) . ' No. ' . $estudiante->getNumeroDocumento() . ' EXPEDIDA EN ' . utf8_decode($expedidoDocumento), 0, 2, 'C');
                    } else {

                        DocumentoCedulaCiudadania($nombreDocumento,$estudiante->getNumeroDocumento() ,$expedidoDocumento,$pdf);
                    }
                }

                $pdf->SetFont('Humanst521BTRoman', '', 12);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetY(153);
                $pdf->SetX(45);
                $pdf->CellFit(330, 0, utf8_decode("CUMPLIÓ CON LOS REQUISITOS LEGALES Y ACADÉMICOS EXIGIDOS POR LA INSTITUCIÓN,"), 0, 0, 'C', '', '', true, false);
                $pdf->SetY(158);
                $pdf->SetX(45);
                $pdf->CellFit(330, 0, utf8_decode("LE CONFIERE EL TÍTULO DE "), 0, 0, 'C', '', '', true, false);

                $pdf->SetFont('TrajanPro', '', 50);
                $pdf->SetY(177);
                $pdf->SetX(30);

                if ($estudiante->getGenero()->getCodigo() == 100) {
                    $pdf->CellFit(360, 0, utf8_decode($tituloProfesion->getTituloProfesion()->getNombreTituloGenero()), 0, 0, 'C', '', '', true, false);
                }
                else {
                    $pdf->CellFit(360, 0, utf8_decode($tituloProfesion->getTituloProfesion()->getNombreTitulo()), 0, 0, 'C', '', '', true, false);
                }

                $pdf->SetFont('Humanst521BTRoman', '', 12);
                $pdf->SetY(197);
                $pdf->Cell(0, 0, str_replace($search, $replace, strtoupper(utf8_decode('DADO EN BOGOTÁ D.C., REPÚBLICA DE COLOMBIA, EL DÍA'))) . ' ' . $diaGrado . ' DE ' . strtoupper($mesGrado) . ' DE ' . $anioGrado . ' ', 0, 2, 'C');


                if($txtCodigoImprimi == 6){
                //firma rectora
                $pdf->Image('../css/images/FirmaDraMariaClaraRangel.png', '40', '200', '50', '0');
                //firma secretaria general
                $pdf->Image('../css/images/FirmaDraCristinaMatiz.png', '230', '230', '50', '0');
                //firma presidente de el consejo directivo
                $pdf->Image('../css/images/FirmaDrCamiloEscobar.jpeg', '320', '193', '40', '0');
                //firma decano
                if ($txtCodigoCarrera == 10) {
                    $pdf->Image('../css/images/FirmaHugoCardenas.png', '95', '230', '60', '0');
                }
                else if($txtCodigoCarrera == 5 || $txtCodigoCarrera == 748){
                     $pdf->Image('../css/images/FirmaDrAntonioAdminNegocios.jpg', '95', '235', '65', '0');
                }
                else if($txtCodigoCarrera == 123 || $txtCodigoCarrera == 124 ||$txtCodigoCarrera == 564 ||$txtCodigoCarrera == 125 ||$txtCodigoCarrera == 118 || $txtCodigoCarrera == 119 || $txtCodigoCarrera == 126){
                     $pdf->Image('../css/images/FirmaJulioCesarIngenierias.jpg', '95', '218', '50', '0');
                }
				else if($txtCodigoCarrera == 1266 || $txtCodigoCarrera == 500 || $txtCodigoCarrera == 132 || $txtCodigoCarrera == 788 || $txtCodigoCarrera == 129 || $txtCodigoCarrera == 130){
                     $pdf->Image('../css/images/FirmaJuanPabloSalcedoArtes.png', '95', '230', '50', '0');
                }else if($txtCodigoCarrera == 58){//Especialiazacion Cirugia Plastica
                    $pdf->Image('../css/images/FirmaCelsoBohorquezCirugiaPlastica.png', '80', '227', '70', '0');
                }else if($txtCodigoCarrera == 907){//ESPECIALIZACION EN ANESTESIOLOGIA.
                    $rotacion = $controlEstudiante->buscarRotacionEstudiante($estudiante->getCodigoEstudiante());
                    
                    if($rotacion == 1){//Fundación Santa Fe
                         $pdf->Image('../css/images/FirmaEnriqueArangoAnestesiologiaFSB.png', '80', '235', '70', '0'); 
                    }else{ //Hosp. Simón Bolivar
                       $pdf->Image('../css/images/FirmaFernandoAguileraAnestesiologiaHsb.png', '80', '210', '70', '0'); 
                    }

                }else if($txtCodigoCarrera == 1318 || $txtCodigoCarrera == 57){//ESP. EN MEDICINA CRITICA Y CUIDADO INTENSIVO Y ESP. EN MEDICINA INTERNA HSC
                    $pdf->Image('../css/images/FirmaGuillermoOrtizMedicinaCritica.png', '80', '220', '70', '0');
                }else if($txtCodigoCarrera == 47){//ESPECIALIZACION EN PEDIATRIA
                    $pdf->Image('../css/images/FirmaNicolasRamosPediatria.png', '80', '235', '70', '0');
                }else if($txtCodigoCarrera == 52){//ESPECIALIZACION EN MEDICINA INTERNA FSB
                    $pdf->Image('../css/images/FirmaJairoRoaMedicinaInternaFSB.png', '80', '235', '70', '0');
                }else if($txtCodigoCarrera == 11){//ODONTOLOGIA
                    $pdf->Image('../css/images/FirmaMariaBuenahoraOdontologia.png', '80', '240', '70', '0');
                }else if($txtCodigoCarrera == 55){//ESPECIALIZACION EN CIRUGIA DE TORAX
                    $pdf->Image('../css/images/FirmaStellaMartinezCirugiaTorax.png', '84', '235', '70', '0');
                }else if($txtCodigoCarrera == 19){//ESPECIALIZACION EN ODONTOLOGIA PEDIATRICA
                    $pdf->Image('../css/images/FirmaSandraHincapieOdontoPediatrica.png', '84', '236', '70', '0');
                }else if($txtCodigoCarrera == 578){//MAESTRIA EN DOCENCIA DE LA EDUCACION SUPERIOR
                    $pdf->Image('../css/images/FirmaGladysGomezEducacionSuperior.png', '82', '236', '70', '0');
                }else if($txtCodigoCarrera == 581){//MAESTRIA EN SALUD PUBLICA
                    $pdf->Image('../css/images/FirmaLuisGomezSaludPublica.png', '82', '215', '70', '0');
                }else if($txtCodigoCarrera == 451){//ESP. PSICOLOGÍA CLÍNICA Y AUTOEFICACIA
                    $pdf->Image('../css/images/FirmaNancyMartinezPsicologiaClinica.png', '82', '233', '70', '0');
                }else if($txtCodigoCarrera == 78){//ESPECIALIZACION EN DOCENCIA UNIVERSITARIA
                    $pdf->Image('../css/images/FirmaMartaMontielDocenciaUniversitaria.png', '82', '233', '70', '0');
                }else if($txtCodigoCarrera == 71){//ESPECIALIZACION EN GERENCIA DE PROYECTOS
                    $pdf->Image('../css/images/FirmaJorgeOsorioGerenciaProyectos.png', '72', '228', '70', '0');
                }else if($txtCodigoCarrera == 33){//ESPECIALIZACION EN  MEDICINA FAMILIAR
                    $pdf->Image('../css/images/FirmaMauricioRodriguezMedicinaFamiliar.png', '80', '228', '70', '0');
                }else if($txtCodigoCarrera == 609){//MAESTRIA EN EPIDEMIOLOGÍA
                    $pdf->Image('../css/images/FirmaAlexandraPorrasEpidemiologia.png', '80', '232', '70', '0');
                }
            }else{
                $pdf->Image('../css/images/FirmaDraMariaClaraRangel.png', '120', '200', '50', '0');
                $pdf->Image('../css/images/FirmaDrCamiloEscobar.jpeg', '295', '193', '40', '0');
                $pdf->Image('../css/images/FirmaDraCristinaMatiz.png', '190', '230', '50', '0');

                if ($txtCodigoCarrera == 10) {
                    $pdf->Image('../css/images/FirmaHugoCardenas.png', '55', '230', '60', '0');
                }
                else if($txtCodigoCarrera == 5 || $txtCodigoCarrera == 748){
                     $pdf->Image('../css/images/FirmaDrAntonioAdminNegocios.jpg', '54', '235', '65', '0');
                }
                else if($txtCodigoCarrera == 123 || $txtCodigoCarrera == 124 ||$txtCodigoCarrera == 564 ||$txtCodigoCarrera == 125 ||$txtCodigoCarrera == 118 || $txtCodigoCarrera == 119 || $txtCodigoCarrera == 126){
                     $pdf->Image('../css/images/FirmaJulioCesarIngenierias.jpg', '55', '218', '50', '0');
                }
                else if($txtCodigoCarrera == 1266 || $txtCodigoCarrera == 500 || $txtCodigoCarrera == 132 || $txtCodigoCarrera == 788 || $txtCodigoCarrera == 129 || $txtCodigoCarrera == 130){
                     $pdf->Image('../css/images/FirmaJuanPabloSalcedoArtes.png', '55', '230', '50', '0');
                }
                else if($txtCodigoCarrera == 11){//ODONTOLOGIA
                    $pdf->Image('../css/images/FirmaMariaBuenahoraOdontologia.png', '40', '240', '70', '0');
                }

            }

            if($txtCodigoImprimi == 6){
                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(227);
                $pdf->SetX(45);
                $pdf->Cell(0, 0, 'RECTORA', 0, 0, 'L');
                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(227);
                $pdf->SetX(157);
                if ($carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 200 || $carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 800) {
                    //firma Presidenta de el claustro
                    $pdf->Image('../css/images/FirmaDraTianaCian.png', '150', '205', '80', '0');
                    $pdf->Cell(0, 0, 'PRESIDENTA DE EL CLAUSTRO', 0, 0, 'L');
                } else if ($carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 300 || $carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 600) {
                    $pdf->Cell(0, 0, 'DIRECTOR DE POSTGRADOS', 0, 0, 'L');
                    $pdf->Image('../css/images/FirmaJuanSanchezDirectorPostgrados.png', '150', '200', '80', '0');
                }

                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(227);
                $pdf->SetX(294);
                $pdf->Cell(0, 0, 'PRESIDENTE DE El CONSEJO DIRECTIVO', 0, 0, 'L');

                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(254);
                if ($carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 200 || $carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 800) {
                    $pdf->SetX(107);
                    $pdf->Cell(0, 0, 'DECANO', 0, 0, 'L');
                } else if ($carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 300 || $carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 600) {
                    $pdf->SetX(82);
                    $pdf->Cell(0, 0, 'DIRECTOR DEL PROGRAMA', 0, 0, 'L');
                }

                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(254);
                $pdf->SetX(231);
                $pdf->Cell(0, 0, 'SECRETARIA GENERAL', 0, 0, 'L');
                //pie de pagina
            }
            else{

                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(227);
                $pdf->SetX(125);
                $pdf->Cell(0, 0, 'RECTORA', 0, 0, 'L');

                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(227);
                $pdf->SetX(270);
                $pdf->Cell(0, 0, 'PRESIDENTE DE El CONSEJO DIRECTIVO', 0, 0, 'L');

                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(254);
                if ($carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 200 || $carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 800) {
                    $pdf->SetX(65);
                    $pdf->Cell(0, 0, 'DECANO', 0, 0, 'L');
                } else if ($carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 300 || $carrera->getModalidadAcademica()->getCodigoModalidadAcademica() == 600) {
                    $pdf->SetX(31);
                    $pdf->Cell(0, 0, 'DIRECTOR DE POSTGRADOS', 0, 0, 'L');
                    $pdf->Image('../css/images/FirmaJuanSanchezDirectorPostgrados.png', '30', '225', '80', '0');
                }

                $pdf->SetFont('TrajanPro', '', 12);
                $pdf->SetY(254);
                $pdf->SetX(190);
                $pdf->Cell(0, 0, 'SECRETARIA GENERAL', 0, 0, 'L');

            }

                //izquierda
                $pdf->SetFont('Humanst521BTRoman', '', 10);
                $pdf->SetY(284);
                $pdf->SetX(5);
                $pdf->Cell(0, 0, utf8_decode('Personería Jurídica Resolución No. 11153 del 4 de agosto de 1978 expedida por el Ministerio de Educación Nacional'), 0, 0, 'L');

                //centro
                $pdf->SetFont('Humanst521BTRoman', '', 10);
                $pdf->SetY(284);
                $pdf->SetX(45);
                $pdf->CellFit(330, 0, utf8_decode(  $registroGrado->getNumeroDiploma()),0, 0, 'C', '', '', true, false);
                $pdf->SetFont('TrajanPro', '', 2);
                $pdf->SetY(286);
                $pdf->SetX(45);
                $pdf->CellFit(330, 0, utf8_decode("THOMAS GREG & SONS."),0, 0, 'C', '', '', true, false);

                //derecha
                $pdf->SetFont('Humanst521BTRoman', '', 10);
                $pdf->SetY(284);
                $pdf->SetX(314);
                $pdf->Cell(0, 0, 'Registro  ' . $registroGrado->getIdRegistroGrado(), 0, 0, 'L');

                $pdf->SetFont('Humanst521BTRoman', '', 10);
                $pdf->SetY(284);
                $pdf->SetX(344);
                $pdf->Cell(0, 0, 'Folio ' . $folioTemporal->getNumeroFolio(), 0, 0, 'L');

                $pdf->SetFont('Humanst521BTRoman', '', 10);
                $pdf->SetY(284);
                $pdf->SetX(364);
                $pdf->Cell(0, 0, utf8_decode('Vigilada Mineducación'), 0, 0, 'L');

                $nameFile = "../documentos/diplomas/DP-".trim($nombreCarrera)."-".$estudiante->getNumeroDocumento()."-".$estudiante->getApellidoEstudiante()."-".$estudiante->getNombreEstudiante().".pdf";
                $pdf->Output($nameFile, 'F');
            }

            echo "<h2>Para descargar los documentos continue aqui:</h2>";

            $directorio = opendir("../documentos/diplomas/"); //ruta actual
            $contadoFiles=1;
            echo "<table class='table table-bordered'><tr><td>#</td><td>Nombre</td><td>Accion</td><td>Fecha</td></tr>";
            while ($archivo = readdir($directorio)){
                if(!is_dir($archivo)){
                    echo "<tr><td>$contadoFiles</td><td><a href='../documentos/diplomas/$archivo' download='$archivo'>$archivo</a>
                    </td><td><input type=\"checkbox\" name=\"option-1\" id=\"option-1\"><td><td></td></tr>";
                    $contadoFiles++;
                }
            }
            echo "</table>";

            break;
        //ACTA DE GRADO CON PLANTILLA
        case "7":
            $orientacion = "p";
            $unidad = "mm";
            $formato = "letter";

            foreach ($txtCodigoEstudiantes as $txtCodigoEstudiante) {

                $pdf = new FPDF_CellFit($orientacion, $unidad, $formato);
                $pdf->SetMargins(0, 0, 0);
                $pdf->SetAutoPageBreak(true, 8);
                $pdf->AddFont('Times-Roman', '', 'times.php');
                $pdf->AddFont('Times-Roman', 'B', 'timesb.php');

                $estudiante = $controlEstudiante->buscarEstudiante($txtCodigoEstudiante);
                $registroGradoEstudiante = $controlRegistroGrado->buscarRegistroGradoCarreraEstudiante($txtCodigoCarrera, $txtCodigoEstudiante);
                $txtIdTipoGrado = $registroGradoEstudiante->getActaAcuerdo()->getFechaGrado()->getTipoGrado()->getIdTipoGrado();
                if ($estudiante->getGenero()->getCodigo() == 100) {
                    $profesion = $tituloProfesion->getTituloProfesion()->getNombreTituloGenero();
                } else {
                    $profesion = $tituloProfesion->getTituloProfesion()->getNombreTitulo();
                }

                $anioAcuerdo = date("Y", strtotime($registroGradoEstudiante->getActaAcuerdo()->getFechaAcuerdo()));
                $diaAcuerdo = date("d", strtotime($registroGradoEstudiante->getActaAcuerdo()->getFechaAcuerdo()));
                $mes = mes(date("Y-m-d", strtotime($registroGradoEstudiante->getActaAcuerdo()->getFechaAcuerdo())));
                $anioGraduacion = date("Y", strtotime($registroGradoEstudiante->getActaAcuerdo()->getFechaGrado()->getFechaGraduacion()));
                $diaGraduacion = date("d", strtotime($registroGradoEstudiante->getActaAcuerdo()->getFechaGrado()->getFechaGraduacion()));
                $mesGraduacion = mes(date("Y-m-d", strtotime($registroGradoEstudiante->getActaAcuerdo()->getFechaGrado()->getFechaGraduacion())));
                $txtIdActa = $registroGradoEstudiante->getActaAcuerdo()->getIdActaAcuerdo();
                $registroGrado = $controlRegistroGrado->buscarRegistroGradoId($txtCodigoEstudiante, $txtIdActa);
                $folioTemporal = $controlFolioTemporal->buscarFolioTemporal($registroGrado->getIdRegistroGrado());
                $txtCodigoModalidadAcademicaSic = $registroGradoEstudiante->getActaAcuerdo()->getFechaGrado()->getCarrera()->getModalidadAcademicaSic()->getCodigoModalidadAcademicaSic();

                $pdf->AddPage();

                $pdf->Image('../css/images/logo-Acta.png', '73', '8', '70', '30');

                $pdf->SetFont('Times-Roman', '', 10);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetY(38);
                $pdf->CellFit(0, 0, utf8_decode("Por una cultura de la vida, su calidad y su sentido"), 0, 0, 'C', '', '', true, false);

				if ($txtCodigoCarrera == 10) {
                $pdf->SetFont('Times-Roman', 'B', 14);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetY(45);
                $pdf->CellFit(0, 0, utf8_decode("ESCUELA COLOMBIANA DE MEDICINA"), 0, 0, 'C', '', '', true, false);
				}

                $pdf->SetFont('Times-Roman', '', 6);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetY(233);
                $pdf->SetX(8);
                $pdf->Rotate(90);
                $pdf->Cell(200, 0, utf8_decode("Personería Jurídica: Resolución No. 11153 de 1978 Reconocimiento institucional como Universidad: Resolución No. 327 de 1997 del "), 0, 0, 'C', '', '', true, false);
                $pdf->SetY(233);
                $pdf->SetX(10);
                $pdf->Rotate(90);
                $pdf->Cell(200, 0, utf8_decode("Ministerio de Educación Nacional."), 0, 0, 'C', '', '', true, false);

                $pdf->SetFont('Times-Roman', '', 6);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetY(110);
                $pdf->SetX(210);
                $pdf->Rotate(90);
                $pdf->Cell(100, 0, utf8_decode("Vigilada Mineducación"), 0, 0, 'C', '', '', true, false);
                $pdf->Rotate(0);

                $pdf->SetFont('Times-Roman', 'B', 14);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetY(68);
                $pdf->CellFit(0, 0, utf8_decode("ACTA DE GRADO"), 0, 0, 'C', '', '', true, false);

                $pdf->SetFont('Times-Roman', '', 12);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetY(90);
                $pdf->SetX(24);
                $pdf->Cell(170, 0, utf8_decode("El Consejo Directivo de la Universidad El Bosque, en su sesión del día ".
                    $diaAcuerdo." de ". strtolower($mes)." del año"), 0, 0, 'FJ',0);
                $pdf->SetY(95);
                $pdf->SetX(24);
                $pdf->Cell(170, 0, utf8_decode($anioAcuerdo .", según consta en el Acta No. ".
                    $registroGradoEstudiante->getActaAcuerdo()->getNumeroActaConsejoDirectivo()." y Acuerdo No. ".
                    $registroGradoEstudiante->getActaAcuerdo()->getNumeroAcuerdo()." de la misma fecha, estudió y"), 0, 0, 'FJ',0);
                $pdf->SetY(100);
                $pdf->SetX(24);
                $pdf->CellFit(200, 0, utf8_decode("aprobó la solicitud del aspirante a grado, alumno (a)"), 0, 0, 'L', '', '', true, false);

                $pdf->SetFont('Times-Roman', 'B', 14);
                $pdf->SetY(115);
                $pdf->CellFit(0, 0, utf8_decode($estudiante->getNombreEstudiante()." ".$estudiante->getApellidoEstudiante()), 0, 0, 'C', '', '', true,false);

                $pdf->SetY(120);
                if ($estudiante->getTipoDocumento()->getIniciales() == "05") {
                    $pdf->CellFit(0, 0, utf8_decode(substr($estudiante->getTipoDocumento()->getDescripcion(), 0, 1).".".
                        substr($estudiante->getTipoDocumento()->getDescripcion(), 1, 1).". No. ".
                        $estudiante->getNumeroDocumento()." DE ".convertirBogota(capitalizar2(strtolower_utf8($estudiante->getExpedicion())))), 0, 0, 'C', '', '', true,false);
                } else {
                    if ($estudiante->getTipoDocumento()->getIniciales() == "03") {
                        $pdf->CellFit(0, 0, utf8_decode(substr($estudiante->getTipoDocumento()->getDescripcion(), 0, 1).".".
                            substr($estudiante->getTipoDocumento()->getDescripcion(), 1, 1).". No. " .
                            $estudiante->getNumeroDocumento() . ' DE ' . pasarMayusculas($estudiante->getExpedicion())), 0, 0, 'C', '', '', true,false);
                    } else {
                        $numeroprimero = substr($estudiante->getNumeroDocumento(), 0,1); 
                        if($numeroprimero == 0){
                            $pdf->CellFit(0, 0, utf8_decode(substr($estudiante->getTipoDocumento()->getDescripcion(), 0, 1).".".
                            substr($estudiante->getTipoDocumento()->getDescripcion(), 1, 1).". No ".
                            $estudiante->getNumeroDocumento()." DE ".
                            pasarMayusculas($estudiante->getExpedicion())), 0, 0, 'C', '', '', true,false);    

                        }else{
                            $pdf->CellFit(0, 0, utf8_decode(substr($estudiante->getTipoDocumento()->getDescripcion(), 0, 1).".".
                            substr($estudiante->getTipoDocumento()->getDescripcion(), 1, 1).". No ".
                            number_format($estudiante->getNumeroDocumento(), 0, '', '.')." DE ".
                            pasarMayusculas($estudiante->getExpedicion())), 0, 0, 'C', '', '', true,false);    
                        }
                    }
                }

                $pdf->SetFont('Times-Roman', '', 12);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetY(135);
                $pdf->SetX(24);
                $pdf->Cell(170, 0, utf8_decode("Quien cumplió satisfactoriamente con todos los requisitos académicos y legales exigidos por la"), 0, 0, 'FJ',0);
                $pdf->SetY(140);
                $pdf->SetX(24);
                $pdf->CellFit(200, 0, utf8_decode("Institución, motivo por el cual autorizó se le otorgue el título de:"),0, 0, 'L`', '', '', true, false);

                $pdf->SetFont('Times-Roman', 'B', 14);
                $pdf->SetY(160);
                $pdf->SetX(5);
                $pdf->CellFit(0, 0, utf8_decode(pasarMayusculas($profesion)), 0, 0, 'C', '', '', true, false);

                if ($txtCodigoModalidadAcademicaSic == 301) {
                    $incentivo = $controlIncentivo->buscarIncentivoEstudiante($txtCodigoEstudiante, $txtCodigoCarrera);
                    if ($incentivo->getIdIncentivo() != "") {
                        $txtCodigoIncentivo = $incentivo->getCodigoIncentivo();
                        $mencion = $controlIncentivo->buscarIncentivoId($txtCodigoIncentivo);
                        $trabajoGrado = $controlTrabajoGrado->buscarTGradoEstudiante($txtCodigoEstudiante);
                        if ($estudiante->getGenero()->getCodigo() == 200) {
                            $tratoEstudiante = "lo hizo merecedor";
                        } else {
                            $tratoEstudiante = "la hizo merecedora";
                        }

                        $pdf->SetFont('Times-Roman', 'B', 14);
                        $pdf->SetY(170);
                        $pdf->SetX(5);
                        $pdf->CellFit(200, 0, utf8_decode(">El graduando, para optar al título de magíster, presento y aprobó el trabajo de investigación denominado ".
                            pasarMayusculas($trabajoGrado->getNombreTrabajoGrado()).", el cuál ".
                            $tratoEstudiante." de la ".$mencion->getNombreIncentivo()),0, 0, 'L`', '', '', true, false);
                    }
                }

                $diaActual = date("d");
                $mesActual = mes(date("Y-m-d"));
                $anioActual = date("Y");


                $pdf->SetFont('Times-Roman', '', 12);
                $pdf->SetTextColor(0, 0, 0);

                if ($txtIdTipoGrado == 2) {
                    $pdf->SetY(180);
                    $pdf->SetX(24);
                    $pdf->Cell(170, 0, utf8_decode("En la Secretaría General de la Universidad, se le hace entrega del diploma No. ".
                        $registroGrado->getNumeroDiploma().", el cual"),  0, 0, 'FJ',0);
                    $pdf->SetY(185);
                    $pdf->SetX(24);
                    $pdf->Cell(170, 0, utf8_decode("aparece registrado con el No. ".
                        $registroGrado->getIdRegistroGrado().", al folio ".$folioTemporal->getNumeroFolio().
                        " del libro de registro de títulos de la"),  0, 0, 'FJ',0);
                    $pdf->SetY(190);
                    $pdf->SetX(24);
                    $pdf->CellFit(200, 0, utf8_decode("Universidad, correspondiente al año ".
                        $anioAcuerdo."."), 0, 0, 'L', '', '', true, false);
                    if ($diaActual == 1) {
                        $pdf->SetY(200);
                        $pdf->SetX(24);
                        $pdf->Cell(170, 0, utf8_decode("En testimonio de lo anterior, se firma el presente extracto de acta de grado, en Bogotá, D.C, "), 0, 0, 'FJ',0);
                        $pdf->SetY(205);
                        $pdf->SetX(24);
                        $pdf->CellFit(200, 0, utf8_decode("el día primero (".$diaActual.") del mes de ".
                            strtolower($mesActual)." del año ".numtoletras($anioActual)." (".$anioActual.
                            ")."), 0, 0, 'L', '', '', true, false);
                    } else {
                        $pdf->SetY(200);
                        $pdf->SetX(24);
                        $pdf->Cell(170, 0, utf8_decode("En testimonio de lo anterior, se firma el presente extracto de acta de grado, en Bogotá, D.C, a"), 0, 0, 'FJ',0);
                        $pdf->SetY(205);
                        $pdf->SetX(24);
                        $pdf->CellFit(200, 0, utf8_decode("los ".numtoletras($diaActual)." (".$diaActual.
                            ") días del mes de ".strtolower($mesActual)." del año ".numtoletras($anioActual)." ("
                            .$anioActual.")."), 0, 0, 'L', '', '', true, false);
                    }

                }else{
                    if ($diaGraduacion == 1) {
                        $pdf->SetY(180);
                        $pdf->SetX(24);
                        $pdf->Cell(170, 0, utf8_decode("En ceremonia solemne del día (".$diaGraduacion.") de ".
                            strtolower($mesGraduacion)." del año ".$anioGraduacion." se le hará entrega del"), 0, 0, 'FJ',0);
                        $pdf->SetY(185);
                        $pdf->SetX(24);
                        $pdf->CellFit(200, 0, utf8_decode("diploma No. ".$registroGrado->getNumeroDiploma().
                            " , el cual aparece registrado con el No. ".$registroGrado->getIdRegistroGrado()." , al folio ".
                            $folioTemporal->getNumeroFolio()." del libro de"), 0, 0, 'L', '', '', true, false);
                        $pdf->SetY(190);
                        $pdf->SetX(24);
                        $pdf->CellFit(200, 0, utf8_decode("registro de títulos de la Universidad, correspondiente al año ,".
                            $anioAcuerdo."."), 0, 0, 'L', '', '', true, false);

                        if ($diaActual == 1) {
                            $pdf->SetY(200);
                            $pdf->SetX(24);
                            $pdf->Cell(170, 0, utf8_decode("En testimonio de lo anterior, se firma el presente extracto de acta de grado, en Bogotá, D.C, "), 0, 0, 'FJ',0);
                            $pdf->SetY(205);
                            $pdf->SetX(24);
                            $pdf->CellFit(200, 0, utf8_decode("el día primero (".$diaActual.") del mes de ".
                                strtolower($mesActual)." del año ".numtoletras($anioActual)." (".$anioActual.")."), 0, 0, 'L', '', '', true, false);
                        } else {
                            $pdf->SetY(200);
                            $pdf->SetX(24);
                            $pdf->CellFit(170, 0, utf8_decode("En testimonio de lo anterior, se firma el presente extracto de acta de grado, en Bogotá, D.C, a"), 0, 0, 'FJ',0);
                            $pdf->SetY(205);
                            $pdf->SetX(24);
                            $pdf->CellFit(200, 0, utf8_decode(" los ".numtoletras($diaActual)."(".
                                $diaActual.") días del mes de ".strtolower($mesActual)." del año ".
                                numtoletras($anioActual)." (".$anioActual.")."), 0, 0, 'L', '', '', true, false);
                        }
                    } else {
                        $pdf->SetY(180);
                        $pdf->SetX(24);
                        $pdf->Cell(170, 0, utf8_decode("En ceremonia solemne del día (".$diaGraduacion.") de ".
                            strtolower($mesGraduacion)." del año ".$anioGraduacion." se le hará entrega del"), 0, 0, 'FJ',0);
                        $pdf->SetY(185);
                        $pdf->SetX(24);
                        $pdf->Cell(170, 0, utf8_decode("diploma No. ".$registroGrado->getNumeroDiploma().
                            " , el cual aparece registrado con el No. ".$registroGrado->getIdRegistroGrado().", al folio ".
                            $folioTemporal->getNumeroFolio()." del libro de"), 0, 0, 'FJ',0);
                        $pdf->SetY(190);
                        $pdf->SetX(24);
                        $pdf->Cell(200, 0, utf8_decode("registro de títulos de la Universidad, correspondiente al año, "
                            .$anioAcuerdo."."), 0, 0, 'L', '', '', true, false);

                        if ($diaActual == 1) {
                            $pdf->SetY(200);
                            $pdf->SetX(24);
                            $pdf->Cell(170, 0, utf8_decode("En testimonio de lo anterior, se firma el presente extracto de acta de grado, en Bogotá, D.C, "), 0, 0, 'FJ',0);
                            $pdf->SetY(205);
                            $pdf->SetX(24);
                            $pdf->CellFit(200, 0, utf8_decode("el día primero (".$diaActual.") del mes de ".
                                strtolower($mesActual)." del año ".numtoletras($anioActual)." (".$anioActual.")."), 0, 0, 'L', '', '', true, false);
                        } else {
                            $pdf->SetY(200);
                            $pdf->SetX(24);
                            $pdf->Cell(170, 0, utf8_decode("En testimonio de lo anterior, se firma el presente extracto de acta de grado, en Bogotá, D.C, a"), 0, 0, 'FJ',0);
                            $pdf->SetY(205);
                            $pdf->SetX(24);
                            $pdf->CellFit(200, 0, utf8_decode("los ".numtoletras($diaActual)."(".$diaActual.
                                ") días del mes de ".strtolower($mesActual)." del año ".numtoletras($anioActual)." (".
                                $anioActual.")."), 0, 0, 'L', '', '', true, false);
                        }
                    }
                }

                $pdf->Image('../css/images/FirmaDraMariaClaraRangel.png', '25', '210', '50', '0');
                $pdf->SetFont('Times-Roman', 'B', 11);
                $pdf->SetY(235);
                $pdf->SetX(24);
                $pdf->CellFit(150, 0, utf8_decode("MARÍA CLARA RANGEL GALVIS"), 0, 0, 'L', '', '', true, false);
                $pdf->Image('../css/images/FirmaDraCristinaMatiz.png', '125', '207', '50', '0');
                $pdf->SetFont('Times-Roman', 'B', 11);
                $pdf->SetY(235);
                $pdf->CellFit(180, 0, utf8_decode("CRISTINA MATIZ MEJIA"), 0, 0, 'R', '', '', true, false);

                $pdf->SetFont('Times-Roman', 'B', 11);
                $pdf->SetY(240);
                $pdf->SetX(24);
                $pdf->CellFit(200, 0, utf8_decode("RECTORA"), 0, 0, 'L', '', '', true, false);
                $pdf->SetY(240);
                $pdf->SetX(55);
                $pdf->CellFit(200, 0, utf8_decode("SECRETARIA GENERAL"), 0, 0, 'C', '', '', true, false);


                $pdf->SetFont('Times-Roman', 'B', 9);
                $pdf->SetY(250);
                $pdf->SetX(24);
                $pdf->CellFit(200, 0, utf8_decode("Av. Cra. 9 No 131A - 02"), 0, 0, 'L', '', '', true, false);

                $pdf->SetY(250);
                $pdf->CellFit(200, 0, utf8_decode("PBX (57 )6489000"), 0, 0, 'C', '', '', true, false);

                $pdf->SetY(250);
                $pdf->CellFit(200, 0, utf8_decode("Bogotá DC - Colombia Sur América"), 0, 0, 'R', '', '', true, false);

                $pdf->SetFont('Times-Roman', '', 9);
                $pdf->SetY(255);
                $pdf->SetX(24);
                $pdf->CellFit(200, 0, utf8_decode(" 018000113033"), 0, 0, 'L', '', '', true, false);
                $pdf->SetY(255);
                $pdf->CellFit(200, 0, utf8_decode("www.uelbosque.edu.co"), 0, 0, 'C', '', '', true, false);
                $pdf->SetY(255);
                $pdf->CellFit(200, 0, utf8_decode(" atencionalusuario@unbosque.co"), 0, 0, 'R', '', '', true, false);

                $pdf->SetFont('Times-Roman', '', 14);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetY(265);
                $pdf->SetX(100);
                $pdf->CellFit(200, 0, utf8_decode("No. ".$numeroactagrado), 0, 0, 'C', '', '', true, false);

                $numeroactagrado++;
                $nameFile = "../documentos/actagrado/AG-".trim($nombreCarrera)."-".$estudiante->getNumeroDocumento()."-".$estudiante->getApellidoEstudiante()."-".$estudiante->getNombreEstudiante().".pdf";
                $pdf->Output($nameFile, 'F');

            }//foreach
            echo "<h2>Para descargar los documentos continue aqui:</h2>";

            $directorio = opendir("../documentos/actagrado/"); //ruta actual
            $contadoFiles=1;
            echo "<table class='table table-bordered'><tr><td>#</td><td>Nombre</td><td>Accion</td></tr>";
            while ($archivo = readdir($directorio)){
                if(!is_dir($archivo)){
                    echo "<tr><td>$contadoFiles</td><td><a href='../documentos/actagrado/$archivo' download='$archivo'>$archivo</a>
                    </td><td><input type=\"checkbox\" name=\"option-1\" id=\"option-1\"><td></tr>";
                    $contadoFiles++;
                }
            }
            echo "</table>";

            break;
        //CERTIFICADO DE INCENTIVOS
        case "8":
            $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>Documento sin título</title>
					<style type="text/css">
						body {
							font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
							background: url("../css/images/marcaAgua5.png");
						    background-repeat: no-repeat;
							background-attachment: fixed;
   							background-position: center; 
						}
					@page { margin: 55px 55px; }
					#footer { position: fixed; left: 0px; bottom: 150px; right: 0px; height: 15px; }
					</style>
					</head>
					<body>';

            function uc_first_aux($str) {
                return ucfirst($str[1]);
            }

            function uc_first($str) {
                return preg_replace_callback('/([a-z]){1}/i', "uc_first_aux", $str, 1);
            }

            foreach ($txtCodigoEstudiantes as $txtCodigoEstudiante) {

                $estudiante = $controlEstudiante->buscarEstudiante($txtCodigoEstudiante);
                $trabajoGrado = $controlTrabajoGrado->buscarTGradoEstudiante($txtCodigoEstudiante);
                $incentivos = $controlRegistroGrado->listarIncentivoEstudianteRegistroGrado($txtCodigoEstudiante, $txtCodigoCarrera);

                if ($estudiante->getGenero()->getCodigo() == 100) {
                    $profesion = $tituloProfesion->getTituloProfesion()->getNombreTituloGenero();
                } else {
                    $profesion = $tituloProfesion->getTituloProfesion()->getNombreTitulo();
                }

                if (count($incentivos) != 0) {
                    $i = 1;
                    foreach ($incentivos as $incentivo) {

                        $anioAcuerdo = date("Y", strtotime($incentivo->getIncentivoAcademico()->getFechaAcuerdoIncentivo()));
                        $diaAcuerdo = date("d", strtotime($incentivo->getIncentivoAcademico()->getFechaAcuerdoIncentivo()));
                        $mes = mes(date("Y-m-d", strtotime($incentivo->getIncentivoAcademico()->getFechaAcuerdoIncentivo())));
                        $anioGraduacion = date("Y", strtotime($incentivo->getIncentivoAcademico()->getFechaAcuerdoIncentivo()));
                        $diaGraduacion = date("d", strtotime($incentivo->getIncentivoAcademico()->getFechaAcuerdoIncentivo()));
                        $mesGraduacion = mes(date("Y-m-d", strtotime($incentivo->getIncentivoAcademico()->getFechaAcuerdoIncentivo())));

                        $html .= '
							
                            <div align="center">
                              <div align="center"><br>
                                <p style="margin-top: -15px;"><img src="../css/images/logo2.png" width="170"  align="center" /></p>
                                <br />
                                <p align="center" style="font-size:18px;"><strong>El Consejo  Directivo de la Universidad El Bosque, en su sesión del día ' . $diaAcuerdo . ' <br />
                                  de ' . strtolower($mes) . ' del  año ' . $anioAcuerdo . ', según consta en el acta N° ' . $incentivo->getIncentivoAcademico()->getNumeroActaAcuerdoIncentivo() . ' y acuerdo<br />
                                N° ' . $incentivo->getIncentivoAcademico()->getNumeroAcuerdoIncentivo() . ' de la  misma fecha,</strong></p>
                                <br />
                                <p style="font-size:18px;"><strong>confiere a:</strong></p>
                                <br/>
                                <p><span style="font-size:24px;"><strong>' . pasarMayusculas($estudiante->getNombreEstudiante() . " " . $estudiante->getApellidoEstudiante()) . '</strong></span><br />';
                        if ($estudiante->getTipoDocumento()->getIniciales() == "05") {
                            $html .= '<span style="font-size:16px;">' . $estudiante->getTipoDocumento()->getDescripcion() . ' No. ' . $estudiante->getNumeroDocumento() . ' de ' . $estudiante->getExpedicion() . '</span></p>';
                        } else {
                            $html .= '<span style="font-size:16px;">' . substr($estudiante->getTipoDocumento()->getDescripcion(), 0, 1) . '.' . substr($estudiante->getTipoDocumento()->getDescripcion(), 1, 1) . '. No. ' . number_format($estudiante->getNumeroDocumento(), 0, '', '.') . ' de ' . $estudiante->getExpedicion() . '</span></p>';
                        }
                        $html .= '<br><br>
							    <p align="center" style="font-size:26px;"><strong>' . pasarMayusculas($incentivo->getIncentivoAcademico()->getNombreIncentivo()) . '</strong></p><br />';
                        if ($incentivo->getIncentivoAcademico()->getCodigoIncentivo() == 3) {
                            $html .= '<p align="center" style="line-height:175%;font-size:14px;">Por haber obtenido el promedio de calificaciones más alto,  de la <br />
							    ' . num2toordinal($incentivo->getNumeroPromocion()) . ' promoción del programa de ' . convertirBogota(capitalizar(strtolower_utf8($carrera->getNombreCortoCarrera()))) . '.</p>';
                        } else {
                            $html .= '<p align="center" style="line-height:175%;font-size:14px;">En reconocimiento por su trabajo de investigación denominado: <br />';

                            $nombreIncentivoObservacion = $incentivo->getIncentivoAcademico()->getObservacionIncentivo();
                            $identificadorPunto = substr($nombreIncentivoObservacion, -1);

                            if ($identificadorPunto == '.') {
                                $nombreIncentivoObservacion = substr($nombreIncentivoObservacion, 0, -1);
                            }

                            $html .= $nombreIncentivoObservacion . ', <br />
                                    presentado para optar al título de ' . convertirBogota(capitalizar(strtolower_utf8($profesion))) . '.</p>';
                        }
                        $html .= '<p style="font-size:16px;" ><i>Dado en Bogotá, D.C., a los ' . numtoletras($diaGraduacion) . ' (' . $diaGraduacion .
                            ') días del mes de ' . strtolower($mesGraduacion) . ' del año ' . numtoletras($anioGraduacion) . ' ('. $anioGraduacion . ')</i></p><br />';

                        $html .= '';
                        $html .= '<div id="footer">                            
							<table width="100%" style="font-size:12px; text-align= center;">
				                	<tr>
				                        <td>
				                            <div align="center">
                                                <img src="../css/images/FirmaDraMariaClaraRangel.png" width="80" height="60">
                                                <br>
                                                <strong>Rectora</strong>
				                            </div>
                                        </td>
                                    <td>
				                        <div align="center">
				                            <img src="../css/images/FirmaDrCamiloEscobar.jpeg" width="80" height="60">
				                            <br>
				                            <strong>Presidente de el <br />Consejo Directivo</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div align="center">
                                            <img src="../css/images/FirmaDraRitaCecilia.png" width="100" height="70">
                                            <br>
                                            <strong>Vicerrectora<br />Académica</strong>
                                        </div>
                                    </td>
                                </tr>                                
                            </table>
                            <table width="100%" style="font-size:12px; text-align= center;">
                                <tr>
                                    <td>
                                        <div align="center">
                                            <img src="../css/images/FirmaHugoCardenas.png" width="80" height="60">
                                            <br>
                                            <strong>Decano</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div align="center">
                                            <img src="../css/images/FirmaDraCristinaMatiz.png" width="90" height="60">
                                            <br>
                                            <strong>Secretaria General</strong>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" style="font-size:10px; text-align= center;">
                                <tr>
                                    <td ><div align="center"><strong></strong></div></td>
                                    <td><div align="center"><strong>' . $incentivo->getIncentivoAcademico()->getNumeroConsecutivoIncentivo() . '</strong></div></td>
                                    <td ><div align="center"><strong></strong></div></td>
                                </tr>
                            </table>
                            <br />
                            <p align="justify" style="font-size: 8px;">Personería Jurídica Resolución N° 11153 del 4 de agosto de 1978 expedida por el Ministerio de Educación Nacional. - Vigilada Mineducación</p>
                        </div>
                        </div>
                    </div>
                <div style="page-break-after: always;"></div>';
                    }
                }
            }
            $html .= '</body>
		      </html>';
            $filename = "mencionHonor" . $nombreCarrera . ".pdf";

            $dompdf = new DOMPDF();
            $dompdf->set_paper("letter", "portrait");
            $dompdf->load_html($html); //cargamos el html
            $dompdf->render(); //renderizamos
            $dompdf->stream($filename);
            break;
    }
}
?>