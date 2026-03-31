<?php
session_start();
include_once('../../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
#echo 'Aca estoy =)';die;
include('../../../men/templates/MenuReportes.php');

?>

    <style type="text/css" title="currentStyle">
                @import "../../../css/demo_page.css";
                @import "../../../css/demo_table_jui.css";
                @import "../../../css/demos.css";
                @import "../../../css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                @import "/data/media/css/ColVis.css";
                
    </style>
    <script type="text/javascript" language="javascript" src="/data/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" src="/data/extras/TableTools/media/js/ZeroClipboard.js"></script>
    <script type="text/javascript" charset="utf-8" src="/data/extras/TableTools/media/js/TableTools.js"></script>
    <script type="text/javascript" charset="utf-8" src="/data/media/js/ColVis.js"></script>
    <script type="text/javascript" language="javascript">
	/****************************************************************/
	$(document).ready( function () {
			
			oTable = $('#example').dataTable({
                            "sDom": 'C<"clear">lfrtip',
                            "oColVis": {
                                    "aiExclude": [ 0 ]
                            },
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers"
                        });
			
		} );
	/**************************************************************/
</script>	
<?PHP
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
        $codigoperiodo = $_POST['Periodo'];
        $semestre = $_POST['semestre'];
        $riesgo = $_POST['riesgo'];
        $codigocarrera = $_POST['codigocarrera'];
		
		
					if($_POST['riesgo']==1){$NombreRiesgo=' en Riesgo Alto';}
					if($_POST['riesgo']==2){$NombreRiesgo= 'en Riesgo Medio';}
					if($_POST['riesgo']==3){$NombreRiesgo='en Riesgo Bajo';}
					if($_POST['riesgo']==0){$NombreRiesgo='Sin Riesgo';}
        ?>
        <p>Listado de Estudiante por Materia</p>
        <div id="demo">
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <th>N&deg;</th>
                <th>Codigo Carrera</th>
                <th>Nombre Carrera</th>
                <th>Codigo Materia</th>
                <th>Nombre Materia</th>
                <th>Codigo Grupo</th>
                <th>Codigo Periodo</th>
                <th>Riesgo Alto</th>
                <th>Riesgo Medio</th>
                <th>Riesgo Bajo</th>
                <th>Sin Riesgo</th>
                <th>Estudiante Matriculados</th>
            </tr>
        </thead>
        <tbody>
            <tr class="odd_gradeX">
                <td>a</td>
                <td>s</td>
                <td>d</td>
                <td>f</td>
                <td>t</td>
                <td>y</td>
                <td>u</td>
                <td>i</td>
                <td>k</td>
                <td>k</td>
                <td>m</td>
                <td>b</td>
            </tr>
        </tbody>
        </table>
        </div>
                <?php
//$db->debug = true;
// Para los riesgos se vana a tomar los estudiantes que están matriculados
                 /*$query_estudiantes = "select distinct e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) as nombre, eg.numerodocumento, e.codigoperiodo
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
                    if ($_POST['riesgo'] == 1) {
                        if ($detallenota->esAltoRiesgo()) {
                            $cuentaregistros++;
                            //$estudiantes = new estudiante($codigoestudiante, $_SESSION['codigoperiodoriesgo']);
                ?>
                            <tr class="odd_gradeX">
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
                    else if ($_POST['riesgo'] == 2) {
                        if (!$detallenota->esAltoRiesgo() && $detallenota->esMedianoRiesgo()) {
                            $cuentaregistros++;
?>
                        <tr class="odd_gradeX">
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
                    else if ($_POST['riesgo'] == 3) {
                        if (!$detallenota->esAltoRiesgo() && !$detallenota->esMedianoRiesgo() && $detallenota->esBajoRiesgo()) {
                            $cuentaregistros++;
            ?>
                            <tr class="odd_gradeX">
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
                    else if ($_POST['riesgo'] == 0) {
							#echo '<br>esAltoRiesgo->'.$detallenota->esAltoRiesgo();
                        if (!$detallenota->esAltoRiesgo() && !$detallenota->esMedianoRiesgo() && !$detallenota->esBajoRiesgo()) {
							
							
                            $cuentaregistros++;
            ?>
                            <tr class="odd_gradeX">
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
                //}/*Fin*/
                /*
                if ($cuentaregistros == 0) {
					
					if($_POST['riesgo']==1){$NombreRiesgo='Alto';}
					if($_POST['riesgo']==2){$NombreRiesgo='Medio';}
					if($_POST['riesgo']==3){$NombreRiesgo='Bajo';}
					if($_POST['riesgo']==0){$NombreRiesgo='Sin Riesgo';}
?>
                    <tr class="odd_gradeX">
                        <td colspan="100">No existen estudiantes con riesgo <?php echo $NombreRiesgo; ?></td>
                    </tr>
<?php
                }*/
				?>
                 
		<!--</tbody>
        </table> -->	
        <?PHP
                if (!isset($_REQUEST['formato'])) {
?>
				<br><br>		
            	<table>	
                    <tr>
                        <td <? if ($_POST['riesgo'] != "Sin Riesgo")
							echo 'colspan="8"'; else
                        echo 'colspan="4"'; ?>>
                            <form action="riesgossemestredetalle.php" method="get" name="f1">
                                <input type="button" onClick="document.location.href='menuriesgossemestre.php';" value="Regresar">
                                <input type="submit" value="Exportar a Excel">
                                <input type="hidden" value="" name="formato">
                                <input type="hidden" value="<?php echo $semestre; ?>" name="semestre">
                                <input type="hidden" value="<?php echo $riesgo; ?>" name="riesgo">
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
                  </table>  
            <?php
                }
            ?>
           
    </body>
</html>