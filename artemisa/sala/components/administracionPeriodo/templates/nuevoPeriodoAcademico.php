<?php
defined('_EXEC') or die;
echo Factory::printImportJsCss("css", HTTP_SITE . "/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css");
echo Factory::printImportJsCss("css", HTTP_SITE . "/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css");
echo Factory::printImportJsCss("js", HTTP_SITE . "/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js");
echo Factory::printImportJsCss("js", HTTP_SITE . "/assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.js");
echo Factory::printImportJsCss("js", HTTP_SITE . "/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js");
echo Factory::printImportJsCss("js", HTTP_SITE . "/assets/plugins/bootstrap-validator/bootstrapValidator.min.js");
echo Factory::printImportJsCss("css", HTTP_SITE . "/assets/plugins/bootstrap-validator/bootstrapValidator.min.css");
echo Factory::printImportJsCss("js", HTTP_SITE . "/components/administracionPeriodo/assets/js/nuevoPeriodoAcademico.js");
echo Factory::printImportJsCss("js", HTTP_ROOT . "/assets/js/triggerChosen.js");

$activarEstado = "hide";
$activarCampos = "";
if (!empty($ePeriodoAcademico) and $variables->estado == "estadoVisible") {
    $activarEstado = "";
    $activarCampos = "hide";
}
?>
<div class="row">
    <div class="panel">
        <form class="form-horizontal" id="formPeriodoAcademico">
            <input type="hidden" name="id" id="id" value="<?php echo @$ePeriodoAcademico->id; ?>">
            <div class="panel-body">

                <div class="form-group">
                    <label for="codigoModalidadAcademica" class="col-sm-4 control-label ">Modalidad Académica *</label>
                    <div class="col-sm-7 <?php echo $displayClassNew; ?>">
                        <select class="form-control chosen-select" id="codigoModalidadAcademica" name="codigoModalidadAcademica">
                            <option value="">Seleccione</option>
                            <?php
                            $modalidadActiva = "";
                            foreach ($listaModalidadesAcademicas as $ma) {
                                $selected = "";
                                if (@$ePeriodoAcademico->codigoModalidadAcademica == @$ma->codigo) {
                                    $selected = " selected ";
                                    $modalidadActiva = $ma->nombre;
                                }
                                ?>
                                <option value="<?php echo $ma->codigo; ?>" <?php echo $selected; ?>><?php echo $ma->nombre; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-7  <?php echo $displayClassEdit; ?>">
                        <?php echo $modalidadActiva; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="codigoCarrera" class="col-sm-4 control-label ">Programa Académico *</label>
                    <div class="col-sm-7 <?php echo $displayClassNew; ?>">
                        <select class="form-control chosen-select" id="codigoCarrera" name="codigoCarrera">
                            <option value="">Seleccione</option>
                            <?php
                            if (!empty($eCarrera)) {
                                ?>
                                <option value="<?php echo $eCarrera->codigocarrera; ?>" selected ><?php echo $eCarrera->nombrecarrera; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-7  <?php echo $displayClassEdit; ?>">
                        <?php echo @$eCarrera->nombrecarrera; ?>
                    </div>
                </div>

                <div class="form-group  <?php echo $displayClassNew; ?>">
                    <label for="anio" class="col-sm-4 control-label ">Año *</label>
                    <div class="col-sm-7">
                        <select class="form-control chosen-select" id="anio" name="anio">
                            <option value="">Seleccionar</option>
                            <?php
                            $i = 0;
                            foreach ($anio as $a) {
                                $selected = "";
                                if (!empty($eAno) && ($eAno->idAgno == $a->getIdAno())) {
                                    $selected = " selected ";
                                }
                                ?>
                                <option value="<?php echo $a->getIdAno(); ?>" <?php echo $selected; ?>><?php echo $a->getCodigoAno(); ?></option>
                                <?php
                                $i++;
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group <?php echo $activarCampos ?>">
                    <label for="PeriodoMaestro" class="col-sm-4 control-label ">Período *</label>
                    <div class="col-sm-7  <?php echo $displayClassNew; ?>">
                        <select class="form-control chosen-select" id="idPeriodoMaestro" name="idPeriodoMaestro">
                            <option value="">Seleccione</option>
                            <?php
                            $periodoSeleccionado = "";
                            foreach ($listaPeriodosMaestros as $pm) {
                                $selected = "";
                                if ($ePeriodoAcademico->idPeriodoMaestro == $pm->getId()) {
                                    $selected = " selected ";
                                    $periodoSeleccionado = $pm->getCodigo();
                                }
                                ?>
                                <option value="<?php echo $pm->getId(); ?>" <?php echo $selected; ?>><?php echo $pm->getNombre() . " (" . $pm->getCodigo() . ")"; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-7  <?php echo $displayClassEdit; ?>">
                        <?php echo $periodoSeleccionado; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="PeriodoFinanciero" class="col-sm-4 control-label ">Período Financiero *</label>
                    <div class="col-sm-7 <?php echo $activarCampos ?>">
                        <select class="form-control chosen-select" id="idPeriodoFinanciero" name="idPeriodoFinanciero">
                            <option value="">Seleccione</option>
                            <?php
                            foreach ($listaPeriodosFinancieros as $pm) {
                                $selected = "";
                                if ($ePeriodoAcademico->idPeriodoFinanciero == $pm->getId()) {
                                    $selected = " selected ";
                                    $periodoFinancieroSeleccionado = $pm->getNombre();
                                }
                                ?>
                                <option value="<?php echo $pm->getId(); ?>" <?php echo $selected; ?>><?php echo $pm->getNombre(); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-7  <?php echo $activarEstado ?>">
                        <?php echo @$periodoFinancieroSeleccionado; ?>
                    </div>
                </div>

                <div class="form-group <?php echo $activarCampos ?>">
                    <label for="nombre" class="col-sm-4 control-label">Fecha de inicio *</label>
                    <div class="col-sm-7 ">
                        <div class="input-group date" data-name="fechaInicio" >
                            <input type="text" placeholder="AAAA-MM-DD" class="form-control" id="fechaInicio" name="fechaInicio" value="<?php echo @$ePeriodoAcademico->fechaInicio; ?>" autocomplete="off" />
                            <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group <?php echo $activarCampos ?>">
                    <label for="nombre" class="col-sm-4 control-label">Fecha de fin *</label>
                    <div class="col-sm-7 ">
                        <div class="input-group date" data-name="fechaFin" >
                            <input type="text" placeholder="AAAA-MM-DD" class="form-control" id="fechaFin" name="fechaFin" value="<?php echo @$ePeriodoAcademico->fechaFin; ?>" autocomplete="off" />
                            <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group <?php echo $activarEstado ?>" >
                    <label for="idEstadoPeriodo" class="col-sm-4 control-label ">Estado *</label>
                    <div class="col-sm-7">
                        <?php
                        if (!empty($listaEstadoPeriodo)) {
                            ?>
                            <select class="form-control chosen-select" id="idEstadoPeriodo" name="idEstadoPeriodo">
                                <?php
                                foreach ($listaEstadoPeriodo as $ep) {
                                    $selected = "";
                                    if ($ePeriodoAcademico->idEstadoPeriodo == $ep->getCodigoestadoperiodo()) {
                                        $selected = " selected ";
                                    }
                                    ?>
                                    <option value="<?php echo $ep->getCodigoestadoperiodo(); ?>" <?php echo $selected; ?>><?php echo $ep->getNombreestadoperiodo(); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <?php
                        } else {
                            ?>
                            <input type="hidden" id="idEstadoPeriodo" name="idEstadoPeriodo" value="null">
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-9 col-sm-offset-3">
                        <button class="btn btn-warning btn-labeled fa  fa-floppy-o fa-lg" type="submit">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
