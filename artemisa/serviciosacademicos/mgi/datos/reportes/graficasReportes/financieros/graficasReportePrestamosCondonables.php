<?php

function getValores($db,$codigoperiodo,$utils){
    $valores = array();
    $total1 = 0;
    $total2 = 0;
    $total3 = 0;
    $total4 = 0;
    $total5 = 0;
    $total6 = 0;
    
    $periodos = $utils->getMesesPeriodo($db,$codigoperiodo,true);
    $sql = "SELECT SUM(valorNacionalEspecializacion) as valorNacionalEspecializacion, SUM(valorNacionalMaestria) as valorNacionalMaestria,
    SUM(valorNacionalDoctorado) as valorNacionalDoctorado, SUM(valorInternacionalEspecializacion) as valorInternacionalEspecializacion,
    SUM(valorInternacionalMaestria) as valorInternacionalMaestria, SUM(valorInternacionalDoctorado) as valorInternacionalDoctorado 
    FROM siq_formTalentoHumanoPrestamosCondonables WHERE codigoestado=100 AND codigoperiodo IN $periodos ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";

    $row = $db->GetRow($sql);
    
        if($row!=NULL && (count($row)>0)){
            $total += $row["valorNacionalEspecializacion"];
            $total += $row["valorNacionalMaestria"];
            $total += $row["valorNacionalDoctorado"];
            $total += $row["valorInternacionalEspecializacion"];
            $total += $row["valorInternacionalMaestria"];
            $total += $row["valorInternacionalDoctorado"];
        }
           
    $valores[] = $total;
           //var_dump($valores);
    return array("valores"=>array($valores));
}


function drawGraphic($db,$periodos,$reporte,$fontPath,$utils) { 
    
    /* Create and populate the pData object */
 $MyData = new pData();  
 $labelCategorias = array();
 $vals = array();
 
 for($j=0; $j<count($periodos); $j++){
     //var_dump($periodos[$j]);echo "<br/><br/>";
     $valores = getValores($db,$periodos[$j],$utils);
    $labelCategorias[] = $periodos[$j];
    $vals[] = $valores["valores"][0][0];
 }
 
 $MyData->addPoints($vals,"");
 $MyData->setAxisName(0,"Valor ($)");
 $MyData->addPoints($labelCategorias,"Creditos");
 $MyData->setSerieDescription("Creditos","AÑOS");
 $MyData->setAbscissa("Creditos");

 /* Create the pChart object */
 $myPicture = new pImage(700,330,$MyData);
  /* Turn of Antialiasing */
 $myPicture->Antialias = FALSE;

 /* Add a border to the picture */
 $myPicture->drawRectangle(0,0,699,329,array("R"=>0,"G"=>0,"B"=>0)); 

//$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
 //$myPicture->drawGradientArea(0,0,700,230,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
 $myPicture->setFontProperties(array("FontName"=>$fontPath."calibri.ttf","FontSize"=>8));

 /* Draw the scale  */
 $myPicture->setGraphArea(50,30,680,300);
 $myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"Mode"=>SCALE_MODE_START0,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10));

 /* Turn on shadow computing */ 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

 /* Create the per bar palette */
 $Palette = array("0"=>array("R"=>188,"G"=>224,"B"=>46,"Alpha"=>100),
                "1"=>array("R"=>224,"G"=>100,"B"=>46,"Alpha"=>100),
                 "2"=>array("R"=>224,"G"=>214,"B"=>46,"Alpha"=>100),
                 "3"=>array("R"=>46,"G"=>151,"B"=>224,"Alpha"=>100),
                "4"=>array("R"=>176,"G"=>46,"B"=>224,"Alpha"=>100),
             "5"=>array("R"=>224,"G"=>46,"B"=>117,"Alpha"=>100),
                "6"=>array("R"=>92,"G"=>224,"B"=>46,"Alpha"=>100),
                 "7"=>array("R"=>224,"G"=>176,"B"=>46,"Alpha"=>100));
 
 /* Draw the chart */
 $settings = array("Gradient"=>TRUE,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"DisplayShadow"=>FALSE,"OverrideColors"=>$Palette,"Surrounding"=>10);
 $myPicture->drawBarChart($settings);

 /* Write the chart legend */
 //$myPicture->drawLegend(575,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
 
   //$myPicture->drawLegend($ancho-240,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));

    /* Render the picture (choose the best way) */
    $myPicture->Render("imagenesGraficas/".$reporte["alias"]."/prestamosCondonables.png"); 
     ?>
        <img alt="Resultados préstamos" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/prestamosCondonables.png?random=".time(); ?>" style="border: 1px solid gray;margin-right: 20px;"/>
 <?php }
  
$periodos = $utils->getYears($dates["fecha_inicial"],$dates["fecha_final"]);
//var_dump($periodos); 
//$periodos = getPeriodosArray($db,$dates);

             //var_dump($row_modalidad); ?>

            <div class="grafica">
            <?php drawGraphic($db,$periodos,$reporte,$fontPath,$utils); ?> </div>
