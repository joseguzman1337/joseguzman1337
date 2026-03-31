<?php

/**
 * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package servicio
 */
header('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

ini_set('display_errors', 'On');
session_start();

include '../tools/includes.php';

include '../control/ControlCarrera.php';
include '../control/ControlItem.php';
include '../control/ControlPeriodo.php';
include '../control/ControlFacultad.php';
include '../control/ControlTipoDocumento.php';
include '../control/ControlContacto.php';
//include '../control/ControlEstudiante.php';
include '../control/ControlTrabajoGrado.php';
include '../control/ControlConcepto.php';
include '../control/ControlDocumentacion.php';
include '../control/ControlFechaGrado.php';
include '../control/ControlTipoGrado.php';

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

$controlFechaGrado = new ControlFechaGrado($persistencia);


switch ($tipoOperacion) {

    case "crearFechaGrado":

        /* Mofied Diego Rivera <riveradiego@unbosque.edu.co>
         * Se añade validacion para registrar todos los programas de pregrado y posgrado de la facultad seleccionada 
         * Since July 25, 2017 
         */

        if ($cmbCarrera == 'pregrados' or $cmbCarrera == 'posgrados') {

            $controlCarrera = new ControlCarrera($persistencia);
            $modalidad = '';

            if ($cmbCarrera == 'pregrados') {
                $modalidad = 200;
            } else {
                $modalidad = 300;
            }

            $carreras = $controlCarrera->buscarCarreras($modalidad, $cmbFacultad);

            foreach ($carreras as $carrera) {
                $cmbCarrera = $carrera->getCodigoCarrera();

                $fechaGrado = new FechaGrado($persistencia);
                $fechaGrado->setFechaGraduacion($fechaGraduacion);
                $fechaGrado->setFechaMaxima($fechaMaxCumplimiento);

                $carrera = new Carrera(null);
                $carrera->setCodigoCarrera($cmbCarrera);

                $fechaGrado->setCarrera($carrera);

                $periodo = new Periodo(null);
                $periodo->setCodigo($cmbPeriodo);

                $fechaGrado->setPeriodo($periodo);

                $tipoGrado = new TipoGrado(null);
                $tipoGrado->setIdTipoGrado($cmbTipoGrado);

                $fechaGrado->setTipoGrado($tipoGrado);

                $error = $controlFechaGrado->validar($fechaGrado);

                if ($error == "") {
                    $controlFechaGrado->actualizar($fechaGrado, $idPersona);
                } else {
                    echo $error;
                }
            }
        } else {

            $fechaGrado = new FechaGrado($persistencia);
            $fechaGrado->setFechaGraduacion($fechaGraduacion);
            $fechaGrado->setFechaMaxima($fechaMaxCumplimiento);

            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($cmbCarrera);

            $fechaGrado->setCarrera($carrera);

            $periodo = new Periodo(null);
            $periodo->setCodigo($cmbPeriodo);

            $fechaGrado->setPeriodo($periodo);

            $tipoGrado = new TipoGrado(null);
            $tipoGrado->setIdTipoGrado($cmbTipoGrado);

            $fechaGrado->setTipoGrado($tipoGrado);
            $error = $controlFechaGrado->validar($fechaGrado);

            if ($error == "") {
                $controlFechaGrado->actualizar($fechaGrado, $idPersona);
            } else {
                echo $error;
            }
        }

        break;

    /* MOdified Diego Rivera <riveradiego@unbosque.edu.co>
     * Se crea case acutalizarfechagrado este realizara el proceso de acutalizacion de fechas de grado
     */
    case "actualizarFechaGrado":

         
            $fechaGrado = new FechaGrado($persistencia);
            $fechaGrado->setFechaGraduacion($fechaGraduacion);
            $fechaGrado->setFechaMaxima($fechaMaxCumplimiento);
                        
            $periodo = new Periodo(null);
            $periodo->setCodigo($cmbPeriodo);
            $fechaGrado->setPeriodo($periodo);

            $tipoGrado = new TipoGrado(null);
            $tipoGrado->setIdTipoGrado($cmbTipoGrado);
            $fechaGrado->setTipoGrado($tipoGrado);
            
            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($cmbCarrera);
            
            $fechaGrado->setCarrera($carrera);
            
            $error = $controlFechaGrado->validar($fechaGrado);

            if ($error == "") {
                $controlFechaGrado->fechaGradoActualizar($fechaGrado, $idPersona, $fechaGraduacion, $fechaMaxCumplimiento,$idfechaGrado);
            } else {
                echo $error;
            }



        break;

    case "fechagradocarrera":
        $filtroFecha = "";
        $filtroFecha .= " AND F.CarreraId = " . $idCarrera . " AND F.CodigoPeriodo=" . $idPeriodo . " AND TipoGradoId=" . $idTipoGrado . "";
        $fechasGrados = $controlFechaGrado->consultarFechaGrado($filtroFecha);
        echo "<option value='-1'>Seleccione Fecha de Grado</option>";

        foreach ($fechasGrados as $fechaGrado) {
            echo "<option value='" . $fechaGrado->getIdFechaGrado() . "'>" . $fechaGrado->getFechaGraduacion() . "</option>";
        }

        break;

    case "consultarFechaGrado":
        ?>
        <script src="../js/MainFechaGrado.js"></script>
        <?php

        $filtroFecha = "";

        if ($cmbFacultad != -1) {
            $filtroFecha .= " AND FC.codigofacultad = " . $cmbFacultad . "";
        }

        /* Modified Diego Rivera <riveradiego@unbosque.edu.co>
         * Se añade validion con el fin de que cargue todos los pregrados y postgrados de la facultad selccionada
         * antes de modificar   if( $cmbCarrera != -1 ) se añaden los else if dependiendo el filtro 
         * Since July 25 , 2017 
         */
        if ($cmbCarrera != -1 and $cmbCarrera != 'pregrados' and $cmbCarrera != 'posgrados') {
            $filtroFecha .= " AND C.codigocarrera = " . $cmbCarrera . "";
        } else if ($cmbCarrera == 'pregrados') {
            $filtroFecha .= " AND C.codigomodalidadacademica = 200 ";
        } else if ($cmbCarrera == 'posgrados') {
            $filtroFecha .= " AND C.codigomodalidadacademica = 300 ";
        }
        // fin Modificacion

        if ($cmbPeriodo != -1) {
            $filtroFecha .= " AND F.codigoperiodo = " . $cmbPeriodo . "";
        }

        if ($fechaGraduacion != "") {
            $filtroFecha .= " AND F.FechaGrado = '" . $fechaGraduacion . "'";
        }

        if ($fechaMaxCumplimiento != "") {
            $filtroFecha .= " AND F.FechaMaximaCumplimiento = '" . $fechaMaxCumplimiento . "'";
        }

        if ($cmbTipoGrado != -1) {
            $filtroFecha .= " AND F.TipoGradoId = " . $cmbTipoGrado . "";
        }

        $fechasGrados = $controlFechaGrado->consultarFechaGrado($filtroFecha);
        $i = 1;
        if (count($fechasGrados != 0)) {

            echo "<div style=\"overflow: auto; width: 100%; top: 0px; height: 100%\">
					<table border=\"0\" id=\"fechasGrados\" cellpadding=\"0\" cellspacing=\"0\" class=\"display\" >
						<thead>
							<tr >
								<th>No</th>
								<th>Carrera</th>
								<th>Fecha de Ceremonia de Grado</th>
								<th>Fecha Máxima de Cumplimiento</th>
								<th>Tipo de Grado</th>
								<th>Período Académico</th>
                                                                <th>Editar</th>
							</tr>
						</thead>
					<tbody class=\"listaRadicaciones\" >";
            /* END */

            $imgActualizar = "../css/images/vcard_edit.png";
            foreach ($fechasGrados as $fechasGrado) {
                
                $idFechaGrado=$fechasGrado->getIdFechaGrado();  
                $fechaGrado=date("Y-m-d", strtotime($fechasGrado->getFechaGraduacion()));
                $fechaCumplimiento=date("Y-m-d", strtotime($fechasGrado->getFechaMaxima())); 
                $carrera=$fechasGrado->getCarrera()->getCodigoCarrera();
                $facultad=$fechasGrado->getCarrera()->getFacultad();
                $periodo=$fechasGrado->getPeriodo()->getCodigo();
                $tipoGrado=$fechasGrado->getTipoGrado()->getIdTipoGrado();
                echo "<tr>";
                echo "<td>" . $i++ . "</td>";
                echo "<td >" . $fechasGrado->getCarrera()->getNombreCarrera() . "</td>";
                echo "<td align=\"center\" >" .$fechaGrado . "</td>";
                echo "<td align=\"center\">" .$fechaCumplimiento . "</td>";
                echo "<td align=\"center\">" . $fechasGrado->getTipoGrado()->getNombreTipoGrado() . "</td>";
                echo "<td align=\"center\">" . $periodo . "</td>";
                echo "<td align=\"center\">" . "<input type=\"button\" class=\"editar\" name=\"btnEditar\" attr-carrera=\"$carrera\" attr-tipo=\"$tipoGrado\" attr-periodo=\"$periodo\" attr-facultad=\"$facultad\"   attr-id=\"$idFechaGrado\" attr-fechagrado=\"$fechaGrado\" attr-fechacumplimiento=\"$fechaCumplimiento\" title=\"Actualizar Fecha Grado\"  style=\"background:url($imgActualizar) no-repeat; border:none; margin-top:0.3cm; width:30px; height:30px; cursor:pointer;\"></td>";
                echo "</tr>";
            }
            echo "</tbody>";

            echo "</table>";
            echo "</div>";
        }
}
?>