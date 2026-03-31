<?php
session_start();

if ($db == null) {
    include_once ('../EspacioFisico/templates/template.php');
    $db = getBD();
}
$id_Docente = $_GET["iddocente"];

$Periodo = $_GET["txtCodigoPeriodo"];


$condicionDocente = "";
if (isset($_GET["iddocente"])) {
    $condicionDocente = "AND pl.iddocente='" . $id_Docente . "' ";
}

$SQL = "SELECT
	a.iddocente,
	a.apellidodocente,
	a.nombredocente,
	a.numerodocumento,
	a.emaildocente,
	SUM(totalHoras) AS totalHoras,
	GROUP_CONCAT( DISTINCT vocaciones ORDER BY orden SEPARATOR '|' ) AS vocaciones,
	GROUP_CONCAT( vocacionesid ORDER BY orden SEPARATOR '|' ) AS vocacionesid,
	GROUP_CONCAT( DISTINCT programas";
if (isset($_GET["iddocente"]) && $_GET["iddocente"] != 273) {
    $SQL .= " ORDER BY programas ASC";
}
$SQL .= " SEPARATOR '|' ) AS programas,
	GROUP_CONCAT( DISTINCT Carrera_id";
if (isset($_GET["iddocente"]) && $_GET["iddocente"] != 273) {
    /**
     * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * en este ORDER BY se cambia el Carrera_id por programas ya que al oprimir el boton del nombre de un programa
     * muestra datos asociados de otro programa (caso 3248)
     * @since Agosto 6, 2019
     */
    $SQL .= " ORDER BY programas ASC";
}
$SQL .= " SEPARATOR '|' ) AS Carrera_id
FROM docente a,
	(
            SELECT DISTINCT
            iddocente,
            'ENSENANZA',
            SUM(
                HorasPresencialesPorSemana + HorasPreparacion + HorasEvaluacion + HorasAsesoria + HorasTIC + HorasInnovar + HorasTaller + HorasPAE
            ) AS totalHoras,
            'Enseñanza y aprendizaje' AS vocaciones,
            1 AS vocacionesid,
            1 AS orden,
            GROUP_CONCAT( DISTINCT c.nombrecarrera SEPARATOR '|' ) AS programas,
            GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id
            FROM PlanesTrabajoDocenteEnsenanza pl
            INNER JOIN carrera c ON (c.codigocarrera = pl.codigocarrera AND
                                        (pl.HorasPresencialesPorSemana>0 OR
                                         pl.HorasPreparacion>0 or
                                         pl.HorasEvaluacion>0 or
                                         HorasAsesoria>0 or
                                         HorasTIC > 0 or
                                         HorasInnovar >0 or
                                         HorasTaller>0 or HorasPAE>0 ))
            WHERE codigoestado = 100
            AND pl.codigoperiodo = '" . $Periodo . "'
            " . $condicionDocente . "
            GROUP BY pl.iddocente
            UNION ALL
            SELECT DISTINCT
            iddocente,
            'OTROS',
            SUM(HorasDedicadas) AS totalHoras,
            GROUP_CONCAT( DISTINCT v.Nombre ORDER BY v.Nombre SEPARATOR '|' ) AS vocaciones,
            GROUP_CONCAT( v.VocacionesPlanesTrabajoDocenteId ORDER BY v.Nombre SEPARATOR '|' ) AS vocacionesid,
            2 AS orden,
            GROUP_CONCAT( DISTINCT c.nombrecarrera SEPARATOR '|' ) AS programas,
            GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id
            FROM PlanesTrabajoDocenteOtros pl
            INNER JOIN VocacionPlanesTrabajoDocentes v ON v.VocacionesPlanesTrabajoDocenteId = pl.VocacionesPlanesTrabajoDocenteId
            INNER JOIN carrera c ON (c.codigocarrera = pl.codigocarrera AND (pl.HorasDedicadas>0 ))
            WHERE pl.codigoestado = 100
            AND pl.codigoperiodo = '" . $Periodo . "' 
            " . $condicionDocente . "
            GROUP BY pl.iddocente
	) b
WHERE a.iddocente = b.iddocente
GROUP BY a.iddocente, a.apellidodocente, a.nombredocente, a.numerodocumento
ORDER BY a.apellidodocente, a.nombredocente";
if (isset($_GET["iddocente"]) && $_GET["iddocente"] != 273) {
    $SQL .= ", programas ASC, Carrera_id ASC";
}

$resultados = $db->Execute($SQL);
?>
<style type="text/css">
    table#tablaReporteGeneral thead tr th{
        background-color:transparent;color:#fffc0b;border-color:#fff;
    }
    table#tablaReporteGeneral thead tr {
        border-color:#fff;
    }

    table#tablaReporteGeneral tbody{
        background-color:transparent;color:#fff;border-color:#fff;
    }
    table#tablaReporteGeneral tbody tr td{
        border-color:#fff;
    }
    .ui-widget #tablaReporteGeneral tr td button{
        border: 0 none;
        border-radius: 2px 2px 2px 2px;
        color: #FFFFFF;
        cursor: pointer;
        display: inline-block;
        font-size: 12px;
        font-weight: bold;
        line-height: 16px;
        margin-bottom: 0;
        margin-top: 10px;
        padding: 7px 10px;
        text-transform: none;
        transition: all 0.3s ease 0s;
        -moz-transition: all 0.3s ease 0s;
        -webkit-transition: all 0.3s ease 0s;
        background: none repeat scroll 0 0 #0f6d39;
        color: #FFFFFF;

    }

    .ui-widget #tablaReporteGeneral tr td button:hover {
        background: none repeat scroll 0 0 #7f7f7f;
        color: #FFFFFF;
    }

    table table.detalleProgramas {
        margin:0;padding:0;
    }
    table table.detalleProgramas tr{
        border:0;margin:0;padding:0;
    }
    table table.detalleProgramas tr td{
        border:0;
    }

    table table.detalleProgramasEv {
        margin:0;padding:0;
    }
    table table.detalleProgramasEv tr{
        border:0;margin:0;padding:0;
    }
    table table.detalleProgramasEv tr td{
        border:0;
    }
    .dataColumns:hover{
        background: #777777;
        color: #0D0D0D;
    }
</style>
<div style="overflow: scroll">
    <table id="tablaReporteGeneral" align="center" class="table table-responsive" border="2" bordercolor="#fff" >
        <thead>
        <tr class="">
            <th class="column borderR" style="text-align:center;width:10%"><span>Apellido docente</span></th>
            <th class="column borderR" style="text-align:center;width:10%"><span>Nombre docente</span></th>
            <th class="column borderR" style="text-align:center;width:10% "><span>Número documento</span></th>
            <th class="column borderR" style="text-align:center;width:15%"><span>Email</span></th>
            <th class="column borderR" style="text-align:center "><span>Vocaciones</span></th>
            <th class="column borderR" style="text-align:center "><span>Total horas</span></th>
            <th class="column borderR" style="text-align:center "><span>Programas</span></th>
            <?php if ($_GET['txtNumeroDocumento'] == 52256041 || $_GET['txtNumeroDocumento'] == 35497790 || $_GET['txtNumeroDocumento'] == 51826550) { ?>
                <th class="column" style="text-align:center "><span>Evidencia</span></th>
            <?php } ?>
            <th class="column" style="text-align:center "><span>Autoevaluación</span></th>
            <th class="column" style="text-align:center "><span>Plan Mejora</span></th>
        </tr>
        </thead>
        <tbody style="">
        <?php
        while (!$resultados->EOF) {

            $codigoEstudiante = $resultados->fields['iddocente'];
            ?>
            <tr class="dataColumns" >
                <td class="column borderR"><?php echo $resultados->fields['apellidodocente']; ?></td>
                <td class="column borderR"><?php echo $resultados->fields['nombredocente']; ?></td>
                <td class="column center borderR"><?php echo $resultados->fields['numerodocumento']; ?></td>
                <td class="column center borderR"><?php echo $resultados->fields['emaildocente']; ?></td>
                <td class="column center borderR"><?php echo $resultados->fields['vocaciones']; ?></td>

                <td class="column center borderR">
                    <?php if ($_GET['txtNumeroDocumento'] == 52256041 || $_GET['txtNumeroDocumento'] == 35497790 || $_GET['txtNumeroDocumento'] == 51826550) { ?>
                        <a id="txtHoraDocente" style="color: white; cursor: pointer;" onclick="verResumen('<?php echo $codigoEstudiante; ?>', '<?php echo $Periodo; ?>');"  ><?php echo $resultados->fields['totalHoras']; ?></a>
                        <?php
                    } else {
                        echo $resultados->fields['totalHoras'];
                    }
                    ?>
                </td>

                <td class="column borderR"><table class="detalleProgramas" ><?php
                        $programas = explode("|", $resultados->fields['programas']);
                        $programas = array_merge(array_unique($programas));

                        $id_programas = explode("|", $resultados->fields['Carrera_id']);
                        $id_programas = array_merge(array_unique($id_programas));
                        $zIdPrograma = 0;
                        $docIdPrograma = $id_programas;



                        $tempIdPrograma = null;
                        /* Converir en array los valores de check */
                        for ($i = 0; $i < strlen($id_programas); $i++) {
                            if ($id_programas[$i] <> '|') {
                                $docIdPrograma[$zIdPrograma] = $tempIdPrograma . $id_programas[$i];
                                $tempIdPrograma = $docIdPrograma[$zIdPrograma];
                            } else {
                                $tempIdPrograma = null;
                                $zIdPrograma = $zIdPrograma + 1;
                            }
                        }

                        $vocaciones = $resultados->fields['vocacionesid'];
                        $dIdPrograma = 0;
                        foreach ($programas as $programa) {
                            ?>
                            <tr><td><button id="programa_<?php echo $docIdPrograma[$dIdPrograma]; ?>_<?php echo $resultados->fields['iddocente']; ?>_<?php echo $vocaciones; ?>_<?php echo $Periodo; ?>" class="soft image programas" title="Ver datos vocación" style="margin:2px;display: inline-block;" type="button">
                                        <?php
                                        $dIdPrograma = $dIdPrograma + 1;
                                        echo $programa;
                                        ?>
                                    </button></td>
                            </tr>
                            <?php
                        }
                        ?></table></td>
                <?php if ($_GET['txtNumeroDocumento'] == 52256041 || $_GET['txtNumeroDocumento'] == 35497790 || $_GET['txtNumeroDocumento'] == 51826550) { ?>
                    <td class="column borderR"><table class="detalleProgramasEv">
                            <?php
                            $dIdProgramaE = 0;
                            foreach ($programas as $programa) {

                                $rutaFichero = "documentos/" . $resultados->fields['iddocente'] . "/" . $Periodo . "/" . $docIdPrograma[$dIdProgramaE];
                                ?>
                                <tr>
                                    <?php
                                    if (file_exists($rutaFichero)) {
                                        ?>
                                        <td>
                                            <button id="evidencia_<?php echo $resultados->fields['iddocente']; ?>_<?php echo $Periodo; ?>_<?php echo $docIdPrograma[$dIdProgramaE]; ?>" class="evidencias" title="Ver Evidencias" style="margin:2px;display: inline-block;">
                                                Evidencia
                                            </button>
                                        </td>
                                    <?php }
                                    ?>
                                </tr>
                                <?php
                                $dIdProgramaE = $dIdProgramaE + 1;
                            }
                            ?>
                        </table></td>
                <?php } ?>
                <td class="column borderR"><table class="detalleProgramasEv">
                        <?php
                        $dIdProgramaAE = 0;
                        foreach ($programas as $programa) {

                            $idDocente = $resultados->fields['iddocente'];

                            $sqlExisteAE = "SELECT 
                                                COUNT(DocenteId) AS existe 
                                                FROM AutoevaluacionDocentes
                                                WHERE DocenteId = $idDocente
                                                AND CodigoPeriodo = $Periodo
                                                AND CodigoCarrera = $docIdPrograma[$dIdProgramaAE]
                                                AND CodigoEstado = 100";

                            $existeAutoEvaluacion = $db->Execute($sqlExisteAE);

                            $existeAutoEvaluacion = $existeAutoEvaluacion->fields["existe"];
                            ?>
                            <tr>
                                <?php
                                if ($existeAutoEvaluacion != 0) {
                                    ?>
                                    <td>
                                        <button id="autoevaluacion_<?php echo $docIdPrograma[$dIdProgramaAE]; ?>_<?php echo $resultados->fields['iddocente']; ?>_<?php echo $vocaciones; ?>_<?php echo $Periodo; ?>" class="autoevaluaciones" title="Ver AutoEvaluación" style="margin:2px;display: inline-block;" type="button">
                                            Autoevaluación
                                        </button>
                                    </td>
                                <?php }
                                ?>
                            </tr>
                            <?php
                            $dIdProgramaAE = $dIdProgramaAE + 1;
                        }
                        ?>
                    </table></td>
                <td class="column borderR"><table class="detalleProgramasEv">
                        <?php
                        $dIdProgramaPM = 0;
                        foreach ($programas as $programa) {

                            $idDocente = $resultados->fields['iddocente'];

                            $sqlExistePM = "SELECT 
                                            COUNT(DocenteId) AS existePM
                                            FROM PlanMejoraDocentes
                                            WHERE DocenteId = $idDocente
                                            AND CodigoPeriodo = $Periodo
                                            AND CodigoCarrera = $docIdPrograma[$dIdProgramaPM]
                                            AND CodigoEstado = 100";

                            $existePM = $db->Execute($sqlExistePM);

                            $existePM = $existePM->fields["existePM"];
                            ?>
                            <tr>
                                <?php
                                if ($existePM != 0) {
                                    ?>
                                    <td>
                                        <button id="planmejora_<?php echo $docIdPrograma[$dIdProgramaPM]; ?>_<?php echo $resultados->fields['iddocente']; ?>_<?php echo $vocaciones; ?>_<?php echo $Periodo; ?>" class="planMejoras" title="Ver Plan Mejora" style="margin:2px;display: inline-block;" type="button">
                                            Plan Mejora
                                        </button>
                                    </td>
                                <?php }
                                ?>
                            </tr>
                            <?php
                            $dIdProgramaPM = $dIdProgramaPM + 1;
                        }
                        ?>
                    </table></td>
            </tr>
            <?php $resultados->MoveNext();
        } ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    //on es porque como estoy creando y quitanto elementos dinamicamente, me los reconozca
    $(".programas").on('click', function () {
        // get number of column
        var ids = $(this).attr('id');
        ids = ids.replace("programa_", "");
        ids = ids.split("_");

        popup_carga('./verDatosDocenteVocacion.php?idPrograma=' + ids[0] + '&idDocente=' + ids[1] + '&idVocacion=' + ids[2] + '&idPeriodo=' + ids[3]);

    });

    $(".evidencias").on('click', function () {
        // get number of column
        var ids = $(this).attr('id');
        ids = ids.replace("evidencia_", "");
        ids = ids.split("_"); 
        popup_carga('./finder/verEvidencias.php?idDocente=' + ids[0] + '&idPeriodo=' + ids[1] + '&idPrograma=' + ids[2]);

    });

    $(".autoevaluaciones").on('click', function () {
        // get number of column
        var ids = $(this).attr('id');
        ids = ids.replace("autoevaluacion_", "");
        ids = ids.split("_");

        popup_carga('./verAutoEvaluacionDocente.php?idPrograma=' + ids[0] + '&idDocente=' + ids[1] + '&idVocacion=' + ids[2] + '&idPeriodo=' + ids[3]);

    });

    $(".planMejoras").on('click', function () {
        // get number of column
        var ids = $(this).attr('id');
        ids = ids.replace("planmejora_", "");
        ids = ids.split("_");

        popup_carga('./verPlanMejora.php?idPrograma=' + ids[0] + '&idDocente=' + ids[1] + '&idVocacion=' + ids[2] + '&idPeriodo=' + ids[3]);

    });


</script>