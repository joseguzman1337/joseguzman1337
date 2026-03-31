<?php
echo Factory::printImportJsCss("js", HTTP_SITE . "/assets/plugins/bootstrap-validator/bootstrapValidator.min.js");
echo Factory::printImportJsCss("css", HTTP_SITE . "/assets/plugins/bootstrap-validator/bootstrapValidator.min.css");
echo Factory::printImportJsCss("js", HTTP_ROOT . "/assets/js/triggerChosen.js");
echo Factory::printImportJsCss("js", HTTP_SITE . "/components/cobroMatriculas/assets/cobro.js");

$desde="";
$hasta="";
$cobro="";
$periodoActual="";

  if ($variables->periodo != "") {
      $periodoActual=$variables->periodo;
      $desde= $variables->desde;
      $hasta = $variables->hasta;
      $cobro = $variables->porcentaje;
  }
?>
<div class="row">
    <div class="panel">
        <form class="form-horizontal" id="formCobro">
            <div class="panel-body">
                <div class="form-group">
                    <label for="periodoMatriculas" class="col-sm-4 control-label ">Seleccione Periodo*</label>
                    <div class="col-sm-7" >
                        <select class="form-control chosen-select" id="periodoMatriculas" data-periodo="<?php echo $periodoActual?>" name="periodoMatriculas">
                            <option value="">Seleccionar</option>
                            <?php
                            $selected = "";
                            foreach ($periodoMatricula as $periodoMatriculas) {
                                if ($variables->periodo == $periodoMatriculas->getCodigoPeriodo()) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                                ?>
                                <option value="<?php echo $periodoMatriculas->getCodigoPeriodo() ?>" <?php echo $selected; ?> ><?php echo $periodoMatriculas->getCodigoPeriodo() ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="porcentajeDesde" class="col-sm-4 control-label"> Porcentaje crédito desde<label id="obligatorio">*</label></label>
                    <div class="col-sm-7">
                        <input type="text" placeholder="Porcentaje crédito desde" value="<?php echo $desde ?>" data-desde="<?php echo $desde ?>" class="form-control" id="porcentajeDesde" name="porcentajeDesde">
                    </div>
                </div>

                <div class="form-group">
                    <label for="porcentajeHasta" class="col-sm-4 control-label"> Porcentaje crédito hasta<label id="obligatorio">*</label></label>
                    <div class="col-sm-7">
                        <input type="text" placeholder="Porcentaje crédito hasta" value="<?php echo $hasta ?>" data-hasta="<?php echo $hasta ?>" class="form-control" id="porcentajeHasta" name="porcentajeHasta">
                    </div>
                </div>

                <div class="form-group">
                    <label for="porcentajeCobro" class="col-sm-4 control-label"> Porcentaje cobro matrícula<label id="obligatorio">*</label></label>
                    <div class="col-sm-7">
                        <input type="text" placeholder="Porcentaje cobro matrícula" value="<?php echo $cobro ?>" data-cobro="<?php echo $cobro?>" class="form-control" id="porcentajeCobro" name="porcentajeCobro">
                    </div>
                </div>

            </div>

            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                         <input type="hidden" id="item" value="<?php echo $variables->item ?>">
                        <button class="btn btn-warning btn-labeled fa  fa-floppy-o fa-lg"  type="submit">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
