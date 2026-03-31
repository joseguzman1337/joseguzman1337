<?php 
/**
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package templates
*/
defined('_EXEC') or die;
?>
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $test; ?></h3>
    </div>
    <div  class="panel-body"> 
        <button class="btn btn-success btn-labeled fa fa-plus-circle" id="nuevaActividad">Nueva Actividad</button>
        <div id="tablaDatos">
        <table id="datos" data-toggle="table"
                data-page-size="<?php if(!empty($origin)){ echo '10';}else{ echo '20'; } ?>"
                data-search="true"
                data-show-pagination-switch="false"
                data-pagination="true"   >
            <thead>
                <tr>
                    <th data-field="idnumber" class="hidden-xs">#</th>
                    <th data-field="name" data-switchable="false">Nombre</th>
                    <th data-field="description" data-sortable="false">Descripcion</th> 
                    <th data-field="limitdate" data-sortable="false">Fecha Limite</th> 
                    <th data-field="starthour" data-sortable="false">Hora Inicio</th> 
                    <th data-field="endhour" data-sortable="false">Hora Fin</th> 
                    <th data-field="quota" data-sortable="false">Cupo</th> 
                    <th data-field="state" data-sortable="false">Estado</th> 
                    <th data-field="edit" data-sortable="false">Editar</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach($ActividadesBienestar as $m){
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td>
                            <?php echo $m->getNombre();?>
                        </td>
                        <td>
                            <?php echo $m->getDescripcion();?>
                        </td> 
                        <td>
                            <?php 
                            $fechaLimite=explode(" ", $m->getFechaLimite()); 
                            echo $fechaLimite[0];
                            ?>
                        </td> 
                        <td>
                            <?php  
                            echo $fechaLimite[1];
                            ?>
                        </td> 
                        <td>
                            <?php 
                            echo $m->getHoraFin();
                            ?>
                        </td> 
                        <td>
                            <?php echo $m->getCupo();?>
                        </td> 
                        <td>
                            <?php echo ControlModuloActividadesBienestar::printInconEstado($m->getCodigoEstado(), $m->getId());?>
                        </td> 
                        <td>
                            <?php echo ControlModuloActividadesBienestar::printInconEditar($m->getId());?>
                        </td> 
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
       
<?php
//Bootstrap Table [ OPTIONAL ]
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/plugins/bootstrap-table/bootstrap-table.min.css");

echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-table/bootstrap-table.min.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/components/moduloActividadesBienestar/assets/js/moduloActividadesBienestar.js");
?>
 <?php //} ?>