<?php
session_start();
$nombrearchivo = 'riesgos' . "_" . $_POST['riesgo'] . "_" . $_GET['semestre'];
require_once('../../../Connections/sala2.php');
if (isset($_REQUEST['formato'])) {
    $formato = $_REQUEST['formato'];
    switch ($formato) {
        case 'xls' :
            $strType = 'application/msexcel';
            $strName = $nombrearchivo . ".xls";
            break;
        case 'doc' :
            $strType = 'application/msword';
            $strName = $nombrearchivo . ".doc";
            break;
        case 'txt' :
            $strType = 'text/plain';
            $strName = $nombrearchivo . ".txt";
            break;
        case 'csv' :
            $strType = 'text/plain';
            $strName = $nombrearchivo . ".csv";
            break;
        case 'xml' :
            $strType = 'text/plain';
            $strName = $nombrearchivo . ".xml";
            break;
        default :
            $strType = 'application/msexcel';
            $strName = $nombrearchivo . ".xls";
            break;
    }
    header("Content-Type: $strType");
    header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //header("Cache-Control: no-store, no-cache");
    header("Pragma: public");
}

$rutaado = "../../../funciones/adodb/";
require_once('../../../funciones/sala/nota/nota.php');
require_once('../../../funciones/sala/estudiante/estudiante.php');
//$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');
require_once('../../../funciones/sala/nota/nota.php');
require ('../../../funciones/notas/redondeo.php');
require('../../../funciones/notas/funcionequivalenciapromedio.php');
?>
<html>
    <head>
        <title>Menu Riesgos X Semestre</title>
<?php
if (isset($_REQUEST['debug']))
    $db->debug = true;

if (!isset($_REQUEST['formato'])) {
?>
        <link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
        <?php
    }
        ?>
    </head>
    <body>
        <?php

        function obternerNombreMateria($codigomaterias, $mensaje = "") {
            global $db;
            if ($codigomaterias != "") {
                $codigomaterias = ereg_replace(",$", "", $codigomaterias);
                $query_materia = "select nombremateria, codigomateria
		from materia
		where codigomateria in($codigomaterias)";
                $materia = $db->Execute($query_materia);
                $totalRows_materia = $materia->RecordCount();
                $nombrematerias = "";
                while ($row_materia = $materia->FetchRow()) {
                    $nombrematerias .= "<b>" . $row_materia['codigomateria'] . "</b>-" . $row_materia['nombremateria'] . "$mensaje<br>";
                }
            }
            return $nombrematerias;
        }

//print_r($_GET);
// De acuerdo a la sesión y a lo que venga por get muestra el detalle
        /* echo "<pre>";
          print_r($_SESSION);
          echo "</pre>";
         */
//$_SESSION['codigoperiodosesion'] = 20082;
//$_SESSION['codigofacultad'] = 118;
        $codigoperiodo = $_SESSION['codigoperiodosesion'];
        $semestre = $_POST['semestre'];
        $riesgo = $_POST['riesgo'];
        $codigocarrera = $_POST['codigocarrera'];
        ?>
        <p>Listado de Estudiantes en Riesgo <?php echo $riesgo; ?> y semestre <?php echo $semestre; ?></p>
        <table border="1" cellspacing="0" cellpadding="0">
            <tr id="trtitulogris">
                <td>#</td>
                <td>Documento</td>
                <td>Nombre</td>
                <td>Periodo Ingreso</td>
<?php
        if ($_POST['riesgo'] == "Alto") {
?>
                    <td>Pierde Más del 50%</td>
                    <td>Promedio Ponderado Acumulado Menor a 3.3</td>
                    <td>Pierde Asignatura Otra Vez</td>
                    <td>Está en Prueba Académica</td>
            <!-- 	<td>Pierde Por Fallas</td> -->
                    <td>Materias Perdidas</td>
                <?php
            }
            if ($_POST['riesgo'] == "Medio") {
                ?>
                <td colspan="4">Pierde Menos del 50% y Más del 25%</td>
                <td>Materias Perdidas</td>
<?php
            }
            if ($_POST['riesgo'] == "Bajo") {
?>
                <td colspan="4">Pierde Menos del 25% y Más del 0%</td>
                <td>Materias Perdidas</td>
<?php
            }
?>
            </tr>
                <?php
//$db->debug = true;
// Para los riesgos se vana a tomar los estudiantes que están matriculados
                $query_estudiantes = "select distinct e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) as nombre, eg.numerodocumento, e.codigoperiodo
from prematricula p, estudiante e, estudiantegeneral eg, detalleprematricula dp
where e.codigoestudiante = p.codigoestudiante
and eg.idestudiantegeneral = e.idestudiantegeneral
and p.codigoestadoprematricula like '4%'
and p.codigoperiodo = '$codigoperiodo'
and p.semestreprematricula = '$semestre'
and e.codigocarrera = '$codigocarrera'
and dp.idprematricula = p.idprematricula
and dp.codigoestadodetalleprematricula like '3%'
order by 2";
                $estudiantes = $db->Execute($query_estudiantes);
                $totalRows_estudiantes = $estudiantes->RecordCount();
                $hayregistros = false;
                $cuentaregistros = 0;
//$db->debug = false;
                while ($row_estudiantes = $estudiantes->FetchRow()) {
                    unset($detallenota);
                    $codigoestudiante = $row_estudiantes['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                            $detallenota->setAcumuladoCertificado("1");
                    //if($detallenota->tieneNotas())
                    //{
                    if ($_POST['riesgo'] == "Alto") {
                        if ($detallenota->esAltoRiesgo()) {
                            $cuentaregistros++;
                            //$estudiantes = new estudiante($codigoestudiante, $_SESSION['codigoperiodoriesgo']);
                ?>
                            <tr>
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo $row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $row_estudiantes['nombre']; ?></td>
                                <td><?php echo $row_estudiantes['codigoperiodo']; ?></td>
                                <td>&nbsp;<?php echo $detallenota->mensajepierdeMasdel50; ?></td>
                                <td>&nbsp;<?php echo $detallenota->mensajeppaMenor33; ?></td>
                                <td><?php echo obternerNombreMateria($detallenota->mensajepierdeAsignaturaOtraVez); ?>&nbsp;</td>
                                <td>&nbsp;<?php echo $detallenota->mensajeestaEnPrueba; ?></td>
                        <!-- 	<td>&nbsp;<?php //echo $detallenota->mensajeperdioPorFallas; ?></td>  -->
                                <td><?php echo obternerNombreMateria($detallenota->materiasperdidas); ?>
            <?php echo obternerNombreMateria($detallenota->materiasperdidasfallas, " (F)"); ?>
                                </td>
                            </tr>
<?php
                        }
                        else
                            continue;
                    }
                    else if ($_POST['riesgo'] == "Medio") {
                        if (!$detallenota->esAltoRiesgo() && $detallenota->esMedianoRiesgo()) {
                            $cuentaregistros++;
?>
                            <tr>
                                <td><?php echo $cuentaregistros; ?></td>
                        <td><?php echo $row_estudiantes['numerodocumento']; ?></td>
                        <td><?php echo $row_estudiantes['nombre']; ?></td>
                                <td><?php echo $row_estudiantes['codigoperiodo']; ?></td>
                                <td colspan="4">&nbsp;<?php echo $detallenota->mensajepierdeMasde25yMenosde50; ?></td>
                                <td><?php echo obternerNombreMateria($detallenota->materiasperdidas); ?>&nbsp;</td>
                            </tr>
            <?php
                        }
                        else
                            continue;
                    }
                    else if ($_POST['riesgo'] == "Bajo") {
                        if (!$detallenota->esAltoRiesgo() && !$detallenota->esMedianoRiesgo() && $detallenota->esBajoRiesgo()) {
                            $cuentaregistros++;
            ?>
                            <tr>
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo $row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $row_estudiantes['nombre']; ?></td>
                                <td><?php echo $row_estudiantes['codigoperiodo']; ?></td>
                                <td colspan="4">&nbsp;<?php echo $detallenota->mensajepierdeMasde0yMenosde25; ?></td>
                                <td><?php echo obternerNombreMateria($detallenota->materiasperdidas); ?>&nbsp;</td>
                            </tr>
            <?php
                        }
                        else
                            continue;
                    }
                    else if ($_POST['riesgo'] == "Sin Riesgo") {
                        if (!$detallenota->esAltoRiesgo() && !$detallenota->esMedianoRiesgo() && !$detallenota->esBajoRiesgo()) {
                            $cuentaregistros++;
            ?>
                            <tr>
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo $row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $row_estudiantes['nombre']; ?></td>
                                <td><?php echo $row_estudiantes['codigoperiodo']; ?></td>
                            </tr>
<?php
                        }
                        else
                            continue;
                    }
                    //}
                    /* else
                      {
                      continue;
                      } */
                }
                if ($cuentaregistros == 0) {
?>
                    <tr>
                        <td colspan="100">No existen estudiantes con riesgo <?php echo $_POST['riesgo']; ?></td>
                    </tr>
<?php
                }
                if (!isset($_REQUEST['formato'])) {
?>
                    <tr>
                        <td <? if ($_POST['riesgo'] != "Sin Riesgo")
                        echo 'colspan="8"'; else
                        echo 'colspan="4"'; ?>>
                            <form action="riesgossemestredetalle.php" method="get" name="f1">
                                <input type="button" onclick="document.location.href='menuriesgossemestre.php';" value="Regresar">
                                <input type="submit" value="Exportar a Excel">
                                <input type="hidden" value="" name="formato">
                                <input type="hidden" value="<?php echo "$semestre"; ?>" name="semestre">
                                <input type="hidden" value="<?php echo "$riesgo"; ?>" name="riesgo">
                            </form>
                        </td>
            <?
                    if ($_POST['riesgo'] != "Sin Riesgo") {
            ?>
                            <td>(F): Perdio por fallas</td>
            <?
                    }
            ?>
                    </tr>
            <?php
                }
            ?>
        </table>
    </body>
</html>