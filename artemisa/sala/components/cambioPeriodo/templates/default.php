<?php
defined('_EXEC') or die;
//d($listaPeriodosVirtuales);
//d($_SESSION);
?>
<!--Bootstrap Table [ OPTIONAL ]-->
<?php
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/plugins/bootstrap-table/bootstrap-table.min.css");
?>
<!--Basic Columns-->
<!--===================================================-->
<script type="text/javascript">
    var nombreCarreraActual = "<?php echo $Carrera->getNombrecarrera();?>";
    var nombrePeriodoActual = "<?php echo $periodoActual->getNombreperiodo(); ?>";
</script>
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            Periodos disponibles para <span id="nombreCarreraActual"><?php echo $Carrera->getNombrecarrera();?></span>
            <p class="text-xs">Periodo actual: <span id="nombrePeriodoActual"><?php echo $periodoActual->getNombreperiodo(); ?></span></p>
        </h3>
    </div>
    <div class="panel-body">
        <?php
        if($rol==13){
            ?>
            <button id="cambiarCarrera" class="btn btn-warning btn-labeled fa fa-university" >Cambiar carrera</button>
            <?php
        }
        ?>
        <table id="datosCambioPeriodo" data-toggle="table" 
                <?php
                if($rol==13){
                    ?>
                    data-toolbar="#cambiarCarrera" 
                    <?php
                }
                ?> 
                data-page-size="20"
                data-search="true"
                data-show-pagination-switch="false"
                data-pagination="true"   >
            <thead>
                <tr>
                    <th data-field="idnumber" class="hidden-xs">#</th>
                    <?php
                    if(!empty($listaPeriodosVirtuales)){
                        ?>
                        <th data-field="codePeriodFinan" data-switchable="false">Periodo financiero</th>
                        <?php
                    }
                    ?>
                    <th data-field="codePeriod" data-switchable="false">Codigo periodo</th>
                    <th data-field="period" data-sortable="false">Periodo</th> 
                    <th data-field="state" data-sortable="false" class="hidden-xs">Estado</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                
                $i = 1;
                if(!empty($listaPeriodosVirtuales)){
                    foreach($listaPeriodosVirtuales as $m){
                        $m->setDb();
                        $m->setEstadoPeriodo();
                        ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td>
                                <a href="#" class="seleccionarPeriodo" data-Codigo-Periodo="<?php echo $m->getPeriodo()->getCodigoperiodo();?>" data-id-PeriodoVirtual="<?php echo $m->getId();?>" data-Codigo-PeriodoVirtual="<?php echo $m->getPeriodoVirtual()->getCodigoPeriodo();?>">
                                    <?php echo $m->getPeriodo()->getCodigoperiodo();?>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="seleccionarPeriodo" data-Codigo-Periodo="<?php echo $m->getPeriodo()->getCodigoperiodo();?>" data-id-PeriodoVirtual="<?php echo $m->getId();?>" data-Codigo-PeriodoVirtual="<?php echo $m->getPeriodoVirtual()->getCodigoPeriodo();?>">
                                    <?php echo $m->getPeriodoVirtual()->getCodigoPeriodo();?>
                                </a>
                                <span id="iconoPeriodo_<?php echo $m->getPeriodoVirtual()->getCodigoPeriodo();?>" class="fa-lg text-success iconosPeriodos" style="display: <?php echo ($m->getId()==$periodoVirtualActual->getId())?"inline-block":"none"; ?>;" data-Codigo-PeriodoVirtual="<?php echo $m->getPeriodoVirtual()->getCodigoPeriodo();?>">
                                    <i class="fa fa-check"></i>
                                </span>
                            </td>
                            <td>
                                <a href="#" class="seleccionarPeriodo" data-Codigo-Periodo="<?php echo $m->getPeriodo()->getCodigoperiodo();?>" data-id-PeriodoVirtual="<?php echo $m->getId();?>" data-Codigo-PeriodoVirtual="<?php echo $m->getPeriodoVirtual()->getCodigoPeriodo();?>">
                                    <?php echo $m->getPeriodoVirtual()->getNombrePeriodo();?>
                                </a>
                            </td> 
                            <td>
                                <a href="#" class="seleccionarPeriodo" data-Codigo-Periodo="<?php echo $m->getPeriodo()->getCodigoperiodo();?>" data-id-PeriodoVirtual="<?php echo $m->getId();?>" data-Codigo-PeriodoVirtual="<?php echo $m->getPeriodoVirtual()->getCodigoPeriodo();?>">
                                    <?php echo $m->getEstadoPeriodo()->getNombreestadoperiodo();?>
                                </a>
                            </td> 
                        </tr>
                        <?php
                        $i++;
                    }/**/
                }else{
                    foreach($listaPeriodos as $m){
                        $m->setDb();
                        $m->setEstadoPeriodo();
                        ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td>
                                <a href="#" class="seleccionarPeriodo" data-Codigo-Periodo="<?php echo $m->getCodigoperiodo();?>">
                                    <?php echo $m->getCodigoperiodo();?>
                                </a>
                                <span id="iconoPeriodo_<?php echo $m->getCodigoperiodo();?>" class="fa-lg text-success iconosPeriodos" style="display: <?php echo ($m->getCodigoperiodo()==$periodoActual->getCodigoperiodo())?"inline-block":"none"; ?>;">
                                    <i class="fa fa-check"></i>
                                </span>
                            </td>
                            <td>
                                <a href="#" class="seleccionarPeriodo" data-Codigo-Periodo="<?php echo $m->getCodigoperiodo();?>">
                                    <?php echo $m->getNombreperiodo();?>
                                </a>
                            </td> 
                            <td>
                                <a href="#" class="seleccionarPeriodo" data-Codigo-Periodo="<?php echo $m->getCodigoperiodo();?>">
                                    <?php echo $m->getEstadoPeriodo()->getNombreestadoperiodo();?>
                                </a>
                            </td> 
                        </tr>
                        <?php
                        $i++;
                    }/**/
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!--===================================================-->


<!--Bootstrap Table [ OPTIONAL ]-->
<?php 
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-table/bootstrap-table.min.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/components/cambioPeriodo/assets/js/cambioPeriodo.js");
?>

