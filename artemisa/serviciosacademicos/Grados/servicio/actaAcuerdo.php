<?php

/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package servicio
 */
header('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//sini_set('display_errors', 'On');
session_start();

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

function unserializeForm($str) {
    $strArray = explode("&", $str);
    foreach ($strArray as $item) {
        $array = explode("=", $item);
        $returndata[] = $array[1];
    }
    return $returndata;
}

function unserializeForm2($str) {
    $strArray = explode("&", $str);
    foreach ($strArray as $item) {
        $array = explode("%2C", $item);
        $array = str_replace("ckSeleccionarAcuerdo=", "", $array);
        $returndata[] = $array;
    }
    return $returndata;
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

switch ($tipoOperacion) {

    case "crearActaAcuerdo":
        $actaAcuerdo = new ActaAcuerdo($persistencia);
        $actaAcuerdo->setNumeroActa($txtNumeroActa);
        $actaAcuerdo->setFechaActa($txtFechaActa);
        $fechaGrado = new FechaGrado(null);
        $fechaGrado->setIdFechaGrado($txtFechaGrado);
        $actaAcuerdo->setFechaGrado($fechaGrado);
        $controlActaAcuerdo->crearActaAcuerdo($actaAcuerdo, $idPersona);
        $lastId = $persistencia->lastId();
        $txtCodigoEstudiantes = unserializeForm($txtCodigoEstudiantes);

        foreach ($txtCodigoEstudiantes as $txtCodigoEstudiante) {

            $detalleActaAcuerdo = new DetalleActaAcuerdo($persistencia);
            $actaAcuerdo = new ActaAcuerdo($persistencia);
            $actaAcuerdo->setIdActaAcuerdo($lastId);
            $estudiante = new Estudiante($persistencia);
            $estudiante->setCodigoEstudiante($txtCodigoEstudiante);
            $detalleActaAcuerdo->setActaAcuerdo($actaAcuerdo);
            $detalleActaAcuerdo->setEstudiante($estudiante);
            $controlActaAcuerdo->crearDetalleActaAcuerdo($detalleActaAcuerdo, $idPersona);
        }


        break;

    case "anularActaEstudiante":

        $txtIdDetalleActas = unserializeForm($txtIdDetalleActas);

        foreach ($txtIdDetalleActas as $txtIdDetalleActa) {

            $detalleActaAcuerdo = new DetalleActaAcuerdo($persistencia);

            $detalleActaAcuerdo->setIdDetalleActaAcuerdo($txtIdDetalleActa);

            $actualizarActa = $controlActaAcuerdo->anularActa($detalleActaAcuerdo);

            $detalleActaAcuerdo = $controlActaAcuerdo->buscarEstudianteDetalleActaId($txtIdDetalleActa);
            $txtCodigoEstudiante = $detalleActaAcuerdo->getEstudiante()->getCodigoEstudiante();

            $controlIncentivo = new ControlIncentivoAcademico($persistencia);
            $incentivos = $controlIncentivo->listarIncentivoEstudiante($txtCodigoEstudiante, $txtCodigoCarrera);
            //echo count($incentivos);
            if (count($incentivos) != 0) {
                foreach ($incentivos as $incentivo) {
                    $txtIdRegistroIncentivo = $incentivo->getIdIncentivo();
                    if ($txtIdRegistroIncentivo != "") {
                        $controlIncentivo->actualizarIncentivos($txtIdRegistroIncentivo, $idPersona);
                    }
                }
            }

        }

        break;


    case "registrarIncentivo":

        $txtCodigoIncentivos = unserializeForm($txtCodigoIncentivos);

        foreach ($txtCodigoIncentivos as $txtCodigoIncentivo) {

            $controlIncentivo = new ControlIncentivoAcademico($persistencia);
            $incentivo = $controlIncentivo->buscarIncentivoId($txtCodigoIncentivo);
            $txtNombreIncentivo = $incentivo->getNombreIncentivo();
            $existeIncentivo = $controlIncentivo->existeIncentivo($txtCodigoEstudiante, $txtCodigoIncentivo, $txtCodigoCarrera);

            if ($existeIncentivo != 1) {
                $controlIncentivo->crearRegistroIncentivo($txtCodigoEstudiante, $txtCodigoIncentivo, $txtCodigoCarrera, $txtNombreIncentivo, $txtNumeroIncentivo, $txtFechaActaIncentivo, $txtObservacionIncentivo, $idPersona);
                echo $existeIncentivo;
            } else {
                echo $existeIncentivo;
            }
        }

        break;

    case "crearAcuerdo":

        $txtIdActasEstudiantes = unserializeForm2($txtIdActas);

        $txtIdActaSeleccionadas = array();
        $txtCodigoEstudianteSeleccionados = array();
        foreach ($txtIdActasEstudiantes as $txtIdActasEstudiante) {
            $txtIdActaSeleccionadas[count($txtIdActaSeleccionadas)] = $txtIdActasEstudiante[0];
            $txtCodigoEstudianteSeleccionados[count($txtCodigoEstudianteSeleccionados)] = $txtIdActasEstudiante[1];
        }
        $txtIdActas = $txtIdActaSeleccionadas;
        $txtCodigoEstudiantes = $txtCodigoEstudianteSeleccionados;
        foreach ($txtIdActas as $txtIdActa) {
            $actaAcuerdo = $controlActaAcuerdo->buscarActaId($txtFechaGrado, $txtIdActa, $txtCodigoCarrera);

            $txtNumero = $actaAcuerdo->getNumeroAcuerdo();

            if ($txtNumero == 0) {
                $actualizaAcuerdo = $controlActaAcuerdo->actualizarAcuerdo($txtNumeroAcuerdo, $txtFechaAcuerdo, $txtNumeroActaAcuerdo, $idPersona, $txtIdActa);
            }
            foreach ($txtCodigoEstudiantes as $txtCodigoEstudiante) {
                $controlActaAcuerdo->actualizarDetalleAcuerdo($txtIdActa, $txtCodigoEstudiante);
            }
        }

        break;

    case "anularAcuerdoEstudiante":

        $txtIdDetalleActas = unserializeForm($txtIdDetalleActas);

        foreach ($txtIdDetalleActas as $txtIdDetalleActa) {

            $controlActaAcuerdo->anularAcuerdo($txtIdDetalleActa);
        }

        break;
}
?>