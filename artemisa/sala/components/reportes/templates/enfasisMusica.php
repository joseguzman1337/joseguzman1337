<?php
defined('_EXEC') or die;
echo Factory::printImportJsCss("js", HTTP_SITE . "/components/reportes/assets/js/enfasisMusica.js");
echo Factory::printImportJsCss("js", HTTP_SITE . "/assets/plugins/bootstrap-validator/bootstrapValidator.min.js");
echo Factory::printImportJsCss("css", HTTP_SITE . "/assets/plugins/bootstrap-validator/bootstrapValidator.min.css");
?>
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte Énfasis Formación Musical</h3>
            </div>
            <form id="reporteEnfasisSemestre" method="post" action="none">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label class="control-label">Énfasis</label>
                                <select class="form-control chosen-select" id="enfasis" name="enfasis">
                                    <option value=""></option>
                                   <?php
                                    foreach( $enfasisPlanEstudio as $enfasis ){
                                        $idEnfasis = $enfasis->getIdlineaenfasisplanestudio();
                                        $nombreEnfasis = $enfasis->getNombrelineaenfasisplanestudio();
                                        $nombrePlanEstudio = $enfasis->getNombreplanestudio();
                                    ?>
                                    <option value="<?php echo $idEnfasis;?>">
                                        <?php echo $nombrePlanEstudio." ".$nombreEnfasis;?>
                                    </option>
                                    <?php
                                     }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Semestre</label>
                                <select class="form-control chosen-select" id="semestre" name="semestre">
                                    <option value=""></option>
                                    <?php
                                    $semestre=1;
                                    $numeroSemestre = $cantidadSemestre["cantidadSemestres"];
                                    while( $semestre <= $numeroSemestre ){
                                    ?>
                                    <option value="<?php echo $semestre?>"><?php echo $semestre?></option>
                                    <?php                                        
                                        $semestre++;
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Periodo</label>
                                <select class="form-control chosen-select" id="periodo" name="periodo">
                                    <?php
                                    foreach ($periodo as $periodos){
                                         $codigoPeriodo = $periodos->getCodigoperiodo();
                                    ?>
                                    <option value="<?php echo $codigoPeriodo;?>"><?php echo $codigoPeriodo;?></option>
                                    <?php
                                     }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-heading text-right">
                        <button class="btn btn-info" type="submit" id="consultar">Consultar</button>
                        <button class="btn btn-success" value="exportar" id="exportar">Exportar</button>
                </div>
            </form>
            <div id="visualizar">
                
            </div>
        </div>
    </div>
