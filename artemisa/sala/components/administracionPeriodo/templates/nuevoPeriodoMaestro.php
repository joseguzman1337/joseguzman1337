<?php
defined('_EXEC') or die;
echo Factory::printImportJsCss("js", HTTP_SITE . "/assets/plugins/bootstrap-validator/bootstrapValidator.min.js");
echo Factory::printImportJsCss("css", HTTP_SITE . "/assets/plugins/bootstrap-validator/bootstrapValidator.min.css");
echo Factory::printImportJsCss("js", HTTP_SITE . "/components/administracionPeriodo/assets/js/nuevoPeriodoMaestro.js");

$id = "";
$codigo = "";
$numeroPeriodo = "";
$idAgno = "";
$codigoEstado = "";
$nombre = "";
$secuencia = "";
$verAnio="";

if (!empty($ePeriodoMaestro)) {
    $id = $ePeriodoMaestro->getId();
    $codigo = substr($ePeriodoMaestro->getCodigo(), 0, 4);
    $numeroPeriodo = $ePeriodoMaestro->getNumeroPeriodo();
    $idAgno = $ePeriodoMaestro->getIdAgno();
    $codigoEstado = $ePeriodoMaestro->getCodigoEstado();
    $nombre = $ePeriodoMaestro->getNombre();
    $secuencia = 1;
}
?>
<div class="row">
    <div class="panel">
        <form class="form-horizontal" id="formPeriodoMaestro">
            <?php
            if(!empty($id)){
                ?>
                <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
                <?php
            }
            ?>
            <div class="panel-body">
                <div class="form-group">
                    <label for="anio" class="col-sm-4 control-label ">Seleccione Año *</label>
                    <div class="col-sm-7 <?php echo $displayClassNew;?>">
                        <input type="hidden"  readonly placeholder="Código de periodo" class="form-control" id="codigoMaestro" name="codigoMaestro" value="<?php echo $codigo; ?>">
                        <input type="hidden"  readonly class="form-control" id="id" name="id" value="<?php echo $id ?>">
                        <select class="form-control chosen-select" id="anio" name="anio">
                            <option value="">Seleccionar</option>
                            <?php
                            $selected = "";
                            $anioOCulto="";
                            foreach ($anio as $a) {
                                $currentAnio = $a->getIdAno();
                                if ($idAgno == $currentAnio) {
                                    $selected = " selected ";
                                    $verAnio = $a->getCodigoAno();
                                }else{
                                    $selected = "";
                                }
                                ?>
                                <option value="<?php echo $a->getIdAno(); ?>" <?php echo $selected;?> ><?php echo $a->getCodigoAno(); ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-7  <?php echo $displayClassEdit;?>">
                        <?php echo $verAnio;?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nombre" class="col-sm-4 control-label">Nombre <label id="obligatorio">*</label></label>
                    <div class="col-sm-7">
                        <input type="text" placeholder="Nombre período maestro" value="<?php echo $nombre ?>" class="form-control" id="nombre" name="nombre">
                    </div>
                </div>

                <div class="form-group <?php echo $displayClassNew;?>">
                    <label for="secuencia" class="col-sm-4 control-label">Crear Secuencia</label>
                    <div class="col-sm-3" >
                        <input type="checkbox" value="" id="secuencia" <?php
                        if ($secuencia == 1) {
                            echo "disabled";
                        }
                        ?>>
                    </div>
                </div>    

                <div class="form-group">
                    <label for="numeroPeriodo" class="col-sm-4 control-label">Número Período *</label>
                    <div class="col-sm-7 <?php echo $displayClassNew;?>">
                        <input type="text"  value="<?php echo $numeroPeriodo; ?>" placeholder="Número de periodo(s)" class="form-control numeroPeriodo" id="numeroPeriodo" name="numeroPeriodo">
                    </div>
                    <div class="col-sm-7  <?php echo $displayClassEdit;?>">
                        <?php echo $numeroPeriodo;?>
                    </div>

                </div>
                <?php if (!empty($codigoEstado)) { ?>
                    <div class="form-group">
                        <label for="estado" class="col-sm-4 control-label ">Estado Período</label>
                        <div class="col-sm-7">
                            <select class="form-control chosen-select" id="estado" name="estado">
                                <?php
                                if ($codigoEstado == 100) {
                                    ?>
                                    <option value="100" selected>Activo</option>
                                    <option value="200" >Inactivo</option>
                                    <?php
                                } else {
                                    ?>
                                    <option value="100" >Activo</option>
                                    <option value="200" selected >Inactivo</option>
                                    <?php
                                }
                                ?>
                                    
                            </select>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <button class="btn btn-warning btn-labeled fa  fa-floppy-o fa-lg" type="submit">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
