<?php
defined('_EXEC') or die;
if(!empty($notasMaterias)){
    $arrayNotas = array();
    $valores = array();
    $labelsShort = array();
    $labels = array();
    $numeroCortes = 0;

    $i = 0;
    foreach($notasMaterias as $k => $v){
        if(!empty($v->notaHisotrico)){
            $valores[$i]=  $v->notaHisotrico->getNotadefinitiva();
        }else{
            $valores[$i] = '';
        }
        $labelsShort[$i] = $k;//$v->Materia->getNombremateria();
        $labels[$i] = $v->Materia->getNombremateria();
         
        $i++;
    }
    $valores = implode(",", $valores); 
    ?>
    <?php echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/chart/Chart.min.js"); ?>

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">Cambiar periodo <i class="dropdown-caret fa fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <?php
                        $codigoPeriodoActual = $PeriodoActual->getCodigoperiodo();
                        if($codigoPeriodo!=$codigoPeriodoActual){
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
                            $cp = $p->getCodigoperiodo();
                            if($codigoPeriodo!=$cp){
                                if($cp != $codigoPeriodoActual){
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
                        }
                        ?> 
                    </ul>
            </div>
            <h3 class="panel-title">Notas <span class="hidden-sm hidden-xs">periodo</span> <?php echo $codigoPeriodo; ?></h3>
        </div>
        <div class="panel-body">
            <!--Flot Line Chart placeholder-->
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            
            <div class="chartjs-wrapper" style="min-height:200px;" >
                <canvas id="chartjs-3" class="chartjs" ></canvas>
                <script>
                    var w = parseInt($(window).width());
    
                    var labels = ["<?php echo implode('","',$labels); ?>"];
                    if(w<749){
                        labels = ["<?php echo implode('","',$labelsShort); ?>"];
                    }
                    var data  = [<?php echo $valores?>];
                    var chartLabel = "<?php echo $codigoPeriodo; ?>";
 
                    var chart = new Chart($('#chartjs-3'),
                        {
                            type:"radar",
                            data:{
                                labels:labels,
                                datasets:[
                                    {
                                        label:chartLabel,
                                        data:data,
                                        fill:true,
                                        backgroundColor:"rgba(54, 162, 235, 0.2)",
                                        borderColor:"rgb(54, 162, 235)",
                                        pointBackgroundColor:"rgb(54, 162, 235)",
                                        pointBorderColor:"#fff",
                                        pointHoverBackgroundColor:"#fff",
                                        pointHoverBorderColor:"rgb(54, 162, 235)"
                                    }
                                ]
                            },
                            options:{
                                elements:{
                                    line:{tension:0,borderWidth:3}
                                },
				scale: {
                                    ticks: {
                                        beginAtZero: true
                                    } 
				}
                            }
                        }
                    );
                    if(w<749){
                        chart.canvas.parentNode.style.height = '350px';
                        chart.canvas.style.height = '350px';
                        chart.canvas.parentNode.style.width = '100%';
                        chart.canvas.style.width = '100%';
                    }
                </script>
            </div> 
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Asignatura</th>
                            <th>Nota</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($notasMaterias as $k => $v){
                            ?>
                            <tr>
                                <td>
                                    <span class="hidden-md hidden-lg"><?php echo  $k; ?> - </span>
                                    <?php echo  $v->Materia->getNombremateria(); ?>
                                </td>
                                <td><?php echo (!empty($v->notaHisotrico))?$v->notaHisotrico->getNotadefinitiva():''; ?></td>
                            </tr> 
                            <?php 
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php echo Factory::printImportJsCss("js",HTTP_SITE."/components/moduloGraficaNotas/assets/js/notasMateriasPosgrado.js"); ?>
    <?php 
    /**/
}