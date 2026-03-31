<?php
echo Factory::printImportJsCss("css", HTTP_SITE . "/assets/plugins/bootstrap-validator/bootstrapValidator.min.css");
echo Factory::printImportJsCss("js", HTTP_SITE . "/assets/plugins/bootstrap-validator/bootstrapValidator.min.js");
echo Factory::printImportJsCss("js", HTTP_ROOT . "/assets/js/triggerChosen.js");
echo Factory::printImportJsCss("js", HTTP_SITE . "/components/trmHistoricos/assets/trm.js");
$fechaActual = date('Y-m-d');

$novedad=$idTrmHistorico=$estadoTrm=$valorTrm=$selected=$disabled=$disabledgeneral="";
if ($variables->dataAction == "editar" ) {
    $idTrmHistorico = $variables->item;
    $valorTrm= $variables->valorTrm;
    $fInicial = new DateTime ($variables->fechaInicial);
    $fechaInicial = $fInicial->format('Y-m-d');
    $fFin = new DateTime($variables->fechaFin);
    $fechaFin =$fFin->format('Y-m-d');
    $tpMoneda = $variables->tpMoneda;
    $novedad = $variables->novedad;
    $dia = $variables->dia;
    $estadoTrm = $variables->estadoTrm;
}
$dataAction = $variables->dataAction;
if ($dataAction == "editar"){
    $selected = "selected";
    $disabledgeneral = "disabled";
}
?>
<div class="row">
    <div class="panel">
        <form  id="formTrm">
            <div class="panel-body">
                <div class="form-group">
                    <label  for="valortrm">Valor Trm:</label>
                    <input type="number" placeholder="ej: 3660.04" <?php echo $disabledgeneral;?> class="form-control" id="valortrm" name="valortrm" step=".01" value="<?php echo $valorTrm;?>">
                </div>
                <div class="form-group">
                    <label for="tipomoneda">Seleccione tipo moneda:</label>
                    <select class="form-control" id="tipomoneda"  name="tipomoneda" <?php echo $disabledgeneral;?>>
                        <option value="">Seleccionar</option>
                        <?php
                        $selected = "";
                        foreach ($tipoMoneda as $tipoMonedas) {
                            if ($variables->tpMoneda == $tipoMonedas->getIdTipoMoneda()){ $selected = "selected"; }
                            if($tipoMonedas->getidTipoMoneda() == 1){ $disabled = "disabled"; }else{ $disabled = ""; }
                            ?>
                            <option class="form-control"  value="<?php echo $tipoMonedas->getIdTipoMoneda(); ?>" <?php echo $selected; echo $disabled; ?> ><?php echo $tipoMonedas->getNombreMoneda(); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label  for="fechainicio">Fecha Inicio:</label>
                    <input type="date" class="form-control" id="fechainicio" min="<?php echo date("Y-m-d");?>" name="fechainicio" value="<?php echo $fechaInicial;?>" <?php echo $disabledgeneral;?>>
                </div>
                <div class="form-group">
                    <label  for="fechafin">Fecha Fin:</label>
                    <input type="date" class="form-control" id="fechafin"  name="fechafin" value="<?php echo $fechaFin;?>"  <?php echo $disabledgeneral;?>>
                </div>
                <div class="form-group">
                    <label  for="novedad">Observacion:</label>
                    <textarea  id="novedad" name="novedad" placeholder="Novedad del ingreso manual" class="form-control"><?php echo $novedad?></textarea>
                </div>
                <?php if ($variables->item != "" && $variables->item!=0) { ?>
                    <div class="form-group bg-warning">
                        <label  for="estadoTrm">Estado TRM:</label>
                        <select class="form-control" id="estadoTrm"  name="estadoTrm">
                            <option value="100" <?php if ($variables->estadoTrm == 100){?> selected <?php  }?>>Activar</option>
                            <option value="200"  <?php if ($variables->estadoTrm == 200){?> selected <?php  }?>>Inactivo</option>
                        </select>
                    </div>
                <?php }?>
            </div>
            <div class="panel-footer">
                <div class="form-group">
                    <input type="hidden" id="item" value="<?php echo $idTrmHistorico;?>">
                    <button class="btn btn-warning btn-labeled fa  fa-floppy-o fa-lg"  type="submit">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
