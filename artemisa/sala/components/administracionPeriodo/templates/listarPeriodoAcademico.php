<?php
defined('_EXEC') or die;
echo Factory::printImportJsCss("css", HTTP_SITE . "/assets/plugins/bootstrap-table/bootstrap-table.min.css");
echo Factory::printImportJsCss("js", HTTP_SITE . "/assets/plugins/bootstrap-table/bootstrap-table.min.js");
echo Factory::printImportJsCss("js", HTTP_SITE . "/components/administracionPeriodo/assets/js/listarPeriodoAcademico.js");
?>

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            Listado Períodos Académicos
        </h3>
    </div>
    <div class="panel-body">
        <div class="row" id="rowOpciones">
            <div class="col-md-2">
                <button class="btn btn-success btn-labeled fa fa-plus-circle accionPeriodoAcademico" data-action="nuevo" data-type="PeriodoAcademico" 
                        data-id="" id="nuevoPeriodo" >Nuevo</button>
            </div>            
            <div class="col-md-7">
                <select class="form-control chosen-select" id="programaAcademico">
                    <option value="todos">Todos los Programas</option>
                    <?php
                    foreach ($listaCarreras as $programasAcademico) {
                        $selected = "";
                        if ($programasAcademico->getCodigoCarrera() == $variables->programaAcademico) {
                            $selected = "selected";
                        }
                        ?>
                        <option value="<?php echo $programasAcademico->getCodigoCarrera(); ?>" <?php echo $selected; ?> >
                            <?php echo $programasAcademico->getNombreCarrera(); ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control chosen-select" id="anios">
                    <option value="todos">Todos los Años</option>
                    <?php
                    foreach ($listaAnios as $ano) {
                        $selected = "";
                        if ($ano->getCodigoAno() == $variables->anio) {
                            $selected = "selected";
                        }
                        ?>
                        <option value="<?php echo $ano->getCodigoAno() ?>" <?php echo $selected; ?> >
                            <?php echo $ano->getCodigoAno() ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </div>    
        </div>      
        <table id="listaPeriodosAcademicos" data-toggle="table" 
               data-page-size="20"
               data-search="true"
               data-sort-name="maestro"
               data-sort-order="desc"
               data-sort-name="programaAcademico"
               data-sort-order="asc"
               data-show-pagination-switch="false"
               data-pagination="true"
               data-toolbar="#rowOpciones" >
            <thead>
                <tr> 
                    <th data-sortable="true" data-field="maestro">Período Académico</th>
                    <th data-sortable="true" data-field="financiero">Período Financiero</th> 
                    <th data-sortable="true" data-field="programaAcademico">Programa Académico</th>
                    <th data-sortable="true" data-field="fechaInicio">Fecha Inicio</th>
                    <th data-sortable="true" data-field="fechaFin">Fecha Fin</th>
                    <th data-sortable="false" data-field="estado">Estado</th>
                    <th data-sortable="false" data-field="editar" class="hidden-xs">Editar</th> 
                </tr>
            </thead>
            <tbody> 
                <?php
                foreach ($listaPeriodosAcademicos as $p) {
                    $icoEditar = ControlAdministracionPeriodo::printInconEditar($p->id, "PeriodoAcademico", "editar");
                    ?>
                    <tr>
                        <td>
                            <?php echo $p->periodoMaestro->codigo; ?>
                        </td>
                        <td>
                            <?php echo $p->periodoFinanciero->codigo; ?>
                        </td>
                        <td>
                            <?php echo $p->carrera; ?>
                        </td>
                        <td>
                            <?php echo $p->fechaInicio; ?>
                        </td>
                        <td>
                            <?php echo $p->fechaFin; ?>
                        </td>
                        <td>
                            <a class="accionPeriodoAcademico editarEstadoPeriodoAcademico" href="#" data-type="PeriodoAcademico" 
                               data-id="<?php echo $p->id ?>" data-action="editarEstado"  data-toggle="tooltip" 
                               title="Clic para cambiar de estado">
                                <div class="col-sm-4"style="padding-right: 0 !important; padding-left: 2px !important">
                                    <i class="fa fa-<?php echo $p->icon; ?> "></i>
                                </div>
                                <div class="col-sm-8"style="padding-left: 0 !important">
                                    <?php echo $p->nombreEstado; ?>
                                </div>
                            </a>
                        </td>
                        <td>
                            <?php echo $icoEditar; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
