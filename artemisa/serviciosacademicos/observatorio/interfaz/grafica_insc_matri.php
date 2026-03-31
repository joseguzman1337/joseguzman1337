<?php
include('../templates/templateObservatorio.php');

 include("../../mgi/pChart/class/pData.class.php");
 include("../../mgi/pChart/class/pDraw.class.php");
 include("../../mgi/pChart/class/pImage.class.php"); 
 include_once ('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
 $fontPath = "../../mgi/pChart/fonts/";
 
 $db=writeHeader('Observatorio',true,'');
 $c_Odata=new obtener_datos_matriculas($db,$_REQUEST['codigoperiodo']);
 
 $val=$_REQUEST['modalidad'];
 
 $query_carrera = "SELECT nombrecarrera, codigocarrera 
                     FROM carrera 
                     where codigomodalidadacademica='".$val."' and codigocarrera not in (1,2) and fechavencimientocarrera >= '2013-01-01 00:00:00'
                      order by 1";
//echo $query_carrera;
$data_in= $db->Execute($query_carrera);
   
 
 $periodofin=$_REQUEST['codigoperiodo'];
 $cant=5;
 $pf = substr ($periodofin, 0, strlen($periodofin) - 1);
 $pf=(int)$pf;
 $i = 1; $j=1;
 while($i <= $cant) {
  //echo 'Periodo' .$pf . '<br>';
  $periodos[$pf.'1']=(string)$pf.'1';
  $periodos[$pf.'2']=(string)$pf.'2';
  $pf= (int)$pf;
  $pf=$pf-$j;
  ++$i; 
}

foreach ($data_in as $value) {
    foreach ($periodos as $codigoperiodo){
         $c_Odata=new obtener_datos_matriculas($db,$codigoperiodo);
         $inscritos[$codigoperiodo]=$c_Odata->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($codigoperiodo,$value,'','conteo',null);
         $matriculados[$codigoperiodo]=$c_Odata->obtener_datos_estudiantes_matriculados_nuevos($value,'conteo');
    }
}

//print_r($inscritos);
//print_r($matriculados);

//include_once ('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
//$db=writeHeader('Observatorio',true,'');

//$val=$_REQUEST['id'];
//$sin_ind=$_REQUEST['opt'];


 
// $MyData = new pData();  
// $MyData->addPoints(array(3,12,15,8,5,-5,6,9,8,7),"Inscritos");
// $MyData->addPoints(array(2,7,5,18,19,22,7,8,9,6),"Matriculados");
// $MyData->setSerieWeight("Inscritos",2);
// $MyData->setSerieTicks("Matriculados",4);
// $MyData->setAxisName(0,"");
// $MyData->addPoints($periodos,"Labels");
// $MyData->setSerieDescription("Labels","Periodos");
// $MyData->setAbscissa("Labels");
//
// $myPicture = new pImage(800,330,$MyData);
//
// $myPicture->Antialias = FALSE;
//
// $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
// $myPicture->drawFilledRectangle(0,0,800,330,$Settings);
//
// $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
// $myPicture->drawGradientArea(0,0,800,330,DIRECTION_VERTICAL,$Settings);
// $myPicture->drawGradientArea(0,0,800,30,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));
//
// //$myPicture->drawRectangle(0,0,699,229,array("R"=>0,"G"=>0,"B"=>0));
// 
// $myPicture->setFontProperties(array("FontName"=>"../../mgi/pChart/fonts/Forgotte.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
// $myPicture->drawText(10,16,"Inscritos vs Matriculados",array("FontSize"=>18,"Align"=>TEXT_ALIGN_BOTTOMLEFT));
//
// $myPicture->setFontProperties(array("FontName"=>"../../mgi/pChart/fonts/pf_arma_five.ttf","FontSize"=>6,"R"=>0,"G"=>0,"B"=>0));
//
// $myPicture->setGraphArea(60,40,750,300);
//
// $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
// $myPicture->drawScale($scaleSettings);
//
// $myPicture->Antialias = TRUE;
//
// $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
//
// $myPicture->drawLineChart();
// $myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>80));
//
// $myPicture->drawLegend(590,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));
//
// $myPicture->autoOutput("graficas/grafica_".$periodofin.".png");
//?>



    <?PHP  $MyData = new pData();  
        $MyData->addPoints($inscritos,"Inscritos");
        $MyData->addPoints($matriculados,"Matriculados");
        $MyData->setSerieWeight("Inscritos",2);
        $MyData->setSerieTicks("Matriculados",4);
        $MyData->addPoints($periodos,"Labels");
        $MyData->setSerieDescription("Labels","Periodos");
        $MyData->setAbscissa("Labels");

        $myPicture = new pImage(800,300,$MyData);
        $myPicture->Antialias = FALSE;
        $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
        $myPicture->drawFilledRectangle(0,0,800,300,$Settings);
        $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
        $myPicture->drawGradientArea(0,0,800,300,DIRECTION_VERTICAL,$Settings);
        $myPicture->drawGradientArea(0,0,800,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));
        $myPicture->drawRectangle(0,0,800,299,array("R"=>0,"G"=>0,"B"=>0));
        $myPicture->setFontProperties(array("FontName"=>$fontPath."Forgotte.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
        $myPicture->drawText(10,16,"Estadisticas Admisiones",array("FontSize"=>11,"Align"=>TEXT_ALIGN_BOTTOMLEFT));
        $myPicture->setFontProperties(array("FontName"=>$fontPath."pf_arma_five.ttf","FontSize"=>6,"R"=>0,"G"=>0,"B"=>0));
        $myPicture->setGraphArea(60,40,750,280);
        $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
        $myPicture->drawScale($scaleSettings);
        $myPicture->Antialias = TRUE;
        $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
        $myPicture->drawLineChart();
        $myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>80));
        $myPicture->drawLegend(590,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));
       $myPicture->Render("graficas/admisiones.png");
?>
  <!--  <div id="carga" style="display:none">..Cargando </div>-->
<img alt="Line chart" src="graficas/admisiones.png"  style="border: 1px solid gray;"/>
<script type="text/javascript">
//       $(document).ready(function(){
//           
//           $('#carga').css({display:'block'});
//           $('#carga').html('<blink>Cargando...</blink>');
//       });
//$.ajax(
//        {
//            url:'grafica_insc_matri.php?codigoperiodo=<?php //echo $_REQUEST['codigoperiodo'] ?>&modalidad=<?php //echo $_REQUEST['modalidad'] ?>',
//            type:'POST',
//            beforeSend:function(objeto){
//                $('#carga').css({display:'block'});
//            },
//            complete:function(){$('#carga').css('display','none');}
//        }
//    );
</script>