<?php
defined('_EXEC') or die;
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/plugins/bootstrap-table/bootstrap-table.min.css");
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-table/bootstrap-table.min.js");
echo Factory::printImportJsCss("js", HTTP_SITE . "/components/administracionPeriodo/assets/js/listarPeriodoMaestro.js");
?>
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            Listado Períodos Maestros
        </h3>
    </div>
    <div class="panel-body">
        <button class="btn btn-success btn-labeled fa fa-plus-circle accionPeriodoMaestro" data-action="nuevo" data-type="PeriodoMaestro" 
                data-id="" id="nuevoPeriodo" >Nuevo</button>
        <table id="listaPeriodosMaestro" data-toggle="table" 
               data-page-size="20"
               data-search="true"
               data-sort-name="codigo"
               data-sort-order="desc"
               data-show-pagination-switch="false"
               data-pagination="true"
               data-toolbar="#nuevoPeriodo" >
            <thead>
                <tr>
                    <th data-sortable="true" data-field="anio">Año</th>
                    <th data-sortable="true" data-field="codigo">Código</th> 
                    <th data-sortable="true" data-field="nombre">Nombre</th>
                    <th data-sortable="true" data-field="numero">Número período</th>
                    <th data-sortable="true" data-field="estado">Estado</th>
                    <th data-sortable="false" class="hidden-xs">Editar</th> 
                </tr>
            </thead>
            <tbody> 
                <?php
                
                    foreach( $periodoMaestro as $p){
                ?>
                <tr>
                    <td><?php echo $p->anio;?></td>
                    <td><?php echo $p->codigo;?></td>
                    <td><?php echo $p->nombre;?></td>
                    <td><?php echo $p->numeroPeriodo;?></td>
                    <td><?php echo $p->codigoEstado;?></td>
                    <td><?php echo ControlAdministracionPeriodo::printInconEditar($p->id, "PeriodoMaestro")?> </td>
                </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
