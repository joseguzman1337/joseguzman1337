<?php 
defined('_EXEC') or die;
//d($datos);
?>
<div class="panel-heading">
    <h3 class="panel-title">Horario para el <?php echo $fecha; ?></h3>
</div>
<div class="panel-body">
    <div class="table-responsive" id="tablaHorariosEstudiante">
        <table class="table table-hover table-condensed table-vcenter">
            <thead>
                <tr>
                    <th>Hora</th>
                    <th>Materia</th>
                    <th class="hidden-xs">Docente</th>
                    <?php /*/ ?><th class="hidden-xs">Fin</th><?php /**/ ?>
                    <th class="hidden-xs">Sede/Campus</th>
                    <th class="hidden-xs">Bloque</th>
                    <th>Salón</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(!empty($datos)){
                    foreach($datos as $d){
                        ?>
                        <tr>
                            <td>
                                <span class="text-semibold">
                                    <?php echo $d['HoraInicio'] ;?>
                                </span>
                            </td>
                            <td>
                                <?php echo $d['nombremateria'] ;?>
                            </td>
                            <td class="hidden-xs">
                                <?php echo $d['DocenteName'] ;?>
                            </td>
                            <?php /*/ ?><td class="hidden-xs">
                                <?php echo $d['HoraFin'] ;?>
                            </td><?php /**/ ?>
                            <td class="hidden-xs">
                                <?php echo $d['Campus'] ;?>
                            </td>
                            <td class="hidden-xs">
                                <?php echo $d['Bloke'] ;?>
                            </td>
                            <td>
                                <?php echo $d['Nombre'] ;?>
                            </td>
                        </tr>
                        <?php
                    }
                }else{
                    ?>
                    <tr>
                        <td colspan="6">
                            <span class="text-semibold">
                                No tiene materias asignadas para hoy.
                            </span>
                        </td> 
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<style type="text/css">
#tablaHorariosEstudiante > .table > thead > tr > th, 
#tablaHorariosEstudiante > .table > tbody > tr > th, 
#tablaHorariosEstudiante > .table > tfoot > tr > th, 
#tablaHorariosEstudiante > .table > thead > tr > td, 
#tablaHorariosEstudiante > .table > tbody > tr > td, 
#tablaHorariosEstudiante > .table > tfoot > tr > td {
    white-space: pre-line !important;
}
</style>