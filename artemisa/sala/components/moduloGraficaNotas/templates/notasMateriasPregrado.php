<?php
defined('_EXEC') or die;
//d($notasMaterias);
$arrayNotas = array();
$valores = array();
$labels = array();
$numeroCortes = 0;
if(!empty($notasMaterias)){
    $i = 0;
    foreach($notasMaterias as $k => $v){
        $valores[$i]= "m_".$v->Materia->getCodigoMateria();
        $arrayNotas = array();
        $j=0;
        //d($v->notasCorte);
        if(!empty($v->notasCorte)){
            foreach($v->notasCorte as $n){
                $Corte = $n->Corte;
                $DetalleNota = $n->detalleNotas;
                if($j==0){
                    $arrayNotas[] = "[0, ]";
                    $j=1;
                }
                if(!empty($DetalleNota)){
                    $arrayNotas[] = "[".$Corte->getNumerocorte().", ".$DetalleNota->getNota()."]";
                }else{
                    $arrayNotas[] = "[".$n->Corte->getNumerocorte().",  ]";
                }
                $j++;
            }/**/
        }
        $arrayNotas[] = "[".$j.", ]";
        
        if($j > $numeroCortes){
            $numeroCortes = $j;
        }
        
        $valores[$i] .= " = [".implode(",",$arrayNotas)."]";
        
        $labels[$i] = "{ "
                . " label: '".$v->Materia->getNombremateria()."', "
                . " data: m_".$v->Materia->getCodigoMateria().", "
                . " points: { "
                . "    show: true, "
                . "    radius: 4 "
                . " } "
                . "}";
         
        $i++;
    }
    $valores = implode(",", $valores);
    $labels = implode(",", $labels);
}
    ?>
    <?php echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/flot-charts/jquery.flot.min.js"); ?>
    <?php echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/flot-charts/jquery.flot.resize.min.js"); ?>

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">Cambiar periodo <i class="dropdown-caret fa fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <?php
                        if($codigoPeriodo!=$PeriodoActual->getCodigoperiodo()){
                            ?>
                            <li>
                                <a href="#" class="cabiarPeriodo" data-codigoPeriodo="<?php echo $PeriodoActual->getCodigoperiodo();?>" >
                                    <span class="hidden-md hidden-lg"><?php echo $PeriodoActual->getCodigoperiodo();?></span>
                                    <span class="hidden-sm hidden-xs"><?php echo $PeriodoActual->getNombreperiodo();?></span>
                                </a>
                            </li>
                            <?php
                        }
                        foreach($periodos as $p){
                            if($codigoPeriodo!=$p->getCodigoperiodo()){
                                ?>
                                <li>
                                    <a href="#" class="cabiarPeriodo" data-codigoPeriodo="<?php echo $p->getCodigoperiodo();?>" >
                                        <span class="hidden-md hidden-lg"><?php echo $p->getCodigoperiodo();?></span>
                                        <span class="hidden-sm hidden-xs"><?php echo $p->getNombreperiodo();?></span> 
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?> 
                    </ul>
            </div>
            <h3 class="panel-title">Notas <span class="hidden-sm hidden-xs">periodo</span> <?php echo $codigoPeriodo; ?></h3>
        </div>
        <div class="panel-body">
            <?php
            if(!empty($notasMaterias)){
            ?>
            <!--Flot Line Chart placeholder-->
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <div id="notasMaterias" style="height:250px"></div>
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Asignatura</th>
                            <?php
                            for($i=1; $i<=$numeroCortes; $i++){
                                ?>
                                <th><?php echo $i; ?>° corte</th>
                                <?php
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($notasMaterias as $k => $v){
                            ?>
                            <tr>
                                <td>&nbsp;&nbsp;<?php echo $v->Materia->getNombremateria(); ?><span class="label label-success pull-left" style="background-color: <?php echo $colors[$k]; ?> !important;"> &nbsp;</span></td>
                                <?php
                                $j=1;
                                if(!empty($v->notasCorte)){
                                    foreach($v->notasCorte as $n){
                                        $Corte = $n->Corte;
                                        $DetalleNota = $n->detalleNotas; 
                                        if(!empty($DetalleNota)){
                                            ?>
                                            <td><?php echo $DetalleNota->getNota(); ?></td>
                                            <?php
                                        }else{
                                            ?>
                                            <td>_</td>
                                            <?php
                                        }
                                        $j++;
                                    }
                                    while($j <= $numeroCortes){
                                        ?>
                                        <td>_</td>
                                        <?php
                                        $j++;
                                    }
                                }
                                ?>
                            </tr> 
                            <?php 
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
<?php
if(!empty($notasMaterias)){
?>
    <script type="text/javascript">
        var  <?php echo $valores; ?>;
        var ticksXaxis = <?php echo $numeroCortes;?>;
        var labels = [ <?php echo $labels; ?> ];
        var cortes = new Array();
        var colors = ['<?php echo implode("','", $colors);?>'];
        for(i=0; i<ticksXaxis; i++){
            cortes[i] = (i+1);
        }
	
    </script>
    <?php echo Factory::printImportJsCss("js",HTTP_SITE."/components/moduloGraficaNotas/assets/js/notasMateriasPregrado.js"); ?>
    <?php 
    /**/
}