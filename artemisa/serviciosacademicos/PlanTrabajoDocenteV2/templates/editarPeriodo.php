<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/PlanTrabajoDocenteV2/js/editarPeriodo.js");?>
<div class="panel panel-default">
    <div class="panel-body">
        <form id="editarPeriodo" method="post" action="<?php echo HTTP_ROOT; ?>/serviciosacademicos/PlanTrabajoDocenteV2/AutoEvaluacionCambiarPeriodo.php" >
            <input type="hidden" value="<?php echo $id;?>" name="id" id="id" />
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pad-all-5">
                <select name="codigoNuevoPeriodo" id="codigoNuevoPeriodo" class="chosen-select" >
                    <option value="0">Periodo...</option>
                    <?php
                    foreach($listaPeriodos as $p){
                        $selected = "";
                        if($codigoPeriodo == $p->getCodigoperiodo()){
                            $selected = " selected ";
                        }
                        ?>
                        <option value="<?php echo $p->getCodigoperiodo(); ?>" <?php echo $selected; ?> ><?php echo $p->getCodigoperiodo(); ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div> 
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 pad-all-5">
                <input type="submit" id="actualizarPeriodo" value="Actualizar Periodo" class="btn btn-fill-green-XL btn-labeled fa fa-plus accion" />
            </div>
        </form>
    </div>
</div>