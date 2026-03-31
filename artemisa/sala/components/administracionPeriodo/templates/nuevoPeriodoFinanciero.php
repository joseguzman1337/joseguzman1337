<?php
defined('_EXEC') or die;
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css");
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css");
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js");
echo Factory::printImportJsCss("js", HTTP_SITE . "/components/administracionPeriodo/assets/js/nuevoPeriodoFinanciero.js");
echo Factory::printImportJsCss("js", HTTP_SITE . "/assets/plugins/bootstrap-validator/bootstrapValidator.min.js");
echo Factory::printImportJsCss("css", HTTP_SITE . "/assets/plugins/bootstrap-validator/bootstrapValidator.min.css");

?>
<div class="row">
    <div class="panel">
        <form class="form-horizontal" id="formPeriodoFinanciero">
            <input type="hidden" name="id" id="id" value="<?php echo @$ePeriodoFinanciero->id;?>">
            
            <div class="panel-body">
                <div class="form-group <?php echo $displayClassNew;?>">
                    <label for="anio" class="col-sm-4 control-label ">Seleccione Año *</label>
                    <div class="col-sm-7">
                        <select class="form-control chosen-select" id="anio" name="anio">
                            <option value="">Seleccionar</option>
                            <?php
                            $i = 0;
                            foreach ($anio as $a) {
                                $selected = "";
                                if(!empty($ePeriodoFinanciero->id) && $i==0){
                                    $selected = " selected ";
                                }
                                ?>
                                <option value="<?php echo $a->getIdAno(); ?>" <?php echo $selected;?>><?php echo $a->getCodigoAno(); ?></option>
                                <?php
                                $i++;
                            }
                            ?>
                        </select>

                    </div>
                </div>

                <div class="form-group">
                    <label for="nombre" class="col-sm-4 control-label">Periodo *</label>
                    <div class="col-sm-7 <?php echo $displayClassNew;?>">
                        <select class="form-control chosen-select" id="idPeriodoMaestro" name="idPeriodoMaestro">
                            <option value="">Seleccionar</option>
                            <?php
                            $codigoActivo = "";
                            foreach ($listaPeriodosMaestros as $pm) {
                                $selected = "";
                                if(@$ePeriodoFinanciero->idPeriodoMaestro == $pm->getId() ){
                                    $selected = " selected ";
                                    $codigoActivo = $pm->getCodigo();
                                }
                                ?>
                                <option value="<?php echo $pm->getId(); ?>" <?php echo $selected; ?>><?php echo $pm->getNombre(); ?>(<?php echo $pm->getCodigo(); ?>)</option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-7  <?php echo $displayClassEdit;?>">
                        <?php echo $codigoActivo;?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nombre" class="col-sm-4 control-label">Nombre *</label>
                    <div class="col-sm-7">
                        <input type="text" placeholder="Nombre período financero" class="form-control" id="nombre" name="nombre" value="<?php echo @$ePeriodoFinanciero->nombre; ?>" autocomplete="off" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="nombre" class="col-sm-4 control-label">Fecha de inicio *</label>
                    <div class="col-sm-7 ">
                        <div class="input-group date" data-name="fechaInicio" >
                            <input type="text" placeholder="AAAA-MM-DD" class="form-control" id="fechaInicio" name="fechaInicio" value="<?php echo @$ePeriodoFinanciero->fechaInicio; ?>" autocomplete="off" />
                                <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nombre" class="col-sm-4 control-label">Fecha de fin *</label>
                    <div class="col-sm-7">
                        <div class="input-group date" data-name="fechaFin" >
                            <input type="text" placeholder="AAAA-MM-DD" class="form-control" id="fechaFin" name="fechaFin" value="<?php echo @$ePeriodoFinanciero->fechaFin; ?>" autocomplete="off" />
                                <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-9 col-sm-offset-3">
                        <button class="btn btn-warning btn-labeled fa  fa-floppy-o fa-lg" id="save" type="submit">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>