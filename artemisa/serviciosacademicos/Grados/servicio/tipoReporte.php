

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
set_time_limit(0);

session_start();

include '../lib/nuSoap5/nusoap.php';

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
include '../control/ControlActaGrado.php';
include '../control/ControlRegistroGrado.php';
include '../control/ControlFolioTemporal.php';
/* Modified Diego Rivera <riveradiego>
 * Se inclye ControlIncentivoAcademico con el fin de evitar error de objeto redeclarado
 * Since august 16 ,2017
 */

include '../control/ControlIncentivoAcademico.php';

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

$controlIncentivo = new ControlIncentivoAcademico($persistencia);

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

$controlEstudiante = new ControlEstudiante($persistencia);
$controlRegistroGrado = new ControlRegistroGrado($persistencia);
$controlFolioTemporal = new ControlFolioTemporal($persistencia);
$controlCarrera = new ControlCarrera($persistencia);

switch ($tipoOperacion) {

    case "consultarCeremoniaEgresados":

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

        if ($cmbPeriodoTReporte != -1) {
            $filtro .= " AND F.CodigoPeriodo = " . $cmbPeriodoTReporte . "";
        }

        if ($cmbTipoGradoTReporte != -1) {
            $filtro .= " AND F.TipoGradoId = " . $cmbTipoGradoTReporte . "";
        }

        $registroGrados = $controlRegistroGrado->consultarCeremoniaEgresados($filtro);
        $i = 1;

        if (count($registroGrados) != 0) {
            ?>
            <script src="../js/MainTipoReporte.js"></script>

            <?php
            /**
             * @modified Diego Rivera<riveradiego@unbosque.edu.co>
             * Se añade columna Trabajo de grado con el fin de visualizar el nombre del trabajo de grado
             * @since May 20,2019
             */
            echo "
                <div style=\"width: 100%; top: 0px; height: 100%px; border: 1px; border-style: solid groove; border-radius: 4px; border-color: #aaaaaa;\">
                    <table id=\"estudianteCeremoniaEgresados\" width=\"100%\" border=\"0\"  >
                        <thead>
                            <tr >
                                    <th style=\"width: 5%;\" >No</th>
                                    <th>Universidad</th>
                                    <th>Sede</th>
                                    <th>Título</th>
                                    <th>Tipo de Documento</th>
                                    <th>Numero de Documento</th>
                                    <th>Nombres Graduado</th>
                                    <th>Apellidos Graduado</th>
                                    <th>Fecha Grado</th>
                                    <th>Trabajo de Grado</th>
                                    <th>Tipo Incentivo</th>
                                    <th>Incentivo</th>
                                    <th>Número Registro</th>
                                    <th>Número Acta</th>
                                    <th>Número Acuerdo</th> 
                                    <th>Número Diploma</th>
                                    <th>Folio</th>
                            </tr>
                        </thead>
                    <tbody class=\"listaEstudiantes\">";
            foreach ($registroGrados as $registroGrado) {
                $estadoIncentivo = $registroGrado->getIncentivoAcademico()->getEstadoIncentivo();

                if ($estadoIncentivo == 100 or $estadoIncentivo == '') {
                    $folioTemporal = $controlFolioTemporal->buscarFolioTemporal($registroGrado->getIdRegistroGrado());

                    echo "<tr>";
                    echo "<td align=\"center\">" . $i++ . "</td>";
                    echo "<td>UNIVERSIDAD EL BOSQUE</td>";
                    echo "<td>BOGOTÁ</td>";
                    echo "<td>" . $registroGrado->getActaAcuerdo()->getFechaGrado()->getCarrera()->getTituloProfesion()->getNombreTitulo() . "</td>";
                    echo "<td>" . $registroGrado->getEstudiante()->getTipoDocumento()->getIniciales() . "</td>";
                    echo "<td>" . $registroGrado->getEstudiante()->getNumeroDocumento() . "</td>";
                    echo "<td>" . $registroGrado->getEstudiante()->getNombreEstudiante() . "</td>";
                    echo "<td>" . $registroGrado->getEstudiante()->getApellidoEstudiante() . "</td>";
                    echo "<td>" . date("Y-m-d", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo())) . "</td>";
                    echo "<td>" . $registroGrado->getTrabjoGrado() . "</td>";
                    echo "<td>" . $registroGrado->getIncentivoAcademico()->getNombreIncentivo() . "</td>";
                    echo "<td>" . $registroGrado->getIncentivoAcademico()->getObservacionIncentivo() . "</td>";
                    echo "<td>" . $registroGrado->getIdRegistroGrado() . "</td>";
                    echo "<td>" . $registroGrado->getActaAcuerdo()->getNumeroActaConsejoDirectivo() . "</td>";
                    echo "<td>" . $registroGrado->getActaAcuerdo()->getNumeroAcuerdo() . "</td>";
                    echo "<td>" . $registroGrado->getNumeroDiploma() . "</td>";
                    echo "<td>" . $folioTemporal->getNumeroFolio() . "</td>";
                    echo "</tr>";
                }
            }
            echo "</tbody>";
            echo "</table>";
            echo "<br />";
            echo "</div>";
            /* Modified Diego Rivera <riveradiego@unbosque.edu.co>
             * Se añada else con el fin de realizar llamdo de jquery  para cuando la consulta retorna 0 esta permite activar el evento click del boton para seguir realizando consultas
             */
        } else {
            ?>

            <script src="../js/MainTipoReporte.js"></script>
            <?php
        }

        break;

    case "consultarNumeroGraduados":
        $filtro = "";
        $filtroSubConsulta = "";

        /* Modified Diego Rivera <riveradiego>
         * Se añande validacion con el fin de identificar la forma de consulta si es por modalidad o por carrera 
         * Se crea variabre $filtroSubConsulta con el fin de añadir los parametros a la subconsulta 
         * */

        if ($cmbFacultadTReporte != -1) {
            $filtro .= " AND FT.codigofacultad = " . $cmbFacultadTReporte . "";
            $filtroSubConsulta .= " AND FT.codigofacultad = " . $cmbFacultadTReporte . "";
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
            ?>
            <script src="../js/MainTipoReporte.js"></script>
            <?php
            echo "
                <div style=\"width: 100%; top: 0px; height: 100%px; border: 1px; border-style: solid groove; border-radius: 4px; border-color: #aaaaaa;\">
                <table id=\"estudianteCeremoniaEgresados\" width=\"100%\" border=\"0\"  >
                    <thead>
                        <tr >
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

                echo "<tr>";
                echo "<td align=\"center\">" . $i++ . "</td>";
                echo "<td>" . $registroGrado->getActaAcuerdo()->getFechaGrado()->getCarrera()->getNombreCarrera() . "</td>";
                echo "<td>" . $mujer . "</td>";
                echo "<td>" . $hombre . "</td>";
                echo "<td>" . $registroGrado->getIdRegistroGrado() . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "<br />";
            echo "</div>";
        } else {
            ?>
            <script src="../js/MainTipoReporte.js"></script>
            <?php
        }
        break;

    case "consultarTarjetaProfesional":



        $filtro = "";

        if ($cmbFacultadTReporte != -1) {
            $filtro .= " AND FT.codigofacultad = " . $cmbFacultadTReporte . "";
        }

        /* 	if( $cmbCarreraTReporte != -1){
          $filtro .= " AND C.codigocarrera = ".$cmbCarreraTReporte."";
          } */

        if ($cmbCarreraTReporte != -1) {

            if ($cmbCarreraTReporte == 'pregrados') {

                $filtro .= " AND C.codigomodalidadacademica = 200";
            } else if ($cmbCarreraTReporte == 'posgrados') {

                $filtro .= " AND C.codigomodalidadacademica = 300";
            } else {

                $filtro .= " AND C.codigocarrera = " . $cmbCarreraTReporte . "";
            }
        }

        if ($cmbPeriodoTReporte != -1) {
            $filtro .= " AND F.CodigoPeriodo = " . $cmbPeriodoTReporte . "";
        }

        if ($cmbTipoGradoTReporte != -1) {
            $filtro .= " AND F.TipoGradoId = " . $cmbTipoGradoTReporte . "";
        }

         $registroGrados = $controlRegistroGrado->consultarCeremoniaEgresados($filtro);

        if (count($registroGrados) == 0) {
            echo 0;
        } else {

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
                ?>
                <script src="../js/MainTipoReporte.js"></script>
                <?php
                echo "
			<div style=\"width: 100%; top: 0px; height: 100%px; border: 1px; border-style: solid groove; border-radius: 4px; border-color: #aaaaaa;\">
			<br />
                        <table width=\"100%\" border=\"0\">
                          <tr>
                            <td>Fecha de Grado: ";
                if (count($actaAcuerdos) > 1) {
                    foreach ($actaAcuerdos as $actaAcuerdo) {
                        $anioGrado = date("Y", strtotime($actaAcuerdos[$cuentaAcuerdo]->getFechaAcuerdo()));
                        $diaGrado = date("d", strtotime($actaAcuerdos[$cuentaAcuerdo]->getFechaAcuerdo()));
                        $mes = mes($actaAcuerdos[$cuentaAcuerdo]->getFechaAcuerdo());
                        echo $mes . " " . $diaGrado . " " . "de" . " " . $anioGrado . " ";
                        $cuentaAcuerdo = $cuentaAcuerdo + 1;
                    }
                } else {
                    $anioGrado = date("Y", strtotime($actaAcuerdos[0]->getFechaAcuerdo()));
                    $diaGrado = date("d", strtotime($actaAcuerdos[0]->getFechaAcuerdo()));
                    $mes = mes($actaAcuerdos[0]->getFechaAcuerdo());
                    echo $mes . " " . $diaGrado . " " . "de" . " " . $anioGrado . " ";
                } echo "</td>
			<td>Acuerdo: ";
                if (count($actaAcuerdos) > 1) {
                    foreach ($actaAcuerdos as $actaAcuerdo) {
                        echo $actaAcuerdos[$cuentaAcuerdo2]->getNumeroAcuerdo() . " ";
                        $cuentaAcuerdo2 = $cuentaAcuerdo2 + 1;
                    }
                } else {
                    echo $actaAcuerdos[0]->getNumeroAcuerdo();
                } echo "</td>
			<td>Acta: ";
                if (count($actaAcuerdos) > 1) {
                    foreach ($actaAcuerdos as $actaAcuerdo) {
                        echo $actaAcuerdos[$cuentaAcuerdo3]->getNumeroActaConsejoDirectivo() . " ";
                        $cuentaAcuerdo3 = $cuentaAcuerdo3 + 1;
                    }
                } else {
                    echo $actaAcuerdos[0]->getNumeroActaConsejoDirectivo();
                } echo "</td>
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
                                <th>Título Otorgado</th>
                                <th>Diploma</th>
                                <th>Folio</th>
                            </tr>
                          </thead>
                          <tbody>";
                foreach ($registroGrados as $registroGrado) {

                    $folioTemporal = $controlFolioTemporal->buscarFolioTemporal($registroGrado->getIdRegistroGrado());

                    echo "<tr>";
                    echo "<td align=\"center\">" . $registroGrado->getIdRegistroGrado() . "</td>";
                    echo "<td>" . $registroGrado->getEstudiante()->getApellidoEstudiante() . " " . $registroGrado->getEstudiante()->getNombreEstudiante() . "</td>";
                    echo "<td>" . $registroGrado->getEstudiante()->getNumeroDocumento() . "</td>";
                    echo "<td>" . $registroGrado->getActaAcuerdo()->getFechaGrado()->getCarrera()->getNombreCarrera() . "</td>";
                    echo "<td>" . $registroGrado->getActaAcuerdo()->getFechaGrado()->getCarrera()->getTituloProfesion()->getNombreTitulo() . "</td>";
                    echo "<td>" . $registroGrado->getNumeroDiploma() . "</td>";
                    echo "<td>" . $folioTemporal->getNumeroFolio() . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "<br />";
                echo "</div>";
            }
        }

        break;
    /* Modified Diego Rivera<riveradiego@unbosque.edu.co>
     * se añade caso generarCarta  permite diligenciar datos al remitente  y para proceder a generar carta dependiendo los parametros seleccionados (facultad,carrera , periodo , tipo de grado)
     * Since february 28 ,2018
     */
    case "generarCarta":

        $filtro = "";
        $filtro .= " AND FT.codigofacultad = " . $cmbFacultadTReporte . "";

        if ($cmbCarreraTReporte == 'pregrados') {

            $filtro .= " AND C.codigomodalidadacademica = 200";
        } else if ($cmbCarreraTReporte == 'posgrados') {

            $filtro .= " AND C.codigomodalidadacademica = 300";
        } else if ($cmbCarreraTReporte == 123 or $cmbCarreraTReporte == 124) {

            $filtro .= " AND C.codigocarrera in( 123 , 124 ) ";
        } else if ($cmbCarreraTReporte == 118 or $cmbCarreraTReporte == 119) {

            $filtro .= " AND C.codigocarrera in( 118 , 119 ) ";
        } else if ($cmbCarreraTReporte == 133 or $cmbCarreraTReporte == 134 or $cmbCarreraTReporte == 143) {

            $filtro .= " AND C.codigocarrera in( 133 , 134 , 143 ) ";
        } else {

            $filtro .= " AND C.codigocarrera = " . $cmbCarreraTReporte;
        }



        $filtro .= " AND F.CodigoPeriodo = " . $cmbPeriodoTReporte . "";
        $filtro .= " AND F.TipoGradoId = " . $cmbTipoGradoTReporte . "";

        $registroGrados = $controlRegistroGrado->detalleConsultarActaAcuerdos($filtro);
        ?>
        <script src="../js/MainTipoReporte.js"></script>
        <form name="pdfCarta" id="pdfCarta" action="../servicio/pdf.php">
            <input type="hidden" name="tipoOperacion" id="tipoOperacion" value="generarCartaEntidades">
            <input type="hidden" name="txtCartaFacultad" id="txtCartaFacultad" value="<?php echo $cmbFacultadTReporte ?>">
            <input type="hidden" name="txtCartaCarrera" id="txtCartaCarrera" value="<?php echo $cmbCarreraTReporte ?>">
            <input type="hidden" name="txtCartaPeriodo" id="txtCartaPeriodo" value="<?php echo $cmbPeriodoTReporte ?>">
            <input type="hidden" name="TxtCartaTipoGrado" id="TxtCartaTipoGrado" value="<?php echo $cmbTipoGradoTReporte ?>">

            Nombres : <input type="text" name="nombres" id="nombres" size="50" autocomplete="off"><br><br>
            Apellidos : <input type="text" name="apellidos" id="apellidos" size="50" autocomplete="off"><br><br>
            Cargo : <input type="text" name="cargo" id="cargo" size="50" autocomplete="off"><br><br>
            Entidad : <input type="text" name="entidad" id="entidad" size="50" autocomplete="off"><br><br>

            <?php
            if ($cmbCarreraTReporte == 'pregrados' or $cmbCarreraTReporte == 'posgrados') {
                
            } else {
                ?>
                Graduado :<br/><select name="cbmEgresados" id="cbmEgresados">
                    <option value="todos">Todos</option>
                    <?php
                    foreach ($registroGrados as $registroGrado) {
                        $codigoEstudiante = $registroGrado->getIdRegistroGrado();
                        $nombreEstudiante = $registroGrado->getEstudiante()->getApellidoEstudiante() . " " . $registroGrado->getEstudiante()->getNombreEstudiante();
                        ?>
                        <option value="<?php echo $codigoEstudiante ?>"><?php echo $nombreEstudiante; ?></option>
                    <?php } ?>
                </select><br><br>
                <?php
            }
            ?>
            <input id="btnExportarCarta" value="Exportar PDF"  class="ui-button ui-widget ui-state-default ui-corner-all" role="button" aria-disabled="false">
            <div id="carga" style="display:none;text-align: center;">
                <img src="../css/images/cargando.gif" />
            </div>

        </form>	

        <?php
        break;
    /* Modified Diego Rivera<riveradiego@unbsoque.edu.co>
     * Se añade caso generarcertificado (cargar estudiantes de programa seleccionado para generar ceritificados en bloque o individual)
     * March 09 ,2018
     */

    case "generarCertificado":
        $filtro = "";
        $filtro .= " AND FT.codigofacultad = " . $cmbFacultadTReporte . "";

        if ($cmbCarreraTReporte == 'pregrados') {

            $filtro .= " AND C.codigomodalidadacademica = 200";
        } else if ($cmbCarreraTReporte == 'posgrados') {

            $filtro .= " AND C.codigomodalidadacademica = 300";
        } else if ($cmbCarreraTReporte == 123 or $cmbCarreraTReporte == 124) {

            $filtro .= " AND C.codigocarrera in( 123 , 124 ) ";
        } else if ($cmbCarreraTReporte == 118 or $cmbCarreraTReporte == 119) {

            $filtro .= " AND C.codigocarrera in( 118 , 119 ) ";
        } else if ($cmbCarreraTReporte == 133 or $cmbCarreraTReporte == 134 or $cmbCarreraTReporte == 143) {

            $filtro .= " AND C.codigocarrera in( 133 , 134 , 143 ) ";
        } else {

            $filtro .= " AND C.codigocarrera = " . $cmbCarreraTReporte;
        }

        $filtro .= " AND F.CodigoPeriodo = " . $cmbPeriodoTReporte . "";
        $filtro .= " AND F.TipoGradoId = " . $cmbTipoGradoTReporte . "";

        $registroGrados = $controlRegistroGrado->detalleConsultarActaAcuerdos($filtro);
        ?>

        <script src="../js/MainTipoReporte.js"></script>

        <form name="pdfCertificado" id="pdfCertificado" action="../servicio/pdf.php">
            <input type="hidden" name="tipoOperacion" id="tipoOperacion" value="generarcertificado">
            <input type="hidden" name="txtFacultad" id="txtFacultad" value="<?php echo $cmbFacultadTReporte ?>">
            <input type="hidden" name="txtCarrera" id="txtCarrera" value="<?php echo $cmbCarreraTReporte ?>">
            <input type="hidden" name="txtPeriodo" id="txtPeriodo" value="<?php echo $cmbPeriodoTReporte ?>">
            <input type="hidden" name="TxtTipoGrado" id="TxtipoGrado" value="<?php echo $cmbTipoGradoTReporte ?>">
            <?php
            if ($cmbCarreraTReporte == 'pregrados' or $cmbCarreraTReporte == 'posgrados') {
                
            } else {
                ?>
                Graduados :<br/><select name="cbmEgresados" id="cbmEgresados">
                    <option value="todos">Todos</option>
                    <?php
                    foreach ($registroGrados as $registroGrado) {
                        $codigoEstudiante = $registroGrado->getIdRegistroGrado();
                        $nombreEstudiante = $registroGrado->getEstudiante()->getApellidoEstudiante() . " " . $registroGrado->getEstudiante()->getNombreEstudiante();
                        ?>
                        <option value="<?php echo $codigoEstudiante ?>"><?php echo $nombreEstudiante; ?></option>
                    <?php } ?>
                </select><br><br>
                <?php
            }
            ?>

            <input id="btnExportarCertificado" value="Exportar Certificado"  class="ui-button ui-widget ui-state-default ui-corner-all" role="button" aria-disabled="false">
            <div id="carga" style="display:none;text-align: center;">
                <img src="../css/images/cargando.gif" />
            </div>
        </form>
        <?php
        break;

    /* Modified Diego Rivera<riveradiego@unbosque.edu.co>
     * Se añade caso consultarIndexacion  este caso permite identificar los docuamentos asociados al egresado tales como  diploma ,actas e incentivos
     * Se añade funcion archivo la cual verifica si existen archivos asociados al egresado
     * Since january 30 ,2018
     */
    case "consultarIndexacion":

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

        if ($cmbPeriodoTReporte != -1) {
            $filtro .= " AND F.CodigoPeriodo = " . $cmbPeriodoTReporte . "";
        }

        if ($cmbTipoGradoTReporte != -1) {
            $filtro .= " AND F.TipoGradoId = " . $cmbTipoGradoTReporte . "";
        }

        $registroGrados = $controlRegistroGrado->consultarIndexacion($filtro);
        $i = 1;
        if (count($registroGrados) != 0) {
            ?>

            <script src="../js/MainTipoReporte.js"></script>
            <?php

            function archivo($codigo, $identificaRuta) {

                $validador = "";

                if ($identificaRuta == "Diplomas") {
                    $ruta = "../documentos/Diplomas/DP_" . $codigo . ".pdf";
                } else if ($identificaRuta == "Acta de Grado") {
                    $ruta = "../documentos/Acta de Grado/AG_" . $codigo . ".pdf";
                } else if ($identificaRuta == "Incentivo") {
                    $ruta = "../documentos/Incentivo/IA_" . $codigo . ".pdf";
                } else if ($identificaRuta == "Mencion de Honor") {
                    $ruta = "../documentos/Mencion de Honor/MH_" . $codigo . ".pdf";
                } else if ($identificaRuta == "Mencion Meritoria") {
                    $ruta = "../documentos/Mencion Meritoria/MM_" . $codigo . ".pdf";
                } else if ($identificaRuta == "Grado de Honor") {
                    $ruta = "../documentos/Grado de Honor/GH_" . $codigo . ".pdf";
                } else if ($identificaRuta == "Cum Laude") {
                    $ruta = "../documentos/Cum Laude/CL_" . $codigo . ".pdf";
                } else if ($identificaRuta == "Mangna Cum Laude") {
                    $ruta = "../documentos/Mangna Cum Laude/MC_" . $codigo . ".pdf";
                } else if ($identificaRuta == "Suma Cum Laude") {
                    $ruta = "../documentos/Suma Cum Laude/SC_" . $codigo . ".pdf";
                } else if ($identificaRuta == "Laureada") {
                    $ruta = "../documentos/Laureada/LA_" . $codigo . ".pdf";
                } else if ($identificaRuta == "Certificados Cal") {
                    $ruta = "../documentos/Certificados Cal/CN_" . $codigo . ".pdf";
                } else if ($identificaRuta == "Enfasis") {
                    $ruta = "../documentos/Enfasis/EN_" . $codigo . ".pdf";
                } else {
                    $ruta = "";
                }

                if (file_exists($ruta)) {
                    $validador = "x";
                } else {

                    $validador = "";
                }

                return $validador;
            }

            echo "
                <div style=\"width: 100%; top: 0px; height: 100%px; border: 1px; border-style: solid groove; border-radius: 4px; border-color: #aaaaaa;\">
                        <table id=\"estudianteCeremoniaEgresados\" width=\"100%\" border=\"0\"  >
                            <thead>
                                <tr >
                                        <th style=\"width: 5%;\" >No</th>
                                        <th>Código</th>
                                        <th>Documento</th>
                                        <th>Número</th>
                                        <th>Nombre</th>
                                        <th>Carrera</th>
                                        <th>Periodo</th>
                                        <th>Tipo Programa</th>
                                        <th>Tipo Grado</th>
                                        <th>Diploma</th>
                                        <th>Acta de grado</th>
                                        <th>Certificado de notas</th>
                                        <th>Mención de Honor</th>
                                        <th>Mención Meritoria</th>
                                        <th>Grado de Honor</th>
                                        <th>Cum Laude</th>
                                        <th>Mangna Cum Laude</th> 
                                        <th>Suma Cum Laude</th>
                                        <th>Laureada</th>
                                        <th>Énfasis</th>
                                </tr>
                            </thead>
                <tbody class=\"listaEstudiantes\">";
            foreach ($registroGrados as $registroGrado) {
            echo "<tr align='center'>
                    <td>$i</td>
                    <td>" . $registroGrado->getEstudiante()->getCodigoEstudiante() . "</td>
                    <td>" . $registroGrado->getEstudiante()->getTipoDocumento()->getIniciales() . "</td>
                    <td>" . $registroGrado->getEstudiante()->getNumeroDocumento() . "</td>
                    <td>" . $registroGrado->getEstudiante()->getApellidoEstudiante() . " " . $registroGrado->getEstudiante()->getNombreEstudiante() . "</td>
                    <td>" . $registroGrado->getActaAcuerdo()->getFechaGrado()->getCarrera()->getNombreCarrera() . "</td>
                    <td>" . $registroGrado->getActaAcuerdo()->getFechaGrado()->getPeriodo() . "</td>
                    <td>" . substr($registroGrado->getActaAcuerdo()->getFechaGrado()->getCarrera()->getModalidadAcademica()->getNombreModalidadAcademica(), 12) . "</td>
                    <td>" . $registroGrado->getActaAcuerdo()->getFechaGrado()->getTipoGrado()->getNombreTipoGrado() . "</td>
                    <td>" . archivo($registroGrado->getEstudiante()->getCodigoEstudiante(), 'Diplomas') . "</td>
                    <td>" . archivo($registroGrado->getEstudiante()->getCodigoEstudiante(), 'Acta de Grado') . "</td>
                    <td>" . archivo($registroGrado->getEstudiante()->getCodigoEstudiante(), 'Certificados Cal') . "</td>
                    <td>" . archivo($registroGrado->getEstudiante()->getCodigoEstudiante(), 'Mencion de Honor') . "</td>
                    <td>" . archivo($registroGrado->getEstudiante()->getCodigoEstudiante(), 'Mencion Meritoria') . "</td>
                    <td>" . archivo($registroGrado->getEstudiante()->getCodigoEstudiante(), 'Grado de Honor') . "</td>
                    <td>" . archivo($registroGrado->getEstudiante()->getCodigoEstudiante(), 'Cum Laude') . "</td>
                    <td>" . archivo($registroGrado->getEstudiante()->getCodigoEstudiante(), 'Mangna Cum Laude') . "</td>
                    <td>" . archivo($registroGrado->getEstudiante()->getCodigoEstudiante(), 'Suma Cum Laude') . "</td>
                    <td>" . archivo($registroGrado->getEstudiante()->getCodigoEstudiante(), 'Laureada') . "</td>
                    <td>" . archivo($registroGrado->getEstudiante()->getCodigoEstudiante(), 'Enfasis') . "</td>
                </tr>";
                $i++;
            }
            echo "</tbody>
		</table>";
        }
        break;

        case "consultaColegioPsicologia":
         $filtro = "";
         $filtro .= " AND FT.codigofacultad = " . $cmbFacultadTReporte . "";
         $filtro .= " AND C.codigocarrera = " . $cmbCarreraTReporte . "";
         $filtro .= " AND F.CodigoPeriodo = " . $cmbPeriodoTReporte . "";
         $filtro .= " AND F.TipoGradoId = " . $cmbTipoGradoTReporte . "";

        $registroGrados = $controlRegistroGrado->consultarColegioPsicologia($filtro);

        if (count($registroGrados) == 0) {
            echo 0;
        } else {
            ?>
            <script src="../js/MainTipoReporte.js"></script>
            <?php
             
        echo "
            <table width=\"100%\" id=\"estudianteCeremoniaEgresados\" border=\"0\" style=\"text-align:center\">
                          <thead>
                                <tr>
                                <th>Reg.</th>
                                <th>Numero de Documento</th>
                                <th>Apellidos y Nombres</th>
                                <th>Snies Institucion</th>
                                <th>Nombre Institucion</th>
                                <th>Nombre Firma Acta</th>
                                <th>Cod Snies Programa</th>
                                <th>Fecha de Grado</th>
                                <th>Acta de Grado</th>
                                <th>Libro de Grado</th>
                                <th>Folio Acta</th>
                                <th>Numero Diploma</th>
                                <th>Registro Diploma</th>
                            </tr>
                          </thead>
                          <tbody>";

                    foreach ($registroGrados as $registroGrado) {

                    $folioTemporal = $controlFolioTemporal->buscarFolioTemporal($registroGrado->getIdRegistroGrado());
                    $snies= $controlCarrera ->Snies($registroGrado->getActaAcuerdo()->getFechaGrado()->getCarrera()->getCodigoCarrera());
                    

                    echo "<tr>";
                    echo "<td align=\"center\">" . $registroGrado->getIdRegistroGrado() . "</td>";
                    echo "<td>" . $registroGrado->getEstudiante()->getNumeroDocumento() . "</td>";
                    echo "<td>" . $registroGrado->getEstudiante()->getApellidoEstudiante() . " " . $registroGrado->getEstudiante()->getNombreEstudiante() . "</td>";
                    echo "<td>" . "1729" . "</td>";
                    echo "<td>" . "UNIVERSIDAD EL BOSQUE" . "</td>";
                    echo "<td>" . "María Clara Rangel Galvis; Cristina Matiz Mejia" . "</td>";
                    echo "<td>" . $snies->getCodigoCarrera()."</td>";
                    echo "<td>" . date("Y-m-d", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo())) . "</td>";
                    echo "<td>" . $registroGrado->getActaAcuerdo()->getNumeroActaConsejoDirectivo(). "</td>";
                    echo "<td>" . "" . "</td>";
                     echo "<td>" . $folioTemporal->getNumeroFolio() . "</td>";
                    echo "<td>" . $registroGrado->getNumeroDiploma() . "</td>";
                    echo "<td>" . $registroGrado->getIdRegistroGrado() . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "<br />";
        }

        break;
}
?>