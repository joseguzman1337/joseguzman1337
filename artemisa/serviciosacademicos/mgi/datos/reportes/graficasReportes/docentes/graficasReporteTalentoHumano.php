<?php

function getValores($db,$codigoperiodo,$utils){
    $total1 = 0;
    $total2 = 0;
    
    $periodos = $utils->getMesesPeriodo($db,$codigoperiodo,true);
    
    //el orden es para que me lea como numeros la primera parte del string de codigoperiodo
    $sql = "SELECT * FROM siq_formTalentoHumanoNumeroPersonas WHERE codigoestado=100 AND codigoperiodo IN $periodos ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";
    //echo $sql;
    $row = $db->GetRow($sql);
    
        if($row!=NULL && (count($row)>0)){
            $total1 += $row["numAcademicos"];
            $total2 += $row["numAdministrativos"];
        }
           
    $academicos[] = $total1;
    $administrativos[] = $total2;
           //var_dump($valores);
    return array("valores"=>array($academicos,$administrativos));
}


function drawGraphic($db,$periodos,$reporte,$fontPath,$utils) { 
    
    /* Create and populate the pData object */
 /* Create and populate the pData object */
 $MyData = new pData();  
 
 $academicos = array(); 
 $administrativos = array();
 for($j=0; $j<count($periodos); $j++){
     //var_dump($periodos[$j]);echo "<br/><br/>";
     $val = getValores($db,$periodos[$j],$utils);
     $academicos[] = $val["valores"][0][0];
     $administrativos[] = $val["valores"][1][0];
 }
 //echo "<pre>";print_r($administrativos);
 
 $MyData->addPoints($administrativos,"Administrativos");
 $MyData->addPoints($academicos,"Académicos");
 //$MyData->addPoints(array(0,0,0,0,0,0),"");
 //$MyData->setSerieTicks("Probe 2",4);
 $MyData->setAxisName(0,"Número de Personas");
 $MyData->addPoints($periodos,"Labels");
 $MyData->setSerieDescription("Labels","Años");
 $MyData->setAbscissa("Labels");

 /* Create the pChart object */
 $ancho = 850;
 $myPicture = new pImage($ancho,360,$MyData);

 /* Draw the background */
 $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
 $myPicture->drawFilledRectangle(0,0,$ancho,360,$Settings);

 /* Overlay with a gradient */
 $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
 $myPicture->drawGradientArea(0,0,$ancho,360,DIRECTION_VERTICAL,$Settings);
 $myPicture->drawGradientArea(0,0,$ancho,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));

 /* Add a border to the picture */
 $myPicture->drawRectangle(0,0,$ancho-1,359,array("R"=>0,"G"=>0,"B"=>0));
 
 /* Write the picture title */ 
 $myPicture->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8));
 $myPicture->drawText(10,13,"Talento Humano",array("R"=>255,"G"=>255,"B"=>255));

 /* Write the chart title */ 
 //$myPicture->setFontProperties(array("FontName"=>$fontPath."Forgotte.ttf","FontSize"=>11));
 //$myPicture->drawText(250,55,"Average temperature",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

 /* Draw the scale and the 1st chart */
 $myPicture->setGraphArea(60,80,$ancho-20,330);
 //$myPicture->drawFilledRectangle(60,60,$ancho-20,330,array("R"=>255,"G"=>255,"B"=>255,"Surrounding"=>-200,"Alpha"=>10));
 $myPicture->drawScale(array("DrawSubTicks"=>FALSE,"Mode"=>SCALE_MODE_ADDALL_START0));
 $myPicture->setFontProperties(array("FontName"=>$fontPath."calibri.ttf","FontSize"=>10));
 $myPicture->setShadow(FALSE);
 //DRAPLOT EN TRUE PARA MOSTRAR LOS CIRCULOS DE CADA PERIODO
 $myPicture->drawStackedAreaChart(array("DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO,"DrawPlot"=>FALSE,"DrawLine"=>TRUE,"LineSurrounding"=>-250));

 /* Draw one static threshold */ 
 $myPicture->drawThreshold(0,array("Alpha"=>70,"Ticks"=>1,"NoMargin"=>TRUE));

 /* Draw one static threshold */ 
 $myPicture->drawThreshold(0,array("Alpha"=>70,"Ticks"=>1,"NoMargin"=>TRUE));
 
  $myPicture->writeLabel(array("Administrativos","Académicos"),count($periodos)-1,array("DrawVerticalLine"=>TRUE));  

 /* Write the chart legend */
 $myPicture->drawLegend($ancho-200,8,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));
 
    /* Render the picture (choose the best way) */
    $myPicture->Render("imagenesGraficas/".$reporte["alias"]."/talentoHumano.png"); 
     ?>
        <img alt="Resultados selectividad" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/talentoHumano.png?random=".time(); ?>" style="border: 1px solid gray;margin-right: 20px;"/>
 <?php }
  
$periodos = $utils->getYears($dates["fecha_inicial"],$dates["fecha_final"]);
//var_dump($periodos); 
//$periodos = getPeriodosArray($db,$dates);

             //var_dump($row_modalidad); ?>

            <div class="grafica">
            <?php drawGraphic($db,$periodos,$reporte,$fontPath,$utils); ?> </div>
