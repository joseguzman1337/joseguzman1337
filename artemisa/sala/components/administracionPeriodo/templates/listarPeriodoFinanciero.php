<?php
defined('_EXEC') or die;
echo Factory::printImportJsCss("css", HTTP_SITE . "/assets/plugins/bootstrap-table/bootstrap-table.min.css");
echo Factory::printImportJsCss("js", HTTP_SITE . "/assets/plugins/bootstrap-table/bootstrap-table.min.js");
echo Factory::printImportJsCss("js", HTTP_SITE . "/components/administracionPeriodo/assets/js/listarPeriodoFinanciero.js");
?>
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            Listado Períodos Financieros
        </h3>
    </div>
    <div class="panel-body">
        <button class="btn btn-success btn-labeled fa fa-plus-circle accionPeriodoFinanciero" data-action="nuevo" data-type="PeriodoFinanciero" 
                data-id="" id="nuevoPeriodo" >Nuevo</button>
        <table id="listaPeriodosFinancieros" data-toggle="table" 
               data-page-size="20"
               data-search="true"
               data-sort-name="codigo"
               data-sort-order="desc"
               data-show-pagination-switch="false"
               data-pagination="true"
               data-toolbar="#nuevoPeriodo" >
            <thead>
                <tr> 
                    <th data-sortable="true" data-field="nombre">Nombre</th>
                    <th data-sortable="true" data-field="codigo">Código</th> 
                    <th data-sortable="true" data-field="fechaIni">Fecha inicio</th>
                    <th data-sortable="true" data-field="fechaFin">Fecha fin</th>
                    <th data-sortable="false" data-field="estado">Estado</th>
                    <th data-sortable="false" data-field="editar" class="hidden-xs">Editar</th> 
                </tr>
            </thead>
            <tbody> 
                <?php
                foreach ($listaPeriodosFinancieros as $p) {
                    $icoEditar = ControlAdministracionPeriodo::printInconEditar($p->id, "PeriodoFinanciero");
                    ?>
                    <tr>
                        <td>
                            <?php echo $p->nombre; ?>
                        </td>
                        <td>
                            <?php echo $p->periodoMaestro->codigo; ?>
                        </td>
                        <td>
                            <?php echo $p->fechaInicio; ?>
                        </td>
                        <td>
                            <?php echo $p->fechaFin; ?>
                        </td>
                        <td>
                            <?php echo $p->codigoEstado; ?>
                        </td>
                        <td><?php echo $icoEditar; ?></td>
                        <?php /*/ ?><td><?php echo ControlAdministracionPeriodo::printInconEliminar($p->id, "PeriodoFinanciero"); ?></td><?php /**/ ?>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
