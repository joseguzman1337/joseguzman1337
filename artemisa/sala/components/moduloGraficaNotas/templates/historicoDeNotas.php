<?php
defined('_EXEC') or die;
if(!empty($historicoNotas)){
    //d($historicoNotas);
    $arrayNotas = array();

    $i = 0;
    foreach($historicoNotas as $k => $v){
        $t = explode("_",$k);
        //d($v);
        if($i==0){
            $arrayNotas[] = "[0, ]";
            $i=1;
        }
        $arrayNotas[] = "[".$i.", ".round(($v['notas']/$v['creditos']),1)."]";
        $arrayPeriodos[] = " ".$t[1]." ";
        $i++;
    }
    $arrayNotas[] = "[".$i.", ]";
    ?>
    <?php echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/flot-charts/jquery.flot.min.js"); ?>
    <?php echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/flot-charts/jquery.flot.resize.min.js"); ?>

    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Historico de notas</h3>
        </div>
        <div class="panel-body">
            <!--Flot Line Chart placeholder-->
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <div id="historicoDeNotas" style="height:212px"></div>
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        </div>
    </div>
    <script type="text/javascript">
        var periodos = [<?php echo implode(",",$arrayPeriodos);?>];
        var notas = [<?php echo implode(",",$arrayNotas);?>];
        var ticksXaxis = <?php echo count($historicoNotas);?>;
    </script>
    <?php echo Factory::printImportJsCss("js",HTTP_SITE."/components/moduloGraficaNotas/assets/js/historicoDeNotas.js"); ?>
    <?php
}