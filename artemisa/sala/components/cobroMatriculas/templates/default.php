<?php

defined('_EXEC') or die;
echo Factory::printImportJsCss("js", HTTP_SITE . "/components/cobroMatriculas/assets/js.js");
echo Factory::printImportJsCss("css", HTTP_SITE . "/assets/plugins/bootstrap-table/bootstrap-table.min.css");
echo Factory::printImportJsCss("js", HTTP_SITE . "/assets/plugins/bootstrap-table/bootstrap-table.min.js");
?>
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            Cobro Matricula
        </h3>
    </div>
    <div class="panel-body">
        <button class="btn btn-success btn-labeled fa fa-plus-circle cobro" data-action="nuevo" 
                data-id="" data-porcentaje="" data-periodo="" data-desde="" data-hasta=""  data-item="<?php echo $variables->itemId?>" id="nuevo" >Nuevo</button>
        <table id="cobrosM" data-toggle="table" 
               data-page-size="20"
               data-search="true"
               data-sort-name="Periodo"
               data-sort-order="desc"
               data-show-pagination-switch="false"
               data-pagination="true"
               data-toolbar="#nuevo" >
            <thead>
                <tr>
                    <th data-sortable="true" data-field="numerador">#</th>
                    <th data-sortable="true" data-field="Periodo">Periodo</th> 
                    <th data-sortable="true" data-field=">Porcentaje crédito desde">Porcentaje crédito desde</th>
                    <th data-sortable="true" data-field="Porcentaje crédito hasta">Porcentaje crédito hasta</th>
                    <th data-sortable="true" data-field="Porcentaje cobro matrícula">Porcentaje cobro matrícula</th>
                    <th data-sortable="false" class="hidden-xs">Editar</th> 
                </tr>
            </thead>
            <tbody> 
                <?php
                $numerador=1;
                foreach ($cobroMatricula as $cm) {
                    ?>
                    <tr>
                        <td><?php echo $numerador; ?></td>
                        <td><?php echo $cm->getCodigoPeriodo() ?></td>
                        <td><?php echo $cm->getPorcentajeCreditosDesde()?></td>
                        <td><?php echo $cm->getPorcentajeCreditosHasta()?></td>
                        <td><?php echo $cm->getPorcentajeCobroMatricula()?></td>
                        <td>
                            <a href="#" class="cobro" data-item="<?php echo $variables->itemId?>" data-porcentaje="<?php echo $cm->getPorcentajeCobroMatricula()?>" data-periodo="<?php echo $cm->getCodigoPeriodo() ?>" data-desde="<?php echo $cm->getPorcentajeCreditosDesde()?>" data-hasta="<?php echo $cm->getPorcentajeCreditosHasta()?>" data-action="editar" style="color:#bb7815">
                                <span class="fa-stack fa-lg">
                                    <em class="fa fa-square-o fa-stack-2x"></em>
                                    <em class="fa fa-pencil fa-stack-1x"></em> 
                                </span> 
                            </a>
                        </td>
                    </tr>
                    <?php
                    $numerador++;
                }   
                ?>
            </tbody>
        </table>
    </div>
</div> 
