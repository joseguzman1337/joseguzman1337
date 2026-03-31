<?php
defined('_EXEC') or die;
echo Factory::printImportJsCss("js", HTTP_SITE . "/components/trmHistoricos/assets/js.js");
echo Factory::printImportJsCss("css", HTTP_SITE . "/assets/plugins/bootstrap-table/bootstrap-table.min.css");
echo Factory::printImportJsCss("css", HTTP_SITE . "/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css");
echo Factory::printImportJsCss("js", HTTP_SITE . "/assets/plugins/bootstrap-table/bootstrap-table.min.js");
echo Factory::printImportJsCss("js", HTTP_SITE . "/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js");

?>
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            Administracion TRM
        </h3>
    </div>
    <div class="panel-body">
        <button class="btn btn-success btn-labeled fa fa-plus-circle trm" data-action="nuevo"
                data-id="0" data-valorrrm="" data-tipomoneda="" data-fechainicio="" data-fechafin=""  data-item="<?php echo $variables->itemId?>" id="nuevo" >Nuevo</button>

        <table id="historicoTrm" data-toggle="table"
               data-page-size="20"
               data-search="false"
               data-sort-name="Periodo"
               data-sort-order="desc"
               data-show-pagination-switch="false"
               data-pagination="true"
               data-toolbar="#nuevo" >
            <caption>Historial Ultimos trms</caption>
            <thead>
            <tr>
                <th data-sortable="true" data-field="numerador">#</th>
                <th data-sortable="true" data-field="fechacreacion">Fecha Creación</th>
                <th data-sortable="true" data-field="novedad">Novedad</th>
                <th data-sortable="true" data-field="tipoejecucion">Tipo Ejecución</th>
                <th data-sortable="true" data-field="valortrm">Valor</th>
                <th data-sortable="true" data-field="fechadesde">Inicia Desde</th>
                <th data-sortable="true" data-field="fechahasta">Termina Hasta</th>
                <th data-sortable="false" class="hidden-xs">Editar</th>
                <th data-sortable="false" class="hidden-xs">Estado</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $numerador=1;
            foreach ($trmHistorico as $trm) {
                ?>
                <tr <?php if($trm->getcodigoEstado() == 200){?> class="danger" title="Registro TRM Inactivo" <?php }?>>
                    <td><?php echo $numerador; ?></td>
                    <td><?php echo $trm->getFechacreacion()?></td>
                    <td><?php echo $trm->getNovedad()?></td>
                    <td><?php echo $trm->getTipotrm()?></td>
                    <td><?php echo $trm->getValortrm()?></td>
                    <td><?php echo $trm->getVigenciadesde()?></td>
                    <td><?php echo $trm->getVigenciahasta()?></td>
                    <td>
                        <a href="#" class="trm" data-item="<?php echo $trm->getIdTrmHistorico()?>" data-dia="<?php echo $trm->getDia()?>" data-novedad="<?php echo $trm->getNovedad() ?>" data-valortrm="<?php echo $trm->getValorTrm()?>" data-fechainicial="<?php echo $trm->getvigenciaDesde()?>" data-tipomoneda="<?php echo $trm->getTipoMoneda()?>" data-estadotrm="<?php echo $trm->getcodigoEstado()?>" data-fechafin="<?php echo $trm->getVigenciaHasta() ?>" data-action="editar" style="color:#bb7815">
                                <span class="fa-stack fa-lg">
                                    <em class="fa fa-square-o fa-stack-2x"></em>
                                    <em class="fa fa-pencil fa-stack-1x"></em>
                                </span>
                        </a>
                    </td>
                    <td><?php  if($trm->getCodigoEstado() == 100){ echo "Activo"; }else{ echo "Inactivo"; }?></td>
                </tr>
                <?php
                $numerador++;
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<div id="mensajeLoader"></div>