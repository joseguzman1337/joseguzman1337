<?php 
defined('_EXEC') or die; 
//d($carrerasEstudiante);
?>
<div class="alert alert-info fade in">
    <strong><i class="fa fa-info-circle fa-2x" aria-hidden="true"></i></strong> <span class="text-2x">Seleccione una carrera para continuar.</span>
</div>
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Carrera(s) estudiante</h3>
    </div>
    
    <!--Hover Rows-->
    <!--===================================================-->
    <div class="panel-body">
        <table class="table table-hover table-vcenter">
            <thead>
                <tr>
                    <th class="min-width hidden-xs">Id</th>
                    <th class="text-center">Nombre Carrera</th>
                    <th class="text-center hidden-xs">Código Carrera</th>
                    <th class="text-center">Situación Carrera</th>
                    <th class="text-center hidden-xs">Periodo Ingreso</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach($carrerasEstudiante as $ce){
                ?>
                <tr>
                    <td class="text-center hidden-xs">
                        <a href="#" class="selCarrera" data-codigoestudiante="<?php echo $ce['codigoestudiante'];?>" data-codigoperiodo="<?php echo $ce['codigoperiodo'];?>">
                            <?php echo $ce['codigoestudiante'];?>
                        </a>
                    </td>
                    <td class="text-center">
                        <span class="text-semibold">
                            <a href="#" class="selCarrera" data-codigoestudiante="<?php echo $ce['codigoestudiante'];?>" data-codigoperiodo="<?php echo $ce['codigoperiodo'];?>">
                                <?php echo $ce['nombrecarrera'];?>
                            </a>
                        </span> 
                    </td>
                    <td class="text-center hidden-xs">
                        <a href="#" class="selCarrera" data-codigoestudiante="<?php echo $ce['codigoestudiante'];?>" data-codigoperiodo="<?php echo $ce['codigoperiodo'];?>">
                            <?php echo $ce['codigocarrera'];?>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="#" class="selCarrera" data-codigoestudiante="<?php echo $ce['codigoestudiante'];?>" data-codigoperiodo="<?php echo $ce['codigoperiodo'];?>">
                            <?php echo $ce['nombresituacioncarreraestudiante'];?>
                        </a>
                    </td>
                    <td class="text-center hidden-xs">
                        <a href="#" class="selCarrera" data-codigoestudiante="<?php echo $ce['codigoestudiante'];?>" data-codigoperiodo="<?php echo $ce['codigoperiodo'];?>">
                            <?php echo $ce['codigoperiodo'];?>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php echo Factory::printImportJsCss("js",HTTP_SITE."/assets/js/btheme.js"); ?>
<?php echo Factory::printImportJsCss("js",HTTP_SITE."/components/dashBoard/assets/js/carrerasEstudiante.js"); ?>