<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
include(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));
include('modelo/modeloPlantrabajo.php');
$planTrabajoModelo = new planTrabajoModelo();
$periodo = $_GET["txtCodigoPeriodo"];
?>
<link rel="stylesheet" type="text/css" href="css/estilosTablahoraDocentes.css">
<script src="js/mainExportartablaHoras.js" type="text/javascript"></script>
<div class="container" style="border: 1px solid #f0e3df;overflow:scroll;">
    <div>
        <h3 style=" float: right;"><button type="" class="buttons-menu"  style="cursor:pointer;padding:8px 22px;height:auto;width:auto;" id="exportarDocumento">Exportar a Excel</button></h3>
          <form id="formInforme" style="z-index: -1; width:100%" method="post" action="../utilidades/imprimirReporteExcel.php">
            <input id="datos_a_enviar" type="hidden" name="datos_a_enviar">
          </form>    
    </div>
    <table id="tablaReporteHoras" border="1">
        <caption>
          <h3 style="background: #BDBAAE; color: #000000;">Reporte Docentes Horas</h3>
        </caption>
        <thead>
            <tr>
                <th rowspan="2" style="background: #BDBAAE; color: #000000;">#</th>
                <th rowspan="2" style="background: #BDBAAE; color: #000000;">Programa</th>
                <th rowspan="2" style="background: #BDBAAE; color: #000000;">Nombre</th>
                <th rowspan="2" style="background: #BDBAAE; color: #000000;">Documento</th>
                <th rowspan="2" style="background: #BDBAAE; color: #000000;">Email</th>
                <th colspan="9" style="background: #BDBAAE; color: #000000;">Vocación enseñanza aprendizaje</th>
                <th colspan="3" style="background: #BDBAAE; color: #000000;">Vocación Descubrimiento</th>
                <th colspan="4" style="background: #BDBAAE; color: #000000;">Vocación Compromiso</th>
                <th style="background: #BDBAAE; color: #000000;">Gestión Académica</th>
                <th rowspan="2" style="background: #BDBAAE; color: #000000;">Total</th>
            </tr>
            <tr id="subRow">
                
                <td style="background: #BDBAAE; color: #000000;">Horas presenciales por Semana</td>
                <td style="background: #BDBAAE; color: #000000;">Horas de Preparación</td>
                <td style="background: #BDBAAE; color: #000000;">Horas de Evaluación</td>
                <td style="background: #BDBAAE; color: #000000;">Horas de asesoría Académica</td>
                <td style="background: #BDBAAE; color: #000000;">Horas de Laboratorio,Talleres o Preclínica</td>
                <td style="background: #BDBAAE; color: #000000;">Horas Tutoría PAE</td>
                <td style="background: #BDBAAE; color: #000000;">Horas TIC</td>
                <td style="background: #BDBAAE; color: #000000;">Horas Innovación</td>
                <td style="background: #BDBAAE; color: #000000;">Total enseñanza Aprendizaje</td>
                <td style="background: #BDBAAE; color: #000000;">Horas Investigación Formativa</td>
                <td style="background: #BDBAAE; color: #000000;">Horas Investig en Sentido Estricto</td>
                <td style="background: #BDBAAE; color: #000000;">Total Descubrimiento</td>
                <td style="background: #BDBAAE; color: #000000;">Horas Supervisión prácticas</td>
                <td style="background: #BDBAAE; color: #000000;">Horas Consultoría</td>
                <td style="background: #BDBAAE; color: #000000;">Horas Educación Continua</td>
                <td style="background: #BDBAAE; color: #000000;">Total Compromiso</td>
                <td style="background: #BDBAAE; color: #000000;">Horas GestionAcademica</td>
            </tr>
        </thead>
        <tbody>
        <?php

        $resultado1 = $planTrabajoModelo->mdlDocente($periodo);
        
$n=1;

        foreach ($resultado1 as $key => $value) {
             $idDocente = $value["iddocente"];
             $documentoDocente = $value["numerodocumento"];
             $nombre = $value["nombredocente"];
             $apellido = $value["apellidodocente"];
             $nbCompletoDocente = $nombre." ".$apellido;
             $mail = $value["emaildocente"];
             $programa = $value["programas"];
             $carreraId = $value["Carrera_id"];
             $totalHoras = $value["totalHoras"];
             $hEvaluacion = $value["HorasEvaluacion"];
             /*Vocación enseñanza aprendizaje*/
             $hPresencialesPorSemana = $value["hPresencialesPorSemana"];
             $horasPreparacion = $value["horasPreparacion"];
             $horasaAsesoriaAcademica = $value["horasAsesoria"];
             $hLaboratoriaTaller = $value["horasTaller"];
             $horasPAE = $value["horasPAE"];
             $horasTic = $value["horasTIC"];
             $horasInnovar = $value["horasInnovar"];
             $totalHorasEnsenanzaAprendizaje = $hPresencialesPorSemana+$hEvaluacion+$horasPreparacion+$horasaAsesoriaAcademica+$hLaboratoriaTaller+$horasPAE+$horasTic+$horasInnovar;
              /*Fin Vocación enseñanza aprendizaje*/
             /*Vocacion*/
             $resHoras = $planTrabajoModelo->mdlConsultaHoras($periodo,$idDocente);
             $horasFormativas  = $resHoras["horasFormativas"];
             $horasEstrictas  = $resHoras["horasEstrictas"];
             $totalVocacionDescubrimiento =  $horasFormativas + $horasEstrictas;
            /*compromiso horas*/
             $horasSupervisionPractica = $resHoras["horasSupervisionPractica"];
             $horasConsultoriaExterna = $resHoras["horasConsultoriaExterna"];
             $horasEducacionContinuada = $resHoras["horasEducacionContinuada"];
             $totalHVocacionCompromiso = $horasSupervisionPractica+$horasConsultoriaExterna+$horasEducacionContinuada;
            /*Fin compromiso horas*/
             $hGestionAcademica = $totalHVocacionCompromiso;
             /*Fin vocacion*/
            $totalHoras= $totalHorasEnsenanzaAprendizaje+$totalVocacionDescubrimiento+$totalHVocacionCompromiso;
         ?>
            <tr class="filFor">
                <td class="tdFil"><?php echo $n; ?></td>
                <td class="tdFil"><?php echo $programa; ?></td>
                <td class="tdFil"><?php echo $nbCompletoDocente; ?></td>
                <td class="tdFil"><?php echo $documentoDocente; ?></td>
                <td class="tdFil"><?php echo $mail; ?></td>
                <td class="tdFilNum"><?php echo $hPresencialesPorSemana; ?></td>
                <td class="tdFilNum"><?php echo $horasPreparacion; ?></td>
                <td class="tdFilNum"><?php echo $hEvaluacion; ?></td>
                <td class="tdFilNum"><?php echo $horasaAsesoriaAcademica; ?></td>
                <td class="tdFilNum"><?php echo $hLaboratoriaTaller; ?></td>
                <td class="tdFilNum"><?php echo $horasPAE; ?></td>
                <td class="tdFilNum"><?php echo $horasTic; ?></td>
                <td class="tdFilNum"><?php echo $horasInnovar; ?></td>
                <td class="tdFilNum" style="background: #BDBAAE; color: #000000; text-align: center;"><?php echo $totalHorasEnsenanzaAprendizaje; ?></td>
                <td class="tdFilNum"><?php echo $horasFormativas; ?></td>
                <td class="tdFilNum"><?php echo $horasEstrictas; ?></td>
                <td class="tdFilNum" style="background: #BDBAAE; color: #000000; text-align: center;"><?php echo $totalVocacionDescubrimiento; ?></td>
                <td class="tdFilNum"><?php echo $horasSupervisionPractica; ?></td>
                <td class="tdFilNum"><?php echo $horasConsultoriaExterna; ?></td>
                <td class="tdFilNum"><?php echo $horasEducacionContinuada; ?></td>
                <td class="tdFilNum" style="background: #BDBAAE; color: #000000; text-align: center;"><?php echo $totalHVocacionCompromiso; ?></td>
                <td class="tdFilNum"><?php echo $hGestionAcademica; ?></td>
                <td class="tdFilNum" style="background: #BDBAAE; color: #000000; text-align: center;"><?php echo $totalHoras; ?></td>
            </tr>
         <?php $n++;} ?>   
        </tbody>
    </table>

</div>
